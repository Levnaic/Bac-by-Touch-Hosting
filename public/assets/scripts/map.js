//* VARIABLES
const btnOrder = document.querySelectorAll(".orderBtn");
const btnAddComment = document.querySelectorAll(".addComment");
const btnCommentBack = document.querySelector(".btnCommentBack");
const btnOrderBack = document.querySelector(".btnOrderBack");
const btnNotLoggedAddCmnt = document.querySelectorAll(".notLogged");
const formFieldForMarkerIdComment = document.getElementById(
  "markerIdFieldComment"
);
const formFieldForMarkerIdOrder = document.getElementById("markerIdFieldOrder");
const commentDates = document.querySelectorAll(".commentTime");
const commentTextArea = document.getElementById("commentTextArea");

const commentBox = document.getElementById("addComment");
const orderBox = document.getElementById("addOrder");

//responsive
const btnShowLocationZoom = document.querySelector(".zoomToLocation");

const mapView = document.querySelector(".mapBoxContainer");
const markersView = document.querySelector(".markers-container");
const btnOpenMenu = document.querySelector(".open-btn");
const btnOpenMap = document.querySelector(".openMapResp");

let date = new Date();

//* FUNCTIONS

//checks if it is mobile
function isMobile() {
  return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
    navigator.userAgent
  );
}

//calling from html
function openCommentSection(markerId) {
  formFieldForMarkerIdComment.value = markerId;
}

function openOrderSection(markerId) {
  formFieldForMarkerIdOrder.value = markerId;
}

//redirect if not loged in
function handleConfirmAction() {
  const response = confirm(
    "Niste prijavljeni na nalog, da li želite da se prijavite?"
  );

  if (response) window.location.href = "/login";
}

//* EVENT HANDLERS
function handlePopupShow(targetPopup) {
  window.addEventListener(
    "keydown",
    function (e) {
      if (e.target === commentTextArea) return;
      if (
        e.key === " " ||
        e.key === "ArrowUp" ||
        e.key === "ArrowDown" ||
        e.key === "ArrowLeft" ||
        e.key === "ArrowRight" ||
        e.key === "PageUp" ||
        e.key === "PageDown"
      ) {
        e.preventDefault();
      }
    },
    false
  );

  targetPopup.style.display = "block";
  mapContainer.classList.add("blur");
  mapContainer.style.height = "100%";
  mapContainer.style.overflow = "hidden";
  markerActive.style.pointerEvents = "none";
  html[0].style.height = "100%";
  body[0].style.height = "100%";
  body[0].style.overflow = "hidden";

  getMapPossition();
  map.remove();
  initializeMap(mapCenter.lat, mapCenter.lng, mapZoom, false, false);
}

function handlePopupClose(target) {
  target.style.display = "none";
  mapContainer.classList.remove("blur");
  mapContainer.style.height = "100%";
  mapContainer.style.overflow = "auto";
  markerActive.style.pointerEvents = "auto";
  html[0].style.height = "100%";
  body[0].style.height = "100%";
  body[0].style.overflow = "show";

  getMapPossition();
  map.remove();
  //! mozda bi trebalo zameniti route from your location??
  initializeMap(mapCenter.lat, mapCenter.lng, mapZoom);
  addBookmarks(targetLat, targetLng, targetPopupMsg, targetImgUrl);
  //tu si stao, dodaj bukmarkove
}

//responsive part
function handleOpenMenuClick() {
  if (isMobile()) {
    mapView.style.display = "none";
    btnOpenMenu.style.display = "none";
  }
}

function handleOpenMapClick() {
  if (isMobile()) {
    mapView.style.display = "block";
    btnOpenMenu.style.display = "flex";
  }
}

function handleZoomToLocationClick() {
  handleOpenMapClick();
}

//* CALLBACK

//not logged in popup btns
btnNotLoggedAddCmnt.forEach((btn) => {
  btn.addEventListener("click", handleConfirmAction);
});

//show comment popup
btnAddComment.forEach((btn) => {
  btn.addEventListener("click", handlePopupShow.bind(null, commentBox));
});

//show order popup
btnOrder.forEach((btn) => {
  btn.addEventListener("click", handlePopupShow.bind(null, orderBox));
});

//close comments
btnCommentBack?.addEventListener(
  "click",
  handlePopupClose.bind(null, commentBox)
);

//close order
btnOrderBack?.addEventListener("click", handlePopupClose.bind(null, orderBox));

//responsive
//open menu
btnOpenMenu?.addEventListener("click", handleOpenMenuClick);

btnOpenMap?.addEventListener("click", handleOpenMapClick);

btnShowLocationZoom?.addEventListener("click", handleZoomToLocationClick);

//* APP
commentDates.forEach((commentDate) => {
  const timePassedInMs = date - new Date(commentDate.innerHTML);
  const days = Math.floor(timePassedInMs / (1000 * 60 * 60 * 24));
  const weeks = Math.floor(days / 7);
  const months = Math.floor(days / 30);
  const years = Math.floor(months / 12);

  //writing time till comment
  if (days == 0) {
    commentDate.innerHTML = "danas";
  } else if (days == 1) {
    commentDate.innerHTML = "juce";
  } else if (days == 2) {
    commentDate.innerHTML = "prekjuče";
  } else if (days == 3) {
    commentDate.innerHTML = "nakjuče";
  } else if (days > 3 && days < 7) {
    commentDate.innerHTML = `pre ${days} dana`;
  } else if (weeks == 1) {
    commentDate.innerHTML = "pre nedelju dana";
  } else if (weeks > 1 && weeks <= 4) {
    commentDate.innerHTML = `pre ${weeks} nedelje`;
  } else if (weeks == 5) {
    commentDate.innerHTML = "pre 5 nedelja";
  } else if (months == 1) {
    commentDate.innerHTML = "pre mesec dana";
  } else if (months > 1 && months <= 4) {
    commentDate.innerHTML = `pre ${months} meseca`;
  } else if (months > 4 && months < 12) {
    commentDate.innerHTML = `pre ${months} meseci`;
  } else if (years == 1) {
    commentDate.innerHTML = "pre godinu dana";
  } else if (years > 1 && years < 5) {
    commentDate.innerHTML = `pre ${years} godine`;
  } else if (years > 5) {
    commentDate.innerHTML = `pre ${years} godina`;
  }
});
