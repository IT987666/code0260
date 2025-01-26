@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>All Products</h3>
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
                    <div class="text-tiny">All Products</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search flex-grow">
                        <fieldset class="name">
                            <input type="text" placeholder="Search here..." class="show-search"
                                name="name" id="search-input" tabindex="2" value=""
                                aria-required="true" required="" autocomplete="off">
                        </fieldset>
                        <div class="button-submit">
                            <button class="" type="submit"><i class="icon-search"></i></button>
                        </div>
                        <div class="box-content-search">
                            <ul id="box-content-search">
                            </ul>
                        </div>
                    </form>
                        
</div>
                <a class="tf-button style-1 w208" href="{{route('admin.product.add')}}"><i
                        class="icon-plus"></i>Add new</a>
            </div>
            <div class="table-responsive">
                @if(Session::has('status'))
                <p class="alert alert-success">{{Session::get('status')}}</p>
                  @endif
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                           
                            <th>Product Code</th>
                             <th>Status</th>
                             <th>Last Modification</th>
                             <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                     @foreach ($products as $product )
                         
                    
                        <tr>
                            <td>{{ str_pad($product->id, 3, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="pname">
                                
                                <div class="name">
                                    <a href="#" class="body-title-2">{{$product->name}}</a>
                                </div>
                            </td>
                            <td>{{$product->code}}</td>
                             <td class="text-center">
                                @if($product->stock_status == 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($product->stock_status == 'inactive')
                                    <span class="badge bg-danger">Inactive</span>
                                @else
                                    <span class="badge bg-warning">Unknown</span>
                                @endif
                            </td>
                            <td>{{$product->updated_at}}</td>
                            <td>
                                <div class="list-icon-function">
                                   
                                    <a href="{{route('admin.product.edit',['id'=>$product->id])}}">
                                        <div class="item edit">
                                            <i class="icon-edit-3"></i>
                                        </div>
                                    </a>
                                    <form action="{{route('admin.product.delete',['id'=>$product->id])}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="item text-danger delete">
                                            <i class="icon-trash-2"></i>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach  
                    </tbody>
                </table>
            </div>

            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
         {{$products->links('pagination::bootstrap-5')}}

            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$(function() {
$('.delete').on('click', function(e){
e.preventDefault();
var form = $(this).closest('form');
swal({
title: "Are you sure?",
text: "You want to delete this record?", 
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



  $(function() {
        $("#search-input").on("keyup", function() {
            var searchQuery = $(this).val();

            if (searchQuery.length > 2) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.search') }}",
                    data: {
                        query: searchQuery
                    },
                    dataType: 'json',
                    success: function(data) {
                        $("#box-content-search").html(''); // تفريغ المحتوى الحالي

                        $.each(data, function(index, item) {
                            var url =
                                "{{ route('admin.product.edit', ['id' => ':product_id']) }}";
                            var link = url.replace(':product_id', item.id);

                            $("#box-content-search").append(`
                                <li>
                                    <ul>
                                        <li class="product-item gap14 mb-10">
                                             
                                            <div class="flex items-center justify-between gap20 flex-grow">
                                                <div class="name">
                                                    <a href="${link}" class="body-text">${item.name}</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-10">
                                            <div class="divider"></div>
                                        </li>
                                    </ul>
                                </li>
                            `);
                        });
                    },
                    error: function() {
                        console.error("Failed to fetch search results.");
                    }
                });
            }
        });
    });
</script>
 
@endpush