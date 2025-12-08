// 1. Получаем элементы по их уникальным ID
const button = document.getElementById('btn1');
const link = document.getElementById('clientaccount');
const avatar = document.getElementById('user_avatar');

// 2. Добавляем "слушателя" события клика на кнопку
button.addEventListener('click', function() {
    // 3. Когда кнопка нажата, мы меняем стиль ссылки.
    // Вместо 'none' делаем ее 'inline' (потому что это строчный элемент <a>)
    link.style.display = 'inline';
    avatar.style.display = 'none';
    
    // Опционально: можно скрыть саму кнопку после нажатия
    button.style.display = 'none';
});



// Функция для валидации телефонного ввода
function validatePhoneInput(event) {
    const input = event.target;
    // Регулярное выражение разрешает только цифры (0-9) и символы (+ и -)
    const sanitizedValue = input.value.replace(/[^0-9+-]/g, '');

    // Заменяем текущее значение в поле на отфильтрованное
    input.value = sanitizedValue;
}

// Также можно добавить обработчик отправки формы для финальной проверки, если нужно
document.getElementById('appointmentForm').addEventListener('submit', function(event) {
    const phoneInput = document.getElementById('phone');
    // Финальная проверка, чтобы убедиться, что телефон начинается с +
    if (!phoneInput.value.startsWith('+')) {
        alert('Телефонный номер должен начинаться со знака "+".');
        event.preventDefault(); // Остановить отправку формы
    }
    // Далее можно добавить и другую логику валидации...
});