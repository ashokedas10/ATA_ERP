
<div class="panel panel-primary"  style="background-color:#E67753">
	  <div class="panel-body" align="center">
		<h3><span class="label label-default">
		<?php echo $FormRptName; ?>
		 &nbsp;&nbsp;&nbsp;<?php if($NEWENTRYBUTTON=='YES'){ ?>
  <a href="<?php echo $tran_link;?>list/"><button type="button" class="btn btn-success">New Entry</button></a>
  <a href="<?php echo $tran_link;?>hierarchy/"><button type="button" class="btn btn-primary" id="HIERARCHY" name="HIERARCHY">CREATE HIERARCHY</button></a>
   <?php } ?>
		</span></h3>
	  </div>
	  
</div>
		
<form id="frm" name="frm" method="post" action="<?php echo $tran_link;?>save/" >
<input type="hidden" name="id" id="id" value="<?php echo $id; ?>"  />
<div class="panel panel-primary"  style="background-color:#E67753">
 <div class="panel-footer">
 <div class="form-row">
<?php    
			
		$records="select * from frmrpttemplatedetails 
		where frmrpttemplatehdrID=".$frmrpttemplatehdrID." 
		and SectionType='HEADER' order by Section,FieldOrder ";
		$records = $this->projectmodel->get_records_from_sql($records);	
		foreach ($records as $record)
		{
			$DIVClass=$record->DIVClass; // col size
			$LabelName=$record->LabelName;
			$InputName=$record->InputName;
			$Inputvalue=$record->Inputvalue;
			$tran_table_name=$record->tran_table_name;
			$InputType=$record->InputType;
			$datafields=$record->datafields;
			
			if($datafields<>'')
			{$RecordSet=$this->projectmodel->get_records_from_sql($datafields);}
						
		if($id>0)
		{
			 $data['DataFields']=$InputName;
			 $data['TableName']=$tran_table_name;
			 $data['WhereCondition']=" id=".$id;
			 $data['OrderBy']='';
			 $datavalue=$this->projectmodel->Activequery($data,'LIST');
			 foreach($datavalue as $key=>$bd)
			 {foreach($bd as $key1=>$bdr){$Inputvalue=$bdr;}}
		}
			
				
?>	
	   <div class="form-group col-md-<?php echo $DIVClass; ?>">
			<label for="inputState"><?php  echo $LabelName; ?></label>
		
		<?php if($InputType=='SingleSelect'){ ?>
		
		
		<select name="<?php echo $InputName; ?>" 
	    class="form-control select2"  style="width:100%;"	 >
               
			   <option value="">--------Select-----</option>			   
                <?php foreach ($RecordSet as $row1){?>
					<option value="<?php echo $row1->FieldID; ?>"
					<?php 				
					if($row1->FieldID==$Inputvalue) 
					{ echo 'selected="selected"'; }					
					?>>
					<?php echo $row1->FieldVal; ?>
					</option>
			  
			  	 <?php } ?>
          </select>
		
		<?php } else if($InputType=='MultiSelect'){ 
		if($Inputvalue==''){$Inputvalue=0;  } ?>
		

		<select name="<?php echo $InputName; ?>[]" 
	    class="form-control select2" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
               
			   <option value="">--------Select-----</option>			   
                <?php 
								
				$OrgListIds='0';
				$RecordSet="select id from tbl_hierarchy_org WHERE id not in
				(select childuid from tbl_organisation_chain) order by hierarchy_name";	
				$RecordSet = $this->projectmodel->get_records_from_sql($RecordSet);
				foreach ($RecordSet as $row1){$OrgListIds=$OrgListIds.','.$row1->id;}
				$OrgListIds=$OrgListIds.','.$Inputvalue;
				
				$OrgListIds = explode(",",$OrgListIds);
				foreach($OrgListIds as $OrgListId)
				{						
				?>
					<option value="<?php echo $OrgListId; ?>"
					<?php 					
					$orgstructure = explode(",",$Inputvalue);
					$designation_name=$hierarchy_name=$tbl_designation_id='';
					if($OrgListId=='')
					{$OrgListId=0;}
					if($OrgListId>=0)
					{
						$sql_tplan="select * from tbl_hierarchy_org 
						where id=".$OrgListId;
						$tplans = $this->projectmodel->get_records_from_sql($sql_tplan);	
						foreach ($tplans as $tplan)
						{
						$tbl_designation_id=$tplan->tbl_designation_id;
						$hierarchy_name=$tplan->hierarchy_name;
						}
						
						if($tbl_designation_id>0)
						{
							$sql_tplan="select * from tbl_designation 
							where id=".$tbl_designation_id;
							$tplans = $this->projectmodel->get_records_from_sql($sql_tplan);	
							foreach ($tplans as $tplan)
							{$designation_name=$tplan->designation_name;}
						}
								
						if (in_array($OrgListId, $orgstructure)) 
						{ echo 'selected="selected"'; }
					
					?>>
					<?php	echo $hierarchy_name.'-'.$designation_name;?>
					</option>
			  
			  	 <?php }} ?>
          </select>
		
		<?php }else{ ?>
		
		<input type="text" id="<?php echo $InputName; ?>"  
		name="<?php echo $InputName; ?>"
		value="<?php echo $Inputvalue;  ?>" class="form-control" />
		
		<?php } ?>	
			
				  
		</div>
<?php } ?>	
	<div class="panel-body" align="center">
		
  </div>
  
  
  <div class="panel panel-primary"  style="background-color:#A1D490">
  
   <div class="panel-body" align="center">
		<button type="submit" class="btn btn-primary" id="Save" name="Save">Save</button>
  </div>
  </div>
</div></div></div>
</form>
<!--LIST VIEW-->
<?php if($DisplayGrid=='YES'){ ?>
<table  id="example1" class="table table-bordered table-striped">
	    <thead>
	        <tr>
			<?php 
			foreach($GridHeader as $key=>$hdr){
			 $cn_values =explode("-", trim($hdr));			
			 ?>
	            <td  align="<?php echo $cn_values[1]; ?>"><?php echo $cn_values[0]; ?></td>
	        <?php } ?>  
			<td  align="left">Action</td> 
            </tr>
        </thead>
       
	   <tbody>
			<?php foreach($body as $key=>$bd){$column=0;?>
			<tr>
				<?php foreach($bd as $key1=>$bdr)
				{ 
					$align=$GridHeader[$column];
					$align =explode("-", trim($align));	
					$column=$column+1;
					if($key1=='id'){$id=$bdr;}
					
					if($key1=='tbl_designation_id'){
					
					$sql="select * from tbl_designation where id=".$bdr;
					$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
					foreach ($rowrecord as $row1)
					{$bdr=$row1->designation_name;}
					
					}
					
					/*if($key1=='teritory_list')
					{
						$teritory_list = explode(",",$bdr);
						$bdr='';
						foreach($teritory_list as  $teritory)
						{
							if($teritory>0)
							{
								$sql_tplan="select * from tbl_hierarchy_org 
								where id=".$teritory;
								$tplans = 
								$this->projectmodel->get_records_from_sql($sql_tplan);	
								foreach ($tplans as $tplan)
								{$bdr=$bdr.','.$tplan->hierarchy_name;}
								
							}
						}
					}*/
					if($key1=='under_tbl_hierarchy_org')
					{
						$sql_tplan="select * from tbl_hierarchy_org 
						where id=".$bdr;
						$tplans =$this->projectmodel->get_records_from_sql($sql_tplan);	
						foreach ($tplans as $tplan)
						{$bdr=$tplan->hierarchy_name;}
					}
					
					if($key1=='employee_id'){
					
						$sql="select * from tbl_employee_mstr 
						where id=".$bdr;
						$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
						foreach ($rowrecord as $row1)
						{$bdr=$row1->name.'('.$row1->code.')';}	
						//if($bdr==0){$bdr='';}
					 }
										
						
					
				?>
				<td align="<?php echo $align[1]; ?>"><?php echo $bdr; ?></td>
				<?php } ?>
				
				<td  align="left">
				<a href="<?php 	echo $tran_link.'addeditview/'.$id; ?>">
				<button class="btn-block btn-info">Edit</button></a>
				</td> 
			</tr>
			<?php } ?>	
	 </tbody>
</table>   
<?php } ?>  