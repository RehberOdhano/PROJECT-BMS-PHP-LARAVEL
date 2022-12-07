const checkName = (name) => {
    let valid = false;
    const Name = name.value.trim();
    if (!isrequired(Name)) {
        displayErrorMsg(name, 'Name can\'t be empty.');
    } else if (!isStrValid(Name)) {
        displayErrorMsg(name, 'Name is not valid.');
    } else {
        displaySuccessMsg(name);
        valid = true;
    }
    return valid;
};

const checkBio = (bio) => {
    let valid = false;
    const Bio = bio.value.trim();
    if (!isrequired(Bio)) {
        displayErrorMsg(bio, 'Bio cannot be blank.');
    } else if (!isStrValid(Bio)) {
        displayErrorMsg(bio, 'Bio is not valid.');
    } else {
        displaySuccessMsg(bio);
        valid = true;
    }
    return valid;
};

const checkEmail = (email) => {
    let valid = false;
    const Email = email.value.trim();
    if (!isrequired(Email)) {
        displayErrorMsg(email, 'Email can\'t be empty');
    } else if (!isEmailValid(Email)) {
        displayErrorMsg(email, 'Email is not valid.');
    } else {
        displaySuccessMsg(email);
        valid = true;
    }
    return valid;
};

const checkCity = (city) => {
    let valid = false;
    const City = city.value.trim();
    if (!isrequired(City)) {
        displayErrorMsg(city, 'City can\'t be empty.');
    } else if (!isStrValid(City)) {
        displayErrorMsg(city, 'City is not valid.');
    } else {
        displaySuccessMsg(city);
        valid = true;
    }
    return valid;
};

const checkContact = (contact) => {
    let valid = false;
    const Contact = contact.value.trim();
    if (!isrequired(Contact)) {
        displayErrorMsg(contact, 'Contact can\'t be empty.');
    } else if (!isContactValid(Contact)) {
        displayErrorMsg(contact, 'Contact is not valid.');
    } else {
        displaySuccessMsg(contact);
        valid = true;
    }
    return valid;
};

const checkProfileFile = (file) => {
    let valid = false;
    const checkFile = file.value.trim();
    if (!isrequired(checkFile)) {
        displayErrorMsg(file, 'File can\'t be empty.');
    } else if (!isProfileFileValid(checkFile)) {
        displayErrorMsg(file, 'File is not valid.');
    } else {
        displaySuccessMsg(file);
        valid = true;
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

const isProfileFileValid = (file) => {
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
                    if(!checkProfileFile(element)) {
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