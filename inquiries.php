<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

if($_SESSION['role'] != 'owner'){
    header("Location: login.html");
    exit();
}

$username = $_SESSION['user_name'];
$owner_id = $_SESSION['user_id'];

/* ================= FETCH COUNTS ================= */

$totalQuery = mysqli_query($conn,"SELECT COUNT(*) as total FROM inquiries WHERE owner_id='$owner_id'");
$total = mysqli_fetch_assoc($totalQuery)['total'];

$newQuery = mysqli_query($conn,"SELECT COUNT(*) as total FROM inquiries WHERE owner_id='$owner_id' AND status='New'");
$new = mysqli_fetch_assoc($newQuery)['total'];

$contactedQuery = mysqli_query($conn,"SELECT COUNT(*) as total FROM inquiries WHERE owner_id='$owner_id' AND status='Contacted'");
$contacted = mysqli_fetch_assoc($contactedQuery)['total'];

/* ================= FETCH INQUIRIES ================= */

$inquiries = mysqli_query($conn,"
SELECT * FROM inquiries 
WHERE owner_id='$owner_id'
ORDER BY created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inquiries - PropertyHub</title>

<script src="https://cdn.tailwindcss.com"></script>

<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        navy: "#0A192F",
        deepnavy: "#112240",
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

<body class="bg-gray-100 overflow-x-hidden">

<?php include "owner-layout.php"; ?>

<!-- ✅ IMPORTANT WRAPPER -->
<div class="flex">

<!-- ================= MAIN CONTENT ================= -->
<div class="flex-1 md:ml-64 w-full min-w-0">

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-6">

<!-- HEADER -->
<div class="mb-8">
<h1 class="text-2xl sm:text-3xl font-bold text-navy">
Property Inquiries
</h1>
<p class="text-gray-500 mt-2 text-sm sm:text-base">
Manage and respond to potential buyers.
</p>
</div>

<!-- CARDS -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">

<div class="bg-white p-6 rounded-xl shadow-md border border-lightroyal">
<h3 class="text-gray-500 text-sm">Total Inquiries</h3>
<p class="text-3xl font-bold text-royal mt-3"><?php echo $total; ?></p>
</div>

<div class="bg-white p-6 rounded-xl shadow-md border border-lightroyal">
<h3 class="text-gray-500 text-sm">New</h3>
<p class="text-3xl font-bold text-green-600 mt-3"><?php echo $new; ?></p>
</div>

<div class="bg-white p-6 rounded-xl shadow-md border border-lightroyal">
<h3 class="text-gray-500 text-sm">Contacted</h3>
<p class="text-3xl font-bold text-yellow-500 mt-3"><?php echo $contacted; ?></p>
</div>

</div>

<!-- ================= INQUIRIES ================= -->
<div class="bg-white p-5 sm:p-6 rounded-xl shadow-md border border-lightroyal">

<h2 class="text-xl font-semibold mb-6 text-navy">
Recent Inquiries
</h2>

<div class="space-y-5">

<?php while($row = mysqli_fetch_assoc($inquiries)){ ?>

<div class="p-5 bg-gray-50 rounded-lg 
flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4
hover:shadow-md transition">

<!-- LEFT -->
<div class="flex-1">

<p class="font-semibold text-navy text-base">
<?php echo $row['customer_name']; ?>
</p>

<p class="text-sm text-gray-500 mt-1">
Interested in: <?php echo $row['property_name']; ?>
</p>

<?php if($row['phone']){ ?>
<p class="text-sm text-gray-400 mt-1">
📞 <?php echo $row['phone']; ?>
</p>
<?php } ?>

<p class="text-sm text-gray-400 mt-1">
💬 <?php echo $row['message']; ?>
</p>

<?php if($row['email']){ ?>
<p class="text-sm text-gray-400 mt-1">
📧 <?php echo $row['email']; ?>
</p>
<?php } ?>

</div>

<!-- RIGHT -->
<div class="flex flex-wrap gap-2 items-center mt-3 md:mt-0">

<?php if($row['status'] == "New"): ?>

<span class="bg-green-100 text-green-600 px-3 py-1 text-xs rounded-full">
New
</span>

<form action="update-inquiry.php" method="POST">
<input type="hidden" name="inquiry_id" value="<?php echo $row['id']; ?>">

<button type="submit"
class="bg-yellow-500 text-white px-3 py-1 rounded-lg text-xs sm:text-sm">
Mark Contacted
</button>
</form>

<?php elseif($row['status'] == "Contacted"): ?>

<span class="bg-yellow-100 text-yellow-600 px-3 py-1 text-xs rounded-full">
Contacted
</span>

<?php 
$payment_status = $row['payment_status'] ?? 'not_requested';
?>

<?php if($payment_status == 'pending'): ?>
<span class="text-yellow-500 text-sm">Waiting Payment</span>

<?php elseif($payment_status == 'paid'): ?>

<span class="text-green-600 font-bold text-sm">💰 Paid</span>

<form action="complete-deal.php" method="POST">
<input type="hidden" name="property_id" value="<?php echo $row['property_id']; ?>">
<input type="hidden" name="inquiry_id" value="<?php echo $row['id']; ?>">

<button type="submit"
class="bg-green-600 text-white px-3 py-1 rounded-lg text-xs sm:text-sm">
Complete Deal
</button>
</form>

<?php else: ?>
<span class="text-gray-400 text-sm">No Payment Yet</span>
<?php endif; ?>

<?php elseif($row['status'] == "Completed"): ?>

<span class="bg-green-600 text-white px-3 py-1 text-xs rounded-full">
Completed
</span>

<?php endif; ?>

</div>

</div>

<?php } ?>

</div>
</div>

</div>
</div>

</body>
</html>