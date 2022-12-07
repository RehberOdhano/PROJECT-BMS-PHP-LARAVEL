const checkOutetValue = (outlet) => {
  var valid = false;
  const outletVal = outlet.value.trim();
  if (!isRequired(outletVal)) {
    showError(outlet, "Outlet value can't be empty.");
  } else if (outletVal == "Choose Outlet" || !isValidString(outletVal)) {
    showError(outlet, "Outlet value isn't valid.");
  } else {
    showSuccess(outlet);
    valid = true;
  }
  return valid;
};

const checkRouteValue = (route) => {
  var valid = false;
  const routeVal = route.value.trim();
  if (!isRequired(routeVal)) {
    showError(route, "Route value can't be empty.");
  } else if (routeVal == "Route" || !isValidString(routeVal)) {
    showError(route, "Route value isn't valid.");
  } else {
    showSuccess(route);
    valid = true;
  }
  return valid;
};

const checkVehicleValue = (vehicle) => {
  var valid = false;
  const vehicleVal = vehicle.value.trim();
  if (!isRequired(vehicleVal)) {
    showError(vehicle, "Vehicle value can't be empty.");
  } else if (!isValidNumberPlate(vehicleVal)) {
    showError(vehicle, "Vehicle value isn't valid.");
  } else {
    showSuccess(vehicle);
    valid = true;
  }
  return valid;
};

const checkSalesmanValue = (salesman) => {
  var valid = false;
  const salesmanVal = salesman.value.trim();
  if (!isRequired(salesmanVal)) {
    showError(salesman, "Salesman value can't be empty.");
  } else if (salesmanVal == "Choose Salesman" || !isValidString(salesmanVal)) {
    showError(salesman, "Salesman value isn't valid.");
  } else {
    showSuccess(salesman);
    valid = true;
  }
  return valid;
};

const checkDriverValue = (driver) => {
  var valid = false;
  const driverVal = driver.value.trim();
  if (!isRequired(driverVal)) {
    showError(driver, "Driver value can't be empty.");
  } else if (driverVal == "Choose Driver" || !isValidString(driverVal)) {
    showError(driver, "Driver value isn't valid.");
  } else {
    showSuccess(driver);
    valid = true;
  }
  return valid;
};

const checkQuantity = (quantity) => {
  let valid = false;
  const checkSaleQuantity = quantity.value.trim();
  if (!isRequired(checkSaleQuantity)) {
    showError(quantity, "Quantity cannot be blank.");
  } else if (!validateQuantity(checkSaleQuantity)) {
    showError(quantity, "Quantity is not valid.");
  } else {
    showSuccess(quantity);
    valid = true;
  }
  return valid;
};

const checkNewPrice = (newprice) => {
  let valid = false;
  const checkPrice = newprice.value.trim();
  if (!isRequired(checkPrice)) {
    showError(newprice, "New Price cannot be blank.");
  } else if (!validatePrice(checkPrice)) {
    showError(newprice, "New Price is not valid.");
  } else {
    showSuccess(newprice);
    valid = true;
  }
  return valid;
};

const checkReceivedAmount = (receivedAmount) => {
  let valid = false;
  const totalAmount = document.getElementById("total-amount").value.trim();
  const amountReceived = receivedAmount.value.trim();
  if (!isRequired(amountReceived)) {
    showError(receivedAmount, "Received amount cannot be blank.");
  } else if (parseFloat(amountReceived) > parseFloat(totalAmount)) {
    showError(
      receivedAmount,
      "Amount paid can't be bigger than the total amount!"
    );
  } else if (!validatePrice(amountReceived)) {
    showError(receivedAmount, "Received amount is not valid.");
  } else {
    showSuccess(receivedAmount);
    valid = true;
  }
  return valid;
};

const isRequired = (value) => (value === "" ? false : true);

const isValidString = (input) => {
  const re = /^[a-zA-Z0-9_ \,]+$/i;
  return re.test(input);
};

const validateQuantity = (quantity) => {
  const re = /[0-9]$/i;
  return re.test(quantity);
};

const validatePrice = (price) => {
  const re = /^[+]?\d+([.]\d+)?$/gm;
  return re.test(price);
};

const isValidNumberPlate = (num_plate) => {
  const re = /^([a-zA-Z0-9]){1,10}$/;
  return re.test(num_plate);
};

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

const isValidFormData = () => {
  const saleForm = document.getElementById("addSaleForm");
  var allInputFieldsValid = true;

  Array.from(saleForm.elements).forEach((element) => {
    if (element.id.includes("outlet-search")) {
      if (!checkOutetValue(element)) {
        allInputFieldsValid = false;
      }
    } else if (element.id.includes("route-search")) {
      if (!checkRouteValue(element)) {
        allInputFieldsValid = false;
      }
    } else if (element.id.includes("vehicle-search")) {
      if (!checkVehicleValue(element)) {
        allInputFieldsValid = false;
      }
    } else if (element.id.includes("salesman_search")) {
      if (!checkSalesmanValue(element)) {
        allInputFieldsValid = false;
      }
    } else if (element.id.includes("drivers-search")) {
      if (!checkDriverValue(element)) {
        allInputFieldsValid = false;
      }
    } else if (element.id.includes("new_price")) {
      if (!checkNewPrice(element)) {
        allInputFieldsValid = false;
      }
    } else if (element.id.includes("quantity")) {
      if (!checkQuantity(element)) {
        allInputFieldsValid = false;
      }
    } else if (element.id.includes("amount-paid")) {
      if (!checkReceivedAmount(element)) {
        allInputFieldsValid = false;
      }
    }
  });

  return allInputFieldsValid;
};

var productCode = "";
var data = {},
  org_prices = [],
  new_prices = [],
  productCodes = [],
  quantities = [],
  amounts = [],
  productNames = [],
  pkgSizes = [],
  pkgTypes = [];

function getPkgType(option, id) {
  const pkgName = document.getElementById("p_name" + id).innerHTML;
  const pkgType = document.getElementById("pkgType" + id);
  $.ajax({
    url: "/dists/admin/search/package",
    type: "GET",
    data: { pkgSize: option, pkgName: pkgName },
    success: function (pkg) {
      pkgType.innerHTML = pkg["pkg_type"];
      pkgTypes.push(pkg["pkg_type"]);
    },
    error: function (err) {
      console.log(err);
    },
  });
}

function getOutletRoutes(option) {
  $.ajax({
    url: "/dists/admin/outlet/get-routes",
    type: "GET",
    data: { name: option },
    success: function (routes) {
      const route = document.getElementById("route-search");
      route.setAttribute("value", routes[0].route);
      route.setAttribute("text", routes[0].route);
      var evt = new Event("change");
      route.dispatchEvent(evt);
    },
    error: function (err) {
      console.log("ERROR: " + err.responseText);
    },
  });
}

var prevID = 0;

function getState(option, id) {
  console.log(option);
  productCode = option;
  if (productCodes.length == 0) {
    productCodes.push(option);
  } else {
    if (prevID === id) {
      productCodes.pop();
      productCodes.push(option);
    } else {
      productCodes.push(option);
    }
  }
  prevID = id;
  var searchProductReq = new XMLHttpRequest();
  let URL = "/dists/admin/search/product?product-code=" + option.split("-")[0];
  searchProductReq.open("GET", URL);
  searchProductReq.send();

  var name = document.getElementById("p_name" + id);
  var quantity = document.getElementById("quantity" + id);
  var original_price = document.getElementById("original_price" + id);
  var amount = document.getElementById("amt" + id);
  var pkgSize = document.getElementById("pkgSize" + id);
  var pkgType = document.getElementById("pkgType" + id);

  searchProductReq.onreadystatechange = function () {
    if (searchProductReq.readyState == 4 && searchProductReq.status == 200) {
      if (option.length != 0) {
        const JSONResponse = JSON.parse(searchProductReq.responseText);
        const product = JSONResponse["product"][0];
        const pkg = JSONResponse["pkg"][0];

        name.innerHTML = product["product_name"].toUpperCase();
        quantity.value = product.quantity == null ? 0 : product["quantity"];
        original_price.value = product["unit_price"];
        amount.innerHTML =
          parseInt(quantity.value) * parseFloat(original_price.value);
        pkgSize.innerHTML = pkg["size"];
        pkgType.innerHTML = pkg["pkg_type"];
        pkgTypes.push(pkg["pkg_type"]);
      } else {
        alert("OH NO... SOMETHING WENT WRONG!");
      }
    }
  };
}

// THIS FUNCTION WILL BE USED TO DELETE THE ROW FROM THE TABLE...
// when deleting a row, we'll also delete that specific product code from the
// product codes array, then we'll also change the total amount accordingly...
function delete_row(del_btn, ID) {
  // deleting that specific product code from the product codes array...
  const pCode = document.getElementById("productCode" + ID);
  productCodes.splice(productCodes.indexOf(pCode.value), 1);
  const table = document.getElementById("data_table");
  var totalAmount = document.getElementById("total-amount");
  const rows = table.rows.length - 1;
  const parent = del_btn.parentNode.parentNode;
  const id = "#" + parent.id;

  if (rows == 1) {
    del_btn.disabled = true;
  } else {
    $(id).remove();
  }

  // calculating the total amount of all the added products...
  var totalSum = 0;
  const count = table.rows.length;
  for (var i = 1; i < count; i++) {
    totalSum += parseFloat(table.rows[i].cells[7].innerHTML);
  }
  totalAmount.value = totalSum;
}

$("#addSale").on("click", function (e) {
  e.preventDefault();
  if (isValidFormData()) {
    const form = document.getElementById("addSaleForm");
    var _token = $('meta[name="csrf-token"]').attr("content");
    Array.from(form.elements).forEach((element) => {
      if (element.id.includes("outlet-search")) data.outlet = element.value;
      else if (element.id.includes("route-search")) data.route = element.value;
      else if (element.id.includes("vehicle-search"))
        data.vehicle = element.value;
      else if (element.id.includes("salesman_search"))
        data.salesman = element.value;
      else if (element.id.includes("drivers-search"))
        data.driver = element.value;
      else if (element.id.includes("original_price"))
        org_prices.push(element.value);
      else if (element.id.includes("new_price")) {
        if (element.value == "") new_prices.push(-1);
        else new_prices.push(element.value);
      } else if (element.id.includes("quantity"))
        quantities.push(element.value);
      else if (element.id.includes("pkgSize")) pkgSizes.push(element.value);
    });

    var table = document.getElementById("data_table");
    for (var i = 0, row; (row = table.rows[i]); i++) {
      for (var j = 0, col; (col = row.cells[j]); j++) {
        const id = col.id;
        if (id.includes("p_name")) productNames.push(col.innerHTML);
        else if (id.includes("pkgSize")) pkgSizes.push(col.innerHTML);
      }
    }

    new_prices.forEach((price, index) => {
      if (price == -1) amounts.push(org_prices[index] * quantities[index]);
      else amounts.push(price * quantities[index]);
    });

    const totalAmount = document.getElementById("total-amount").value.trim();
    const amountPaid = document.getElementById("amount-paid").value.trim();
    const amountDue = document.getElementById("due-amount").value.trim();
    const outlet = document.getElementById("outlet-search").value.trim();

    (data._token = _token),
      (data.names = productNames),
      (data.sizes = pkgSizes),
      (data.types = pkgTypes),
      (data.org_prices = org_prices),
      (data.productCodes = productCodes),
      (data.new_prices = new_prices),
      (data.quantities = quantities),
      (data.amounts = amounts),
      (data.totalAmount = totalAmount),
      (data.amountPaid = amountPaid),
      (data.amountDue = amountDue),
      (data.outlet = outlet);

    // console.log(data, productCodes);

    $.ajaxSetup({
      headers: {
        "X-CSRF-TOKEN": _token,
      },
    });

    $.ajax({
      url: "/dists/admin/addSale",
      type: "POST",
      data: data,
      success: function (res) {
        // console.log("response: " + JSON.stringify(res));
        window.location.href = "/dists/admin/sales";
      },
      error: function (err) {
        console.log(err);
      },
    });
  }
});

function calcDueAmount(amountPaid) {
  const totalAmount = document.getElementById("total-amount").value.trim();
  const amountDue = document.getElementById("due-amount");
  if (amountPaid.value == "" || amountPaid.value == "0") {
    amountDue.value = totalAmount;
  } else if (parseFloat(amountPaid.value) > parseFloat(totalAmount)) {
    amountDue.value = 0;
  } else {
    amountDue.value = parseFloat(totalAmount) - parseFloat(amountPaid.value);
  }
}
