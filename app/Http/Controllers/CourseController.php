<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Course;
use App\Http\Resources\CourseResource;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Course::latest()->get();
        return response()->json(CourseResource::collection($data));
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
            'title' => 'required|string|max:500',
            'syllabus' => 'required|string',
            'level_id' => 'required|integer',
            'semester_id' => 'required|integer',
            'professors' => 'required',
            'appreciation' => 'string',
            'remark' => 'string',
            // 'professors.*' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $course = Course::create([
            'name' => $request->name,
            'title' => $request->title,
            'syllabus' => $request->syllabus,
            'level_id' => $request->level_id,
            'semester_id' => $request->semester_id,
        ]);

        $course->professors()->attach(json_decode($request->professors));

        return response()->json(new CourseResource($course));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::find($id);
        if (is_null($course)) {
            return response()->json('Data not found', 404);
        }
        return response()->json(new CourseResource($course));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'title' => 'string|max:500',
            'syllabus' => 'string',
            'level_id' => 'integer',
            'semester_id' => 'integer',
            'appreciation' => 'string',
            'remark' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        $course->update($request->except(['professors']));
        if (isset($request->professors)) {
            $course->professors()->sync(json_decode($request->professors));
        }

        return response()->json(new CourseResource($course));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json('Course deleted successfully');
    }
}
