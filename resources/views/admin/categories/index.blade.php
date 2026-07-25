@extends('admin.layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4">Danh sách loại sản phẩm</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-success">+ Thêm mới</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên loại</th>
                    <th>Slug</th>
                    <th>Ảnh</th>
                    <th>Trạng thái</th>
                    <th>Chức năng</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->catename }}</td>
                        <td>{{ $item->slug }}</td>
                        <td>
                            <img src="{{ asset('images/' . ($item->image ?? 'default.png')) }}" alt="" width="60">
                        </td>
                        <td>{{ $item->status == 1 ? 'Hiển thị' : 'Ẩn' }}</td>
                        <td>
                            <form action="{{ route('admin.categories.destroy', $item->id) }}" method="POST" class="d-inline">
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
                {{ $list->links() }}
            </div>
        </div>
    </div>
@endsection
