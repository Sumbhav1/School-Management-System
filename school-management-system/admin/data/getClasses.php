<?php 
// All classes
function getAllClasses($conn){
   $sql = "SELECT * FROM classes";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() >= 1) {
     $classes = $stmt->fetchAll();
     return $classes;
   }else {
    return 0;
   }
}

// Get class by ID
function getClassById($class_id, $conn){
   $sql = "SELECT * FROM classes
           WHERE class_id=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$class_id]);

   if ($stmt->rowCount() == 1) {
     $class = $stmt->fetch();
     return $class;
   }else {
    return 0;
   }
}
// DELETE
function removeClass($id, $conn){
  $sql  = "DELETE FROM classes
          WHERE class_id=?";
  $stmt = $conn->prepare($sql);
  $re   = $stmt->execute([$id]);
  if ($re) {
    return 1;
  }else {
   return 0;
  }
}
function getClassByClass($class, $conn){
  try {
      $sql = "SELECT * FROM classes WHERE class=?";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$class]);

      if ($stmt->rowCount() == 1) {
          $class = $stmt->fetch();
          return $class;
      } else {
          return 0;
      }
  } catch (PDOException $e) {
      // Handle database errors
      echo "Error: " . $e->getMessage();
      // display the error message 
      return false; // Return false to indicate error
  }
};

function getAssignmentByClass($class, $conn){
  try {
    $sql = "SELECT current_assignment FROM classes WHERE class=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$class]);

    if ($stmt->rowCount() == 1) {
        $class = $stmt->fetch();
        return $class;
    } else {
        return 0;
    }
} catch (PDOException $e) {
    // Handle database errors
    echo "Error: " . $e->getMessage();
    // display the error message 
    return false; // Return false to indicate error
}
};