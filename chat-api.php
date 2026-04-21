<?php
header("Content-Type: application/json");
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);
$userMessage = strtolower($data['message'] ?? '');

if(empty($userMessage)){
    echo json_encode(["reply" => "Empty message"]);
    exit();
}

/* ================= SEARCH FUNCTION ================= */

function searchProperties($conn, $message){

    $city = "";
    $minPrice = 0;
$maxPrice = 999999999;
    $bhk = "";
    $type = "";

    // ✅ Detect property type
    if(strpos($message, "villa") !== false) $type = "villa";
if(strpos($message, "house") !== false) $type = "house";
if(strpos($message, "apartment") !== false) $type = "apartment";
if(strpos($message, "flat") !== false) $type = "flat";
if(strpos($message, "office") !== false) $type = "office";
if(strpos($message, "plot") !== false) $type = "plot";

    // ✅ FIXED LOCATION DETECTION
    if(preg_match('/in\s+([a-zA-Z]+)/', $message, $match)){
        $city = ucfirst($match[1]);
    }

    // Detect BHK
    if(preg_match('/(\d)\s*bhk/', $message, $match)){
        $bhk = $match[1];
    }

    // Detect price
    /* ================= PRICE DETECTION ================= */

// UNDER (e.g. under 50 lakh)
if(preg_match('/under\s+(\d+)\s*(lakh|cr)?/', $message, $match)){
    $value = (int)$match[1];
    $unit = $match[2] ?? "";

    if($unit == "cr") $maxPrice = $value * 10000000;
    elseif($unit == "lakh") $maxPrice = $value * 100000;
    else $maxPrice = $value;
}

// BETWEEN (e.g. between 1cr and 2cr)
if(preg_match('/between\s+(\d+)\s*(lakh|cr)?\s+and\s+(\d+)\s*(lakh|cr)?/', $message, $match)){
    $minVal = (int)$match[1];
    $minUnit = $match[2] ?? "";

    $maxVal = (int)$match[3];
    $maxUnit = $match[4] ?? "";

    $minPrice = ($minUnit == "cr") ? $minVal * 10000000 :
                (($minUnit == "lakh") ? $minVal * 100000 : $minVal);

    $maxPrice = ($maxUnit == "cr") ? $maxVal * 10000000 :
                (($maxUnit == "lakh") ? $maxVal * 100000 : $maxVal);
}

// DIRECT NUMBER (fallback)
if(preg_match('/\d{6,}/', $message, $match)){
    $maxPrice = (int)$match[0];
}

    // SQL
    $sql = "SELECT title, price, location, property_type FROM properties WHERE 1=1";

    if($city != "") $sql .= " AND location LIKE '%$city%'";
    if($type != "") $sql .= " AND LOWER(property_type) = '$type'";
    if($bhk != "") $sql .= " AND title LIKE '%$bhk BHK%'";
    $sql .= " AND price BETWEEN $minPrice AND $maxPrice";

    $sql .= " LIMIT 5";

    $result = mysqli_query($conn, $sql);

    if(!$result || mysqli_num_rows($result) == 0){
        return "";
    }

    $response = "";

    while($row = mysqli_fetch_assoc($result)){
        $response .= "• {$row['title']} ({$row['location']}) - ₹{$row['price']} [{$row['property_type']}]\n";
    }

    return $response;
}
/* ================= GET DB DATA ================= */

$dbResults = searchProperties($conn, $userMessage);

/* ================= INTENT DETECTION ================= */

$isPropertyQuery = false;

if(
    strpos($userMessage, "flat") !== false ||
    strpos($userMessage, "property") !== false ||
    strpos($userMessage, "plot") !== false ||
    strpos($userMessage, "buy") !== false ||
    strpos($userMessage, "bhk") !== false ||
    strpos($userMessage, "villa") !== false ||
    strpos($userMessage, "house") !== false ||
    strpos($userMessage, "apartment") !== false
){
    $isPropertyQuery = true;
}

/* ================= MAIN LOGIC ================= */

if($isPropertyQuery){

    $dbResults = searchProperties($conn, $userMessage);

    if(!empty($dbResults)){
        echo json_encode([
            "reply" => "🏡 Here are matching properties:\n\n" . $dbResults
        ]);
        exit();
    }

    // If no DB results → let AI handle
}

/* ================= AI ONLY WHEN NO DATA ================= */

$apiKey = "api_key";
$model = "gemini-2.5-flash";

$url = "https://generativelanguage.googleapis.com/v1/models/$model:generateContent?key=$apiKey";

$prompt = "You are a helpful real estate assistant.

User message: $userMessage

If it's a greeting, reply normally.
If it's about real estate, guide the user.";

$postData = json_encode([
    "contents" => [
        [
            "parts" => [
                ["text" => $prompt]
            ]
        ]
    ]
]);

$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $postData,
    CURLOPT_HTTPHEADER => ["Content-Type: application/json"]
]);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

$reply = $result['candidates'][0]['content']['parts'][0]['text'] ?? "Hello! How can I help you?";

echo json_encode(["reply" => $reply]);
