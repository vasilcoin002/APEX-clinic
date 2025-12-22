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

        private function get_admin_from_session(): User {
            $admin = $this->user_service->get_user_from_session();

            if ($admin->get_role() != Roles::ADMIN) {
                $GLOBALS["errors"]["role"] = "Nemáte přístup ke službě AdminService. Tato služba je přístupná pouze uživatelům s rolí " . Roles::ADMIN;
                http_response_code(403);
                throw new BadMethodCallException();
            }

            return $admin;
        }

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