<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'admin') {
    	

if (isset($_POST['class'])) {
    
    include '../../DB_connection.php';

    $class = $_POST['class'];
    $year = $_POST['year'];
    
    $data = 'class='.$class;

  if (empty($class)) {
		$em  = "class is required";
		header("Location: ../class-add.php?error=$em&$data");
		exit;
	}else if ($year > 13 or $year < 1){
        $em = "year is not valid";
        header("Location: ../class-add.php?error=$em&$data");
    } else {
        $sql  = "INSERT INTO
                 classes(class, year)
                 VALUES(?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$class, $year]);
        $sm = "New class created successfully";
        header("Location: ../class-add.php?success=$sm");
        exit;
	}
    
  }else {
  	$em = "An error occurred";
    header("Location: ../class-add.php?error=$em");
    exit;
  }

  }else {
    header("Location: ../../logout.php");
    exit;
  } 
}else {
	header("Location: ../../logout.php");
	exit;
} 