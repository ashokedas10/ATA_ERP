<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
function getlink(href) 
{
	//alert(href);	
	if(href) {window.location = href;}			
}
</script>
<style>

table#example {
    border-collapse: collapse;   
}
#example tr {
    background-color: #eee;
    border-top: 1px solid #fff;
}
#example tr:hover {
    background-color: #ccc;
}
#example th {
    background-color: #fff;
}
#example th, #example td {
    padding: 3px 5px;
}
#example td:hover {
    cursor: pointer;
}

a {
  color:#000000;
  text-decoration: none;
}
</style>

<div class="panel panel-primary" >
	
	  <div class="panel-body" align="center" >
		<h3><span class="label label-default"><?php echo $REPORT_NAME;?></span>
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
 
<?php echo $report_parameter;?>

 <!--REPORT PARAMETER SECTION END-->
  
  <?php if($with_paran=='YES') { ?>
  
<div id="printablediv">

	
	
	
	<?php if($REPORT_TYPE=='REPORT_TYPE-1'){
			if(sizeof($report_data)>0){
			 ?>
			<table   class="table table-bordered table-striped" id="example">
				<tr >
				<?php foreach($report_data['header'][0] as $key=>$value){?>	<td  class="bg-primary"> <?php echo $key; ?></td><?php } ?>	
				 </tr>
				 
				<?php foreach($report_data['header'] as $key=>$array_record){?>	
				<tr>
				<?php foreach($array_record as $key2=>$values){?>				
				<td> <?php echo $values; ?></td>
				<?php } ?>	
				 </tr>	
				<?php } ?>						
				</table>
			<?php }else{ ?>
			
			<table   class="table table-bordered table-striped" id="example">
				<tr >
					<td  class="bg-primary" align="center">No data Found</td>
				 </tr>	
			</table>
			
	<?php }} ?>
	
	
	
	<?php if($REPORT_NAME=='TRIAL_BALANCE'){
	
	echo '<pre>';print_r($report_data);echo '<pre>';
	
	 ?>
	 
	 
	
	
	<?php } ?>	
	
	
	
	
				
</div>	
  
   <?php } ?>

<div class="panel panel-primary" >
			<div class="panel-body" align="center" style="background-color:#3c8dbc">
					<button type="button" class="btn btn-danger" onclick="myExportToExcel();">Excel</button>	
			</div>
</div> 



<script>
$(document).ready(function() {

    $('#example tr').click(function() {
        var href = $(this).find("a").attr("href");
        if(href) {window.location = href;}
    });

});
</script>

 <script>
  
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
  

	
	