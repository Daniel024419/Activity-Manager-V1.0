document
    .getElementById("loginForm")
    .addEventListener("submit", function (event) {
        // Prevent form submission
        event.preventDefault();

        // Clear previous error messages
        clearErrorMessages();

        // Validate fields
        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;

        let isValid = true;

        if (!validateEmail(email)) {
            setError("email", "Please enter a valid email address");
            isValid = false;
        }

        if (password.trim() === "") {
            setError("password", "Password cannot be empty");
            isValid = false;
        }

        if (isValid) {
            this.submit(); // Submit the form if validation is successful
        }
    });

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
}

function setError(id, message) {
    const inputField = document.getElementById(id);
    const errorMessage = inputField.nextElementSibling;
    errorMessage.innerText = message;
    errorMessage.style.visibility = "visible";
    inputField.style.borderColor = "red";
}

function clearErrorMessages() {
    const errorMessages = document.querySelectorAll(".input-group small");
    errorMessages.forEach(function (msg) {
        msg.style.visibility = "hidden";
    });

    const inputs = document.querySelectorAll(".input-group input");
    inputs.forEach(function (input) {
        input.style.borderColor = "#ccc";
    });
}
