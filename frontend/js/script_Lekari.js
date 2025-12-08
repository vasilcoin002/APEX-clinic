document.addEventListener('DOMContentLoaded', function() {
    const button = document.getElementById('show-more-btn');
    const hiddenContent = document.getElementById('hidden-doctors');
    const arrow = button.querySelector('.arrow-icon');
    
    const showText = 'Zobrazit více lékařů';
    const hideText = 'Zobrazit méně lékařů';
    
    if (button && hiddenContent && arrow) {
        button.addEventListener('click', function() {
            
            // 1. Переключаем класс для показа/скрытия контента
            hiddenContent.classList.toggle('visible-doctors');
            arrow.classList.toggle('rotated');

            if (hiddenContent.classList.contains('visible-doctors')) {
                // Pokud je obsah VIDITELNÝ
                button.firstChild.data = hideText; 
                
                // Получаем позицию кнопки относительно начала документа
                const buttonPosition = button.offsetTop;
                
                window.scrollTo({
                    top: buttonPosition -690, 
                    behavior: "smooth"
                });
                // ==============================

            } else {
                // Если контент СКРЫТ
                button.firstChild.data = showText;
                
                // При скрытии контента, прокручиваем вверх к началу секции врачей
                    const doctorsSection = document.querySelector('.grid_3x3');
                    if (doctorsSection) {
                        window.scrollTo({
                            top: doctorsSection.offsetTop - 85, // Прокручиваем к началу первого ряда
                            behavior: 'smooth'
                        });
                    }

            }
        });
    }
});