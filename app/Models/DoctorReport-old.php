<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorReport extends Model
{
    protected $fillable = ['call_id', 'department_id', 'pid', 'user_id'];

    
}
