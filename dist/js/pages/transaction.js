// JavaScript code to handle the calculations and update the "checkedItems" and "totalPrice" elements
const checkboxes = document.querySelectorAll('input[type="checkbox"][name="productCheckbox[]"]');
const quantityInputs = document.querySelectorAll('input[type="number"][name="stock[]"]');
const checkedItemsSpan = document.getElementById("checkedItems");
const totalPriceSpan = document.getElementById("totalPrice");

function updateTotals() {
  let checkedItems = 0;
  let totalPrice = 0;

  checkboxes.forEach((checkbox, index) => {
    if (checkbox.checked) {
      checkedItems++;
      const priceCell = checkbox.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling;
      const price = parseFloat(priceCell.textContent);
      const quantity = parseInt(quantityInputs[index].value);
      totalPrice += price * quantity;
    }
  });

  checkedItemsSpan.textContent = `${checkedItems} items checked`;
  totalPriceSpan.textContent = `Total Price: Rp${totalPrice.toFixed(2)}`;
}

checkboxes.forEach((checkbox) => {
  checkbox.addEventListener("change", updateTotals);
});

quantityInputs.forEach((input) => {
  input.addEventListener("input", updateTotals);
});


// Function to generate options for the select element
function generateOptions(start, end, elementId) {
  var selectElement = document.getElementById(elementId);

  for (var i = start; i <= end; i++) {
    var option = document.createElement("option");
    option.value = i;
    option.textContent = i;
    selectElement.appendChild(option);
  }
}

// Call the function to generate options for the date, month, and year select elements
document.addEventListener("DOMContentLoaded", function () {
  // Generate options for the date (1 to 31)
  generateOptions(1, 31, "inputDate");

  // Generate options for the month (January to December)
  var months = [
    "January", "February", "March", "April", "May", "June", "July",
    "August", "September", "October", "November", "December"
  ];
  var monthSelect = document.getElementById("inputMonth");
  months.forEach(function (month, index) {
    var option = document.createElement("option");
    option.value = index + 1;
    option.textContent = month;
    monthSelect.appendChild(option);
  });

  // Generate options for the year (2000 to 2030)
  generateOptions(2020, 2100, "inputYear");
});

// Function to handle the 'Add' action
function addItem() {
  $("#formAddItem").submit()
}

function deleteItem() {
  // Code to add the selected items
  alert("Transaction is deleted successfully!"); // Replace this with your actual 'Add' action
  // Optionally, you can close the modal after the 'Add' action is performed
  $('#confirmationDeleteModal').modal('hide');
}