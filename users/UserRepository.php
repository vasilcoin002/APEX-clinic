<?php

/**
 * Repository class for managing User data persistence.
 *
 * This class acts as a data access layer (DAL) using a JSON file as the storage medium
 * instead of a traditional SQL database. It handles reading, writing, updating,
 * and deleting user records from the file system.
 *
 * @package App\Repositories
 * @version 1.0.0
 */
class UserRepository {

    /**
     * The file system path to the JSON database file.
     *
     * @var string
     */
    private string $db_path = "../users/users.json";

    /**
     * In-memory cache of user objects.
     * Used to prevent reading the file multiple times during a single request.
     *
     * @var array<User>|null
     */
    private array|null $users = null;

    /**
     * Gets the current path to the database file.
     *
     * @return string
     */
    public function get_db_path(): string {
        return $this->db_path;
    }

    /**
     * Retrieves all users from the JSON file.
     *
     * Implements a lazy-loading mechanism: if users are already loaded in memory ($this->users),
     * it returns the cached version. Otherwise, it reads the file, decodes the JSON,
     * and maps the data to User objects.
     *
     * @return array<User> An array of User objects.
     */
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

    /**
     * Returns the total count of stored users.
     *
     * @return int
     */
    public function get_number_of_users(): int {
        return count($this->get_users());
    }

    /**
     * Retrieves a specific slice of users (pagination).
     *
     * @param int $from The starting index (offset).
     * @param int $to   The ending index (limit).
     *
     * @return array<User> The sliced array of users.
     *
     * @throws InvalidArgumentException If $to is less than or equal to $from.
     */
    public function get_range_of_users(int $from, int $to): array {
        if ($to <= $from) {
            $GLOBALS["errors"]["to"] = 'Hodnota "do" (to) nesmí být menší nebo rovna hodnotě "od" (from).';
            http_response_code(400);
            throw new InvalidArgumentException();
        }
        $users = $this->get_users();
        return array_slice($users, $from, $to - $from);
    }

    /**
     * Overwrites the JSON database file with the provided list of users.
     *
     * Converts the array of User objects into associative arrays before encoding to JSON.
     *
     * @param array<User> $new_users The new state of users to save.
     * @return void
     */
    private function rewrite_db(array $new_users): void {

        $new_db_associative_array = [];
        foreach ($new_users as $user) {
            $new_db_associative_array[] = $user->toAssociativeArray();
        }

        $json_encoded_db = json_encode($new_db_associative_array, JSON_PRETTY_PRINT);
        file_put_contents($this->db_path, $json_encoded_db);

        $this->users = $new_users;
    }

    /**
     * Checks if an email is already currently in use by another user.
     *
     * @param string   $email   The email to check.
     * @param int|null $user_id The ID of the current user (to exclude them from the check during updates).
     *
     * @return void
     * @throws InvalidArgumentException If the email is already taken.
     */
    private function check_if_email_is_taken(string $email, ?int $user_id): void {
        $user_with_same_email = $this->find_user_by_email($email);
        if (isset($user_with_same_email) && $user_with_same_email->get_id() !== $user_id) {
            $GLOBALS["errors"]["email"] = "Tento e-mail je již obsazen. Zadejte prosím jiný.";
            http_response_code(400);
            throw new InvalidArgumentException();
        }
    }

    /**
     * Adds a new user to the database.
     *
     * Automatically assigns a new ID based on the last user's ID (auto-increment simulation).
     *
     * @param User $user The user object to add.
     * @return User The user object with the newly assigned ID.
     * @throws InvalidArgumentException If the email is already taken.
     */
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

    /**
     * Finds a user by their email address.
     *
     * @param string $email
     * @return User|null The user if found, null otherwise.
     */
    public function find_user_by_email(string $email): ?User {
        foreach ($this->get_users() as $user) {
            if ($email == $user->get_email()) {
                return $user;
            }
        }
        return null;
    }

    /**
     * Finds a user by their ID.
     *
     * @param int $id
     * @return User|null The user if found, null otherwise.
     */
    public function find_user_by_id(int $id): ?User {
        foreach ($this->get_users() as $user) {
            if ($id == $user->get_id()) {
                return $user;
            }
        }
        return null;
    }

    /**
     * Deletes a user from the database.
     *
     * Also handles the deletion of the user's avatar file from the filesystem.
     *
     * @param User $user The user to delete.
     * @return void
     * @throws InvalidArgumentException If the provided user has no ID.
     */
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

    /**
     * Updates an existing user's information.
     *
     * @param User $user The user object containing updated data.
     * @return User The updated user object.
     * @throws InvalidArgumentException If the user has no ID or the new email is taken.
     */
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