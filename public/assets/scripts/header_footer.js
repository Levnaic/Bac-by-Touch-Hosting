//* NAV
//* responsive nav

const burgerMenu = document.querySelector(".burger-menu");
const header = document.querySelector("header");
const yellowRibbon = document.querySelector(".menu__wrapper-yellow");
const greenRibbon = document.querySelector(".menu__wrapper-green");

let isMenuOpened = false;

function openMenu() {
  setTimeout(() => {
    greenRibbon.style.transform = "translateX(0%)";
  }, 0);
  setTimeout(() => {
    yellowRibbon.style.transform = "translateX(0%)";
  }, 200);
  setTimeout(() => {
    header.style.transform = "translateX(0%)";
  }, 400);
  isMenuOpened = true;
}

function closeMenu() {
  setTimeout(() => {
    header.style.transform = "translateX(100%)";
  }, 0);
  setTimeout(() => {
    yellowRibbon.style.transform = "translateX(100%)";
  }, 200);
  setTimeout(() => {
    greenRibbon.style.transform = "translateX(100%)";
  }, 400);
  isMenuOpened = false;
}

burgerMenu.addEventListener("click", () => {
  isMenuOpened ? closeMenu() : openMenu();
});

//* sticky navbar
let prevScrollPos = window.scrollY;
window.onscroll = function () {
  let currentScrollPos = window.scrollY;
  if (prevScrollPos > currentScrollPos) {
    document.querySelector("nav").style.top = "0";
  } else {
    document.querySelector("nav").style.top = "-100px";
  }
  prevScrollPos = currentScrollPos;
};

//* Language cookies
function getCookieValue(cookieName) {
  let cookies = document.cookie.split(";");
  for (let i = 0; i < cookies.length; i++) {
    let cookie = cookies[i].trim();
    // Check if the cookie starts with the specified name
    if (cookie.indexOf(cookieName + "=") === 0) {
      return cookie.substring(cookieName.length + 1);
    }
  }
  return null; // Cookie not found
}
//set cookie, clled from html
function setLanguage(language) {
  let languageValue = getCookieValue("language");

  // checks if cookie is same as before
  if (languageValue != language) {
    document.cookie =
      "language=" +
      language +
      "; expires=" +
      new Date(new Date().getTime() + 30 * 24 * 60 * 60 * 1000).toUTCString() +
      "; path=/";
    ("");
    window.location.reload();
  } else {
    return true;
  }
}

//* FOOTER
const footerLogo = document.querySelector(".footerHeadline");

footerLogo?.addEventListener("click", () => {
  window.scrollTo(0, 0);
});
