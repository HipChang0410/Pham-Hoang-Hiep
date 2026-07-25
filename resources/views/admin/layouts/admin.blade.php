<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid p-0">
    <div class="row min-vh-100 g-0">
        <div class="col-md-2 bg-dark text-white">
            @include('admin._partials.sidebar')
        </div>
        <div class="col-md-10 d-flex flex-column">
            <div class="border-bottom bg-white">
                @include('admin._partials.header')
            </div>
            <main class="flex-grow-1 bg-light p-3">
                @yield('content')
            </main>
            <footer class="bg-dark text-white text-center py-2">
                @include('admin._partials.footer')
            </footer>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
