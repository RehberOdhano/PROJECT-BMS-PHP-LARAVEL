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

const isExpenseTitleValid = (type) => {
  const re = /^[a-zA-Z0-9 ,.'-]+$/i;
  return re.test(type);
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

const addExpenseTitle = (id) => {
  const expenseTitleForm = document.getElementById("expenseTitleForm" + id);
  expenseTitleForm.addEventListener("submit", function (e) {
    // prevent the form from submitting
    e.preventDefault();

    var allInputFieldsValid = true;
    Array.from(expenseTitleForm.elements).forEach((element) => {
      switch (element.id) {
        case "title" + id:
          if (!checkExpenseTitle(element)) {
            allInputFieldsValid = false;
          }
          break;
      }
    });

    var data = {};
    const title = document.getElementById("title" + id).value;
    data.title = title;

    if (allInputFieldsValid) {
      $.ajax({
        url: "/dists/admin/add/expense/title",
        type: "POST",
        data: data,
        success: function (res) {
          console.log("response: " + JSON.stringify(res));
          window.location.href = "/dists/admin/expense/titles";
        },
        error: function (err) {
          console.log(err);
        },
      });
    } else console.log("something went wrong");
  });
};
