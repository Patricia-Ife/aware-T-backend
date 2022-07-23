<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;
use App\Http\Resources\StudentResource;

class StudentController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Student::latest()->get();
        return response()->json(StudentResource::collection($data));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'matricule' => 'required|string|min:7|max:7|unique:students',
            'level_id' => 'required|integer'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $student = Student::create([
            'name' => $request->name,
            'matricule' => $request->matricule,
            'level_id' => $request->level_id
         ]);

        return response()->json(new StudentResource($student));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::find($id);
        if (is_null($student)) {
            return response()->json('Data not found', 404);
        }
        return response()->json(new StudentResource($student));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'string|max:255',
            'matricule' => 'string|min:7|max:7',
            'level_id' => 'integer',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        // $student->name = $request->name;
        // $student->matricule = $request->matricule;
        // $student->save();
        $student->update($request->all());

        return response()->json(new StudentResource($student));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json('Student deleted successfully');
    }
}
