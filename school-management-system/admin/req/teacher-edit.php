<?php
session_start();
if (
  isset($_SESSION['admin_id']) &&
  isset($_SESSION['role']) &&
  isset($_POST['fname']) &&
  isset($_POST['lname']) &&
  isset($_POST['email']) &&
  isset($_POST['teacher_id']) &&
  isset($_POST['date_of_birth']) &&
  isset($_POST['qualification']) &&
  isset($_POST['phone_number']) &&
  isset($_POST['subjects']) &&
  isset($_POST['classes'])
) {

  if ($_SESSION['role'] == 'admin') {

    include '../../DB_connection.php';
    include "../data/getTeacher.php";

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $teacher_id = $_POST['teacher_id'];
    $date_of_birth = $_POST['date_of_birth'];
    $qualification = $_POST['qualification'];
    $phone_number = $_POST['phone_number'];

    $classes = implode(',', $_POST['classes']);
    $subjects = implode(',', $_POST['subjects']);

    $data = 'teacher_id=' . $teacher_id;

    if (empty($fname)) {
      $em  = "First name is required";
      header("Location: ../teacher-edit.php?error=$em&$data");
      exit;
    } else if (empty($lname)) {
      $em  = "Last name is required";
      header("Location: ../teacher-edit.php?error=$em&$data");
      exit;
    } else if (empty($email)) {
      $em  = "Email is required";
      header("Location: ../teacher-edit.php?error=$em&$data");
      exit;
    } else {
      $sql = "UPDATE teachers SET email=?, fname=?, lname=?, date_of_birth=?, qualification=?, phone_number=?, subjects=?, classes=? WHERE teacher_id=?";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$email, $fname, $lname, $date_of_birth, $qualification, $phone_number, $subjects, $classes, $teacher_id]);
      $sm = "Successfully updated!";
      header("Location: ../teacher-edit.php?success=$sm&$data");
      exit;
    }
  } else {
    $em = "An error occurred";
    header("Location: ../teacher-edit.php?error=$em");
    exit;
  }
} else {
  header("Location: ../../logout.php");
  exit;
}

