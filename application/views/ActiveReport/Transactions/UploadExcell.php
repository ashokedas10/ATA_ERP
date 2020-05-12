
<style type="text/css">
<!--
.style1 {
	color: #CC3300;
	font-weight: bold;
	font-size: 14px;
}
-->
</style>
<h2><span class="tcat">Upload Data
</span></h2>
<div class="box-header with-border">
	<?php if($this->session->userdata('alert_msg')<>''){ ?>
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" 
		aria-hidden="true">&times;</button>
		<h4><i class="icon fa fa-check"></i>
		<?php echo $this->session->userdata('alert_msg'); ?></h4>
		</div>
	<?php } ?>
</div>


<?php /*?><form action="<?php echo ADMIN_BASE_URL?>Project_controller/DataUpdateDelete/" 
	name="frmreport" id="frmreport" method="post" enctype="multipart/form-data">
	<table  border="0" cellpadding="0" cellspacing="0" class="srstable" style="width:100%"> 
		

<tr><td width="127" class="srscell-head-lft"><?php echo $msgdelete; ?></td></tr>


<tr>
	
	
	<td width="127" class="srscell-head-lft">DELETE HQ</td>
		<td class="srscell-body">
		
			   
	   <select id="hq_id" data-rel="chosen" name="hq_id" onChange="load_field(this.value)">
          <option value="">Select Position</option>
   			 <?php 
			
				$sql="select a.id,a.hierarchy_name ,b.name
				 from tbl_hierarchy_org  a,tbl_employee_mstr b
				 where	b.id=a.employee_id AND a.tbl_designation_id=5
				 order by  a.hierarchy_name";
				$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
								
				?>
					
								
				<?php foreach ($rowrecord as $row1){?>					
				<option value="<?php echo $row1->id; ?>">
				<?php echo $row1->hierarchy_name.'('.$row1->name.')'; ?>
				</option>				
			  	 <?php } ?>
        </select>
	   
	</td>
	
	
	<td width="127" class="srscell-head-lft">Select</td>
		<td class="srscell-body">
		
		 <select id="SettingName"   name="SettingName" >
             <option value="DOCTOR_MASTER" selected="selected">DOCTOR DELETE</option>
			 <option value="RETAILER_MASTER">RETAILER DELETE</option>
			 <option value="LOCATION">INVALID LOCATION DELETE</option>
       </select>
	</td>
		
					  
			<td class="srscell-head-lft">password</td>
              <td class="srscell-body">			  
			  <input type="text" name="psw" id="psw" value="">
			  </td>  
		
		</td>
		
		
		<td width="172" class="srscell-body">
	   <input name="Upload" type="submit" value="DELETE" class="btn srs-btn-reset"/>
		</td>
</tr>
          
  </table>
</form><?php */?>

<form action="<?php echo ADMIN_BASE_URL?>Project_controller/Master_upload/" 
	name="frmreport" id="frmreport" method="post" enctype="multipart/form-data">
	<table  border="0" cellpadding="0" cellspacing="0" class="srstable" style="width:100%"> 
		
	<tr>
	<td width="127" class="srscell-head-lft">DOWNLOAD FORMAT</td>
	<td class="srscell-body"><a href="<?php echo BASE_PATH_ADMIN;?>	
	theme_files/UPLOAD_FORMAT.xls">UPLOAD FORMAT</a>
	</td>
	</tr>
	
<tr>
	
	
	<td width="127" class="srscell-head-lft">Temp/Original</td>
		<td class="srscell-body">
		
		 <select id="temp_original" class="form-control select2"  
		 name="temp_original" >
                 <!-- <option value="TEMPORARY" selected="selected">TEMPORARY VIEW</option>-->
				 <option value="FINAL" selected="selected">FINAL UPLOAD</option>
       </select>
	</td>
	
	
	<td width="127" class="srscell-head-lft">Select</td>
		<td class="srscell-body">
		
		 <select id="SettingName" class="form-control select2"   name="SettingName" >
             <option value="DATA_MASTER" selected="selected">DATA_MASTER</option>
			 
			 <!--<option value="RETAILER_MASTER">RETAILER_MASTER</option>
			 <option value="STOCKIST_MASTER">STOCKIST_MASTER</option>			 
			 <option value="FARECHART">FARE CHART UPLOAD</option>
			 <option value="GST_TEST">GST TEST</option>
			 
			 <option value="SALES_TREND">SALES_TREND</option>
			 <option value="ITEM_WISE_SALE">ITEM_WISE_SALE</option>
			 <option value="CATEGORY_WISE_SALE">CATEGORY_WISE_SALE</option>-->
			 
       </select>
	</td>
		
		 <td class="srscell-head-lft">File: </td>
              <td class="srscell-body">			  
			  <input type="file" name="image1" id="image1" value="">
			  </td>
		
		</td>
		
		
		<td width="172" class="srscell-body">
	   <input name="Upload" type="submit" value="Upload" class="btn srs-btn-reset"/>
		</td>
</tr>
          
  </table>
</form>


<?php if($DisplayGrid=='YES'){ ?>
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
					if($key1=='id'){$id=$bdr;  }
				?>
				<td align="<?php echo $align[1]; ?>"><?php echo $bdr; ?></td>
				<?php } ?>
				
				
			</tr>
			<?php } ?>	
	 </tbody>
</table>   
</div>
<?php } ?>  

