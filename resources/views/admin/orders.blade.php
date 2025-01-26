@extends('layouts.admin')

<style>
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.1) !important;
     }
</style>

<style>
    .modal-dialog-centered {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        margin: 0;
    }

    .modal-content {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        /* Adjust shadow */
        border-radius: 8px;
        /* Optional rounded corners */
    }
    .list-icon-function {
    display: flex;
    justify-content: center;
    gap: 15px; /* مسافة بين الأيقونات */
}

.list-icon-function a {
    padding: 5px; /* لزيادة المساحة القابلة للنقر حول الأيقونة */
    border-radius: 5px; /* إضافة زوايا مستديرة اختيارياً */
    transition: background-color 0.2s ease; /* تأثير مرئي عند التمرير */
}

.list-icon-function a:hover {
    background-color: rgba(0, 0, 0, 0.1); /* تغيير اللون عند التمرير */
}
td.text-center a.edit-note {
    white-space: nowrap; /* منع النص من الالتفاف */
    overflow: hidden; /* إخفاء النص الزائد */
    text-overflow: ellipsis; /* إضافة ثلاث نقاط (...) عند تجاوز النص */
    display: inline-block;
    max-width: 100px; /* عرض محدد للعنصر */
    vertical-align: middle;
}

td.text-center a.edit-note:hover {
    overflow: visible; /* إظهار النص الكامل عند التمرير */
    white-space: normal;
    word-wrap: break-word;
    position: relative;
    z-index: 10;
    background-color: #f9f9f9; /* خلفية واضحة للنص */
    padding: 5px;
    border: 1px solid #ccc; /* حدود لإظهار النص بشكل مميز */
    border-radius: 5px; /* زوايا دائرية */
}





/* تنسيق صندوق نتائج البحث */
#box-content-search-order {
    max-height: 300px; /* تحديد ارتفاع الصندوق */
    overflow-y: auto; /* إتاحة التمرير إذا تجاوزت النتائج الطول */
    border: 1px solid #ddd;
    background-color: #fff;
    padding: 10px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    position: absolute; /* ليظهر فوق العناصر الأخرى */
    width: 100%;
    z-index: 1000;
}

/* تنسيق العناصر الفردية */
#box-content-search-order li {
    list-style: none;
    padding: 8px 10px;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    align-items: center;
    gap: 15px;
    transition: background-color 0.3s ease;
}

#box-content-search-order li:last-child {
    border-bottom: none;
}

#box-content-search-order li:hover {
    background-color: #f9f9f9;
    cursor: pointer;
}

/* تنسيق النصوص داخل النتائج */
.order-item .name {
    font-size: 1rem;
    font-weight: bold;
    color: #333;
    text-decoration: none;
}

.order-item .name:hover {
    color: #007bff; /* لون عند التمرير */
}

.order-item .status {
    font-size: 0.8rem;
    padding: 2px 6px;
    border-radius: 4px;
}

.order-item .status.badge-success {
    background-color: #28a745;
    color: #fff;
}

.order-item .status.badge-warning {
    background-color: #ffc107;
    color: #212529;
}

.order-item .status.badge-danger {
    background-color: #dc3545;
    color: #fff;
}
.table-responsive {
    overflow-y: auto !important; /* إجبار التمرير */
    max-height: 500px !important; /* تحديد أقصى ارتفاع */
}

</style>

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Orders</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Orders</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search flex-grow" id="order-search-form">
                            <fieldset class="name">
                                <input type="text" placeholder="Search Orders..." class="show-search" name="name"
                                    id="search-input-order" tabindex="2" autocomplete="off">
                            </fieldset>

                            <div class="box-content-search">
                                <ul id="box-content-search-order"></ul>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width:70px">ID Number</th>
                                    <th class="text-center">Client's Name</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Order Date</th>
                                    <th class="text-center">Total Items</th>
                                    <th class="text-center">Delivered On</th>
                                    <th class="text-center">Canceled On</th>
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
                                        <td class="text-center">
                                            {{ $order->delivered_date ? \Carbon\Carbon::parse($order->delivered_date)->format('Y-m-d H:i:s') : 'N/A' }}
                                        </td>
                                        <td class="text-center">
                                            {{ $order->status == 'canceled' ? \Carbon\Carbon::parse($order->canceled_date)->format('Y-m-d H:i:s') : 'N/A' }}
                                            <!-- عرض تاريخ الإلغاء في العمود الجديد -->
                                        </td>
                                        
                                        <td class="text-center">
                                            <a href="javascript:void(0)" class="edit-note"
                                                data-order-id="{{ $order->id }}" data-note="{{ $order->note }}">
                                                {{ $order->note ? $order->note : 'Add Note' }}
                                            </a>
                                        </td>
                                        

                                        <td class="text-center">
                                            <div class="list-icon-function">
                                                <a href="{{ route('admin.order.details', ['order_id' => $order->id]) }}" title="View Details">
                                                    <i class="icon-eye"></i>
                                                </a>
                                                <a href="{{ route('user.order.edit', ['order_id' => $order->id]) }}" title="Edit Order">
                                                    <i class="fa fa-edit text-primary" style="font-size: 1.2rem;"></i>
                                                </a>
                                            </div>
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
        $(function () {
    $("#search-input-order").on("keyup", function () {
        var searchQuery = $(this).val();

        if (searchQuery.length > 2) {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.orders.search') }}",
                data: { query: searchQuery },
                dataType: 'json',
                success: function (data) {
                    $("#box-content-search-order").html(''); // مسح النتائج القديمة

                    if (data.length === 0) {
                        $("#box-content-search-order").append('<li>No results found.</li>');
                    } else {
                        $.each(data, function (index, item) {
                            if (item && item.name && item.id && item.status) {
                                // تحديد الكلاس بناءً على الحالة
                                let statusClass = '';
                                switch (item.status.toLowerCase()) {
                                    case 'delivered':
                                        statusClass = 'badge-success'; // أخضر
                                        break;
                                    case 'canceled':
                                        statusClass = 'badge-danger'; // أحمر
                                        break;
                                    case 'ordered':
                                        statusClass = 'badge-warning'; // أصفر
                                        break;
                                    default:
                                        statusClass = 'badge-secondary'; // رمادي (افتراضي)
                                }

                                var link = "{{ route('admin.order.details', ['order_id' => ':order_id']) }}";
                                link = link.replace(':order_id', item.id);

                                $("#box-content-search-order").append(`
                                    <li>
                                        <div class="order-item">
                                            <div class="order-info">
                                                <a href="${link}" class="name">${item.name}</a>
                                                <span class="status badge ${statusClass}">${item.status}</span>
                                            </div>
                                        </div>
                                    </li>
                                `);
                            } else {
                                console.warn("Invalid item data: ", item);
                            }
                        });
                    }
                },
                error: function () {
                    console.error("Failed to fetch search results.");
                }
            });
        } else {
            $("#box-content-search-order").html(''); // إخفاء النتائج
        }
    });
});

        </script>

        <script>
            $(document).ready(function() {
                // Open the modal when clicking on the note
                $(document).on('click', '.edit-note', function() {
                    const orderId = $(this).data('order-id');
                    const note = $(this).data('note');

                    // Set values in the modal
                    $('#order-id').val(orderId);
                    $('#order-note').val(note);

                    // Show the modal
                    $('#editNoteModal').modal('show');
                });

                // Save the note
                $('#save-note-btn').on('click', function() {
                    const orderId = $('#order-id').val();
                    const note = $('#order-note').val();

                    // Send the updated note to the server
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('admin.orders.updateNote') }}', // Adjust the route name accordingly
                        data: {
                            _token: '{{ csrf_token() }}',
                            order_id: orderId,
                            note: note
                        },
                        success: function(response) {
                            // Update the note in the table
                            $(`.edit-note[data-order-id="${orderId}"]`).text(note || 'Add Note');

                            // Hide the modal
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
