document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registration');
    const firstnameInput = document.getElementById('firstname');
    const lastnameInput = document.getElementById('lastname');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('confirm');
    const errorMsg_username = document.getElementById('err-username');
    const errorMsg_pwd = document.getElementById('err-pwd');

    // Clear previous error messages
    // errorMsg = errorMsg.textContent.replace('Error: ', '');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form from submitting by default

        // Validate inputs
        const firstname = firstnameInput.value;
        const lastname = lastnameInput.value;
        const username = usernameInput.value;
        const password = passwordInput.value;
        const confirm = confirmInput.value;
        let valid = true;
        
        if (firstname === '' || firstname === null) {
            valid = false;
            // errorMsg_username.textContent += 'Username is required. ';

            console.log("firstname empty");
            errorMsg_username.style.display = "block";
        }

        if (lastname === '' || lastname === null) {
            valid = false;
            // errorMsg_username.textContent += 'Username is required. ';

            console.log("lastname empty");
            errorMsg_username.style.display = "block";
        }

        if (username === '' || username === null) {
            valid = false;
            // errorMsg_username.textContent += 'Username is required. ';

            console.log("username empty");
            errorMsg_username.style.display = "block";
        } else {
            errorMsg_username.style.display = "none";

        }

        if (password === '' || password === null) {
            valid = false;
            // errorMsg_pwd.textContent += 'Password is required. ';
            console.log("pwd empty");

            errorMsg_pwd.style.display = "block";
        } else {
            errorMsg_pwd.style.display = "none";
        }

        if (confirm === '' || confirm === null) {
            valid = false;
            // errorMsg_pwd.textContent += 'Password is required. ';
            console.log("confirm empty");

            errorMsg_pwd.style.display = "block";
        }

        // If valid, allow form submission (or handle login logic here)
        if (valid) {
            //alert('Login successful'); // Replace with actual login logic
            form.submit();
        } else {
            // alert('Please fix the errors before submitting.');
        }


        // call the api
    });
});
