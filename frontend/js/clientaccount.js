
function showError(elementId, message) {
    const errorElement = document.getElementById(elementId);
    errorElement.textContent = message;
}

function clearError(elementId) {
    const errorElement = document.getElementById(elementId);
    errorElement.textContent = '';
}

const avatarInput = document.getElementById('avatar-upload');
const avatarPreview = document.getElementById('user-avatar-placeholder');
const avatarForm = document.getElementById('upload-avatar-form');
const changeAvatarBtn = avatarForm.querySelector('.primary-button');

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


changeAvatarBtn.addEventListener('click', function() {
    clearError(AVATAR_ERROR_ID);

    if (!avatarInput.files.length) {
        showError(AVATAR_ERROR_ID, 'Prosím, nejprve vyberte obrázek kliknutím na avatar.');
        return;
    }

    const formData = new FormData(avatarForm);
    formData.append("action", "update-avatar");
    const originalText = changeAvatarBtn.innerText;
    
    // UI Loading
    changeAvatarBtn.innerText = "Nahrávám...";
    changeAvatarBtn.disabled = true;

    fetch(USER_CONTROLLER_PATH, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) return response.text();
        throw new Error('Chyba sítě nebo serveru');
    })
    .then(data => {
        // window.location.reload();
    })
    .catch(error => {
        console.error('Chyba:', error);
        showError(AVATAR_ERROR_ID, 'Nastala chyba při nahrávání obrázku. Zkuste to prosím znovu.');
        
        changeAvatarBtn.innerText = originalText;
        changeAvatarBtn.disabled = false;
    });
});