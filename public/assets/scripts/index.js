//* VARIABLES
const left = document.querySelector(".left");
const right = document.querySelector(".right");
const cards = document.querySelectorAll(".card");
const bluredPart = document.querySelector(".headlineBluredPart");

//* HERO
function isMobile() {
  return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
    navigator.userAgent
  );
}

if (!isMobile()) {
  window.addEventListener("load", () => {
    bluredPart.style.transform = "translateX(0%)";
  });
} else {
  window.addEventListener("load", () => {
    bluredPart.style.transform = "translate(-50%, -50%)";
  });
}

//* CARDS
cards.forEach((card) => {
  card.addEventListener("mouseenter", () => {
    card.querySelector(".cardsHeadline").classList.add("animationCardsAddPart");
  });
});

cards.forEach((card) => {
  card.addEventListener("mouseleave", () => {
    card
      .querySelector(".cardsHeadline")
      .classList.remove("animationCardsAddPart");
  });
});
