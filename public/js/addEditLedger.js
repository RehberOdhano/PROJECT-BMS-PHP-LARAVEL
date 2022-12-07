const checkDescription = (description) => {
  var valid = false;
  const ledgerDescription = description.value.trim();
  if (!isRequired(ledgerDescription)) {
    showError(description, "Description can't be empty.");
  } else if (!isValidLedgerDescription(ledgerDescription)) {
    showError(
      description,
      "Description isn't valid. It only contains alphabetical characters."
    );
  } else {
    showSuccess(description);
    valid = true;
  }
  return valid;
};

const checkPaymentMethod = (pay_method) => {
  var valid = false;
  const paymentMethod = pay_method.value.trim();
  if (!isRequired(paymentMethod)) {
    showError(pay_method, "Payment method can't be empty.");
  } else if (!isValidLedgerPayMethod(paymentMethod)) {
    showError(
      pay_method,
      "Payment method isn't valid. It only contains alphabetical characters."
    );
  } else {
    showSuccess(pay_method);
    valid = true;
  }
  return valid;
};

const checkLedgerTotalAmount = (In) => {
  var valid = false;
  const checkAmountIn = In.value.trim();
  if (!isRequired(checkAmountIn)) {
    showError(In, "In Amount can't be empty.");
  } else if (!isAmountValid(checkAmountIn)) {
    showError(
      In,
      "In Amount method isn't valid. It only contains positive decimal numbers like 10.5, 0.5, etc"
    );
  } else {
    showSuccess(In);
    valid = true;
  }
  return valid;
};

const checkLedgerAmountDue = (In) => {
  var valid = false;
  const checkAmountIn = In.value.trim();
  if (!isRequired(checkAmountIn)) {
    showError(In, "In Amount can't be empty.");
  } else if (!isAmountValid(checkAmountIn)) {
    showError(
      In,
      "In Amount method isn't valid. It only contains positive decimal numbers like 10.5, 0.5, etc"
    );
  } else {
    showSuccess(In);
    valid = true;
  }
  return valid;
};

const checkLedgerAmountPaid = (amountPaid) => {
  let valid = false;
  var id = amountPaid.id.match(/[0-9]/g).join("");
  const totalAmount = document.getElementById("totalAmount" + id).value.trim();
  const amountReceived = amountPaid.value.trim();
  if (!isRequired(amountReceived)) {
    showError(amountPaid, "Received amount cannot be blank.");
  } else if (parseFloat(amountReceived) > parseFloat(totalAmount)) {
    showError(amountPaid, "Amount paid can't be bigger than the total amount!");
  } else if (!isAmountValid(amountReceived)) {
    showError(amountPaid, "Received amount is not valid.");
  } else {
    showSuccess(amountPaid);
    valid = true;
  }
  return valid;
};

const checkDate = (date) => {
  var valid = false;
  const Date = date.value.trim();
  if (!isRequired(Date)) {
    showError(date, "Date can't be empty.");
  } else {
    showSuccess(date);
    valid = true;
  }
  return valid;
};

const isValidLedgerDescription = (ledgerDescription) => {
  const re = /^[a-zA-z ,.'-]+$/i;
  return re.test(ledgerDescription);
};

const isValidLedgerPayMethod = (paymentMethod) => {
  const re = /^[a-zA-Z_ ]*$/;
  return re.test(paymentMethod);
};

const isAmountValid = (amount) => {
  const re = /^(?!(?:\.0+)?$)[0-9]+(?:\.[0-9]+)?$/gm;
  return re.test(amount);
};

const isRequired = (value) => (value === "" ? false : true);

const showError = (input, message) => {
  const formField = input.parentElement;
  input.classList.remove("success");
  input.classList.add("error");
  const error = formField.querySelector("small");
  error.classList.remove("successmsg");
  error.classList.add("errormsg");
  error.textContent = message;
};

const showSuccess = (input) => {
  const formField = input.parentElement;
  input.classList.remove("error");
  input.classList.add("success");
  const error = formField.querySelector("small");
  error.classList.remove("errormsg");
  error.classList.add("successmsg");
  error.textContent = "";
};

const submitLedgerForm = (id) => {
  const ledgerForm = document.getElementById("ledgerForm" + id);
  ledgerForm.addEventListener("submit", function (e) {
    // prevent the form from submitting
    e.preventDefault();

    var allInputFieldsValid = true;
    Array.from(ledgerForm.elements).forEach((element) => {
      switch (element.id) {
        case "description" + id:
          if (!checkDescription(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "pay_method" + id:
          if (!checkPaymentMethod(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "totalAmount" + id:
          if (!checkLedgerTotalAmount(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "amountDue" + id:
          if (!checkLedgerAmountDue(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "amountPaid" + id:
          if (!checkLedgerAmountPaid(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "date" + id:
          if (!checkDate(element)) {
            allInputFieldsValid = false;
          }
          break;
      }
    });

    if (allInputFieldsValid) {
      document.getElementById("totalAmount" + id).disabled = false;
      document.getElementById("dueAmount" + id).disabled = false;
      $("#ledgerForm" + id).submit();
    } else console.log("something went wrong");
  });
};

function calcDueAmount(element) {
  const amountPaid = element.value;
  var id = element.id.match(/[0-9]/g).join("");
  const totalAmount = document.getElementById("totalAmount" + id).value.trim();
  const amountDue = document.getElementById("dueAmount" + id);
  amountDue.value = parseFloat(totalAmount) - parseFloat(amountPaid);
}
