document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('edit');
    //const photoInput = document.getElementById('photo');
    const firstnameInput = document.getElementById('firstname');
    const lastnameInput = document.getElementById('lastname');
    const usernameInput = document.getElementById('username');
    //const errorMsg_photo = document.getElementById('err-photo');
    const errorMsg_firstname = document.getElementById('err-firstname');
    const errorMsg_lastname = document.getElementById('err-lastname');
    const errorMsg_username = document.getElementById('err-username');
    
    // Clear previous error messages
    // errorMsg = errorMsg.textContent.replace('Error: ', '');

    form.addEventListener('submit', async function(event) {
        event.preventDefault(); // Prevent form from submitting by default

        // Validate inputs
        //const photo = photoInput.value;
        const firstname = firstnameInput.value;
        const lastname = lastnameInput.value;
        const username = usernameInput.value;

        let valid = true;

        //The user does not have to choose a photo if he does not want to.

        if (firstname === '' || firstname === null) {
            valid = false;
            // errorMsg_username.textContent += 'Username is required. ';

            console.log("firstname empty");
            errorMsg_firstname.style.display = "block";
        } else {
            errorMsg_firstname.style.display = "none";
        }

        if (lastname === '' || lastname === null) {
            valid = false;
            // errorMsg_username.textContent += 'Username is required. ';

            console.log("lastname empty");
            errorMsg_lastname.style.display = "block";
        } else {
            errorMsg_lastname.style.display = "none";
        }

        if (username === '' || username === null) {
            valid = false;
            // errorMsg_username.textContent += 'Username is required. ';

            console.log("username empty");
            errorMsg_username.style.display = "block";
        } else {
            errorMsg_username.style.display = "none";

        }
        
        bodyMessage = {
            //photo: photo,
            firstname: firstname,
            lastname: lastname,
            username: username,
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
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('edit-pwd');
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('confirm');
    const errorMsg_pwd = document.getElementById('err-password');
    const errorMsg_confirm = document.getElementById('err-confirm');

    form.addEventListener('submit', async function(event) {
        event.preventDefault(); // Prevent form from submitting by default

        // Validate inputs
        const password = passwordInput.value;
        const confirm = confirmInput.value;
        let valid = true;

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
        } else {
            errorMsg_pwd.style.display = "none";
        }

        if (password !== confirm) {
            valid = false;
            // errorMsg_pwd.textContent += 'Password is required. ';
            console.log("pwd not match");

            errorMsg_confirm.style.display = "block";
        } else {
            errorMsg_confirm.style.display = "none";
        }

        bodyMessage = {
            password: password,
        };

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