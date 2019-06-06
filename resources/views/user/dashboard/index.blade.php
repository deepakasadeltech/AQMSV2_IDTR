@extends('layouts.app')

@section('title', trans('messages.mainapp.menu.dashboard'))

@section('css')
    <link href="{{ asset('assets/css/materialize-colorpicker.min.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="{{ asset('assets/js/plugins/data-tables/css/jquery.dataTables.min.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
@endsection


@section('content')
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem">{{ trans('messages.mainapp.menu.dashboard') }}</h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li class="active">{{ trans('messages.mainapp.menu.dashboard') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div id="card-stats">
            @can('access', \App\Models\User::class)
                <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content light-blue darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> {{ trans('messages.today_queue') }}</p>
                                <h4 class="card-stats-number">{{ $today_queue }}</h4>
                                </p>
                            </div>
                            <div class="card-action light-blue darken-4">
                                <div class="center-align">
                                    <a href="{{ route('reports::queue_list', ['date' => \Carbon\Carbon::now()->format('d-m-Y')]) }}" style="text-transform:none;color:#fff">{{ trans('messages.more_info') }} <i class="mdi-navigation-arrow-forward"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content green lighten-1 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-communication-call-missed"></i> {{ trans('messages.today_missed') }}</p>
                                <h4 class="card-stats-number">{{ $missed }}</h4>
                                </p>
                            </div>
                            <div class="card-action green darken-2">
                                <div class="center-align">
                                    <a href="{{ route('reports::missed_show', ['date' => \Carbon\Carbon::now()->format('d-m-Y'), 'user' => 'all', 'counter' => 'all', 'type' => 'missed']) }}" style="text-transform:none;color:#fff">{{ trans('messages.more_info') }} <i class="mdi-navigation-arrow-forward"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content blue-grey white-text">
                                <p class="card-stats-title truncate"><i class="mdi-action-trending-up"></i> {{ trans('messages.today_served') }}</p>
                                <h4 class="card-stats-number">{{ $served }}</h4>
                                </p>
                            </div>
                            <div class="card-action blue-grey darken-2">
                                <div class="center-align">
                                    <a href="{{ route('reports::missed_show', ['date' => \Carbon\Carbon::now()->format('d-m-Y'), 'user' => 'all', 'counter' => 'all', 'type' => 'all']) }}" style="text-transform:none;color:#fff">{{ trans('messages.more_info') }} <i class="mdi-navigation-arrow-forward"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content orange darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-image-timer"></i> {{ trans('messages.over_time') }}</p>
                                <h4 class="card-stats-number">{{ $overtime }}</h4>
                                </p>
                            </div>
                            <div class="card-action orange darken-4">
                                <div class="center-align">
                                    <a href="{{ route('reports::missed_show', ['date' => \Carbon\Carbon::now()->format('d-m-Y'), 'user' => 'all', 'counter' => 'all', 'type' => 'overtime']) }}" style="text-transform:none;color:#fff">{{ trans('messages.more_info') }} <i class="mdi-navigation-arrow-forward"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            @can('access', \App\Models\User::class)
                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="card-panel hoverable waves-effect waves-dark teal lighten-3 white-text" style="display:inherit">
                            <span class="chart-title">{{ trans('messages.queue_details') }}</span>
                            <div class="trending-line-chart-wrapper">
                                <canvas id="queue-details-chart" height="155" style="height:308px"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l6">
                        <div class="card-panel hoverable waves-effect waves-dark" style="display:inherit">
                            <span class="chart-title">{{ trans('messages.today_yesterday') }}</span>
                            <div class="trending-line-chart-wrapper">
                                <canvas id="today-vs-yesterday-chart" height="155" style="height:308px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
  <!-----------display-controller-------------------------->
            @if($role == 'I')
            <div class="row">
					<div class="col s12 m6 l4">
                        <div class="card hoverable">
                        <div class="card-content pink darken-2 white-text dispuser">
                        <h4 class="card-stats-number"><a href="{{ route('display') }}" target="_blank">{{ trans('messages.mainapp.display_url') }}</a></h4>
                        </div>
                        </div>
                        </div>
                    <div class="col s12 m6 l4">
                        <div class="card hoverable">
                        <div class="card-content green darken-2 white-text dispuser">
                        <h4 class="card-stats-number"><a href="{{ route('displaysecond') }}" target="_blank">{{ trans('messages.mainapp.display_url') }} Second</a></h4>
                        </div>
                        </div>
                        </div>

                        <div class="col s12 m6 l4">
                        <div class="card hoverable">
                        <div class="card-content blue darken-2 white-text dispuser">
                        <h4 class="card-stats-number"><a href="{{ route('add_to_queue') }}" target="_blank">Display Kiosk URL</a></h4>
                        </div>
                        </div>
                        </div>
            </div>

            @endif
<!--------------------------------------------------------->

            @if($role == 'H')
			<div class="row">
					<div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content orange darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i>Doctors Active Today</p>
                                <h4 class="card-stats-number">{{count($totaldoctor_present)}}</h4>
                                </p>
                            </div>
                            <div class="card-action orange darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
					
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content light-green darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i>Doctors Absent</p>
                                <h4 class="card-stats-number">{{count($totaldoctor_absent)}}</h4>
                                </p>
                            </div>
                            <div class="card-action light-green darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>	
                <div class="row">
            <div class="col s12">
            
            <div class="queuetokenbox">  
            
       <ul id="tabs-swipe-demo" class="tabs">    
    <li class="tab"><a class="active" href="#tabname_doctor">Doctor</a></li>
    <li class="tab"><a href="#tabname_user">User</a></li>
  </ul>
  <div id="tabname_doctor" style="width:100%;">
            <h3 class="listdoctor">List Of Doctors</h3>
                <div class="cardp card-panel">
                    <table id="doctor-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.email') }}</th>
                                <th>{{ trans('messages.users.parent_department') }}</th>
                                <th>{{ trans('messages.users.department') }}</th>
                                <th>{{ trans('messages.users.counter') }}</th>
                                <th>{{ trans('messages.users.role') }}</th>
                                <th>{{ trans('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $tuser)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tuser->name }}</td>
                                    <td>{{ $tuser->email }}</td>
                                    <td>
                                    @foreach($pardepartments as $pardepartment)
                                    @if( $tuser->pid == $pardepartment->id )
                                    {{ $pardepartment->name }} @else @endif
                                    @endforeach
                                    </td>
                                    <td>{{ $tuser->department->name }}</td>
                                    <td>{{ $tuser->counter->name }}</td>
                                    <td>{{ $tuser->role_text }}</td>
                                  <td class="caction">
                                  @if($tuser->user_status == 1)
                                  <button class="btn waves-effect waves-light btn-small green">Active</button>
                                  @else
                                  <button class="btn waves-effect waves-light btn-small pink">InActive</button>
                                  @endif
                                 </td>
                                   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
<!------------------------------------------------>

<div id="tabname_user" style="width:100%;">
            <h3 class="listdoctor">List Of Users</h3>
                <div class="cardp card-panel">
                    <table id="user-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.email') }}</th>
                                <th>{{ trans('messages.users.role') }}</th>
                                <th>{{ trans('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($staffusers as $staffuser)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $staffuser->name }}</td>
                                    <td>{{ $staffuser->email }}</td>
                                    <td>{{ $staffuser->role_text }}</td>
                                  <td class="caction">
                                  @if($staffuser->user_status == 1)
                                  <button class="btn waves-effect waves-light btn-small green">Active</button>
                                  @else
                                  <button class="btn waves-effect waves-light btn-small pink">InActive</button>
                                  @endif
                                 </td>
                                   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
               
               </div>


<!-------------------------------------------->

               </div>


            </div>
        </div>
    </div>
			@endif

			
			
			@if($role == 'S')
			<div class="row userdashboard">
            <ul id="tabs-swipe-demo" class="tabs">    
            <li class="tab"> <div class="col s12 m12 l12">
                        <div class="card hoverable">
                            <div class="card-content yellow darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i>Tokens Issued Today</p>
                                <h4 class="card-stats-number">{{count($get_all_department_total_queue_in_today)}}</h4>
                                </p>
                            </div>
                            <div class="card-action yellow darken-4">
                                <div class="center-align">
                                <a class="active" href="#tabname_queue">More Details <i class="mdi-navigation-arrow-down"></i></a>
                                </div>
                            </div>
                        </div>
                    </div></li>
					
                    <li class="tab"> <div class="col s12 m12 l12">
                        <div class="card hoverable">
                            <div class="card-content pink darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i>Tokens Called Today</p>
                                <h4 class="card-stats-number">{{count($get_all_department_total_called_in_today)}}</h4>
                                </p>
                            </div>
                            <div class="card-action pink darken-4">
                                <div class="center-align">
                                <a href="#tabname_called">More Details <i class="mdi-navigation-arrow-down"></i></a>
                                </div>
                            </div>
                        </div>
                    </div></li>

                    <li class="tab"> <div class="col s12 m12 l12">
                        <div class="card hoverable">
                            <div class="card-content light-green darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i>Doctors Active Today</p>
                                <h4 class="card-stats-number">{{count($totaldoctor_present)}}</h4>
                                </p>
                            </div>
                            <div class="card-action light-green darken-4">
                                <div class="center-align">
                                <a href="#tabname_dpresent">More Details <i class="mdi-navigation-arrow-down"></i></a>
                                </div>
                            </div>
                        </div>
                    </div></li>
					
                    <li class="tab"> <div class="col s12 m12 l12">
                        <div class="card hoverable">
                            <div class="card-content orange darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i>Doctors InActive Today</p>
                                <h4 class="card-stats-number">{{count($totaldoctor_absent)}}</h4>
                                </p>
                            </div>
                            <div class="card-action orange darken-4">
                                <div class="center-align">
                                <a href="#tabname_dabsent">More Details <i class="mdi-navigation-arrow-down"></i></a>
                                </div>
                            </div>
                        </div>
                    </div></li>
                   
                </ul>
      <!------------------------------>  
      <div class="usertablebox">
      <div id="tabname_queue" class="col s12 m12 l12">
      <div class="cardp card-panel">
         
                    <table id="queue-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>{{ trans('messages.users.parent_department') }}</th>
                                <th>{{ trans('messages.users.department') }}</th>
                                <th>{{ trans('messages.users.token_number') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($get_all_department_total_queue_in_today as $q)
                        <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>@foreach($pardepartments as $pardepartment)
                                    @if( $q->department->pid == $pardepartment->id )
                                    {{ $pardepartment->name }} @else @endif
                                    @endforeach</td>
                           <td>{{$q->department->name}}</td>
                           <td>{{$q->department->letter}}{{$q->number}}</td>
                           </tr>
                       @endforeach    
                        </tbody>
                    </table>
                </div>

      </div>
      <div id="tabname_called" class="col s12 m12 l12">
      <div class="cardp card-panel">
                    <table id="called-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.parent_department') }}</th>
                                <th>{{ trans('messages.users.department') }}</th>
                                <th>{{ trans('messages.users.token_number') }}</th>
                                <th>{{ trans('messages.users.room_number') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($get_all_department_total_called_in_today as $c)
                           <tr>
                           <td>{{ $loop->iteration }}</td>

                           <td>@foreach($users as $uc)
                           @if( $c->counter_id == $uc->counter_id )
                           {{$uc->name}}
                           @endif
                           @endforeach</td>

                           <td>@foreach($pardepartments as $pardepartment)
                                    @if( $c->department->pid == $pardepartment->id )
                                    {{ $pardepartment->name }} @else @endif
                                    @endforeach</td>
                           <td>{{$c->department->name}}</td>
                           <td>{{$c->department->letter}}{{$c->number}}</td>
                           <td>
                            @foreach($users as $uc)
                           @if( $c->counter_id == $uc->counter_id )
                           {{$uc->counter->name}}
                           @endif
                           @endforeach
                           </td>
                           </tr> 
                        @endforeach 
                        </tbody>
                    </table>
                </div>

      </div>
      <div id="tabname_dpresent" class="col s12 m12 l12">
      <div class="cardp card-panel">
                    <table id="dp-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.email') }}</th>
                                <th>{{ trans('messages.users.parent_department') }}</th>
                                <th>{{ trans('messages.users.department') }}</th>
                                <th>{{ trans('messages.users.counter') }}</th>
                                <th>{{ trans('messages.users.role') }}</th>
                                <th>{{ trans('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $tuser)
                            @if($tuser->user_status == 1)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tuser->name }}</td>
                                    <td>{{ $tuser->email }}</td>
                                    <td>
                                    @foreach($pardepartments as $pardepartment)
                                    @if( $tuser->pid == $pardepartment->id )
                                    {{ $pardepartment->name }} @else @endif
                                    @endforeach
                                    </td>
                                    <td>{{ $tuser->department->name }}</td>
                                    <td>{{ $tuser->counter->name }}</td>
                                    <td>{{ $tuser->role_text }}</td>
                                  <td class="caction">
                                <button class="btn waves-effect waves-light btn-small green">Active</button>
                                  </td>
                                    </tr>
                                    
                                  @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
      </div>
      <div id="tabname_dabsent" class="col s12 m12 l12">
       
      <div class="cardp card-panel">
                    <table id="da-table"  class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.email') }}</th>
                                <th>{{ trans('messages.users.parent_department') }}</th>
                                <th>{{ trans('messages.users.department') }}</th>
                                <th>{{ trans('messages.users.counter') }}</th>
                                <th>{{ trans('messages.users.role') }}</th>
                                <th>{{ trans('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $tuser)
                            @if($tuser->user_status == 2)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tuser->name }}</td>
                                    <td>{{ $tuser->email }}</td>
                                    <td>
                                    @foreach($pardepartments as $pardepartment)
                                    @if( $tuser->pid == $pardepartment->id )
                                    {{ $pardepartment->name }} @else @endif
                                    @endforeach
                                    </td>
                                    <td>{{ $tuser->department->name }}</td>
                                    <td>{{ $tuser->counter->name }}</td>
                                    <td>{{ $tuser->role_text }}</td>
                                  <td class="caction">
                                  <button class="btn waves-effect waves-light btn-small pink">InActive</button>
                                 </td>
                                </tr>
                               
                                @endif 
                            @endforeach
                        </tbody>
                    </table>
                </div> </div>
      </div>

      </div>            
                    
      <!------------------------------->              
                </div>	
			@endif
			
			@if($role == 'D')
           <!----------------------------------> 
            <div class="row">

            <div class="col s12 m6 l3">
            <div class="doctordetails">
            <span>Department :</span><span>
           @if($pdepartments->id == '') <a style="color:red">Not Allotted</a>  @else {{$pdepartments->name}}  @endif
            </span>
            </div></div>

            <div class="col s12 m6 l3">
            <div class="doctordetails">
            <span>Sub Department :</span><span>@if($user_details->department_id == '') <a style="color:red">Not Allotted </a> @else {{$user_details->department->name}}   @endif</span>
            </div></div>

            <div class="col s12 m6 l3">
            <div class="doctordetails">
            <span>Room No. :</span><span>@if($user_details->counter_id == '') <a style="color:red">Not Allotted</a> @else {{$user_details->counter->name}}  @endif</span>
            </div></div>

            <div class="col s12 m6 l3">
            </div>

            </div>
           <!------------------------------------->
			<div class="row">

             <!------------------------->
             <div class="col s12 m3 l3 pd_right">
               
               <div class="card hoverable">
               <div class="pripad responsive_info card-content lightblack darken-2 white-text">
 
                  <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Priority Pending</p>
                    <div class="prioritybox"> <ul>
                     <li><span class="plclr">Platinum</span><span class="plclr">{{count($today_queue_platinum)}}<span></li>
                     <li><span class="glclr">Gold</span><span class="glclr">{{count($today_queue_gold)}}<span></li>
                     <li><span class="slclr">Silver</span><span class="slclr">{{count($today_queue_silver)}}<span></li>
                     </ul></div>
 
                  </div>
                         
              </div>
              </div>
 
<!-------------------------> 
            <div class="col s12 m9 l9 pd_right">
            <div class="row">
            <!---------------------->
             <div class="col s6 m6 l3 pd_right">
              <div class="card hoverable">
                            <div class="responsive_info card-content light-green darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Document Check By You <span class="respan">Today</span> </p>
                                <h4 class="card-stats-number">{{ $patient_seen }}</h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action light-green darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> 
            <!-------------------------> 

            <div class="col s6 m6 l3 pd_left">
              <div class="card hoverable">
                            <div class="responsive_info card-content pink darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Token Called By You <span class="respan">Today</span></p>
                                <h4 class="card-stats-number">
                                {{count($patient_called_bydoctor)}}
                               <!-- {{count($today_called_bycounter)}}--->
                                </h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action pink darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> 

            <!------------------------>
                    
            <div class="col s6 m6 l3 pd_right">
               <div class="card hoverable">
                            <div class="responsive_info card-content orange darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Tokens Pending</p>
                                <h4 class="card-stats-number">
                                @if(count($today_queue_bycounter) > 0)
                                {{count($today_queue_bycounter)}} @else No Token @endif
                                </h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action orange darken-4">
                                <div class="center-align">
                                <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> 
            <!--------------------------->
            <div class="col s6 m6 l3 pd_left">
                        <div class="card hoverable">
                            <div class="responsive_info card-content blue darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Average Time <span class="respan">(with Token)</span></p>
                                <h4 class="card-stats-number">
                               
                               <?php $total_end_time = '0'; $total_start_time = '0'; $total_token = '0'; $total_time_spent_for_patient; $ttpatient ?>
                               @foreach($daily_avgtime_of_doctor as $option)
                                @php( $total_end_time += strtotime($option->end_time) )
                                @php( $total_start_time += strtotime($option->start_time))
                               @endforeach
                            
                                <?php 
                               // echo $patient_seen.'<br>';
                               if($patient_seen > 0){
                                $ttpatient = $patient_seen;
                               }else{
                                $ttpatient = 1;
                               }
                                $total_time_spent_for_patient = ($total_end_time-$total_start_time)/$ttpatient;
                                 echo gmdate("H:i:s", $total_time_spent_for_patient).'<sub style="font-size:12px;">&nbsp; Hrs / Tokens</sub>'; 
                                ?>
                                </h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action blue darken-4">
                                <div class="center-align">
                                    
                                    <!---------------------------------->
                 <form  action="{{ route('post_doctor_status') }}" method="post">
                            {{ csrf_field() }}
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <button id="mailbtn" style="height:auto; line-height:18px; padding:2px 15px; font-size:13px;" class="btn waves-effect waves-light pink" type="submit" name="user_id" value="{{$user->id}}">mail <i class="mdi-content-send right"></i></button>
                         </form>
                 <!---------------------------------->

                                </div>
                            </div>
                        </div>
                    </div>  
            <!---------------------------->
                    </div></div>
             
            <!------------------------->            
                </div>	
			@endif
			
			@if($role == 'D')
			<div class="row">
                <div class="col s12">
				<div class="card-panel doctordashboard">
                    
                    <div class="divider" style="margin:15px 0 10px 0; display:none;"></div>
                 

                    <table id="department-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Counter</th>
								<th>Token</th>
                                <th>Priority</th>
                                <th>{{ trans('messages.actions') }}</th>
                                <th>Token Called</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patient_list_doctorwise->sortBy('id') as $patient)
                        <!---------------------------------------->   
                                <tr>
                                    <td @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif >{{ $loop->iteration }}</td>
                                    <td  @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif>{{ $patient->counter->name }}</td>
									<td  @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif>{{$patient->department->letter}}{{ $patient->number  }}</td>
									<td  @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif>
									@if($patient->priority==1) <span class="boxmodi plbox">Plantinum </span>
									@elseif($patient->priority==2) <span class="boxmodi glbox">Gold</span>
									@elseif($patient->priority==3) <span class="boxmodi slbox">Silver</span>
									@elseif($patient->priority==4) <span class="boxmodi nlbox">Normal</span>
									@else
                                     Normal										
									@endif	
									</td>
                                    <td  @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif>
                                    <?php
                                    if(in_array($patient->view_status, array(1,2))) {
                                        if($patient->doctor_work_start == 0){
                                    ?>
                                         <a class="btn-floating waves-effect waves-light btn blue tooltipped" href="{{url('/dashboard/startCounter')}}/{{$patient->id}}" data-position="top" data-tooltip="{{ trans('messages.start_time') }}"> <i class="mdi-av-timer"></i></a>

<a style="cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light deep-purple tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="{{ trans('messages.you_do_first_start') }}"> <i class="mdi-action-schedule"></i></a>
                                    <?php
                                        }else if($patient->doctor_work_start == 1){
                                    ?>
                                    <a style="cursor:not-allowed" class="disabled btn-floating waves-effect waves-light btn blue tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="{{ trans('messages.You_have_started') }}"> <i class="mdi-av-timer"></i></a>

<a  class="btn-floating btn waves-effect waves-light deep-purple tooltipped" href="{{url('/dashboard/endCounter')}}/{{$patient->id}}" data-position="top" data-tooltip="{{ trans('messages.end_time') }}"> <i class="mdi-action-schedule"></i></a>
                                    <?php
                                        }else{
                                    ?>
                                     <a style="cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light deep-purple tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Press ON to display Patient Token Number"> <i class="mdi-action-schedule"></i></a>

<a style="cursor:not-allowed" class="disabled btn-floating waves-effect waves-light btn blue tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Press ON to display Patient Token Number"> <i class="mdi-av-timer"></i></a>
                                    <?php
                                        }
                                    }else{

                                    ?>
                                     <a style="cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light deep-purple tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Press ON to display Patient Token Number"> <i class="mdi-action-schedule"></i></a>

<a style="cursor:not-allowed" class="disabled btn-floating waves-effect waves-light btn blue tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Press ON to display Patient Token Number"> <i class="mdi-av-timer"></i></a>
                                    <?php    
                                    }
                                    ?>
                                    </td>
                                  
                                  
                                  @if(in_array($patient->view_status, array(1,2)))
                                  <td>
                                  @if($patient->doctor_work_start == 1)     
                                  <a style="font-size:10px cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light green tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Not Allowed">ON</a>
                                  @else
                                 <a style="font-size:10px" class="btn-floating btn waves-effect waves-light green tooltipped" href="{{url('/dashboard/PatientStatus')}}/{{$patient->id}}" data-position="top" data-tooltip="Press to turn OFF ??">ON</a>
                                 @endif
                                 </td> 
                                 <!--------->
                                  @else
                                  <td>  
                                  <a style="font-size:10px" class="btn-floating btn waves-effect waves-light red tooltipped" href="{{url('/dashboard/PatientStatus')}}/{{$patient->id}}" data-position="top" data-tooltip="Press to turn ON ??">OFF</a>
                                 </td>
                                  @endif
                                  <!------------->
                                  

                                 </tr>
                         <!------------------>  
                            
                        
                         <!------------------>

                            @endforeach
                        </tbody>
                    </table>
                    
                <div class="row">
                <div class="col s12 center">
                <div class="nextbuttoncall">
               <!------------------------------------>
               <form id="new_call" action="{{ route('post_doctor_call') }}" method="post">
                            {{ csrf_field() }}
                            @if(!($user->is_admin)||($user->role=='D'))
                            <input type="hidden" name="user" value="{{ $user->id }}">
                            <input type="hidden" name="pid" value="{{ $user->pid }}">
                            <input type="hidden" name="department" value="{{ $user->department_id }}">
                            <input type="hidden" name="counter" value="{{ $user->counter_id }}">
                           @endif
                             <div class="row">
                                <div class="col s12">
                                
                <button id="<?php if($totaloldtoken > 0) {echo 'autosubmitcall';} ?>" @if((count($patient_list_doctorwise) >= 6)||(count($today_queue_bycounter)==0)) disabled="disabled" @endif class="btn waves-effect waves-light pink" type="submit">
                                 
                                Call Next Token<i class="mdi-content-send right"></i></i> 
                             </button>
                                </div>
                            </div>
                        </form>
               <!------------------------------------>
                </div>
                </div>
                </div>
                    
                </div>
				</div>
			</div>
			@endif

            
			@if($role == 'A')
            <div class="row">
                <div class="col s12">
                    <div class="card hoverable waves-effect waves-dark" style="display:inherit">
                        <div class="card-move-up black-text">
                            <div class="move-up">
                                <div>
                                    <span class="chart-title">{{ trans('messages.dashboard.notification') }}</span>
                                </div>
                                <div class="trending-line-chart-wrapper">
                                    <p>{{ trans('messages.dashboard.preview') }}:</p>
                                    <span style="font-size:{{ $setting->size }}px;color:{{ $setting->color }}">
                                        <marquee>{{ $setting->notification }}</marquee>
                                    </span>
                                    <p></p>
                                    <form id="noti" action="{{ route('dashboard_store') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="input-field col s12 m8">
                                                <label for="notification">{{ trans('messages.dashboard.notification_text') }}</label>
                                                <input id="notification" name="notification" type="text" placeholder="{{ trans('messages.dashboard.notification_placeholder') }}" data-error=".errorNotification" value="{{ $setting->notification }}">
                                                <div class="errorNotification"></div>
                                            </div>
                                            <div class="input-field col s12 m1">
                                                <label for="size">{{ trans('messages.font_size') }}</label>
                                                <input id="size" name="size" type="number" placeholder="Size" max="60" min="15" size="2" data-error=".errorSize" value="{{ $setting->size }}">
                                                <div class="errorSize"></div>
                                            </div>
                                            <div class="input-field col s12 m2">
                                                <label for="color">{{ trans('messages.color') }}</label>
                                                <input id="color" type="text" placeholder="Color" name="color" data-error=".errorColor" value="{{ $setting->color }}">
                                                <div class="errorColor"></div>
                                            </div>
                                            <div class="input-field col s12 m1">
                                                <button class="btn waves-effect waves-light right submit" type="submit" style="padding:0 1.3rem">{{ trans('messages.go') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			@endif
<!--------------------------------------------------->
@if($role == 'U') 
GENERATOR
@endif
<!---------------------------------------------------->
@if($role == 'R') 


<div class="row">

            <div class="col s12 m6 l3">
            <div class="doctordetails">
            <span>Department :</span><span>
           @if($npdepartments->id == '') <a style="color:red">Not Allotted</a>  @else {{$npdepartments->name}}  @endif
            </span>
            </div></div>

            <div class="col s12 m6 l3">
            <div class="doctordetails">
            <span>Sub Department :</span><span>@if($nuser_details->department_id == '') <a style="color:red">Not Allotted </a> @else {{$nuser_details->department->name}}   @endif</span>
            </div></div>

            <div class="col s12 m6 l3">
            <div class="doctordetails">
            <span>Counter :</span><span>@if($nuser_details->counter_id == '') <a style="color:red">Not Allotted</a> @else {{$nuser_details->counter->name}}  @endif</span>
            </div></div>

            <div class="col s12 m6 l3">
            </div>

            </div>
           <!------------------------------------->
			<div class="row" style="display:none;">

             <!------------------------->
             <div class="col s12 m3 l3 pd_right">
               
               <div class="card hoverable">
               <div class="pripad responsive_info card-content lightblack darken-2 white-text">
 
                  <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Priority Pending</p>
                    <div class="prioritybox"> <ul>
                     <li><span class="plclr">Platinum</span><span class="plclr">{{count($ntoday_queue_platinum)}}<span></li>
                     <li><span class="glclr">Gold</span><span class="glclr">{{count($ntoday_queue_gold)}}<span></li>
                     <li><span class="slclr">Silver</span><span class="slclr">{{count($ntoday_queue_silver)}}<span></li>
                     </ul></div>
 
                  </div>
                         
              </div>
              </div>
 
<!-------------------------> 
            <div class="col s12 m9 l9 pd_right">
            <div class="row">
            <!---------------------->
             <div class="col s6 m6 l3 pd_right">
              <div class="card hoverable">
                            <div class="responsive_info card-content light-green darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Patient Seen By You <span class="respan">Today</span> </p>
                                <h4 class="card-stats-number">{{ $npatient_seen }}</h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action light-green darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> 
            <!-------------------------> 

            <div class="col s6 m6 l3 pd_left">
              <div class="card hoverable">
                            <div class="responsive_info card-content pink darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Patient Called By You <span class="respan">Today</span></p>
                                <h4 class="card-stats-number">
                                {{count($npatient_called_bydoctor)}}
                               <!-- {{count($today_called_bycounter)}}--->
                                </h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action pink darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> 

            <!------------------------>
                    
            <div class="col s6 m6 l3 pd_right">
               <div class="card hoverable">
                            <div class="responsive_info card-content orange darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Patients Pending</p>
                                <h4 class="card-stats-number">{{count($ntoday_queue_bycounter)}}</h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action orange darken-4">
                                <div class="center-align">
                                <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> 
            <!--------------------------->
            <div class="col s6 m6 l3 pd_left">
                        <div class="card hoverable">
                            <div class="responsive_info card-content blue darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Average Time <span class="respan">(with patient)</span></p>
                                <h4 class="card-stats-number">
                               
                               <?php $total_end_time = '0'; $total_start_time = '0'; $total_token = '0'; $total_time_spent_for_patient; $ttpatient ?>
                               @foreach($ndaily_avgtime_of_doctor as $option)
                                @php( $total_end_time += strtotime($option->end_time) )
                                @php( $total_start_time += strtotime($option->start_time))
                               @endforeach
                            
                                <?php 
                               // echo $patient_seen.'<br>';
                               if($patient_seen > 0){
                                $ttpatient = $patient_seen;
                               }else{
                                $ttpatient = 1;
                               }
                                $total_time_spent_for_patient = ($total_end_time-$total_start_time)/$ttpatient;
                                 echo gmdate("H:i:s", $total_time_spent_for_patient).'<sub style="font-size:12px;">&nbsp; Hrs / Patient</sub>'; 
                                ?>
                                </h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action blue darken-4">
                                <div class="center-align">
                                    
                                    <!---------------------------------->
                 <form  action="{{ route('post_doctor_status') }}" method="post">
                            {{ csrf_field() }}
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <button id="mailbtn" style="height:auto; line-height:18px; padding:2px 15px; font-size:13px;" class="btn waves-effect waves-light pink" type="submit" name="user_id" value="{{$user->id}}">mail <i class="mdi-content-send right"></i></button>
                         </form>
                 <!---------------------------------->

                                </div>
                            </div>
                        </div>
                    </div>  
            <!---------------------------->
                    </div></div>
             
            <!------------------------->            
                </div>	
			
			<div class="row">
                <div class="col s12">
				<div class="card-panel doctordashboard">
                    
                    <div class="divider" style="margin:15px 0 10px 0; display:none;"></div>


                    <div class="row" style="display:none;">
                <div class="col s12 center">
                <div class="nextbuttoncall">
               <!------------------------------------>
               <form id="new_call" action="{{ route('post_scanner_call') }}" method="post">
                            {{ csrf_field() }}
                            @if(!($user->is_admin)||($user->role=='T'))
                            <input type="hidden" name="user" value="{{ $user->id }}">
                            <input type="hidden" name="pid" value="{{ $user->pid }}">
                            <input type="hidden" name="department" value="{{ $user->department_id }}">
                            <input type="hidden" name="counter" value="{{ $user->counter_id }}">
                           @endif
                             <div class="row">
                                <div class="col s12">
                                <button @if((count($npatient_list_doctorwise) >= 6)||(count($ntoday_queue_bycounter)==0)) disabled="disabled" @endif class="btn waves-effect waves-light pink" type="submit">
                                 
                                 {{ trans('messages.call.call_next') }}<i class="mdi-content-send right"></i></i>
                             </button>
                                </div>
                            </div>
                        </form>
               <!------------------------------------>
                </div>
                </div>
                </div>



<div class="row">
                <div class="col s12 center">
                
               <table id="department-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>COUNTER</th>
								<th>Token</th>
                                <th>Priority</th>
                                <th>{{ trans('messages.actions') }}</th>
                                <th>Token Called</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rpatient_list_doctorwise->sortBy('id') as $patient)
                        <!---------------------------------------->   
                                <tr>
                                    <td @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif >{{ $loop->iteration }}</td>
                                    <td  @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif>
                                    @if($patient->checkingCounter == 'R') Court Work @else @endif</td>

									<td  @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif>{{$patient->department->letter}}{{ $patient->nt_number  }}</td>
									<td  @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif>
									@if($patient->priority==1) <span class="boxmodi plbox">Plantinum </span>
									@elseif($patient->priority==2) <span class="boxmodi glbox">Gold</span>
									@elseif($patient->priority==3) <span class="boxmodi slbox">Silver</span>
									@elseif($patient->priority==4) <span class="boxmodi nlbox">Normal</span>
									@else
                                     Normal										
									@endif	
									</td>
                                    <td  @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif>
                                    <?php
                                    if(in_array($patient->view_status, array(1,2))) {
                                        if($patient->doctor_work_start == 0){
                                    ?>
                                         <a class="btn-floating waves-effect waves-light btn blue tooltipped" href="{{url('/dashboard/startCounter')}}/{{$patient->id}}" data-position="top" data-tooltip="{{ trans('messages.start_time') }}"> <i class="mdi-av-timer"></i></a>

<a style="cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light deep-purple tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="{{ trans('messages.you_do_first_start') }}"> <i class="mdi-action-schedule"></i></a>
                                    <?php
                                        }else if($patient->doctor_work_start == 1){
                                    ?>
                                    <a style="cursor:not-allowed" class="disabled btn-floating waves-effect waves-light btn blue tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="{{ trans('messages.You_have_started') }}"> <i class="mdi-av-timer"></i></a>

<a  class="btn-floating btn waves-effect waves-light deep-purple tooltipped" href="{{url('/dashboard/endCounter')}}/{{$patient->id}}" data-position="top" data-tooltip="{{ trans('messages.end_time') }}"> <i class="mdi-action-schedule"></i></a>
                                    <?php
                                        }else{
                                    ?>
                                     <a style="cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light deep-purple tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Press ON to display Patient Token Number"> <i class="mdi-action-schedule"></i></a>

<a style="cursor:not-allowed" class="disabled btn-floating waves-effect waves-light btn blue tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Press ON to display Patient Token Number"> <i class="mdi-av-timer"></i></a>
                                    <?php
                                        }
                                    }else{

                                    ?>
                                     <a style="cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light deep-purple tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Press ON to display Patient Token Number"> <i class="mdi-action-schedule"></i></a>

<a style="cursor:not-allowed" class="disabled btn-floating waves-effect waves-light btn blue tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Press ON to display Patient Token Number"> <i class="mdi-av-timer"></i></a>
                                    <?php    
                                    }
                                    ?>
                                    </td>
                                  
                                  
                                  @if(in_array($patient->view_status, array(1,2)))
                                  <td>
                                  @if($patient->doctor_work_start == 1)     
                                  <a style="font-size:10px cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light green tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Not Allowed">ON</a>
                                  @else
                                 <a style="font-size:10px" class="btn-floating btn waves-effect waves-light green tooltipped" href="{{url('/dashboard/PatientStatus')}}/{{$patient->id}}" data-position="top" data-tooltip="Press to turn OFF ??">ON</a>
                                 @endif
                                 </td> 
                                 <!--------->
                                  @else
                                  <td>  
                                  <a style="font-size:10px" class="btn-floating btn waves-effect waves-light red tooltipped" href="{{url('/dashboard/PatientStatus')}}/{{$patient->id}}" data-position="top" data-tooltip="Press to turn ON ??">OFF</a>
                                 </td>
                                  @endif
                                  <!------------->
                                  

                                 </tr>
                         <!------------------>  
                            
                        
                         <!------------------>

                            @endforeach
                        </tbody>
                    </table>


                </div>
                </div>
     @endif
<!---------------------------------------------------->


<!---------------------------------------------------->
@if($role == 'P') 


<div class="row">

            <div class="col s12 m6 l3">
            <div class="doctordetails">
            <span>Department :</span><span>
           @if($npdepartments->id == '') <a style="color:red">Not Allotted</a>  @else {{$npdepartments->name}}  @endif
            </span>
            </div></div>

            <div class="col s12 m6 l3">
            <div class="doctordetails">
            <span>Sub Department :</span><span>@if($nuser_details->department_id == '') <a style="color:red">Not Allotted </a> @else {{$nuser_details->department->name}}   @endif</span>
            </div></div>

            <div class="col s12 m6 l3">
            <div class="doctordetails">
            <span>COUNTER :</span><span>@if($nuser_details->counter_id == '') <a style="color:red">Not Allotted</a> @else {{$nuser_details->counter->name}}  @endif</span>
            </div></div>

            <div class="col s12 m6 l3">
            </div>

            </div>
           <!------------------------------------->
			<div class="row" style="display:none;">

             <!------------------------->
             <div class="col s12 m3 l3 pd_right">
               
               <div class="card hoverable">
               <div class="pripad responsive_info card-content lightblack darken-2 white-text">
 
                  <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Priority Pending</p>
                    <div class="prioritybox"> <ul>
                     <li><span class="plclr">Platinum</span><span class="plclr">{{count($ntoday_queue_platinum)}}<span></li>
                     <li><span class="glclr">Gold</span><span class="glclr">{{count($ntoday_queue_gold)}}<span></li>
                     <li><span class="slclr">Silver</span><span class="slclr">{{count($ntoday_queue_silver)}}<span></li>
                     </ul></div>
 
                  </div>
                         
              </div>
              </div>
 
<!-------------------------> 
            <div class="col s12 m9 l9 pd_right">
            <div class="row">
            <!---------------------->
             <div class="col s6 m6 l3 pd_right">
              <div class="card hoverable">
                            <div class="responsive_info card-content light-green darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Patient Seen By You <span class="respan">Today</span> </p>
                                <h4 class="card-stats-number">{{ $npatient_seen }}</h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action light-green darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> 
            <!-------------------------> 

            <div class="col s6 m6 l3 pd_left">
              <div class="card hoverable">
                            <div class="responsive_info card-content pink darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Patient Called By You <span class="respan">Today</span></p>
                                <h4 class="card-stats-number">
                                {{count($npatient_called_bydoctor)}}
                               <!-- {{count($today_called_bycounter)}}--->
                                </h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action pink darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> 

            <!------------------------>
                    
            <div class="col s6 m6 l3 pd_right">
               <div class="card hoverable">
                            <div class="responsive_info card-content orange darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Patients Pending</p>
                                <h4 class="card-stats-number">{{count($ntoday_queue_bycounter)}}</h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action orange darken-4">
                                <div class="center-align">
                                <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> 
            <!--------------------------->
            <div class="col s6 m6 l3 pd_left">
                        <div class="card hoverable">
                            <div class="responsive_info card-content blue darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Average Time <span class="respan">(with patient)</span></p>
                                <h4 class="card-stats-number">
                               
                               <?php $total_end_time = '0'; $total_start_time = '0'; $total_token = '0'; $total_time_spent_for_patient; $ttpatient ?>
                               @foreach($ndaily_avgtime_of_doctor as $option)
                                @php( $total_end_time += strtotime($option->end_time) )
                                @php( $total_start_time += strtotime($option->start_time))
                               @endforeach
                            
                                <?php 
                               // echo $patient_seen.'<br>';
                               if($patient_seen > 0){
                                $ttpatient = $patient_seen;
                               }else{
                                $ttpatient = 1;
                               }
                                $total_time_spent_for_patient = ($total_end_time-$total_start_time)/$ttpatient;
                                 echo gmdate("H:i:s", $total_time_spent_for_patient).'<sub style="font-size:12px;">&nbsp; Hrs / Patient</sub>'; 
                                ?>
                                </h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action blue darken-4">
                                <div class="center-align">
                                    
                                    <!---------------------------------->
                 <form  action="{{ route('post_doctor_status') }}" method="post">
                            {{ csrf_field() }}
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <button id="mailbtn" style="height:auto; line-height:18px; padding:2px 15px; font-size:13px;" class="btn waves-effect waves-light pink" type="submit" name="user_id" value="{{$user->id}}">mail <i class="mdi-content-send right"></i></button>
                         </form>
                 <!---------------------------------->

                                </div>
                            </div>
                        </div>
                    </div>  
            <!---------------------------->
                    </div></div>
             
            <!------------------------->            
                </div>	
			
			<div class="row">
                <div class="col s12">
				<div class="card-panel doctordashboard">
                    
                    <div class="divider" style="margin:15px 0 10px 0; display:none;"></div>


                    <div class="row" style="display:none;">
                <div class="col s12 center">
                <div class="nextbuttoncall">
               <!------------------------------------>
               <form id="new_call" action="{{ route('post_scanner_call') }}" method="post">
                            {{ csrf_field() }}
                            @if(!($user->is_admin)||($user->role=='T'))
                            <input type="hidden" name="user" value="{{ $user->id }}">
                            <input type="hidden" name="pid" value="{{ $user->pid }}">
                            <input type="hidden" name="department" value="{{ $user->department_id }}">
                            <input type="hidden" name="counter" value="{{ $user->counter_id }}">
                           @endif
                             <div class="row">
                                <div class="col s12">
                                <button @if((count($npatient_list_doctorwise) >= 6)||(count($ntoday_queue_bycounter)==0)) disabled="disabled" @endif class="btn waves-effect waves-light pink" type="submit">
                                 
                                 {{ trans('messages.call.call_next') }}<i class="mdi-content-send right"></i></i>
                             </button>
                                </div>
                            </div>
                        </form>
               <!------------------------------------>
                </div>
                </div>
                </div>



<div class="row">
                <div class="col s12 center">
                
               <table id="department-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Counter</th>
								<th>Token</th>
                                <th>Priority</th>
                                <th>{{ trans('messages.actions') }}</th>
                                <th>Token Called</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ppatient_list_doctorwise->sortBy('id') as $patient)
                        <!---------------------------------------->   
                                <tr>
                                    <td @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif >{{ $loop->iteration }}</td>
                                    <td  @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif>
                                    @if($patient->checkingCounter == 'P') PayFine @else @endif</td>

									<td  @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif>{{$patient->department->letter}}{{ $patient->nt_number  }}</td>
									<td  @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif>
									@if($patient->priority==1) <span class="boxmodi plbox">Plantinum </span>
									@elseif($patient->priority==2) <span class="boxmodi glbox">Gold</span>
									@elseif($patient->priority==3) <span class="boxmodi slbox">Silver</span>
									@elseif($patient->priority==4) <span class="boxmodi nlbox">Normal</span>
									@else
                                     Normal										
									@endif	
									</td>
                                    <td  @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif>
                                    <?php
                                    if(in_array($patient->view_status, array(1,2))) {
                                        if($patient->doctor_work_start == 0){
                                    ?>
                                         <a class="btn-floating waves-effect waves-light btn blue tooltipped" href="{{url('/dashboard/startCounter')}}/{{$patient->id}}" data-position="top" data-tooltip="{{ trans('messages.start_time') }}"> <i class="mdi-av-timer"></i></a>

<a style="cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light deep-purple tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="{{ trans('messages.you_do_first_start') }}"> <i class="mdi-action-schedule"></i></a>
                                    <?php
                                        }else if($patient->doctor_work_start == 1){
                                    ?>
                                    <a style="cursor:not-allowed" class="disabled btn-floating waves-effect waves-light btn blue tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="{{ trans('messages.You_have_started') }}"> <i class="mdi-av-timer"></i></a>

<a id="endcounter"  class="btn-floating btn waves-effect waves-light deep-purple tooltipped" href="{{url('/dashboard/endCounter')}}/{{$patient->id}}" data-position="top" data-tooltip="{{ trans('messages.end_time') }}"> <i class="mdi-action-schedule"></i></a>
                                    <?php
                                        }else{
                                    ?>
                                     <a style="cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light deep-purple tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Press ON to display Patient Token Number"> <i class="mdi-action-schedule"></i></a>

<a style="cursor:not-allowed" class="disabled btn-floating waves-effect waves-light btn blue tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Press ON to display Patient Token Number"> <i class="mdi-av-timer"></i></a>
                                    <?php
                                        }
                                    }else{

                                    ?>
                                     <a style="cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light deep-purple tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Press ON to display Patient Token Number"> <i class="mdi-action-schedule"></i></a>

<a style="cursor:not-allowed" class="disabled btn-floating waves-effect waves-light btn blue tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Press ON to display Patient Token Number"> <i class="mdi-av-timer"></i></a>
                                    <?php    
                                    }
                                    ?>
                                    </td>
                                  
                                  
                                  @if(in_array($patient->view_status, array(1,2)))
                                  <td>
                                  @if($patient->doctor_work_start == 1)     
                                  <a style="font-size:10px cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light green tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Not Allowed">ON</a>
                                  @else
                                 <a style="font-size:10px" class="btn-floating btn waves-effect waves-light green tooltipped" href="{{url('/dashboard/PatientStatus')}}/{{$patient->id}}" data-position="top" data-tooltip="Press to turn OFF ??">ON</a>
                                 @endif
                                 </td> 
                                 <!--------->
                                  @else
                                  <td>  
                                  <a style="font-size:10px" class="btn-floating btn waves-effect waves-light red tooltipped" href="{{url('/dashboard/PatientStatus')}}/{{$patient->id}}" data-position="top" data-tooltip="Press to turn ON ??">OFF</a>
                                 </td>
                                  @endif
                                  <!------------->
                                  

                                 </tr>
                         <!------------------>  
                            
                        
                         <!------------------>

                            @endforeach
                        </tbody>
                    </table>


                </div>
                </div>
     @endif
<!---------------------------------------------------->
@if($role == 'T')


<div class="row">

            <div class="col s12 m6 l3">
            <div class="doctordetails">
            <span>Department :</span><span>
           @if($npdepartments->id == '') <a style="color:red">Not Allotted</a>  @else {{$npdepartments->name}}  @endif
            </span>
            </div></div>

            <div class="col s12 m6 l3">
            <div class="doctordetails">
            <span>Sub Department :</span><span>@if($nuser_details->department_id == '') <a style="color:red">Not Allotted </a> @else {{$nuser_details->department->name}}   @endif</span>
            </div></div>

            <div class="col s12 m6 l3">
            <div class="doctordetails">
            <span>Counter :</span><span>@if($nuser_details->counter_id == '') <a style="color:red">Not Allotted</a> @else {{$nuser_details->counter->name}}  @endif</span>
            </div></div>

            <div class="col s12 m6 l3">
            </div>

            </div>
           <!------------------------------------->
			<div class="row">

             <!------------------------->
             <div class="col s12 m3 l3 pd_right">
               
               <div class="card hoverable">
               <div class="pripad responsive_info card-content lightblack darken-2 white-text">
 
                  <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Priority Pending</p>
                    <div class="prioritybox"> <ul>
                     <li><span class="plclr">Platinum</span><span class="plclr">{{count($ntoday_queue_platinum)}}<span></li>
                     <li><span class="glclr">Gold</span><span class="glclr">{{count($ntoday_queue_gold)}}<span></li>
                     <li><span class="slclr">Silver</span><span class="slclr">{{count($ntoday_queue_silver)}}<span></li>
                     </ul></div>
 
                  </div>
                         
              </div>
              </div>
 
<!-------------------------> 
            <div class="col s12 m9 l9 pd_right">
            <div class="row">
            <!---------------------->
             <div class="col s6 m6 l3 pd_right" style="display:none;">
              <div class="card hoverable">
                            <div class="responsive_info card-content light-green darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Patient Seen By You <span class="respan">Today</span> </p>
                                <h4 class="card-stats-number">{{ $npatient_seen }}</h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action light-green darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> 
            <!-------------------------> 

            <div class="col s6 m6 l3 pd_left">
              <div class="card hoverable">
                            <div class="responsive_info card-content pink darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Token Scan By You <span class="respan">Today</span></p>
                                <h4 class="card-stats-number">
                                {{count($npatient_called_bydoctor)}}
                               <!-- {{count($today_called_bycounter)}}--->
                                </h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action pink darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> 

            <!------------------------>
                    
            <div class="col s6 m6 l3 pd_right">
               <div class="card hoverable">
                            <div class="responsive_info card-content orange darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Tokens Pending</p>
                                <h4 class="card-stats-number">{{count($ntoday_queue_bycounter)}}</h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action orange darken-4">
                                <div class="center-align">
                                <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> 
            <!--------------------------->
            <div class="col s6 m6 l3 pd_left" style="display:none;">
                        <div class="card hoverable">
                            <div class="responsive_info card-content blue darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Average Time <span class="respan">(with patient)</span></p>
                                <h4 class="card-stats-number">
                               
                               <?php $total_end_time = '0'; $total_start_time = '0'; $total_token = '0'; $total_time_spent_for_patient; $ttpatient ?>
                               @foreach($ndaily_avgtime_of_doctor as $option)
                                @php( $total_end_time += strtotime($option->end_time) )
                                @php( $total_start_time += strtotime($option->start_time))
                               @endforeach
                            
                                <?php 
                               // echo $patient_seen.'<br>';
                               if($patient_seen > 0){
                                $ttpatient = $patient_seen;
                               }else{
                                $ttpatient = 1;
                               }
                                $total_time_spent_for_patient = ($total_end_time-$total_start_time)/$ttpatient;
                                 echo gmdate("H:i:s", $total_time_spent_for_patient).'<sub style="font-size:12px;">&nbsp; Hrs / Patient</sub>'; 
                                ?>
                                </h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action blue darken-4">
                                <div class="center-align">
                                    
                                    <!---------------------------------->
                 <form  action="{{ route('post_doctor_status') }}" method="post">
                            {{ csrf_field() }}
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <button id="mailbtn" style="height:auto; line-height:18px; padding:2px 15px; font-size:13px;" class="btn waves-effect waves-light pink" type="submit" name="user_id" value="{{$user->id}}">mail <i class="mdi-content-send right"></i></button>
                         </form>
                 <!---------------------------------->

                                </div>
                            </div>
                        </div>
                    </div>  
            <!---------------------------->
                    </div></div>
             
            <!------------------------->            
                </div>	
			
			<div class="row">
                <div class="col s12">
				<div class="card-panel doctordashboard">
                    
                    <div class="divider" style="margin:15px 0 10px 0; display:none;"></div>


                    <div class="row">
                <div class="col s12 center">
                <div class="nextbuttoncall">
               <!------------------------------------>
               <form id="new_call" action="{{ route('post_scanner_call') }}" method="post">
                            {{ csrf_field() }}
                            @if(!($user->is_admin)||($user->role=='T'))
                            <input type="hidden" name="user" value="{{ $user->id }}">
                            <input type="hidden" name="pid" value="{{ $user->pid }}">
                            <input type="hidden" name="department" value="{{ $user->department_id }}">
                            <input type="hidden" name="counter" value="{{ $user->counter_id }}">
             <div class="barcodescanbox"> <input id="newbarcodebox" type="text" name="newbarcode" value="" autocomplete="off" placeholder="Scan Barcode Here" autofocus="autofocus" > </div>
                           @endif
                             <div class="row" style="display:none;">
                                <div class="col s12">
                                <button id="newbarcodebox_btn" @if((count($npatient_list_doctorwise) >= 6)||(count($ntoday_queue_bycounter)==0)) disabled="disabled" @endif class="btn waves-effect waves-light pink" type="submit">
                                 SCAN SECOND TOKEN
                             </button>
                                </div>
                            </div>
                        </form>
               <!------------------------------------>
                </div>
                </div>
                </div>
                 

                    <table id="department-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Token</th>
                                <th>Checking Counter</th>
                                <th>Batch Time</th>
                                <th>Priority</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($npatient_list_doctorwise->sortBy('id') as $patient)
                        <!---------------------------------------->   
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{$patient->department->letter}}{{ $patient->nt_number  }}</td>
                                    <td>
                                   @if($patient->checkingCounter=='R') Court Work @elseif($patient->checkingCounter=='P') Pay Fine @else @endif
                                    </td>

                                    <td>
                                 {{$patient->timeslot}}
                                    </td>

									

									<td>
									@if($patient->priority==1) <span class="boxmodi plbox">Plantinum </span>
									@elseif($patient->priority==2) <span class="boxmodi glbox">Gold</span>
									@elseif($patient->priority==3) <span class="boxmodi slbox">Silver</span>
									@elseif($patient->priority==4) <span class="boxmodi nlbox">Normal</span>
									@else
                                     Normal										
									@endif	
									</td>
                                    
                                  
                                  
                                  

                                 </tr>
                         <!------------------>  
                            
                        
                         <!------------------>

                            @endforeach
                        </tbody>
                    </table>
                    
                
                    
                </div>
				</div>
			</div>




 @endif

<!---------------------------------------------------->
		</div>
    </div>
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('assets/js/voice.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/materialize-colorpicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/chartjs/chart.min.js') }}"></script>  
    <script type="text/javascript" src="{{ asset('assets/js/plugins/data-tables/js/jquery.dataTables.min.js') }}"></script>
 
   
    <script>
        $(function() {
            $('#doctor-table').DataTable({
                "oLanguage": {
                    "sLengthMenu": "Show _MENU_",
                    "sSearch": "Search"
                },
                "columnDefs": [{
                    "targets": [ -1 ],
                    "searchable": false,
                    "orderable": false
                }]
            });

            $('#user-table').DataTable({
                "oLanguage": {
                    "sLengthMenu": "Show _MENU_",
                    "sSearch": "Search"
                },
                "columnDefs": [{
                    "targets": [ -1 ],
                    "searchable": false,
                    "orderable": false
                }]
            });


            $('#queue-table').DataTable({
                "oLanguage": {
                    "sLengthMenu": "Show _MENU_",
                    "sSearch": "Search"
                },
                "columnDefs": [{
                    "targets": [ -1 ],
                    "searchable": false,
                    "orderable": false
                }]
            });

            $('#called-table').DataTable({
                "oLanguage": {
                    "sLengthMenu": "Show _MENU_",
                    "sSearch": "Search"
                },
                "columnDefs": [{
                    "targets": [ -1 ],
                    "searchable": false,
                    "orderable": false
                }]
            });




            $('#dp-table').DataTable({
                "oLanguage": {
                    "sLengthMenu": "Show _MENU_",
                    "sSearch": "Search"
                },
                "columnDefs": [{
                    "targets": [ -1 ],
                    "searchable": false,
                    "orderable": false
                }]
            });

            $('#da-table').DataTable({
                "oLanguage": {
                    "sLengthMenu": "Show _MENU_",
                    "sSearch": "Search"
                },
                "columnDefs": [{
                    "targets": [ -1 ],
                    "searchable": false,
                    "orderable": false
                }]
            });


        });
    </script>

    <script>
        /*function nextPatient(){
            var bleep = new Audio();
            bleep.src = '{{ url('assets/sound/sound1.mp3') }}';
            bleep.play();
            window.setTimeout(function() {
         responsiveVoice.speak('Send Next Patient on counter number 2','UK English Female',{rate: 0.85});
        }, 1000); 
        }*/

       /* $(document).ready(function(){
            setInterval( function() { mailSent() }, 1000);
         });
       function mailSent(){
           var ttk="{{$totaloldtoken}}"
           if( ttk > 0){
        $('#autosubmitcall').trigger('click');
               }else{
                   return '';
               }
              }*/
             /* $(document).ready(function(){
$('#newbarcodebox').keyup(function(){
    if(this.value.length == 13){
    $('#newbarcodebox_btn').click();
    }
  });    });*/


        $(function() {
            $('#color').colorpicker();
        });

        @can('access', \App\Models\User::class)
            $("#noti").validate({
                rules: {
                    notification: {
                        required: true,
                        minlength: 5
                    },
                    size: {
                        required: true,
                        digits: true
                    },
                    color: {
                        required: true
                    }
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

           $(function() {
                var todayVsYesterdayCartData = {
                    labels: [@foreach ($counters as $indx => $counter)
                            @if($indx==0) <?php echo "'$counter->name'"; ?>
                            @else <?php echo ", '$counter->name'"; ?>
                            @endif
                        @endforeach],
                    datasets: [
                      {
                          label: "Today",
                          fillColor: "rgba(0,176,159,0.75)",
                          strokeColor: "rgba(220,220,220,0.75)",
                          highlightFill: "rgba(0,176,159,0.9)",
                          highlightStroke: "rgba(220,220,220,9)",
                          data: [@foreach ($today_calls as $indx => $today_call)
                                  @if($indx==0) <?php echo "'$today_call'"; ?>
                                  @else <?php echo ", '$today_call'"; ?>
                                  @endif
                              @endforeach]
                      },
                      {
                          label: "Yesterday",
                          fillColor: "rgba(151,187,205,0.75)",
                          strokeColor: "rgba(220,220,220,0.75)",
                          highlightFill: "rgba(151,187,205,0.9)",
                          highlightStroke: "rgba(220,220,220,0.9)",
                          data: [@foreach ($yesterday_calls as $indx => $yesterday_call)
                                  @if($indx==0) <?php echo "'$yesterday_call'"; ?>
                                  @else <?php echo ", '$yesterday_call'"; ?>
                                  @endif
                              @endforeach]
                      }
                    ]
                };

                var queueDetailsChartData = [
                  {
                      value: "{{ $today_queue }}",
                      color: "#00c0ef",
                      highlight: "#00c0ef",
                      label: "In Queue"
                  },
                  {
                      value: "{{ $missed }}",
                      color: "#00a65a",
                      highlight: "#00a65a",
                      label: "Missed"
                  },
                  {
                      value: "{{ $served }}",
                      color: "#f39c12",
                      highlight: "#f39c12",
                      label: "Served"
                  },
                  {
                      value: "{{ $overtime }}",
                      color: "#dd4b39",
                      highlight: "#dd4b39",
                      label: "Overtime"
                  }
                ];

                var todayVsYesterdayCart = new Chart($("#today-vs-yesterday-chart").get(0).getContext("2d")).Bar(todayVsYesterdayCartData,{
                    responsive:true
                });

                var queueDetailsChart = new Chart($("#queue-details-chart").get(0).getContext("2d")).Pie(queueDetailsChartData,{
                    responsive:true
                });
            });
        @endcan
    </script>
@endsection
