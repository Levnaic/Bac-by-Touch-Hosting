//* VARIABLES
const inputs = document.querySelectorAll("input");
const textareas = document.querySelectorAll("textarea");
const form = document.querySelector("form");
let pattern, errorMessage;
let inputOldBorderCollor;
let formHasErrors = false;

//* FUNCTIONS
function validateInput(input) {
  let language = getLanguageCookie();
  console.log(language);
  switch (input.dataset.inputType) {
    case "str":
      pattern = /^[a-zA-Z]*$/;
      errorMessage = "Možete uneti samo slova";
      break;

    case "int":
      pattern = /^[0-9]*$/;
      errorMessage = "Možete uneti samo brojeve";
      break;

    case "email":
      pattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
      errorMessage = "Pogrešno uneta email adresa";
      break;

    case "txt":
      pattern = /^[\p{L}\p{N}\p{P}\s]+$/u;
      errorMessage =
        "Pogrešno unet tekstualni format";
      break;

   case "username":
      pattern = /^[a-zA-Z0-9._]{1,20}$/;
      errorMessage = "Pogrešno uneto korisničko ime";
      break;

    case "date":
      pattern = /^\d{4}-\d{2}-\d{2}$/;
      errorMessage = "Pogrešno unet datum";
      break;

    case "float":
      pattern = /^-?\d*\.?\d+$/;
      errorMessage = "Možete uneti samo decimalne brojeve";
      break;

    case "password":
      pattern = /^(?=.*[a-z])(?=.*\d)[a-zA-Z\d@$!%*#?&]{8,}$/;
      errorMessage =
        "Morate uneti bar jedno malo slovo, jedno veliko slovo i jedan broj";
      break;

      case "fileName":
      pattern = /^[a-f\d]+_[a-zA-Z0-9-]+\.(jpg|jpeg|png|gif|bmp)$/;
      errorMessage =
        "Pogrešan naziv unete slike";
      break;

      case "phoneNumber":
        pattern = /^[\s]*\+?[\s]*\d+[\s]*$/;
        errorMessage =
          "Pogrešno unet broj telefona";
        break;
    

    default:
      pattern = new RegExp(input.dataset.customPattern);
      errorMessage = "Pogrešno unet format";
  }

  if (!pattern.test(input.value)) {
    showError(input, errorMessage);
  } else {
    clearError(input);
  }
}

//! DESAVA SE DA PRI PEJSTOVANJU VISE PUTA OSTAJE EROR KADA SE OBRISE
function showError(input, message) {
  const errorElement = input.parentNode.querySelector(".error-message");
  if (!errorElement) {
    const errorElement = document.createElement("div");
    errorElement.className = "error-message";
    errorElement.innerText = message;

    input.parentNode.appendChild(errorElement);

    if (input.style.borderColor !== "red") {
      inputOldBorderCollor = input.style.borderColor;
      input.style.borderColor = "red";
    }
  }
}

function clearError(input) {
  const errorElement = input.parentNode.querySelector(".error-message");
  if (errorElement) {
    errorElement.remove();
    input.style.borderColor = inputOldBorderCollor;
  }
}

function getLanguageCookie() {
  let name = 'language' + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}



//* APP
form.addEventListener("submit", function (event) {
  if (formHasErrors) {
    event.preventDefault(); // Prevent form submission
    alert(
      "Forma ima greške prilikom validacije. Molimo vas da ih ispravite pre slanja."
    );
  }
});

inputs.forEach((input) => {
  input.addEventListener("input", () => {
    validateInput(input);

    // Update formHasErrors based on the presence of error messages
    formHasErrors = Array.from(inputs).some(
      (input) => input.parentNode.querySelector(".error-message") !== null
    );
  });
});

textareas.forEach((textarea) => {
  textarea.addEventListener("input", () => {
    validateInput(textarea);

    // Update formHasErrors based on the presence of error messages
    formHasErrors = Array.from(textareas).some(
      (textarea) => textarea.parentNode.querySelector(".error-message") !== null
    );
  });
});