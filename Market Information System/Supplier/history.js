function showSectionById(id) {
    // Hide all sections
    document.querySelectorAll('.section-content').forEach(section => {
        section.classList.add('hidden');
    });

    // Show the selected section
    document.getElementById(id).classList.remove('hidden');
}
// Select the logout button
const logoutButton = document.getElementById('logout-btn');

// Add a click event listener to the button
logoutButton.addEventListener('click', () => {
    // Redirect to the login page
    window.location.href = '/Login_CreateAcc/login.html'; // Replace with the actual path to your login.html
});

// Event listeners for each button
document.getElementById('home-btn').addEventListener('click', function () {
    showSectionById('home-section');
});

document.getElementById('inventory-btn').addEventListener('click', function () {
    showSectionById('inventory-section');
});

document.getElementById('orders-btn').addEventListener('click', function () {
    showSectionById('orders-section');
});

document.getElementById('shipment-btn').addEventListener('click', function () {
    showSectionById('shipment-section');
});

document.getElementById('contacts-btn').addEventListener('click', function () {
    showSectionById('contacts-section');
});

document.getElementById('analytics-btn').addEventListener('click', function () {
    showSectionById('analytics-section');
});

document.getElementById('reports-btn').addEventListener('click', function () {
    showSectionById('reports-section');
});
