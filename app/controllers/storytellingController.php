<?php

use BacByTouch\Session;

Session::sessionStart();

$title = "Storytelling";
$css = "storytelling.css";

require "../app/views/partials/head.php";
require "../app/views/partials/nav.php";
require "../app/views/storytellingView.php";
require "../app/views/partials/footer.php";
