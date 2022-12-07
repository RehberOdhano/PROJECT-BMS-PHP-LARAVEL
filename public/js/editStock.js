const delDate = document.getElementById("del_date");
const invoiceNum = document.getElementById('invoice-num');
const code = document.getElementById('product-code');
const stkqty = document.getElementById('quantity');
const tax = document.getElementById('adv_income_tax');
const discount = document.getElementById('reg_discount');
const editStockForm = document.getElementById('editStock');

const checkDelDate = () => {
    let valid = false;
    const checkDelDate = delDate.value.trim();
    if (!isRequired(checkDelDate)) {
        displayErrorMsg(delDate, 'Date isn\'t valid.');
    } else {
        displaySuccessMsg(delDate);
        valid = true;
    }
    return valid;
};

const checkCode = () => {
    let valid = false;
    const checkProductCode = code.value.trim();
    if (!isRequired(checkProductCode)) {
        displayErrorMsg(code, 'Product code cannot be empty.');
    } else if (!validateCode(checkProductCode)) {
        displayErrorMsg(code, 'Product code is not valid.');
    } else {
        displaySuccessMsg(code);
        valid = true;
    }
    return valid;
};

const checkInvoiceNum = () => {
    let valid = false;
    const checkInvoiceNumber = invoiceNum.value.trim();
    if (!isRequired(checkInvoiceNumber)) {
        displayErrorMsg(invoiceNum, 'Invoice number cannot be empty.');
    } else if (!validateInvoiceNumber(checkInvoiceNumber)) {
        displayErrorMsg(invoiceNum, 'Invoice number is not valid.');
    } else {
        displaySuccessMsg(invoiceNum);
        valid = true;
    }
    return valid;
};

const checkStockQuantity = () => {
    let valid = false;
    const checkStkQuantity = stkqty.value.trim();
    if (!isRequired(checkStkQuantity)) {
        displayErrorMsg(stkqty, 'Quantity cannot be empty.');
    } else if (!validateStockQuantity(checkStkQuantity)) {
        displayErrorMsg(stkqty, 'Quantity is not valid.');
    } else {
        displaySuccessMsg(stkqty);
        valid = true;
    }
    return valid;
};

const checkRegDiscount = () => {
    let valid = false;
    const regDiscount = discount.value.trim();
    if (!isRequired(regDiscount)) {
        displayErrorMsg(discount, 'Regular discount cannot be empty.');
    } else if (!validateDecimalNumber(regDiscount)) {
        displayErrorMsg(discount, 'Regular discount is not valid.');
    } else {
        displaySuccessMsg(discount);
        valid = true;
    }
    return valid;
};

const checkAdvIncomeTax = () => {
    let valid = false;
    const advIncomeTax = tax.value.trim();
    if (!isRequired(advIncomeTax)) {
        displayErrorMsg(tax, 'Advance Income Tax cannot be empty.');
    } else if (!validateDecimalNumber(advIncomeTax)) {
        displayErrorMsg(tax, 'Advance Income Tax is not valid.');
    } else {
        displaySuccessMsg(tax);
        valid = true;
    }
    return valid;
};

// const validateStockDelDate = (date) => {
//     const re = /^[a-z ,.'-]+$/i;
//     return re.test(date);
// };

const validateDecimalNumber = (number) => {
    const re = /^[+]?\d+([.]\d+)?$/gm;
    return re.test(number);
}

const validateCode = (productCode) => {
    const re = /[0-9]{3}-[0-9]{3}$/i;
    return re.test(productCode);
};

const validateInvoiceNumber = (invoice_num) => {
    const re = /^\d{10}$/i;
    return re.test(invoice_num);
}

const validateStockQuantity = (quantity) => {
    const re = /[0-9]{1,5}$/i;
    return re.test(quantity);
}

const isRequired = value => value === '' ? false : true;


const displayErrorMsg = (input, message) => {
    // if(input.id == "product-code") {
    //     input.parentElement.classList.remove("success");
    //     input.parentElement.classList.add("error");
    // } else {
    //     input.classList.remove('success');
    //     input.classList.add('error');
    // }
    input.classList.remove('success');
    input.classList.add('error');
    const formField = input.parentElement;
    const error = formField.querySelector('small');
    error.classList.remove('successmsg');
    error.classList.add('errormsg');
    error.textContent = message;
};

const displaySuccessMsg = (input) => {
    const formField = input.parentElement;
    input.classList.remove('error');
    input.classList.add('success');
    const error = formField.querySelector('small');
    error.classList.remove('errormsg');
    error.classList.add('successmsg');
    error.textContent = '';
}

editStockForm.addEventListener('submit', function(e) {
    // prevent the form from submitting
    e.preventDefault();

    // validate fields
    let isCodeValid = checkCode(),
        isDelDateValid = checkDelDate(),
        isStkQuantityValid = checkStockQuantity(),
        isInvoiceNumberValid = checkInvoiceNum(),
        isRegDiscountValid = checkRegDiscount(),
        isAdvIncomeTaxValid = checkAdvIncomeTax();

    let isFormValid = isCodeValid && isStkQuantityValid && isInvoiceNumberValid &&
        isRegDiscountValid && isAdvIncomeTaxValid && isDelDateValid;
    // submit to the server if the form is valid
    if (isFormValid) {
        $("#editStock").submit();
    }
});

editStockForm.addEventListener('input', function(e) {
    switch (e.target.id) {
        case 'del_date':
            checkDelDate();
            break;
        case 'invoice-num':
            checkInvoiceNum();
            break;
        case 'product-code':
            checkCode();
            break;
        case 'quantity':
            checkStockQuantity();
            break;
        case 'reg_discount':
            checkRegDiscount();
            break;
        case 'adv_income_tax':
            checkAdvIncomeTax();
            break;
    }
});