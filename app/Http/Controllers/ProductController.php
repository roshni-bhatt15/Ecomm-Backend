<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class ProductController extends Controller
{
    public function addProduct(Request $request){
        $product = new Product;
        $product->name = $request->name;
        $product->file_path = $request->file('file')->store('products');
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();
        
        return $product;

    }

    public function list(Request $request){
        return Product::get();
    }
    
    public function getProduct($id){
        $product =  Product::find($id);
        if($product){
            return json_encode(array('status'=>true,'data' => $product));
        }else{
            return json_encode(array('status'=>false));
        }
    }

    public function delete($id){
        $product = Product::destroy($id);

        if($product){
            return json_encode(array('status'=>true,'message' => 'Product has been deleted!'));
        }else{
            return json_encode(array('status'=>false));

        }
    }
}
