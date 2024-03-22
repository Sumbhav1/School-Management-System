<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'admin') {
      
       include "../DB_connection.php";
       include "data/getSubject.php";
       include "data/getClasses.php";
       include "data/getYear.php";
       $subjects = getAllSubjects($conn);
       $classes = getAllClasses($conn);

       $fname = '';
       $lname = '';
       $email = '';
       $qualification = '';
       $phone_number = '';


       if (isset($_GET['fname'])) $fname = $_GET['fname'];
       if (isset($_GET['lname'])) $lname = $_GET['lname'];
       if (isset($_GET['email'])) $email = $_GET['email'];
       if (isset($_GET['qualification'])) $qualification = $_GET['qualification'];
       if (isset($_GET['phone_number'])) $phone_number = $_GET['phone_number'];
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Add Teacher</title>
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
        <a href="teacher.php"
           class="btn btn-dark">return</a>

        <form method="post"
              class="shadow p-3 mt-5 form-w" 
              action="req/add-teacher.php">
        <h3>Add New Teacher</h3><hr>
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
          <label class="form-label">First name</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$fname?>" 
                 name="fname">
        </div>
        <div class="mb-3">
          <label class="form-label">Last name</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$lname?>"
                 name="lname">
        </div>
        <div class="mb-3">
          <label class="form-label">email</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$email?>"
                 name="email">
        </div>
        <div class="mb-3">
          <label class="form-label">Date of Birth</label>
          <input type="date" 
                 class="form-control"
                 value="<?=$date_of_birth?>"
                 name="date_of_birth">
        </div>
        <div class="mb-3">
          <label class="form-label">Phone Number</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$phone_number?>"
                 name="phone_number">
        </div>
        <div class="mb-3">
          <label class="form-label">Qualification</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$qualification?>"
                 name="qualification">
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <div class="input-group mb-3">
              <input type="password" 
                     class="form-control"
                     name="pass"
                     id="passInput">
          </div>
          
        </div>
        <div class="mb-3">
          <label class="form-label">Subject </label>
          <div class="row row-cols-5">
            <?php foreach ($subjects as $subject): ?>
            <div class="col">
              <input type="checkbox"
                     name="subjects[]"
                     value="<?=$subject['subject_id']?>">
                     <?=$subject['subject']?>
            </div>
            <?php endforeach ?>
             
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">classes (should match up with subjects)</label>
          <div class="row row-cols-5">
            <?php foreach ($classes as $class): ?>
            <div class="col">
              <input type="checkbox"
                     name="classes[]"
                     value="<?=$class['class']?>">
                     <?=$class['class']?>
            </div>
            <?php endforeach ?> 
          </div>
        </div>

      <button type="submit" class="btn btn-primary">Add</button>
     </form>
     </div>
     
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
    header("Location: ../login.php");
    exit;
  } 
}else {
	header("Location: ../login.php");
	exit;
} 

?>