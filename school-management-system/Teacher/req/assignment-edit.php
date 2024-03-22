<?php 
session_start();
if (isset($_SESSION['teacher_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'teacher') {
    	

if (isset($_POST['current_assignment']) &&
    isset($_POST['class_id'])) {
    
    include '../../DB_connection.php';
    
    $current_assignment = $_POST['current_assignment'];
    $class_id = $_POST['class_id'];
   
    $data = '&assignment='.$current_assignment.'&class_id='.$class_id;

    if (empty($current_assignment)) {
        $em  = "assignment is required";
        header("Location: ../assignment-edit.php?error=$em&$data");
        exit;
    }else {

        $sql  = "UPDATE classes SET current_assignment=?
                 WHERE class_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$current_assignment,$class_id]);
        $sm = urlencode("assignment updated successfully");
        header("Location: ../assignment-edit.php?success=$sm");
        exit;
        
	}
    
  }else {
  	$em = "An error occurred";
    header("Location: ../classes.php?error=$em");
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