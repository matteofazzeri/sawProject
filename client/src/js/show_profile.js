class Profile {
  async showProfile() {

    if (await get_user_status()['isLogged']) {
      console.log("dio can");
    }


    try {
      const response = await fetch(`${backendUrl.production}p`, {
        method: 'GET',
      });
      const data = await response.json();
      const profileData = data[0];

      if (localStorage.getItem('email') !== profileData.email) {
        localStorage.setItem('email', profileData.email);
        sessionStorage.setItem('email', profileData.email);
      }

      document.getElementById('show-profile').innerHTML = `
        <label for="first-name">First Name:</label>
        <input type="text" id="first-name" class="profile-input" value="${profileData.first_name}" readonly disabled>
        
        <label for="last-name">Last Name:</label>
        <input type="text" id="last-name" class="profile-input" value="${profileData.last_name}" readonly disabled>
        
        <label for="email">Email:</label>
        <input type="text" id="email" class="profile-input" value="${profileData.email}" readonly disabled>
        
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
    };

    document.getElementById('show-profile').innerHTML = `
      <label for="first-name">First Name:</label>
      <input type="text" id="first-name" class="profile-input" value="${profileData.first_name}">
      
      <label for="last-name">Last Name:</label>
      <input type="text" id="last-name" class="profile-input" value="${profileData.last_name}">
      
      <label for="email">Email:</label>
      <input type="email" id="email" class="profile-input" value="${profileData.email}">
      
      <button onclick="profile.updateProfile(event)">Update Profile</button>
    `;
  }

  async updateProfile(event) {
    event.preventDefault(); // Ensure the event object is passed correctly

    const inputs = document.querySelectorAll('.profile-input');
    const profileData = {
      firstname: DOMPurify.sanitize(inputs[0].value),
      lastname: DOMPurify.sanitize(inputs[1].value),
      email: DOMPurify.sanitize(inputs[2].value),
    };

    try {
      const response = await fetch(`${backendUrl.production}p`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(profileData),
      });

      if (!response.ok) {
        throw new Error('Error updating user profile');
      }

      // Optionally, refresh the profile view after updating
      this.showProfile();
    } catch (error) {
      console.error('Error updating user profile:', error);
    }
  }
}

class detailsProfile extends Profile {
  async showDetails() {
    try {
      const response = await fetch(`${backendUrl.production}p/details`, {
        method: 'GET',
      });
      const data = await response.json();

      console.log(data);

      const profileData = data[0] || {};

      document.getElementById('show-details').innerHTML = `
        <label for="username">Public Name:</label>
        <input type="text" id="username" class="detail-input" value="${profileData.username || ""}" readonly disabled>
        
        <label for="phone-number">Phone number:</label>
        <input type="text" id="phone-number" class="detail-input" value="${profileData.phone_number || ""}" readonly disabled>
        
        <label for="birthdate">birthdate:</label>
        <input type="text" id="birthdate" class="detail-input" value="${profileData.birthdate || ""}" readonly disabled>
        
        <label for="bio">A little bit about you:</label>
        <textarea type="text" id="bio" class="detail-input" readonly disabled >${profileData.bio || ""}</textarea>
        
        <button onclick="profileDetails.editDetails()">Edit details</button>
      `;
    } catch (error) {
      console.error('Error fetching user profile:', error);
    }
  }

  editDetails() {
    const inputs = document.querySelectorAll('.detail-input');
    const profileData = {
      username: inputs[0].value,
      phone_number: inputs[1].value,
      birthdate: inputs[2].value,
      bio: inputs[3].value,
    };

    document.getElementById('show-details').innerHTML = `
      <label for="username">Public Name:</label>
      <input type="text" id="username" class="detail-input" value="${profileData.username}">
      
      <label for="phone-number">Phone number:</label>
      <input type="number" id="phone-number" class="detail-input" value="${profileData.phone_number}">
      
      <label for="birthdate">birthdate:</label>
      <input type="date" id="birthdate" class="detail-input" value="${profileData.birthdate}">
      
      <label for="bio">A little bit about you:</label>
      <textarea type="text" id="bio" class="detail-input" >${profileData.bio}</textarea>
      
      <button onclick="profileDetails.updateDetails(event)">Update detail</button>
    `;
  }

  async updateDetails(event) {
    event.preventDefault(); // Ensure the event object is passed correctly

    const inputs = document.querySelectorAll('.detail-input');
    const profileData = {
      username: DOMPurify.sanitize(inputs[0].value),
      phone_number: DOMPurify.sanitize(inputs[1].value),
      birthdate: DOMPurify.sanitize(inputs[2].value),
      bio: DOMPurify.sanitize(inputs[3].value),
    };

    try {
      const response = await fetch(`${backendUrl.production}p/details`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(profileData),
      });

      if (!response.ok) {
        throw new Error('Error updating user profile');
      }

      // Optionally, refresh the profile view after updating
      this.showDetails();
    } catch (error) {
      console.error('Error updating user profile:', error);
    }
  }
}

const profile = new Profile();
const profileDetails = new detailsProfile();