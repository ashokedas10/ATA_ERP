<form id="frm" name="frm" method="post" action="<?php echo $tran_link;?>" >
<div class="panel panel-primary"  style="background-color:#E67753">
 <div class="panel-footer">
 
 
 
<?php if($REPORT_NAME=='TRIAL_BALANCE' || $REPORT_NAME=='PROFIT_LOSS_ACCOUNT' || $REPORT_NAME=='BALANCE_SHEET' ){ ?> 
<div class="panel panel-primary" >
		<div class="panel-body" align="center" style="background-color:#3c8dbc">
				
		<div class="form-row">
					
			<div class="form-group col-md-3">
				<label for="inputState">To Date</label>
				<input type="text"  id="fromdate" name="fromdate" value="<?php echo $fromdate; ?>" class="form-control"  > 				
			</div>
								
			<div class="form-group col-md-3">
				<label for="inputState">From Date</label>
				<input type="text"  id="todate" name="todate" value="<?php echo $todate; ?>" class="form-control"  > 				
			</div>
		
			<div class="form-group col-md-2">
					<button type="submit" class="btn btn-success" name="Save" >Display</button>		
			</div>							
						
				</div>
		</div>
	</div> 
<?php } ?>





<?php if($REPORT_NAME=='PTOP_ACCOUNTS' ){ ?> 
<div class="panel panel-primary" >
		<div class="panel-body" align="center" style="background-color:#3c8dbc">
				
				<div class="form-row">
					
			<div class="form-group col-md-4">
			  <label for="inputState">Select Requisition</label>
			 <select id="param1" class="form-control select2"  name="param1">
					  <option value="0">Select </option>
						  <?php							
							foreach ($ledger_accounts as $row){ 						
							?>
						  <option value="<?php echo $row->id; ?>" 
							<?php if($row->id==$param1) 
							{ echo 'selected="selected"'; } ?>> 
							<?php echo $row->req_number; ?> </option>
						  <?php } ?>
				</select>
			</div>
					
			<?php /*?><div class="form-group col-md-3">
				<label for="inputState">To Date</label>
				<input type="text"  id="fromdate" name="fromdate" value="<?php echo $fromdate; ?>" class="form-control"  > 				
			</div>
								
			<div class="form-group col-md-3">
				<label for="inputState">From Date</label>
				<input type="text"  id="todate" name="todate" value="<?php echo $todate; ?>" class="form-control"  > 				
			</div><?php */?>
		
			<div class="form-group col-md-2">
					<button type="submit" class="btn btn-success" name="Save" >Display</button>		
			</div>							
						
				</div>
		</div>
	</div> 
<?php } ?>

<?php if($REPORT_NAME=='OTOC_REPORT' ){ ?> 
<div class="panel panel-primary" >
		<div class="panel-body" align="center" style="background-color:#3c8dbc">
				
				<div class="form-row">
					
			<div class="form-group col-md-4">
			  <label for="inputState">Select Requisition</label>
			 <select id="param1" class="form-control select2"  name="param1">
					  <option value="0">Select </option>
						  <?php							
							foreach ($ledger_accounts as $row){ 						
							?>
						  <option value="<?php echo $row->id; ?>" 
							<?php if($row->id==$param1) 
							{ echo 'selected="selected"'; } ?>> 
							<?php echo $row->req_number; ?> </option>
						  <?php } ?>
				</select>
			</div>
					
			<?php /*?><div class="form-group col-md-3">
				<label for="inputState">To Date</label>
				<input type="text"  id="fromdate" name="fromdate" value="<?php echo $fromdate; ?>" class="form-control"  > 				
			</div>
								
			<div class="form-group col-md-3">
				<label for="inputState">From Date</label>
				<input type="text"  id="todate" name="todate" value="<?php echo $todate; ?>" class="form-control"  > 				
			</div><?php */?>
		
			<div class="form-group col-md-2">
					<button type="submit" class="btn btn-success" name="Save" >Display</button>		
			</div>							
						
				</div>
		</div>
	</div> 
<?php } ?>




</div></div>
</form>