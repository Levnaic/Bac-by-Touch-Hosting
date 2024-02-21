//* INTERSECTION API

// Define the options for the Intersection Observer
const options = {
  root: null, // Use the viewport as the root
  rootMargin: "-100px", // No margin around the viewport
  threshold: 0, // Trigger the callback when 30% of the section is in view
};

// Callback function for the Intersection Observer
const sectionCallback = (entries, observer) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.style.opacity = "100%";
      entry.target.style.transform = "translateY(0%)";
      observer.unobserve(entry.target); // Stop observing once it's visible
    }
  });
};

// Create an Intersection Observer with the callback and options
const sectionObserver = new IntersectionObserver(sectionCallback, options);

// Observe the section element
const animatedSections = document.querySelectorAll(".popupSection");
animatedSections.forEach((animatedSection) => {
  sectionObserver.observe(animatedSection);
});

//* LANGUAGE COOKIES
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
//set cookie
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
