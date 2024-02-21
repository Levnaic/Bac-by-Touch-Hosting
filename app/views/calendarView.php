<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $title; ?></title>
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon/favicon.png" />
    <link rel="stylesheet" href="/assets/styles/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/styles/css/evo-calendar.css">
    <link rel="stylesheet" href="/assets/styles/css/evo-calendar.orange-coral.css">
    <link rel="stylesheet" href="/assets/styles/css/calendarPage.css" />
</head>

<body>

    <?php
    // require "../app/views/partials/head.php";
    require "../app/views/partials/nav.php";
    ?>
    <h1>Kalendar dogadjaja</h1>

    <!-- //*COUNTER -->
    <section id="showTime" class="margins">
        <p class="showTimeHeadline">Vreme do sledećeg događaja:</p>
        <div class="showTimeBigContainer">

            <div class="showTimeContainer">
                <p>Dana</p>
                <div class="showTimeBoxContainer">
                    <div class="showTimeBox">
                        <p class="days1"></p>
                    </div>
                    <div class="showTimeBox">
                        <p class="days10"></p>
                    </div>
                    <div class="showTimeBox">
                        <p class="days100"></p>
                    </div>
                </div>
            </div>

            <div class="showTimeContainer">
                <p>Sati</p>
                <div class="showTimeBoxContainer">
                    <div class="showTimeBox">
                        <p class="hours1"></p>
                    </div>
                    <div class="showTimeBox">
                        <p class="hours10"></p>
                    </div>
                </div>
            </div>

            <div class="showTimeContainer">
                <p>Minuta</p>
                <div class="showTimeBoxContainer">
                    <div class="showTimeBox">
                        <p class="minutes1"></p>
                    </div>
                    <div class="showTimeBox">
                        <p class="minutes10"></p>
                    </div>
                </div>
            </div>

            <div class="showTimeContainer">
                <p>Sekundi</p>
                <div class="showTimeBoxContainer">
                    <div class="showTimeBox">
                        <p class="seconds1"></p>
                    </div>
                    <div class="showTimeBox">
                        <p class="seconds10"></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- //*CALENDAR -->
    <section class="calendarSec margins">
        <div id="calendar"></div>
    </section>

    <!-- //*EVENTS -->
    <section id="events" class="margins">
        <h2>Događaji koji Vas očekuju</h2>
        <?php
        foreach ($rows as $row) :
        ?>
            <a href="/event?id=<?php echo $row->id; ?>">
                <div id="<?php echo $row->id; ?>" class="eventContainer">
                    <div class="upperPart">
                        <div class="dateContainer">
                            <p class="date" data-date="<?php echo $row->event_date; ?>"><?php echo $row->event_date; ?></p>
                        </div>
                        <img src="assets/img/events-img/<?php echo $row->img; ?>" alt="<?php echo $row->img_alt ?>">
                    </div>
                    <div class="lowerPart">
                        <h3><?php echo $row->event_name; ?></h3>
                        <p><?php echo $row->event_text; ?></p>
                    </div>
                </div>
            </a>
        <?php endforeach ?>
    </section>

    <!-- //* SCRIPTS -->
    <script src="assets/scripts/header_footer.js"></script>
    <!-- jquery import -->
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="assets/scripts/evo-calendar.js"></script>
    <script type="module">
        //variables
        const eventJsonObj = <?php echo json_encode($eventJsonArr); ?>

        // const eventsArr = Object.values(eventJsonObj);
        const eventsArr = Array.from(eventJsonObj);
        const timeTillEvent = [];

        // preparing data
        eventsArr.forEach(event => {
            timeTillEvent.push(new Date(event.date));

        });

        timeTillEvent.sort((a, b) => a - b);

        //calculating days, hours, mins, secs till next event
        function calculateTime() {
            let date = new Date();
            let closestEvent = timeTillEvent.find(eventDate => eventDate > date);

            if (!closestEvent) {
                closestEvent = timeTillEvent[timeTillEvent.length - 1];
            }

            const timeDifference = closestEvent - date;
            const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

            const days100 = Math.floor(days / 100);
            const days10 = Math.floor(days % 100 / 10);
            const days1 = days % 100 % 10;

            const hours10 = Math.floor(hours / 10);
            const hours1 = hours % 10;

            const minutes10 = Math.floor(minutes / 10);
            const minutes1 = minutes % 10;

            const seconds10 = Math.floor(seconds / 10);
            const seconds1 = seconds % 10;

            document.querySelector(".days1").innerText = days1;
            document.querySelector(".days10").innerText = days10;
            document.querySelector(".days100").innerText = days100;
            document.querySelector(".hours1").innerText = hours1;
            document.querySelector(".hours10").innerText = hours10;
            document.querySelector(".minutes1").innerText = minutes1;
            document.querySelector(".minutes10").innerText = minutes10;
            document.querySelector(".seconds1").innerText = seconds1;
            document.querySelector(".seconds10").innerText = seconds10;
        }

        calculateTime();
        setInterval(calculateTime, 1000);


        //evoCalendar library
        $(document).ready(function() {
            $('#calendar').evoCalendar({
                theme: 'Orange Coral',
                format: 'mm/dd/yyyy',
                eventHeaderFormat: 'dd.mm.yyyy.',
                firstDayOfWeek: 1,
                language: 'sr',
                todayHighlight: true,
                calendarEvents: eventsArr
            })

        })
    </script>
    <script src="assets/scripts/calendar.js"></script>