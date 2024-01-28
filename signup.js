document.getElementById('show-signup').addEventListener('click', function () {
    document.querySelector('.popup').classList.add('active');
});

document.querySelector('.close-btn').addEventListener('click', function () {
    document.querySelector('.popup').classList.remove('active');
});

document.getElementById('signup-btn').addEventListener('click', function () {
    // Get user input from form fields
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    // Perform signup logic (this is a basic example, replace it with your actual signup process)
    if (name && email && password) {
        console.log('Signing up with:');
        console.log('Name: ' + name);
        console.log('Email: ' + email);
        console.log('Password: ' + password);

        document.querySelector('.popup').classList.remove('active');
    } else {
        alert('Please fill in all the required fields.');
    }
});