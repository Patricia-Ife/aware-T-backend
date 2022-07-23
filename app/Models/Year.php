<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $guarded = [];
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }
}
