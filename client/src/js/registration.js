document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('registration');
  const firstnameInput = document.getElementById('firstname');
  const lastnameInput = document.getElementById('lastname');
  const emailInput = document.getElementById('email');
  const usernameInput = document.getElementById('username');
  const passwordInput = document.getElementById('password');
  const confirmInput = document.getElementById('confirm');
  const errorMsg_firstname = document.getElementById('err-firstname');
  const errorMsg_lastname = document.getElementById('err-lastname');
  const errorMsg_email = document.getElementById('err-email');
  //const errorMsg_username = document.getElementById('err-username');
  const errorMsg_pwd = document.getElementById('err-password');
  const errorMsg_confirm = document.getElementById('err-confirm');

  // Clear previous error messages
  // errorMsg = errorMsg.textContent.replace('Error: ', '');

  form.addEventListener('submit', async function (event) {
    event.preventDefault(); // Prevent form from submitting by default

    // Validate inputs
    const firstname = firstnameInput.value;
    const lastname = lastnameInput.value;
    const email = emailInput.value;
    const username = usernameInput.value;
    const password = passwordInput.value;
    const confirm = confirmInput.value;
    let valid = true;

    if (firstname === '' || firstname === null) {
      valid = false;
      // errorMsg_username.textContent += 'Username is required. ';
      // console.log("firstname empty");
      errorMsg_firstname.style.display = "block";
    } else {
      errorMsg_firstname.style.display = "none";
    }

    if (lastname === '' || lastname === null) {
      valid = false;
      // errorMsg_username.textContent += 'Username is required. ';
      // console.log("lastname empty");
      errorMsg_lastname.style.display = "block";
    } else {
      errorMsg_lastname.style.display = "none";
    }

    if (email === '' || email === null) {
      valid = false;
      // errorMsg_username.textContent += 'Username is required. ';
      // console.log("email empty");
      errorMsg_email.style.display = "block";
    } else {
      errorMsg_email.style.display = "none";
    }

    if (password === '' || password === null) {
      valid = false;
      // errorMsg_pwd.textContent += 'Password is required. ';
      // console.log("pwd empty");
      errorMsg_pwd.style.display = "block";
    } else {
      errorMsg_pwd.style.display = "none";
    }

    if (confirm === '' || confirm === null) {
      valid = false;
      // errorMsg_pwd.textContent += 'Password is required. ';
      // console.log("confirm empty");
      errorMsg_pwd.style.display = "block";
    } else {
      errorMsg_pwd.style.display = "none";
    }

    if (password !== confirm) {
      valid = false;
      // errorMsg_pwd.textContent += 'Password is required. ';
      // console.log("pwd not match");
      errorMsg_confirm.style.display = "block";
    } else {
      errorMsg_confirm.style.display = "none";
    }

    const bodyMessage = new URLSearchParams();
    bodyMessage.append('firstname', firstname);
    bodyMessage.append('lastname', lastname);
    bodyMessage.append('email', email);
    bodyMessage.append('username', username);
    bodyMessage.append('pass', password);
    bodyMessage.append('confirm', confirm);

    // If valid, allow form submission (or handle login logic here)
    if (valid) {
      const response = await fetch(`${backendUrl.development}r`, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: bodyMessage.toString(),
      });
      console.log(response);
      if (!response.ok) {
        
        const error = document.createElement('div');
        const errorDiv = document.getElementById('errors');
        error.textContent = response.statusText;
        errorDiv.appendChild(error);
        throw new Error(`HTTP error! status: ${response.status}`);

      } else
        window.location.href = "";
    } else {
      alert('Please fix the errors before submitting.');
    }

  });
});
