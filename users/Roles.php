<?php

/**
 * Defines the available user roles and authorization levels within the application.
 *
 * This class acts as a central enumeration to ensure consistency when checking
 * permissions or assigning roles to users. It prevents the use of "magic strings"
 * in the codebase.
 *
 * @package App\Constants
 * @version 1.0.0
 */
class Roles {

    /**
     * Represents a standard registered user.
     * Users with this role have basic access to the application functionalities.
     *
     * @var string
     */
    public const USER = "USER";

    /**
     * Represents an administrator.
     * Users with this role have elevated privileges (e.g., managing other users).
     *
     * @var string
     */
    public const ADMIN = "ADMIN";

    /**
     * Represents a guest or non-logged-in state.
     * Used when verifying sessions if no valid user is found.
     *
     * @var string
     */
    public const UNAUTHORIZED = "UNAUTHORIZED";

}

?>