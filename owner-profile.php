<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

if($_SESSION['role'] != 'owner'){
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Owner Profile - PropertyHub</title>

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

<body class="bg-gray-100 text-navy">

<!-- ✅ COMMON OWNER NAVBAR + SIDEBAR -->
<?php include "owner-layout.php"; ?>

<!-- ================= MAIN WRAPPER ================= -->
<div class="flex min-h-screen overflow-x-hidden">

<!-- ================= MAIN CONTENT ================= -->
<div class="flex-1 w-full md:ml-64 px-4 sm:px-6 md:px-10 py-6 max-w-full">

<!-- Header -->
<h1 class="text-2xl sm:text-3xl font-bold text-navy mb-6">
Owner Profile
</h1>

<?php if(isset($_GET['success'])){ ?>

<div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm sm:text-base">
<?php
if($_GET['success']=="passwordupdated"){
    echo "Password updated successfully!";
}
?>
</div>

<?php } ?>

<!-- Profile Card -->
<div class="bg-white p-4 sm:p-6 rounded-xl shadow-md border border-lightroyal max-w-3xl w-full">

<form action="update-profile.php" method="POST" class="space-y-6">

<!-- Name -->
<div>
<label class="block text-gray-700 mb-1 text-sm sm:text-base">Full Name</label>
<input type="text" name="name" value="<?php echo $_SESSION['user_name']; ?>"
class="w-full border border-gray-300 p-3 rounded-lg focus:border-royal focus:ring-1 focus:ring-royal text-sm sm:text-base">
</div>

<!-- Role -->
<div>
<label class="block text-gray-700 mb-1 text-sm sm:text-base">Role</label>
<input type="text" value="Owner" readonly
class="w-full border border-gray-300 p-3 rounded-lg bg-gray-100 cursor-not-allowed text-sm sm:text-base">
</div>

</form>

<!-- Change Password -->
<div class="mt-8 sm:mt-10 border-t pt-6">
<h2 class="text-lg sm:text-xl font-semibold text-navy mb-4">
Change Password
</h2>

<form action="owner-password.php" method="POST" class="space-y-4">

<div>
<label class="block text-gray-700 mb-1 text-sm sm:text-base">Current Password</label>
<input type="password" name="current_password"
class="w-full border border-gray-300 p-3 rounded-lg focus:border-royal focus:ring-1 focus:ring-royal text-sm sm:text-base">
</div>

<div>
<label class="block text-gray-700 mb-1 text-sm sm:text-base">New Password</label>
<input type="password" name="new_password"
class="w-full border border-gray-300 p-3 rounded-lg focus:border-royal focus:ring-1 focus:ring-royal text-sm sm:text-base">
</div>

<div>
<label class="block text-gray-700 mb-1 text-sm sm:text-base">Confirm New Password</label>
<input type="password" name="confirm_password"
class="w-full border border-gray-300 p-3 rounded-lg focus:border-royal focus:ring-1 focus:ring-royal text-sm sm:text-base">
</div>

<div>
<button type="submit"
class="w-full sm:w-auto bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 transition text-sm sm:text-base">
Update Password
</button>
</div>

</form>

</div>

</div>

</div>
</div>

</body>
</html>