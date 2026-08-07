<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->order_number }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #201d18;
            font-size: 12px;
        }
        .header-table {
            width: 100%;
            margin-bottom: 30px;
        }
        .header-table td {
            vertical-align: top;
        }
        .brand {
            font-size: 18px;
            font-weight: bold;
        }
        .muted {
            color: #6b7280;
            font-size: 10px;
        }
        .right {
            text-align: right;
        }
        .center {
            text-align: center;
        }
        .section-label {
            font-size: 9px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 25px;
        }
        .info-table td {
            vertical-align: top;
            width: 50%;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.items th {
            text-align: left;
            font-size: 10px;
            color: #6b7280;
            border-bottom: 1px solid #d1d5db;
            padding: 6px 4px;
        }
        table.items td {
            border-bottom: 1px solid #e5e7eb;
            padding: 8px 4px;
            font-size: 11px;
        }
        table.totals {
            width: 220px;
            margin-left: auto;
        }
        table.totals td {
            padding: 3px 0;
            font-size: 11px;
        }
        table.totals tr.total-row td {
            border-top: 1px solid #d1d5db;
            font-weight: bold;
            font-size: 13px;
            padding-top: 8px;
        }
        .paid-badge {
            color: #16a34a;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td>
                <div class="brand">Powerful sHOPS</div>
                <div class="muted">Invoice</div>
            </td>
            <td class="right">
                <div class="muted">Invoice No.</div>
                <div><strong>{{ $order->order_number }}</strong></div>
                <div class="muted">{{ optional($order->paid_at)->format('F j, Y') ?? $order->created_at->format('F j, Y') }}</div>
            </td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td>
                <div class="section-label">Billed To</div>
                <div><strong>{{ $order->customer_name }}</strong></div>
                <div class="muted">{{ $order->customer_email }}</div>
                <div class="muted">{{ $order->shipping_address }}</div>
            </td>
            <td class="right">
                <div class="section-label">Payment</div>
                <div style="text-transform:capitalize;"><strong>{{ $order->payment_method }}</strong></div>
                <div class="paid-badge">Paid</div>
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>Item</th>
                <th class="center">Qty</th>
                <th class="right">Price</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'Item' }}</td>
                    <td class="center">{{ $item->quantity }}</td>
                    <td class="right">RM{{ number_format($item->price, 2) }}</td>
                    <td class="right">RM{{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td>Subtotal</td>
            <td class="right">RM{{ number_format($order->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td>Shipping</td>
            <td class="right">RM{{ number_format($order->shipping, 2) }}</td>
        </tr>
        <tr>
            <td>Tax</td>
            <td class="right">RM{{ number_format($order->tax, 2) }}</td>
        </tr>
        <tr class="total-row">
            <td>Total</td>
            <td class="right">{{ $order->formatted_total }}</td>
        </tr>
    </table>

</body>
</html>