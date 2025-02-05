let products = []; // Untuk menyimpan data produk

// Fungsi untuk menampilkan produk
function displayProducts(products) {
    const productContainer = document.getElementById("product-list");
    productContainer.innerHTML = ""; // Kosongkan container sebelum menampilkan produk

    // Loop untuk menampilkan produk di halaman
    products.forEach(product => {
        const productRow = document.createElement("div");
        productRow.className = "row mb-3 align-items-center";

        productRow.innerHTML = `
            <div class="col-md-2">
                <img src="${product.image}" width="100" height="100" alt="Product Image" class="img-fluid">
            </div>
            <div class="col-md-2">
                <h5>${product.name}</h5>
            </div>
            <div class="col-md-3">
                <p>${product.description}</p>
            </div>
            <div class="col-md-2">
                <p>Rp.${product.price}</p>
            </div>
            <div class="col-md-3">
                <a href="edit.html?id=${product.id}" class="btn btn-primary btn-sm me-2">Edit</a>
                <button class="btn btn-danger btn-sm" onclick="deleteProduct(${product.id})">Delete</button>
            </div>
        `;
        productContainer.appendChild(productRow);
    });
}

// Fungsi untuk mencari produk berdasarkan nama
function searchProducts() {
    const searchTerm = document.getElementById("search-input").value.toLowerCase();

    // Filter produk berdasarkan nama
    const filteredProducts = products.filter(product => 
        product.name.toLowerCase().includes(searchTerm)
    );

    displayProducts(filteredProducts);
}

// Menampilkan produk ketika halaman dimuat
window.onload = () => {
    fetch("src/php/get_products.php") // Mengambil data produk dari backend
        .then(response => response.json())
        .then(data => {
            products = data; // Menyimpan data produk dalam array
            displayProducts(products); // Menampilkan semua produk pada awalnya
        })
        .catch(error => console.error('Error fetching products:', error));
};

// Fungsi untuk menghapus produk
function deleteProduct(id) {
    if (confirm("Are you sure you want to delete this product?")) {
        fetch(`src/php/delete.php?id=${id}`)
            .then(response => response.text())
            .then(data => {
                alert(data);
                // Setelah produk dihapus, muat ulang produk
                searchProducts(); // Ini juga akan memperbarui hasil pencarian
            })
            .catch(error => console.error('Error deleting product:', error));
    }
}