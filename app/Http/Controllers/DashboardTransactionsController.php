<?php

namespace App\Http\Controllers;

use App\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardTransactionsController extends Controller
{
    public function index()
    {
        $sellTransactions = TransactionDetail::with(['transaction.user', 'product.galleries'])
            ->whereHas('product', function($product){
                $product->where('users_id', Auth::user()->id);
        })->get();

        $buyTransactions = TransactionDetail::with(['transaction.user', 'product.galleries'])
            ->whereHas('transaction', function($transaction){
                $transaction->where('users_id', Auth::user()->id);
        })->get();

        return view('pages.dashboard-transactions', compact('sellTransactions', 'buyTransactions'));
    }

    public function detail(Request $request, $id)
    {
        $transactions = TransactionDetail::with(['transaction.user', 'product.galleries'])->findOrFail($id);

        return view('pages.dashboard-transactions-details', compact('transactions'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $item = TransactionDetail::findorfail($id);

        $item->update($data);

        return redirect()->route('dashboard-transaction-detail', $id);
    }
}
