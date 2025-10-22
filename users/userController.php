<?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require_once "./UserService.php";
    require_once "./User.php";
    require_once "./Roles.php";

    session_start();

    class UserController {

        private UserService $user_service;

        public function __construct() {
            $this->user_service = new UserService();
        }

        private function get_filtered_email_and_password_from_input() {
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
            return array("email"=>$email, "password"=>$password);
        }

        public function add_user() {
            $user_data = $this->get_filtered_email_and_password_from_input();
            return $this->user_service->add_user($user_data["email"], $user_data["password"]);
        }

        public function login() {
            $user_data = $this->get_filtered_email_and_password_from_input();
            return $this->user_service->login($user_data["email"], $user_data["password"]);
        }
    }

    $user_controller = new UserController();

    if (isset($_POST["register"])) {$user_controller->add_user();}
    elseif (isset($_POST["login"])) {$user_controller->login();}
?>