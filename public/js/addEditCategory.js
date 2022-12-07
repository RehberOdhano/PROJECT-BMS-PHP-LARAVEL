const checkCategoryName = (categoryName) => {
  var valid = false;
  const category = categoryName.value.trim();
  if (!isRequired(category)) {
    showError(categoryName, "Category name can't be empty");
  } else if (!isCategoryNameValid(category)) {
    showError(
      categoryName,
      "Category name isn't valid. Category name contains at least 5 characters, lowercase and upper case letters."
    );
  } else {
    showSuccess(categoryName);
    valid = true;
  }
  return valid;
};

const isCategoryNameValid = (name) => {
  const re = /[a-zA-Z0-9_ ]{1,}$/i;
  return re.test(name);
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

const submitCategoryForm = (id) => {
  const categoryForm = document.getElementById("categoryForm" + id);
  categoryForm.addEventListener("submit", function (e) {
    // prevent the form from submitting
    e.preventDefault();

    var allInputFieldsValid = true;
    Array.from(categoryForm.elements).forEach((element) => {
      switch (element.id) {
        case "name" + id:
          if (!checkCategoryName(element)) {
            allInputFieldsValid = false;
          }
          break;
      }
    });

    if (allInputFieldsValid) {
      $("#categoryForm" + id).submit();
    } else console.log("something went wrong");
  });
};

function delete_row(del_btn) {
  const parent = del_btn.parentNode.parentNode.parentNode.parentNode;
  const id = "#" + parent.id;
  $(id).remove();
}
