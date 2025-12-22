# APEX Medical - System Documentation

## 1. Project Overview
This project is a medical appointment and user management system for **APEX Medical Center**. It handles user registration, authentication (login/logout), profile management, and administrative tasks such as user deletion and role promotion.

## 2. Live demo

Demo is located on the server of Czech Technical University and can be accessed  with this link: https://zwa.toad.cz/~kliusvas/frontend/index.php

## 3. Technical Stack

### Backend
* **Language:** PHP 7.4+ (Strict typing enabled)
* **Database:** JSON File-based storage (No SQL required)
* **Architecture:** Layered Service-Repository Pattern
* **Dependencies:** phpDocumentor (for API docs)

### Frontend
* **View Engine:** Native PHP (`.php` files) for server-side rendering
* **Styling:** CSS3 with Global Variables (`vars.css`) and Flexbox/Grid
* **Interactivity:** Vanilla JavaScript (ES6 Modules)
* **Communication:** AJAX via Fetch API

---


## 4. Project Structure
The project is organized into logical layers to separate backend logic from frontend views.
```
APEX-clinic/
├── frontend/              # Frontend Assets (Views, JS, CSS)
│   ├── css/               # Stylesheets (vars.css, style.css, etc.)
│   ├── js/                # JavaScript Modules (validators.js, adminPanel.js, etc.)
│   ├── images/            # Static assets (logos, icons)
│   ├── index.php          # Homepage
│   ├── adminPanel.php     # Admin Dashboard (Protected)
│   ├── clientaccount.php  # User Profile (Protected)
│   └── ... (other views)
├── users/                 # Data Storage & Users Backend Logic
│   ├── users.json         # Main JSON Database
│   ├── avatars/           # User uploaded profile pictures
│   ├── User.php           # Models
│   ├── UserDTO.php        # Data Transfer Objects
│   ├── userController.php # API Endpoints
│   ├── UserService.php    # Business Logic
│   ├── UserRepository.php # Repository
│   └── Roles.php          # Roles constants
├── admins/                # Admins Backend Logic
│   ├── adminController.php# API Endpoints
│   └── UserService.php    # Business Logic
└── docs/                  # Generated Documentation
```
---

## 5. Backend Documentation

The backend uses a **Layered Architecture** to ensure separation of concerns.

### A. Data Transfer Objects (DTO)
* **File:** `UserDTO.php`
* **Purpose:** Carries data between the Frontend (HTML Forms) and the Backend Services.
* **Why:** Ensures that controllers and services exchange structured objects rather than raw `$_POST` arrays.

### B. Controllers (Input Layer)
* **Files:** `UserController.php`, `AdminController.php`
* **Purpose:**
    * Receives HTTP requests (GET/POST).
    * Hydrates `UserDTO` objects from input data.
    * Calls the appropriate Service method.
    * Returns JSON responses to the frontend.

### C. Services (Business Logic Layer)
* **Files:** `UserService.php`, `AdminService.php`
* **Purpose:**
    * Contains all validation logic (email format, password strength, empty fields).
    * Handles security checks.
    * Hashes passwords using Bcrypt.
    * Throws Exceptions (`InvalidArgumentException`, `BadMethodCallException`) on failure.

### D. Repository (Data Access Layer)
* **Files:** `UserRepository.php`
* **Purpose:**
    * Acts as an abstraction over the data storage.
    * Reads/Writes to `../users/users.json`.
    * Handles JSON decoding/encoding and auto-incrementing IDs.

---

## 6. Frontend Documentation

The frontend is built as a Multi-Page Application (MPA) with AJAX interactivity.

### A. Page Protection & Authorization
Access control is enforced at the top of sensitive PHP files before any HTML is rendered.

| Page | Protection Logic | Redirects To |
| :--- | :--- | :--- |
| **clientaccount.php** | Checks if `$_SESSION["user_id"]` is set. | `frmLogin.php` |
| **adminPanel.php** | Checks if `$_SESSION["user_role"]` is "ADMIN". | `error.php` (403 Forbidden) |

### B. JavaScript & AJAX Layer
The application uses a **Single-Controller Pattern** for AJAX requests.

#### 1. Shared Self-created Validation Library (`js/validators.js`)
A reusable ES6 module used across Login, Registration, and Profile forms.
* **`isRequired(value)`**: Validates if required value was sent.
* **`isValidEmail(value)`**: Validates email format via Regex.
* **`isValidPhone(value)`**: Validates phone number format via Regex.
* **`getPasswordErrors(value)`**: Enforces security policy (Min 8 chars, 1 uppercase, 1 lowercase, 1 digit).
* **`doPasswordsMatch(pass1, pass2)`**: Compares 2 passwords if they are equal

#### 2. Authentication Modules
* **Registration (`js/registr_validateinput.js`):** Validates inputs client-side, then sends `FormData` with `action="register"` to the controller.
* **Login (`js/login_validateinput.js`):** Sends `action="login"`. On failure (HTTP 400), it parses the JSON error object to display messages under specific fields.

#### 3. Client Dashboard (`js/clientaccount.js`)
* **Initialization:** Fetches user data via `action="get-session-user-info"` on load.
* **Avatar Upload:** Validates file type (JPG/PNG) and size (Max 16MB) before sending `action="update-avatar"`.

#### 4. Admin Panel (`js/adminPanel.js`)
Acts as a Single-Page-Application (SPA) within the admin view.
* **Data Fetching:** Fetches user counts and ranges for pagination.
* **Dynamic Rendering:** Generates the user table via JS.
* **Actions:** Attaches event listeners for `delete-user` and `promote-user` actions.

### C. CSS Architecture
* **`vars.css`**: Global variables for colors (`--color-btn_blue`, `--color-golden-rod`) and fonts.
* **`header-footer.css`**: Shared layout styles.
* **`*_print.css`**: Specific stylesheets for print-friendly views (hides navigation, adjusts layout).

---

## 7. API / Routing Guide

The controllers act as API endpoints using the `action` parameter.

### User Actions (`UserController.php`)
* **POST `register`:** Register a new user (Required: email, password, name, surname, phone)
* **POST `login`:** Log in a user (Required: email, password)
* **POST `update-profile`:** Update details (Required: name, surname, phone, comment)
* **POST `update-avatar`:** Upload profile picture (Required: file)
* **GET `check-if-logined`:** Returns true/false

### Admin Actions (`AdminController.php`)
* **POST `delete-user`:** Delete a specific user (Required: id)
* **POST `promote-user`:** Make a user an ADMIN (Required: id)
* **GET `get-range-of-users`:** Pagination for user list (Required: from, to)

### Access from frontend
Endpoints are accessed with AJAX using objects of class **FormData** to send data and attribute `action` which defines the name of endpoint

---

## 8. Security Features
* **Authentication:** Session-based (`$_SESSION['user_id']`).
* **Password Storage:** Bcrypt hashing via `password_hash()`.
* **Role-Based Access Control (RBAC):**
    * Defined in `Roles.php` (`USER`, `ADMIN`).
    * `AdminService` strictly enforces `get_admin_from_session()` before allowing operations.
* **Input Validation:** Strict regex checks for emails, passwords (complexity), and phone numbers.

---

## 9. Documentation Generation
This project uses **phpDocumentor** to generate technical API docs.

To regenerate the documentation after code changes, run:
php phpDocumentor.phar run -d . -t docs/api --ignore "vendor/"

Open `docs/api/index.html` to view the result.