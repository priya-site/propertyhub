<?php
session_start();
include "db.php";
include "functions.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'broker') {
    header("Location: login.html");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM properties WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

/* ================= API FUNCTIONS ================= */

function fetchImages($query) {
    $apiKey = "BfQWWU6dH1BJwYCfd85BqHxSlctMGOlHL2EyrXSkJA0pz5MrWzRxNQgS";

    $url = "https://api.pexels.com/v1/search?query=" . urlencode($query) . "&per_page=4";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: $apiKey"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    $images = [];
    if(isset($data['photos'])){
        foreach($data['photos'] as $photo){
            $images[] = $photo['src']['medium'];
        }
    }

    return $images;
}

function fetchVideo($query){
    $apiKey = "BfQWWU6dH1BJwYCfd85BqHxSlctMGOlHL2EyrXSkJA0pz5MrWzRxNQgS";

    $url = "https://api.pexels.com/videos/search?query=" . urlencode($query) . "&per_page=1";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: $apiKey"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if(isset($data['videos'][0]['video_files'][0]['link'])){
        return $data['videos'][0]['video_files'][0]['link'];
    }

    return "";
}

/* EXISTING IMAGES */
$existing_images = [];
if(!empty($row['images'])){
    $existing_images = explode(",", $row['images']);
}

/* ================= FORM SUBMIT ================= */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $location = $_POST['location'];
    $price = (int)$_POST['price'];
    $description = $_POST['description'];

    $bedrooms = $_POST['bedrooms'];
    $bathrooms = $_POST['bathrooms'];
    $area = $_POST['area'];
    $parking = $_POST['parking'];
    $amenities = $_POST['amenities'];
    $listing_type = $_POST['listing_type'];

    $property_type = $row['property_type'];

    /* DELETE SELECTED IMAGES */
    if(isset($_POST['delete_images'])){
        $existing_images = array_diff($existing_images, $_POST['delete_images']);
    }

    /* ADD NEW IMAGES */
    if(!empty($_FILES['images']['name'][0])){
        foreach($_FILES['images']['tmp_name'] as $key => $tmp_name){

            $image_name = $_FILES['images']['name'][$key];
            $tmp = $_FILES['images']['tmp_name'][$key];

            $path = "uploads/" . uniqid() . "_" . $image_name;

            move_uploaded_file($tmp, $path);

            $existing_images[] = $path;
        }
    }

    /* 🔥 IF EMPTY → AUTO FETCH (IMPORTANT) */
    if(empty($existing_images)){

        if($property_type == "Villa"){
            $baseQuery = "luxury villa interior";
        } elseif($property_type == "Apartment"){
            $baseQuery = "modern apartment interior";
        } elseif($property_type == "House"){
            $baseQuery = "family house interior";
        } else {
            $baseQuery = strtolower($property_type) . " interior";
        }

        $existing_images = array_merge(
            fetchImages($baseQuery . " living room"),
            fetchImages($baseQuery . " kitchen"),
            fetchImages($baseQuery . " bedroom"),
            fetchImages($baseQuery . " bathroom")
        );

        $existing_images = array_slice($existing_images, 0, 10);

        if(empty($existing_images)){
            $existing_images[] = "https://via.placeholder.com/400x300";
        }
    }

    $images = implode(",", $existing_images);

    /* VIDEO */
    $video_path = $row['video'];

    if(!empty($_FILES['video']['name'])){
        $video_name = $_FILES['video']['name'];
        $tmp = $_FILES['video']['tmp_name'];

        $video_path = "uploads/" . uniqid() . "_" . $video_name;
        move_uploaded_file($tmp, $video_path);
    }

    /* 🔥 VIDEO FALLBACK */
    if(empty($video_path)){
        $video_path = fetchVideo($property_type . " home tour");
    }

    /* UPDATE */
    $sql = "UPDATE properties 
    SET title=?, location=?, price=?, description=?, 
    images=?, video=?, bedrooms=?, bathrooms=?, area=?, parking=?, amenities=?, listing_type=? 
    WHERE id=?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssisssiissssi",
        $title,
        $location,
        $price,
        $description,
        $images,
        $video_path,
        $bedrooms,
        $bathrooms,
        $area,
        $parking,
        $amenities,
        $listing_type,
        $id
    );

    $stmt->execute();

    header("Location: my-listings.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Listing - PropertyHub</title>

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

<body class="bg-gray-100 min-h-screen flex flex-col">

<!-- NAVBAR -->
<nav class="bg-white shadow-md px-4 sm:px-6 md:px-10 py-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
<h1 class="text-xl sm:text-2xl font-bold text-purple-700">PropertyHub</h1>

<div class="flex flex-wrap gap-3 sm:gap-6 text-sm sm:text-base">
<a href="index.php">Home</a>
<a href="property-listing.php">Properties</a>
<a href="my-listings.php">My Listing</a>
</div>
</nav>

<!-- FORM -->
<div class="flex-1 flex justify-center items-start mt-8 px-4">
<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-xl border border-lightroyal">

<h2 class="text-2xl font-bold text-navy mb-6 text-center">
Edit Listing
</h2>

<form method="POST" enctype="multipart/form-data" class="space-y-4">

<!-- TITLE -->
<input type="text" name="title" value="<?php echo $row['title']; ?>" class="w-full border rounded-lg px-4 py-2">

<!-- PROPERTY TYPE -->
<select name="property_type" class="w-full border rounded-lg px-4 py-2">
<option value="Apartment" <?php if($row['property_type']=="Apartment") echo "selected"; ?>>Apartment</option>
<option value="Villa" <?php if($row['property_type']=="Villa") echo "selected"; ?>>Villa</option>
<option value="House" <?php if($row['property_type']=="House") echo "selected"; ?>>House</option>
<option value="Plot" <?php if($row['property_type']=="Plot") echo "selected"; ?>>Plot</option>
<option value="Office" <?php if($row['property_type']=="Office") echo "selected"; ?>>Office</option>
</select>

<!-- LISTING TYPE -->
<select name="listing_type" class="w-full border rounded-lg px-4 py-2">
<option value="Rent" <?php if($row['listing_type']=="Rent") echo "selected"; ?>>For Rent</option>
<option value="Sale" <?php if($row['listing_type']=="Sale") echo "selected"; ?>>For Sale</option>
</select>

<!-- LOCATION -->
<input type="text" name="location" value="<?php echo $row['location']; ?>" class="w-full border rounded-lg px-4 py-2">

<!-- PRICE -->
<input type="text" name="price" value="<?php echo $row['price']; ?>" class="w-full border rounded-lg px-4 py-2">

<!-- BED / BATH / AREA -->
<div class="grid grid-cols-3 gap-4">
<input type="number" name="bedrooms" value="<?php echo $row['bedrooms']; ?>" class="border rounded-lg px-3 py-2">
<input type="number" name="bathrooms" value="<?php echo $row['bathrooms']; ?>" class="border rounded-lg px-3 py-2">
<input type="text" name="area" value="<?php echo $row['area']; ?>" class="border rounded-lg px-3 py-2">
</div>

<!-- PARKING -->
<select name="parking" class="w-full border rounded-lg px-4 py-2">
<option value="Yes" <?php if($row['parking']=="Yes") echo "selected"; ?>>Yes</option>
<option value="No" <?php if($row['parking']=="No") echo "selected"; ?>>No</option>
</select>

<!-- AMENITIES -->
<input type="text" name="amenities" value="<?php echo $row['amenities']; ?>" class="w-full border rounded-lg px-4 py-2">

<!-- EXISTING IMAGES -->
<div>
<label class="block mb-2">Existing Images</label>

<div class="grid grid-cols-3 gap-3">
<?php foreach($existing_images as $img){ ?>
<div class="relative">
<img src="<?php echo $img; ?>" class="w-full h-20 object-cover rounded">
<input type="checkbox" name="delete_images[]" value="<?php echo $img; ?>" class="absolute top-1 left-1">
</div>
<?php } ?>
</div>
</div>

<!-- ADD NEW -->
<input type="file" name="images[]" multiple class="w-full border rounded-lg px-4 py-2">

<!-- VIDEO -->
<input type="file" name="video" class="w-full border rounded-lg px-4 py-2">

<!-- DESCRIPTION -->
<textarea name="description" class="w-full border rounded-lg px-4 py-2"><?php echo $row['description']; ?></textarea>

<button class="w-full bg-royal text-white py-3 rounded-lg">
Update Listing
</button>

</form>

</div>
</div>

<div id="footer-container" class="mt-auto"></div>
<script src="js/loadFooter.js"></script>

</body>
</html>