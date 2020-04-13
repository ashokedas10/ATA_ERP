<div class="box-header" style="background-color:#3c8dbc" >	   
	   <div class="col-md-6">
	  <a href="<?php echo $product_addedit.'0/0/'; ?>">
			 <button class="btn btn-success btn-flat margin">New Entry</button>
	 </a>
	  </div>
	 
	  <div class="col-md-6">
			<span class="info-box-number style1">ACCOUNTS LEDGER MANAGE</span>
 	 </div>
</div>
<div class="box-header with-border">
	<?php if($this->session->userdata('alert_msg')<>''){ ?>
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" 
		aria-hidden="true">&times;</button>
		<h4><i class="icon fa fa-check"></i>
		<?php echo $this->session->userdata('alert_msg'); ?></h4>
		</div>
	<?php } ?>
</div>

<div class="box box-info">

<?php 
		
	/*CHANGE HERE*/
	
			$acc_nature='';
			$acc_name='';
			$parent_id='';
			$acc_type='';
			$EDIT_STATUS='';
			$TRAN_TYPE='';	
			$TRAN_TYPE=$OB_AMT='';	
			$default_value=$OB_DATE='';	
			$acc_code='';
			$status='';
				
	
		if(count($records_edit) > 0)
		{
			foreach ($records_edit as $fld) 
			{ 
			/*CHANGE HERE*/
			$acc_code=$fld->acc_code;
			$status=$fld->status;
								
			$acc_nature=$fld->acc_nature;
			$acc_name=$fld->acc_name;
			$parent_id=$fld->parent_id;
			$acc_type=$fld->acc_type;
			$EDIT_STATUS=$fld->EDIT_STATUS;
			$TRAN_TYPE=$fld->TRAN_TYPE;	
			$OB_AMT=$fld->OB_AMT;	
			$OB_DATE=$fld->OB_DATE;	
			$default_value=$fld->default_value;		
			}	
		}
		
?>

 
  
<form id="frm" name="frm" method="post" 
action="<?php echo ADMIN_BASE_URL?>accounts_controller/acc_ledger_master/" >

<input type="hidden" value="<?php echo $this->uri->segment(4); ?>" name="id" id="id">
<input type="hidden" value="<?php echo 'LEDGER'; ?>" name="acc_type" id="acc_type">
   
   
  <table class="srstable">
    
		
	<tr>
	<td width="140" class="srscell-head-lft">Ledger Code </td>
	<td width="274" class="srscell-body"><input  class="srs-txt" 
			name="acc_code" id="acc_code"  value="<?PHP echo $acc_code;?>" /></td>
	</tr>
	
	<tr>
	<td width="140" class="srscell-head-lft">Ledger Name </td>
	<td width="274" class="srscell-body"><input  class="srs-txt" 
			name="acc_name" id="acc_name"  value="<?PHP echo $acc_name;?>" /></td>
	</tr>
				
	
	<tr>
	<td class="srscell-head-lft">Under Account Group </td>
	<td class="srscell-body">
	<select id="parent_id" data-rel="chosen" name="parent_id">
               
                <?php 
					
					foreach ($parent_records as $row1)
					{ 						
					?>
					<option value="<?php echo $row1->id; ?>" 
					<?php if($row1->id==$parent_id) 
					{ echo 'selected="selected"'; } ?>>
					<?php echo $row1->acc_name; ?>
					</option>
			  
			  	 <?php } ?>
        </select></td>
	</tr>
	
	<tr>
	<td width="140" class="srscell-head-lft">Default Value</td>
	<td width="274" class="srscell-body"><input  class="srs-txt" 
			name="default_value" id="default_value"  
			value="<?PHP echo $default_value;?>" /></td>
	</tr>
	
	
	<tr>
              <td class="srscell-head-lft">OB TYPE</td>
              <td class="srscell-body">		
			  
			  <select id="TRAN_TYPE" name="TRAN_TYPE" class="srs-dropdwn">
              
			   <option value="CR" <?php if($TRAN_TYPE=='CR') 
			   { echo 'selected="selected"'; } ?>>CR</option>
			   
			 	<option value="DR" <?php if($TRAN_TYPE=='DR') 
			   { echo 'selected="selected"'; } ?>>DR</option>
			  
               </select>
						  
              </td>
    </tr>
	
	
	
	<tr>
	<td width="140" class="srscell-head-lft">OB AMT</td>
	<td width="274" class="srscell-body"><input  class="srs-txt" 
			name="OB_AMT" id="OB_AMT"  value="<?PHP echo $OB_AMT;?>" /></td>
	</tr>
	
	<tr>
	<td width="103" class="srscell-head-lft">OB Date</td>
	<td class="srscell-body"  colspan="3">
	 <input type="text" id="OB_DATE" class="srs-txt"
		  value="<?php  if($OB_DATE=='') 
	  { echo date('Y-m-d');} else { echo $OB_DATE; } ?>" name="OB_DATE" />
	 <img src="<?php echo BASE_PATH_ADMIN;?>theme_files/calender_final/images2/cal.gif" 
		onclick="javascript:NewCssCal ('OB_DATE','yyyyMMdd')" 	style="cursor:pointer"/>

	</td>
	</tr>
	
	<tr>
              <td class="srscell-head-lft">STATUS</td>
              <td class="srscell-body">		
			  
			  <select id="status" name="status" class="srs-dropdwn">
              
			   <option value="ACTIVE" <?php if($status=='ACTIVE') 
			   { echo 'selected="selected"'; } ?>>ACTIVE</option>
			   
			 	<option value="INACTIVE" <?php if($status=='INACTIVE') 
			   { echo 'selected="selected"'; } ?>>IN-ACTIVE</option>
			  
               </select>
						  
              </td>
    </tr>
	
	
			
		<tr class="alt1">
             <td valign="top" align="center" colspan="2" class="srscell-body"> 
		<input type="submit" class="srs-btn-submit" 
		value="Save" id="Save" name="Save"> 
			  </td>
            </tr>
	</table>
  
</form>

</div>


<table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="37">SysID# </th>
							<th width="121">Group Nature</th>
							<th width="121">Ledger Name</th>
							<th width="121">Under Group  </th>
							<th width="121">Status</th>
							<th width="58">Action</th>
							
						</tr>
					</thead>
					
					<tbody>
					<?php
					if(count($records) > 0){
					$i = 1;
					foreach ($records as $row){
						$alt = ($i%2==0)?'alt1':'alt2';
					?>
					
						<tr class="<?php if($i%2==0) { echo ' even gradeX'; } 
						else {  echo ' odd gradeC'; } ?> ">
							<td><?php echo $row->id; ?></td>
							<td><?php echo $row->acc_nature; ?></td>
							<td><?php echo $row->acc_name; ?></td>
							<td>
							<?php 
							$sql="select * from acc_group_ledgers where id=".$row->parent_id;
							$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
							foreach ($rowrecord as $row1)
							{echo $row1->acc_name;}
							?>
					</td>	
					<td><?php echo $row->status; ?></td>
									
						<td class="center"> 
						 <a href="<?php echo $product_addedit.$row->id; ?>">
						 <input type="submit" class="srs-btn-submit" value="Edit" 
							id="Save" name="Save"></a>
						</td>
					
					</tr>
				
				
				<?php 
				$i++;	
				}
				}
				?>		
				
					</tbody>
				</table>