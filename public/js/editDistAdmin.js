const editAdminName = document.getElementById("adminname");
const editEmail = document.getElementById("adminemail");
const editPassword = document.getElementById('adminpassword');
const confirmPassword = document.getElementById("confirm_pass");
const editContact = document.getElementById('admincontact');
const editCity = document.getElementById('admincity');
const editDistAdminForm = document.getElementById('editDistAdmin');

const checkDistAdminName = (name) => {
    let valid = false;
    const checkAdminName = name.value.trim();
    if (!isFieldRequired(checkAdminName)) {
        showErrorMessage(name, 'Name cannot be blank.');
    } else if (!isAdminNameValid(checkAdminName)) {
        showErrorMessage(name, 'Name is not valid.')
    } else {
        showSuccessMessage(name);
        valid = true;
    }
    return valid;
};

const checkDistAdminEmail = (email) => {
    let valid = false;
    const checkEmail = email.value.trim();
    if (!isFieldRequired(checkEmail)) {
        showErrorMessage(email, "Email can't be empty.")
    } else if (!isDistAdminEmailValid(checkEmail)) {
        showErrorMessage(email, 'Email is not valid.')
    } else {
        showSuccessMessage(email);
        valid = true;
    }
    return valid;
};

const checkDistAdminPassword = (password) => {
    let valid = false;
    const newPassword = password.value.trim();
    if (!isFieldRequired(newPassword)) {
        showErrorMessage(password, "Password can't be empty.")
    } else if (!isDistAdminPasswordSecure(newPassword)) {
        showErrorMessage(password, 'Password must has at least 8 characters that include at least 1 lowercase character, 1 uppercase characters, 1 number, and 1 special character in (!@#$%^&*)');
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
        showErrorMessage(confirmPassword, 'Confirm password cannot be empty.');
    } else if (!isDistAdminPasswordSecure(checkConfirmPassword)) {
        showErrorMessage(confirmPassword, 'Confirm password must has at least 8 characters that include at least 1 lowercase character, 1 uppercase characters, 1 number, and 1 special character in (!@#$%^&*)')
    } else {
        if (password != checkConfirmPassword) {
            showErrorMessage(confirmPassword, "New Password and Confirm Password must be the same.");
        } else {
            showSuccessMessage(confirmPassword);
            valid = true;
        }
    }
    return valid;
};

const checkDistAdminContact = (contact) => {
    let valid = false;

    const checkContact = editContact.value.trim();
    if (!isFieldRequired(checkContact)) {
        showErrorMessage(editContact, "Contact can't be empty.")
    } else if (!isDistAdminContactValid(checkContact)) {
        showErrorMessage(editContact, 'Contact is not valid. It should be in the format +92 330 1234567');
    } else {
        showSuccessMessage(editContact);
        valid = true;
    }
    return valid;
};

const checkDistAdminCity = () => {
    let valid = false;

    const checkCity = editCity.value.trim();
    if (!isFieldRequired(checkCity)) {
        showErrorMessage(editCity, "Address can't be empty.")
    } else if (!isDistAdminCityValid(checkCity)) {
        showErrorMessage(editCity, 'Address is not valid.');
    } else {
        showSuccessMessage(editCity);
        valid = true;
    }
    return valid;
};

const isAdminNameValid = (name) => {
    const re = /^[a-z ,.'-]+$/i;
    return re.test(name);
};

const isDistAdminEmailValid = (email) => {
    const re = /^([a-z0-9\.-]+)@([a-z0-9-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/;
    return re.test(email);
};

const isDistAdminPasswordSecure = (password) => {
    const re = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\\$%\\^&\\*])(?=.{5,})");
    return re.test(password);
};

const isDistAdminContactValid = (contact) => {
    const re = /^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{7}$/gm;
    return re.test(contact);
}

const isDistAdminCityValid = (city) => {
    const re = /^[a-zA-Z,]+(?:[\s-][a-zA-Z]+)*$/gm;
    return re.test(city);
}

const isFieldRequired = value => value === '' ? false : true;


const showErrorMessage = (input, message) => {
    const formField = input.parentElement;
    input.classList.remove('success');
    input.classList.add('error');
    const error = formField.querySelector('small');
    error.classList.remove('successmsg');
    error.classList.add('errormsg');
    error.textContent = message;
};

const showSuccessMessage = (input) => {
    const formField = input.parentElement;
    input.classList.remove('error');
    input.classList.add('success');
    const error = formField.querySelector('small');
    error.classList.remove('errormsg');
    error.classList.add('successmsg');
    error.textContent = '';
}

editDistAdminForm.addEventListener('submit', function(e) {
    // prevent the form from submitting
    e.preventDefault();

    // validate fields
    let isDistAdminEmailValid = checkDistAdminEmail(),
        isPasswordValid = checkDistAdminPassword(),
        isConfirmPassValid = checkConfirmPassword(),
        isDistAdminContactValid = checkDistAdminContact(),
        isDistAdminCityValid = checkDistAdminCity(),
        isDistAdminNameValid = checkDistAdminName();

    let isFormValid = isDistAdminEmailValid && isDistAdminContactValid &&
        isDistAdminNameValid && isDistAdminCityValid && isPasswordValid && isConfirmPassValid;
    // submit to the server if the form is valid
    if (isFormValid) {
        $("#editDistAdmin").submit();
    }
});

editDistAdminForm.addEventListener('input', function(e) {
    switch (e.target.id) {
        case 'adminname':
            checkDistAdminName();
            break;
        case 'adminemail':
            checkDistAdminEmail();
            break;
        case 'adminpassword':
            checkDistAdminPassword();
            break;
        case 'confirm_pass':
            checkConfirmPassword();
            break;
        case 'admincontact':
            checkDistAdminContact();
            break;
        case 'admincity':
            checkDistAdminCity();
            break;
    }
});