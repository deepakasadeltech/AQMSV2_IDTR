
@extends('layouts.mainappqueue')

@section('title', trans('messages.display.display'))

@section('content')
<input type="text" name="audio_id" id="audio_id" value="<?php echo $audio_call_id; ?>" />
<input type="text" name="audio_last_id" id="audio_last_id" value="<?php echo $last_id; ?>" />
	<!-- display start -->
	<div id="callarea1">
 <!------------------------------>
 
 <!------------------------------->   

	<div class="dipbox" id="add_dynamic_slider" >
	<div class="slider" id="display22">
    <ul class="slides">
    
     <?php if($data) {?>   
     
      
	<?php
	foreach($data as $d1)
	{
    ?>
   
	<li>
<?php	
		foreach($d1 as $d2){
	?>
      
	  <div class="boxrow" class="caption right-align">
		<table>
		<caption><h1><?php if($d2[0]['checkingCounter']=='R'){echo 'Court Work';}elseif($d2[0]['checkingCounter']=='P'){echo 'Pay Fine';}  ?> <span class="displaytime"> <span style="margin-right:15px !important"><?php date_default_timezone_set('Asia/Kolkata'); echo date("l"); ?></span><span><?php date_default_timezone_set('Asia/Kolkata'); echo date("d.m.Y"); ?></span> <span class="timestamp"> <?php date_default_timezone_set('Asia/Calcutta');$h = date('H'); $a = $h >= 12 ? 'PM' : 'AM'; echo $timestamp = date('h:i:s ').$a; ?> </span> </span> </h1> </caption>
		<thead>
		<tr>
		<th>टोकन संख्या</th>
        <th>प्रशिक्षण समय</th>
		<th>जाँच काउंटर</th>
		<th>कार्य</th>
		</tr>
		</thead>
		<tbody>

		<?php
		foreach($d2 as $d3) { 
		?>
      <?php if($d3['view_status'] == 1) { ?>
		<tr>
		<td id=""><span class="patcurrentstatus"></span><?php echo $d3['call_number']; ?></td>
        <td id=""><?php echo $d3['timeslot']; ?></td>
		<td id=""><?php if($d3['checkingCounter']=='R'){echo 'Court Work' ;} if($d3['checkingCounter']=='P'){ echo 'Pay Fine';} ?></td>
		<td>काउंटर पर आगे बढ़ें</td>
		</tr>
      <?php } else {?>

        <tr>
		<td id=""><span class="patcurrentstatusb"></span><?php echo $d3['call_number']; ?></td>
        <td id=""><?php echo $d3['timeslot']; ?></td>
		<td id=""><?php if($d3['checkingCounter']=='R'){echo 'Court Work' ;} if($d3['checkingCounter']=='P'){ echo 'Pay Fine';} ?></td>
		<td>काउंटर पर आगे बढ़ें</td>
		</tr>

      <?php } ?>

		<?php }  ?>
		</tbody>
		</table>
		</div>
	<?php
	} 
	?>
    </li>

	<?php
	}
?> 

<?php }
else{?>
     <li> <div class="datetimeglobal_time"><span>Plaese Wait...</span><span>For Second Token</span><span><?php date_default_timezone_set('Asia/Kolkata'); echo date("l"); ?></span><span><?php date_default_timezone_set('Asia/Kolkata'); echo date("d.m.Y"); ?></span> <span class="gtime"> <?php date_default_timezone_set('Asia/Calcutta');$h = date('h'); $a = $h >= 12 ? 'PM' : 'AM';
             echo $timestamp = date('h:i:s ').$a; ?> </span></div></li>

     <li><div class="datetimeglobal_time">
     <video autoplay loop muted="">
              <source src="{{ asset('assets/videos/1.webm') }}" type="video/webm">
              <source src="{{ asset('assets/videos/1.mp4') }}" type="video/mp4">
            </video>
     </div></li>
                          
<?php } ?>
      </ul>
      
      <div>

<!------------------------------------------->
    
    <div class="infobox"><span class="esiclogo"><img src="{{ asset('assets/images/esiclogo.png') }}" ></span>
    <div id="notitext" class="notitext"> <marquee> {{ $settings->notification }} </marquee> </div> <span class="mylogo">Powered By :<strong> ASADEL TECHNOLOGIES (P) LTD</strong></span></div>
    
<!----------------------------------------------->
	
	</div>
	</div>
    <!--display end --->

    


    <!-------------Notification----------------->
    <div style="display:none;" class="option">
		<label for="voice">Voice</label>
		<select name="voice" id="voice">
        <option selected value="{{ $settings->language->display }}">{{ $settings->language->display }}</option>
        </select>
	</div>


@endsection

@section('script')

<!----<script type="text/javascript" src="{{ asset('assets/js/voice.min.js') }}"></script>--->
    <script>


    /* function requestFullScreen(element) {
    var requestMethod = element.requestFullScreen || element.webkitRequestFullScreen || element.mozRequestFullScreen || element.msRequestFullScreen;

    if (requestMethod) { 
        requestMethod.call(element);
    } else if (typeof window.ActiveXObject !== "undefined") {
        var wscript = new ActiveXObject("WScript.Shell");
        if (wscript !== null) {
            wscript.SendKeys("{F11}");
        }
        
    }
}

var elem = document.body; // Make the body go full screen.
requestFullScreen(elem); */

    //--------------------------------------------------
        $(function() {
            $('#main').css({'min-height': $(window).height()-114+'px'});
        });
        $(window).resize(function() {
            $('#main').css({'min-height': $(window).height()-114+'px'});
        });

 //-------------start-google-voice----------------
 var voiceSelect = document.getElementById('voice');
function loadVoices() {
var voices = speechSynthesis.getVoices();
voices.forEach(function(voice, i) {
var option = document.createElement('option');
 
		option.value = voice.name;
		option.innerHTML = voice.name;
		voiceSelect.appendChild(option);
	});
}
loadVoices();

// Chrome loads voices asynchronously.
window.speechSynthesis.onvoiceschanged = function(e) {
  loadVoices();
};

function speak(text) {
	var msg = new SpeechSynthesisUtterance();
	msg.text = text;
	msg.volume = 8;
	msg.rate = 0.9;
	msg.pitch = 1;
   if (voiceSelect.value) {
		msg.voice = speechSynthesis.getVoices().filter(function(voice) { return voice.name == voiceSelect.value; })[0];
	}
	window.speechSynthesis.speak(msg);
}
 //--------------end-google-voice-------------------       

        function checkcall() {
            $.ajax({
                type: "GET",
                url: "{{ url('assets/files/displaysecond') }}",
                cache: false,
                success: function(response) {
                    s = JSON.parse(response);
                    if (curr!=s[0].call_id) {
						
                        /*$("#callarea").fadeOut(function(){
                            $('#num0').html(s[0].number);
                            $("#cou0").html(s[0].counter);
                            $('#num1').html(s[1].number);
                            $("#cou1").html(s[1].counter);
                            $('#num2').html(s[2].number);
                            $("#cou2").html(s[2].counter);
                            $('#num3').html(s[3].number);
                            $("#cou3").html(s[3].counter);
                        });
                        $("#callarea").fadeIn();
						*/
						$('#add_dynamic_slider').html(s[1].html);
						$('.slider').slider({ 
							indicators: false,
							height : 800, // default - height : 400
							interval: 8000 // default - interval: 6000
						});
						if (curr!=0) {							
                            var bleep = new Audio();
                            bleep.src = '{{ url('assets/sound/sound1.mp3') }}';
                            bleep.play();

                            window.setTimeout(function() {
                                msg1 = '{!! trans('messages.display.token') !!} '+s[0].call_number+' {!! trans('messages.display.please') !!} {!! trans('messages.display.proceed_to') !!} '+s[0].counter+'{!! trans('messages.display.room') !!}';
                               // responsiveVoice.speak(msg1, "{{ $settings->language->display }}", {rate: 0.85});
                                speak(msg1);
                            }, 800);
                        }
                        curr = s[0].call_id;
						
                    }/*else{
                      //autocall();
                      $('#add_dynamic_slider').html(s[1].html);
						$('.slider').slider({ 
							indicators: false,
							height : 800, // default - height : 400
							interval: 8000 // default - interval: 6000
						});
                    }*/
                }
            });
        }

        window.setInterval(function() {			
            checkcall();
            $("body").addClass('loaded');
			
        }, 4000);

        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "{{ url('assets/files/displaysecond') }}",
                cache: false,
                success: function(response) {
                    s = JSON.parse(response);
                    curr = s[0].call_id;
                }
            });
            checkcall();

       
        });

        window.setInterval(function() {			
          autocall();
			
        }, 8000);

        function autocall()
        {
          var data = 'audio_id='+$('#audio_id').val()+'&audio_last_id='+$('#audio_last_id').val()+'&_token={{ csrf_token() }}';
            $.ajax({
                type:"POST",
                url:"{{ route('auto_call') }}",
                data:data,
                cache:false,
               // dataType:'json',
				        success: function(resultData) {
                  rs = resultData.split("@");
                  if(rs[0] == 'PLAY')
                  {
                    $('#audio_id').val(rs[3]);
                    $('#audio_last_id').val(rs[4]);
                    var bleep = new Audio();
                    bleep.src = '{{ url('assets/sound/sound1.mp3') }}';
                    bleep.play();
                    //rs[1] = "P 100"; //call_number
                    //rs[2] = "Room No 344"; //counter
                    //console.log();
                    window.setTimeout(function() {
                    msg1 = '{!! trans('messages.display.token') !!} '+rs[1]+' {!! trans('messages.display.please') !!} {!! trans('messages.display.proceed_to') !!} '+rs[2]+'{!! trans('messages.display.room') !!}';
                    //responsiveVoice.speak(msg1, "{{ $settings->language->display }}", {rate: 0.85});
                    speak(msg1);
                    }, 800);
                  }else{
                    $('#audio_id').val(rs[3]);
                    $('#audio_last_id').val(rs[4]);
                  }
                  
               
										
                }
            });
        }
		
//---------------------------------------------------
//----------single-liftloby-----------------------
$(document).ready(function() {
    setInterval(liftTable, 1000);
});

function liftTable() {
    var data;
    $.ajax({
        type: 'GET',
        url: "{{ route('test_lift') }}",
        data: data,
        success: function(data) {
            $('#display2').html(data);
        },
    });
}


 //----------------------------------------------------



		
    </script>
@endsection
