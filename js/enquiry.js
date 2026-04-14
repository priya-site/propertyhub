document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("enquiryForm");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const role = document.getElementById("roleSelected").innerText;
        const name = form.querySelector("input[type='text']").value.trim();
        const email = form.querySelector("input[type='email']").value.trim();
        const phone = form.querySelector("input[type='tel']").value.trim();

        const roleError = document.getElementById("roleError");
        const nameError = document.getElementById("nameError");
        const emailError = document.getElementById("emailError");
        const phoneError = document.getElementById("phoneError");
        const successMessage = document.getElementById("successMessage");

        // Hide previous messages
        [roleError, nameError, emailError, phoneError].forEach(error => {
            error.classList.add("hidden");
            error.innerText = "";
        });

        successMessage.classList.add("hidden");

        let isValid = true;

        // Role Validation
        if (role === "Select Role") {
            roleError.innerText = "Please select your role";
            roleError.classList.remove("hidden");
            isValid = false;
        }

        // Name Validation
        if (name === "") {
            nameError.innerText = "Name is required";
            nameError.classList.remove("hidden");
            isValid = false;
        }

        // Email Validation
        if (email === "") {
            emailError.innerText = "Email is required";
            emailError.classList.remove("hidden");
            isValid = false;
        }
        else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            emailError.innerText = "Enter a valid email";
            emailError.classList.remove("hidden");
            isValid = false;
        }

        // Phone Validation
        if (phone === "") {
            phoneError.innerText = "Phone number is required";
            phoneError.classList.remove("hidden");
            isValid = false;
        }
        else if (!/^[6-9]\d{9}$/.test(phone)) {
            phoneError.innerText = "Enter valid 10-digit number";
            phoneError.classList.remove("hidden");
            isValid = false;
        }

        // If everything valid
        if (isValid) {
            successMessage.classList.remove("hidden");
            form.reset();
            document.getElementById("roleSelected").innerText = "Select Role";
        }

    });

});