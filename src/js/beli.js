document.addEventListener('DOMContentLoaded', function () {
    displayCartItems();
});

function displayCartItems() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartItemsContainer = document.getElementById('cart-items');
    const totalPriceElement = document.getElementById('total-price');
    cartItemsContainer.innerHTML = ''; // Kosongkan elemen sebelumnya

    let total = 0; // Untuk total harga

    if (cart.length === 0) {
        cartItemsContainer.innerHTML = '<p>Keranjang Anda kosong.</p>';
        totalPriceElement.textContent = '0';
    } else {
        cart.forEach((product, index) => {
            const price = Number(product.price) || 0;
            const quantity = Number(product.quantity) || 0;

            // Hitung total harga
            total += price * quantity;

            // Buat elemen card untuk setiap produk
            const cardElement = document.createElement('div');
            cardElement.className = 'card';
            cardElement.style.width = '18rem';
            cardElement.style.display = 'inline-block';
            cardElement.style.marginRight = '10px';
            cardElement.innerHTML = `
                <img src="${product.image}" class="card-img-top" alt="${product.name}" style="height: 150px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">${product.name}</h5>
                    <p class="card-text">Harga: Rp${price}</p>
                    <p class="card-text">
                        Jumlah:
                        <button class="btn btn-sm btn-secondary quantity-decrease" data-index="${index}">-</button>
                        <span>${quantity}</span>
                        <button class="btn btn-sm btn-secondary quantity-increase" data-index="${index}">+</button>
                    </p>
                    <p class="card-text"><strong>Subtotal: Rp${price * quantity}</strong></p>
                    <button class="btn btn-danger btn-sm delete-item" data-index="${index}">Hapus</button>
                </div>
            `;

            cartItemsContainer.appendChild(cardElement);
        });

        // Perbarui total harga
        totalPriceElement.textContent = total;
    }

    // Pasang event listener untuk tombol +/- dan hapus setelah elemen ditambahkan
    attachListeners();
}

function attachListeners() {
    const decreaseButtons = document.querySelectorAll('.quantity-decrease');
    const increaseButtons = document.querySelectorAll('.quantity-increase');
    const deleteButtons = document.querySelectorAll('.delete-item');

    decreaseButtons.forEach((button) => {
        button.addEventListener('click', function () {
            updateQuantity(this.dataset.index, -1);
        });
    });

    increaseButtons.forEach((button) => {
        button.addEventListener('click', function () {
            updateQuantity(this.dataset.index, 1);
        });
    });

    deleteButtons.forEach((button) => {
        button.addEventListener('click', function () {
            deleteItem(this.dataset.index);
        });
    });
}

function updateQuantity(index, change) {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    if (cart[index]) {
        cart[index].quantity = Math.max(1, (cart[index].quantity || 1) + change); // Minimal 1 item
        localStorage.setItem('cart', JSON.stringify(cart));
        displayCartItems(); // Render ulang keranjang
    }
}

function deleteItem(index) {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    if (cart[index]) {
        cart.splice(index, 1); // Hapus item dari array
        localStorage.setItem('cart', JSON.stringify(cart));
        displayCartItems(); // Render ulang keranjang
    }
}

document.getElementById('order-form').addEventListener('submit', function (event) {
    event.preventDefault();

    // Ambil data keranjang dari localStorage
    const cartItems = JSON.parse(localStorage.getItem('cart')) || [];

    if (cartItems.length === 0) {
        alert('Keranjang belanja kosong!');
        return;
    }

    // Ambil data form
    const formData = new FormData(this);
    formData.append('cart', JSON.stringify(cartItems));

    // Kirim data menggunakan AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', this.action, true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.status === 'success') {
                alert(response.message);
                localStorage.removeItem('cart'); // Kosongkan keranjang setelah sukses
                window.location.href = 'index.html';
            } else {
                alert('Gagal: ' + response.message);
            }
        } else {
            alert('Terjadi kesalahan server.');
        }
    };
    xhr.send(formData);
});
