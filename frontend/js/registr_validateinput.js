function validaceRegistrace() {
    let form = document.forms["Registration"];
    let surname = document.forms["surname"].value;
    let name = document.forms["name"].value;
    let email = document.forms["email"].value;
    let phone = document.forms["phone"].value;
    let password = document.forms["password"].value;
    let confirm_password = document.forms["confirm_password"].value;

    if (surname === "") {
        alert("Zadejte své příjmení!");
        return false;
    }

    if (name === "") {
        alert("Zadejte své jméno!");
        return false;
    }

    if (email === "") {
        alert("Zadejte svůj e-mail!");
        return false;
    }

    if (email.indexOf("@") == -1) {
        alert("E-mail není ve správném formátu!");
        return false;
    }

    if (email.includes(".") == -1) {
        alert("V e-mailu chybí tečka!");
        return false;
    }


    if (phone === "") {
        alert("Zadejte telefonní číslo!");
        return false;
    }


    // Ищем большую букву
    let maVelke = /[A-Z]/.test(password);
    if (maVelke === false) {
        alert("Heslo musí obsahovat alespoň jedno velké písmeno!");
        return false;
    }

    // Ищем цифру
    let maCislo = /[0-9]/.test(password);
    if (maCislo === false) {
        alert("Heslo musí obsahovat alespoň jednu číslici!");
        return false;
    }

    // Проверяем подтверждение пароля
    if (password !== confirm_password) {
        alert("Hesla se neshodují!");
        return false;
    }

    // 7. Отправка на сервер (чтобы не перезагружать страницу)
    // let formData = new FormData(form);
    // let response = await fetch('php/registrovat.php', {
    //     method: 'POST',
    //     body: formData
    // });

    // let result = await response.json();

    // if (result.status === "email_obsazen") {
    //     alert("Tento e-mail už někdo používá, zadejte jiný!");
    //     return false;
    // }

    // if (result.status === "ok") {
    //     window.location.href = "ucet.php";
    // }

    return false;
}