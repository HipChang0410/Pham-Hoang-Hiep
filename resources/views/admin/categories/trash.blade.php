@extends('admin.layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0">Danh sách loại sản phẩm đã xóa</h2>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Quay lại danh sách</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Tên loại</th>
                    <th>Slug</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                @forelse($list as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->catename }}</td>
                        <td>{{ $item->slug }}</td>
                        <td>
                            @if($item->status == 1)
                                <span class="badge bg-success">Hiển thị</span>
                            @else
                                <span class="badge bg-danger">Ẩn</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.categories.restore', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-success btn-sm">Khôi phục</button>
                            </form>
                            <form action="{{ route('admin.categories.forceDelete', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Xóa vĩnh viễn?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Không có dữ liệu trong thùng rác</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{ $list->links() }}
        </div>
    </div>
@endsection
