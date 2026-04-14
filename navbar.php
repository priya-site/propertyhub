<?php
session_start();

$role = $_SESSION['role'];

if($role == 'owner'){
    $profile_page = "owner-profile.php";
}
elseif($role == 'broker'){
    $profile_page = "broker-profile.php";
}
else{
    $profile_page = "user-profile.php";
}

$username = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : "";
?>

<nav class="bg-royal shadow-lg fixed top-0 left-0 w-full z-50">
  <div class="max-w-full mx-auto px-6">

    <div class="flex justify-between items-center h-20">

      <!-- Logo -->
      <div class="flex items-center">
        <a href="index.php" class="flex items-center">

          <img src="Images/logo4.png" alt="PropertyHub Logo"
            class="h-32 w-31 object-contain transition-all duration-300 hover:scale-105" />

        </a>
      </div>

      <!-- Mobile Button -->
      <button id="menuBtn" class="md:hidden text-white text-3xl focus:outline-none">
        ☰
      </button>

      <!-- Nav Links -->
      <div id="navLinks" class="hidden md:flex flex-col md:flex-row md:space-x-8 
          md:items-center text-white absolute md:static 
          bg-royal w-full md:w-auto left-0 top-32 
          px-6 py-6 md:p-0 space-y-4 md:space-y-0">

        <a href="index.php" class="block hover:text-gray-200">Home</a>

        <a href="about.html" class="block hover:text-gray-200">About</a>

        <!-- Property Dropdown -->
        <div class="w-full md:w-auto relative">

          <button id="propertyBtn" class="w-full text-left md:text-center hover:text-gray-200 focus:outline-none">
            Property ▼
          </button>

          <div id="propertyDropdown" class="hidden flex-col md:absolute md:bg-white 
              md:border md:border-royal md:mt-2 
              md:rounded md:w-56 md:z-50 shadow-lg text-gray-900 border border-lightroyal">

            <a href="property-type.php?type=Flat" class="block px-4 py-2 hover:bg-royal hover:text-white">Flats</a>
            <a href="property-type.php?type=Plot" class="block px-4 py-2 hover:bg-royal hover:text-white">Plots</a>
            <a href="property-type.php?type=Office" class="block px-4 py-2 hover:bg-royal hover:text-white">Offices</a>
            <a href="property-type.php?type=House" class="block px-4 py-2 hover:bg-royal hover:text-white">Houses</a>
            <a href="property-type.php?type=Villa" class="block px-4 py-2 hover:bg-royal hover:text-white">Villas</a>
            <a href="property-type.php?type=Apartment" class="block px-4 py-2 hover:bg-royal hover:text-white">Apartment</a>

            <!-- <hr class="border-royal my-2"> -->

            <!-- <a href="enquiry.html" class="block text-center m-3 bg-royal text-white py-2 rounded hover:bg-purple-700">
              Make an Enquiry
            </a> -->
          </div>
        </div>

        <a href="property-listing.php" class="block hover:text-gray-200">
          Property Listing
        </a>

        <?php if(isset($_SESSION['user_id'])) { 

    $dashboard = "";
    $username = $_SESSION['user_name']; 

    if(isset($_SESSION['role']) && $_SESSION['role'] == "user"){
        $dashboard = "user-dashboard.php";
    }
    elseif(isset($_SESSION['role']) && $_SESSION['role'] == "owner"){
        $dashboard = "owner-dashboard.php";
    }
    elseif(isset($_SESSION['role']) && $_SESSION['role'] == "broker"){
        $dashboard = "broker-dashboard.php";
    }

?>

          <!-- PROFILE DROPDOWN -->
<div class="relative">

<button id="profileBtn"
class="flex items-center gap-2 bg-white text-royal px-3 py-2 rounded-full hover:bg-gray-200 transition">

<i class="fa-solid fa-user"></i>
<span class="font-semibold"><?php echo $username; ?></span>
<i class="fa-solid fa-caret-down text-sm"></i>

</button>

<!-- Dropdown -->
<div id="profileDropdown"
class="hidden absolute right-0 mt-3 w-48 bg-white text-gray-800 rounded-lg shadow-lg border border-gray-200 z-50">

<a href="<?php echo $dashboard; ?>"
class="block px-4 py-2 hover:bg-royal hover:text-white">
<i class="fa fa-chart-line mr-2"></i> Dashboard
</a>

<a href="<?php echo $profile_page; ?>"
class="block px-4 py-2 hover:bg-royal hover:text-white">
<i class="fa fa-user mr-2"></i> Profile
</a>

<button onclick="openLogoutModal()" 
class="w-full text-left px-4 py-2 hover:bg-red-500">
   <i class="fa fa-sign-out-alt mr-2"></i> Logout
</button>

</div>

</div>
        <?php } else { ?>

          <!-- Login & Signup (When Not Logged In) -->
          <a href="login.html" class="block hover:text-gray-200">
            Login
          </a>

          <a href="signup.html"
            class="block bg-white text-royal px-4 py-2 rounded font-semibold text-center hover:bg-gray-200">
            Sign Up
          </a>

        <?php } ?>

      </div>
    </div>
  </div>
</nav>

<div class="h-20"></div>

<!-- LOGOUT MODAL -->
<div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 px-4">

<div class="bg-white w-full max-w-sm p-6 rounded-2xl text-center">

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

