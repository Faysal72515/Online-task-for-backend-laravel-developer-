<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Mainfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    public function file(Request $request)
    {
        // return 'Passed';
        $validator = Validator::make($request->all(), [
            'images'=> 'mimes:jpg,jpeg,png,svg,gif|max:30000',
            'description'=> 'max:225',
            //'files_id'=> 'required|string|regex:/^[0-9]*$/|max:225',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $file_info = new File();
        if ($request->hasFile('images')) {
            $files = $request->file();
            $file_size = $request->file('images')->getSize();
            $imageLocation = array();
            $i=0;

            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = 'Product_' . time() . '_'. time(). ++$i . '.' . $extension;
                $location = '/images/products/';
                $file->move(public_path() . $location, $filename);
                $imageLocation[] = $location.$filename;
            }
            $file_info->name = $filename;
            $file_info->file = implode('|', $imageLocation);
            $file_info->extension =  $extension;
            $file_info->size =   $file_size;
            $file_info ->description = $request-> description;
            $file_info ->files_id =  $request-> files_id;
            $file_info->save();

            return response()->json([
                'message' =>'File No. '. $file_info->id. ' Has Been Uploaded Successfully',
                'File Info.' => $file_info,
            ], 201);
        }
    }

    public function upload_contents_of_main_file(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id'=> 'required|string|regex:/^[0-9]*$/|max:225',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        Mainfile::insert([
            'item_id'=> $request->item_id,
            'is_primary' =>1,
        ]);
        return response()->json([
            'Message' =>'Main file '.$request->item_id.' has been successfully uploaded into Files',
            'File Info.' => true,
        ], 201);
        }

        //return 'success';
   // }
}