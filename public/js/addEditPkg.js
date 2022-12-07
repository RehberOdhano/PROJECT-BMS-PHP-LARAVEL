const checkPkgType = (pkgType) => {
  let valid = false;
  const checkType = pkgType.value.trim();
  if (!isInputFieldRequired(checkType)) {
    displayError(pkgType, "Package type can't be empty.");
  } else if (!validatePkgType(checkType)) {
    displayError(pkgType, "Package type is not valid.");
  } else {
    displaySuccess(pkgType);
    valid = true;
  }
  return valid;
};

const checkPkgSize = (pkgSize) => {
  let valid = false;
  const checkSize = pkgSize.value.trim();
  if (!isInputFieldRequired(checkSize)) {
    displayError(pkgSize, "Package size can't be empty.");
  } else if (!validatePkgSize(checkSize)) {
    displayError(
      pkgSize,
      "Package size is not valid. It should be a positive decimal number like 1.5, 0.5, 15, etc"
    );
  } else {
    displaySuccess(pkgSize);
    valid = true;
  }
  return valid;
};

const checkPkgName = (pkgName) => {
  let valid = false;
  const checkName = pkgName.value.trim();
  if (!isInputFieldRequired(checkName)) {
    displayError(pkgName, "Package name cannot be blank.");
  } else if (!validatePkgName(checkName)) {
    displayError(pkgName, "Package name is not valid.");
  } else {
    displaySuccess(pkgName);
    valid = true;
  }
  return valid;
};

const checkPkgDiscount = (pkgDiscount) => {
  let valid = false;
  const checkRegDiscount = pkgDiscount.value.trim();
  if (!isInputFieldRequired(checkRegDiscount)) {
    displayError(pkgDiscount, "Regular discont can't be empty.");
  } else if (!validateRegDiscount(checkRegDiscount)) {
    displayError(
      pkgDiscount,
      "Regular discont is not valid. It should be a positive decimal number like 1.5, 0.5, 15, etc"
    );
  } else {
    displaySuccess(pkgDiscount);
    valid = true;
  }
  return valid;
};

const checkCategoryName = (categoryName) => {
  var valid = false;
  const category = categoryName.value.trim();
  if (!isInputFieldRequired(category)) {
    displayError(categoryName, "Category name can't be empty");
  } else if (!isCategoryNameValid(category)) {
    displayError(
      categoryName,
      "Category name isn't valid. Category name contains at least 5 characters, lowercase and upper case letters."
    );
  } else {
    displaySuccess(categoryName);
    valid = true;
  }
  return valid;
};

const checkFlavorName = (flavor_name) => {
  let valid = false;
  const checkName = flavor_name.value.trim();
  if (!isInputFieldRequired(checkName)) {
    displayError(flavor_name, "Flavor name cannot be empty.");
  } else if (!isFlavorNameValid(checkName)) {
    displayError(
      flavor_name,
      "Flavor name is not valid. Name contains at least 4 characters, lowercase and upper case letters."
    );
  } else {
    displaySuccess(flavor_name);
    valid = true;
  }
  return valid;
};

const isFlavorNameValid = (name) => {
  const re = /[a-zA-Z0-9_ ]{1,}$/i;
  return re.test(name);
};

const isCategoryNameValid = (name) => {
  const re = /[a-zA-Z0-9_ ]{1,}$/i;
  return re.test(name);
};

const validatePkgType = (pkg_type) => {
  const re = /[a-zA-Z]$/i;
  return re.test(pkg_type);
};

const validatePkgSize = (pkg_size) => {
  // const re = /(\d+(?:\.\d+)?)\s?(L|ML)\b/i;
  const re = /^[+]?\d+([.]\d+)?$/gm;
  return re.test(pkg_size);
};

const validatePkgName = (name) => {
  const re = /[a-zA-Z0-9_ \.'-]$/i;
  return re.test(name);
};

const validateRegDiscount = (reg_discount) => {
  const re = /^[+]?\d+([.]\d+)?$/gm;
  return re.test(reg_discount);
};

const isInputFieldRequired = (value) => (value === "" ? false : true);

const displayError = (input, message) => {
  const formField = input.parentElement;
  input.classList.remove("success");
  input.classList.add("error");
  const error = formField.querySelector("small");
  error.classList.remove("successmsg");
  error.classList.add("errormsg");
  error.textContent = message;
};

const displaySuccess = (input) => {
  const formField = input.parentElement;
  input.classList.remove("error");
  input.classList.add("success");
  const error = formField.querySelector("small");
  error.classList.remove("errormsg");
  error.classList.add("successmsg");
  error.textContent = "";
};

const submitPkgForm = (id) => {
  const pkgForm = document.getElementById("pkgForm" + id);
  pkgForm.addEventListener("submit", function (e) {
    // prevent the form from submitting
    e.preventDefault();

    var allInputFieldsValid = true;
    Array.from(pkgForm.elements).forEach((element) => {
      switch (element.id) {
        case "pkgType" + id:
          if (!checkPkgType(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "pkgSize" + id:
          if (!checkPkgSize(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "pkgName" + id:
          if (!checkPkgName(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "flavor" + id:
          if (!checkFlavorName(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "category" + id:
          if (!checkCategoryName(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "pkgName" + id:
          if (!checkPkgName(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "regDiscount" + id:
          if (!checkPkgDiscount(element)) {
            allInputFieldsValid = false;
          }
          break;
      }
    });

    if (allInputFieldsValid) {
      $("#pkgForm" + id).submit();
    } else console.log("something went wrong");
  });
};
