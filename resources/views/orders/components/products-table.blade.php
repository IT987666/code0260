
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
    <table class="checkout-cart-items" style="width: 100%; border-collapse: collapse; border: 1px solid black;">
        <thead>
            <tr style="background-color: #20bec6 !important; color: black !important;">
                <th style="border: 1px solid black; padding: 8px; background-color: #20bec6 !important; color: black !important;">
                    Shipping Type
                </th>
                <th style="border: 1px solid black; padding: 8px; background-color: #20bec6 !important; color: black !important;">
                    Quantity
                </th>
                <th style="border: 1px solid black; padding: 8px; background-color: #20bec6 !important; color: black !important;">
                    Unit Price (USD)
                </th>
                <th style="border: 1px solid black; padding: 8px; background-color: #20bec6 !important; color: black !important;">
                    Shipping Cost (USD)
                </th>
            </tr>
        </thead>
        
        
        <tbody>
            <tr style="background-color: #f8f9fa;">
                <td style="border: 1px solid black; padding: 8px;">{{ $shipping_type->shipping_type }}</td>
                <td style="border: 1px solid black; padding: 8px; text-align: right;">{{ $shipping_type->quantity }}</td>
                <td style="border: 1px solid black; padding: 8px; text-align: right;">{{ $shipping_type->unit_price }}</td>
                <td style="border: 1px solid black; padding: 8px; text-align: right;">{{ $shipping_type->shipping_cost }}</td>
            </tr>
        </tbody>

        <tfoot>
            <tr>
                <td colspan="3" style="border: 1px solid black; padding: 8px; font-weight: bold; text-align: right;">
                    TOTAL COST WITH SHIPPING (USD):
                </td>
                <td style="border: 1px solid black; padding: 8px; text-align: right; font-weight: bold;">
                    {{ $shipping_type->total_cost }}
                </td>
            </tr>
        </tfoot>
    </table>

    <!-- الملاحظة تحت الجدول -->
    <p style="margin-top: 10px; font-weight: bold;">
        Given offer is {{ $shipping_type->shipping_incoterm }} - Jeddah Port according to Incoterms {{ $shipping_type->port_name_or_city }}.
    </p>
@endif



<!-- سيتم استبدال النص الثابت بقيمة billing_info -->
{!! $order->billing_info !!}
