<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  public function index()
  {
    $product = Product::orderBy('created_at', 'asc')->take(3)->get();

    return view('product', compact('product'));
  }

  public function show($id)
  {
    $product = Product::find($id);

    return response()->json($product);
  }

  public function create(Request $request)
  {
    $product = new Product();
    $product->name            = $request->name;
    $product->image           = $request->image;
    $product->price           = $request->price;
    $product->type            = $request->type;           
    $product->description     = $request->description;    
    $product->save();

    return response()->json("Product Successfully Created!");
  }

  public function update(Request $request, $id)
  {
    $product = Product::find($id);
    $product->name            = $request->name;
    $product->image           = $request->image;
    $product->price           = $request->price;
    $product->type            = $request->type;           
    $product->description     = $request->description;    
    $product->save();

    return response()->json($product);
  }

  public function delete($id)
  {
    $product = Product::find($id);
    $product->delete();

    return response()->json('Product sucessfully deleted!');
  }
}
