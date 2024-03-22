<?php 

function adminPasswordVerify($admin_pass, $conn, $admin_id){

    $sql = "SELECT * FROM admin
            WHERE admin_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$admin_id]);
 
    if ($stmt->rowCount() == 1) {
      $admin = $stmt->fetch();
      $hashed_admin_pass  = $admin['password'];
      $admin_salt = $admin["salt"];
 
      // Define the bitwise_hash and custom_hash functions here
      function bitwise_hash($string) {
          $hash = 0;
          for ($i = 0; $i < strlen($string); $i++) {
              $hash ^= ord($string[$i]);
          }
          return dechex($hash);
      };
      function custom_hash($password, $salt) {
          return bitwise_hash($password . $salt);
      };
 
      $hashed_user_pass = custom_hash($admin_pass, $admin_salt);
 
      if ($hashed_admin_pass == $hashed_user_pass){
          return $hashed_user_pass;
      }
    } else {
     return 0;
    }
 }
 