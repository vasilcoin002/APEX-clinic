<?php

    class UserRepository {

        private string $db_path = "./users.json";
        private array|null $users = null;

        public function get_db_path(): string {
            return $this->db_path;
        }

        public function debug_to_console($data) {
            $output = $data;
            if (is_array($output))
                $output = implode(',', $output);

            echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
        }


        public function get_users(): array {
            if ($this->users != null) {
                return $this->users;
            }

            $file_contents = file_get_contents($this->get_db_path());
            $decoded_array = json_decode($file_contents, true);
            if (!isset($decoded_array)) {
                return [];
            }

            $users_array = [];

            foreach ($decoded_array as $elem) {
                $user = new User(
                    $elem["id"],
                    $elem["email"],
                    $elem["password"],
                    $elem["role"]
                );
                $users_array[] = $user;
            };
            return $users_array;
        }

        public function echo_db(): void {
            foreach ($this->get_users() as $user) {
                $str_value = implode(', ', $user);
                echo "{$str_value} <br>";
            };
        }

        private function var_dump_pretty($var): void {
            echo '<pre>';
            var_dump($var);
            echo '</pre>';
        }

        // here goes array with Users, but not with associative array representation of user
        private function rewrite_db(array $new_users): void {

            $new_db_associative_array = [];
            foreach ($new_users as $user) {
                $new_db_associative_array[] = $user->toAssociativeArray();
            }

            $json_encoded_db = json_encode($new_db_associative_array, JSON_PRETTY_PRINT);
            file_put_contents($this->db_path, $json_encoded_db);

            $this->users = $new_users;
        }

        public function add_user(User $user): User {
            $users = $this->get_users();

            $user_with_same_email = $this->find_user_by_email($user->get_email());
            if (isset($user_with_same_email)) {
                throw new InvalidArgumentException("This email is already taken. Please, provide another one");
            }

            # cheking if db is not empty
            if (count($users) > 0) {
                $user->set_id(end($users)->get_id() + 1);
            } else {
                $user->set_id(1);
            }

            $users[] = $user;
            $this->rewrite_db($users);

            return $user;
        }

        public function find_user_by_email(string $email): ?User {
            foreach ($this->get_users() as $user) {
                if ($email == $user->get_email()) {
                    return $user;
                }
            }
            return null;
        }

        public function find_user_by_id(int $id): ?User {
            foreach ($this->get_users() as $user) {
                if ($id == $user->get_id()) {
                    return $user;
                }
            }
            return null;
        }

        public function delete_user(User $user): void {
            $user_id = $user->get_id();
            if (!isset($user_id)) {
                throw new InvalidArgumentException("User does not have id. Please, provide user with id");
            }

            $users = $this->get_users();
            foreach ($users as $i=>$current_user) {
                if ($current_user->get_id() == $user->get_id()) {
                    unset($users[$i]);
                    $this->rewrite_db($users);
                    break;
                }
            }
        }

        public function update_user(User $user) {

            $user_id = $user->get_id();
            if (!isset($user_id)) {
                throw new InvalidArgumentException("User does not have id. Please, provide user with id");
            }

            $user_with_same_email = $this->find_user_by_email($user->get_email());
            if (isset($user_with_same_email) && $user->get_id() != $user_with_same_email->get_id()) {
                throw new InvalidArgumentException("This email is already taken. Please, provide another one");
            }

            $users = $this->get_users();
            foreach ($users as $i=>$current_user) {
                if ($current_user->get_id() == $user->get_id()) {
                    $users[$i] = $user;
                    $this->rewrite_db($users);
                    break;
                }
            }

            return $user;
        }
    }

?>