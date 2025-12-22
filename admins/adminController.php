<?php

    require_once "../users/UserService.php";
    require_once "../users/User.php";
    require_once "../users/Roles.php";
    require_once "AdminService.php";

    /**
     * Global error array used to collect validation messages.
     * @global array $GLOBALS["errors"]
     */
    $GLOBALS["errors"] = [];

    /**
     * Controller class for handling Administrator-specific actions.
     *
     * This class acts as the interface for administrative tasks such as
     * deleting users, changing user roles (promotion), and retrieving 
     * lists of users for the admin dashboard. It outputs data in JSON format
     * for frontend consumption.
     *
     * @package App\Controllers
     * @version 1.0.0
     */
    class AdminController {

        /**
         * The service instance that handles admin business logic.
         *
         * @var AdminService
         */
        private AdminService $admin_service;

        /**
         * AdminController constructor.
         * Initializes the AdminService dependency.
         */
        public function __construct() {
            $this->admin_service = new AdminService();
        }

        /**
         * Deletes a user account.
         *
         * Delegates the deletion logic to the service layer.
         * The UserDTO must contain the ID of the user to delete.
         *
         * @param UserDTO $userDTO Contains the target user ID.
         * @return void
         */
        public function delete_user(UserDTO $userDTO): void {
            $this->admin_service->delete_user($userDTO);
        }

        /**
         * Promotes a regular user to an administrator role.
         *
         * The UserDTO must contain the ID of the user to promote.
         *
         * @param UserDTO $userDTO Contains the target user ID.
         * @return void
         */
        public function promote_user(UserDTO $userDTO): void {
            $this->admin_service->promote_user($userDTO);
        }

        /**
         * Retrieves the total count of registered users.
         *
         * This method echoes the count as a JSON response.
         *
         * @return int The total number of users.
         */
        public function get_number_of_users(): int {
            $number = $this->admin_service->get_number_of_users();
            echo json_encode($number);
            return $number;
        }

        /**
         * Retrieves a specific range (slice) of users for pagination.
         *
         * This method echoes the list of users as a JSON response.
         *
         * @param int $from The starting index (offset).
         * @param int $to   The ending index (limit).
         *
         * @return array<array<string, mixed>> An array of user data arrays.
         */
        public function get_range_of_users(int $from, int $to): array {
            $associative_users = $this->admin_service->get_range_of_users($from, $to);
            echo json_encode($associative_users);
            return $associative_users;
        }
    }
    
    // -------------------------------------------------------------------------
    // REQUEST ROUTING AND DTO HYDRATION
    // -------------------------------------------------------------------------

    $admin_controller = new AdminController();

    // Handle POST Requests (Actions that modify data)
    if (isset($_POST["action"])) {
        session_start();

        $userDTO = new UserDTO;
        if (isset($_POST["id"])) {
            $userDTO->id = $_POST["id"];
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
    
    // Handle GET Requests (Actions that retrieve data)
    if (isset($_GET["action"])) {
        session_start();

        $userDTO = new UserDTO;
        
        // Initialize pagination variables to avoid undefined variable warnings if not set
        $from = 0;
        $to = 0;

        if (isset($_GET["from"])) {
            $from = intval($_GET["from"]);
        }
        if (isset($_GET["to"])) {
            $to = intval($_GET["to"]);
        }

        $endpoints = array(
            "get-number-of_users" => fn() => $admin_controller->get_number_of_users(),
            "get-range-of-users" => fn() => $admin_controller->get_range_of_users($from, $to),
        );

        try {
            $endpoints[$_GET["action"]]();
        } catch (Exception) {
            echo json_encode($GLOBALS["errors"]);
        }
    }
?>