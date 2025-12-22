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
                $GLOBALS["errors"]["email"] = "Uživatel nenalezen. Zadejte prosím správný e-mail.";
                http_response_code(404);
                throw new InvalidArgumentException();
            }

            if (!password_verify($userDTO->password, $user->get_hashed_password())) {
                $GLOBALS["errors"]["password"] = "Heslo je nesprávné. Zadejte prosím správné heslo.";
                http_response_code(400);
                throw new InvalidArgumentException();
            }

            return $user;
        }

        public function check_if_email_is_in_user_dto(UserDTO $userDTO): void {
            if (empty($userDTO->email)) {
                $GLOBALS["errors"]["email"] = "E-mail je povinný.";
                http_response_code(400);
                throw new InvalidArgumentException();
            }
        }

        public function check_if_id_is_in_user_dto(UserDTO $userDTO): void {
            if (empty($userDTO->id)) {
                $GLOBALS["errors"]["id"] = "ID je povinné.";
                http_response_code(400);
                throw new InvalidArgumentException();
            }
        }

        public function check_if_phone_is_in_user_dto(UserDTO $userDTO): void {
            if (empty($userDTO->phone)) {
                $GLOBALS["errors"]["phone"] = "Telefonní číslo je povinné.";
                http_response_code(400);
                throw new InvalidArgumentException();
            }
        }

        public function check_if_password_is_in_user_dto(UserDTO $userDTO): void {
            if (empty($userDTO->password)) {
                $GLOBALS["errors"]["password"] = "Heslo je povinné.";
                http_response_code(400);
                throw new InvalidArgumentException();
            }
        }

        public function check_if_email_and_password_is_in_user_dto(UserDTO $userDTO): void {

            if (empty($userDTO->email)) {
                $GLOBALS["errors"]["email"] = "E-mail je povinný.";
            }

            if (empty($userDTO->password)) {
                $GLOBALS["errors"]["password"] = "Heslo je povinné.";
            }

            if (count($GLOBALS["errors"]) !== 0) {
                http_response_code(400);
                throw new InvalidArgumentException();
            }
        }

        public function get_user_from_session(): User {
            $this->check_if_session_is_active();
            $user = $this->user_repository->find_user_by_id($_SESSION["user_id"]);
            if ($user == null) {
                $GLOBALS["errors"]["session"] = "Uživatel ze sezení (session) nebyl nalezen.";
                http_response_code(404);
                throw new UnexpectedValueException();
            }
            return $user;
        }

        public function get_user_info(User $user): array {
            return array(
                "id" => $user->get_id(),
                "email" => $user->get_email(), 
                "name" => $user->get_name(),
                "surname" => $user->get_surname(),
                "phone" => $user->get_phone(),
                "role" => $user->get_role(),
                "avatar_path" => $user->get_avatar_path(),
                "comment" => $user->get_comment(),
            );
        }

        public function get_session_user_info(): array {
            $user = $this->get_user_from_session();

            return $this->get_user_info($user);
        }

        private function validate_email($email): void {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $GLOBALS["errors"]["email"] = "E-mail není platný. Zadejte prosím platný formát.";
                http_response_code(400);
                throw new InvalidArgumentException();
            }
        }

        private function validate_password($password): void {
            $failures = [];

            $minLengthPattern = '/.{8,}/';
            if (!preg_match($minLengthPattern, $password)) {
                $failures[] = 'musí být alespoň 8 znaků dlouhé';
            }

            $uppercasePattern = '/[A-Z]/';
            if (!preg_match($uppercasePattern, $password)) {
                $failures[] = 'musí obsahovat alespoň jedno velké písmeno (A-Z)';
            }

            $lowercasePattern = '/[a-z]/';
            if (!preg_match($lowercasePattern, $password)) {
                $failures[] = 'musí obsahovat alespoň jedno malé písmeno (a-z)';
            }

            $digitPattern = '/\d/';
            if (!preg_match($digitPattern, $password)) {
                $failures[] = 'musí obsahovat alespoň jednu číslici (0-9)';
            }

            if (!empty($failures)) {
                $GLOBALS["errors"]["password"] = "Heslo je příliš slabé: " . implode(", ", $failures);
                http_response_code(400);
                throw new InvalidArgumentException();
            }
        }

        private function validate_phone($phone) : void {
            if (!preg_match('/\d/', $phone)) {
                $GLOBALS["errors"]["phone"] = "Telefonní číslo nesmí být prázdné a musí obsahovat číslice.";
                http_response_code(400);
                throw new InvalidArgumentException();
            }
        }

        private function validate_name($name): void {
            if (strlen($name) === 0) {
                $GLOBALS["errors"]["name"] = "Jméno je povinné.";
                http_response_code(400);
                throw new InvalidArgumentException();
            }
        }

        private function validate_surname($surname): void {
            if (strlen($surname) === 0) {
                $GLOBALS["errors"]["surname"] = "Příjmení musí být vyplněno.";
                http_response_code(400);
                throw new InvalidArgumentException();
            }
        }

        private function validate_comment($comment): void {
            if (strlen($comment) > 1000) {
                $GLOBALS["errors"]["comment"] = "Komentář je příliš dlouhý. Prosím, omezte jej na 1000 znaků.";
                http_response_code(400);
                throw new InvalidArgumentException();
            }
        }

        public function check_if_logined(): bool {
            return isset($_SESSION["user_id"]);
        }

        public function check_if_user_dto_is_complete_for_registration(UserDTO $userDTO): void {
            if (!isset($userDTO->email)) {
                $GLOBALS["errors"]["email"] = "E-mail je povinný.";
            }
            if (!isset($userDTO->password)) {
                $GLOBALS["errors"]["password"] = "Heslo je povinné.";
            }
            if (!isset($userDTO->name)) {
                $GLOBALS["errors"]["name"] = "Jméno je povinné.";
            }
            if (!isset($userDTO->surname)) {
                $GLOBALS["errors"]["surname"] = "Příjmení je povinné.";
            }
            if (!isset($userDTO->phone)) {
                $GLOBALS["errors"]["phone"] = "Telefon je povinný.";
            }

            if (count($GLOBALS["errors"]) !== 0) {
                http_response_code(400);
                throw new InvalidArgumentException();
            }
        }

        public function add_user(UserDTO $userDTO): ?User {
            $this->check_if_user_dto_is_complete_for_registration($userDTO);
            $this->validate_email($userDTO->email);
            $this->validate_password($userDTO->password);
            $this->validate_name($userDTO->name);
            $this->validate_surname($userDTO->surname);
            $this->validate_phone($userDTO->phone);
            
            $hashed_password = $this->get_hashed_password($userDTO->password);

            $user = new User(
                null, 
                $userDTO->email, 
                $userDTO->name,
                $userDTO->surname,
                $userDTO->phone,
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
            if (!$this->check_if_logined()) {
                $GLOBALS["errors"]["session"] = "K provedení této akce musíte být přihlášeni.";
                http_response_code(401);
                throw new BadMethodCallException();
            }
        }

        private function get_hashed_password(string $password): string {
            return password_hash($password, PASSWORD_DEFAULT);
        }


        public function update_email(UserDTO $userDTO): User {
            $user = $this->get_user_from_session();
            $this->check_if_email_is_in_user_dto($userDTO);

            if ($userDTO->email == $user->get_email()) {
                $GLOBALS["errors"]["email"] = "Zadali jste stejný e-mail, jaký již používáte.";
                http_response_code(400);
                throw new InvalidArgumentException();
            }
            $this->validate_email($userDTO->email);

            $user->set_email($userDTO->email);
            $user = $this->user_repository->update_user($user);
            $_SESSION["user_email"] = $user->get_email();
            return $user;
        }

        public function update_profile(UserDTO $userDTO): User {
            $user = $this->get_user_from_session();
            $isUpdated = false;

            // Check if provided AND if it is actually different
            // Handle Name
            if (isset($userDTO->name) && $userDTO->name !== $user->get_name()) {
                $this->validate_name($userDTO->name);
                $user->set_name($userDTO->name);
                $isUpdated = true;
            }

            // Handle Surname
            if (isset($userDTO->surname) && $userDTO->surname !== $user->get_surname()) {
                $this->validate_surname($userDTO->surname);
                $user->set_surname($userDTO->surname);
                $isUpdated = true;
            }

            // Handle Phone Number
            if (isset($userDTO->phone) && $userDTO->phone !== $user->get_phone()) {
                $this->validate_phone($userDTO->phone);
                $user->set_phone($userDTO->phone);
                $isUpdated = true;
            }

            // Handle Comment
            if (isset($userDTO->comment) && $userDTO->comment !== $user->get_comment()) {
                $this->validate_comment($userDTO->comment);
                $user->set_comment($userDTO->comment);
                $isUpdated = true;
            }

            if ($isUpdated) {
                return $this->user_repository->update_user($user);
            }

            return $user;
        }

        public function update_password(UserDTO $userDTO): void {
            $user = $this->get_user_from_session();

            $this->check_if_password_is_in_user_dto($userDTO);
            if (password_verify($userDTO->password, $user->get_hashed_password())) {
                $GLOBALS["errors"]["password"] = "Zadali jste stejné heslo, jaké již používáte.";
                http_response_code(400);
                throw new InvalidArgumentException();
            }
            $this->validate_password($userDTO->password);

            $user->set_hashed_password($this->get_hashed_password($userDTO->password));
            $this->user_repository->update_user($user);
        }

        public function delete_avatar(): void {
            $user = $this->get_user_from_session();

            if ($user->get_avatar_path() == null) {
                $GLOBALS["errors"]["avatar"] = "Nemáte žádný avatar k smazání.";
                http_response_code(400);
                throw new BadMethodCallException();
            }

            unlink($user->get_avatar_path());
            $user->set_avatar_path(null);
            $this->user_repository->update_user($user);
        }

        public function update_avatar(): void {
            $user = $this->get_user_from_session();

            if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] === UPLOAD_ERR_NO_FILE) {
                $GLOBALS["errors"]["avatar"] = "Soubor nebyl poskytnut. Nahrajte prosím obrázek.";
                http_response_code(400);
                throw new InvalidArgumentException();
            }

            $target_dir = "../users/avatars/";
            $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
            $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $ALLOWED_IMAGE_FORMATS = ["png", "jpg", "jpeg", "gif"];
            if (!in_array($image_file_type, $ALLOWED_IMAGE_FORMATS)) {
                $GLOBALS["errors"]["avatar"] = "Soubor není obrázek. Nahrajte prosím obrázek v jednom z těchto formátů: " . implode(", ", $ALLOWED_IMAGE_FORMATS);
                http_response_code(400);
                throw new InvalidArgumentException();
            }
            
            $image_size = getimagesize($_FILES["avatar"]["tmp_name"]);
            if ($image_size == false) {
                $GLOBALS["errors"]["avatar"] = "Soubor není platný obrázek.";
                http_response_code(400);
                throw new InvalidArgumentException();
            }

            $MAX_SIZE_MB = 16;
            if ($_FILES["avatar"]["size"] > $MAX_SIZE_MB * 1048576 - 1) {
                $GLOBALS["errors"]["avatar"] = "Soubor je příliš velký. Nahrajte prosím obrázek o maximální velikosti " . $MAX_SIZE_MB . "Mb";
                http_response_code(400);
                throw new InvalidArgumentException();
            }

            $renamed_file_name = $target_dir . "{$user->get_id()}.{$image_file_type}";

            move_uploaded_file($_FILES["avatar"]["tmp_name"], $renamed_file_name);
            unlink($user->get_avatar_path());
            $user->set_avatar_path($renamed_file_name);
            $this->user_repository->update_user($user);
        }
    }

?>