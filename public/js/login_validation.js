const email = document.getElementById("email");
const password = document.getElementById('password');
const form = document.getElementById('login');

const checkEmail = () => {
    let valid = false;
    const checkEmail = email.value.trim();
    if (!isRequired(checkEmail)) {
        showError(email, 'Email cannot be blank.');
    } else if (!isEmailValid(checkEmail)) {
        showError(email, 'Email is not valid.')
    } else {
        showSuccess(email);
        valid = true;
    }
    return valid;
};

const checkPassword = () => {
    let valid = false;

    const newPassword = password.value.trim();

    if (!isRequired(newPassword)) {
        showError(password, 'Password cannot be blank.');
    } else if (!isPasswordSecure(newPassword)) {
        showError(password, 'Password isn\'t valid.');
        // showError(password, 'Password must has at least 8 characters that include at least 1 lowercase character, 1 uppercase characters, 1 number, and 1 special character in (!@#$%^&*)');
    } else {
        showSuccess(password);
        valid = true;
    }

    return valid;
};

const isEmailValid = (email) => {
    const re = /^([a-z0-9\.-]+)@([a-z0-9-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/;
    return re.test(email);
};

const isPasswordSecure = (password) => {
    const re = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\\$%\\^&\\*])(?=.{5,})");
    return re.test(password);
};

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

form.addEventListener('submit', function(e) {
    // prevent the form from submitting
    e.preventDefault();

    // validate fields
    let isEmailValid = checkEmail(),
        isPasswordValid = checkPassword();

    let isFormValid = isEmailValid && isPasswordValid;
    // submit to the server if the form is valid
    if (isFormValid) {
        console.log("submitted!");
        $("#login").submit();
    }
});


const debounce = (fn, delay = 500) => {
    let timeoutId;
    return (...args) => {
        // cancel the previous timer
        if (timeoutId) {
            clearTimeout(timeoutId);
        }
        // setup a new timer
        timeoutId = setTimeout(() => {
            fn.apply(null, args)
        }, delay);
    };
};

form.addEventListener('input', debounce(function(e) {
    switch (e.target.id) {
        case 'email':
            checkEmail();
            break;
        case 'password':
            checkPassword();
            break;
    }
}));