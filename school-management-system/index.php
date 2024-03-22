<?php 
include "DB_connection.php";
include "admin/data/getSetting.php";
$setting = getSetting($conn);

if ($setting != 0){


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SCHOOL MANAGEMENT</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body class="body-home">
  <div class="black-fill"><br />
    <div class="container">
      <nav class="navbar navbar-expand-lg" id="homeNav">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            <img src="img/logo.png" alt="ICON" width="40">
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02"
            aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <br/>
      <section class="welcome-text d-flex justify-content-center align-items-center flex-column">
        <img src="img/logo.png">
        <h4>Welcome to <?=$setting['school_name']?></h4>
        <p><?=$setting['slogan']?></p>
      </section>
      <section class="d-flex justify-content-center align-items-center flex-column"id="about">
        <div class="card mb-3 card-1" >
          <div class="row g-0">
            <div class="col-md-4">
              <img src="img/logo.png" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">About</h5>
                <p class="card-text"><?=$setting['about']?></p>
                <p class="card-text"><small class="text-body-secondary"><?=$setting['school_name']?></small></p>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php }else {
	header("Location: login.php");
	exit;
}  ?>