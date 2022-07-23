<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];

    protected $with = ['semester', 'presences', 'level'];

    use HasFactory;

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function professors()
    {
        return $this->belongsToMany(Professor::class, 'professor_course');
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }
}
