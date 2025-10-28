<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        $request->validate([
            'payment_method' => 'required|in:cash,debit,credit,qris',
        ]);

        DB::beginTransaction();
        
        try {
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // Create transaction
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'transaction_code' => 'TRX-' . strtoupper(Str::random(10)),
                'total_amount' => $total,
                'status' => 'completed',
                'payment_method' => $request->payment_method,
            ]);

            // Create transaction items
            foreach ($cart as $productId => $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);

                // Update stock
                $product = Product::find($productId);
                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            session()->forget('cart');
            DB::commit();

            return redirect()->route('transaction.success', $transaction->id)
                ->with('success', 'Pembayaran berhasil!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function success($id)
    {
        $transaction = Transaction::with('items.product')->findOrFail($id);
        return view('transaction.success', compact('transaction'));
    }

    public function history()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with('items.product')
            ->latest()
            ->paginate(10);
        
        return view('transaction.history', compact('transactions'));
    }
}
