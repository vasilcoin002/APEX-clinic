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
            if ($userDTO->email == null) {
                throw new InvalidArgumentException("Email is not provided");
            }
            if ($userDTO->password == null) {
                throw new InvalidArgumentException("Password is not provided");
            }

            $user = $this->user_repository->find_user_by_email($userDTO->email);

            if (!isset($user)) {
                throw new InvalidArgumentException("User not found. Please, provide the rigth email");
            }

            if (!password_verify($userDTO->password, $user->get_hashed_password())) {
                throw new InvalidArgumentException("Password is incorrect. Please, provide the right one");
            }

            return $user;
        }

        private function get_user_from_session(): User {
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
            $user = $this->get_user_from_session();
            if ($userDTO->email == $user->get_email()) {
                throw new InvalidArgumentException("You provided the same email as you already have");
            }

            $user->set_email($userDTO->email);
            $user = $this->user_repository->update_user($user);
            $_SESSION["user_email"] = $user->get_email();
            return $user;
        }


        public function update_password(UserDTO $userDTO): void {
            $user = $this->get_user_from_session();
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

        public function update_avatar(UserDTO $userDTO): void {
            
            $user = $this->get_user_from_session();

            $target_dir = "/Applications/XAMPP/xamppfiles/htdocs/website/users/avatars/";
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

        public function delete_user(UserDTO $userDTO): void {
            $admin = $this->get_user_from_session();
            if ($admin->get_role() != Roles::ADMIN) {
                throw new BadMethodCallException("You don't have permission for this action");
            }

            $user = $this->user_repository->find_user_by_email($userDTO->email);
            if ($user == null) {
                throw new InvalidArgumentException("User not found. Please, provide the right email");
            }
            if ($user->get_id() == $admin->get_id()) {
                throw new BadMethodCallException(
                    "You can't delete yourself through the admin panel. Please, use user's panel"
                );
            }
            if ($user->get_role() == Roles::ADMIN) {
                throw new InvalidArgumentException("You can't delete users with role " . Roles::ADMIN);
            }
            $this->user_repository->delete_user($user);
        }
    }

?>