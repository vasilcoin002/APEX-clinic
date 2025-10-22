<?php

    class UserDTO {

        public int $id;
        public string $username;
        public string $hashed_password;
        // public Role $role;

        public function __construct($user)
        {
            $this->id = $user->get_id();
            $this->username = $user->get_username();
            $this->hashed_password = $user->get_hashed_password();
            // $this->role = $user->get_role();
        }

        public function __toString()
    {
        // TODO rewrite here to write roles also
        $id = $this->id;
        $username = $this->username;
        $hashed_password = $this->hashed_password;
        
        return "{$id}, {$username}, {$hashed_password}";
    }
    }

?>