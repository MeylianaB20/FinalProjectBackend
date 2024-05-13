<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('addProduct', compact('categories'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'category_id' => ['required'],
            'name' => ['required','string', 'min:5', 'max:80'],
            'price' => ['required', 'integer', 'min:1'],
            'stock' => ['required', 'integer', 'min:1'],
            'image' => ['required', 'image'],
        ]);

        if($request->hasFile('image')){
            $category = Category::find($request->category_id)->name;
            $image = $request->file('image');
            $filename = Str::random(3).'_'.$image->getClientOriginalName();
            $image->storeAs('/public'.'/'.$category, $filename);
        }

        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $filename,
        ]);

        return redirect('/');
    }

    public function edit(Request $request, $id)
    {
        $categories = Category::all();
        $product = Product::find($id);
        $category_product = Category::find($product->category_id);
        return view('editProduct', compact('categories', 'product', 'category_product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => ['required'],
            'name' => ['required','string', 'min:5', 'max:80'],
            'price' => ['required', 'integer', 'min:1'],
            'stock' => ['required', 'integer', 'min:1'],
            'image' => ['required', 'image'],
        ]);

        if($request->hasFile('image')){
            $product = Product::find($id);
            $category = Category::find($request->category_id)->name;
            $image = $request->file('image');
            $filename = Str::random(3).'_'.$image->getClientOriginalName();
            Storage::delete('/public'.'/'.$category.'/'.$product->image);
            $image->storeAs('/public'.'/'.$category, $filename);
        }

        Product::find($id)->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $filename,
        ]);

        return redirect('/');
    }

    public function delete($id) {
        $product = Product::find($id);
        $category = Category::find($product->category_id)->name;
        Product::destroy($id);
        Storage::delete('/public'.'/'.$category.'/'.$product->image);
        return redirect('/');
    }
}
