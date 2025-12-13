// Функция для подсветки поля с ошибкой
function highlightField(fieldId) {
    const field = document.getElementById(fieldId);
    field.classList.add("error-border");
}

function validateLoginForm(event) {
    event.preventDefault(); // Останавливаем отправку формы

    // Убираем старую подсветку
    let fields = ["email", "password"];
    fields.forEach(function(id) {
        document.getElementById(id).classList.remove("error-border");
    });

    // Очищаем старые сообщения об ошибках
    let errorMessages = ["email-error-message", "password-error-message"];
    errorMessages.forEach(function(id) {
        document.getElementById(id).innerText = "";
    });

    let hasError = false;

    // Проверка email
    if (loginEmailInput.value === "") {
        document.getElementById("email-error-message").innerText = "E-mail musí být vyplněn!";
        highlightField("email");
        hasError = true;
    }

    // Проверка пароля
    if (loginPasswordInput.value === "") {
        document.getElementById("password-error-message").innerText = "Heslo musí být vyplněno!";
        highlightField("password");
        hasError = true;
    }

    if (hasError) {
        return false;
    }

    // Имитируем проверку на сервере
    // Здесь ты потом заменишь на fetch(...)
    const serverResponse = {
        error: "email_exists" // ← тестовая ошибка
    };

    if (serverResponse.error === "email_exists") {
        document.getElementById("email-error-message").innerText =
            "Tento e-mail již existuje!";
        highlightField("email");
        return false;
    }

    // Если всё хорошо — можно отправлять форму
    // form.submit(); ← если понадобится
}

// Получаем поля
let loginEmailInput = document.getElementById("email");
let loginPasswordInput = document.getElementById("password");

// Вешаем обработчик
const loginForm = document.querySelector("form");
loginForm.addEventListener("submit", validateLoginForm);
