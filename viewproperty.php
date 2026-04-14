<?php
session_start();
include "db.php";
include "functions.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'owner'){
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

/* IMAGE HANDLING */
$imgs = [];
if(!empty($row['images'])){
    $imgs = explode(",", $row['images']);
}

$main_image = !empty($imgs) ? trim($imgs[0]) : "https://via.placeholder.com/800x500";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Property Details - PropertyHub</title>

<script src="https://cdn.tailwindcss.com"></script>

<script>
tailwind.config = {
theme: {
extend: {
colors: {
navy: "#0A192F",
royal: "#6A0DAD",
lightroyal: "#8A2BE2"
}
}
}
}
</script>

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

<!-- 🔥 AIRBNB IMAGE GRID -->
<div class="mb-8">
<div class="grid grid-cols-1 lg:grid-cols-4 gap-2 rounded-xl overflow-hidden">

<!-- BIG IMAGE -->
<div class="lg:col-span-2 lg:row-span-2 relative group">
<img id="mainImage"
onclick="openGallery(0)"
src="<?php echo $main_image; ?>"
class="w-full h-[260px] sm:h-[350px] lg:h-full object-cover transition duration-300 group-hover:scale-105">

<?php if($row['status'] == 'Sold'){ ?>
<div class="absolute inset-0 bg-black/40"></div>
<div class="absolute inset-0 flex items-center justify-center">
<span class="text-white font-bold text-3xl sm:text-5xl bg-red-600 px-6 py-2 rounded-lg shadow-lg">
SOLD
</span>
</div>
<?php } ?>
</div>

<!-- RIGHT GRID -->
<div class="hidden lg:grid grid-cols-2 grid-rows-2 gap-2 col-span-2">

<?php for($i=1; $i<=4; $i++){ ?>
<?php if(isset($imgs[$i])){ ?>
<div class="relative group">
<img src="<?php echo trim($imgs[$i]); ?>"
onclick="openGallery(<?php echo $i; ?>)"
class="w-full h-full object-cover cursor-pointer transition duration-300 group-hover:scale-105">

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
<img src="<?php echo trim($img); ?>"
onclick="document.getElementById('mainImage').src=this.src"
class="w-40 h-28 object-cover rounded cursor-pointer flex-shrink-0">
<?php } ?>
</div>

<!-- 🎥 VIDEO -->
<?php if(!empty($row['video'])){ ?>
<div class="mt-8">
<h3 class="text-xl font-semibold mb-3">Property Video</h3>

<div class="rounded-xl overflow-hidden shadow-lg">
<video controls class="w-full h-[250px] sm:h-[400px] object-cover">
<source src="<?php echo $row['video']; ?>" type="video/mp4">
</video>
</div>
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
<a href="myproperties.php"
class="bg-royal text-white px-6 py-3 rounded-lg inline-block hover:bg-lightroyal">
← Back
</a>
</div>

</div>

<!-- 🔥 ADVANCED GALLERY MODAL -->
<div id="galleryModal" class="fixed inset-0 bg-black/95 hidden z-50 flex flex-col justify-center items-center">

<!-- CLOSE -->
<span onclick="closeGallery()" 
class="absolute top-5 right-6 text-white text-4xl cursor-pointer z-50">&times;</span>

<!-- MAIN IMAGE -->
<div class="relative w-full flex justify-center items-center">

<button onclick="prevImage()" 
class="absolute left-4 text-white text-4xl z-50">❮</button>

<img id="galleryImage" 
class="max-h-[75vh] max-w-full rounded-lg shadow-lg transition duration-300">

<button onclick="nextImage()" 
class="absolute right-4 text-white text-4xl z-50">❯</button>

</div>

<!-- THUMBNAILS -->
<div id="thumbnailContainer"
class="flex gap-3 mt-6 overflow-x-auto px-4 w-full justify-center">

</div>

</div>

<!-- 🔥 JS -->
<script>
let images = <?php echo json_encode($imgs); ?>;
let currentIndex = 0;

function openGallery(index = 0){
    currentIndex = index;
    document.getElementById("galleryModal").classList.remove("hidden");
    updateGallery();
    renderThumbnails();
}

function closeGallery(){
    document.getElementById("galleryModal").classList.add("hidden");
}

function updateGallery(){
    document.getElementById("galleryImage").src = images[currentIndex];

    // Highlight active thumbnail
    document.querySelectorAll(".thumb").forEach((img, i) => {
        img.classList.remove("border-4","border-white");
        if(i === currentIndex){
            img.classList.add("border-4","border-white");
        }
    });
}

function nextImage(){
    currentIndex = (currentIndex + 1) % images.length;
    updateGallery();
}

function prevImage(){
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    updateGallery();
}

function renderThumbnails(){
    const container = document.getElementById("thumbnailContainer");
    container.innerHTML = "";

    images.forEach((img, index) => {
        container.innerHTML += `
            <img src="${img}" 
            onclick="openGallery(${index})"
            class="thumb w-24 h-16 object-cover rounded cursor-pointer opacity-70 hover:opacity-100">
        `;
    });
}

/* 🔥 KEYBOARD SUPPORT */
document.addEventListener("keydown", function(e){
    if(document.getElementById("galleryModal").classList.contains("hidden")) return;

    if(e.key === "ArrowRight") nextImage();
    if(e.key === "ArrowLeft") prevImage();
    if(e.key === "Escape") closeGallery();
});

/* 🔥 SWIPE SUPPORT (MOBILE) */
let startX = 0;

document.getElementById("galleryModal").addEventListener("touchstart", e => {
    startX = e.touches[0].clientX;
});

document.getElementById("galleryModal").addEventListener("touchend", e => {
    let endX = e.changedTouches[0].clientX;

    if(startX - endX > 50){
        nextImage();
    } else if(endX - startX > 50){
        prevImage();
    }
});
</script>

</body>
</html>