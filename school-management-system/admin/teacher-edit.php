<?php
session_start();
if (
  isset($_SESSION['admin_id']) &&
  isset($_SESSION['role']) &&
  isset($_GET['teacher_id'])
) {

  if ($_SESSION['role'] == 'admin') {

    include "../DB_connection.php";
    include "data/getSubject.php";
    include "data/getClasses.php";
    include "data/getTeacher.php";
    include "data/getYear.php";
    include "data/getAdmin.php";

    $subjects = getAllSubjects($conn);
    $classes = getAllClasses($conn);
    $years = getAllYears($conn);

    $teacher_id = $_GET['teacher_id'];
    $teacher = getTeacherById($teacher_id, $conn);

    if ($teacher == 0) {
      header("Location: teacher.php");
      exit;
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Admin - Edit Teacher</title>
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
        <a href="teacher.php" class="btn btn-dark">Go Back</a>

        <form method="post" class="shadow p-3 mt-5 form-w" action="req/teacher-edit.php">
          <h3>Edit Teacher</h3>
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
            <input type="text" class="form-control" value="<?= $teacher['fname'] ?>" name="fname">
          </div>
          <div class="mb-3">
            <label class="form-label">Last name</label>
            <input type="text" class="form-control" value="<?= $teacher['lname'] ?>" name="lname">
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="text" class="form-control" value="<?= $teacher['email'] ?>" name="email">
          </div>
          <div class="mb-3">
            <label class="form-label">Date of birth</label>
            <input type="date" class="form-control" value="<?= $teacher['date_of_birth'] ?>" name="date_of_birth">
          </div>
          <div class="mb-3">
            <label class="form-label">Qualification</label>
            <input type="text" class="form-control" value="<?= $teacher['qualification'] ?>" name="qualification">
          </div>
          <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" class="form-control" value="<?= $teacher['phone_number'] ?>" name="phone_number">
          </div>
          <input type="text" value="<?= $teacher['teacher_id'] ?>" name="teacher_id" hidden>
          <div class="mb-3">
            <label class="form-label">Subject</label>
            <div class="row row-cols-5">
              <?php
              $subject_ids = str_split(trim($teacher['subjects']));
              foreach ($subjects as $subject) {
                $checked = 0;
                foreach ($subject_ids as $subject_id) {
                  if ($subject_id == $subject['subject_id']) {
                    $checked = 1;
                  }
                }
                ?>
                <div class="col">
                  <input type="checkbox" name="subjects[]" <?php if ($checked) echo "checked"; ?> value="<?= $subject['subject_id'] ?>">
                  <?= $subject['subject'] ?>
                </div>
              <?php } ?>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Classes</label>
            <div class="row row-cols-5">
              <?php
              $teacher_classes = explode(',', trim($teacher['classes']));
              foreach ($classes as $class) {
                $checked = in_array($class['class'], $teacher_classes) ? 'checked' : '';
                ?>
                <div class="col">
                  <input type="checkbox" name="classes[]" <?= $checked ?> value="<?= $class['class'] ?>">
                  <?= $class['class'] ?>
                </div>
              <?php } ?>
            </div>
          </div>

          <button type="submit" class="btn btn-primary">
            Update</button>
        </form>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
      <script>
        $(document).ready(function () {
          $("#navLinks li:nth-child(2) a").addClass('active');
        });
      </script>

    </body>

    </html>
<?php

  } else {
    header("Location: teacher.php");
    exit;
  }
} else {
  header("Location: teacher.php");
  exit;
}

?>
