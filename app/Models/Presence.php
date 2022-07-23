<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function delegate()
    {
        return $this->belongsTo(User::class);
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_presence');
    }
}
