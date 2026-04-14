<?php
include "db.php";

/* API FUNCTIONS (same as addproperty.php) */

function fetchImages($query) {
    $apiKey = "YOUR_PEXELS_API_KEY";

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
    $apiKey = "YOUR_PEXELS_API_KEY";

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

/* GET OLD PROPERTIES WITHOUT IMAGES */

$sql = "SELECT * FROM properties WHERE images IS NULL OR images = ''";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()){

    $id = $row['id'];
    $type = $row['property_type'];

    // Smart query
    if($type == "Villa"){
        $baseQuery = "luxury villa interior";
    } elseif($type == "Apartment"){
        $baseQuery = "modern apartment interior";
    } else {
        $baseQuery = strtolower($type) . " interior";
    }

    // Fetch images
    $imgs = array_merge(
        fetchImages($baseQuery . " living room"),
        fetchImages($baseQuery . " kitchen"),
        fetchImages($baseQuery . " bedroom"),
        fetchImages($baseQuery . " bathroom")
    );

    $imgs = array_slice($imgs, 0, 8);

    if(empty($imgs)){
        $imgs[] = "https://via.placeholder.com/400x300";
    }

    $images = implode(",", $imgs);

    // Fetch video
    $video = fetchVideo($type . " home tour");

    // Update DB
    $stmt = $conn->prepare("UPDATE properties SET images=?, video=? WHERE id=?");
    $stmt->bind_param("ssi", $images, $video, $id);
    $stmt->execute();

    echo "Updated Property ID: $id <br>";
}

echo "✅ DONE!";
?>