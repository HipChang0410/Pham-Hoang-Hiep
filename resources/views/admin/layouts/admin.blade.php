<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
</body>
</html>
