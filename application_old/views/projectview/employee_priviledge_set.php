<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://rawgit.com/RobinHerbots/Inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>

<script language="javascript" type="text/javascript">
		
	function loadUrl(newLocation)
	{
	//alert(newLocation);
	window.location = newLocation;
	return false;
	}
</script>


<style type="text/css">
<!--
.style2 {
	color: #990000;
	font-weight: bold;
	font-size:18px;
}
-->
</style>

<div class="panel panel-primary" >	
    <div class="panel-body" align="center" style="background-color:#999999">  	
	  <span class="blink_me style2">Employee Priviledge Set </span> <br>
	  <span class="style1"><?php echo $this->session->userdata('alert_msg'); ?></span></div>
</div>


<form id="frm" name="frm" method="post" action="<?php echo ADMIN_BASE_URL?>Project_controller/Employee_priviledge_set/<?php echo $tbl_employee_mstr_id; ?>/save/" >

<input type="hidden" id="tbl_employee_mstr_id" name="tbl_employee_mstr_id" value="<?php echo $tbl_employee_mstr_id; ?>"  />


   <div class="panel-body" align="center">
   
   <div class="panel panel-primary" >	
    
		<div class="form-row" > 
		  <div class="col-sm-4" style="background-color:#FF9966">Main Menu </div>
		  <div class="col-sm-4" style="background-color:#FF9966">Sub Menu</div>
		  <div class="col-sm-4" style="background-color:#FF9966">Operation</div>
		</div>	 
	</div>
						
	<?php
	
	
	foreach ($records as $key=>$record )
	{ 						
		$OPERATION='VIEW';
		$whr=" tbl_employee_mstr_id=".$tbl_employee_mstr_id." and menu_details_id=".$record->id;
		$OPERATION=$this->projectmodel->GetSingleVal('OPERATION','menu_user_priviledge',$whr);	
		
		$whr=" id=".$record->parent_id;
		$name_group=$this->projectmodel->GetSingleVal('name','software_architecture_details',$whr);			
	
	?>		
	 	<div class="row" >   		           			    
			  <div class="col-sm-4"><?php echo $name_group; ?></div>
			  <div class="col-sm-4"><?php echo $record->name; ?></div>
			  <div class="col-sm-4">
			  
			  <input type="hidden" id="menu_details_id<?php echo $key;?>" name="menu_details_id<?php echo $key;?>" value="<?php echo $record->id;?>"  />
			  <select id="OPERATION<?php echo $key;?>" name="OPERATION<?php echo $key;?>" class="form-control">
				
				<option  value="CAN_NOT_OPEN" <?php if($OPERATION=='CAN_NOT_OPEN') { echo 'selected="selected"'; } ?>>CAN_NOT_OPEN</option>
				<option  value="VIEW" <?php if($OPERATION=='VIEW') { echo 'selected="selected"'; } ?>>VIEW</option>
				<option  value="ADD_EDIT" <?php if($OPERATION=='ADD_EDIT') { echo 'selected="selected"'; } ?>>ADD_EDIT</option>
				<option  value="ADD_EDIT_DELETE" <?php if($OPERATION=='ADD_EDIT_DELETE') { echo 'selected="selected"'; } ?>>ADD_EDIT_DELETE</option>
				</select>
												
			  </div>
		 
	 </div>
	 <br />
	<?php } ?>
		<div class="form-row">   
		 
		<button type="submit" class="btn btn-primary" name="submit">Submit</button>
		
		</div>
	</div>
  
</form>


