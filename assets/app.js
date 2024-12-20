
document.addEventListener('DOMContentLoaded', () => {
    const pages = document.querySelectorAll('.page');
    const bullets = document.querySelectorAll('.custom-progress-bar .step');
    const nextButtons = document.querySelectorAll('.next');
    const prevButtons = document.querySelectorAll('.prev');
    const submitButton = document.querySelector('.submit');

    let currentPage = 0;

    function updateProgressBar() {
        bullets.forEach((step, index) => {
            if (index < currentPage) {
                step.classList.add('completed'); 
                step.classList.remove('active');
                step.querySelector('.check').style.display = 'block'; 
            } else if (index === currentPage) {
                step.classList.add('active'); 
                step.classList.remove('completed');
                step.querySelector('.check').style.display = 'none'; 
            } else {
                step.classList.remove('active', 'completed'); 
                step.querySelector('.check').style.display = 'none'; 
            }
        });
    }
    

    function showPage(index) {
        pages.forEach((page, i) => {
            page.style.display = i === index ? 'block' : 'none';
        });
        updateProgressBar(); 
    }

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

    showPage(currentPage);
});
