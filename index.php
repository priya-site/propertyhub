<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Property Hub</title>

  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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

  <style>
    #propertiesContainer {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }

    #propertiesContainer::-webkit-scrollbar {
      display: none;
    }
  </style>

  <style>
  html, body {
    max-width: 100%;
    overflow-x: hidden;
  }
</style>

<!-- <style>
@media (max-width: 768px) {
  #testimonialCarousel {
    transform: none !important;
  }
}
</style>

<style>
@keyframes slideUp {
  from {
    transform: translateY(80px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

.animate-slideUp {
  animation: slideUp 1s ease-out forwards;
}
</style> -->

</head>

<body class="bg-white text-gray-800 m-0 p-0 overflow-x-hidden">

  <!-- Navbar -->
 <div id="navbar-container" class="w-full max-w-full overflow-hidden"></div>

  <section class="relative w-full h-[50vh] sm:h-[60vh] md:h-[90vh] overflow-hidden -mt-20 sm:-mt-16 md:-mt-14">

  <!-- VIDEO -->
  <video autoplay muted loop playsinline
    class="w-full h-full object-cover">
    <source src="video/property-video.mp4" type="video/mp4">
  </video>

  <!-- OVERLAY
  <div class="absolute inset-0 flex justify-center items-center px-4">

  <div class="bg-white/10 backdrop-blur-lg p-6 sm:p-10 rounded-2xl text-center shadow-lg">

    <h1 class="text-white text-4xl font-bold animate-slideUp">
  Welcome to <span class="text-lightroyal">PropertyHub</span>
</h1>
    <p class="text-gray-200 text-sm sm:text-lg">
      Find your dream home today
    </p>

  </div>

</div> -->

</section>

  <!-- ================= HERO SECTION ================= -->
<section class="w-full flex justify-center px-4 sm:px-6 md:px-16 py-8 md:py-16">

  <div class="max-w-7xl w-full grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">

    <!-- LEFT SIDE PROPERTY IMAGE CARD -->
    <div class="group relative">

      <div class="overflow-hidden rounded-3xl shadow-2xl transform transition duration-500 group-hover:scale-105">
        <img src="Images/home-pl.png" alt="Luxury Property"
          class="w-full h-[260px] sm:h-[320px] md:h-[420px] object-cover transition duration-700 group-hover:scale-110">
      </div>

      <!-- Floating Card -->
      <div class="absolute -bottom-6 left-4 sm:left-6 bg-white/80 backdrop-blur-lg px-4 sm:px-6 py-3 sm:py-4 rounded-xl shadow-lg">
        <p class="text-gray-600 text-xs sm:text-sm">Premium Villa</p>
        <h3 class="font-bold text-base sm:text-lg text-royal">₹1,200,000</h3>
      </div>

    </div>


    <!-- RIGHT SIDE TEXT CONTENT -->
    <div class="text-center md:text-left">

      <h1 class="text-2xl sm:text-3xl md:text-5xl lg:text-6xl font-bold mb-4 md:mb-6 leading-tight">
        Discover <span class="text-royal">Luxury Living</span>
      </h1>

      <p class="text-sm sm:text-base md:text-lg mb-6 md:mb-8 max-w-lg mx-auto md:mx-0 text-gray-800">
        Find your dream property from premium flats, villas, lands and more.
        Experience elegance and comfort with PropertyHub.
      </p>

      <!-- SEARCH BAR -->
      <form action="property-listing.php" method="GET"
        class="flex flex-col sm:flex-row bg-white shadow-xl rounded-xl overflow-hidden max-w-lg mx-auto md:mx-0 transition duration-300 hover:shadow-2xl border border-lightroyal">

        <input 
          type="text" 
          name="city" 
          placeholder="Search by city..." 
          class="flex-1 px-4 sm:px-6 py-3 sm:py-4 outline-none text-sm sm:text-base"
          required
        >

        <button type="submit" class="bg-royal text-white px-6 sm:px-8 py-3 hover:bg-lightroyal transition text-sm sm:text-base">
          Search
        </button>

      </form>

    </div>

  </div>

</section>

  <!-- ================= EXPLORE PROPERTIES ================= -->
<section class="py-10 sm:py-16 bg-white">
  <div class="max-w-6xl mx-auto px-4">

    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6 sm:mb-8">
      <h2 class="text-2xl sm:text-3xl font-bold text-royal">Explore Properties</h2>
      <a href="property-listing.php"
        class="flex items-center text-royal font-semibold hover:text-lightroyal transition text-sm sm:text-base">
        Explore More →
      </a>
    </div>

    <div class="relative">

      <!-- LEFT BUTTON (HIDE ON MOBILE) -->
      <button id="prevProperty"
        class="hidden md:block absolute left-0 top-1/2 -translate-y-1/2 bg-royal text-white p-2 sm:p-3 rounded-full hover:bg-lightroyal z-10">
        &larr;
      </button>

      <!-- SCROLL CONTAINER -->
      <div id="propertiesContainer" class="grid grid-cols-1 sm:grid-cols-2 md:flex md:overflow-x-auto gap-4 sm:gap-6">

        <!-- Card 1 -->
        <div class="flex-none w-full sm:w-auto md:w-72 bg-card rounded-lg shadow-lg">
          <img src="Images/pl-img5.png"
            class="w-full h-40 sm:h-44 md:h-48 object-cover rounded-t-lg">
          <div class="p-3 sm:p-4">
            <h3 class="text-royal font-semibold text-base sm:text-lg mb-1">Beach House</h3>
            <p class="text-gray-600 text-xs sm:text-sm mb-2">Beach houses are homes designed for seaside living.</p>
            <p class="font-semibold text-navy text-sm sm:text-base">₹ 25000000</p>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="flex-none w-full sm:w-auto md:w-72 bg-card rounded-lg shadow-lg">
          <img src="https://purples.co.in/blog/wp-content/uploads/2018/11/Front_Angle_3.jpg"
            class="w-full h-40 sm:h-44 md:h-48 object-cover rounded-t-lg">
          <div class="p-3 sm:p-4">
            <h3 class="text-royal font-semibold text-base sm:text-lg mb-1">Loft Apartments</h3>
            <p class="text-gray-600 text-xs sm:text-sm mb-2">Highlight raw materials—exposed brick walls, polished concrete floors.</p>
            <p class="font-semibold text-navy text-sm sm:text-base">₹ 4000000</p>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="flex-none w-full sm:w-auto md:w-72 bg-card rounded-lg shadow-lg">
          <img src="Images/flat3.png"
            class="w-full h-40 sm:h-44 md:h-48 object-cover rounded-t-lg">
          <div class="p-3 sm:p-4">
            <h3 class="text-royal font-semibold text-base sm:text-lg mb-1">Rented Flats</h3>
            <p class="text-gray-600 text-xs sm:text-sm mb-2">Clearly state if it is Unfurnished (basic lights/fans).</p>
            <p class="font-semibold text-navy text-sm sm:text-base">₹ 2000000</p>
          </div>
        </div>

        <!-- Card 4 -->
        <div class="flex-none w-full sm:w-auto md:w-72 bg-card rounded-lg shadow-lg">
          <img src="Images/pl-img7.png"
            class="w-full h-40 sm:h-44 md:h-48 object-cover rounded-t-lg">
          <div class="p-3 sm:p-4">
            <h3 class="text-royal font-semibold text-base sm:text-lg mb-1">Commercial Office</h3>
            <p class="text-gray-600 text-xs sm:text-sm mb-2">An established office in the West known for offering a residential.</p>
            <p class="font-semibold text-navy text-sm sm:text-base">₹ 16000000</p>
          </div>
        </div>

        <!-- Card 5 -->
        <div class="flex-none w-full sm:w-auto md:w-72 bg-card rounded-lg shadow-lg">
          <img src="Images/pl-img12.png"
            class="w-full h-40 sm:h-44 md:h-48 object-cover rounded-t-lg">
          <div class="p-3 sm:p-4">
            <h3 class="text-royal font-semibold text-base sm:text-lg mb-1">Duplex Villa</h3>
            <p class="text-gray-600 text-xs sm:text-sm mb-2">A 5BHK luxury villa built on 3,000 sq. ft. of land.</p>
            <p class="font-semibold text-navy text-sm sm:text-base">₹ 4000000</p>
          </div>
        </div>

      </div>

      <!-- RIGHT BUTTON (HIDE ON MOBILE) -->
      <button id="nextProperty"
        class="hidden md:block absolute right-0 top-1/2 -translate-y-1/2 bg-royal text-white p-2 sm:p-3 rounded-full hover:bg-lightroyal z-10">
        &rarr;
      </button>

    </div>
  </div>
</section>

  <!-- ================= BUY / SELL / INVEST SECTION ================= -->
<section class="py-12 sm:py-16 md:py-20 bg-gray-50">

  <div class="max-w-6xl mx-auto px-4 space-y-16 md:space-y-24">

    <!-- ================= BUYING ================= -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">

      <!-- Image -->
      <div
        class="overflow-hidden rounded-xl shadow-lg group reveal-left opacity-0 -translate-x-32 transition-all duration-1000 ease-out">
        <img
          src="https://static.asianpaints.com/content/dam/asian_paints/blog/bhs/bhs-article12-your-budget-asian-paints.jpg"
          class="w-full h-[250px] sm:h-[320px] md:h-[420px] object-cover transition duration-500 ease-in-out group-hover:scale-110">
      </div>

      <!-- Text -->
      <div class="reveal-right opacity-0 translate-x-32 transition-all duration-1000 ease-out delay-200 text-center md:text-left">
        <h2 class="text-2xl sm:text-3xl md:text-5xl font-bold text-royal mb-4 md:mb-6 tracking-wide">
          BUYING
        </h2>

        <p class="mb-6 md:mb-8 text-gray-700 leading-relaxed max-w-md mx-auto md:mx-0 text-sm sm:text-base">
          Embark on your quest for the perfect residence with confidence,
          guided by our experienced team at PropertyHub.
        </p>

        <button>
          <a href="dashboard-redirect.php?role=buyer"
            class="inline-block border-2 border-royal text-royal px-6 sm:px-10 py-2 sm:py-3 tracking-widest hover:bg-royal hover:text-white transition duration-300 text-sm sm:text-base">
            FOR BUYERS
          </a>
        </button>
      </div>

    </div>


    <!-- ================= SELLING ================= -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">

      <!-- Text -->
      <div
        class="order-2 md:order-1 reveal-left opacity-0 -translate-x-32 transition-all duration-1000 ease-out delay-200 text-center md:text-left">
        <h2 class="text-2xl sm:text-3xl md:text-5xl font-bold text-royal mb-4 md:mb-6 tracking-wide">
          SELLING
        </h2>

        <p class="mb-6 md:mb-8 text-gray-700 leading-relaxed max-w-md mx-auto md:mx-0 text-sm sm:text-base">
          Maximize the value of your property with our strategic
          marketing and professional selling approach.
        </p>

        <button>
          <a href="dashboard-redirect.php?role=seller"
            class="inline-block border-2 border-royal text-royal px-6 sm:px-10 py-2 sm:py-3 tracking-widest hover:bg-royal hover:text-white transition duration-300 text-sm sm:text-base">
            FOR SELLERS
          </a>
        </button>
      </div>

      <!-- Image -->
      <div
        class="order-1 md:order-2 overflow-hidden rounded-xl shadow-lg group reveal-right opacity-0 translate-x-32 transition-all duration-1000 ease-out">
        <img
          src="https://images.livspace-cdn.com/w:3840/plain/https://d3gq2merok8n5r.cloudfront.net/abhinav/ond-1634120396-Obfdc/di-2026-1769081758-Ayx2Q/jfm-1769081772-NQyUm/li-1769098863-3uRws/lr-2-1770807680-hkNXC.jpg"
          class="w-full h-[250px] sm:h-[320px] md:h-[420px] object-cover transition duration-500 ease-in-out group-hover:scale-110">
      </div>

    </div>


    <!-- ================= INVESTING ================= -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">

      <!-- Image -->
      <div
        class="overflow-hidden rounded-xl shadow-lg group reveal-left opacity-0 -translate-x-32 transition-all duration-1000 ease-out">
        <img
          src="https://i.pinimg.com/736x/8f/5c/af/8f5caf41deea03d3702cb0ddd2063902.jpg"
          class="w-full h-[250px] sm:h-[320px] md:h-[420px] object-cover transition duration-500 ease-in-out group-hover:scale-110">
      </div>

      <!-- Text -->
      <div class="reveal-right opacity-0 translate-x-32 transition-all duration-1000 ease-out delay-200 text-center md:text-left">
        <h2 class="text-2xl sm:text-3xl md:text-5xl font-bold text-royal mb-4 md:mb-6 tracking-wide">
          Brokers
        </h2>

        <p class="mb-6 md:mb-8 text-gray-700 leading-relaxed max-w-md mx-auto md:mx-0 text-sm sm:text-base">
          Connect buyers and sellers easily while managing multiple
          property deals through our professional brokerage tools.
        </p>

        <button>
          <a href="dashboard-redirect.php?role=broker"
            class="inline-block border-2 border-royal text-royal px-6 sm:px-10 py-2 sm:py-3 tracking-widest hover:bg-royal hover:text-white transition duration-300 text-sm sm:text-base">
            FOR BROKERS
          </a>
        </button>
      </div>

    </div>

  </div>

</section>

  <!-- ================= HOW IT WORKS ================= -->
<section class="py-10 bg-white">

  <div class="max-w-6xl mx-auto px-4">

    <!-- Heading -->
    <h2 class="text-2xl md:text-3xl font-bold text-center text-royal mb-8">
      How PropertyHub Works
    </h2>

    <!-- STEP 1 -->
    <div class="grid md:grid-cols-2 gap-6 items-center mb-6">

      <div>
        <h3 class="text-xl font-semibold mb-2 text-lg">
          Simple Property Listing
        </h3>

        <p class="text-gray-600 leading-relaxed text-sm sm:text-base">
           PropertyHub makes listing your property quick and hassle-free. 
          Owners and brokers can add property details such as location, pricing, images, 
          and key features within minutes. Our streamlined process ensures your listing 
          goes live instantly, helping you reach potential buyers without delays.
        </p>
      </div>

      <div class="flex justify-center">
        <img src="Images/step1.png" class="w-56 hover:scale-105 transition duration-300">
      </div>

    </div>

    <!-- STEP 2 -->
    <div class="grid md:grid-cols-2 gap-6 items-center mb-6">

      <div class="order-2 md:order-1 flex justify-center">
        <img src="Images/step2.png" class="w-56 hover:scale-105 transition duration-300">
      </div>

      <div class="order-1 md:order-2">
        <h3 class="text-xl font-semibold mb-2 text-lg">
          Buyers Discover Properties
        </h3>

        <p class="text-gray-600 leading-relaxed text-sm sm:text-base">
          Buyers can easily explore a wide range of properties using smart filters 
          like city, budget, and property type. Our intuitive search experience helps 
          users quickly find properties that match their exact requirements, saving 
          time and effort during the decision-making process.
        </p>
      </div>

    </div>

    <!-- STEP 3 -->
    <div class="grid md:grid-cols-2 gap-6 items-center mb-6">

      <div>
        <h3 class="text-xl font-semibold mb-2 text-lg">
          Connect Easily
        </h3>

        <p class="text-gray-600 leading-relaxed text-sm sm:text-base">
          Once a buyer finds a suitable property, they can directly connect with 
          the owner or broker through the platform. Discuss details, 
          and clarify queries seamlessly without unnecessary middlemen, ensuring 
          faster communication and better transparency.
        </p>
      </div>

      <div class="flex justify-center">
        <img src="Images/step3.png" class="w-56 hover:scale-105 transition duration-300">
      </div>

    </div>

    <!-- STEP 4 -->
    <div class="grid md:grid-cols-2 gap-6 items-center">

      <div class="order-2 md:order-1 flex justify-center">
        <img src="Images/step4.png" class="w-56 hover:scale-105 transition duration-300">
      </div>

      <div class="order-1 md:order-2">
        <h3 class="text-xl font-semibold mb-2 text-lg">
          Close Deals Faster
        </h3>

        <p class="text-gray-600 leading-relaxed text-sm sm:text-base">
          With direct communication and organized property management, closing deals 
          becomes faster and more efficient. PropertyHub simplifies the entire process, 
          helping buyers, sellers, and brokers finalize transactions smoothly with 
          confidence and complete transparency.
        </p>
      </div>

    </div>

  </div>

</section>

  <!-- Why Choose -->
  <section class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 text-center">

      <h2 class="text-3xl font-bold text-royal mb-12">
        Why Choose PropertyHub?
      </h2>

      <div class="grid md:grid-cols-3 gap-8">

        <div>
          <i class="fa-solid fa-shield-halved text-4xl text-royal mb-4"></i>
          <h3 class="font-semibold text-lg mb-2">Verified Listings</h3>
          <p class="text-gray-600 text-sm">All properties are verified for safety and transparency.</p>
        </div>

        <div>
          <i class="fa-solid fa-hand-holding-dollar text-4xl text-royal mb-4"></i>
          <h3 class="font-semibold text-lg mb-2">Best Price Deals</h3>
          <p class="text-gray-600 text-sm">Get the best deals with no hidden charges.</p>
        </div>

        <div>
          <i class="fa-solid fa-headset text-4xl text-royal mb-4"></i>
          <h3 class="font-semibold text-lg mb-2">24/7 Support</h3>
          <p class="text-gray-600 text-sm">Dedicated support team for buyers and owners.</p>
        </div>

      </div>
    </div>
  </section>

  <!-- ================= TESTIMONIALS ================= -->
<section class="py-10 sm:py-16 bg-white">
  <div class="max-w-6xl mx-auto px-4 text-center">

    <h2 class="text-2xl sm:text-3xl font-bold text-royal mb-8 sm:mb-10">
      Client Reviews
    </h2>

    <!-- Carousel Wrapper -->
    <div class="relative overflow-hidden">

      <!-- ✅ IMPORTANT CHANGE -->
      <div id="testimonialCarousel"
class="grid grid-cols-1 sm:grid-cols-2 md:flex md:transition-transform md:duration-500 md:ease-in-out gap-4 sm:gap-6 justify-center md:justify-start">

<?php
include "db.php";

$result = mysqli_query($conn,"
SELECT * FROM feedback
ORDER BY created_at DESC
LIMIT 10
");

while($row = mysqli_fetch_assoc($result)){

    $stars = str_repeat("⭐", $row['rating']);
?>

<!-- ✅ CARD -->
<div class="w-full sm:w-full md:flex-none md:w-1/3 px-0 md:px-4">
  <div class="bg-card p-4 sm:p-6 rounded-xl shadow-md border border-lightroyal h-full">

<?php
if($row['gender'] == 'female'){
    $image = "Images/woman.png";
} else {
    $image = "Images/man.png";
}
?>

<img src="<?php echo $image; ?>"
class="w-16 h-16 sm:w-20 sm:h-20 mx-auto rounded-full mb-3 sm:mb-4 border-4 border-royal object-cover">

    <p class="text-navy text-xs sm:text-sm">
      "<?php echo $row['message']; ?>"
    </p>

    <p class="text-yellow-500 mt-2 text-sm"><?php echo $stars; ?></p>

    <h3 class="text-royal font-semibold mt-2 text-sm sm:text-base">
      – <?php echo $row['name']; ?>
    </h3>

  </div>
</div>

<?php } ?>

      </div>

    </div>

    <!-- ✅ BUTTONS (HIDE ON MOBILE) -->
    <div class="hidden md:flex justify-center mt-8 space-x-6">
      <button id="prevTestimonial"
        class="bg-royal text-white px-6 py-2 rounded-lg hover:bg-lightroyal transition">
        &larr;
      </button>

      <button id="nextTestimonial"
        class="bg-royal text-white px-6 py-2 rounded-lg hover:bg-lightroyal transition">
        &rarr;
      </button>
    </div>

  </div>
</section>

<!-- ================= FEEDBACK SECTION ================= --> 
<section class="relative py-12 md:py-20 overflow-hidden bg-white">

  <!-- CONTENT -->
  <div class="max-w-3xl mx-auto px-4 sm:px-6 grid grid-cols-1 md:grid-cols-2 items-center gap-8 md:gap-10">

    <!-- LEFT IMAGE -->
    <div class="flex justify-center">
      <img src="Images/feedback.png"
           class="w-40 sm:w-56 md:w-72 transition duration-500">
    </div>

    <!-- RIGHT CONTENT -->
    <div class="text-center md:text-left">

      <h2 class="text-2xl sm:text-3xl font-bold text-royal mb-4 leading-snug">
        Tell Us About Your Experience
      </h2>

      <p class="text-gray-600 mb-5 text-sm sm:text-base leading-relaxed">
        Share your experience with PropertyHub. Your feedback helps us improve and create a better platform for everyone.
      </p>

      <p class="text-sm text-gray-500 mb-6">
        ⭐ Trusted by 1,000+ users
      </p>

      <a href="feedback.php"
         class="inline-block bg-royal text-white px-6 sm:px-7 py-3 rounded-lg font-semibold 
         hover:bg-lightroyal transition duration-300 shadow-md hover:shadow-lg">
         
         <i class="fa-solid fa-star mr-2"></i> Give Feedback
      </a>

    </div>

  </div>

</section>

  <!-- Footer -->
  <div id="footer-container"></div>

  <!-- Properties Scroll -->
  <script>
    const container = document.getElementById('propertiesContainer');
    const nextBtn = document.getElementById('nextProperty');
    const prevBtn = document.getElementById('prevProperty');

    nextBtn.addEventListener('click', () => {
      container.scrollBy({ left: 300, behavior: 'smooth' });
    });
    prevBtn.addEventListener('click', () => {
      container.scrollBy({ left: -300, behavior: 'smooth' });
    });

    //image scroll

    const elements = document.querySelectorAll(
      ".reveal-left, .reveal-right"
    );

    const observer = new IntersectionObserver((entries) => {

      entries.forEach(entry => {

        if (entry.isIntersecting) {

          entry.target.classList.remove("opacity-0");

          if (entry.target.classList.contains("reveal-left")) {
            entry.target.classList.remove("-translate-x-32");
          }

          if (entry.target.classList.contains("reveal-right")) {
            entry.target.classList.remove("translate-x-32");
          }

        }

      });

    }, { threshold: 0.25 });

    elements.forEach(el => observer.observe(el));
  </script>



  <!-- Scripts -->
  <script src="js/loadNavbar.js"></script>
  <script src="js/review.js"></script>
  <script src="js/loadFooter.js"></script>

  <!-- ================= FLOATING CHAT BUTTON ================= -->
<button id="chatToggle"
class="fixed bottom-6 right-6 bg-royal text-white w-16 h-16 rounded-full shadow-xl hover:bg-lightroyal flex items-center justify-center z-50">
<i class="fa fa-comments text-2xl"></i>
</button>

<!-- ================= CHAT BOX ================= -->
<div id="chatBox"
class="fixed bottom-24 right-6 w-80 bg-white rounded-2xl shadow-2xl hidden flex flex-col overflow-hidden z-50">

<!-- Header -->
<div class="bg-royal text-white p-4 font-semibold flex justify-between items-center">
    Property AI Assistant
    <button onclick="toggleChat()">✖</button>
</div>

<!-- Messages -->
<div id="chatMessages" class="flex-1 p-4 overflow-y-auto text-sm space-y-2 h-80 bg-gray-50"></div>

<!-- Input -->
<div class="flex border-t">
    <input id="chatInput" type="text" placeholder="Ask about properties..."
        class="flex-1 p-3 outline-none">
    <button onclick="sendMessage()"
        class="bg-royal text-white px-4">Send</button>
</div>

</div>

<script>
const chatBox = document.getElementById("chatBox");
const chatMessages = document.getElementById("chatMessages");

function toggleChat() {
    chatBox.classList.toggle("hidden");
}

document.getElementById("chatToggle").addEventListener("click", toggleChat);

// ✅ ADD HERE
const chatInput = document.getElementById("chatInput");

chatInput.addEventListener("keydown", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        sendMessage();
    }
});

function addMessage(message, sender) {
    const div = document.createElement("div");

    div.className = sender === "user"
        ? "text-right"
        : "text-left";

    div.innerHTML = `
        <span class="inline-block px-3 py-2 rounded-lg ${
            sender === "user"
            ? "bg-royal text-white"
            : "bg-gray-200"
        }">
        ${message}
        </span>
    `;

    chatMessages.appendChild(div);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

async function sendMessage() {
    const input = document.getElementById("chatInput");
    const message = input.value.trim();

    if (!message) return;

    addMessage(message, "user");
    input.value = "";

    // Loading message
    const typingDiv = document.createElement("div");
typingDiv.id = "typing";
typingDiv.innerHTML = `<span class="bg-gray-200 px-3 py-2 rounded-lg">Typing...</span>`;
chatMessages.appendChild(typingDiv);

    try {
        const response = await fetch("chat-api.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ message })
        });

        const data = await response.json();

        // remove "Typing..."
        document.getElementById("typing")?.remove();

        addMessage(data.reply, "bot");

    } catch (error) {
        chatMessages.lastChild.remove();
        addMessage("Error connecting to AI", "bot");
    }
}
</script>

</body>

</html>