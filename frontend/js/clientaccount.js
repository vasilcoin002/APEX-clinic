import { Validators } from './validators.js';

function showError(elementId, message) {
    const errorElement = document.getElementById(elementId);
    if (errorElement) errorElement.textContent = message;
    const inputId = elementId.replace("-error-message", ""); 
    highlightField(inputId);
}

function clearError(elementId) {
    const errorElement = document.getElementById(elementId);
    if (errorElement) errorElement.textContent = '';
    const inputId = elementId.replace("-error-message", "");
    const field = document.getElementById(inputId);
    if (field) field.classList.remove("error-border");
}

function highlightField(fieldId) {
    const field = document.getElementById(fieldId);
    if (field) field.classList.add("error-border");
}

function disableAllButtons() {
    allButtons.forEach(button => button.disabled = true);
}

function enableAllButtons() {
    allButtons.forEach(button => button.disabled = false);
}

async function handleExceptionResponse(response) {
    const data = await response.json();
    
    const inputNames = Object.keys(data);
    inputNames.forEach(function (inputName) {
        console.log(inputName);

        highlightField(inputName);
        const errorId = inputName + "-error-message";
        const errorEl = document.getElementById(errorId);
        if(errorEl) errorEl.textContent = data[inputName];
    });
    enableAllButtons();
}

async function handleResponse(response) {
    if (!response.ok) {
        handleExceptionResponse(response);
        return;
    }
    window.location.reload();
}

const avatarInput = document.querySelector('#avatar-upload');
const emailInput = document.querySelector("#email");
const passwordInput = document.querySelector("#password");
const confirmPasswordInput = document.querySelector("#confirm-password");
const nameInput = document.querySelector("#name");
const surnameInput = document.querySelector("#surname");
const telefonInput = document.querySelector("#phone");
const notesInput = document.querySelector("#comment");

const avatarPreview = document.querySelector('#user-avatar-placeholder');
const avatarForm = document.querySelector('#avatar-form');
const emailForm = document.querySelector("#email-form");
const passwordForm = document.querySelector("#password-form");
const personalDataForm = document.querySelector("#personal-data-form");

const updateAvatarBtn = avatarForm.querySelector('#update-avatar-button');
const deleteAvatarBtn = avatarForm.querySelector('#delete-avatar-button');
const updateEmailBtn = emailForm.querySelector("button");
const updatePasswordBtn = passwordForm.querySelector("button");
const updatePersonalDataBtn = personalDataForm.querySelector("button");
const logoutBtn = document.querySelector("#logout-form").querySelector("button");

const allButtons = document.querySelectorAll("button");
const allForms = document.querySelectorAll("form");
allForms.forEach(form => form.addEventListener("submit", e => e.preventDefault()));

const AVATAR_ERROR_ID = 'avatar-error-message';
const EMAIL_ERROR_ID = 'email-error-message';
const PASSWORD_ERROR_ID = 'password-error-message';
const CONFIRM_PASSWORD_ERROR_ID = 'confirm-password-error-message';
const NAME_ERROR_ID = 'name-error-message';
const SURNAME_ERROR_ID = 'surname-error-message';
const PHONE_ERROR_ID = 'phone-error-message';
const COMMENT_ERROR_ID = 'comment-error-message'

const USER_CONTROLLER_PATH = '../users/userController.php';

// Avatar logic
const MAX_SIZE = 16 * 1024 * 1024; // 16MB
const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/gif'];

avatarInput.addEventListener('change', function(event) {
    clearError(AVATAR_ERROR_ID);
    
    const file = event.target.files[0];
    if (!file) return;

    if (!ALLOWED_TYPES.includes(file.type)) {
        showError(AVATAR_ERROR_ID, 'Chyba: Vyberte prosím obrázek ve formátu JPG, PNG nebo GIF.');
        avatarInput.value = ''; 
        return;
    }

    if (file.size > MAX_SIZE) {
        showError(AVATAR_ERROR_ID, 'Chyba: Obrázek je příliš velký (max 16MB).');
        avatarInput.value = ''; 
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        avatarPreview.src = e.target.result;
    };
    reader.readAsDataURL(file);
});

updateAvatarBtn.addEventListener('click', function() {
    clearError(AVATAR_ERROR_ID);

    if (!avatarInput.files.length) {
        showError(AVATAR_ERROR_ID, 'Prosím, nejprve vyberte obrázek kliknutím na avatar.');
        return;
    }

    const formData = new FormData(avatarForm);
    formData.append("action", "update-avatar");

    disableAllButtons();
    fetch(USER_CONTROLLER_PATH, {
        method: 'POST',
        body: formData
    })
    .then(response => handleResponse(response));
});

deleteAvatarBtn.addEventListener('click', function() {
    clearError(AVATAR_ERROR_ID);

    const formData = new FormData();
    formData.append("action", "delete-avatar");

    disableAllButtons();
    fetch(USER_CONTROLLER_PATH, {
        method: 'POST',
        body: formData
    })
    .then(response => handleResponse(response));
});

// Email Logic
updateEmailBtn.addEventListener('click', function() {
    clearError(EMAIL_ERROR_ID);

    const emailValue = emailInput.value;
    let hasError = false;

    if (!Validators.isRequired(emailValue)) {
        showError(EMAIL_ERROR_ID, "E-mail musí být vyplněno!");
        hasError = true;
    } else if (!Validators.isValidEmail(emailValue)) {
        showError(EMAIL_ERROR_ID, "E-mail není ve správném formátu!");
        hasError = true;
    }

    if (hasError) return;

    const formData = new FormData(emailForm);
    formData.append("action", "update-email");

    disableAllButtons();
    fetch(USER_CONTROLLER_PATH, {
        method: 'POST',
        body: formData
    })
    .then(response => handleResponse(response));
});

// Password Logic
updatePasswordBtn.addEventListener("click", function() {
    clearError(PASSWORD_ERROR_ID);
    clearError(CONFIRM_PASSWORD_ERROR_ID);

    const passValue = passwordInput.value;
    const confirmValue = confirmPasswordInput.value;
    let hasError = false;

    // 1. Required Check
    if (!Validators.isRequired(passValue)) {
        showError(PASSWORD_ERROR_ID, "Heslo musí být vyplněno!");
        hasError = true;
    } else {
        // 2. Complexity Check
        const passCheck = Validators.getPasswordErrors(passValue);
        if (!passCheck.isValid) {
            const messages = [];
            if (passCheck.missing.includes("length")) messages.push("musí být minimálně 8 symbolů dlouhé");
            if (passCheck.missing.includes("uppercase")) messages.push("musí obsahovat velké písmeno");
            if (passCheck.missing.includes("lowercase")) messages.push("musí obsahovat malé písmeno");
            if (passCheck.missing.includes("digit")) messages.push("musí obsahovat číslici");

            showError(PASSWORD_ERROR_ID, "Heslo je příliš slabé: " + messages.join(", "));
            hasError = true;
        }
    }

    // 3. Confirm Required
    if (!Validators.isRequired(confirmValue)) {
        showError(CONFIRM_PASSWORD_ERROR_ID, "Potvrzení hesla musí být vyplněno!");
        hasError = true;
    }

    // 4. Matching Check
    if (!hasError && !Validators.doPasswordsMatch(passValue, confirmValue)) {
        showError(PASSWORD_ERROR_ID, "Hesla se neshodují!");
        showError(CONFIRM_PASSWORD_ERROR_ID, "Hesla se neshodují!");
        hasError = true;
    }

    if (hasError) return;

    const formData = new FormData();
    formData.append("password", passValue);
    formData.append("action", "update-password");

    disableAllButtons();
    fetch(USER_CONTROLLER_PATH, {
        method: 'POST',
        body: formData
    })
    .then(response => handleResponse(response));
})

// Personal Data Logic 
updatePersonalDataBtn.addEventListener("click", function() {
    clearError(NAME_ERROR_ID);
    clearError(SURNAME_ERROR_ID);
    clearError(PHONE_ERROR_ID);
    clearError(COMMENT_ERROR_ID);

    let hasError = false;

    // Validate Name
    if (!Validators.isRequired(nameInput.value)) {
        showError(NAME_ERROR_ID, "Jméno musí být vyplněno!");
        hasError = true;
    }

    // Validate Surname
    if (!Validators.isRequired(surnameInput.value)) {
        showError(SURNAME_ERROR_ID, "Příjmení musí být vyplněno!");
        hasError = true;
    }

    // Validate Phone
    if (!Validators.isRequired(telefonInput.value)) {
        showError(PHONE_ERROR_ID, "Telefonní číslo musí být vyplněno!");
        hasError = true;
    } else if (!Validators.isValidPhone(telefonInput.value)) {
        showError(PHONE_ERROR_ID, "Telefonní číslo musí obsahovat číslice");
        hasError = true;
    }

    if (hasError) return;

    const formData = new FormData(personalDataForm);
    formData.append("action", "update-profile");

    disableAllButtons();
    fetch(USER_CONTROLLER_PATH, {
        method: 'POST',
        body: formData
    })
    .then(response => handleResponse(response));
})

logoutBtn.addEventListener("click", function() {
    const formData = new FormData();
    formData.append("action", "logout");

    disableAllButtons();
    fetch(USER_CONTROLLER_PATH, {
        method: 'POST',
        body: formData
    })
    .then(response => handleResponse(response));
})


// Initial Data Load
const initialRequestParams = new URLSearchParams({
    action: "get-session-user-info"
});

fetch(USER_CONTROLLER_PATH + "?" + initialRequestParams)
.then(response => response.json())
.then(data => {
    avatarPreview.src = data["avatar_path"];
    emailInput.value = data["email"];
    surnameInput.value = data["surname"];
    nameInput.value = data["name"];
    telefonInput.value = data["phone"];
    notesInput.value = data["comment"];
});