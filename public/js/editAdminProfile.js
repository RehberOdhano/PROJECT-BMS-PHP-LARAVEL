const checkName = (name) => {
    let valid = false;
    const checkName = name.value.trim();
    if (!isrequired(checkName)) {
        displayErrorMsg(name, 'Name cannot be blank.');
    } else if (!isStrValid(checkName)) {
        displayErrorMsg(name, 'Name is not valid.');
    } else {
        displaySuccessMsg(name);
        valid = true;
    }
    return valid;
};

const checkBio = (bio) => {
    let valid = true;
    const checkbio = bio.value.trim();
    if (checkbio != "") {
        if (!isStrValid(checkbio)) {
            displayErrorMsg(bio, 'Bio is not valid.');
        } else {
            displaySuccessMsg(bio);
            valid = true;
        }
    }

    return valid;
};

const checkEmail = (email) => {
    let valid = true;
    const checkEmail = email.value.trim();
    if (checkEmail != "") {
        if (!isEmailValid(checkEmail)) {
            displayErrorMsg(email, 'Email is not valid.');
        } else {
            displaySuccessMsg(email);
            valid = true;
        }
    }

    return valid;
};

const checkCity = (city) => {
    let valid = true;
    const checkCity = city.value.trim();
    if (checkCity != "") {
        if (!isStrValid(checkCity)) {
            displayErrorMsg(city, 'City is not valid.');
        } else {
            displaySuccessMsg(city);
            valid = true;
        }
    }

    return valid;
};

const checkContact = (contact) => {
    let valid = true;
    const checkContact = contact.value.trim();
    if (checkContact != "") {
        if (!isContactValid(checkContact)) {
            displayErrorMsg(contact, 'Contact is not valid.');
        } else {
            displaySuccessMsg(contact);
            valid = true;
        }
    }

    return valid;
};

const checkFile = (file) => {
    let valid = true;
    const checkFile = file.value.trim();
    if (checkFile != "") {
        if (!isFileNameValid(checkFile)) {
            displayErrorMsg(file, 'File is not valid.');
        } else {
            displaySuccessMsg(file);
            valid = true;
        }
    }

    return valid;
};

const isStrValid = (input) => {
    const re = /^[a-z ,.'-]+$/i;
    return re.test(input);
};

const isEmailValid = (email) => {
    const re = /^([a-z0-9\.-]+)@([a-z0-9-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/;
    return re.test(email);
};

const isContactValid = (contact) => {
    const re = /^[0-9]{11}$/;
    return re.test(contact);
}

const isFileNameValid = (file) => {
    const re = /([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.png)$/i;
    return re.test(file);
}

const isrequired = value => value === '' ? false : true;

const displayErrorMsg = (input, message) => {
    const formField = input.parentElement;
    input.classList.remove('success');
    input.classList.add('error');
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

const submitProfileForm = () => {
    const profileForm = document.getElementById("profileForm");
    profileForm.addEventListener('submit', function(e) {
        // prevent the form from submitting
        e.preventDefault();
        
        var allInputFieldsValid = true;
        Array.from(profileForm.elements).forEach(element => {
            switch(element.id) {
                case "name":
                    if(!checkName(element)) {
                        allInputFieldsValid = false;
                    }
                    break;
                case "email":
                    if(!checkEmail(element)) {
                        allInputFieldsValid = false;
                    }
                    break;
                case "bio":
                    if(!checkBio(element)) {
                        allInputFieldsValid = false;
                    }
                    break;
                case "contact":
                    if(!checkContact(element)) {
                        allInputFieldsValid = false;
                    }
                    break;
                case "city":
                    if(!checkCity(element)) {
                        allInputFieldsValid = false;
                    }
                    break;
                case "file":
                    if(!checkFile(element)) {
                        allInputFieldsValid = false;
                    }
                    break;
            }
        });

        if (allInputFieldsValid) {
            $("#profileForm").submit();

        } else console.log("something went wrong");
    });
}