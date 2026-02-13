<?php

namespace App\Http\Controllers;

use App\Models\Towns;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class TownsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $country = $request->country;
        $import = ( !empty($request->import) && $request->import == 'confirmed' ) ? true : false;

        if($import){
            $path = storage_path() . '/cities.json';
            $errors = [];
            if(file_exists($path)){
                $cities = json_decode(file_get_contents($path), true);
                foreach ($cities as $key => $city) {
                    try {
                        Towns::create([
                            'country'=> $city['country'],
                            'name'=> $city['name'],
                            'lat'=> $city['lat'],
                            'lng'=> $city['lng'],
                        ]);
                    } catch (QueryException $e){
                        $errors[] = $e->getMessage();
                    }
                }
                return response()->json(['country'=> $country, 'data'=> $errors, 'total'=> count($cities) ]);
            }
            return response()->json(['country'=> $country, 'data'=> [], 'path'=> $path ]);
        } else {
            if(!empty($country)){
                $cities = Towns::where('country', $country)->get();
                return response()->json(['country'=> $country, 'data'=> $cities, ]);
            } else {
                return response()->json(['country'=> $country, 'data'=> [], ]);
            }
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response()->json(['data'=> []]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Towns  $towns
     * @return \Illuminate\Http\Response
     */
    public function show(Towns $towns)
    {
        return response()->json(['data'=> []]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Towns  $towns
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Towns $towns)
    {
        return response()->json(['data'=> []]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Towns  $towns
     * @return \Illuminate\Http\Response
     */
    public function destroy(Towns $towns)
    {
        return response()->json(['data'=> []]);
    }
}
