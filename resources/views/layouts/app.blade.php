<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Saturn Mart POS - @yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        body {
            background: #f8f9fa;
            transition: background 0.3s ease, color 0.3s ease;
        }

        /* Dark Mode Styles */
        body.dark-mode {
            background: #1a1a1a;
            color: #e0e0e0;
        }

        body.dark-mode .navbar-custom {
            background: #2d2d2d;
            border-bottom-color: #404040;
        }

        body.dark-mode .navbar-brand {
            color: #e0e0e0 !important;
        }

        body.dark-mode .card,
        body.dark-mode .card-custom {
            background: #2d2d2d;
            border-color: #404040;
            color: #e0e0e0;
        }

        body.dark-mode .table {
            color: #e0e0e0;
        }

        body.dark-mode .table-striped tbody tr:nth-of-type(odd) {
            background: #333333;
        }

        body.dark-mode .form-control,
        body.dark-mode .form-select {
            background: #333333;
            border-color: #404040;
            color: #e0e0e0;
        }

        body.dark-mode .form-control:focus,
        body.dark-mode .form-select:focus {
            background: #3a3a3a;
            border-color: #007bff;
            color: #e0e0e0;
        }

        body.dark-mode .user-badge {
            background: #1e3a5f;
            color: #66b3ff;
        }

        body.dark-mode .modal-content {
            background: #2d2d2d;
            color: #e0e0e0;
        }

        body.dark-mode .modal-header {
            border-bottom-color: #404040;
        }

        body.dark-mode .modal-footer {
            border-top-color: #404040;
        }

        /* Dark mode text colors */
        body.dark-mode h1,
        body.dark-mode h2,
        body.dark-mode h3,
        body.dark-mode h4,
        body.dark-mode h5,
        body.dark-mode h6,
        body.dark-mode p,
        body.dark-mode span,
        body.dark-mode label,
        body.dark-mode td,
        body.dark-mode th,
        body.dark-mode .text-dark,
        body.dark-mode .text-muted {
            color: #e0e0e0 !important;
        }

        body.dark-mode .card-header {
            background: #333333;
            border-bottom-color: #404040;
            color: #e0e0e0;
        }

        body.dark-mode .card-body {
            color: #e0e0e0;
        }

        body.dark-mode .btn-outline-primary,
        body.dark-mode .btn-outline-secondary {
            color: #e0e0e0;
            border-color: #404040;
        }

        body.dark-mode .btn-outline-primary:hover,
        body.dark-mode .btn-outline-secondary:hover {
            background: #404040;
            color: #e0e0e0;
        }

        body.dark-mode .badge {
            background: #404040;
            color: #e0e0e0;
        }

        body.dark-mode .alert {
            background: #333333;
            border-color: #404040;
            color: #e0e0e0;
        }

        body.dark-mode .list-group-item {
            background: #2d2d2d;
            border-color: #404040;
            color: #e0e0e0;
        }

        /* Additional dark mode elements */
        body.dark-mode input[type="text"],
        body.dark-mode input[type="email"],
        body.dark-mode input[type="password"],
        body.dark-mode input[type="number"],
        body.dark-mode input[type="date"],
        body.dark-mode input[type="search"],
        body.dark-mode textarea {
            background: #333333 !important;
            border-color: #404040 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode input::placeholder,
        body.dark-mode textarea::placeholder {
            color: #888888 !important;
        }

        body.dark-mode .bg-light {
            background: #2d2d2d !important;
        }

        body.dark-mode .bg-white {
            background: #2d2d2d !important;
        }

        body.dark-mode .border {
            border-color: #404040 !important;
        }

        body.dark-mode .shadow,
        body.dark-mode .shadow-sm,
        body.dark-mode .shadow-lg {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5) !important;
        }

        body.dark-mode hr {
            border-color: #404040 !important;
            opacity: 0.3;
        }

        body.dark-mode .dropdown-menu {
            background: #2d2d2d;
            border-color: #404040;
        }

        body.dark-mode .dropdown-item {
            color: #e0e0e0;
        }

        body.dark-mode .dropdown-item:hover {
            background: #404040;
            color: #e0e0e0;
        }

        body.dark-mode .breadcrumb {
            background: #2d2d2d;
        }

        body.dark-mode .breadcrumb-item,
        body.dark-mode .breadcrumb-item a {
            color: #e0e0e0;
        }

        body.dark-mode .pagination .page-link {
            background: #2d2d2d;
            border-color: #404040;
            color: #e0e0e0;
        }

        body.dark-mode .pagination .page-link:hover {
            background: #404040;
            color: #e0e0e0;
        }

        body.dark-mode .pagination .page-item.active .page-link {
            background: #007bff;
            border-color: #007bff;
        }

        body.dark-mode .pagination .page-item.disabled .page-link {
            background: #2d2d2d;
            color: #666666;
        }

        /* Style untuk card di dashboard */
        body.dark-mode .card-title {
            color: #e0e0e0 !important;
        }

        body.dark-mode .card-text {
            color: #b0b0b0 !important;
        }

        body.dark-mode small,
        body.dark-mode .small {
            color: #b0b0b0 !important;
        }

        /* Buttons */
        body.dark-mode .btn-light {
            background: #404040;
            border-color: #404040;
            color: #e0e0e0;
        }

        body.dark-mode .btn-light:hover {
            background: #4a4a4a;
            color: #e0e0e0;
        }

        body.dark-mode .btn-secondary {
            background: #404040;
            border-color: #404040;
        }

        body.dark-mode .btn-secondary:hover {
            background: #4a4a4a;
        }

        /* Input group */
        body.dark-mode .input-group-text {
            background: #404040;
            border-color: #404040;
            color: #e0e0e0;
        }

        /* Nav tabs */
        body.dark-mode .nav-tabs {
            border-color: #404040;
        }

        body.dark-mode .nav-tabs .nav-link {
            color: #e0e0e0;
        }

        body.dark-mode .nav-tabs .nav-link:hover {
            border-color: #404040;
        }

        body.dark-mode .nav-tabs .nav-link.active {
            background: #2d2d2d;
            border-color: #404040;
            color: #e0e0e0;
        }

        /* Product cards di POS */
        body.dark-mode .product-card {
            background: #2d2d2d !important;
            border-color: #404040 !important;
        }

        body.dark-mode .product-card:hover {
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.1) !important;
        }

        /* Stats cards */
        body.dark-mode .stats-card {
            background: #2d2d2d !important;
            border-color: #404040 !important;
        }

        .navbar-custom {
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            border-bottom: 1px solid #e9ecef;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
            color: #2d3748 !important;
        }

        .btn-gradient {
            background: #007bff;
            border: none;
            color: white;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-gradient:hover {
            background: #0056b3;
            color: white;
        }

        .card-custom {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .user-badge {
            background: #e7f1ff;
            color: #007bff;
            padding: 8px 20px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 8px 20px;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-block;
        }

        .logout-btn:hover {
            background: #c82333;
            color: white;
        }

        /* Dark Mode Toggle Button */
        .dark-mode-toggle {
            position: fixed;
            top: 10px;
            right: 20px;
            z-index: 1050;
            background: #007bff;
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .dark-mode-toggle:hover {
            background: #0056b3;
            transform: scale(1.1);
        }

        body.dark-mode .dark-mode-toggle {
            background: #ffc107;
            color: #1a1a1a;
        }

        body.dark-mode .dark-mode-toggle:hover {
            background: #ffca2c;
        }
    </style>    @stack('styles')
</head>
<body>
    <!-- Dark Mode Toggle Button -->
    <button class="dark-mode-toggle" id="darkModeToggle" title="Toggle Dark Mode">
        <i class="fas fa-moon" id="darkModeIcon"></i>
    </button>

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ auth()->check() ? route('dashboard') : '/' }}">
                <i class="fas fa-store-alt me-2"></i>Saturn Mart POS
            </a>

            <div class="d-flex align-items-center gap-3">
                @auth
                    <span class="user-badge">
                        <i class="fas fa-user-circle me-2"></i>{{ auth()->user()->name }}
                        <span class="opacity-75 ms-1">({{ ucfirst(auth()->user()->role) }})</span>
                    </span>
                    <a class="logout-btn" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else
                    <a class="btn btn-gradient px-4" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </a>
                    <a class="btn btn-outline-primary px-4" href="{{ route('register') }}">
                        <i class="fas fa-user-plus me-2"></i>Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mt-4 mb-5">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Dark Mode Toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        const darkModeIcon = document.getElementById('darkModeIcon');
        const body = document.body;

        // Check for saved dark mode preference
        const isDarkMode = localStorage.getItem('darkMode') === 'enabled';

        if (isDarkMode) {
            body.classList.add('dark-mode');
            darkModeIcon.classList.remove('fa-moon');
            darkModeIcon.classList.add('fa-sun');
        }

        // Toggle dark mode
        darkModeToggle.addEventListener('click', () => {
            body.classList.toggle('dark-mode');

            if (body.classList.contains('dark-mode')) {
                darkModeIcon.classList.remove('fa-moon');
                darkModeIcon.classList.add('fa-sun');
                localStorage.setItem('darkMode', 'enabled');
            } else {
                darkModeIcon.classList.remove('fa-sun');
                darkModeIcon.classList.add('fa-moon');
                localStorage.setItem('darkMode', 'disabled');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
