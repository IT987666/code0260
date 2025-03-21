@foreach ($groupedOrderItems as $specifications => $productGroup)
    @php
        $firstItem = $productGroup->first();
    @endphp

    <div>
        <div class="product-name">
            PREFABEX
            <span>{{ $firstItem->product->name }}</span>
            TECHNICAL SPECIFICATIONS
        </div>

        @if (!empty($firstItem->specifications))
            @foreach ($firstItem->specifications as $spec)
                <div>
                    <h3>{{ $spec['name'] ?? 'Specification' }}</h3>

                    <!-- Paragraphs -->
                    @if (!empty($spec['paragraphs']))
                        <div>{!! $spec['paragraphs'] !!}</div>
                    @endif

                    <!-- Images -->
                    @if (!empty($spec['images']))
                        {{-- @php
                            $images = is_array($spec['images']) ? $spec['images'] : json_decode($spec['images'], true);
                        @endphp --}}

                        {{-- @if (is_array($images) && count($images) > 0) --}}
                        <div class="product-image-container">
                            @foreach ($spec['images'] as $image)
                                @php
                                    $base64Image = $base64EncodeImageA($image);
                                @endphp

                                {{-- @if ($base64Image)
                                        <img src="{{ $base64Image }}" class="product-image" alt="spec image">
                                    @endif --}}
                                <img src="{{ asset('storage/' . $image) }}" alt="spec image" class="product-image">
                            @endforeach
                        </div>
                        {{-- @endif --}}
                    @endif

                </div>
            @endforeach
        @endif
    </div>
@endforeach
