<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Transaction;
use App\TransactionDetail;
use Illuminate\Http\Request;

use Exception;
use Midtrans\Snap;
use Midtrans\Config;

use Illuminate\Support\Facades\Auth;

class CheckController extends Controller
{
    public function process(Request $request)
    {
        // save user data
        $user = Auth::user();
        $user->update($request->except('total_price'));

        // proses cekout
        $code = 'STORE-' . mt_rand(0000,9999);
        $carts = Cart::with(['product', 'user'])
            ->where('users_id', Auth::user()->id)
            ->get();

        // transaction create
        $transaction = Transaction::create([
            'users_id' => Auth::user()->id,
            'inscurance_price' => 0,
            'shipping_price' => 0,
            'total_price' => $request->total_price,
            'transaction_status' => 'PEDDING',
            'code' => $code
        ]);

        foreach ($carts as $cart) {
            $trx = 'TRX-' . mt_rand(0000,9999);

            TransactionDetail::create([
                'transactions_id' => $transaction->id,
                'products_id' => $cart->product->id,
                'price' => $cart->product->price,
                'shipping_status' => 'PEDDING',
                'resi' => '',
                'code' => $trx,
            ]);
        }

        // delete cart data
        // cara 1
        // Cart::with(['product', 'user'])
        //     ->where('user_id',  Auth::user()->id)
        //     ->delete();

        // cara 2
        Cart::where('users_id', Auth::user()->id)->delete();


        // configurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // buat array untuk dikirim ke midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id' => $code,
                'gross_amount' => (int) $request->total_price
            ],

            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],

            'enabled_payments' => [
                'gopay','permata_va','bank_transfer'
            ],
            'vtweb' => []
        ];
        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            // Redirect to Snap Payment Page
            return redirect($paymentUrl);
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function callback(Request $request)
    {

    }
}
