<link href="https://fonts.googleapis.com/css?family=PT+Serif&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH_ADMIN;?>theme_files/style_main.css" media="screen" />

	<?php /*?><link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script><?php */?>

<style>

div.ex1 {
  background-color: lightblue;
  width: 100%;
  height: 200px;
  overflow: scroll;
}

.activeTR {  
	background-color: yellow;
    color:black;	
    font-weight:bold;
}

.nopadding {
   padding: 0 !important;
   margin: 0 !important;
}	


/* The heart of the matter */
.testimonial-group > .row {
  overflow-x: auto;
  white-space: nowrap;
}
.testimonial-group > .row > .col-xs-4 {
  display: inline-block;
  float: none;
}

.input_field_height
{
height:27px;
font-family:Arial, Helvetica, sans-serif bold;
font-size:15px;
color:#000000;
font-weight:600;
}
.control-label
{
font-family:Arial, Helvetica, sans-serif bold;
font-size:12px;
color:#000000;
font-weight:300;

}


</style>



<div  ng-app="Accounts">	
<div class="container" style="width:100%"  ng-controller="experimental_form" ng-init="view_list(0)" id="myBody" onkeypress = "shortcut()">
			
	<div  class="form-row">
	
		<div class="panel panel-danger"   >		
				<div class="panel-heading">
					<div class="row">
						<div class="col-sm-12">
							<h4 class="panel-title" id="contactLabel">
							<span class="glyphicon glyphicon-info-sign"></span>{{formname}}</h4>
						</div>
					</div>
				</div>
			</div>	
			
		<div class="form-row col-md-12 nopadding" > 	
			<div class="panel panel-default form-group form-group-sm">		
											
				<div  ng-repeat="header_index in [0,FormInputArray[0]['header'].length] | toRange"   id="maindiv" >	
				
					<p><div class="clearfix"></div></p>
													
					<!--FORM SECTION -->
					
					<div  ng-if="FormInputArray[0]['header'][header_index]['section_type']== 'FORM'">
					
					<div class="panel panel-success"   >		
							<div class="panel-heading">
								<div class="row">
									<div class="col-sm-12">
										<h4 class="panel-title" id="contactLabel">
										<span class="glyphicon glyphicon-info-sign"></span>
										<strong>
										{{FormInputArray[0]['header'][header_index]['DataFields_name']}}
										</strong>
										</h4>
									</div>
								</div>
							</div>
						</div>	
						
						<div  ng-init="update_input_id_index(0)">&nbsp;</div>
			<div  ng-repeat="field_index in [0,FormInputArray[0]['header'][header_index]['fields'].length] | toRange"   >
								
						<div ng-repeat="steps in FormInputArray[0]['header'][header_index]['fields'][field_index]" 
						ng-init="Index2 = $index">	
					<div  ng-repeat="(key,value) in steps" >
							<div class="col-sm-{{steps['DIVClass']}}"  ng-if="$index==8 && steps['InputType'] != 'hidden'">
							<table  class="table table-condensed nopadding">
								<tr >
									<td width="110px;"><label class="control-label"><strong>{{steps['LabelName']}}</strong></label></td>
									<td >{{steps.Inputvalue}}</td>
									
								</tr>
							</table>	
										</div>
								</div>
						</div>
						
					</div>
					
					</div>
					
					<!--FORM SECTION -->
					
					
					<!--SECTION main GRID TYPE -->	
					
					<!--GRID ENTRY -->				
					<div  ng-if="FormInputArray[0]['header'][header_index]['section_type']== 'GRID_ENTRY'">	
					
								<!--<div class="panel panel-danger"   >		
									<div class="panel-heading">
										<div class="row">
											<div class="col-sm-12">
												<h4 class="panel-title" id="contactLabel">
												<span class="glyphicon glyphicon-info-sign"></span>Lines</h4>
											</div>
										</div>
									</div>
								</div>				-->			
									
					
								<!--GRID BODY SECTION-->								
								
		<div class="clearfix"></div>
		<!--<div >	-->
		<!--<div  class="container testimonial-group" ng-repeat="(key,value) in steps" >-->
		<div class="table-responsive">
			<table  class="table table-condensed nopadding"  style="overflow:auto">
				
				<tr  class="bg-primary">
				<td ng-repeat="steps in FormInputArray[0]['header'][header_index]['fields'][0]" ng-init="$index==0"
					   ng-if="steps.InputType != 'hidden'">	
					{{steps.LabelName}}
					</td>
				</tr>
			
				<tr ng-repeat="field_index in [0,FormInputArray[0]['header'][header_index]['fields'].length] | toRange">
					<td ng-repeat="steps in FormInputArray[0]['header'][header_index]['fields'][field_index]" 
					ng-init="Index2 = $index"  ng-if="steps['InputType']!= 'hidden'">	
						{{steps.Inputvalue}}
					</td>
				</tr>
			</table>
					</div>		
			</div>		
					<!--GRID ENTRY -->		
					
						
							
					<!--SECTION  GRID END -->	
					
				</div>
				
				<table  class="table"  style="100%" cellpadding="0" cellspacing="0" border="0"> 		 
					<tr class="bg-success">
						<td align="center">
						
					<a data-toggle="modal" data-target="#search_modal">
					<button type="submit" class="btn btn-success" ng-click="main_grid(1)">Search</button>
					</a>
					<button type="button" class="btn btn-danger" ng-click="test()">test</button>
												  
						  </td>
						</tr>					
					</table>
					
			</div>
		</div>
	
		
		<!--SEARCH POPUP for ACCOUNTS-->		
		<div class="modal fade" id="search_modal" tabindex="-1" role="dialog" aria-hidden="true" 
		style=" width:100%;" >
		<div class="modal-dialog" role="document" style="width:800px;max-width:100%;" >
		<div class="modal-content">
				<div class="modal-header bg-primary">
				<h5 class="modal-title" id="exampleModalLongTitle-1">View List</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
						 <div class="box box-success">
								<div class="box-header with-border">	
								
								<table class="table table-bordered table-hover table-condensed" >	
									<tr>
									<td  align="left" style="width:{{50*field.DIVClass}}px;" class="bg-warning" ng-repeat="(key,value) in return_object[0]" 
									 ng-if="key!='id'">{{key}}</td>	
									<td  align="left" class="bg-warning">View</td>					
									</tr>
									
									<tbody>
									
									<tr ng-repeat="values in return_object">
									<td  align="left" style="width:{{50*field.DIVClass}}px;"  ng-repeat="(key,value) in values" 
									 ng-if="key!='id'">{{value}}</td>	
									<td  align="left" class="bg-warning">
									<button class="btn btn-warning input_field_height" 
									ng-click="view_list(values.id)" >View</button>
									</td>					
									</tr>						
								
									</tbody>
																															
								</table>
								
						
												
								</div>
						 </div>	
				</div>		
		
		</div>
		</div>
		</div>
		<!--SEARCH POPUP END-->		
		
					
	</div>
						
	<!--Return Object: {{FormInputArray[0]['header']}}				-->			
	
	<!--main_grid : {{return_object}}-->
				
	<!--Return Object: {{FormInputArray[0]}}-->
	
	<!--result {{temp}}-->
	<!--Return Object: {{FormInputArray[0]['header'][1]}}-->
	
	
	
	
	
	
	
	</div>
</div>

