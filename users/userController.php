<?php

    require_once "UserService.php";
    require_once "User.php";
    require_once "Roles.php";

    $GLOBALS["errors"] = [];

    class UserController {

        private UserService $user_service;

        public function __construct() {
            $this->user_service = new UserService();
        }

        public function add_user(UserDTO $userDTO): void {
            $this->user_service->add_user($userDTO);
        }

        public function login(UserDTO $userDTO): void {
            $this->user_service->login($userDTO);
        }

        public function logout(): void {
            $this->user_service->logout();
        }

        public function delete_account(UserDTO $userDTO): void {
            $this->user_service->delete_user_by_user_data($userDTO);
        }

        public function update_email(UserDTO $userDTO): void {
            $this->user_service->update_email($userDTO);
        }

        public function update_profile(UserDTO $userDTO): void {
            $this->user_service->update_profile($userDTO);
        }

        public function update_password(UserDTO $userDTO): void {
            $this->user_service->update_password($userDTO);
        }

        public function update_avatar(UserDTO $userDTO): void {
            $this->user_service->update_avatar($userDTO);
        }

        public function delete_avatar(): void {
            $this->user_service->delete_avatar();
        }

        public function check_if_logined(): void {
            echo json_encode($this->user_service->check_if_logined());
        }

        public function get_session_user_info(): void {
            echo json_encode($this->user_service->get_session_user_info());
        }
    }

    $user_controller = new UserController();
    if (isset($_POST["action"])) {
        session_start();

        $userDTO = new UserDTO;
        if (isset($_POST["email"])) {
            $userDTO->email = trim($_POST["email"]);
        }
        // without trimming
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

        try {
            $endpoints[$_POST["action"]]();
        } catch (Exception $e) {
            echo json_encode($GLOBALS["errors"]);
        }
    }

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