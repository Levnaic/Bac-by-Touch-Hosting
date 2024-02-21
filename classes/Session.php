<?php

namespace BacByTouch;

class Session
{
    public static function sessionStart()
    {
        ini_set("session.use_only_cookies", 1);
        ini_set("session.use_strict_mode", 1);

        session_set_cookie_params(
            //!PRODUKCIJA zameniti u 1800
            180000,           // lifetime
            "/",            // path
            "",             // domain
            true,           // secure
            true            // httponly
        );

        session_start();

        if (!isset($_SESSION["last_regeneration"])) {
            session_regenerate_id(true);
            $_SESSION["last_regeneration"] = time();
        } else {
            //!PRODUKCIJA promeniti 3000 u 30
            $interval = 30 * 3000;

            if (time() - $_SESSION["last_regeneration"] >= $interval) {
                session_regenerate_id(true);
                $_SESSION["last_regeneration"] = time();
            }
        }
    }
}
