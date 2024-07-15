class Profile {
  async showProfile() {
    try {
      const response = await fetch(`${backendUrl.development}p`, {
        method: 'GET',
      });
      const data = await response.json();
      const profileData = data[0];

      console.log(profileData);

      document.getElementById('show-profile').innerHTML = `
        <label for="first-name">First Name:</label>
        <input type="text" id="first-name" class="profile-input" value="${profileData.first_name}" readonly disabled>
        
        <label for="last-name">Last Name:</label>
        <input type="text" id="last-name" class="profile-input" value="${profileData.last_name}" readonly disabled>
        
        <label for="email">Email:</label>
        <input type="text" id="email" class="profile-input" value="${profileData.email}" readonly disabled>
        
        <label for="username">Username:</label>
        <input type="text" id="username" class="profile-input" value="${profileData.username}" readonly disabled>
        
        <button onclick="profile.editProfile()">Edit Profile</button>
      `;
    } catch (error) {
      console.error('Error fetching user profile:', error);
    }
  }

  editProfile() {
    const inputs = document.querySelectorAll('.profile-input');
    const profileData = {
      first_name: inputs[0].value,
      last_name: inputs[1].value,
      email: inputs[2].value,
      username: inputs[3].value,
    };

    document.getElementById('show-profile').innerHTML = `
      <label for="first-name">First Name:</label>
      <input type="text" id="first-name" class="profile-input" value="${profileData.first_name}">
      
      <label for="last-name">Last Name:</label>
      <input type="text" id="last-name" class="profile-input" value="${profileData.last_name}">
      
      <label for="email">Email:</label>
      <input type="email" id="email" class="profile-input" value="${profileData.email}">
      
      <label for="username">Username:</label>
      <input type="text" id="username" class="profile-input" value="${profileData.username}">
      
      <button onclick="profile.updateProfile(event)">Update Profile</button>
    `;
  }

  async updateProfile(event) {
    event.preventDefault(); // Ensure the event object is passed correctly

    const inputs = document.querySelectorAll('.profile-input');
    const profileData = {
      first_name: DOMPurify.sanitize(inputs[0].value),
      last_name: DOMPurify.sanitize(inputs[1].value),
      email: DOMPurify.sanitize(inputs[2].value),
      username: DOMPurify.sanitize(inputs[3].value),
    };

    try {
      const response = await fetch(`${backendUrl.development}p`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(profileData),
      });
      const data = await response.json();
      console.log(data);

      // Optionally, refresh the profile view after updating
      this.showProfile();
    } catch (error) {
      console.error('Error updating user profile:', error);
    }
  }
}

const profile = new Profile();
