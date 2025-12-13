function validateRegistrationForm(event) {
  event.preventDefault(); // Останавливаем отправку формы

    let surname = document.getElementById("surname").value;
    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let phone = document.getElementById("phone").value;
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirm_password").value;

    document.getElementById("errorMessage").innerText = "";
    document.getElementById("email").style.border = "";

    if (surname === "") {
    showError("Příjmení musí být vyplněno!");
    return false;
}

if (name === "") {
    showError("Jméno musí být vyplněno!");
    return false;
}

if (email === "") {
    showError("E-mail musí být vyplněn!");
    return false;
}

if (phone === "") {
    showError("Telefonní číslo musí být vyplněno!");
    return false;
}

if (password === "") {
    showError("Heslo musí být vyplněno!");
    return false;
}

if (confirmPassword === "") {
    showError("Potvrzení hesla musí být vyplněno!");
    return false;
}

if (password !== confirmPassword) {
    showError("Hesla se neshodují!");
    return false;
}

let userData = {
    surname: surname,
    name: name,
    email: email,
    phone: phone,
    password: password
};

fetch("register_handler.html", {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify(userData)
})
.then(function(response) {
    return response.json();
})
.then(function(data) {
    data = { error: "email_taken" };
    if (data.success === true) {
        alert("Registrace byla úspěšná!");
        document.forms["Registration"].reset();
}

else if (data.error === "email_taken") {
    showError("Tento e-mail je již používán, napište jiný.");
    document.getElementById("email").style.border = "2px solid red";
}

else {
    showError("Došlo k chybě. Zkuste to znovu.");
    }
})
.catch(function(error) {
    showError("Chyba připojení k serveru.");
});

return false;
}

function showError(message) {
    document.getElementById("errorMessage").innerText = message;
}
