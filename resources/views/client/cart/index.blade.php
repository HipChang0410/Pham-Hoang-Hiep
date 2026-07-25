@extends('client.layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h1 class="h4 fw-bold">Giỏ hàng</h1>
        @if (empty($cart))
            <p class="text-muted">Giỏ hàng trống.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($cart as $item)
                        @php $subtotal = $item['quantity'] * $item['price']; $total += $subtotal; @endphp
                        <tr>
                            <td>{{ $item['product_name'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ number_format($item['price'], 0, ',', '.') }}₫</td>
                            <td>{{ number_format($subtotal, 0, ',', '.') }}₫</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                <h4 class="fw-bold">Tổng tiền: {{ number_format($total, 0, ',', '.') }}₫</h4>
                <form method="POST" action="{{ route('checkout') }}" class="mt-3">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6"><input name="fullname" class="form-control" placeholder="Họ tên" required></div>
                        <div class="col-md-6"><input name="phone" class="form-control" placeholder="Số điện thoại" required></div>
                        <div class="col-12"><input name="address" class="form-control" placeholder="Địa chỉ" required></div>
                        <div class="col-12"><input name="email" class="form-control" placeholder="Email" type="email"></div>
                    </div>
                    <button class="btn btn-success mt-3">Đặt hàng</button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
