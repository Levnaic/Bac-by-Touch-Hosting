//variables
const btnPrev = document.querySelector(".prevBtn");
const btnNext = document.querySelector(".nextBtn");
let dots = document.querySelectorAll(".dot");
let slides = document.getElementsByClassName("slide");

//on startup
let currentSlide = 0;
showSlide(currentSlide);

//functions
function showSlide(n) {
  if (n >= slides.length) {
    n = 0;
    currentSlide = 0;
  }

  if (n < 0) {
    n = slides.length - 1;
    currentSlide = slides.length - 1;
  }

  for (let i = 0; i < slides.length; i++) {
    slides[i].classList.remove("activeSlide");
  }

  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" activeDot", "");
  }

  // slides[n].style.display = "block";
  slides[n].classList.add("activeSlide");
  dots[n].classList.add("activeDot");
}

function showSlideDots(n) {
  currentSlide = n;
  showSlide(n);
}

//calling functions
btnNext.addEventListener("click", () => {
  currentSlide++;
  showSlide(currentSlide);
});

btnPrev.addEventListener("click", () => {
  currentSlide--;
  showSlide(currentSlide);
});

//!PRODUKCIJA
//auto scroll
// setInterval(() => {
//   currentSlide++;
//   showSlide(currentSlide)
// }, 7000);
