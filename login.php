<?php
session_start();
include "db.php";

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email=?";
$stmt = $conn->prepare($sql);

if(!$stmt){
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("s",$email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 1){

    $user = $result->fetch_assoc();

    if(password_verify($password,$user['password'])){

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        if($user['role'] == "user"){
            header("Location: user-dashboard.php");
        }
        elseif($user['role'] == "owner"){
            header("Location: owner-dashboard.php");
        }
        else{
            header("Location: broker-dashboard.php");
        }

        exit();
    }
}

echo "Invalid login credentials";