<?php 
session_start();
if (isset($_SESSION['teacher_id']) && 
    isset($_SESSION['role'])     &&
    isset($_GET['class'])) {

    if ($_SESSION['role'] == 'teacher') {
      
       include "../DB_connection.php";
       include "../admin/data/getClasses.php";

       
       $class = $_GET['class'];
       $class = getClassByClass($class, $conn);

       if ($class == 0) {
         header("Location: classes.php");
         exit;
       }


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Edit assignment</title>
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
     <div class="container mt-5">
        <a href="classes.php"
           class="btn btn-dark">Go Back</a>

        <form method="post"
              class="shadow p-3 mt-5 form-w" 
              action="req/assignment-edit.php">
        <h3>Edit Assignment</h3><hr>
        <?php if (isset($_GET['error'])) { ?>
          <div class="alert alert-danger" role="alert">
           <?=$_GET['error']?>
          </div>
        <?php } ?>
        <?php if (isset($_GET['success'])) { ?>
          <div class="alert alert-success" role="alert">
           <?=$_GET['success']?>
          </div>
        <?php } ?>
        <div class="mb-3">
          <label class="form-label">Assignment</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$class['current_assignment']?>"
                 name="current_assignment">
        </div>
        <input type="text" 
                 class="form-control"
                 value="<?=$class['class_id']?>"
                 name="class_id"
                 hidden>

      <button type="submit" 
              class="btn btn-primary">
              Update</button>
     </form>
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
    <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(5) a").addClass('active');
        });
    </script>

</body>
</html>
<?php 

  }else {
    header("Location: classes.php");
    exit;
  } 
}else {
	header("Location: classes.php");
	exit;
} 

?>