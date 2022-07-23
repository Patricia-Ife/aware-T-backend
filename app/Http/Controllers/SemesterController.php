<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\SemesterResource;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Semester::latest()->get();
        return response()->json(SemesterResource::collection($data));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:semesters,name,NULL,id,year_id,' . $request->year_id,
            'year_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $semester = Semester::create([
            'name' => $request->name,
            'year_id' => $request->year_id,
        ]);

        return response()->json(new SemesterResource($semester));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $semester = Semester::find($id);
        if (is_null($semester)) {
            return response()->json('Data not found', 404);
        }
        return response()->json(new SemesterResource($semester));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Semester $semester)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255|unique:semesters,name,NULL,id,year_id,' . $request->year_id,
            'year_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $semester->update($request->all());

        return response()->json(new SemesterResource($semester));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Semester $semester)
    {
        $semester->delete();

        return response()->json('Semester deleted successfully');
    }
}
