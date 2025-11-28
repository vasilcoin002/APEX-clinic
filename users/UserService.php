<?php

    require_once "UserRepository.php";
    require_once "User.php";
    require_once "UserDTO.php";
    require_once "Roles.php";

    class UserService {

        private UserRepository $user_repository;

        public function __construct() {
            $this->user_repository = new UserRepository();
        }


        private function get_user_and_verify(UserDTO $userDTO): User {
            $this->check_if_email_and_password_is_in_user_dto($userDTO);

            $user = $this->user_repository->find_user_by_email($userDTO->email);

            if (!isset($user)) {
                throw new InvalidArgumentException("User not found. Please, provide the rigth email");
            }

            if (!password_verify($userDTO->password, $user->get_hashed_password())) {
                throw new InvalidArgumentException("Password is incorrect. Please, provide the right one");
            }

            return $user;
        }

        public function check_if_email_is_in_user_dto(UserDTO $userDTO): void {
            if ($userDTO->email == null) {
                throw new InvalidArgumentException("Email is not provided");
            }
        }

        public function check_if_phone_is_in_user_dto(UserDTO $userDTO): void {
            if ($userDTO->phone_number == null) {
                throw new InvalidArgumentException("Phone number is not provided");
            }
        }
        
        public function check_if_password_is_in_user_dto(UserDTO $userDTO): void {
            if ($userDTO->password == null) {
                throw new InvalidArgumentException("Password is not provided");
            }
        }

        public function check_if_email_and_password_is_in_user_dto($userDTO): void {
            $this->check_if_email_is_in_user_dto($userDTO);
            $this->check_if_password_is_in_user_dto($userDTO);
        }

        public function get_user_from_session(): User {
            $this->check_if_session_is_active();
            $user = $this->user_repository->find_user_by_id($_SESSION["user_id"]);
            if ($user == null) {
                throw new UnexpectedValueException("User from session is not found");
            }
            return $user;
        }

        // TODO finish validate_email function
        private function validate_email($email): void {
            
        }


        // TODO finish validate_password function
        private function validate_password($password): void {
            
        }

        private function validate_phone_number($cleaned_phone_number) : void {
            if (strlen($cleaned_phone_number) !== 9) {
                throw new InvalidArgumentException("The Czech phone number must contain exactly 9 numbers");
            }
        }

        private function validate_name($name): void {
            if (strlen($name) === 0) {
                throw new InvalidArgumentException("Name must be filled");
            }
        }

        private function validate_surname($surname): void {
            if (strlen($surname) === 0) {
                throw new InvalidArgumentException("Surname must be filled");
            }
        }
        
        private function get_cleaned_phone_number(string $phone_number) {
            return preg_replace('/[^0-9]/', '', $phone_number);
        }

        public function add_user(UserDTO $userDTO): ?User {
            $this->check_if_email_and_password_is_in_user_dto($userDTO);
            $this->validate_email($userDTO->email);
            $this->validate_password($userDTO->password);
            $this->validate_name($userDTO->name);
            $this->validate_surname($userDTO->surname);

            $cleaned_phone_number = $this->get_cleaned_phone_number($userDTO->phone_number);
            $this->validate_phone_number($cleaned_phone_number);
            $userDTO->phone_number = intval($cleaned_phone_number);
            $hashed_password = $this->get_hashed_password($userDTO->password);

            $user = new User(
                null, 
                $userDTO->email, 
                $userDTO->name,
                $userDTO->surname,
                $userDTO->phone_number,
                $hashed_password, 
                Roles::USER
            );
            return $this->user_repository->add_user($user);
        }


        public function login(UserDTO $userDTO): User {
            $user = $this->get_user_and_verify($userDTO);

            $_SESSION["user_id"] = $user->get_id();
            $_SESSION["user_email"] = $user->get_email();
            $_SESSION["user_role"] = $user->get_role();

            return $user;
        }


        public function logout(): void {
            session_destroy();
        }


        public function delete_user_by_user_data(UserDTO $userDTO): void {
            $user = $this->get_user_and_verify($userDTO);

            $this->user_repository->delete_user($user);
            $this->logout();
        }

        public function check_if_session_is_active(): void {
            if (!isset($_SESSION["user_id"])) {
                throw new BadMethodCallException("You need to be authorized to do this action");
            }
        }

        private function get_hashed_password(string $password): string {
            return password_hash($password, PASSWORD_DEFAULT);
        }


        public function update_email(UserDTO $userDTO): User {
            $this->check_if_email_is_in_user_dto($userDTO);

            $user = $this->get_user_from_session();
            if ($userDTO->email == $user->get_email()) {
                throw new InvalidArgumentException("You provided the same email as you already have");
            }

            $user->set_email($userDTO->email);
            $user = $this->user_repository->update_user($user);
            $_SESSION["user_email"] = $user->get_email();
            return $user;
        }

        public function update_name($userDTO): User {
            if ($userDTO->name == null) {
                throw new InvalidArgumentException("Name is not provided");
            }

            $user = $this->get_user_from_session();
            if ($userDTO->name == $user->get_name()) {
                throw new InvalidArgumentException("You provided the same name as you already have");
            }

            $user->set_name($userDTO->name);
            $user = $this->user_repository->update_user($user);
            return $user;
        }

        public function update_surname($userDTO): User {
            if ($userDTO->surname == null) {
                throw new InvalidArgumentException("Surname is not provided");
            }

            $user = $this->get_user_from_session();
            if ($userDTO->surname == $user->get_surname()) {
                throw new InvalidArgumentException("You provided the same surname as you already have");
            }

            $user->set_surname($userDTO->surname);
            $user = $this->user_repository->update_user($user);
            return $user;
        }

        public function update_phone_number(UserDTO $userDTO): User {
            $this->check_if_phone_is_in_user_dto($userDTO);

            $user = $this->get_user_from_session();
            if ($userDTO->phone_number == $user->get_phone_number()) {
                throw new InvalidArgumentException("You provided the same phone number as you already have");
            }

            $user->set_phone_number($userDTO->phone_number);
            $user = $this->user_repository->update_user($user);
            return $user;
        }

        public function update_password(UserDTO $userDTO): void {
            $user = $this->get_user_from_session();

            $this->check_if_password_is_in_user_dto($userDTO);
            if (password_verify($userDTO->password, $user->get_hashed_password())) {
                throw new InvalidArgumentException("You provided the same password as you already have");
            }

            $user->set_hashed_password($this->get_hashed_password($userDTO->password));
            $this->user_repository->update_user($user);
        }

        public function delete_avatar(): void {
            $user = $this->get_user_from_session();

            if ($user->get_avatar_path() == null) {
                throw new BadMethodCallException("You don't have avatar to delete");
            }

            unlink($user->get_avatar_path());
            $user->set_avatar_path(null);
            $this->user_repository->update_user($user);
        }

        public function update_avatar(): void {
            $user = $this->get_user_from_session();

            $target_dir = "../users/avatars/";
            $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
            $image_file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
            // Check if file is provided
            if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] === UPLOAD_ERR_NO_FILE) {
                throw new InvalidArgumentException("File is not provided. Please, provide an image");
            }
            // Check file format
            $ALLOWED_IMAGE_FORMATS = ["png", "jpg", "jpeg", "gif"];
            if (!in_array($image_file_type, $ALLOWED_IMAGE_FORMATS)) {
                throw new InvalidArgumentException(
                    "FIle is not an image. Please, provide an image in one of those formats: " 
                    . implode(", ", $ALLOWED_IMAGE_FORMATS)
                );
            }
            // Check if image file is a actual image or fake image
            $image_size = getimagesize($_FILES["avatar"]["tmp_name"]);
            if($image_size == false) {
                throw new InvalidArgumentException("File is not an image. Please, provide a real image");
            }
            // Check file size
            $MAX_SIZE_MB = 16;
            if ($_FILES["avatar"]["size"] > $MAX_SIZE_MB*1048576 - 1) { 
                throw new InvalidArgumentException(
                    "File size is too big. Please, provide image with max size "
                    . $MAX_SIZE_MB . "Mb"
                );
            }

            $renamed_file_name = $target_dir . "{$user->get_id()}.{$image_file_type}";

            move_uploaded_file($_FILES["avatar"]["tmp_name"], $renamed_file_name);
            $user->set_avatar_path($renamed_file_name);
            $this->user_repository->update_user($user);
        }
    }

?>