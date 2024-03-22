<?php
session_start();


function sendError($errorMessage) {
    header("Content-Type: application/json");
    echo json_encode(["error" => $errorMessage]);
    exit;
}


function generate_salt($length) {
    return bin2hex(random_bytes($length));
}

// Function for the XOR-based hash
function bitwise_hash($string) {
    $hash = 0;
    for ($i = 0; $i < strlen($string); $i++) {
        $hash ^= ord($string[$i]);
    }
    return dechex($hash);
};

// Function to hash the password before storing in the database
function custom_hash($password, $salt) {
    return bitwise_hash($password . $salt);
};

// Function to verify the password during login
function custom_verify($entered_password, $storedPassword, $salt) {
    $hashed_entered_password = bitwise_hash($entered_password . $salt);
    return $hashed_entered_password === $storedPassword;
};

if (isset($_POST['email']) &&
    isset($_POST['password']) &&
    isset($_POST['role'])) {

    include '../DB_connection.php';

	
	$email = $_POST['email'];
	$password = $_POST['password'];
	$role = $_POST['role'];

	if (empty($email)) {
        sendError("email is required");
		exit;
	}else if (empty($password)) {
		sendError("password is required");
		exit;
	}else if (empty($role)) {
        sendError("role is required");
		exit;


    } else{
        if ($role == "admin"){
            $sql = "SELECT * FROM admins WHERE email = ?";
        }elseif ($role == "student"){
            $sql = "SELECT * FROM students WHERE email = ?";
        }else if ($role == "teacher"){
            $sql = "SELECT * FROM teachers WHERE email = ?";
        }

        $stmt = $conn->prepare($sql); 
        $stmt->execute([$email]);
        if ($stmt -> rowCount() == 1) {
            $user = $stmt->fetch();
            $storedEmail = $user['email']; 
            $storedPassword = $user['password'];   
            $salt = $user['salt'];
            if ($email == $storedEmail) {
                if (custom_verify($password, $storedPassword, $salt) ){
                    $_SESSION['role'] = $role;
                    $_SESSION[$role . '_id'] = $user[$role . '_id'];
                    // Return JSON response indicating successful login
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'role' => $role]);
                    exit;
                    
                }else {
                    sendError("incorrect password");
                    exit;
                };

                 
            }else {
                sendError("No user found with this email");
                exit;
            }
        }else {
            sendError("incorrect email or password");
            exit;
        }
    };
}else{
    sendError("invalid request");
};



