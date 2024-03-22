<?php 

function getNotices($conn){
    // Get the current date
    $current_date = date('Y-m-d');

    $sql = "SELECT * FROM notices WHERE date >= :current_date";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':current_date', $current_date, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $notices = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $notices;
    } else {
        return 0;
    }
}

