const checkOutletName = (name) => {
  let valid = false;
  const checkName = name.value.trim();
  if (!isRequired(checkName)) {
    showError(name, "Name cannot be empty.");
  } else if (!isOutletNameValid(checkName)) {
    showError(
      name,
      "Name is not valid. Name contains only lowercase and upper case letters."
    );
  } else {
    showSuccess(name);
    valid = true;
  }
  return valid;
};

const checkOutletAddress = (address) => {
  let valid = false;
  const checkAddress = address.value.trim();
  if (!isRequired(checkAddress)) {
    showError(address, "Address cannot be empty.");
  } else if (!isOutletAddressValid(checkAddress)) {
    showError(
      address,
      "Address is not valid. Address contains digits, lowercase and upper case letters."
    );
  } else {
    showSuccess(address);
    valid = true;
  }
  return valid;
};

const checkOutletContact = (contact) => {
  let valid = false;
  const checkContact = contact.value.trim();
  if (!isRequired(checkContact)) {
    showError(contact, "Contact cannot be empty.");
  } else if (!isOutletContactValid(checkContact)) {
    showError(
      contact,
      "Contact is not valid. It should be in the format: 03301293789"
    );
  } else {
    showSuccess(contact);
    valid = true;
  }
  return valid;
};

const checkOutletRoute = (route) => {
  let valid = false;
  const checkRoute = route.value.trim();
  if (!isRequired(checkRoute)) {
    showError(route, "Route cannot be empty.");
  } else if (!isOutletAddressValid(checkRoute)) {
    showError(
      route,
      "Route is not valid. Route contains digits, lowercase and upper case letters."
    );
  } else {
    showSuccess(route);
    valid = true;
  }
  return valid;
};

const checkOutletDate = (date) => {
  let valid = false;
  const checkJoinDate = date.value.trim();
  if (!isRequired(checkJoinDate)) {
    showError(date, "Date cannot be empty.");
  } else {
    showSuccess(date);
    valid = true;
  }
  return valid;
};

const isOutletNameValid = (name) => {
  const re = /^[a-zA-Z0-9_ \.'-]+$/i;
  return re.test(name);
};

const isOutletAddressValid = (address) => {
  const re = /^[a-zA-Z0-9\s,.'-]*$/gm;
  return re.test(address);
};

const isOutletContactValid = (contact) => {
  const re = /^[0-9]{11}$/;
  return re.test(contact);
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

const submitOutletForm = (id) => {
  const outletForm = document.getElementById("outletForm" + id);
  outletForm.addEventListener("submit", function (e) {
    // prevent the form from submitting
    e.preventDefault();

    var allInputFieldsValid = true;
    Array.from(outletForm.elements).forEach((element) => {
      switch (element.id) {
        case "name" + id:
          if (!checkOutletName(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "route" + id:
          if (!checkOutletRoute(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "contact" + id:
          if (!checkOutletContact(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "address" + id:
          if (!checkOutletAddress(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "date" + id:
          if (!checkOutletDate(element)) {
            allInputFieldsValid = false;
          }
          break;
      }
    });

    if (allInputFieldsValid) {
      $("#outletForm" + id).submit();
    } else console.log("something went wrong");
  });
};
