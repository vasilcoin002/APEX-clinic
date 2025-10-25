<?php

    require_once "./UserRepository.php";
    require_once "./User.php";
    require_once "./UserDTO.php";
    require_once "./Roles.php";

    class UserService {

        private UserRepository $user_repository;


        public function __construct() {
            $this->user_repository = new UserRepository();
        }

        private function get_user_and_verify(UserDTO $userDTO): User {
            $user = $this->user_repository->find_user_by_email($userDTO->email);

            if (!isset($user)) {
                throw new InvalidArgumentException("User not found. Please, provide the rigth email");
            }

            if (!password_verify($userDTO->password, $user->get_hashed_password())) {
                throw new InvalidArgumentException("Password is incorrect. Please, provide the right one");
            }

            return $user;
        }


        // TODO finish validate_email function
        private function validate_email($email): void {
            
        }


        // TODO finish validate_password function
        private function validate_password($email): void {
            
        }


        public function add_user(UserDTO $userDTO): ?User {
            $this->validate_email($userDTO->email);
            $this->validate_password($userDTO->password);

            // $hashed_password = password_hash($userDTO->password, PASSWORD_DEFAULT);
            $hashed_password = $this->get_hashed_password($userDTO->password);


            $user = new User(null, $userDTO->email, $hashed_password, Roles::USER);
            return $this->user_repository->add_user($user);
        }


        public function login(UserDTO $userDTO): User {
            $user = $this->get_user_and_verify($userDTO);

            $_SESSION["user_id"] = $user->get_id();
            $_SESSION["user_email"] = $user->get_email();
            $_SESSION["user_role"] = $user->get_role();

            return $user;
        }


        public function logout() {
            session_destroy();
        }


        public function delete_user_by_user_data(UserDTO $userDTO) {
            $user = $this->get_user_and_verify($userDTO);

            $this->user_repository->delete_user($user);
            $this->logout();
        }


        private function check_if_session_is_active(): void {
            if (!isset($_SESSION["user_id"])) {
                throw new BadMethodCallException("You need to be authorized to do this action");
            }
        }

        private function get_hashed_password(string $password): string {
            return password_hash($password, PASSWORD_DEFAULT);
        }


        public function update_email(UserDTO $userDTO): User {
            $this->check_if_session_is_active();

            $user = $this->user_repository->find_user_by_id($_SESSION["user_id"]);
            if ($userDTO->email == $user->get_email()) {
                throw new InvalidArgumentException("You provided the same email as you already have");
            }

            $user->set_email($userDTO->email);
            $user = $this->user_repository->update_user($user);
            $_SESSION["user_email"] = $user->get_email();
            return $user;
        }

        public function update_password(UserDTO $userDTO): void {
            $this->check_if_session_is_active();

            $user = $this->user_repository->find_user_by_id($_SESSION["user_id"]);
            if (password_verify($userDTO->password, $user->get_hashed_password())) {
                throw new InvalidArgumentException("You provided the same password as you already have");
            }

            $user->set_hashed_password($this->get_hashed_password($userDTO->password));
            $this->user_repository->update_user($user);
        }
    }

?>