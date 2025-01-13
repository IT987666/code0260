<div class="product-image-container">
    @if (!empty($order->images))
        @foreach (json_decode($order->images) as $image)
            <img src="{{ public_path('storage/' . $image) }}" alt="Order Image" class="product-image">
        @endforeach
    @endif
</div>
