const checkFlavorName = (flavor_name) => {
  let valid = false;
  const checkName = flavor_name.value.trim();
  if (!isRequired(checkName)) {
    showError(flavor_name, "Flavor name cannot be empty.");
  } else if (!isFlavorNameValid(checkName)) {
    showError(
      flavor_name,
      "Flavor name is not valid. Name contains at least 4 characters, lowercase and upper case letters."
    );
  } else {
    showSuccess(flavor_name);
    valid = true;
  }
  return valid;
};

const isFlavorNameValid = (name) => {
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

const submitFlavorForm = (id) => {
  const flavorForm = document.getElementById("flavorForm" + id);
  flavorForm.addEventListener("submit", function (e) {
    // prevent the form from submitting
    e.preventDefault();

    var allInputFieldsValid = true;
    Array.from(flavorForm.elements).forEach((element) => {
      switch (element.id) {
        case "name" + id:
          if (!checkFlavorName(element)) {
            allInputFieldsValid = false;
          }
          break;
      }
    });

    if (allInputFieldsValid) {
      $("#flavorForm" + id).submit();
    } else console.log("something went wrong");
  });
};

function delete_row(del_btn) {
  const parent = del_btn.parentNode.parentNode.parentNode.parentNode;
  const id = "#" + parent.id;
  $(id).remove();
}
