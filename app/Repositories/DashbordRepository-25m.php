<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Setting;
use App\Models\Queue;
use App\Models\Call;
use App\Models\Counter;
use App\Models\Department;
use App\Models\ParentDepartment;
use Carbon\Carbon;
use App\Models\DoctorReport;


class DashbordRepository
{
    public function getSetting()
    {
        return Setting::first();
    }

    public function getTodayQueue()
    {
        return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->count();

    }

    public function getTodayServed()
    {
        return Call::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->count();
    }

    public function getCounters()
    {
        return Counter::all();
    }

    public function getTodayMissed()
    {
        $setting = $this->getSetting();

        $calls = Call::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->get();

        $count = 0;
        foreach ($calls as $call) {
            $next_call_key = $calls->search(function($incall, $key) use($call) {
                if(($incall->id>$call->id) && ($incall->counter_id==$call->counter_id)) return $key;
            });

            if($next_call_key && ($calls[$next_call_key]->created_at->timestamp-$call->created_at->timestamp)<$setting->missed_time) $count++;
        }
        return $count;
    }

    public function getTodayOverTime()
    {
        $setting = $this->getSetting();

        $calls = Call::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->get();

        $count = 0;
        foreach ($calls as $call) {
            $next_call_key = $calls->search(function($incall, $key) use($call) {
                if(($incall->id>$call->id) && ($incall->counter_id==$call->counter_id)) return $incall;
            });

            if($next_call_key && ($calls[$next_call_key]->created_at->timestamp-$call->created_at->timestamp)>$setting->over_time) $count++;
        }
        return $count;
    }

    public function getTodayCalls()
    {
        $counters = $this->getCounters();

        $count = [];
        foreach ($counters as $counter) {
            $count[] = $counter->calls()
                    ->whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->count();
        }

        return $count;
    }

    public function getYesterdayCalls()
    {
        $counters = $this->getCounters();

        $count = [];
        foreach ($counters as $counter) {
            $count[] = $counter->calls()
                    ->whereBetween('created_at', [Carbon::yesterday()->format('Y-m-d').' 00:00:00', Carbon::yesterday()->format('Y-m-d').' 23:59:59'])
                    ->count();
        }

        return $count;
    }

    public function updateNotification($data)
    {
        $setting = $this->getSetting();

        $setting->notification = $data['notification'];
        $setting->size = $data['size'];
        $setting->color = $data['color'];
        $setting->save();

        return $setting;
    }
	
	public function getPatientList($pid = '', $department_id = '')
	{
		$calls = Call::with('department', 'counter')
		->whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
		->where('pid', $pid)
		->where('department_id', $department_id)
		->where('doctor_work_end', 0)->where('token', 'O')
		->orderBy('id', 'desc')
		->take(3)
		->get();
		
		return $calls;
    }
    
    public function getPatientListDoctorWise($id = '', $department_id = '')
	{
		$calls = Call::with('department', 'counter')
		->whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
		->where('user_id', $id)
		->where('department_id', $department_id)
        ->where('doctor_work_end', 0)
        ->where('token', 'O')
		->orderBy('id', 'desc')
		->take(6)
		->get();
		
		return $calls;
	}
	
	public function getPatientSeenList($id = '')
	{
		$calls = DoctorReport::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
        ->where('user_id', $id)
        ->where('token', 'O')
		->count();
		
		return $calls;
    }
//-----------------------------------------------
    public function getDailyDoctorAvgTime($id = '')
	{
		//$stat_day = date();
         return DoctorReport::whereBetween('start_time', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
         ->where('user_id', $id)->where('token', 'O')->get();
    }

    public function getTodayQueueByCounter($department_id = '')
    {
        return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->where('called', 0)
                    ->where('token', 'O')
                    ->where('department_id', $department_id)
		            ->get();

    }

    public function getTodayPalatinump($department_id = '')
    {
        return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->where('called', 0)->where('token', 'O')->where('priority', 1)
                    ->where('department_id', $department_id)
		            ->get();

    }

    public function getTodayGoldp($department_id = '')
    {
        return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->where('called', 0)->where('token', 'O')->where('priority', 2)
                    ->where('department_id', $department_id)
		            ->get();

    }

    public function getTodaySilverp($department_id = '')
    {
        return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->where('called', 0)->where('token', 'O')->where('priority', 3)
                    ->where('department_id', $department_id)
		            ->get();

    }

    public function getTodayPatientCalledByCounter($department_id = '')
    {
        return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->where('called', 1)->where('token', 'O')
                    ->where('department_id', $department_id)
		            ->get();

    }

    public function getTodayPatientCalledByDoctor($id = '')
    {
        return Call::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->where('user_id', $id)->where('token', 'O')
		            ->get();
		            

    }

    public function getUserDetails($pid = '', $department_id = '', $counter_id = ''){
        $calls = User::with('department', 'counter') 
        ->where('pid', $pid)
		->where('department_id', $department_id)
        ->where('counter_id', $counter_id)
        ->first();
    
        return $calls;
    }

    public function getUserDoctor()
    {
        return User::with('department', 'counter') 
                   ->where('role', 'D')
                   ->get();
    }

    public function getUserStaff(){
        return User::where('role', 'S')->get(); 
    }

    public function gettotalDoctorPresent()
    {
        return User::where('user_status', '1')->where('role', 'D')
                   ->get();
    }

    public function gettotalDoctorAbsent()
    {
        return User::where('user_status', '2')->where('role', 'D')
                   ->get();
    }

    public function getAllDepartmentTotalQueueInToday()
    {     
 return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])->where('called', 0)->where('token', 'O')->get();

    }
    public function getAllDepartmentTotalCalledInToday()
    {
        return Call::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])->where('doctor_work_start', 0)->where('token', 'O')->get();

    }

  //-----------------------------------------------
  
    public function getPDepartments()
    {
        return ParentDepartment::all();
    }
	
	public function getPDepartmentName($id)
	{
		return ParentDepartment::find($id);
	}
	
	public function getDepartments()
    {
        return Department::all();
    }

    

    public function getNextToken(Department $department)
    {
        return $department->queues()
                    ->where('called', 0)->where('token', 'O')
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->first();
    }

    public function getNextTokenByPriority(Department $department)
    {
        return $department->queues()
                    ->where('called', 0)->where('token', 'O')
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->orderBy('priority', 'asc')
					->take(1)
					->get();
					//->first();
    }
//------==========================----For--Scanner------===========================----------

public function NgetPatientList($pid = '', $department_id = '')
	{
		$calls = Call::with('department', 'counter')
		->whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
		->where('pid', $pid)
		->where('department_id', $department_id)
		->where('doctor_work_end', 0)->where('token', 'N')
		->orderBy('id', 'desc')
		->take(3)
		->get();
		
		return $calls;
    }
    
    public function NgetPatientListDoctorWise($id = '', $department_id = '')
	{
		$calls = Call::with('department', 'counter')
		->whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
		->where('user_id', $id)
		->where('department_id', $department_id)
        ->where('doctor_work_end', 0)
        ->where('token', 'N')
		->orderBy('id', 'desc')
		->take(6)
		->get();
		
		return $calls;
	}
	
	public function NgetPatientSeenList($id = '')
	{
		$calls = DoctorReport::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
        ->where('user_id', $id)
        ->where('token', 'N')
		->count();
		
		return $calls;
    }
//-----------------------------------------------
    public function NgetDailyDoctorAvgTime($id = '')
	{
		//$stat_day = date();
         return DoctorReport::whereBetween('start_time', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
         ->where('user_id', $id)->where('token', 'N')->get();
    }

    public function NgetTodayQueueByCounter($department_id = '')
    {
        return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->where('called', 0)
                    ->where('token', 'N')
                    ->where('department_id', $department_id)
		            ->get();

    }

    public function NgetTodayPalatinump($department_id = '')
    {
        return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->where('called', 0)->where('token', 'N')->where('priority', 1)
                    ->where('department_id', $department_id)
		            ->get();

    }

    public function NgetTodayGoldp($department_id = '')
    {
        return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->where('called', 0)->where('token', 'N')->where('priority', 2)
                    ->where('department_id', $department_id)
		            ->get();

    }

    public function NgetTodaySilverp($department_id = '')
    {
        return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->where('called', 0)->where('token', 'N')->where('priority', 3)
                    ->where('department_id', $department_id)
		            ->get();

    }

    public function NgetTodayPatientCalledByCounter($department_id = '')
    {
        return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->where('called', 1)->where('token', 'N')
                    ->where('department_id', $department_id)
		            ->get();

    }

    public function NgetTodayPatientCalledByDoctor($id = '')
    {
        return Call::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
                    ->where('user_id', $id)->where('token', 'N')
		            ->get();
		            

    }

    public function NgetUserDetails($pid = '', $department_id = '', $counter_id = ''){
        $calls = User::with('department', 'counter') 
        ->where('pid', $pid)
		->where('department_id', $department_id)
        ->where('counter_id', $counter_id)
        ->first();
    
        return $calls;
    }

    public function NgetUserDoctor()
    {
        return User::with('department', 'counter') 
                   ->where('role', 'T')
                   ->get();
    }

    public function NgetUserStaff(){
        return User::where('role', 'S')->get(); 
    }

    public function NgettotalDoctorPresent()
    {
        return User::where('user_status', '1')->where('role', 'T')
                   ->get();
    }

    public function NgettotalDoctorAbsent()
    {
        return User::where('user_status', '2')->where('role', 'T')
                   ->get();
    }

    public function NgetAllDepartmentTotalQueueInToday()
    {     
 return Queue::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])->where('called', 0)->where('token', 'N')->get();

    }
    public function NgetAllDepartmentTotalCalledInToday()
    {
        return Call::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])->where('doctor_work_start', 0)->where('token', 'N')->get();

    }

  //-----------------------------------------------
  
    public function NgetPDepartments()
    {
        return ParentDepartment::all();
    }
	
	public function NgetPDepartmentName($id)
	{
		return ParentDepartment::find($id);
	}
	
	public function NgetDepartments()
    {
        return Department::all();
    }

    

    public function NgetNextToken(Department $department)
    {
        return $department->queues()
                    ->where('called', 0)->where('token', 'N')
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->first();
    }

    public function NgetNextTokenByPriority(Department $department)
    {
        return $department->queues()
                    ->where('called', 0)->where('token', 'N')
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->orderBy('priority', 'asc')
					->take(1)
					->get();
					//->first();
    }

//------=========================-----------------------===========================-----------	
	
}
