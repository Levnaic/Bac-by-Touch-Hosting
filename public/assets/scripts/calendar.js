//*VARIABLE
const calendar = document.getElementById("calendar");
let eventContainer;

//*FUNCTIONS

//*HANDLERS
function handleCalendarClick() {
  eventContainer = document.querySelector(".event-container");
  eventContainer.addEventListener("click", handleScrollToEvent);
}

function handleScrollToEvent() {
  let scrollToId = eventContainer.dataset.eventIndex;
  console.log(scrollToId, "taj");
  let targetElement = document.getElementById(scrollToId);
  targetElement.scrollIntoView();
}

//*EVENT LISTENERS
calendar.addEventListener("click", handleCalendarClick);
