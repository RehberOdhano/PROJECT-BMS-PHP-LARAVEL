"use strict";

const checkDistAdminName = (name) => {
  let valid = false;
  const checkAdminName = name.value.trim();
  if (!isFieldRequired(checkAdminName)) {
    showErrorMessage(name, "Name cannot be blank.");
  } else if (!isAdminNameValid(checkAdminName)) {
    showErrorMessage(name, "Name is not valid.");
  } else {
    showSuccessMessage(name);
    valid = true;
  }
  return valid;
};

const checkDistAdminEmail = (email) => {
  let valid = false;
  const checkEmail = email.value.trim();
  if (!isFieldRequired(checkEmail)) {
    showErrorMessage(email, "Email cannot be blank.");
  } else if (!isDistAdminEmailValid(checkEmail)) {
    showErrorMessage(
      email,
      "Email is not valid. It should be in the format: hello@example.com"
    );
  } else {
    showSuccessMessage(email);
    valid = true;
  }
  return valid;
};

const checkDistAdminPassword = (password) => {
  let valid = false;

  const newPassword = password.value.trim();

  if (!isFieldRequired(newPassword)) {
    showErrorMessage(password, "Password cannot be blank.");
  } else if (!isDistAdminPasswordSecure(newPassword)) {
    showErrorMessage(
      password,
      "Password must has at least 8 characters that include at least 1 lowercase character, 1 uppercase characters, 1 number, and 1 special character in (!@#$%^&*)"
    );
  } else {
    showSuccessMessage(password);
    valid = true;
  }

  return valid;
};

const checkConfirmPassword = (confirmPassword, id) => {
  let valid = false;
  const password = document.getElementById("password" + id).value.trim();
  const checkConfirmPassword = confirmPassword.value.trim();
  if (!isFieldRequired(checkConfirmPassword)) {
    showErrorMessage(confirmPassword, "Confirm password cannot be blank.");
  } else if (!isDistAdminPasswordSecure(checkConfirmPassword)) {
    showErrorMessage(
      confirmPassword,
      "Confirm password must has at least 8 characters that include at least 1 lowercase character, 1 uppercase characters, 1 number, and 1 special character in (!@#$%^&*)"
    );
  } else {
    if (password == checkConfirmPassword) {
      showSuccessMessage(confirmPassword);
      valid = true;
    } else {
      showErrorMessage(
        confirmPassword,
        "New Password and Confirm Password must be the same."
      );
    }
  }
  return valid;
};

const checkDistAdminContact = (contact) => {
  let valid = false;

  const checkContact = contact.value.trim();

  if (!isFieldRequired(checkContact)) {
    showErrorMessage(contact, "Contact cannot be blank.");
  } else if (!isDistAdminContactValid(checkContact)) {
    showErrorMessage(
      contact,
      "Contact is not valid. It should be in the format: 03301293789"
    );
  } else {
    showSuccessMessage(contact);
    valid = true;
  }

  return valid;
};

const checkDistAdminCity = (city) => {
  let valid = false;

  const checkCity = city.value.trim();

  if (!isFieldRequired(checkCity)) {
    showErrorMessage(city, "City cannot be blank.");
  } else if (!isDistAdminCityValid(checkCity)) {
    showErrorMessage(
      city,
      "City is not valid. City contains only uppercase, lowercase letters and comma. Format: Islamabad or Islamabad, Pakistan"
    );
  } else {
    showSuccessMessage(city);
    valid = true;
  }

  return valid;
};

const isAdminNameValid = (name) => {
  const re = /^[a-zA-Z_ ]*$/gm;
  return re.test(name);
};

const isDistAdminEmailValid = (email) => {
  const re = /^([a-z0-9\.-]+)@([a-z0-9-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/;
  return re.test(email);
};

const isDistAdminPasswordSecure = (password) => {
  const re = new RegExp(
    "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\\$%\\^&\\*])(?=.{5,})"
  );
  return re.test(password);
};

const isDistAdminContactValid = (contact) => {
  const re = /^[0-9]{11}$/;
  return re.test(contact);
};

const isDistAdminCityValid = (city) => {
  const re = /^[a-zA-Z,]+(?:[\s-][a-zA-Z]+)*$/gm;
  return re.test(city);
};

const isFieldRequired = (value) => (value === "" ? false : true);

const showErrorMessage = (input, message) => {
  const formField = input.parentElement;
  input.classList.remove("success");
  input.classList.add("error");
  const error = formField.querySelector("small");
  error.classList.remove("successmsg");
  error.classList.add("errormsg");
  error.textContent = message;
};

const showSuccessMessage = (input) => {
  const formField = input.parentElement;
  input.classList.remove("error");
  input.classList.add("success");
  const error = formField.querySelector("small");
  error.classList.remove("errormsg");
  error.classList.add("successmsg");
  error.textContent = "";
};

const submitAdminForm = (id) => {
  const addDistAdminForm = document.getElementById("distAdminForm" + id);
  addDistAdminForm.addEventListener("submit", function (e) {
    // prevent the form from submitting
    e.preventDefault();

    var allInputFieldsValid = true;
    Array.from(addDistAdminForm.elements).forEach((element) => {
      switch (element.id) {
        case "admin" + id:
          if (!checkDistAdminEmail(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "name" + id:
          if (!checkDistAdminName(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "email" + id:
          if (!checkDistAdminEmail(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "password" + id:
          if (!checkDistAdminPassword(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "confirm_pass" + id:
          if (!checkConfirmPassword(element, id)) {
            allInputFieldsValid = false;
          }
          break;
        case "contact" + id:
          if (!checkDistAdminContact(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "city" + id:
          if (!checkDistAdminCity(element)) {
            allInputFieldsValid = false;
          }
          break;
      }
    });

    if (allInputFieldsValid) {
      $("#distAdminForm" + id).submit();
    } else console.log("something went wrong");
  });
};
