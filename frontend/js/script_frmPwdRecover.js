// Добавляем обработчик события, который сработает, когда весь HTML загружен
document.addEventListener('DOMContentLoaded', (event) => {
    // Находим нашу форму по имени 'recovery'
    const recoveryForm = document.forms["recovery"];

    // Добавляем слушатель события 'submit' (отправка формы)
    recoveryForm.addEventListener('submit', function (e) {

        e.preventDefault(); // !!! КЛЮЧЕВОЙ ШАГ: Отменяем стандартное действие формы (перезагрузку страницы)

        let username = recoveryForm["username"].value;
        let email = recoveryForm["email"].value;

        // --- Проверки (валидация) ---
        if (username === "") {
            alert("Uživatelské jméno musí být vyplněno!");
            return; // Просто выходим из функции, данные остаются в полях
        }

        if (email === "") {
            alert("Email musí být vyplněn!");
            return;
        }

        if (!email.includes("@")) {
            alert("Zadejte platnou e-mailovou adresu (musí obsahovat '@')!");
            return;
        }
        
        // --- Если проверки пройдены ---
        alert("Zadané údaje byly odeslány k ověření."); 

        // Теперь вы можете отправить данные на сервер с помощью AJAX (fetch API), 
        // не перезагружая страницу.

        // Если вы хотите перенаправить пользователя после успешной отправки:
        window.location.replace("index.html"); 
    });
});