<?php

/**
 * Represents a registered user in the system.
 *
 * This class handles sensitive user data including authentication details
 * (hashed passwords) and personal information. It is used for both 
 * data retrieval and persisting user states to the database.
 *
 * @package App\Models
 * @version 1.0.0
 */
class User {

    /**
     * The unique identifier for the user.
     * Can be null if the user has not yet been persisted to the database.
     *
     * @var int|null
     */
    private ?int $id;

    /**
     * The user's email address.
     * Used as the primary unique identifier for login.
     *
     * @var string
     */
    private string $email;

    /**
     * The user's first name.
     *
     * @var string
     */
    private string $name;

    /**
     * The user's last name (surname).
     *
     * @var string
     */
    private string $surname;

    /**
     * The user's contact phone number.
     *
     * @var string
     */
    private string $phone;

    /**
     * The secure hash of the user's password.
     * Note: This should never store a plain-text password.
     *
     * @var string
     */
    private string $hashed_password;

    /**
     * The user's role/permission level (e.g., 'admin', 'customer').
     *
     * @var string
     */
    private string $role;

    /**
     * The file path to the user's avatar image.
     * Null if no custom avatar is set.
     *
     * @var string|null
     */
    public ?string $avatar_path = null;

    /**
     * Optional administrative comments or notes about the user.
     *
     * @var string|null
     */
    public ?string $comment = null;

    /**
     * User constructor.
     *
     * @param int|null $id              The database ID (pass null for new records).
     * @param string   $email           The user's email address.
     * @param string   $name            The user's first name.
     * @param string   $surname         The user's last name.
     * @param string   $phone           The user's phone number.
     * @param string   $hashed_password The encrypted password string.
     * @param string   $role            The user's role identifier.
     */
    public function __construct(
        ?int $id, string $email, string $name, string $surname,
        string $phone, string $hashed_password, string $role,
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
        $this->surname = $surname;
        $this->phone = $phone;
        $this->hashed_password = $hashed_password;
        $this->role = $role;
    }

    /**
     * Get the unique user ID.
     *
     * @return int|null The ID or null if not set.
     */
    public function get_id(): ?int {
        return $this->id;
    }

    /**
     * Set the unique user ID.
     *
     * @param int $id The database ID.
     * @return void
     */
    public function set_id(int $id) {
        $this->id = $id;
    }

    /**
     * Get the user's email.
     *
     * @return string
     */
    public function get_email(): string {
        return $this->email;
    }

    /**
     * Set the user's email.
     *
     * @param string $email
     * @return void
     */
    public function set_email(string $email) {
        $this->email = $email;
    }

    /**
     * Get the user's first name.
     *
     * @return string
     */
    public function get_name(): string {
        return $this->name;
    }

    /**
     * Set the user's first name.
     *
     * @param string $name
     * @return void
     */
    public function set_name(string $name) {
        $this->name = $name;
    }

    /**
     * Get the user's surname.
     *
     * @return string
     */
    public function get_surname(): string {
        return $this->surname;
    }

    /**
     * Set the user's surname.
     *
     * @param string $surname
     * @return void
     */
    public function set_surname(string $surname) {
        $this->surname = $surname;
    }

    /**
     * Get the user's phone number.
     *
     * @return string
     */
    public function get_phone(): string {
        return $this->phone;
    }

    /**
     * Set the user's phone number.
     *
     * @param string $phone
     * @return void
     */
    public function set_phone(string $phone) {
        $this->phone = $phone;
    }

    /**
     * Get the hashed password.
     *
     * @return string
     */
    public function get_hashed_password(): string {
        return $this->hashed_password;
    }

    /**
     * Set the hashed password.
     *
     * @param string $hashed_password The encrypted password string.
     * @return void
     */
    public function set_hashed_password(string $hashed_password) {
        $this->hashed_password = $hashed_password;
    }

    /**
     * Get the user's role.
     *
     * @return string
     */
    public function get_role(): string {
        return $this->role;
    }

    /**
     * Set the user's role.
     *
     * @param string $role
     * @return void
     */
    public function set_role(string $role): void {
        $this->role = $role;
    }

    /**
     * Get the avatar file path.
     *
     * @return string|null Path to the file, or null if not set.
     */
    public function get_avatar_path(): ?string {
        return $this->avatar_path;
    }

    /**
     * Set the avatar file path.
     *
     * @param string|null $avatar_path
     * @return void
     */
    public function set_avatar_path(?string $avatar_path) {
        $this->avatar_path = $avatar_path;
    }

    /**
     * Get the comment note.
     *
     * @return string|null
     */
    public function get_comment(): ?string {
        return $this->comment;
    }

    /**
     * Set the comment note.
     *
     * @param string|null $comment
     * @return void
     */
    public function set_comment(?string $comment) {
        $this->comment = $comment;
    }

    /**
     * Converts the user object to an associative array.
     * Useful for JSON serialization or logging.
     *
     * @return array<string, mixed> The user data as a key-value pair array.
     */
    public function toAssociativeArray(): array {
        return array(
            "id" => $this->get_id(),
            "email" => $this->get_email(), 
            "name" => $this->get_name(),
            "surname" => $this->get_surname(),
            "phone" => $this->get_phone(),
            "password" => $this->get_hashed_password(),
            "role" => $this->get_role(),
            "avatar_path" => $this->get_avatar_path(),
            "comment" => $this->get_comment(),
        );
    }
}
?>