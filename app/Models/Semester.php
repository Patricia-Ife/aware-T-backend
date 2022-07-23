<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $guarded = [];

    protected $with = ['year'];

    use HasFactory;

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }
}
