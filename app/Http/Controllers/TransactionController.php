<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::where('warung_id', auth()->user()->warung_id)->with('items');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('transaction_code', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%");
            });
        }

        $transactions = $query->latest()->paginate(10)->appends(['search' => $request->search]);
        $products = \App\Models\Product::where('warung_id', auth()->user()->warung_id)->get();
        return view('pages.transaction', compact('transactions', 'products'));
    }

    public function show($id)
    {
        $transaction = Transaction::where('warung_id', auth()->user()->warung_id)
            ->with('items')
            ->findOrFail($id);
            
        return view('pages.transactionDetail', compact('transaction'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'payment_method' => 'required|in:CASH,TRANSFER,QRIS',
            'paid_amount' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required',
            'items.*.product_name' => 'required|string',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $total_amount = 0;
            foreach ($request->items as $item) {
                $total_amount += ($item['unit_price'] * $item['quantity']);
            }

            $discount = $request->discount_amount ?? 0;
            $tax = $request->tax_amount ?? 0;
            $grand_total = $total_amount - $discount + $tax;

            $transaction = Transaction::create([
                'warung_id' => auth()->user()->warung_id,
                'cashier_id' => auth()->id(),
                'transaction_code' => 'TRX-' . time(),
                'customer_name' => $request->customer_name,
                'note' => $request->note,
                'total_amount' => $total_amount,
                'discount_amount' => $discount,
                'tax_amount' => $tax,
                'grand_total' => $grand_total,
                'payment_method' => $request->payment_method,
                'paid_amount' => $request->paid_amount,
                'change_amount' => max(0, $request->paid_amount - $grand_total),
                'status' => 'SUCCESS',
            ]);

            foreach ($request->items as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'unit_price' => $item['unit_price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['unit_price'] * $item['quantity'],
                ]);
            }

            DB::commit();
            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:PENDING,SUCCESS,CANCELLED',
        ]);

        try {
            DB::beginTransaction();
            $transaction->update(['status' => $request->status]);
            
            // Logic for updating items can be expanded here depending on business rules
            
            DB::commit();
            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal update transaksi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            $transaction->delete(); // Items cascade deleted
            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}
