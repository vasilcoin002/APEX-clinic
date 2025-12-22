<?php

/**
 * Data Transfer Object (DTO) for User information.
 *
 * This class serves as a simple container to transport user-related data
 * between different layers of the application (e.g., Controller to Service)
 * without containing business logic.
 *
 * @package App\DTOs
 * @version 1.0.0
 */
class UserDTO {

    /**
     * The unique identifier of the user.
     * Null if the user is new and hasn't been saved to the database yet.
     *
     * @var int|null
     */
    public ?int $id;

    /**
     * The user's email address.
     *
     * @var string
     */
    public string $email;

    /**
     * The user's password.
     * This may be a plain-text password (from a registration form)
     * or a hashed string depending on the context.
     *
     * @var string
     */
    public string $password;

    /**
     * The user's first name.
     *
     * @var string
     */
    public string $name;

    /**
     * The user's last name (surname).
     *
     * @var string
     */
    public string $surname;

    /**
     * The user's phone number.
     *
     * @var string
     */
    public string $phone;

    /**
     * The user's assigned role (e.g., 'admin', 'user').
     *
     * @var string
     */
    public string $role;

    /**
     * The file path or URL to the user's avatar image.
     *
     * @var string
     */
    public string $avatar_path;

    /**
     * Any additional notes or comments regarding the user.
     *
     * @var string
     */
    public string $comment;

    /**
     * Converts the DTO properties to an associative array.
     *
     * @return array<string, mixed> The user data structure.
     */
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