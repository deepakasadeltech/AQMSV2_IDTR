<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Models\Call;
use Carbon\Carbon;
use App\Models\ParentDepartment;

class DisplaySecondRepository
{
    public function getSettings()
    {
        return Setting::first();
    }

    public function getDisplayData()
    {
        $calls = Call::with('department', 'counter')
					->where('called_date', Carbon::now()->format('Y-m-d'))
                    ->where('doctor_work_end', 0)
                    ->where('token', 'N')
                    ->orderBy('id', 'desc')
                    //->take(4)
                    ->get();
		//return $calls;
        $data = [];
		foreach($calls as $cls)
		{
			$call_id = $cls->id;
			$call_number = $cls->department->letter.''.$cls->nt_number;
			$counter = $cls->counter->name;
			$dep_id = $cls->pid;
			$dep_details = ParentDepartment::find($cls->pid);
			$dep = $dep_details->name;
			$sub_dep_id = $cls->department_id;
			$sub_dep = $cls->department->name;
			$view_status = $cls->view_status;
			$timeslot = $cls->timeslot;
			$checkingCounter = $cls->checkingCounter;
			$data[$cls->checkingCounter][] = [
											'call_id'=>$call_id,
											'call_number'=>$call_number,
											'counter'=>$counter,
											'dep_id'=>$dep_id,
											'dep'=>$dep,
											'sub_dep_id'=>$sub_dep_id,
											'sub_dep'=>$sub_dep,
											'view_status'=>$view_status,
											'timeslot' => $timeslot,
											'checkingCounter' => $checkingCounter
			];
			
		}
		$filter_arr = [];
		if(!empty($data)){
			foreach($data as $dt){
				$filter_arr = array_merge($filter_arr, array_chunk($dt, 9));
			}
		}
		$final_arr = [];
		if(!empty($filter_arr))
		{
			$final_arr = array_chunk($filter_arr, 1);
		}
		
		return $final_arr;
			
		/*
        for ($i=0;$i<4;$i++) {
            $data[$i]['call_id'] = (isset($calls[$i]))?$calls[$i]->id:'NIL';
            $data[$i]['number'] = (isset($calls[$i]))?(($calls[$i]->department->letter!='')?$calls[$i]->department->letter.'-'.$calls[$i]->number:$calls[$i]->number):'NIL';
            $data[$i]['call_number'] = (isset($calls[$i]))?(($calls[$i]->department->letter!='')?$calls[$i]->department->letter.' '.$calls[$i]->number:$calls[$i]->number):'NIL';
            $data[$i]['counter'] = (isset($calls[$i]))?$calls[$i]->counter->name:'NIL';
        }
		*/
       // return $data;
	}
	
	public function getLastCallId()
	{
		$calls = Call::with('department', 'counter')
					->where('called_date', Carbon::now()->format('Y-m-d'))
                    ->where('doctor_work_end', 0)
                    ->where('token', 'N')
                    ->orderBy('id', 'desc')
					->first();
	    if(!empty($calls)){
			return $calls->id;
		}else{
			return '';
		}			
	}

	public function getAudioCallId()
	{
		$calls = Call::with('department', 'counter')
					->where('called_date', Carbon::now()->format('Y-m-d'))
                    ->where('doctor_work_end', 0)
                    ->where('token', 'N')
                    ->orderBy('id', 'asc')
					->first();
	    if(!empty($calls)){
			return $calls->id;
		}else{
			return '';
		}			
	}

	public function getCurrentCallDetails($id)
	{
		$calls = Call::with('department', 'counter')
        ->where('called_date', Carbon::now()->format('Y-m-d'))
        ->where('token', 'N')
		->where('id', $id)
		->first();
		return $calls;
	}
	

	public function getNextCallId($id)
	{
		$calls = Call::with('department', 'counter')
					->where('called_date', Carbon::now()->format('Y-m-d'))
                    ->where('doctor_work_end', 0)
                    ->where('token', 'N')
					->where('id', '>', $id)
                    ->orderBy('id', 'asc')
					->first();
	    if(!empty($calls)){
			return $calls->id;
		}else{
			return 'NOID';
		}	
	}
//------------------------
public function getfirstToken()
	{
		$calls = Call::with('department', 'counter')
					->where('called_date', Carbon::now()->format('Y-m-d'))
                    ->where('doctor_work_end', 0)
                    ->where('token', 'N')
					->orderBy('calls.id', 'desc')
                    //->take(4)
					->get();
		return $calls;
	}

	public function getDepartmentName()
	{
		$depet = ParentDepartment::all();
					
		return $depet;
	}	
//----------------------


}
