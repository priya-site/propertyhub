<?php
session_start();

$property_id = $_GET['property_id'] ?? 0;
$lead_id = $_GET['lead_id'] ?? 0;
$inquiry_id = $_GET['inquiry_id'] ?? 0;

/* VALIDATION */
if($property_id == 0){
    header("Location: property-listing.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Secure Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white min-h-screen flex flex-col overflow-x-hidden">

<!-- Navbar -->
<nav class="bg-white shadow-md p-4 flex flex-wrap items-center justify-between gap-3">
    <h1 class="text-xl sm:text-2xl font-bold text-purple-700">PropertyHub</h1>

    <div class="flex flex-wrap gap-3 text-sm sm:text-base">
        <a href="index.php" class="hover:text-purple-700">Home</a>
        <a href="property-listing.php" class="hover:text-purple-700">Properties</a>
        <a href="user-profile.php" class="hover:text-purple-700">Profile</a>
    </div>
</nav>

<!-- Main Content -->
<div class="flex-grow flex items-center justify-center px-4 py-8 sm:py-12">

<div class="bg-[#F3F4F6] p-5 sm:p-6 md:p-8 rounded-2xl shadow-2xl w-full max-w-md">

    <h2 class="text-2xl sm:text-3xl font-bold text-center text-[#6A0DAD] mb-6">
        Secure Payment
    </h2>

    <form action="payment-success.php" method="POST" class="space-y-4 sm:space-y-5">

        <input type="hidden" name="property_id" value="<?php echo $property_id; ?>">

        <?php if($inquiry_id){ ?>
        <input type="hidden" name="inquiry_id" value="<?php echo $inquiry_id; ?>">
        <?php } ?>

        <?php if($lead_id){ ?>
        <input type="hidden" name="lead_id" value="<?php echo $lead_id; ?>">
        <?php } ?>

        <!-- Name -->
        <div>
            <label class="block mb-1 font-semibold text-[#112240] text-sm sm:text-base">
                Card Holder Name
            </label>
            <input type="text" name="name" required
                class="w-full border border-gray-300 p-3 rounded-lg text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-[#8A2BE2]">
        </div>

        <!-- Card -->
        <div>
            <label class="block mb-1 font-semibold text-[#112240] text-sm sm:text-base">
                Card Number
            </label>
            <input type="text" name="card" maxlength="16" required
                class="w-full border border-gray-300 p-3 rounded-lg text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-[#8A2BE2]">
        </div>

        <!-- Expiry + CVV -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1 font-semibold text-[#112240] text-sm sm:text-base">
                    Expiry
                </label>
                <input type="text" name="expiry" placeholder="MM/YY" required
                    class="w-full border border-gray-300 p-3 rounded-lg text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-[#8A2BE2]">
            </div>

            <div>
                <label class="block mb-1 font-semibold text-[#112240] text-sm sm:text-base">
                    CVV
                </label>
                <input type="password" name="cvv" maxlength="3" required
                    class="w-full border border-gray-300 p-3 rounded-lg text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-[#8A2BE2]">
            </div>
        </div>

        <!-- Button -->
        <button type="submit"
            class="w-full bg-[#6A0DAD] text-white py-3 rounded-lg font-semibold hover:bg-[#8A2BE2] transition duration-300 text-sm sm:text-base">
            Pay Now
        </button>

    </form>

</div>

</div>

<!-- Footer -->
<div id="footer-container"></div>

<script src="js/loadNavbar.js"></script>
<script src="js/loadFooter.js"></script>

</body>
</html>