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
            <td style="text-align: center;">Total:</td> <!-- جعل النص في المنتصف -->
            <td></td> <!-- عمود الكمية -->
            <td></td> <!-- عمود السعر -->
            <td>${{ number_format($order->subtotal, 2, '.', ',') }}</td>
        </tr>
    </tbody>
</table>


@if ($shipping_type)
    <h3>Shipping Type</h3>
    <table class="checkout-cart-items">
        <thead>
            <tr>
                <th>shipping type</th>
                <th>quantity</th>
                <th>unit price</th>
                <th>shipping cost</th>
                <th>total cost</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $shipping_type->shipping_type }}</td>
                <td class="text-right">
                    {{ $shipping_type->quantity }}
                </td>
                <td class="text-right">
                    {{ $shipping_type->unit_price }}
                </td>
                <td class="text-right">
                    {{ $shipping_type->shipping_cost }}
                </td>
                <td class="text-right">{{ $shipping_type->total_cost }}</td>

            </tr>


        </tbody>

    </table>
@endif



<!-- سيتم استبدال النص الثابت بقيمة billing_info -->
{!! $order->billing_info !!}
