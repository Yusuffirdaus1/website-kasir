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
            'cash_amount' => 'required_if:payment_method,cash|numeric|min:0',
        ]);

        DB::beginTransaction();
        
        try {
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // Validate cash payment
            if ($request->payment_method === 'cash' && $request->cash_amount < $total) {
                return redirect()->back()->with('error', 'Jumlah uang tidak cukup!');
            }

            // Create transaction
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'transaction_code' => 'TRX-' . strtoupper(Str::random(10)),
                'invoice_number' => 'INV-' . date('Ymd') . '-' . str_pad(Transaction::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT),
                'total_amount' => $total,
                'cash_amount' => $request->payment_method === 'cash' ? $request->cash_amount : $total,
                'change_amount' => $request->payment_method === 'cash' ? ($request->cash_amount - $total) : 0,
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

            return redirect()->route('transaction.receipt', $transaction->id);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function receipt($id)
    {
        $transaction = Transaction::with(['user', 'items.product'])->findOrFail($id);
        return view('transaction.receipt', compact('transaction'));
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
