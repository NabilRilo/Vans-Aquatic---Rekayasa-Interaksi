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
        background-color: #0f2157; /* warna biru gelap sesuai gambar */
    }

    .footer-custom a:hover {
        color: #ffdd57 !important;
    }
</style>
