<?php

namespace BacByTouch;

class Authenticator
{
    public static function authenticateAdmin()
    {
        if (!isset($_SESSION['userRole']) || $_SESSION['userRole'] != 'admin') {
            header("Location: /login");
            exit;
        }
    }

    public static function authenticateUser()
    {
        if (!isset($_SESSION['userRole']) || $_SESSION['userRole'] != 'user') {
            header("Location: /login");
            exit;
        }
    }

    public static function authenticateUserOrAdmin()
    {
        if (!isset($_SESSION['userRole']) || ($_SESSION['userRole'] != 'user' && $_SESSION['userRole'] != 'admin')) {
            header("Location: /login");
            exit;
        }
    }

    public static function authenticateNotLoggedIn()
    {
        if (isset($_SESSION['username'])) {
            header("Location: /");
            exit;
        }
    }
}
