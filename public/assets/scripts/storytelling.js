//*VARIABLES
const videos = document.querySelectorAll(".video");
const selectionBoxes = document.querySelectorAll(".selectionBox");
let mobileFirstClick = [
  false,
  ...Array.from({ length: selectionBoxes.length - 1 }).fill(true),
];
let boxN;

//*FUNCTION
function isMobile() {
  return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
    navigator.userAgent
  );
}

function setViewedBox(e, index) {
  selectionBoxes.forEach((selectionBox, i) => {
    selectionBox.classList.remove(`activeBox${i + 1}`);
    selectionBox.querySelector("h2")?.classList.remove("activeSelectionH2");
  });
  boxN = index;
  selectionBoxes[index].classList.add(`activeBox${+boxN + 1}`);
  selectionBoxes[index].querySelector("h2")?.classList.add("activeSelectionH2");
}

//*CALLBACKS
//setting views
selectionBoxes.forEach((selectionBox, index) => {
  //desktop
  selectionBox.addEventListener("mouseenter", (e) => {
    setViewedBox(e, index);
  });

  //mobile
  if (isMobile()) {
    selectionBox.addEventListener("click", (e) => {
      if (mobileFirstClick[index]) {
        e.preventDefault();
        setViewedBox(e, index);
        mobileFirstClick.fill(true);
        mobileFirstClick[index] = false;
      } else {
        return true;
      }
    });
  }

  // Add event listener for h2 elements
  const h2Element = selectionBox.querySelector("h2");
  if (h2Element) {
    h2Element.addEventListener("click", (e) => {
      if (!mobileFirstClick[index]) {
        // Allow the default behavior after the first click
        return true;
      }
      e.preventDefault();
      setViewedBox(e, index);
    });
  }
});

//video part
videos.forEach((video) => {
  video.controls = true;
});
