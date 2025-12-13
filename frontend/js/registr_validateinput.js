// Функция для подсветки поля с ошибкой


function highlightField(fieldId) {
    const field = document.getElementById(fieldId);
    field.classList.add("error-border");
}

function validateRegistrationForm(event) {
    event.preventDefault(); // Останавливаем отправку формы
    let fields = ["surname", "name", "email", "phone", "password", "confirm_password"];
    fields.forEach(function(id) {
        document.getElementById(id).classList.remove("error-border");
    });

    document.getElementById("email").style.border = "";

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

    // let userData = {
    //     surname: surname,
    //     name: name,
    //     email: email,
    //     phone: phone,
    //     password: password
    // };
}

let surnameInput = document.getElementById("surname");
let nameInput = document.getElementById("name");
let emailInput = document.getElementById("email");
let phoneInput = document.getElementById("phone");
let passwordInput = document.getElementById("password");
let confirmPasswordInput = document.getElementById("confirm_password");

const form = document.querySelector("form");
form.addEventListener("submit", validateRegistrationForm)