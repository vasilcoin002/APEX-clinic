<?php
    class User {

        private ?int $id;
        private string $email;
        private string $hashed_password;
        private string $role;
        public ?string $avatar_path = null;

        public function __construct(?int $id, string $email, string $hashed_password, string $role) {
            $this->id = $id;
            $this->email = $email;
            $this->hashed_password = $hashed_password;
            $this->role = $role;
        }

        public function get_id(): ?int {
            return $this->id;
        }

        public function set_id(int $id) {
            $this->id = $id;
        }

        public function get_email(): string {
            return $this->email;
        }

        public function set_email(string $email) {
            $this->email = $email;
        }

        public function get_hashed_password(): string {
            return $this->hashed_password;
        }

        public function set_hashed_password(string $hashed_password) {
            $this->hashed_password = $hashed_password;
        }

        public function get_role(): string {
            return $this->role;
        }

        public function get_avatar_path(): ?string {
            return $this->avatar_path;
        }

        public function set_avatar_path(?string $avatar_path) {
            $this->avatar_path = $avatar_path;
        }

        public function toAssociativeArray(): array {
            return array(
                "id" => $this->get_id(),
                "email" => $this->get_email(), 
                "password" => $this->get_hashed_password(),
                "role" => $this->get_role(),
                "avatar_path" => $this->get_avatar_path(),
            );
        }
    }
?>