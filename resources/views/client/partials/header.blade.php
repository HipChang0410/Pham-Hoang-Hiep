<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">Shop Laravel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Trang chủ</a></li>
                @foreach ($categories ?? [] as $category)
                    <li class="nav-item"><a class="nav-link" href="{{ route('products.category', $category->slug) }}">{{ $category->catename }}</a></li>
                @endforeach
            </ul>
            <form class="d-flex" method="GET" action="{{ route('products.search') }}">
                <input class="form-control me-2" type="search" name="q" placeholder="Tìm sản phẩm" value="{{ request('q', '') }}">
                <button class="btn btn-outline-light" type="submit">Tìm</button>
            </form>
            <a class="btn btn-outline-light ms-2" href="{{ route('cart.index') }}">Giỏ hàng</a>
        </div>
    </div>
</nav>
