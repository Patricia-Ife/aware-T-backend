<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Presence;
use App\Http\Resources\PresenceResource;
use Illuminate\Support\Facades\Storage;

class PresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Presence::latest()->get();
        return response()->json(PresenceResource::collection($data));
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
            'date' => 'required|date',
            'duration' => 'required|numeric',
            'signature' => 'required|string',
            'content' => 'required|string',
            'session' => 'required|string',
            'hall' => 'required|string',
            'delegate_id' => 'required|integer',
            'professor_id' => 'required|integer',
            'course_id' => 'required|integer',
            'students' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // $signature_image =
        //     base64_encode(file_get_contents($request->file('signature')));

        $presence = Presence::create([
            'date' => $request->date,
            'duration' => $request->duration,
            'content' => $request->content,
            'session' => $request->session,
            'hall' => $request->hall,
            'delegate_id' => $request->delegate_id,
            'signature' => $request->signature,
            'professor_id' => $request->professor_id,
            'course_id' => $request->course_id,
        ]);

        $presence->students()->attach(json_decode($request->students));


        return response()->json(new PresenceResource($presence));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $presence = Presence::find($id);
        if (is_null($presence)) {
            return response()->json('Data not found', 404);
        }
        return response()->json(new PresenceResource($presence));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Presence $presence)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'date',
            'duration' => 'numeric',
            'signature' => 'string',
            'content' => 'string',
            'session' => 'string',
            'hall' => 'string',
            'delegate_id' => 'integer',
            'professor_id' => 'integer',
            'course_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $presence->update($request->except(['students']));
        if(isset($request->students)) {
            $presence->students()->sync(json_decode($request->students));
        }
        // if(isset($request->signature)) {
        //     $signature_image =
        //         base64_encode(file_get_contents($request->file('signature')));
        //     $presence->update(['signature' => $signature_image]);
        // }
        return response()->json(new PresenceResource($presence));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Presence $presence)
    {
        Storage::disk('public')->delete($presence->signature);
        $presence->delete();

        return response()->json('Presence deleted successfully');
    }
}
