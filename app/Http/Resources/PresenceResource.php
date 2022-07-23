<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PresenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'duration' => $this->duration,
            'signature'=> $this->signature,
            'professor' => $this->professor,
            'course' => $this->course,
            'content' => $this->content,
            'session' => $this->session,
            'hall' => $this->hall,
            'delegate' => $this->delegate,
            'students' => $this->students,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
