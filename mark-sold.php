<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'owner'){
    header("Location: login.html");
    exit();
}

$id = $_GET['id'];
$owner_id = $_SESSION['user_id'];

/* ================= GET PROPERTY ================= */
$get = $conn->prepare("
SELECT title, price, status FROM properties 
WHERE id=? AND owner_id=?
");
$get->bind_param("ii", $id, $owner_id);
$get->execute();
$result = $get->get_result();
$property = $result->fetch_assoc();

if($property){

    /* 🚫 PREVENT DUPLICATE SOLD */
    if($property['status'] == 'Sold'){
        header("Location: myproperties.php");
        exit();
    }

    /* ================= UPDATE PROPERTY STATUS ================= */
    $stmt = $conn->prepare("
    UPDATE properties 
    SET status='Sold' 
    WHERE id=? AND owner_id=?
    ");
    $stmt->bind_param("ii", $id, $owner_id);
    $stmt->execute();

    /* ================= CHECK IF EARNING ALREADY EXISTS ================= */
    $check = $conn->prepare("
    SELECT id FROM earnings 
    WHERE property_id=? AND owner_id=?
    ");
    $check->bind_param("ii", $id, $owner_id);
    $check->execute();
    $exists = $check->get_result();

    if($exists->num_rows == 0){

        /* ================= INSERT EARNING ================= */
        $insert = $conn->prepare("
        INSERT INTO earnings 
        (owner_id, property_id, property_name, amount, status, created_at)
        VALUES (?, ?, ?, ?, 'completed', NOW())
        ");

        $insert->bind_param(
            "iisd",
            $owner_id,
            $id,
            $property['title'],
            $property['price']
        );

        $insert->execute();
    }
}

header("Location: myproperties.php");
exit();
?>