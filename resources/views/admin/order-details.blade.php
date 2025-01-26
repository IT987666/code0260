@extends('layouts.admin')
@section('content')

<style>
    .table-transaction>tbody>tr:nth-of-type(odd) {
        --bs-table-accent-bg: #fff !important;
    }
</style>
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Order Details</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{route('admin.index')}}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Order Details</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <h5>Ordered Details</h5>
                </div>
                <a class="tf-button style-1 w208" href="{{route('admin.orders')}}">Back</a>
            </div>
            <div class="table-responsive">
                @if(Session:: has('status'))

                    <p class="alert alert-success">{{Session::get('status')}}</p>

                    @endif
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Order No</th>
                        <td>{{ $order->id }}</td>
                        <th>Mobile</th>
                        <td>{{ $order->phone }}</td>
                        <th> </th>
                        <td> </td>
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

        <br><br> 
        <div class="wg-box">
           
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                          </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderItems as $item) 
                        <tr>
                            <td class="pname">
                                
                                <div class="name">
                                         {{ $item->product->name }}
                                    </a>
                                </div>
                            </td>
                            <td class="text-center">${{ $item->price }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                                
                                
                            </td> 
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
            <h5>Shipping Address</h5>
            <div class="my-account__address-item col-md-6">
                <div class="my-account_address-item_detail">
                    <p>{{ $order->name }}</p>
                    
                    
                    {{ $order->country }}</p>
                     <p>{{ $order->email }}</p> 
                    <br>
                    <p><strong>Mobile:</strong> {{ $order->phone }}</p>
                </div>
                
            </div>
        </div>

        <div class="wg-box mt-5">

            <h5>Update Order Status</h5>
            
            <form action="{{route('admin.order.status.update')}}" method="POST">
            
            @csrf
            
            @method('PUT')
            
            <input type="hidden" name="order_id" value="{{$order->id}}" />
            
            <div class="row">
            
                <div class="col-md-3">
                
                    <select id="order_status" name="order_status">
                        <option value="ordered" {{ $order->status == 'ordered' ? 'selected' : '' }}>Ordered</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="canceled" {{ $order->status == 'canceled' || $order->status == 'cancelled' ? 'selected' : '' }}>Canceled</option>
                        <option value="offer_sent" {{ $order->status == 'offer_sent' ? 'selected' : '' }}>Offer Sent</option>
                        <option value="offer_signed" {{ $order->status == 'offer_signed' ? 'selected' : '' }}>Offer Signed</option>
                        <option value="downpayment_received" {{ $order->status == 'downpayment_received' ? 'selected' : '' }}>Downpayment Received</option>
                        <option value="in_production" {{ $order->status == 'in_production' ? 'selected' : '' }}>In Production</option>
                        <option value="pending_final_payment" {{ $order->status == 'pending_final_payment' ? 'selected' : '' }}>Pending Final Payment</option>
                        <option value="final_payment_received" {{ $order->status == 'final_payment_received' ? 'selected' : '' }}>Final Payment Received</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    </select>
                    
                
                </div>
                
                <div class="col-md-3">
                
                <button type="submit" class="btn btn-primary tf-button w208">Update Status</button>
                
                </div>
                
                </div>
            
            </form>
            
            </div>
            
        
    </div>
</div>

@endsection