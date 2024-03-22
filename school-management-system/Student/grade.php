<?php 
session_start();
if (isset($_SESSION['student_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'student') {
    include "../DB_connection.php";
    include "../admin/data/getStudentScore.php";
    include "../admin/data/getSubject.php";

    $student_id = $_SESSION['student_id'];
    $scores = getScoresById($student_id, $conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student - Grade Summary</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container mt-5">
        <?php if ($scores) { ?>
            <div class="table-responsive">
                <table class="table table-bordered mt-3 n-table">
                    <thead>
                        <tr>
                            <th scope="col">Year</th>
                            <th scope="col">Course Code</th>
                            <th scope="col">Course Title</th>
                            <th scope="col">Results</th>
                            <th scope="col">Total</th>
                            <th scope="col">Grade</th>
                            <th scope="col">Term</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($scores as $score) { 
                            $csubject = getSubjectById($score['subject_id'], $conn);
                            ?>
                            <tr>
                                <td><?= $score['year'] ?></td>
                                <td><?= $csubject['subject_code'] ?></td>
                                <td><?= $csubject['subject'] ?></td>
                                <td>
                                    <?php 
                                    $total = 0;
                                    $outOf = 0;
                                    $results = explode(',', trim($score['results']));
                                    foreach ($results as $result) {
                                        $temp =  explode(' ', trim($result));
                                        $total += (int) $temp[0]; // Convert to integer
                                        $outOf += (int) $temp[1]; // Convert to integer
                                        ?>
                                        <small class="border p-1">
                                            <?= $temp[0] ?> / <?= $temp[1] ?>
                                        </small>&nbsp;
                                    <?php } ?>
                                </td>
                                <td><?= $total ?> / <?= $outOf ?></td>
                                <td>
                                    <?php 
                                    $percentage = ($total / $outOf) * 100;
                                    echo gradeCalc($percentage);
                                    ?>
                                </td>
                                <td><?= $score['term'] ?></td>
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
?>


