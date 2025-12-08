<?php
    class User {

        private ?int $id;
        private string $email;
        private string $name;
        private string $surname;
        private string $phone_number;
        private string $hashed_password;
        private string $role;
        public ?string $avatar_path = null;
        public ?string $comment = null;

        public function __construct(
            ?int $id, string $email, string $name, string $surname,
            string $phone_number, string $hashed_password, string $role,
        ) {
            $this->id = $id;
            $this->email = $email;
            $this->name = $name;
            $this->surname = $surname;
            $this->phone_number = $phone_number;
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

        public function get_name(): string {
            return $this->name;
        }

        public function set_name(string $name) {
            $this->name = $name;
        }

        public function get_surname(): string {
            return $this->surname;
        }

        public function set_surname(string $surname) {
            $this->surname = $surname;
        }

        public function get_phone_number(): string {
            return $this->phone_number;
        }

        public function set_phone_number(string $phone_number) {
            $this->phone_number = $phone_number;
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

        public function set_role(string $role): void {
            $this->role = $role;
        }

        public function get_avatar_path(): ?string {
            return $this->avatar_path;
        }

        public function set_avatar_path(?string $avatar_path) {
            $this->avatar_path = $avatar_path;
        }

        public function get_comment(): ?string {
            return $this->comment;
        }

        public function set_comment(?string $comment) {
            $this->comment = $comment;
        }

        public function toAssociativeArray(): array {
            return array(
                "id" => $this->get_id(),
                "email" => $this->get_email(), 
                "name" => $this->get_name(),
                "surname" => $this->get_surname(),
                "phone_number" => $this->get_phone_number(),
                "password" => $this->get_hashed_password(),
                "role" => $this->get_role(),
                "avatar_path" => $this->get_avatar_path(),
                "comment" => $this->get_comment(),
            );
        }
    }
?>