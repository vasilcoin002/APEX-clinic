<?php

    require_once "./UserRepository.php";
    require_once "./User.php";
    require_once "./Roles.php";

    class UserService {

        private UserRepository $user_repository;


        public function __construct() {
            $this->user_repository = new UserRepository();
        }


        public function debug_to_console($data) {
            $output = $data;
            if (is_array($output))
                $output = implode(',', $output);

            echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
        }


        // TODO finish validate_email function
        private function validate_email($email): void {
            
        }


        // TODO finish validate_password function
        private function validate_password($email): void {
            
        }


        public function add_user(string $email, string $password): ?User {
            $this->validate_email($email);
            $this->validate_password($password);

            $user = new User(null, $email, $password, Roles::USER);
            return $this->user_repository->add_user($user);
        }


        public function login(string $email, string $password): User {
            $user = $this->user_repository->find_user_by_email($email);

            if ($user == null) {
                throw new ValueError("User not found. Please, provide the right email");
            }

            echo "{$password} <br>";
            echo "{$user->get_hashed_password()} <br>";

            if (!password_verify($password, $user->get_hashed_password())) {
                throw new ValueError("Password is incorrect. Please, provide the right one");
            }

            $_SESSION["user_id"] = $user->get_id();
            $_SESSION["email"] = $user->get_email();
            return $user;
        }
    }

?>