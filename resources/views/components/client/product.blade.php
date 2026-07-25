<div class="card h-100 shadow-sm">
    <img src="{{ asset('storage/' . ($product->image ?? 'default.png')) }}" class="card-img-top" alt="{{ $product->productname }}" style="height:150px;object-fit:cover;">
    <div class="card-body d-flex flex-column">
        <h6 class="card-title">{{ $product->productname }}</h6>
        @if (!empty($product->pricediscount) && $product->pricediscount > 0)
            <div>
                <span class="text-decoration-line-through text-muted">{{ number_format($product->price, 0, ',', '.') }}₫</span>
            </div>
            <h5 class="text-danger fw-bold">{{ number_format($product->pricediscount, 0, ',', '.') }}₫</h5>
        @else
            <h5 class="text-danger fw-bold">{{ number_format($product->price ?? 0, 0, ',', '.') }}₫</h5>
        @endif

        <div class="mt-auto">
            <div class="row g-2">
                <div class="col-6">
                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary w-100"><i class="bi bi-eye"></i></a>
                </div>
                <div class="col-6">
                    <form method="POST" action="{{ route('cart.add') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button class="btn btn-success w-100" type="submit"><i class="bi bi-cart-plus"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
