@extends('admin.layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4">Danh sách thương hiệu</h1>
        <a href="{{ route('admin.brands.create') }}" class="btn btn-success">+ Thêm mới</a>
    </div>

    <x-admin.alert :errors="$errors" :message="session('success')" type="success" />

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên thương hiệu</th>
                    <th>Slug</th>
                    <th>Ảnh</th>
                    <th>Trạng thái</th>
                    <th>Chức năng</th>
                </tr>
                </thead>
                <tbody>
                @foreach($brands as $index => $brand)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $brand->brandname }}</td>
                        <td>{{ $brand->slug }}</td>
                        <td>
                            @if($brand->image && $brand->image !== 'default.png')
                                <img src="{{ asset('storage/brands/' . $brand->image) }}" alt="" width="60" class="img-thumbnail">
                            @else
                                <span class="text-muted">Không có ảnh</span>
                            @endif
                        </td>
                        <td>{{ $brand->status == 1 ? 'Hiển thị' : 'Ẩn' }}</td>
                        <td>
                            @if($brand->image && $brand->image !== 'default.png')
                                <img src="{{ asset('storage/brands/' . $brand->image) }}" alt="" width="60" class="img-thumbnail">
                            @else
                                <span class="text-muted">Không có ảnh</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-primary btn-sm">Sửa</a>
                            <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $brands->links() }}
            </div>
        </div>
    </div>
@endsection
