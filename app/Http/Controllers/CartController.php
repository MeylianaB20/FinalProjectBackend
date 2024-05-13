<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::all();
        return view('cart', compact('carts'));
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $category = Category::find($product->category_id)->name;
 
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        }  else {
            $cart[$id] = [
                'user_id' => Auth::user()->id,
                'product_id' => $product->id,
                'category' => $category,
                'product_name' => $product->name,
                'product_price' => $product->price,
                'product_image' => $product->image,
                'quantity' => 1
            ];

            Cart::create([
                'user_id' => Auth::user()->id,
                'product_id' => $product->id,
                'category' => $category,
                'product_name' => $product->name,
                'product_price' => $product->price,
                'product_image' => $product->image,
                'quantity' => 1
            ]);
        }

        session()->put('cart', $cart);

        $product->update([
            'stock' => $product->stock - 1,
        ]);

        return redirect()->back()->with('success', 'Product add to cart successfully!');
    }
 
    public function update(Request $request, $id)
    {
        $cart = Cart::find($id);
        $product = Product::find($cart->product_id);

        $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:'.($product->stock + $cart->quantity)]
        ]);

        if($request->id && $request->quantity){
            $carts = session()->get('cart');
            $carts[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $carts);
        }

        Cart::find($id)->update([
            'quantity' => $request->quantity
        ]);
        
        Product::find($cart->product_id)->update([
            'stock' => $product->stock + $cart->quantity - $request->quantity,
        ]);

        session()->flash('success', 'Cart successfully updated!');;
    }
 
    public function remove(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $product = Product::findOrFail($cart[$id]['product_id']);
            $product->update([
                'stock' => $product->stock + $cart[$id]['quantity'],
            ]);
    
            unset($cart[$id]);
            session()->put('cart', $cart);
            session()->flash('success', 'Product successfully removed!');
        }
    
        Cart::destroy($id);

        // if($request->id) {
        //     $cart = session()->get('cart');
        //     if(isset($cart[$request->id])) {
        //         unset($cart[$request->id]);
        //         session()->put('cart', $cart);
        //     }
        //     session()->flash('success', 'Product successfully removed!');
        // }
        
        session()->flash('success', 'Cart successfully updated!');
    }
}
