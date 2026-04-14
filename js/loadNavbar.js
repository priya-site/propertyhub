document.addEventListener("DOMContentLoaded", function () {
    fetch("navbar.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("navbar-container").innerHTML = data;

            // AFTER navbar loads, run dropdown script
            initializeNavbar();
        })
        .catch(error => console.error("Error loading navbar:", error));
});


function initializeNavbar() {

    const menuBtn = document.getElementById("menuBtn");
    const navLinks = document.getElementById("navLinks");
    const propertyBtn = document.getElementById("propertyBtn");
    const propertyDropdown = document.getElementById("propertyDropdown");

    // ✅ NEW: Profile Dropdown Elements
    const profileBtn = document.getElementById("profileBtn");
    const profileDropdown = document.getElementById("profileDropdown");

    // Mobile Menu Toggle
    if (menuBtn && navLinks) {
        menuBtn.addEventListener("click", function () {
            navLinks.classList.toggle("hidden");
        });
    }

    // Property Dropdown Toggle
    if (propertyBtn && propertyDropdown) {
        propertyBtn.addEventListener("click", function (e) {
            e.stopPropagation();
            propertyDropdown.classList.toggle("hidden");
        });

        window.addEventListener("click", function (e) {
            if (!propertyBtn.contains(e.target) &&
                !propertyDropdown.contains(e.target)) {
                propertyDropdown.classList.add("hidden");
            }
        });
    }

    // ✅ NEW: Profile Dropdown Toggle
    if (profileBtn && profileDropdown) {
        profileBtn.addEventListener("click", function (e) {
            e.stopPropagation();
            profileDropdown.classList.toggle("hidden");
        });

        window.addEventListener("click", function (e) {
            if (!profileBtn.contains(e.target) &&
                !profileDropdown.contains(e.target)) {
                profileDropdown.classList.add("hidden");
            }
        });
    }
}

// ✅ GLOBAL LOGOUT FUNCTIONS
function openLogoutModal() {
    const modal = document.getElementById("logoutModal");
    if (modal) {
        modal.classList.remove("hidden");
        modal.classList.add("flex");
    }
}

function closeLogoutModal() {
    const modal = document.getElementById("logoutModal");
    if (modal) {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
    }
}
