function showError(elementId, message) {
    const errorElement = document.getElementById(elementId);
    errorElement.textContent = message;
}

function clearError(elementId) {
    const errorElement = document.getElementById(elementId);
    errorElement.textContent = '';
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
const passwordInput = document.querySelector("#new-password");
const confirmPasswordInput = document.querySelector("#confirm-password");
const surnameInput = document.querySelector("#prijmeni");
const nameInput = document.querySelector("#jmeno");
const telefonInput = document.querySelector("#telefon");
const notesInput = document.querySelector("#health-notes");

const avatarPreview = document.querySelector('#user-avatar-placeholder');
const avatarForm = document.querySelector('#avatar-form');
const updateAvatarBtn = avatarForm.querySelector('#update-avatar-button');
const deleteAvatarBtn = avatarForm.querySelector('#delete-avatar-button');

allButtons = [updateAvatarBtn, deleteAvatarBtn];

const AVATAR_ERROR_ID = 'avatar-error-message';
const USER_CONTROLLER_PATH = '../users/userController.php';

const MAX_SIZE = 5 * 1024 * 1024; // 5MB
const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/gif'];

avatarInput.addEventListener('change', function(event) {
    clearError(AVATAR_ERROR_ID); // Clear specific avatar errors
    
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

const initialRequestParams = new URLSearchParams({
    action: "get-session-user-info"
});

allForms = document.querySelectorAll("form");
allForms.forEach(form => form.addEventListener("submit", e => e.preventDefault()));

fetch(USER_CONTROLLER_PATH + "?" + initialRequestParams)
.then(response => response.json())
.then(data => {
    avatarPreview.src = data["avatar_path"];
    emailInput.value = data["email"];
    surnameInput.value = data["surname"];
    nameInput.value = data["name"];
    telefonInput.value = data["phone"];
    notesInput.value = data["comment"];
})