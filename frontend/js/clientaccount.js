document.addEventListener('DOMContentLoaded', function() {
    const tabLinks = document.querySelectorAll('.card-link');
    const tabContents = document.querySelectorAll('.card-content');

    // Вложенная функция switchTab для переключения карточек (вкладок)
    function switchTab(targetId) {
        // 1) Для начала скроем контент у всех карточек
        tabContents.forEach(content => {
            content.classList.remove('active');
        });

        // 2) Теперь уберем класс active со всех ссылок
        tabLinks.forEach(link => {
            link.classList.remove('active');
        });

        // 3) ... наконец, покажем (справа) целевой контент (targetId) 
        // путем добавления свойства active к элементу, у которого id=targetContentID
        const targetContentID = document.getElementById(targetId);
        if (targetContentID) { // если targetContentID найден, то добавить свойqтво 'active'
            targetContentID.classList.add('active');
        }
    }  // == END: function switchTab()

    
    // Обработчик событий для каждой ссылки (карточки)
    tabLinks.forEach(link => {
        link.addEventListener('click', function() {
            // сначала определи, какую карточку кликнули (по атрибуту "data-target"?
            // ( см.например в .html вот такой код: <div class="card card-link" data-target="personal_data"></div>
            const targetId = this.getAttribute('data-target');
            
            // Переключаем контент
            switchTab(targetId);

            // Устанавливаем класс active на текущей карточке,
            //чтобы она стала темно-синей
            this.classList.add('active');
        });
    });

    // Устанавливаем начальное активное состояние при загрузке
    // Показываем приветствие (ID: welcome-content)
    switchTab('welcome-txt'); 

    // можно активировать карточку "Moje poznámky" при загрузке
    // if (tabLinks.length > 0) {
        // tabLinks[0].classList.add('active');
    // }
});