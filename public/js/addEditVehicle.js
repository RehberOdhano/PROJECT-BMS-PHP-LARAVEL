const checkVehicleNumPlate = (num_plate) => {
    var valid = false;
    const checkNumberPlate = num_plate.value.trim();
    if (!isRequired(checkNumberPlate)) {
        showError(num_plate, "Vehicle registration number can't be empty.");
    } else if (!isValidNumberPlate(checkNumberPlate)) {
        showError(num_plate, "Vehicle registration number isn't valid. Registration number consists of only digits, lowercase and uppercase letters and maximum of 10 characters.");
    } else {
        showSuccess(num_plate);
        valid = true;
    }
    return valid;
}

const isRequired = value => value === '' ? false : true;

const isValidNumberPlate = (num_plate) => {
    const re = /^([a-zA-Z0-9]){1,10}$/;
    return re.test(num_plate);
}

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

const submitVehicleForm = (id) => {
    const vehicleForm = document.getElementById("vehicleForm" + id);
    vehicleForm.addEventListener('submit', function(e) {
        // prevent the form from submitting
        e.preventDefault();
        
        var allInputFieldsValid = true;
        Array.from(vehicleForm.elements).forEach(element => {
            switch(element.id) {
                case "numPlate" + id:
                    if(!checkVehicleNumPlate(element)) {
                        allInputFieldsValid = false;
                    }
                    break;
            }
        });

        if (allInputFieldsValid) {
            $("#vehicleForm" + id).submit();

        } else console.log("something went wrong");
    });
}
