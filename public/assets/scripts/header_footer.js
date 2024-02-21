//* NAV
const open_btn = document.querySelector(".open-btn");
const close_btn = document.querySelector(".close-btn");
const nav = document.querySelectorAll(".nav");
const navBox = document.querySelector("nav");
const userBtn = document.querySelector(".navUserBtn");
const dropdownUser = document.querySelector(".dropdown-user");
const navHeight = document.querySelector("nav").getBoundingClientRect().height;
const observeObject = document.querySelector(".header-area");
let navIsShowing = false;

function isMobile() {
  return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
    navigator.userAgent
  );
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

//* login credencials show after click on button
userBtn?.addEventListener("click", () => {
  dropdownUser.classList.toggle("dropdown-user-visible");
  if (!isMobile) {
    dropdownUser.style.top = `${navHeight - 7}px`;
  }
});

//mobile
open_btn.addEventListener("click", () => {
  navBox.style.display = "flex";
  setTimeout(() => {
    nav.forEach((nav_el) => nav_el.classList.add("visible"));
  }, 50);
  open_btn.style.display = "none";
});

close_btn.addEventListener("click", () => {
  nav.forEach((nav_el) => nav_el.classList.remove("visible"));
  setTimeout(() => {
    navBox.style.display = "none";
    open_btn.style.display = "block";
  }, 700);
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

//* FOOTER
const footerLogo = document.querySelector(".footerHeadline");

footerLogo?.addEventListener("click", () => {
  window.scrollTo(0, 0);
});
