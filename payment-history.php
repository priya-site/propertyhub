<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

/* ================= FETCH DATA ================= */

$query = mysqli_query($conn, "
SELECT payments.*, 
       properties.title, 
       properties.location,
       buyer.name AS buyer_name,
       owner.name AS owner_name,
       broker.name AS broker_name

FROM payments

LEFT JOIN properties 
    ON payments.property_id = properties.id

LEFT JOIN users buyer 
    ON payments.user_id = buyer.id

LEFT JOIN users owner 
    ON payments.owner_id = owner.id

LEFT JOIN users broker 
    ON payments.broker_id = broker.id

WHERE payments.status='paid'

AND (
    payments.user_id = '$user_id' 
    OR payments.owner_id = '$user_id'
    OR payments.broker_id = '$user_id'
)

ORDER BY payments.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment History</title>

<script src="https://cdn.tailwindcss.com"></script>

<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        navy: "#0A192F",
        royal: "#6A0DAD",
        lightroyal: "#8A2BE2",
        card: "#F3F4F6"
      }
    }
  }
}
</script>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-gray-100 text-navy">

<?php
if($role == "user"){
    include "user-layout.php";
}
elseif($role == "owner"){
    include "owner-layout.php";
}
elseif($role == "broker"){
    include "broker-layout.php"; 
}
?>

<div class="flex min-h-screen overflow-x-hidden">

<div class="flex-1 w-full md:ml-64 px-4 sm:px-6 md:px-10 py-6">

<h1 class="text-2xl sm:text-3xl font-bold text-royal mb-6 text-center">
💳 Payment History
</h1>

<div class="bg-white shadow rounded-xl overflow-hidden">

<!-- ================= DESKTOP TABLE ================= -->
<div class="hidden md:block overflow-x-auto">
<table class="w-full text-left">

<thead class="bg-royal text-white">
<tr>
<th class="p-4">Buyer</th>
<th class="p-4">Owner/Broker</th>
<th class="p-4">Property</th>
<th class="p-4">Location</th>
<th class="p-4">Amount</th>
<th class="p-4">Status</th>
<th class="p-4">Date</th>
</tr>
</thead>

<tbody>

<?php if(mysqli_num_rows($query) > 0){ ?>

<?php while($row = mysqli_fetch_assoc($query)){ ?>

<tr class="border-b hover:bg-gray-50">

<td class="p-4 text-blue-600 font-medium">
<?php echo $row['buyer_name'] ?? 'N/A'; ?>
</td>

<td class="p-4 text-gray-800 font-semibold text-sm whitespace-nowrap">
<?php 
if(!empty($row['broker_name'])){
    echo $row['broker_name']; // broker deal
} 
elseif(!empty($row['owner_name'])){
    echo $row['owner_name']; // owner deal
}
else{
    echo "N/A";
}
?>
</td>

<td class="p-4 font-semibold"><?php echo $row['title'] ?? 'N/A'; ?></td>
<td class="p-4 text-gray-500"><?php echo $row['location'] ?? 'N/A'; ?></td>

<td class="p-4 font-bold text-green-600">
₹ <?php echo number_format($row['amount']); ?>
</td>

<td class="p-4">
<span class="px-3 py-1 rounded text-sm 
<?php echo $row['status']=='paid' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600'; ?>">
<?php echo ucfirst($row['status']); ?>
</span>
</td>

<td class="p-4 text-gray-500">
<?php echo date("d M Y", strtotime($row['created_at'])); ?>
</td>

</tr>

<?php } ?>

<?php } else { ?>
<tr>
<td colspan="7" class="text-center p-6 text-gray-500">
No payment history found
</td>
</tr>
<?php } ?>

</tbody>
</table>
</div>

<!-- ================= MOBILE CARDS ================= -->
<div class="block md:hidden p-4 space-y-4">

<?php if(mysqli_num_rows($query) > 0){ ?>

<?php mysqli_data_seek($query, 0); while($row = mysqli_fetch_assoc($query)){ ?>

<div class="border rounded-lg p-4 shadow-sm bg-gray-50">

<p class="text-sm text-gray-500">Buyer</p>
<p class="font-semibold text-blue-600">
<?php echo $row['buyer_name'] ?? 'N/A'; ?>
</p>

<p class="text-sm text-gray-500 mt-2">Seller</p>
<p class="font-semibold">
<?php 
if(!empty($row['broker_name'])){
    echo $row['broker_name'] . " (Broker)";
} 
elseif(!empty($row['owner_name'])){
    echo $row['owner_name'] . " (Owner)";
}
else{
    echo "N/A";
}
?>
</p>

<p class="text-sm text-gray-500 mt-2">Property</p>
<p class="font-semibold"><?php echo $row['title'] ?? 'N/A'; ?></p>

<p class="text-sm text-gray-500 mt-2">Location</p>
<p><?php echo $row['location'] ?? 'N/A'; ?></p>

<p class="text-sm text-gray-500 mt-2">Amount</p>
<p class="font-bold text-green-600">
₹ <?php echo number_format($row['amount']); ?>
</p>

<p class="text-sm text-gray-500 mt-2">Status</p>
<span class="px-2 py-1 rounded text-xs inline-block
<?php echo $row['status']=='paid' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600'; ?>">
<?php echo ucfirst($row['status']); ?>
</span>

<p class="text-sm text-gray-500 mt-2">Date</p>
<p><?php echo date("d M Y", strtotime($row['created_at'])); ?></p>

</div>

<?php } ?>

<?php } else { ?>

<p class="text-center text-gray-500">No payment history found</p>

<?php } ?>

</div>

</div>

</div>
</div>

</body>
</html>