<?php
session_start();
include "db.php";

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $message = $_POST['message'];
    $rating = $_POST['rating'];

    mysqli_query($conn,"
    INSERT INTO feedback (name, gender, message, rating)
    VALUES ('$name','$gender','$message','$rating')
    ");

    header("Location: feedback.php?success=1");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Feedback - PropertyHub</title>

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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body class="bg-gray-100 flex flex-col min-h-screen">

<div id="navbar-container"></div>

<!-- ================= MAIN CONTENT ================= -->
<div class="flex-grow flex items-center justify-center px-4 sm:px-6 py-8 sm:py-12">

  <div class="bg-white w-full max-w-md sm:max-w-lg p-6 sm:p-8 rounded-2xl shadow-xl border border-lightroyal">

    <h2 class="text-2xl sm:text-3xl font-bold text-center text-royal mb-6">
      Share Your Experience 💬
    </h2>

    <?php if(isset($_GET['success'])) { ?>
      <p class="text-green-600 text-center mb-4 font-semibold text-sm sm:text-base">
        ✅ Thank you! Your feedback has been submitted.
      </p>
    <?php } ?>

    <form method="POST" class="space-y-4">

      <!-- Name -->
      <input type="text" name="name" placeholder="Your Name"
      class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-royal outline-none text-sm sm:text-base"
      required>

      <!-- Gender -->
      <div>
        <p class="mb-2 text-gray-600 text-sm sm:text-base">Gender</p>

        <div class="flex flex-wrap gap-4 sm:gap-6">
          <label class="flex items-center gap-2 text-sm sm:text-base">
            <input type="radio" name="gender" value="male" required>
            Male
          </label>

          <label class="flex items-center gap-2 text-sm sm:text-base">
            <input type="radio" name="gender" value="female" required>
            Female
          </label>
        </div>
      </div>

      <!-- Message -->
      <textarea name="message" placeholder="Your Feedback"
      class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-royal outline-none text-sm sm:text-base"
      rows="4" required></textarea>

      <!-- ⭐ STAR RATING -->
      <div class="text-center">
        <p class="mb-2 text-gray-600 text-sm sm:text-base">Your Rating</p>

        <div class="flex justify-center gap-2 sm:gap-3 text-xl sm:text-2xl text-gray-400 cursor-pointer">

          <i class="fa-solid fa-star" data-value="1"></i>
          <i class="fa-solid fa-star" data-value="2"></i>
          <i class="fa-solid fa-star" data-value="3"></i>
          <i class="fa-solid fa-star" data-value="4"></i>
          <i class="fa-solid fa-star" data-value="5"></i>

        </div>

        <input type="hidden" name="rating" id="rating" required>
      </div>

      <!-- Submit -->
      <button name="submit"
      class="w-full bg-royal text-white py-3 rounded-lg font-semibold hover:bg-lightroyal transition text-sm sm:text-base">
        Submit Feedback
      </button>

    </form>

  </div>

</div>

<div id="footer-container"></div>

<script src="js/loadNavbar.js"></script>
<script src="js/loadFooter.js"></script>

<!-- ================= STAR SCRIPT ================= -->
<script>
const stars = document.querySelectorAll(".fa-star");
const ratingInput = document.getElementById("rating");

stars.forEach((star) => {

  star.addEventListener("click", () => {
    let value = star.getAttribute("data-value");
    ratingInput.value = value;

    stars.forEach((s, i) => {
      if(i < value){
        s.classList.add("text-yellow-400");
        s.classList.remove("text-gray-400");
      } else {
        s.classList.add("text-gray-400");
        s.classList.remove("text-yellow-400");
      }
    });
  });

});
</script>

</body>
</html>