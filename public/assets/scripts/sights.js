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

  4: {
    headline: "Šiljak",
    img: "../assets/img/cards/siljak.jpg",
    link: "siljak",
  },
};

//variables
const pages = document.querySelectorAll(".suggestedPage");
const takenPage = Number(
  document.querySelector(".suggestedPages").dataset.taken_page
);
let takenPages = new Set([takenPage]);
let rand = Math.floor(Math.random() * 5);
pages.forEach((e) => {
  while (takenPages.has(rand)) {
    rand = Math.floor(Math.random() * 5);
  }
  takenPages.add(rand);
  e.querySelector(".suggestedHeadline").innerHTML = cardsData[rand].headline;
  e.querySelector(".suggestedImg").src = cardsData[rand].img;
  e.querySelector("a").href = cardsData[rand].link;
});
