<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

include "db.php";
include "functions.php";

$username = $_SESSION['user_name'];
$user_id = $_SESSION['user_id'];

/* Recently Viewed Properties */
$sql = "
SELECT p.*
FROM viewed_properties vp
LEFT JOIN properties p 
ON vp.property_id = p.id
WHERE vp.user_id = '$user_id'
ORDER BY vp.viewed_at DESC
LIMIT 3
";

$result = $conn->query($sql);

/* Count saved properties */
$count_sql = "SELECT COUNT(*) AS total_saved 
              FROM saved_properties 
              WHERE user_id='$user_id'";

$count_result = $conn->query($count_sql);
$count_row = $count_result->fetch_assoc();
$total_saved = $count_row['total_saved'];

/* Count enquiries */
$sql = "
SELECT
(
SELECT COUNT(*) FROM inquiries WHERE user_id = '$user_id'
)
+
(
SELECT COUNT(*) FROM broker_leads WHERE user_id = '$user_id'
)
AS total_enquiries
";

$enquiry_result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($enquiry_result);
$total_enquiries = $data['total_enquiries'];

/* New listings */
$new_sql = "SELECT COUNT(*) AS total_new 
            FROM properties 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";

$new_result = $conn->query($new_sql);
$new_row = $new_result->fetch_assoc();
$total_new = $new_row['total_new'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Dashboard</title>

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

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}
.animate-fadeIn {
    animation: fadeIn 0.3s ease;
}
body.menu-open {
    overflow: hidden;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-white text-navy">

<!-- ✅ COMMON NAVBAR + SIDEBAR -->
<?php include "user-layout.php"; ?>

<!-- ================= MAIN WRAPPER ================= -->
<div class="flex min-h-screen overflow-x-hidden">

<!-- ================= MAIN CONTENT ================= -->
<div class="flex-1 w-full md:ml-64 px-4 sm:px-6 md:px-10 py-6">

<h1 class="text-2xl md:text-3xl font-bold text-royal mb-2">
Welcome Back, <?php echo $username; ?> 👋
</h1>

<p class="text-gray-600 mb-8">
Here’s what’s happening with your account today.
</p>

<!-- Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-10">

<div class="bg-card p-4 sm:p-6 rounded-xl shadow">
<h3 class="text-gray-600">Saved Properties</h3>
<p class="text-2xl font-bold text-royal mt-2"><?php echo $total_saved; ?></p>
</div>

<div class="bg-card p-4 sm:p-6 rounded-xl shadow">
<h3 class="text-gray-600">My Enquiries</h3>
<p class="text-2xl font-bold text-royal mt-2"><?php echo $total_enquiries; ?></p>
</div>

<div class="bg-card p-4 sm:p-6 rounded-xl shadow">
<h3 class="text-gray-600">New Listings</h3>
<p class="text-2xl font-bold text-royal mt-2"><?php echo $total_new; ?></p>
</div>

</div>

<!-- Recently Viewed -->
<h2 class="text-2xl font-bold text-royal mb-6">
Recently Viewed Properties
</h2>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-10">

<?php if ($result && $result->num_rows > 0) { ?>
<?php while ($row = $result->fetch_assoc()) { ?>

<div class="bg-card rounded-xl shadow-lg overflow-hidden border">

<?php
$img = "";

/* MULTIPLE IMAGES */
if(!empty($row['images'])){
    $arr = array_filter(array_map('trim', explode(",", $row['images'])));
    if(!empty($arr)){
        $img = $arr[0];
    }
}

/* FALLBACK SINGLE IMAGE */
if(empty($img) && !empty($row['image'])){
    $img = $row['image'];
}

/* FINAL FALLBACK */
if(empty($img)){
    $img = "https://via.placeholder.com/400x300?text=No+Image";
}
?>

<img src="<?php echo $img; ?>" 
class="h-40 sm:h-48 md:h-56 w-full object-cover">

<div class="p-4 sm:p-5">

<h3 class="text-lg font-bold mb-2"><?php echo $row['title']; ?></h3>

<p class="text-royal font-semibold mb-2">
₹ <?php echo formatPrice($row['price']); ?>
</p>

<p class="text-gray-600 mb-4"><?php echo $row['location']; ?></p>

<a href="property-details.php?id=<?php echo $row['id']; ?>" 
class="inline-block w-full sm:w-auto text-center bg-royal text-white px-6 py-3 rounded-lg hover:bg-lightroyal">
View
</a>

</div>
</div>

<?php } ?>
<?php } else { ?>
<p class="text-gray-500">No recently viewed properties yet.</p>
<?php } ?>

</div>

<a href="property-listing.php" 
class="inline-block w-full sm:w-auto text-center bg-royal text-white px-6 py-3 rounded-lg hover:bg-lightroyal">
Browse Properties
</a>

</div>
</div>

</body>
</html>