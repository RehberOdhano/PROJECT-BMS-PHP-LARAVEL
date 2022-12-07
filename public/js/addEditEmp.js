const checkEmployeeName = (empName) => {
    let valid = false;
    const checkEmpName = empName.value.trim();
    if (!isRequired(checkEmpName)) {
        showError(empName, 'Name cannot be empty.');
    } else if (!isValid(checkEmpName)) {
        showError(empName, 'Name is not valid. Name contains only lowercase and upper case letters and (,.-).');
    } else {
        showSuccess(empName);
        valid = true;
    }
    return valid;
};

const checkEmployeeDesignation = (designation) => {
    let valid = false;

    const checkEmpDesignation = designation.value.trim();
    if (!isRequired(checkEmpDesignation)) {
        showError(designation, 'Designation cannot be empty.');
    } else if (!isValid(checkEmpDesignation)) {
        showError(designation, 'Designation is not valid. Designation contains only lowercase and upper case letters and (,.-).');
    } else {
        showSuccess(designation);
        valid = true;
    }

    return valid;
};

const checkEmployeeDept = (dept) => {
    let valid = false;

    const checkEmpDept = dept.value.trim();
    if (!isRequired(checkEmpDept)) {
        showError(dept, 'Department cannot be empty.');
    } else if (!isValid(checkEmpDept)) {
        showError(dept, 'Department is not valid. Department contains only lowercase and upper case letters and (,.-).');
    } else {
        showSuccess(dept);
        valid = true;
    }

    return valid;
};

const checkEmployeeContact = (contact) => {
    let valid = false;

    const checkEmpContact = contact.value.trim();

    if (!isRequired(checkEmpContact)) {
        showError(contact, 'Contact cannot be empty.');
    } else if (!isContactValid(checkEmpContact)) {
        showError(contact, 'Contact is not valid. It should be in the format: 03301293789');
    } else {
        showSuccess(contact);
        valid = true;
    }

    return valid;
};

const checkDate = (date) => {
    let valid = false;

    const checkDate = date.value.trim();

    if (!isRequired(checkDate)) {
        showError(date, 'Date cannot be empty.');
    } else {
        showSuccess(date);
        valid = true;
    }

    return valid;
};

const checkEmployeeSalary = (salary) => {
    let valid = false;

    const checkSalary = salary.value.trim();

    if (!isRequired(checkSalary)) {
        showError(salary, 'Salary cannot be empty.');
    } else if (!isSalaryValid(checkSalary)) {
        showError(salary, 'Salary is not valid. It should be a positive decimal number, e.g. 50.00, 5000, etc');
    } else {
        showSuccess(salary);
        valid = true;
    }

    return valid;
};

const isValid = (input) => {
    const re = /^[a-zA-Z0-9_ \.'-]*$/gm;
    return re.test(input);
};

const isContactValid = (contact) => {
    // const re = /^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{7}$/gm;
    const re = /^[0-9]{11}$/;
    return re.test(contact);
}

// const isDateValid = (date) => {
//     const re = "";
//     return re.test(date);
// }

const isSalaryValid = (salary) => {
    const re = /^(?!0+(?:\.0+)?$)[0-9]+(?:\.[0-9]+)?$/gm;
    return re.test(salary);
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

const submitEmployeeForm = (id) => {
    const employeeForm = document.getElementById("employeeForm" + id);
    employeeForm.addEventListener('submit', function(e) {
        // prevent the form from submitting
        e.preventDefault();
        
        var allInputFieldsValid = true;
        Array.from(employeeForm.elements).forEach(element => {
            switch(element.id) {
                case "name" + id:
                    if(!checkEmployeeName(element)) {
                        allInputFieldsValid = false;
                    }
                    break;
                case "designation" + id:
                    if(!checkEmployeeDesignation(element)) {
                        allInputFieldsValid = false;
                    }
                    break;
                case "dept" + id:
                    if(!checkEmployeeDept(element)) {
                        allInputFieldsValid = false;
                    }
                    break;
                case "contact" + id:
                    if(!checkEmployeeContact(element)) {
                        allInputFieldsValid = false;
                    }
                    break;
                case "salary" + id:
                    if(!checkEmployeeSalary(element)) {
                        allInputFieldsValid = false;
                    }
                    break;
                case "date" + id:
                    if(!checkDate(element)) {
                        allInputFieldsValid = false;
                    }
                    break;
            }
        });

        if (allInputFieldsValid) {
            $("#employeeForm" + id).submit();

        } else console.log("something went wrong");
    });
}
