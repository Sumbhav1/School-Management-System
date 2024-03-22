<?php 
session_start();
if ((isset($_SESSION['admin_id']) || isset($_SESSION['teacher_id'])) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'teacher') {
      
       $event = '';
       $date = '';

       if (isset($_GET['event'])) $event = $_GET['event'];
       if (isset($_GET['date'])) $date = $_GET['date'];
       if (isset($_GET['description'])) $descrption = $_GET['description'];

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Add Class</title>
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
        <a href="notices.php"
           class="btn btn-dark">Go Back</a>

        <form method="post"
              class="shadow p-3 mt-5 form-w" 
              action="req/add-notice.php">
        <h3>Add New event </h3><hr>
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
          <label class="form-label">event</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$event?>"
                 name="event">
        </div>
        <div class="mb-3">
          <label class="form-label">description</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$description?>"
                 name="description"> 
        </div>
        <div class="mb-3">
          <label class="form-label">date</label>
          <input type="date" 
                 class="form-control"
                 value="<?=$date?>"
                 name="date">
        </div>
      <button type="submit" class="btn btn-primary">Create</button>
     </form>
     </div>
     
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
    header("Location: ../login.php");
    exit;
  } 
}else {
	header("Location: ../login.php");
	exit;
} 

?>