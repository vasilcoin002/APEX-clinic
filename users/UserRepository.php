<?php

    class UserRepository {

        private string $db_path = "../users/users.json";
        private array|null $users = null;

        public function get_db_path(): string {
            return $this->db_path;
        }

        private function get_users(): array {
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
                    $elem["name"],
                    $elem["surname"],
                    $elem["phone"],
                    $elem["password"],
                    $elem["role"],
                );
                $user->set_avatar_path($elem["avatar_path"]);
                $user->set_comment($elem["comment"]);
                $users_array[] = $user;
            };
            return $users_array;
        }

        public function get_number_of_users(): int {
            return count($this->get_users());
        }

        public function get_range_of_users(int $from, int $to): array {
            if ($to <= $from) {
                $GLOBALS["errors"]["to"] = 'Hodnota "do" (to) nesmí být menší nebo rovna hodnotě "od" (from).';
                http_response_code(400);
                throw new InvalidArgumentException();
            }
            $users = $this->get_users();
            return array_slice($users, $from, $to - $from);
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

        private function check_if_email_is_taken(string $email, ?int $user_id): void {
            $user_with_same_email = $this->find_user_by_email($email);
            if (isset($user_with_same_email) && $user_with_same_email->get_id() !== $user_id) {
                $GLOBALS["errors"]["email"] = "Tento e-mail je již obsazen. Zadejte prosím jiný.";
                http_response_code(400);
                throw new InvalidArgumentException();
            }
        }

        public function add_user(User $user): User {
            $this->check_if_email_is_taken($user->get_email(), null);

            $users = $this->get_users();

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
                $GLOBALS["errors"]["id"] = "Uživatel nemá ID. Zadejte prosím uživatele s ID.";
                http_response_code(400);
                throw new InvalidArgumentException();
            }

            $users = $this->get_users();
            foreach ($users as $i => $current_user) {
                if ($current_user->get_id() == $user->get_id()) {
                    if (isset($current_user->avatar_path)) {
                        unlink($current_user->get_avatar_path());
                    }
                    unset($users[$i]);
                    $this->rewrite_db($users);
                    break;
                }
            }
        }

        public function update_user(User $user): User {
            $user_id = $user->get_id();
            if (!isset($user_id)) {
                $GLOBALS["errors"]["id"] = "Uživatel nemá ID. Zadejte prosím uživatele s ID.";
                http_response_code(400);
                throw new InvalidArgumentException();
            }

            $this->check_if_email_is_taken($user->get_email(), $user_id);

            $users = $this->get_users();
            foreach ($users as $i => $current_user) {
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