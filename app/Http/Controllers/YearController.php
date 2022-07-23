<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Year;
use App\Http\Resources\YearResource;


class YearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Year::latest()->get();
        return response()->json(YearResource::collection($data));
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
            'name' => 'required|string|max:255|unique:years',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $year = Year::create([
            'name' => $request->name,
        ]);

        return response()->json(new YearResource($year));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $year = Year::find($id);
        if (is_null($year)) {
            return response()->json('Data not found', 404);
        }
        return response()->json(new YearResource($year));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Year $year)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255|unique:years',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $year->update($request->all());

        return response()->json(new YearResource($year));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Year $year)
    {
        $year->delete();

        return response()->json('Year deleted successfully');
    }
}
