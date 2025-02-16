@extends('layouts.offer')
{{-- Add this CSS within a <style> tag --}}
    <style>
        @page {
            margin-bottom: 5px; /* Adjust based on footer height */
        }
    
        .pdf-footer {
            position: fixed;
            bottom: 10px; /* Adjust positioning */
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
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

    </style>
    
   
    
    
  
@section('title', 'Price Offer for Flatpack Container')

@section('intro')
    <table class="intro-table">
        <tr>
            <th>SUBJECT:</th>
            <td>Price offer for Flatpack Container</td>
        </tr>
        <tr>
            <th>REF:</th>
            <td>{{ $orderItems->first()->order->reference_code }}</td>
        </tr>
        <tr>
            <th>Date:</th>
            <td>{{ $order->created_at->format('d/m/Y') }}</td>
        </tr>
    </table>

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

     @if ($itemCount > 3) 
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
</div>