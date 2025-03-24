document.addEventListener("DOMContentLoaded", function () {
    let myCarousel = new bootstrap.Carousel(document.getElementById('imageSlider'), {
        interval: 3000, // Change slide every 3 seconds
        ride: 'carousel'
    });
});