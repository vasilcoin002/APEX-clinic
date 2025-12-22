import { Validators } from './validators.js';

function highlightField(fieldId) {
    const field = document.getElementById(fieldId);
    field.classList.add("error-border");
}

async function handleExceptionResponse(response) {
    const data = await response.json();
    // Если произошла ошибка на сервере, нужно снова включить кнопку
    const submitBtn = document.querySelector(".submitBtn");
    if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerText = "Registrovat se";
    }
    const inputNames = Object.keys(data);
    inputNames.forEach(function (inputName) {
        highlightField(inputName);

        const errorElement = document.getElementById(inputName + "-error-message");
        if(errorElement) errorElement.innerText = data[inputName];
    });
}

async function handleResponse(response) {
    if (response.status !== 200) {
        await handleExceptionResponse(response);
        return;
    }
    
    window.location.replace("frmLogin.php");
}

function setFieldError(fieldId, message) {
    const errorElement = document.getElementById(`${fieldId}-error-message`);
    const fieldElement = document.getElementById(fieldId);
    
    if (errorElement) errorElement.innerText = message;
    
    if (typeof highlightField === "function") {
        highlightField(fieldId);
    } else if (fieldElement) {
        fieldElement.classList.add("error-border");
    }
}

function clearErrors(fields) {
    fields.forEach(id => {
        const field = document.getElementById(id);
        const errorMessage = document.getElementById(`${id}-error-message`);
        if(field) field.classList.remove("error-border");
        if(errorMessage) errorMessage.innerText = "";
    });
}

export function validateRegistrationForm(event) {
    event.preventDefault();
    
    const submitBtn = document.querySelector(".submitBtn");
    
    const inputs = {
        surname: document.getElementById('surname'),
        name: document.getElementById('name'),
        phone: document.getElementById('phone'),
        email: document.getElementById('email'),
        password: document.getElementById('password'),
        confirm: document.getElementById('confirm-password')
    };

    const fieldNames = ["surname", "name", "email", "phone", "password", "confirm-password"];
    clearErrors(fieldNames);

    let hasError = false;

    // 1. Проверка если заполнены все необходимые поля
    if (!Validators.isRequired(inputs.surname.value)) {
        setFieldError("surname", "Příjmení musí být vyplněno!");
        hasError = true;
    }

    if (!Validators.isRequired(inputs.name.value)) {
        setFieldError("name", "Jméno musí být vyplněno!");
        hasError = true;
    }

    if (!Validators.isRequired(inputs.email.value)) {
        setFieldError("email", "E-mail musí být vyplněno!");
        hasError = true;
    }

    // 2. Валидация телефона
    if (!Validators.isRequired(inputs.phone.value)) {
        setFieldError("phone", "Telefonní číslo musí být vyplněno!");
        hasError = true;
    } else if (!Validators.isValidPhone(inputs.phone.value)) {
        setFieldError("phone", "Telefonní číslo musí obsahovat číslice");
        hasError = true;
    }

    // 3. Валидация пароля
    if (!Validators.isRequired(inputs.password.value)) {
        setFieldError("password", "Heslo musí být vyplněno!");
        hasError = true;
    } else {
        const passCheck = Validators.getPasswordErrors(inputs.password.value);
        
        if (!passCheck.isValid) {
            const messages = [];
            if (passCheck.missing.includes("length")) messages.push("musí být minimálně 8 symbolů dlouhé");
            if (passCheck.missing.includes("uppercase")) messages.push("musí obsahovat velké písmeno");
            if (passCheck.missing.includes("lowercase")) messages.push("musí obsahovat malé písmeno");
            if (passCheck.missing.includes("digit")) messages.push("musí obsahovat číslici");

            setFieldError("password", "Heslo je příliš slabé: " + messages.join(", "));
            hasError = true;
        }
    }

    // 4. Проверка если оба поля с паролями одинаковые
    if (!Validators.isRequired(inputs.confirm.value)) {
        setFieldError("confirm-password", "Potvrzení hesla musí být vyplněno!");
        hasError = true;
    } else if (!Validators.doPasswordsMatch(inputs.password.value, inputs.confirm.value)) {
        setFieldError("confirm-password", "Hesla se neshodují!");
        setFieldError("password", "Hesla se neshodují!");
        hasError = true;
    }

    if (hasError) return false;

    const formData = new FormData();
    formData.append("action", "register");
    formData.append("surname", inputs.surname.value);
    formData.append("name", inputs.name.value);
    formData.append("email", inputs.email.value);
    formData.append("phone", inputs.phone.value);
    formData.append("password", inputs.password.value);

    submitBtn.disabled = true;
    submitBtn.innerText = "Probíhá registrace...";

    fetch('../users/userController.php', {
            method: "POST",
            body: formData
    })
    .then((response) => handleResponse(response))
    .catch((error) => {
        console.error('Error:', error);
        submitBtn.disabled = false;
        submitBtn.innerText = "Registrovat se";
    });
}

const form = document.querySelector("form");
form.addEventListener("submit", validateRegistrationForm);