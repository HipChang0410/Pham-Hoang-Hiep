@extends('admin.layouts.admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Chi tiết đơn hàng #{{ $order->id }}</h5>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">Quay lại</a>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="fw-bold">Thông tin khách hàng</h6>
                <p class="mb-1"><strong>Họ tên:</strong> {{ $order->customer->fullname }}</p>
                <p class="mb-1"><strong>Số điện thoại:</strong> {{ $order->customer->phone }}</p>
                <p class="mb-1"><strong>Địa chỉ:</strong> {{ $order->customer->address }}</p>
                <p class="mb-0"><strong>Email:</strong> {{ $order->customer->email ?? '—' }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="fw-bold">Thông tin đơn hàng</h6>
                <p class="mb-1"><strong>Trạng thái:</strong> {{ $order->status }}</p>
                <p class="mb-1"><strong>Tổng tiền:</strong> {{ number_format($order->total_amount, 0, ',', '.') }}₫</p>
                <p class="mb-0"><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>SL</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product->productname ?? 'Sản phẩm đã bị xóa' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price, 0, ',', '.') }}₫</td>
                        <td>{{ number_format($item->quantity * $item->price, 0, ',', '.') }}₫</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
