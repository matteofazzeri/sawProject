document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('login');
  const emailInput = document.getElementById('email');
  const passwordInput = document.getElementById('password');
  const rememberInput = document.getElementById('remember');
  const errorMsg_email = document.getElementById('err-email');
  const errorMsg_pwd = document.getElementById('err-pwd');

  form.addEventListener('submit', async function (event) {
    event.preventDefault();

    // Sanitize inputs using DOMPurify
    const email = DOMPurify.sanitize(emailInput.value);
    const password = DOMPurify.sanitize(passwordInput.value);
    let valid = true;

    if (email === '' || email === null) {
      valid = false;
      // console.log("email empty"); 
      errorMsg_email.style.display = "block";
    } else {
      errorMsg_email.style.display = "none";
    }

    if (password === '' || password === null) {
      valid = false;
      // console.log("pwd empty"); 
      errorMsg_pwd.style.display = "block";
    } else {
      errorMsg_pwd.style.display = "none";
    }

    const remember = rememberInput.checked;

    // if (rememberInput.checked) localStorage.setItem('email', email);

    const bodyMessage = {
      email: email,
      password: password,
      remember: remember,
    };

    // console.log(JSON.stringify(bodyMessage)); 

    if (valid) {
      const response = await fetch(`${backendUrl.development}l`, {
        method: "POST",
        body: JSON.stringify(bodyMessage),
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      } else {
        console.log("Login successful"); 
        sessionStorage.setItem('email', email);
      }
    }
  });
});
