fetch('src/php/get_products.php')
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('card-container');
        let cardHTML = '';
        
        data.forEach(product => {
            if (product.stok === 0) {
                cardHTML += `
                    <div class="card product out-of-stock" data-id="${product.id}" data-name="${product.name}" data-price="${product.price}" data-image="${product.image}">
                        <img src="${product.image}" class="card-img" alt="gambar produk">
                        <h3>${product.name}</h3>
                        <p>${product.description}</p>
                        <p class="card-text"><strong>Harga:</strong> Rp.${parseFloat(product.price).toLocaleString('id-ID', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })}</p>
                        <p class="text-danger"><strong>Stok Habis</strong></p>
                        <button class="btn btn-secondary" disabled>
                            <i class="fas fa-cart-plus"></i> Tidak Tersedia
                        </button>
                    </div>
                `;
            }else {
                // Produk dengan stok tersedia
                cardHTML += `
                    <div class="card product" data-id="${product.id}" data-name="${product.name}" data-price="${product.price}" data-image="${product.image}">
                        <img src="${product.image}" class="card-img" alt="gambar produk">
                        <h3>${product.name}</h3>
                        <p>${product.description}</p>
                        <p class="card-text"><strong>Harga:</strong> Rp.${parseFloat(product.price).toLocaleString('id-ID', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })}</p>
                        <button class="btn btn-primary add-to-cart">
                            <i class="fas fa-cart-plus"></i> Beli
                        </button>
                    </div>
                `;
            }
        });

        container.innerHTML = cardHTML;

        // Mengatur event listener untuk tombol "add-to-cart" setelah elemen card ditambahkan
        const cartButtons = document.querySelectorAll('.add-to-cart');
        cartButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productElement = this.closest('.product');
                const product = {
                    id: productElement.getAttribute('data-id'),
                    name: productElement.getAttribute('data-name'),
                    price: parseFloat(productElement.getAttribute('data-price')),
                    image: productElement.getAttribute('data-image')
                };
                addToCart(product);
                showModal('success', `${product.name} telah ditambahkan ke keranjang Anda!`);
            });
        });

      
    })
    .catch(error => console.error('Error:', error));
