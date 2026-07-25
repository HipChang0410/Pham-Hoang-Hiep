@extends('admin.layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4">Danh sách sản phẩm</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-success">+ Thêm mới</a>
    </div>

    <x-admin.alert :errors="$errors" :message="session('success')" type="success" />

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Loại</th>
                    <th>Thương hiệu</th>
                    <th>Giá</th>
                    <th>Ảnh</th>
                    <th>Trạng thái</th>
                    <th>Chức năng</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->productname }}</td>
                        <td>{{ $product->category?->catename ?? '---' }}</td>
                        <td>{{ $product->brand?->brandname ?? '---' }}</td>
                        <td>{{ number_format($product->price, 0, ',', '.') }} đ</td>
                        <td>{{ $product->status == 1 ? 'Hiển thị' : 'Ẩn' }}</td>
                        <td>
                            @if($product->image && $product->image !== 'default.png')
                                <img src="{{ asset('storage/products/' . $product->image) }}" alt="" width="60" class="img-thumbnail">
                            @else
                                <span class="text-muted">Không có ảnh</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary btn-sm">Sửa</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
