<?php

require "../config/config.php";

use BacByTouch\Database;
use BacByTouch\Debug;
use BacByTouch\Session;
use BacByTouch\JsonLoader;
use Models\Event;

Session::sessionStart();

// loading events json for evo-calendar
$eventData = new JsonLoader();
$fileName = 'events.json';
$eventJsonArr = $eventData->loadJsonFile($fileName);

// loading events for view
$db = new Database($databaseConfig);

$events = new Event($db->getConnection());
$rows = $events->getAllEvents();

$currentDateTime = new DateTime();

usort($rows, function ($a, $b) use ($currentDateTime) {
    $dateA = new DateTime($a->event_date);
    $dateB = new DateTime($b->event_date);

    $diffA = $dateA->diff($currentDateTime);
    $diffB = $dateB->diff($currentDateTime);

    return $diffA->days - $diffB->days;
});

foreach ($rows as $row) {
    $row->event_date = (new DateTime($row->event_date))->format('d.m.Y.');
}

$title = "Calendar of events";

require "../app/views/calendarView.php";
require "../app/views/partials/footer.php";
