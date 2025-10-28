<x-layouts.app>
    <!-- Hero Section -->
    <div class="bg-blue-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-5xl font-bold mb-6">Selamat Datang di Cupstore</h1>
            <p class="text-xl text-blue-100">Temukan berbagai produk berkualitas dengan harga terbaik</p>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex gap-4">
                <input type="text" placeholder="Cari produk..." 
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Cari
                </button>
            </div>
        </div>
    </div>

    <!-- Kategori -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-2xl font-bold mb-8 text-gray-800">Pilih Kategori</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition group cursor-pointer">
                <div class="text-5xl mb-4 text-center group-hover:scale-110 transition">🥤</div>
                <h3 class="text-center font-medium text-gray-800 text-lg">Minuman</h3>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition group cursor-pointer">
                <div class="text-5xl mb-4 text-center group-hover:scale-110 transition">🍪</div>
                <h3 class="text-center font-medium text-gray-800 text-lg">Makanan</h3>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition group cursor-pointer">
                <div class="text-5xl mb-4 text-center group-hover:scale-110 transition">🧴</div>
                <h3 class="text-center font-medium text-gray-800 text-lg">Perawatan</h3>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition group cursor-pointer">
                <div class="text-5xl mb-4 text-center group-hover:scale-110 transition">📦</div>
                <h3 class="text-center font-medium text-gray-800 text-lg">Lainnya</h3>
            </div>
        </div>
    </div>

    <!-- Produk -->
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-2xl font-bold mb-8 text-gray-800">Produk Terbaru</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($products as $product)
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition overflow-hidden">
                    <img src="{{ $product->image ? asset($product->image) : 'https://via.placeholder.com/300x200' }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-medium text-lg mb-2 text-gray-800">{{ $product->name }}</h3>
                        <p class="text-blue-600 text-lg font-bold mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        @auth
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full bg-blue-600 text-white py-2.5 rounded-lg hover:bg-blue-700 transition font-medium">
                                    + Keranjang
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" 
                               class="block text-center bg-blue-600 text-white py-2.5 rounded-lg hover:bg-blue-700 transition font-medium">
                                Login untuk Membeli
                            </a>
                        @endauth
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Cupstore</h2>
            <p class="text-blue-100 mb-8">Melayani dengan sepenuh hati</p>
            <p class="text-blue-200">&copy; {{ date('Y') }} Cupstore. Semua hak dilindungi.</p>
        </div>
    </footer>
</x-layouts.app>