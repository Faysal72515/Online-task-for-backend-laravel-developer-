<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function upload_item(Request $request){
        //  Item::insert([
        //     'item_type'=> $request->item_type,
        //     'location_id'=> $request->location_id,
        //     'tradable' =>1,
        //     'user_id'-> Auth::user()->id,
        //     'status'=> $request->status,
        //     'is_active'=>1,
        //  ]);
        $validator = Validator::make($request->all(), [
            'item_type'=> 'required|string|regex:/^[A-Za-z\s\-\_\.\0-9]*$/|max:225|unique:items',
            'description'=> 'string|regex:/^[A-Za-z0-9\s\-\_\#\/\.\,]*$/|max:225',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $items = new Item();
            $items->item_type =  $request->item_type;
            $items->tradable = 1;
            $items->user_id = Auth::user()->id;
            $items->status = $request->status;
            $items->is_active =1;
$location = DB::select('select id from locations where user_id = ?', [$items->user_id]);
            $l_id = intval($location);
            $items->location_id =$l_id;
            $items->save();
         return response()->json([
            'message' =>'Item '.$items->id.' has been uploaded successfully',
            'Category Info.' => $items,
         ],201);

    }


    public function fetch_spe_item(Request $request){
        //return 'Getting specific item page.';

        //$items_id =DB::select('select id from items where location_id?',[$request->item_id]);

        //  $data=DB::table('locations')
        //  ->join('items','locations.id', "=" , 'items.location_id')
        //  ->select('items.id','item_type','items.location_id','locations.*','items.tradable','items.user_id','items.status','items.is_active')->where('locations.id', $request->location)
        //  ->get();


        $data=DB::table('items')
        ->join('locations','items.location_id', "=" , 'locations.id')
        ->join('users','items.user_id','=','users.id')
        ->select('items.id','items.item_type','items.location_id','locations.*','items.tradable','items.user_id', 'users.id','users.first_name','users.last_name','items.status','items.is_active')
        ->where('items.id', $request->items_id)
        ->get();

        // $data=DB::table('items')
        // ->join('locations','items.location_id', "=" , 'locations.id')
        // ->join('users','items.user_id','=','users.id')
        // ->select('users.*','items.*','locations.*')
        // ->get();

        $filedata=DB::table('file')
        ->join('mainfiles','files_id', "=" , 'mainfiles.id')
        ->select('mainfiles.id','mainfiles.item_id','file.name','file','extension','size','description','files_id','mainfiles.is_primary')
        ->where('mainfiles.id', $request->files_id)
        ->get();

        $productData=DB::table('products')
        ->join('categories','products.category_id', "=" , 'categories.id')
        ->join('sub_categories','products.sub_category_id', "=" , 'sub_categories.id')
        ->select('products.id','products.item_id','products.title','products.category_id','categories.id','categories.name','categories.type','categories.is_active','products.sub_category_id', 'sub_categories.id', 'sub_categories.name','sub_categories.parent_id','sub_categories.is_active','products.negotiable','products.price','products.condition','products.description','products.min_quantity','products.validity', 'products.file_id')
        ->where('products.id', $request->productID)
        ->get();

        return response()->json([
            'Message' =>'Success',
            'results' => $data,
            'files'=> $filedata,
            'product'=> $productData,
         ],200);
    }
}
