<?php 
session_start();
if (isset($_SESSION['student_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'student') {

    include "../DB_connection.php";
    include "../admin/data/getNotice.php"; // Include the script to get notices from the database

   
   $notices = getNotices($conn); // Fetch notices from the database
   
   // Filter out notices that are more than 30 days away
   $filtered_notices = array_filter($notices, function($notice) {
       $event_date = strtotime($notice['date']);
       $current_date = strtotime(date('Y-m-d'));
       $days_difference = ceil(abs($event_date - $current_date) / 86400); // Calculate difference in days
       return $days_difference <= 60; // Return true for notices within 30 days
   });

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notices</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .notice-container {
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
    <?php include "inc/navbar.php"; ?>
    <div class="container mt-5">
        <h2 class="text-center">School Notices</h2>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="notice-container">
                    <h4>Upcoming Events</h4>
                    <div class="notice-list">
                        <?php foreach ($filtered_notices as $notice): ?>
                        <div class="notice-item">
                            <h5><?= $notice['event'] ?></h5>
                            <p>Date: <?= $notice['date'] ?></p>
                            <p><?= $notice['description'] ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#navLinks li:nth-child(3) a").addClass('active');
        });
    </script>
</body>
</html>

<?php 
} else {
    header("Location: ../login.php");
    exit;
} 
?>
