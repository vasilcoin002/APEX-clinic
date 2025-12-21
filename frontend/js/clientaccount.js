function showError(elementId, message) {
    const errorElement = document.getElementById(elementId);
    errorElement.textContent = message;
}

function clearError(elementId) {
    const errorElement = document.getElementById(elementId);
    errorElement.textContent = '';
}

// TODO move all error styles to separate file
function highlightField(fieldId) {
    const field = document.getElementById(fieldId);
    field.classList.add("error-border");
}

function disableAllButtons() {
    allButtons.forEach(button => button.disabled = true)
}

function enableAllButtons() {
    allButtons.forEach(button => button.disabled = false)
}

async function handleExceptionResponse(response) {
    const data = await response.json();
    
    inputNames = Object.keys(data);
    inputNames.forEach(function (inputName) {
        console.log(inputName);

        highlightField(inputName);
        document.getElementById(inputName + "-error-message").innerText = data[inputName];
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

allButtons = document.querySelectorAll("button");
allForms = document.querySelectorAll("form");
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
        showError(AVATAR_ERROR_ID, 'Chyba: Obrázek je příliš velký (max 5MB).');
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

// TODO add validation
updateEmailBtn.addEventListener('click', function() {
    clearError(EMAIL_ERROR_ID);

    const formData = new FormData(emailForm);
    formData.append("action", "update-email");

    disableAllButtons();
    fetch(USER_CONTROLLER_PATH, {
        method: 'POST',
        body: formData
    })
    .then(response => handleResponse(response));
});

updatePasswordBtn.addEventListener("click", function() {
    clearError(PASSWORD_ERROR_ID);
    clearError(CONFIRM_PASSWORD_ERROR_ID);

    if (passwordInput.value != confirmPasswordInput.value) {
        showError(PASSWORD_ERROR_ID, "Hesla se neshodují");
        showError(CONFIRM_PASSWORD_ERROR_ID, "Hesla se neshodují");
        return;
    }

    const formData = new FormData();
    formData.append("password", passwordInput.value);
    formData.append("action", "update-password");

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

updatePersonalDataBtn.addEventListener("click", function() {
    clearError(NAME_ERROR_ID);
    clearError(SURNAME_ERROR_ID);
    clearError(PHONE_ERROR_ID);
    clearError(COMMENT_ERROR_ID);

    const formData = new FormData(personalDataForm);
    formData.append("action", "update-profile");

    disableAllButtons();
    fetch(USER_CONTROLLER_PATH, {
        method: 'POST',
        body: formData
    })
    .then(response => handleResponse(response));
})

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