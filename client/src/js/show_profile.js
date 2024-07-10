async function showProfile() {

  await fetch(`${backendUrl.development}p`, {
    method: 'GET',
  })
    .then(response => response.json())
    .then(data => {
      // Handle data
      data = data[0];
      console.log('User profile:', data);

      // split full name into first and last name

      // Use firstName and lastName as needed

      document.getElementById('show-profile').innerHTML = `
        <p><strong>Full Name:</strong> ${data.full_name}</p>

        <p><strong>Email:</strong> ${data.email}</p>
        <p><strong>username:</strong> ${data.username}</p>
      `;
    })
    .catch(error => {
      // Handle error
      console.error('Error fetching user profile:', error);
    });
}