<?php 
session_start();
if (isset($_SESSION['teacher_id']) && isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'teacher') {
       include "../DB_connection.php";
       include "../admin/data/getStudent.php";
       include "../admin/data/getClass.php";
       include "../admin/data/getSetting.php";
       include "../admin/data/getSubject.php";
       include "../admin/data/getTeacher.php";
       include "../admin/data/getStudentScore.php";

       if (!isset($_GET['student_id'])) {
           header("Location: students_of_class.php");
           exit;
       }
       $student_id = $_GET['student_id'];
       $student = getStudentById($student_id, $conn);
       $setting = getSetting($conn);

       $teacher_id = $_SESSION['teacher_id'];
       $teacher = getTeacherById($teacher_id, $conn);

       $teacher_subjects = str_split(trim($teacher['subjects']));
       $studentClasses = preg_split('/\s*,\s*/', $student['classes']);
       $subjects = [];

       foreach ($studentClasses as $studentClass) {
            $subject_code = substr($studentClass, 3);
            array_push($subjects, getSubjectByCode($subject_code,$conn));
       }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher - Students Grade</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php 
include "inc/navbar.php";
if ($student != 0 && $setting !=0 && $subjects !=0 && $teacher_subjects != 0) {
?>
<div class="d-flex align-items-center flex-column"><br><br>
    <div class="login shadow p-3">
        <form method="post" action="req/save-score.php">
            <div class="mb-3">
                <ul class="list-group">
                    <li class="list-group-item"><b>ID: </b> <?php echo $student['student_id'] ?></li>
                    <li class="list-group-item"><b>First Name: </b> <?php echo $student['fname'] ?></li>
                    <li class="list-group-item"><b>Last Name: </b> <?php echo $student['lname'] ?></li>
                    <li class="list-group-item"><b>Year: </b> <?php echo $student['year']; ?></li>
                    <li class="list-group-item text-center"><b>Year: </b> <?php echo $setting['current_year']; ?> &nbsp;&nbsp;&nbsp;<b>Term</b> <?php echo $setting['current_term']; ?></li>
                </ul>
            </div>
            <h5 class="text-center">Add Grade</h5>
            <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger" role="alert">
                <?=$_GET['error']?>
            </div>
            <?php } ?>
            <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-success" role="alert">
                <?=$_GET['success']?>
            </div>
            <?php } ?>
           
            <label class="form-label">Subject / Course</label>
            <select class="form-control" name="subject_id">
                <?php foreach($subjects as $subject){ 
                    foreach($teacher_subjects as $teacher_subject){
                        echo $subject['$subject_id'];
                        if($subject['subject_id'] == $teacher_subject){ ?>
                            <option value="<?php echo $subject['subject_id'] ?>">
                                <?php echo $subject['subject_code'] ?>
                            </option>
                <?php   }
                    }
                } ?>
            </select><br>
   
            <div class="mb-3">
                <label class="form-label">Enter Scores</label>
                <table>
                    <thead>
                        <tr>
                            <th>Score</th>
                            <th>Out of</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 1; $i <= 4; $i++): ?>
                        <tr>
                            <td><input type="number" name="scores[<?= $i ?>][score]" min="0" max="100" required></td>
                            <td><input type="number" name="scores[<?= $i ?>][out_of]" min="1" max="100" required></td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
            
            <button type="submit" class="btn btn-primary">Save</button><br><br>
            <input type="hidden" name="student_id" value="<?=$student_id?>">
            <input type="hidden" name="current_term" value="<?=$setting['current_term']?>">
            <input type="hidden" name="current_year" value="<?=$setting['current_year']?>">
        </form>  
    </div>
</div>
<?php 
    } else {
        header("Location: classes.php");
        exit;
    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>  
<script>
$(document).ready(function(){
    $("#navLinks li:nth-child(4) a").addClass('active');
});
</script>
</body>
</html>
<?php 
} else {
    header("Location: ../login.php");
    exit;
} 
?>
