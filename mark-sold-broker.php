<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'broker'){
    header("Location: login.html");
    exit();
}

$id = $_GET['id'];
$broker_id = $_SESSION['user_id'];

/* SECURITY: ensure broker owns this property */
$stmt = $conn->prepare("UPDATE properties SET status='Sold' WHERE id=? AND broker_id=?");
$stmt->bind_param("ii", $id, $broker_id);
$stmt->execute();

header("Location: my-listings.php");
exit();
?>