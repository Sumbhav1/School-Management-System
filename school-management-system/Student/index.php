<?php 
session_start();
if (isset($_SESSION['student_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'student') {
       include "../DB_connection.php";
       include "../admin/data/getStudent.php";
       include "../admin/data/getSubject.php";
       include "../admin/data/getClasses.php";
       include "../admin/data/getYear.php";
       $student_id = $_SESSION['student_id'];

       $student = getStudentById($student_id, $conn); //get current student based on session id
       $classes = explode(',', $student['classes']);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Student - Home</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php 
        include "inc/navbar.php";
     ?>
     <?php 
        if ($student != 0) {
     ?>
     <div class="container mt-5">
         <div class="card" style="width: 22rem;">
          <div class="card-body">
            <h5 class="card-title text-center"><?=$student['email']?></h5>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">First name: <?=$student['fname']?></li>
            <li class="list-group-item">Last name: <?=$student['lname']?></li>
            <li class="list-group-item">email: <?=$student['email']?></li>
            <li class="list-group-item">Date of birth: <?=$student['date_of_birth']?></li>
            <li class="list-group-item">Date of joining: <?=$student['joining_date']?></li>

            <li class="list-group-item">Class: 
                 <?php 
                      $class = $student['classes'];
                      echo $class;
                  ?>
            </li>
            <li class="list-group-item">year: 
                 <?php 
                    $year = $student['year'];
                    echo $year;
                  ?>
            </li>
            <br><br>
          </ul>
        </div>
     </div>
     <?php 
        }else {
          header("Location: ../login.php");
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