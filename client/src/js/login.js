document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('login');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const rememberInput = document.getElementById('remember');
    const errorMsg_email = document.getElementById('err-email');
    const errorMsg_pwd = document.getElementById('err-pwd');

    // Clear previous error messages
    // errorMsg = errorMsg.textContent.replace('Error: ', '');

    form.addEventListener('submit', async function(event) { // Added async keyword
        event.preventDefault(); // Prevent form from submitting by default

        // Validate inputs
        const email = emailInput.value;
        const password = passwordInput.value;
        let valid = true;

        if (email === '' || email === null) {
            valid = false;
            // errorMsg_email.textContent += 'email is required. ';

            console.log("email empty");
            errorMsg_email.style.display = "block";
        } else {
            errorMsg_email.style.display = "none";
        }

        if (password === '' || password === null) {
            valid = false;
            // errorMsg_pwd.textContent += 'Password is required. ';
            console.log("pwd empty");

            errorMsg_pwd.style.display = "block";
        } else {
            errorMsg_pwd.style.display = "none";
        }

        if(rememberInput.checked) localStorage.setItem('email', email);
        const bodyMessage = {
            email: email,
            password: password,
        };
        console.log(JSON.stringify(bodyMessage));

        // If valid, allow form submission (or handle login logic here)
        if (valid) {
            //alert('Login successful'); // Replace with actual login logic
            const response = await fetch(`${backendUrl.development}l`, {
                method: "POST",
                body: JSON.stringify(bodyMessage),
            });
    
            if(!response.ok)
            {
                throw new Error(`HTTP error! status: ${response.status}`);
            };
            //form.submit();
        } else {
            // alert('Please fix the errors before submitting.');
        }

    });
});
