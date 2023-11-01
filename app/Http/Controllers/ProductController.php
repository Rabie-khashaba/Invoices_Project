<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $sections = Section::all();
        $Products = Product::all();
        return view('products.products' , compact('sections' , 'Products'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        try {
            $product = new Product();
            $product->Product_name = $request->Product_name;
            $product->description = $request->description;
            $product->section_id = $request->section_id;

            $product->save();
            $notification = array(
                'message' => 'Product Saved successfully',
                'alert-type'=> 'success',
            );
            return redirect()->route('products.index')->with($notification);

        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function show(Product $product)
    {
        //
    }


    public function edit(Product $product)
    {
        //
    }


    public function update(Request $request)
    {
       // return $request;
        try {

            $id = Section::where('section_name',$request->section_name)->first()->id;

            $product = Product::findOrFail($request->id);
            //return $product;

            $product->update([
                'Product_name'=>$request->Product_name,
                'description'=>$request->description,
                'section_id'=>$id,
            ]);
            $notification = array(
                'message' => 'Product Updated successfully',
                'alert-type'=> 'info',
            );
            return redirect()->route('products.index')->with($notification);

        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {
        $product = Product::findOrFail($request->pro_id);
        $product->delete();
        $notification = array(
            'message' => 'Product deleted successfully',
            'alert-type'=> 'error',
        );
        return redirect()->route('products.index')->with($notification);
    }
}
