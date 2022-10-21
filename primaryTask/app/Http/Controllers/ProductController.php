<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\File;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //

    public function store_product(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'title'=> 'required|max:255|regex:/^[A-Za-z0-9\-\s\,\_]*$/',
            'negotiable'=> 'required|regex:/^[0-1]*$/',
            'price'=> 'required|max:6|regex:/^[0-9]{0,4}(\.[0-9]{1,3})?$/',
            'condition'=> 'required|string|regex:/^([a-zA-z\s\/\. ])+$/|max:255',
            'description'=> 'required|string|regex:/^[A-Za-z0-9\s\-\_\#\/\.\,]*$/|max:225',
            'quantity' => 'required|string|max:11|regex:/^[0-9]+$/',
            'file_id' => 'required|string|max:11|regex:/^[0-9]+$/|unique:products',
            'item_id'=>'required|regex:/^[0-9]+$/',
            'category_id'=>'required|regex:/^[0-9]+$/',
            'sub_category_id'=>'required|regex:/^[0-9]+$/',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $product = new Product();

        $product->title = $request->title;
        $product->negotiable = $request->negotiable;
        $product->price = $request->price;
        $product->condition = $request->condition;
        $product->description = $request->description;
        $product->min_quantity = $request->quantity;
        $product->file_id = $request->file_id;
        $product->item_id = $request->item_id;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;

        $product->save();


        $x = $request->category1;
        $y = $request->category2;
        $category = Category::find([$x, $y]) ;
        $product->categories()->attach($category);


        return response()->json([
            'message' => 'Product No.'.$product->id. ' Has Been Uploaded Successfully',
            'product Info' => $product,
        ], 201);
    }



        public function fetch_product(Request $request)
        {
            $title = $request->title;
            $product = File::find(1)->one_to_many_relation_between_product_and_file()->where('title', $title)->first();
            return response()->json([
                'Message' =>'One to many relationship between product and file (images)',
                'Product Information' => $product,
                //'Input.' => $name,
            ], 200);
        }

            public function fetch(Request $request)
            {
                $title = $request->title;
                //$product = Product::where('title', $title)->get();
                $product = Product::where('title', $title)->get();
                                return response()->json([
                                    'Message' =>'Search result',
                                    'Product Information' => $product,
                                    //'Input.' => $name,
                                ], 200);


            }
}
