<?php

function getAllStudents($conn){
  $sql = "SELECT * FROM students";
  $stmt = $conn->prepare($sql);
  $stmt->execute();

  if ($stmt->rowCount() >= 1) {
    $teachers = $stmt->fetchAll();
    return $teachers;
  } else {
    return 0;
  }
}
function mergeSort(&$arr) {
  if (count($arr) <= 1) {
      return;
  }

  $middle = count($arr) / 2;
  $left = array_slice($arr, 0, $middle);
  $right = array_slice($arr, $middle);

  mergeSort($left);
  mergeSort($right);

  merge($left, $right, $arr);
}

function merge(&$left, &$right, &$arr) {
  $leftIndex = 0;
  $rightIndex = 0;
  $mergedIndex = 0;

  while ($leftIndex < count($left) && $rightIndex < count($right)) {
      if (strcmp($left[$leftIndex], $right[$rightIndex]) < 0) {
          $arr[$mergedIndex++] = $left[$leftIndex++];
      } else {
          $arr[$mergedIndex++] = $right[$rightIndex++];
      }
  }

  while ($leftIndex < count($left)) {
      $arr[$mergedIndex++] = $left[$leftIndex++];
  }

  while ($rightIndex < count($right)) {
      $arr[$mergedIndex++] = $right[$rightIndex++];
  }
}


function removeStudent($id, $conn)
{
  $sql = "DELETE FROM students
          WHERE student_id=?";
  try {
    $stmt = $conn->prepare($sql);
    $re = $stmt->execute([$id]);
    if ($re) {
      return true;
    } else {
      return false;
    }
  } catch (PDOException $e) {
    // Log or handle the exception
    echo "Error: " . $e->getMessage();  // Display error for debugging
    return false;
  }
}


function getStudentById($student_id, $conn){
  $sql = "SELECT * FROM students
          WHERE student_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$student_id]);

  if ($stmt->rowCount() == 1) {
    $student = $stmt->fetch();
    return $student;
  }else {
   return 0;
  }
}

function searchStudents($key, $conn){
  $key = "%$key%";  // Add % wildcard for partial matches
  $sql = "SELECT * FROM students
          WHERE LOWER(fname) LIKE LOWER(?)
          OR LOWER(lname) LIKE LOWER(?)
          OR LOWER(email) LIKE LOWER(?)
          OR date_of_birth like ?
          OR year LIKE ?";

  $stmt = $conn->prepare($sql);
  $stmt->execute([$key, $key, $key, $key,$key]);

  if ($stmt->rowCount() == 1) {
    $teachers = $stmt->fetchAll();
    return $teachers;
  }else {
   return 0;
  }
}

function StudentEmailIsUnique($email, $conn)
{
  $sql = "SELECT email FROM students";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $emailList = $stmt->fetchAll(PDO::FETCH_COLUMN);

  mergeSort($emailList); // Sort the list of emails

  $result = StudentEmailBinarySearch($email, $emailList);

  return $result == -1; // If email not found, return true; otherwise, return false
}

function StudentEmailBinarySearch($targetEmail, $emails)
{

  $low = 0;
  $high = count($emails) - 1;

  while ($low <= $high) {
    $mid = floor(($low + $high) / 2);
    $currentEmail = $emails[$mid];

    $comparisonResult = strcmp($currentEmail, $targetEmail);

    if ($comparisonResult === 0) {
      return $mid;  // Target email found, return the index
    } elseif ($comparisonResult < 0) {
      $low = $mid + 1;
    } else {
      $high = $mid - 1;
    }
  }

  return -1;  // Target email not found, return -1
}

function MatchStudentInClass($studentClasses, $class, $index = 0){
  // Base case: if index reaches the end of the array, return false
  if ($index >= count($studentClasses)) {
      return false;
  }

  // Check if the current class matches the target class
  if ($studentClasses[$index] == $class) {
      return true;
  }

  // Recursive case: move to the next index
  return MatchStudentInClass($studentClasses, $class, $index + 1);
}





