<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Transaksi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Animasi Keyframes untuk efek hover pada produk */
        @keyframes hoverEffect {
            0% { background-color: #f8f9fa; }
            50% { background-color: #e9ecef; }
            100% { background-color: #f8f9fa; }
        }

        .form-group {
            margin-bottom: 20px;
        }

        .product-table {
            margin-top: 20px;
            transition: transform 0.2s ease-in-out;
        }

        /* Hover effect untuk tabel produk */
        .product-table tr:hover {
            animation: hoverEffect 0.5s ease-in-out;
            cursor: pointer;
        }

        /* Hover effect pada tombol */
        .btn:hover {
            transform: scale(1.05);
            background-color: #ffc107;
            color: #212529;
            transition: all 0.3s ease;
        }

        /* Styling untuk form input dan select */
        .form-control {
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
            border-color: #007bff;
        }

        /* Styling untuk container dan button */
        .container {
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Buat Transaksi</h1>

        <form action="{{ route('kasir.store') }}" method="POST">
            @csrf
            <div id="product-list">
                <div class="form-group">
                    <label for="product_id">Produk</label>
                    <select name="product_id[]" class="form-control" required>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} - Rp {{ $product->price }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Jumlah</label>
                    <input type="number" name="quantity[]" class="form-control" required min="1">
                </div>
            </div>

            <!-- Tabel Produk yang ditambahkan -->
            <table class="table product-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody id="product-details">
                    <!-- Detail Produk yang ditambahkan akan muncul di sini -->
                </tbody>
            </table>

            <button type="button" id="add-product" class="btn btn-secondary">Tambah Produk</button>
            <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
        </form>
    </div>

    <script>
        document.getElementById('add-product').addEventListener('click', function() {
            const productList = document.getElementById('product-list');
            const newProduct = document.createElement('div');
            newProduct.innerHTML = `
                <div class="form-group">
                    <label for="product_id">Produk</label>
                    <select name="product_id[]" class="form-control" required>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} - Rp {{ $product->price }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Jumlah</label>
                    <input type="number" name="quantity[]" class="form-control" required min="1">
                </div>
            `;
            productList.appendChild(newProduct);
        });

        // Fungsi untuk menambahkan detail produk ke dalam tabel
        function updateProductTable() {
            const productDetails = document.getElementById('product-details');
            productDetails.innerHTML = ''; // Reset tabel produk

            const productIds = document.getElementsByName('product_id[]');
            const quantities = document.getElementsByName('quantity[]');

            // Loop untuk mengambil data produk dan jumlah, kemudian menambahkannya ke tabel
            productIds.forEach((productId, index) => {
                const quantity = quantities[index].value;

                const productName = productId.options[productId.selectedIndex].text;
                const productPrice = parseInt(productId.options[productId.selectedIndex].text.split(' - Rp ')[1]);
                const subtotal = productPrice * quantity;

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${productName}</td>
                    <td>${quantity}</td>
                    <td>Rp ${subtotal}</td>
                `;

                productDetails.appendChild(row);
            });
        }

        // Update tabel ketika produk atau jumlah berubah
        document.getElementById('product-list').addEventListener('change', function() {
            updateProductTable();
        });

        // Panggil updateProductTable ketika halaman dimuat untuk menampilkan data awal
        window.addEventListener('load', function() {
            updateProductTable();
        });
    </script>
</body>
</html>
