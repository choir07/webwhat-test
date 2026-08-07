@extends('layouts.shop')

@section('title', 'Invoice ' . $order->order_number)

@section('content')
<div style="max-width:42rem;margin:2rem auto;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;" class="no-print">
        <a href="{{ route('order.invoice.download', $order->order_number) }}"
            style="background:#2563eb;color:white;padding:0.5rem 1.25rem;border-radius:0.375rem;text-decoration:none;font-weight:500;font-size:0.875rem;">
            Download PDF
        </a>
        <button onclick="window.print()"
            style="background:var(--bg-card);border:1px solid var(--border-color);color:var(--text-primary);padding:0.5rem 1.25rem;border-radius:0.375rem;font-weight:500;font-size:0.875rem;cursor:pointer;">
            Print
        </button>
    </div>

    <div style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:0.75rem;padding:2rem;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:2rem;flex-wrap:wrap;gap:1rem;">
            <div>
                <div style="font-size:1.25rem;font-weight:700;color:var(--text-primary);">Powerful sHOPS</div>
                <div style="font-size:0.8rem;color:var(--text-secondary);">Invoice</div>
            </div>
            <div style="text-align:right;">
                <div style="font-size:0.8rem;color:var(--text-secondary);">Invoice No.</div>
                <div style="font-weight:600;color:var(--text-primary);">{{ $order->order_number }}</div>
                <div style="font-size:0.8rem;color:var(--text-secondary);margin-top:0.35rem;">
                    {{ optional($order->paid_at)->format('F j, Y') ?? $order->created_at->format('F j, Y') }}
                </div>
            </div>
        </div>

        <div style="display:flex;justify-content:space-between;margin-bottom:2rem;flex-wrap:wrap;gap:1rem;">
            <div>
                <div style="font-size:0.75rem;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.25rem;">Billed To</div>
                <div style="color:var(--text-primary);font-weight:500;">{{ $order->customer_name }}</div>
                <div style="color:var(--text-secondary);font-size:0.875rem;">{{ $order->customer_email }}</div>
                <div style="color:var(--text-secondary);font-size:0.875rem;">{{ $order->shipping_address }}</div>
            </div>
            <div style="text-align:right;">
                <div style="font-size:0.75rem;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.03em;margin-bottom:0.25rem;">Payment</div>
                <div style="color:var(--text-primary);font-weight:500;text-transform:capitalize;">{{ $order->payment_method }}</div>
                <div style="color:#16a34a;font-size:0.875rem;font-weight:600;">Paid</div>
            </div>
        </div>

        <table style="width:100%;border-collapse:collapse;margin-bottom:1.5rem;">
            <thead>
                <tr style="border-bottom:1px solid var(--border-color);">
                    <th style="text-align:left;padding:0.5rem 0;font-size:0.8rem;color:var(--text-secondary);font-weight:600;">Item</th>
                    <th style="text-align:center;padding:0.5rem 0;font-size:0.8rem;color:var(--text-secondary);font-weight:600;">Qty</th>
                    <th style="text-align:right;padding:0.5rem 0;font-size:0.8rem;color:var(--text-secondary);font-weight:600;">Price</th>
                    <th style="text-align:right;padding:0.5rem 0;font-size:0.8rem;color:var(--text-secondary);font-weight:600;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr style="border-bottom:1px solid var(--border-color);">
                        <td style="padding:0.6rem 0;color:var(--text-primary);">{{ $item->product->name ?? 'Item' }}</td>
                        <td style="padding:0.6rem 0;text-align:center;color:var(--text-secondary);">{{ $item->quantity }}</td>
                        <td style="padding:0.6rem 0;text-align:right;color:var(--text-secondary);">RM{{ number_format($item->price, 2) }}</td>
                        <td style="padding:0.6rem 0;text-align:right;color:var(--text-primary);">RM{{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-left:auto;max-width:14rem;">
            <div style="display:flex;justify-content:space-between;padding:0.25rem 0;font-size:0.875rem;color:var(--text-secondary);">
                <span>Subtotal</span>
                <span>RM{{ number_format($order->subtotal, 2) }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:0.25rem 0;font-size:0.875rem;color:var(--text-secondary);">
                <span>Shipping</span>
                <span>RM{{ number_format($order->shipping, 2) }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:0.25rem 0;font-size:0.875rem;color:var(--text-secondary);">
                <span>Tax</span>
                <span>RM{{ number_format($order->tax, 2) }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:0.5rem 0;margin-top:0.25rem;border-top:1px solid var(--border-color);font-weight:700;color:var(--text-primary);">
                <span>Total</span>
                <span>{{ $order->formatted_total }}</span>
            </div>
        </div>
    </div>

    <p style="text-align:center;color:var(--text-secondary);font-size:0.8rem;margin-top:1.5rem;" class="no-print">
        Questions about this order? Contact us with your invoice number above.
    </p>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        header, footer { display: none !important; }
        body { background: white !important; }
    }
</style>
@endsection