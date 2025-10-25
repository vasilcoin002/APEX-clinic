<?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require_once "./UserService.php";
    require_once "./User.php";
    require_once "./Roles.php";

    class UserController {

        private UserService $user_service;

        public function __construct() {
            $this->user_service = new UserService();
        }

        // private function get_email_and_password_from_input() {
        //     $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
        //     $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        //     return array("email"=>$email, "password"=>$password);
        // }

        public function add_user(UserDTO $userDTO) {
            echo "<a href='../index.php'>go back</a><br>";
            return $this->user_service->add_user($userDTO);
        }

        public function login(UserDTO $userDTO) {
            echo "<a href='../index.php'>go back</a><br>";
            return $this->user_service->login($userDTO);
        }

        public function check_if_logined() {
            echo "<a href='../index.php'>go back</a><br>";
            if (isset($_SESSION["user_id"])) {
                $user_id = htmlspecialchars($_SESSION['user_id']);
                echo $user_id . "<br>";
            }
            if (isset($_SESSION["user_email"])) {
                $user_email = htmlspecialchars($_SESSION['user_email']);
                echo $user_email . "<br>";
            }
            if (isset($_SESSION["user_role"])) {
                $user_role = htmlspecialchars($_SESSION['user_role']);
                echo $user_role . "<br>";
            }
        }

        public function logout() {
            echo "<a href='../index.php'>go back</a><br>";
            $this->user_service->logout();
        }

        public function delete_account(UserDTO $userDTO) {
            echo "<a href='../index.php'>go back</a><br>";
            $this->user_service->delete_user_by_user_data($userDTO);
        }

        public function update_email(UserDTO $userDTO): User {
            echo "<a href='../index.php'>go back</a><br>";
            return $this->user_service->update_email($userDTO);
        }
    }

    $user_controller = new UserController();
    if (isset($_POST["action"])) {
        session_start();

        $userDTO = new UserDTO;
        if (isset($_POST["email"])) {
            $userDTO->email = $_POST["email"];
        }
        if (isset($_POST["password"])) {
            $userDTO->password = $_POST["password"];
        }

        $endpoints = array(
            "register" => fn() => $user_controller->add_user($userDTO),
            "login" => fn() => $user_controller->login($userDTO),
            "check-if-logined" => fn() => $user_controller->check_if_logined(),
            "logout" => fn() => $user_controller->logout(),
            "delete-account" => fn() => $user_controller->delete_account($userDTO),
            "update-email" => fn() => $user_controller->update_email($userDTO)
        );

        $endpoints[$_POST["action"]]();
    }
?>