@extends('client.layouts.app')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="p-4 rounded bg-white shadow-sm">
            <h2 class="h4 fw-bold">Sản phẩm mới nhất</h2>
            <div class="row g-3 mt-2">
                @foreach ($latestProducts as $product)
                    <div class="col-md-3">
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->productname }}" style="height: 180px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->productname }}</h5>
                                <p class="text-muted small">{{ $product->brand->brandname ?? '' }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        @if ($product->pricediscount)
                                            <div class="text-danger fw-bold">{{ number_format($product->pricediscount, 0, ',', '.') }}₫</div>
                                            <div class="text-muted text-decoration-line-through small">{{ number_format($product->price, 0, ',', '.') }}₫</div>
                                        @else
                                            <div class="fw-bold">{{ number_format($product->price, 0, ',', '.') }}₫</div>
                                        @endif
                                    </div>
                                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-primary">Xem</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="p-4 rounded bg-white shadow-sm">
            <h2 class="h4 fw-bold">Sản phẩm giảm giá</h2>
            <div class="row g-3 mt-2">
                @foreach ($saleProducts as $product)
                    <div class="col-md-3">
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->productname }}" style="height: 180px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->productname }}</h5>
                                <p class="text-muted small">{{ $product->brand->brandname ?? '' }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-danger fw-bold">{{ number_format($product->pricediscount, 0, ',', '.') }}₫</div>
                                        <div class="text-muted text-decoration-line-through small">{{ number_format($product->price, 0, ',', '.') }}₫</div>
                                    </div>
                                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-primary">Xem</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
