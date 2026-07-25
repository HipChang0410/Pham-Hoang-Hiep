<footer class="bg-dark text-white py-5 mt-5">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-4">
                <h5 class="text-white">Mini Shop</h5>
                <p class="small text-muted">Mini Shop chuyên cung cấp các sản phẩm công nghệ, phụ kiện máy tính và thiết bị điện tử với chất lượng và giá cả hợp lý.</p>
            </div>
            <div class="col-md-4">
                <h5 class="text-white">Liên kết nhanh</h5>
                <ul class="list-unstyled mb-0">
                    <li><a href="{{ route('home') }}" class="text-decoration-none small text-muted">Trang chủ</a></li>
                    <li><a href="{{ route('products.search') }}?q=" class="text-decoration-none small text-muted">Sản phẩm</a></li>
                    <li><a href="{{ route('cart.index') }}" class="text-decoration-none small text-muted">Giỏ hàng</a></li>
                    <li><a href="mailto:support@minishop.com" class="text-decoration-none small text-muted">Liên hệ</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5 class="text-white">Liên hệ</h5>
                <p class="small text-muted mb-1"><i class="bi bi-geo-alt-fill me-2"></i>123 Nguyễn Văn XXXX, TP. Hồ Chí Minh</p>
                <p class="small text-muted mb-1"><i class="bi bi-telephone-fill me-2"></i>0909 999 999</p>
                <p class="small text-muted mb-0"><i class="bi bi-envelope-fill me-2"></i>support@minishop.com</p>
            </div>
        </div>
        <div class="border-top border-secondary mt-4 pt-3 text-center text-muted small">
            © 2026 Mini Shop. All Rights Reserved.
        </div>
    </div>
</footer>
