<?php
session_start();

include "db.php";
include "functions.php";

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
$type = isset($_GET['type']) ? $_GET['type'] : '';

$sql = "SELECT * FROM properties WHERE 1=1";
$params = [];
$types = "";

/* FILTER BY PROPERTY TYPE */

if(!empty($type)){
    $sql .= " AND LOWER(TRIM(property_type)) = LOWER(TRIM(?))";
    $params[] = $type;
    $types .= "s";
}

/* SORTING (optional) */
if(isset($_GET['sort'])){
    if($_GET['sort'] == "latest"){
        $sql .= " ORDER BY id DESC";
    } elseif($_GET['sort'] == "low"){
        $sql .= " ORDER BY price ASC";
    } elseif($_GET['sort'] == "high"){
        $sql .= " ORDER BY price DESC";
    }
}

/* EXECUTE QUERY */
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
<title><?php echo htmlspecialchars($type); ?> Properties</title>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-white text-navy flex flex-col min-h-screen">

<!-- NAVBAR -->
<div id="navbar-container"></div>

<!-- MAIN -->
<main class="flex-grow">

<div class="max-w-7xl mx-auto px-6 py-10">

<div class="text-center mb-12">

<h1 class="text-3xl md:text-4xl font-bold text-royal">
🏡 Explore Premium <?php echo htmlspecialchars($type); ?>
</h1>

<p class="text-gray-500 mt-2">
Handpicked properties just for you
</p>

</div>

<!-- GRID -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

<?php if($result && $result->num_rows > 0){ ?>

<?php while($row = $result->fetch_assoc()){ 

$property_id = $row['id'];

$check = "SELECT * FROM saved_properties 
          WHERE user_id='$user_id' AND property_id='$property_id'";

$saved = $conn->query($check);
$isSaved = $saved->num_rows > 0;
?>

<!-- CARD -->
<div class="bg-white rounded-2xl shadow-md hover:shadow-2xl transition duration-300 overflow-hidden relative group">

<!-- IMAGE -->
<div class="relative overflow-hidden">
    <?php
$first_img = "";

/* CHECK MULTIPLE IMAGES */
if(!empty($row['images'])){
    $imgs = explode(",", $row['images']);

    foreach($imgs as $img){
        if(trim($img) != ""){
            $first_img = trim($img);
            break;
        }
    }
}

/* FALLBACK TO OLD IMAGE */
if(empty($first_img) && !empty($row['image'])){
    $first_img = $row['image'];
}

/* FINAL FALLBACK */
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
    <img src="<?php echo $first_img; ?>" 
class="w-full h-52 object-cover group-hover:scale-110 transition duration-500">

    <!-- OVERLAY -->
    <div class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition"></div>
</div>

<!-- BADGES -->
<?php if(!empty($row['owner_id'])){ ?>
<span class="absolute top-4 left-4 bg-green-500 text-white text-xs px-3 py-1 rounded-full shadow">
Owner
</span>
<?php } ?>

<?php if(!empty($row['broker_id'])){ ?>
<span class="absolute top-4 left-4 bg-blue-500 text-white text-xs px-3 py-1 rounded-full shadow">
Broker
</span>
<?php } ?>

<!-- ❤️ SAVE -->
<?php if(isset($_SESSION['user_id'])){ ?>

<a href="save-property.php?id=<?php echo $row['id']; ?>"
class="absolute top-4 right-4 bg-white p-2 rounded-full shadow-md hover:scale-110 transition
<?php echo $isSaved ? 'text-red-500' : 'text-royal'; ?>">

<i class="fa-solid fa-heart"></i>
</a>

<?php } else { ?>

<a href="#"
onclick="event.preventDefault(); Swal.fire({
    title: 'Login Required',
    text: 'Please login to save property',
    icon: 'warning',
    confirmButtonColor: '#6A0DAD'
}).then(() => {
    window.location.href = 'login.html';
});"
class="absolute top-4 right-4 bg-white p-2 rounded-full shadow-md text-royal">

<i class="fa-solid fa-heart"></i>
</a>

<?php } ?>

<!-- CONTENT -->
<div class="p-5">

<h2 class="text-lg font-semibold text-navy line-clamp-1">
<?php echo $row['title']; ?>
</h2>

<p class="text-gray-500 text-sm mt-1">
📍 <?php echo $row['location']; ?>
</p>

<p class="text-royal font-bold text-lg mt-2">
₹ <?php echo formatPrice($row['price']); ?>
</p>

<!-- BUTTON -->
<div class="mt-5">

<?php if(isset($_SESSION['user_id'])){ ?>

<a href="property-details.php?id=<?php echo $row['id']; ?>"
class="bg-royal text-white px-4 py-2 rounded hover:bg-lightroyal transition">
View
</a>

<?php } else { ?>

<a href="login.html"
onclick="event.preventDefault(); Swal.fire({
    title: 'Login Required',
    text: 'Please login to view property details',
    icon: 'warning',
    confirmButtonColor: '#6A0DAD'
}).then(() => {
    window.location.href = 'login.html';
});"
class="bg-royal text-white px-4 py-2 rounded hover:bg-lightroyal transition">
View
</a>

<?php } ?>

</div>

</div>

</div>

<?php } ?>

<?php } else { ?>

<!-- EMPTY STATE -->
<div class="col-span-3 text-center py-16">

<i class="fa-solid fa-house text-5xl text-gray-300 mb-4"></i>

<h2 class="text-2xl font-semibold text-gray-600">
No <?php echo htmlspecialchars($type); ?> Available
</h2>

<p class="text-gray-400 mt-2">
New properties will appear here soon.
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