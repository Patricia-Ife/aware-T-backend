<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Level;
use App\Http\Resources\LevelResource;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Level::latest()->get();
        return response()->json(LevelResource::collection($data));
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
            'name' => 'required|string|max:255|unique:levels',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $level = Level::create([
            'name' => $request->name,
        ]);

        return response()->json(new LevelResource($level));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $level = Level::find($id);
        if (is_null($level)) {
            return response()->json('Data not found', 404);
        }
        return response()->json(new LevelResource($level));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Level $level)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255|unique:levels',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $level->update($request->all());

        return response()->json(new LevelResource($level));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Level $level)
    {
        $level->delete();

        return response()->json('Level deleted successfully');
    }
}
