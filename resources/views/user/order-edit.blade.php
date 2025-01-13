@extends('layouts.app')
@section('content')

@push('styles')
    <style>
        /* تحديث الأزرار */


        /* زر إزالة الصورة */
        .remove-old-image-btn {
            position: absolute;
            top: 0;
            right: 0;
            background-color: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            cursor: pointer;
        }

        /* توسيط باستخدام Flexbox */


        /* تحسين النصوص */
        .form-group label {
            font-weight: bold;
            color: #333;
        }

        /* معرض الصور */
        .gallery-preview {
            margin-bottom: 10px;
        }

        .gitems {
            display: inline-block;
            margin-right: 10px;
            position: relative;
        }

        .gitems img {
            max-width: 150px;
            max-height: 150px;
            border-radius: 5px;
        }

        /* تفاصيل المواصفات */
        .specification-details {
            margin-top: 15px;
        }

        .toggle-specification {
            margin-bottom: 10px;
        }

        .modern-btn {
            background-color: #000000;
            /* اللون الأسود */
            color: white;
            /* النص باللون الأبيض */
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            display: inline-block;
            margin-top: 15px;
            text-align: center;
            transition: transform 0.3s ease, background-color 0.3s ease;
            width: 200px;
            box-sizing: border-box;
        }

        /* عند تحريك الفأرة فوق الزر */
        .modern-btn:hover {
            background-color: #333333;
            /* لون أغمق عند التحويم */
            transform: scale(1.05);
        }

        /* تحديث الحقول */
        .modern-input,
        .modern-textarea {
            border-radius: 8px;
            border: 1px solid #120202;
            padding: 12px 16px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        /* إزالة تأثير hover على زر Show */
        /* إزالة تأثير hover على زر Show */
        .toggle-specification {
            background-color: #20bec6;
            /* اللون الأساسي */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            display: inline-block;
            margin-top: 10px;
            width: 100%;
            /* ضمان أن يكون الأزرار بعرض 100% */
            text-align: center;
            transition: none;
            /* إيقاف تأثيرات التغيير عند التحويم */
        }

        /* عند تحريك الفأرة فوق الزر، لا تغير اللون أو الحجم */
        .toggle-specification:hover {
            background-color: #20bec6;
            /* نفس اللون كما هو في الحالة العادية */
            transform: none;
            /* إيقاف التأثير عند تحريك الفأرة */
        }
    </style>
@endpush
    <div class="container pt-5">
        <h2>Edit Order  </h2>
        <form action="{{ route('user.order.update', ['order_id' => $order->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Order Details -->
            <h4>Order Details</h4>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $order->name }}">
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $order->phone }}">
            </div>

            <div class="mb-3">
                <label for="subtotal" class="form-label">Subtotal</label>
                <input type="number" class="form-control" id="subtotal" name="subtotal" value="{{ $order->subtotal }}">
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="ordered" {{ $order->status == 'ordered' ? 'selected' : '' }}>Ordered</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <textarea class="form-control" id="note" name="note">{{ $order->note }}</textarea>
            </div>

            <!-- Order Images -->
            <h4>Attachment-3: Technical Drawing or Image</h4>
            <div class="mb-3">
                <label for="order_images" class="form-label">Upload New Images</label>
                <input type="file" class="form-control" id="order_images" name="order_images[]" multiple>
            </div>

            @if (!empty($order->images))
                <div class="mb-3">
                    <p>Existing Images:</p>
                    <ul>
                        @foreach (json_decode($order->images) as $image)
                            <li>
                                <img src="{{ asset('storage/' . $image) }}" alt="Image" width="100">
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="deleteImage('{{ $image }}')">Delete</button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
 

            <!-- Order Extras -->
            <h4>Order Message</h4> 
            <div class="mb-3">
                <label for="extra" class="form-label">Message</label>
                <textarea class="ckeditor form-control" id="extra" name="extra">{!! $order->extra !!}</textarea>
            </div>




            <!-- Order Items and Specifications -->
            <h4>Order Items</h4>
            @foreach ($orderItems as $item)
                <div class="border p-3 mb-3">
                    <h5>Item: {{ $item->product_name }}</h5>
                    <input type="hidden" name="items[{{ $item->id }}][id]" value="{{ $item->id }}">

                    <div class="mb-3">
                        <label for="quantity_{{ $item->id }}" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity_{{ $item->id }}"
                            name="items[{{ $item->id }}][quantity]" value="{{ $item->quantity }}">
                    </div>

                    <h6>Specifications:</h6>
                    @foreach ($item->specifications as $index => $spec)
                    <div class="border p-2 mb-2">
                        <!-- زر عرض/إخفاء المواصفة -->
                        <button type="button" class="btn btn-info toggle-specification"
                            data-target="#specification-{{ $item->id }}-{{ $index }}">
                            Show {{ $spec->name }}
                        </button>
                
                        <!-- تفاصيل المواصفة -->
                        <div class="specification-details" id="specification-{{ $item->id }}-{{ $index }}" style="display: none;">
                            <input type="hidden"
                                name="items[{{ $item->id }}][specifications][{{ $index }}][id]"
                                value="{{ $spec->id }}">
                
                            <label for="spec_name_{{ $item->id }}_{{ $index }}" class="form-label">Name</label>
                            <input type="text" class="form-control mb-2"
                                id="spec_name_{{ $item->id }}_{{ $index }}"
                                name="items[{{ $item->id }}][specifications][{{ $index }}][name]"
                                value="{{ $spec->name }}">
                
                            <label for="spec_title_{{ $item->id }}_{{ $index }}" class="form-label">Title</label>
                            <input type="text" class="form-control mb-2"
                                id="spec_title_{{ $item->id }}_{{ $index }}"
                                name="items[{{ $item->id }}][specifications][{{ $index }}][title]"
                                value="{{ $spec->title }}">
                
                            <label for="spec_paragraphs_{{ $item->id }}_{{ $index }}" class="form-label">Paragraphs</label>
                            <textarea class="ckeditor form-control mb-2" id="spec_paragraphs_{{ $item->id }}_{{ $index }}"
                                name="items[{{ $item->id }}][specifications][{{ $index }}][paragraphs]">{!! $spec->paragraphs !!}</textarea>
                
                            <label for="spec_images_{{ $item->id }}_{{ $index }}" class="form-label">Upload New Images</label>
                            <input type="file" class="form-control mb-2"
                                id="spec_images_{{ $item->id }}_{{ $index }}"
                                name="items[{{ $item->id }}][specifications][{{ $index }}][images][]"
                                multiple>
                
                            <!-- Display Existing Images -->
                            @if (!empty($spec->images))
                                <p>Existing Images:</p>
                                <div class="mb-3">
                                    <ul class="list-unstyled">
                                        @foreach (json_decode($spec->images) as $image)
                                            <li class="mb-2 d-flex align-items-center">
                                                <img src="{{ asset('storage/' . $image) }}" alt="Specification Image"
                                                    width="100" class="me-3">
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="deleteSpecImage('{{ $image }}', '{{ $spec->id }}')">Delete</button>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
                

                </div>
                <input type="hidden" name="items[{{ $item->id }}][id]" value="{{ $item->id }}">
            @endforeach



            <button type="submit" class="btn btn-success">Update Order</button>
        </form>
    </div>


@endsection
@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.ckeditor').forEach(editorElement => {
                ClassicEditor
                    .create(editorElement)
                    .catch(error => console.error(error));
            });
        });
    </script>

    <script>
        function deleteImage(image) {
            if (!confirm("Are you sure you want to delete this image?")) {
                return;
            }

            fetch('{{ route('order.image.delete', ['order_id' => $order->id]) }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        image: image
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Failed to delete image.');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Event listener for toggle buttons
        document.querySelectorAll('.toggle-specification').forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const targetElement = document.querySelector(targetId);

                // Toggle the display of the target specification
                if (targetElement.style.display === 'none' || targetElement.style.display === '') {
                    targetElement.style.display = 'block';
                    this.textContent = 'Hide ' + this.textContent.slice(5); // Update button text
                } else {
                    targetElement.style.display = 'none';
                    this.textContent = 'Show ' + this.textContent.slice(5); // Update button text
                }
            });
        });
    });
</script>

    <script>
        function deleteSpecImage(image, specId) {
            if (!confirm("Are you sure you want to delete this specification image?")) {
                return;
            }

            fetch('{{ route('specification.image.delete') }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        image: image,
                        spec_id: specId
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Failed to delete specification image.');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endpush