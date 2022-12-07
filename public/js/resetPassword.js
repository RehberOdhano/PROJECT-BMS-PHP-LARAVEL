const checkEmail = (email) => {
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

const checkPassword = (password) => {
    let valid = false;
    const checkNewPassword = password.value.trim();
    if (!isRequired(checkNewPassword)) {
        showError(password, 'Password cannot be blank.');
    } else if (!isPasswordSecure(checkNewPassword)) {
        showError(password, 'Password must has at least 8 characters that include at least 1 lowercase character, 1 uppercase characters, 1 number, and 1 special character in (!@#$%^&*)')
    } else {
        showSuccess(password);
        valid = true;
    }
    return valid;
};

const checkConfirmPassword = (confirmPassword) => {
    let valid = false;
    const password = document.getElementById('password').value.trim();
    const checkConfirmPassword = confirmPassword.value.trim();
    if (!isRequired(checkConfirmPassword)) {
        showError(confirmPassword, 'Confirm password cannot be blank.');
    } else if (!isPasswordSecure(checkConfirmPassword)) {
        showError(confirmPassword, 'Confirm password must has at least 8 characters that include at least 1 lowercase character, 1 uppercase characters, 1 number, and 1 special character in (!@#$%^&*)')
    } else {
        if (password == checkConfirmPassword) {
            showSuccess(confirmPassword);
            valid = true;
        } else {
            showError(confirmPassword, "New Password and Confirm Password must be the same.");
        }
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

const submitResetPassForm = () => {
    const resetPasswordForm = document.getElementById("resetPasswordForm");
    resetPasswordForm.addEventListener('submit', function(e) {
        // prevent the form from submitting
        e.preventDefault();
        
        var allInputFieldsValid = true;
        Array.from(resetPasswordForm.elements).forEach(element => {
            switch(element.id) {
                case "email":
                    if(!checkEmail(element)) {
                        allInputFieldsValid = false;
                    }
                    break;
                case "password":
                    if(!checkPassword(element)) {
                        allInputFieldsValid = false;
                    }
                    break;
                case "password-confirm":
                    if(!checkConfirmPassword(element)) {
                        allInputFieldsValid = false;
                    }
                    break;
            }
        });

        if (allInputFieldsValid) {
            $("#resetPasswordForm").submit();

        } else console.log("something went wrong");
    });
}

const checkInputField = (element) => {
    switch(element.id) {
      case "email":
        checkEmail(element);
        break;
      case "password":
        checkPassword(element);
        break;
      case "password-confirm":
        checkConfirmPassword(element);
        break;
    }
  }