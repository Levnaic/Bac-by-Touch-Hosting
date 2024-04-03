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
