<nav class="navbar navbar-light bg-light admin-header">
    <div class="container-fluid">
        <span class="navbar-brand">Admin Panel</span>
        <ul class="nav align-items-center">
            <li class="nav-item">
                <span class="nav-link text-muted mb-0">Xin chào, {{ Auth::user()?->fullname ?? Auth::user()?->name ?? 'Admin' }}</span>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.change-password') }}">Đổi mật khẩu</a>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link">Đăng xuất</button>
                </form>
            </li>
        </ul>
    </div>
</nav>
