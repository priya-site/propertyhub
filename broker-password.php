<?php

session_start();
include "db.php";

/* Check login */

if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

/* Ensure broker access */

if($_SESSION['role'] != 'broker'){
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

/* Check confirm password */

if($new_password !== $confirm_password){
    echo "New passwords do not match";
    exit();
}


/* Get current password from database */

$sql = "SELECT password FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();


/* Verify old password */

if(!password_verify($current_password, $user['password'])){
    echo "Current password incorrect";
    exit();
}


/* Hash new password */

$new_hashed = password_hash($new_password, PASSWORD_DEFAULT);


/* Update password */

$sql = "UPDATE users SET password=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $new_hashed, $user_id);

if($stmt->execute()){

    header("Location: broker-profile.php?success=passwordupdated");

}else{

    echo "Error updating password";

}

?>