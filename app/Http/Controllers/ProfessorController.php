<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Professor;
use App\Http\Resources\ProfessorResource;

class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Professor::latest()->get();
        return response()->json(ProfessorResource::collection($data));
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:professors',
            'phone' => 'required|numeric|digits:9',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $professor = Professor::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return response()->json(new ProfessorResource($professor));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $professor = Professor::find($id);
        if (is_null($professor)) {
            return response()->json('Data not found', 404);
        }
        return response()->json(new ProfessorResource($professor));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Professor $professor)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'string|email|max:255',
            'phone' => 'numeric|digits:9',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $professor->update($request->all());

        return response()->json(new ProfessorResource($professor));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Professor $professor)

    {
        $professor->delete();

        return response()->json('Professor deleted successfully');
    }
}
