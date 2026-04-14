
<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'broker'){
    header("Location: login.html");
    exit();
}

$id = $_GET['id'];

$sql = "DELETE FROM properties WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$id);
$stmt->execute();

header("Location: my-listings.php");
exit();
?>