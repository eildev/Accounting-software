<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Psize;
use App\Models\Category;
class ProductsSizeController extends Controller
{
    public function ProductSizeView(){
        $productSize = Psize::latest()->get();
        return view('all_modules.products.product-size.all_products_size',compact('productSize'));
    }//End Method

    public function ProductSizeAdd(){
        $productSize = Psize::latest()->get();
        $allCategory = Category::latest()->get();
        return view('all_modules.products.product-size.add_products_size',compact('allCategory','productSize'));
    }//End Method

    public function ProductSizeStore(Request $request) {
        $productSize = new Psize;
        $productSize->category_id = $request->category_id;
        $productSize->size = $request->size;
        $productSize->save();
        $notification = [
            'message' => 'Product Size Added Successfully',
            'alert-type' => 'info'
        ];

        return response()->json([
            'message' => $notification['message'],
           'redirect_url' => route('product.size.view')
        ]);
    }

    public function ProductSizeEdit($id){
        $productSize = Psize::findOrFail($id);
        $allCategory = Category::latest()->get();
        return view('all_modules.products.product-size.edit_products_size',compact('productSize','allCategory'));
    }//
    public function ProductSizeUpdate(Request $request,$id){
        $productSize = Psize::findOrFail($id);
        $productSize->category_id = $request->category_id;
        $productSize->size = $request->size;
        $productSize->save();
        $notification = array(
            'message' =>'Product Size Updated Successfully',
            'alert-type'=> 'info'
         );
        return redirect()->route('product.size.view')->with($notification);
    }//End Method
    public function ProductSizeDelete($id){
        $productSize = Psize::findOrFail($id);
        $productSize->delete();
        $notification = array(
            'message' =>'Product Size Deleted Successfully',
            'alert-type'=> 'info'
         );
        return redirect()->route('all_modules.product.size.view')->with($notification);
    }//End Method

}
