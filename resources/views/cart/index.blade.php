<x-layouts.app>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">Keranjang Belanja</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(empty($cart))
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Keranjang Kosong</h2>
                <p class="text-gray-500 mb-6">Belum ada produk di keranjang Anda</p>
                <a href="{{ route('home') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                    Mulai Belanja
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        @foreach($cart as $id => $item)
                        <div class="flex items-center p-6 border-b border-gray-200">
                            <img src="{{ $item['image'] ? asset('storage/' . $item['image']) : 'https://via.placeholder.com/100' }}" 
                                 alt="{{ $item['name'] }}" 
                                 class="w-24 h-24 object-cover rounded-lg">
                            
                            <div class="ml-6 flex-1">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $item['name'] }}</h3>
                                <p class="text-blue-600 font-bold">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                
                                <div class="flex items-center mt-4 gap-4">
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" 
                                               class="w-20 px-3 py-1 border border-gray-300 rounded-lg text-center">
                                        <button type="submit" class="ml-2 text-blue-600 hover:text-blue-700 text-sm font-medium">
                                            Update
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <p class="text-lg font-bold text-gray-800">
                                    Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <form action="{{ route('cart.clear') }}" method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-700 font-medium">
                            Kosongkan Keranjang
                        </button>
                    </form>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                        <h2 class="text-xl font-bold mb-6 text-gray-800">Ringkasan Pesanan</h2>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Ongkir</span>
                                <span>Gratis</span>
                            </div>
                            <div class="border-t pt-3 flex justify-between text-lg font-bold text-gray-800">
                                <span>Total</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                                <select name="payment_method" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                    <option value="cash">Cash</option>
                                    <option value="debit">Debit Card</option>
                                    <option value="credit">Credit Card</option>
                                    <option value="qris">QRIS</option>
                                </select>
                            </div>

                            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                                Checkout
                            </button>
                        </form>

                        <a href="{{ route('home') }}" class="block text-center mt-4 text-blue-600 hover:text-blue-700">
                            Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
