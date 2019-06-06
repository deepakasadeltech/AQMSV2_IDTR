@extends('layouts.app')

@section('title', trans('messages.mainapp.menu.call'))

@section('css')
    <link href="{{ asset('assets/js/plugins/data-tables/css/jquery.dataTables.min.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
@endsection

@section('content')
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem">{{ trans('messages.mainapp.menu.token_issue') }}</h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="{{ route('dashboard') }}">{{ trans('messages.mainapp.menu.dashboard') }}</a></li>
                        <li class="active">{{ trans('messages.mainapp.menu.token_issue') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col s12 m6">
                <div class="callingnone card">
                    <div class="card-content">
                        <span class="card-title" style="line-height:0;font-size:22px">{{ trans('messages.call.new_call') }}</span>
                        <div class="divider" style="margin:10px 0 10px 0"></div>
                        <form id="new_call" action="{{ route('post_call') }}" method="post">
                            {{ csrf_field() }}
                            @if(!$user->is_admin)
                                <div class="row">
                                    <div class="input-field col s12">
                                        <label for="user">{{ trans('messages.call.user') }}</label>
                                        <input id="user" type="hidden" name="user" value="{{ $user->id }}" data-error=".user">
                                        <input type="text" data-error=".user" value="{{ $user->name }}" readonly>
                                        <div class="user">
                                            @if($errors->has('user'))<div class="error">{{ $errors->first('user') }}</div>@endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="input-field col s12">
                                        <label for="user" class="active">{{ trans('messages.call.user') }}</label>
                                        <select id="user" class="browser-default" name="user" data-error=".user">
                                            <option value="">{{ trans('messages.select') }} {{ trans('messages.call.user') }}</option>
                                            @foreach($users as $cuser)
                             <option value="{{ $cuser->id }}"{!! $cuser->id==old('user')?' selected':'' !!}>  
                              @if(($cuser->role=='S')||($cuser->role=='A'))  {{ $cuser->name }}
                              @if($cuser->role=='S') -(User)  @endif @if($cuser->role=='A') -(Admin)  @endif
                                @endif  
                             </option>
                                            @endforeach
                                        </select>
                                        <div class="user">
                                            @if($errors->has('user'))<div class="error">{{ $errors->first('user') }}</div>@endif
                                        </div>
                                    </div>
                                </div>
                            @endif
							
							<div class="row">
                                <div class="input-field col s12">
                                    <label for="pid" class="active">{{ trans('messages.mainapp.menu.parent_department') }}</label>
                                    <select id="pid" class="browser-default" name="pid" data-error=".pid">
                                        <option value="">{{ trans('messages.select') }} {{ trans('messages.mainapp.menu.parent_department') }}</option>
                                        @foreach($pdepartments as $pdepartment)
                                            @if(session()->has('pid') && ($pdepartment->id==session()->get('pid')))
                                                <option value="{{ $pdepartment->id }}" selected>{{ $pdepartment->name }}</option>
                                            @else
                                                <option value="{{ $pdepartment->id }}">{{ $pdepartment->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="pid">
                                        @if($errors->has('pid'))<div class="error">{{ $errors->first('pid') }}</div>@endif
                                    </div>
                                </div>
                            </div>
							
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="department" class="active">{{ trans('messages.mainapp.menu.department') }}</label>
                                    <select id="department" class="browser-default" name="department" data-error=".department">
                                        <option value="">{{ trans('messages.select') }} {{ trans('messages.mainapp.menu.department') }}</option>
                                        @foreach($departments as $department)
                                            @if(session()->has('department') && ($department->id==session()->get('department')))
                                                <option value="{{ $department->id }}" selected>{{ $department->name }}</option>
                                            @else
                                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="department">
                                        @if($errors->has('department'))<div class="error">{{ $errors->first('department') }}</div>@endif
                                    </div>
                                </div>
                            </div>
							
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="counter" class="active">{{ trans('messages.mainapp.menu.counter') }}</label>
                                    <select id="counter" class="browser-default" name="counter" data-error=".counter">
                                        <option value="">{{ trans('messages.select') }} {{ trans('messages.mainapp.menu.counter') }}</option>
                                        @foreach($counters as $counter)
                                            @if(session()->has('counter') && ($counter->id==session()->get('counter')))
                                                <option value="{{ $counter->id }}" selected>{{ $counter->name }}</option>
                                            @else
                                                <option value="{{ $counter->id }}">{{ $counter->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="counter">
                                        @if($errors->has('counter'))<div class="error">{{ $errors->first('counter') }}</div>@endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <button class="btn waves-effect waves-light right" type="submit">
                                        {{ trans('messages.call.call_next') }}<i class="mdi-navigation-arrow-forward right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <span class="card-title" style="line-height:0;font-size:22px">{{ trans('messages.call.click_department') }}</span>
                        <div class="divider" style="margin:10px 0 10px 0"></div>
                        @if($user->is_admin)

                   @foreach($departments as $department)

                   @if( $department->is_uhid_required == 1)
     <a style="margin-bottom:10px;margin-right:5px;text-transform:uppercase" class="waves-effect waves-light btn modal-trigger" href="#modal1_{{ $department->id }}">{{ $department->name }} <sup style="color:#890202; font-size:15px">*</sup></a>
     @else
     <button style="margin-bottom:10px;margin-right:5px;text-transform:uppercase" class="btn waves-effect waves-light csfloat" onclick="call_dept({{ $department->id }}); this.style.visibility='hidden'; this.disable=true;" style="text-transform:none">{{ $department->name }} </button>
     @endif

                   <div id="modal1_{{ $department->id }}" class="modal">
    <div class="modal-content">
    <div class="customform">
     <h4>{{ $department->name }}</h4>
     <form id="dep_isuuetkn_{{ $department->id }}" name="getValueform_{{ $department->id }}" action="/" method="GET">
    <div class = "row">
    <div class="input-field col s12">      
      <label>Enter UHID :</label>
       <input class="uhid_{{ $department->id }}" name="uhid" type="text" placeholder="UHID" value="" autocomplete="off" onkeyup="getPrioroty(this.value, {{ $department->id }});" />          
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
<li><button class="btn waves-effect waves-light csfloat" onclick="call_dept({{ $department->id }}); this.style.visibility='hidden'; this.disable=true;" style="text-transform:none">{{ trans('messages.call.token_issue') }}<i class="mdi-navigation-arrow-forward right"></i>
</button></li>
</ul>
   </div>
                      
        </div>
       
    </div>
   
  </div> 
  @endforeach
 
  <!--------------------------->

                 @else 

                  
         @foreach($departments as $department)
    @if(($user->parent_id)==$department->parent_id)

    @if( $department->is_uhid_required == 1)
     <a style="margin-bottom:10px;margin-right:5px;text-transform:uppercase" class="reloadclick waves-effect waves-light btn modal-trigger" href="#modal1_{{ $department->id }}">{{ $department->name }} <sup style="color:#890202; font-size:15px">*</sup></a>
     @else
      <button style="margin-bottom:10px;margin-right:5px;text-transform:uppercase" class="btn waves-effect waves-light csfloat" onclick="call_dept({{ $department->id }}); this.style.visibility='hidden'; this.disable=true;" style="text-transform:none">{{ $department->name }} </button>
     @endif

     @endif
     
      

      <!------popup-start---------->     
     <div id="modal1_{{ $department->id }}" class="modal">
    <div class="modal-content">
    <div class="customform">
     <h4>{{ $department->name }}</h4>
     <form id="dep_isuuetkn_{{ $department->id }}" name="getValueform_{{ $department->id }}" action="/" method="GET">
    <div class = "row">
    <div class="input-field col s12">      
      <label>Enter UHID :</label>
       <input class="uhid_{{ $department->id }}" name="uhid" type="text" placeholder="UHID" value="" autocomplete="off" onkeyup="getPrioroty(this.value, {{ $department->id }});" />          
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
        
<li><a href="javascript:void(0)" class="modal-close waves-light btn red csfloat">Cancel</a></li>
<li class="reloadclick">  <button class="btn waves-effect waves-light csfloat" onclick="call_dept({{ $department->id }}); this.style.visibility='hidden'; this.disable=true;" style="text-transform:none">{{ trans('messages.call.token_issue') }}<i class="mdi-navigation-arrow-forward right"></i>
</button></li>
</ul>
   </div>
                      
        </div>
       
    </div>
   
  </div> 
  @endforeach
  @endif 

                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content" style="font-size:14px">
                        <span class="card-title" style="line-height:0;font-size:22px">{{ trans('messages.call.todays_queue') }}</span>
                        <div class="divider" style="margin:10px 0 10px 0"></div>
                        <table id="call-table" class="display" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('messages.mainapp.menu.department') }}</th>
                                    <th>{{ trans('messages.call.number') }}</th>
                                    <th>{{ trans('messages.call.called') }}</th>
                                    <th>{{ trans('messages.mainapp.menu.counter') }}</th>
                                    <th>{{ trans('messages.call.recall') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
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
   
   <table style="width:100%; border:none; margin:0px; padding:0px;">
   <tr><td colspan="2" style="text-align:center">
   <h1 style="display:inline-table; margin:0px;">
   <span style="display:block; text-transform:uppercase; font-size:18px;">{{str_limit( $company_name)}}</span></h1></td></tr>
   
   <tr><td colspan="2" style="text-align:center; padding:5px 0;"><span style="display:inline-table; font-weight:800; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:25px;">टोकन संख्या : {{ session()->get('number') }}</span></td></tr>
   
   <tr><td colspan="2" style="padding:0px 3px; font-size:12px;" >
   <table style="width:100%; border:none; margin:0px; padding:0px; text-transform:uppercase; border-collapse:collapse;">
   <tr> <td style="width:70%; padding:4px; border:1px solid #ccc;">Department Name (विभाग<br> का नाम) <span style="float:right;">:</span></td> <td style="width:30%; padding:4px; border:1px solid #ccc;">{{ session()->get('department_name') }}</td> </tr>
    @if(session()->get('uhid') != '')
   <tr> <td style="padding:4px; border:1px solid #ccc;">UHID No. (यूएचआईडी संख्या) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;">{{ session()->get('uhid') }}</td> </tr>
   @else  @endif

   <tr> <td style="padding:4px; border:1px solid #ccc;">Patients in queue (कुल व्यक्ति प्रतीक्षा कर रहे हैं) <span style="float:right;">:</span></td>  <td style="padding:8px; border:1px solid #ccc;">{{ session()->get('total')-1 }}</td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Date (दिनांक) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"> {{ \Carbon\Carbon::now()->format('d-m-Y') }}</td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Time (समय) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;">{{ \Carbon\Carbon::now()->format('h:i:s A') }}</td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Token slip created by (टोकन पर्ची किसके द्वारा बनाई गई है) <span style="float:right;">:</span></td> <td style="padding:4px; border:1px solid #ccc;"> <strong>{{ session()->get('staffname') }}<strong> </td> </tr>
   </table>
   
   </td></tr>
   
   <tr><td colspan="2" style="padding:10px 10px; font-size:10px; text-align:left;">
   <h5 style="text-transform:uppercase; margin:0 0 0px 0px;">Please wait for your token No. on TV Display <br>(कृपया प्रदर्शन पर अपना टोकन नंबर जांचें)</h5>
   </td></tr>
   <tr><td colspan="2" style="text-align:center; font-size:8px; padding:0 0 10px 0"><p style="margin:0px; padding:0px">Powered by <strong>ASADELTECH<sup>&reg;</sup><strong></p></td></tr>
   
   </table>

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

    <script type="text/javascript" src="{{ asset('assets/js/plugins/data-tables/js/jquery.dataTables.min.js') }}"></script>
    
    <script>
    //-------------------------------
        $("#new_call").validate({
            rules: {
                user: {
                    required: true,
                    digits: true
                },
                pid: {
                    required: true,
                    digits: true
                },
				department: {
                    required: true,
                    digits: true
                },
                counter: {
                    required: true,
                    digits: true
                },
            },
            errorElement : 'div',
            errorPlacement: function(error, element) {
                var placement = $(element).data('error');
                if (placement) {
                    $(placement).append(error)
                } else {
                    error.insertAfter(element);
                }
            }
        });

 //--------------------------
    

    //---------------------------

    function call_dept(value) {
            //$('body').removeClass('loaded');
			var uhid = $('.uhid_'+value).val();
			var priority = $('.priority_'+value+':checked').val();
			//alert(uhid + '---' + priority); return false;
			var myForm1 = '<form id="hidfrm1" action="{{ url('calls/dept') }}/'+value+'" method="post">{{ csrf_field() }}'+
  '<input type="text" name="uhid" value="'+ uhid +'">'+
  '<input type="text" name="priority" value="'+ priority +'">'+'</form>';
            $('body').append(myForm1);
			
            myForm1 = $('#hidfrm1');
            myForm1.submit();
            //-------------------
          // if(myForm1.submit()){
           // window.onload = function() {startTime() }
           // setTimeout(location.reload(), 1000);
            // }; 
            
            //----------------
        }
        

        function recall(call_id) {
            $('body').removeClass('loaded');
            var data = 'call_id='+call_id+'&_token={{ csrf_token() }}';
            $.ajax({
                type:"POST",
                url:"{{ route('post_recall') }}",
                data:data,
                cache:false,
                success: function(response) {
                    location.reload();
                }
            });
        }
		$('body').on('change', '#pid', function(){
			var options = "<option value=''>Select Parent Department</option>";
			if($(this).val() == ''){
				$('#department').html(options);
			}
			var data = 'pid='+$(this).val()+'&_token={{ csrf_token() }}';
            $.ajax({
                type:"POST",
                url:"{{ route('post_pdept') }}",
                data:data,
                cache:false,
				dataType:'json',
                success: function(resultJSON) {
					
					$.each(resultJSON, function(i, obj) {
					  //use obj.id and obj.name here, for example:
					  options += '<option value="'+obj.id+'">'+obj.name+'</option>';
					});
					$('#department').html(options);
										
                }
            });
		});

		
        $(function() {
            var calltable = $('#call-table').dataTable({
                "oLanguage": {
                    "sLengthMenu": "Show _MENU_",
                    "sSearch": "Search"
                },
                "columnDefs": [{
                    "targets": [ -1 ],
                    "searchable": false,
                    "orderable": false
                }],
                "ajax": "{{ url('assets/files/call') }}",
                "columns": [
                    { "data": "id" },
                    { "data": "department" },
                    { "data": "number" },
                    { "data": "called" },
                    { "data": "counter" },
                    { "data": "recall" }
                ]
            });

            setInterval(function(){
                calltable.api().ajax.reload(null,false);
            }, 3000);
        });

        //--------------------------------------
var timer = '';
		function getPrioroty(val, id)
		{  
			clearTimeout(timer);
			timer = setTimeout(function() {
					var data = 'uid='+val+'&_token={{ csrf_token() }}';
					$.ajax({
						type:"POST",
						url:"{{ route('post_uhid') }}",
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
