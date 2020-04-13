 <script language="javascript" type="text/javascript">
		
	function tree_view_operation_unit(parent_id) {
	var base_url = '<?php echo ADMIN_BASE_URL.'Project_controller/treeview/';  ?>';
	var url=base_url+parent_id+'/OPERATION_ENTITY';
	
	window.location.href = url;
			
		/*	url=base_url;
			newwindow=window.open(url,'name','height=600,width=800');
			if (window.focus) {newwindow.focus()}
			return false;*/
	}
</script>
<style>
.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}
</style>
<link href="https://fonts.googleapis.com/css?family=Bitter&display=swap" rel="stylesheet">

  
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {packages:["orgchart"]});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        data.addColumn('string', 'ToolTip');

        // For each orgchart box, provide the name, manager, and tooltip to show.
       <?php /*?> data.addRows([
          [{'v':'1', 'f':'Mike<div style="color:red; font-style:italic">President</div>'},'', 'The President'],
          [{'v':'2', 'f':'Jim<div style="color:red; font-style:italic">Vice President 1</div>'},'1', 'VP'],
          [{'v':'3', 'f':'Jim<div style="color:red; font-style:italic">Vice President 2</div>'},'1', 'VP'],
          [{'v':'4', 'f':'Jim<div style="color:red; font-style:italic">Vice 3 </div>'},'2', 'VP'],
          [{'v':'5', 'f':'Jim<div style="color:red; font-style:italic">Vice 4</div>'},'2', 'VP']
        ]);<?php */?>
		
		<?php 
		if($treetype=='LEGAL_ENTITY'){ 
		foreach($treeview_array as $key=>$out){ ?>
		data.addRows([[{'v':'<?php echo $out['id']; ?>', 'f':'<?php echo $out['name']; ?><div style="color:red; font-style:italic" onclick="tree_view_operation_unit(<?php echo $out['id']; ?>)"><?php echo $out['company_type']; ?></div>'},
		'<?php echo $out['parent_id']; ?>','---']]);
		<?php }} ?>
		
		<?php 
		if($treetype=='OPERATION_ENTITY'){ 
		foreach($treeview_array as $key=>$out){ ?>
		data.addRows([[{'v':'<?php echo $out['id']; ?>', 'f':'<?php echo $out['name']; ?><div style="color:red; font-style:italic" >op</div>'},
		'<?php echo $out['parent_id']; ?>','The op']]);
		<?php }} ?>
		
		<?php 
		if($treetype=='LOCATION_TREE'){ 
		foreach($treeview_array as $key=>$out){ ?>
		data.addRows([[{'v':'<?php echo $out['id']; ?>', 'f':'<?php echo $out['name']; ?><div style="color:red; font-style:italic" onclick="tree_view_operation_unit(<?php echo $out['id']; ?>)"><?php echo $out['location_type']; ?></div>'},
		'<?php echo $out['parent_id']; ?>','---']]);
		<?php }} ?>
	
        // Create the chart.
        var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
        // Draw the chart, setting the allowHtml option to true for the tooltips.
        chart.draw(data, {'allowHtml':true});
      }
   </script>
    <style type="text/css">
<!--
.style1 {
	font-size: 14px;
	font-weight: bold;
	color: #003399;
}
-->
    </style>
	
	
	
  <div class="panel-body" align="center" style="background-color:#99CC00">
	
	<h3><span class="label label-default">
		<?php echo $legal_unit_name.'<br>';
		if( $treetype=='OPERATION_ENTITY')
		{
			if($op_unit_name<>'' ){echo 'Hierarchy of Op Unit :'.$op_unit_name;}
			else { echo 'No op unit available'; }
		}
		 ?>
	</span></h3>
  </div>

<div class="panel panel-primary"  >
 <div class="panel-footer">
	 <div class="form-row"> 
	   <div id="chart_div"></div>
	</div>
	<?php if($treetype=='OPERATION_ENTITY'){ ?>
	 <div class="form-row" align="center"> 
	  <a href="<?php echo ADMIN_BASE_URL?>Project_controller/treeview"><button type="button" class="button">Back</button></a>
	</div>
	<?php } ?>
</div>
</div>






  	
 
