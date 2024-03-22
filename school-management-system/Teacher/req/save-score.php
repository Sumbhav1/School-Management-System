<?php
session_start();
if (
    isset($_SESSION['teacher_id']) && 
    isset($_SESSION['role'])
) {
    if ($_SESSION['role'] == 'teacher') {
        if (
            isset($_POST['scores']) &&
            isset($_POST['student_id']) &&
            isset($_POST['current_term']) &&
            isset($_POST['current_year']) &&
            isset($_POST['subject_id'])
        ) {
            include '../../DB_connection.php';

            $scores = $_POST['scores'];
            $student_id = $_POST['student_id'];
            $current_term = $_POST['current_term'];
            $current_year = $_POST['current_year'];
            $teacher_id = $_SESSION['teacher_id'];
            $subject_id = $_POST['subject_id'];

            // Construct results string
            $data = '';
            foreach ($scores as $score) {
                $score_value = $score['score'];
                $out_of_value = $score['out_of'];
                $data .= "$score_value $out_of_value,";
            }

            // Check if a score entry already exists for the given parameters
            $sql = "SELECT * FROM student_score 
                          WHERE student_id=? AND teacher_id=? AND subject_id=? AND term=? AND year=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$student_id, $teacher_id, $subject_id, $current_term, $current_year]);
            $existing_score = $stmt->fetch();

            if ($existing_score) {
                // If an entry exists, perform an update operation
                $sql_update = "UPDATE student_score 
                               SET results=? 
                               WHERE student_id=? AND teacher_id=? AND subject_id=? AND term=? AND year=?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->execute([$data, $student_id, $teacher_id, $subject_id, $current_term, $current_year]);
                $sm = "The score has been updated successfully!";
                header("Location: ../student_grade.php?student_id=$student_id&success=$sm");
                exit;
            } else {
                // If no entry exists, perform an insert operation
                $sql_insert = "INSERT INTO student_score (term, year, student_id, teacher_id, subject_id, results) 
                               VALUES (?, ?, ?, ?, ?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->execute([$current_term, $current_year, $student_id, $teacher_id, $subject_id, $data]);
                $sm = "The score has been saved successfully!";
                header("Location: ../student_grade.php?student_id=$student_id&success=$sm");
                exit;
            }
        } else {
            $em = "An error occurred. Please make sure all required fields are filled.";
            header("Location: ../student_grade.php?student_id=$student_id&error=$em");
            exit;
        }
    } else {
        header("Location: ../../logout.php");
        exit;
    } 
} else {
    header("Location: ../../logout.php");
    exit;
}



