<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Start query
        $query = Transaction::with(['user', 'items.product']);

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter by customer
        if ($request->filled('customer_id')) {
            $query->where('user_id', $request->customer_id);
        }

        // Filter by product
        if ($request->filled('product_id')) {
            $query->whereHas('items', function ($q) use ($request) {
                $q->where('product_id', $request->product_id);
            });
        }

        // Get transactions
        $transactions = $query->orderBy('created_at', 'desc')->paginate(20);

        // Calculate statistics
        $totalRevenue = $query->sum('total_amount');
        $totalTransactions = $query->count();
        $totalItems = DB::table('transaction_items')
            ->whereIn('transaction_id', $query->pluck('id'))
            ->sum('quantity');

        // Get customers and products for filters
        $customers = User::where('role', 'pelanggan')->orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('report.index', compact(
            'transactions',
            'totalRevenue',
            'totalTransactions',
            'totalItems',
            'customers',
            'products'
        ));
    }

    public function print(Request $request)
    {
        // Start query
        $query = Transaction::with(['user', 'items.product']);

        // Apply same filters
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('customer_id')) {
            $query->where('user_id', $request->customer_id);
        }

        if ($request->filled('product_id')) {
            $query->whereHas('items', function ($q) use ($request) {
                $q->where('product_id', $request->product_id);
            });
        }

        // Get all transactions (no pagination for print)
        $transactions = $query->orderBy('created_at', 'desc')->get();

        // Calculate statistics
        $totalRevenue = $transactions->sum('total_amount');
        $totalTransactions = $transactions->count();
        $totalItems = $transactions->sum(function ($transaction) {
            return $transaction->items->sum('quantity');
        });

        // Get filter info for display
        $filterInfo = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'customer' => $request->customer_id ? User::find($request->customer_id) : null,
            'product' => $request->product_id ? Product::find($request->product_id) : null,
        ];

        return view('report.print', compact(
            'transactions',
            'totalRevenue',
            'totalTransactions',
            'totalItems',
            'filterInfo'
        ));
    }
}
