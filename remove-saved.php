<?php

session_start();
include "db.php";

$user_id = $_SESSION['user_id'];
$property_id = $_GET['id'];

$sql = "DELETE FROM saved_properties 
        WHERE user_id=? AND property_id=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii",$user_id,$property_id);
$stmt->execute();

header("Location: saved.php");
exit();

?>