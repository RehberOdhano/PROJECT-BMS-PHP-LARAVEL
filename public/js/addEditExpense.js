const checkExpenseTitle = (expenseTitle) => {
  var valid = false;
  const type = expenseTitle.value.trim();
  if (!isRequired(type)) {
    showError(expenseTitle, "Title can't be empty.");
  } else if (!isExpenseTitleValid(type)) {
    showError(
      expenseTitle,
      "Title isn't valid.  It only contains alphabetical characters."
    );
  } else {
    showSuccess(expenseTitle);
    valid = true;
  }
  return valid;
};

const checkExpenseAmount = (expenseAmount) => {
  var valid = false;
  const amount = expenseAmount.value.trim();
  if (!isRequired(amount)) {
    showError(expenseAmount, "Amount can't be empty.");
  } else if (!isExpenseAmountValid(amount)) {
    showError(
      expenseAmount,
      "Amount isn't valid.  It should be a positive decimal numbers like 10.5, 0.5, etc"
    );
  } else {
    showSuccess(expenseAmount);
    valid = true;
  }
  return valid;
};

const checkExpensePurpose = (expensePurpose) => {
  var valid = false;
  const purpose = expensePurpose.value.trim();
  if (!isRequired(purpose)) {
    showError(expensePurpose, "Purpose can't be empty.");
  } else if (!isExpensePurposeValid(purpose)) {
    showError(
      expensePurpose,
      "Purpose isn't valid. It only contains alphabetical characters."
    );
  } else {
    showSuccess(expensePurpose);
    valid = true;
  }
  return valid;
};

const checkExpenseDate = (expenseDate) => {
  var valid = false;
  const date = expenseDate.value.trim();
  if (!isRequired(date)) {
    showError(expenseDate, "Date can't be empty.");
  } else {
    showSuccess(expenseDate);
    valid = true;
  }
  return valid;
};

const isExpenseTitleValid = (type) => {
  const re = /^[a-zA-Z0-9 ,.'-]+$/i;
  return re.test(type);
};

const isExpensePurposeValid = (type) => {
  const re = /^[a-zA-Z0-9 ,.'-]+$/i;
  return re.test(type);
};

const isExpenseAmountValid = (amount) => {
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

const submitExpenseForm = (id) => {
  const expenseForm = document.getElementById("expenseForm" + id);
  expenseForm.addEventListener("submit", function (e) {
    // prevent the form from submitting
    e.preventDefault();

    var allInputFieldsValid = true;
    Array.from(expenseForm.elements).forEach((element) => {
      switch (element.id) {
        case "title" + id:
          if (!checkExpenseTitle(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "amount" + id:
          if (!checkExpenseAmount(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "purpose" + id:
          if (!checkExpensePurpose(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "date" + id:
          if (!checkExpenseDate(element)) {
            allInputFieldsValid = false;
          }
          break;
      }
    });

    if (allInputFieldsValid) {
      $("#expenseForm" + id).submit();
    } else console.log("something went wrong");
  });
};
