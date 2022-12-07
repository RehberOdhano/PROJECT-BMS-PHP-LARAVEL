const checkDate = (date) => {
  let valid = false;
  const delDate = date.value.trim();
  if (!isInputFieldRequired(delDate)) {
    displayError(date, "Date isn't valid.");
  } else {
    displaySuccess(date);
    valid = true;
  }
  return valid;
};

const checkProductCode = (product_Code) => {
  let valid = false;
  const checkCode = product_Code.value.trim();
  if (!isInputFieldRequired(checkCode)) {
    displayError(product_Code, "Product code cannot be blank.");
  } else if (!validateProductCode(checkCode)) {
    displayError(product_Code, "Product code is not valid.");
  } else {
    displaySuccess(product_Code);
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

const checkAdvanceIncomeTax = (advanceTax) => {
  let valid = false;
  const checkIncomeTax = advanceTax.value.trim();
  if (!isInputFieldRequired(checkIncomeTax)) {
    displayError(advanceTax, "Advance Income Tax cannot be blank.");
  } else if (!validateDecimalNumber(checkIncomeTax)) {
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

const checkDiscount = (discount) => {
  let valid = false;
  const checkRegDiscount = discount.value.trim();
  if (!isInputFieldRequired(checkRegDiscount)) {
    displayError(discount, "Regular discont can't be empty.");
  } else if (!validateDecimalNumber(checkRegDiscount)) {
    displayError(
      discount,
      "Regular discont is not valid. It should be a positive decimal number like 1.5, 0.5, 15, etc"
    );
  } else {
    displaySuccess(discount);
    valid = true;
  }
  return valid;
};

const checkInvoiceNumber = (invoiceNumber) => {
  let valid = false;
  const checkInvoiceNum = invoiceNumber.value.trim();
  if (!isInputFieldRequired(checkInvoiceNum)) {
    displayError(invoiceNumber, "Invoice number cannot be blank.");
  } else if (!validateInvoiceNum(checkInvoiceNum)) {
    displayError(
      invoiceNumber,
      "Invoice number is not valid. Value must be a positive whole number."
    );
  } else {
    displaySuccess(invoiceNumber);
    valid = true;
  }
  return valid;
};

const validateProductCode = (productCode) => {
  const re = /^[a-z0-9]+$/i;
  return re.test(productCode);
};

const validateDecimalNumber = (number) => {
  const re = /^[+]?\d+([.]\d+)?$/gm;
  return re.test(number);
};

const validateQuantity = (quantity) => {
  const re = /^[1-9]\d*$/;
  return re.test(quantity);
};

const validateInvoiceNum = (invoice_num) => {
  const re = /^\d{1,}$/i;
  return re.test(invoice_num);
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

const isValidFormData = () => {
  const stockForm = document.getElementById("stockForm");
  var allInputFieldsValid = true;

  Array.from(stockForm.elements).forEach((element) => {
    if (element.id.includes("date")) {
      if (!checkDate(element)) {
        allInputFieldsValid = false;
      }
    } else if (element.id.includes("invoice_num")) {
      if (!checkInvoiceNumber(element)) {
        allInputFieldsValid = false;
      }
    } else if (element.id.includes("productCode")) {
      if (!checkProductCode(element)) {
        allInputFieldsValid = false;
      }
    } else if (element.id.includes("tax")) {
      if (!checkAdvanceIncomeTax(element)) {
        allInputFieldsValid = false;
      }
    } else if (element.id.includes("discount")) {
      if (!checkAdvanceIncomeTax(element)) {
        allInputFieldsValid = false;
      }
    } else if (element.id.includes("quantity")) {
      if (!checkQuantity(element)) {
        console.log(element.value);
        allInputFieldsValid = false;
      }
    }
  });

  return allInputFieldsValid;
};

var productCode = "";
var data = {},
  unit_prices = [],
  productCodes = [],
  quantities = [],
  amounts = [],
  productNames = [],
  pkgSizes = [],
  pkgTypes = [],
  discounts = [],
  taxes = [],
  pkgNames = [];
pkgData = [];

var quantity, unit_price, amount, regDiscount, advanceIncomeTax;

function getState(option, id) {
  productCode = option;
  productCodes.push(productCode);
  var searchProductReq = new XMLHttpRequest();
  let URL = "/dists/admin/search/product?product-code=" + option;
  searchProductReq.open("GET", URL);
  searchProductReq.send();

  var name = document.getElementById("p_name" + id);
  var quantity = document.getElementById("quantity" + id);
  var unit_price = document.getElementById("unitprice" + id);
  var amount = document.getElementById("amt" + id);
  var regDiscount = document.getElementById("discount" + id);
  var advanceIncomeTax = document.getElementById("tax" + id);
  var pkgSize = document.getElementById("pkgSize" + id);
  var pkgType = document.getElementById("pkgType" + id);

  searchProductReq.onreadystatechange = function () {
    if (searchProductReq.readyState == 4 && searchProductReq.status == 200) {
      if (option.length != 0) {
        const JSONResponse = JSON.parse(searchProductReq.responseText);
        const product = JSONResponse["product"][0];
        const pkg = JSONResponse["pkg"][0];
        name.innerHTML = product["product_name"].toUpperCase();
        unit_price.value = product["unit_price"];
        pkgSize.innerHTML = pkg["size"];
        pkgType.innerHTML = pkg["pkg_type"];
        pkgTypes.push(pkg["pkg_type"]);
        regDiscount.value = pkg["reg_discount"];
        advanceIncomeTax.value = product["advance_income_tax"];

        if (!isNaN(regDiscount.value) || !isNaN(quantity.value)) {
          amount.value = 0;
        } else {
          var totalCost =
            parseFloat(unit_price.value) * parseInt(quantity.value);
          var discount = (parseFloat(regDiscount.value) / 100) * totalCost;
          var tax =
            (parseFloat(advanceIncomeTax.value) / 100) * (totalCost - discount);
          totalCost = totalCost + tax;
          amount.innerHTML = totalCost;
        }
      } else {
        alert("OH NO... SOMETHING WENT WRONG!");
      }
    }
  };
}

function delete_row(del_btn) {
  const table = document.getElementById("data_table");
  const rows = table.rows.length - 1;
  const parent = del_btn.parentNode.parentNode;
  const id = "#" + parent.id;
  if (rows == 1) {
    del_btn.disabled = true;
  } else {
    $(id).remove();
  }
}

$("#addStockForm").on("click", function (e) {
  e.preventDefault();
  if (isValidFormData()) {
    const form = document.getElementById("stockForm");
    var _token = $('meta[name="csrf-token"]').attr("content");
    Array.from(form.elements).forEach((element) => {
      if (element.id.includes("date")) data.date = element.value;
      else if (element.id.includes("invoice_num"))
        data.invoiceNumber = element.value;
      else if (element.id.includes("discount")) discounts.push(element.value);
      else if (element.id.includes("tax")) taxes.push(element.value);
      else if (element.id.includes("unitprice"))
        unit_prices.push(element.value);
      else if (element.id.includes("quantity")) quantities.push(element.value);
      else if (element.id.includes("pkgSize")) pkgSizes.push(element.value);
    });

    productCodes.forEach((code, index) => {
      const quantity = parseInt(quantities[index]);
      const unit_price = parseFloat(unit_prices[index]);
      var totalCost = unit_price * quantity;
      var discount = discounts[index] / 100;
      var tax = taxes[index] / 100;
      totalCost += totalCost * tax; // tax added
      totalCost -= totalCost * discount; // discount deducted
      amounts.push(totalCost);
    });

    var table = document.getElementById("data_table");
    for (var i = 0, row; (row = table.rows[i]); i++) {
      for (var j = 0, col; (col = row.cells[j]); j++) {
        const id = col.id;
        if (id.includes("p_name")) productNames.push(col.innerHTML);
        else if (id.includes("pkgSize")) pkgSizes.push(col.innerHTML);
      }
    }

    (data._token = _token),
      (data.names = productNames),
      (data.sizes = pkgSizes),
      (data.unit_prices = unit_prices),
      (data.productCodes = productCodes),
      (data.quantities = quantities),
      (data.amounts = amounts),
      (data.discounts = discounts);
    (data.taxes = taxes), (data.types = pkgTypes);

    $.ajaxSetup({
      headers: {
        "X-CSRF-TOKEN": _token,
      },
    });

    $.ajax({
      url: "/dists/admin/addStock",
      type: "POST",
      data: data,
      success: function (res) {
        window.location.href = "/dists/admin/stocks";
      },
      error: function (err) {
        console.log(err);
      },
    });
  }
});
