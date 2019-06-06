@extends('layouts.app')

@section('title', trans('messages.mainapp.menu.users'))

@section('css')
    <link href="{{ asset('assets/js/plugins/data-tables/css/jquery.dataTables.min.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
@endsection

@section('content')
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem">{{ trans('messages.mainapp.menu.users') }}</h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="{{ route('dashboard') }}">{{ trans('messages.mainapp.menu.dashboard') }}</a></li>
                        <li class="active">{{ trans('messages.mainapp.menu.users') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card-panel" style="float:left;width:100%;">
                
         <div class="queuetokenbox">  
		 @if($user->role=='A') 
                    <a style="float:left" class="btn-floating waves-effect waves-light tooltipped" href="{{ route('users.create') }}" data-position="top" data-tooltip="{{ trans('messages.add') }} {{ trans('messages.mainapp.menu.users') }}"><i class="mdi-content-add left"></i></a>
          @endif          
    
       <ul id="tabs-swipe-demo" class="tabs">    
    <li class="tab"><a class="active" href="#tabname_doctor">1st Document Checker</a></li>
    <li class="tab"><a href="#tabname_generator">2nd T. Generator</a></li>
    <li class="tab"><a href="#tabname_scanner">2nd T. Scanner</a></li>
    <li class="tab"><a href="#tabname_courtwork">Court Work</a></li>
    <li class="tab"><a href="#tabname_payfine">Pay Fine</a></li>
    <li class="tab" style="display:none !important;"><a href="#tabname_user">User</a></li>
    <li class="tab" style="display:none !important;"><a href="#tabname_help">Help Desk</a></li>
    <li class="tab" style="display:none !important;"><a href="#tabname_admin">Admin</a></li>
    <li class="tab" style="display:none !important;"><a href="#tabname_cmo">CMO</a></li>
    <li class="tab"><a href="#tabname_displayctrl">Display C.</a></li>
  </ul>

  <div id="tabname_doctor" class="col s12">
  <table id="doctor-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.username') }}</th>
                                <th>{{ trans('messages.users.email') }}</th>
                                <th>{{ trans('messages.users.parent_department') }}</th>
                                <th>{{ trans('messages.users.counter') }}</th>
                                <th>{{ trans('messages.users.attendance') }}</th>
                                <th>{{ trans('messages.users.role') }}</th>
                                <th style="width:63px">{{ trans('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userdoctordetails as $userdoctordetail)

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $userdoctordetail->name }}</td>
                                    <td>{{ $userdoctordetail->username }}</td>
                                    <td>{{ $userdoctordetail->email }}</td>
                                <td> @if($userdoctordetail->department_id == '') <span style='color:red'>Not Allotted <span> @else{{ $userdoctordetail->department->name }} @endif</td>
                                    <td>
                                    <?php
                                    if(!empty($userdoctordetail->counter_id))
                                    {
                                        echo  $userdoctordetail->counter->name;
                                    ?>
									@if($user->role=='A')
                                    <span class='changeroom'><a href="settings/assignroom/<?php echo $userdoctordetail->id; ?>">Change Room</a>
								   @endif
                                    <?php
                                    }else{
                                    ?>
									@if($user->role=='A')
                                        <span class='allottedroom'>Not Allowted <a href="settings/assignroom/<?php echo $userdoctordetail->id; ?>">Allowted Room</a></span>
									@endif
                                    <?php

                                    }
                                    ?>
                                    </td>
                                    <td class="caction">@if($userdoctordetail->user_status == 1) <a href="users/updateStatus/<?php echo $userdoctordetail->id; ?>"><button class="btn waves-effect waves-light btn-small green">Active</button></a> @else <a href="users/updateStatus/<?php echo $userdoctordetail->id; ?>"><button class="btn waves-effect waves-light btn-small pink">InActive</button></a> @endif</td>

                                    <td>{{ $userdoctordetail->role_text }}</td>
                                    @if($userdoctordetail->id==$user->id)
                                        <td>
                                            <a class="btn-floating btn-action waves-effect waves-light orange disabled" href="javascript:void(0);"><i class="mdi-communication-vpn-key"></i></a>
                                            <a class="btn-floating btn-action waves-effect waves-light red disabled" href="javascript:void(0);"><i class="mdi-action-delete"></i></a>
                                        </td>
                                    @else
                                        <td>
                                            <a class="btn-floating btn-action waves-effect waves-light orange tooltipped" href="{{ route('get_user_password', ['userdoctordetails' => $userdoctordetail->id]) }}" data-position="top" data-tooltip="{{ trans('messages.change') }} {{ trans('messages.users.password') }}"><i class="mdi-communication-vpn-key"></i></a>
                                            <a class="btn-floating btn-action waves-effect waves-light red tooltipped frmsubmit" href="{{ route('users.destroy', ['userdoctordetails' => $userdoctordetail->id]) }}" data-position="top" data-tooltip="{{ trans('messages.delete') }}" method="DELETE"><i class="mdi-action-delete"></i></a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
  
  </div>
<!--------------------------------------------------->
<div id="tabname_generator" class="col s12"> <table id="generator-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.username') }}</th>
                                <th>{{ trans('messages.users.email') }}</th>
                                <th>{{ trans('messages.users.attendance') }}</th>
                                <th>{{ trans('messages.users.role') }}</th>
                                <th style="width:63px">{{ trans('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($getusergeneratordetails as $getgenerator)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $getgenerator->name }}</td>
                                    <td>{{ $getgenerator->username }}</td>
                                    <td>{{ $getgenerator->email }}</td>
                                    <td>@if($getgenerator->user_status == 1) Active @else Inactive @endif</td>
                                    <td>{{ $getgenerator->role_text }}</td>
                                    @if($getgenerator->id==$user->id)
                                        <td>
                                            <a class="btn-floating btn-action waves-effect waves-light orange disabled" href="javascript:void(0);"><i class="mdi-communication-vpn-key"></i></a>
                                            <a class="btn-floating btn-action waves-effect waves-light red disabled" href="javascript:void(0);"><i class="mdi-action-delete"></i></a>
                                        </td>
                                    @else
                                        <td>
                                            <a class="btn-floating btn-action waves-effect waves-light orange tooltipped" href="{{ route('get_user_password', ['getusergeneratordetails' => $getgenerator->id]) }}" data-position="top" data-tooltip="{{ trans('messages.change') }} {{ trans('messages.users.password') }}"><i class="mdi-communication-vpn-key"></i></a>
                                            <a class="btn-floating btn-action waves-effect waves-light red tooltipped frmsubmit" href="{{ route('users.destroy', ['getusergeneratordetails' => $getgenerator->id]) }}" data-position="top" data-tooltip="{{ trans('messages.delete') }}" method="DELETE"><i class="mdi-action-delete"></i></a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table> </div>

 

<!------------------------------------------------------>

<div id="tabname_scanner" class="col s12">
  <table id="scanner-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
 
                            <th style="width:40px">#</th>
                                <th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.username') }}</th>
                                <th>{{ trans('messages.users.email') }}</th>
                                <th>{{ trans('messages.users.parent_department') }}</th>
                                <th>{{ trans('messages.users.counter') }}</th>
                                <th>{{ trans('messages.users.attendance') }}</th>
                                <th>{{ trans('messages.users.role') }}</th>
                                <th style="width:63px">{{ trans('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($userscannerdetails as $userdoctordetail)

<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $userdoctordetail->name }}</td>
    <td>{{ $userdoctordetail->username }}</td>
    <td>{{ $userdoctordetail->email }}</td>
<td> @if($userdoctordetail->department_id == '') <span style='color:red'>Not Allotted <span> @else{{ $userdoctordetail->department->name }} @endif</td>
    <td>
    <?php
    if(!empty($userdoctordetail->counter_id))
    {
        echo  $userdoctordetail->counter->name;
    ?>
    @if($user->role=='A')
    <span class='changeroom'><a href="settings/assignroom/<?php echo $userdoctordetail->id; ?>">Change Room</a>
   @endif
    <?php
    }else{
    ?>
    @if($user->role=='A')
        <span class='allottedroom'>Not Allowted <a href="settings/assignroom/<?php echo $userdoctordetail->id; ?>">Allowted Room</a></span>
    @endif
    <?php

    }
    ?>
    </td>
    <td class="caction">@if($userdoctordetail->user_status == 1) <a href="users/updateStatus/<?php echo $userdoctordetail->id; ?>"><button class="btn waves-effect waves-light btn-small green">Active</button></a> @else <a href="users/updateStatus/<?php echo $userdoctordetail->id; ?>"><button class="btn waves-effect waves-light btn-small pink">InActive</button></a> @endif</td>

    <td>{{ $userdoctordetail->role_text }}</td>
    @if($userdoctordetail->id==$user->id)
        <td>
            <a class="btn-floating btn-action waves-effect waves-light orange disabled" href="javascript:void(0);"><i class="mdi-communication-vpn-key"></i></a>
            <a class="btn-floating btn-action waves-effect waves-light red disabled" href="javascript:void(0);"><i class="mdi-action-delete"></i></a>
        </td>
    @else
        <td>
            <a class="btn-floating btn-action waves-effect waves-light orange tooltipped" href="{{ route('get_user_password', ['userdoctordetails' => $userdoctordetail->id]) }}" data-position="top" data-tooltip="{{ trans('messages.change') }} {{ trans('messages.users.password') }}"><i class="mdi-communication-vpn-key"></i></a>
            <a class="btn-floating btn-action waves-effect waves-light red tooltipped frmsubmit" href="{{ route('users.destroy', ['userdoctordetails' => $userdoctordetail->id]) }}" data-position="top" data-tooltip="{{ trans('messages.delete') }}" method="DELETE"><i class="mdi-action-delete"></i></a>
        </td>
    @endif
</tr>
@endforeach
                        </tbody>
                    </table>
  
  </div>

<!---------------------------------------------------->

<!--------------------------------------------------->

<div id="tabname_courtwork" class="col s12">
  <table id="courtwork-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
 
                            <th style="width:40px">#</th>
                                <th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.username') }}</th>
                                <th>{{ trans('messages.users.email') }}</th>
                                <th>{{ trans('messages.users.parent_department') }}</th>
                                <th>{{ trans('messages.users.counter') }}</th>
                                <th>{{ trans('messages.users.attendance') }}</th>
                                <th>{{ trans('messages.users.role') }}</th>
                                <th style="width:63px">{{ trans('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($usercourtworkdetails as $userdoctordetail)

<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $userdoctordetail->name }}</td>
    <td>{{ $userdoctordetail->username }}</td>
    <td>{{ $userdoctordetail->email }}</td>
<td> @if($userdoctordetail->department_id == '') <span style='color:red'>Not Allotted <span> @else{{ $userdoctordetail->department->name }} @endif</td>
    <td>
    <?php
    if(!empty($userdoctordetail->counter_id))
    {
        echo  $userdoctordetail->counter->name;
    ?>
    @if($user->role=='A')
    <span class='changeroom'><a href="settings/assignroom/<?php echo $userdoctordetail->id; ?>">Change Room</a>
   @endif
    <?php
    }else{
    ?>
    @if($user->role=='A')
        <span class='allottedroom'>Not Allowted <a href="settings/assignroom/<?php echo $userdoctordetail->id; ?>">Allowted Room</a></span>
    @endif
    <?php

    }
    ?>
    </td>
    <td class="caction">@if($userdoctordetail->user_status == 1) <a href="users/updateStatus/<?php echo $userdoctordetail->id; ?>"><button class="btn waves-effect waves-light btn-small green">Active</button></a> @else <a href="users/updateStatus/<?php echo $userdoctordetail->id; ?>"><button class="btn waves-effect waves-light btn-small pink">InActive</button></a> @endif</td>

    <td>{{ $userdoctordetail->role_text }}</td>
    @if($userdoctordetail->id==$user->id)
        <td>
            <a class="btn-floating btn-action waves-effect waves-light orange disabled" href="javascript:void(0);"><i class="mdi-communication-vpn-key"></i></a>
            <a class="btn-floating btn-action waves-effect waves-light red disabled" href="javascript:void(0);"><i class="mdi-action-delete"></i></a>
        </td>
    @else
        <td>
            <a class="btn-floating btn-action waves-effect waves-light orange tooltipped" href="{{ route('get_user_password', ['userdoctordetails' => $userdoctordetail->id]) }}" data-position="top" data-tooltip="{{ trans('messages.change') }} {{ trans('messages.users.password') }}"><i class="mdi-communication-vpn-key"></i></a>
            <a class="btn-floating btn-action waves-effect waves-light red tooltipped frmsubmit" href="{{ route('users.destroy', ['userdoctordetails' => $userdoctordetail->id]) }}" data-position="top" data-tooltip="{{ trans('messages.delete') }}" method="DELETE"><i class="mdi-action-delete"></i></a>
        </td>
    @endif
</tr>
@endforeach
                        </tbody>
                    </table>
  
  </div>

<!---------------------------------------------------->
<!--------------------------------------------------->

<div id="tabname_payfine" class="col s12">
  <table id="payfine-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
 
                            <th style="width:40px">#</th>
                                <th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.username') }}</th>
                                <th>{{ trans('messages.users.email') }}</th>
                                <th>{{ trans('messages.users.parent_department') }}</th>
                                <th>{{ trans('messages.users.counter') }}</th>
                                <th>{{ trans('messages.users.attendance') }}</th>
                                <th>{{ trans('messages.users.role') }}</th>
                                <th style="width:63px">{{ trans('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($userpayfinedetails as $userdoctordetail)

<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $userdoctordetail->name }}</td>
    <td>{{ $userdoctordetail->username }}</td>
    <td>{{ $userdoctordetail->email }}</td>
<td> @if($userdoctordetail->department_id == '') <span style='color:red'>Not Allotted <span> @else{{ $userdoctordetail->department->name }} @endif</td>
    <td>
    <?php
    if(!empty($userdoctordetail->counter_id))
    {
        echo  $userdoctordetail->counter->name;
    ?>
    @if($user->role=='A')
    <span class='changeroom'><a href="settings/assignroom/<?php echo $userdoctordetail->id; ?>">Change Room</a>
   @endif
    <?php
    }else{
    ?>
    @if($user->role=='A')
        <span class='allottedroom'>Not Allowted <a href="settings/assignroom/<?php echo $userdoctordetail->id; ?>">Allowted Room</a></span>
    @endif
    <?php

    }
    ?>
    </td>
    <td class="caction">@if($userdoctordetail->user_status == 1) <a href="users/updateStatus/<?php echo $userdoctordetail->id; ?>"><button class="btn waves-effect waves-light btn-small green">Active</button></a> @else <a href="users/updateStatus/<?php echo $userdoctordetail->id; ?>"><button class="btn waves-effect waves-light btn-small pink">InActive</button></a> @endif</td>

    <td>{{ $userdoctordetail->role_text }}</td>
    @if($userdoctordetail->id==$user->id)
        <td>
            <a class="btn-floating btn-action waves-effect waves-light orange disabled" href="javascript:void(0);"><i class="mdi-communication-vpn-key"></i></a>
            <a class="btn-floating btn-action waves-effect waves-light red disabled" href="javascript:void(0);"><i class="mdi-action-delete"></i></a>
        </td>
    @else
        <td>
            <a class="btn-floating btn-action waves-effect waves-light orange tooltipped" href="{{ route('get_user_password', ['userdoctordetails' => $userdoctordetail->id]) }}" data-position="top" data-tooltip="{{ trans('messages.change') }} {{ trans('messages.users.password') }}"><i class="mdi-communication-vpn-key"></i></a>
            <a class="btn-floating btn-action waves-effect waves-light red tooltipped frmsubmit" href="{{ route('users.destroy', ['userdoctordetails' => $userdoctordetail->id]) }}" data-position="top" data-tooltip="{{ trans('messages.delete') }}" method="DELETE"><i class="mdi-action-delete"></i></a>
        </td>
    @endif
</tr>
@endforeach
                        </tbody>
                    </table>
  
  </div>

<!---------------------------------------------------->

  <div id="tabname_user" class="col s12"> <table id="user-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.username') }}</th>
                                <th>{{ trans('messages.users.email') }}</th>
                                <th>{{ trans('messages.users.attendance') }}</th>
                                <th>{{ trans('messages.users.role') }}</th>
                                <th style="width:63px">{{ trans('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($getalluserdetails as $getalluserdetail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $getalluserdetail->name }}</td>
                                    <td>{{ $getalluserdetail->username }}</td>
                                    <td>{{ $getalluserdetail->email }}</td>
                                    <td>@if($getalluserdetail->user_status == 1) Active @else Inactive @endif</td>
                                    <td>{{ $getalluserdetail->role_text }}</td>
                                    @if($getalluserdetail->id==$user->id)
                                        <td>
                                            <a class="btn-floating btn-action waves-effect waves-light orange disabled" href="javascript:void(0);"><i class="mdi-communication-vpn-key"></i></a>
                                            <a class="btn-floating btn-action waves-effect waves-light red disabled" href="javascript:void(0);"><i class="mdi-action-delete"></i></a>
                                        </td>
                                    @else
                                        <td>
                                            <a class="btn-floating btn-action waves-effect waves-light orange tooltipped" href="{{ route('get_user_password', ['getalluserdetails' => $getalluserdetail->id]) }}" data-position="top" data-tooltip="{{ trans('messages.change') }} {{ trans('messages.users.password') }}"><i class="mdi-communication-vpn-key"></i></a>
                                            <a class="btn-floating btn-action waves-effect waves-light red tooltipped frmsubmit" href="{{ route('users.destroy', ['getalluserdetails' => $getalluserdetail->id]) }}" data-position="top" data-tooltip="{{ trans('messages.delete') }}" method="DELETE"><i class="mdi-action-delete"></i></a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table> </div>

  <div id="tabname_help" class="col s12"> <table id="help-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.username') }}</th>
                                <th>{{ trans('messages.users.email') }}</th>
                                <th>{{ trans('messages.users.attendance') }}</th>
                                <th>{{ trans('messages.users.role') }}</th>
                                <th style="width:63px">{{ trans('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gethepdeskdetails as $gethepdeskdetail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $gethepdeskdetail->name }}</td>
                                    <td>{{ $gethepdeskdetail->username }}</td>
                                    <td>{{ $gethepdeskdetail->email }}</td>
                                    <td>@if($gethepdeskdetail->user_status == 1) Active @else Inactive @endif</td>
                                    <td>{{ $gethepdeskdetail->role_text }}</td>
                                    @if($gethepdeskdetail->id==$user->id)
                                        <td>
                                            <a class="btn-floating btn-action waves-effect waves-light orange disabled" href="javascript:void(0);"><i class="mdi-communication-vpn-key"></i></a>
                                            <a class="btn-floating btn-action waves-effect waves-light red disabled" href="javascript:void(0);"><i class="mdi-action-delete"></i></a>
                                        </td>
                                    @else
                                        <td>
                                            <a class="btn-floating btn-action waves-effect waves-light orange tooltipped" href="{{ route('get_user_password', ['gethepdeskdetails' => $gethepdeskdetail->id]) }}" data-position="top" data-tooltip="{{ trans('messages.change') }} {{ trans('messages.users.password') }}"><i class="mdi-communication-vpn-key"></i></a>
                                            <a class="btn-floating btn-action waves-effect waves-light red tooltipped frmsubmit" href="{{ route('users.destroy', ['gethepdeskdetails' => $gethepdeskdetail->id]) }}" data-position="top" data-tooltip="{{ trans('messages.delete') }}" method="DELETE"><i class="mdi-action-delete"></i></a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table> </div>

      <div id="tabname_admin" class="col s12"> <table id="admin-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.username') }}</th>
                                <th>{{ trans('messages.users.email') }}</th>
                                <th>{{ trans('messages.users.attendance') }}</th>
                                <th>{{ trans('messages.users.role') }}</th>
                                <th style="width:63px">{{ trans('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($getadmindetails as $getadmindetail)
                                <tr{!! ($getadmindetail->id==$getadmindetail->id)?' class="orange lighten-4"':'' !!}>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $getadmindetail->name }}</td>
                                    <td>{{ $getadmindetail->username }}</td>
                                    <td>{{ $getadmindetail->email }}</td>
                                    <td>@if($getadmindetail->user_status == 1) Active @else Inactive @endif</td>
                                    <td>{{ $getadmindetail->role_text }}</td>
                                    @if($getadmindetail->id==$user->id)
                                        <td>
                                            <a class="btn-floating btn-action waves-effect waves-light orange disabled" href="javascript:void(0);"><i class="mdi-communication-vpn-key"></i></a>
                                            <a class="btn-floating btn-action waves-effect waves-light red disabled" href="javascript:void(0);"><i class="mdi-action-delete"></i></a>
                                        </td>
                                    @else
                                        <td>
                                        <a class="btn-floating btn-action waves-effect waves-light orange disabled" href="javascript:void(0);"><i class="mdi-communication-vpn-key"></i></a>
                                        <a class="btn-floating btn-action waves-effect waves-light red disabled" href="javascript:void(0);"><i class="mdi-action-delete"></i></a>

                                           <!-- <a  class="btn-floating btn-action waves-effect waves-light orange tooltipped disabled" href="{{ route('get_user_password', ['getadmindetails' => $getadmindetail->id]) }}" data-position="top" data-tooltip="{{ trans('messages.change') }} {{ trans('messages.users.password') }}"><i class="mdi-communication-vpn-key"></i></a>
                                            <a class="btn-floating btn-action waves-effect waves-light red tooltipped frmsubmit disabled" href="{{ route('users.destroy', ['getadmindetails' => $getadmindetail->id]) }}" data-position="top" data-tooltip="{{ trans('messages.delete') }}" method="DELETE"><i class="mdi-action-delete"></i></a>-->
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table> </div> 

       <!------------------------------------------------------>
       <div id="tabname_cmo" class="col s12"> <table id="cmo-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.username') }}</th>
                                <th>{{ trans('messages.users.email') }}</th>
                                <th>{{ trans('messages.users.attendance') }}</th>
                                <th>{{ trans('messages.users.role') }}</th>
                                <th style="width:63px">{{ trans('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($getcmodetails as $getcmodetail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $getcmodetail->name }}</td>
                                    <td>{{ $getcmodetail->username }}</td>
                                    <td>{{ $getcmodetail->email }}</td>
                                    <td>@if($getcmodetail->user_status == 1) Active @else Inactive @endif</td>
                                    <td>{{ $getcmodetail->role_text }}</td>
                                    @if($getcmodetail->id==$user->id)
                                        <td>
                                            <a class="btn-floating btn-action waves-effect waves-light orange disabled" href="javascript:void(0);"><i class="mdi-communication-vpn-key"></i></a>
                                            <a class="btn-floating btn-action waves-effect waves-light red disabled" href="javascript:void(0);"><i class="mdi-action-delete"></i></a>
                                        </td>
                                    @else
                                        <td>
                                            <a class="btn-floating btn-action waves-effect waves-light orange tooltipped" href="{{ route('get_user_password', ['getcmodetails' => $getcmodetail->id]) }}" data-position="top" data-tooltip="{{ trans('messages.change') }} {{ trans('messages.users.password') }}"><i class="mdi-communication-vpn-key"></i></a>
                                            <a class="btn-floating btn-action waves-effect waves-light red tooltipped frmsubmit" href="{{ route('users.destroy', ['getcmodetails' => $getcmodetail->id]) }}" data-position="top" data-tooltip="{{ trans('messages.delete') }}" method="DELETE"><i class="mdi-action-delete"></i></a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table> </div>

                    <div id="tabname_displayctrl" class="col s12"> <table id="displayctrl-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.username') }}</th>
                                <th>{{ trans('messages.users.email') }}</th>
                                <th>{{ trans('messages.users.attendance') }}</th>
                                <th>{{ trans('messages.users.role') }}</th>
                                <th style="width:63px">{{ trans('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($getdisplayctrldetails as $getdisplayctrldetail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $getdisplayctrldetail->name }}</td>
                                    <td>{{ $getdisplayctrldetail->username }}</td>
                                    <td>{{ $getdisplayctrldetail->email }}</td>
                                    <td>@if($getdisplayctrldetail->user_status == 1) Active @else Inactive @endif</td>
                                    <td>{{ $getdisplayctrldetail->role_text }}</td>
                                    @if($getdisplayctrldetail->id==$user->id)
                                        <td>
                                            <a class="btn-floating btn-action waves-effect waves-light orange disabled" href="javascript:void(0);"><i class="mdi-communication-vpn-key"></i></a>
                                            <a class="btn-floating btn-action waves-effect waves-light red disabled" href="javascript:void(0);"><i class="mdi-action-delete"></i></a>
                                        </td>
                                    @else
                                        <td>
                                            <a class="btn-floating btn-action waves-effect waves-light orange tooltipped" href="{{ route('get_user_password', ['getdisplayctrldetails' => $getdisplayctrldetail->id]) }}" data-position="top" data-tooltip="{{ trans('messages.change') }} {{ trans('messages.users.password') }}"><i class="mdi-communication-vpn-key"></i></a>
                                            <a class="btn-floating btn-action waves-effect waves-light red tooltipped frmsubmit" href="{{ route('users.destroy', ['getdisplayctrldetails' => $getdisplayctrldetail->id]) }}" data-position="top" data-tooltip="{{ trans('messages.delete') }}" method="DELETE"><i class="mdi-action-delete"></i></a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table> </div>

       <!------------------------------------------------------>                                              


                   
                   

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/plugins/data-tables/js/jquery.dataTables.min.js') }}"></script>
    <script>
        $(function() {
            $('#user-table, #doctor-table, #help-table, #admin-table, #cmo-table, #displayctrl-table, #scanner-table, #courtwork-table, #payfine-table, #generator-table').DataTable({
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
@endsection
