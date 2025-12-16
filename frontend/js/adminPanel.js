async function handleResponse(response) {
    window.location.replace(window.location.href);
}

async function handleExceptionResponse(response) {
    if (response.status === 403) {
        window.location.replace("error.php");
    }
    else if (response.status === 401) {
        window.location.replace("frmLogin.php");
    }
    return response.json()
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
    const tableBody = document.querySelector("tbody");
    const tableRow = document.createElement("tr");
    const idCell = document.createElement("td");
    const nameCell = document.createElement("td");
    const surnameCell = document.createElement("td");
    const emailCell = document.createElement("td");
    const roleCell = document.createElement("td");

    idCell.textContent = user.id;
    nameCell.textContent = user.name;
    surnameCell.textContent = user.surname;
    emailCell.textContent = user.email;
    roleCell.textContent = user.role;

    tableRow.appendChild(idCell);
    tableRow.appendChild(nameCell);
    tableRow.appendChild(surnameCell);
    tableRow.appendChild(emailCell);
    tableRow.appendChild(roleCell);

    const controllCell = document.createElement("td");
    const controllForm = document.createElement("form");
    

    controllForm.method = "post";
    controllCell.appendChild(controllForm);

    controllForm.onsubmit = function (e) {
        e.preventDefault();

        const formData = new FormData(controllForm);
        // TODO дописать удаление и повышение юзеров
        fetch('../admins/adminController.php', {
            method: "POST",
            body: formData
        })
        .then((response) => handleResponse(response));
    };

    tableBody.appendChild(tableRow);
    tableRow.appendChild(controllCell);

    if (user.role === "ADMIN") {
        return;
    }

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
    users.forEach(user => renderUser(user));
}

const numberOfUsersOnPage = 5;
const currentUrlParams = new URLSearchParams(window.location.search);
const page = parseInt(currentUrlParams.get("page"));

const fetchUsersParams = {
    from: (page-1)*numberOfUsersOnPage,
    to: page*numberOfUsersOnPage,
    action: "get-range-of-users"
}

fetch('../admins/adminController.php?action=get-number-of-users')
.then(response => handleExceptionResponse(response))
.then(numberOfUsers => renderPagination(numberOfUsers));

const stringParams = new URLSearchParams(fetchUsersParams).toString();
fetch('../admins/adminController.php?' + stringParams)
.then((response) => handleExceptionResponse(response))
.then((users) => renderUsers(users));
