<?php
class Logout
{
    public function __construct()
    {
        // Start the session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function execute()
    {
        // Destroy the session
        session_unset();
        session_destroy();

        // Redirect to index.php
        header("Location: ../index.php");
        exit();
    }
}

// Instantiate and execute the logout process
$logout = new Logout();
$logout->execute();
?>