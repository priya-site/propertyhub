<?php 
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $property_id = $_POST['property_id'] ?? 0;
    $lead_id = $_POST['lead_id'] ?? 0;
    $inquiry_id = $_POST['inquiry_id'] ?? 0;
    $user_id = $_SESSION['user_id'];

    /* GET PROPERTY */
    $stmt = $conn->prepare("
        SELECT price, owner_id, broker_id 
        FROM properties 
        WHERE id = ?
    ");
    $stmt->bind_param("i", $property_id);
    $stmt->execute();
    $property = $stmt->get_result()->fetch_assoc();

    $amount = $property['price'];
    $owner_id = $property['owner_id'];
    $broker_id = $property['broker_id'];

    /* ✅ INSERT PAYMENT */
    $stmt = $conn->prepare("
        INSERT INTO payments 
        (user_id, property_id, owner_id, broker_id, amount, status, created_at)
        VALUES (?, ?, ?, ?, ?, 'paid', NOW())
    ");
    $stmt->bind_param("iiiii", $user_id, $property_id, $owner_id, $broker_id, $amount);
    $stmt->execute();

    /* ✅ IMPORTANT: UPDATE PAYMENT STATUS */

    if($inquiry_id){
        $stmt = $conn->prepare("
            UPDATE inquiries 
            SET payment_status='paid' 
            WHERE id=?
        ");
        $stmt->bind_param("i", $inquiry_id);
        $stmt->execute();
    }

    if($lead_id){
        $stmt = $conn->prepare("
            UPDATE broker_leads 
            SET payment_status='paid' 
            WHERE id=?
        ");
        $stmt->bind_param("i", $lead_id);
        $stmt->execute();
    }

    /* UPDATE PROPERTY */
    $stmt = $conn->prepare("
        UPDATE properties 
        SET status='Sold' 
        WHERE id=?
    ");
    $stmt->bind_param("i", $property_id);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Payment Success</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0A192F] flex items-center justify-center min-h-screen px-4">

<div class="bg-[#F3F4F6] p-6 sm:p-8 md:p-10 rounded-2xl shadow-2xl text-center w-full max-w-md">

    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-[#6A0DAD] mb-4">
        Payment Successful 🎉
    </h2>

    <p class="text-[#112240] mb-6 text-sm sm:text-base">
        You have successfully purchased!
    </p>

    <a href="user-dashboard.php"
       class="block w-full sm:w-auto bg-[#6A0DAD] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#8A2BE2] transition duration-300 text-sm sm:text-base">
       Go to Dashboard
    </a>

</div>

</body>
</html>