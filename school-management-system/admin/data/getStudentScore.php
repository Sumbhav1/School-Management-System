<?php  

// All student_score
function getAllScores($conn){
   $sql = "SELECT * FROM student_score";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() >= 1) {
     $students_score = $stmt->fetchAll();
     return $students_score;
   }else {
    return 0;
   }
}

// Get student_score by ID
function getScoreById($student_id, $teacher_id, $subject_id, $term, $year, $conn){
   $sql = "SELECT * FROM student_score
           WHERE student_id=? AND teacher_id=? AND subject_id=? AND term=? AND year=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$student_id, $teacher_id, $subject_id, $term, $year]);

   if ($stmt->rowCount() == 1) {
     $student_score = $stmt->fetch();
     return $student_score;
   }else {
    return 0;
   }
}
function getScoresById($student_id, $conn){
    $sql = "SELECT * FROM student_score WHERE student_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$student_id]);

    // Check for errors
    if ($stmt === false) {
        // Handle SQL error
        die("Error executing SQL query: " . $conn->errorInfo()[2]);
    }

    // Fetch all rows
    $student_scores = $stmt->fetchAll();

    // Check if any rows were returned
    if ($student_scores) {
        return $student_scores;
    } else {
        return 0;
    }
}



 function gradeCalc($grade){
    $g = "";
    if ($grade >= 85) {
        $g = "A*";
    }else if ($grade >= 80) {
        $g = "A";
    }else if ($grade >= 70) {
        $g = "B";
    }else if ($grade >= 60) {
        $g = "C";
    }else if ($grade >= 45) {
        $g = "D";
    }else if ($grade < 39) {
        $g = "U";
    }
    return $g;
 }

