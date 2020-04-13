
<script language="javascript" type="text/javascript">
		
		function print_result() {
				
	var base_url = '<?php echo ADMIN_BASE_URL.'tour_plan_expense_controller/hq_to_location_master/';  ?>';
			//url=base_url+visitdate+'/'+hqid;
			
			url=base_url;
			newwindow=window.open(url,'name','height=600,width=800');
			if (window.focus) {newwindow.focus()}
			return false;
		}
</script>


<script type="text/javascript">
            var controller = 'project_controller';
            var base_url = '<?php echo ADMIN_BASE_URL;  ?>';						
            function load_field(type)
			{
                $.ajax({
                    'url' : base_url + controller + '/load_ajax_field',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'type' : type},
                    'success' : function(data){ 
					 var container_field = $('#container_field'); 
					 if(data){
					 //alert(data);
                            container_field.html(data);
                        }
                    }
                });
            }
</script>
<!--KRIS EGRA,SINGUR,BAHA,SONAR,PANCHA-->

<!--data table start   MAMPI123-->
<style type="text/css">
<!--
.style1 {
	color: #CC3300;
	font-weight: bold;
	font-size: 14px;
}
-->
</style>
<h2><span class="tcat">Master Create</span></h2>

<form action="<?php echo ADMIN_BASE_URL?>project_controller/master_data_upload/" 
	name="frmreport" id="frmreport" method="post">
	<table  border="0" cellpadding="0" cellspacing="0" class="srstable"> 
		
		 <tr>

	<td width="127" class="srscell-head-lft">Select HQ </td>
	<td class="srscell-body"  colspan="2">
	<select id="hq_id" data-rel="chosen" name="hq_id" >
      <option value="">Select All</option>
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
        </select>
		
		</td>
		
		<td class="srscell-body"  colspan="2">
		<select id="activity_type" name="activity_type" class="srs-dropdwn">
                 
				  <option value="Location_create" 
				  <?php if($activity_type=='Location_create') 
				  { echo 'selected="selected"'; } ?>>
				  Location_create</option>
				  
                  <option value="Doctor_create" 
				  <?php if($activity_type=='Doctor_create') { echo 
				  'selected="selected"'; } ?>>Doctor_create
				  </option>
				  
				   <option value="Doctor_insert_main_table" 
				  <?php if($activity_type=='Doctor_insert_main_table') { echo 
				  'selected="selected"'; } ?>>Doctor_insert_main_table
				  </option>
				  
				  
                  <option value="Retailer_create" 
				  <?php if($activity_type=='Retailer_create') { echo 
				  'selected="selected"'; } ?>>Retailer_create
				  </option>
				  
				   <option value="Retailer_insert_main_table" 
				  <?php if($activity_type=='Retailer_insert_main_table') { echo 
				  'selected="selected"'; } ?>>Retailer_insert_main_table
				  </option>
				  
				  <option value="Retailer_inactive" 
				  <?php if($activity_type=='Retailer_inactive') { echo 
				  'selected="selected"'; } ?>>Retailer Inactive
				  </option>
				  
				  
				  
				  <option value="Stockist_create" 
				  <?php if($activity_type=='Stockist_create') { echo 
				  'selected="selected"'; } ?>>Stockist_create
				  </option>
				  				  
				  <option value="Stockist_insert_main_table" 
				  <?php if($activity_type=='Doctor_insert_main_table') { echo 
				  'selected="selected"'; } ?>>Stockist_insert_main_table
				  </option>
				  
				  <option value="Delete_location_doctor_stockist_retailer" 
				  <?php if($activity_type=='Delete_location_doctor_stockist_retailer') 
				  { echo 'selected="selected"'; } ?>>
				  In-active doctor list
				  </option> 
				  
				  <option value="Standard_tour_plan" 
				  <?php if($activity_type=='Standard_tour_plan') { echo 
				  'selected="selected"'; } ?>>Standard_tour_plan
				  </option>
				  
				  <option value="Tour_Expense_master" 
				  <?php if($activity_type=='Tour_Expense_master') { echo 
				  'selected="selected"'; } ?>>Tour_Expense_master
				  </option>
				  
				   
        </select>
		</td>
		
		<td width="172" class="srscell-body">
			 <input type="password" id="pass" class="srs-txt"  value="" name="pass" 
			  style='text-transform:uppercase'/>
		</td>
		
		<td width="172" class="srscell-body">
		<input name="submit" type="submit" value="Submit" class="btn srs-btn-reset"/>
		
		<a href="<?php echo BASE_PATH_FRONT?>import_from_excel" target="_blank">
		<input name="upload" type="button" value="Upload" class="btn srs-btn-reset"/>
		</a>
		
		<!--<input name="Print" type="button" value="Print" class="btn btn-green" 
onclick="print_result()"/> -->
		</td>
	</tr>
          
  </table>
</form>

<?php if($activity_type=='Location_create') { ?>

<table class="data display datatable" id="example">
					<thead>
						<tr>
							<th width="37">Sl </th>
							<th width="121">Field/Location</th>
							<th width="121">Hq</th>
						</tr>
					</thead>
					
					<tbody>
					<?php
					if($hq_id=='')
					{
					$sql="select distinct(hq_id) hq_id from import_doctor_master ";
					}
					else
					{
					$sql="select distinct(hq_id) hq_id from 
					import_doctor_master where hq_id=".$hq_id;
					}
					
					
					$projectlist = $this->projectmodel->get_records_from_sql($sql);	
					$i = 1;
					foreach ($projectlist as $row){
					
					$sql2="select * from tbl_hierarchy_org where 
					under_tbl_hierarchy_org=".$row->hq_id;
					$rowrecord2 = $this->projectmodel->get_records_from_sql($sql2);	
					foreach ($rowrecord2 as $row2)
					{$fieldid=$row2->id;
					
					?>
					
					<tr>
					
					<td><?php echo $i; ?></td>
					<td>
					<?php 
					$sql3="select * from tbl_hierarchy_org where id=".$fieldid;
					$rowrecord3 = $this->projectmodel->get_records_from_sql($sql3);	
					foreach ($rowrecord3 as $row3)
					{echo $row3->hierarchy_name;}
					?>	
					
					</td>
					
					<td>
					<?php 
					$sql3="select * from tbl_hierarchy_org where id=".$row->hq_id;
					$rowrecord3 = $this->projectmodel->get_records_from_sql($sql3);	
					foreach ($rowrecord3 as $row3)
					{echo $row3->hierarchy_name;}
					?>
					</td>
					
				</tr>
				
				
				<?php 
				$i++;	
				}
				}
				?>		
				
		 </tbody>
		</table>
<?php } ?>


<?php if($activity_type=='Doctor_create') { ?>

<table class="data display datatable" id="example">
					<thead>
						<tr>
							<th width="37">Sl </th>
							<th width="37">SVLNO</th>
							<th width="121">Doctor Name</th>
							<th width="121">Field/Location</th>
							<th width="121">HQ Name</th>
							<th width="121">QUALIFICATION</th>
							<th width="121">SPECIALITY</th>
							<th width="121">TYPE</th>
						</tr>
					</thead>
					
					<tbody>
					<?php
					
					if($hq_id=='')
					{
					$sql="select * from import_doctor_master ";
					}
					else
					{
					$sql="select * from	import_doctor_master where hq_id=".$hq_id;
					}
					
					$projectlist = $this->projectmodel->get_records_from_sql($sql);	
					$i = 1;
					foreach ($projectlist as $row){
					?>
					
					<tr>
					
					<td><?php echo $i; ?></td>
					<td><?php echo $row->SVLNO; ?></td>
					<td><?php echo $row->DOCNAME; ?></td>
					
					<td>
					<?php 
					$sql3="select * from tbl_hierarchy_org where id=".$row->field_id;
					$rowrecord3 = $this->projectmodel->get_records_from_sql($sql3);	
					foreach ($rowrecord3 as $row3)
					{echo $row3->hierarchy_name;}
					?>	
					</td>
					
					<td>
					<?php 
					$sql3="select * from tbl_hierarchy_org where id=".$row->hq_id;
					$rowrecord3 = $this->projectmodel->get_records_from_sql($sql3);	
					foreach ($rowrecord3 as $row3)
					{echo $row3->hierarchy_name;}
					?>
					</td>
					<td><?php echo $row->QUALIFICATION; ?></td>
					<td><?php echo $row->SPECIALITY; ?></td>
					<td><?php echo $row->doc_type; ?></td>
				</tr>
				
				
				<?php $i++;} ?>		
				
		 </tbody>
		</table>
<?php } ?>



<?php if($activity_type=='Retailer_create') { ?>

<table class="data display datatable" id="example">
					<thead>
						<tr>
							<th width="37">Sl </th>
							<th width="121">Retailer Name</th>
							<th width="121">Field/Location</th>
							<th width="121">HQ Name</th>							
						</tr>
					</thead>
					
					<tbody>
					<?php
					
					if($hq_id=='')
					{
					$sql="select * from import_retailer_master ";
					}
					else
					{
					$sql="select * from	import_retailer_master where hq_id=".$hq_id;
					}
					
					$projectlist = $this->projectmodel->get_records_from_sql($sql);	
					$i = 1;
					foreach ($projectlist as $row){
					?>
					
					<tr>
					
					<td><?php echo $i; ?></td>
					<td><?php echo $row->NAME; ?></td>
					<td>
					<?php 
					$sql3="select * from tbl_hierarchy_org where id=".$row->field_id;
					$rowrecord3 = $this->projectmodel->get_records_from_sql($sql3);	
					foreach ($rowrecord3 as $row3)
					{echo $row3->hierarchy_name;}
					?>	
					</td>
					
					<td>
					<?php 
					$sql3="select * from tbl_hierarchy_org where id=".$row->hq_id;
					$rowrecord3 = $this->projectmodel->get_records_from_sql($sql3);	
					foreach ($rowrecord3 as $row3)
					{echo $row3->hierarchy_name;}
					?>
					</td>
				
				</tr>
				
				
				<?php $i++;} ?>		
				
		 </tbody>
		</table>
		
<?php } ?>


