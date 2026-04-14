<?php
session_start();
include "db.php";

if(isset($_POST['inquiry_id'])){

    $inquiry_id = $_POST['inquiry_id'];

    /* GET DATA */
    $get = mysqli_query($conn,"
    SELECT i.property_id, p.title, p.price, i.owner_id
    FROM inquiries i
    JOIN properties p ON i.property_id = p.id
    WHERE i.id='$inquiry_id'
    ");

    $data = mysqli_fetch_assoc($get);

    if($data){

        /* ✅ UPDATE STATUS + REQUEST PAYMENT */
        mysqli_query($conn,"
UPDATE inquiries
SET status='Contacted', payment_status='pending'
WHERE id='$inquiry_id'
");

        /* ✅ INSERT EARNING IF NOT EXISTS */
        $check = mysqli_query($conn,"
        SELECT id FROM earnings
        WHERE property_id='{$data['property_id']}'
        AND owner_id='{$data['owner_id']}'
        ");

        if(mysqli_num_rows($check) == 0){
            mysqli_query($conn,"
            INSERT INTO earnings (owner_id, property_id, property_name, amount, status)
            VALUES (
                '{$data['owner_id']}',
                '{$data['property_id']}',
                '{$data['title']}',
                '{$data['price']}',
                'pending'
            )
            ");
        }
    }
}

header("Location: inquiries.php");
exit();
?>