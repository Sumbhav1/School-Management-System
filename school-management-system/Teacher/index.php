<?php 
session_start();
if (isset($_SESSION['teacher_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'teacher') {
       include "../DB_connection.php";
       include "../admin/data/getTeacher.php";
       include "../admin/data/getSubject.php";
       include "../admin/data/getClasses.php";
       include "../admin/data/getYear.php";
       include "../admin/data/getNotice.php";

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



       $teacher_id = $_SESSION['teacher_id'];
       $teacher = getTeacherById($teacher_id, $conn);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Teacher - Home</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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

        if ($teacher != 0) {
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
         <div class="card" style="width: 22rem;">
          <div class="card-body">
            <h5 class="card-title text-center"><?=$teacher['email']?></h5>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">First name: <?=$teacher['fname']?></li>
            <li class="list-group-item">Last name: <?=$teacher['lname']?></li>

            <li class="list-group-item">Date of birth: <?=$teacher['date_of_birth']?></li>
            <li class="list-group-item">Phone number: <?=$teacher['phone_number']?></li>
            <li class="list-group-item">Qualification: <?=$teacher['qualification']?></li>
            <li class="list-group-item">Email address: <?=$teacher['email']?></li>
            <li class="list-group-item">Date of joining: <?=$teacher['joining_date']?></li>

            <li class="list-group-item">Subject: 
                <?php 
                   $s = '';
                   $subjects = str_split(trim($teacher['subjects']));
                   foreach ($subjects as $subject) {
                      $s_temp = getSubjectById($subject, $conn);
                      if ($s_temp != 0) 
                        $s .=$s_temp['subject_code'].', ';
                   }
                   echo $s;
                ?>
            </li>
            <li class="list-group-item">Class: 
                  <?php 
                     $classes = $teacher['classes'];
                     echo $classes;

                  ?>
            </li>
            
          </ul>
        </div>
     </div>
     <?php 
        }else {
          header("Location: logout.php?error=An error occurred");
          exit;
        }
     ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
   <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(1) a").addClass('active');
        });
    </script>
</body>
</html>
<?php 

  }else {
    header("Location: ../login.php");
    exit;
  } 
}else {
	header("Location: ../login.php");
	exit;
} 

?>