<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function level() {
        return $this->belongsTo(Level::class);
    }
    public function presences()
    {
        return $this->belongsToMany(Presence::class, 'student_presence');
    }
}
