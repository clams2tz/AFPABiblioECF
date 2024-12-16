/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');


document.addEventListener('DOMContentLoaded', () => {
    const pages = document.querySelectorAll('.page');
    const bullets = document.querySelectorAll('.progress-bar .step');
    const nextButtons = document.querySelectorAll('.next');
    const prevButtons = document.querySelectorAll('.prev');

    let currentPage = 0;

    function updateProgressBar() {
        bullets.forEach((step, index) => {
            if (index === currentPage) {
                step.classList.add('active');
                step.classList.remove('completed');
            } else if (index < currentPage) {
                step.classList.add('completed');
                step.classList.remove('active');
            } else {
                step.classList.remove('active', 'completed');
            }
        });
    }

    function showPage(index) {
        pages.forEach((page, i) => {
            page.classList.toggle('active', i === index);
        });
        updateProgressBar();
    }
    showPage(currentPage);

    nextButtons.forEach((button) => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage < pages.length - 1) {
                currentPage++;
                showPage(currentPage);
            }
        });
    });

    prevButtons.forEach((button) => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage > 0) {
                currentPage--;
                showPage(currentPage);
            }
        });
    });

    // Initialize the first page and progress bar
    showPage(currentPage);
});


