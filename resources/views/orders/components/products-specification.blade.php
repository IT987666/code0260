@foreach ($orderItems as $item)
    <div>
        <div class="product-name">
            PREFABEX
            <span>{{ $item->product->name }}</span>
            TECHNICAL SPECIFICATIONS
        </div>

        @if (!empty($item->specifications))
            @foreach ($item->specifications as $spec)
                <div>
                    <h3>{{ $spec['name'] ?? 'Specification' }}</h3>
                    <p>{{ $spec['title'] }}</p>

                    <!-- Paragraphs -->
                    @if (!empty($spec['paragraphs']))
                        <div>{!! $spec['paragraphs'] !!}</div>
                    @endif

                    <!-- Images -->
                    @if (!empty($spec['images']))
                        @php
                            $images = is_array($spec['images']) ? $spec['images'] : json_decode($spec['images'], true);
                        @endphp

                        @if (is_array($images) && count($images) > 0)
                            <div class="product-image-container">
                                @foreach ($images as $image)
                                    @php
                                        $base64Image = $base64EncodeImageA($image);
                                    @endphp

                                    @if ($base64Image)
                                        <img src="{{ $base64Image }}" class="product-image" alt="spec image">
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    @endif

                </div>
            @endforeach
        @endif
    </div>
@endforeach
