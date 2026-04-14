<?php
include "db.php";

$property_id = $_GET['property_id'];
$broker_id = $_GET['broker_id'];
?>

<!DOCTYPE html>
<html>
<head>

<title>Contact Broker</title>

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

<!-- NAVBAR -->
<div id="navbar-container"></div>


<!-- Page Content -->
<div class="flex-grow flex items-center justify-center px-4 py-10 sm:py-16">

<div class="max-w-xl w-full bg-card p-6 sm:p-8 rounded-xl shadow-lg border border-lightroyal">

<h2 class="text-2xl sm:text-3xl font-bold mb-6 text-royal text-center">
Contact Broker
</h2>

<?php if(isset($_GET['success'])){ ?>

<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-center text-sm sm:text-base">
<i class="fa-solid fa-circle-check mr-2"></i>
Your enquiry has been sent successfully. The broker will contact you soon.
</div>

<?php } ?>

<form action="send-lead.php" method="POST" class="space-y-5 sm:space-y-6">

<input type="hidden" name="property_id" value="<?php echo $property_id; ?>">
<input type="hidden" name="broker_id" value="<?php echo $broker_id; ?>">

<div>
<label class="font-semibold block mb-2 text-sm sm:text-base">Name</label>
<input type="text" name="name"
class="w-full border p-3 rounded-lg text-sm sm:text-base focus:outline-none focus:border-royal"
required>
</div>

<div>
<label class="font-semibold block mb-2 text-sm sm:text-base">Email</label>
<input type="email" name="email"
class="w-full border p-3 rounded-lg text-sm sm:text-base focus:outline-none focus:border-royal"
required>
</div>

<div>
<label class="font-semibold block mb-2 text-sm sm:text-base">Phone</label>
<input type="text" name="phone"
class="w-full border p-3 rounded-lg text-sm sm:text-base focus:outline-none focus:border-royal"
required>
</div>

<div>
<label class="font-semibold block mb-2 text-sm sm:text-base">Message</label>
<textarea name="message"
class="w-full border p-3 rounded-lg text-sm sm:text-base focus:outline-none focus:border-royal"
rows="4"></textarea>
</div>

<button type="submit"
class="w-full bg-royal text-white py-3 rounded-lg hover:bg-lightroyal transition text-sm sm:text-base">
Send Inquiry
</button>

</form>

</div>

</div>


<!-- FOOTER -->
<div id="footer-container"></div>


<!-- LOAD NAVBAR & FOOTER -->
<script src="js/loadNavbar.js"></script>
<script src="js/loadFooter.js"></script>

</body>
</html>