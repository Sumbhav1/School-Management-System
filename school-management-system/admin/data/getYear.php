<?php  

// All Sections
function getAllYears($conn){
   $sql = "SELECT * FROM year";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() >= 1) {
     $years = $stmt->fetchAll();
     return $years;
   }else {
    return 0;
   }
}

// Get Section by ID
function getYearById($class_id, $conn){
   $sql = "SELECT * FROM year
           WHERE section_id=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$class_id]);

   if ($stmt->rowCount() == 1) {
     $grade = $stmt->fetch();
     return $grade;
   }else {
    return 0;
   }
}