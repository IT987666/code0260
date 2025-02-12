<table class="price-offer-table">
    <thead>
        <tr style="background-color: #20bec6; color:black">
            <th>Product Description</th>
            <th>Quantity</th>
            <th>Unit Price (USD)</th>
            <th>Total Amount (USD)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orderItems as $cartItem)
            <tr>
                <td>{{ $cartItem->description ?? 'No description available' }}</td>
                <td>{{ $cartItem->quantity }}</td>
                <td>${{ number_format($cartItem->price, 2, '.', ',') }}</td>
                <td>${{ number_format($cartItem->quantity * $cartItem->price, 2, '.', ',') }}</td>
            </tr>
        @endforeach
        <!-- صف الإجمالي -->
        <tr style="background-color: #f8f9fa; font-weight: bold;">
            <td style="text-align: left;">Total:</td> <!-- تم التعديل هنا -->
            <td colspan="2"></td> <!-- خلايا فارغة لتنسيق الجدول -->
            <td>${{ number_format($order->subtotal, 2, '.', ',') }}</td>
        </tr>
    </tbody>
</table>



<!-- سيتم استبدال النص الثابت بقيمة billing_info -->
{!! $order->billing_info !!}
