//* VARIABLES

//map starting view
const mapConfig = {
  initialLat: 45.39807,
  initialLng: 19.179063,
  initialZoom: 12,
};

//DOM variables
const domElements = {
  mapBox: document.getElementById("map"),
  markers: document.querySelectorAll(".marker"),
  nav: document.querySelector("nav"),
  select: document.getElementById("mapCategorySelect"),
  btnShowAll: document.querySelector(".showAll"),
  btnShowLocation: document.querySelector(".zoomToLocation"),
  openMapResponsive: document.querySelector(".openMapResp"),
};

let userLocation = {
  lat: null,
  lng: null,
};

const categories = [];
let map;
let targetLat;
let targetLng;
let targetPopupMsg;
let targetImgUrl;
let savedBounds;
let mapCenter;
let mapZoom;
let markerActive;
let clickedMarker;
let screenHeight = window.innerHeight;
let locationsObjArr = [];

//* FUNCTIONS

function initializeMap(
  lat,
  lng,
  zoom,
  enableZoom = true,
  enablePanning = true
) {
  map = L.map("map", {
    scrollWheelZoom: enableZoom,
    dragging: enablePanning,
    keyboard: enablePanning,
    zoomControl: false,
  }).setView([lat, lng], zoom);

  // set tiles
  L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png").addTo(map);

  //set position of zoom buttons
  L.control
    .zoom({
      position: "bottomright",
    })
    .addTo(map);

  changeMapSize();
}

function restartMap() {
  getMapPossition();
  map.remove();
  initializeMap(mapCenter.lat, mapCenter.lng, mapZoom);
}

function getMapPossition() {
  mapCenter = map.getCenter();
  mapZoom = map.getZoom();
}

function changeMapSize() {
  screenHeight = window.innerHeight;
  domElements.mapBox.style.height = `${screenHeight}px`;
  //! dodano
  map?.invalidateSize();
}

function getUserLatLng() {
  const options = {
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 0,
  };

  function success(pos) {
    let coords = pos.coords;

    //!PRODUKCIJA U PORDUKCIJI UKLJUCITI OBAVEZNO!!!!
    // userLocation.lat = coords.latitude;
    // userLocation.lng = coords.longitude;

    //!PRODUKCIJA SAMO ZA TESTIRANJE DEO
    userLocation.lat = 45.391621;
    userLocation.lng = 19.236691;
  }

  function error(err) {
    console.warn(`ERROR(${err.code}): ${err.message}`);
  }
  navigator.geolocation.getCurrentPosition(success, error, options);
}

function removeAllMarkers() {
  map.eachLayer(function (layer) {
    if (layer instanceof L.Marker) {
      map.removeLayer(layer);
    }
  });
}

function addBookmarks(lat, lng, msg, iconUrl) {
  var myIcon = L.icon({
    iconUrl: `assets/img/mapIcons/${iconUrl}.png`,
    iconSize: [32, 32],
  });

  L.marker([lat, lng], { icon: myIcon })
    .addTo(map)
    .bindPopup(
      L.popup({
        maxWidth: 250,
        minWidth: 100,
        autoClose: true,
        openOnClick: true,
        closeOnClick: true,
        className: `markerPopup`,
      })
    )
    .setPopupContent(msg);
}

//! ZAMENSKA FUNKCIJA
function zoomOnLocation(lat, lng, popupMsg, iconUrl) {
  map.setView([lat, lng], 27);
  removeAllMarkers();
  addBookmarks(lat, lng, popupMsg, iconUrl);
}

function createLocationObject(marker) {
  return {
    headline: marker.querySelector(".markersHeadline").innerHTML,
    text: marker.querySelector(".textMarker").innerHTML,
    latitude: Number(marker.querySelector(".latitude").innerHTML),
    longitude: Number(marker.querySelector(".longitude").innerHTML),
    popupMsg: marker.querySelector(".popupMsg").innerHTML,
    category: marker.querySelector(".category").innerHTML,
  };
}

// ! OVO SI MENJAO
function findMarkerById(markerId) {
  // Iterate over the markers to find the one with the matching ID
  for (const marker of domElements.markers) {
    if (
      marker.querySelector(".markerMeta .markerId").dataset.markerId ===
      markerId
    ) {
      return marker;
    }
  }
  return null;
}

//routing functions

//!FUNKCIJA KOJA MORA DA SE UKLJUCI
function routeFromYourLocation(lat, lng, popupMsg, iconUrl) {
  //kupi korisnikovu latitudu i longitudu,
  //mora ovde zato sto je asinhrono i ne bi stiglo drugacije
  getUserLatLng();

  //namestanje mape da stane cela ruta
  let bounds = [
    [lat, lng], // Southwest corner
    [userLocation.lat, userLocation.lng], // Northeast corner
  ];
  map.fitBounds(bounds);

  const waypoints = [
    //user lat and lng
    L.latLng(userLocation.lat, userLocation.lng),
    //shops lat and lng
    L.latLng(lat, lng),
  ];

  L.Routing.control({
    waypoints: waypoints,
    language: "en",
    collapsible: true,
    draggableWaypoints: false,
    addWaypoints: false,
  }).addTo(map);

  removeAllMarkers();
  addBookmarks(lat, lng, popupMsg, iconUrl);
  addBookmarks(userLocation.lat, userLocation.lng, "Vaša pozicija", "user");
}

//!ubacen deo
async function fetchDirections(start, end, profile) {
  const apiKey = "5b3ce3597851110001cf6248719502b7fd784b5d9d52e3098d8d6c9f";
  const url = `https://api.openrouteservice.org/ors/v2/directions/${profile}?api_key=${apiKey}&start=${start}&end=${end}`;

  try {
    const response = await fetch(url);
    const data = await response.json();
    return data;
  } catch (error) {
    console.log("Error fetching directions:", error);
    return null;
  }
}

async function handleDirections(start, end, profile) {
  const directions = await fetchDirections(start, end, profile);

  if (directions && directions.routes && directions.routes.length > 0) {
    const route = directions.routes[0]; // Assuming the first route is chosen
    const routeCoordinates = route.geometry.coordinates;

    L.Routing.control({
      waypoints: [
        L.latLng(routeCoordinates[0][1], routeCoordinates[0][0]),
        L.latLng(routeCoordinates[routeCoordinates.length - 1][1]),
      ],
      lineOptions: {
        styles: [{ color: "blue", opacity: 0.6, weight: 4 }],
      },
    }).addTo(map);
  }
}

// Example usage
const start = "45.39807,19.179063"; // Start coordinates
const end = "45.391621,19.236691"; // End coordinates
const profile = "driving-car"; // Routing profile

// handleDirections(start, end, profile);
//!kraj ubacenog dela

//*EVENT HANDLERS

function handleMarkerClick() {
  document.body.scrollTop = document.documentElement.scrollTop = 0;
  clickedMarker = this;

  domElements.markers.forEach((marker) => {
    marker.classList.add("invisibleMarker");
  });

  domElements.nav.querySelector(".standardMode").style.display = "none";
  domElements.nav.querySelector(".focusedMode").style.display = "flex";
  this.classList.remove("invisibleMarker");
  this.querySelector(".markerInvisablePart").style.display = "block";
  this.style.cursor = "default";

  markerActive = this;

  showMarkerLocation();
}

function showMarkerLocation() {
  targetLat = Number(clickedMarker.querySelector(".latitude").innerHTML);
  targetLng = Number(clickedMarker.querySelector(".longitude").innerHTML);
  targetPopupMsg = clickedMarker.querySelector(".popupMsg").innerHTML;
  targetImgUrl = clickedMarker.querySelector(".category").innerHTML;

  savedBounds = map.getBounds();
  restartMap();

  /*
  //!UBACENA NAJNOVIJA
  handleDirections(targetLat, targetLng, "driving-car");
  //!PRODUKCIJA UKLJUCI U PRODUKCIJI, ISKLJUCENO DA ME NE BI IZBACILI
  // routeFromYourLocation(targetLat, targetLng, targetPopupMsg, targetImgUrl);
  */
  //!zamenska funkcija
  zoomOnLocation(targetLat, targetLng, targetPopupMsg, targetImgUrl);
  // clickedMarker.removeEventListener("click", handleMarkerClick);
}

function handleShowAllBtnClick() {
  markerActive.addEventListener("click", handleMarkerClick);
  markerActive.style.cursor = "pointer";
  restartMap();
  domElements.nav.querySelector(".standardMode").style.display = "flex";
  domElements.nav.querySelector(".focusedMode").style.display = "none";
  map.fitBounds(savedBounds);

  domElements.markers.forEach((marker, i) => {
    marker.querySelector(".markerInvisablePart").style.display = "none";
    marker.classList.remove("invisibleMarker");
    addBookmarks(
      locationsObjArr[i].latitude,
      locationsObjArr[i].longitude,
      locationsObjArr[i].popupMsg,
      locationsObjArr[i].category
    );
  });
}

function handleCategoryChange(event) {
  let chosenCategory = event.target.value;

  // Add or remove bookmarks based on the selected category
  let mapCenter = map.getCenter();
  let mapZoom = map.getZoom();
  map.remove();
  initializeMap(mapCenter.lat, mapCenter.lng, mapZoom);

  locationsObjArr.forEach((locationsObj) => {
    if (chosenCategory === "svi" || locationsObj.category === chosenCategory) {
      addBookmarks(
        locationsObj.latitude,
        locationsObj.longitude,
        locationsObj.popupMsg,
        locationsObj.category
      );
    }
  });

  // Add or remove side markers based on the selected category
  domElements.markers.forEach((marker) => {
    if (
      chosenCategory === "svi" ||
      marker.querySelector(".category").innerHTML === chosenCategory
    ) {
      marker.classList.remove("invisibleMarker");
    } else {
      marker.classList.add("invisibleMarker");
    }
  });
}

// ! OVO SI MENJAO
function handleIconClick() {
  console.log("radi");
  // Retrieve the marker ID associated with the clicked icon
  const markerId =
    this.parentElement.querySelector(".markerId").dataset.markerId;

  // Find the corresponding marker based on the marker ID
  const marker = findMarkerById(markerId);

  // Trigger a click event on the marker to open its popup
  if (marker) {
    marker.click();
  }
}

//responsive
function handleOpenMapResponsiveClick() {
  location.reload();
}

//*MAP application
window.addEventListener("load", () => {
  // initialize lat and lng of user
  getUserLatLng();

  // map position on webpage
  window.onresize = changeMapSize;
  domElements.mapBox.style.height = `${screenHeight}px`;

  // map initialization
  initializeMap(
    mapConfig.initialLat,
    mapConfig.initialLng,
    mapConfig.initialZoom
  );

  // init bookmarks and go to place of bookmark when clicking on card
  domElements.markers.forEach((marker) => {
    const locationObj = createLocationObject(marker);
    locationsObjArr.push(locationObj);
    // adding bookmarks
    addBookmarks(
      locationObj.latitude,
      locationObj.longitude,
      locationObj.popupMsg,
      locationObj.category
    );
    marker.addEventListener("click", handleMarkerClick);
  });

  // shows producers of selected category
  domElements.select.addEventListener("change", handleCategoryChange);

  // restart map view after clicking on show all/prikazi sve
  domElements.btnShowAll.addEventListener("click", handleShowAllBtnClick);

  // show location of marker when clicked on show location
  domElements.btnShowLocation.addEventListener(
    "click",
    handleShowLocationClick
  );
  //responsive
  domElements.openMapResponsive.addEventListener(
    "click",
    handleOpenMapResponsiveClick
  );
});
