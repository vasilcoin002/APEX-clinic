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
                throw new BadMethodCallException("You can't delete admins");
            }
            $this->user_repository->delete_user($user);
        }

        public function promote_user(UserDTO $userDTO): void {
            $admin = $this->get_admin_from_session();

            $this->user_service->check_if_email_is_in_user_dto($userDTO);

            $user = $this->user_repository->find_user_by_email($userDTO->email);
            if ($user == null) {
                throw new InvalidArgumentException("User not found. Please, provide the right email");
            }
            if ($user->get_id() == $admin->get_id()) {
                throw new BadMethodCallException("You can't promote yourself");
            }
            if ($user->get_role() == Roles::ADMIN) {
                throw new BadMethodCallException("You can't promote admins");
            }

            $user->set_role(Roles::ADMIN);
            $this->user_repository->update_user($user);
        }

        public function get_number_of_users() {
            $this->get_admin_from_session();
            return $this->user_repository->get_number_of_users();
        }

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