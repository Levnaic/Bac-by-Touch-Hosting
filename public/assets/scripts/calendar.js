//*VARIABLE
const calendar = document.getElementById("calendar");
// this has to be defined in handlers becouse calendar elements load later
let activeEventIndicator;
let eventContainer;


//*FUNCTIONS

//*HANDLERS
function handleCalendarClick() {
  eventContainer = document.querySelector(".event-container");
  eventContainer?.addEventListener("click", handleScrollToEvent);
}

function handleScrollToEvent() {
  let scrollToId = eventContainer.dataset.eventIndex;
  let targetElement = document.getElementById(scrollToId);
  targetElement.scrollIntoView();
}

function handleClickOnActiveEvent(){
  
}

//*EVENT LISTENERS
calendar.addEventListener("click", handleCalendarClick);
