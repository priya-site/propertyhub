function initLoginForm() {

    const form = document.getElementById("loginForm");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const role = document.getElementById("loginRole").value;
        const email = document.getElementById("loginEmail").value.trim();
        const password = document.getElementById("loginPassword").value.trim();

        const roleError = document.getElementById("roleError");
        const emailError = document.getElementById("emailError");
        const passwordError = document.getElementById("passwordError");

        // Reset errors
        roleError.classList.add("hidden");
        emailError.classList.add("hidden");
        passwordError.classList.add("hidden");
        roleError.innerText = "";
        emailError.innerText = "";
        passwordError.innerText = "";

        let isValid = true;

        // Role Validation
        if (role === "") {
            roleError.innerText = "Please select who you are";
            roleError.classList.remove("hidden");
            isValid = false;
        }

        if (email === "") {
            emailError.innerText = "Email is required";
            emailError.classList.remove("hidden");
            isValid = false;
        } 
        else if (!email.includes("@")) {
            emailError.innerText = "Please enter valid email";
            emailError.classList.remove("hidden");
            isValid = false;
        }

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

        if (isValid) {
            alert("Login Successful!");
            form.reset();
        }
    });
}

// Run automatically on normal login.html page
document.addEventListener("DOMContentLoaded", initLoginForm);

// Make globally accessible
window.initLoginForm = initLoginForm;