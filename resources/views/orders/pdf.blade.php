@extends('layouts.offer')
{{-- Add this CSS within a <style> tag --}}
    <style>
        @page {
            margin-bottom: 3px; /* Adjust based on footer height */
        }
        .contact-info {
    margin-top: 5px; /* يضيف مسافة بين الصورة والنص */
}

       
        .pdf-footer {
    position: fixed;
    bottom: -40px; /* تقليل المسافة بين الفوتر والحافة السفلية */
    left: 0;
    right: 0;
    text-align: center;
    font-size: 9px; /* تقليل حجم النص */
    line-height: 1.2; /* تصغير المسافات بين الأسطر */
    padding: 5px 0; /* تقليل الحشو داخل الفوتر */
}
        .pdf-footer img {
            width: 700; /* Adjust size as needed */
            height: auto;
            display: block;
            margin: 0 auto;
        }
    
        .pdf-footer .page-number::after {
            content: counter(page);
        }
    
        .pdf-footer .total-pages:after {
            content: counter(pages);
        }
        table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid black !important;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f2f2f2 !important;
    font-weight: bold;
}
.intro-container {
    font-size: 14px;
    line-height: 1.6;
}

.intro-container p {
    margin: 5px 0;
    display: flex;
    align-items: baseline; /* يجعل النصوص بنفس الخط */
}

.intro-container strong {
    font-weight: bold;
    display: inline-block;
    width: 120px; /* ضبط عرض العناوين */
}
.price-offer-table th {
    background-color: #20bec6 !important;
    color: black !important;
    text-align: center;
}
    </style>
    
   
    
    
  
@section('title', 'Price Offer for Flatpack Container')

@section('intro')
<div class="intro-container">
    <p><strong>SUBJECT:</strong> Price offer for Flatpack Container</p>
    <p><strong>REF:</strong> {{ $orderItems->first()->order->reference_code }}</p>
    <p><strong>Date:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
</div>


    <div class="extra">
        @if (!empty($order->extra))
            {!! $order->extra !!}
        @endif

        <p class="manager-signature"><strong>{{ Auth::user()->name }}</strong><br>Branch Manager</p>
    </div>

    <div>
        <h3>Attachments:</h3>
        <ul class="attachments-list">
            <li>Attachment-1: Price Offer</li>
            <li>Attachment-2: Technical Specification</li>
            <li>Attachment-3: Technical Drawing or Image</li>
        </ul>
    </div>
@endsection

{{-- ------------------------------------------------------- --}}

@section('priceOffer')
    <h3>Attachment-1: Price Offer</h3>
    @include('orders.components.products-table', ['orderItems' => $orderItems]) <!-- Use orderItems -->
@endsection

{{-- ------------------------------------------------------- --}}
@section('technicalSpecification')
     @php
        $itemCount = count($orderItems);
    @endphp

     @if ($itemCount > 15) 
        <div style="page-break-before: always;">
            <h3>Attachment-2: Technical Specification</h3>
        </div>
    @else
         <h3>Attachment-2: Technical Specification</h3>
    @endif

    @include('orders.components.products-specification', ['orderItems' => $orderItems])
@endsection

{{-- ------------------------------------------------------- --}}

@section('technicalDrawingOrImage')
    <h3>Attachment-3: Technical Drawing or Image</h3>
    @include('orders.components.products-technical-drawing', ['order' => $order])
@endsection
 {{-- Footer HTML --}}
<div class="pdf-footer">
    <img src="{{ public_path('images/logo/Picture1.png') }}" alt="Footer Image">
    <span class="page-number"></span>
    <div class="contact-info">
        <p>
            Yesilbaglar Mh. Selvili Sk. Helis Beyaz Ofis B Blok No:2/2/22-23 Pendik/Istanbul/Turkey<br>
            <span style="color: #20bec6;">Tel.: +90 216 306 7374</span> / 
            <span style="color: #20bec6;">E-Mail: info@prefabex.com</span><br>
            <a href="http://www.prefabex.com" target="_blank" style="color: #20bec6;">www.prefabex.com</a>
        </p>
    </div>
</div>
