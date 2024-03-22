<?php
session_start();
if (
    isset($_SESSION['admin_id']) &&
    isset($_SESSION['role']) &&
    isset($_GET['student_id'])
) {

    if ($_SESSION['role'] == 'admin') {

        include "../DB_connection.php";
        include "data/getSubject.php";
        include "data/getClasses.php";
        include "data/getStudent.php";
        include "data/getYear.php"; // Include file to get years
        $classes = getAllClasses($conn);
        $years = getAllYears($conn); // Fetch years

        $student_id = $_GET['student_id'];
        $student = getStudentById($student_id, $conn);

        if ($student == 0) {
            header("Location: student.php");
            exit;
        }


        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Admin - Edit Student</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="../css/style.css">
            <link rel="icon" href="../logo.png">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        </head>

        <body>
            <?php
            include "inc/navbar.php";
            ?>
            <div class="container mt-5">
                <a href="student.php" class="btn btn-dark">Go Back</a>

                <form method="post" class="shadow p-3 mt-5 form-w" action="req/student-edit.php">
                    <h3>Edit Student</h3>
                    <hr>
                    <?php if (isset($_GET['error'])) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $_GET['error'] ?>
                        </div>
                    <?php } ?>
                    <?php if (isset($_GET['success'])) { ?>
                        <div class="alert alert-success" role="alert">
                            <?= $_GET['success'] ?>
                        </div>
                    <?php } ?>
                    <div class="mb-3">
                        <label class="form-label">First name</label>
                        <input type="text" class="form-control" value="<?= $student['fname'] ?>" name="fname">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Last name</label>
                        <input type="text" class="form-control" value="<?= $student['lname'] ?>" name="lname">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" value="<?= $student['email'] ?>" name="email">
                    </div>
                    <input type="text" value="<?= $student['student_id'] ?>" name="student_id" hidden>


                    <div class="mb-3">
                        <label class="form-label">Classes</label>
                        <div class="row row-cols-5">
                            <?php
                            $student_classes = explode(',', trim($student['classes']));

                            foreach ($classes as $class) {
                                $checked = in_array($class['class'], $student_classes) ? 'checked' : '';
                            ?>
                                <div class="col">
                                    <input type="checkbox" name="classes[]" <?= $checked ?> value="<?= $class['class'] ?>">
                                    <?= $class['class'] ?>
                                </div>
                            <?php } ?>

                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Year</label>
                        <select class="form-select" name="year">
                            <?php
                            foreach ($years as $year) {
                                $selected = $year['year'] == $student['year'] ? 'selected' : '';
                            ?>
                                <option value="<?= $year['year'] ?>" <?= $selected ?>><?= $year['year'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                $(document).ready(function() {
                    $("#navLinks li:nth-child(3) a").addClass('active');
                });
            </script>

        </body>

        </html>
<?php

    } else {
        header("Location: student.php");
        exit;
    }
} else {
    header("Location: student.php");
    exit;
}

?>

