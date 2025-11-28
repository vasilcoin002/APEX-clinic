<?php

    class UserDTO {

        public ?int $id;
        public string $email;
        public string $password;
        public string $name;
        public string $surname;
        public string|int $phone_number;
        public string $role;
        public string $avatar_path;

    }

?>