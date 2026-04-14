<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

include "db.php";
include "functions.php";

$user_id = $_SESSION['user_id'];

$city = isset($_GET['city']) ? $_GET['city'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';
$price = isset($_GET['price']) ? $_GET['price'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$listing_type = isset($_GET['listing_type']) ? $_GET['listing_type'] : '';

$sql = "SELECT * FROM properties WHERE 1=1";
$params = [];
$types = "";

/* SEARCH */
if(!empty($city)){
    $sql .= " AND LOWER(TRIM(location)) LIKE LOWER(TRIM(?))";
    $searchTerm = "%".trim($city)."%";
    $params[] = $searchTerm;
    $types .= "s";
}

/* FILTERS */
if(!empty($type)){
    $sql .= " AND LOWER(TRIM(property_type)) = LOWER(TRIM(?))";
    $params[] = $type;
    $types .= "s";
}

/* LISTING TYPE FILTER */
if(!empty($listing_type)){
    $sql .= " AND LOWER(TRIM(listing_type)) = LOWER(TRIM(?))";
    $params[] = $listing_type;
    $types .= "s";
}

if(!empty($price)){
    if($price == "1"){
        $sql .= " AND price < ?";
        $params[] = 5000000;
        $types .= "i";
    }
    if($price == "2"){
        $sql .= " AND price BETWEEN ? AND ?";
        $params[] = 5000000;
        $params[] = 10000000;
        $types .= "ii";
    }
    if($price == "3"){
        $sql .= " AND price > ?";
        $params[] = 10000000;
        $types .= "i";
    }
}

/* SORT */
if($sort == "latest"){ $sql .= " ORDER BY id DESC"; }
if($sort == "low"){ $sql .= " ORDER BY price ASC"; }
if($sort == "high"){ $sql .= " ORDER BY price DESC"; }

$stmt = $conn->prepare($sql);

if(!empty($params)){
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Browse Properties</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

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

<body class="bg-white text-navy flex flex-col min-h-screen overflow-x-hidden">

<!-- NAVBAR -->
<div id="navbar-container"></div>

<main class="flex-grow">

<div class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-10">


<form method="GET" action="">
<div class="bg-card p-4 sm:p-6 rounded-xl shadow-md mb-10 border border-lightroyal relative">
<!-- ✅ Responsive Filters -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">

<input type="text" name="city" placeholder="Search by city..."
value="<?php echo htmlspecialchars($city); ?>"
class="w-full p-3 rounded border border-gray-300 focus:ring-2 focus:ring-royal text-sm sm:text-base">

<div class="w-full overflow-hidden">
<select name="type"
class="w-full p-3 rounded border border-gray-300 focus:ring-2 focus:ring-royal text-sm sm:text-base appearance-none bg-white">
<option value="">Property Type</option>
<option value="Apartment" <?php if($type=="Apartment") echo "selected"; ?>>Apartment</option>
<option value="Villa" <?php if($type=="Villa") echo "selected"; ?>>Villa</option>
<option value="Plot" <?php if($type=="Plot") echo "selected"; ?>>Plot</option>
<option value="House" <?php if($type=="House") echo "selected"; ?>>Houses</option>
<option value="Office" <?php if($type=="Office") echo "selected"; ?>>Offices</option>
</select>
</div>

<div class="w-full overflow-hidden">
<select name="listing_type"
class="w-full p-3 rounded border border-gray-300 focus:ring-2 focus:ring-royal text-sm sm:text-base appearance-none bg-white">
<option value="">Listing Type</option>
<option value="Rent" <?php if($listing_type=="Rent") echo "selected"; ?>>For Rent</option>
<option value="Sale" <?php if($listing_type=="Sale") echo "selected"; ?>>For Sale</option>
</select>
</div>

<div class="w-full overflow-hidden">
<select name="price" class="w-full p-3 rounded border border-gray-300 focus:ring-2 focus:ring-royal text-sm sm:text-base appearance-none bg-white">
<option value="">Price Range</option>
<option value="1" <?php if($price=="1") echo "selected"; ?>>Under 80 Lakh</option>
<option value="2" <?php if($price=="2") echo "selected"; ?>>80 Lakh - 1.5 Cr</option>
<option value="3" <?php if($price=="3") echo "selected"; ?>>1.5 Cr+</option>
</select>
</div>

<div class="w-full overflow-hidden">
<select name="sort" class="w-full p-3 rounded border border-gray-300 focus:ring-2 focus:ring-royal text-sm sm:text-base appearance-none bg-white">
<option value="">Sort By</option>
<option value="latest" <?php if($sort=="latest") echo "selected"; ?>>Latest</option>
<option value="low" <?php if($sort=="low") echo "selected"; ?>>Price Low-High</option>
<option value="high" <?php if($sort=="high") echo "selected"; ?>>Price High-Low</option>
</select>
</div>

<button type="submit" class="bg-royal text-white rounded p-3 hover:bg-lightroyal transition text-sm sm:text-base">
Search
</button>

</div>
</div>
</form>

<!-- ✅ Responsive Property Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

<?php if($result && $result->num_rows > 0){ ?>

<?php while($row = $result->fetch_assoc()) { 

$property_id = $row['id'];

$check = "SELECT * FROM saved_properties 
          WHERE user_id='$user_id' AND property_id='$property_id'";

$saved = $conn->query($check);
$isSaved = $saved->num_rows > 0;
?>

<div class="bg-white rounded-xl shadow-lg overflow-hidden hover:scale-105 transition duration-300 relative">

<!-- OWNER / BROKER BADGE -->
<?php if(!empty($row['owner_id'])){ ?>
<span class="absolute top-3 left-3 bg-green-500 text-white text-xs px-3 py-1 rounded-full shadow">
Owner Listed
</span>
<?php } ?>

<?php if(!empty($row['broker_id'])){ ?>
<span class="absolute top-3 left-3 bg-blue-500 text-white text-xs px-3 py-1 rounded-full shadow">
Broker Listed
</span>
<?php } ?>

<!-- BADGES -->

<?php if($row['status'] == 'Sold'){ ?>

    <!-- 🔴 SOLD (LEFT SIDE) -->
    <span class="absolute top-3 left-3 bg-red-100 text-red-600 text-xs px-7 py-1 rounded-full shadow font-semibold z-20">
        🔴 Sold
    </span>

<?php } else { ?>

    <!-- 🟢 OWNER / 🔵 BROKER (LEFT SIDE) -->
    <?php if(!empty($row['owner_id'])){ ?>
        <span class="absolute top-3 left-3 bg-green-500 text-white text-xs px-3 py-1 rounded-full shadow">
            Owner Listed
        </span>
    <?php } ?>

    <?php if(!empty($row['broker_id'])){ ?>
        <span class="absolute top-3 left-3 bg-blue-500 text-white text-xs px-3 py-1 rounded-full shadow">
            Broker Listed
        </span>
    <?php } ?>

    <!-- 🔵🟢 LISTING TYPE (RIGHT SIDE) -->
    <?php if(!empty($row['listing_type'])){ ?>
        <?php if($row['listing_type'] == 'Rent'){ ?>
            <span class="absolute top-3 right-3 sm:right-14 bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full shadow font-semibold">
                For Rent
            </span>
        <?php } else { ?>
            <span class="absolute top-3 right-3 sm:right-14 bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full shadow font-semibold">
                For Sale
            </span>
        <?php } ?>
    <?php } ?>

<?php } ?>

<!-- ❤️ Save Button -->
<a href="save-property.php?id=<?php echo $row['id']; ?>"
class="absolute top-3 right-3 bg-white p-2 rounded-full shadow z-20
<?php echo $isSaved ? 'text-red-500' : 'text-royal'; ?>">
<i class="fa-solid fa-heart"></i>
</a>

<?php 
$first_img = "";

if(!empty($row['images'])){
    $imgs = explode(",", $row['images']);
    $first_img = trim($imgs[0]);
}

if(empty($first_img)){
    $first_img = $row['image'];
}
?>

<img src="<?php echo $first_img; ?>" 
class="w-full h-44 sm:h-48 object-cover">

<div class="p-4">

<h2 class="text-lg sm:text-xl font-semibold">
<?php echo $row['title']; ?>
</h2>

<p class="text-gray-500 text-sm mt-1">
📍 <?php echo $row['location']; ?>
</p>

<!-- ✅ UPDATED PRICE -->
<p class="text-royal font-bold text-base sm:text-lg mt-2">
<?php if(isset($row['listing_type']) && $row['listing_type'] == 'Rent'){ ?>
    ₹ <?php echo formatPrice($row['price']); ?> / month
<?php } else { ?>
    ₹ <?php echo formatPrice($row['price']); ?>
<?php } ?>
</p>

<div class="flex justify-between mt-4">

<a href="property-details.php?id=<?php echo $row['id']; ?>"
class="bg-royal text-white px-4 py-2 rounded hover:bg-lightroyal transition text-sm sm:text-base">
View
</a>

</div>

</div>

</div>

<?php } ?>

<?php } else { ?>

<div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-10">

<h2 class="text-xl sm:text-2xl font-semibold text-gray-600">
No Properties Found
</h2>

<p class="text-gray-400 mt-2 text-sm sm:text-base">
Try searching with different filters.
</p>

</div>

<?php } ?>

</div>

</div>

</main>

<!-- FOOTER -->
<div id="footer-container"></div>

<script src="js/loadNavbar.js"></script>
<script src="js/loadFooter.js"></script>

</body>
</html>