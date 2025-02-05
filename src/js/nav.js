function showsidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.style.display = 'flex'; // Menampilkan sidebar
}

function hidesidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.style.display = 'none'; // Menyembunyikan sidebar
}
   // Fungsi untuk memperbarui tombol Sign in/Sign out
   function updateAuthButtons() {
    const username = localStorage.getItem('username');
    const authButton = document.getElementById('authButton');
    const sidebarAuthButton = document.getElementById('sidebarAuthButton');

    if (username) {
        authButton.textContent = "Sign out";
        authButton.onclick = handleSignOut;

        sidebarAuthButton.textContent = "Sign out";
        sidebarAuthButton.onclick = handleSignOut;

    } else {
        authButton.textContent = "Sign in";
        authButton.onclick = handleSignIn;

        sidebarAuthButton.textContent = "Sign in";
        sidebarAuthButton.onclick = handleSignIn;

    }
}

// Fungsi untuk login
function handleSignIn() {
    window.location.href = "login.html";
    location.reload();

}

// Fungsi untuk logout
function handleSignOut() {
    localStorage.removeItem('username');
    updateAuthButtons();
    alert("You have signed out.");
}

// Fungsi untuk toggle sidebar
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.style.display = (sidebar.style.display === 'block') ? 'none' : 'block';
}

// Inisialisasi tombol saat halaman dimuat
document.addEventListener('DOMContentLoaded', updateAuthButtons);