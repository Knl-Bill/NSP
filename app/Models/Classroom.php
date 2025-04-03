<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = ['class_code', 'programme_name', 'description', 'faculty_name', 'joining_code'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
