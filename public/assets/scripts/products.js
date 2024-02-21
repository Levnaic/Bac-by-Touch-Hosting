//* VARIABLES
const products = document.querySelectorAll(".productPrice");
const inputs = document.querySelectorAll(".quantity");
const priceSumView = document.getElementById("priceSum");
let prices = [];
let priceSumByProduct = [];
sum = 0;

//*HANDLERS
function handleInputChange() {
  inputs.forEach((input, i) => {
    priceSumByProduct[i] = input.value * prices[i];
  });
  sum = priceSumByProduct.reduce((accumulator, currentValue) => {
    return accumulator + currentValue;
  });
  priceSumView.value = sum;
}

//*data prepare
products.forEach((product, i) => {
  prices[i] = Number(product.dataset.price);
});

//* CALLBACK
inputs.forEach((input) => {
  input.addEventListener("change", handleInputChange);
});
