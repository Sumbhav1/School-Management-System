<?php 
session_start();
if (isset($_SESSION['teacher_id']) && isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'teacher') {
       include "../DB_connection.php";
       include "../admin/data/getStudent.php";
       include "../admin/data/getSetting.php";
       include "../admin/data/getClasses.php";
       include "../admin/data/getSubject.php";
       include "../admin/data/getStudentScore.php";

       if (!isset($_GET['class'])) {
           header("Location: classes.php");
           exit;
       }
    $class = $_GET['class'];
    $students = getAllStudents($conn);
    $settings = getSetting($conn);
    $current_term = $settings['current_term'];
    $current_year = $settings['current_year'];
    $teacher_id = $_SESSION['teacher_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher - Students</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container mt-5">
        <?php if ($students != 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered mt-3 n-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">email</th>
                        <th scope="col">Scores</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; foreach ($students as $student ) {
                        $studentClasses = preg_split('/\s*,\s*/', $student['classes']);
                        $Match = MatchStudentInClass($studentClasses, $class);
                        $classGet = getClassByClass($class, $conn);
                        $subject_code = substr($class, 3);
                        $subject = getSubjectByCode($subject_code, $conn);
                        $studentScore = getScoreById($student['student_id'], $teacher_id, $subject['subject_id'], $current_term, $current_year, $conn);
                        if ($Match == True) { $i++; ?>
                        <tr>
                            <th scope="row"><?= $i ?></th>
                            <td><?= $student['student_id'] ?></td>
                            <td><a href="student_grade.php?student_id=<?= $student['student_id'] ?>"><?= $student['fname'] ?></a></td>
                            <td><?= $student['lname'] ?></td>
                            <td><?= $student['email'] ?></td>
                            <td><?= $studentScore['results'] ?></td>
                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="alert alert-info .w-450 m-5" role="alert">
            Empty!
        </div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>    
    <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(2) a").addClass('active');
        });
    </script>
</body>
</html>

<?php 
  } else {
    header("Location: ../login.php");
    exit;
  } 
} else {
	header("Location: ../login.php");
	exit;
} 
?>
