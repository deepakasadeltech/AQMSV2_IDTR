<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\DisplaySecondRepository;
use App\Models\User;
use App\Models\Call;
use App\Models\ParentDepartment;
use Carbon\Carbon;

class DisplaySecondController extends Controller
{
    protected $displays;

    public function __construct(DisplaySecondRepository $displays)
    {
        $this->displays = $displays;
    }

    public function index()
    {
        $settings = $this->displays->getSettings();

        \App::setLocale($settings->language->code);

        event(new \App\Events\TokenCalledSecond());

        return view('displaysecond.index', [
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
        $data = $this->displays->getDisplayData();
    
      //echo '<ul class="slides">';
             if($data) {  
          foreach($data as $d1) {
        echo '<li>';
          foreach($d1 as $d2){
       echo '<div class="boxrow" class="caption right-align">';
       echo '<table>';  
       echo '<caption><h1>'.$d2[0]['checkingCounter'].'</h1> </caption>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>टोकन संख्या</th>';
        echo '<th>प्रशिक्षण समय</th>';
        echo '<th>जाँच काउंटर</th>';
        echo '<th>कार्य</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
         foreach($d2 as $d3) { 
        if($d3['view_status'] == 1) { 
         echo '<tr>';
         echo '<td>'.'<span class="patcurrentstatus"></span>'. $d3['call_number'].'</td>';
         echo '<td id="">'. $d3['timeslot'].'</td>';
         echo '<td id="">'.$d3['checkingCounter'].'</td>';
         echo '<td>काउंटर पर आगे बढ़ें</td>';
         echo '</tr>';
       } else {
        echo '<tr>';
         echo '<td>'.'<span class="patcurrentstatus"></span>'. $d3['call_number'].'</td>';
         echo '<td id="">'. $d3['timeslot'].'</td>';
         echo '<td id="">'.$d3['checkingCounter'].'</td>';
         echo '<td>काउंटर पर आगे बढ़ें</td>';
         echo '</tr>';
 
        } 
 
         }  
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    
        } 
   
        echo '</li>';
         }
         }
 else{
     echo '<li>'; 
     echo '<div class="datetimeglobal_time"><span>Plaese Wait...</span><span>For Second Token</span>';
     echo '<span>'.date_default_timezone_set('Asia/Kolkata').date("l").'</span>';
     echo '<span>'.date_default_timezone_set('Asia/Kolkata').date("d.m.Y").'</span>'; 
     echo '<span class="gtime">'.date_default_timezone_set('Asia/Calcutta').$h = date('h'); $a = $h >= 12 ? 'PM' : 'AM';
               $timestamp = date('h:i:s ').$a.'</span></div></li>';
 
     echo '<li><div class="datetimeglobal_time">';
     echo '<video autoplay loop muted="">';
     echo '<source src="assets/videos/1.webm" type="video/webm">';
     echo '<source src="assets/videos/1.mp4" type="video/mp4">';
    echo '</video>';
    echo '</div></li>';
       } 
      // echo '</ul>';    
    
     
   
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
            $call_number = $cls->department->letter.' '.$cls->nt_number;
            $counter = $cls->counter->name;
            $str = $play.'@'.$call_number.'@'.$counter.'@'.$id1.'@'.$id2;
        }else{
            $str = 'NOTPLAY@NA@NA@'.$call_id.'@'.$last_id;
        }
        
        return $str;
    }

}
