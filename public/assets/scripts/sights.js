//data for input
const cardsData = {
  0: {
    headline: "Tvrđava",
    img: "../assets/img/cards/tvrdjava.jpg",
    link: "tvrdjava",
  },

  1: {
    headline: "Manastir",
    img: "../assets/img/cards/manastir.jpg",
    link: "manastir",
  },

  2: {
    headline: "Samostan",
    img: "../assets/img/cards/samostan.jpg",
    link: "samostan",
  },

  3: {
    headline: "Tursko kupatilo",
    img: "../assets/img/cards/tursko-kupatilo.jpg",
    link: "tursko-kupatilo",
  },
};

//variables
const pages = document.querySelectorAll(".suggestedPage");
const takenPage = Number(
  document.querySelector(".suggestedPages").dataset.taken_page
);
let takenPages = new Set([takenPage]);
let rand = Math.floor(Math.random() * 4);
pages.forEach((e) => {
  while (takenPages.has(rand)) {
    rand = Math.floor(Math.random() * 4);
  }
  takenPages.add(rand);
  e.querySelector(".suggestedHeadline").innerHTML = cardsData[rand].headline;
  e.querySelector(".suggestedImg").src = cardsData[rand].img;
  e.querySelector("a").href = cardsData[rand].link;
});

//* SLIDESHOW
//*variables
const btnPrev = document.querySelector(".prevBtn");
const btnNext = document.querySelector(".nextBtn");
let dots = document.querySelectorAll(".dot");
let slides = [...document.getElementsByClassName("slide")];
let imgs = document.getElementsByClassName("slideImg");
let slideTimer = 5000;

// slide timer
let slideTimerId = setInterval(() => {
  currentSlide++;
  showSlide(currentSlide);
}, slideTimer);

//on startup
let currentSlide = 0;
showSlide(currentSlide);

//*functions

function startSlideTimer() {
  clearInterval(slideTimerId);
  slideTimerId = setInterval(() => {
    currentSlide++;
    showSlide(currentSlide);
  }, slideTimer);
}

function activateSlide(n) {
  slides[n].classList.add("activeSlide");
  // imgs[n].classList.add("fade-id");
  // imgs[n].classList.remove("fade-out");
  dots[n].classList.add("activeDot");
  startSlideTimer();
}

function deactivateSlides() {
  slides.forEach((slide, i) => {
    // imgs[i].classList.remove("fade-in");
    // imgs[i].classList.add("fade-out");
    slide.classList.remove("activeSlide");
    dots[i].className = dots[i].className.replace(" activeDot", "");
  });
}

function showSlide(n) {
  deactivateSlides();

  if (n >= slides.length) {
    n = 0;
    currentSlide = 0;
  }

  if (n < 0) {
    n = slides.length - 1;
    currentSlide = slides.length - 1;
  }

  activateSlide(n);
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

// auto scroll
