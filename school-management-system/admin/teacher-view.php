<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'admin') {
       include "../DB_connection.php";
       include "data/getTeacher.php";
       include "data/getSubject.php";
       include "data/getClasses.php";
       include "data/getYear.php";

       if(isset($_GET['teacher_id'])){

       $teacher_id = $_GET['teacher_id'];

       $teacher = getTeacherById($teacher_id,$conn);    
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Teachers</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php 
        include "inc/navbar.php";
        if ($teacher != 0) {
     ?>
     <div class="container mt-5">
         <div class="card" style="width: 22rem;">
          <div class="card-body">
            <h5 class="card-title text-center"><?=$teacher['email']?></h5>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">First name: <?=$teacher['fname']?></li>
            <li class="list-group-item">Last name: <?=$teacher['lname']?></li>
            <li class="list-group-item">Email: <?=$teacher['email']?></li>
            <li class="list-group-item">Date of birth: <?=$teacher['date_of_birth']?></li>
            <li class="list-group-item">Phone number: <?=$teacher['phone_number']?></li>
            <li class="list-group-item">Qualification: <?=$teacher['qualification']?></li>
            <li class="list-group-item">Joining date: <?=$teacher['joining_date']?></li>

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
            <li class="list-group-item">Years: 
                 <?php 
                   $years = $teacher['year'];
                   echo $years;
                  ?>
            </li>
            
          </ul>
          <div class="card-body">
            <a href="teacher.php" class="card-link">Go Back</a>
          </div>
        </div>
     </div>
     <?php 
        }else {
          header("Location: teacher.php");
          exit;
        }
     ?>
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
    <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(2) a").addClass('active');
        });
    </script>

</body>
</html>
<?php 

    }else {
        header("Location: teacher.php");
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