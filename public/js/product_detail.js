document.addEventListener('DOMContentLoaded', function() {
    const carouselEl = document.querySelector('#productCarousel');
    if (!carouselEl) return;

    // Inisialisasi Bootstrap Carousel
    const carousel = new bootstrap.Carousel(carouselEl, {
        interval: 4000, // autoplay 4 detik
        ride: 'carousel'
    });

    // Thumbnail klik
    document.querySelectorAll('.thumbnail').forEach((thumb, index) => {
        thumb.addEventListener('click', () => {
            carousel.to(index);
        });
    });

    // Update thumbnail aktif saat slide berubah
    carouselEl.addEventListener('slide.bs.carousel', (event) => {
        document.querySelectorAll('.thumbnail').forEach((thumb, i) => {
            thumb.classList.toggle('active', i === event.to);
        });
    });
});
