<link href="https://fonts.googleapis.com/css?family=PT+Serif&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH_ADMIN;?>theme_files/style_main.css" media="screen" />

  <?php /*?>
	  <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <?php */?>

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
<div class="container" style="width:100%"  ng-controller="experimental_form" ng-init="view_list(0)" id="myBody" >
			
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
			
		<div class="form-row col-md-9 nopadding" > 	
			<div class="panel panel-default form-group form-group-sm">		
			
				
				<div class="panel panel-success">		
					<div class="panel-heading">
						<div class="row">
							<div class="col-sm-12" align="center">
								<h4 class="panel-title" id="contactLabel">
								<span class="glyphicon glyphicon-info-sign"></span>{{server_msg}}</h4>
							</div>
						</div>
					</div>
				</div>			
											
				<div  ng-repeat="header_index in [0,FormInputArray[0]['header'].length] | toRange"   id="maindiv" >	
				
					<!--<p><div class="clearfix">&nbsp;</div></p>-->
													
					<!--FORM SECTION -->
					
					<div  ng-if="FormInputArray[0]['header'][header_index]['section_type']== 'FORM'">
									
						
						<div   ng-if="header_index ==0">	
							<div class="box box-success">
								<div class="with-border box-header"><strong>Header</strong></div>
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
																		 autocomplete="off"  style="font-size:14px; f"/>
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
						</div>
						
						<div   ng-if="header_index ==2" class="col-sm-6">
							<div class="box box-success">
							<div class="with-border box-header"><strong>Summary</strong></div>
									
								<div  ng-repeat="field_index in [0,FormInputArray[0]['header'][header_index]['fields'].length] | toRange"   >
									
							<div ng-repeat="steps in FormInputArray[0]['header'][header_index]['fields'][field_index]" ng-init="Index2 = $index">	
									<div  ng-repeat="(key,value) in steps" >
											<div class="col-sm-{{steps['DIVClass']}}"  ng-if="$index==8 && steps['InputType'] != 'hidden'">
												<table  class="table table-condensed nopadding">
													<tr >
														<td width="90px;"><label class="control-label">{{steps['LabelName']}}</label></td>
														<td ng-if="steps['InputType'] == 'text'">	
																				
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
														
													</tr>
												</table>
											</div>
											
									</div>
							</div>
							
						</div>
									
							</div>
						</div>
						
						<div   ng-if="header_index ==3" class="col-sm-6">
							<div class="box box-success">
							<div class="with-border box-header"><strong>Status</strong></div>
									
								<div  ng-repeat="field_index in [0,FormInputArray[0]['header'][header_index]['fields'].length] | toRange"   >
									
							<div ng-repeat="steps in FormInputArray[0]['header'][header_index]['fields'][field_index]" ng-init="Index2 = $index">	
									<div  ng-repeat="(key,value) in steps" >
											<div class="col-sm-{{steps['DIVClass']}}"  ng-if="$index==8 && steps['InputType'] != 'hidden'">
												<table  class="table table-condensed nopadding">
													<tr >
														<td width="90px;"><label class="control-label">{{steps['LabelName']}}</label></td>
														<td ng-if="steps['InputType'] == 'text'">	
																				
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
														
													</tr>
												</table>
											</div>
											
									</div>
							</div>
							
						</div>
									
							</div>
						</div>
						
					</div>
					
					<!--FORM SECTION -->
					
					
					<!--SECTION main GRID TYPE -->	
					
					<!--GRID ENTRY -->		
							
						<div  ng-if="FormInputArray[0]['header'][header_index]['section_type']== 'GRID_ENTRY'">	
								<!--GRID BODY SECTION-->								
								
									<div class="clearfix"></div>
									<div class="box box-success">
										
									<div class="with-border box-header" ng-if="header_index ==1"><strong>List of Items</strong></div>
									<!--<div class="with-border box-header" ng-if="header_index ==2"><strong>Tax Details</strong></div>-->
									
										<!--<div class="table-responsive"  ng-if="header_index !=4">-->
										<div class="table-responsive"  >
										<table  class="table table-condensed nopadding"  style="overflow:auto">
													
													<tr  class="bg-primary">
													<td ng-repeat="steps in FormInputArray[0]['header'][header_index]['fields'][0]" ng-init="$index==0"
														   ng-if="steps.InputType != 'hidden'">	
														{{steps.LabelName}}
													  </td>
													  <td>Save</td>
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
														 
														 <div ng-if="steps['InputType']== 'datefield'">	
														<input id="{{steps.input_id_index}}" autofocus type="text" name=""   placeholder="{{steps.LabelName}}"  
															ng-keydown="checkKeyDown($event,header_index,field_index,Index2,$index,steps.input_id_index)" 
															ng-keyup="checkKeyUp($event)" ng-model="steps.Inputvalue"
															ng-change="search(steps.InputName,header_index,field_index,Index2,$index)" 
															ng-focus="search(steps.InputName,header_index,field_index,Index2,$index)" 
															class="form-control input_field_height"	
															ng-keypress="mainOperation($event,header_index,field_index,Index2,$index,steps.input_id_index)"
															autocomplete="off"  style="width:{{50*steps.DIVClass}}px;"  />
														 </div>
														
														</td>
														
									<td ng-if="FormInputArray[0]['header'][header_index]['fields'].length!= $index">
									<button type="button" class="btn btn-success" id="Save" name="Save" 
									ng-click="savedata()">Save</button>
									</td>
													</tr>
										</table>
										
										</div>	
										
										
										
									</div>	
										
									
					 </div>		
					
					 
				
					<!--GRID ENTRY -->		
					
						
							
					<!--SECTION  GRID END -->	
					
				</div>
				
				<table  class="table"  style="100%" cellpadding="0" cellspacing="0" border="0"> 		 
					<tr class="bg-success">
						<td align="center">
						<!--<button type="submit" class="btn btn-success">Outside Services</button> 
						 <button type="submit" class="btn btn-success">Catalog</button> 
						  <button type="submit" class="btn btn-success">Distributins</button>  -->
						  <button type="button" class="btn btn-success" id="Save" name="Save" ng-click="view_list(0)">New Entry</button>
						  <button type="button" class="btn btn-success" id="Save" name="Save" ng-click="savedata()" 
						  onclick="return confirm('Do you want to Save ?');">Save</button>
						  
						  <a data-toggle="modal" data-target="#search_modal"><button type="submit" class="btn btn-success" ng-click="main_grid(1)">
						  Search Invoice</button></a>
						  
						  <a data-toggle="modal" data-target="#search_match_po"><button type="submit" class="btn btn-success" ng-click="match_po(1)">
						  Match</button></a>
						  
						 <!--  <a data-toggle="modal" data-target="#tax_model"><button type="submit" class="btn btn-success" 
						   ng-click="tax_details(FormInputArray[0]['header'][0]['id'])">
						  Tax Details</button></a>
						  -->
						  
						  
						 <button type="button" class="btn btn-danger" ng-click="test()">test</button>
						 
						 <!-- <button type="button" class="btn btn-danger" id="Save" name="Save" ng-click="form_data_save()">Submit</button>-->
						 <!-- <a data-toggle="modal" data-target="#shortModal"><button type="submit" class="btn btn-success">Approve</button></a>-->
						  <!--<button type="button" class="btn btn-danger" ng-click="view_list(29)">View previous</button>-->
						  
						  </td>
						</tr>					
					</table>
					
			</div>
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
		
		
		
		<!--SEARCH  FOR UNMATCH PO-->		
		<div class="modal fade" id="search_match_po" tabindex="-1" role="dialog" aria-hidden="true" 
		style=" width:100%;" >
		<div class="modal-dialog" role="document" style="width:800px;max-width:100%;" >
		<div class="modal-content">
				<div class="modal-header bg-primary">
				<h5 class="modal-title" id="exampleModalLongTitle-1">Match PO</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
						 <div class="box box-success">
								<div class="box-header with-border">	
								
								<table class="table table-bordered table-hover table-condensed" >	
									<tr>
									<td  align="left" style="width:{{50*field.DIVClass}}px;" class="bg-warning" ng-repeat="(key,value) in match_po_object[0]" 
									 >{{key}}</td>	
									<td  align="left" class="bg-warning">View</td>					
									</tr>
									
									<tbody>
									
									<tr ng-repeat="values in match_po_object">
									<td  align="left" style="width:{{50*field.DIVClass}}px;"  ng-repeat="(key,value) in values" >{{value}}</td>	
									<td  align="left" class="bg-warning">
									<button class="btn btn-warning input_field_height" 
									ng-click="po_data(values.id)" >View</button>
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
		<!--SEARCH  FOR UNMATCH PO-->	
		
					
	</div>
	<!-- : {{ FormInputArray[0]['header'][0]['fields'][0]['id']['Inputvalue_id']}}		
		{{ FormInputArray[0]['header'][0]['fields'][0]['id']}}
	Return Object: {{FormInputArray[0]['header'][0]['id']}}			-->				
	
	<!--main_grid : {{return_object}}-->
				
	<!--Return Object: {{FormInputArray[0]}}-->
	
	<!--result {{temp}}-->
	<!--Return Object: {{FormInputArray[0]['header'][4]}}-->
		
	
	</div>
</div>

