<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$property_id = $_GET['id'];

/* check if already saved */

$sql = "SELECT * FROM saved_properties 
        WHERE user_id=? AND property_id=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii",$user_id,$property_id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 0){

    $insert = "INSERT INTO saved_properties(user_id,property_id)
               VALUES(?,?)";

    $stmt = $conn->prepare($insert);
    $stmt->bind_param("ii",$user_id,$property_id);
    $stmt->execute();
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>