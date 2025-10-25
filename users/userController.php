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

        // private function get_email_and_password_from_input() {
        //     $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
        //     $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        //     return array("email"=>$email, "password"=>$password);
        // }

        public function add_user(UserDTO $userDTO) {
            echo "<a href='../index.php'>go back</a><br>";
            // $user_data = $this->get_email_and_password_from_input();
            return $this->user_service->add_user($userDTO);
        }

        public function login(UserDTO $userDTO) {
            echo "<a href='../index.php'>go back</a><br>";
            // $user_data = $this->get_email_and_password_from_input();
            return $this->user_service->login($userDTO);
        }

        public function check_if_logined() {
            echo "<a href='../index.php'>go back</a><br>";
            echo "{$_SESSION['user_id']}<br>";
            echo "{$_SESSION['user_email']}<br>";
            echo "{$_SESSION['user_role']}<br>";
        }

        public function logout() {
            echo "<a href='../index.php'>go back</a><br>";
            $this->user_service->logout();
        }

        public function delete_account(UserDTO $userDTO) {
            echo "<a href='../index.php'>go back</a><br>";
            // $user_data = $this->get_email_and_password_from_input();
            return $this->user_service->delete_user_by_user_data($userDTO);
        }
    }

    $user_controller = new UserController();
    if (isset($_POST["action"])) {
        $userDTO = new UserDTO;
        if (isset($_POST["email"])) {
            $userDTO->email = $_POST["email"];
        }
        if (isset($_POST["password"])) {
            $userDTO->password = $_POST["password"];
        }
        
        switch ($_POST["action"]) {
            case "register":
                $user_controller->add_user($userDTO);
                break;
            case "login":
                $user_controller->login($userDTO);
                break;
            case "check-if-logined":
                $user_controller->check_if_logined();
                break;
            case "logout":
                $user_controller->logout();
                break;
            case "delete-account":
                $user_controller->delete_account($userDTO);
                break;
        }
    }
?>