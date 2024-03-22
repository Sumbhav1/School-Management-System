<?php 
session_start();
if ((isset($_SESSION['admin_id']) || isset($_SESSION['teacher_id'])) && isset($_SESSION['role'])){

    if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'teacher') {
    	
        if (isset($_POST['event'])) {
            
            include '../../DB_connection.php';
            
            $event = $_POST['event'];
            $date = $_POST['date'];
            $description = $_POST['description'];
            $data = 'event='.$event;
            
            if (empty($event)) {
                $em = "Event is required";
                header("Location: ../add-notice.php?error=$em&$data");
                exit;
            } else {
                // Validate if the entered date is in the future
                $current_date = date('Y-m-d');
                if ($date <= $current_date) {
                    $em = "Please enter a future date";
                    header("Location: ../add-notice.php?error=$em&$data");
                    exit;
                }
                
                // Proceed with insertion if the date is valid
                $sql  = "INSERT INTO notices (event, description, date) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$event, $description, $date]);
                $sm = "New notice added successfully";
                header("Location: ../add-notice.php?success=$sm");
                exit;
            }
        } else {
            $em = "An error occurred";
            header("Location: ../add-notice.php?error=$em");
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