<?php
session_start();
include "db.php";

/* Get logged-in user id */
$user_id = $_SESSION['user_id'];

$property_id = $_POST['property_id'];
$broker_id = $_POST['broker_id'];

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];

/* Get property name from properties table */

$getProperty = $conn->query("SELECT title FROM properties WHERE id='$property_id'");
$property = $getProperty->fetch_assoc();
$property_name = $property['title'];

/* Insert Lead */

$sql = "INSERT INTO broker_leads
(user_id, property_id, broker_id, property_name, client_name, email, contact, message, status)

VALUES
('$user_id','$property_id','$broker_id','$property_name','$name','$email','$phone','$message','New')";

$conn->query($sql);

header("Location: contact-broker.php?property_id=".$property_id."&broker_id=".$broker_id."&success=1");
exit();
exit();
?>