<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
function getlink(href) 
{
	//alert(href);	
	if(href) {window.location = href;}			
}
</script>
<style>

table#example {
    border-collapse: collapse;   
}
#example tr {
    background-color: #eee;
    border-top: 1px solid #fff;
}
#example tr:hover {
    background-color: #ccc;
}
#example th {
    background-color: #fff;
}
#example th, #example td {
    padding: 3px 5px;
}
#example td:hover {
    cursor: pointer;
}

a {
  color:#000000;
  text-decoration: none;
}
</style>

<div class="panel panel-primary" >
	
	  <div class="panel-body" align="center" style="background-color:#99CC00">
		<h3><span class="label label-default"><?php echo $REPORT_NAME;?></span>
		<span class="label label-default">
		<?php 
		if($this->session->userdata('alert_msg')<>''){
		echo '<br><br><br>'.$this->session->userdata('alert_msg');
		}
		 ?>
		</span></h3>
	  </div>
</div>
  
<!--REPORT PARAMETER SECTION-->
 
<?php echo $report_parameter;?>

 <!--REPORT PARAMETER SECTION END-->
  
  <?php if($with_paran=='YES') { ?>
  
<div id="printablediv"  >
		
			<!-- MIS REPORT SECTIONS START-->				
			<?php if($REPORT_NAME=='PRODUCT_GROUP'){ ?>
			<table   class="table table-bordered table-striped" id="example">
			
				<tr ><td    colspan="4" style="background-color:#999999"><?php //echo $rs[$group1]['site_name']; ?></td></tr>
				<tr  style="background-color:#999999">
				 <td   >Product Name</td>
				 <td   >Qnty Available</td>
				 <td   >Rate</td>
				 <td   >Total</td>			 
				 </tr>			
			 				
					  <?php 
					  		$tranlink=ADMIN_BASE_URL.'Accounts_controller/all_mis_reports/';
							
							$trading_rs=$report_data;
							$trading_cnt_total=sizeof($trading_rs); 
							if($trading_cnt_total>0){  
							for($trading_cnt=0;$trading_cnt<$trading_cnt_total;$trading_cnt++)
							{
							$href=$tranlink.'PRODUCT_BATCH/'.$trading_rs[$trading_cnt]['id'];	
						?>	
						<tr bgcolor="#999999">						 
							<td   ><a href="<?php echo $href;  ?>">
							<?php echo $trading_rs[$trading_cnt]['particular'] ?></a></td>
							 <td   ><?php echo $trading_rs[$trading_cnt]['qnty_available'] ?></td>
							 <td   ><?php echo $trading_rs[$trading_cnt]['rate'] ?></td>
							 <td   ><?php echo $trading_rs[$trading_cnt]['total'] ?></td>			 
						 </tr>		
						
				<?php }} ?>
				
				</table>
			<?php } ?>
			
			<?php if($REPORT_NAME=='PRODUCT_BATCH'){ ?>
			<table   class="table table-bordered table-striped" id="example">
			<tr ><td    colspan="9" style="background-color:#999999"><?php //echo $rs[$group1]['site_name']; ?></td></tr>
				<tr  style="background-color:#999999">
				 <td   >Batch No</td>
				 <td   >Mfg Date</td>
				 <td   >Exp date</td>
				 <td    align="right">Purchase Qnty</td>	
				 <td   align="right">Sale Qnty</td>
				 <td   align="right">Sale Rtn</td>
				<!-- <td   align="right">Sample Issue</td>-->
				 <td   align="right">Availavle Qnty</td>
				 <td   align="right">Rate</td>
				 <td   align="right">Total</td>			 
				 </tr>			
				 
					 <?php 
							$trading_rs=$report_data;
							$trading_cnt_total=sizeof($trading_rs); 
							$tot_sample=$TOTAL_SELL_RTN=$total_purchase=$total_sale=$total_available_qnty=$total_amt=0;
							if($trading_cnt_total>0){  
							for($trading_cnt=0;$trading_cnt<$trading_cnt_total;$trading_cnt++)
							{			
							$total_purchase=$total_purchase+$trading_rs[$trading_cnt]['total_purchase'];
							$total_sale=$total_sale+$trading_rs[$trading_cnt]['total_sale'];
							$total_available_qnty=$total_available_qnty+$trading_rs[$trading_cnt]['total_available_qnty'];
							$total_amt=$total_amt+$trading_rs[$trading_cnt]['total_amt'];	
							$tot_sample=$tot_sample+$trading_rs[$trading_cnt]['tot_sample'];	
							$TOTAL_SELL_RTN=$TOTAL_SELL_RTN+$trading_rs[$trading_cnt]['TOTAL_SELL_RTN'];	
						?>	
							<tr >
							 <td   >
							 <a href="<?php echo $trading_rs[$trading_cnt]['href'];  ?>">
							 <?php echo $trading_rs[$trading_cnt]['batchno'] ?></a></td>
							 <td   ><?php echo $trading_rs[$trading_cnt]['mfg_monyr'] ?></td>
							 <td   ><?php echo $trading_rs[$trading_cnt]['exp_monyr'] ?></td>
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['total_purchase'] ?></td>	
							 <td   align="right" ><?php echo $trading_rs[$trading_cnt]['total_sale'] ?></td>
							  <td  align="right" ><?php echo $trading_rs[$trading_cnt]['TOTAL_SELL_RTN'] ?></td>
							  <?php /*?> <td  align="right" ><?php echo $trading_rs[$trading_cnt]['tot_sample'] ?></td><?php */?>
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['total_available_qnty'] ?></td>
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['rate'] ?></td>
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['total_amt'] ?></td>			 
							 </tr>	
					<?php }} ?>
							<tr  style="background-color:#CC6633">
							 <td   colspan="3"  style="background-color:#CC6633">Total</td>
							 <td   align="right"><?php echo $total_purchase; ?></td>	
							 <td   align="right"><?php echo $total_sale; ?></td>
							 <td   align="right"><?php echo $TOTAL_SELL_RTN; ?></td>
							<?php /*?> <td   align="right"><?php echo $tot_sample; ?></td><?php */?>
							 <td   align="right"><?php echo $total_available_qnty; ?></td>
							 <td   >&nbsp;</td>
							 <td   align="right"><?php echo $total_amt; ?></td>			 
							 </tr>	
				</table>
			<?php } ?>
			
			<?php if($REPORT_NAME=='PRODUCT_BATCH_TRANSACTIONS'){ ?>
				<div class="panel-body" > 					
					<div  class="row" style="background-color:#CCCC66">						
						<div class="col-md-2"  align="left">Invoice No</div>
						<div class="col-md-2"  align="left">Invoice Date</div>
						<div class="col-md-2"  align="left">Party</div>
						<div class="col-md-2"  align="right">Status</div>
						<div class="col-md-2"  align="right">Qnty</div>
						<div class="col-md-2"  align="right">Balance Qnty</div>
					</div>
					
					 <?php 
							$trading_rs=$report_data;
							$trading_cnt_total=sizeof($trading_rs); 
							$total_purchase=$total_sale=$total_available_qnty=$total_amt=0;
							if($trading_cnt_total>0){  
							for($trading_cnt=0;$trading_cnt<$trading_cnt_total;$trading_cnt++)
							{			
					 ?>	
					<div class="row"  
					style="background:white" onmouseover="this.style.background='gray';" onmouseout="this.style.background='white';">
					
							<div class="col-md-2"  align="left" ><?php echo $trading_rs[$trading_cnt]['invoice_no']; ?></div> 
							<div class="col-md-2"  align="left" ><?php echo $trading_rs[$trading_cnt]['invoice_date']; ?></div> 
							<div class="col-md-2"  align="left" ><?php echo $trading_rs[$trading_cnt]['party_name']; ?></div> 							
							<div class="col-md-2"  align="left" ><?php echo $trading_rs[$trading_cnt]['status'] ?></div> 
							<div class="col-md-2"  align="right" ><?php echo $trading_rs[$trading_cnt]['qnty']; ?></div> 
							<div class="col-md-2"  align="right" ><?php echo $trading_rs[$trading_cnt]['balance'] ?></div> 
							
					</div>
					<?php }} ?>
					
			</div>			
			<?php } ?>
			
			<!--SAMPLE PRODUCT SECTIONS-->			
			<?php if($REPORT_NAME=='PRODUCT_GROUP_SAMPLE'){ ?>
			<table   class="table table-bordered table-striped" id="example">
			
				<tr ><td    colspan="4" style="background-color:#999999"><?php //echo $rs[$group1]['site_name']; ?></td></tr>
				<tr  style="background-color:#999999">
				 <td   >Product Name</td>
				 <td   >Qnty Available</td>
				 <td   >Rate</td>
				 <td   >Total</td>			 
				 </tr>			
			 				
					  <?php 
							$trading_rs=$report_data;
							$trading_cnt_total=sizeof($trading_rs); 
							if($trading_cnt_total>0){  
							for($trading_cnt=0;$trading_cnt<$trading_cnt_total;$trading_cnt++)
							{			
							//echo $trading_rs[$trading_cnt]['href'];			
						?>	
						<tr bgcolor="#999999">						 
							<td   ><a href="<?php echo $trading_rs[$trading_cnt]['href'];  ?>">
							<?php echo $trading_rs[$trading_cnt]['particular'] ?></a></td>
							 <td   ><?php echo $trading_rs[$trading_cnt]['qnty_available'] ?></td>
							 <td   ><?php echo $trading_rs[$trading_cnt]['rate'] ?></td>
							 <td   ><?php echo $trading_rs[$trading_cnt]['total'] ?></td>			 
						 </tr>		
						
				<?php }} ?>
				
				</table>
			<?php } ?>
			
			<?php if($REPORT_NAME=='PRODUCT_BATCH_SAMPLE'){ ?>
			<table   class="table table-bordered table-striped" id="example">
			<tr ><td    colspan="8" style="background-color:#999999"><?php //echo $rs[$group1]['site_name']; ?></td></tr>
				<tr  style="background-color:#999999">
				 <td   >Batch No</td>
				 <td   >Mfg Date</td>
				 <td   >Exp date</td>				
				 <td   align="right">Sample Qnty</td>
				 <td   align="right">Sample issue </td>
				 <td   align="right">Availavle Qnty</td>
				 <td   align="right">Rate</td>
				 <td   align="right">Total</td>			 
				 </tr>			
				 
					 <?php 
							$trading_rs=$report_data;
							$trading_cnt_total=sizeof($trading_rs); 
							$tot_sample=$tot_sample_issue=$total_purchase=$total_sale=$total_available_qnty=$total_amt=0;
							if($trading_cnt_total>0){  
							for($trading_cnt=0;$trading_cnt<$trading_cnt_total;$trading_cnt++)
							{			
							
							$tot_sample_issue=$tot_sample_issue+$trading_rs[$trading_cnt]['tot_sample_issue'];	
							$tot_sample=$tot_sample+$trading_rs[$trading_cnt]['tot_sample'];
							$total_available_qnty=$total_available_qnty+$trading_rs[$trading_cnt]['total_available_qnty'];	
							
						?>	
							<tr >
							 <td   >
							 <a href="<?php echo $trading_rs[$trading_cnt]['href'];  ?>">
							 <?php echo $trading_rs[$trading_cnt]['batchno'] ?></a></td>
							 <td   ><?php echo $trading_rs[$trading_cnt]['mfg_monyr'] ?></td>
							 <td   ><?php echo $trading_rs[$trading_cnt]['exp_monyr'] ?></td>	
							  <td  align="right" ><?php echo $trading_rs[$trading_cnt]['tot_sample'] ?></td>						
							  <td  align="right" ><?php echo $trading_rs[$trading_cnt]['tot_sample_issue'] ?></td>							  
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['total_available_qnty'] ?></td>
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['rate'] ?></td>
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['total_amt'] ?></td>			 
							 </tr>	
					<?php }} ?>
							<tr  style="background-color:#CC6633">
							 <td   colspan="3"  style="background-color:#CC6633">Total</td>							
							 <td   align="right"><?php echo $tot_sample; ?></td>
							 <td   align="right"><?php echo $tot_sample_issue; ?></td>
							 <td   align="right"><?php echo $total_available_qnty; ?></td>
							 <td   >&nbsp;</td>
							 <td   align="right"><?php echo $total_amt; ?></td>			 
							 </tr>	
				</table>
			<?php } ?>
			
			<?php if($REPORT_NAME=='PRODUCT_BATCH_TRANSACTIONS_SAMPLE'){ ?>
				<div class="panel-body" > 					
					<div  class="row" style="background-color:#CCCC66">						
						<div class="col-md-2"  align="left">Invoice No</div>
						<div class="col-md-2"  align="left">Invoice Date</div>
						<div class="col-md-2"  align="left">Party</div>
						<div class="col-md-2"  align="right">Status</div>
						<div class="col-md-2"  align="right">Qnty</div>
						<div class="col-md-2"  align="right">Balance Qnty</div>
					</div>
					
					 <?php 
							$trading_rs=$report_data;
							$trading_cnt_total=sizeof($trading_rs); 
							$total_purchase=$total_sale=$total_available_qnty=$total_amt=0;
							if($trading_cnt_total>0){  
							for($trading_cnt=0;$trading_cnt<$trading_cnt_total;$trading_cnt++)
							{			
					 ?>	
					<div class="row"  
					style="background:white" onmouseover="this.style.background='gray';" onmouseout="this.style.background='white';">
					
							<div class="col-md-2"  align="left" ><?php echo $trading_rs[$trading_cnt]['invoice_no']; ?></div> 
							<div class="col-md-2"  align="left" ><?php echo $trading_rs[$trading_cnt]['invoice_date']; ?></div> 
							<div class="col-md-2"  align="left" ><?php echo $trading_rs[$trading_cnt]['party_name']; ?></div> 							
							<div class="col-md-2"  align="left" ><?php echo $trading_rs[$trading_cnt]['status'] ?></div> 
							<div class="col-md-2"  align="right" ><?php echo $trading_rs[$trading_cnt]['qnty']; ?></div> 
							<div class="col-md-2"  align="right" ><?php echo $trading_rs[$trading_cnt]['balance'] ?></div> 
							
					</div>
					<?php }} ?>
					
			</div>			
			<?php } ?>	
						
			<!-- PRODUCT ALL TRANSACTION SECTIONS-->
			<?php if($REPORT_NAME=='PRODUCT_TRANSACTIONS'){ ?>			
				<div class="panel-body" > 					
					<div  class="row" style="background-color:#CCCC66">						
						<div class="col-md-2"  align="left">Invoice No</div>
						<div class="col-md-2"  align="left">Invoice Date</div>
						<div class="col-md-2"  align="left">Party</div>
						<div class="col-md-2"  align="right">Status</div>
						<div class="col-md-2"  align="right">Qnty</div>
						
					</div>
					
					 <?php 
							$trading_rs=$report_data;
							$trading_cnt_total=sizeof($trading_rs); 
							$total_purchase=$total_sale=$total_available_qnty=$total_amt=0;
							if($trading_cnt_total>0){  
							for($trading_cnt=0;$trading_cnt<$trading_cnt_total;$trading_cnt++)
							{			
					 ?>	
					<div class="row"  
					style="background:white" onmouseover="this.style.background='gray';" onmouseout="this.style.background='white';">
					
							<div class="col-md-2"  align="left" ><?php echo $trading_rs[$trading_cnt]['invoice_no']; ?></div> 
							<div class="col-md-2"  align="left" ><?php echo $trading_rs[$trading_cnt]['invoice_date']; ?></div> 
							<div class="col-md-2"  align="left" ><?php echo $trading_rs[$trading_cnt]['party_name']; ?></div> 							
							<div class="col-md-2"  align="left" ><?php echo $trading_rs[$trading_cnt]['status'] ?></div> 
							<div class="col-md-2"  align="right" ><?php echo $trading_rs[$trading_cnt]['qnty']; ?></div> 
					</div>
					<?php }} ?>
					
			</div>			
			<?php } ?>		
			
			
			
			<?php if($REPORT_NAME=='PRODUCT_WISE_PURCHASE' || $REPORT_NAME=='PRODUCT_WISE_SALE'){ ?>
				<table    class="table table-bordered table-striped" id="example">
			
				<tr>			
					<td  colspan="9" align="center" style="background: linear-gradient(#CC9933,#CC9933);">
					<?php echo ' From :'.$fromdate.' To :'.$todate;?>
					</td>	
				</tr>
				
				<tr style="background: linear-gradient(#CC9933,#CC9933);">			
					<td  align="left">Date</td>	
					<td  align="left">Invoice No</td>	
					<td  align="left">Party Name</td>
					<td  align="left">Product Name</td>
					<td  align="right">Qnty</td>	
					<td  align="right">Rate</td>	
					<td  align="right">Total</td>	
					<td  align="right">Disc Amt</td>	
					<td  align="right">Grand Total</td>	
				</tr>
			 				
					  <?php 
							$total_total=$discount_total=$grandtot_total=0;
							
							$trading_cnt_total=sizeof($report_data); 
							if($trading_cnt_total>0){  
							for($trading_cnt=0;$trading_cnt<$trading_cnt_total;$trading_cnt++)
							{			
							//echo $trading_rs[$trading_cnt]['href'];			
						?>	
						<tr >						 
							<td  align="left"><a href="<?php //echo $report_data[$trading_cnt]['href'];  ?>">
							<?php echo $report_data[$trading_cnt]['invoice_date'] ?></a></td>
							 <td align="left"><?php echo $report_data[$trading_cnt]['invoice_no']; ?></td>
							 <td align="left"><?php echo $report_data[$trading_cnt]['party_name']; ?></td>
							 <td align="left"><?php echo $report_data[$trading_cnt]['product']; ?></td>
							<td  align="right"><?php echo $report_data[$trading_cnt]['qnty']; ?></td>	
							<td  align="right"><?php echo $report_data[$trading_cnt]['rate']; ?></td>	
							<td  align="right"><?php echo $report_data[$trading_cnt]['total']; ?></td>	
							<td  align="right"><?php echo $report_data[$trading_cnt]['discount']; ?></td>	
							<td  align="right"><?php echo $report_data[$trading_cnt]['grandtot'];?></td>				
							 
					 </tr>	
				<?php 	
					$total_total=$total_total+$report_data[$trading_cnt]['total'];
					$discount_total=$discount_total+$report_data[$trading_cnt]['discount'];
					$grandtot_total=$grandtot_total+$report_data[$trading_cnt]['grandtot'];
				}} ?>
	<tr>
	<td style="background: linear-gradient(#CC9933,#CC9933);"  colspan="6"><strong>Total</strong></td>	
	<td style="background: linear-gradient(#CC9933,#CC9933);" align="right"><strong><?php echo $total_total;?></strong> </td>
	<td style="background: linear-gradient(#CC9933,#CC9933);" align="right"><strong><?php echo $discount_total;?></strong></td>		
	<td style="background: linear-gradient(#CC9933,#CC9933);" align="right"><strong><?php echo $grandtot_total;?></strong></td>
	</tr>
	
	
				
				</table>
			<?php } ?>
			
			
			<?php if($REPORT_NAME=='DEBTORS_SUMMARY'){ ?>
				<table    class="table table-bordered table-striped" id="example">
			
				<tr>			
					<td  colspan="7" align="center" style="background: linear-gradient(#CC9933,#CC9933);">
					<?php
					$acc_name=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$ledger_ac); 		
					echo 'Ledger Transaction of '.$acc_name.' From :'.$fromdate.' To :'.$todate;
					?>
					</td>	
				</tr>
				
				<tr style="background: linear-gradient(#CC9933,#CC9933);">			
					<td  align="left">Date</td>	
					<td  align="left">Vch Type</td>
					<td  align="left">Vch/Invoice No</td>
					<td  align="left">Particular</td>	
					<td  align="right">Due Amount</td>	
					<td  align="right">Receive Amount</td>				
					<!--<td  align="right">Balance</td> -->
				</tr>
			 				
					  <?php 
					  		
							$credit_cumulative_balance=$debit_cumulative_balance=$tot_dr_balance=$tot_cr_balance=0;
							$trading_cnt_total=sizeof($report_data); 
							if($trading_cnt_total>0){  
							for($trading_cnt=0;$trading_cnt<$trading_cnt_total;$trading_cnt++)
							{	
							$display='YES';
							if($report_data[$trading_cnt]['credit_amount']>0  )
							{
								if($report_data[$trading_cnt]['particular_ledger_account']==323)
								{$display='YES';}
								else
								{$display='NO';}
								
								$whr="  id=".$report_data[$trading_cnt]['tran_table_id'];
								$report_data[$trading_cnt]['credit_amount']=$this->projectmodel->GetSingleVal('grandtot','invoice_summary',	$whr,'id ASC ');
																
							}
							
							if($display=='YES')
							{		
									
						?>	
						<tr style="background-color:<?php 
						if($report_data[$trading_cnt]['debit_amount']>0)
						{echo '#CC6666';}else{echo '#33CC66';} ?>">						 
							<td  ><a href="<?php //echo $report_data[$trading_cnt]['href'];  ?>">
							<?php echo $report_data[$trading_cnt]['tran_date'] ?></a></td>
							 <td  ><?php echo $report_data[$trading_cnt]['tran_type'] ?></td>
							 <td  ><?php echo $report_data[$trading_cnt]['tran_code'] ?></td>	
							 <td><?php echo $report_data[$trading_cnt]['particular'] ?></td>
							 <td align="right"><?php echo $report_data[$trading_cnt]['credit_amount'] ?></td>			
							 <td align="right"><?php echo $report_data[$trading_cnt]['debit_amount'] ?></td>			
							 
						 </tr>	
						 
						 <?php if($report_data[$trading_cnt]['credit_amount']>0 && $report_data[$trading_cnt]['tran_table_id']>0){ ?>
						 <tr >
						 <td  colspan="6" >	
						 <table    class="table table-bordered table-striped" id="example">
						  <tr>	
						 	<td  align="left">Product Name</td>	
							<td  align="right">Qnty</td>	
							<td  align="right">Rate</td>
							<td  align="right">Total After disc</td>
							<td  align="right">Tax %</td>	
							<td  align="right">Total After tax</td>	
						  </tr>
						   <?php 
								
							$whr="  invoice_summary_id=".$report_data[$trading_cnt]['tran_table_id']." and RELATED_TO_MIXER='NO'";
							$invoice_details_rs=$this->projectmodel->GetMultipleVal('*','invoice_details',	$whr,'id ASC ');
							$cnt=sizeof($invoice_details_rs);	 
							for($fieldIndex=0;$fieldIndex<$cnt;$fieldIndex++)
							{				
							?>	
							 <tr>	
								<td  align="left"><?php 
								echo $this->projectmodel->GetSingleVal('brand_name','brands',' id='.$invoice_details_rs[$fieldIndex]['product_id']);
								 ?></td>	
								<td  align="right"><?php echo $invoice_details_rs[$fieldIndex]['qnty']; ?></td>	
								<td align="right"><?php echo $invoice_details_rs[$fieldIndex]['srate']; ?></td>
								<td  align="right"><?php echo $invoice_details_rs[$fieldIndex]['taxable_amt']; ?></td>
								<td  align="right"><?php echo $invoice_details_rs[$fieldIndex]['tax_per']; ?></td>	
								<td  align="right"><?php echo $invoice_details_rs[$fieldIndex]['taxable_amt']+
								$invoice_details_rs[$fieldIndex]['cgst_amt']+
								$invoice_details_rs[$fieldIndex]['sgst_amt']+
								$invoice_details_rs[$fieldIndex]['igst_amt']; ?></td>	
							  </tr>
						  <?php } ?>
						 </table>
						 </td>
						 </tr>
						 <?php } ?>
				<?php 				
					$debit_cumulative_balance=$debit_cumulative_balance+$report_data[$trading_cnt]['credit_amount'];
					$credit_cumulative_balance=$credit_cumulative_balance+$report_data[$trading_cnt]['debit_amount'];
					
					if($debit_cumulative_balance>=$credit_cumulative_balance)
					{ $bal=$debit_cumulative_balance-$credit_cumulative_balance;} //echo $bal.'Dr';}
					else
					{$bal=$credit_cumulative_balance-$debit_cumulative_balance;} //echo $bal.'Cr';}
	
					$tot_dr_balance=$tot_dr_balance+$report_data[$trading_cnt]['credit_amount'];
					$tot_cr_balance=$tot_cr_balance+$report_data[$trading_cnt]['debit_amount'];
				
				}}} ?>
	<tr>
	<td style="background: linear-gradient(#CC9933,#CC9933);"  colspan="4"><strong>Total</strong></td>	
	<td style="background: linear-gradient(#CC9933,#CC9933);" align="right"><strong><?php echo $tot_dr_balance;?></strong> </td>
	<td style="background: linear-gradient(#CC9933,#CC9933);" align="right"><strong><?php echo $tot_cr_balance;?></strong></td>		
	</tr>
	
	<tr>
	<td style="background: linear-gradient(#CC9933,#CC9933);"  colspan="6">
	<strong>
	<?php 		
	
		if($tot_cr_balance>$tot_dr_balance)
		{echo 'Total Advance paid  :'.($tot_cr_balance-$tot_dr_balance);}
		else
		{echo 'Total Due :'.($tot_dr_balance-$tot_cr_balance); }
	?>
	
	</strong></td>			
	</tr>
				
				</table>
			<?php } ?>
			
			
			<?php if($REPORT_NAME=='CREDITORS_SUMMARY'){ ?>
				<table    class="table table-bordered table-striped" id="example">
			
				<tr>			
					<td  colspan="7" align="center" style="background: linear-gradient(#CC9933,#CC9933);">
					<?php
					$acc_name=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$ledger_ac); 		
					echo 'Ledger Transaction of '.$acc_name.' From :'.$fromdate.' To :'.$todate;
					?>
					</td>	
				</tr>
				
				<tr style="background: linear-gradient(#CC9933,#CC9933);">			
					<td  align="left">Date</td>	
					<td  align="left">Vch Type</td>
					<td  align="left">Vch/Invoice No</td>
					<td  align="left">Particular</td>	
					<td  align="right">Due Amount</td>	
					<td  align="right">Paid Amount</td>				
					<!--<td  align="right">Balance</td> -->
				</tr>
			 				
					  <?php 
					  		
							$credit_cumulative_balance=$debit_cumulative_balance=$tot_dr_balance=$tot_cr_balance=0;
							$trading_cnt_total=sizeof($report_data); 
							if($trading_cnt_total>0){  
							for($trading_cnt=0;$trading_cnt<$trading_cnt_total;$trading_cnt++)
							{	
							$display='YES';
							
							if($report_data[$trading_cnt]['debit_amount']>0  )
							{
								if($report_data[$trading_cnt]['particular_ledger_account']==322)
								{$display='YES';}
								else
								{$display='NO';}
								
								$whr="  id=".$report_data[$trading_cnt]['tran_table_id'];
								$report_data[$trading_cnt]['credit_amount']=$this->projectmodel->GetSingleVal('grandtot','invoice_summary',	$whr,'id ASC ');
																
							}
							
							if($display=='YES')
							{	
									
						?>	
						<tr style="background-color:<?php 
						if($report_data[$trading_cnt]['debit_amount']>0)
						{echo '#CC6666';}else{echo '#33CC66';} ?>">						 
							<td  ><a href="<?php //echo $report_data[$trading_cnt]['href'];  ?>">
							<?php echo $report_data[$trading_cnt]['tran_date'] ?></a></td>
							 <td  ><?php echo $report_data[$trading_cnt]['tran_type'] ?></td>
							 <td  ><?php echo $report_data[$trading_cnt]['tran_code'] ?></td>	
							 <td><?php echo $report_data[$trading_cnt]['particular'] ?></td>
							 <td align="right"><?php echo $report_data[$trading_cnt]['debit_amount'] ?></td>
							 <td align="right"><?php echo $report_data[$trading_cnt]['credit_amount'] ?></td>				
							 
						 </tr>	
						 
						 <?php if($report_data[$trading_cnt]['debit_amount']>0 && $report_data[$trading_cnt]['tran_table_id']>0){ ?>
						 <tr >
						 <td  colspan="6" >	
						 <table    class="table table-bordered table-striped" id="example">
						  <tr>	
						 	<td  align="left">Product Name</td>	
							<td  align="right">Qnty</td>	
							<td  align="right">Rate</td>
							<td  align="right">Total After disc</td>
							<td  align="right">Tax %</td>	
							<td  align="right">Total After tax</td>	
						  </tr>
						   <?php 
								
							$whr="  invoice_summary_id=".$report_data[$trading_cnt]['tran_table_id']." and RELATED_TO_MIXER='NO'";
							$invoice_details_rs=$this->projectmodel->GetMultipleVal('*','invoice_details',	$whr,'id ASC ');
							$cnt=sizeof($invoice_details_rs);	 
							for($fieldIndex=0;$fieldIndex<$cnt;$fieldIndex++)
							{				
							?>	
							 <tr>	
								<td  align="left"><?php 
								echo $this->projectmodel->GetSingleVal('brand_name','brands',' id='.$invoice_details_rs[$fieldIndex]['product_id']);
								 ?></td>	
								<td  align="right"><?php echo $invoice_details_rs[$fieldIndex]['qnty']; ?></td>	
								<td align="right"><?php echo $invoice_details_rs[$fieldIndex]['srate']; ?></td>
								<td  align="right"><?php echo $invoice_details_rs[$fieldIndex]['taxable_amt']; ?></td>
								<td  align="right"><?php echo $invoice_details_rs[$fieldIndex]['tax_per']; ?></td>	
								<td  align="right"><?php echo $invoice_details_rs[$fieldIndex]['taxable_amt']+
								$invoice_details_rs[$fieldIndex]['cgst_amt']+
								$invoice_details_rs[$fieldIndex]['sgst_amt']+
								$invoice_details_rs[$fieldIndex]['igst_amt']; ?></td>	
							  </tr>
						  <?php } ?>
						 </table>
						 </td>
						 </tr>
						 <?php } ?>
				<?php 				
					$debit_cumulative_balance=$debit_cumulative_balance+$report_data[$trading_cnt]['credit_amount'];
					$credit_cumulative_balance=$credit_cumulative_balance+$report_data[$trading_cnt]['debit_amount'];
					
					if($debit_cumulative_balance>=$credit_cumulative_balance)
					{ $bal=$debit_cumulative_balance-$credit_cumulative_balance;} //echo $bal.'Dr';}
					else
					{$bal=$credit_cumulative_balance-$debit_cumulative_balance;} //echo $bal.'Cr';}
	
					$tot_dr_balance=$tot_dr_balance+$report_data[$trading_cnt]['credit_amount'];
					$tot_cr_balance=$tot_cr_balance+$report_data[$trading_cnt]['debit_amount'];
				
				}}} ?>
	<tr>
	<td style="background: linear-gradient(#CC9933,#CC9933);"  colspan="4"><strong>Total</strong></td>	
	<td style="background: linear-gradient(#CC9933,#CC9933);" align="right"><strong><?php echo $tot_cr_balance;?></strong></td>	
	<td style="background: linear-gradient(#CC9933,#CC9933);" align="right"><strong><?php echo $tot_dr_balance;?></strong> </td>	
	</tr>
	
	<tr>
	<td style="background: linear-gradient(#CC9933,#CC9933);"  colspan="6">
	<strong>
	<?php 		
	
		if($tot_cr_balance>$tot_dr_balance)
		{echo 'Total Due :'.($tot_cr_balance-$tot_dr_balance);}
		else
		{echo 'Total Advance paid   :'.($tot_dr_balance-$tot_cr_balance); }
	?>
	
	</strong></td>			
	</tr>
				
				</table>
			<?php } ?>
			
			<?php if($REPORT_NAME=='BILL_WISE_SALE'){ ?>
			<table   class="table table-bordered table-striped" id="example">
			<tr ><td    colspan="21" style="background-color:#FFFF33" align="center">
			<?php echo 'Sale Report From '. $fromdate.' To '.$todate; ?></td></tr>
				<tr  style="background-color:#CCFFFF">
				 <td   >Date</td>
				 <td   >Tax Invoice No</td>
				 <td   >Customer Name</td>				
				 <td   >Place of Supply</td>
				 <td   >GSTIN </td>
				 <td   align="center" colspan="5">GST 5 %</td>
				 <td   align="center" colspan="5">GST 12 %</td>
				 <td   align="center" colspan="5">GST 18 %</td>
				<!-- <td   align="right">Free Goods</td>	
				 <td   align="right">INTEREST</td>
				 <td   align="right">Delivery Charge</td>
				 <td   align="right">Cash Discount</td>
				 <td   align="right">R/OFF</td>-->
				 <td   align="right">Bill Amount</td>		 
				 </tr>	
				 
				 <tr  style="background-color:#999999">
				 
				 <td   colspan="5">--</td>
				 	
				 <td   align="right" >Taxable Amount</td>	
				 <td   align="right" >CGST</td>	
				 <td   align="right" >SGST</td>	
				 <td   align="right" >IGST</td>	
				 <td   align="right" >AMOUNT WITH TAX</td>		
					
				 <td   align="right" >Taxable Amount</td>	
				 <td   align="right" >CGST</td>	
				 <td   align="right" >SGST</td>	
				 <td   align="right" >IGST</td>	
				 <td   align="right" >AMOUNT WITH TAX</td>	
				
				 <td   align="right" >Taxable Amount</td>	
				 <td   align="right" >CGST</td>	
				 <td   align="right" >SGST</td>	
				 <td   align="right" >IGST</td>	
				 <td   align="right" >AMOUNT WITH TAX</td>	  			
				<td   colspan="6">--</td>
				 </tr>					
				 
					 <?php 
							$trading_rs=$report_data;
							$trading_cnt_total=sizeof($trading_rs); 
							$grand_total=$taxable_amt_5=$taxable_amt_12=$taxable_amt_18=0;
							
							if($trading_cnt_total>0){  
							for($trading_cnt=0;$trading_cnt<$trading_cnt_total;$trading_cnt++)
							{	
							$taxable_amt_5=$taxable_amt_5+$trading_rs[$trading_cnt]['taxable_amt_5'];
							$taxable_amt_12=$taxable_amt_12+$trading_rs[$trading_cnt]['taxable_amt_12'];
							$taxable_amt_18=$taxable_amt_18+$trading_rs[$trading_cnt]['taxable_amt_18'];
							$grand_total=$grand_total+$trading_rs[$trading_cnt]['grand_total'];
						?>	
							<tr>
							 <td   ><?php echo $trading_rs[$trading_cnt]['invoice_date'] ?></td>
							 <td   ><?php echo $trading_rs[$trading_cnt]['invoice_no'] ?></td>
							 <td   ><?php echo $trading_rs[$trading_cnt]['party_name'] ?></td>	
							 <td  align="right" ><?php echo $trading_rs[$trading_cnt]['destination'] ?></td>						
							 <td   ><?php echo $trading_rs[$trading_cnt]['GSTNO'] ?></td>
							 
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['taxable_amt_5'] ?></td>
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['CGST_5'] ?></td>	
							 <td   align="right" ><?php echo $trading_rs[$trading_cnt]['SGST_5'] ?></td>			
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['IGST_5'] ?></td>
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['amount_with_tax_5'] ?></td>
							 
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['taxable_amt_12'] ?></td>
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['CGST_12'] ?></td>	
							 <td   align="right" ><?php echo $trading_rs[$trading_cnt]['SGST_12'] ?></td>			
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['IGST_12'] ?></td>
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['amount_with_tax_12'] ?></td>
							 
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['taxable_amt_18'] ?></td>
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['CGST_18'] ?></td>	
							 <td   align="right" ><?php echo $trading_rs[$trading_cnt]['SGST_18'] ?></td>			
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['IGST_18'] ?></td>
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['amount_with_tax_18'] ?></td>
							 <td  align="right" ><?php echo $trading_rs[$trading_cnt]['grand_total'] ?></td>	
							 </tr>	
					<?php }} ?>
							<tr  style="background-color:#CC6633">
							 <td   colspan="5"  style="background-color:#CC6633">Total</td>							
							 <td   align="right"><?php echo $taxable_amt_5; ?></td>
							 <td   align="right" colspan="4">Total 12% taxable </td>
							 <td   align="right"><?php echo $taxable_amt_12; ?></td>
							 <td   align="right" colspan="4">Total 18% taxable </td>
							  <td   align="right"><?php echo $taxable_amt_18; ?></td>
							  <td   align="right" colspan="4">Grand Total </td>
							 <td   align="right"><?php echo $grand_total; ?></td>			 
							 </tr>	
				</table>
			<?php } ?>	
			
			<?php if($REPORT_NAME=='BILL_WISE_PURCHASE'){ ?>
			<table   class="table table-bordered table-striped" id="example">
			<tr ><td    colspan="21" style="background-color:#FFFF33" align="center">
			<?php echo 'Purchase Report From '. $fromdate.' To '.$todate; ?></td></tr>
				<tr  style="background-color:#CCFFFF">
				 <td   >Date</td>
				 <td   >Tax Invoice No</td>
				 <td   >Supplier Name</td>				
				 <td   >Address</td>
				 <td   >GSTIN </td>
				 <td   align="center" colspan="5">GST 5 %</td>
				 <td   align="center" colspan="5">GST 12 %</td>
				 <td   align="center" colspan="5">GST 18 %</td>
				 <td   align="right">Bill Amount</td>		 
				 </tr>	
				 
				 <tr  style="background-color:#999999">
				 
				 <td   colspan="5">--</td>
				 	
				 <td   align="right" >Taxable Amount</td>	
				 <td   align="right" >CGST</td>	
				 <td   align="right" >SGST</td>	
				 <td   align="right" >IGST</td>	
				 <td   align="right" >AMOUNT WITH TAX</td>		
					
				 <td   align="right" >Taxable Amount</td>	
				 <td   align="right" >CGST</td>	
				 <td   align="right" >SGST</td>	
				 <td   align="right" >IGST</td>	
				 <td   align="right" >AMOUNT WITH TAX</td>	
				
				 <td   align="right" >Taxable Amount</td>	
				 <td   align="right" >CGST</td>	
				 <td   align="right" >SGST</td>	
				 <td   align="right" >IGST</td>	
				 <td   align="right" >AMOUNT WITH TAX</td>	  			
				<td   colspan="6">--</td>
				 </tr>					
				 
					 <?php 
							$trading_rs=$report_data;
							$trading_cnt_total=sizeof($trading_rs); 
							$tot_sample=$tot_sample_issue=$total_purchase=$total_sale=$total_available_qnty=$total_amt=0;
							if($trading_cnt_total>0){  
							for($trading_cnt=0;$trading_cnt<$trading_cnt_total;$trading_cnt++)
							{	
							
						?>	
							<tr>
							 <td   ><?php echo $trading_rs[$trading_cnt]['invoice_date'] ?></td>
							 <td   ><?php echo $trading_rs[$trading_cnt]['invoice_no'] ?></td>
							 <td   ><?php echo $trading_rs[$trading_cnt]['party_name'] ?></td>	
							 <td  align="right" ><?php echo $trading_rs[$trading_cnt]['destination'] ?></td>						
							 <td   ><?php echo $trading_rs[$trading_cnt]['GSTNO'] ?></td>
							 
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['taxable_amt_5'] ?></td>
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['CGST_5'] ?></td>	
							 <td   align="right" ><?php echo $trading_rs[$trading_cnt]['SGST_5'] ?></td>			
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['IGST_5'] ?></td>
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['amount_with_tax_5'] ?></td>
							 
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['taxable_amt_12'] ?></td>
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['CGST_12'] ?></td>	
							 <td   align="right" ><?php echo $trading_rs[$trading_cnt]['SGST_12'] ?></td>			
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['IGST_12'] ?></td>
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['amount_with_tax_12'] ?></td>
							 
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['taxable_amt_18'] ?></td>
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['CGST_18'] ?></td>	
							 <td   align="right" ><?php echo $trading_rs[$trading_cnt]['SGST_18'] ?></td>			
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['IGST_18'] ?></td>
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['amount_with_tax_18'] ?></td>
							<?php /*?> 
							 <td  align="right" ><?php echo $trading_rs[$trading_cnt]['freegoods'] ?></td>			
							 <td   ><?php echo $trading_rs[$trading_cnt]['interest_charge'] ?></td>
							 <td   ><?php echo $trading_rs[$trading_cnt]['delivery_charge'] ?></td>
							 <td   ><?php echo $trading_rs[$trading_cnt]['cash_discount'] ?></td>	
							 <td  align="right" ><?php echo $trading_rs[$trading_cnt]['round_off'] ?></td>			<?php */?>
							 <td  align="right" ><?php echo $trading_rs[$trading_cnt]['grand_total'] ?></td>	
							 </tr>	
					<?php }} ?>
							<?php /*?><tr  style="background-color:#CC6633">
							 <td   colspan="3"  style="background-color:#CC6633">Total</td>							
							 <td   align="right"><?php echo $tot_sample; ?></td>
							 <td   align="right"><?php echo $tot_sample_issue; ?></td>
							 <td   align="right"><?php echo $total_available_qnty; ?></td>
							 <td   >&nbsp;</td>
							 <td   align="right"><?php echo $total_amt; ?></td>			 
							 </tr>	<?php */?>
				</table>
			<?php } ?>	
			
			<?php if($REPORT_NAME=='HSN_WISE_SALE'){ ?>
			<table   class="table table-bordered table-striped" id="example">
			<tr ><td    colspan="21" style="background-color:#FFFF33" align="center">
			<?php echo 'HSN Wise Sale Report From '. $fromdate.' To '.$todate; ?></td></tr>
				<tr  style="background-color:#CCFFFF">
				 <td   >HSN Code</td>
				 <td   >Description</td>
				 <td   >UQC</td>				
				 <td   align="right">Total Quantity</td>
				 <td   align="right">Total Value </td>
				 <td   align="right" >Taxable Value</td>
				 <td   align="right" >Integrated Tax Amount</td>
				 <td   align="right" >Central Tax Amount</td>
				 <td   align="right">State/UT Tax Amount</td>		 
				 </tr>	
				 
					 <?php 
							$trading_rs=$report_data;
							$trading_cnt_total=sizeof($trading_rs); 
							$tot_qnty=$tot_value=$taxable_amt=$igst_amt=$cgst_amt=$sgst_amt=0;
							if($trading_cnt_total>0){
							for($trading_cnt=0;$trading_cnt<$trading_cnt_total;$trading_cnt++)
							{	
							$tot_qnty=$tot_qnty+$trading_rs[$trading_cnt]['tot_qnty'];
							$tot_value=$tot_value+$trading_rs[$trading_cnt]['tot_value'];
							$taxable_amt=$taxable_amt+$trading_rs[$trading_cnt]['taxable_amt'];
							$igst_amt=$igst_amt+$trading_rs[$trading_cnt]['igst_amt'];
							$cgst_amt=$cgst_amt+$trading_rs[$trading_cnt]['cgst_amt'];
							$sgst_amt=$sgst_amt+$trading_rs[$trading_cnt]['sgst_amt'];
						?>	
							<tr>
								 <td   ><?php echo $trading_rs[$trading_cnt]['hsn_code'] ?></td>
								 <td   ><?php echo $trading_rs[$trading_cnt]['hsn_desc'] ?></td>
								 <td   ><?php echo $trading_rs[$trading_cnt]['uqc'] ?></td>	
								 <td   align="right" ><?php echo $trading_rs[$trading_cnt]['tot_qnty'] ?></td>						
								 <td   align="right"><?php echo $trading_rs[$trading_cnt]['tot_value'] ?></td>							 
								 <td   align="right"><?php echo $trading_rs[$trading_cnt]['taxable_amt'] ?></td>
								 <td   align="right"><?php echo $trading_rs[$trading_cnt]['igst_amt'] ?></td>	
								 <td   align="right" ><?php echo $trading_rs[$trading_cnt]['cgst_amt'] ?></td>			
								 <td   align="right"><?php echo $trading_rs[$trading_cnt]['sgst_amt'] ?></td>
								 
							 </tr>	
					<?php }} ?>
					
							<tr style="background-color:#FFFF33">
								 <td   colspan="3" >Total</td>
								 <td   align="right" ><?php echo $tot_qnty ?></td>						
								 <td   align="right"><?php echo $tot_value ?></td>							 
								 <td   align="right"><?php echo $taxable_amt ?></td>
								 <td   align="right"><?php echo $igst_amt ?></td>	
								 <td   align="right" ><?php echo $cgst_amt ?></td>			
								 <td   align="right"><?php echo $sgst_amt ?></td>
							 </tr>	
							
				</table>
			<?php } ?>	
			
			<?php if($REPORT_NAME=='HSN_WISE_SUMMARY'){ ?>			
			<table   class="table table-bordered table-striped" id="example">
			<tr ><td width="40"  colspan="21" style="background-color:#FFFF33" align="center">
			<?php echo 'HSN Wise Sale Report From '. $fromdate.' To '.$todate; ?></td></tr>
				<tr  style="background-color:#CCFFFF">
				 <td width="40" >HSN Code</td>	
				 <td width="40" >GST %</td>			 		
				 <td width="40" align="right">Total Quantity</td>
				 <td width="40" align="right">Total Value </td>
				 <td width="40" align="right" >Taxable Value</td>
				 <td width="40" align="right" >Integrated Tax Amount</td>
				 <td width="40" align="right" >Central Tax Amount</td>
				 <td width="40" align="right">State/UT Tax Amount</td>		 
				 </tr>	
				 
					 <?php 
							$trading_rs=$report_data;
							$trading_cnt_total=sizeof($trading_rs); 
							$tot_qnty=$tot_value=$taxable_amt=$igst_amt=$cgst_amt=$sgst_amt=0;
							if($trading_cnt_total>0){
							for($trading_cnt=0;$trading_cnt<$trading_cnt_total;$trading_cnt++)
							{	
							$tot_qnty=$tot_qnty+$trading_rs[$trading_cnt]['tot_qnty'];
							$tot_value=$tot_value+$trading_rs[$trading_cnt]['tot_value'];
							$taxable_amt=$taxable_amt+$trading_rs[$trading_cnt]['taxable_amt'];
							$igst_amt=$igst_amt+$trading_rs[$trading_cnt]['igst_amt'];
							$cgst_amt=$cgst_amt+$trading_rs[$trading_cnt]['cgst_amt'];
							$sgst_amt=$sgst_amt+$trading_rs[$trading_cnt]['sgst_amt'];
						?>	
							<tr>
								 <td width="40" ><?php echo $trading_rs[$trading_cnt]['hsn_code'] ?></td>
								 <td width="40" ><?php echo $trading_rs[$trading_cnt]['gst_per'] ?></td>									
								 <td width="40" align="right" ><?php echo $trading_rs[$trading_cnt]['tot_qnty'] ?></td>						
								 <td width="40" align="right"><?php echo $trading_rs[$trading_cnt]['tot_value'] ?></td>							 
								 <td width="40" align="right"><?php echo $trading_rs[$trading_cnt]['taxable_amt'] ?></td>
								 <td width="40" align="right"><?php echo $trading_rs[$trading_cnt]['igst_amt'] ?></td>	
								 <td width="40" align="right" ><?php echo $trading_rs[$trading_cnt]['cgst_amt'] ?></td>			
								 <td width="40" align="right"><?php echo $trading_rs[$trading_cnt]['sgst_amt'] ?></td>
								 
							 </tr>	
					<?php }} ?>
					
							<tr style="background-color:#FFFF33">
								 <td width="40" colspan="2" >Total</td>
								 <td width="40" align="right" ><?php echo $tot_qnty ?></td>						
								 <td width="40" align="right"><?php echo $tot_value ?></td>							 
								 <td width="40" align="right"><?php echo $taxable_amt ?></td>
								 <td width="40" align="right"><?php echo $igst_amt ?></td>	
								 <td width="40" align="right" ><?php echo $cgst_amt ?></td>			
								 <td width="40" align="right"><?php echo $sgst_amt ?></td>
							 </tr>	
							
				</table>
			<?php } ?>	
			
			
			<?php if($REPORT_NAME=='EXPIRY_REGISTER'){ ?>
			<table   class="table table-bordered table-striped" id="example">
			<tr ><td    colspan="9" style="background-color:#999999"><?php echo 'Expiry Register'; ?></td></tr>
				<tr  style="background-color:#999999">
				 <td   >Product Name</td>
				 <td   >Batch No</td>
				 <td   >Exp date</td>
				 <td   >Mfg date</td>				
				 <td   align="right">Availavle Qnty</td>
				 <td   align="right">Rate</td>
				 <td   align="right">Total</td>			 
				 </tr>			
				 
					 <?php 
							$trading_rs=$report_data;
							$trading_cnt_total=sizeof($trading_rs); 
							$tot_sample=$TOTAL_SELL_RTN=$total_purchase=$total_sale=$total_available_qnty=$total_amt=0;
							if($trading_cnt_total>0){  
							for($trading_cnt=0;$trading_cnt<$trading_cnt_total;$trading_cnt++)
							{	
							$total_available_qnty=$total_available_qnty+$trading_rs[$trading_cnt]['qty_available'];
							$total_amt=$total_amt+$trading_rs[$trading_cnt]['total_amt'];	
							
						?>	
							<tr >
							 <td   >
							 <a href="<?php echo $trading_rs[$trading_cnt]['href'];  ?>">
							 <?php echo $trading_rs[$trading_cnt]['product_name'] ?></a></td>
							 <td   ><?php echo $trading_rs[$trading_cnt]['batchno'] ?></td>
							 <td   ><?php echo $trading_rs[$trading_cnt]['exp_monyr'] ?></td>
							 <td   ><?php echo $trading_rs[$trading_cnt]['mfg_monyr'] ?></td>							
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['qty_available'] ?></td>
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['rate'] ?></td>
							 <td   align="right"><?php echo $trading_rs[$trading_cnt]['total_amt'] ?></td>			 
							 </tr>	
					<?php }} ?>
							<tr  style="background-color:#CC6633">
							 <td   colspan="4"  style="background-color:#CC6633">Total</td>							
							 <td   align="right"><?php echo $total_available_qnty; ?></td>
							 <td   >&nbsp;</td>
							 <td   align="right"><?php echo $total_amt; ?></td>			 
							 </tr>	
				</table>
			<?php } ?>
			
			<!-- MIS REPORT SECTIONS END-->	
			
			
			<!-- ACCOUNT REPORT SECTIONS START-->
			<?php if($REPORT_NAME=='GENERAL_LEDGER'){ ?>
			<table    class="table table-bordered table-striped" id="example">
			
				<tr>			
					<td  colspan="7" align="center" style="background: linear-gradient(#CC9933,#CC9933);">
					<?php
					$acc_name=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$ledger_ac); 		
					echo 'Ledger Transaction of '.$acc_name.' From :'.$fromdate.' To :'.$todate;
					?>
					</td>	
				</tr>
				
				<tr style="background: linear-gradient(#CC9933,#CC9933);">			
					<td  align="left">Date</td>	
					<td  align="left">Particular</td>	
					<td  align="left">Vch Type</td>
					<td  align="left">Vch/Invoice No</td>
					<td  align="right">Debit</td>	
					<td  align="right">Credit</td>				
					<td  align="right">Balance</td> 
				</tr>
			 				
					  <?php 
							$credit_cumulative_balance=$debit_cumulative_balance=$tot_dr_balance=$tot_cr_balance=0;
							$trading_cnt_total=sizeof($report_data); 
							if($trading_cnt_total>0){  
							for($trading_cnt=0;$trading_cnt<$trading_cnt_total;$trading_cnt++)
							{			
							//echo $trading_rs[$trading_cnt]['href'];			
						?>	
						<tr >						 
							<td  ><a href="<?php //echo $report_data[$trading_cnt]['href'];  ?>">
							<?php echo $report_data[$trading_cnt]['tran_date'] ?></a></td>
							 <td><?php echo $report_data[$trading_cnt]['particular'] ?></td>
							 <td  ><?php echo $report_data[$trading_cnt]['tran_type'] ?></td>
							 <td  ><?php echo $report_data[$trading_cnt]['tran_code'] ?></td>	
							 <td align="right"><?php echo $report_data[$trading_cnt]['credit_amount'] ?></td>			
							 <td align="right"><?php echo $report_data[$trading_cnt]['debit_amount'] ?></td>			
							 <td align="right">
							 <?php 
				
								$debit_cumulative_balance=$debit_cumulative_balance+$report_data[$trading_cnt]['credit_amount'];
								$credit_cumulative_balance=$credit_cumulative_balance+$report_data[$trading_cnt]['debit_amount'];
								
								if($debit_cumulative_balance>=$credit_cumulative_balance)
								{ $bal=$debit_cumulative_balance-$credit_cumulative_balance; echo $bal.'Dr';}
								else
								{$bal=$credit_cumulative_balance-$debit_cumulative_balance; echo $bal.'Cr';}
				
								$tot_dr_balance=$tot_dr_balance+$report_data[$trading_cnt]['credit_amount'];
								$tot_cr_balance=$tot_cr_balance+$report_data[$trading_cnt]['debit_amount'];
								
							?></td>  		 
						 </tr>	
				<?php }} ?>
				<tr>
	<td style="background: linear-gradient(#CC9933,#CC9933);"  colspan="4"><strong>Total</strong></td>
	
	<td style="background: linear-gradient(#CC9933,#CC9933);" align="right"><strong><?php echo $tot_dr_balance;?></strong> </td>
	<td style="background: linear-gradient(#CC9933,#CC9933);" align="right"><strong><?php echo $tot_cr_balance;?></strong></td>	
	<td style="background: linear-gradient(#CC9933,#CC9933);" align="right"><strong>
	<?php 
	$drbalance=$crbalance=0;
	if($tot_dr_balance>=$tot_cr_balance)
	{ $drbalance=$tot_dr_balance-$tot_cr_balance; echo round($drbalance,2).' DR';}
	else
	{  $crbalance=$tot_cr_balance-$tot_dr_balance;echo round($crbalance,2).' CR'; }
	
	?>
	</strong></td>			
	</tr>
				
				</table>
			<?php } ?>	
			
			
			<?php if($REPORT_NAME=='TRIAL_BALANCE'){ ?>
			<table   class="table table-bordered table-striped" id="example">
			<tr ><td    colspan="6" style="background-color:#FFFF33" align="center">
			<?php echo 'Trial balance From '. $fromdate.' To '.$todate; ?></td></tr>
			
				<tr  style="background-color:#CCFFFF">
				<!-- <td   >id</td>
				 <td   >Parent id</td>
				 <td   >Level</td>-->
				 
				 <td    colspan="3">A/c Name</td>
				 <td   align="right" >Debit</td>				
				 <td   align="right">Credit</td>
				 </tr>	
					 <?php 
					 	
						$trading_rs=$report_data;
						$trading_cnt_total=sizeof($trading_rs); 
						$total_debit=$total_credit=0;
							if($trading_cnt_total>0){  
							for($trading_cnt=0;$trading_cnt<$trading_cnt_total;$trading_cnt++)
							{	
								$manual_pading='&nbsp;';
								
								/*$child_count=1;	
								echo $childs = "select count(*) totqnty from acc_group_ledgers where parent_id=".$trading_rs[$trading_cnt]['id']."  " ;
								$childs = $this->projectmodel->get_records_from_sql($childs);
								foreach ($childs as $child){$child_count= $child->totqnty;} */
							
								if($trading_rs[$trading_cnt]['index']>0){
								
								for($i=1;$i<=$trading_rs[$trading_cnt]['index'];$i++)
								{$manual_pading=$manual_pading.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}
							
							if($trading_rs[$trading_cnt]['debit_amt']>0 or $trading_rs[$trading_cnt]['credit_amt']>0){
						 ?>
						 
						 <tr >
						 
						 	<?php /*?> <td   ><?php echo $trading_rs[$trading_cnt]['id'] ?></td>
							 <td   ><?php echo $trading_rs[$trading_cnt]['parent_id'] ?></td>	
							 <td   ><?php echo $trading_rs[$trading_cnt]['index'] ?></td><?php */?>
							 
							 <?php if($trading_rs[$trading_cnt]['index']==1){?><!--MAIN GROUP-->
							 <td     bgcolor="#99CC66" colspan="3"><?php echo $manual_pading.$trading_rs[$trading_cnt]['name'] ?></td>
							 <td   align="right"><?php 
							 $total_debit=$total_debit+$trading_rs[$trading_cnt]['debit_amt'];
							 $total_credit=$total_credit+$trading_rs[$trading_cnt]['credit_amt'];
							 
							 echo ($trading_rs[$trading_cnt]['debit_amt'] > 0 ? $trading_rs[$trading_cnt]['debit_amt'] : ' '); ?></td>
							 <td   align="right"><?php echo ($trading_rs[$trading_cnt]['credit_amt'] > 0 ? $trading_rs[$trading_cnt]['credit_amt'] : ' '); ?></td>
							<?php } ?>
							
							<?php if($trading_rs[$trading_cnt]['index']>1){?><!--OTHERS-->
							
								<?php  if($trading_rs[$trading_cnt]['acc_type']=='GROUP'){?>
								<td   ><strong><?php echo $manual_pading.$trading_rs[$trading_cnt]['name'] ?></strong></td>
								<td   align="right">
								<strong><?php echo ($trading_rs[$trading_cnt]['debit_amt'] > 0 ? $trading_rs[$trading_cnt]['debit_amt'].' Dr' : ' '); ?></strong></td>
								 <td   align="right"><strong>
								 <?php echo ($trading_rs[$trading_cnt]['credit_amt'] > 0 ? $trading_rs[$trading_cnt]['credit_amt'].' Cr' : ' '); ?></strong></td>
								 <td   colspan="2" >&nbsp;</td>
								 
								<?php }else {?>
								<td   ><?php echo $manual_pading.$trading_rs[$trading_cnt]['name'] ?></td>
								<td  align="right" ><?php echo  ($trading_rs[$trading_cnt]['debit_amt'] > 0 ? $trading_rs[$trading_cnt]['debit_amt'].' Dr' : ' '); ?></td>
								 <td   align="right"><?php echo ($trading_rs[$trading_cnt]['credit_amt'] > 0 ? $trading_rs[$trading_cnt]['credit_amt'].' Cr' : ' '); ?></td>
								  <td   colspan="2" >&nbsp;</td>
								 <?php }?>
							 
							 <?php } ?>
							 
							 </tr>	
						
							<?php }}}} ?>
							
							 <tr >
							 <td     bgcolor="#99CC66" colspan="3">Total</td>
							 <td   align="right" ><?php echo $total_debit; ?></td>
							 <td   align="right"><?php echo $total_credit; ?></td>
							 </tr>	
							
				</table>
			<?php } ?>	
			
			
			<?php if($REPORT_NAME=='PROFIT_LOSS_ACCOUNT'){ ?>
			<table   class="table table-bordered table-striped" id="example">
			<tr ><td    colspan="6" style="background-color:#FFFF33" align="center">
			Trading A/c <?php echo  ' From  '.$fromdate.' To '.$todate; ?></td></tr>
			
				<tr  style="background-color:#CCFFFF">
				 <td   >A/c Name</td>
				 <td   >A/c Name</td>
				 <td   >A/c Name</td>
				 <td   >A/c Name</td>
				 <td   >A/c Name</td>
				 <td   >A/c Name</td>			 
				
				 </tr>
				 
												
					 <?php 
					 	
						$trading_rs=$report_data;
						$trading_cnt_total=sizeof($trading_rs); 
						$total_debit=$total_credit=0;
						
							if($trading_cnt_total>0){  
							for($trading_cnt=0;$trading_cnt<$trading_cnt_total;$trading_cnt++)
							{	
								$manual_pading='&nbsp;';
														
								/*if($trading_rs[$trading_cnt]['index']>0){								
								for($i=1;$i<=$trading_rs[$trading_cnt]['index'];$i++)
								{$manual_pading=$manual_pading.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';}*/
							
							//if($trading_rs[$trading_cnt]['debit_amt']>0 or $trading_rs[$trading_cnt]['credit_amt']>0){
						 ?>
						 
						 <tr >
							 <td  bgcolor="#99CC66" ><?php echo $manual_pading.$trading_rs[$trading_cnt]['left_ac_name']; ?></td>
							 <td  align="right" ><?php echo  ($trading_rs[$trading_cnt]['left_ac_debit_amt'] > 0 ? 
							 $trading_rs[$trading_cnt]['left_ac_debit_amt'].' Dr' : ' '); ?></td>							 
							 <td   align="right"><?php echo ($trading_rs[$trading_cnt]['left_ac_credit_amt'] > 0 ? 
							 $trading_rs[$trading_cnt]['left_ac_credit_amt'].' Cr' : ' '); ?></td>	
							 
							 	
							 
							 <td  bgcolor="#99CC66" ><?php echo $manual_pading.$trading_rs[$trading_cnt]['right_ac_name']; ?></td>
							 <td  align="right" ><?php echo  ($trading_rs[$trading_cnt]['right_ac_debit_amt'] > 0 ? 
							 $trading_rs[$trading_cnt]['right_ac_debit_amt'].' Dr' : ' '); ?></td>
							 
							 <td   align="right"><?php echo ($trading_rs[$trading_cnt]['right_ac_credit_amt'] > 0 ? 
							 $trading_rs[$trading_cnt]['right_ac_credit_amt'].' Cr' : ' '); ?></td>					 
											 
						 </tr>		 
							 
						 <?php }}//} ?>
						
				</table>
			<?php } ?>	
			
		
			<!-- ACCOUNT REPORT SECTIONS END-->
				
</div>	
  
   <?php } ?>

<div class="panel panel-primary" >
			<div class="panel-body" align="center" style="background-color:#3c8dbc">
					<button type="button" class="btn btn-danger" onclick="myExportToExcel();">Excel</button>	
			</div>
</div> 



<script>
$(document).ready(function() {

    $('#example tr').click(function() {
        var href = $(this).find("a").attr("href");
        if(href) {window.location = href;}
    });

});
</script>

 <script>
  
     $("#fromdate").datepicker({
      changeMonth: true,
      changeYear: true
    });
 	
	$("#fromdate").change(function() {
	 var  trandate = $('#fromdate').val();
	 trandate=
	 trandate.substring(6, 10)+'-'+
	 trandate.substring(0, 2)+'-'+
	 trandate.substring(3, 5);
	 $("#fromdate").val(trandate);
	});
	
	 $("#todate").datepicker({
      changeMonth: true,
      changeYear: true
    });
 	
	$("#todate").change(function() {
	 var  trandate = $('#todate').val();
	 trandate=
	 trandate.substring(6, 10)+'-'+
	 trandate.substring(0, 2)+'-'+
	 trandate.substring(3, 5);
	 $("#todate").val(trandate);
	});
	
  </script>
  

	
	