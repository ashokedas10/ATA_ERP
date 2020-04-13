<style type="text/css">
<!--
.style1 {
	color: #CC3300;
	font-weight: bold;
	font-size: 14px;
}
-->
</style>
 <h2><span class="tcat">Template Form Report </span> </h2>

 <a href="<?php echo $tran_link.'list/0/0/'; ?>">
 <button class="btn btn-block btn-success">Add New </button>
 </a>


<p align="center"><span class="style1">
<?php echo $this->session->userdata('alert_msg'); ?></span></p>

<div class="block" style="overflow:scroll">
<form id="challan_trip" name="challan_trip"  method="post" 
action="<?php echo ADMIN_BASE_URL?>Project_controller/TempleteFormReport/save/<?php echo $this->uri->segment(4).'/'.$this->uri->segment(5).'/'; ?>" 
onsubmit="return validateForm()">
      	
		<input type="hidden" value="<?php echo $id_header; ?>" 
		  name="id_header" id="id_header">		
		    
		  <input type="hidden" value="<?php echo $id_detail; ?>" 
		  name="id_detail" id="id_detail">	
		  		  
		  <input type="hidden" value=""  name="LogoType" id="LogoType">	
		 	   
			   
			        
		 <table  class="srstable" style="width:100%">
           <tr>
             <td class="srscell-head-divider" colspan="4"> Details</td>
           </tr>
		   
		   <tr>
             <td width="7%" class="srscell-head-lft">Name</td>
             <td width="19%" class="srscell-body"> 
			 <input type="text" id="FormRptName" class="srs-txt"
			  value="<?php echo $FormRptName; ?>" 
			  name="FormRptName"  autocomplete="off" />
		     </td>
             <td  width="16%" class="srscell-head-lft">Type</td>
             <td  width="58%" class="srscell-body">
			  
			   <select id="Type" name="Type" class="srs-dropdwn">
			   <option value="FORM" <?php if($Type=='FORM') 
			   { echo 'selected="selected"'; } ?>>FORM</option>
			   
			    <option value="GRID" <?php if($Type=='GRID') 
			  { echo 'selected="selected"'; } ?>>GRID</option>
			   
			  <option value="REPORT" <?php if($Type=='REPORT') 
			  { echo 'selected="selected"'; } ?>>REPORT</option>
				
               </select>
		     </td>
           </tr>
		   
		   <tr>
             <td width="7%" class="srscell-head-lft">Order By</td>
             <td width="19%" class="srscell-body"> 
			 <input type="text" id="OrderBy" class="srs-txt"
			  value="<?php echo $OrderBy; ?>"  name="OrderBy"   />
		     </td>
			  <td width="16%" class="srscell-head-lft">Table Name</td>
             <td width="58%" class="srscell-body"> 
			 <input type="text" id="TableName" class="srs-txt"
			  value="<?php echo $TableName; ?>"  name="TableName" autocomplete="off"  />
		     </td>
			 
            
           </tr>
		   
		   <tr>
		    <td  width="7%" class="srscell-head-lft">Data Fields 1</td>
             <td class="srscell-body" colspan="3">
			   <input type="text" id="DataFields" 
			  value="<?php echo $DataFields; ?>"  name="DataFields"  style="width:1200px;" autocomplete="off"  />
			 
		     </td>
		   </tr>
		   
		   <tr>
		    <td  width="7%" class="srscell-head-lft">Data Fields 2</td>
             <td class="srscell-body" colspan="3">
			   <input type="text" id="DataFields2" 
			  value="<?php echo $DataFields2; ?>"  name="DataFields2"  style="width:1200px;" autocomplete="off"  />
			 
		     </td>
		   </tr>
		   
		   <tr>
		    <td  width="7%" class="srscell-head-lft">Data Fields 3</td>
             <td class="srscell-body" colspan="3">
			   <input type="text" id="DataFields3" 
			  value="<?php echo $DataFields3; ?>"  name="DataFields3"  style="width:1200px;" autocomplete="off"  />
			 
		     </td>
		   </tr>
		   
		   <tr>
		    <td  width="7%" class="srscell-head-lft">Data Fields 4</td>
             <td class="srscell-body" colspan="3">
			   <input type="text" id="DataFields4" 
			  value="<?php echo $DataFields4; ?>"  name="DataFields4"  style="width:1200px;" autocomplete="off"  />
			 
		     </td>
		   </tr>
		   
		    <tr>
			 <td  width="7%" class="srscell-head-lft">Grid header</td>
             <td class="srscell-body" colspan="3">
			   <input type="text" id="GridHeader" 
			  value="<?php echo $GridHeader; ?>"  name="GridHeader"  style="width:1200px;"  autocomplete="off" />
			 
		     </td>
            
           </tr>
		   <tr>
             
			  <td  width="16%" class="srscell-head-lft">Where Condition</td>
             <td  width="58%" class="srscell-body" colspan="3">
			   <input type="text" id="WhereCondition" 
			  value="<?php echo $WhereCondition; ?>"  name="WhereCondition" style="width:1200px;"  />
			 
		     </td>
           </tr>
		   
		   
		    
		    <tr>
             <td width="7%" class="srscell-head-lft">Controller Function Link</td>
             <td width="19%" class="srscell-body"> 
			 <input type="text" id="ControllerFunctionLink" class="srs-txt"
			  value="<?php echo $ControllerFunctionLink; ?>"  
			  name="ControllerFunctionLink"  autocomplete="off" />
		     </td>
             <td  width="16%" class="srscell-head-lft">View Path</td>
             <td  width="58%" class="srscell-body">
			   <input type="text" id="ViewPath" class="srs-txt"
			  value="<?php echo $ViewPath; ?>"  name="ViewPath" autocomplete="off"  />
			 
		     </td>
           </tr>
		   
		   
		   <tr>
             <td width="7%" class="srscell-head-lft">Display Grid</td>
             <td width="19%" class="srscell-body"> 
			  <select id="DisplayGrid" name="DisplayGrid" class="srs-dropdwn">
			   <option value="YES" <?php if($DisplayGrid=='YES') 
			   { echo 'selected="selected"'; } ?>>YES</option>
			   
			  <option value="NO" <?php if($DisplayGrid=='NO') 
			  { echo 'selected="selected"'; } ?>>NO</option>
				
               </select>
		     </td>
             <td  width="16%" class="srscell-head-lft">NEWE NTRY BUTTON</td>
             <td  width="58%" class="srscell-body">
			  
			 <select id="NEWENTRYBUTTON" name="NEWENTRYBUTTON" class="srs-dropdwn">
			   <option value="YES" <?php if($NEWENTRYBUTTON=='YES') 
			   { echo 'selected="selected"'; } ?>>YES</option>
			   
			  <option value="NO" <?php if($NEWENTRYBUTTON=='NO') 
			  { echo 'selected="selected"'; } ?>>NO</option>
				
               </select>
		     </td>
           </tr>
		   
		   
		   <tr>
             <td width="7%" class="srscell-head-lft">Parent Form Name</td>
             <td width="19%" class="srscell-body"> 
			 <select id="parent_id"  class="form-control select2" name="parent_id">
			 <option value="0">No parent</option>
					   
			<?php 
			$DATABASE=DATABASE;
			$records = "SELECT * FROM frmrpttemplatehdr order by FormRptName";
			$records = $this->projectmodel->get_records_from_sql($records);		
				foreach ($records as $record)
				{ 						
				?>
				<option value="<?php echo $record->id; ?>"
				<?php if($parent_id==$record->id) 
				 { echo 'selected="selected"'; } ?>>
				<?php echo $record->FormRptName; ?>
				</option>
		  
			 <?php } ?>
			   </select>
		     </td>
             <td class="srscell-body" colspan="2">
			 Parent table Field:
			   <input type="text" id="parent_table_field_name" class="srs-txt"	
			 value="<?php echo $parent_table_field_name; ?>"  name="parent_table_field_name"   />
			 &nbsp;
			 Child table Field:<input type="text" id="child_table_field_name" class="srs-txt"	
			 value="<?php echo $child_table_field_name; ?>"  name="child_table_field_name"   />
			 
			 &nbsp;
			 Child Section's Ids (12,23..):<input type="text" id="child_ids" class="srs-txt"	
			 value="<?php echo $child_ids; ?>"  name="child_ids"   />
				
		     </td>
           </tr>
		   
		   
		   
	</table>
	<p></p>
		   
       <table  style="width:100%"  border="0" 
		   cellpadding="0" cellspacing="0"  class="srstable"> 
		   
		   
		   <tr>
               <td  class="srscell-body"    colspan="4">
		   
		   <table  style="width:100%"  border="0" 
		   cellpadding="0" cellspacing="0"  class="srstable">
		   <tr>
			<td  class="srscell-head-lft">Input Type</td>
			<td class="srscell-head-lft">Table Name</td>
			<td  class="srscell-head-lft">Input Name</td>
			<td  class="srscell-head-lft">Label Name</td>
			<td  class="srscell-head-lft">Field Order</td>
			<td  class="srscell-head-lft">Section Type</td>			
			<td  class="srscell-head-lft">Col Size</td>
			<!--<td  class="srscell-head-lft">Section</td>-->
			<td  class="srscell-head-lft">Validation Type</td>
			<td  class="srscell-head-lft">Action</td>
			</tr>
			<tr>
			<td  class="srscell-body"   >
					
			 <select id="InputType" name="InputType"  class="srs-txt-small">
			 
			   <option value="text" <?php if($InputType=='text') 
			   { echo 'selected="selected"'; } ?>>text</option>
			   <option value="SingleSelect" <?php if($InputType=='SingleSelect') 
			   { echo 'selected="selected"'; } ?>>Single Select</option>
			   <option value="MultiSelect" <?php if($InputType=='MultiSelect') 
			   { echo 'selected="selected"'; } ?>>Multi Select</option>
			    <option value="hidden" <?php if($InputType=='hidden') 
			   { echo 'selected="selected"'; } ?>>Hidden </option>
			    <option value="password" <?php if($InputType=='password') 
			   { echo 'selected="selected"'; } ?>>password </option>
			  
			    <option value="text_area" <?php if($InputType=='text_area') 
			   { echo 'selected="selected"'; } ?>>Text Area</option>
			   
			  <option value="LABEL" <?php if($InputType=='LABEL') 
			   { echo 'selected="selected"'; } ?>>LABEL </option>
				
				  <option value="datefield" <?php if($InputType=='datefield') 
			   { echo 'selected="selected"'; } ?>>Date field </option> 
			   
			     <option value="FILE_UPLOAD" <?php if($InputType=='FILE_UPLOAD') 
			   { echo 'selected="selected"'; } ?>>File Upload</option> 
			   				
            </select>
				
			</td>
			
	
	<td class="srscell-body">
	
	<select id="tran_table_name"  class="form-control select2" name="tran_table_name"
	 onchange="load_field(this.value)">
               
    <?php 
	$DATABASE=DATABASE;
	$sql = "SELECT table_name FROM INFORMATION_SCHEMA.TABLES 
	WHERE table_schema = '$DATABASE'";
	$parent_records = $this->projectmodel->get_records_from_sql($sql);		
		foreach ($parent_records as $row1)
		{ 						
		?>
		<option value="<?php echo $row1->table_name; ?>"
		<?php if($tran_table_name==$row1->table_name) 
		 { echo 'selected="selected"'; } ?>>
		<?php echo $row1->table_name; ?>
		</option>
  
	 <?php } ?>
        </select></td>
			
			
			<td  class="srscell-body"   >
			<input type="text" id="InputName" class="srs-txt-small" 
			value="" name="InputName"  />
			</td>
			<td  class="srscell-body"   >
			<input type="text" id="LabelName" class="srs-txt-small" 
			value="" name="LabelName"   />
			</td>
			
			<td  class="srscell-body"   >					
			<select id="FieldOrder" name="FieldOrder" >
			 <?php for($dv=1;$dv<=50;$dv++){?>  <option value="<?php echo $dv; ?>" ><?php echo $dv; ?></option>
			  <?php }?> 
			</select> 
			</td>
			
			<td  class="srscell-body"   >
			<select id="SectionType" name="SectionType" >
			  	 <option value="HEADER" >HEADER 1</option>
				 <option value="HEADER2" >HEADER 2</option>
				 <option value="HEADER3" >HEADER 3</option>
				 
			     <option value="DETAILS1" >DETAILS 1</option>
				 <option value="DETAILS2" >DETAILS 2</option>
				 <option value="DETAILS3" >DETAILS 3</option>
				 				 
			     <option value="FOOTER1" >FOOTER 1</option>
				 <option value="FOOTER2" >FOOTER 2</option>
				 <option value="FOOTER3" >FOOTER 3</option>
			  
			</select> 
			</td>
			
			
			<td class="srscell-body">
						
			<select id="DIVClass" name="DIVClass" >
			 <?php for($dv=1;$dv<=12;$dv++){?>
			  <option value="<?php echo $dv; ?>" <?php if($DIVClass==$dv) 
			   { echo 'selected="selected"'; } ?>><?php echo $dv; ?></option>
			  <?php }?> 
			</select> 
			
			 </td>
			 
	<td class="srscell-body">	
	<select id="validation_type"  class="form-control select2" name="validation_type"
	 onchange="load_field(this.value)">
               
    <?php 
	
		$sql = "SELECT * FROM frmrptgeneralmaster	WHERE  Status='validation_type'";
		$parent_records = $this->projectmodel->get_records_from_sql($sql);		
		foreach ($parent_records as $row1)
		{ 						
		?>
		<option value="<?php echo $row1->id; ?>"
		<?php if($validation_type==$row1->id) 
		 { echo 'selected="selected"'; } ?>>
		<?php echo $row1->FieldVal; ?>
		</option>
  
	 <?php } ?>
        </select></td>
			 
			<?php /*?> <td class="srscell-body">
						
			<select id="Section" name="Section" >
			 <?php for($dv=1;$dv<=12;$dv++){?>
			  <option value="<?php echo $dv; ?>" <?php if($Section==$dv) 
			   { echo 'selected="selected"'; } ?>><?php echo $dv; ?></option>
			  <?php }?> 
			</select> 
			
			 </td><?php */?>
			 
			 
			
			
			<td   class="srscell-body"  >
			
			<input type="submit" style="background-color:#99CC00"
			value="Add" id="Save" name="Save" />
			</td>
			</tr>
			
			<tr>
			
			<td class="srscell-head-lft" colspan="4">Sql Query for Dropdown</td>			
			<td  class="srscell-head-lft">Default value</td>
			<td  class="srscell-head-lft" colspan="2">Main Table</td>
			<td  class="srscell-head-lft">Link Field</td>
			<td  class="srscell-head-lft">&nbsp;</td>
			</tr>
			
			<tr>
			
			
	
	<td class="srscell-body" colspan="4">
	<textarea id="datafields"  name="datafields" cols="50"></textarea>
	
	</td>
						
			
			<td class="srscell-body">
			<input type="text" id="Inputvalue" class="srs-txt-small" 
			value="" name="Inputvalue"  />
						
			
			
			 </td>
			 
			 <td class="srscell-body" colspan="2">
						
			<select id="MainTable"  class="form-control select2" name="MainTable"
	 onchange="load_field(this.value)">
               
    <?php 
	$DATABASE=DATABASE;
	$sql = "SELECT table_name FROM INFORMATION_SCHEMA.TABLES 
	WHERE table_schema = '$DATABASE'";
	$parent_records = $this->projectmodel->get_records_from_sql($sql);	
	
					foreach ($parent_records as $row1)
					{ 						
					?>
					<option value="<?php echo $row1->table_name; ?>"
					<?php if($MainTable==$row1->table_name) 
					 { echo 'selected="selected"'; } ?>>
					<?php echo $row1->table_name; ?>
					</option>
			  
			  	 <?php } ?>
        </select>
			
			 </td>
			 
			 <td  class="srscell-body"   >
			<input type="text" id="LinkField" class="srs-txt-small" 
			value="" name="LinkField"  />
			</td>
			<td  class="srscell-head-lft">&nbsp;</td>
			
			</tr>
			
			</table>
		<?php if($id_header>0){ ?>
		
	<table  style="width:100%"  border="0" cellpadding="0" cellspacing="0" 
	class="srstable">
	
	 <?php	  
		$total_received=0;  			
		/*$income_records="select * from frmrpttemplatedetails 
		WHERE frmrpttemplatehdrID=".$id_header." order by SectionType,Section,FieldOrder ";	*/						
		$income_records="select * from frmrpttemplatedetails 	WHERE frmrpttemplatehdrID=".$id_header." order by FieldOrder ,id";
		$income_records = $this->projectmodel->get_records_from_sql($income_records);	
		foreach ($income_records as $record)
		{ 	
			$dtl_id=$record->id;
			$InputName=$record->InputName;
			$InputType=$record->InputType;
			$Inputvalue=$record->Inputvalue;
			$LogoType=$record->LogoType;
		    $LabelName=$record->LabelName;
			$LogoType=$record->LogoType;
			$DIVClass=$record->DIVClass;
			$Section=$record->Section;
			$tran_table_name=$record->tran_table_name;
			
			$FieldOrder=$record->FieldOrder;
			$datafields=$record->datafields;
			$table_name=$record->table_name;
			$where_condition=$record->where_condition;
			$orderby=$record->orderby;
			$SectionType=$record->SectionType;
			$MainTable=$record->MainTable;
			$LinkField=$record->LinkField;
			$validation_type=$record->validation_type;
	?>
		<tr><td   style="background-color:#CCFF00" colspan="8" align="center">
		<strong><?php echo $InputName; ?><strong></td></tr>	  
		
		<tr>
			<td  class="srscell-head-lft">Input Type</td>
			<td class="srscell-head-lft">Table Name</td>
			<td  class="srscell-head-lft">Input Name</td>
			<td  class="srscell-head-lft">Label Name</td>
			
			<td  class="srscell-head-lft">Field Order</td>
			<td  class="srscell-head-lft">Section Type</td>
			<td  class="srscell-head-lft">Col Size</td>
			<!--<td  class="srscell-head-lft">Section</td>-->
			<td  class="srscell-head-lft">Validation Type</td>
			<td  class="srscell-head-lft">Action</td>
		</tr>
		
		<tr>
		<td  class="srscell-body"   >
					
		 <select id="InputType<?php echo $dtl_id; ?>"
		 name="InputType<?php echo $dtl_id; ?>"  class="srs-txt-small">
			 
			   <option value="text" <?php if($InputType=='text') 
			   { echo 'selected="selected"'; } ?>>text</option>
			   <option value="SingleSelect" <?php if($InputType=='SingleSelect') 
			   { echo 'selected="selected"'; } ?>>Single Select</option>
			   <option value="MultiSelect" <?php if($InputType=='MultiSelect') 
			   { echo 'selected="selected"'; } ?>>Multi Select</option>
			    <option value="hidden" <?php if($InputType=='hidden') 
			   { echo 'selected="selected"'; } ?>>Hidden </option>
			    <option value="password" <?php if($InputType=='password') 
			   { echo 'selected="selected"'; } ?>>password </option>
			   	
				<option value="text_area" <?php if($InputType=='text_area') 
			   { echo 'selected="selected"'; } ?>>Text Area</option>
			   
			  <option value="LABEL" <?php if($InputType=='LABEL') 
			   { echo 'selected="selected"'; } ?>>LABEL </option>
				
				  <option value="datefield" <?php if($InputType=='datefield') 
			   { echo 'selected="selected"'; } ?>>Date field </option> 
			   
			     <option value="FILE_UPLOAD" <?php if($InputType=='FILE_UPLOAD') 
			   { echo 'selected="selected"'; } ?>>File Upload</option> 
			   			
            </select>
		</td>
		
		<td class="srscell-body">
	
	<select id="tran_table_name<?php echo $dtl_id; ?>"  
	class="form-control select2" name="tran_table_name<?php echo $dtl_id; ?>"
	 onchange="load_field(this.value)">
               
    <?php 
	$DATABASE=DATABASE;
	$sql = "SELECT table_name FROM INFORMATION_SCHEMA.TABLES 
	WHERE table_schema = '$DATABASE'";
	$parent_records = $this->projectmodel->get_records_from_sql($sql);	
	
					foreach ($parent_records as $row1)
					{ 						
					?>
					<option value="<?php echo $row1->table_name; ?>" 
					<?php if($row1->table_name==$tran_table_name) 
					{ echo 'selected="selected"'; } ?>>
					<?php echo $row1->table_name; ?>
					</option>
			  
			  	 <?php } ?>
        </select></td>
		
		
			<td  class="srscell-body"   >
			<input type="text" id="InputName<?php echo $dtl_id; ?>" class="srs-txt-small" 
			value="<?php echo $InputName; ?>" name="InputName<?php echo $dtl_id; ?>"  />
			</td>
			<td  class="srscell-body"   >
			<input type="text" id="LabelName<?php echo $dtl_id; ?>" 
			class="srs-txt-small" 
			value="<?php echo $LabelName; ?>" 
			name="LabelName<?php echo $dtl_id; ?>"   />
			</td>
			
			<td  class="srscell-body">
			<select id="FieldOrder<?php echo $dtl_id; ?>" name="FieldOrder<?php echo $dtl_id; ?>" >
			 <?php for($dv=1;$dv<=50;$dv++){?> <option value="<?php echo $dv; ?>" <?php if($FieldOrder==$dv) 
			   { echo 'selected="selected"'; } ?>><?php echo $dv; ?></option>
			  <?php }?> 
			</select> 
			</td>
			
			<td  class="srscell-body"   >
			<select id="SectionType<?php echo $dtl_id; ?>" 
			name="SectionType<?php echo $dtl_id; ?>" >
			
				<option value="HEADER" <?php if($SectionType=='HEADER') { echo 'selected="selected"'; } ?>>HEADER1</option>	
				<option value="HEADER2" <?php if($SectionType=='HEADER2') { echo 'selected="selected"'; } ?>>HEADER2</option>
				<option value="HEADER3" <?php if($SectionType=='HEADER3') { echo 'selected="selected"'; } ?>>HEADER3</option>
				   		   
				<option value="DETAILS1" <?php if($SectionType=='DETAILS1') { echo 'selected="selected"'; } ?>>DETAILS1</option>
				<option value="DETAILS2" <?php if($SectionType=='DETAILS2') { echo 'selected="selected"'; } ?>>DETAILS2</option>
				<option value="DETAILS3" <?php if($SectionType=='DETAILS3') { echo 'selected="selected"'; } ?>>DETAILS3</option>
				
			     <option value="FOOTER1" <?php if($SectionType=='FOOTER1') { echo 'selected="selected"'; } ?>>FOOTER1</option>
				 <option value="FOOTER2" <?php if($SectionType=='FOOTER2') { echo 'selected="selected"'; } ?>>FOOTER2</option>
				 <option value="FOOTER3" <?php if($SectionType=='FOOTER3') { echo 'selected="selected"'; } ?>>FOOTER3</option>
				 
			</select> 
			</td>
						
			<td class="srscell-body"   >
				<select id="DIVClass<?php echo $dtl_id; ?>" 
				name="DIVClass<?php echo $dtl_id; ?>" >
			 <?php for($dv=1;$dv<=12;$dv++){?>
			  <option value="<?php echo $dv; ?>" <?php if($DIVClass==$dv) 
			   { echo 'selected="selected"'; } ?>><?php echo $dv; ?></option>
			  <?php }?> 
			</select> 
			</td>
				
		<?php /*?><td class="srscell-body"   >
				<select id="Section<?php echo $dtl_id; ?>" 
				name="Section<?php echo $dtl_id; ?>" >
			 <?php for($dv=1;$dv<=12;$dv++){?>
			  <option value="<?php echo $dv; ?>" <?php if($Section==$dv) 
			   { echo 'selected="selected"'; } ?>><?php echo $dv; ?></option>
			  <?php }?> 
			</select> 
			</td>		<?php */?>
			
			
			<td class="srscell-body">	
			<select id="validation_type<?php echo $dtl_id; ?>"  class="form-control select2" name="validation_type<?php echo $dtl_id; ?>"
			 onchange="load_field(this.value)">
			<?php 
			
				$sql = "SELECT * FROM frmrptgeneralmaster	WHERE  Status='validation_type'";
				$parent_records = $this->projectmodel->get_records_from_sql($sql);		
				foreach ($parent_records as $row1)
				{ 						
				?>
				<option value="<?php echo $row1->id; ?>" <?php if($validation_type==$row1->id) { echo 'selected="selected"'; } ?>>
				<?php echo $row1->FieldVal; ?>
				</option>
		  
			 <?php } ?>
				</select></td>
			
			 
			
			<td  class="srscell-body"  >
			
			<input type="submit" style="background-color:#99CC00"
			value="Edit" id="Save" name="Save" />
			
			<a href="<?php echo $tran_link.'delete/'.$id_header.'/'.$dtl_id.'/'; ?>">
			<input type="button"  style="background-color:#FF3366"
			value="Delete" id="Delete" name="Delete" />
			</a>
			</td>
	</tr>
		
		<tr>
			
			<td class="srscell-head-lft" colspan="4">Sql Query for Dropdown</td>
			<td  class="srscell-head-lft">Default value</td>
			<td  class="srscell-head-lft" colspan="2">Main Table</td>
			<td  class="srscell-head-lft">Link Field</td>
			<td  class="srscell-head-lft">&nbsp;</td>
		  </tr>
		
			<tr>
			
			
	
			<td class="srscell-body" colspan="4">
			<textarea id="datafields<?php echo $dtl_id; ?>"  name="datafields<?php echo $dtl_id; ?>" cols="50"><?php echo $datafields; ?></textarea>
			</td>
			
			<td class="srscell-body">
			<input type="text" id="Inputvalue<?php echo $dtl_id; ?>" 
			class="srs-txt-small" value="<?php echo $Inputvalue; ?>" name="Inputvalue<?php echo $dtl_id; ?>"  />
			 </td>
			 
			 <td class="srscell-body" colspan="2">
						
			<select id="MainTable<?php echo $dtl_id; ?>" 
			 class="form-control select2" name="MainTable<?php echo $dtl_id; ?>"
	 onchange="load_field(this.value)">
               
    <?php 
	$DATABASE=DATABASE;
	$sql = "SELECT table_name FROM INFORMATION_SCHEMA.TABLES 
	WHERE table_schema = '$DATABASE'";
	$parent_records = $this->projectmodel->get_records_from_sql($sql);	
	
					foreach ($parent_records as $row1)
					{ 						
					?>
					<option value="<?php echo $row1->table_name; ?>"
					<?php if($row1->table_name==$MainTable) 
					{ echo 'selected="selected"'; } ?>>
					<?php echo $row1->table_name; ?>
					</option>
			  
			  	 <?php } ?>
        </select>
			
			 </td>
			 
			 <td  class="srscell-body"   >
			<input type="text" id="LinkField<?php echo $dtl_id; ?>" class="srs-txt-small" 
			value="<?php echo $LinkField; ?>" name="LinkField<?php echo $dtl_id; ?>"  />
			</td>
			
			<td  class="srscell-head-lft">&nbsp;</td>
			
			</tr>
		
		
		<?php }} ?>
			
		  		           
		       <tr>
             <td  class="srscell-body"	 colspan="4"  >
 <input type="submit" class="srs-btn-submit" value="Save" id="Save" name="Save" 
onclick="return confirm('Do you want to Save ?');"/>
              
				 </td>
				 
				 <td  class="srscell-body"	 colspan="4"  >

				<?php //echo $id_header; ?>
				<a href="<?php echo $tran_link.'copy_create/'.$id_header; ?>">
				<input type="button" class="btn btn-block btn-success" value="Copy this form and create" id="copy" name="copy" 
				onclick="return confirm('Do you want to Copy and Create ?');"/>
				</a>
				
				 </td>
           </tr>
		   
         </table>
</form>

</DIV>

<table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="50">#SysID</th>
							<th width="472">Form Report Name </th>
							<th width="85">Type </th>
							<th width="62">Edit</th>
							<th width="62">Delete</th>
						</tr>
					</thead>
					
					<tbody>
					<?php
					if(count($projectlist) > 0){
					$i = 1;
					foreach ($projectlist as $row){
						$alt = ($i%2==0)?'alt1':'alt2';
						
					?>
					
					<tr class="<?php if($i%2==0) { echo ' even gradeX'; } 
						else {  echo ' odd gradeC'; } ?> ">
							<td><?php echo $row->id;; ?></td>
							<td><?php echo $row->FormRptName; ?></td>
							<td><?php echo $row->Type; ?></td>
							<td class="center"> 
			
					 <a href="<?php echo $tran_link.'addeditview/'.$row->id.'/0/'; ?>">
					 <input type="button" class="btn btn-block btn-success"
					 value="Edit" id="Save" name="Save">
					</a>
						</td>
						<td class="center"> 
						<a href="<?php echo $tran_link.'deleteAll/'.$row->id; ?>">
	<input type="button"class="btn btn-block btn-danger" value="Delete" id="deleteAll" 
	name="deleteAll" 
	onClick="return confirm('Do you want to Delete  this Invoice ?');"/>
	</a>
					</td>	
                    </tr>				
			  </td>
						</tr>
				
				<?php 	$i++;}}	?>		
		</table>

