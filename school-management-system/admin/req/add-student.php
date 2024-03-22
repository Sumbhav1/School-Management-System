<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'admin') {
    	

if (isset($_POST['fname']) &&
    isset($_POST['lname']) &&
    isset($_POST['email']) &&
    isset($_POST['pass']) &&
    isset($_POST['classes'])&&
    isset($_POST['date_of_birth'])&&
    isset($_POST['years'])) {
    
    include '../../DB_connection.php';
    include "../data/getStudent.php";

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $years = implode(',', $_POST['years']);
    $date_of_birth = $_POST['date_of_birth'];
    $classes = implode(',', $_POST['classes']);
    
    
    $data = 'email='.$email.'&fname='.$fname.'&lname='.$lname;

    if (empty($fname)) {
		$em  = "First name is required";
		header("Location: ../add-student.php?error=$em&$data");
		exit;
	}else if (empty($lname)) {
		$em  = "Last name is required";
		header("Location: ../add-student.php?error=$em&$data");
		exit;
	}else if (empty($email)) {
		$em  = "email is required";
		header("Location: ../add-student.php?error=$em&$data");
		exit;
	}else if (!StudentEmailIsUnique($email, $conn)) {
		$em  = "email already in use";
		header("Location: ../add-student.php?error=$em&$data");
		exit;
	}else if (empty($pass)) {
		$em  = "Password is required";
		header("Location: ../add-student.php?error=$em&$data");
		exit;
	}else {
        // hashing the password
        function generate_salt($length) {
            return bin2hex(random_bytes($length));
        }
        function bitwise_hash($string) {
            $hash = 0;
            for ($i = 0; $i < strlen($string); $i++) {
                $hash ^= ord($string[$i]);
            }
            return dechex($hash);
        };
        function custom_hash($password, $salt) {
            return bitwise_hash($password . $salt);
        };

        $salt = generate_salt(16);
        $hashedPass = custom_hash($pass, $salt);


        $sql  = "INSERT INTO
                 students(email, password, salt, fname, lname, classes, year, date_of_birth)
                 VALUES(?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email, $hashedPass, $salt, $fname, $lname, $classes, $years, $date_of_birth]);
        $sm = "New student registered successfully";
        header("Location: ../add-student.php?success=$sm");
        exit;
	}
    
  }else {
  	$em = "An error occurred";
    header("Location: ../add-student.php?error=$em");
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