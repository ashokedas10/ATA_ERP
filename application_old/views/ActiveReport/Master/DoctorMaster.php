

<script>

$(document).ready(function() {
        
		<?php for($s=1;$s<=30;$s++){ ?>
		$('#showmenu<?php echo $s; ?>').click(function() {
                $('.menu<?php echo $s; ?>').slideToggle("fast");
				
        });
		<?php } ?>
		
		
		<?php 		
		$sql="select a.* from mr_manager_doctor  a,tbl_hierarchy_org b 
		where a.headq=b.id 	and b.tbl_designation_id='6' and b.under_tbl_hierarchy_org=".$hq_id." 
		order by a.code,b.hierarchy_name,a.name ";
		
		$doctor_list=$this->projectmodel->get_records_from_sql($sql);	
		foreach ($doctor_list as $row){		
		?>
		$('#showmenu_edit<?php echo $row->id; ?>').click(function() {
                $('.menu_edit<?php echo $row->id; ?>').slideToggle("fast");
				
        });
		<?php } ?>
		
			
    }); 

/*$(document).ready(function() {
        $('#showmenu2').click(function() {
                $('.menu2').slideToggle("fast");
				
        });
    }); 
*/</script>


<div class="tab-pane" >
	<ul class="timeline timeline-inverse">
	  <li>
		<div class="timeline-item">
		  <h3 class="timeline-header"><a href="#">Doctor Master</a> </h3>
		  <div class="timeline-body">

<form action="<?php echo ADMIN_BASE_URL?>project_controller/doctor_master/listing/" 
name="frmreport" id="frmreport" method="post" >
			 
			  <div class="box-body">
			  	<div class="row">
			 <div class="col-xs-3"> 
	
		<?php 
			$ownid=$ownname='';		
			if(strtoupper($this->session->userdata('HIERARCHY_STATUS'))=='SUPERUSER')
			{
				$tbl_designation_id=$this->session->userdata('billing_emp_desig'); 
				$login_emp_id=$this->session->userdata('billing_emp_id'); 
				$activity_status=$this->session->userdata('activity_status');
				
				 $sql="select a.id,a.hierarchy_name ,b.name
				 from tbl_hierarchy_org a,tbl_employee_mstr b 
				where a.employee_id=".$login_emp_id." 
				and b.status='REPORT_ACTIVE' and b.id=a.employee_id  
				order by  hierarchy_name";
				$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
				foreach ($rowrecord as $row1)
				{$ownid=$row1->id;$ownname=$row1->hierarchy_name;$empname=$row1->name;}
				
			}
			
			?>
			 
			   <select id="hq_id"  name="hq_id" class="form-control select2">
          <option value="">Select HQ</option>
   	 <?php 
			$ownid=$ownname='';		
			if(strtoupper($this->session->userdata('HIERARCHY_STATUS'))=='SUPERUSER')
			{
				$tbl_designation_id=$this->session->userdata('billing_emp_desig'); 
				$login_emp_id=$this->session->userdata('billing_emp_id'); 
				$activity_status=$this->session->userdata('activity_status');
				
				echo $sql="select a.id,a.hierarchy_name ,b.name
				 from tbl_hierarchy_org a,tbl_employee_mstr b 
				where a.employee_id=".$login_emp_id." 
				and b.status='REPORT_ACTIVE' and b.id=a.employee_id  
				order by  hierarchy_name";
				$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
				foreach ($rowrecord as $row1)
				{$ownid=$row1->id;$ownname=$row1->hierarchy_name;$empname=$row1->name;}
			}
			else
			{
				$sql="select a.id,a.hierarchy_name ,b.name
				 from tbl_hierarchy_org  a,tbl_employee_mstr b
				 where	a.employee_id=".
				$this->session->userdata('login_emp_id')." 
				and b.status='REPORT_ACTIVE' and b.id=a.employee_id
				 order by  hierarchy_name";
				$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
				foreach ($rowrecord as $row1)
				{$ownid=$row1->id;
				$ownname=$row1->hierarchy_name;
				$empname=$row1->name;}
			}
				
				$childlist='0';
				$sql="select childuid from tbl_organisation_chain
				where  child_desig_srl<>6  and parentuid='$ownid'";
				$rowrecord = $this->projectmodel->get_records_from_sql($sql);
				foreach ($rowrecord as $row1)
				{ $childlist=$childlist.','.$row1->childuid; }
				
				$sql="select a.id,a.hierarchy_name,b.name 
				from tbl_hierarchy_org a,tbl_employee_mstr b
				where a.id in (".$childlist.") and b.status='REPORT_ACTIVE' 
				and b.id=a.employee_id order by  hierarchy_name";
				$rowrecord = $this->projectmodel->get_records_from_sql($sql);
				
				?>
					
				<?php if($ownname<>''){ ?>	
					<option value="<?php echo $ownid; ?>"
					<?php if($ownid==$hq_id) { echo 'selected="selected"'; } ?>>
					<?php echo $ownname.'('.$empname.')'; ?>
					</option>
				<?php } ?>	
				
				<?php foreach ($rowrecord as $row1){?>					
				<option value="<?php echo $row1->id; ?>"
				<?php if($row1->id==$hq_id) { echo 'selected="selected"'; } ?>>
				<?php echo $row1->hierarchy_name.'('.$row1->name.')'; ?>
				</option>
				
			  	 <?php } ?>
        </select>
		
		<?php /*?>	  <select id="hq_id"  name="hq_id" class="form-control select2">
      			<option value="">Select HQ</option>
                <?php 

					$sql="select * from tbl_hierarchy_org 
					where tbl_designation_id=5 
					and tbl_designation_id<>1  order by hierarchy_name";
					$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
					foreach ($rowrecord as $row1)
					{ 						
					?>
					
					<option value="<?php echo $row1->id; ?>" 
					<?php if($row1->id==$hq_id) 
					{ echo 'selected="selected"'; } ?>>
					<?php echo $row1->hierarchy_name; ?>
					</option>
			  	 <?php } ?>
        </select>			<?php */?>	
		</div>	
			<div class="col-xs-3">
			  <input  placeholder="From SVL" id="fromsvl" 
			  value="<?php echo $fromsvl; ?>" name="fromsvl" class="form-control">
			</div>
			 <div class="col-xs-3"> 
			  <input  placeholder="To SVL" id="tosvl" 
			  value="<?php echo $tosvl; ?>" name="tosvl" class="form-control">
			  </div>
			  <input name="submit" type="submit" value="Submit" class="btn srs-btn-reset"/>
			
				 
</form>
</div>         
 <?php 
		if($hq_id<>''){
		$sql="select * from tbl_hierarchy_org where id=".$hq_id;
		$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
		foreach ($rowrecord as $row1)
		{ 	echo 'You Have Selected : '.$row1->hierarchy_name;}
		}
		else
		{ echo 'Please Select HQ'; } 
		
		?>
	<br>
	<?php echo $this->session->userdata('alert_msg'); ?>       
</li>
</ul>

<div class="row">
<div class="box-body">	  
<div class="box-header" >&nbsp;</div>
</div>
</div>


<div class="col-md-12">
            
<div class="nav-tabs-custom" style="overflow:scroll">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#Add" data-toggle="tab">Add</a></li>
                  <li><a href="#Edit" data-toggle="tab">Edit</a></li>
                </ul>
                <div class="tab-content">
<?php
	
		if($hq_id<>''){ 
		//$hq_id=$hq_id.',387';
		
	    $sql="select * from tbl_hierarchy_org 	where tbl_designation_id='6' and 
		under_tbl_hierarchy_org=".$hq_id." 	order by  hierarchy_name ";
		$field_list=$this->projectmodel->get_records_from_sql($sql);	
	
?>
	<!--ADD DOCTORS-->
    <div class="active tab-pane" id="Add">
				  
                   <form id="frm" name="frm" method="post" 
action="<?php echo ADMIN_BASE_URL?>project_controller/doctor_master/save/add/" >

<input type="hidden" value="<?php echo $hq_id; ?>" name="hq_id" id="hq_id">
<input type="hidden" value="<?php echo $fromsvl; ?>" name="fromsvl" id="fromsvl">
<input type="hidden" value="<?php echo $tosvl; ?>" name="tosvl" id="tosvl">
		
		
		<table width="100%" class="srstable">
		<thead>
		<tr>
			<td  class="srscell-body">Svl No</td>
			<td  class="srscell-body">Field</td>
			<td  class="srscell-body">Doctor Name</td>
			<td  class="srscell-body">Speciality</td>
			<td  class="srscell-body">Qualification</td>
			<td  class="srscell-body">Type</td>
			<td  class="srscell-body">DETAILS</td>
			
		</tr>
		</thead>
		
		<?php 
		$code=$name=$address=$contactno=$email=$headq=$undermanager=$userid='';
		$password=$speciality=$address=$mob_no=$qualification=$headq=$undermanager=$userid='';
						
			$mob_no='';
			$chamber1='';
			$chamber2='';
			$chamber3='';
			$c_ph1='';
			$c_ph2='';
			$c_ph3='';
			$dob='';
			$dom='';
			$spouse_name='';
			$doc_type='';
			$children='';
			$brand_targeted='';
			$status='';
			$business_amount='';
			$designation='';
			$city='';
			$state='';
			$zone='';
			$district='';
			$VISITTIME='';
			$AD='';
			$SUNDAY='';
			$MONDAY='';
			$TUESDAY='';
			$WEDNESDAY='';
			$THURSDAY='';
			$FRIDAY='';
			$SATERDAY='';
			
		for($key=1;$key<=30;$key++){ ?>	  
			<tbody>	
		<tr>
			<td  class="srscell-body">
			<input  style="width:50px;" class="medium success"
			name="code<?php echo $key; ?>" id="code<?php echo $key; ?>"  
			value="<?PHP echo $code;?>" />
			</td>
			
			<td  class="srscell-body">
			<select id="headq<?php echo $key; ?>" 
			data-rel="chosen" name="headq<?php echo $key; ?>">
                <option value="">Select Field</option>
                <?php 
					foreach ($field_list as $row1)
					{ 						
					?>
					<option value="<?php echo $row1->id; ?>" 
					<?php if($row1->id==$headq) 
					{ echo 'selected="selected"'; } ?>>
					<?php echo $row1->hierarchy_name; ?>
					</option>
			  
			  	 <?php } ?>
      </select>
			</td>
			
			<td  class="srscell-body"><input  class="srs-txt" 
			name="name<?php echo $key; ?>" id="name<?php echo $key; ?>"  
			value="<?PHP echo $name;?>" /></td>
			
		<td  class="srscell-body">
		<select  name="speciality<?php echo $key; ?>" id="speciality<?php echo $key; ?>" >
		<?php 
			$sql="select * from brands where brandtype='SPECIALITY' 
			order by  brand_name ";
			$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
			foreach ($rowrecord as $row1)
			{ 						
			?>
			<option value="<?php echo $row1->id; ?>" 
			<?php if($row1->id==$speciality) 
			{ echo 'selected="selected"'; } ?>>
			<?php echo $row1->brand_name; ?>
			</option>
	  
		 <?php } ?>
		</select></td>
			
			<td  class="srscell-body">
			<input  style="width:100px;" class="medium success"
			name="qualification<?php echo $key; ?>" id="qualification<?php echo $key; ?>"  
			value="<?PHP echo $qualification;?>" /></td>
			
			<td  class="srscell-body">
			<select id="doc_type<?php echo $key; ?>" 
			name="doc_type<?php echo $key; ?>" >
                
				 <option value="Super_Core" 
				 <?php if($doc_type=='Super_Core') { echo 'selected="selected"'; } 
				 ?>>Super Core</option>
				 		  
                  <option value="Core" 
				  <?php if($doc_type=='Core') { echo 'selected="selected"'; } 
				  ?>>Core</option>
				  
				   <option value="Non_Core" 
				   <?php if($doc_type=='Non_Core') { echo 'selected="selected"'; }
				    ?>>Non Core</option>
				   
				  <option value="Ellite" 
				  <?php if($doc_type=='Ellite') { echo 'selected="selected"'; }
				   ?>>Ellite</option>
				  
                  <option value="Prescribing" 
				  <?php if($doc_type=='Prescribing') { echo 'selected="selected"'; }
				   ?>>Prescribing</option>
				   
				    <option value="Non-Prescribing" 
					<?php if($doc_type=='Non-Prescribing') 
					{ echo 'selected="selected"'; } ?>>Non-Prescribing
					</option>
					
      		 </select>
			 
			 </td>
			
			<td  class="srscell-head-lft">
			<div id="showmenu<?php echo $key; ?>">DETAILS</div>
			</td> 
            
		</tr>
		
		<tr><td colspan="6">
		<div class="menu<?php echo $key; ?>" style="display: none;">
			
			<table width="100%" class="srstable">
				  <tr>
	<td class="srscell-head-lft">Email Id</td>
	<td class="srscell-body" ><input  class="srs-txt" 
			name="email<?php echo $key; ?>" id="email<?php echo $key; ?>"  value="<?PHP echo $email;?>" /></td>
			
	<td class="srscell-head-lft">Contact No</td>
	<td class="srscell-body" ><input  class="srs-txt" 
			name="contactno<?php echo $key; ?>" id="contactno<?php echo $key; ?>"  value="<?PHP echo $contactno;?>" /></td>
					
	</tr>
				 
	<tr>
	<td class="srscell-head-lft"><strong>Visit Time </strong></td>
	<td class="srscell-body" colspan="3" >
	<select id="VISITTIME<?php echo $key; ?>" 
	data-rel="chosen" name="VISITTIME<?php echo $key; ?>" >
	
	  <option value="M" <?php if($VISITTIME=='M') 
	  { echo 'selected="selected"'; } ?>>MORNING
	  </option> 
	 <option value="E" <?php if($VISITTIME=='E') 
	 { echo 'selected="selected"'; } ?>>EVENING
	 </option>
	</select>
	AD<input name="AD<?php echo $key; ?>" type="checkbox" id="AD<?php echo $key; ?>" 	value="N" 
	<?PHP if($AD=='Y') { echo 'checked';}else {echo ''; }?> />
	SUNDAY<input name="SUNDAY<?php echo $key; ?>" type="checkbox" id="SUNDAY<?php echo $key; ?>" 	value="N" 
	<?PHP if($SUNDAY=='Y') { echo 'checked';}else {echo ''; }?> />
	MONDAY<input name="MONDAY<?php echo $key; ?>" type="checkbox" id="MONDAY<?php echo $key; ?>" 	value="N" 
	<?PHP if($MONDAY=='Y') { echo 'checked';}else {echo ''; }?> /><br>
	
	TUESDAY<input name="TUESDAY<?php echo $key; ?>" type="checkbox" id="TUESDAY<?php echo $key; ?>" 	value="N" 
	<?PHP if($TUESDAY=='Y') { echo 'checked';}else {echo ''; }?> />
	WEDNESDAY<input name="WEDNESDAY<?php echo $key; ?>" type="checkbox" id="WEDNESDAY<?php echo $key; ?>" 	value="N" 
	<?PHP if($WEDNESDAY=='Y') { echo 'checked';}else {echo ''; }?> />
	THURSDAY<input name="THURSDAY<?php echo $key; ?>" type="checkbox" id="THURSDAY<?php echo $key; ?>" 	value="N" 
	<?PHP if($THURSDAY=='Y') { echo 'checked';}else {echo ''; }?> /><br>
	
	FRIDAY<input name="FRIDAY<?php echo $key; ?>" type="checkbox" id="FRIDAY<?php echo $key; ?>" 	value="N" 
	<?PHP if($FRIDAY=='Y') { echo 'checked';}else {echo ''; }?> />
	SATERDAY<input name="SATERDAY<?php echo $key; ?>" type="checkbox" id="SATERDAY<?php echo $key; ?>" 	value="N" 
	<?PHP if($SATERDAY=='Y') { echo 'checked';}else {echo ''; }?> />
	
		
	</td>
	</tr>
	
		
	<tr>
	<td class="srscell-head-lft">Address</td>
	<td class="srscell-body"  ><textarea  
	 name="address<?php echo $key; ?>" id="address<?php echo $key; ?>" cols="20"><?PHP echo $address;?></textarea></td>
	 
	 
	</tr>
	
	<tr>
	<td class="srscell-head-lft">Chamber-1 Address</td>
	<td class="srscell-body" >
	<textarea class="srs-txt" name="chamber1<?php echo $key; ?>" id="chamber1<?php echo $key; ?>"><?PHP echo $chamber1;?>
	</textarea>
	</td>
			
	<td class="srscell-head-lft">Chamber-1 Phone</td>
	<td class="srscell-body" ><input  class="srs-txt" 
			name="c_ph1<?php echo $key; ?>" id="c_ph1<?php echo $key; ?>"  value="<?PHP echo $c_ph1;?>" />
	</td>
	</tr>
	
	<tr>
	<td class="srscell-head-lft">Chamber-2 Address</td>
	<td class="srscell-body" ><textarea  class="form-textarea" name="chamber2<?php echo $key; ?>" id="chamber2<?php echo $key; ?>"><?PHP echo $chamber2;?></textarea></td>
	<td class="srscell-head-lft">Chamber-2 Phone</td>
	<td class="srscell-body" ><input  class="srs-txt" 
			name="c_ph2<?php echo $key; ?>" id="c_ph2<?php echo $key; ?>"  value="<?PHP echo $c_ph2;?>" />
	</td>		
	</tr>
	
	<tr>
	<td class="srscell-head-lft">Chamber-3 Addres</td>
	<td class="srscell-body" ><textarea  class="form-textarea" name="chamber3<?php echo $key; ?>" id="chamber3<?php echo $key; ?>"><?PHP echo $chamber3;?></textarea></td>
	<td class="srscell-head-lft">Chamber-3 Phone</td>
	<td class="srscell-body" ><input  class="srs-txt" 
			name="c_ph3<?php echo $key; ?>" id="c_ph3<?php echo $key; ?>"  value="<?PHP echo $c_ph3;?>" /></td>
					
	</tr>
	
	<tr>
	<td class="srscell-head-lft">DOB</td>
	<td class="srscell-body" ><input  class="srs-txt" 
			name="dob<?php echo $key; ?>" id="dob<?php echo $key; ?>"  value="<?PHP echo $dob;?>" /></td>
			
	<td class="srscell-head-lft">DOM</td>

	<td class="srscell-body" ><input  class="srs-txt" 
			name="dom<?php echo $key; ?>" id="dom<?php echo $key; ?>"  value="<?PHP echo $dom;?>" /></td>
					
	</tr>
	
	<tr>
	<td class="srscell-head-lft">Children(if any)</td>
	<td class="srscell-body" ><input  class="srs-txt" 
			name="children<?php echo $key; ?>" id="children<?php echo $key; ?>"  value="<?PHP echo $children;?>" /></td>
			
	<td class="srscell-head-lft">Spouse</td>
	<td class="srscell-body" ><input  class="srs-txt" 
			name="spouse_name<?php echo $key; ?>" id="spouse_name<?php echo $key; ?>"  value="<?PHP echo $spouse_name;?>" /></td>
					
	</tr>
	

		
			</table>
		</div>
		</td></tr>		  
		
		</tbody>	
		<?php } ?>	
		
		<tr>
			<td  class="srscell-body" colspan="7" align="center">
			<button type="submit" class="btn btn-danger" id="Save" name="Save">Submit</button>
			
			</td>
		</tr>
		
		</table>
		</form>	
               
    </div>
                 
				 
				 
				  <div class="tab-pane" id="Edit">
                  	<form id="frm" name="frm" method="post" 
action="<?php echo ADMIN_BASE_URL?>project_controller/doctor_master/save/edit/" >
<input type="hidden" value="<?php echo $hq_id; ?>" name="hq_id" id="hq_id">
<input type="hidden" value="<?php echo $fromsvl; ?>" name="fromsvl" id="fromsvl">
<input type="hidden" value="<?php echo $tosvl; ?>" name="tosvl" id="tosvl">


		<table width="100%" class="srstable">
		<tr>
			<td  class="srscell-body">Svl No</td>
			<td  class="srscell-body">Field</td>
			<td  class="srscell-body">Doctor Name</td>
			<td  class="srscell-body">Speciality</td>
			<td  class="srscell-body">Qualification</td>
			<td  class="srscell-body">ACTIVITY_STATUS</td>
			<td  class="srscell-body">DETAILS</td>
			
		</tr>
		
		<?php 
		$code=$name=$address=$contactno=$email=$headq=$undermanager=$userid='';
		$password=$speciality=$address=$mob_no=$qualification=$headq=$undermanager=
		$userid=$ACTIVITY_STATUS='';
						
			$mob_no='';
			$chamber1='';
			$chamber2='';
			$chamber3='';
			$c_ph1='';
			$c_ph2='';
			$c_ph3='';
			$dob='';
			$dom='';
			$spouse_name='';
			$doc_type='';
			$children='';
			$brand_targeted='';
			$status='';
			$business_amount='';
			$designation='';
			$city='';
			$state='';
			$zone='';
			$district='';
			$VISITTIME='';
			$AD='';
			$SUNDAY='';
			$MONDAY='';
			$TUESDAY='';
			$WEDNESDAY='';
			$THURSDAY='';
			$FRIDAY='';
			$SATERDAY='';
			
		$sql_edit="select a.* from mr_manager_doctor  a,tbl_hierarchy_org b 
		where a.headq=b.id 	and b.tbl_designation_id='6' and b.under_tbl_hierarchy_org=".$hq_id."  
		and a.code between '$fromsvl' and '$tosvl' order by a.code,a.headq,a.name ";
		$doctor_list_edit=$this->projectmodel->get_records_from_sql($sql_edit);	
			
		foreach ($doctor_list_edit  as $key=>$row_edit)
		{
			$docid=$row_edit->id; 
			$code=$row_edit->code; 
			$headq=$row_edit->headq; 
			$name=$row_edit->name; 
			$qualification=$row_edit->qualification; 
			$doc_type=$row_edit->doc_type;
			$ACTIVITY_STATUS=$row_edit->ACTIVITY_STATUS;
		?>	  
				
		<tr  >
		
		<td  class="srscell-body">
		<?php //echo 'key '.$key; ?>
		<input   type="hidden" name="docid<?php echo $key; ?>" id="docid<?php echo $key; ?>"  value="<?php echo $docid; ?>" />
		
		<input  style="width:50px;" class="medium success"
		name="code_edit<?php echo $key; ?>" id="code_edit<?php echo $key; ?>"  
		value="<?PHP echo $code;?>" /><?PHP //echo $code;?>
		</td>
		
		<td  class="srscell-body">
			<select id="headq_edit<?php echo $key; ?>" 
			data-rel="chosen" name="headq_edit<?php echo $key; ?>">
                <?php 
					foreach ($field_list as $rfld)
					{ 						
					?>
					<option value="<?php echo $rfld->id; ?>" 
					<?php if($rfld->id==$headq) 
					{ echo 'selected="selected"'; } ?>>
					<?php echo $rfld->hierarchy_name; ?>
					</option>
			  
			  	 <?php } ?>
      </select>
			</td>
			
		<td  class="srscell-body"><input  class="srs-txt" 
			name="name_edit<?php echo $key; ?>" id="name_edit<?php echo $key; ?>"  
			value="<?PHP echo $name;?>" /></td>
			
		<td  class="srscell-body">
		<select  name="speciality_edit<?php echo $key; ?>" 	id="speciality_edit<?php echo $key; ?>" >
		<?php foreach ($speciality_list as $srow){?>
		
			<option value="<?php echo $srow->id; ?>" 
			<?php if($srow->id==$row_edit->speciality) 
			{ echo 'selected="selected"'; } ?>>
			<?php echo $srow->brand_name; ?>
			</option>
	  
		 <?php } ?>
		</select></td>
		
		<td  class="srscell-body">
			<input  style="width:100px;" class="medium success"
			name="qualification_edit<?php echo $key; ?>" 
			id="qualification_edit<?php echo $key; ?>"  
			value="<?PHP echo $qualification;?>" />
         </td>
         
					
		<td  class="srscell-body">
			<select id="ACTIVITY_STATUS<?php echo $key; ?>" 
			name="ACTIVITY_STATUS<?php echo $key; ?>" >
                
				 <option value="ACTIVE" 
				 <?php if($ACTIVITY_STATUS=='ACTIVE') { echo 'selected="selected"'; } 
				 ?>>ACTIVE</option>
							 		  
                  <option value="INACTIVE" 
				  <?php if($ACTIVITY_STATUS=='INACTIVE') { echo 'selected="selected"'; } 
				  ?>>INACTIVE</option>
				  
      		 </select>
	  </td>
			
	
				
		<td  class="srscell-head-lft">
				<div id="showmenu_edit<?php echo $docid; ?>">DETAILS</div>
		</td> 
				
	  </tr>
		
		
		<tr><td colspan="6">
		
				<div class="menu_edit<?php echo $docid; ?>" style="display: none;">
						<table width="100%" border="1">
						  <tr>
			<td class="srscell-head-lft">Email Id</td>
			<td class="srscell-body" ><input  class="srs-txt" 
					name="email_edit<?php echo $key; ?>" 
					id="email_edit<?php echo $key; ?>" 
					 value="<?PHP echo $row_edit->email;?>" /></td>
					
			<td class="srscell-head-lft">Contact No</td>
			<td class="srscell-body" ><input  class="srs-txt" 
					name="contactno_edit<?php echo $key; ?>" id="contactno_edit<?php echo $key; ?>"  value="<?PHP echo $row_edit->contactno;?>" /></td>
							
			</tr>
						 
			<tr>
			<td class="srscell-head-lft"><strong>Visit Time </strong></td>
			<td class="srscell-body" colspan="3" >
			<select id="VISITTIME<?php echo $key; ?>" data-rel="chosen" 
            name="VISITTIME<?php echo $key; ?>" >
			  <option value="M" <?php if($row_edit->VISITTIME=='M') 
			  { echo 'selected="selected"'; } ?>>MORNING
			  </option> 
			 <option value="E" <?php if($row_edit->VISITTIME=='E') 
			 { echo 'selected="selected"'; } ?>>EVENING
			 </option>
			</select>
			AD<input name="AD<?php echo $key; ?>" type="checkbox" id="AD<?php echo $key; ?>" 	value="N" 
			<?PHP if($row_edit->AD=='Y') { echo 'checked';}else {echo ''; }?> />
			
			SUNDAY<input name="SUNDAY<?php echo $key; ?>" type="checkbox" id="SUNDAY<?php echo $key; ?>" 	value="N" 
			<?PHP if($row_edit->SUNDAY=='Y') { echo 'checked';}else {echo ''; }?> />
			
			MONDAY<input name="MONDAY<?php echo $key; ?>" type="checkbox" id="MONDAY<?php echo $key; ?>" 	value="N" 
			<?PHP if($row_edit->MONDAY=='Y') { echo 'checked';}else {echo ''; }?> /><br>
			
			TUESDAY<input name="TUESDAY<?php echo $key; ?>" type="checkbox" id="TUESDAY<?php echo $key; ?>" 	value="N" 
			<?PHP if($row_edit->TUESDAY=='Y') { echo 'checked';}else {echo ''; }?> />
			
			WEDNESDAY<input name="WEDNESDAY<?php echo $key; ?>" type="checkbox" id="WEDNESDAY<?php echo $key; ?>" 	value="N" 
			<?PHP if($row_edit->WEDNESDAY=='Y') { echo 'checked';}else {echo ''; }?> />
			
			THURSDAY<input name="THURSDAY<?php echo $key; ?>" type="checkbox" id="THURSDAY<?php echo $key; ?>" 	value="N" 
			<?PHP if($row_edit->THURSDAY=='Y') { echo 'checked';}else {echo ''; }?> /><br>
			
			FRIDAY<input name="FRIDAY<?php echo $key; ?>" type="checkbox" id="FRIDAY<?php echo $key; ?>" 	value="N" 
			<?PHP if($row_edit->FRIDAY=='Y') { echo 'checked';}else {echo ''; }?> />
			
			SATURDAY<input name="SATERDAY<?php echo $key; ?>" type="checkbox" id="SATERDAY<?php echo $key; ?>" 	value="N" 
			<?PHP if($row_edit->SATERDAY=='Y') { echo 'checked';}else {echo ''; }?> />
			
				
			</td>
			</tr>
					
			<tr>
			<td class="srscell-head-lft">Address</td>
			<td class="srscell-body"  ><textarea  
			 name="address<?php echo $key; ?>" id="address<?php echo $key; ?>" cols="20"><?PHP echo $row_edit->address;?></textarea></td>
			 
			 	<td  class="srscell-body">
			<select id="doc_type<?php echo $key; ?>" 
			name="doc_type<?php echo $key; ?>" class="srs-dropdwn">
                
				 <option value="Super_Core" 
				 <?php if($doc_type=='Super_Core') { echo 'selected="selected"'; } 
				 ?>>Super Core</option>
				 		  
                  <option value="Core" 
				  <?php if($doc_type=='Core') { echo 'selected="selected"'; } 
				  ?>>Core</option>
				  
				   <option value="Non_Core" 
				   <?php if($doc_type=='Non_Core') { echo 'selected="selected"'; }
				    ?>>Non Core</option>
				   
				  <option value="Ellite" 
				  <?php if($doc_type=='Ellite') { echo 'selected="selected"'; }
				   ?>>Ellite</option>
				  
                  <option value="Prescribing" 
				  <?php if($doc_type=='Prescribing') { echo 'selected="selected"'; }
				   ?>>Prescribing</option>
				   
				    <option value="Non-Prescribing" 
					<?php if($doc_type=='Non-Prescribing') 
					{ echo 'selected="selected"'; } ?>>Non-Prescribing
					</option>
					
      		 </select>
			 
			 </td>
			</tr>
			
			<tr>
			<td class="srscell-head-lft">Chamber-1 Address</td>
			<td class="srscell-body" >
			<textarea class="srs-txt" name="chamber1<?php echo $key; ?>" id="chamber1<?php echo $key; ?>"><?PHP echo $row_edit->chamber1;?>
			</textarea>
			</td>
					
			<td class="srscell-head-lft">Chamber-1 Phone</td>
			<td class="srscell-body" ><input  class="srs-txt" 
					name="c_ph1<?php echo $key; ?>" id="c_ph1<?php echo $key; ?>"  value="<?PHP echo $row_edit->c_ph1;?>" />
			</td>
			</tr>
			
			<tr>
			<td class="srscell-head-lft">Chamber-2 Address</td>
			<td class="srscell-body" >
			<textarea  class="form-textarea" name="chamber2<?php echo $key; ?>" id="chamber2<?php echo $key; ?>"><?PHP echo $row_edit->chamber2;?></textarea></td>
			<td class="srscell-head-lft">Chamber-2 Phone</td>
			<td class="srscell-body" ><input  class="srs-txt" 
					name="c_ph2<?php echo $key; ?>" id="c_ph2<?php echo $key; ?>"  value="<?PHP echo $row_edit->c_ph2;?>" />
			</td>		
			</tr>
			
			<tr>
			<td class="srscell-head-lft">Chamber-3 Addres</td>
			<td class="srscell-body" ><textarea  class="form-textarea" name="chamber3<?php echo $key; ?>" id="chamber3<?php echo $key; ?>"><?PHP echo $row_edit->chamber3;?></textarea></td>
			<td class="srscell-head-lft">Chamber-3 Phone</td>
			<td class="srscell-body" ><input  class="srs-txt" 
					name="c_ph3<?php echo $key; ?>" id="c_ph3<?php echo $key; ?>"  value="<?PHP echo $row_edit->c_ph3;?>" /></td>
							
			</tr>
			
			<tr>
			<td class="srscell-head-lft">DOB</td>
			<td class="srscell-body" ><input  class="srs-txt" 
					name="dob<?php echo $key; ?>" id="dob<?php echo $key; ?>"  value="<?PHP echo $row_edit->dob;?>" /></td>
					
			<td class="srscell-head-lft">DOM</td>
			<td class="srscell-body" >
            <input  class="srs-txt" name="dom<?php echo $key; ?>" id="dom<?php echo $key; ?>"  value="<?PHP echo $row_edit->dom;?>" /></td>
							
			</tr>
			
			<tr>
			<td class="srscell-head-lft">Children(if any)</td>
			<td class="srscell-body" ><input  class="srs-txt" 
					name="children<?php echo $key; ?>" id="children<?php echo $key; ?>"  value="<?PHP echo $row_edit->children;?>" /></td>
					
			<td class="srscell-head-lft">Spouse</td>
			<td class="srscell-body" ><input  class="srs-txt" 
					name="spouse_name<?php echo $key; ?>" id="spouse_name<?php echo $key; ?>"  value="<?PHP echo $row_edit->spouse_name;?>" /></td>
                    
							
			</tr>
			
			</table>
				</div>
				
		</td></tr>
		
			
		<?php } ?>	
		        
        <tr>
			<td  class="srscell-body" colspan="7" align="center">
			
			<button type="submit" class="btn btn-danger" id="Save" name="Save">Submit</button>
			
			</td>
		</tr>
		
		</table>
		
		</form>	
                  </div>
<?php } ?>		  
                </div><!-- /.tab-content -->
              </div>

</div>


</div><!-- /.tab-pane -->