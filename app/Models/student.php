<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class student extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'students';
    protected $fillable = [
        'rollno',
        'name',
        'phoneno',
        'email',
        'course',
        'batch',
        'department',
        'gender',
        'hostelname',
        'roomno',
        'password'
    ];
    public function setPasswordAttribute($value)
    {
    $this->attributes['password'] = bcrypt($value);
    }
}
