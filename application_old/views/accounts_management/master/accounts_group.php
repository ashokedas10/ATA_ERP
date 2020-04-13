<div class="box-header" style="background-color:#3c8dbc" >	   
	   <div class="col-md-6">
	 <?php /*?> <a href="<?php echo $product_addedit.'0/0/'; ?>">
			 <button class="btn btn-success btn-flat margin">New Entry</button>
	 </a><?php */?>
	  </div>
	 
	  <div class="col-md-6">
			<span class="info-box-number style1">ACCOUNTS GROUP</span>
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
			
			$VOUCHER_TYPE='';
			$REF_TABLE='';
			$SHOW_IN_TRIAL_BALANCE=$REF_TABLE_ID='';
				
	
		if(count($records_edit) > 0)
		{
			foreach ($records_edit as $fld) 
			{ 
			/*CHANGE HERE*/					
			$acc_nature=$fld->acc_nature;
			$acc_name=$fld->acc_name;
			$parent_id=$fld->parent_id;
			$acc_type=$fld->acc_type;
			$EDIT_STATUS=$fld->EDIT_STATUS;			
			
			$VOUCHER_TYPE=$fld->VOUCHER_TYPE;
			$SHOW_IN_TRIAL_BALANCE=$fld->SHOW_IN_TRIAL_BALANCE;
			
			/*$REF_TABLE=$fld->REF_TABLE;
			$REF_TABLE_ID=$fld->REF_TABLE_ID;*/
			
			}	
		}
		
?>
 
 
  
<form id="frm" name="frm" method="post" 
action="<?php echo ADMIN_BASE_URL?>accounts_controller/acc_group_master/" >

<input type="hidden" value="<?php echo $this->uri->segment(4); ?>" name="id" id="id">
<input type="hidden" value="<?php echo 'GROUP'; ?>" name="acc_type" id="acc_type">
   
   
  <table class="srstable">
    	
	<tr>
	<td width="140" class="srscell-head-lft">Group Name </td>
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
              <td class="srscell-head-lft">VOUCHER TYPE </td>
              <td class="srscell-body">
			  <select id="VOUCHER_TYPE" name="VOUCHER_TYPE" class="srs-dropdwn">
                  <option value="" <?php if($VOUCHER_TYPE=='') { echo 'selected="selected"'; } ?>>--Select--</option>
                  <option value="SUNDRY_CREDITORS" <?php if($VOUCHER_TYPE=='SUNDRY_CREDITORS') { echo 'selected="selected"'; } ?>>SUNDRY_CREDITORS</option>
                  <option value="SUNDRY_DEBTORS" <?php if($VOUCHER_TYPE=='SUNDRY_DEBTORS') { echo 'selected="selected"'; } ?>>SUNDRY_DEBTORS</option>
				  
                  <option value="BANK_ACCOUNT" <?php if($VOUCHER_TYPE=='BANK_ACCOUNT') { echo 'selected="selected"'; } ?>>BANK_ACCOUNT</option>				  
				   <option value="CASH_ACCOUNT" <?php if($VOUCHER_TYPE=='CASH_ACCOUNT') { echo 'selected="selected"'; } ?>>CASH_ACCOUNT</option>
				   
				     <option value="STOCK_ACCOUNT" <?php if($VOUCHER_TYPE=='STOCK_ACCOUNT') { echo 'selected="selected"'; } ?>>STOCK_ACCOUNT</option>
				   
				   <option value="VATGROUP" <?php if($VOUCHER_TYPE=='VATGROUP') 
				   { echo 'selected="selected"'; } ?>>VAT ACCOUNT</option>
				   
			   <option value="CSTGROUP" <?php if($VOUCHER_TYPE=='CSTGROUP') 
				   { echo 'selected="selected"'; } ?>>CST ACCOUNT</option>
				   
                </select>
              </td>
            </tr>
		
		
		 <tr>
              <td class="srscell-head-lft">SHOW IN TRIAL BALANCE</td>
              <td class="srscell-body">
			  <select id="SHOW_IN_TRIAL_BALANCE" 
			  name="SHOW_IN_TRIAL_BALANCE" class="srs-dropdwn">
                 
                  <option value="GROUP" 
				  <?php if($SHOW_IN_TRIAL_BALANCE=='GROUP') 
				  { echo 'selected="selected"'; } ?>>GROUP
				  </option>
                  
				  <option value="LEDGER" 
				  <?php if($SHOW_IN_TRIAL_BALANCE=='LEDGER') 
				  { echo 'selected="selected"'; } ?>>LEDGER
				  </option>
				  
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
							<th width="37">TABLE-ID </th>
							<th width="121">Group Nature</th>
							<th width="121">Group Name</th>
							<th width="121">Under Position  </th>
							<th width="121">Group Type  </th>
							
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
					<td><?php echo $row->VOUCHER_TYPE; ?></td>
								
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