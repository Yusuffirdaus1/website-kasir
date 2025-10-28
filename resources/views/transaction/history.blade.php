<x-layouts.app>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Riwayat Transaksi</h1>
                <p class="text-gray-600 mt-1">Semua riwayat pembelian Anda</p>
            </div>

            @if($transactions->isEmpty())
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Transaksi</h2>
                    <p class="text-gray-500 mb-6">Anda belum melakukan pembelian</p>
                    <a href="{{ route('home') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                        Mulai Belanja
                    </a>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($transactions as $transaction)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-gray-500">Kode Transaksi</p>
                                    <p class="text-lg font-bold text-gray-800">{{ $transaction->transaction_code }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                                    <span class="inline-block mt-1 px-3 py-1 text-sm rounded-full {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="space-y-4 mb-4">
                                @foreach($transaction->items as $item)
                                <div class="flex items-center justify-between pb-4 border-b border-gray-200 last:border-0">
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

                            <div class="pt-4 border-t border-gray-200 flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-gray-600">Metode Pembayaran</p>
                                    <p class="font-semibold text-gray-800 uppercase">{{ $transaction->payment_method }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-600">Total Pembayaran</p>
                                    <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $transactions->links() }}
                </div>
            @endif

            <div class="mt-8 text-center">
                <a href="{{ route('pelanggan.dashboard') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                    ← Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
