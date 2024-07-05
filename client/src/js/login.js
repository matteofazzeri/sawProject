document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('login');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const rememberInput = document.getElementById('remember');
    const errorMsg_username = document.getElementById('err-username');
    const errorMsg_pwd = document.getElementById('err-pwd');

    // Clear previous error messages
    // errorMsg = errorMsg.textContent.replace('Error: ', '');

    form.addEventListener('submit', async function(event) { // Added async keyword
        event.preventDefault(); // Prevent form from submitting by default

        // Validate inputs
        const username = usernameInput.value;
        const password = passwordInput.value;
        let valid = true;

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

        if(rememberInput.checked) localStorage.setItem('username', username);
        bodyMessage = {
            username: username,
            password: password,
        };
        console.log(JSON.stringify(bodyMessage));

        // If valid, allow form submission (or handle login logic here)
        if (valid) {
            //alert('Login successful'); // Replace with actual login logic
            form.submit();
        } else {
            // alert('Please fix the errors before submitting.');
        }

        const response = await fetch(`${backendUrl.development}r`, {
            method: "POST",
            body: JSON.stringify(bodyMessage),
        });

        if(!response.ok)
        {
            throw new Error(`HTTP error! status: ${response.status}`);
        };
    });
});
