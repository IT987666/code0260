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
                <td>{{ $cartItem->price }}</td>
                <td>{{ $cartItem->quantity * $cartItem->price }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- سيتم استبدال النص الثابت بقيمة billing_info -->
{!! $order->billing_info !!}
