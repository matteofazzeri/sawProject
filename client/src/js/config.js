const backendUrl = {
  development: 'http://localhost/sawProject/server/api/',
  production: 'https://saw21.dibris.unige.it/~S5163676/server/api/'
};

async function get_user_status() {
  const response = await fetch(`${backendUrl.production}user/status`, {
    method: 'GET',
  });
  const data = await response.json();

  return data['user_status'];
}

function logout() {
  // delete session and local storage
  sessionStorage.clear();
  localStorage.clear();

  // redirect to login page
  window.location.href = 'logout';
}

document.addEventListener('DOMContentLoaded', function () {
  const profileIcon = document.getElementById('profile');
  const popupProfile = document.getElementById('popup-profile');

  profileIcon.addEventListener('click', function () {
    if (popupProfile.style.display === 'none' || popupProfile.style.display === '') {
      popupProfile.style.display = 'block';
    } else {
      popupProfile.style.display = 'none';
    }
  });

  // Optionally, close the popup when clicking outside of it
  document.addEventListener('click', function (event) {
    if (!profileIcon.contains(event.target) && !popupProfile.contains(event.target)) {
      popupProfile.style.display = 'none';
    }
  });
});
