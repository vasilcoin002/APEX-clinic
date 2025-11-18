<?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require_once "../users/UserService.php";
    require_once "../users/User.php";
    require_once "../users/Roles.php";
    require_once "AdminService.php";

    class AdminController {

        private AdminService $admin_service;

        public function __construct() {
            $this->admin_service = new AdminService();
        }

        public function delete_user(UserDTO $userDTO): void {
            echo "<a href='../index.php'>go back</a><br>";
            $this->admin_service->delete_user($userDTO);
        }

    }

    $admin_controller = new AdminController();
    if (isset($_POST["action"])) {
        session_start();

        $userDTO = new UserDTO;
        if (isset($_POST["email"])) {
            $userDTO->email = $_POST["email"];
        }

        $endpoints = array(
            "delete-user" => fn() => $admin_controller->delete_user($userDTO),
        );

        $endpoints[$_POST["action"]]();
    }
?>