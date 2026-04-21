<?php
session_start();
include "db.php";
include "functions.php";

/* CHECK BROKER LOGIN */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'broker') {
    header("Location: login.html");
    exit();
}

/* ================= API FUNCTIONS ================= */

// FETCH IMAGES FROM PEXELS
function fetchImages($query) {

    $apiKey = "api_key"; // 🔥 PUT YOUR REAL KEY

    $url = "https://api.pexels.com/v1/search?query=" . urlencode($query) . "&per_page=4";

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: $apiKey"
    ]);
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

// FETCH VIDEO FROM PEXELS
function fetchVideo($query){

    $apiKey = "api_key";

    $url = "https://api.pexels.com/videos/search?query=" . urlencode($query) . "&per_page=1";

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: $apiKey"
    ]);
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
    $broker_id = $_SESSION['user_id'];

    /* ================= IMAGE HANDLING ================= */

    $uploaded_images = [];

    // ✅ USER UPLOAD
    if (!empty($_FILES['images']['name'][0])) {

        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {

            $image_name = $_FILES['images']['name'][$key];
            $tmp = $_FILES['images']['tmp_name'][$key];

            $path = "uploads/" . time() . "_" . $image_name;

            move_uploaded_file($tmp, $path);

            $uploaded_images[] = $path;
        }
    }

    // ✅ IF NO IMAGE → AUTO FETCH
    if(empty($uploaded_images)){

    if($property_type == "Villa"){
        $baseQuery = "luxury villa interior";
    } elseif($property_type == "Apartment"){
        $baseQuery = "modern apartment interior";
    } elseif($property_type == "House"){
        $baseQuery = "family house interior";
    } elseif($property_type == "Office"){
        $baseQuery = "modern office interior";
    } else {
        $baseQuery = strtolower($property_type) . " interior";
    }

    $living   = fetchImages($baseQuery . " living room");
    $kitchen  = fetchImages($baseQuery . " kitchen");
    $bedroom  = fetchImages($baseQuery . " bedroom");
    $bathroom = fetchImages($baseQuery . " bathroom");

    $uploaded_images = array_merge($living, $kitchen, $bedroom, $bathroom);
    $uploaded_images = array_filter($uploaded_images); // 🔥 remove empty
    $uploaded_images = array_values($uploaded_images);
    $uploaded_images = array_slice($uploaded_images, 0, 8);

    // ✅ FINAL GUARANTEE (VERY IMPORTANT)
    if(empty($uploaded_images)){
        $uploaded_images = [
            "https://images.pexels.com/photos/106399/pexels-photo-106399.jpeg"
        ];
    }
}

    $images = implode(",", $uploaded_images);

    /* ================= VIDEO HANDLING ================= */

    $video_path = "";

    // ✅ USER VIDEO
    if (!empty($_FILES['video']['name'])) {

        $video_name = $_FILES['video']['name'];
        $tmp = $_FILES['video']['tmp_name'];

        $video_path = "uploads/" . time() . "_" . $video_name;

        move_uploaded_file($tmp, $video_path);
    }

    // ✅ IF NO VIDEO → AUTO FETCH
    if(empty($video_path)){
        $video_path = fetchVideo($property_type . " home tour");
    }

    /* ================= INSERT PROPERTY ================= */

    $sql = "INSERT INTO properties
(broker_id,title,location,price,description,images,video,bedrooms,bathrooms,area,parking,amenities,status,property_type,listing_type)
VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ississsiissssss",
        $broker_id,
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
        $status,
        $property_type,
        $listing_type
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
<title>Add Property - PropertyHub</title>

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

<!-- Navbar -->
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
Add New Listing
</h2>

<form method="POST" enctype="multipart/form-data" class="space-y-4">

<input type="text" name="title" placeholder="Property Title" required class="w-full border px-4 py-2 rounded">

<select name="listing_type" required class="w-full border px-4 py-2 rounded">
<option value="">Listing Type</option>
<option value="Rent">For Rent</option>
<option value="Sale">For Sale</option>
</select>

<input type="text" name="location" placeholder="Location" required class="w-full border px-4 py-2 rounded">

<input type="number" name="price" placeholder="Price" required class="w-full border px-4 py-2 rounded">

<div class="grid grid-cols-3 gap-4">
<input type="number" name="bedrooms" placeholder="Bedrooms" class="border px-3 py-2 rounded">
<input type="number" name="bathrooms" placeholder="Bathrooms" class="border px-3 py-2 rounded">
<input type="text" name="area" placeholder="Area" class="border px-3 py-2 rounded">
</div>

<div class="grid grid-cols-2 gap-4">
<select name="parking" class="border px-3 py-2 rounded">
<option value="Yes">Parking Yes</option>
<option value="No">Parking No</option>
</select>

<select name="property_type" required class="border px-3 py-2 rounded">
<option value="">Property Type</option>
<option>Apartment</option>
<option>Villa</option>
<option>House</option>
<option>Plot</option>
<option>Office</option>
</select>
</div>

<input type="text" name="amenities" placeholder="Amenities" class="w-full border px-4 py-2 rounded">

<!-- OPTIONAL IMAGES -->
<input type="file" name="images[]" multiple class="w-full border px-4 py-2 rounded">

<!-- OPTIONAL VIDEO -->
<input type="file" name="video" class="w-full border px-4 py-2 rounded">

<textarea name="description" placeholder="Description" class="w-full border px-4 py-2 rounded"></textarea>

<button class="w-full bg-royal text-white py-3 rounded hover:bg-lightroyal">
Add Property
</button>

</form>

</div>
</div>

<div id="footer-container" class="mt-auto"></div>

</body>
</html>

<?php $conn->close(); ?>
