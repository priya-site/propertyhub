<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

if($_SESSION['role'] != 'broker'){
    header("Location: login.html");
    exit();
}

$broker_id = $_SESSION['user_id'];

$query = mysqli_query($conn,"
SELECT broker_leads.*, properties.title AS property_title
FROM broker_leads
LEFT JOIN properties 
ON broker_leads.property_id = properties.id
WHERE broker_leads.broker_id='$broker_id'
ORDER BY broker_leads.created_at DESC
");

if(!$query){
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Leads - PropertyHub</title>

<script src="https://cdn.tailwindcss.com"></script>

<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        royal: "#6A0DAD",
        lightroyal: "#8A2BE2"
      }
    }
  }
}
</script>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-gray-100 overflow-x-hidden">

<!-- ✅ INCLUDE LAYOUT -->
<?php include "broker-layout.php"; ?>

<!-- ================= MAIN WRAPPER ================= -->
<div class="flex min-h-screen overflow-x-hidden">

<!-- ================= MAIN CONTENT ================= -->
<div class="flex-1 w-full md:ml-64 px-4 sm:px-6 md:px-10 py-6 box-border">

<h1 class="hidden md:block text-3xl font-bold mb-6">My Leads</h1>

<div class="bg-white p-4 sm:p-6 rounded-xl shadow border border-lightroyal max-w-full overflow-hidden">

<?php if(mysqli_num_rows($query) > 0): ?>

<!-- ================= MOBILE CARDS ================= -->
<div class="md:hidden space-y-4">
<?php while($lead = mysqli_fetch_assoc($query)): ?>

<div class="bg-gray-50 p-4 rounded-lg shadow w-full">

<p class="font-semibold truncate">
<?php echo $lead['property_title'] ?? $lead['property_name']; ?>
</p>

<p class="text-sm text-gray-500 truncate">
<?php echo $lead['client_name']; ?> • <?php echo $lead['contact']; ?>
</p>

<p class="text-xs text-gray-400 mt-1">
<?php echo date("d M Y", strtotime($lead['created_at'])); ?>
</p>

<!-- STATUS + ACTIONS -->
<div class="mt-3 space-y-2">

<span class="bg-purple-500 text-white px-2 py-1 text-xs rounded">
<?php echo $lead['status']; ?>
</span>

<div class="flex flex-wrap gap-2">

<a href="view-lead.php?id=<?php echo $lead['id']; ?>"
class="bg-purple-600 text-white px-3 py-1 rounded text-xs">
View
</a>

<?php 
$payment_status = $lead['payment_status'] ?? 'not_requested';
?>

<?php if($payment_status == 'not_requested'): ?>

<a href="request-payment.php?id=<?php echo $lead['id']; ?>"
class="bg-green-500 text-white px-3 py-1 rounded text-xs">
Request Payment
</a>

<?php elseif($payment_status == 'pending'): ?>

<span class="text-yellow-600 text-xs font-semibold">
Waiting Payment
</span>

<?php elseif($payment_status == 'paid'): ?>

<span class="text-green-600 text-xs font-bold">
Paid
</span>

<?php if($lead['status'] != 'Closed'): ?>
<a href="close-lead.php?id=<?php echo $lead['id']; ?>"
class="bg-red-500 text-white px-3 py-1 rounded text-xs">
Close
</a>
<?php endif; ?>

<?php endif; ?>

</div>
</div>

</div>

<?php endwhile; ?>
</div>

<?php mysqli_data_seek($query, 0); ?>

<!-- ================= DESKTOP TABLE ================= -->
<div class="hidden md:block w-full overflow-x-auto">
<table class="min-w-[700px] w-full text-left">

<thead>
<tr class="text-gray-500 border-b">
<th class="pb-2">Property</th>
<th class="pb-2">Client</th>
<th class="pb-2">Contact</th>
<th class="pb-2">Status</th>
<th class="pb-2">Date</th>
<th class="pb-2">Actions</th>
</tr>
</thead>

<tbody>

<?php while($lead = mysqli_fetch_assoc($query)): ?>

<tr class="border-b hover:bg-purple-50">

<td class="py-2 whitespace-nowrap"><?php echo $lead['property_title'] ?? $lead['property_name']; ?></td>
<td class="py-2 whitespace-nowrap"><?php echo $lead['client_name']; ?></td>
<td class="py-2 whitespace-nowrap"><?php echo $lead['contact']; ?></td>

<td class="py-2">
<span class="bg-purple-500 text-white px-2 py-1 text-xs rounded">
<?php echo $lead['status']; ?>
</span>
</td>

<td class="py-2 whitespace-nowrap"><?php echo date("d M Y", strtotime($lead['created_at'])); ?></td>

<td class="py-2 whitespace-nowrap">

<a href="view-lead.php?id=<?php echo $lead['id']; ?>"
class="bg-red-600 text-white px-2 py-1 rounded text-sm mr-2">
View
</a>

<?php 
$payment_status = $lead['payment_status'] ?? 'not_requested';
?>

<?php if($payment_status == 'not_requested'): ?>

<a href="request-payment.php?id=<?php echo $lead['id']; ?>"
class="bg-green-500 text-white px-2 py-1 rounded">
Request Payment
</a>

<?php elseif($payment_status == 'pending'): ?>

<span class="text-yellow-600">Waiting</span>

<?php elseif($payment_status == 'paid'): ?>

<span class="text-green-600 font-bold">Paid</span>

<?php if($lead['status'] != 'Closed'): ?>
<a href="close-lead.php?id=<?php echo $lead['id']; ?>"
class="bg-red-500 text-white px-2 py-1 rounded ml-2">
Close
</a>
<?php endif; ?>

<?php endif; ?>

</td>

</tr>

<?php endwhile; ?>

</tbody>
</table>
</div>

<?php else: ?>

<div class="text-center text-gray-500 py-10">
No leads found
</div>

<?php endif; ?>

</div>

</div>

</div>

</body>
</html>