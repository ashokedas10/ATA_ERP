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

</style>



<div  ng-app="Accounts">	
<div class="container" style="width:100%"  ng-controller="experimental_form" ng-init="view_list(0)" id="myBody" onkeypress = "shortcut()">
			
	<div  class="form-row" ng-init="tabindex==0">
	
		<div class="panel panel-danger"   >		
				<div class="panel-heading">
					<div class="row">
						<div class="col-sm-12">
							<h4 class="panel-title" id="contactLabel">
							<span class="glyphicon glyphicon-info-sign"></span>{{formname}}-Batch Processing </h4>
						</div>
					</div>
				</div>
			</div>	
			
		<div class="form-row col-md-9 nopadding" > 	
		
		
			<!--Header Setion-->
		
			<div class="panel panel-default form-group form-group-sm" >											
				<div  ng-repeat="header_index in [0,FormInputArray[0]['header'].length] | toRange"   id="maindiv" >					
					<p><div class="clearfix">&nbsp;</div></p>
					<!--FORM SECTION -->					
					<div  ng-if="FormInputArray[0]['header'][header_index]['section_type']== 'FORM'">
					
					<div class="panel panel-danger"   >		
							<div class="panel-heading">
								<div class="row">
									<div class="col-sm-12">
										<h4 class="panel-title" id="contactLabel">
										<span class="glyphicon glyphicon-info-sign"></span>Lines</h4>
									</div>
								</div>
							</div>
						</div>	
						
						<div  ng-init="update_input_id_index(0)">&nbsp;</div>
						<div  ng-repeat="field_index in [0,FormInputArray[0]['header'][header_index]['fields'].length] | toRange"   >
								
						<div ng-repeat="steps in FormInputArray[0]['header'][header_index]['fields'][field_index]" ng-init="Index2 = $index">	
								<div  ng-repeat="(key,value) in steps" >
										<div class="col-sm-{{steps['DIVClass']}}"  ng-if="$index==8 && steps['InputType'] != 'hidden'">
											<table  class="table table-condensed nopadding">
												<tr >
													<td width="110px;"><label class="control-label">{{steps['LabelName']}}</label></td>
													<td ng-if="steps['InputType'] == 'text'">	
													<!--{{steps.input_id_index}}	-->								
														<input id="{{steps.input_id_index}}"  
														ng-keydown="checkKeyDown($event,header_index,field_index,Index2,$index,steps.input_id_index)" 
														ng-keyup="checkKeyUp($event)"
														ng-model="steps.Inputvalue"
														ng-change="search(steps.InputName,header_index,field_index,Index2,$index)" 
														ng-focus="search(steps.InputName,header_index,field_index,Index2,$index)" 
														class="form-control input_field_height" 
														ng-keypress="mainOperation($event,header_index,field_index,Index2,$index,steps.input_id_index)"
														 autocomplete="off" />
													</td>
													<td ng-if="steps['InputType'] == 'LABEL'">	
																					
														<input id="{{steps.input_id_index}}"  
														ng-keydown="checkKeyDown($event,header_index,field_index,Index2,$index,steps.input_id_index)" 
														ng-keyup="checkKeyUp($event)"
														ng-model="steps.Inputvalue"
														ng-change="search(steps.InputName,header_index,field_index,Index2,$index)" 
														ng-focus="search(steps.InputName,header_index,field_index,Index2,$index)" 
														class="form-control input_field_height" 
														ng-keypress="mainOperation($event,header_index,field_index,Index2,$index,steps.input_id_index)"
														  readonly="" />
													</td>
													<td ng-if="steps['InputType'] == 'datefield'">	
																									
														<input id="{{steps.input_id_index}}"  
														ng-keydown="checkKeyDown($event,header_index,field_index,Index2,$index,steps.input_id_index)" 
														ng-keyup="checkKeyUp($event)"
														ng-model="steps.Inputvalue"
														ng-change="search(steps.InputName,header_index,field_index,Index2,$index)" 
														ng-focus="search(steps.InputName,header_index,field_index,Index2,$index)" 
														class="form-control input_field_height" 
														ng-keypress="mainOperation($event,header_index,field_index,Index2,$index,steps.input_id_index)"
														 autocomplete="off"  />
													</td>
												</tr>
											</table>
											
											
										</div>
								</div>
						</div>
						
					</div>
					
					</div>					
					<!--FORM SECTION -->					
				</div>					
			</div>
			
			<!--grid Setion-->
			
			<!--GRID ENTRY -->	
			<div class="panel panel-default form-group form-group-sm" id="tabs">
			
				<ul>
							<!--<li ng-repeat="indx in [0,FormInputArray[0]['header'].length] | toRange">
							<a href="#tabs-{{indx}}">Nunc tincidunt</a>
							</li>-->
							
							<li><a href="#tabs-1">Final Product</a></li>
							<li><a href="#tabs-2">Ingredients</a></li>
							<li><a href="#tabs-3">Bi-Product</a></li>
				</ul >	
								
					<div  ng-repeat="header_index in [0,FormInputArray[0]['header'].length] | toRange"    >	
						<div  ng-if="FormInputArray[0]['header'][header_index]['section_type']== 'GRID_ENTRY'" >	
							
								<div class="table-responsive" id="tabs-{{header_index}}">
								
								<table  class="table table-condensed nopadding"  style="overflow:auto">
													
													<tr  class="bg-primary">
													<td ng-repeat="steps in FormInputArray[0]['header'][header_index]['fields'][0]" ng-init="$index==0"
														   ng-if="steps.InputType != 'hidden'">	
														{{steps.LabelName}}
														</td>
													</tr>
										
													<tr ng-repeat="field_index in [0,FormInputArray[0]['header'][header_index]['fields'].length] | toRange">
														<td ng-repeat="steps in FormInputArray[0]['header'][header_index]['fields'][field_index]" ng-init="Index2 = $index"
														  ng-if="steps['InputType']!= 'hidden'">	
														 
														 <div ng-if="steps['InputType'] == 'text'">													 
															 <input id="{{steps.input_id_index}}" autofocus type="text" name=""   placeholder="{{steps.LabelName}}"  
															ng-keydown="checkKeyDown($event,header_index,field_index,Index2,$index,steps.input_id_index)" 
															ng-keyup="checkKeyUp($event)" ng-model="steps.Inputvalue"
															ng-change="search(steps.InputName,header_index,field_index,Index2,$index)" 
															ng-focus="search(steps.InputName,header_index,field_index,Index2,$index)" 
															class="form-control input_field_height"	
															ng-keypress="mainOperation($event,header_index,field_index,Index2,$index,steps.input_id_index)"
															  style="width:{{50*steps.DIVClass}}px;"  autocomplete="off"/>
														 </div> 
														 <div ng-if="steps['InputType'] == 'LABEL'">													
															<input id="{{steps.input_id_index}}" autofocus type="text" name=""   placeholder="{{steps.LabelName}}"  
															ng-keydown="checkKeyDown($event,header_index,field_index,Index2,$index,steps.input_id_index)" 
															ng-keyup="checkKeyUp($event)" ng-model="steps.Inputvalue"
															ng-change="search(steps.InputName,header_index,field_index,Index2,$index)" 
															ng-focus="search(steps.InputName,header_index,field_index,Index2,$index)" 
															class="form-control input_field_height"	
															ng-keypress="mainOperation($event,header_index,field_index,Index2,$index,steps.input_id_index)"
															autocomplete="off"  style="width:{{50*steps.DIVClass}}px;"   readonly=""/>
														 </div>
														
														</td>
													</tr>
										</table>
								
								</div>		
										
						 </div>	
					</div>						
			</div>
			<!--GRID ENTRY -->	
			
			
			<table  class="table"  style="100%" cellpadding="0" cellspacing="0" border="0"> 		 
					<tr class="bg-success">
						<td align="center">
						  <button type="button" class="btn btn-success" id="Save" name="Save" ng-click="view_list(0)">New Entry</button>
						  <button type="button" class="btn btn-success" id="Save" name="Save" ng-click="savedata()">Save</button>
						  <a data-toggle="modal" data-target="#search_modal"><button type="submit" class="btn btn-success" ng-click="main_grid(1)">Search</button></a>
						  <button type="button" class="btn btn-danger" ng-click="test()">test</button>						  
						  </td>
						</tr>					
					</table>
		</div>
		<div class="form-row col-md-3 nopadding" id="table_search" > 
				<table class="table table-bordered table-hover table-condensed"  >
					<tr class="bg-primary"><th>Search</th></tr>
					<!--<tr ng-repeat="suggestion in suggestions track by $index" 
					ng-class="{active : selectedIndex === $index}"	ng-click="AssignValueAndHide($index)">	-->
					
					<tr ng-repeat="suggestion in suggestions track by $index" ng-class="{'activeTR': selectedIndex == $index}"				
							ng-click="AssignValueAndHide($index)" style="overflow:scroll">			
					<td>{{suggestion.name}}</td>					
					</tr>
				</table>
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
						
	<!--Return Object: {{FormInputArray[0]['header']}}	-->						
	
	<!--main_grid : {{return_object}}-->
				
	<!--Return Object: {{FormInputArray[0]}}-->
	
	<!--result {{temp}}-->
	<!--Return Object: {{FormInputArray[0]['header'][1]}}-->
	
	
	</div>
</div>




<?php /*?><div id="tabs">
	  <ul>
		<li><a href="#tabs-1">Nunc tincidunt</a></li>
		<li><a href="#tabs-2">Proin dolor</a></li>
		<li><a href="#tabs-3">Aenean lacinia</a></li>
	  </ul>
		  <div id="tabs-1">
			<p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
		  </div>
		  <div id="tabs-2">
			<p>Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>
		  </div>
		  <div id="tabs-3">
			<p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
			<p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
		  </div>
</div><?php */?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<?php /*?><script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script><?php */?>
  <script>
  $( function() {
    $( "#tabs" ).tabs();
  } );
  </script>

