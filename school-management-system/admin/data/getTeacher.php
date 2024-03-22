<?php

function getTeacherById($teacher_id, $conn){
  $sql = "SELECT * FROM teachers
          WHERE teacher_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$teacher_id]);

  if ($stmt->rowCount() == 1) {
    $teacher = $stmt->fetch();
    return $teacher;
  }else {
   return 0;
  }
}


function getAllTeachers($conn)
{
  $sql = "SELECT * FROM teachers";
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

function emailIsUnique($email, $conn)
{
  $sql = "SELECT email FROM teachers";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $emailList = $stmt->fetchAll(PDO::FETCH_COLUMN);

  mergeSort($emailList); // Sort the list of emails

  $result = emailBinarySearch($email, $emailList);

  return $result == -1; // If email not found, return true; otherwise, return false
}



function emailBinarySearch($targetEmail, $emails)
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



// DELETE
function removeTeacher($id, $conn)
{
  $sql = "DELETE FROM teachers
          WHERE teacher_id=?";
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

function searchTeachers($key, $conn){
  $key = strtolower($key);
  $sql = "SELECT * FROM teachers
          WHERE LOWER(fname) REGEXP CONCAT('^', ?)
          OR LOWER(lname) REGEXP CONCAT('^', ?)
          OR LOWER(email) REGEXP CONCAT('^', ?)
          OR LOWER(phone_number) REGEXP CONCAT('^', ?)
          OR LOWER(qualification) REGEXP CONCAT('^', ?)";

  $stmt = $conn->prepare($sql);
  $stmt->execute([$key, $key, $key, $key, $key]);

  if ($stmt->rowCount() > 0) {
    $teachers = $stmt->fetchAll();
    return $teachers;
  } else {
    return 0; // Return an empty array if no matches found
  }
}
