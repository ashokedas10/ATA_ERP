<link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH_ADMIN;?>theme_files/style_main.css" media="screen" />
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
</style>


<script type = "text/javascript">
/*Final Submit(F8) | New Mixer(F9) | Print Invoice(F10) | Print POS(F11) | New Entry (F1) */
 function shortcut() 
 {		 
		 
		 document.addEventListener("keydown", function(event) {
		 
		//alert(event.keyCode);
		 	//alert(event.keyCode);
		 	/*if(event.keyCode==119)//Final Submit(F8)
			{angular.element(document.getElementById('myBody')).scope().submit_print(); }*/
			
			if(event.keyCode==120) //New Mixer(F9)
			{$('#search_modal').modal({show: 'false'});document.getElementById(101).focus();}
			
			/*if(event.keyCode==121) // Print Invoice(F10)
			{angular.element(document.getElementById('myBody')).scope().print_invoice('INVOICE');}
			if(event.keyCode==122) //Print POS(F11)
			{angular.element(document.getElementById('myBody')).scope().print_invoice('INVOICE_POS');}
			if(event.keyCode==118) //New Entry (F1)
			{angular.element(document.getElementById('myBody')).scope().get_set_value('','','NEWENTRY');}*/
		  
		});
			
 }
</script>  

<div  ng-app="Accounts">
	
<div class="container" style="width:100%"  ng-controller="dynamic_angularjs_form" ng-init="view_list(41,0,0,-1,'NA')" id="myBody" onkeypress = "shortcut()">
			
	<div  class="form-row"  >
	
		<div class="panel panel-danger"   >		
				<div class="panel-heading">
					<div class="row">
						<div class="col-sm-12">
							<h4 class="panel-title" id="contactLabel">
							<span class="glyphicon glyphicon-info-sign"></span>{{FormInputArray[0].header[0].FormRptName}} </h4>
						</div>
					</div>
				</div>
			</div>	
		
						
		<!--<div class="panel">
			<div class="panel-body bg-danger" align="center" ><h5><strong>Create Requition 1</strong></h5></div>
		</div>	-->
		 
		<div class="form-row col-md-9 nopadding" > 	
			
			<div class="panel panel-default">		
								
					<!--HEADER 1 FILDSET-->
					<div class="bg-primary clearfix" ng-init="update_header_section(0,1,'section1')"></div>
					
					<div class="row" >						
						
							<div  ng-repeat="body_index in [0,FormInputArray[0].header[0].body.length] | toRange"   >
								
								<div ng-if="FormInputArray[0].header[0].body[body_index]['SectionType']=='HEADER1'"> 
								
									<div ng-if="FormInputArray[0].header[0].row_num= FormInputArray[0].header[0].body[body_index].Section"> 
									<div class="form-row" ng-init="update_header_section(0,body_index,'section1')">	
										<div class="col-md-{{FormInputArray[0].header[0].body[body_index].DIVClass}}" >
																			
											<table  class="table table-condensed nopadding">
												<tr >
													<td width="100px;"><label>{{FormInputArray[0].header[0].body[body_index].LabelName}}</label></td>
													<td >
																										
													<input id="{{body_index}}" autofocus type="FormInputArray[0].header[0].body[body_index].InputType" 
													name="tbl_party_id_name"   
													placeholder="{{FormInputArray[0].header[0].body[body_index].LabelName}}"  
													ng-keydown="checkKeyDown($event)" ng-keyup="checkKeyUp($event)" 
													ng-model="FormInputArray[0].header[0].body[body_index].Inputvalue" 
													ng-change="search(FormInputArray[0].header[0].body[body_index].InputName,0,body_index)" 
													ng-focus="search(FormInputArray[0].header[0].body[body_index].InputName,0,body_index)" 
													class="form-control input_field_height" ng-keypress="mainOperation($event,0)" autocomplete="off"/>	
													<!--{{$index}}-->
													</td>
												</tr>
											</table>
											
										</div>														  
								   </div>
								</div>  
								
								</div>
								
							</div>
					</div>		
					
					<!--HEADER 1 FILDSET END -->
					
							
					<!--BODY FILDSET-->
					<div class="bg-primary clearfix">&nbsp;</div>				
					
					<table class="table table-bordered table-hover table-condensed" >	
						<tr  >
						<td  align="left" class="bg-warning">&nbsp;</td>
						
						<td  align="left" style="width:{{50*field.DIVClass}}px;"
						 class="bg-warning" ng-repeat="field in FormInputArray[0].header[1].body" 
						 ng-if="field.SectionType=='HEADER1'">{{field.LabelName}}</td>	
												
						
						<td  align="left" class="bg-warning">View</td>					
						</tr>
						
						<tbody>
						<tr  style="padding-top:0px;" >
							<td  align="left" >&nbsp;</td>
							<td   align="left" ng-repeat="field in FormInputArray[0].header[1].body" ng-if="field.SectionType=='HEADER1'">												
								<input id="1" autofocus type="text" name="tbl_party_id_name"   placeholder="{{field.LabelName}}"  
								ng-keydown="checkKeyDown($event)" ng-keyup="checkKeyUp($event)"
								ng-model="field.Inputvalue"
								ng-change="search(field.InputName,1,$index)" 
								ng-focus="search(field.InputName,1,$index)" 
								class="form-control input_field_height" ng-keypress="mainOperation($event,2)" autocomplete="off" 
								style="width:{{50*field.DIVClass}}px;" onchange = "shortcut($index)"/>																							
							</td>
							<td  align="left" >		
							 <a data-toggle="modal" data-target="#MODAL2"><button type="submit" class="btn btn-success">Submit</button></a>
							 					 
							<!--<button type="button" class="btn btn-danger input_field_height" id="Save" name="Save" ng-click="form_data_save()">Submit</button>-->
							
							</td>
						</tr>
						
						<tr  ng-repeat="fields in FormInputArray[0].header[1].grid_list">								
							<td  align="left" ng-repeat="field in fields" ><div ng-if="$index != 0">{{field}}</div></td>	
														
							<td  align="left" >
							<button class="btn btn-warning input_field_height" 
							ng-click="view_list(form_id,master_table_id,1,$index,'VIEW_LIST')" >View</button>
							
							</td>															
						</tr>
						
						</tbody>
																												
					</table>
										
					<!--BODY FILDSET END-->
									
					
					<!--FOOTER 1 FILDSET-->
					
					<div class="bg-primary clearfix" ng-init="update_header_section(0,1,'section1')">&nbsp;</div>
					<div class="row" >						
						
							<div  ng-repeat="body_index in [0,FormInputArray[0].header[0].body.length] | toRange"   >
								
								<div ng-if="FormInputArray[0].header[0].body[body_index]['SectionType']=='FOOTER1'"> 
								
									<div ng-if="FormInputArray[0].header[0].row_num= FormInputArray[0].header[0].body[body_index].Section"> 
									<div class="form-row nopadding" ng-init="update_header_section(0,body_index,'section1')">	
										<div class="col-md-{{FormInputArray[0].header[0].body[body_index].DIVClass}}" >
																				
											<table  class="table table-condensed nopadding">
												<tr >
													<td width="100px;"><label>{{FormInputArray[0].header[0].body[body_index].InputName}}</label></td>
													<td >
													<input id="0" autofocus type="text" name="tbl_party_id_name"   
													placeholder="{{FormInputArray[0].header[0].body[body_index].LabelName}}"  
													ng-keydown="checkKeyDown($event)" ng-keyup="checkKeyUp($event)" 
													ng-model="FormInputArray[0].header[0].body[body_index].Inputvalue" 
													ng-change="search(FormInputArray[0].header[0].body[body_index].InputName,0,body_index)" 
													ng-focus="search(FormInputArray[0].header[0].body[body_index].InputName,0,body_index)" 
													class="form-control input_field_height" ng-keypress="mainOperation($event,2)" autocomplete="off"/>	
													</td>
												</tr>
											</table>
											
											
										</div>														  
								   </div>
								</div>  
								
								</div>
								
							</div>
					</div>		
					
					<!--FOOTER 1 FILDSET END -->
					
					
					<!--SUBMIT SECTION -->
					<table  class="table"  style="100%" cellpadding="0" cellspacing="0" border="0"> 		 
					<tr class="bg-success">
						<td align="center">
						<!--<button type="submit" class="btn btn-success">Outside Services</button> 
						 <button type="submit" class="btn btn-success">Catalog</button> 
						  <button type="submit" class="btn btn-success">Distributins</button>  -->
						  <button type="button" class="btn btn-success" id="Save" name="Save" ng-click="new_entry()">New Entry</button>
						  <a data-toggle="modal" data-target="#search_modal"><button type="submit" class="btn btn-success">Search</button></a>
						 <!-- <button type="button" class="btn btn-danger" id="Save" name="Save" ng-click="form_data_save()">Submit</button>-->
						  <a data-toggle="modal" data-target="#shortModal"><button type="submit" class="btn btn-success">Approve</button></a>
						  
						  <button type="button" class="btn btn-danger" onclick="shortcut123(41,19)">onclick</button>
						  </td>
						</tr>					
					</table>
					<!--SUBMIT SECTION END -->
			
			</div>	
			
			
		<!--MODAL 1 POPUP for new entry-->		
		<div class="modal fade" id="shortModal" tabindex="-1" role="dialog" aria-hidden="true" style="position:absolute; top:100px; left:50px;" >
		<div class="modal-dialog" role="document" style="width:800px;max-width:100%;" >
		<div class="modal-content">
				<div class="modal-header bg-primary">
				<h5 class="modal-title" id="exampleModalLongTitle-1">Approval</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
						 <div class="box box-success">
								<div class="box-header with-border">				    
									 
								 <!--FOOTER 2 FILDSET-->
								<div  class="form-row" >
									
										<div  ng-init="update_header_section(0,1,'section1')"></div>
										
										<div class="row" >						
											
												<div  ng-repeat="body_index in [0,FormInputArray[0].header[0].body.length] | toRange"   >
													
													<div ng-if="FormInputArray[0].header[0].body[body_index]['SectionType']=='FOOTER2'"> 
													
														<div ng-if="FormInputArray[0].header[0].row_num= FormInputArray[0].header[0].body[body_index].Section"> 
														<div class="form-row" ng-init="update_header_section(0,body_index,'section1')">	
															<div class="col-md-{{FormInputArray[0].header[0].body[body_index].DIVClass}}" >
																									
																<table  class="table table-condensed nopadding">
																	<tr >
																		<td width="100px;"><label>{{FormInputArray[0].header[0].body[body_index].LabelName}}</label>
																		</td>
																		
																		<td >
																																				
																		<input id="{{body_index}}" autofocus 
																		type="text" name="tbl_party_id_name"   
																		placeholder="{{FormInputArray[0].header[0].body[body_index].LabelName}}"  
																		ng-keydown="checkKeyDown($event)" ng-keyup="checkKeyUp($event)" 
																		ng-model="FormInputArray[0].header[0].body[body_index].Inputvalue" 
																		ng-change="search(FormInputArray[0].header[0].body[body_index].InputName,0,body_index)" 
																		ng-focus="search(FormInputArray[0].header[0].body[body_index].InputName,0,body_index)" 
																		class="form-control input_field_height" ng-keypress="mainOperation($event,0)" autocomplete="off"/>	
																		<!--{{$index}}-->
																		</td>
																	</tr>
																</table>
																
															</div>														  
													   </div>
													</div>  
													
													</div>
													
												</div>
										</div>		
										
										<table  class="table"  style="100%" cellpadding="0" cellspacing="0" border="0"> 		 
										<tr class="bg-success">
											<td align="center">
											  <button type="button" class="btn btn-danger" id="Save" name="Save" ng-click="form_data_save()">Submit</button>
											  </td>
											</tr>					
										</table>			
								</div>									
								<!--FOOTER 1 FILDSET END -->	
								
												
								</div>
						 </div>	
				</div>		
		
		</div>
		</div>
		</div>
		<!--MODAL 1 POPUP END-->	
		
		<!--MODAL 2 POPUP for ACCOUNTS-->		
		<div class="modal fade" id="MODAL2" tabindex="-1" role="dialog" aria-hidden="true" 
		style="position:absolute; top:100px; left:50px;" >
		<div class="modal-dialog" role="document" style="width:800px;max-width:100%;" >
		<div class="modal-content">
				<div class="modal-header bg-primary">
				<h5 class="modal-title" id="exampleModalLongTitle-1">Account Setup</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
						 <div class="box box-success">
								<div class="box-header with-border">				    
									 
								 <!--FOOTER 2 FILDSET-->
								<table class="table table-bordered table-hover table-condensed" >
									
								<tr  ng-repeat="field in FormInputArray[0].header[1].body" ng-if="field.SectionType=='HEADER2'">
										
								<td  align="left" style="width:{{50*field.DIVClass}}px;" class="bg-warning" >{{field.LabelName}}</td>	
								<td   align="left" >												
										<input id="1" autofocus type="text" name="tbl_party_id_name"   placeholder="{{field.LabelName}}"  
										ng-keydown="checkKeyDown($event)" ng-keyup="checkKeyUp($event)"
										ng-model="field.Inputvalue"
										ng-change="search(field.InputName,1,$index)" 
										ng-focus="search(field.InputName,1,$index)" 
										class="form-control input_field_height" ng-keypress="mainOperation($event,2)" autocomplete="off" 
										style="width:{{50*field.DIVClass}}px;" onchange = "shortcut($index)"/>																							
								</td>
								</tr>
																														
								</table>					
								<!--FOOTER 1 FILDSET END -->									
								
								
								<!--<table  class="table"  style="100%" cellpadding="0" cellspacing="0" border="0"> 		 
								<tr class="bg-success">
									<td align="center">
									  <button type="button" class="btn btn-danger" id="Save" name="Save" ng-click="form_data_save()">Submit</button>
									  </td>
									</tr>					
								</table>-->
								
												
								</div>
						 </div>	
				</div>		
		
		</div>
		</div>
		</div>
		<!--MODAL 2 POPUP END-->	
		
		
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
									 
								 <!--FOOTER 2 FILDSET-->
								<table class="table table-bordered table-hover table-condensed" >
									
								<tr>
									<td class="bg-warning">Type</td>
									<td class="bg-warning">Number</td>
									<td class="bg-warning">Date</td>
									<td class="bg-warning">Approval Status</td>
									<td class="bg-warning">View</td>
								</tr>
								
								<!--<td  align="left" style="width:{{50*field.DIVClass}}px;"
						 class="bg-warning" ng-repeat="field in FormInputArray[0].header[1].body" 
						 ng-if="field.SectionType=='HEADER1'">{{field.LabelName}}</td>	-->
																			
								<tr ng-repeat="field in FormInputArray[0].header[0].grid_list">	
								<td   align="left" >{{field.req_type}}</td>
								<td   align="left" >{{field.req_number}}</td>
								<td   align="left" >{{field.req_accounting_date}}</td>
								<td   align="left" >{{field.req_submit_approval}}</td>
								
								<td   align="left" >																 								
								<button type="button" class="btn btn-danger" id="Save" name="Save" 
								ng-click="view_list(form_id,field.id,0,-1,'NA')">Submit</button>
								</td>
								
								</tr>
																														
								</table>					
								<!--FOOTER 1 FILDSET END -->									
												
								</div>
						 </div>	
				</div>		
		
		</div>
		</div>
		</div>
		<!--SEARCH POPUP END-->		
				
					
			
		</div>
			
		<div class="form-row col-md-3 nopadding" > 
				<table class="table table-bordered table-hover table-condensed" >
					<tr class="bg-primary"><th>Search</th></tr>
					<!--<tr ng-repeat="suggestion in suggestions track by $index" 
					ng-class="{active : selectedIndex === $index}"	ng-click="AssignValueAndHide($index)">	-->
					
					<tr ng-repeat="suggestion in suggestions track by $index" ng-class="{'activeTR': selectedIndex == $index}"				
							ng-click="AssignValueAndHide($index)" style="overflow:scroll">			
					<td>{{suggestion.name}}</td>					
					</tr>
				</table>
		</div>
					
	</div>
				
	
	<!--Return Object: {{FormInputArray[0]}}-->
	</div>
</div>



