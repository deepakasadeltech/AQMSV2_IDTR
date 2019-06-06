<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\ParentDepartment;
use App\Models\Department;
use App\Models\Counter;
use App\Models\Queue;
use Carbon\Carbon;

class CallRepository
{
    public function getUsers()
    {
        return User::all();
    }

    public function getCounters()
    {
        return Counter::all();
    }

    public function getPDepartments()
    {
        return ParentDepartment::all();
    }
	
	public function getDepartments()
    {
        return Department::all();
    }

    public function getActiveDepartments()
    {
        $depid = User::all()->where('user_status', '1');
       
        $ids = [];
        foreach($depid as $id){
            if(!empty($id->department_id)){
                $ids[$id->department_id] = $id->department_id;
            }
        }
        return Department::whereIn('id', $ids)->get();
    }
	
    public function getNextToken(Department $department)
    {
        return $department->queues()
                    ->where('called', 0)
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->first();
    }

    public function getLastToken(Department $department)
    {
        return $department->queues()
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->orderBy('created_at', 'desc')
                    ->first();
    }

    public function getCustomersWaiting(Department $department)
    {
        return $department->queues()
                    ->where('called', 0)
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->count();
    }
	
	public function isTokenExist($pid, $department_id, $token)
    {
        return Queue::where('pid', $pid)
                    ->where('department_id', $department_id)
					->where('number', $token)
					->where('called', 0)
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->count();
    }

    public function tokenDetailBeforeCalled()
    {
        return Queue::with('department')->where('called', 1)
                    ->where('queue_status', 0)
                    ->where('token', 'O')
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->get();
    }

    public function tokenDetailBeforeCalledSingle()
    {
        return Queue::with('department')->where('called', 1)
                    ->where('queue_status', 0)
                    ->where('token', 'O')
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    //->inRandomOrder()
                    ->first();
    }

    public function tokenRePrint()
    {
        return Queue::with('department')->where('called', 0)
                    ->where('queue_status', 1)
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->get();
    }
//-------------====================================-------------------------
public function NgetNextToken(Department $department)
{
    return $department->queues()
                ->where('called', 0)
                ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                ->first();
}

public function NgetLastToken()
{
    return Queue::where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                ->orderBy('created_at', 'desc')
                ->where('token', 'N')
                ->first();
}

public function NgetCustomersWaiting(Department $department)
{
    return $department->queues()
                ->where('called', 0)
                ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                ->where('token', 'N')
                ->count();
}

public function NisTokenExist($pid, $department_id, $token)
{
    return Queue::where('pid', $pid)
                ->where('department_id', $department_id)
                ->where('number', $token)
                ->where('called', 0)
                ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                ->where('token', 'N')
                ->count();
}

//------------======================================--------------------------




}
