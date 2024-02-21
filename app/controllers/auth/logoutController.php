<?php

use Models\Auth;
use BacByTouch\Redirect;

Auth::logout();
Redirect::redirectToHome();
