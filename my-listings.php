<?php
session_start();
include "db.php";
include "functions.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'broker'){
    header("Location: login.html");
    exit();
}

$broker_id = $_SESSION['user_id'];

/* TOTAL NEW LISTINGS */
$newListingsQuery = $conn->prepare("
SELECT COUNT(*) as total 
FROM properties 
WHERE broker_id=? 
AND DATE(created_at)=CURDATE()
");
$newListingsQuery->bind_param("i",$broker_id);
$newListingsQuery->execute();
$newListings = $newListingsQuery->get_result()->fetch_assoc()['total'];

/* TOTAL ACTIVE LISTINGS */
$activeListingsQuery = $conn->prepare("
SELECT COUNT(*) as total 
FROM properties 
WHERE broker_id=? 
AND status='Active'
");
$activeListingsQuery->bind_param("i",$broker_id);
$activeListingsQuery->execute();
$activeListings = $activeListingsQuery->get_result()->fetch_assoc()['total'];

$sql = "SELECT * FROM properties WHERE broker_id=? ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$broker_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Listings - PropertyHub</title>

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

<!-- ✅ COMMON BROKER LAYOUT -->
<?php include "broker-layout.php"; ?>

<div class="flex-1 ml-0 md:ml-64 p-4 sm:p-6 md:p-10 max-w-full">

<div class="max-w-7xl mx-auto">

<!-- HEADER -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
<h1 class="text-2xl sm:text-3xl font-bold text-navy">My Listings</h1>
<a href="add-listing.php" class="bg-royal text-white px-5 py-2 rounded-lg hover:bg-lightroyal">
+ Add New Listing
</a>
</div>

<!-- STATS -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-10">
<div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-lightroyal">
<p class="text-gray-500 text-sm">New Listings Today</p>
<h2 class="text-2xl sm:text-3xl font-bold text-royal mt-2"><?php echo $newListings; ?></h2>
</div>

<div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-green-400">
<p class="text-gray-500 text-sm">Active Listings</p>
<h2 class="text-2xl sm:text-3xl font-bold text-green-600 mt-2"><?php echo $activeListings; ?></h2>
</div>
</div>

<!-- PROPERTY GRID -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

<?php if($result->num_rows > 0): ?>
<?php while($row = $result->fetch_assoc()) { ?>

<?php 
$first_img = "";

/* STEP 1: CLEAN IMAGES ARRAY */
if(!empty($row['images'])){
    $imgs = explode(",", $row['images']);

    foreach($imgs as $img){
        if(trim($img) != ""){
            $first_img = trim($img);
            break; // take FIRST VALID image
        }
    }
}

/* STEP 2: CHECK OLD SINGLE IMAGE */
if(empty($first_img) && !empty($row['image']) && trim($row['image']) != ""){
    $first_img = $row['image'];
}

/* STEP 3: FINAL FALLBACK */
if(empty($first_img)){
    switch($row['property_type']){
        case "Villa":
            $first_img = "https://images.pexels.com/photos/259588/pexels-photo-259588.jpeg";
            break;

        case "Apartment":
            $first_img = "https://images.pexels.com/photos/439391/pexels-photo-439391.jpeg";
            break;

        case "House":
            $first_img = "https://images.pexels.com/photos/106399/pexels-photo-106399.jpeg";
            break;

        case "Office":
            $first_img = "https://images.pexels.com/photos/37347/office-sitting-room-executive-sitting.jpg";
            break;

        case "Plot":   
            $first_img = "https://images.pexels.com/photos/440731/pexels-photo-440731.jpeg";
            break;

        default:
            $first_img = "https://via.placeholder.com/400x300?text=No+Image";
    }
}
?>
<div class="bg-white rounded-xl shadow-md overflow-hidden border border-lightroyal relative hover:scale-105 transition duration-300">

<!-- STATUS -->
<span class="absolute top-3 left-3 px-3 py-1 text-xs rounded-full shadow 
<?php echo $row['status']=="Sold" ? 'bg-red-100 text-red-600':'bg-green-100 text-green-600'; ?>">
<?php echo $row['status']; ?>
</span>

<!-- LISTING TYPE -->
<?php if(!empty($row['listing_type'])){ ?>
    <?php if($row['listing_type'] == 'Rent'){ ?>
        <span class="absolute top-3 right-3 bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full shadow font-semibold">
            For Rent
        </span>
    <?php } else { ?>
        <span class="absolute top-3 right-3 bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full shadow font-semibold">
            For Sale
        </span>
    <?php } ?>
<?php } ?>

<!-- IMAGE -->
<div class="h-48 overflow-hidden">
    <img src="<?php echo $first_img; ?>" class="w-full h-full object-cover">
</div>


<div class="p-4">

<h3 class="text-lg font-semibold text-royal truncate">
<?php echo $row['title']; ?>
</h3>

<p class="text-sm text-gray-500 mt-1 truncate">
<?php echo $row['location']; ?>
</p>

<p class="text-navy font-bold mt-3">
₹ <?php echo formatPrice($row['price']); ?>
</p>

<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mt-5">

<div class="flex gap-2">
<a href="edit-listing.php?id=<?php echo $row['id']; ?>" 
class="bg-green-300 px-3 py-1 rounded-lg text-sm hover:bg-green-200 text-green-600">
Edit
</a>

<a href="delete-listing.php?id=<?php echo $row['id']; ?>" 
onclick="return confirm('Delete this listing?')" 
class="bg-red-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-red-600">
Delete
</a>
</div>

<a href="view-listing.php?id=<?php echo $row['id']; ?>" 
class="bg-royal text-white px-3 py-1 rounded-lg text-sm hover:bg-lightroyal text-center">
View
</a>

</div>

</div>

</div>

<?php } ?>
<?php else: ?>

<div class="col-span-full text-center py-10 text-gray-500">
You haven’t added any listings yet.<br>
<a href="add-listing.php" class="text-royal font-semibold hover:underline">
Add your first listing
</a>
</div>

<?php endif; ?>

</div>

</div>
</div>

</body>
</html>