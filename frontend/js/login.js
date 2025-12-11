const form = document.querySelector("form");
const inputEmail = document.querySelector("#email");
const inputPassword = document.querySelector("#password");

function validate_email(email) {
    const emailRegex = new RegExp(
        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );

    if (typeof email !== 'string') return false;

    return emailRegex.test(String(email).toLowerCase());
}

function validate_password(password) {
    const failures = [];

    // Ensure it's a string before testing
    if (typeof password !== 'string') {
        failures.push('password must be a string.');
        return failures;
    }

    // 1. Minimum Length (.{8,})
    const minLengthPattern = /.{8,}/;
    if (!minLengthPattern.test(password)) {
        failures.push('password must be at least 8 characters long');
    }

    // 2. Uppercase Letter ([A-Z])
    const uppercasePattern = /[A-Z]/;
    if (!uppercasePattern.test(password)) {
        failures.push('password must contain at least one uppercase letter (A-Z)');
    }

    // 3. Lowercase Letter ([a-z])
    const lowercasePattern = /[a-z]/;
    if (!lowercasePattern.test(password)) {
        failures.push('password must contain at least one lowercase letter (a-z)');
    }

    // 4. Digit (\d or [0-9])
    const digitPattern = /\d/;
    if (!digitPattern.test(password)) {
        failures.push('password must contain at least one number (0-9)');
    }

    return failures;
}

form.addEventListener("submit", (e) => {
    errors = []
    if (!validate_email(inputEmail.value)) {
        e.preventDefault();
        errors.push("email is invalid");
    }
    password_errors = validate_password(inputPassword.value)
    if (password_errors.length !== 0) {
        e.preventDefault();
        errors = [...errors, ...password_errors];
    }

    if (errors.length === 0) {
        window.location.replace("../index.php");
        return;
    }
    e.preventDefault();
    alert(errors.join(", "));
});