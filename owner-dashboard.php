<?php
session_start();

include "db.php";
include "functions.php";

$owner_id = $_SESSION['user_id'];

/* ================= SECURITY ================= */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

if ($_SESSION['role'] != 'owner') {
    header("Location: login.html");
    exit();
}

$username = $_SESSION['user_name'];

/* ================= DASHBOARD STATS ================= */

$totalInquiryQuery = mysqli_query($conn, "
SELECT COUNT(*) as total 
FROM inquiries 
WHERE owner_id='$owner_id'
");
$totalInquiries = mysqli_fetch_assoc($totalInquiryQuery)['total'];

$totalPropertiesQuery = mysqli_query($conn, "
SELECT COUNT(*) as total 
FROM properties 
WHERE owner_id='$owner_id'
");
$totalProperties = mysqli_fetch_assoc($totalPropertiesQuery)['total'];

$activeQuery = mysqli_query($conn, "
SELECT COUNT(*) as total 
FROM properties 
WHERE owner_id='$owner_id' AND status='Active'
");
$activeListings = mysqli_fetch_assoc($activeQuery)['total'];

$earningsQuery = mysqli_query($conn, "
SELECT SUM(amount) as total
FROM earnings
WHERE owner_id='$owner_id'
AND status='completed'
AND MONTH(created_at) = MONTH(CURRENT_DATE())
AND YEAR(created_at) = YEAR(CURRENT_DATE())
");
$earnings = mysqli_fetch_assoc($earningsQuery)['total'];
if (!$earnings) $earnings = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Owner Dashboard - PropertyHub</title>

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

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}
.animate-fadeIn {
    animation: fadeIn 0.3s ease;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-gray-100 overflow-x-hidden">

<?php include "owner-layout.php"; ?>

<!-- ================= MAIN WRAPPER ================= -->
<div class="flex min-h-screen">

<!-- ================= MAIN CONTENT ================= -->
<div class="flex-1 w-full md:ml-64 px-4 sm:px-6 md:px-10 py-6">

<div class="max-w-7xl mx-auto">

<!-- Header -->
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 sm:mb-8 gap-3">
<h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-navy">
Welcome, <?php echo $username; ?> 👋
</h1>
</div>

<!-- ================= STATS ================= -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">

<div class="bg-white p-4 sm:p-6 rounded-xl shadow-md border border-lightroyal">
<h3 class="text-gray-500 text-sm sm:text-base">Total Properties</h3>
<p class="text-xl sm:text-2xl font-bold text-royal mt-2">
<?php echo $totalProperties; ?>
</p>
</div>

<div class="bg-white p-4 sm:p-6 rounded-xl shadow-md border border-lightroyal">
<h3 class="text-gray-500 text-sm sm:text-base">Active Listings</h3>
<p class="text-xl sm:text-2xl font-bold text-royal mt-2">
<?php echo $activeListings; ?>
</p>
</div>

<div class="bg-white p-4 sm:p-6 rounded-xl shadow-md border border-lightroyal">
<h3 class="text-gray-500 text-sm sm:text-base">Total Inquiries</h3>
<p class="text-xl sm:text-2xl font-bold text-royal mt-2">
<?php echo $totalInquiries; ?>
</p>
</div>

<div class="bg-white p-4 sm:p-6 rounded-xl shadow-md border border-lightroyal">
<h3 class="text-gray-500 text-sm sm:text-base">Monthly Earnings</h3>
<p class="text-xl sm:text-2xl font-bold text-green-600 mt-2">
₹ <?php echo formatPrice($earnings); ?>
</p>
</div>

</div>

<!-- ================= TABLE ================= -->
<div class="mt-8 sm:mt-10 bg-white p-4 sm:p-6 rounded-xl shadow-md border border-lightroyal">

<h2 class="text-lg sm:text-xl font-semibold mb-4 text-navy">
My Properties
</h2>

<div class="overflow-x-auto">
<table class="min-w-[700px] w-full text-left">

<thead>
<tr class="text-gray-500 border-b text-sm sm:text-base">
<th class="pb-3">Property</th>
<th class="pb-3">Location</th>
<th class="pb-3">Price</th>
<th class="pb-3">Status</th>
<th class="pb-3">Actions</th>
</tr>
</thead>

<tbody>

<?php
$properties = mysqli_query($conn, "
SELECT * FROM properties
WHERE owner_id='$owner_id'
ORDER BY id DESC
LIMIT 5
");

while ($row = mysqli_fetch_assoc($properties)) {
?>

<tr class="border-b text-sm sm:text-base">

<td class="py-3 font-medium whitespace-nowrap">
<?php echo $row['title']; ?>
</td>

<td class="whitespace-nowrap"><?php echo $row['location']; ?></td>

<td>₹ <?php echo formatPrice($row['price']); ?></td>

<td>
<?php if ($row['status'] == "Active") { ?>
<span class="bg-green-100 text-green-600 px-3 py-1 text-xs rounded-full">Active</span>
<?php } elseif ($row['status'] == "Sold") { ?>
<span class="bg-red-100 text-red-600 px-3 py-1 text-xs rounded-full">Sold</span>
<?php } else { ?>
<span class="bg-yellow-100 text-yellow-600 px-3 py-1 text-xs rounded-full">Pending</span>
<?php } ?>
</td>

<td class="space-x-2 whitespace-nowrap">
<a href="editproperty.php?id=<?php echo $row['id']; ?>" 
class="bg-royal text-white px-3 py-1 rounded-lg text-xs sm:text-sm">
Edit
</a>

<a href="deleteproperty.php?id=<?php echo $row['id']; ?>" 
class="bg-red-500 text-white px-3 py-1 rounded-lg text-xs sm:text-sm">
Delete
</a>
</td>

</tr>

<?php } ?>

</tbody>
</table>
</div>

</div>

<!-- ================= RECENT INQUIRIES ================= -->
<div class="mt-8 sm:mt-10 bg-white p-4 sm:p-6 rounded-xl shadow-md border border-lightroyal">

<h2 class="text-lg sm:text-xl font-semibold mb-4 text-navy">
Recent Inquiries
</h2>

<?php
$inquiries = mysqli_query($conn, "
SELECT * FROM inquiries
WHERE owner_id='$owner_id'
ORDER BY created_at DESC
LIMIT 3
");

while ($inq = mysqli_fetch_assoc($inquiries)) {
?>

<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center p-4 bg-gray-50 rounded-lg mb-3 gap-2">

<div>
<p class="font-semibold text-sm sm:text-base">
<?php echo $inq['customer_name']; ?>
</p>

<p class="text-xs sm:text-sm text-gray-500">
Interested in <?php echo $inq['property_name']; ?>
</p>

<p class="text-xs sm:text-sm text-gray-400">
Message: <?php echo $inq['message']; ?>
</p>
</div>

</div>

<?php } ?>

</div>

</div>
</div>
</div>

</body>
</html>