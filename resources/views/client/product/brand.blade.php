@extends('client.layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h1 class="h4 fw-bold">Thương hiệu: {{ $brand->brandname }}</h1>
        <div class="row g-3 mt-2">
            @foreach ($products as $product)
                <div class="col-md-3">
                    <div class="card h-100">
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->productname }}" style="height: 180px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->productname }}</h5>
                            <div class="fw-bold">{{ number_format($product->pricediscount ?: $product->price, 0, ',', '.') }}₫</div>
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-primary mt-2">Xem</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $products->links() }}</div>
    </div>
</div>
@endsection
