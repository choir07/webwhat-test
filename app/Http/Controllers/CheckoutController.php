<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\BillplzService;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected BillplzService $billplz;

    public function __construct(BillplzService $billplz)
    {
        $this->billplz = $billplz;
    }

    public function index()
    {
        $items = Cart::getItems();
        $total = Cart::getTotal();
        $count = Cart::getCount();

        if ($count == 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        return view('checkout.index', compact('items', 'total', 'count'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'payment_method' => 'required|in:billplz',
        ]);

        $items = Cart::getItems();
        $total = Cart::getTotal();

        if (count($items) === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        // 1. Create the order (status: pending)
        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'user_id' => auth()->id(),
            'customer_name' => $validated['name'],
            'customer_email' => $validated['email'],
            'shipping_address' => $validated['address'] . ', ' . $validated['city'] . ', ' . $validated['postal_code'],
            'subtotal' => $total,
            'tax' => 0,
            'shipping' => 0,
            'total' => $total,
            'status' => 'pending',
            'payment_method' => 'billplz',
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'] ?? $item->id,
                'quantity' => $item['quantity'] ?? $item->quantity,
                'price' => $item['price'] ?? $item->price,
            ]);
        }

        // 2. Create the Billplz bill
        try {
            $bill = $this->billplz->createBill([
                'email' => $validated['email'],
                'name' => $validated['name'],
                'amount' => (int) round($total * 100), // Billplz expects cents
                'callback_url' => route('billplz.callback'),
                'redirect_url' => route('billplz.redirect'),
                'description' => 'Payment for order ' . $order->order_number,
                'order_number' => $order->order_number,
            ]);
        } catch (\Exception $e) {
            $order->update(['status' => 'failed']);
            return redirect()->route('checkout.index')
                ->with('error', 'Payment could not be initiated. Please try again.');
        }

        // 3. Save the bill_id as payment_reference, keep cart intact until payment confirmed
        $order->update(['payment_reference' => $bill['id']]);

        // 4. Redirect customer to Billplz's hosted payment page
        return redirect()->away($bill['url']);
    }

    /**
     * Billplz calls this server-to-server after payment attempt.
     * This is the source of truth — always re-verify via API, never trust POST data alone.
     */
    public function callback(Request $request)
    {
        $billId = $request->input('id');
        $order = Order::where('payment_reference', $billId)->first();

        if (!$order) {
            return response('Order not found', 404);
        }

        $bill = $this->billplz->getBill($billId);

        if ($bill['paid'] ?? false) {
            $order->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);
            Cart::clear();
        } else {
            $order->update(['status' => 'failed']);
        }

        return response('OK', 200);
    }

    /**
     * Customer lands here after finishing (or abandoning) payment on Billplz.
     */
    public function redirect(Request $request)
    {
        $billId = $request->input('billplz')['id'] ?? $request->input('id');
        $order = Order::where('payment_reference', $billId)->first();

        if (!$order) {
            return redirect()->route('shop.index')->with('error', 'Order not found.');
        }

        // Re-check status directly (don't rely solely on the callback having landed yet)
        $bill = $this->billplz->getBill($billId);
        if (($bill['paid'] ?? false) && $order->status !== 'paid') {
            $order->update(['status' => 'paid', 'paid_at' => now()]);
            Cart::clear();
        }

        if ($order->status === 'paid') {
            return view('order.success', compact('order'));
        }

        return redirect()->route('checkout.index')
            ->with('error', 'Payment was not completed. Please try again.');
    }
}