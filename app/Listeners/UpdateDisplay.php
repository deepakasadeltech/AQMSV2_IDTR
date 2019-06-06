<?php

namespace App\Listeners;

use App\Events\TokenCalled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Call;
use App\Models\Setting;
use App\Models\ParentDepartment;
use Carbon\Carbon;

class UpdateDisplay
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
	}

    public function handle(TokenCalled $event)
    {    
		  $welcome = Setting::first();
		
        $calls = Call::with('department', 'counter')
					->where('called_date', Carbon::now()->format('Y-m-d'))
					->where('doctor_work_end', 0)
					->where('token', 'O')
                    ->orderBy('calls.id', 'desc')
                    //->take(4)
					->get();

		$day = date("l"); 
		$time = \Carbon\Carbon::now()->format('h:i A');	
		$date = date("d.m.Y");
	    date_default_timezone_set('Asia/Calcutta');$h = date('H'); $a = $h >= 12 ? 'PM' : 'AM'; 
		$timestamp = date('h:i:s ').$a;
		
        $data = [];
        for ($i=0;$i<1;$i++) {
            $data[$i]['call_id'] = (isset($calls[$i]))?$calls[$i]->id:'NIL';
            $data[$i]['number'] = (isset($calls[$i]))?(($calls[$i]->department->letter!='')?$calls[$i]->department->letter.''.$calls[$i]->number:$calls[$i]->number):'NIL';
            $data[$i]['call_number'] = (isset($calls[$i]))?(($calls[$i]->department->letter!='')?$calls[$i]->department->letter.' '.$calls[$i]->number:$calls[$i]->number):'NIL';
            $data[$i]['counter'] = (isset($calls[$i]))?$calls[$i]->counter->name:'NIL';
			$data[$i]['pid'] = (isset($calls[$i]))?$calls[$i]->pid:'NIL';
			$data[$i]['department_id'] = (isset($calls[$i]))?$calls[$i]->department_id:'NIL';
			$data[$i]['view_status'] = (isset($calls[$i]))?$calls[$i]->view_status:'NIL';
        }
		$data2 = [];
		foreach($calls as $cls)
		{
			$call_id = $cls->id;
			$call_number = $cls->department->letter.''.$cls->number;
			$counter = $cls->counter->name;
			$dep_id = $cls->pid;
			$dep_details = ParentDepartment::find($cls->pid);
			$dep = $dep_details->name;
			$sub_dep_id = $cls->department_id;
			$sub_dep = $cls->department->name;
			$view_status = $cls->view_status;
			$data2[$cls->pid][] = [
											'call_id'=>$call_id,
											'call_number'=>$call_number,
											'counter'=>$counter,
											'dep_id'=>$dep_id,
											'dep'=>$dep,
											'sub_dep_id'=>$sub_dep_id,
											'sub_dep'=>$sub_dep,
											'view_status'=>$view_status
			];
			
		}
		$filter_arr = [];
		if(!empty($data2)){
			foreach($data2 as $dt){
				$filter_arr = array_merge($filter_arr, array_chunk($dt, 9));
			}
		}
		$final_arr = [];
		if(!empty($filter_arr))
		{
			$final_arr = array_chunk($filter_arr, 1);
		}
		
		if(!empty($final_arr))
		{
			//print_r($final_arr); die;
			$html ='<div class="slider"><ul class="slides">';
			foreach($final_arr as $d1)
			{
				$html .='<li>';
				foreach($d1 as $d2)
				{
					$html .='<div class="boxrow" class="caption right-align">';
					$html .='<table>';
					$html .='<caption><h1>'.$d2[0]['sub_dep']. '<span class="displaytime"> <span style="margin-right:15px !important">' .$day. '</span><span>' 
					 .$date.'</span> <span class="timestamp">' .$timestamp. '</span> </span></h1></caption>';
					$html .='<thead><tr><th>टोकन संख्या</th><th>काउंटर</th><th>कार्य</th></tr></thead>';
					$html .='<tbody>';
					foreach($d2 as $d3) {
						if($d3['view_status'] == 1) { 
						$html .='<tr>';
						$html .='<td id="">'.'<span class="patcurrentstatus"></span>'.$d3['call_number'].'</td>';
						$html .='<td id="">'.$d3['counter'].'</td>';
						$html .='<td id="">काउंटर पर आगे बढ़ें</td>';
						$html .='</tr>';
						 } else { 
							$html .='<tr>';
							$html .='<td id="">'.'<span class="patcurrentstatusb"></span>'.$d3['call_number'].'</td>';
							$html .='<td id="">'.$d3['counter'].'</td>';
							$html .='<td id="">काउंटर पर आगे बढ़ें</td>';
							$html .='</tr>';

						 }


					}
					$html .='</tbody>';
					$html .='</table>';
					$html .="</div>";
				}
				$html .= '</li>';
			}
			$html .= '</ul></div>';

			$html .= '<div id="notitext" class="row"></div>';
		 $html .= "<div class='infobox'><span class='esiclogo'><img src='assets/images/esiclogo.png' ></span><div id='notitext' class='notitext'> <marquee>".$welcome->notification."</marquee> </div><span class='mylogo'>Powered By :<strong> ASADEL TECHNOLOGIES (P) LTD</strong></span></div>";
			$data[1]['html'] = $html;
		}else{
			date_default_timezone_set('Asia/Kolkata'); 
			$dt = date("d.m.Y");
			$html ='<div class="slider"><ul class="slides">';
			$html .='<li> <div class="datetimeglobal_time"><span>Plaese Wait...</span><span>No Token Called</span><span>'.$dt.'</span><span>' .$dt . '</span>
			<span class="gtime">' .$timestamp. '</span></div></li>';
			$html .="<li><div class='datetimeglobal_time'><video autoplay loop muted=''>
              <source src='assets/videos/1.webm' type='video/webm'>
              <source src='assets/videos/1.mp4' type='video/mp4'>
            </video> </div></li>";
			$html .='</ul></div>';
			$html .= '<div id="notitext" class="row"></div>';
		 $html .= "<div class='infobox'><span class='esiclogo'><img src='assets/images/esiclogo.png' ></span><div id='notitext' class='notitext'> <marquee>".$welcome->notification."</marquee> </div><span class='mylogo'>Powered By :<strong> ASADEL TECHNOLOGIES (P) LTD</strong></span></div>";
			$data[1]['html'] = $html;
		}
		

        file_put_contents(base_path('assets/files/display'), json_encode($data));
    }
}
