const checkSupplierName = (supplier_name) => {
  let valid = false;
  const checkName = supplier_name.value.trim();
  if (!isRequired(checkName)) {
    showError(supplier_name, "Name can't be empty.");
  } else if (!isSupplierNameValid(checkName)) {
    showError(
      supplier_name,
      "Name is not valid. Name contains at least 3 characters, lowercase and upper case letters."
    );
  } else {
    showSuccess(supplier_name);
    valid = true;
  }
  return valid;
};

const checkSupplierContact = (supplier_contact) => {
  let valid = false;
  const checkContact = supplier_contact.value.trim();
  if (!isRequired(checkContact)) {
    showError(supplier_contact, "Contact can't be empty.");
  } else if (!isSupplierContactValid(checkContact)) {
    showError(
      supplier_contact,
      "Contact is not valid. It should be in the format 03301234567"
    );
  } else {
    showSuccess(supplier_contact);
    valid = true;
  }
  return valid;
};

const checkSupplierAddress = (supplier_address) => {
  let valid = false;
  const checkAddress = supplier_address.value.trim();
  if (!isRequired(checkAddress)) {
    showError(supplier_address, "Address can't be empty.");
  } else if (!isSupplierAddressValid(checkAddress)) {
    showError(
      supplier_address,
      "Address is not valid. Address contains digits, lowercase and upper case letters."
    );
  } else {
    showSuccess(supplier_address);
    valid = true;
  }
  return valid;
};

const checkSupplierJoinDate = (joinDate) => {
  let valid = false;
  const checkJoinDate = joinDate.value.trim();
  if (!isRequired(checkJoinDate)) {
    showError(joinDate, "Date can't be empty.");
  } else {
    showSuccess(joinDate);
    valid = true;
  }
  return valid;
};

const isSupplierNameValid = (name) => {
  const re = /[a-zA-Z0-9_ \.'-]$/i;
  return re.test(name);
};

const isSupplierContactValid = (contact) => {
  const re = /^[0-9]{11}$/;
  return re.test(contact);
};

const isSupplierAddressValid = (address) => {
  const re = /^[a-zA-Z0-9\s,.'-]*$/gm;
  return re.test(address);
};

// const isSupplierJoinDateValid = (date) => {
//     const re = /[a-zA-Z]{3,10}$/i;
//     return re.test(date);
// };

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

const submitSupplierForm = (id) => {
  const supplierForm = document.getElementById("supplierForm" + id);
  supplierForm.addEventListener("submit", function (e) {
    // prevent the form from submitting
    e.preventDefault();

    var allInputFieldsValid = true;
    Array.from(supplierForm.elements).forEach((element) => {
      switch (element.id) {
        case "name" + id:
          if (!checkSupplierName(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "address" + id:
          if (!checkSupplierAddress(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "contact" + id:
          if (!checkSupplierContact(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "date" + id:
          if (!checkSupplierJoinDate(element)) {
            allInputFieldsValid = false;
          }
          break;
      }
    });

    if (allInputFieldsValid) {
      $("#supplierForm" + id).submit();
    } else console.log("something went wrong");
  });
};
