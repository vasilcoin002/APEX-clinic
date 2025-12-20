// Функция для подсветки поля с ошибкой
function highlightField(fieldId) {
    const field = document.getElementById(fieldId);
    field.classList.add("error-border");
}

async function handleExceptionResponse(response) {
    const data = await response.json();
    const submitBtn = document.querySelector(".submitBtn");
    if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerText = "Přihlásit se";
    }

    inputNames = Object.keys(data);
    inputNames.forEach(function (inputName) {
        highlightField(inputName);
        const errorElement = document.getElementById(inputName + "-error-message");
        errorElement.innerText = data[inputName];
    });
}

async function handleResponse(response) {
    if (response.status !== 200) {
        await handleExceptionResponse(response);
        return;
    }
    
    window.location.replace("index.php");
}

function validateLoginForm(event) {
    event.preventDefault(); // Останавливаем отправку формы
    const submitBtn = document.querySelector(".submitBtn");
    let fields = ["email", "password"];
// сброс старых ошибок и рамок
    fields.forEach(function(id) {
        const field = document.getElementById(id);
        const errorMessage = document.getElementById(id + "-error-message");
        if(field) field.classList.remove("error-border");
        if(errorMessage) errorMessage.innerText = "";
    });

    let hasError = false;

    // Проверка email
    if (emailInput.value === "") {
        document.getElementById("email-error-message").innerText = "E-mail musí být vyplněn!";
        highlightField("email");
        hasError = true;
    }

    // Проверка пароля
    if (passwordInput.value === "") {
        document.getElementById("password-error-message").innerText = "Heslo musí být vyplněno!";
        highlightField("password");
        hasError = true;
    }

    if (hasError) {
        return false;
    }


    submitBtn.disabled = true;
    submitBtn.innerText = "Přihlašování...";

    const formData = new FormData();
    formData.append("action", "login");
    formData.append("email", emailInput.value);
    formData.append("password", passwordInput.value);

    fetch('../users/userController.php', {
            method: "POST",
            body: formData
    })
    .then((response) => handleResponse(response))
    .catch((error) => {
        console.error('Error:', error);
        submitBtn.disabled = false;
        submitBtn.innerText = "Přihlásit se";
    });

}

// Получаем поля
let emailInput = document.getElementById("email");
let passwordInput = document.getElementById("password");


// Вешаем обработчик
const form = document.querySelector("form");
form.addEventListener("submit", validateLoginForm);