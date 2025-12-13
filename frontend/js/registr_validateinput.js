// Функция для подсветки поля с ошибкой

function highlightField(fieldId) {
    const field = document.getElementById(fieldId);
    field.classList.add("error-border");
}

async function handleExceptionResponse(response) {
    const data = await response.json();
    console.log(data);
    
    inputNames = Object.keys(data);
    inputNames.forEach(function (inputName) {
        highlightField(inputName);
        document.getElementById(inputName + "-error-message").innerText = data[inputName];
    });
}

async function handleResponse(response) {
    if (response.status !== 200) {
        handleExceptionResponse(response);
        return;
    }

    console.log(response);
    
    window.location.replace("frmLogin.php");
}

function validateRegistrationForm(event) {
    event.preventDefault(); // Останавливаем отправку формы
    let fields = ["surname", "name", "email", "phone", "password", "confirm_password"];
    fields.forEach(function(id) {
        document.getElementById(id).classList.remove("error-border");
    });

    let errorMessages = ["surname-error-message", "name-error-message", "email-error-message", "phone-error-message", "password-error-message", "confirm_password-error-message"];
    errorMessages.forEach(function(id) {
        // Устанавливаем текст ошибки в пустую строку
        document.getElementById(id).innerText = ""; 
    });
    // **


    let hasError = false;
    if (surnameInput.value === "") {
        document.getElementById("surname-error-message").innerText = "Příjmení musí být vyplněno!";
        highlightField("surname");
        hasError = true;
    }

    if (nameInput.value === "") {
        document.getElementById("name-error-message").innerText = "Jméno musí být vyplněno!";
        highlightField("name");
        hasError = true;
    }

    // (Регулярное выражение для проверки телефона: С плюсом ИЛИ только цифры ИЛИ пустая строка)
    const phoneNumberRegex = /^(\+\d+|\d*)$/;
    if (!phoneNumberRegex.test(phoneInput.value)) {
        document.getElementById("phone-error-message").innerText = "Telefonní číslo by nemělo obsahovat nic jiného než číslice a znamenko +";
        highlightField("phone");
        hasError = true;
    }

    if (emailInput.value === "") {
        document.getElementById("email-error-message").innerText = "E-mail musí být vyplněno!";
        highlightField("email");
        hasError = true;
    }

    if (passwordInput.value === "") {
        document.getElementById("password-error-message").innerText = "Heslo musí být vyplněno!";
        highlightField("password");
        hasError = true;
    }

    const password = passwordInput.value

    const isLengthValid = /.{8,}/.test(password);
    // 2. Проверка заглавной буквы
    const hasUpperCase = /[A-Z]/.test(password);
    // 3. Проверка строчной буквы
    const hasLowerCase = /[a-z]/.test(password);
    // 4. Проверка цифры
    const hasDigit = /\d/.test(password);
    // Общий результат проверки
    const isValid = isLengthValid && hasUpperCase && hasLowerCase && hasDigit;
    if (!isValid) {
        const messages = [];
        if (!isLengthValid) messages.push("musí být minimálně 8 symbolů dlouhé");
        if (!hasUpperCase) messages.push("musí obsahovat velké písmeno");
        if (!hasLowerCase) messages.push("musí obsahovat malé písmeno");
        if (!hasDigit) messages.push("musí obsahovat číslici");

        let message = "Heslo je příliš slabé: " + messages.join(", ");

        document.getElementById("password-error-message").innerText = message;
        highlightField("password");
        hasError = true;

    }

    if (confirmPasswordInput.value === "") {
        document.getElementById("confirm_password-error-message").innerText = "Potvrzení hesla musí být vyplněno!";
        highlightField("confirm_password");
        hasError = true;
    }

    if (passwordInput.value !== confirmPasswordInput.value) {
        document.getElementById("confirm_password-error-message").innerText = "Hesla se neshodují!";
        document.getElementById("password-error-message").innerText = "Hesla se neshodují!";
        highlightField("password");
        highlightField("confirm_password");
        hasError = true;
    }

    if (hasError) {
        return false;
    }

    let userData = {
        surname: surnameInput.value,
        name: nameInput.value,
        email: emailInput.value,
        phone_number: phoneInput.value,
        password: passwordInput.value,
        action: "register",
    };

    const formData = new FormData();
    formData.append("action", "register");
    formData.append("email", emailInput.value);
    formData.append("password", password);
    formData.append("phone", phoneInput.value);
    formData.append("name", nameInput.value);
    formData.append("surname", surnameInput.value);
    // let request = new XMLHttpRequest();
    // request.addEventListener("load", function (e) {
    //     console.log(e.target.responseText);
    // });
    // request.open("POST", "../users/userController.php", true);
    // request.setRequestHeader("Content-Type", "application/json");
    // request.send(JSON.stringify(userData));

    fetch('../users/userController.php', {
            method: "POST",
            body: formData
    })
    .then((response) => handleResponse(response));

}

let surnameInput = document.getElementById("surname");
let nameInput = document.getElementById("name");
let emailInput = document.getElementById("email");
let phoneInput = document.getElementById("phone");
let passwordInput = document.getElementById("password");
let confirmPasswordInput = document.getElementById("confirm_password");

const form = document.querySelector("form");
form.addEventListener("submit", validateRegistrationForm)