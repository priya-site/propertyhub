<?php
session_start();
include "db.php";
include "functions.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'owner') {
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

    $property_type = $row['property_type']; // keep same type

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

    /* 🔥 IF NO IMAGES LEFT → AUTO FETCH */
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

    /* VIDEO LOGIC */
    $video_path = $row['video'];

    if(!empty($_FILES['video']['name'])){
        $video_name = $_FILES['video']['name'];
        $tmp = $_FILES['video']['tmp_name'];

        $video_path = "uploads/" . uniqid() . "_" . $video_name;
        move_uploaded_file($tmp, $video_path);
    }

    /* 🔥 IF VIDEO EMPTY → AUTO FETCH */
    if(empty($video_path)){
        $video_path = fetchVideo($property_type . " home tour");
    }

    /* UPDATE QUERY */
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

    header("Location: myproperties.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Property</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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

<div class="bg-white p-6 rounded-xl shadow-lg max-w-5xl mx-auto mt-10">

<h2 class="text-2xl font-bold mb-6 text-center">Edit Property</h2>

<form method="POST" enctype="multipart/form-data">

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

<input type="text" name="title" value="<?php echo $row['title']; ?>" class="border p-2 rounded">

<select name="listing_type" class="border p-2 rounded">
<option value="Rent" <?php if($row['listing_type']=="Rent") echo "selected"; ?>>Rent</option>
<option value="Sale" <?php if($row['listing_type']=="Sale") echo "selected"; ?>>Sale</option>
</select>

<input type="text" name="location" value="<?php echo $row['location']; ?>" class="border p-2 rounded">
<input type="number" name="price" value="<?php echo $row['price']; ?>" class="border p-2 rounded">

<input type="number" name="bedrooms" value="<?php echo $row['bedrooms']; ?>" class="border p-2 rounded">
<input type="number" name="bathrooms" value="<?php echo $row['bathrooms']; ?>" class="border p-2 rounded">

<input type="text" name="area" value="<?php echo $row['area']; ?>" class="border p-2 rounded">

<select name="parking" class="border p-2 rounded">
<option value="Yes" <?php if($row['parking']=="Yes") echo "selected"; ?>>Yes</option>
<option value="No" <?php if($row['parking']=="No") echo "selected"; ?>>No</option>
</select>

<input type="text" name="amenities" value="<?php echo $row['amenities']; ?>" class="border p-2 rounded">

</div>

<!-- EXISTING IMAGES -->
<div class="mt-6">
<label class="block mb-2">Existing Images (select to delete)</label>

<div class="grid grid-cols-3 gap-3">
<?php foreach($existing_images as $img){ ?>
<div class="relative">
<img src="<?php echo $img; ?>" class="w-full h-24 object-cover rounded">
<input type="checkbox" name="delete_images[]" value="<?php echo $img; ?>"
class="absolute top-1 left-1">
</div>
<?php } ?>
</div>
</div>

<!-- ADD NEW IMAGES -->
<div class="mt-6">
<label>Add New Images</label>
<input type="file" name="images[]" multiple class="border p-2 w-full">
</div>

<!-- VIDEO -->
<div class="mt-6">
<label>Replace Video</label>
<input type="file" name="video" class="border p-2 w-full">
</div>

<textarea name="description" class="border p-2 w-full mt-4"><?php echo $row['description']; ?></textarea>

<button class="w-full bg-purple-700 text-white py-3 mt-6 rounded">
Update Property
</button>

</form>

</div>

</body>
</html>