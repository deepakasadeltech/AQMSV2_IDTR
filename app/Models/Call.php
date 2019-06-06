<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    protected $fillable = ['queue_id', 'pid', 'department_id', 'counter_id', 'user_id', 'number', 'nt_number', 'barcode', 'timeslot', 'checkingCounter', 'newbarcode', 'token', 'priority', 'called_date'];

    public function queue()
	{
		return $this->belongsTo('App\Models\Queue');
	}

    public function department()
	{
		return $this->belongsTo('App\Models\Department');
	}

	public function pdepartment()
	{
		return $this->belongsTo('App\Models\ParentDepartment');
	}

    public function counter()
	{
		return $this->belongsTo('App\Models\Counter');
	}

    public function user()
	{
		return $this->belongsTo('App\Models\User');
	}
}
