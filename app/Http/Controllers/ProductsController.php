<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{

    public function index()
    {
        $products = Products::paginate(12);
        // dd($products); // Debugging statement
        return view('index', ['products' => $products]);
    }


    public function create()
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


    public function edit($id)
    {
        $products = Products::find($id);

        if (!$products) {
            return redirect()->route('products.index')->with('error', 'Product not found');
        }

        return view('edit', ['products' => $products]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'type' => 'required|string|min:3|max:250',
            'date' => 'required|string|min:3|max:250',
            'salary' => 'required|string|min:3|max:250'
        ]);

        // Find the existing product by ID
        $product = Products::find($id);

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found');
        }

        // Update the product's attributes
        $product->name = $request->input('name');
        $product->type = $request->input('type');
        $product->date = $request->input('date');
        $product->salary = $request->input('salary');

        $isSaved = $product->save();

        if ($isSaved) {
            session()->flash('success', 'Product updated successfully');
            return redirect()->route('products.index');
        } else {
            return redirect()->back()->with('error', 'Failed to update product');
        }
    }

    public function updateOLD(Request $request)
    {

        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'type' => 'required|string|min:3|max:250',
            'date' => 'required|string|min:3|max:250',
            'salary' => 'required|string|min:3|max:250'
        ]);

        $products = new Products();

        $products->name = $request->input('name');
        $products->type = $request->input('type');
        $products->date = $request->input('date');
        $products->salary = $request->input('salary');

        $isSaved = $products->save();

        if ($isSaved) {
            session()->flash('success', 'Product updated successfully');
            return redirect()->route('products.index');
        } else {

            return redirect()->back()->view('404');
        }
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

        return redirect()->route('products.index');
    }
}
