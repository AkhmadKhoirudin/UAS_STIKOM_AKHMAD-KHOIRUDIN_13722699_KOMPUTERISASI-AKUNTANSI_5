let slideIndex = 0;
let slideTimeout; // Menyimpan timeout agar bisa dibersihkan jika diperlukan
let isPaused = false; // Menyimpan status apakah slide sedang dijeda

showSlides(); // Memanggil fungsi untuk menampilkan slide pertama

function showSlides() {
    if (!isPaused) {
        const slides = document.getElementsByClassName("mySlides");
        const dots = document.getElementsByClassName("dot");

        // Sembunyikan semua slide
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }

        slideIndex++;
        if (slideIndex > slides.length) {
            slideIndex = 1; // Kembali ke slide pertama jika di akhir
        }

        // Hapus kelas 'active' dari semua dots
        for (let i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }

        // Tampilkan slide saat ini
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";

        // Set timeout untuk slide berikutnya, 5 detik tampil + 2 detik transisi
        slideTimeout = setTimeout(showSlides, 5000); 
    }
}

// Fungsi untuk menampilkan slide sesuai dot yang diklik
function currentSlide(n) {
    slideIndex = n - 1;
    clearTimeout(slideTimeout); // Bersihkan timeout sebelumnya
    showSlides();
}

// Fungsi untuk berpindah antar slide dengan tombol prev/next
function plusSlides(n) {
    slideIndex += n - 1;
    clearTimeout(slideTimeout);
    showSlides();
}

// Fungsi untuk menghentikan slide ketika mouse ditahan
function pauseSlides() {
    clearTimeout(slideTimeout); // Hentikan perputaran slide
    isPaused = true;
}

// Fungsi untuk melanjutkan slide ketika mouse dilepas
function resumeSlides() {
    isPaused = false; // Reset status jeda
    showSlides(); // Lanjutkan perputaran slide
}

// Event listener untuk mendeteksi klik dan tahan pada slide container
const slideshowContainer = document.querySelector(".slideshow-container");

// Saat mouse ditahan, slide berhenti
slideshowContainer.addEventListener("mousedown", pauseSlides);

// Saat mouse dilepas, slide berputar lagi
slideshowContainer.addEventListener("mouseup", resumeSlides);

// Untuk perangkat layar sentuh (opsional)
slideshowContainer.addEventListener("touchstart", pauseSlides);
slideshowContainer.addEventListener("touchend", resumeSlides);
