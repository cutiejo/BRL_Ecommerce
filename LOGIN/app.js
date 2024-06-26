document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById('container');
    const userLink = document.getElementById('user-link');
    const adminLink = document.getElementById('admin-link');
    const bullets = document.querySelectorAll('.bullets span');
    const images = document.querySelectorAll('.image');

    userLink.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    adminLink.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });

    bullets.forEach((bullet, idx) => {
        bullet.addEventListener('click', () => {
            bullets.forEach(b => b.classList.remove('active'));
            bullet.classList.add('active');
            images.forEach(img => img.classList.remove('show'));
            images[idx].classList.add('show');
        });
    });

    let currentIndex = 0;
    setInterval(() => {
        currentIndex = (currentIndex + 1) % images.length;
        images.forEach((img, idx) => img.classList.toggle('show', idx === currentIndex));
        bullets.forEach((bull, idx) => bull.classList.toggle('active', idx === currentIndex));
    }, 3000); // Change image every 3 seconds
});
