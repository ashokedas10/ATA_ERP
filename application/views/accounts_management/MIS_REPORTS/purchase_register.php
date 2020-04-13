<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
		<button type="button" class="btn btn-primary" onClick="myExportToExcel();">Excel</button>
  </div>
  </div>
	
</div></div></div>
</form>

 <!--REPORT PARAMETER SECTION END-->
  
  <div id="printablediv" class="block"  style="overflow:scroll"> 	
	<section class="invoice">			
        <div class="row" >
          <div class="col-xs-12 table-responsive">
		  		  
 		  <div  style="overflow:scroll">
<table   class="table table-bordered table-striped">
	    <thead>
		
		 <tr><td colspan="8" align="center" ><?php  echo 'Report from '.$fromdate.' to '.$todate; ?></td></tr>
			
	        <tr>
			<?php 			
			foreach($GridHeader as $key=>$hdr){
			 $cn_values =explode("-", trim($hdr));			
			 ?>
	            <td width="55"  align="<?php echo $cn_values[1]; ?>" bgcolor="#999999"><?php echo $cn_values[0]; ?></td>
	        <?php } ?>  			
            </tr>
        </thead>
       
	   <tbody>
			<?php 
				$total_amt_sum=$tot_discount_sum=$totvatamt_sum=$grandtot_sum=0;
				$group1_cnt=sizeof($rs);	 
				for($group1=0;$group1<$group1_cnt;$group1++)
				{		
				$total_amt_sum=$total_amt_sum+$rs[$group1]['total_amt'];
				$tot_discount_sum=$tot_discount_sum+$rs[$group1]['tot_discount'];
				$totvatamt_sum=$totvatamt_sum+$rs[$group1]['totvatamt'];
				$grandtot_sum=$grandtot_sum+$rs[$group1]['grandtot'];	
			?>
			 <tr >
			
				<td width="40" ><?php echo $rs[$group1]['invoice_no']; ?></td>
				<td width="40" ><?php echo $rs[$group1]['invoice_date']; ?></td>
				<td width="40" ><?php 						
				$whr=" id=".$rs[$group1]['tbl_party_id'];
				echo $this->projectmodel->GetSingleVal('acc_name 	','acc_group_ledgers',$whr);					
				?></td>
				<td width="40" align="right" ><?php echo $rs[$group1]['total_amt']; ?></td>
				<td width="40" align="right"><?php echo $rs[$group1]['tot_discount']; ?></td>
				<td width="40" align="right"><?php echo $rs[$group1]['totvatamt']; ?></td>
				<td width="40" align="right" ><?php echo $rs[$group1]['grandtot']; ?></td>
				
			</tr>			
			
			<?php } ?>	
			
			 <tr>
				<td width="40"  colspan="3" bgcolor="#999999"><strong>Total</strong></td>
				<td width="40" bgcolor="#999999" align="right"><strong><?php echo $total_amt_sum; ?></strong></td>
				<td width="40" bgcolor="#999999" align="right"><strong><?php echo $tot_discount_sum; ?></strong></td>
				<td width="40" bgcolor="#999999" align="right"><strong><?php echo $totvatamt_sum; ?></strong></td>
				<td width="40" bgcolor="#999999" align="right"><strong><?php echo $grandtot_sum; ?></strong></td>
			</tr>			
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
  

	
	