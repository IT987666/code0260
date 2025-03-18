@extends('layouts.offer')
{{-- Add this CSS within a <style> tag --}}
    <style>
        @page {
            margin-bottom: 3px;
            /* Adjust based on footer height */
     background: url('{{ public_path('images/logo/logo.png') }}') no-repeat center center;
    background-size: cover; /* لجعل الصورة تغطي الصفحة بالكامل */

        }
    
        /* نوع الخط العام */
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: #000;
        }
        .background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('{{ public_path('images/logo/enhanced_photo.png') }}') no-repeat center center;
    background-size: cover;
    opacity: 0.1; /* تقليل الوضوح لمحاكاة الشفافية */
    z-index: -1;
}

        /* تنسيق العناوين الرئيسية */
        h1, .main-title {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }
    
        /* تنسيق العناوين الفرعية */
        h2, .sub-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 5px;
        }
    
        /* تنسيق النصوص العادية */
        p, .body-text {
            font-size: 14px;
            line-height: 1.5;
            margin: 5px 0;
        }
    
        /* تنسيق القوائم */
        ul {
            padding-left: 20px;
        }
    
        ul li {
            margin-bottom: 5px;
        }
    
        /* تنسيق الجداول */
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
    
        /* الفوتر */
        .pdf-footer {
            position: fixed;
            bottom: -40px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            line-height: 1.2;
            padding: 5px 0;
        }
    
        .pdf-footer img {
            width: 500px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
    
        .pdf-footer .page-number::after {
            content: counter(page);
        }
    
        .pdf-footer .total-pages::after {
            content: counter(pages);
        }
    
        /* تنسيق معلومات الاتصال */
        .contact-info {
            margin-top: 5px;
        }
    
        /* تنسيق القسم التمهيدي */
        .intro-container {
            font-size: 14px;
            line-height: 1.6;
        }
    
        .intro-container p {
            margin: 5px 0;
            display: flex;
            align-items: baseline;
        }
    
        .intro-container strong {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
    
        /* تنسيق جداول عروض الأسعار */
        .price-offer-table th {
            background-color: #20bec6 !important;
            color: black !important;
            text-align: center;
        }
    
        /* تنسيق عناوين سلة المشتريات */
        .checkout-cart-items thead tr {
            background-color: #20bec6 !important;
            color: black !important;
        }
    
        /* رقم الصفحة */
        .page-number-container {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            font-size: 14px;
            font-weight: bold;
        }
     
        table {
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
    @include('orders.components.products-table', [
        'orderItems' => $orderItems,
        'shipping_type' => $shipping_type,
    ]) <!-- Use orderItems -->
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
    <div class="page-number-container">
        <span class="page-number"></span>
    </div>
    <img src="{{ public_path('images/logo/Picture1.png') }}" alt="Footer Image">
    <div class="contact-info">
    
        <p style="font-size: 12px;">
            Yesilbaglar Mh. Selvili Sk. Helis Beyaz Ofis B Blok No:2/2/22-23 Pendik/Istanbul/Turkey<br>
            <span style="color: #20bec6;">Tel.: +90 216 306 7374</span>, 
            E-Mail: <span style="color: #20bec6;">info@prefabex.com</span>, 
            Website: <a href="http://www.prefabex.com" target="_blank" style="color: #20bec6;">www.prefabex.com</a>
        </p>
        
    </div>
    
</div>
