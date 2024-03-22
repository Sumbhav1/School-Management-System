<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'admin') {
      
        if (
            isset($_POST['fname']) &&
            isset($_POST['lname']) &&
            isset($_POST['email']) &&
            isset($_POST['student_id']) &&
            isset($_POST['classes'])
        ) {
            include '../../DB_connection.php';
            include "../data/getStudent.php";

            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $student_id = $_POST['student_id'];
            
            $classes = implode(',', $_POST['classes']); // Concatenating classes separated by commas
            
            $data = 'student_id=' . $student_id;

            if (empty($fname)) {
                $em  = "First name is required";
                header("Location: ../student-edit.php?error=$em&$data");
                exit;
            } elseif (empty($lname)) {
                $em  = "Last name is required";
                header("Location: ../student-edit.php?error=$em&$data");
                exit;
            } elseif (empty($email)) {
                $em  = "Email is required";
                header("Location: ../student-edit.php?error=$em&$data");
                exit;
            } else {
                try { // try and except to avoid program termination on database error
                    $sql = "UPDATE students SET email=?, fname=?, lname=?, classes=? WHERE student_id=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$email, $fname, $lname, $classes, $student_id]);
                    $sm = "Successfully updated!";
                    header("Location: ../student-edit.php?success=$sm&$data");
                    exit;
                } catch (PDOException $e) {
                    $em = "An error occurred while updating: " . $e->getMessage();
                    header("Location: ../student-edit.php?error=$em&$data");
                    exit;
                }
            }
        } else {
            $em = "Incomplete form data";
            header("Location: ../student-edit.php?error=$em");
            exit; //handling error messages for all errors
        }

    } else {
        header("Location: ../../logout.php");
        exit;
    } 
} else {
    header("Location: ../../logout.php");
    exit;
} 

