<x-layouts.app>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-3xl mx-auto px-4">
            <!-- Success Message -->
            <div class="bg-white rounded-lg shadow-md p-8 text-center mb-8">
                <div class="w-20 h-20 bg-green-100 rounded-full mx-auto flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Pembayaran Berhasil!</h1>
                <p class="text-gray-600 mb-6">Terima kasih telah berbelanja di Cupstore</p>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-gray-600 mb-1">Kode Transaksi</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $transaction->transaction_code }}</p>
                </div>
            </div>

            <!-- Transaction Details -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800">Detail Pesanan</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4 mb-6">
                        @foreach($transaction->items as $item)
                        <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                            <div class="flex items-center">
                                <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/60' }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="w-16 h-16 object-cover rounded-lg">
                                <div class="ml-4">
                                    <h3 class="font-semibold text-gray-800">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <p class="font-bold text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                        </div>
                        @endforeach
                    </div>

                    <div class="space-y-2 pt-4 border-t border-gray-200">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Metode Pembayaran</span>
                            <span class="uppercase">{{ $transaction->payment_method }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-gray-800 pt-2 border-t border-gray-200">
                            <span>Total</span>
                            <span>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 justify-center">
                <a href="{{ route('home') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Kembali ke Beranda
                </a>
                <a href="{{ route('pelanggan.dashboard') }}" class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    Lihat Riwayat
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
