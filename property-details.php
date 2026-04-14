<?php
session_start();
include "db.php";
include "functions.php";

$id = isset($_GET['id']) ? $_GET['id'] : 0;

$sql = "SELECT * FROM properties WHERE id='$id'";
$result = $conn->query($sql);
$property = $result->fetch_assoc();


/* IMAGES */
$imgs = [];
if(!empty($property['images'])){
    $imgs = explode(",", $property['images']);
}

/* MAIN IMAGE */
$main_image = !empty($imgs) ? trim($imgs[0]) : $property['image'];

/* SAVE RECENT */
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $conn->query("INSERT INTO viewed_properties (user_id, property_id)
                  VALUES ('$user_id','$id')");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Property Details</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-white text-gray-800">

<!-- NAVBAR -->
<nav class="bg-white shadow-md p-4 flex justify-between">
<h1 class="text-xl font-bold text-purple-700">PropertyHub</h1>
<div>
<a href="index.php" class="mr-4">Home</a>
<a href="property-listing.php">Properties</a>
</div>
</nav>

<div class="max-w-6xl mx-auto p-6">

<?php if($property['status'] == 'Sold'){ ?>
<span class="inline-block bg-red-100 text-red-600 px-4 py-1 rounded-full text-xs sm:text-sm mb-3">
🔴 Sold
</span>
<?php } else { ?>
<span class="inline-block bg-green-100 text-green-600 px-4 py-1 rounded-full text-xs sm:text-sm mb-3">
🟢 Active
</span>
<?php } ?>

<!-- TITLE -->
<h1 class="text-3xl font-bold mb-2"><?php echo $property['title']; ?></h1>
<p class="text-gray-500 mb-6">📍 <?php echo $property['location']; ?></p>

<!-- 🔥 AIRBNB GRID -->
<div class="mb-8">
<div class="grid grid-cols-1 lg:grid-cols-4 gap-2 rounded-xl overflow-hidden">

<!-- BIG IMAGE -->
<div class="lg:col-span-2 lg:row-span-2 relative group">
<img id="mainImage"
onclick="openGallery(0)"
src="<?php echo $main_image; ?>"
class="w-full h-[260px] sm:h-[350px] lg:h-full object-cover cursor-pointer">

<?php if(isset($property['status']) && $property['status'] == 'Sold'){ ?>
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
<!-- MOBILE SCROLL -->
<div class="flex gap-2 overflow-x-auto mt-3 lg:hidden">
<?php foreach($imgs as $img){ ?>
<img src="<?php echo trim($img); ?>"
onclick="document.getElementById('mainImage').src=this.src"
class="w-32 h-24 object-cover rounded cursor-pointer">
<?php } ?>
</div>

<!-- ✅ VIDEO -->
<?php if(!empty($property['video'])){ ?>
<div class="mt-8">
<h3 class="text-xl font-semibold mb-2">Property Video</h3>

<video controls class="w-full rounded-xl shadow">
<source src="<?php echo $property['video']; ?>" type="video/mp4">
</video>
</div>
<?php } ?>

<!-- DETAILS -->
<div class="mt-8">

<p class="text-2xl font-bold text-purple-700">
₹ <?php echo formatPrice($property['price']); ?>
</p>

<div class="grid grid-cols-2 gap-4 mt-4 text-gray-600">
<div>🛏 <?php echo $property['bedrooms']; ?> Bedrooms</div>
<div>🛁 <?php echo $property['bathrooms']; ?> Bathrooms</div>
<div>📐 <?php echo $property['area']; ?></div>
<div>🚗 <?php echo $property['parking']; ?> Parking</div>
</div>

</div>

<!-- Buttons -->
<div class="mt-6">

<?php if($property['status'] == 'Sold'){ ?>

<div class="bg-gray-100 p-4 rounded-lg text-center shadow">
    <p class="text-green-600 font-semibold text-base sm:text-lg">
        ✅ This property has been sold
    </p>
    <p class="text-gray-500 mt-1 text-sm">
        📞 Contact us for similar properties
    </p>
</div>

<div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-4">

<a href="about.html"
class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 text-center">
Contact Us
</a>

<button disabled 
class="bg-gray-300 text-gray-600 px-6 py-3 rounded-lg cursor-not-allowed">
Buy Not Available
</button>

</div>

<?php } else { ?>

<div class="flex flex-col sm:flex-row gap-3 sm:gap-4">

<?php if(!empty($property['owner_id'])){ ?>
<a href="contact.php?property_id=<?php echo $property['id']; ?>&owner_id=<?php echo $property['owner_id']; ?>"
class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 text-center">
Contact Owner
</a>
<?php } ?>

<?php if(!empty($property['broker_id'])){ ?>
<a href="contact-broker.php?property_id=<?php echo $property['id']; ?>&broker_id=<?php echo $property['broker_id']; ?>"
class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 text-center">
Contact Broker
</a>
<?php } ?>

</div>

<?php } ?>

</div>

</div>

</div>

<!-- DESCRIPTION -->
<div class="mt-10 ml-8">
<h3 class="text-xl font-semibold mb-2">Description</h3>
<p class="text-gray-600"><?php echo $property['description']; ?></p>
</div>

<!-- AMENITIES -->
<div class="mt-12 ml-8">
    <h3 class="text-2xl font-semibold text-gray-800 mb-6">Amenities</h3>

    <div class="flex flex-wrap gap-4 ml-4">

    <?php
    $amenities = explode(",", $property['amenities']);

    foreach($amenities as $a){
        $amenity = trim($a);
        $icon = "fa-check"; // Default fallback icon

        switch(strtolower($amenity)){
            case "parking": $icon="fa-car"; break;
            case "gym": $icon="fa-dumbbell"; break;
            case "wifi": $icon="fa-wifi"; break;
            case "swimming pool": $icon="fa-person-swimming"; break;
            case "garden": $icon="fa-tree"; break;
            case "security": $icon="fa-shield-halved"; break;
            case "lift": $icon="fa-elevator"; break;
            case "power backup": $icon="fa-bolt"; break;
            case "ac": $icon="fa-snowflake"; break;
        }

        echo "
        <div class='flex items-center gap-3 px-5 py-3 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200'>
            <div class='flex items-center justify-center w-10 h-10 bg-blue-50 text-blue-600 rounded-lg'>
                <i class='fa-solid $icon text-lg'></i>
            </div>
            <span class='text-sm font-semibold text-gray-700'>$amenity</span>
        </div>
        ";
    }
    ?>

    </div>
</div>

<!-- BACK -->
<div class="mt-10 m-4">
<a href="property-listing.php"
class="bg-purple-700 text-white px-6 py-3 text-center rounded-lg inline-block">
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