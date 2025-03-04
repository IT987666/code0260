@extends('layouts.app')
@section('content')
    <style>
        .table> :not(caption)>tr>th {
            padding: 0.625rem 1.5rem .625rem !important;
            background-color: #109faf !important;
        }

        .table>tr>td {
            padding: 0.625rem 1.5rem .625rem !important;
        }

        .table-bordered> :not(caption)>tr>th,
        .table-bordered> :not(caption)>tr>td {
            border-width: 1px 1px;
            border-color: #109faf;
        }

        .table> :not(caption)>tr>td {
            padding: .8rem 1rem !important;
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
    </style>
    <main class="pt-90" style="padding-top: 0px;">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Orders</h2>
            <div class="row">
                <div class="col-lg-2">
                    @include('user.account-nav')

                </div>

                <div class="col-lg-10">
                    <div class="wg-table table-all-user">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 80px">OrderNo</th>
                                        <th>Name</th>
                                        <th class="text-center">Phone</th>
                                        <th class="text-center">Total</th>

                                        <th class="text-center">Status</th>
                                        <th class="text-center">Order Date</th>
                                        <th class="text-center">Items</th>
                                        <th class="text-center">Delivered On</th>
                                        <th class="text-center">Notes</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="text-center">{{ $order->id }}</td>
                                            <td class="text-center">{{ $order->name }}</td>
                                            <td class="text-center">{{ $order->phone }}</td>
                                            <td class="text-center">${{ $order->subtotal }}</td>
                                            <td class="text-center">
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
                                            
                                            <td class="text-center">{{ $order->created_at }}</td>
                                            <td class="text-center">{{ $order->orderItems->count() }}</td>
                                            <td class="text-center">{{ $order->delivered_date ?? 'N/A' }}</td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="edit-note"
                                                    data-order-id="{{ $order->id }}" data-note="{{ $order->note }}">
                                                    {{ $order->note ? $order->note : 'Add Note' }}
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('user.order.details', ['order_id' => $order->id]) }}">

                                                    <div class="list-icon-function view-icon">
                                                        <div class="item eye">
                                                            <i class="fa fa-eye"></i>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="{{ route('user.order.edit', ['order_id' => $order->id]) }}"
                                                    class="ms-2" title="Edit Order">
                                                    <i class="fa fa-edit text-primary" style="font-size: 1.2rem;"></i>
                                                </a>

                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                        {{ $orders->links('pagination::bootstrap-5') }}
                    </div>
                </div>

            </div>
        </section>
    </main>


    <div class="modal fade" id="editNoteModal" tabindex="-1" aria-labelledby="editNoteModalLabel" aria-hidden="true"
        data-bs-backdrop="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editNoteModalLabel">Edit Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-note-form">
                        <div class="mb-3">
                            <label for="order-note" class="form-label">Note</label>
                            <textarea class="form-control" id="order-note" rows="3"></textarea>
                        </div>
                        <input type="hidden" id="order-id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="save-note-btn">Save Note</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.edit-note', function() {
                const orderId = $(this).data('order-id');
                const note = $(this).data('note');

                $('#order-id').val(orderId);
                $('#order-note').val(note);

                $('#editNoteModal').modal('show');
            });

            $('#save-note-btn').on('click', function() {
                const orderId = $('#order-id').val();
                const note = $('#order-note').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.orders.updateNote') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        order_id: orderId,
                        note: note
                    },
                    success: function(response) {
                        $(`.edit-note[data-order-id="${orderId}"]`).text(note || 'Add Note');

                        $('#editNoteModal').modal('hide');


                    },
                    error: function() {
                        alert('Failed to update the note.');
                    }
                });
            });
        });
    </script>
@endpush
