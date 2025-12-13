<?php

    // ini_set('display_errors', 1);
    // error_reporting(E_ALL);

    require_once "../users/UserService.php";
    require_once "../users/User.php";
    require_once "../users/Roles.php";
    require_once "AdminService.php";
    // require_once "../exceptionHandler.php";

    // set_exception_handler("exception_handler");
    $GLOBALS["errors"] = [];

    // TODO add try/catch in controllers
    class AdminController {

        private AdminService $admin_service;

        public function __construct() {
            $this->admin_service = new AdminService();
        }

        public function delete_user(UserDTO $userDTO): void {
            $this->admin_service->delete_user($userDTO);
        }

        public function promote_user(UserDTO $userDTO): void {
            $this->admin_service->promote_user($userDTO);
        }

        public function get_number_of_users(): int {
            $number = $this->admin_service->get_number_of_users();
            echo json_encode($number);
            return $number;
        }

        public function get_range_of_users(int $from, int $to): array {
            $associative_users = $this->admin_service->get_range_of_users($from, $to);
            echo json_encode($associative_users);
            return $associative_users;
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
            "promote-user" => fn() => $admin_controller->promote_user($userDTO),
        );

        try {
            $endpoints[$_POST["action"]]();
        } catch (Exception $e) {
            echo json_encode($GLOBALS["errors"]);
        }
    }
    if (isset($_GET["action"])) {
        session_start();

        $userDTO = new UserDTO;
        if (isset($_GET["from"])) {
            $from = intval($_GET["from"]);
        }
        if (isset($_GET["to"])) {
            $to = intval($_GET["to"]);
        }

        $endpoints = array(
            "get-number-of-users" => fn() => $admin_controller->get_number_of_users(),
            "get-range-of-users" => fn() => $admin_controller->get_range_of_users($from, $to),
        );

        try {
            $endpoints[$_GET["action"]]();
        } catch (Exception) {
            echo json_encode($GLOBALS["errors"]);
        }
    }
?>