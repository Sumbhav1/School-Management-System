<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        if (isset($_POST['fname']) &&
            isset($_POST['lname']) &&
            isset($_POST['email']) &&
            isset($_POST['pass']) &&
            isset($_POST['subjects']) &&
            isset($_POST['classes']) &&
            isset($_POST['qualification']) &&
            isset($_POST['phone_number']) &&
            isset($_POST['date_of_birth'])) {
            
            include '../../DB_connection.php';
            include "../data/getTeacher.php";

            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $pass = $_POST['pass'];
            $phone_number = $_POST['phone_number'];
            $qualification = $_POST['qualification'];
            $date_of_birth = $_POST['date_of_birth'];

            $classes = implode(',', $_POST['classes']);
            $subjects = implode(',', $_POST['subjects']);

            if (empty($fname) || empty($lname) || empty($email) || empty($pass)) {
                $em = "All fields are required";
                redirectWithError($em, $email, $fname, $lname);
            } elseif (!emailIsUnique($email, $conn)) {
                $em = "Email already in use";
                redirectWithError($em, $email, $fname, $lname);
            } else {
                // Hash the password
                $salt = generate_salt(16);
                $hashedPass = custom_hash($pass, $salt);

                // Insert the teacher into the database
                $sql = "INSERT INTO teachers (email, password, salt, fname, lname, subjects, classes, phone_number, qualification, date_of_birth)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$email, $hashedPass, $salt, $fname, $lname, $subjects, $classes, $phone_number, $qualification, $date_of_birth]);

                redirectWithSuccess("New teacher registered successfully");
            }
        } else {
            redirectWithError("An error occurred");
        }
    } else {
        header("Location: ../../logout.php");
        exit;
    } 
} else {
    header("Location: ../../logout.php");
    exit;
} 

function redirectWithError($errorMessage, $email = "", $fname = "", $lname = "") {
    $data = "email=$email&fname=$fname&lname=$lname";
    header("Location: ../add-teacher.php?error=$errorMessage&$data");
    exit;
}

function redirectWithSuccess($successMessage) {
    header("Location: ../add-teacher.php?success=$successMessage");
    exit;
}

function generate_salt($length) {
    return bin2hex(random_bytes($length));
}

function bitwise_hash($string) {
    $hash = 0;
    for ($i = 0; $i < strlen($string); $i++) {
        $hash ^= ord($string[$i]);
    }
    return dechex($hash);
}

function custom_hash($password, $salt) {
    return bitwise_hash($password . $salt);
}


