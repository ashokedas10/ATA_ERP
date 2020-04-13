

<!--data table start-->
<style type="text/css">
<!--
.style1 {
	color: #CC3300;
	font-weight: bold;
	font-size: 14px;
}
-->
</style>
<h2><span class="tcat">Doctor Commission Set</span></h2>

<form action="<?php echo ADMIN_BASE_URL?>Project_controller/doctor_commission_set/listing/" 
	name="frmreport" id="frmreport" method="post">
	<table  border="0" cellpadding="0" cellspacing="0" class="srstable" style="width:100%"> 
	
	 <tr>

	<td width="127" class="srscell-head-lft">   Date</td>

		<td class="srscell-body"  >
			<select id="doctor_mstr_id" class="form-control select2"  name="doctor_mstr_id">
			  <option value="0">Select Product</option>
				  <?php	foreach ($doctor_list as $row){?>
				  <option value="<?php echo $row->id; ?>" 
					<?php if($row->id==$doctor_mstr_id) 
					{ echo 'selected="selected"'; } ?>> 
					<?php echo $row->name; ?> 
				</option>
				  <?php } ?>
			</select>
	   </td>
		<td class="srscell-body"><input name="submit" type="submit" value="Submit" class="btn srs-btn-reset"/>
		
	
		</td>
	</tr>
          
  </table>
</form>

<form id="frm" name="frm" method="post" 
action="<?php echo ADMIN_BASE_URL?>Project_controller/doctor_commission_set/save/" >
 <input type="hidden" value="<?php echo $doctor_mstr_id; ?>" name="doctor_mstr_id" id="doctor_mstr_id">
 

  <table  class="srstable"  style="width:100%">
	<tr>
	<td   colspan="9"  align="center"><span class="style1">
	 <?php 	 
	 $whr=" id=".$doctor_mstr_id;
	 $doc_name=$this->projectmodel->GetSingleVal('name','doctor_mstr',$whr);				
	 echo "Commission Set for :".$doc_name;	 ?>
	 </td>
	</tr>
	
	
	<tr style="background-color:#996633">
		<td width="23%" >Product Group  </td>
		<td width="77%" >Commission %</td>
	</tr>
	
	 <?php 

		$sql="select * from misc_mstr where  mstr_type='PRODUCT_GROUP'";
		$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
		foreach ($rowrecord as $row1)
		{
		   $product_group_id=$row1->id;
		   $product_group_name=$row1->name;
		   $commission=0;
		   
			$records="select * from doctor_commission_set where 	doctor_mstr_id=".$doctor_mstr_id." and product_group_id=".$product_group_id;
			$records = $this->projectmodel->get_records_from_sql($records);	
			foreach ($records as $record)
			{$commission=$record->commission_percentage;}
		
		
		?>
	
	<tr>
		<td class="srscell-body"><?php echo $product_group_name; ?></td>
		<td class="srscell-body">
		<input  class="srs-txt-small" name="doc_commission<?PHP echo $product_group_id;?>" id="doc_commission<?PHP echo $product_group_id;?>" 
		 value="<?PHP echo $commission;?>"  />
		</td>
	</tr>
	
	<?php } ?>
	
<tr>

<td valign="top" align="center" colspan="9" class="srscell-body"> 
<input type="submit" class="srs-btn-submit" value="Save" id="submit" name="submit">
</td>
</tr>


  </table>

</form>


