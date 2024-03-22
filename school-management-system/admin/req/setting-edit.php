<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'admin') {
    	

if (isset($_POST['school_name']) &&
    isset($_POST['slogan']) &&
    isset($_POST['about']) &&
    isset($_POST['current_year']) &&
    isset($_POST['id'])) {
    
    include '../../DB_connection.php';

    $school_name = $_POST['school_name'];
    $slogan = $_POST['slogan'];
    $about = $_POST['about'];
    $current_year = $_POST['current_year'];
    $current_term = $_POST['current_term'];
    $id = $_POST['id'];
   

    if (empty($school_name)) {
        $em  = "School name is required";
        header("Location: ../settings.php?error=$em");
        exit;
    }else if (empty($slogan)) {
        $em  = "Slogan name is required";
        header("Location: ../settings.php?error=$em");
        exit;
    }else if (empty($about)) {
        $em  = "About name is required";
        header("Location: ../settings.php?error=$em");
        exit;
    }else {
        $id = 1;
        $sql  = "UPDATE setting 
                 SET current_year=?,
                     current_term=?,
                     school_name=?,
                     slogan=?,
                     about=?
                 WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$current_year, $current_term, $school_name, $slogan, $about, $id]);
        $sm = "Settings updated successfully";
        header("Location: ../settings.php?success=$sm&$data");
        exit;
	}
    
  }else {
  	$em = "An error occurred";
    header("Location: ../settings.php?error=$em");
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