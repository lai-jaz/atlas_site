document.getElementById('show-login').addEventListener('click', function () {
    document.querySelector('.popup').classList.add('active');
});

document.querySelector('.close-btn').addEventListener('click', function () {
    document.querySelector('.popup').classList.remove('active');
});

document.getElementById('login-btn').addEventListener('click', function () {
    // Add login functionality here
    alert("Logging in");
});