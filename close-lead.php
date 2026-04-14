<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'broker'){
    header("Location: login.html");
    exit();
}

$lead_id = $_GET['id'];

mysqli_query($conn,"
UPDATE properties 
SET status='sold' 
WHERE id=(SELECT property_id FROM broker_leads WHERE id='$id')
");

/* STEP 1: Get property_id from lead */
$getLead = $conn->query("SELECT property_id FROM broker_leads WHERE id='$lead_id'");
$leadData = $getLead->fetch_assoc();

$property_id = $leadData['property_id'];

/* STEP 2: Update lead status */
$conn->query("UPDATE broker_leads SET status='Closed' WHERE id='$lead_id'");

/* STEP 3: Mark property as SOLD */
$conn->query("UPDATE properties SET status='Sold' WHERE id='$property_id'");

/* REDIRECT */
header("Location: leads.php");
exit();
?>