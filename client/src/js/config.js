const backendUrl = {
  development: 'http://localhost/sawProject/server/api/',
  production: 'https://saw21.dibris.unige.it/~S5163676/server/api/'
};

async function get_user_status() {
  const response = await fetch(`${backendUrl.development}/user/status`, {
    method: 'GET',
  });
  const data = await response.json();
  return data['user_status'];
}

