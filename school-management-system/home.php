<?php 
session_start();
if (isset($_SESSION["id"]) && isset($_SESSION['role'])) {
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCHOOL MANAGEMENT</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
</head>
<body class="body-home">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="shadow w-450 p-3 text-center bg-light rounded" >
            <small>
                Role: 
                <b>
                    <?php 
                    if ($_SESSION['role'] == 'admin'){
                        echo 'admin';
                    }else if ($_SESSION['role'] == 'teacher'){
                        echo "teacher";
                    }else if($_SESSION['role'] == 'student'){
                        echo "student";
                    }
                    ?>
                </b><br>
                <h3><?=$_SESSION['fname']?></h3>
                <a href="logout.php" class="btn btn-warning">
                    Logout
                </a>
            </small>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html >
<?php }else{
    header("Location: login.php");
    exit;
} 
?>