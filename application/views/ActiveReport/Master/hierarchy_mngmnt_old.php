<script language="javascript" type="text/javascript">
		
		function print_result() {
				
var base_url = '<?php echo ADMIN_BASE_URL.'project_controller/hq_wise_location_master/';  
?>';
			url=base_url;
			newwindow=window.open(url,'name','height=600,width=800');
			if (window.focus) {newwindow.focus()}
			return false;
		}
</script>

<script type="text/javascript">
            
            var controller = 'project_controller';
            var base_url = '<?php echo ADMIN_BASE_URL; //you have to load the "url_helper" to use this function ?>';						
            function load_data_ajax(id,type)
			{
								
				$.ajax({
                    'url' : base_url + controller + '/load_hierarchy_ajax',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'type' : id},
                    'success' : function(data){ 
					//probably this request will return anything, it'll be put in var "data"
                        var container = $('#container'); 
						   if(data){
                            container.html(data);
                        }
                    }
                });
				
				$.ajax({
                    'url' : base_url + controller + '/load_employee_ajax',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'type' : id},
                    'success' : function(data){ 
					//probably this request will return anything, it'll be put in var "data"
                        var containeremp = $('#containeremp'); 
						   if(data){
                            containeremp.html(data);
                        }
                    }
                });
				
            }
</script>


<div class="row">
<div class="box-body">	  
<div class="box-header bg-purple" >
  <h3 class="box-title"><?php echo $FormRptName; ?>
  
  <?php if($NEWENTRYBUTTON=='YES'){ ?>
  <a href="<?php echo $tran_link;?>list/"><button type="button" class="btn btn-success">New Entry</button></a>
   <?php } ?>
  </h3>
</div>
</div>
</div>		
		
<form id="frm" name="frm" method="post" action="<?php echo $tran_link;?>save/" >

<input type="hidden" name="id" id="id" value="<?php echo $id; ?>"  />

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
			{$RecordSet=$this->projectmodel->get_records_from_sql($datafields);}
			
			if($id>0)
			{
				 $data['DataFields']=$InputName;
				 $data['TableName']=$tran_table_name;
				 $data['WhereCondition']=" id=".$id;
				 $data['OrderBy']='';
				 $datavalue=$this->projectmodel->Activequery($data,'LIST');
				 foreach($datavalue as $key=>$bd){
				 foreach($bd as $key1=>$bdr){
				 $Inputvalue=$bdr;
				 }}
			}
			$empname=$hname=$employee_id='';					
			/*$InputName=
			$this->projectmodel->create_field($InputType,$LogoType,
			$LabelName,$InputName,$Inputvalue,$RecordSet);*/
	  ?>

<?php if($InputName=='tbl_designation_id'){ ?>
<div class="box-body"><div class="row">  
<div class="col-xs-3">
	<div class="form-group">
    <label><?PHP echo $LabelName;?></label>
		<select id="<?PHP echo $InputName;?>" 
		name="<?PHP echo $InputName;?>" 
		onchange="load_data_ajax(this.value)" class="form-control select2">
                <option value="">Select</option>
                <?php 
					$sql="select * from tbl_designation order by srlno ";
					$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
					foreach ($rowrecord as $row1)
					{ 						
					?>
					<option value="<?php echo $row1->id; ?>" 
					<?php if($row1->id==$Inputvalue) 
					{ echo 'selected="selected"'; } ?>>
					<?php echo $row1->designation_name; ?>
					</option>
			  	 <?php } ?>
         </select>
		</div>
	</div>
	</div>
	</div>
<?php } ?>	

<?php  if($InputName=='hierarchy_name'){ ?>
<div class="box-body"><div class="row">  
<div class="col-xs-3">
	<div class="form-group">
    <label><?PHP echo $LabelName;?></label>
	<input  class="form-control" name="<?PHP echo $InputName;?>" 
	id="<?PHP echo $InputName;?>"  value="<?PHP echo $Inputvalue;?>" />
</div>
	</div>
	</div>
	</div>
<?php } ?>	

<?php  if($InputName=='under_tbl_hierarchy_org'){ ?>
<div class="box-body"><div class="row">  
<div class="col-xs-3">
	<div class="form-group">
    <label>Under Position</label>
	
	<div id="container"></div>
</div></div>

<div class="col-xs-3">
	<div class="form-group">
    <label>Employee</label>
<div id="containeremp"></div>
</div>
	</div>
	</div>
	</div>
<?php } ?>	

<?php  if($InputName=='under_tbl_hierarchy_org'){ ?>
<div class="box-body"><div class="row">
<div class="col-xs-6">
	<div class="form-group"><label>
   <?php 
			if($Inputvalue<>0) {
			$sql="select * from tbl_hierarchy_org where id=".$Inputvalue;
			$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
			foreach ($rowrecord as $row1)
			{ $hname=$row1->hierarchy_name;$employee_id=$row1->employee_id;}}
			
			if($employee_id<>0) {
			$sql="select * from tbl_employee_mstr where id=".$employee_id;
			$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
			foreach ($rowrecord as $row1)
			{ $empname=$row1->name.'('.$row1->code.')';}}
			
			echo 'Under Position : '.$hname;
			
			//echo $hname;
	?></label>
</div>
	</div>
	</div>
	</div>
<?php } ?>	

<?php  if($InputName=='employee_id'){ ?>
<div class="box-body"><div class="row">
<div class="col-xs-6">
	<div class="form-group"><label>
   <?php 
			
			if($Inputvalue>0){
						
			$sql="select * from tbl_employee_mstr where id=".$Inputvalue;
			$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
			foreach ($rowrecord as $row1)
			{
			$empname=$row1->name.'('.$row1->code.')';
			echo ' Employee: '.$empname;
			}
			}
			
			
			
			
			//echo $hname;
	?></label>
</div>
	</div>
	</div>
	</div>
<?php } ?>	
	
	
	
	
<?php } ?>
</div></div>
	
<div class="row">
<div class="box-body">	  
<div class="box-header" >&nbsp;</div>
</div>
</div>

<div class="row">
	<div class="box-body">	 
		<div class="box-header" style="background:#ff851b" align="center">
		<button type="submit" class="btn btn-success">Save</button>
		</div>
	</div>
</div>
	

</form>


<!--LIST VIEW-->
<?php if($DisplayGrid=='YES'){ ?>
<table  id="example1" class="table table-bordered table-striped">
	    <thead>
	        <tr>
			<?php 
			//print_r($header);
			//echo $header[1];
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
					
					if($key1=='under_tbl_hierarchy_org'){
					$sql="select * from tbl_hierarchy_org 
					where id=".$bdr;
					$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
					foreach ($rowrecord as $row1)
					{ $bdr=$row1->hierarchy_name;}	
					
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