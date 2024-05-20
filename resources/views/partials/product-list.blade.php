@foreach ($products as $product)
    <div class="col-md-4">
        <div class="card">
            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->title }}">
            <div class="card-body">
                <h5 class="card-title">{{ $product->title }}</h5>
                <p class="card-text">{{ $product->price }}</p>
                <button class="btn btn-primary add-to-cart" data-id="{{ $product->id }}">Add to Cart</button>
            </div>
        </div>
        <br>
    </div>
@endforeach
