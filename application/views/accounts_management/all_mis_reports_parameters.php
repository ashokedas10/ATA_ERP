<form id="frm" name="frm" method="post" action="<?php echo $tran_link;?>" >
<div class="panel panel-primary"  style="background-color:#E67753">
 <div class="panel-footer">
 <div class="panel panel-primary" >
			<div class="panel-body" align="center" style="background-color:#999999">
 


<?php if($REPORT_NAME=='PRODUCT_TRANSACTIONS' ){ ?> 

	<div class="form-row">
												
					<div class="form-group col-md-4">
					  <label for="inputState">Select Account</label>
					 <select id="param1" class="form-control select2"  name="param1">
							  <option value="0">Select Product</option>
								  <?php
									
									foreach ($ledger_accounts as $row){ 						
									?>
								  <option value="<?php echo $row->id; ?>" 
									<?php if($row->id==$param1) 
									{ echo 'selected="selected"'; } ?>> 
									<?php echo $row->brand_name; ?> </option>
								  <?php } ?>
						</select>
					</div>
					<div class="form-group col-md-3">
						<label for="inputState">Type</label>
						<select id="param2" class="form-control select2"  name="param2">
							  <option value="SELL">SALE</option>
							   <option value="PURCHASE">PURCHASE</option>
						</select>			
					</div>
					
					<div class="form-group col-md-2">
							<button type="submit" class="btn btn-primary" name="Save" >Display</button>		
					</div>							
							
		</div>
					
<?php } ?>		


<?php if($REPORT_NAME=='BILL_WISE_SALE' || $REPORT_NAME=='BILL_WISE_PURCHASE' || $REPORT_NAME=='HSN_WISE_SALE' || $REPORT_NAME=='GST_REPORT' || 
$REPORT_NAME=='PRODUCT_WISE_PURCHASE' || $REPORT_NAME=='PRODUCT_WISE_SALE'){ ?> 
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
								<button type="submit" class="btn btn-primary" name="Save" >Display</button>		
						</div>							
						
				</div>
		</div>
	</div> 
<?php } ?>

<?php if($REPORT_NAME=='EXPIRY_REGISTER' ){ ?> 
<div class="panel panel-primary" >
		<div class="panel-body" align="center" style="background-color:#3c8dbc">
				<div class="form-row">
						<div class="form-group col-md-3">
							<label for="inputState">Date</label>
							<input type="text"  id="todate" name="todate" value="<?php echo $todate; ?>" class="form-control"  > 				
						</div>					
						<div class="form-group col-md-2">
						<button type="submit" class="btn btn-primary" name="Save" >Display</button>		
						</div>	
				</div>
		</div>
	</div> 
<?php } ?>


<?php if($REPORT_NAME=='DOCTOR_COMMISSION_SUMMARY' || $REPORT_NAME=='DOCTOR_COMMISSION_DETAILS'
 ||$REPORT_NAME=='GENERAL_LEDGER' || $REPORT_NAME=='PURCHASE_LEDGER' || $REPORT_NAME=='SALE_LEDGER' || $REPORT_NAME=='DEBTORS_SUMMARY' 
 || $REPORT_NAME=='CREDITORS_SUMMARY' ){ ?> 
<div class="panel panel-primary" >
		<div class="panel-body" align="center" style="background-color:#3c8dbc">
				<div class="form-row">
					<div class="form-group col-md-4">
					  <label for="inputState">Select Account</label>
					 <select id="param1" class="form-control select2"  name="param1">
							  <option value="0">Select Doctor</option>
								  <?php							
									foreach ($ledger_accounts as $row){ 						
									?>
								  <option value="<?php echo $row->id; ?>" 
									<?php if($row->id==$param1) 
									{ echo 'selected="selected"'; } ?>> 
									<?php echo $row->acc_name; ?> </option>
								  <?php } ?>
						</select>
					</div>
						<div class="form-group col-md-3">
							<label for="inputState">To Date</label>
							<input type="text"  id="fromdate" name="fromdate" value="<?php echo $fromdate; ?>" class="form-control"  > 				
						</div>
											
						<div class="form-group col-md-3">
							<label for="inputState">From Date</label>
							<input type="text"  id="todate" name="todate" value="<?php echo $todate; ?>" class="form-control"  > 				
						</div>
					
						<div class="form-group col-md-2">
								<button type="submit" class="btn btn-primary" name="Save" >Display</button>		
						</div>							
						
				</div>
		</div>
	</div> 
<?php } ?>





</div></div>
</div></div>
</form>