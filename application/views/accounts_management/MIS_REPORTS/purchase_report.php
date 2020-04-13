<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 
<style type="text/css">
<!--
.style1 {color: #FF6633}
-->
</style>
<div class="panel panel-primary" >
	
	  <div class="panel-body" align="center" style="background-color:#99CC00">
		<h3><span class="label label-default"><?php echo $FormRptName;?></span>
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
  
<form id="frm" name="frm" method="post" action="<?php echo $tran_link;?>save/" >
<div class="panel panel-primary"  style="background-color:#E67753">
 <div class="panel-footer">
 <div class="form-row"> 

<?php    
	
		$SectionPRE='';
		$rownoPRE=1;
			
		$records="select * from frmrpttemplatedetails 
		where frmrpttemplatehdrID=".$frmrpttemplatehdrID." 
		and SectionType='HEADER' order by Section,FieldOrder ";
		$records = $this->projectmodel->get_records_from_sql($records);	
		foreach ($records as $record)
		{
			//RELATED TO ROW DIV CLASS
			$SectionType=$record->SectionType; //HEADER,...
			$Section=$record->Section;
			$FieldOrder=$record->FieldOrder;
			$DIVClass=$record->DIVClass; // col size
			$LabelName=$record->LabelName;
			
			//RELATED TO FIELD
			$InputName=$record->InputName;
			$InputType=$record->InputType;
			$Inputvalue=$record->Inputvalue;
			$tran_table_name=$record->tran_table_name;
			$RecordSet=$record->RecordSet;
			$MainTable=$record->MainTable;
			$LinkField=$record->LinkField;
			$LogoType=$record->LogoType;
			
			//RELATED TO LINK TABLE OF THE FIELD
			//DYNAMIK RECORD SET ...USEFL FOR DROPDOWN LIST 
			$datafields=$record->datafields;
			$table_name=$record->table_name;
			$where_condition=$record->where_condition;
			$orderby=$record->orderby;
			
			if($datafields<>'')
			{ 			
			$RecordSet=$this->projectmodel->get_records_from_sql($datafields);}
												
			$InputName=
			$this->projectmodel->create_field($InputType,$LogoType,
			$LabelName,$InputName,$Inputvalue,$RecordSet);
	  ?>

<?php   if($SectionType=='HEADER'){ ?>	
			
<div class="form-group col-md-<?php echo $DIVClass; ?>">
<?php echo $InputName; ?>
</div>

<?php } ?>

<?php }?>





<div class="panel-body" align="center">
		
  </div>  
  <div class="panel panel-primary"  style="background-color:#4caf50">
  
   <div class="panel-body" align="center">
		<button type="submit" class="btn btn-primary" id="Save" name="Save">Save</button>
		<button type="button" class="btn btn-primary" onclick="myExportToExcel();">Excel</button>
  </div>
  </div>
	
</div></div></div>
</form>

 <!--REPORT PARAMETER SECTION END-->
  
  <div id="printablediv" class="block"  style="overflow:scroll"> 	
	<section class="invoice">			
        <div class="row" >
          <div class="col-xs-12 table-responsive">
		  		  
   
<!--B2B PARTY-->	
<div  style="overflow:scroll">
<table   class="table table-bordered table-striped">
	    <thead>
		
		 <tr><td colspan="8" align="center" ><?php  echo 'B2B Party Purchase Report from '.$fromdate.' to '.$todate; ?></td></tr>
			
	        <tr>
			<?php 			
			foreach($GridHeader as $key=>$hdr){
			 $cn_values =explode("-", trim($hdr));			
			 ?>
	            <td width="55"  align="<?php echo $cn_values[1]; ?>"><?php echo $cn_values[0]; ?></td>
	        <?php } ?>  			
            </tr>
        </thead>
       
	   <tbody>
			<?php 
				$group1_cnt=sizeof($rs);	 
				for($group1=0;$group1<$group1_cnt;$group1++)
				{		
				
				
				$invcount=0;
				$whr=" tbl_party_id=".$rs[$group1]['id']." and invoice_date between '$fromdate' and '$todate' and status='PURCHASE'";
				$sqlfields="select count(*) invcount from invoice_summary where ".$whr." ";
				$fields = $this->projectmodel->get_records_from_sql($sqlfields);
				foreach ($fields as $field){$invcount=$field->invcount;}
				
				$gstno='';
				if($rs[$group1]['ref_table_id']>0)
				{
				echo $whr=" id=".$rs[$group1]['ref_table_id'];
				$party=$this->projectmodel->GetMultipleVal('*','tbl_party',$whr,' party_name');
				$gstno=$party[0]['GSTNo'];
				}
				
				if($invcount>0 && $gstno<>''){
			?>
			 <tr style="background-color:#99CC00">
			<td ><?php echo $rs[$group1]['id']; ?></td>
			<td width="40" ><?php echo $rs[$group1]['acc_name']; ?></td>
			<td width="54" ><?php 
				if($rs[$group1]['ref_table_id']>0)
				{
				$whr=" id=".$rs[$group1]['ref_table_id'];
				$party=$this->projectmodel->GetMultipleVal('*','tbl_party',$whr,' party_name');
				echo $party[0]['GSTNo'];
				}
			 ?></td>
			<td width="82"  align="right">
			<?php  
			
				$outstanding=0;
				$cr_open_balance=$this->accounts_model->ledger_opening_balance($rs[$group1]['id'],$todate,'CR');
				
				$dr_open_balance=$this->accounts_model->ledger_opening_balance($rs[$group1]['id'],$todate,'DR');
				
				 $outstanding=$dr_open_balance-$cr_open_balance;
				
				if($dr_open_balance>$cr_open_balance)
				{echo $outstanding.'(DR)';}
				else if($dr_open_balance<$cr_open_balance)
				{echo abs($outstanding).'(CR)';}
				else
				{ echo ''; }	
	
			?></td>
			</tr>
						
			<?php 
						
				$whr=" tbl_party_id=".$rs[$group1]['id']." and invoice_date between '$fromdate' and '$todate' and status='PURCHASE'";
				$invoices=$this->projectmodel->GetMultipleVal('*','invoice_summary',$whr,' invoice_date');
				$group2_cnt=sizeof($invoices);	 
				
				if($group2_cnt>0)
				{
			?>
			
			<tr>
				<td >Inv No</td>
				<td >Date</td>
				<td >Trade Price</td>
				<td >Discount</td>
				<td width="98" >Taxable Amount</td>
				<td colspan="6" >GST DETAILS</td>
				<td width="69" >Total GST</td>
				<td width="77" >Grand Total</td>	
				<td width="51" > Rcv</td>	
				<td width="48" >Due </td>				
			</tr>
			<tr>
					<td  colspan="5">&nbsp;</td>
					<td width="88" >SGST%</td>
					<td width="86" >SGST Amt</td>
					<td width="64" >CGST%</td>
					<td width="73" >CGST Amt</td>
					<td width="50" >IGST%</td>
					<td width="72" >IGST Amt</td>	
					<td  colspan="4">&nbsp;</td>						
			</tr>
			
			
			<?php 
			for($group2=0;$group2<$group2_cnt;$group2++)
			{
			
				$tax_details=array();
				$tax_details_cnt=0;
				$sql_vatper="select distinct(tax_ledger_id) tax_ledger_id
				from invoice_details where invoice_summary_id=".$invoices[$group2]['id']."  ";
				$rowsql_vatper = $this->projectmodel->get_records_from_sql($sql_vatper);	
				foreach ($rowsql_vatper as $rows_vatper)
				{ 
					$tax_ledger_id=$rows_vatper->tax_ledger_id;	
					
					$taxamt=0;	
					$records="select cgst_rate,sum(cgst_amt) cgst_amt,sgst_rate,sum(sgst_amt) sgst_amt,igst_rate,sum(igst_amt) igst_amt,
					sum(taxable_amt) taxable_amt from invoice_details where invoice_summary_id=".$invoices[$group2]['id']." 
					and  tax_ledger_id=".$tax_ledger_id;
					$records = $this->projectmodel->get_records_from_sql($records);	
					foreach ($records as $record)
					{
						$tax_details[$tax_details_cnt]['sgst_rate']=$record->sgst_rate;
						$tax_details[$tax_details_cnt]['sgst_amt']=$record->sgst_amt;
						
						$tax_details[$tax_details_cnt]['cgst_rate']=$record->cgst_rate;
						$tax_details[$tax_details_cnt]['cgst_amt']=$record->cgst_amt;
						
						$tax_details[$tax_details_cnt]['igst_rate']=$record->igst_rate;
						$tax_details[$tax_details_cnt]['igst_amt']=$record->igst_amt;
						$tax_details[$tax_details_cnt]['taxable_amt']=$record->taxable_amt;
					}
					$tax_details_cnt=$tax_details_cnt+1;
				}
			
			?>
			 <tr>
				<td ><?php echo $invoices[$group2]['invoice_no']; ?></td>
				<td ><?php echo $invoices[$group2]['invoice_date']; ?></td>
				<td ><?php echo $invoices[$group2]['total_amt']; ?></td>
				<td ><?php echo $invoices[$group2]['tot_discount']+$invoices[$group2]['tot_cash_discount']; ?></td>
				<td ><?php echo $invoices[$group2]['total_amt']-$invoices[$group2]['tot_discount']; ?></td>
				
				<td ><?php echo $tax_details[0]['sgst_rate']; ?></td>
				<td ><?php echo $tax_details[0]['sgst_amt']; ?></td>
				<td ><?php echo $tax_details[0]['cgst_rate']; ?></td>
				<td ><?php echo $tax_details[0]['cgst_amt']; ?></td>
				<td ><?php echo $tax_details[0]['igst_rate']; ?></td>
				<td ><?php echo $tax_details[0]['igst_amt']; ?></td>				 
				<td ><?php echo $invoices[$group2]['totvatamt']; ?></td>
				<td ><?php echo $invoices[$group2]['grandtot']; ?></td>
				<td ><?php echo $tot_paid=$this->accounts_model->bill_wise_outstanding('invoice_summary',$invoices[$group2]['id'],'MINUS');
				 ?></td>
				<td ><?php echo $invoices[$group2]['grandtot']-$tot_paid; ?></td>
				
			</tr>
			
			<?php }}}} ?>	
	 </tbody>
</table>   
</div>
			
<!--B2C PARTY-->				
<div  style="overflow:scroll">
<table   class="table table-bordered table-striped">
	    <thead>
		
		 <tr><td colspan="8" align="center" ><?php  echo 'B2C Party Purchase Report from '.$fromdate.' to '.$todate; ?></td></tr>
			
	        <tr>
			<?php 			
			foreach($GridHeader as $key=>$hdr){
			 $cn_values =explode("-", trim($hdr));			
			 ?>
	            <td width="55"  align="<?php echo $cn_values[1]; ?>"><?php echo $cn_values[0]; ?></td>
	        <?php } ?>  			
            </tr>
        </thead>
       
	   <tbody>
			<?php 
				$group1_cnt=sizeof($rs);	 
				for($group1=0;$group1<$group1_cnt;$group1++)
				{		
				
				$invcount=0;
				$whr=" tbl_party_id=".$rs[$group1]['id']." and invoice_date between '$fromdate' and '$todate' and status='PURCHASE'";
				$sqlfields="select count(*) invcount from invoice_summary where ".$whr." ";
				$fields = $this->projectmodel->get_records_from_sql($sqlfields);
				foreach ($fields as $field){$invcount=$field->invcount;}
				
				$gstno='';
				if($rs[$group1]['ref_table_id']>0)
				{
				$whr=" id=".$rs[$group1]['ref_table_id'];
				$party=$this->projectmodel->GetMultipleVal('*','tbl_party',$whr,' party_name');
				$gstno=$party[0]['GSTNo'];
				}
				
				if($invcount>0 && $gstno==''){
			?>
			 <tr style="background-color:#99CC00">
			<td ><?php echo $rs[$group1]['id']; ?></td>
			<td width="40" ><?php echo $rs[$group1]['acc_name']; ?></td>
			<td width="54" ><?php 
				if($rs[$group1]['ref_table_id']>0)
				{
				$whr=" id=".$rs[$group1]['ref_table_id'];
				$party=$this->projectmodel->GetMultipleVal('*','tbl_party',$whr,' party_name');
				echo $party[0]['GSTNo'];
				}
			 ?></td>
			<td width="82"  align="right">
			<?php  
			
				$outstanding=0;
				$cr_open_balance=$this->accounts_model->ledger_opening_balance($rs[$group1]['id'],$todate,'CR');
				
				$dr_open_balance=$this->accounts_model->ledger_opening_balance($rs[$group1]['id'],$todate,'DR');
				
				 $outstanding=$dr_open_balance-$cr_open_balance;
				
				if($dr_open_balance>$cr_open_balance)
				{echo $outstanding.'(DR)';}
				else if($dr_open_balance<$cr_open_balance)
				{echo abs($outstanding).'(CR)';}
				else
				{ echo ''; }	
	
			?></td>
			</tr>
						
			<?php 
						
				$whr=" tbl_party_id=".$rs[$group1]['id']." and invoice_date between '$fromdate' and '$todate' and status='PURCHASE'";
				$invoices=$this->projectmodel->GetMultipleVal('*','invoice_summary',$whr,' invoice_date');
				$group2_cnt=sizeof($invoices);	 
				
				if($group2_cnt>0)
				{
			?>
			
			<tr>
				<td >Inv No</td>
				<td >Date</td>
				<td >Trade Price</td>
				<td >Discount</td>
				<td width="98" >Taxable Amount</td>
				<td colspan="6" >GST DETAILS</td>
				<td width="69" >Total GST</td>
				<td width="77" >Grand Total</td>	
				<td width="51" > Rcv</td>	
				<td width="48" >Due </td>				
			</tr>
			<tr>
					<td  colspan="5">&nbsp;</td>
					<td width="88" >SGST%</td>
					<td width="86" >SGST Amt</td>
					<td width="64" >CGST%</td>
					<td width="73" >CGST Amt</td>
					<td width="50" >IGST%</td>
					<td width="72" >IGST Amt</td>	
					<td  colspan="4">&nbsp;</td>						

			</tr>
			
			
			<?php 
			for($group2=0;$group2<$group2_cnt;$group2++)
			{
			
				$tax_details=array();
				$tax_details_cnt=0;
				$sql_vatper="select distinct(tax_ledger_id) tax_ledger_id
				from invoice_details where invoice_summary_id=".$invoices[$group2]['id']."  ";
				$rowsql_vatper = $this->projectmodel->get_records_from_sql($sql_vatper);	
				foreach ($rowsql_vatper as $rows_vatper)
				{ 
					$tax_ledger_id=$rows_vatper->tax_ledger_id;	
					
					$taxamt=0;	
					$records="select cgst_rate,sum(cgst_amt) cgst_amt,sgst_rate,sum(sgst_amt) sgst_amt,igst_rate,sum(igst_amt) igst_amt,
					sum(taxable_amt) taxable_amt from invoice_details where invoice_summary_id=".$invoices[$group2]['id']." 
					and  tax_ledger_id=".$tax_ledger_id;
					$records = $this->projectmodel->get_records_from_sql($records);	
					foreach ($records as $record)
					{
						$tax_details[$tax_details_cnt]['sgst_rate']=$record->sgst_rate;
						$tax_details[$tax_details_cnt]['sgst_amt']=$record->sgst_amt;
						
						$tax_details[$tax_details_cnt]['cgst_rate']=$record->cgst_rate;
						$tax_details[$tax_details_cnt]['cgst_amt']=$record->cgst_amt;
						
						$tax_details[$tax_details_cnt]['igst_rate']=$record->igst_rate;
						$tax_details[$tax_details_cnt]['igst_amt']=$record->igst_amt;
						$tax_details[$tax_details_cnt]['taxable_amt']=$record->taxable_amt;
					}
					$tax_details_cnt=$tax_details_cnt+1;
				}
			
			?>
			 <tr>
				<td ><?php echo $invoices[$group2]['invoice_no']; ?></td>
				<td ><?php echo $invoices[$group2]['invoice_date']; ?></td>
				<td ><?php echo $invoices[$group2]['total_amt']; ?></td>
				<td ><?php echo $invoices[$group2]['tot_discount']+$invoices[$group2]['tot_cash_discount']; ?></td>
				<td ><?php echo $invoices[$group2]['total_amt']-$invoices[$group2]['tot_discount']; ?></td>
				
				<td ><?php echo $tax_details[0]['sgst_rate']; ?></td>
				<td ><?php echo $tax_details[0]['sgst_amt']; ?></td>
				<td ><?php echo $tax_details[0]['cgst_rate']; ?></td>
				<td ><?php echo $tax_details[0]['cgst_amt']; ?></td>
				<td ><?php echo $tax_details[0]['igst_rate']; ?></td>
				<td ><?php echo $tax_details[0]['igst_amt']; ?></td>				 
				<td ><?php echo $invoices[$group2]['totvatamt']; ?></td>
				<td ><?php echo $invoices[$group2]['grandtot']; ?></td>
				<td ><?php echo $tot_paid=$this->accounts_model->bill_wise_outstanding('invoice_summary',$invoices[$group2]['id'],'MINUS');
				 ?></td>
				<td ><?php echo $invoices[$group2]['grandtot']-$tot_paid; ?></td>
				
			</tr>
			
			<?php }}}} ?>	
	 </tbody>
</table>   
</div>

			
 
          </div><!-- /.col -->
        </div><!-- /.row -->	
      </section><!-- /.content -->
</div>
  


 <script>
  
     $("#tran_date").datepicker({
      changeMonth: true,
      changeYear: true
    });
 	
	$("#tran_date").change(function() {
	 var  trandate = $('#tran_date').val();
	 trandate=
	 trandate.substring(6, 10)+'-'+
	 trandate.substring(0, 2)+'-'+
	 trandate.substring(3, 5);
	 $("#tran_date").val(trandate);
	});
	
	
	 $("#chqdate").datepicker({
      changeMonth: true,
      changeYear: true
    });
 	
	$("#chqdate").change(function() {
	 var  trandate = $('#chqdate').val();
	 trandate=
	 trandate.substring(6, 10)+'-'+
	 trandate.substring(0, 2)+'-'+
	 trandate.substring(3, 5);
	 $("#chqdate").val(trandate);
	});
	
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
  


	
	