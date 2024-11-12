// main.blade.php

// Get the button
let backToTopBtn = document.getElementById("backToTopBtn");

// When the user scrolls down 300px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
        backToTopBtn.classList.remove('hidden');
    } else {
        backToTopBtn.classList.add('hidden');
    }
}

// When the user clicks on the button, scroll to the top of the document
backToTopBtn.addEventListener('click', function(event) {
    event.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
});
