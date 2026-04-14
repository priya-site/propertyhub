document.getElementById("signupForm").addEventListener("submit", function (e) {

    const name = document.getElementById("fullName").value.trim();
    const contact = document.getElementById("contact").value.trim();
    const email = document.getElementById("signupEmail").value.trim();
    const password = document.getElementById("signupPassword").value.trim();

    const nameError = document.getElementById("nameError");
    const contactError = document.getElementById("contactError");
    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");

    // Reset errors
    [nameError, contactError, emailError, passwordError].forEach(error => {
        error.classList.add("hidden");
        error.innerText = "";
    });

    let isValid = true;

    // Name Validation
    if (name === "") {
        nameError.innerText = "Full Name is required";
        nameError.classList.remove("hidden");
        isValid = false;
    }

    // Contact Validation
    if (contact === "") {
        contactError.innerText = "Contact number is required";
        contactError.classList.remove("hidden");
        isValid = false;
    }
    else if (!/^[0-9]{10}$/.test(contact)) {
        contactError.innerText = "Enter valid 10-digit contact number";
        contactError.classList.remove("hidden");
        isValid = false;
    }

    // Email Validation
    if (email === "") {
        emailError.innerText = "Email is required";
        emailError.classList.remove("hidden");
        isValid = false;
    }
    else if (!email.includes("@")) {
        emailError.innerText = "Please enter a valid email";
        emailError.classList.remove("hidden");
        isValid = false;
    }

    // Password Validation
    if (password === "") {
        passwordError.innerText = "Password is required";
        passwordError.classList.remove("hidden");
        isValid = false;
    }
    else if (password.length < 6) {
        passwordError.innerText = "Password must be at least 6 characters";
        passwordError.classList.remove("hidden");
        isValid = false;
    }
    
    if (!isValid) {
        e.preventDefault();
    }

});