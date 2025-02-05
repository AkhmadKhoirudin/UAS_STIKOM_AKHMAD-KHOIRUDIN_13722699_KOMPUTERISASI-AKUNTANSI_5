window.onload = function () {
  // Periksa jika pengguna sudah login dengan localStorage
  if (!localStorage.getItem('loggedIn')) {
    window.location.href = 'login.html'; // Jika belum login, arahkan ke halaman login
    return; // Hentikan eksekusi lebih lanjut
  }

  // Ambil data dari localStorage
  const username = localStorage.getItem('username');
  const userId = localStorage.getItem('userId');

  // // Periksa apakah username dan userId tersedia
  // if (!username || !userId) {
  //   window.location.href = 'login.html'; // Jika salah satu tidak ada, arahkan ke halaman login
  //   return;
  // }

  // Periksa apakah elemen untuk username dan userId tersedia di halaman
  const usernameDisplay = document.getElementById('usernameDisplay');
  const userIdDisplay = document.getElementById('userIdDisplay');

  if (usernameDisplay) {
    usernameDisplay.innerText = username;
  }

  if (userIdDisplay) {
    userIdDisplay.innerText = `ID: ${userId}`;
  }
};
