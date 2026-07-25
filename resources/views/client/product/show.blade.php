@extends('client.layouts.app')

@section('content')
<div class="row g-4">
    <div class="col-md-6">
        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded shadow-sm" alt="{{ $product->productname }}">
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h1 class="h3 fw-bold">{{ $product->productname }}</h1>
                <p class="text-muted">Danh mục: {{ $product->category->catename ?? '' }} | Thương hiệu: {{ $product->brand->brandname ?? '' }}</p>
                <div class="mb-3">
                    @if ($product->pricediscount)
                        <div class="text-danger fw-bold fs-4">{{ number_format($product->pricediscount, 0, ',', '.') }}₫</div>
                        <div class="text-muted text-decoration-line-through">{{ number_format($product->price, 0, ',', '.') }}₫</div>
                    @else
                        <div class="fw-bold fs-4">{{ number_format($product->price, 0, ',', '.') }}₫</div>
                    @endif
                </div>
                <p>{{ $product->description }}</p>
                <form method="POST" action="{{ route('cart.add') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="input-group w-50">
                        <span class="input-group-text">Số lượng</span>
                        <input type="number" name="quantity" class="form-control" value="1" min="1">
                    </div>
                    <button class="btn btn-primary mt-3">Thêm vào giỏ hàng</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
