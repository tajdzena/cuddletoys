import './bootstrap';

//slajder
    const slider = document.getElementById('slider');
    const prevButton = document.getElementById('prev');
    const nextButton = document.getElementById('next');
    let currentIndex = 0;

    function showSlide(index) {
    slider.style.transform = `translateX(-${index * 100}%)`;
}

    prevButton.addEventListener('click', () => {
    currentIndex = (currentIndex > 0) ? currentIndex - 1 : slider.children.length - 1;
    showSlide(currentIndex);
});

    nextButton.addEventListener('click', () => {
    currentIndex = (currentIndex < slider.children.length - 1) ? currentIndex + 1 : 0;
    showSlide(currentIndex);
});

    // Optional: Automatska rotacija slajdera svakih 20 sekundi
    setInterval(() => {
    nextButton.click();
}, 20000);
