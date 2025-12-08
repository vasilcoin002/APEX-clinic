function validateUser() {
    let username = document.forms["login"]["username"].value;
    let password = document.forms["login"]["password"].value;

    // Проверка логина
    if (username === "") {
        alert("Uživatelské jméno musí být vyplněno!"); 
        return false; // Останавливаем отправку формы
    }

    // Проверка пароля
    if (password === "") {
        alert("Heslo musí být vyplněno!"); 
        return false; // Останавливаем отправку формы
    }
    // Если обе проверки пройдены успешно, форма отправится
    return true; 
}

function validateDataAdmin() {
    let admin_name = document.forms["login"]["admin_name"].value;
    let password = document.forms["login"]["password"].value;

    if (admin_name === "") {
        alert("Jméno administrátora musí být vyplněno!"); 
        return false; 
    }

    if (password === "") {
        alert("Heslo musí být vyplněno!"); 
        return false; 
    }
    return true; 
}