
<style type="text/css">
<!--
.style2 {	
	font-weight: bold;
	font-size:18px;
}
-->
</style>

<style>
input {
  font-family: monospace;
}
label {
  display: block;
}
div {
  margin: 0 0 1rem 0;
}

.shell {
  position: relative;
  line-height: 1; }
  .shell span {
    position: absolute;
    left: 3px;
    top: 1px;
    color: #ccc;
    pointer-events: none;
    z-index: -1; }
    .shell span i {
      font-style: normal;
      /* any of these 3 will work */
      color: transparent;
      opacity: 0;
      visibility: hidden; }

input.masked,
.shell span {
  font-size: 16px;
  font-family: monospace;
  padding-right: 10px;
  background-color: transparent;
  text-transform: uppercase; }

</style>



<div ng-app="Accounts" ng-controller="dynamic_angularjs_form" >		  		  	
		 
			<div class="panel panel-primary" >
			<div class="panel-body" >
			
			
					<div  class="form-row" >	 
							<div class="form-row col-md-9" > 		
								
								<!-- HEADER counts-->
								<!--OLD-->	
										<div  class="form-row bg-primary" align="center" >
										{{server_msg}}
										</div>	
									<div class="form-row"  ng-repeat="header_index in [0,FormInputArray[0].header.length] | toRange"   >
										
														
										
											<div ng-if="FormInputArray[0].header[header_index].Type == 'FORM'">						
											<table class="table table-bordered table-striped" >						
												<tr ng-repeat="field in FormInputArray[0].header[header_index].body">						
														<td  align="left" >{{field.LabelName}}</td> 
														<td  align="left" >
														<input id="2" autofocus type="text" name="tbl_party_id_name"   placeholder="{{field.LabelName}}"  
														ng-keydown="checkKeyDown($event)" ng-keyup="checkKeyUp($event)" ng-model="field.Inputvalue" 
														ng-change="search(field.InputName,header_index,$index)" 
														ng-focus="search(field.InputName,header_index,$index)" 
														class="form-control" ng-keypress="mainOperation($event,2)"/>
														</td>
												</tr>				
											</table>
											</div>
									
									
											
											<div ng-if="FormInputArray[0].header[header_index].Type == 'GRID'">		
												<table class="table table-bordered table-striped" >	
													<tr   style="padding-top:0px;">
													<td  align="left" >&nbsp;</td>
													<td  align="left" ng-repeat="field in FormInputArray[0].header[header_index].body">{{field.LabelName}}</td>	
													<td  align="left" >&nbsp;</td>					
													</tr>
													
													<tr  style="padding-top:0px;" >
														<td  align="left" >&nbsp;</td>
														<td  align="left" ng-repeat="field in FormInputArray[0].header[header_index].body">	
																			
															<input id="1" autofocus type="text" name="tbl_party_id_name"   placeholder="{{field.LabelName}}"  
															ng-keydown="checkKeyDown($event)" ng-keyup="checkKeyUp($event)"
															ng-model="field.Inputvalue"
															ng-change="search(field.InputName,header_index,$index)" 
															ng-focus="search(field.InputName,header_index,$index)" 
															class="form-control" ng-keypress="mainOperation($event,2)"/>							
														</td>
														<td  align="left" >&nbsp;</td>
													</tr>
													
													<tr   style="padding-top:0px;"  ng-repeat="fields in FormInputArray[0].header[header_index].grid_list">								
														<td  align="left" ng-repeat="field in fields"><div ng-if="$index != 0">{{field}}</div></td>								
														<td  align="left" >
														<button class="btn btn-warning" 
														ng-click="view_list(form_id,master_table_id,header_index,$index,'VIEW_LIST')" >View</button>
														
														</td>															
													</tr>
																									
												</table>
											</div>
											
									
									</div>
								
							
							
							
							<!--NEW-->	
								
										
							
							</div> 
							
							<div class="form-row col-md-3" > 
								
								<table class="table" style="background-color:#CC9999">
									<tr><th>Search</th></tr>
									<tr ng-repeat="suggestion in suggestions track by $index" 
									ng-class="{active : selectedIndex === $index}"
									ng-click="AssignValueAndHide($index)">				
									<td >{{suggestion.name}}</td>					
									</tr>
								</table>
							
							</div>
					</div>
						
			
			<div  class="form-row" >
			<div class="form-row col-md-12" align="center" > 
			<button type="button" class="btn btn-danger" id="Save" name="Save" ng-click="savedata()">Submit</button>
			</div>
			</div>	
						
			
				
			</div>
			</div>
			<br>
			Return Object: {{FormInputArray[0].header[1].grid_list}}
			<!--<br /><br />
			FOOTER: {{FormInputArray}}-->
			
			<!--{{searchItems}}-->
</div>
