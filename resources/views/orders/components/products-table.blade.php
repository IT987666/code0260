
<style>
    /* جعل حقل Area أعرض */
    .price-offer-table td:nth-child(3), .price-offer-table th:nth-child(3) {
        width: 150px; /* تغيير هذا الرقم لتعديل العرض كما تريد */
    }

    /* جعل النص في صف Total بالخط العريض */
    .total-row td {
        font-weight: bold;
    }
</style>

<div style="overflow-x: auto !important;">
    <table class="price-offer-table" style="width: 100% !important; border-collapse: collapse !important; table-layout: fixed !important; max-width: 100% !important;">
        <thead>
            <tr style="background-color: #20bec6 !important; color: black !important; text-align: center !important; height: 40px !important;">
                <th style="width: 14% !important; padding: 10px !important; overflow: hidden !important; white-space: nowrap !important;">Item Number</th>
                <th style="width: 39% !important; padding: 10px !important; overflow: hidden !important; white-space: nowrap !important;">Product Description</th>
                <th style="width: 11% !important; padding: 10px !important; overflow: hidden !important; white-space: nowrap !important;">Area (m²)</th>
                <th style="width: 11% !important; padding: 10px !important; overflow: hidden !important; white-space: nowrap !important;">Quantity</th>
                <th style="width: 13% !important; padding: 10px !important; overflow: hidden !important; white-space: nowrap !important;">Unit Price</th>
                <th style="width: 13% !important; padding: 10px !important; overflow: hidden !important; white-space: nowrap !important;">Total Cost</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderItems as $index => $cartItem)
                <tr style="height: 35px !important;">
                    <td style="text-align: center !important; padding: 10px !important;">{{ $index + 1 }}</td>
                    <td style="padding: 10px !important; word-wrap: break-word !important; overflow: hidden !important;">{{ $cartItem->description ?? 'No description available' }}</td>
                    <td style="text-align: center !important; padding: 10px !important;">{{ $cartItem->area }}</td>
                    <td style="text-align: center !important; padding: 10px !important;">{{ $cartItem->quantity }}</td>
                    <td style="text-align: right !important; padding: 10px !important;">${{ number_format($cartItem->price, 2, '.', ',') }}</td>
                    <td style="text-align: right !important; padding: 10px !important;">${{ number_format($cartItem->quantity * $cartItem->price, 2, '.', ',') }}</td>
                </tr>
            @endforeach
            <tr style="height: 40px !important;">
                <td colspan="5" style="text-align: right !important; font-weight: bold !important; padding: 10px !important;">TOTAL COST WITHOUT SHIPPING (USD)</td>
                <td style="text-align: right !important; font-weight: bold !important; padding: 10px !important;">${{ number_format($order->subtotal, 2, '.', ',') }}</td>
            </tr>
        </tbody>
    </table>
</div>

<!-- تحسين التجاوب باستخدام media queries -->
<style>
@media (max-width: 768px) {
    .price-offer-table th, 
    .price-offer-table td {
        padding: 8px !important;
        font-size: 14px !important;
    }
}

@media (max-width: 480px) {
    .price-offer-table th, 
    .price-offer-table td {
        padding: 6px !important;
        font-size: 12px !important;
    }
}
</style>





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


<div class="billing-info-table" style="overflow-x: auto;">
    {!! $order->billing_info !!}
</div>

<style>
/* استهداف الجداول داخل .billing-info-table */
.billing-info-table table {
    width: 100% !important;
    border-collapse: collapse !important;
}

.billing-info-table table th {
    background-color: #20bec6 !important;
    color: black !important;
    text-align: center !important;
    padding: 10px !important;
    font-weight: bold !important;
    border: 1px solid #ccc !important;
}

.billing-info-table table td {
    padding: 10px !important;
    text-align: center !important;
    border: 1px solid #ccc !important;
}

/* تحسين التجاوب مع الشاشات الصغيرة */
@media (max-width: 768px) {
    .billing-info-table table th,
    .billing-info-table table td {
        padding: 8px !important;
        font-size: 14px !important;
    }
}

@media (max-width: 480px) {
    .billing-info-table table th,
    .billing-info-table table td {
        padding: 6px !important;
        font-size: 12px !important;
    }
}
table {/*مشان تقطيع ل جداول*/
    page-break-inside: avoid;
    width: 100%;
}

tr {
    page-break-inside: avoid;
    page-break-before: auto;
}

thead {
    display: table-header-group;
}

tfoot {
    display: table-footer-group;
}
/*مشان تقطيع ل جداول*/
</style>
