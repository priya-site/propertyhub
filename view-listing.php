<?php
session_start();
include "db.php";
include "functions.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'broker'){
    header("Location: login.html");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM properties WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

/* ================= IMAGE HANDLING ================= */

$imgs = [];

if(!empty($row['images'])){
    $imgs = array_filter(array_map('trim', explode(",", $row['images'])));
}

/* FALLBACK */
if(empty($imgs)){
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

$imgs = array_values($imgs);

/* ✅ FIX: USE FALLBACK IF NO IMAGES */
if(!empty($imgs)){
    $main_image = $imgs[0];
} else {
    $main_image = $first_img;
    $imgs = [$first_img]; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Property Details - PropertyHub</title>

<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white text-gray-800">

<!-- NAVBAR -->
<nav class="bg-white shadow-md px-4 sm:px-6 md:px-10 py-4 flex justify-between items-center">
<h1 class="text-xl sm:text-2xl font-bold text-purple-700">PropertyHub</h1>

<div class="flex gap-4">
<a href="index.php">Home</a>
<a href="property-listing.php">Properties</a>
</div>
</nav>

<div class="max-w-6xl mx-auto px-4 py-6">

<!-- TITLE -->
<div class="mb-6">
<h1 class="text-2xl sm:text-3xl font-bold mb-2">
<?php echo $row['title']; ?>
</h1>

<p class="text-gray-500">
📍 <?php echo $row['location']; ?>
</p>
</div>

<!-- 🔥 AIRBNB GRID -->
<div class="mb-8">
<div class="grid grid-cols-1 lg:grid-cols-4 gap-2 rounded-xl overflow-hidden">

<!-- BIG IMAGE -->
<div class="lg:col-span-2 lg:row-span-2 relative group">
<img id="mainImage"
onclick="openGallery(0)"
src="<?php echo $main_image; ?>"
class="w-full h-[260px] sm:h-[350px] lg:h-full object-cover cursor-pointer">

<?php if($row['status'] == 'Sold'){ ?>
<div class="absolute inset-0 bg-black/40"></div>
<div class="absolute inset-0 flex items-center justify-center">
<span class="text-white font-bold text-3xl sm:text-5xl bg-red-600 px-6 py-2 rounded-lg">
SOLD
</span>
</div>
<?php } ?>
</div>

<!-- RIGHT GRID -->
<div class="hidden lg:grid grid-cols-2 grid-rows-2 gap-2 col-span-2">

<?php for($i=1; $i<=4; $i++){ ?>
<?php if(isset($imgs[$i])){ ?>
<div class="relative">
<img src="<?php echo $imgs[$i]; ?>"
onclick="openGallery(<?php echo $i; ?>)"
class="w-full h-full object-cover cursor-pointer">

<?php if($i == 4 && count($imgs) > 5){ ?>
<div onclick="openGallery()"
class="absolute inset-0 bg-black/50 flex items-center justify-center cursor-pointer">
<span class="text-white text-lg font-semibold">
+<?php echo count($imgs) - 5; ?> Photos
</span>
</div>
<?php } ?>

</div>
<?php } ?>
<?php } ?>

</div>

</div>
</div>

<!-- 📱 MOBILE SCROLLER -->
<div class="lg:hidden mt-4 flex gap-2 overflow-x-auto">
<?php foreach($imgs as $img){ ?>
<img src="<?php echo $img; ?>"
onclick="document.getElementById('mainImage').src=this.src"
class="w-40 h-28 object-cover rounded cursor-pointer flex-shrink-0">
<?php } ?>
</div>

<!-- 🎥 VIDEO -->
<?php if(!empty($row['video'])){ ?>
<div class="mt-8">
<h3 class="text-xl font-semibold mb-3">Property Video</h3>

<video controls class="w-full h-[250px] sm:h-[400px] object-cover rounded-xl">
<source src="<?php echo $row['video']; ?>" type="video/mp4">
</video>
</div>
<?php } ?>

<!-- PRICE -->
<div class="mt-8">
<p class="text-2xl font-bold text-purple-700 mb-4">
₹ <?php echo formatPrice($row['price']); ?>
</p>

<div class="grid grid-cols-2 gap-4 text-gray-600">
<div>🛏 <?php echo $row['bedrooms']; ?> Bedrooms</div>
<div>🛁 <?php echo $row['bathrooms']; ?> Bathrooms</div>
<div>📐 <?php echo $row['area']; ?> sq ft</div>
<div>🚗 <?php echo $row['parking']; ?> Parking</div>
</div>
</div>

<!-- DESCRIPTION -->
<div class="mt-10">
<h3 class="text-xl font-semibold mb-3">Description</h3>
<p class="text-gray-600">
<?php echo !empty($row['description']) ? $row['description'] : "No description available."; ?>
</p>
</div>

<!-- AMENITIES -->
<div class="mt-10">
<h3 class="text-xl font-semibold mb-3">Amenities</h3>

<div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
<?php
if(!empty($row['amenities'])){
$amenities = explode(",", $row['amenities']);
foreach($amenities as $a){
echo "<div class='bg-gray-100 text-center py-2 rounded'>".trim($a)."</div>";
}
}
?>
</div>
</div>

<!-- BACK -->
<div class="mt-10">
<a href="my-listings.php"
class="bg-purple-700 text-white px-6 py-3 rounded-lg inline-block">
← Back
</a>
</div>

</div>

<!-- 🔥 GALLERY MODAL -->
<div id="galleryModal" class="fixed inset-0 bg-black/95 hidden z-50 flex flex-col justify-center items-center">

<span onclick="closeGallery()" class="absolute top-5 right-6 text-white text-4xl cursor-pointer">&times;</span>

<button onclick="prevImage()" class="absolute left-4 text-white text-4xl">❮</button>

<img id="galleryImage" class="max-h-[75vh] max-w-full rounded-lg">

<button onclick="nextImage()" class="absolute right-4 text-white text-4xl">❯</button>

</div>

<script>
let images = <?php echo json_encode($imgs); ?>;
let currentIndex = 0;

function openGallery(index = 0){
    currentIndex = index;
    document.getElementById("galleryModal").classList.remove("hidden");
    updateGallery();
}

function closeGallery(){
    document.getElementById("galleryModal").classList.add("hidden");
}

function updateGallery(){
    document.getElementById("galleryImage").src = images[currentIndex];
}

function nextImage(){
    currentIndex = (currentIndex + 1) % images.length;
    updateGallery();
}

function prevImage(){
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    updateGallery();
}
</script>

</body>
</html>