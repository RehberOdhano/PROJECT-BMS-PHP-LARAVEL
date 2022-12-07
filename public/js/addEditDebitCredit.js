const checkDescription = (description) => {
  let valid = false;
  const checkDescript = description.value.trim();
  if (!isRequired(checkDescript)) {
    showError(description, "Description cannot be empty.");
  } else if (!isValid(checkDescript)) {
    showError(
      description,
      "Description is not valid. It should contains only lowercase and upper case letters and (,.-)."
    );
  } else {
    showSuccess(description);
    valid = true;
  }
  return valid;
};

const checkDebit = (debit, id) => {
  let valid = false;

  const checkDebitAmount = debit.value.trim();
  if (!isValidAmount(checkDebitAmount)) {
    showError(
      debit,
      "Debit is not valid. It should be positive number like 200, etc"
    );
  } else {
    showSuccess(debit);
    valid = true;
  }
  return valid;
};

const checkCredit = (credit, id) => {
  let valid = false;

  const checkCreditAmount = credit.value.trim();
  if (!isValidAmount(checkCreditAmount)) {
    showError(
      credit,
      "Credit is not valid. It should be a positive number like 500, etc"
    );
  } else {
    showSuccess(credit);
    valid = true;
  }

  return valid;
};

const checkDebitCreditAmount = (amount, id) => {
  let valid = false;

  const checkAmount = amount.value.trim();
  if (!isValidAmount(checkAmount)) {
    showError(
      amount,
      "Amount is not valid. It should be a positive number like 500, etc"
    );
  } else {
    showSuccess(amount);
    valid = true;
  }

  return valid;
};

const checkBalance = (balance) => {
  let valid = false;

  const checkTotalBalance = balance.value.trim();

  if (!isRequired(checkTotalBalance)) {
    showError(balance, "Balance cannot be empty.");
  } else if (!isValidAmount(checkTotalBalance)) {
    showError(
      balance,
      "Balance is not valid. It should be a positive number like 100."
    );
  } else {
    showSuccess(balance);
    valid = true;
  }

  return valid;
};

const checkDate = (date) => {
  let valid = false;

  const checkDate = date.value.trim();

  if (!isRequired(checkDate)) {
    showError(date, "Date cannot be empty.");
  } else {
    showSuccess(date);
    valid = true;
  }

  return valid;
};

const isValid = (input) => {
  const re = /^[a-zA-Z0-9_ \.'-]*$/gm;
  return re.test(input);
};

const isChecked = (element, id) => {
  const debit = document.getElementById("debit-radio" + id);
  const credit = document.getElementById("credit-radio" + id);
  if (debit.checked || credit.checked) {
    showSuccess(element);
    return true;
  } else {
    showError(element, "Choose one of the option");
    return false;
  }
};

// const isDateValid = (date) => {
//     const re = "";
//     return re.test(date);
// }

const isValidAmount = (salary) => {
  const re = /^(?!0+(?:\.0+)?$)[0-9]+(?:\.[0-9]+)?$/gm;
  return re.test(salary);
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

const submitDebitCreditForm = (id) => {
  const debitCreditForm = document.getElementById("debitCreditForm" + id);
  debitCreditForm.addEventListener("submit", function (e) {
    // prevent the form from submitting
    e.preventDefault();

    var allInputFieldsValid = true;
    Array.from(debitCreditForm.elements).forEach((element) => {
      switch (element.id) {
        case "description" + id:
          if (!checkDescription(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "debit" + id:
          if (!checkDebitCreditAmount(element, id)) {
            allInputFieldsValid = false;
          }
          break;
        case "credit" + id:
          if (!checkDebitCreditAmount(element, id)) {
            allInputFieldsValid = false;
          }
          break;
        case "debit-radio" + id:
          if (!isChecked(element, id)) {
            allInputFieldsValid = false;
          }
          break;
        case "credit-radio" + id:
          if (!isChecked(element, id)) {
            allInputFieldsValid = false;
          }
          break;
        case "newInput" + id:
          if (!checkDebitCreditAmount(element, id)) {
            allInputFieldsValid = false;
          }
          break;
        case "date" + id:
          if (!checkDate(element)) {
            allInputFieldsValid = false;
          }
          break;
        // case "balance" + id:
        //     if(!checkBalance(element)) {
        //         allInputFieldsValid = false;
        //     }
        //     break;
      }
    });

    if (allInputFieldsValid) {
      $("#debitCreditForm" + id).submit();
    } else console.log("something went wrong");
  });
};

function showInput(element, id) {
  const parent = document.getElementById("debitCreditInput" + id);
  const small = element.parentElement.querySelector("small");
  if (small.classList.contains("errormsg")) {
    small.classList.remove("errormsg");
    small.textContent = "";
  }
  const input = parent.childNodes[1];
  input.style.display = "inline-block";
  input.setAttribute("name", element.id.split("-")[0]);
  input.setAttribute("id", "newInput" + id);
}
