<?php

    require_once "../users/UserRepository.php";
    require_once "../users/User.php";
    require_once "../users/UserDTO.php";
    require_once "../users/Roles.php";
    require_once "../users/UserService.php";

    class AdminService {

        private UserService $user_service;
        private UserRepository $user_repository;

        public function __construct() {
            $this->user_service = new UserService();
            $this->user_repository = new UserRepository();
        }

        public function get_admin_from_session(): User {
            $this->user_service->check_if_session_is_active();
            $admin = $this->user_service->get_user_from_session();

            if ($admin->get_role() != Roles::ADMIN) {
                throw new BadMethodCallException(
                    "You can't access AdminService. " .
                    "This service is accessible for users with role ".Roles::ADMIN." only"
                );
            }

            return $admin;
        }

        public function delete_user(UserDTO $userDTO): void {
            $admin = $this->get_admin_from_session();

            $this->user_service->check_if_email_is_in_user_dto($userDTO);

            $user = $this->user_repository->find_user_by_email($userDTO->email);
            if ($user == null) {
                throw new InvalidArgumentException("User not found. Please, provide the right email");
            }
            if ($user->get_id() == $admin->get_id()) {
                throw new BadMethodCallException(
                    "You can't delete yourself through the admin's panel. Please, use user's panel"
                );
            }
            if ($user->get_role() == Roles::ADMIN) {
                throw new BadMethodCallException("You can't delete users with role " . Roles::ADMIN);
            }
            $this->user_repository->delete_user($user);
        }

    }

?>