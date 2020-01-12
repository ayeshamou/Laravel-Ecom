<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use Str;
use Session;
class ProductController extends Controller
{
    public function add_product()
    {
        $categories = DB :: table('categories') -> get();
        return view('admin.add_product') -> with('categories',$categories);
    }

    public function save_product(Request $request)
    {
        $data = array();
        $data['product_name'] = $request -> product_name;
        $data['painter_name'] = $request -> painter_name;
        $data['product_price'] = $request -> product_price;
        $data['product_description'] = $request -> product_description;
        $data['category_id'] = $request -> category_id;
        $image = $request ->file('product_image');

        if($image)
        {
            
            $image_name = Str :: random(20);
            $extension = strtolower($image -> getClientOriginalExtension());
            $image_full_name = $image_name . '.' . $extension;
            $upload_path = 'bookImage/';
            $image_url = $upload_path.$image_full_name;
            $success = $image -> move($upload_path,$image_full_name);

            if($success)
            {
                $data['product_image'] = $image_url;
                DB :: table('products')->insert($data);
                Session :: put('save_message','Product saved successfully!!!');
                return Redirect :: to('/admin/all-products');
            }
        }
         
        $data['product_image'] = '';
            DB :: table('products')->insert($data);
            Session :: put('save_message','Product saved successfully!!!');
        return Redirect :: to('/admin/all-products');
    }

    public function all_products()
    {
        $all_products = DB :: table('products')
                     ->join('categories','products.category_id','=','categories.category_id')
                     ->select('products.*','categories.category_name')
                     ->paginate(10);
        return view('admin.all_products') -> with('all_products',$all_products);
    }

    public function delete_product($product_id)
    {
         DB :: table('products')
             ->where('product_id',$product_id)
             ->delete();
        Session :: put('save_message','Product deleted successfully!!!');
        return Redirect :: to('/admin/all-products');
    }

    public function edit_product($product_id)
    {
        $product_info = DB :: table('products')
                     ->join('categories','products.category_id','=','categories.category_id')
                     ->select('products.*','categories.category_name')
                     ->where('product_id',$product_id)
                     ->first();

        $categories = DB :: table('categories') -> get();

        return view('admin.edit_product',['product_info' => $product_info,'categories' => $categories]);
    }

    public function update_product(Request $request,$product_id)
    {
        $data = array();
        $data['product_name'] = $request -> product_name;
        $data['painter_name'] = $request -> painter_name;
        $data['product_price'] = $request -> product_price;
        $data['product_description'] = $request -> product_description;
        $data['category_id'] = $request -> category_id;
        $image = $request ->file('product_image');
        
        if($image)
        {
            $image_name = Str :: random(20);
            $extension = strtolower($image -> getClientOriginalExtension());
            $image_full_name = $image_name . '.' . $extension;
            $upload_path = 'bookImage/';
            $image_url = $upload_path.$image_full_name;
            $success = $image -> move($upload_path,$image_full_name);

            if($success)
            {
                $data['product_image'] = $image_url;
                DB :: table('products')
                ->where('product_id',$product_id)
                ->update($data);
                Session :: put('save_message','Product updated successfully!!!');
                return Redirect :: to('/admin/all-products');
            }
        }
        else
        {
            DB :: table('products')
            ->where('product_id',$product_id)
            ->update($data);
            Session :: put('save_message','Product updated successfully!!!');
            return Redirect :: to('/admin/all-products');
        }
        
    }

    public function get_products()
    {
        $products = DB :: table('products')
                     ->join('categories','products.category_id','=','categories.category_id')
                     ->select('products.*')
                     ->paginate(12);
        return view('all_products_view',['products' => $products]);
    }

    public function asce_order_by_name()
    {
        $products = DB :: table('products')
        ->join('categories','products.category_id','=','categories.category_id')
        ->select('products.*')
        ->orderBy('product_name','asc')
        ->paginate(12);
        return view('all_products_view',['products' => $products]);
    }
    public function asce_order_by_price()
    {
        $products = DB :: table('products')
        ->join('categories','products.category_id','=','categories.category_id')
        ->select('products.*')
        ->orderBy('product_price','asc')
        ->paginate(12);
        return view('all_products_view',['products' => $products]);
    }
    public function desc_order_by_name()
    {
        $products = DB :: table('products')
        ->join('categories','products.category_id','=','categories.category_id')
        ->select('products.*')
        ->orderBy('product_name','desc')
        ->paginate(12);
        return view('all_products_view',['products' => $products]);
    }
    public function desc_order_by_price()
    {
        $products = DB :: table('products')
        ->join('categories','products.category_id','=','categories.category_id')
        ->select('products.*')
        ->orderBy('product_price','desc')
        ->paginate(12);
        return view('all_products_view',['products' => $products]);
    }
    public function get_product_by_keyword(Request $request)
    {
        $keyword = $request -> product_name;
        Session :: put('keyword',$keyword);
        return Redirect :: to('/products-by-keyword');
    }

    public function get_single_product($product_id)
    {
        $product = DB :: table('products')
                   ->join('categories','categories.category_id','=','products.category_id')
                   ->where('product_id',$product_id)
                   ->select('products.*','categories.category_name')
                   ->first();
        $related_items = DB :: table('products')
                        ->where('category_id',$product -> category_id)
                        ->limit(4)
                        ->get();
        return view('single_product',['product' => $product,'related_items' => $related_items]);
    }

    public function helper_function()
    {
      
        $keyword = Session :: get('keyword');
        $products = DB :: table('products')
        ->join('categories','products.category_id','=','categories.category_id')
        ->where('product_name','like','%'.$keyword.'%')
        ->orWhere('painter_name','like','%'.$keyword.'%')
        ->orWhere('categories.category_name','like','%'.$keyword.'%')
        ->paginate(12);
        return view('all_products_view',['products' => $products]);
    }
}