<?php
session_start();
include "db.php";
include "functions.php";

$id = $_GET['id'];
$broker_id = $_SESSION['user_id'];

/* FETCH LEAD + PROPERTY DATA */

$stmt = $conn->prepare("
SELECT broker_leads.*, 
       properties.title AS property_title,
       properties.location AS property_location,
       properties.price AS price
FROM broker_leads
LEFT JOIN properties 
ON broker_leads.property_id = properties.id
WHERE broker_leads.id=? AND broker_leads.broker_id=?
");

$stmt->bind_param("ii",$id,$broker_id);
$stmt->execute();
$result = $stmt->get_result();
$lead = $result->fetch_assoc();

/* AUTO STATUS UPDATE */
if($lead && $lead['status'] == 'New'){
    
    $update = $conn->prepare("
    UPDATE broker_leads 
    SET status='Pending' 
    WHERE id=? AND broker_id=?
    ");

    $update->bind_param("ii",$id,$broker_id);
    $update->execute();

    $lead['status'] = 'Pending';
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Lead Details</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://cdn.tailwindcss.com"></script>

<script>
tailwind.config = {
theme: {
extend: {
colors: {
navy: "#0A192F",
deepnavy: "#112240",
card: "#F3F4F6",
royal: "#6A0DAD",
lightroyal: "#8A2BE2",
}
}
}
}
</script>

</head>

<body class="bg-card min-h-screen">

<!-- Navbar -->
<nav class="bg-white shadow-md p-4 flex flex-col md:flex-row md:justify-between md:items-center gap-3">

<h1 class="text-xl md:text-2xl font-bold text-purple-700">
PropertyHub
</h1>

<div class="flex flex-wrap gap-4 text-sm md:text-base">
<a href="index.php" class="hover:text-purple-700">Home</a>
<a href="property-listing.php" class="hover:text-purple-700">Properties</a>
<a href="leads.php" class="hover:text-purple-700">My Leads</a>
</div>

</nav>

<!-- CARD -->
<div class="max-w-xl w-full bg-white p-5 sm:p-6 md:p-10 rounded-2xl shadow-xl border border-gray-200 mt-6 md:mt-12 mx-auto">

<h2 class="text-2xl md:text-3xl font-bold mb-6 md:mb-8 text-royal border-b pb-4">
Lead Details
</h2>

<div class="space-y-4 text-gray-700">

<!-- PROPERTY NAME -->
<div class="flex flex-col sm:flex-row sm:justify-between border-b pb-2 gap-1">
<span class="font-semibold text-navy">Property</span>
<span class="break-words"><?php echo $lead['property_title']; ?></span>
</div>

<!-- LOCATION -->
<div class="flex flex-col sm:flex-row sm:justify-between border-b pb-2 gap-1">
<span class="font-semibold text-navy">Location</span>
<span class="break-words"><?php echo $lead['property_location']; ?></span>
</div>

<!-- AMOUNT -->
<div class="flex flex-col sm:flex-row sm:justify-between border-b pb-2 gap-1">
<span class="font-semibold text-navy">Amount</span>
<span class="text-gray-600">
₹ <?php echo isset($lead['price']) ? formatPrice($lead['price']) : "Not Available"; ?>
</span>
</div>

<!-- CLIENT NAME -->
<div class="flex flex-col sm:flex-row sm:justify-between border-b pb-2 gap-1">
<span class="font-semibold text-navy">Client Name</span>
<span><?php echo $lead['client_name']; ?></span>
</div>

<!-- EMAIL -->
<div class="flex flex-col sm:flex-row sm:justify-between border-b pb-2 gap-1">
<span class="font-semibold text-navy">Email</span>
<span class="break-words"><?php echo $lead['email']; ?></span>
</div>

<!-- PHONE -->
<div class="flex flex-col sm:flex-row sm:justify-between border-b pb-2 gap-1">
<span class="font-semibold text-navy">Phone</span>
<span><?php echo $lead['contact']; ?></span>
</div>

<!-- MESSAGE -->
<div class="flex flex-col sm:flex-row sm:justify-between border-b pb-2 gap-2">
<span class="font-semibold text-navy">Message</span>

<div class="text-gray-600 w-full sm:max-w-xs break-words sm:text-right">
<?php echo $lead['message']; ?>
</div>

</div>

<!-- DATE -->
<div class="flex flex-col sm:flex-row sm:justify-between gap-1">
<span class="font-semibold text-navy">Date</span>
<span><?php echo date("d M Y", strtotime($lead['created_at'])); ?></span>
</div>

</div>

<!-- BUTTON -->
<div class="mt-6 md:mt-8 flex justify-center sm:justify-end">

<a href="leads.php"
class="bg-royal text-white px-6 py-2 rounded-lg hover:bg-lightroyal transition text-sm md:text-base">
Back
</a>

</div>

</div>

<div id="footer-container"></div>

<script src="js/loadFooter.js"></script>

</body>
</html>