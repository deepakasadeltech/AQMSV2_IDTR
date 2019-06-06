<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\DisplayRepository;
use App\Models\User;
use App\Models\Call;
use App\Models\ParentDepartment;
use Carbon\Carbon;

class DisplayController extends Controller
{
    protected $displays;

    public function __construct(DisplayRepository $displays)
    {
        $this->displays = $displays;
    }

    public function index()
    {
        $settings = $this->displays->getSettings();

        \App::setLocale($settings->language->code);

        event(new \App\Events\TokenCalled());

        return view('display.index', [
            'data' => $this->displays->getDisplayData(),
            'audio_call_id' => $this->displays->getAudioCallId(),
            'last_id' => $this->displays->getLastCallId(),
            'settings' => $settings,
            'patstatus' => $this->displays->getfirstToken(),
            'departmentname' => $this->displays->getDepartmentName(),
        ]);
    }

    //----------------------------

//-------------------------

    public function testlift()
	{
      $fisrttoken = $this->displays->getfirstToken();
      
     if(count($fisrttoken) > 0)
      foreach($fisrttoken as $lifttoken){
          
        echo '<span id="">'.$lifttoken->view_status.'</span>';
              
       }      
    
     
   
    }
	
	public function test()
	{
		$data = $this->displays->getAudioCallId();
		echo "<pre>";
		print_r($data);die;
    }
    
    public function autoCall(Request $request)
    {
        $call_id = $request->audio_id;
        $last_id = $request->audio_last_id;
        $currentlastId = $this->displays->getLastCallId();
        $cls = $this->displays->getCurrentCallDetails($call_id);
        if(!empty($cls))
        {
            $nextid = $this->displays->getNextCallId($call_id);
            $play = "PLAY";
            if($currentlastId != $last_id){
                $play = "NOTPLAY";
                $id1 = $call_id;
                $id2 = $currentlastId;
            }else{
                $play = "PLAY";
                if($nextid == 'NOID'){
                    $id1 = $this->displays->getAudioCallId();     
                    $id2 = $this->displays->getLastCallId();
                }else{
                    $id1 =$nextid; 
                    $id2 = $last_id;  
                }
                
            }
            $call_number = $cls->department->letter.' '.$cls->number;
            $counter = $cls->counter->name;
            $str = $play.'@'.$call_number.'@'.$counter.'@'.$id1.'@'.$id2;
        }else{
            $str = 'NOTPLAY@NA@NA@'.$call_id.'@'.$last_id;
        }
        
        return $str;
    }

}
