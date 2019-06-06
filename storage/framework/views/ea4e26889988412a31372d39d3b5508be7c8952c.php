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
           <!----------------------------------> 
            
           <!------------------------------------->
			<div class="row">

             <!------------------------->
             <div class="col s12 m3 l3 pd_right">
               
               <div class="card hoverable">
               <div class="pripad responsive_info card-content lightblack darken-2 white-text">
 
                  <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Priority Pending</p>
                    <div class="prioritybox"> <ul>
                     <li><span class="plclr">Platinum</span><span class="plclr"><?php echo e(count($today_queue_platinum)); ?><span></li>
                     <li><span class="glclr">Gold</span><span class="glclr"><?php echo e(count($today_queue_gold)); ?><span></li>
                     <li><span class="slclr">Silver</span><span class="slclr"><?php echo e(count($today_queue_silver)); ?><span></li>
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
                                    
                                    <!---------------------------------->
                 <form  action="<?php echo e(route('post_doctor_status')); ?>" method="post">
                            <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="email" value="<?php echo e($user->email); ?>">
                        <button id="mailbtn" style="height:auto; line-height:18px; padding:2px 15px; font-size:13px;" class="btn waves-effect waves-light pink" type="submit" name="user_id" value="<?php echo e($user->id); ?>">mail <i class="mdi-content-send right"></i></button>
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
                 

                    <table id="department-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Room No.</th>
								<th>Token</th>
                                <th>Priority</th>
                                <th><?php echo e(trans('messages.actions')); ?></th>
                                <th>Patient Called</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $patient_list_doctorwise->sortBy('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <!---------------------------------------->   
                                <tr>
                                    <td <?php if($patient->view_status == 1): ?> class="enabled" <?php else: ?> class="disabled"  <?php endif; ?> ><?php echo e($loop->iteration); ?></td>
                                    <td  <?php if($patient->view_status == 1): ?> class="enabled" <?php else: ?> class="disabled"  <?php endif; ?>><?php echo e($patient->counter->name); ?></td>
									<td  <?php if($patient->view_status == 1): ?> class="enabled" <?php else: ?> class="disabled"  <?php endif; ?>><?php echo e($patient->department->letter); ?><?php echo e($patient->number); ?></td>
									<td  <?php if($patient->view_status == 1): ?> class="enabled" <?php else: ?> class="disabled"  <?php endif; ?>>
									<?php if($patient->priority==1): ?> <span class="boxmodi plbox">Plantinum </span>
									<?php elseif($patient->priority==2): ?> <span class="boxmodi glbox">Gold</span>
									<?php elseif($patient->priority==3): ?> <span class="boxmodi slbox">Silver</span>
									<?php elseif($patient->priority==4): ?> <span class="boxmodi nlbox">Normal</span>
									<?php else: ?>
                                     Normal										
									<?php endif; ?>	
									</td>
                                    <td  <?php if($patient->view_status == 1): ?> class="enabled" <?php else: ?> class="disabled"  <?php endif; ?>>
                                    <?php
                                    if(in_array($patient->view_status, array(1,2))) {
                                        if($patient->doctor_work_start == 0){
                                    ?>
                                         <a class="btn-floating waves-effect waves-light btn blue tooltipped" href="<?php echo e(url('/dashboard/startCounter')); ?>/<?php echo e($patient->id); ?>" data-position="top" data-tooltip="<?php echo e(trans('messages.start_time')); ?>"> <i class="mdi-av-timer"></i></a>

<a style="cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light deep-purple tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="<?php echo e(trans('messages.you_do_first_start')); ?>"> <i class="mdi-action-schedule"></i></a>
                                    <?php
                                        }else if($patient->doctor_work_start == 1){
                                    ?>
                                    <a style="cursor:not-allowed" class="disabled btn-floating waves-effect waves-light btn blue tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="<?php echo e(trans('messages.You_have_started')); ?>"> <i class="mdi-av-timer"></i></a>

<a  class="btn-floating btn waves-effect waves-light deep-purple tooltipped" href="<?php echo e(url('/dashboard/endCounter')); ?>/<?php echo e($patient->id); ?>" data-position="top" data-tooltip="<?php echo e(trans('messages.end_time')); ?>"> <i class="mdi-action-schedule"></i></a>
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
                                  
                                  
                                  <?php if(in_array($patient->view_status, array(1,2))): ?>
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
                                  <!------------->
                                  

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
               <form id="new_call" action="<?php echo e(route('post_scanner_call')); ?>" method="post">
                            <?php echo e(csrf_field()); ?>

                            <?php if(!($user->is_admin)||($user->role=='T')): ?>
                            <input type="hidden" name="user" value="<?php echo e($user->id); ?>">
                            <?php endif; ?>
                          <?php $__currentLoopData = $tokencalledbyscanner; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tscanner): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <input type="hidden" name="pid" value="<?php echo e($tscanner->pid); ?>">
                            <input type="hidden" name="department" value="<?php echo e($tscanner->department_id); ?>">
                            <input type="hidden" name="counter" value="12">
                            <div class="row">
                                <div class="col s12">
                                <button  class="btn waves-effect waves-light pink" type="submit">
                                 
                                 <?php echo e(trans('messages.call.call_next')); ?><i class="mdi-content-send right"></i></i>
                             </button>
                                </div>
                            </div>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?> 
                             
                        </form>
               <!------------------------------------>
                </div>
                </div>
                </div>
                    
                </div>
				</div>
			</div>
			

            
			
<!---------------------------------------------------->
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
        /*function nextPatient(){
            var bleep = new Audio();
            bleep.src = '<?php echo e(url('assets/sound/sound1.mp3')); ?>';
            bleep.play();
            window.setTimeout(function() {
         responsiveVoice.speak('Send Next Patient on counter number 2','UK English Female',{rate: 0.85});
        }, 1000); 
        }*/

        $(document).ready(function(){
            setInterval( function() { mailSent() }, 10000);
         });
       function mailSent(){
           if($patient_seen == 2){
        $('#mailbtn').trigger('click');
               }else{
                   alert('no');
               }
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