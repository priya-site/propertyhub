<?php
if (!isset($_SESSION)) session_start();
$username = $_SESSION['user_name'];
?>

<!-- NAVBAR -->
<div class="bg-white shadow-md sticky top-0 z-50 w-full">
    <div class="flex justify-between items-center px-4 sm:px-6 md:px-10 py-4">

        <!-- LEFT -->
        <div class="flex items-center gap-3">
            <button id="menuBtn" class="md:hidden text-xl text-royal">
                <i class="fa fa-bars"></i>
            </button>

            <h1 class="text-lg md:text-xl font-semibold text-navy">
                User Dashboard
            </h1>
        </div>

        <!-- RIGHT -->
        <div class="flex items-center gap-3 sm:gap-6 text-sm">

            <a href="index.php" class="hidden sm:flex items-center gap-2 text-gray-600 hover:text-royal">
                <i class="fa-solid fa-house"></i> Home
            </a>

            <!-- Username -->
            <span class="hidden md:block font-medium">
                <?php echo $username; ?>
            </span>

            <!-- Logout Button -->
            <button onclick="openLogoutModal()" 
            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">
                Logout
            </button>
        </div>
    </div>
</div>

<!-- OVERLAY -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-30 md:hidden"></div>

<!-- SIDEBAR -->
<div id="menuItems"
class="w-64 bg-gradient-to-b from-royal to-lightroyal text-white p-6 shadow-xl
fixed top-0 left-0 h-full z-40
transform -translate-x-full md:translate-x-0 transition duration-300">

<h2 class="text-2xl font-bold mb-10">Property Hub</h2>

<ul class="space-y-4 text-sm">

<li>
<a href="user-dashboard.php" class="flex items-center gap-3 py-3 px-4 rounded hover:bg-white/20">
<i class="fa fa-chart-line"></i> Dashboard
</a>
</li>

<li>
<a href="property-listing.php" class="flex items-center gap-3 py-3 px-4 rounded hover:bg-white/20">
<i class="fa fa-building"></i> Browse
</a>
</li>

<li>
<a href="saved.php" class="flex items-center gap-3 py-3 px-4 rounded hover:bg-white/20">
<i class="fa fa-heart"></i> Saved
</a>
</li>

<li>
<a href="my-enquiries.php" class="flex items-center gap-3 py-3 px-4 rounded hover:bg-white/20">
<i class="fa fa-envelope"></i> Enquiries
</a>
</li>

<li>
<a href="payment-history.php" class="flex items-center gap-3 py-3 px-4 rounded hover:bg-white/20">
<i class="fa-solid fa-clock-rotate-left"></i> History
</a>
</li>

<li>
<a href="user-profile.php" class="flex items-center gap-3 py-3 px-4 rounded hover:bg-white/20">
<i class="fa fa-user"></i> Profile
</a>
</li>

</ul>
</div>

<!-- LOGOUT MODAL -->
<div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 px-4">
<div class="bg-white w-full max-w-sm p-6 rounded-2xl text-center animate-fadeIn">

<div class="text-red-500 text-5xl mb-4">
<i class="fa-solid fa-right-from-bracket"></i>
</div>

<h2 class="text-xl font-bold mb-2">Confirm Logout</h2>

<p class="text-gray-600 mb-6">Are you sure you want to logout?</p>

<div class="flex justify-center gap-4">
<button onclick="closeLogoutModal()" class="bg-gray-300 px-4 py-2 rounded-lg">
Cancel
</button>

<a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
Yes, Logout
</a>
</div>

</div>
</div>

<!-- ✅ JS -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const menuBtn = document.getElementById("menuBtn");
    const menuItems = document.getElementById("menuItems");
    const overlay = document.getElementById("overlay");

    // Sidebar toggle
    if (menuBtn && menuItems && overlay) {
        menuBtn.addEventListener("click", () => {
            menuItems.classList.toggle("-translate-x-full");
            overlay.classList.toggle("hidden");
        });

        overlay.addEventListener("click", () => {
            menuItems.classList.add("-translate-x-full");
            overlay.classList.add("hidden");
        });
    }

});

// Logout modal functions
function openLogoutModal() {
    const modal = document.getElementById("logoutModal");
    modal.classList.remove("hidden");
    modal.classList.add("flex");
}

function closeLogoutModal() {
    const modal = document.getElementById("logoutModal");
    modal.classList.add("hidden");
    modal.classList.remove("flex");
}
</script>