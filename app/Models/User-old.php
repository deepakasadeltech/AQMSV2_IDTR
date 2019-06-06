<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'username', 'email','pid','department_id', 'role', 'password','user_status'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function calls()
	{
		return $this->hasMany('App\Models\Call');
	}

	public function getRoleTextAttribute($value)
	{
		if($this->attributes['role']=='A') {
			return trans('messages.mainapp.role.Administrator');
		}elseif($this->attributes['role']=='D'){
			return trans('messages.mainapp.role.Doctor');
		}
	    elseif($this->attributes['role']=='H'){
		  return trans('messages.mainapp.role.Helpdesk');
	   }
	   elseif($this->attributes['role']=='C'){
		return trans('messages.mainapp.role.CMO');
	   }
	   elseif($this->attributes['role']=='I'){
		return trans('messages.mainapp.role.Displayctrl');
	 }
		else{
			return trans('messages.mainapp.role.Staff');
		}

		
	}

    public function getIsAdminAttribute($value)
	{
		if($this->attributes['role']=='A') return true;

        return false;
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



}
