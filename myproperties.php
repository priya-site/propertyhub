<?php
session_start();
include "db.php";
include "functions.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'owner'){
    header("Location: login.html");
    exit();
}

$username = $_SESSION['user_name'];
$owner_id = $_SESSION['user_id'];

$sql = "SELECT * FROM properties WHERE owner_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$owner_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Properties - PropertyHub</title>

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

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-gray-100 overflow-x-hidden">

<!-- ✅ COMMON OWNER LAYOUT -->
<?php include "owner-layout.php"; ?>

<div class="flex">

<!-- ================= MAIN CONTENT ================= -->
<div class="flex-1 w-full md:ml-64 p-4 sm:p-6 md:p-10">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-navy">
            My Properties
        </h1>

        <a href="addproperty.php" 
        class="bg-royal text-white px-5 py-2 rounded-lg hover:bg-lightroyal transition text-center w-full sm:w-auto">
        + Add New Property
        </a>
    </div>

    <!-- ================= PROPERTY CARDS ================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

<?php while($row = $result->fetch_assoc()) { ?>

<div class="bg-white rounded-xl shadow-md overflow-hidden border border-lightroyal relative hover:shadow-lg transition">

<!-- STATUS BADGE (LEFT) -->
<?php if($row['status'] == "Active"){ ?>
<span class="absolute top-3 left-3 bg-green-100 text-green-600 px-3 py-1 text-xs rounded-full shadow">
Active
</span>
<?php } elseif($row['status'] == "Sold"){ ?>
<span class="absolute top-3 left-3 bg-red-100 text-red-600 px-3 py-1 text-xs rounded-full shadow">
Sold
</span>
<?php } ?>

<!-- ✅ LISTING TYPE BADGE (RIGHT) -->
<?php if(!empty($row['listing_type'])){ ?>
    <?php if($row['listing_type'] == 'Rent'){ ?>
        <span class="absolute top-3 right-3 bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full shadow font-semibold">
            For Rent
        </span>
    <?php } else { ?>
        <span class="absolute top-3 right-3 bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full shadow font-semibold">
            For Sale
        </span>
    <?php } ?>
<?php } ?>

<?php 
$first_img = "";

if(!empty($row['images'])){
    $imgs = explode(",", $row['images']);
    $first_img = trim($imgs[0]);
}

if(empty($first_img)){
    $first_img = "https://via.placeholder.com/400x300";
}
?>

<img src="<?php echo $first_img; ?>"
class="w-full h-44 sm:h-48 md:h-52 object-cover">

<div class="p-4">

<h3 class="text-lg font-semibold text-royal truncate">
<?php echo $row['title']; ?>
</h3>

<p class="text-sm text-gray-500 mt-1 truncate">
<?php echo $row['location']; ?>
</p>

<p class="text-navy font-bold mt-3">
₹ <?php echo formatPrice($row['price']); ?>
</p>

<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mt-5">

<div class="flex gap-2 flex-wrap">

<a href="editproperty.php?id=<?php echo $row['id']; ?>"
class="bg-green-300 px-3 py-1 rounded-lg text-sm hover:bg-green-200 text-green-600">
Edit
</a>

<a href="deleteproperty.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Are you sure you want to delete this property?')"
class="bg-red-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-red-600">
Delete
</a>

</div>

<a href="viewproperty.php?id=<?php echo $row['id']; ?>"
class="bg-royal text-white px-3 py-1 rounded-lg text-sm hover:bg-lightroyal text-center w-full sm:w-auto">
View
</a>

</div>

</div>
</div>

<?php } ?>

    </div>

</div>

</div>

</body>
</html>