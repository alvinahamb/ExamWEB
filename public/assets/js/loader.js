// loader.js
document.addEventListener("DOMContentLoaded", function() {
    const loader = document.querySelector('.wheel-and-hamster');
    loader.style.display = 'block'; // Show loader

    // Hide loader after the window has fully loaded
    window.addEventListener('load', () => {
        loader.style.display = 'none'; // Hide loader
    });
});
