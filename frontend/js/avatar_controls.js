// 1. Ждем, пока весь HTML-документ полностью загрузится.
// Это гарантирует, что мы сможем найти все элементы на странице.
document.addEventListener('DOMContentLoaded', function() {
    
    const changeAvatarButton = document.querySelector('.primary-button');
    const avatarUploadInput = document.getElementById('avatar-upload');
    const uploadAvatarForm = document.getElementById('upload-avatar-form');

    // --- Логика для кнопки "Změnit avatar" (Изменить аватар) ---

    // 5. Проверяем, что кнопка найдена, чтобы избежать ошибок.
    if (changeAvatarButton) {
        // 6. Добавляем "слушателя событий" (event listener) к кнопке.
        // Когда пользователь нажмет на кнопку ('click'), выполнится функция внутри.
        changeAvatarButton.addEventListener('click', function() {
            // 7. Проверяем, что поле для загрузки файла найдено.
            if (avatarUploadInput) {
                // 8. Имитируем нажатие на скрытое поле загрузки файла.
                // Это откроет стандартное диалоговое окно выбора файла.
                avatarUploadInput.click();
            }
        });
    }

    // --- Логика для автоматической отправки формы после выбора файла ---

    // 9. Проверяем, что поле для загрузки файла найдено.
    if (avatarUploadInput) {
        // 10. Добавляем слушателя событий к полю загрузки файла.
        // Когда значение поля изменится (т.е. пользователь выберет файл), выполнится функция.
        avatarUploadInput.addEventListener('change', function() {
            // 11. Проверяем, что пользователь действительно выбрал файл (список файлов не пуст).
            if (this.files.length > 0) {
                // 12. Если форма найдена, автоматически отправляем ее.
                // Это запускает отправку файла на сервер (на "upload_avatar.php", как указано в HTML).
                if (uploadAvatarForm) {
                    uploadAvatarForm.submit();
                }
            }
        });
    }

}); 