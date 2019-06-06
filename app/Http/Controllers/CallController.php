<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CallRepository;
use App\Models\User;
use App\Models\ParentDepartment;
use App\Models\Department;
use App\Models\Counter;
use App\Models\Call;
use App\Models\Queue;
use App\Models\DoctorReport;
use App\Models\UhidMaster;
use Carbon\Carbon;
use App\Models\Setting;
class CallController extends Controller
{
    protected $calls;

    public function __construct(CallRepository $calls)
    {
        $this->calls = $calls;
    }

    public function index(Request $request)
    {
		$this->authorize('access', Call::class);
        event(new \App\Events\TokenIssued());

        return view('user.calls.index', [
            'users' => $this->calls->getUsers(),
            'counters' => $this->calls->getCounters(),
			'pdepartments' => $this->calls->getPDepartments(),
            'departments' => $this->calls->getActiveDepartments(),
        ]);
    }

    //----------------------------------------------
public function newToken(){
    //$this->authorize('access', Call::class);
    return view('user.calls.newtoken', [
        'users' => $this->calls->getUsers(),
        'counters' => $this->calls->getCounters(),
        'pdepartments' => $this->calls->getPDepartments(),
        'departments' => $this->calls->getActiveDepartments(),
        'tokendetailbeforecall' => $this->calls->tokenDetailBeforeCalled(),
        'tokensingle' => $this->calls->tokenDetailBeforeCalledSingle(),

    ]);

}

//-----------------------------------------------------
public function printToken(){

    return view('user.calls.tokenprint', [
        'users' => $this->calls->getUsers(),
        'tokendetailbeforecall' => $this->calls->tokenDetailBeforeCalled(),
        'tokensingle' => $this->calls->tokenDetailBeforeCalledSingle(),
        'tokenreprint' => $this->calls->tokenRePrint(),

    ]);
        
}
//---------------------------------------------------------
public function rePrintToken(Request $request, $id){
    $request->session()->flash('printFlag', true);
    $queuemodify = Queue::find($request->id);
    $department = Department::findOrFail($queuemodify->department_id);
       event(new \App\Events\TokenIssued());
       if($queuemodify->token == 'O'){
        $token_number = $queuemodify->number;
        $timeslot = '';
        $newbarcode = $token_number.'_'.\Carbon\Carbon::now()->format('m-Y');
       }
       if($queuemodify->token == 'N'){
        $token_number = $queuemodify->nt_number;
        $timeslot = $queuemodify->timeslot;
        $newbarcode = $token_number.'_'.\Carbon\Carbon::now()->format('m-Y');
       }
        $staffuser = User::find(Auth::user()->id);
        $stt = Setting::first();
        $request->session()->flash('department_name', $department->name);
        $request->session()->flash('number', $token_number);
        $request->session()->flash('total', $queuemodify->customer_waiting);
        $request->session()->flash('uhid',  $queuemodify->uhid);
        $request->session()->flash('timeslot',   $timeslot);
        $request->session()->flash('newbarcode',  $newbarcode);
        $request->session()->flash('priority',  $queuemodify->priority);
        $request->session()->flash('company_name', $stt->name);
        $request->session()->flash('staffname', $staffuser->name); 
        
        flash()->success('print');
    return redirect()->route('print_Token');
}
//-----------------------------------------------------------
public function newTokenGenerator(Request $request, $id){
      $request->session()->flash('printFlag', true);

      $barcode = $request->barcode;
      $newtimeslot = $request->timeslot;
     $newcheckingCounter = $request->checkingCounter;

      $is_uhid_required = $this->isUhidRequired($request->department_id);
		if($is_uhid_required){
			$uhid = $request->uhid;
			$is_uhid_exist = $this->isUHIDExist($uhid);
			if(!$is_uhid_exist) {
				$request->session()->flash('printFlag', false);
				flash()->warning('Invalid UHID, only Number');
				return redirect()->route('new_Token');
			}
		}
    $queuemodify = Queue::find($request->id);
	$department = Department::findOrFail($queuemodify->department_id);
    $departmentdetail = UhidMaster::where('uhid', $request->uhid)->first();
  
    if($newtimeslot =='undefined'){
        flash()->warning('Please Select Timeslot');
        return redirect()->route('new_Token');
    }elseif($newcheckingCounter == 'undefined'){
        flash()->warning('Please Select Work Type');
        return redirect()->route('new_Token'); 
    }elseif($barcode !== $queuemodify->barcode){
        flash()->warning('Please Scan Correct Barcode');
        return redirect()->route('new_Token');
    }
    else{
        $ntimeslot = $newtimeslot; 
        $checkCounter = $newcheckingCounter; 
        
      }

      $queuemodify->token = 'N';
    if($queuemodify->nt_number !== ($queuemodify->token.''.$queuemodify->number)){
        $queuemodify->nt_number = $queuemodify->token.''.$queuemodify->number; 
    }else{
        flash()->warning('You have already New token Taken');
		return redirect()->route('new_Token');
    }
      
      $newbarcode = $queuemodify->nt_number.'_'.\Carbon\Carbon::now()->format('m-Y');
      
      $newlasttoken = $this->calls->NgetLastToken($request->id);
      if($newlasttoken){
        $newWaiting =  $newlasttoken->new_waiting + 1;
        $newtoken = $department->start+$newWaiting.''.$queuemodify->token.''.$queuemodify->number;
      }else{
        $newWaiting = 0;
        $newtoken = $department->start+$newWaiting.''.$queuemodify->token.''.$queuemodify->number;
      }
    
   $queuemodify->uhid = $departmentdetail->uhid;
   $queuemodify->priority = $departmentdetail->priority_type;
   $queuemodify->called = 0;
   $queuemodify->timeslot=  $ntimeslot;
   $queuemodify->checkingCounter= $checkCounter;
   $queuemodify->token = $queuemodify->token;
   $queuemodify->nt_number =  $newtoken;
   $queuemodify->newbarcode = $newbarcode;
   $queuemodify->new_waiting = $newWaiting;
   $queuemodify->queue_status = 1;
    $queuemodify->save();

    $total = $this->calls->getCustomersWaiting($department);
        $priority_details = UhidMaster::where('uhid', $request->uhid)->first();
        event(new \App\Events\TokenIssued());
        $staffuser = User::find(Auth::user()->id);
        $stt = Setting::first();
        $request->session()->flash('department_name', $department->name);
        $request->session()->flash('number', $newtoken);
        $request->session()->flash('total', $newWaiting);
        $request->session()->flash('uhid', $request->uhid);
        $request->session()->flash('newbarcode', $newbarcode);
        $request->session()->flash('timeslot', $ntimeslot);
        $request->session()->flash('checkingCounter', $checkCounter);
        $request->session()->flash('priority', $priority_details['priority_type']);
        $request->session()->flash('company_name', $stt->name);
        $request->session()->flash('staffname', $staffuser->name);
  
    flash()->success('Token Successfully Modify');
    return redirect()->route('new_Token');
              

  }
//-----------------------------------------------------------

    public function newCall(Request $request)
    {
        $this->validate($request, [
            'user' => 'bail|required|exists:users,id',
            'counter' => 'bail|required|exists:counters,id',
            'pid' => 'bail|required|exists:parent_departments,id',
			'department' => 'bail|required|exists:departments,id',
        ]);

        $user = User::findOrFail($request->user);
        $counter = Counter::findOrFail($request->counter);
        $pdepartment = ParentDepartment::findOrFail($request->pid);
		$department = Department::findOrFail($request->department);

        $queue = $this->calls->getNextToken($department);

        if($queue==null) {
            flash()->warning('No Token for this department');
            return redirect()->route('calls');
        }

        $call = $queue->call()->create([
            'pid' => $pdepartment->id,
			'department_id' => $department->id,
            'counter_id' => $counter->id,
            'user_id' => $user->id,
            'number' => $queue->number,
            'called_date' => Carbon::now()->format('Y-m-d'),
        ]);

        $queue->called = 1;
        $queue->save();

        $request->session()->flash('department', $department->id);
        $request->session()->flash('counter', $counter->id);

        event(new \App\Events\TokenIssued());
        event(new \App\Events\TokenCalled());

        flash()->success('Token Called');
        return redirect()->route('calls');
    }

    public function postDept(Request $request, Department $department)
    {
		$request->session()->flash('printFlag', true);
		$is_uhid_required = $this->isUhidRequired($department->id);
		$priority = 4;//by default normal
		if($is_uhid_required){
			$uhid = $request->uhid;
			$is_uhid_exist = $this->isUHIDExist($uhid);
			if(!$is_uhid_exist) {
				$request->session()->flash('printFlag', false);
				flash()->warning('Invalid UHID');
				return redirect()->route('calls');
			}
		}
		if(!empty($uhid)){
			$uhid_details = UhidMaster::where('uhid', $uhid)->first();
			if(!empty($uhid_details)){
				$priority = $uhid_details['priority_type'];
			}
			
		}
		
        $last_token = $this->calls->getLastToken($department);
        $total = $this->calls->getCustomersWaiting($department);

        if($last_token) {
			$tokenNumber = ((int)$last_token->number)+1;
			$istkenExist = $this->calls->isTokenExist($department->pid, $department->id, $tokenNumber);
			if($istkenExist > 0){
				$request->session()->flash('printFlag', false);
				flash()->warning('Token already issued');
				return redirect()->route('calls');
			}
            $queue = $department->queues()->create([
				'pid' => $department->pid,
                'number' => ((int)$last_token->number)+1,
                'called' => 0,
				'uhid' => $request->uhid,
                'priority' => $priority,
                'customer_waiting' => $total,
            ]);
        } else {
			$tokenNumber = $department->start;
			$istkenExist = $this->calls->isTokenExist($department->pid, $department->id, $tokenNumber);
			if($istkenExist > 0){
				$request->session()->flash('printFlag', false);
				flash()->warning('Token already issued');
				return redirect()->route('calls');
			}
            $queue = $department->queues()->create([
				'pid' => $department->pid,
                'number' => $department->start,
                'called' => 0,
				'uhid' => $request->uhid,
                'priority' => $priority,
                'customer_waiting' => $total,
            ]);
        }

       
        $priority_details = UhidMaster::where('uhid', $request->uhid)->first();
        event(new \App\Events\TokenIssued());
        $staffuser = User::find(Auth::user()->id);
        $stt = Setting::first();
        $request->session()->flash('department_name', $department->name);
        $request->session()->flash('number', ($department->letter!='')?$department->letter.'-'.$queue->number:$queue->number);
        $request->session()->flash('total', $total);
		$request->session()->flash('uhid', $request->uhid);
        $request->session()->flash('priority', $priority_details['priority_type']);
        $request->session()->flash('company_name', $stt->name);
        $request->session()->flash('staffname', $staffuser->name);


        flash()->success('Token Added');
        return redirect()->route('calls');
    }

	private function isUhidRequired($department_id)
	{
		$flag = false;
		$result = Department::find($department_id);
		if(!empty($result)){
			$flag = ($result->is_uhid_required == 1) ? true : false;
		}
		return $flag;
	}
	
	private function isUHIDExist($uhid)
	{
		$flag = false;
		$result = UhidMaster::where('uhid', $uhid)->count();
		$flag = ($result > 0) ? true : false;
		return $flag;
	}
	
	
    public function recall(Request $request)
    {
        $call = Call::find($request->call_id);
        $new_call = $call->replicate();
        $new_call->save();

        $call->delete();

        event(new \App\Events\TokenCalled());

        flash()->success('Token Called');
        return $new_call->toJson();
    }
	
	public function postPdept(Request $request)
    { 
		$department = Department::where('pid', $request->pid)->get();
        return $department->toJson();
    }
    
    public function getPriority(Request $request)
    { 
		$uhid = $request->uid;
		if(empty($uhid)){
			return '';
		}
		$result = UhidMaster::where('uhid', $uhid)->first();
		if(!empty($result)){
			if($result['priority_type'] == 1){
				$output = '<span class="plbox">Platinum</span>';
			}else if($result['priority_type'] == 2){
				$output = '<span class="glbox">Gold</span>';
			}else if($result['priority_type'] == 3){
                $output = '<span class="slbox">Silver</span>';
            }else if($result['priority_type'] == 4){
				$output = '<span class="nlbox">Normal</span>';    
			}else{
				$output = '<span class="erbox">Inavid UHID</span>';
			}
		}else{
			$output = '<span class="erbox">Inavid UHID</span>';
		}
        return $output;
    }
//-----------============================--------------
public function getBarcode(Request $request)
{  
    $barcode = $request->barcode;
    if(empty($barcode)){
        return '';
    }
    $result = Queue::where('called', 1)
                    ->where('queue_status', 0)
                    ->where('token', 'O')
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->where('barcode', $barcode)
                    ->first();

    if(!empty($result)){
        if($result['barcode'] == $barcode){
            $output = "<div class='col s12' style='padding-bottom:10px;'><input type='hidden' class='barcode_".$result['id']."' value='".$result['barcode']."' name='barcode' ><input type='hidden' class='id_".$result['id']."' value='".$result['id']."' name='id' ><input type='hidden' class='department_id_".$result['id']."' value='".$result['id']."' name='department_id' > <input class='uhid_".$result['id']."' name='uhid' type='hidden' value='".$result['uhid']."' ><div class='timeslotbox'><label>Select Batch</label><ul>
            <li class='tm_a'><input name='timeslot' id='p' class='timeslot_".$result['id']."' type='radio' value='10:20 AM' /> 10:20 AM
            <div class='documentcheck checking_a'><strong>Select Work</strong>
            <span><input name='checkingCounter' class='checkingCounter_".$result['id']."' type='radio' value='R' /> Court Work</span>
            <span><input name='checkingCounter' class='checkingCounter_".$result['id']."' type='radio' value='P' /> Pay Fine</span>
            </div></li> 
            <li class='tm_b'><input name='timeslot' id='q' class='timeslot_".$result['id']."' type='radio' value='11:20 AM' /> 11:20 AM
            <div class='documentcheck checking_b'><strong>Select Work</strong>
            <span><input name='checkingCounter' class='checkingCounter_".$result['id']."' type='radio' value='R' /> Court Work</span>
            <span><input name='checkingCounter' class='checkingCounter_".$result['id']."' type='radio' value='P' /> Pay Fine</span>
            </div></li>
            <li class='tm_c'><input name='timeslot' id='r' class='timeslot_".$result['id']."' type='radio' value='12:20 PM' /> 12:20 PM
            <div class='documentcheck checking_c'><strong>Select Work</strong>
            <span><input name='checkingCounter' class='checkingCounter_".$result['id']."' type='radio' value='R' /> Court Work</span>
            <span><input name='checkingCounter' class='checkingCounter_".$result['id']."' type='radio' value='P' /> Pay Fine</span>
            </div></li>
            <li class='tm_d'><input name='timeslot' id='s' class='timeslot_".$result['id']."' type='radio' value='01:20 PM' /> 01:20 PM
            <div class='documentcheck checking_d'><strong>Select Work</strong>
            <span><input name='checkingCounter' class='checkingCounter_".$result['id']."' type='radio' value='R' /> Court Work</span>
            <span><input name='checkingCounter' class='checkingCounter_".$result['id']."' type='radio' value='P' /> Pay Fine</span>
            </div></li>
            <li class='tm_e'><input name='timeslot' id='t' class='timeslot_".$result['id']."' type='radio' value='02:20 PM' /> 02:20 PM
            <div class='documentcheck checking_e'><strong>Select Work</strong>
            <span><input name='checkingCounter' class='checkingCounter_".$result['id']."' type='radio' value='R' /> Court Work</span>
            <span><input name='checkingCounter' class='checkingCounter_".$result['id']."' type='radio' value='P' /> Pay Fine</span>
            </div></li>
            <li class='tm_f'><input name='timeslot' id='u' class='timeslot_".$result['id']."' type='radio' value='03:20 PM' /> 03:20 PM
            <div class='documentcheck checking_f'><strong>Select Work</strong>
            <span><input name='checkingCounter' class='checkingCounter_".$result['id']."' type='radio' value='R' /> Court Work</span>
            <span><input name='checkingCounter' class='checkingCounter_".$result['id']."' type='radio' value='P' /> Pay Fine</span>
            </div></li>
            </ul></div><button id='autosubmitbarcode_btn' onclick='call_dept(".$result['id'].");' class='btn waves-effect waves-light csfloat' >Generate New Token </button></div>";
        }else{
            $output = '<span class="erbox">Invalid</span>';
        }
    }else{
        $output = '<span class="erbox">Invalid</span>';
    }
    return $output;
}
//-----------===========================---------------


}
