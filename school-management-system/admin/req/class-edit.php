<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'admin') {
    	

if (isset($_POST['class']) &&
    isset($_POST['class_id'])) {
    
    include '../../DB_connection.php';

    $class = $_POST['class'];
    $year = $_POST['year'];
    $class_id = $_POST['class_id'];
   
    $data = '&class='.$class.'&class_id='.$class_id;

    if (empty($class)) {
        $em  = "class is required";
        header("Location: ../class-edit.php?error=$em&$data");
        exit;
    }else {

        $sql  = "UPDATE classes SET class=?, year=?
                 WHERE class_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$class, $year, $class_id]);
        $sm = "class updated successfully";
        header("Location: ../class-edit.php?success=$sm&$data");
        exit;
	}
    
  }else {
  	$em = "An error occurred";
    header("Location: ../class.php?error=$em");
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