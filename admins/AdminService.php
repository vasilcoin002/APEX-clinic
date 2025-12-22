<?php

    require_once "../users/UserRepository.php";
    require_once "../users/User.php";
    require_once "../users/UserDTO.php";
    require_once "../users/Roles.php";
    require_once "../users/UserService.php";

    /**
     * Service class for handling high-privilege administrative operations.
     *
     * This class contains business logic restricted to administrators, such as
     * deleting users, promoting users to admin status, and viewing system-wide
     * user statistics. It enforces Role-Based Access Control (RBAC).
     *
     * @package App\Services
     * @version 1.0.0
     */
    class AdminService {

        /**
         * Service for handling general user operations and session verification.
         *
         * @var UserService
         */
        private UserService $user_service;

        /**
         * Repository for direct database/file access.
         *
         * @var UserRepository
         */
        private UserRepository $user_repository;

        /**
         * AdminService constructor.
         * Initializes dependencies for user management and data access.
         */
        public function __construct() {
            $this->user_service = new UserService();
            $this->user_repository = new UserRepository();
        }

        /**
         * Verifies that the current session belongs to an Administrator.
         *
         * This is a critical security method called at the start of every admin action.
         *
         * @return User The authenticated administrator object.
         *
         * @throws BadMethodCallException If the user is not logged in or is not an ADMIN (403 Forbidden).
         */
        private function get_admin_from_session(): User {
            $admin = $this->user_service->get_user_from_session();

            if ($admin->get_role() != Roles::ADMIN) {
                $GLOBALS["errors"]["role"] = "Nemáte přístup ke službě AdminService. Tato služba je přístupná pouze uživatelům s rolí " . Roles::ADMIN;
                http_response_code(403);
                throw new BadMethodCallException();
            }

            return $admin;
        }

        /**
         * Deletes a specific user account.
         *
         * Business Rules:
         * - Admins cannot delete their own account via this panel.
         * - Admins cannot delete other administrators.
         *
         * @param UserDTO $userDTO Contains the ID of the user to delete.
         * @return void
         * @throws InvalidArgumentException If the user ID is missing or not found (404).
         * @throws BadMethodCallException If trying to delete self or another admin (400).
         */
        public function delete_user(UserDTO $userDTO): void {
            $admin = $this->get_admin_from_session();

            $this->user_service->check_if_id_is_in_user_dto($userDTO);

            $user = $this->user_repository->find_user_by_id($userDTO->id);
            if ($user == null) {
                $GLOBALS["errors"]["id"] = "Uživatel nenalezen. Zadejte prosím správné ID.";
                http_response_code(404);
                throw new InvalidArgumentException();
            }
            if ($user->get_id() == $admin->get_id()) {
                $GLOBALS["errors"]["id"] = "V administračním panelu nemůžete smazat vlastní účet. Použijte prosím uživatelský panel.";
                http_response_code(400);
                throw new BadMethodCallException();
            }
            if ($user->get_role() == Roles::ADMIN) {
                $GLOBALS["errors"]["id"] = "Nemůžete smazat administrátory.";
                http_response_code(400);
                throw new BadMethodCallException();
            }
            $this->user_repository->delete_user($user);
        }

        /**
         * Promotes a regular user to Administrator status.
         *
         * Business Rules:
         * - Cannot promote someone who is already an admin.
         *
         * @param UserDTO $userDTO Contains the ID of the user to promote.
         * @return void
         * @throws InvalidArgumentException If user is not found.
         * @throws BadMethodCallException If target is already an admin or self-promotion is attempted.
         */
        public function promote_user(UserDTO $userDTO): void {
            $admin = $this->get_admin_from_session();

            $this->user_service->check_if_id_is_in_user_dto($userDTO);

            $user = $this->user_repository->find_user_by_id($userDTO->id);
            if ($user == null) {
                $GLOBALS["errors"]["id"] = "Uživatel nenalezen. Zadejte prosím správné ID.";
                http_response_code(404);
                throw new InvalidArgumentException();
            }
            if ($user->get_id() == $admin->get_id()) {
                $GLOBALS["errors"]["id"] = "Nemůžete povýšit sami sebe.";
                http_response_code(400);
                throw new BadMethodCallException();
            }
            if ($user->get_role() == Roles::ADMIN) {
                $GLOBALS["errors"]["id"] = "Nemůžete povýšit administrátory.";
                http_response_code(400);
                throw new BadMethodCallException();
            }

            $user->set_role(Roles::ADMIN);
            $this->user_repository->update_user($user);
        }

        /**
         * Retrieves the total number of users in the system.
         *
         * @return int The total user count.
         * @throws BadMethodCallException If the current session is not authorized.
         */
        public function get_number_of_users() {
            $this->get_admin_from_session();
            return $this->user_repository->get_number_of_users();
        }

        /**
         * Retrieves a subset of users for pagination and converts them to arrays.
         *
         * This method fetches User objects from the repository and transforms them
         * into associative arrays suitable for JSON output by the controller.
         *
         * @param int $from Starting index.
         * @param int $to   Ending index.
         *
         * @return array<array<string, mixed>> A list of users represented as associative arrays.
         * @throws BadMethodCallException If the current session is not authorized.
         */
        public function get_range_of_users(int $from, int $to) {
            $this->get_admin_from_session();
            $users = $this->user_repository->get_range_of_users($from, $to);
            $associative_users = [];
            foreach ($users as $user) {
                $associative_users[] = $this->user_service->get_user_info($user);
            }
            return $associative_users;
        }
    }

?>