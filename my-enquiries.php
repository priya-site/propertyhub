<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

include "db.php";

$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '';

$user_id = $_SESSION['user_id'];

/* FETCH ENQUIRIES */
$enquiry_sql = "
SELECT id, property_name, message, status, created_at, 'Owner' AS type, payment_status, property_id
FROM inquiries
WHERE user_id=?

UNION ALL

SELECT id, property_name, message, status, created_at, 'Broker' AS type, payment_status, property_id
FROM broker_leads
WHERE user_id=?

ORDER BY created_at DESC
";

$stmt = $conn->prepare($enquiry_sql);
$stmt->bind_param("ii",$user_id,$user_id);
$stmt->execute();
$enquiries = $stmt->get_result();

/* COUNTS */
$total_sql = "
SELECT 
(
SELECT COUNT(*) FROM inquiries WHERE user_id=?
)
+
(
SELECT COUNT(*) FROM broker_leads WHERE user_id=?
)
AS total
";

$stmt = $conn->prepare($total_sql);
$stmt->bind_param("ii",$user_id,$user_id);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()['total'];

$pending_sql = "
SELECT
(
SELECT COUNT(*) FROM inquiries WHERE user_id=? AND status='New'
)
+
(
SELECT COUNT(*) FROM broker_leads WHERE user_id=? AND status='New'
)
AS pending
";

$stmt = $conn->prepare($pending_sql);
$stmt->bind_param("ii",$user_id,$user_id);
$stmt->execute();
$pending = $stmt->get_result()->fetch_assoc()['pending'];

$responded_sql = "
SELECT
(
SELECT COUNT(*) FROM inquiries 
WHERE user_id=? 
AND (status='Completed' OR status='Closed' OR status='Contacted')
)
+
(
SELECT COUNT(*) FROM broker_leads 
WHERE user_id=? 
AND (status='Completed' OR status='Closed' OR status='Contacted')
)
AS responded
";

$stmt = $conn->prepare($responded_sql);
$stmt->bind_param("ii",$user_id,$user_id);
$stmt->execute();
$responded = $stmt->get_result()->fetch_assoc()['responded'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Enquiries</title>

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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-white text-navy">

<!-- ✅ COMMON NAVBAR + SIDEBAR -->
<?php include "user-layout.php"; ?>

<!-- ================= MAIN WRAPPER ================= -->
<div class="flex min-h-screen overflow-x-hidden">

<!-- ================= MAIN ================= -->
<div class="flex-1 w-full md:ml-64 px-4 sm:px-6 md:px-10 py-6">

<h1 class="text-2xl sm:text-3xl font-bold text-royal mb-6">My Enquiries</h1>

<!-- STATS -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-10">

<div class="bg-card p-6 rounded-xl shadow">
<h3>Total Enquiries</h3>
<p class="text-2xl sm:text-3xl font-bold text-royal mt-2"><?php echo $total; ?></p>
</div>

<div class="bg-card p-6 rounded-xl shadow">
<h3>Pending</h3>
<p class="text-2xl sm:text-3xl font-bold text-yellow-500 mt-2"><?php echo $pending; ?></p>
</div>

<div class="bg-card p-6 rounded-xl shadow">
<h3>Responded</h3>
<p class="text-2xl sm:text-3xl font-bold text-green-500 mt-2"><?php echo $responded; ?></p>
</div>

</div>

<!-- TABLE -->
<div class="bg-white shadow rounded-xl overflow-hidden">

<!-- SCROLL FIX -->
<div class="overflow-x-auto">

<table class="min-w-[700px] w-full text-left border-collapse">

<thead class="bg-royal text-white">
<tr>
<th class="p-2">Property</th>
<th class="p-2">Owner/Broker</th>
<th class="p-2">Message</th>
<th class="p-2">Date</th>
<th class="p-2">Status</th>
<th class="p-2">Action</th>
</tr>
</thead>

<tbody>

<?php while($row = $enquiries->fetch_assoc()){ ?>

<tr class="border-b hover:bg-gray-50 transition">

<td class="p-4 whitespace-nowrap"><?php echo $row['property_name']; ?></td>

<td class="p-4"><?php echo $row['type']; ?></td>

<td class="p-4 max-w-[200px] truncate"><?php echo $row['message']; ?></td>

<td class="p-4 whitespace-nowrap"><?php echo date("d M Y", strtotime($row['created_at'])); ?></td>

<td class="p-4">

<?php if(strtolower($row['status']) == "completed" || strtolower($row['status']) == "closed"){ ?>
<span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-sm">Responded</span>
<?php } else { ?>
<span class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full text-sm">Pending</span>
<?php } ?>

</td>

<td class="p-4 whitespace-nowrap">

<?php 
$payment_status = $row['payment_status'] ?? 'not_requested';
?>

<?php if($payment_status == 'pending'): ?>

<form action="payment.php" method="GET">
<input type="hidden" name="property_id" value="<?php echo $row['property_id']; ?>">

<?php if($row['type'] == 'Owner'): ?>
<input type="hidden" name="inquiry_id" value="<?php echo $row['id']; ?>">
<?php else: ?>
<input type="hidden" name="lead_id" value="<?php echo $row['id']; ?>">
<?php endif; ?>

<button type="submit"
class="bg-green-500 text-white px-3 py-1 rounded-lg hover:bg-green-600">
Pay Now
</button>
</form>

<?php elseif($payment_status == 'paid'): ?>
<span class="text-green-600 font-bold">Paid ✅</span>

<?php else: ?>
<span class="text-gray-400">No Action</span>
<?php endif; ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>
</div>

</body>
</html>