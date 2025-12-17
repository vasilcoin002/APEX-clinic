async function handleResponse() {
    // перезагружаем страницу
    location.reload();
}

async function handleExceptionResponse(response) {
    // Когда ошибка "неавторизирован" либо "нет доступа", то перезагрузить страницу
    if (response.status === 401 || response.status === 403) {
        location.reload();
    }
    return response.json();
}

async function renderPagination(numberOfUsers) {
    let totalPages = Math.ceil(numberOfUsers / numberOfUsersOnPage);

    const paginationContainer = document.querySelector('.pagination');
    paginationContainer.innerHTML = ''; 
    const fragment = document.createDocumentFragment();

    for (let i = 1; i <= totalPages; i++) {
        const isFirstOrLast = (i === 1) || (i === totalPages);
        const isNearCurrent = Math.abs(i - page) <= 1;

        if (isFirstOrLast || isNearCurrent) {

            const link = document.createElement('a');
            link.href = `?page=${i}`;
            link.textContent = i;

            if (i === page) {
                link.classList.add('active');
            }

            fragment.appendChild(link);
        } 
        else if (i === page - 2 || i === page + 2) {
            const span = document.createElement('span');
            span.textContent = '...';
            fragment.appendChild(span);
        }
    }

    paginationContainer.appendChild(fragment);
}

// TODO add error showing
async function renderUser(user) {
    // Создаем элементы, которые потом вставим в html
    const tableBody = document.querySelector("tbody");
    const tableRow = document.createElement("tr");
    const idCell = document.createElement("td");
    const nameCell = document.createElement("td");
    const surnameCell = document.createElement("td");
    const emailCell = document.createElement("td");
    const roleCell = document.createElement("td");

    // Даем внутри этих клеток информацию
    idCell.textContent = user.id;
    nameCell.textContent = user.name;
    surnameCell.textContent = user.surname;
    emailCell.textContent = user.email;
    roleCell.textContent = user.role;

    // Добавляем внутрь ряда все эти клетки
    tableRow.appendChild(idCell);
    tableRow.appendChild(nameCell);
    tableRow.appendChild(surnameCell);
    tableRow.appendChild(emailCell);
    tableRow.appendChild(roleCell);
    tableBody.appendChild(tableRow);

    // Когда рендерит админа, дальше по коду не идет, что бы не рисовать кнопки для него
    if (user.role === "ADMIN") {
        return;
    }

    // Клетки для контроля юзеров
    const controllCell = document.createElement("td");
    const controllForm = document.createElement("form");
    controllForm.method = "post";
    controllCell.appendChild(controllForm);

    // при сабмите будет запускаться функция:
    controllForm.onsubmit = function (e) {
        e.preventDefault();

        // из ивента достаем ту кнопку, на которую кликнули
        const buttonClicked = e.submitter;

        // симуляция того, что запрос на сервер будет послан из формы,
        // хотя на самом деле из js
        const formData = new FormData(controllForm);
        formData.append("action", buttonClicked.value);
        
        fetch('../admins/adminController.php', {
            method: "POST",
            body: formData
        })
        .then(handleResponse);
    };

    tableRow.appendChild(controllCell);

    const idHiddenInput = document.createElement("input");
    idHiddenInput.type = "hidden";
    idHiddenInput.name = "id";
    idHiddenInput.value = user.id;
    controllForm.appendChild(idHiddenInput);

    const deleteButton = document.createElement("button");
    deleteButton.className = "btn-del";
    deleteButton.type = "submit";
    deleteButton.name = "action";
    deleteButton.value = "delete-user";
    deleteButton.textContent = "Delete";
    controllForm.appendChild(deleteButton);

    const promoteBotton = document.createElement("button");
    promoteBotton.className = "btn-admin";
    promoteBotton.type = "submit";
    promoteBotton.name = "action";
    promoteBotton.value = "promote-user";
    promoteBotton.textContent = "Promote";
    controllForm.appendChild(promoteBotton);
}

async function renderUsers(users) {
    // для каждого пользователя вызываем функцию renderUser
    users.forEach(user => renderUser(user));
}

// Сами определяем, сколько будет пользователей на странице
const numberOfUsersOnPage = 5;
// Достаем из текущей ссылки все параметры
const currentUrlParams = new URLSearchParams(window.location.search);
// Достаем из всех параметров параметр page, но превращаем его из строки в число
const page = parseInt(currentUrlParams.get("page"));

const fetchUsersParams = {
    from: (page-1)*numberOfUsersOnPage,
    to: page*numberOfUsersOnPage,
    action: "get-range-of-users"
}

// Отправляем запрос на сервер, получаем оттуда общее количество пользователей
// И от этого рендерим контроль в пагинации
fetch('../admins/adminController.php?action=get-number-of-users')
.then(response => handleExceptionResponse(response))
.then(numberOfUsers => renderPagination(numberOfUsers));

// Превращаем словник с параметрами для следующего запроса в строку,
// потому что для get запроса параметры пишутся в строке
const stringParams = new URLSearchParams(fetchUsersParams).toString();
// Отправляем запрос на сервер, получаем оттуда список пользователей, рендерим его
fetch('../admins/adminController.php?' + stringParams)
.then((response) => handleExceptionResponse(response))
.then((users) => renderUsers(users));
