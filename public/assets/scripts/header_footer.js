//* helper functions

function isMobile() {
  return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
    navigator.userAgent
  );
}

//* NAV
//* responsive nav

const burgerMenu = document.querySelector(".burger-menu");
const header = document.querySelector("header");
const yellowRibbon = document.querySelector(".menu__wrapper-yellow");
const greenRibbon = document.querySelector(".menu__wrapper-green");
const navBtns = document.querySelectorAll(".nav-btn");
const dropdownLi = document.querySelector(".dropdown-li");
const dropdown = document.querySelector(".dropdown");
const dropdownSvg = document.querySelector(".dropdown-svg");

let isMenuOpened = false;
let isDropdownOpen = false;

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

function closeDropdown() {
  dropdown.style.display = "none";
  dropdownSvg.style.rotate = "0deg";
  isDropdownOpen = false;
}
function openDropdown(i) {
  closeDropdown();
  dropdown.style.display = "block";
  dropdownSvg.style.rotate = "180deg";
  isDropdownOpen = true;
}

burgerMenu.addEventListener("click", () => {
  isMenuOpened ? closeMenu() : openMenu();
});

if (isMobile()) {
  dropdownLi.addEventListener("click", () => {
    isDropdownOpen ? closeDropdown() : openDropdown();
  });
}
//* sticky navbar
const nav = document.querySelector(".menu__wrapper-green");
let prevScrollPos = window.scrollY;

if (!isMobile()) {
  window.onscroll = function () {
    let currentScrollPos = window.scrollY;
    if (prevScrollPos > currentScrollPos) {
      nav.style.top = "0";
    } else {
      nav.style.top = "-100px";
    }
    prevScrollPos = currentScrollPos;
  };
}
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
