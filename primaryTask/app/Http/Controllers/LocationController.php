<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'=> 'required|string|regex:/^([a-zA-z0-9\s\-\_\,])+$/',
            ]);
            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }

        $code  = $request->code;
        $location = Location::where('code', $code)->first();
        //$location = User::find(1)->ono_to_one_location;

    return response()->json([
        'message' =>'One to one relationship between Location and User',
        'Location.' => $location,
        //'Input.' => $name,
    ], 200);




    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:11|regex:/^[A-Za-z0-9-]+$/|unique:locations',
            'country' => 'required|string|regex:/^([a-zA-z])+$/',
            'address_1'=> 'required|max:255|regex:/^[A-Za-z0-9\-\s\,\_]*$/',
            'address_2'=> 'max:255',
            'city'=> 'required|string|regex:/^([a-zA-z])+$/',
            'state'=> 'required|string|regex:/^([a-zA-z])+$/',
            'zone'=> 'required|string|regex:/^[A-Za-z0-9\-\s\,]*$/',
            'zip_code'=> 'required|string|min:4|max:4|regex:/^[0-9]*$/',
            'lat'=> 'required|max:18|regex:/^[0-9]{2}(\.[0-9]{1,15})?$/',
            'lng'=> 'required|max:17|regex:/^[0-9]{2}(\.[0-9]{1,14})?$/',
            'type'=> 'required|string|regex:/^[A-Za-z0-9\s\-]*$/|max:25',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $location = new Location();
        //$location->code = $request->has('code')? $request->get('code'):'';
        $location->code = $request->code;
        $location->country = $request->country;
        $location->address_1 = $request->address_1;
        $location->address_2 = $request->address_2;
        $location->city = $request->city;
        $location->state = $request->state;
        $location->zone = $request->zone;
        $location->zip_code = $request->zip_code;
        $location->lat = $request->lat;
        $location->lng = $request->lng;
        $location->type = $request->type;
        $location->user_id =Auth::user()->id;

        $location->save();
        return response()->json([
            'message'=>'Location Info. Has Been Stored Successfully.',
            'location'=> $location
        ],201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //
    }
}
