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

<body class="body-login">
    <div class="black-fill"><br />
        <div class="container">
            <nav class="navbar navbar-expand-lg" id="homeNav">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <img src="img/logo.png" alt="ICON" width="40">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="index.php">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="login.php">Login</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <br />
            <div class="d-flex justify-content-center align-items-center flex-column">
                <form class="login" method="post" action="req/login.php" id="loginForm">
                    <h3>admin login</h3>
                    <div id="errorContainer"></div>
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="userPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="Password" name="password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="userType">Login as</label>
                        <select class="form-control" name="role">
                            <option value="admin">Admin</option>
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("loginForm").addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent form submission

            var formData = new FormData(this);

            fetch("req/login.php", {
                method: "POST",
                body: formData
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json(); // Parse JSON response
                })
                .then(data => {
                    if (data.error) {
                        // Display error message
                        document.getElementById("errorContainer").innerHTML = `
                            <div class="alert alert-danger" role="alert">
                                ${data.error}
                            </div>
                        `;
                    } else {
                        // Login successful, redirect to appropriate page
                        if (data.role === "admin") {
                            window.location.href = "admin/index.php";
                        } else if (data.role === "student") {
                            window.location.href = "student/index.php";
                        } else if (data.role === "teacher") {
                            window.location.href = "teacher/index.php";
                        }
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                });
        });
    </script>
</body>

</html>