<?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require_once "../users/UserService.php";
    require_once "../users/User.php";
    require_once "../users/Roles.php";
    require_once "AdminService.php";

    // TODO create function make_admin_from_user
    class AdminController {

        private AdminService $admin_service;

        public function __construct() {
            $this->admin_service = new AdminService();
        }

        public function delete_user(UserDTO $userDTO): void {
            $this->admin_service->delete_user($userDTO);
        }

        public function get_number_of_users(): int {
            $number = $this->admin_service->get_number_of_users();
            print_r($number);
            return $number;
        }

        public function get_range_of_users(int $from, int $to): array {
            $users = $this->admin_service->get_range_of_users($from, $to);
            print_r($users);
            return $users;
        }
    }

    $admin_controller = new AdminController();
    if (isset($_REQUEST["action"])) {
        session_start();

        $userDTO = new UserDTO;
        if (isset($_GET["email"])) {
            $userDTO->email = $_POST["email"];
        }
        if (isset($_GET["from"])) {
            $from = intval($_GET["from"]);
        }
        if (isset($_GET["to"])) {
            $to = intval($_GET["to"]);
        }

        echo "<a href='../index.php'>go back</a><br>";

        $endpoints = array(
            "delete-user" => fn() => $admin_controller->delete_user($userDTO),
            "get-number-of-users" => fn() => $admin_controller->get_number_of_users(),
            "get-range-of-users" => fn() => $admin_controller->get_range_of_users($from, $to),
        );

        $endpoints[$_GET["action"]]();
    }
?>