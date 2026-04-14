<?php
include "db.php";

$lead_id = $_GET['id'];

/* ================= GET LEAD ================= */
$lead = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM broker_leads WHERE id='$lead_id'
"));

/* ================= GET PROPERTY PRICE ================= */
$property_id = $lead['property_id'];

$property = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT price FROM properties WHERE id='$property_id'
"));

$amount = $property['price'] ?? 0; // ✅ REAL PRICE

/* ================= INSERT PAYMENT ================= */
mysqli_query($conn,"
INSERT INTO payments (lead_id, broker_id, user_id, property_id, amount, status)
VALUES ('$lead_id', '{$lead['broker_id']}', '{$lead['user_id']}', '$property_id', '$amount', 'pending')
");

/* ================= UPDATE LEAD ================= */
mysqli_query($conn,"
UPDATE broker_leads 
SET payment_status='pending' 
WHERE id='$lead_id'
");

header("Location: leads.php");
?>