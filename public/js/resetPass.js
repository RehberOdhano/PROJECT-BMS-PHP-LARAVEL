const email = document.getElementById("email");
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

const isEmailValid = (email) => {
    const re = /^([a-z0-9\.-]+)@([a-z0-9-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/;
    return re.test(email);
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
    let isEmailValid = checkEmail();

    let isFormValid = isEmailValid;
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
    }
}));