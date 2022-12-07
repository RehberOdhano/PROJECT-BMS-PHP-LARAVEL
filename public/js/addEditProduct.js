const checkProductCode = (productCode) => {
  let valid = false;
  const checkCode = productCode.value.trim();
  if (!isInputFieldRequired(checkCode)) {
    displayError(productCode, "Product code cannot be blank.");
  } else if (!validateProductCode(checkCode)) {
    displayError(
      productCode,
      "Product code is not valid. It should be in the format: 11AB, 110, 11ab, etc"
    );
  } else {
    displaySuccess(productCode);
    valid = true;
  }
  return valid;
};

const checkProductName = (productName) => {
  let valid = false;
  const checkName = productName.value.trim();
  if (!isInputFieldRequired(checkName)) {
    displayError(productName, "Product name cannot be blank.");
  } else if (!validateProductName(checkName)) {
    displayError(productName, "Product name is not valid.");
  } else {
    displaySuccess(productName);
    valid = true;
  }
  return valid;
};

const checkQuantity = (quantity) => {
  let valid = false;
  const checkStockQuantity = quantity.value.trim();
  if (!isInputFieldRequired(checkStockQuantity)) {
    displayError(quantity, "Quantity cannot be blank.");
  } else if (!validateQuantity(checkStockQuantity)) {
    displayError(
      quantity,
      "Quantity is not valid. It should be positive whole number."
    );
  } else {
    displaySuccess(quantity);
    valid = true;
  }
  return valid;
};

const checkPackageSize = (pkgSize) => {
  let valid = false;
  const checkPkgSize = pkgSize.value.trim();
  if (!isInputFieldRequired(checkPkgSize)) {
    displayError(pkgSize, "Package size cannot be blank.");
  } else if (!validatePkgSize(checkPkgSize)) {
    displayError(
      pkgSize,
      "Package size is not valid. It should be a positive decimal number like 1.5, 15, etc"
    );
  } else {
    displaySuccess(pkgSize);
    valid = true;
  }
  return valid;
};

const checkAdvanceIncomeTax = (advanceTax) => {
  let valid = false;
  const checkIncomeTax = advanceTax.value.trim();
  if (!isInputFieldRequired(checkIncomeTax)) {
    displayError(advanceTax, "Advance Income Tax cannot be blank.");
  } else if (!validateIncomeTax(checkIncomeTax)) {
    displayError(
      advanceTax,
      "Advance Income Tax is not valid. It should be a positive decimal number like: 5, 0.5, etc"
    );
  } else {
    displaySuccess(advanceTax);
    valid = true;
  }
  return valid;
};

const checkUnitPrice = (unitPrice) => {
  let valid = false;
  const checkPrice = unitPrice.value.trim();
  if (!isInputFieldRequired(checkPrice)) {
    displayError(unitPrice, "Unit price cannot be blank.");
  } else if (!validateUnitPrice(checkPrice)) {
    displayError(
      unitPrice,
      "Unit price is not valid. It should be a positive decimal number like: 15, 10.5, etc"
    );
  } else {
    displaySuccess(unitPrice);
    valid = true;
  }
  return valid;
};

const checkPkgType = (pkgType, id) => {
  let valid = false;
  const checkType = pkgType.value.trim();
  if (!isInputFieldRequired(checkType)) {
    displayError(pkgType, "Package type can't be empty.");
  } else if (!validatePkgType(checkType)) {
    displayError(pkgType, "Package type is not valid.");
  } else {
    displaySuccess(pkgType);
    valid = true;
    // addUnitPrice(id);
  }
  return valid;
};

const checkPkgName = (pkgName) => {
  let valid = false;
  if (pkgName.value != "Package Names") {
    valid = true;
    displaySuccess(pkgName);
  } else {
    displayError(pkgName, "Package name can't be empty.");
  }
  return valid;
};

const checkCategoryName = (categoryName) => {
  var valid = false;
  if (categoryName.value != "Category") {
    displaySuccess(categoryName);
    valid = true;
  } else {
    displayError(categoryName, "Category name can't be empty");
  }
  return valid;
};

const checkFlavorName = (flavor_name) => {
  let valid = false;
  if (flavor_name.value == "Flavor") {
    displayError(flavor_name, "Flavor name cannot be empty.");
  } else {
    displaySuccess(flavor_name);
    valid = true;
  }
  return valid;
};

const checkRegDiscount = (regDiscount) => {
  let valid = false;
  const checkRegDiscount = regDiscount.value.trim();
  if (!isInputFieldRequired(checkRegDiscount)) {
    displayError(regDiscount, "Regular discount can't be empty.");
  } else if (!validateRegDiscount(checkRegDiscount)) {
    displayError(
      regDiscount,
      "Regular discount is not valid. It should be a positive decimal number like 1.5, 0.5, 15, etc"
    );
  } else {
    displaySuccess(regDiscount);
    valid = true;
  }
  return valid;
};

const isFlavorNameValid = (name) => {
  const re = /[a-zA-Z]$/i;
  return re.test(name);
};

const isCategoryNameValid = (name) => {
  const re = /[a-zA-Z]$/i;
  return re.test(name);
};

const validateProductCode = (productCode) => {
  // const re = /[0-9]{3}-[0-9]{3}$/i;
  const re = /^[a-z0-9]+$/i;
  return re.test(productCode);
};

const validateProductName = (name) => {
  const re = /[a-zA-Z0-9_ \.'-]$/i;
  return re.test(name);
};

const validateQuantity = (quantity) => {
  const re = /^[1-9]\d*$/;
  return re.test(quantity);
};

const validatePkgSize = (pkg_size) => {
  const re = /(\d+(?:\.\d+)?)\s?(L|ML)\b/i;
  // const re = /^[+]?\d+([.]\d+)?$/gm;
  return re.test(pkg_size);
};

const validateRegDiscount = (reg_discount) => {
  const re = /^[+]?\d+([.]\d+)?$/gm;
  return re.test(reg_discount);
};

const validateIncomeTax = (tax) => {
  const re = /^[+]?\d+([.]\d+)?$/gm;
  return re.test(tax);
};

const validateUnitPrice = (price) => {
  const re = /^[+]?\d+([.]\d+)?$/gm;
  return re.test(price);
};

const validatePkgType = (pkg_type) => {
  const re = /[a-zA-Z]$/i;
  return re.test(pkg_type);
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

const submitProductForm = (id) => {
  const productForm = document.getElementById("productForm" + id);
  productForm.addEventListener("submit", function (e) {
    // prevent the form from submitting
    e.preventDefault();

    var allInputFieldsValid = true;
    Array.from(productForm.elements).forEach((element) => {
      switch (element.id) {
        case "name" + id:
          if (!checkProductName(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "code" + id:
          if (!checkProductCode(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "category" + id:
          if (!checkCategoryName(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "flavor" + id:
          if (!checkFlavorName(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "pkgName" + id:
          if (!checkPkgName(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "size" + id:
          if (!checkPackageSize(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "pkg_type" + id:
          if (!checkPkgType(element, id)) {
            allInputFieldsValid = false;
          }
          break;
        case "unitPrice" + id:
          if (!checkUnitPrice(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "regDiscount" + id:
          if (!checkRegDiscount(element)) {
            allInputFieldsValid = false;
          }
          break;
        case "tax" + id:
          if (!checkAdvanceIncomeTax(element)) {
            allInputFieldsValid = false;
          }
          break;
      }
    });

    if (allInputFieldsValid) {
      $("#productForm" + id).submit();
    } else console.log("something went wrong");
  });
};
