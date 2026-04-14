<?php

include "db.php";

$name = $_POST['fullname'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$contact = $_POST['contact'];
$role = $_POST['role'];

$sql = "INSERT INTO users(name,email,password,contact,role)
        VALUES(?,?,?,?,?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss",$name,$email,$password,$contact,$role);
$stmt->execute();

header("Location: login.html?signup=success");
exit();

?>