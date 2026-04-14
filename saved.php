<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

include "db.php"; 
include "functions.php";

$user_id = $_SESSION['user_id'];

$sql = "SELECT properties.*
        FROM properties
        JOIN saved_properties
        ON properties.id = saved_properties.property_id
        WHERE saved_properties.user_id='$user_id'";

$result = $conn->query($sql);

/* COUNT saved properties */
$count_sql = "SELECT COUNT(*) AS total 
              FROM saved_properties 
              WHERE user_id='$user_id'";

$count_result = $conn->query($count_sql);
$count_row = $count_result->fetch_assoc();
$total_saved = $count_row['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Saved Properties - PropertyHub</title>

<script src="https://cdn.tailwindcss.com"></script>

<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        navy: "#0A192F",
        deepnavy: "#112240",
        card: "#F3F4F6",
        royal: "#6A0DAD",
        lightroyal: "#8A2BE2",
      }
    }
  }
}
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-white text-navy">

<!-- ✅ COMMON NAVBAR + SIDEBAR -->
<?php include "user-layout.php"; ?>

<!-- ================= MAIN WRAPPER ================= -->
<div class="flex min-h-screen overflow-x-hidden">

<!-- ================= MAIN CONTENT ================= -->
<div class="flex-1 w-full md:ml-64 px-4 sm:px-6 md:px-10 py-6">

    <!-- Header -->
    <div class="mb-6 md:mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-royal">
            My Saved Properties
        </h1>
        <p class="text-gray-600 mt-2 text-sm sm:text-base">
            You have saved <?php echo $total_saved; ?> properties
        </p>
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 md:gap-8">

<?php while($row = $result->fetch_assoc()) { ?>

<div class="bg-card rounded-xl shadow-md overflow-hidden border border-gray-200">

<div class="relative">

<img src="<?php echo $row['image']; ?>"
class="w-full h-40 sm:h-44 md:h-48 object-cover">

<a href="remove-saved.php?id=<?php echo $row['id']; ?>"
class="absolute top-3 right-3 bg-white p-2 rounded-full shadow hover:bg-red-100">

<i class="fa-solid fa-heart text-red-500"></i>

</a>

</div>

<div class="p-4 sm:p-5">

<h3 class="text-base sm:text-lg font-semibold">
<?php echo $row['title']; ?>
</h3>

<p class="text-gray-600 mt-1 text-sm sm:text-base">
<?php echo $row['location']; ?>
</p>

<p class="text-royal font-bold mt-2 text-sm sm:text-base">
₹ <?php echo formatPrice($row['price']); ?>
</p>

<div class="mt-4 flex justify-between">

<a href="property-details.php?id=<?php echo $row['id']; ?>"
class="inline-block w-full sm:w-auto text-center bg-royal text-white px-4 py-2 rounded hover:bg-lightroyal transition text-sm sm:text-base">
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