<?php $__env->startSection('title', trans('messages.mainapp.menu.dashboard')); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(asset('assets/css/materialize-colorpicker.min.css')); ?>" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="<?php echo e(asset('assets/js/plugins/data-tables/css/jquery.dataTables.min.css')); ?>" type="text/css" rel="stylesheet" media="screen,projection">
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem"><?php echo e(trans('messages.mainapp.menu.dashboard')); ?></h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li class="active"><?php echo e(trans('messages.mainapp.menu.dashboard')); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div id="card-stats">
            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('access', \App\Models\User::class)): ?>
                <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content light-blue darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> <?php echo e(trans('messages.today_queue')); ?></p>
                                <h4 class="card-stats-number"><?php echo e($today_queue); ?></h4>
                                </p>
                            </div>
                            <div class="card-action light-blue darken-4">
                                <div class="center-align">
                                    <a href="<?php echo e(route('reports::queue_list', ['date' => \Carbon\Carbon::now()->format('d-m-Y')])); ?>" style="text-transform:none;color:#fff"><?php echo e(trans('messages.more_info')); ?> <i class="mdi-navigation-arrow-forward"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content green lighten-1 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-communication-call-missed"></i> <?php echo e(trans('messages.today_missed')); ?></p>
                                <h4 class="card-stats-number"><?php echo e($missed); ?></h4>
                                </p>
                            </div>
                            <div class="card-action green darken-2">
                                <div class="center-align">
                                    <a href="<?php echo e(route('reports::missed_show', ['date' => \Carbon\Carbon::now()->format('d-m-Y'), 'user' => 'all', 'counter' => 'all', 'type' => 'missed'])); ?>" style="text-transform:none;color:#fff"><?php echo e(trans('messages.more_info')); ?> <i class="mdi-navigation-arrow-forward"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content blue-grey white-text">
                                <p class="card-stats-title truncate"><i class="mdi-action-trending-up"></i> <?php echo e(trans('messages.today_served')); ?></p>
                                <h4 class="card-stats-number"><?php echo e($served); ?></h4>
                                </p>
                            </div>
                            <div class="card-action blue-grey darken-2">
                                <div class="center-align">
                                    <a href="<?php echo e(route('reports::missed_show', ['date' => \Carbon\Carbon::now()->format('d-m-Y'), 'user' => 'all', 'counter' => 'all', 'type' => 'all'])); ?>" style="text-transform:none;color:#fff"><?php echo e(trans('messages.more_info')); ?> <i class="mdi-navigation-arrow-forward"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content orange darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-image-timer"></i> <?php echo e(trans('messages.over_time')); ?></p>
                                <h4 class="card-stats-number"><?php echo e($overtime); ?></h4>
                                </p>
                            </div>
                            <div class="card-action orange darken-4">
                                <div class="center-align">
                                    <a href="<?php echo e(route('reports::missed_show', ['date' => \Carbon\Carbon::now()->format('d-m-Y'), 'user' => 'all', 'counter' => 'all', 'type' => 'overtime'])); ?>" style="text-transform:none;color:#fff"><?php echo e(trans('messages.more_info')); ?> <i class="mdi-navigation-arrow-forward"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('access', \App\Models\User::class)): ?>
                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="card-panel hoverable waves-effect waves-dark teal lighten-3 white-text" style="display:inherit">
                            <span class="chart-title"><?php echo e(trans('messages.queue_details')); ?></span>
                            <div class="trending-line-chart-wrapper">
                                <canvas id="queue-details-chart" height="155" style="height:308px"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l6">
                        <div class="card-panel hoverable waves-effect waves-dark" style="display:inherit">
                            <span class="chart-title"><?php echo e(trans('messages.today_yesterday')); ?></span>
                            <div class="trending-line-chart-wrapper">
                                <canvas id="today-vs-yesterday-chart" height="155" style="height:308px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>


            <?php if($role == 'H'): ?>
			<div class="row">
					<div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content orange darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i>Doctors Active Today</p>
                                <h4 class="card-stats-number"><?php echo e(count($totaldoctor_present)); ?></h4>
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
                                <h4 class="card-stats-number"><?php echo e(count($totaldoctor_absent)); ?></h4>
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
                                <th><?php echo e(trans('messages.name')); ?></th>
                                <th><?php echo e(trans('messages.users.email')); ?></th>
                                <th><?php echo e(trans('messages.users.parent_department')); ?></th>
                                <th><?php echo e(trans('messages.users.department')); ?></th>
                                <th><?php echo e(trans('messages.users.counter')); ?></th>
                                <th><?php echo e(trans('messages.users.role')); ?></th>
                                <th><?php echo e(trans('messages.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tuser): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($tuser->name); ?></td>
                                    <td><?php echo e($tuser->email); ?></td>
                                    <td>
                                    <?php $__currentLoopData = $pardepartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pardepartment): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                    <?php if( $tuser->pid == $pardepartment->id ): ?>
                                    <?php echo e($pardepartment->name); ?> <?php else: ?> <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                    </td>
                                    <td><?php echo e($tuser->department->name); ?></td>
                                    <td><?php echo e($tuser->counter->name); ?></td>
                                    <td><?php echo e($tuser->role_text); ?></td>
                                  <td class="caction">
                                  <?php if($tuser->user_status == 1): ?>
                                  <button class="btn waves-effect waves-light btn-small green">Active</button>
                                  <?php else: ?>
                                  <button class="btn waves-effect waves-light btn-small pink">InActive</button>
                                  <?php endif; ?>
                                 </td>
                                   
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
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
                                <th><?php echo e(trans('messages.name')); ?></th>
                                <th><?php echo e(trans('messages.users.email')); ?></th>
                                <th><?php echo e(trans('messages.users.role')); ?></th>
                                <th><?php echo e(trans('messages.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $staffusers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staffuser): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($staffuser->name); ?></td>
                                    <td><?php echo e($staffuser->email); ?></td>
                                    <td><?php echo e($staffuser->role_text); ?></td>
                                  <td class="caction">
                                  <?php if($staffuser->user_status == 1): ?>
                                  <button class="btn waves-effect waves-light btn-small green">Active</button>
                                  <?php else: ?>
                                  <button class="btn waves-effect waves-light btn-small pink">InActive</button>
                                  <?php endif; ?>
                                 </td>
                                   
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </tbody>
                    </table>
                </div>
               
               </div>


<!-------------------------------------------->

               </div>


            </div>
        </div>
    </div>
			<?php endif; ?>

			
			
			<?php if($role == 'S'): ?>
			<div class="row userdashboard">
            <ul id="tabs-swipe-demo" class="tabs">    
            <li class="tab"> <div class="col s12 m12 l12">
                        <div class="card hoverable">
                            <div class="card-content yellow darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i>Tokens Issued Today</p>
                                <h4 class="card-stats-number"><?php echo e(count($get_all_department_total_queue_in_today)); ?></h4>
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
                                <h4 class="card-stats-number"><?php echo e(count($get_all_department_total_called_in_today)); ?></h4>
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
                                <h4 class="card-stats-number"><?php echo e(count($totaldoctor_present)); ?></h4>
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
                                <h4 class="card-stats-number"><?php echo e(count($totaldoctor_absent)); ?></h4>
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
                                <th><?php echo e(trans('messages.users.parent_department')); ?></th>
                                <th><?php echo e(trans('messages.users.department')); ?></th>
                                <th><?php echo e(trans('messages.users.token_number')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $get_all_department_total_queue_in_today; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $q): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <tr>
                           <td><?php echo e($loop->iteration); ?></td>
                           <td><?php $__currentLoopData = $pardepartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pardepartment): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                    <?php if( $q->department->pid == $pardepartment->id ): ?>
                                    <?php echo e($pardepartment->name); ?> <?php else: ?> <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?></td>
                           <td><?php echo e($q->department->name); ?></td>
                           <td><?php echo e($q->department->letter); ?>-<?php echo e($q->number); ?></td>
                           </tr>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>    
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
                                <th><?php echo e(trans('messages.users.parent_department')); ?></th>
                                <th><?php echo e(trans('messages.users.department')); ?></th>
                                <th><?php echo e(trans('messages.users.token_number')); ?></th>
                                <th><?php echo e(trans('messages.users.room_number')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $get_all_department_total_called_in_today; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                           <tr>
                           <td><?php echo e($loop->iteration); ?></td>
                           <td><?php $__currentLoopData = $pardepartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pardepartment): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                    <?php if( $c->department->pid == $pardepartment->id ): ?>
                                    <?php echo e($pardepartment->name); ?> <?php else: ?> <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?></td>
                           <td><?php echo e($c->department->name); ?></td>
                           <td><?php echo e($c->department->letter); ?>-<?php echo e($c->number); ?></td>
                           <td>
                           <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uc): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                           <?php if( $c->department->id == $uc->department_id ): ?>
                           <?php echo e($uc->counter->name); ?>

                           <?php endif; ?>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                           </td>
                           </tr> 
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?> 
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
                                <th><?php echo e(trans('messages.name')); ?></th>
                                <th><?php echo e(trans('messages.users.email')); ?></th>
                                <th><?php echo e(trans('messages.users.parent_department')); ?></th>
                                <th><?php echo e(trans('messages.users.department')); ?></th>
                                <th><?php echo e(trans('messages.users.counter')); ?></th>
                                <th><?php echo e(trans('messages.users.role')); ?></th>
                                <th><?php echo e(trans('messages.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tuser): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <?php if($tuser->user_status == 1): ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($tuser->name); ?></td>
                                    <td><?php echo e($tuser->email); ?></td>
                                    <td>
                                    <?php $__currentLoopData = $pardepartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pardepartment): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                    <?php if( $tuser->pid == $pardepartment->id ): ?>
                                    <?php echo e($pardepartment->name); ?> <?php else: ?> <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                    </td>
                                    <td><?php echo e($tuser->department->name); ?></td>
                                    <td><?php echo e($tuser->counter->name); ?></td>
                                    <td><?php echo e($tuser->role_text); ?></td>
                                  <td class="caction">
                                <button class="btn waves-effect waves-light btn-small green">Active</button>
                                  </td>
                                    </tr>
                                    
                                  <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
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
                                <th><?php echo e(trans('messages.name')); ?></th>
                                <th><?php echo e(trans('messages.users.email')); ?></th>
                                <th><?php echo e(trans('messages.users.parent_department')); ?></th>
                                <th><?php echo e(trans('messages.users.department')); ?></th>
                                <th><?php echo e(trans('messages.users.counter')); ?></th>
                                <th><?php echo e(trans('messages.users.role')); ?></th>
                                <th><?php echo e(trans('messages.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tuser): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <?php if($tuser->user_status == 2): ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($tuser->name); ?></td>
                                    <td><?php echo e($tuser->email); ?></td>
                                    <td>
                                    <?php $__currentLoopData = $pardepartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pardepartment): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                    <?php if( $tuser->pid == $pardepartment->id ): ?>
                                    <?php echo e($pardepartment->name); ?> <?php else: ?> <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                    </td>
                                    <td><?php echo e($tuser->department->name); ?></td>
                                    <td><?php echo e($tuser->counter->name); ?></td>
                                    <td><?php echo e($tuser->role_text); ?></td>
                                  <td class="caction">
                                  <button class="btn waves-effect waves-light btn-small pink">InActive</button>
                                 </td>
                                </tr>
                               
                                <?php endif; ?> 
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </tbody>
                    </table>
                </div> </div>
      </div>

      </div>            
                    
      <!------------------------------->              
                </div>	
			<?php endif; ?>
			
			<?php if($role == 'D'): ?>
           <!----------------------------------> 
            <div class="row">

            <div class="col s12 m6 l3">
            <div class="doctordetails">
            <span>Department :</span><span>
           <?php if($pdepartments->id == ''): ?> <a style="color:red">Not Allotted</a>  <?php else: ?> <?php echo e($pdepartments->name); ?>  <?php endif; ?>
            </span>
            </div></div>

            <div class="col s12 m6 l3">
            <div class="doctordetails">
            <span>Sub Department :</span><span><?php if($user_details->department_id == ''): ?> <a style="color:red">Not Allotted </a> <?php else: ?> <?php echo e($user_details->department->name); ?>   <?php endif; ?></span>
            </div></div>

            <div class="col s12 m6 l3">
            <div class="doctordetails">
            <span>Room No. :</span><span><?php if($user_details->counter_id == ''): ?> <a style="color:red">Not Allotted</a> <?php else: ?> <?php echo e($user_details->counter->name); ?>  <?php endif; ?></span>
            </div></div>

            <div class="col s12 m6 l3">
            </div>

            </div>
           <!------------------------------------->
			<div class="row">
            <!---------------------->
             <div class="col s6 m6 l3 pd_right">
              <div class="card hoverable">
                            <div class="responsive_info card-content light-green darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Patient Seen By You <span class="respan">Today</span> </p>
                                <h4 class="card-stats-number"><?php echo e($patient_seen); ?></h4>
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
                                <?php echo e(count($patient_called_bydoctor)); ?>

                               <!-- <?php echo e(count($today_called_bycounter)); ?>--->
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
                                <h4 class="card-stats-number"><?php echo e(count($today_queue_bycounter)); ?></h4>
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
                               <?php $__currentLoopData = $daily_avgtime_of_doctor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <?php ( $total_end_time += strtotime($option->end_time) ); ?>
                                <?php ( $total_start_time += strtotime($option->start_time)); ?>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                            
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
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>         
            <!------------------------->            
                </div>	
			<?php endif; ?>
			
			<?php if($role == 'D'): ?>
			<div class="row">
                <div class="col s12">
				<div class="card-panel doctordashboard">
                    
                    <div class="divider" style="margin:15px 0 10px 0; display:none;"></div>
                    <table id="department-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Room No.</th>
								<th>Token</th>
                                <th><?php echo e(trans('messages.actions')); ?></th>
                                <th>Patient Called</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $patient_list_doctorwise->sortBy('number'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <!---------------------------------------->   
                                <tr>
                                    <td <?php if($patient->view_status == 1): ?> class="enabled" <?php else: ?> class="disabled"  <?php endif; ?> ><?php echo e($loop->iteration); ?></td>
                                    <td  <?php if($patient->view_status == 1): ?> class="enabled" <?php else: ?> class="disabled"  <?php endif; ?>><?php echo e($patient->counter->name); ?></td>
									<td  <?php if($patient->view_status == 1): ?> class="enabled" <?php else: ?> class="disabled"  <?php endif; ?>><?php echo e($patient->department->letter); ?>-<?php echo e($patient->number); ?></td>
                                    <td  <?php if($patient->view_status == 1): ?> class="enabled" <?php else: ?> class="disabled"  <?php endif; ?>>
                                    <?php if($patient->view_status == 1): ?>      
                                    <?php if($patient->doctor_work_start == 0): ?>
										<?php if($patient->doctor_work_start == 0): ?>
                                 <a class="btn-floating waves-effect waves-light btn blue tooltipped" href="<?php echo e(url('/dashboard/startCounter')); ?>/<?php echo e($patient->id); ?>" data-position="top" data-tooltip="<?php echo e(trans('messages.start_time')); ?>"> <i class="mdi-av-timer"></i></a>

                             <a style="cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light deep-purple tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="<?php echo e(trans('messages.you_do_first_start')); ?>"> <i class="mdi-action-schedule"></i></a>
										<?php endif; ?>
										
										<?php if($patient->doctor_work_start == 1): ?>
                             <a style="cursor:not-allowed" class="disabled btn-floating waves-effect waves-light btn blue tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="<?php echo e(trans('messages.You_have_started')); ?>"> <i class="mdi-av-timer"></i></a>

                         <a  class="btn-floating btn waves-effect waves-light deep-purple tooltipped" href="<?php echo e(url('/dashboard/endCounter')); ?>/<?php echo e($patient->id); ?>" data-position="top" data-tooltip="<?php echo e(trans('messages.end_time')); ?>"> <i class="mdi-action-schedule"></i></a>
										<?php endif; ?>

                                    
                                    <?php else: ?>

                                     <a style="cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light deep-purple tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="<?php echo e(trans('messages.you_do_first_start')); ?>"> <i class="mdi-action-schedule"></i></a>

                                     <a class="btn-floating btn waves-effect waves-light deep-purple tooltipped" href="<?php echo e(url('/dashboard/endCounter')); ?>/<?php echo e($patient->id); ?>" data-position="top" data-tooltip="<?php echo e(trans('messages.end_time')); ?>"> <i class="mdi-action-schedule"></i></a>
                                     
                                     <?php endif; ?>
                                <!----------------------->
                                     <?php else: ?> 
                                     <a style="cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light deep-purple tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Press ON to display Patient Token Number"> <i class="mdi-action-schedule"></i></a>

                                     <a style="cursor:not-allowed" class="disabled btn-floating waves-effect waves-light btn blue tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Press ON to display Patient Token Number"> <i class="mdi-av-timer"></i></a>
                                     
                                     <?php endif; ?> 

                                    </td>
                                  
                                  
                                  <?php if($patient->view_status == 1): ?>
                                  <td>
                                  <?php if($patient->doctor_work_start == 1): ?>     
                                  <a style="font-size:10px cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light green tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Not Allowed">ON</a>
                                  <?php else: ?>
                                
                                 <a style="font-size:10px" class="btn-floating btn waves-effect waves-light green tooltipped" href="<?php echo e(url('/dashboard/PatientStatus')); ?>/<?php echo e($patient->id); ?>" data-position="top" data-tooltip="Press to turn OFF ??">ON</a>

                                 <?php endif; ?>
                                 </td>
                                  
                                 <!--------->
                                  <?php else: ?>
                                  <td>       
                                  <a style="font-size:10px" class="btn-floating btn waves-effect waves-light red tooltipped" href="<?php echo e(url('/dashboard/PatientStatus')); ?>/<?php echo e($patient->id); ?>" data-position="top" data-tooltip="Press to turn ON ??">OFF</a>
                                 </td>

                                  <?php endif; ?>

                                 </tr>
                         <!------------------>  
                            
                        
                         <!------------------>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </tbody>
                    </table>
                    
                <div class="row">
                <div class="col s12 center">
                <div class="nextbuttoncall">
               <!------------------------------------>
               <form id="new_call" action="<?php echo e(route('post_doctor_call')); ?>" method="post">
                            <?php echo e(csrf_field()); ?>

                            <?php if(!($user->is_admin)||($user->role=='D')): ?>
                            <input type="hidden" name="user" value="<?php echo e($user->id); ?>">
                            <input type="hidden" name="pid" value="<?php echo e($user->pid); ?>">
                            <input type="hidden" name="department" value="<?php echo e($user->department_id); ?>">
                            <input type="hidden" name="counter" value="<?php echo e($user->counter_id); ?>">
                           <?php endif; ?>
                             <div class="row">
                                <div class="col s12">
                                    <button <?php if(count($patient_list_doctorwise) >= 3): ?> disabled="disabled" <?php endif; ?> class="btn waves-effect waves-light pink" type="submit">
                                        <?php echo e(trans('messages.call.call_next')); ?><i class="mdi-content-send right"></i></i>
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
			<?php endif; ?>

            
			<?php if($role == 'A'): ?>
            <div class="row">
                <div class="col s12">
                    <div class="card hoverable waves-effect waves-dark" style="display:inherit">
                        <div class="card-move-up black-text">
                            <div class="move-up">
                                <div>
                                    <span class="chart-title"><?php echo e(trans('messages.dashboard.notification')); ?></span>
                                </div>
                                <div class="trending-line-chart-wrapper">
                                    <p><?php echo e(trans('messages.dashboard.preview')); ?>:</p>
                                    <span style="font-size:<?php echo e($setting->size); ?>px;color:<?php echo e($setting->color); ?>">
                                        <marquee><?php echo e($setting->notification); ?></marquee>
                                    </span>
                                    <p></p>
                                    <form id="noti" action="<?php echo e(route('dashboard_store')); ?>" method="post">
                                        <?php echo e(csrf_field()); ?>

                                        <div class="row">
                                            <div class="input-field col s12 m8">
                                                <label for="notification"><?php echo e(trans('messages.dashboard.notification_text')); ?></label>
                                                <input id="notification" name="notification" type="text" placeholder="<?php echo e(trans('messages.dashboard.notification_placeholder')); ?>" data-error=".errorNotification" value="<?php echo e($setting->notification); ?>">
                                                <div class="errorNotification"></div>
                                            </div>
                                            <div class="input-field col s12 m1">
                                                <label for="size"><?php echo e(trans('messages.font_size')); ?></label>
                                                <input id="size" name="size" type="number" placeholder="Size" max="60" min="15" size="2" data-error=".errorSize" value="<?php echo e($setting->size); ?>">
                                                <div class="errorSize"></div>
                                            </div>
                                            <div class="input-field col s12 m2">
                                                <label for="color"><?php echo e(trans('messages.color')); ?></label>
                                                <input id="color" type="text" placeholder="Color" name="color" data-error=".errorColor" value="<?php echo e($setting->color); ?>">
                                                <div class="errorColor"></div>
                                            </div>
                                            <div class="input-field col s12 m1">
                                                <button class="btn waves-effect waves-light right submit" type="submit" style="padding:0 1.3rem"><?php echo e(trans('messages.go')); ?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<?php endif; ?>
		</div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script type="text/javascript" src="<?php echo e(asset('assets/js/voice.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/materialize-colorpicker.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/chartjs/chart.min.js')); ?>"></script>  
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/data-tables/js/jquery.dataTables.min.js')); ?>"></script>
 
   
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
        function nextPatient(){
            var bleep = new Audio();
            bleep.src = '<?php echo e(url('assets/sound/sound1.mp3')); ?>';
            bleep.play();
            window.setTimeout(function() {
         responsiveVoice.speak('Send Next Patient on counter number 2','UK English Female',{rate: 0.85});
        }, 1000); 
        }

        $(function() {
            $('#color').colorpicker();
        });

        <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('access', \App\Models\User::class)): ?>
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
                    labels: [<?php $__currentLoopData = $counters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indx => $counter): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <?php if($indx==0): ?> <?php echo "'$counter->name'"; ?>
                            <?php else: ?> <?php echo ", '$counter->name'"; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>],
                    datasets: [
                      {
                          label: "Today",
                          fillColor: "rgba(0,176,159,0.75)",
                          strokeColor: "rgba(220,220,220,0.75)",
                          highlightFill: "rgba(0,176,159,0.9)",
                          highlightStroke: "rgba(220,220,220,9)",
                          data: [<?php $__currentLoopData = $today_calls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indx => $today_call): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                  <?php if($indx==0): ?> <?php echo "'$today_call'"; ?>
                                  <?php else: ?> <?php echo ", '$today_call'"; ?>
                                  <?php endif; ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>]
                      },
                      {
                          label: "Yesterday",
                          fillColor: "rgba(151,187,205,0.75)",
                          strokeColor: "rgba(220,220,220,0.75)",
                          highlightFill: "rgba(151,187,205,0.9)",
                          highlightStroke: "rgba(220,220,220,0.9)",
                          data: [<?php $__currentLoopData = $yesterday_calls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indx => $yesterday_call): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                  <?php if($indx==0): ?> <?php echo "'$yesterday_call'"; ?>
                                  <?php else: ?> <?php echo ", '$yesterday_call'"; ?>
                                  <?php endif; ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>]
                      }
                    ]
                };

                var queueDetailsChartData = [
                  {
                      value: "<?php echo e($today_queue); ?>",
                      color: "#00c0ef",
                      highlight: "#00c0ef",
                      label: "In Queue"
                  },
                  {
                      value: "<?php echo e($missed); ?>",
                      color: "#00a65a",
                      highlight: "#00a65a",
                      label: "Missed"
                  },
                  {
                      value: "<?php echo e($served); ?>",
                      color: "#f39c12",
                      highlight: "#f39c12",
                      label: "Served"
                  },
                  {
                      value: "<?php echo e($overtime); ?>",
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
        <?php endif; ?>
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>