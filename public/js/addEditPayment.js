const checkAmountPaid = (amountPaid) => {
    let valid = false;
    const amount = amountPaid.value.trim();
    if (!isrequired(amount)) {
        displayErrorMsg(amountPaid, 'Amount Paid cannot be empty.');
    } else if (!checkNum(amount)) {
        displayErrorMsg(amountPaid, 'Amount Paid is not valid. It should be a positive decimal number like 10, 10.5, etc.');
    } else {
        displaySuccessMsg(amountPaid);
        valid = true;
    }
    return valid;
};

const checkAmountDue = (amountDue, id) => {
    let valid = false;
    const amountdue = amountDue.value.trim();
    if (!isrequired(amountdue)) {
        displayErrorMsg(amountDue, 'Amount Due cannot be empty.');
    } else if (!checkNum(amountdue)) {
        displayErrorMsg(amountDue, 'Amount Due is not valid. It should be a positive decimal number like 10, 10.5, etc.');
    } else {
        displaySuccessMsg(amountDue);
        valid = true;
        const paymentStatus = document.getElementById("status" + id);
        // console.log(paymentStatus, amountdue);
        if(amountdue == "" || amountdue == "0") {
            paymentStatus.value = "Paid";
        } else paymentStatus.value = "Pending";
        checkStatus(paymentStatus);
    }

    return valid;
};

const checkStatus = (paymentStatus) => {
    let valid = false;
    const checkStatus = paymentStatus.value.trim();
    if (!isrequired(checkStatus)) {
        displayErrorMsg(paymentStatus, 'Status cannot be empty.');
    } else if (!isStatusValid(checkStatus)) {
        displayErrorMsg(paymentStatus, 'Status is not valid.');
    } else {
        displaySuccessMsg(paymentStatus);
        valid = true;
    }

    return valid;
};

const checkPaymentDate = (paymentDate) => {
    let valid = false;
    const checkDate = paymentDate.value.trim();
    if (!isrequired(checkDate)) {
        displayErrorMsg(paymentDate, 'Payment Date cannot be empty.');
    } else {
        displaySuccessMsg(paymentDate);
        valid = true;
    }
    return valid;
};

// const isDateValid = (date) => {
//     const re = "";
//     return re.test(date);
// }

const isStatusValid = (name) => {
    const re = /^[a-zA-Z]+$/i;
    return re.test(name);
};

const checkNum = (num) => {
    const re = /^(?!(?:\.0+)?$)[0-9]+(?:\.[0-9]+)?$/gm;
    return re.test(num);
}

const isrequired = value => value === '' ? false : true;

const displayErrorMsg = (input, message) => {
    // if(input.id == "status") {
    //     input = input.parentElement;
    //     input.classList.remove('success');
    //     input.classList.add('error');        
    // } 
    const formField = input.parentElement;
    input.classList.remove('success');
    input.classList.add('error');
    const error = formField.querySelector('small');
    error.classList.remove('successmsg');
    error.classList.add('errormsg');
    error.textContent = message;
};

const displaySuccessMsg = (input) => {
    // if(input.id == "status") {
    //     input = input.parentElement;
    //     input.classList.remove('error');
    //     input.classList.add('success');        
    // } 
    const formField = input.parentElement;
    input.classList.remove('error');
    input.classList.add('success');
    const error = formField.querySelector('small');
    error.classList.remove('errormsg');
    error.classList.add('successmsg');
    error.textContent = '';
}

const submitDistPaymentForm = (id) => {
    const distPaymentForm = document.getElementById("distPaymentForm" + id);
    distPaymentForm.addEventListener('submit', function(e) {
        // prevent the form from submitting
        e.preventDefault();
        
        var allInputFieldsValid = true;
        Array.from(distPaymentForm.elements).forEach(element => {
            switch(element.id) {
                case "amoutPaid" + id:
                    if(!checkAmountPaid(element)) {
                        allInputFieldsValid = false;
                    }
                    break;
                case "amountDue" + id:
                    if(!checkAmountDue(element, id)) {
                        allInputFieldsValid = false;
                    }
                    break;
                case "payment_date" + id:
                    if(!checkPaymentDate(element)) {
                        allInputFieldsValid = false;
                    }
                    break;
                case "status" + id:
                    if(!checkStatus(element)) {
                        allInputFieldsValid = false;
                    }
                    break;
            }
        });

        if (allInputFieldsValid) {
            document.getElementById('status' + id).disabled = false;
            $("#distPaymentForm" + id).submit();

        } else console.log("something went wrong");
    });
}