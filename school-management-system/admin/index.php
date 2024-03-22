<?php
session_start();
if (
    isset($_SESSION["admin_id"]) &&
    isset($_SESSION['role'])
) {

    if ($_SESSION['role'] == 'admin') {
        include "../DB_connection.php";
        include "data/getNotice.php";

        $upcoming_events = array(); // Array to store upcoming events
        $notices = getNotices($conn);
        // Loop through notices to filter upcoming events
        foreach ($notices as $notice) {
            $event_date = strtotime($notice['date']);
            $current_date = strtotime(date('Y-m-d'));
            $days_difference = ceil(abs($event_date - $current_date) / 86400);
            
            // Add event to upcoming_events array if it falls within the next week
            if ($days_difference <= 7) {
                $upcoming_events[] = $notice;
            }
        }
        ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>SCHOOL MANAGEMENT</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="../css/styles.css">
            <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <style>
        .upcoming-events {
            background-color: #e6f7ff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            position: relative;
        }
    </style>
        </head>

        <body>
            <?php
            include "inc/navbar.php";
            ?>
                <div class="container mt-5">
        <!-- Display upcoming events -->
        <div class="upcoming-events">
            <h3>Upcoming Events (Next 7 Days)</h3>
            <?php if (!empty($upcoming_events)): ?>
            <ul>
                <?php foreach ($upcoming_events as $event): ?>
                <li><?= $event['event'] ?> - <?= date('F j, Y', strtotime($event['date'])) ?></li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
            <p>No upcoming events in the next 7 days.</p>
            <?php endif; ?>
            </div>
        </div>

            <div class="container mt-5">
                <div class="container text-center">
                    <div class="row row-cols-5">
                        <a href="teacher.php" class="col btn btn-dark m-2 py-3">
                            <i c aria-hidden="true"></i>
                            Teachers
                        </a>
                        <a href="student.php" class="col btn btn-dark m-2 py-3">
                            <i aria-hidden="true"></i>
                            Students
                        </a>
                        <a href="class.php" class="col btn btn-dark m-2 py-3">
                            <i  aria-hidden="true"></i>
                            Class
                        </a>
                        <a href="notices.php" class="col btn btn-dark m-2 py-3">
                            <i  aria-hidden="true"></i>
                            School notices
                        </a>
                        <a href="settings.php" class="col btn btn-dark m-2 py-3 col-5">
                            <i  aria-hidden="true"></i>
                            Settings
                        </a>
                        <a href="../logout.php" class="col btn m-2 py-3 col-5 btn-warning">
                             <aria-hidden="true"></i>
                            Logout
                        </a>

                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                $(document).ready(function () {
                    $("#navLinks li:nth-child(1) a").addClass('active');
                });
            </script>


        </body>

        </html>
        <?php
    } else {
        header("Location: ../login.php");
        exit;
    }
    ;
} else {
    header("Location: ../login.php");
    exit;
}
?>