fetch("login.html")
    .then(response => response.text())
    .then(data => {
        document.getElementById("login-container").innerHTML = data;

        // Wait a tiny bit then attach validation
        setTimeout(() => {
            if (window.initLoginForm) {
                window.initLoginForm();
            }
        }, 100);
    });