<?php
session_start();

include "db.php";

$property_id = isset($_GET['property_id']) ? $_GET['property_id'] : '';

if($_SERVER["REQUEST_METHOD"] == "POST"){

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];
$property_id = $_POST['property_id'];

$propertyQuery = mysqli_query($conn,"
SELECT owner_id,title,price
FROM properties
WHERE id='$property_id'
");

if(mysqli_num_rows($propertyQuery) == 0){
    echo "Property not found";
    exit();
}

$property = mysqli_fetch_assoc($propertyQuery);

$owner_id = $property['owner_id'];
$property_name = $property['title'];
$property_price = floatval($property['price']);

$user_id = $_SESSION['user_id'];

mysqli_query($conn,"
INSERT INTO inquiries
(owner_id,user_id,property_id,property_name,customer_name,email,phone,message,status)
VALUES
('$owner_id','$user_id','$property_id','$property_name','$name','$email','$phone','$message','New')
");

$commission = $property_price * 0.02;

if($commission < 1){
$commission = $property_price;
}

mysqli_query($conn,"
INSERT INTO earnings
(owner_id,property_id,property_name,amount,status)
VALUES
('$owner_id','$property_id','$property_name','$commission','pending')
");

header("Location: contact.php?property_id=".$property_id."&success=1");
exit();

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Contact Owner</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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

</head>

<body class="bg-white text-navy flex flex-col min-h-screen overflow-x-hidden">

<div id="navbar-container"></div>

<!-- MAIN -->
<div class="flex-grow py-10 sm:py-16 flex justify-center items-center px-4">

<div class="bg-card p-6 sm:p-8 md:p-10 rounded-lg shadow-xl w-full max-w-xl border border-lightroyal">

<h2 class="text-2xl sm:text-3xl font-bold text-royal mb-6 text-center">
Contact Owner
</h2>

<?php if(isset($_GET['success'])){ ?>

<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-center text-sm sm:text-base">
<i class="fa-solid fa-circle-check mr-2"></i>
Your inquiry has been sent successfully. The owner will contact you soon.
</div>

<?php } ?>

<form action="" method="POST" class="space-y-5 sm:space-y-6">

<input type="hidden" name="property_id" value="<?php echo htmlspecialchars($property_id); ?>">

<div>
<label class="block mb-2 font-semibold text-sm sm:text-base">Full Name</label>
<input type="text" name="name" required
class="w-full border rounded-lg p-3 text-sm sm:text-base focus:outline-none focus:border-royal">
</div>

<div>
<label class="block mb-2 font-semibold text-sm sm:text-base">Email</label>
<input type="email" name="email" required
class="w-full border rounded-lg p-3 text-sm sm:text-base focus:outline-none focus:border-royal">
</div>

<div>
<label class="block mb-2 font-semibold text-sm sm:text-base">Phone</label>
<input type="text" name="phone"
class="w-full border rounded-lg p-3 text-sm sm:text-base focus:outline-none focus:border-royal">
</div>

<div>
<label class="block mb-2 font-semibold text-sm sm:text-base">Message</label>
<textarea name="message" rows="4" required
class="w-full border rounded-lg p-3 text-sm sm:text-base focus:outline-none focus:border-royal"></textarea>
</div>

<button type="submit"
class="w-full bg-royal text-white py-3 rounded-lg hover:bg-lightroyal transition text-sm sm:text-base">
Send Inquiry
</button>

</form>

</div>

</div>

<div id="footer-container"></div>

<script src="js/loadNavbar.js"></script>
<script src="js/loadFooter.js"></script>

</body>
</html>