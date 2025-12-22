<?php

    require_once "UserService.php";
    require_once "User.php";
    require_once "Roles.php";

    /**
     * Global error array used to collect validation messages.
     * @global array $GLOBALS["errors"]
     */
    $GLOBALS["errors"] = [];

    /**
     * Controller class for handling User-related HTTP requests.
     *
     * This class acts as the interface between the frontend (HTTP requests)
     * and the backend business logic (UserService). It receives data via DTOs,
     * calls the appropriate service methods, and handles the output.
     *
     * @package App\Controllers
     * @version 1.0.0
     */
    class UserController {

        /**
         * The service instance that handles business logic.
         *
         * @var UserService
         */
        private UserService $user_service;

        /**
         * UserController constructor.
         * Initializes the UserService dependency.
         */
        public function __construct() {
            $this->user_service = new UserService();
        }

        /**
         * Handles user registration requests.
         *
         * @param UserDTO $userDTO The data transfer object containing registration details.
         * @return void
         */
        public function add_user(UserDTO $userDTO): void {
            $this->user_service->add_user($userDTO);
        }

        /**
         * Handles user login requests.
         *
         * @param UserDTO $userDTO The data transfer object containing login credentials.
         * @return void
         */
        public function login(UserDTO $userDTO): void {
            $this->user_service->login($userDTO);
        }

        /**
         * Handles user logout requests.
         *
         * @return void
         */
        public function logout(): void {
            $this->user_service->logout();
        }

        /**
         * Handles account deletion requests.
         *
         * @param UserDTO $userDTO Credentials to confirm deletion authorization.
         * @return void
         */
        public function delete_account(UserDTO $userDTO): void {
            $this->user_service->delete_user_by_user_data($userDTO);
        }

        /**
         * Handles email address update requests.
         *
         * @param UserDTO $userDTO Contains the new email address.
         * @return void
         */
        public function update_email(UserDTO $userDTO): void {
            $this->user_service->update_email($userDTO);
        }

        /**
         * Handles general profile information updates (name, phone, bio).
         *
         * @param UserDTO $userDTO Contains the updated profile fields.
         * @return void
         */
        public function update_profile(UserDTO $userDTO): void {
            $this->user_service->update_profile($userDTO);
        }

        /**
         * Handles password change requests.
         *
         * @param UserDTO $userDTO Contains the new password.
         * @return void
         */
        public function update_password(UserDTO $userDTO): void {
            $this->user_service->update_password($userDTO);
        }

        /**
         * Handles avatar image upload requests.
         *
         * Note: The actual file data is handled via the global $_FILES superglobal
         * inside the service, but the DTO may contain metadata.
         *
         * @param UserDTO $userDTO
         * @return void
         */
        public function update_avatar(UserDTO $userDTO): void {
            $this->user_service->update_avatar($userDTO);
        }

        /**
         * Handles avatar deletion requests.
         *
         * @return void
         */
        public function delete_avatar(): void {
            $this->user_service->delete_avatar();
        }

        /**
         * Outputs the login status of the current user.
         *
         * Echoes a JSON-encoded boolean.
         *
         * @return void
         */
        public function check_if_logined(): void {
            echo json_encode($this->user_service->check_if_logined());
        }

        /**
         * Outputs the session information for the current user.
         *
         * Echoes a JSON-encoded array of user data.
         *
         * @return void
         */
        public function get_session_user_info(): void {
            echo json_encode($this->user_service->get_session_user_info());
        }
    }

    // -------------------------------------------------------------------------
    // REQUEST ROUTING AND DTO HYDRATION
    // -------------------------------------------------------------------------

    $user_controller = new UserController();

    // Handle POST Requests (Actions that change data)
    if (isset($_POST["action"])) {
        session_start();

        // Hydrate the DTO from POST data with basic sanitization
        $userDTO = new UserDTO;
        if (isset($_POST["email"])) {
            $userDTO->email = trim($_POST["email"]);
        }
        // Password is not trimmed to preserve spaces if intended by user
        if (isset($_POST["password"])) {
            $userDTO->password = $_POST["password"];
        }
        if (isset($_POST["name"])) {
            $userDTO->name = trim($_POST["name"]);
        }
        if (isset($_POST["surname"])) {
            $userDTO->surname = trim($_POST["surname"]);
        }
        if (isset($_POST["phone"])) {
            $userDTO->phone = trim($_POST["phone"]);
        }
        if (isset($_POST["comment"])) {
            $userDTO->comment = trim($_POST["comment"]);
        }

        // Map action strings to controller methods
        $endpoints = array(
            "register" => fn() => $user_controller->add_user($userDTO),
            "login" => fn() => $user_controller->login($userDTO),
            "logout" => fn() => $user_controller->logout(),
            "delete-account" => fn() => $user_controller->delete_account($userDTO),
            "update-email" => fn() => $user_controller->update_email($userDTO),
            "update-profile" => fn() => $user_controller->update_profile($userDTO),
            "update-password" => fn() => $user_controller->update_password($userDTO),
            "update-avatar" => fn() => $user_controller->update_avatar($userDTO),
            "delete-avatar" => fn() => $user_controller->delete_avatar(),
        );

        // Execute action or catch errors to return JSON response
        try {
            $endpoints[$_POST["action"]]();
        } catch (Exception $e) {
            echo json_encode($GLOBALS["errors"]);
        }
    }

    // Handle GET Requests (Actions that retrieve data)
    elseif (isset($_GET["action"])) {
        session_start();

        $endpoints = array(
            "check-if-logined" => fn() => $user_controller->check_if_logined(),
            "get-session-user-info" => fn() => $user_controller->get_session_user_info(),
        );

        try {
            $endpoints[$_GET["action"]]();
        } catch (Exception $e) {
            echo json_encode($GLOBALS["errors"]);
        }
    }
?>