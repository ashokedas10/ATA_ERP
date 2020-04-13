<script language="javascript" type="text/javascript">
		
		function treeview(parent_id,param) {				
			var base_url = '<?php echo ADMIN_BASE_URL.'Project_controller/treeview/';  ?>';
			url=base_url+parent_id+'/'+param;
			newwindow=window.open(url,'name','height=600,width=800');
			if (window.focus) {newwindow.focus()}
			return false;
		}
</script>




<style type="text/css">
<!--
.style2 {
	color: #990000;
	font-weight: bold;
	font-size:18px;
}
.input_field_hight
{
height:27px;
font-family:Arial, Helvetica, sans-serif bold;
font-size:12px;
color:#000000;
font-weight:300;
}

input:focus {
  background-color: yellow;
}

-->
</style>

	
<?php 
$login_status=$this->session->userdata('login_status');
if($DisplayGrid=='YES'){ 
?>

<div class="container" id="maindiv" >
	<div class="row" >   
		<div class="panel panel-danger"   >
		
			<div class="panel-heading">
			
				<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>-->
				<div class="row">
					<div class="col-sm-8">
						<h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-info-sign"></span> <?php echo $FormRptName; ?></h4>
					</div>
					<div class="col-sm-4">
						<div  align="right" >
						<a data-toggle="modal" data-target="#editModal<?php echo 0; ?>" 
						class="btn btn-danger"><i class="fa fa-pencil"></i> New Entry</a>	
						</div>
					</div>
				</div>
				
			</div>
			
			<!--MODAL POPUP for new entry-->		
		<div class="modal fade" id="editModal<?php echo '0'; $id=0; ?>" tabindex="-1" role="dialog" aria-hidden="true" >
		<div class="modal-dialog" role="document" style="width:800px;max-width:100%;" >
		<div class="modal-content">
				<div class="modal-header bg-primary">
				<h5 class="modal-title" id="exampleModalLongTitle-1">NEW ENTRY</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
						 <div class="box box-success">
								<div class="box-header with-border">				    
									  <div class="col-sm-12">
									  
									  
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
			{ 
			
			$RecordSet=$this->projectmodel->get_records_from_sql($datafields);}
			
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
									
			$InputName=
			$this->projectmodel->create_field($InputType,$LogoType,$LabelName,$InputName,$Inputvalue,$RecordSet,$DIVClass);
			
			if($SectionType=='HEADER'){
	  ?>		
				<div class="row" style="padding-top:5px;">	
				
				 <?php if($InputType<>'hidden'){ ?>			  
					<div class="col-sm-3"><label ><?php echo $LabelName; ?></label></div>
					<!--<div class="col-sm-1">:</div>	-->			
				<?php } ?>		
				<div class="col-sm-9" align="left"><?php echo $InputName; ?></div>	
				
				</div>
		<?php }} ?>	
		
			<div class="row" style="padding-top:5px;">&nbsp;</div>
				
				<div class="panel-footer"  align="center">
				
				
				<?php if($login_status=='SUPER' || $login_status=='ADMIN') {?>					
					
					<button type="submit" class="btn btn-success" id="Save" name="Save">Save</button>					 
					<?php if($frmrpttemplatehdrID==8){ ?>		
					 <button type="button" class="btn btn-danger"  onclick="treeview(0,'LEGAL_ENTITY')">Tree View</button>
					 <?php } ?>
					 
				<?php }else{ ?>	
				 
					<?php if($OPERATION=='ADD_EDIT' ||  $OPERATION=='ADD_EDIT_DELETE'){ ?>
					<button type="submit" class="btn btn-success" id="Save" name="Save">Save</button>
					 <?php } ?>
					 
					<?php if($frmrpttemplatehdrID==8){ ?>		
					 <button type="button" class="btn btn-danger"  onclick="treeview(0,'LEGAL_ENTITY')">Tree View</button>
					 <?php } ?>
				
				<?php } ?>	 
			 					
				</div>
				
			</form>		  	  
									  </div>
												
								</div>
						 </div>	
						
							
				</div>		
		
		</div>
		</div>
		</div>
			<!--MODAL POPUP END-->		

<div  style="overflow:scroll">
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
					
					//FOR EMPLOYEE MASTER
					if($frmrpttemplatehdrID==10 && $key1=='tbl_designation_id')
					{
						$sql="select * from tbl_designation 
						where  	srlno=".$bdr;
						$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
						foreach ($rowrecord as $row1)
						{$bdr=$row1->designation_name;}
					}
					
					//FOR STOCKIST MASTER
					if($frmrpttemplatehdrID==13 && $key1=='retail_field')
					{
						$location='';
						$sql="select * from tbl_hierarchy_org 	where  	id in (".$bdr.") ";
						$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
						foreach ($rowrecord as $row1)
						{
						$marketname=$row1->hierarchy_name;
						$parentid=$row1->under_tbl_hierarchy_org;
						$Whr=' id='.$parentid;
						$parenthq=$this->projectmodel->GetSingleVal(
						'hierarchy_name','tbl_hierarchy_org',$Whr);
						
						$locHq=$marketname.'('.$parenthq.')';						
						$location=$location.','.$locHq;
						}
						$bdr=substr($location,1);
					}
					
						//FOR RETAIL MASTER
					if($frmrpttemplatehdrID==12 && $key1=='retail_field')
					{
						$location='';
						$sql="select * from tbl_hierarchy_org 	where  	id in (".$bdr.") ";
						$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
						foreach ($rowrecord as $row1)
						{
						$marketname=$row1->hierarchy_name;
						$parentid=$row1->under_tbl_hierarchy_org;
						
						$Whr=' id='.$parentid;
						$parenthq=$this->projectmodel->GetSingleVal(
						'hierarchy_name','tbl_hierarchy_org',$Whr);
						
						$locHq=$marketname.'('.$parenthq.')';							
						$location=$location.','.$locHq;
						}
						$bdr=substr($location,1);
					}
					
					
					if($frmrpttemplatehdrID==22 && $key1=='hq_id')
					{
						$location='';
						$sql="select * from tbl_hierarchy_org 	where  	id in (".$bdr.") ";
						$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
						foreach ($rowrecord as $row1)
						{$bdr=$row1->hierarchy_name;}						
					}
					
					if(($frmrpttemplatehdrID==21 or $frmrpttemplatehdrID==22 or $frmrpttemplatehdrID==26) && $key1=='parent_id')
					{
						if($bdr>0)
						{
							$Whr=' id='.$bdr;
							$bdr=$this->projectmodel->GetSingleVal(
							'acc_name','acc_group_ledgers',$Whr);
						}
					}
					
					if($frmrpttemplatehdrID==27 && $key1=='parent_id')
					{
						if($bdr>0)
						{
							$Whr=' id='.$bdr;
							$bdr=$this->projectmodel->GetSingleVal('name','tbl_location',$Whr);
						}
						else
						{ $bdr='None';}
					}
					if($frmrpttemplatehdrID==27 && $key1=='location_type')
					{
						if($bdr>0)
						{
							$Whr=' id='.$bdr;
							$bdr=$this->projectmodel->GetSingleVal('FieldVal','frmrptgeneralmaster',$Whr);
						}
					}
					
					if($frmrpttemplatehdrID==28 && $key1=='data_type')
					{
						if($bdr>0)
						{
							$Whr=' id='.$bdr;
							$bdr=$this->projectmodel->GetSingleVal('FieldVal','frmrptgeneralmaster',$Whr);
						}
					}
					
					if($frmrpttemplatehdrID==29 && $key1=='parent_id')
					{
						if($bdr>0)
						{
							$Whr=' id='.$bdr;
							$bdr=$this->projectmodel->GetSingleVal('name','software_architecture_details',$Whr);
						}
					}
				?>
				<td align="<?php echo $align[1]; ?>"><?php echo $bdr; ?></td>
				<?php } ?>
				
		<!--MODAL POPUP-->		
		<div class="modal fade" id="editModal<?php echo $id; ?>" 
   				tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document" style="width:800px;max-width:100%;">
		<div class="modal-content">
				<div class="modal-header bg-primary">
				<h5 class="modal-title" id="exampleModalLongTitle-1">View And Edit </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
						 <div class="box box-success">
								<div class="box-header with-border">				    
									  <div class="col-sm-12">
									  									  
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
			{ 
			
			$RecordSet=$this->projectmodel->get_records_from_sql($datafields);}
			
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
			
			$InputName=$this->projectmodel->create_field($InputType,$LogoType,$LabelName,$InputName,$Inputvalue,$RecordSet,$DIVClass);
			
			if($SectionType=='HEADER'){
	  ?>		
					
				<div class="row" style="padding-top:5px;">	
				
				 <?php if($InputType<>'hidden'){ ?>			  
					<div class="col-sm-3"><label><?php echo $LabelName; ?></label></div>
					<!--<div class="col-sm-1">:</div>	-->			
				<?php } ?>		
				<div class="col-sm-9" align="left"><?php echo $InputName; ?></div>	
				
				</div>
		<?php }} ?>	
		
				<div class="row" style="padding-top:5px;">&nbsp;</div>
				
				<div class="panel-footer"  align="center">
				
					<?php if($login_status=='SUPER' || $login_status=='ADMIN') {?>					
					
					<button type="submit" class="btn btn-success" id="Save" name="Save">Save</button>					 
					<?php if($frmrpttemplatehdrID==8){ ?>		
					 <button type="button" class="btn btn-danger"  onclick="treeview(0,'LEGAL_ENTITY')">Tree View</button>
					 <?php } ?>
					 
					<?php }else{ ?>	
				 
					<?php if($OPERATION=='ADD_EDIT' ||  $OPERATION=='ADD_EDIT_DELETE'){ ?>
					<button type="submit" class="btn btn-success" id="Save" name="Save">Save</button>
					 <?php } ?>
					 
					<?php if($frmrpttemplatehdrID==8){ ?>		
					 <button type="button" class="btn btn-danger"  onclick="treeview(0,'LEGAL_ENTITY')">Tree View</button>
					 <?php } ?>
				
				<?php } ?>	 
			 					
				</div>
				
			</form>		  	  
									  </div>
												
								</div>
						 </div>	
				</div>		
		
		</div>
		</div>
		</div>
			<!--MODAL POPUP END-->		
			
				
				<td  align="left">
				<?php /*?><a href="<?php 	echo $tran_link.'addeditview/'.$id; ?>">
				<button class="btn btn-info" onclick="displaydiv('maindiv')">Edit</button></a><?php */?>
				
			<?php /*?>	<?php 	$url_link=$tran_link.'addeditview/'.$id; ?>
				<button class="btn btn-info" onclick="displaydiv('maindiv','<?php echo $url_link; ?>')">Edit</button><?php */?>
				
				 <a data-toggle="modal" data-target="#editModal<?php echo $id; ?>" 
				 class="btn btn-primary"><i class="fa fa-pencil"></i> VIEW DETAILS</a>		
				
				<?php if($frmrpttemplatehdrID==10){ ?>				
				<?php /*?> <a data-toggle="modal" data-target="#editModal<?php echo $id; ?>"><button class="btn btn-danger">Roll Wise previledge</button></a>
				<?php */?>
				 
				 <?php $prevurl=ADMIN_BASE_URL.'Project_controller/Employee_priviledge_set/'.$id; ?>				 
				 <a href="<?php 	echo $prevurl; ?>" target="_blank"><button class="btn btn-info">Roll Wise previledge</button></a>
				 <?php } ?>	
				 
				</td> 
			</tr>
			<?php } ?>	
	 </tbody>
</table>   
</div>

	</div>
	</div>    
</div>
<?php } ?>  


</div>
</div>
<!--LIST VIEW-->

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<script>
  
  <?php   
		$records="select * from frmrpttemplatedetails 	where frmrpttemplatehdrID=".$frmrpttemplatehdrID." 
		and SectionType='HEADER' order by Section,FieldOrder ";
		$records = $this->projectmodel->get_records_from_sql($records);	
		foreach ($records as $record)
		{
		if($record->InputType=='datefield')
		{
	?>
		
     $("#<?php echo $record->InputName;?>").datepicker({
      changeMonth: true,
      changeYear: true
    });
 	
	$("#<?php echo $record->InputName;?>").change(function() {
	 var  trandate = $('#<?php echo $record->InputName;?>').val();
	 trandate=
	 trandate.substring(6, 10)+'-'+
	 trandate.substring(0, 2)+'-'+
	 trandate.substring(3, 5);
	 $("#<?php echo $record->InputName;?>").val(trandate);
	});
	
	 <?php  }} ?>
	
  </script>
  
  
