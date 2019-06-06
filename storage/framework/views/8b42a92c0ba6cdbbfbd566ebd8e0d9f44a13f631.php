<?php $__env->startSection('title', trans('messages.mainapp.menu.call')); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(asset('assets/js/plugins/data-tables/css/jquery.dataTables.min.css')); ?>" type="text/css" rel="stylesheet" media="screen,projection">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem"><?php echo e(trans('messages.mainapp.menu.missedprint')); ?></h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(trans('messages.mainapp.menu.dashboard')); ?></a></li>
                        <li class="active"><?php echo e(trans('messages.mainapp.menu.missedprint')); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            
            <div class="col s12 m12">
                <div class="card">
                    <div class="card-content" style="font-size:14px">
                        <span class="card-title" style="line-height:0;font-size:22px"><?php echo e(trans('messages.call.todays_queue')); ?></span>
                        <div class="divider" style="margin:15px 0 10px 0; display:none;"></div>
                    <table id="token_detail" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Token</th>
                                <th>Sub Department</th>
                                <th>New Token Number</th>
                                <th>Token Number</th>
                                <th>Called</th>
                                <th>Priority</th>
                                <th><?php echo e(trans('messages.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $tokenreprint; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tokendetail): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <tr style="background:<?php if($tokendetail->nt_number==null){ echo '#b0d8f5'; }else{ echo '#f6bac8' ;} ?>">
                           <td> <?php echo e($loop->iteration); ?> </td>
                           <td><?php echo e($tokendetail->number); ?></td>
                           <td><?php echo e($tokendetail->department->name); ?></td>
                           <td><?php if($tokendetail->nt_number==null): ?> No New <?php else: ?> <?php echo e($tokendetail->nt_number); ?> <?php endif; ?></td>
                           <td>
                            <?php if($tokendetail->nt_number==null): ?> First Token <?php else: ?> Second Token <?php endif; ?>

                           </td>
                           <td>
                            <?php if($tokendetail->called==0): ?> NO <?php else: ?> YES <?php endif; ?>

                           </td>
                           <td>
                            <?php if($tokendetail->priority==1): ?> <span style="font-size:10px; text-transform:uppercase; padding:4px 10px; line-height:inherit; height:auto; width:50px; text-align:center;" class="plbox">Platinum</span> 
                            <?php elseif($tokendetail->priority==2): ?> <span style="font-size:10px; text-transform:uppercase; padding:4px 10px; line-height:inherit; height:auto; width:50px; text-align:center;" class="glbox">Gold</span>
                            <?php elseif($tokendetail->priority==3): ?> <span style="font-size:10px; text-transform:uppercase; padding:4px 10px; line-height:inherit; height:auto; width:50px; text-align:center;" class="slbox">Silver</span> 
                            <?php elseif($tokendetail->priority==4): ?> <span style="font-size:10px; text-transform:uppercase; padding:4px 10px; line-height:inherit; height:auto; width:50px; text-align:center;" class="nlbox">Normal</span> 
                            <?php else: ?> <span style="font-size:10px; text-transform:uppercase; padding:4px 10px; line-height:inherit; height:auto; width:50px; text-align:center;" class="nlbox">Normal</span>   
                            <?php endif; ?>  
                         

                           </td>
                           <td>
                           <a style="font-size:10px; margin:0px 4px; padding:5px 10px; line-height:inherit; height:auto;" href="<?php echo e(url('/calls/rePrintToken')); ?>/<?php echo e($tokendetail->id); ?>" class="waves-effect waves-light btn green" >Re-print Token</a>

                      <!--------------------->
      <!------popup-start---------->     
     <div id="modal1_<?php echo e($tokendetail->id); ?>" class="modal">
    <div class="modal-content">
    <div class="customform">
     <h4><?php echo e($tokendetail->department->name); ?></h4>
     <form id="dep_isuuetkn_<?php echo e($tokendetail->id); ?>" name="getValueform_<?php echo e($tokendetail->id); ?>" action="/" method="GET">
         <input type="hidden" class="id_<?php echo e($tokendetail->id); ?>" value="<?php echo e($tokendetail->id); ?>" name="id" >
         <input type="hidden" class="department_id_<?php echo e($tokendetail->id); ?>" value="<?php echo e($tokendetail->department_id); ?>" name="department_id" >
    <div class = "row">
    <div class="input-field col s12">      
      <label>Enter UHID :</label>
       <input class="uhid_<?php echo e($tokendetail->id); ?>" name="uhid" type="text" placeholder="UHID" value="<?php echo e($tokendetail->uhid); ?>" autocomplete="off" onkeyup="getPrioroty(this.value, <?php echo e($tokendetail->id); ?>);" />          
    </div>
               
         <div class="col s12">
         <ul>
         <li style="font-size:0.8rem">Priority : <span id="uhidlbl_<?php echo e($tokendetail->id); ?>"></span></li>
         </ul>
          </div>      
       
       </div>
       </form>
       <div class="modal-footer">
         <ul>
        
<li><a href="javascript:void(0)" class="modal-close waves-light btn red csfloat">Cancel</a></li>
<li class="reloadclick">  <button class="btn waves-effect waves-light csfloat" onclick="call_dept(<?php echo e($tokendetail->id); ?>); this.style.visibility='hidden'; this.disable=true;" style="text-transform:none"><?php echo e(trans('messages.call.token_issue')); ?><i class="mdi-navigation-arrow-forward right"></i>
</button></li>
</ul>
   </div>
                      
        </div>
       
    </div>
   
  </div> 

                      <!---------------------->
                           </td>
                            </tr>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                         </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('print'); ?>
    <?php if(session()->has('department_name')): ?>
        <style>#printarea{display:none;text-align:left}@media  print{#loader-wrapper,header,#main,footer,#toast-container{display:none}#printarea{display:block;}}@page{margin:0}</style>
<div id="printarea" style="background:#f2f2f2; -webkit-print-color-adjust:exact; font-family: 'Open Sans', sans-serif; line-height:1.2;  position:relative;">
          <!------------------>     
         <!------------------>     
         <?php if(session()->get('uhid') != ''): ?>
			<span style="position:absolute; top:0px; right:0px; font-size:10px; color:black;">
               <?php if(session()->get('priority') == '1'): ?> P 
               <?php elseif(session()->get('priority') == '2'): ?> G
               <?php elseif(session()->get('priority') == '3'): ?> S 
               <?php elseif(session()->get('priority') == '4'): ?> N 
               <?php else: ?> N  <?php endif; ?>
             </span><?php else: ?>  <?php endif; ?>
 <!----------------------------->
 <table style="width:100%; border:none; margin:0px; padding:0px; font-size:12px;">

   <tr><td colspan="2" style="text-align:center">
   <h1 style="display:inline-table; margin:0px;">
   <span style="display:block; text-transform:uppercase; font-size:18px;"><?php echo e(str_limit( $company_name)); ?></span></h1></td></tr>

   <tr><td width="100%" colspan="2" style="text-align:center; padding:5px 0;"><span style="display:block; font-weight:800; border:2px dotted #000; color:#000; padding:5px 2px; font-size:25px;"><strong style="font-size:25px; display:block;">टोकन संख्या</strong>
   <?php echo e(session()->get('number')); ?></span>
</td></tr>

<?php if(session()->get('uhid') != ''): ?>
   <tr> <td style="padding:4px; border:1px solid #555;">UID No. (यूआईडी संख्या) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #555;"><?php echo e(session()->get('uhid')); ?></td> </tr>
   <?php else: ?>  <?php endif; ?>

  
<tr> <td style="padding:4px; border:1px solid #555;">VISITORS IN QUEUE <br>(कुल व्यक्ति प्रतीक्षा कर रहे हैं)  <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #555;"><?php echo e(session()->get('total')); ?></td> </tr>

<?php if(session()->get('timeslot') != ''): ?>
<tr> <td style="padding:4px; border:1px solid #555;">BATCH TIME <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #555;"><?php echo e(session()->get('timeslot')); ?></td> </tr>
<?php else: ?>  <?php endif; ?>

<tr> <td style="padding:4px; border:1px solid #555;">DATE (दिनांक) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #555;"><?php echo e(\Carbon\Carbon::now()->format('d-m-Y')); ?></td> </tr>

<tr> <td style="padding:4px; border:1px solid #555;">TIME (समय) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #555;"><?php echo e(\Carbon\Carbon::now()->format('h:i:s A')); ?></td> </tr>

<tr> <td style="padding:4px; border:1px solid #555;">Token slip created by <br>(टोकन पर्ची किसके द्वारा बनाई गई है) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #555;">Self (KIOSK)</td> </tr>

<tr> <td colspan="2" style="padding:4px; border:1px solid #555;">Please wait for your Lift Token on TV Display (कृपया प्रदर्शन पर अपना लिफ्ट टोकन जांचें)</td> </tr>

<tr><td colspan="2" style="text-align:center; font-size:8px; padding:0 0 10px 0"><p style="margin:0px; padding:0px">Powered by <strong>ASADELTECH<sup>&reg;</sup><strong></p></td></tr>

 </table>
 
<div style="transform:rotate(90deg); padding:60px 0;">
<img id="ean-5">
</div>

        <!--------------------->
        </div>
		<?php if(session()->get('printFlag')): ?>
			<script>
				window.onload = function(){window.print();}
			</script>
		<?php endif; ?>	
        
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    

    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/data-tables/js/jquery.dataTables.min.js')); ?>"></script>
    <script src='https://cdn.jsdelivr.net/jsbarcode/3.3.20/JsBarcode.all.min.js'></script>
    <script>
    
    //-------------------------------
       
 //--------------------------
    

    //---------------------------
    function call_dept(value) {
            var id = $('.id_'+value).val();
            var department_id = $('.department_id_'+value).val();
			var uhid = $('.uhid_'+value).val();
			//alert(uhid +'--'+ department_id + '---' + id); return false;
			var myForm1 = '<form id="hidfrm1" action="<?php echo e(url('calls/newtoken')); ?>/'+value+'" method="post"><?php echo e(csrf_field()); ?>'+
            '<input type="text" name="id" value="'+ id +'">'+
            '<input type="text" name="department_id" value="'+ department_id +'">'+
  '<input type="text" name="uhid" value="'+ uhid +'">'+'</form>';
            $('body').append(myForm1);
			
            myForm1 = $('#hidfrm1');
            myForm1.submit();
            //-------------------
        }
     
		$('body').on('change', '#pid', function(){
			var options = "<option value=''>Select Parent Department</option>";
			if($(this).val() == ''){
				$('#department').html(options);
			}
			var data = 'pid='+$(this).val()+'&_token=<?php echo e(csrf_token()); ?>';
            $.ajax({
                type:"POST",
                url:"<?php echo e(route('post_pdept')); ?>",
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
  

    //--------------------------------------------

            $('#token_detail').DataTable({
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": true,
               "bInfo": false,
               "bAutoWidth": false
                
            });    

        //--------------------------------------
var timer = '';
		function getPrioroty(val, id)
		{  
			clearTimeout(timer);
			timer = setTimeout(function() {
					var data = 'uid='+val+'&_token=<?php echo e(csrf_token()); ?>';
					$.ajax({
						type:"POST",
						url:"<?php echo e(route('post_uhid')); ?>",
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
   
        JsBarcode("#ean-5", "<?php echo e(session()->get('newbarcode')); ?>");
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>