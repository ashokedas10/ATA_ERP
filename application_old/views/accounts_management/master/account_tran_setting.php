<script type="text/javascript">
            var controller = 'accounts_controller';
            var base_url = '<?php echo ADMIN_BASE_URL;  ?>';	
			var viewname='account_rean_setting';
           
		    function load_field(tran_table_name)
			{
				//alert(tran_table_name);
				
				//var tran_table_name 
				//=document.getElementById('tran_table_name').value;
                var fldname='tran_table_fld';
				$.ajax({
                    'url' : base_url + controller + '/load_ajax',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'tran_table_name' : tran_table_name,
					'viewname': viewname,'fldname' :fldname },
                    'success' : function(data){ 
					 var fld_cont1 = $('#fld_cont1');
					 if(data){ fld_cont1.html(data); }
                    }
                });
				
				 var fldname='qnty_fld';
				
				$.ajax({
                    'url' : base_url + controller + '/load_ajax',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'tran_table_name' : tran_table_name,
					'viewname': viewname,'fldname' :fldname },
                    'success' : function(data){ 
					 var fld_cont1 = $('#fld_cont2');
					 if(data){ fld_cont1.html(data); }
                    }
                });
				
				
				var fldname='rate_fld';
				 
				$.ajax({
                    'url' : base_url + controller + '/load_ajax',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'tran_table_name' : tran_table_name,
					'viewname': viewname,'fldname' :fldname },
                    'success' : function(data){ 
					 var fld_cont1 = $('#fld_cont3');
					 if(data){ fld_cont1.html(data); }
                    }
                });
				
				
				var fldname='percentage_fld';
				 
				$.ajax({
                    'url' : base_url + controller + '/load_ajax',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'tran_table_name' : tran_table_name,
					'viewname': viewname,'fldname' :fldname },
                    'success' : function(data){ 
					 var fld_cont1 = $('#fld_cont4');
					 if(data){ fld_cont1.html(data); }
                    }
                });
				
			
			}
			
</script>
				

<div class="box-header" style="background-color:#3c8dbc" >
	  
	    <div class="col-md-6">
	  <a href="<?php echo $product_addedit.'0/0/'; ?>">
			 <button class="btn btn-success btn-flat margin">New Entry</button>
	 </a>
	  </div>
	  <div class="col-md-6">
			<span class="info-box-number style1">ACCOUNTS SETTING</span>
 	 </div>
</div>
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



<?php 
			
			$voucher_type='';
			$tran_table_name='';
			$tran_table_fld='';
			$tran_table_fld=$ledger_tran_type='';
			$ledger_ac=$remarks=$qnty_fld=$rate_fld=$percentage_fld='';	
			$TRAN_TABLE='';
			
		if(count($records_edit) > 0)
		{
			foreach ($records_edit as $fld) 
			{ 
			/*CHANGE HERE*/					
			$voucher_type=$fld->voucher_type;
			$tran_table_name=$fld->tran_table_name;
			$tran_table_fld=$fld->tran_table_fld;
			$ledger_tran_type=$fld->ledger_tran_type;
			$tran_table_fld=$fld->tran_table_fld;
			$qnty_fld=$fld->qnty_fld;
			$rate_fld=$fld->rate_fld;
			$percentage_fld=$fld->percentage_fld;
			$remarks=$fld->remarks;
			$ledger_ac=$fld->ledger_ac;
			$TRAN_TABLE=$fld->TRAN_TABLE;
			}	
		}
		
?>
 
 
  
<form id="frm" name="frm" method="post" 
action="<?php echo ADMIN_BASE_URL?>accounts_controller/acc_tran_setting_save/" >

<input type="hidden" value="<?php echo $this->uri->segment(4); ?>" name="id" id="id">

   
   
  <table class="srstable">
    
	
	
	 <tr>
              <td width="114" class="srscell-head-lft">Remarks</td>
              <td width="558" class="srscell-body">
			  <textarea name="remarks" id="remarks"  
			   cols="50" rows="3" ><?php echo $remarks; ?></textarea>
	
	</td>
	</tr>
	
	 <tr>
              <td class="srscell-head-lft">Voucher Name</td>
              <td class="srscell-body">
			  <select id="voucher_type" name="voucher_type" class="srs-dropdwn">
               
			     <option value="PURCHASE" <?php if($voucher_type=='PURCHASE') 
				  { echo 'selected="selected"'; } ?>>PURCHASE</option>
				  
                  <option value="SELL" <?php if($voucher_type=='SELL') 
				  { echo 'selected="selected"'; } ?>>SELL</option>
				  
                  <option value="VENDOR_PAYMENT" <?php if($voucher_type=='VENDOR_PAYMENT') 
				  { echo 'selected="selected"'; } ?>>VENDOR_PAYMENT</option>	
				  	
				  		  
				   
                </select>
              </td>
    </tr>
	
	
	
	<?php /*?><tr>
	<td width="140" class="srscell-head-lft">Group Name </td>
	<td width="274" class="srscell-body"><input  class="srs-txt" 
			name="acc_name" id="acc_name"  value="<?PHP echo $acc_name;?>" /></td>
	</tr><?php */?>
				
	
	<tr>
	<td class="srscell-head-lft">Table Name</td>
	<td class="srscell-body">
	
	<select id="tran_table_name" data-rel="chosen" name="tran_table_name"
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
	</tr>
	
	<tr>
	<td class="srscell-head-lft">Table fld name</td>
	<td class="srscell-body">
	<?php echo 'Previous Selected :'.$tran_table_fld.'<br>' ?>
	<div id="fld_cont1"></div>
	
	</td>
	</tr>
	
	<tr>
	<td class="srscell-head-lft">Qnty fld</td>
	<td class="srscell-body">
	<?php echo 'Previous Selected :'.$qnty_fld.'<br>' ?>
	<div id="fld_cont2"></div>
	
	</td>
	</tr>
	
	<tr>
	<td class="srscell-head-lft">Rate fld </td>
	<td class="srscell-body">
	<?php echo 'Previous Selected :'.$rate_fld.'<br>' ?>
	<div id="fld_cont3"></div>
	
	</td>
	</tr>
	
	<tr>
	<td class="srscell-head-lft">Percentage fld </td>
	<td class="srscell-body">
	<?php echo 'Previous Selected :'.$percentage_fld.'<br>' ?>
	<div id="fld_cont4"></div>
	
	</td>
	</tr>
	
	 <tr>
              <td class="srscell-head-lft">Ledger Tran Type </td>
              <td class="srscell-body">
			  <select id="ledger_tran_type" name="ledger_tran_type" class="srs-dropdwn">
               
                  <option value="CR" <?php if($ledger_tran_type=='CR') 
				  { echo 'selected="selected"'; } ?>>CR</option>
				  
                   <option value="DR" <?php if($ledger_tran_type=='DR') 
				  { echo 'selected="selected"'; } ?>>DR</option>
				  
                </select>
              </td>
            </tr>
			
		 <tr>
              <td class="srscell-head-lft">AC LEDGER TRAN TABLE</td>
              <td class="srscell-body">
			  <select id="TRAN_TABLE" name="TRAN_TABLE" class="srs-dropdwn">
               
			   <option value="acc_tran_header" <?php if($TRAN_TABLE=='acc_tran_header') 
			  { echo 'selected="selected"'; } ?>>Ac Header table</option>
			  
			  <option value="acc_tran_details" <?php if($TRAN_TABLE=='acc_tran_details') 
			  { echo 'selected="selected"'; } ?>>Ac Detail table</option>
			  
			  
				  
                </select>
              </td>
            </tr>
		
		<tr>
	<td class="srscell-head-lft">Ledger A/c</td>
	<td class="srscell-body">
	
	<select id="ledger_ac" data-rel="chosen" name="ledger_ac">
    <option value="" >No Ledger Select</option>
					           
    <?php 
	$groupname='';
	$sql = "select * from  acc_group_ledgers 
	where acc_type='LEDGER'	 order by  acc_name ";
	$parent_records = $this->projectmodel->get_records_from_sql($sql);	
	foreach ($parent_records as $row1)
	{ 
	
	$sql_grp = "select * from  acc_group_ledgers 
	where id=".$row1->parent_id;
	$parent_records_grp = $this->projectmodel->get_records_from_sql($sql_grp);	
	foreach ($parent_records_grp as $row_grp)
	{ $groupname= $row_grp->acc_name;   }
							
	?>
					<option value="<?php echo $row1->id; ?>" 
					<?php if($row1->id==$ledger_ac) 
					{ echo 'selected="selected"'; } ?>>
					<?php echo $row1->acc_name."(".$groupname.")"; ?>
					</option>
			  
	<?php } ?>
        </select>
	<br />(if Select direct transact to this ledger. If not select then transaction table 's ledger map fld will effect) </td>
	</tr>
				
		<tr class="alt1">
              <td valign="top" align="center" colspan="2" class="srscell-body">
		<input type="submit" class="srs-btn-submit" value="Save" id="Save" 
		name="Save"> 
			  </td>
            </tr>
	</table>
  
</form>



	<table  id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="36">TAB ID </th>
							<th width="60">Voucher Name </th>
							<th width="42">Table Name </th>
							<th width="42">Table fld </th>
							<th width="27"> CR / DR </th>
							<th width="194">Ledger TRAN TABLE</th>
							<th width="198">Remarks</th>
							<th width="53">Action</th>
							
						</tr>
					</thead>
					
					<tbody>
					<?php
					if(count($records) > 0){
					$i = 1;
					foreach ($records as $row){
						$alt = ($i%2==0)?'alt1':'alt2';
					?>
					
						<tr class="<?php if($i%2==0) { echo ' even gradeX'; } 
						else {  echo ' odd gradeC'; } ?> ">
							<td><?php echo $row->id; ?></td>
							<td><?php echo $row->voucher_type; ?></td>
							<td><?php echo $row->tran_table_name; ?></td>
							<td><?php echo $row->tran_table_fld; ?></td>		
							<td><?php echo $row->ledger_tran_type; ?></td>
							<td><?php echo $row->TRAN_TABLE; ?></td>
							<td><?php echo $row->remarks; ?></td>
						<td class="center"> 
						 <a href="<?php echo $product_addedit.$row->id; ?>">
						<input type="submit" class="srs-btn-submit" value="Edit" 
							id="Save" name="Save"></a>
						</td>
					
					</tr>
				
				
				<?php $i++;}}?>		
				
					</tbody>
				</table>

