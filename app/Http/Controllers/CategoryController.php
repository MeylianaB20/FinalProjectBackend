<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index()
    {
        return view('addCategory');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required','string'],
        ]);
        
        Category::create([
            'name' => $request->name,
        ]);

        return redirect('/');
    }
}
