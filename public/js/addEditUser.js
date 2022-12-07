const checkUserName = (username) => {
  let valid = false;
  const checkUserFullName = username.value.trim();
  if (!isFieldRequired(checkUserFullName)) {
    showErrorMessage(username, "Name cannot be empty.");
  } else if (!isUserNameValid(checkUserFullName)) {
    showErrorMessage(username, "Name is not valid.");
  } else {
    showSuccessMessage(username);
    valid = true;
  }
  return valid;
};

const checkUserEmail = (useremail) => {
  let valid = false;
  const checkEmail = useremail.value.trim();
  if (!isFieldRequired(checkEmail)) {
    showErrorMessage(useremail, "Email cannot be empty.");
  } else if (!isUserEmailValid(checkEmail)) {
    showErrorMessage(useremail, "Email is not valid.");
  } else {
    showSuccessMessage(useremail);
    valid = true;
  }
  return valid;
};

const checkUserPassword = (password) => {
  let valid = false;
  const checkPassword = password.value.trim();
  if (!isFieldRequired(checkPassword)) {
    showErrorMessage(password, "Password cannot be empty.");
  } else if (!isPasswordSecure(checkPassword)) {
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
  } else if (!isPasswordSecure(checkConfirmPassword)) {
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

const checkUserContact = (usercontact) => {
  let valid = false;
  const checkContact = usercontact.value.trim();
  if (!isFieldRequired(checkContact)) {
    showErrorMessage(usercontact, "Contact cannot be empty.");
  } else if (!isUserContactValid(checkContact)) {
    showErrorMessage(
      usercontact,
      "Contact is not valid. It should be in the format +92 330 1234567"
    );
  } else {
    showSuccessMessage(usercontact);
    valid = true;
  }

  return valid;
};

const checkUserCity = (usercity) => {
  let valid = true;
  const checkCity = usercity.value.trim();

  if (!isFieldRequired(checkCity)) {
    showErrorMessage(usercity, "City cannot be empty.");
  } else if (!isUserCityValid(checkCity)) {
    showErrorMessage(
      usercity,
      "City is not valid. City contains only uppercase, lowercase letters and comma. Format: Islamabad, Pakistan"
    );
  } else {
    showSuccessMessage(usercity);
    valid = true;
  }

  return valid;
};

const isUserNameValid = (name) => {
  const re = /^[a-zA-Z\s]*$/i;
  return re.test(name);
};

const isUserEmailValid = (email) => {
  const re = /^([a-z0-9\.-]+)@([a-z0-9-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/;
  return re.test(email);
};

const isPasswordSecure = (password) => {
  const re = new RegExp(
    "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\\$%\\^&\\*])(?=.{5,})"
  );
  return re.test(password);
};

const isUserContactValid = (contact) => {
  const re = /^[0-9]{11}$/;
  return re.test(contact);
};

const isUserCityValid = (city) => {
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

const submitUserForm = (id) => {
  const userForm = document.getElementById("userForm" + id);
  userForm.addEventListener("submit", function (e) {
    // prevent the form from submitting
    e.preventDefault();

    var allInputFieldsValid = true;
    Array.from(userForm.elements).forEach((element) => {
      switch (element.id) {
        case "username" + id:
          if (!checkUserName(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "email" + id:
          if (!checkUserEmail(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "password" + id:
          if (!checkUserPassword(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "confirmPass" + id:
          if (!checkConfirmPassword(element, id)) {
            allInputFieldsValid = false;
          }
          break;
        case "contact" + id:
          if (!checkUserContact(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "city" + id:
          if (!checkUserCity(element)) {
            allInputFieldsValid = false;
          }
          break;
      }
    });

    if (allInputFieldsValid) {
      $("#userForm" + id).submit();
    } else console.log("something went wrong");
  });
};
