@extends('layouts.mainappqueue')

@section('title', trans('messages.issue').' '.trans('messages.display.token'))

@section('css')
<link href="{{ url('assets/keyboard/css/keyboard.css') }}" type="text/css" rel="stylesheet" >
<link href="{{ url('assets/keyboard/css/jquery-ui.css') }}" type="text/css" rel="stylesheet" >
    <style>
        .btn-queue{padding:25px;font-size:47px;line-height:36px;height:auto;margin:10px;letter-spacing:0;text-transform:none}
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col s12">
            <div class="card" style="background:#f9f9f9;box-shadow:none">
                <span class="card-title" style="line-height:0;font-size:22px">{{ trans('messages.call.click_department') }}</span>
                <div class="divider" style="margin:10px 0 10px 0"></div>
<!----------------------------------------------------->
                 <div class="addtoqueuesection">
                <div class="queuetokenbox">
                <div class="queue_time">  <span></span> <span><?php date_default_timezone_set('Asia/Kolkata'); echo date("l"); ?></span><span><?php date_default_timezone_set('Asia/Kolkata'); echo date("d.m.Y"); ?></span>
                <span id="gtime"> <?php date_default_timezone_set('Asia/Calcutta');$h = date('H'); $a = $h >= 12 ? 'PM' : 'AM';
             echo $timestamp = date('h:i:s ').$a; ?> </span> </div>
                <div class="queue_time"><span>Click on Department to get token Number <br> टोकन नंबर पाने के लिए विभाग पर क्लिक करें</span> <span style=display:none;></span><span style=display:none;></span></div>
               <!-- @foreach($getdepartmentbydoctors as $getdepartmentbydoctor)  @endforeach-->
                <div class="boxdept" id="token_section">
                @foreach($departments as $department)
              @if( $department->is_uhid_required == 1)
     <a style="margin-bottom:10px;margin-right:5px;text-transform:uppercase" class="waves-effect waves-light btn modal-trigger" href="#modal2_{{ $department->id }}">{{ $department->name }} <sup style="color:#890202; font-size:15px">*</sup></a>
     @else
     <button style="margin-bottom:10px;margin-right:5px;text-transform:uppercase" class="btn waves-effect waves-light csfloat" onclick="queue_dept({{ $department->id }}); this.style.visibility='hidden'; this.disable=true;" style="text-transform:none">{{ $department->name }} </button>
     @endif

             
                 @endforeach
                 </div>
                </div>
                </div>
<!------------------------------------------>
                @foreach($departments as $department)
<div id="modal2_{{ $department->id }}" class="modal">
<div class="modal-content">
<div class="customform">
<h4>{{ $department->name }} </h4>
      <form id="dep_isuuetkn_{{ $department->id }}" name="getValueform_{{ $department->id }}" action="{{url('queue')}}" method="GET">
    <div class = "row">
    <div class="input-field col s12">      
      <label>Enter UID :</label>
       <input class="uhid_{{ $department->id }}" name="uhid" type="text" placeholder="UID" value="" autofocus="autofocus" autocomplete="off" onkeyup="getPrioroty(this.value, {{ $department->id }});" />          
    </div>
               
         <div class="col s12">
         <ul>
         <li style="font-size:0.8rem">Priority : <span id="uhidlbl_{{ $department->id }}"></span></li>
         </ul>
          </div>      
       
       </div>
       </form>
<div class="modal-footer">
<ul>

<li><a href="javascript:void(0)" class="modal-close waves-light btn red csfloat">{{ trans('messages.call.cancel') }}</a></li>
<li>  <button class="btn waves-effect waves-light csfloat" onclick="queue_dept({{ $department->id }}); this.style.visibility='hidden'; this.disable=true;" style="text-transform:none">{{ trans('messages.call.token_issue') }}<i class="mdi-navigation-arrow-forward right"></i>
</button></li>
</ul>
</div>
   
</div>

</div>

</div> 

  @endforeach
            </div>
        </div>
    </div>
@endsection



@section('print')
    @if(session()->has('department_name'))
    <style>#printarea{display:none;text-align:left}@media print{#loader-wrapper,header,#main,footer,#toast-container{display:none}#printarea{display:block;}}@page{margin:0}</style>
<div id="printarea" style="background:#f2f2f2; -webkit-print-color-adjust:exact; font-family: 'Open Sans', sans-serif; line-height:1.2;  position:relative;">
          <!------------------>     
          @if(session()->get('uhid') != '')
			<span style="position:absolute; top:0px; right:0px; font-size:10px; color:black;">
               @if(session()->get('priority') == '1') P 
               @elseif(session()->get('priority') == '2') G
               @elseif(session()->get('priority') == '3') S 
               @elseif(session()->get('priority') == '4') N 
               @else N  @endif
             </span>@else  @endif
 <!----------------------------->
 <table style="width:100%; border:none; margin:0px; padding:0px; font-size:12px;">

   <tr><td colspan="2" style="text-align:center">
   <h1 style="display:inline-table; margin:0px;">
   <span style="display:block; text-transform:uppercase; font-size:18px;">{{str_limit( $settings->name)}}</span></h1></td></tr>

   <tr><td width="100%" colspan="2" style="text-align:center; padding:5px 0;"><span style="display:block; font-weight:800; border:2px dotted #000; color:#000; padding:5px 2px; font-size:25px;"><strong style="font-size:25px; display:block;">टोकन संख्या</strong>
   {{ session()->get('number') }}</span>
</td></tr>

@if(session()->get('uhid') != '')
   <tr> <td style="padding:4px; border:1px solid #555;">UID No. (यूआईडी संख्या) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #555;">{{ session()->get('uhid') }}</td> </tr>
   @else  @endif

<tr> <td style="padding:4px; border:1px solid #555;">VISITORS IN QUEUE <br>(कुल व्यक्ति प्रतीक्षा कर रहे हैं)  <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #555;">{{ session()->get('total') }}</td> </tr>

<tr> <td style="padding:4px; border:1px solid #555;">DATE (दिनांक) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #555;">{{ \Carbon\Carbon::now()->format('d-m-Y') }}</td> </tr>

<tr> <td style="padding:4px; border:1px solid #555;">TIME (समय) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #555;">{{ \Carbon\Carbon::now()->format('h:i:s A') }}</td> </tr>

<tr> <td style="padding:4px; border:1px solid #555;">Token slip created by <br>(टोकन पर्ची किसके द्वारा बनाई गई है) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #555;">Self (KIOSK)</td> </tr>

<tr> <td colspan="2" style="padding:4px; border:1px solid #555;">Please wait for your Lift Token on TV Display (कृपया प्रदर्शन पर अपना लिफ्ट टोकन जांचें)</td> </tr>

<tr><td colspan="2" style="text-align:center; font-size:8px; padding:0 0 10px 0"><p style="margin:0px; padding:0px">Powered by <strong>ASADELTECH<sup>&reg;</sup><strong></p></td></tr>

 </table>
 
<div style="transform:rotate(90deg); padding:60px 0;">
<svg id="ean-5"></svg>
</div>



        <!--------------------->
        </div>
        @if(session()->get('printFlag'))
			<script>
				window.onload = function(){window.print();}
			</script>
		@endif	
    @endif
@endsection

@section('script')
<script src="{{asset('assets/js/JsBarcode.all.min.js')}}"></script>
<!---<script src="{{ url('assets/js/click_security.js') }}" type="text/javascript" ></script>---->

<script type="text/javascript">
//---------------------------------
var barcodedata = "{{ session()->get('number') }}_{{ \Carbon\Carbon::now()->format('m-Y') }}";
//JsBarcode("#ean-5", barcodedata);
$("#ean-5").JsBarcode(barcodedata);
//-----------------------------------   
</script>

    <script type="text/javascript">
        $(function() {
            $('#main').css({'min-height': $(window).height()-134+'px'});
        });
        $(window).resize(function() {
            $('#main').css({'min-height': $(window).height()-134+'px'});
        });
        function queue_dept(value) {
           // $('body').removeClass('loaded');
		   var uhid = $('.uhid_'+value).val();
			var priority = $('.priority_'+value+':checked').val();
			//alert(uhid + '---' + priority); return false;
            var myForm2 = '<form id="hidfrm2" action="{{ route('post_add_to_queue') }}" method="post">{{ csrf_field() }}<input type="hidden" name="department" value="'+value+'">'+
  '<input type="text" name="uhid" value="'+ uhid +'">'+
  '<input type="text" name="priority" value="'+ priority +'">'+'</form>';
            $('body').append(myForm2);
            myForm2 = $('#hidfrm2');
            myForm2.submit();
        }

        function refreshtoken()
        {
            var data = 'type=refresh&_token={{ csrf_token() }}';
            $.ajax({
                type:"POST",
                data:data,
                url:"{{ route('refresh_token') }}",
                success: function(result) {
					$('#token_section').html(result);
				}
            });
        }

       /* window.setInterval(function() {			
           // refreshtoken();
           window.location.reload();
        }, 300000); */

//--------------------------------------
var timer = '';
		function getPrioroty(val, id)
		{  
			clearTimeout(timer);
			timer = setTimeout(function() {
					var data = 'uid='+val+'&_token={{ csrf_token() }}';
					$.ajax({
						type:"POST",
						url:"{{ route('post_cuhid') }}",
						data:data,
						cache:false,
						beforeSend: function(){
							$('#uhidlbl_'+id).html('Validating...');	
						},
						success: function(result) {							
							$('#uhidlbl_'+id).html(result);												
						}
					});
			}, 1000);
		}        
     
    </script>
@endsection
