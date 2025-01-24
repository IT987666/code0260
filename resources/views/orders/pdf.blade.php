@extends('layouts.offer')

@section('title', 'Price Offer for Flatpack Container')

@section('intro')
    <table class="intro-table">
        <tr>
            <th>SUBJECT:</th>
            <td>Price offer for Flatpack Container</td>
        </tr>
        <tr>
            <th>REF:</th>
            <td>{{ $orderItems->first()->product->slug }}</td>
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
    <h3>Attachment-2: Technical Specification</h3>
    @include('orders.components.products-specification', ['orderItems' => $orderItems]) <!-- Use orderItems -->
@endsection

{{-- ------------------------------------------------------- --}}

@section('technicalDrawingOrImage')
    <h3>Attachment-3: Technical Drawing or Image</h3>
    @include('orders.components.products-technical-drawing', ['order' => $order])
@endsection
