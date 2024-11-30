document.addEventListener("DOMContentLoaded", () => {
    const captchaBox = document.querySelector(".captcha-box");
    const captchaInput = document.getElementById("captcha");
    const refreshCaptchaBtn = document.querySelector(".refresh-btn");

    // Function to refresh and generate a new CAPTCHA
    function refreshCaptcha() {
        // Send a request to reload the CAPTCHA image
        const captchaImage = document.querySelector("img");
        captchaImage.src = "captcha.php?" + new Date().getTime(); // Prevents caching by appending timestamp
    }

    // Event listener to refresh CAPTCHA when button is clicked
    refreshCaptchaBtn.addEventListener("click", refreshCaptcha);

    // Form validation before submission
    document.querySelector("form").addEventListener("submit", (event) => {
        const enteredCaptcha = captchaInput.value.trim();
        const generatedCaptcha = captchaBox.textContent.trim();

        if (enteredCaptcha === "") {
            event.preventDefault();
            alert("Please enter the CAPTCHA.");
            return;
        }

        if (enteredCaptcha !== generatedCaptcha) {
            event.preventDefault();
            alert("Incorrect CAPTCHA. Please try again.");
            refreshCaptcha(); // Reload CAPTCHA upon failure
        }
    });

    // Initialize CAPTCHA on page load
    refreshCaptcha();
});
