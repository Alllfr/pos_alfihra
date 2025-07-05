<div class="container">
    <h1>Edit Transaksi</h1>

    <form action="{{ route('kasir.update', $transaction->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div id="product-list">
            @foreach($transaction->transactionDetails as $detail) <!-- Gunakan 'transactionDetails' bukan 'details' -->
                <div class="form-group">
                    <label for="product_id">Produk</label>
                    <select name="product_id[]" class="form-control" required>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ $product->id == $detail->product_id ? 'selected' : '' }}>
                                {{ $product->name }} - Rp {{ $product->price }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Jumlah</label>
                    <input type="number" name="quantity[]" class="form-control" value="{{ $detail->quantity }}" required min="1">
                </div>
            @endforeach
        </div>
        <button type="button" id="add-product" class="btn btn-secondary">Tambah Produk</button>
        <button type="submit" class="btn btn-primary">Perbarui Transaksi</button>
    </form>
</div>

<script>
    document.getElementById('add-product').addEventListener('click', function() {
        const productList = document.getElementById('product-list');
        const newProduct = document.createElement('div');
        
        // Ambil daftar produk dalam format JSON
        const products = @json($products);

        // Menambahkan produk baru dengan select dan input quantity
        newProduct.innerHTML = `
            <div class="form-group">
                <label for="product_id">Produk</label>
                <select name="product_id[]" class="form-control" required>
                    ${products.map(product => `
                        <option value="${product.id}">${product.name} - Rp ${product.price}</option>
                    `).join('')}
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Jumlah</label>
                <input type="number" name="quantity[]" class="form-control" required min="1">
            </div>
        `;
        productList.appendChild(newProduct);
    });
</script>
