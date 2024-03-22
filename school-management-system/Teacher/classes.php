<?php 
session_start();
if (isset($_SESSION['teacher_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'teacher') {
        include "../DB_connection.php";
        include "../admin/data/getTeacher.php";
        include "../admin/data/getSubject.php";
        include "../admin/data/getClasses.php";
        include "../admin/data/getYear.php";
       
        $teacher_id = $_SESSION['teacher_id'];
        $teacher = getTeacherById($teacher_id, $conn);
        $raw_classes = explode(",", $teacher['classes']);
        $classes = array_map('trim', $raw_classes);
        $AllClasses = getAllClasses($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers - Classes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container mt-5">
        <?php if ($classes != 0) { ?>
            <div class="table-responsive">
                <table class="table table-bordered mt-3 n-table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Class</th>
                            <th scope="col">Assignment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; foreach ($classes as $class) { 
                            $i++;
                            ?>
                            <tr>
                                <th scope="row"><?= $i ?></th>
                                <td>
                                    <a href="students_of_class.php?class=<?= $class ?>">
                                        <?= $class ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="assignment-edit.php?class=<?= $class ?>" class="btn btn-warning">
                                        <?php
                                        $classGet = getClassByClass($class, $conn);
                                        echo $classGet['current_assignment'];
                                        ?>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <div class="alert alert-info .w-450 m-5" role="alert">
                Empty!
            </div>
        <?php } ?>
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
