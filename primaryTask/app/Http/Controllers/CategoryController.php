<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{


    public function product_category(Request $request){
        $validator = Validator::make($request->all(), [

            'name'=> 'required|max:255|regex:/^[A-Za-z0-9\-\s\,\_]*$/|unique:categories',
            'type'=> 'required|max:255|regex:/^[A-Za-z0-9\-\s\,\_]*$/',

        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $category=Category::insert([
            'name'=> $request->name,
            'type'=> $request->type,
            'is_active'=> 1,
         ]);

         return response()->json([
            'message' =>'New Category Has Been Uploaded Successfully',
            'Category Info.' => $category,
         ],201);

    }


    public function sub_category(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=> 'required|max:255|regex:/^[A-Za-z0-9\-\s\,\_]*$/|   unique:sub_categories',
            'category_id'=> 'required|max:20|regex:/^[0-9]*$/',

        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

         $id= $request->category_id;
         //$total_cate_id= Category::find($id)->id;

         if(Category::where('id', $id)->firstOrFail()){
              $subCategory=Subcategory::insert([
                'name'=> $request->name,
                'parent_id'=>$request->category_id,
                'is_active'=> 1,
         ]);

         return response()->json([
            'message' =>'A New Sub-category Has Been Uploaded Successfully',
            'Sub Category Info.' => $subCategory,
         ],201);
         }
         else{
            return response()->json([
                'message' =>'Missing this category.',
                'success' => false,
             ],401);
        }

    }

    public function fetch_sub_category(Request $request){
        $name = $request->name;
        $sub_category = Category::find(1)->one_to_many()->where('name', $name)
        ->first();
            return response()->json([
                'message' =>'One to many relationship of sub-categories',
                'Sub Category.' => $sub_category,
                //'Input.' => $name,
            ], 200);
        }


}