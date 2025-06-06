@extends('layouts.app')
@section('content')
<style>
    .pt-90 {
      padding-top: 90px !important;
    }

    .pr-6px {
      padding-right: 6px;
      text-transform: uppercase;
    }

    .my-account .page-title {
      font-size: 1.5rem;
      font-weight: 700;
      text-transform: uppercase;
      margin-bottom: 40px;
      border-bottom: 1px solid;
      padding-bottom: 13px;
    }

    .my-account .wg-box {
      display: -webkit-box;
      display: -moz-box;
      display: -ms-flexbox;
      display: -webkit-flex;
      display: flex;
      padding: 24px;
      flex-direction: column;
      gap: 24px;
      border-radius: 12px;
      background: var(--White);
      box-shadow: 0px 4px 24px 2px rgba(20, 25, 38, 0.05);
    }

    .bg-success {
      background-color: #40c710 !important;
    }

    .bg-danger {
      background-color: #cf0c0c !important;
    }

    .bg-warning {
      background-color: #f5d700 !important;
      color: #000;
    }

    .table-transaction>tbody>tr:nth-of-type(odd) {
      --bs-table-accent-bg: #fff !important;

    }

    .table-transaction th,
    .table-transaction td {
      padding: 0.625rem 1.5rem .25rem !important;
      color: #000 !important;
    }

    .table> :not(caption)>tr>th {
      padding: 0.625rem 1.5rem .25rem !important;
      background-color: #109faf !important;
    }

    .table-bordered>:not(caption)>*>* {
      border-width: inherit;
      line-height: 32px;
      font-size: 14px;
      border: 1px solid #e1e1e1;
      vertical-align: middle;
    }

    .table-striped .image {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 50px;
      height: 50px;
      flex-shrink: 0;
      border-radius: 10px;
      overflow: hidden;
    }

    .table-striped td:nth-child(1) {
      min-width: 250px;
      padding-bottom: 7px;
    }

    .pname {
      display: flex;
      gap: 13px;
    }

    .table-bordered> :not(caption)>tr>th,
    .table-bordered> :not(caption)>tr>td {
      border-width: 1px 1px;
      border-color: #109faf;
    }
    .btn-custom-black {
    background-color: #000; /* لون الخلفية أسود */
    color: #fff; /* لون النص أبيض */
    border: 1px solid #000; /* حدود الزر أسود */
}

.btn-custom-black:hover {
    background-color: #333; /* لون الخلفية عند التمرير */
    color: #fff; /* لون النص */
    transform: scale(1.05); /* تكبير الزر قليلاً عند التمرير */
    transition: transform 0.3s ease, background-color 0.3s ease;
}
.btn-custom-black {
    background-color: #000; /* لون الخلفية أسود */
    color: #fff; /* لون النص أبيض */
    border: 1px solid #000; /* حدود الزر أسود */
}

.btn-custom-black:hover {
    background-color: #333; /* لون الخلفية عند التمرير */
    color: #fff; /* لون النص */
    transform: scale(1.05); /* تأثير تكبير خفيف */
    transition: transform 0.3s ease, background-color 0.3s ease;
}

    
  </style>
    <main class="pt-90" style="padding-top: 0px;">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Orders Details</h2>
            <div class="row">
                <div class="col-lg-2">
                    @include('user.account-nav')

                </div>

                <div class="col-lg-10">
                 
                    <div class="wg-box">
                        <div class="flex items-center justify-between gap10 flex-wrap">
                           
<div class="row">
    <div class="col-6">
        <h5>Ordered Details</h5>

    </div>
    <div class="col-6 text-right">
        <a class="btn btn-sm btn-custom-black" href="{{route('user.orders')}}">Back</a>

    </div>
</div>
                        </div> 
                        <div class="table-responsive">
                            @if(Session:: has('status'))

                            <p class="alert alert-success">{{Session::get('status')}}</p>
        
                            @endif
                            <table class="table table-bordered table striped table transition">
                                <tr>
                                    <th>Order No</th>
                                    <td>{{ $order->id }}</td>
                                    <th>Mobile</th>
                                    <td>{{ $order->phone }}</td>
                                    <th>Zip Code</th>
                                    <td>{{ $order->zip }}</td>
                                </tr>
                                <tr>
                                    <th>Order Date</th>
                                    <td>{{ $order->created_at }}</td>
                                    <th>Delivered Date</th>
                                    <td>{{ $order->delivered_date }}</td>
                                    <th>Canceled Date</th>
                                    <td>{{ $order->canceled_date }}</td>
                                </tr>
                                <tr>
                                    <th>Order Status</th>
                                    <td colspan="5">
                                        @if($order->status == 'delivered')
                                            <span class="badge bg-success">Delivered</span>
                                        @elseif($order->status == 'canceled' || $order->status == 'cancelled')
                                            <span class="badge bg-danger">Canceled</span>
                                        @elseif($order->status == 'offer_sent')
                                            <span class="badge bg-info">Offer Sent</span>
                                        @elseif($order->status == 'offer_signed')
                                            <span class="badge bg-primary">Offer Signed</span>
                                        @elseif($order->status == 'downpayment_received')
                                            <span class="badge bg-secondary">Downpayment Received</span>
                                        @elseif($order->status == 'in_production')
                                            <span class="badge bg-warning">In Production</span>
                                        @elseif($order->status == 'pending_final_payment')
                                            <span class="badge bg-dark">Pending Final Payment</span>
                                        @elseif($order->status == 'final_payment_received')
                                            <span class="badge bg-success">Final Payment Received</span>
                                        @elseif($order->status == 'shipped')
                                            <span class="badge bg-info">Shipped</span>
                                        @else
                                            <span class="badge bg-warning">Ordered</span>
                                        @endif
                                    </td>
                                </tr>
                                
                            </table>
                            
                        </div>
            
                        <div class="divider"></div>
                      
                    </div>
            
            
                    <div class="wg-box">
                        <div class="flex items-center justify-between gap10 flex-wrap">
                            <div class="wg-filter flex-grow">
                                <h5>Ordered Items</h5>
                            </div>
                           
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Quantity</th>
                                         <th class="text-center">Return Status</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td class="pname">
                                            <div class="image">
                                                @if (!empty($specification['images']))
                                                    @foreach ($specification['images'] as $image)
                                                        <img src="{{ asset('storage/' . $image) }}" 
                                                             alt="Specification Image" class="image" style="max-width: 50px; margin: 5px;">
                                                    @endforeach
                                                @else 
                                                    <span>No images available</span>
                                                @endif
                                            </div> 
                                            <div class="name">
                                                <a href="{{ route('shop.product.details', ['product_slug' => $item->product->slug]) }}" 
                                                   target="_blank" class="body-title-2">
                                                    {{ $item->product->name }}
                                                </a>
                                            </div>
                                        </td>
                                        
                                        
                                        <td class="text-center">${{ $item->price }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        
                                         <td class="text-center">{{ $item->rstatus == 0 ? 'No' : 'Yes' }}</td>
                                       
                                    </tr>
                                    @endforeach
                                    
            
                                </tbody>
                            </table>
                        </div>
            
                        <div class="divider"></div>
                        <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                            {{$orderItems->links('pagination::bootstrap-5')}}            {{--</div>--}}
            
                        </div>
                    </div>
            
                    <div class="wg-box mt-5">
                        <h5>Customer Information</h5>
                        <div class="my-account__address-item col-md-6">
                            <div class="my-account_address-item_detail">
                                <p>{{ $order->name }}</p>
                                      {{ $order->country }}</p>
                                  <br>
                                <p><strong>Mobile:</strong> {{ $order->phone }}</p>
                            </div>
                            
                        </div>
                    </div>
            
                    <div class="wg-box mt-5">
                        <h5>Transactions</h5>
                        <table class="table table-striped table-bordered table-transaction">
                            <tbody>
                                <tr>
                                    <th>Total</th>
                                    <td>${{$order->subtotal}}</td>
                              
                                </tr>
                                  
                            </tbody>
                        </table>
                    </div>
                    @if ($order->status=='ordered')
                        
                
                    <div class="wg-box mt-5 text-right">

                        <form action="{{ route('user.order.cancel') }}" method="POST">
                        
                            @csrf
                            @method('PUT')
                        
                            <input type="hidden" name="order_id" value="{{ $order->id }}" />
                        
                            <button type="button" class="btn btn-custom-black cancel-order">Cancel Order</button>
                        
                        </form>
                        
                        </div>
                       
                        @endif
                </div>

            </div>
        </section>
    </main>
@endsection
@push('scripts')
<script>
$(function() {
$('.cancel-order').on('click', function(e){
e.preventDefault();
var form = $(this).closest('form');
swal({
title: "Are you sure?",
text: "You want to cancel this order?", 
type: "warning",
buttons: ["No", "Yes"],
confirmButtonColor: '#dc3545'
}).then(function(result) {
if (result) {
form.submit();
}
});
});
});
</script>
@endpush