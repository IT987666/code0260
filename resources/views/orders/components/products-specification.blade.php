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


                    @if (!empty($spec['base64Images']))
                        <div class="product-image-container">
                            @foreach ($spec['base64Images'] as $base64Image)
                                <img src="data:image/png;base64,{{ $base64Image }}" class="product-image"
                                    alt="spec image">
                            @endforeach
                        </div>
                    @endif

                </div>
            @endforeach
        @endif
    </div>
@endforeach
