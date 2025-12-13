<?php

    class UserDTO {

        public ?int $id;
        public string $email;
        public string $password;
        public string $name;
        public string $surname;
        public string $phone;
        public string $role;
        public string $avatar_path;
        public string $comment;

        public function toAssociativeArray(): array {
            return array(
                "id" => $this->id,
                "email" => $this->email,
                "password" => $this->password,
                "name" => $this->name,
                "surname" => $this->surname,
                "phone" => $this->phone,
                "role" => $this->role,
                "avatar_path" => $this->avatar_path,
                "comment" => $this->comment,
            );
        }

    }

?>