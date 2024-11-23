document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (username && password) {
        // Redirect to Farmer User's Landing Page
        window.location.href = "../FarmerUser/LandingFarmer.html";
    } else {
        alert("Please enter valid login credentials!");
    }
});
