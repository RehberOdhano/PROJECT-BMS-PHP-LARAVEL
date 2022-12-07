const checkDistName = (distName) => {
    let valid = false;
    const checkName = distName.value.trim();
    if (!isRequired(checkName)) {
        showError(distName, 'Name cannot be blank.');
    } else if (!isDistNameValid(checkName)) {
        showError(distName, 'Name is not valid. Name contains only lowercase and upper case letters.');
    } else {
        showSuccess(distName);
        valid = true;
    }
    return valid;
};

const checkDistAddress = (distAddress) => {
    let valid = false;
    const checkAddress = distAddress.value.trim();
    if (!isRequired(checkAddress)) {
        showError(distAddress, 'Address cannot be blank.');
    } else if (!isDistAddressValid(checkAddress)) {
        showError(distAddress, 'Address is not valid. Address contains digits, lowercase and upper case letters.');
    } else {
        showSuccess(distAddress);
        valid = true;
    }
    return valid;
};

const checkDistContact = (distContact) => {
    let valid = false;
    const checkContact = distContact.value.trim();
    if (!isRequired(checkContact)) {
        showError(distContact, 'Contact cannot be blank.');
    } else if (!isDistContactValid(checkContact)) {
        showError(distContact, 'Contact is not valid. It should be in the format: 03301293789');
    } else {
        showSuccess(distContact);
        valid = true;
    }
    return valid;
};

const isDistNameValid = (name) => {
    const re = /^[a-z ,.'-]+$/i;
    return re.test(name);
};

const isDistAddressValid = (address) => {
    const re = /^[a-zA-Z0-9\s,.'-]*$/gm;
    return re.test(address);
};

const isDistContactValid = (contact) => {
    const re = /^[0-9]{11}$/;
    return re.test(contact);
}

const isRequired = value => value === '' ? false : true;


const showError = (input, message) => {
    const formField = input.parentElement;
    input.classList.remove('success');
    input.classList.add('error');
    const error = formField.querySelector('small');
    error.classList.remove('successmsg');
    error.classList.add('errormsg');
    error.textContent = message;
};

const showSuccess = (input) => {
    const formField = input.parentElement;
    input.classList.remove('error');
    input.classList.add('success');
    const error = formField.querySelector('small');
    error.classList.remove('errormsg');
    error.classList.add('successmsg');
    error.textContent = '';
}

const submitDistForm = (id) => {
    const distForm = document.getElementById("distForm" + id);
    distForm.addEventListener('submit', function(e) {
        // prevent the form from submitting
        e.preventDefault();
        
        var allInputFieldsValid = true;
        Array.from(distForm.elements).forEach(element => {
            switch(element.id) {
                case "distName" + id:
                    if(!checkDistName(element)) {
                        allInputFieldsValid = false;
                    }
                    break;
                case "distAddress" + id:
                    if(!checkDistAddress(element)) {
                        allInputFieldsValid = false;
                    }
                    break;
                case "distContact" + id:
                    if(!checkDistContact(element)) {
                        allInputFieldsValid = false;
                    }
                    break;
            }
        });

        if (allInputFieldsValid) {
            $("#distForm" + id).submit();

        } else console.log("something went wrong");
    });
}