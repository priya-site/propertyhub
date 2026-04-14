<?php
session_start();
include "db.php";

if (isset($_POST['property_id']) && isset($_POST['inquiry_id'])) {

    $property_id = $_POST['property_id'];
    $inquiry_id = $_POST['inquiry_id'];
    $owner_id = $_SESSION['user_id'];

    /* CHECK PAYMENT STATUS */
    $check = mysqli_query($conn, "
    SELECT payment_status FROM inquiries
    WHERE id='$inquiry_id'
    ");

    $data = mysqli_fetch_assoc($check);

    if ($data['payment_status'] == 'paid') {

        /* 1. UPDATE INQUIRY STATUS */
        mysqli_query($conn, "
        UPDATE inquiries
        SET status='Completed'
        WHERE id='$inquiry_id'
        ");

        /* 2. UPDATE PROPERTY STATUS */
        mysqli_query($conn, "
        UPDATE properties
        SET status='Sold'
        WHERE id='$property_id'
        ");

        /* 3. GET PROPERTY DETAILS */
        $get = mysqli_query($conn, "
SELECT title, price FROM properties 
WHERE id='$property_id' AND owner_id='$owner_id'
");

        $property = mysqli_fetch_assoc($get);

        /* ✅ CHECK PROPERTY EXISTS */
        if (!$property) {
            die("Property not found");
        }

        $property_name = $property['title'];
        $amount = $property['price'];

        /* 4. CHECK IF ALREADY EXISTS */
        $checkEarning = mysqli_query($conn, "
SELECT * FROM earnings 
WHERE property_id='$property_id' 
AND owner_id='$owner_id'
");

        /* 5. INSERT OR UPDATE */
        if (mysqli_num_rows($checkEarning) > 0) {

            // ✅ UPDATE EXISTING (fix wrong amount)
            mysqli_query($conn, "
    UPDATE earnings 
    SET 
        property_name='$property_name',
        amount='$amount',
        status='completed'
    WHERE property_id='$property_id'
    AND owner_id='$owner_id'
    ");

        } else {

            // ✅ INSERT NEW
            mysqli_query($conn, "
    INSERT INTO earnings 
    (owner_id, property_id, property_name, amount, status, created_at)
    VALUES (
        '$owner_id',
        '$property_id',
        '$property_name',
        '$amount',
        'completed',
        NOW()
    )
    ");
        }
    }
}


header("Location: inquiries.php");
exit();
?>