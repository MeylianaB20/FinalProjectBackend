<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        $carts = Cart::all();
        return view('invoice', compact('carts'));
    }

    public function print($id){
        Cart::where('user_id', $id)->delete();

        // Hapus item keranjang yang memiliki user_id yang sesuai dari session
        $cart = session()->get('cart');
        foreach ($cart as $key => $item) {
            if ($item['user_id'] == $id) {
                unset($cart[$key]);
                session()->put('cart', $cart);
            }
        }

        return view('order');
    }

    public function create(Request $request){
        $request->validate([
            'address' => ['required', 'string', 'min:10', 'max:100'],
            'postal_code' => ['required', 'string', 'regex:/^\d{5}$/']
        ],  [
            'postal_code.regex' => 'The postal code must be 5 digit',
        ]);

        $invoiceNumber = str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
        $invoice = Invoice::create([
            'user_id' => Auth::user()->id,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'invoice_number' => $invoiceNumber,
        ]);

        $invoiceId = $invoice->id;
        $carts = Cart::All();
        $invoices = Invoice::find($invoiceId);
        $user = Auth::user()->id;
        $user_name = User::find($user)->name;

        return view('printInvoice', compact('carts', 'invoices', 'user_name'));
    }



}
