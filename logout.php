<?php
session_start();

// Clear all session data
$_SESSION = array();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Logged Out - PropertyHub</title>

<script src="https://cdn.tailwindcss.com"></script>

<!-- Tailwind Custom Colors -->
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        navy: "#0A192F",
        royal: "#6A0DAD",
        lightroyal: "#8A2BE2"
      }
    }
  }
}
</script>

<!-- Font Awesome (FIXED ICON ISSUE) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<script>
  // Redirect after 3 seconds
  setTimeout(() => {
    window.location.href = 'login.html';
  }, 3000);
</script>

</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen px-4">

<div class="bg-white p-6 sm:p-8 md:p-10 rounded-xl shadow-lg text-center w-full max-w-md">

    <i class="fa-solid fa-check-circle text-5xl sm:text-6xl text-royal mb-4"></i>

    <h1 class="text-xl sm:text-2xl font-bold text-navy mb-2">
        You have successfully logged out!
    </h1>

    <p class="text-gray-600 text-sm sm:text-base">
        Redirecting to the login page...
    </p>

</div>

</body>
</html>