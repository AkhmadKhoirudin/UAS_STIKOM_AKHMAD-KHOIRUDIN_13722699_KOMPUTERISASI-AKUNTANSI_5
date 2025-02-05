document.addEventListener('DOMContentLoaded', function() {
    // Panggil displayCartItems dan updateCartCount setelah halaman selesai dimuat
    displayCartItems();
    updateCartCount();
    
    // Menambahkan event listener pada tombol "Beli"
    const checkoutButton = document.getElementById('checkout-button');
    if (checkoutButton) {
        checkoutButton.addEventListener('click', goToBuyPage);
    }
});

// Cart functionality
const cartButtons = document.querySelectorAll('.add-to-cart');
cartButtons.forEach(button => {
    button.addEventListener('click', function() {
        const productElement = this.closest('.product');
        const product = {
            id: productElement.getAttribute('data-id'),
            name: productElement.getAttribute('data-name'),
            price: parseInt(productElement.getAttribute('data-price')),
            image: productElement.getAttribute('data-image')
        };
        addToCart(product);
        showModal('success', `${product.name} telah ditambahkan ke keranjang Anda!`);
    });
});

// Fungsi untuk menambah produk ke keranjang
function addToCart(product) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Cek apakah produk sudah ada di keranjang
    const existingProductIndex = cart.findIndex(item => item.id === product.id);

    if (existingProductIndex !== -1) {
        // Jika produk sudah ada, tambahkan jumlahnya
        cart[existingProductIndex].quantity += 1;
    } else {
        // Jika produk belum ada, tambahkan produk ke keranjang dengan jumlah 1
        product.quantity = 1;
        cart.push(product);
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();  // Update jumlah item di ikon keranjang
}

// Menampilkan item di dalam popup keranjang
function displayCartItems() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartItemsContainer = document.getElementById('cart-items');
    cartItemsContainer.innerHTML = '';  // Hapus item sebelumnya

    if (cart.length === 0) {
        cartItemsContainer.innerHTML = '<p>Keranjang Anda kosong.</p>';
    } else {
        cart.forEach((product, index) => {
            const price = Number(product.price) || 0;
            const quantity = Number(product.quantity) || 0;

            const productElement = document.createElement('div');
            productElement.className = 'cart-item';
            productElement.innerHTML = `
                <img src="${product.image}" alt="${product.name}" class="cart-item-image">
                <div class="cart-item-details">
                    <p class="cart-item-name">${product.name}</p>
                    <p class="cart-item-quantity">Jumlah: ${quantity}</p>
                    <p class="cart-item-price">Rp${price * quantity}</p>
                </div>
                <button class="remove-from-cart" onclick="removeFromCart(${index})">Hapus</button>
            `;
            cartItemsContainer.appendChild(productElement);
        });
    }
    updateCartCount();  // Pastikan untuk memperbarui jumlah item di ikon keranjang
}

// Fungsi untuk memperbarui jumlah item di ikon keranjang
function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartCount = document.getElementById('cart-count');

    // Hitung jumlah total item
    const totalItems = cart.reduce((total, product) => total + (Number(product.quantity) || 0), 0);
    cartCount.innerText = totalItems;
}

// Fungsi untuk menghapus item dari keranjang
function removeFromCart(index) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.splice(index, 1);  // Hapus item dari keranjang
    localStorage.setItem('cart', JSON.stringify(cart));
    displayCartItems();  // Tampilkan kembali isi keranjang yang telah diperbarui
    updateCartCount();   // Perbarui jumlah item setelah penghapusan
}

// Fungsi untuk menampilkan popup keranjang
function toggleCartPopup() {
    const cartPopup = document.getElementById('cart-popup');
    cartPopup.style.display = cartPopup.style.display === 'none' ? 'block' : 'none';
    displayCartItems();  // Tampilkan item di keranjang saat membuka popup
}

// Menutup popup jika mengklik di luar keranjang
document.addEventListener('click', function(event) {
    const cartPopup = document.getElementById('cart-popup');
    const cartButton = document.querySelector('.cart-button'); // Sesuaikan dengan elemen yang memicu tampilan popup

    // Cek apakah klik terjadi di luar popup dan tombol keranjang
    if (cartPopup.style.display === 'block' && !cartPopup.contains(event.target) && !cartButton.contains(event.target)) {
        cartPopup.style.display = 'none';  // Tutup popup
    }
});

// Fungsi untuk menampilkan pesan sukses (opsional)
function showModal(type, message) {
    alert(message); // Sederhana menggunakan alert untuk sekarang
}

// Fungsi untuk mengarahkan ke halaman beli.html
function goToBuyPage() {
    // Pastikan keranjang berisi item sebelum mengarahkan ke halaman beli
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    if (cart.length === 0) {
        alert("Keranjang Anda kosong! Silakan tambahkan produk terlebih dahulu.");
        return;
    }
    
    // Jika ada item di keranjang, arahkan ke halaman beli.html
    window.location.href = 'beli.html'; // Mengarahkan ke halaman beli.html
}
