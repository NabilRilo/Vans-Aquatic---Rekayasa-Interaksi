<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Van\'s Aquatic - Toko Ikan Hias Online')</title>

    {{-- Google Fonts: Poppins dan Segoe UI --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&family=Segoe+UI:wght@300;400;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap 5.3.3 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    {{-- Link CSS Kustom --}}
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    {{-- Material Design Icons --}}
    <link href="https://cdn.materialdesignicons.com/6.5.95/css/materialdesignicons.min.css" rel="stylesheet" />

    {{-- Animate.css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    {{-- Styles tambahan --}}
    @stack('styles')

</head>
<body>

    {{-- NAVBAR --}}
    @include('layouts.navbar')

    {{-- MAIN CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- ========================= --}}
    {{--         FOOTER           --}}
    {{-- ========================= --}}
    <footer class="footer-custom text-center py-4 mt-5">
        <h5 class="text-white fw-semibold mb-1">
            Bersama laut, kami tumbuh | Van's Aquatic
        </h5>

        <p class="text-white-50 mb-3">
            © 2025 Van's Aquatic. All rights reserved.
        </p>

        @auth
            <p class="text-white mb-2">
                Halo, {{ Auth::user()->name }}!
            </p>

            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="text-warning fw-semibold text-decoration-none">
                <i class="mdi mdi-logout me-1"></i> Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        @endauth
    </footer>

    <style>
        .footer-custom {
            background-color: #0f2157; /* Warna navy seperti di gambar */
        }
        .footer-custom a:hover {
            color: #ffdd57 !important;
        }
    </style>

    {{-- jQuery --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    {{-- Scripts tambahan --}}
    @stack('scripts')

</body>
</html>
