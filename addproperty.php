<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'owner') {
    header("Location: login.html");
    exit();
}


/* ================= API FUNCTIONS ================= */

function fetchImages($query) {

    $apiKey = "api_key"; // 🔥 PUT YOUR REAL KEY

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

    $apiKey = "api_key";

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

/* ================= FORM SUBMIT ================= */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $bedrooms = $_POST['bedrooms'];
    $bathrooms = $_POST['bathrooms'];
    $area = $_POST['area'];
    $parking = $_POST['parking'];
    $amenities = $_POST['amenities'];

    $property_type = $_POST['property_type'];
    $listing_type = $_POST['listing_type'];

    $status = "Active";
    $owner_id = $_SESSION['user_id'];

    /* ================= IMAGE LOGIC ================= */

    $uploaded_images = [];

    if(!empty($_FILES['images']['name'][0])){

        // ✅ USER UPLOADED IMAGES
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {

            $image_name = $_FILES['images']['name'][$key];
            $tmp = $_FILES['images']['tmp_name'][$key];

            $path = "uploads/" . uniqid() . "_" . $image_name;

            move_uploaded_file($tmp, $path);

            $uploaded_images[] = $path;
        }

        $images = implode(",", $uploaded_images);

    } else {

        // 🔥 API AUTO IMAGES
        if($property_type == "Villa"){
            $baseQuery = "luxury villa interior";
        } elseif($property_type == "Apartment"){
            $baseQuery = "modern apartment interior";
        } elseif($property_type == "House"){
            $baseQuery = "family house interior";
        } else {
            $baseQuery = strtolower($property_type) . " interior";
        }

        $all_images = array_merge(
            fetchImages($baseQuery . " living room"),
            fetchImages($baseQuery . " kitchen"),
            fetchImages($baseQuery . " bedroom"),
            fetchImages($baseQuery . " bathroom")
        );

        $all_images = array_slice($all_images, 0, 10);

        if(empty($all_images)){
            $all_images[] = "https://via.placeholder.com/400x300?text=No+Image";
        }

        $images = implode(",", $all_images);
    }

    /* ================= VIDEO LOGIC ================= */

    $video_path = "";

    if(!empty($_FILES['video']['name'])){

        // ✅ USER UPLOADED VIDEO
        $video_name = $_FILES['video']['name'];
        $tmp = $_FILES['video']['tmp_name'];

        $video_path = "uploads/" . uniqid() . "_" . $video_name;

        move_uploaded_file($tmp, $video_path);

    } else {

        // 🔥 API VIDEO
        $video_path = fetchVideo($property_type . " home tour");
    }

    /* ================= INSERT ================= */

    $sql = "INSERT INTO properties
(owner_id,title,location,price,description,images,video,bedrooms,bathrooms,area,parking,amenities,property_type,listing_type,status)
VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ississsiissssss",
        $owner_id,
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
        $property_type,
        $listing_type,
        $status
    );

    $stmt->execute();

    header("Location: myproperties.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Property - PropertyHub</title>

<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">



<!-- Navbar -->
    <nav
        class="bg-white shadow-md px-4 sm:px-6 md:px-10 py-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
        <h1 class="text-xl sm:text-2xl font-bold text-purple-700">PropertyHub</h1>

        <div class="flex flex-wrap gap-3 sm:gap-6 text-sm sm:text-base">
            <a href="index.php" class="hover:text-purple-700">Home</a>
            <a href="property-listing.php" class="hover:text-purple-700">Properties</a>
            <a href="myproperties.php" class="hover:text-purple-700">My Properties</a>
        </div>
    </nav>

<div class="bg-white p-8 rounded-xl shadow-lg max-w-5xl mx-auto mt-10">

<h2 class="text-2xl font-bold mb-6 text-center">Add New Property</h2>

<form method="POST" enctype="multipart/form-data">

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

<input type="text" name="title" placeholder="Title" required class="border p-2 rounded">

<select name="listing_type" required class="border p-2 rounded">
<option value="">Listing Type</option>
<option value="Rent">Rent</option>
<option value="Sale">Sale</option>
</select>

<input type="text" name="location" placeholder="Location" required class="border p-2 rounded">

<input type="number" name="price" placeholder="Price" required class="border p-2 rounded">

<input type="number" name="bedrooms" placeholder="Bedrooms" class="border p-2 rounded">

<input type="number" name="bathrooms" placeholder="Bathrooms" class="border p-2 rounded">

<input type="text" name="area" placeholder="Area" class="border p-2 rounded">

<select name="parking" class="border p-2 rounded">
<option value="Yes">Parking Yes</option>
<option value="No">Parking No</option>
</select>

<select name="property_type" required class="border p-2 rounded">
<option value="">Property Type</option>
<option value="Apartment">Apartment</option>
<option value="Villa">Villa</option>
<option value="House">House</option>
<option value="Plot">Plot</option>
<option value="Office">Office</option>
</select>

</div>

<input type="text" name="amenities" placeholder="Amenities" class="border p-2 rounded w-full mt-4">

<textarea name="description" placeholder="Description" class="border p-2 rounded w-full mt-4"></textarea>

<!-- 🔥 OPTIONAL UPLOAD -->
<div class="mt-4">
<label>Upload Images (optional)</label>
<input type="file" name="images[]" multiple class="border p-2 w-full">
</div>

<div class="mt-4">
<label>Upload Video (optional)</label>
<input type="file" name="video" class="border p-2 w-full">
</div>

<button class="w-full bg-purple-700 text-white py-3 rounded mt-6 hover:bg-purple-800">
Add Property
</button>

</form>

</div>

</body>
</html>

<?php $conn->close(); ?>
