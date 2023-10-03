<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    // DB::table Way
    // public function index()
    // {
    //     // Use the DB query builder to fetch data
    //     $products = DB::table('products')->get();

    //     // Debug the retrieved data
    //     dd($products);

    //     // Pass the data to the view
    //     return view('index', ['products' => $products]);
    // }

    public function index()
    {
        $products = Products::all();
        // dd($products); // Debugging statement
        return view('index', ['products' => $products]);
    }


    public function viewCreate()
    {
        $products = Products::all();
        return view('create', ['products' => $products]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'type' => 'required|string|min:3|max:250',
            'date' => 'required|string|min:3|max:250',
            'salary' => 'required|string|min:3|max:250'
        ]);

        $products = new Products();
        $products->name = $request->name;
        $products->type = $request->type;
        $products->date = $request->date;
        $products->salary = $request->salary;

        $isSaved = $products->save();

        if ($isSaved) {
            session()->flash('message', 'Product created successfully');
            return redirect()->route('index.show');
        } else {
            return redirect()->back()->view('404');
        }
    }

    public function show(Request $id)
    {
        $products = Products::find($id);

        return view('index', ['products' => $products]);
    }



    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }
    public function destroy(string $id)
    {
        $products = Products::find($id);
        if ($products) {
            $products->delete();
            session()->flash('message', 'Product deleted successfully');
        } else {
            session()->flash('message', 'Product not found');
        }

        return redirect()->route('products.index'); // Redirect to the index page
    }
}
