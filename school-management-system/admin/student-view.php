<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'admin') {
       include "../DB_connection.php";
       include "data/getStudent.php";
       include "data/getClasses.php";
       include "data/getYear.php";

       if(isset($_GET['student_id'])){

       $student_id = $_GET['student_id'];

       $student = getStudentById($student_id,$conn);    
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Students</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php 
        include "inc/navbar.php";
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
            <li class="list-group-item">Email: <?=$student['email']?></li>
            <li class="list-group-item">Date of birth: <?=$student['date_of_birth']?></li>
            <li class="list-group-item">Joining date: <?=$student['joining_date']?></li>
            
            <li class="list-group-item">Classes: 
                 <?php 
                   $classes = $student['classes'];
                   echo $classes;
                  ?>
            </li>
            <li class="list-group-item">Year: 
                 <?php ;
                   echo $student['year'];
                  ?>
            </li>
            
          </ul>
          <div class="card-body">
            <a href="student.php" class="card-link">Go Back</a>
          </div>
        </div>
     </div>
     <?php 
        }else {
          header("Location: student.php");
          exit;
        }
     ?>
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
    <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(3) a").addClass('active');
        });
    </script>

</body>
</html>
<?php 

    }else {
        header("Location: student.php");
        exit;
    }

  }else {
    header("Location: ../login.php");
    exit;
  } 
}else {
	header("Location: ../login.php");
	exit;
} 

?>