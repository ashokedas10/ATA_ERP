<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://rawgit.com/RobinHerbots/Inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>

<style type="text/css">
<!--
.style2 {
	color: #990000;
	font-weight: bold;
	font-size:18px;
}
-->
</style>
<div ng-app="Accounts" ng-controller="ROLLE_MAPPING" ng-click="hideMenu($event)" ng-init="initarray('TRIP_ENTRY')" id="myBody">

<div class="container">
	<div class="row" >   
		<div class="panel panel-danger">	
		
		<div class="panel-heading">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-info-sign">Role Mapping</span>{{savemsg}}</h4>
		</div>	
			
		

	<table  class="table table-striped" >				  
		<tr>
			<td width="338"  align="left">Select Role Name </td>
			<td width="442"  align="left" > 
			<select ng-model="FormInputArray[0].id_header" class="form-control" ng-click="view_list(FormInputArray[0].id_header)">
			<option  value="0">Select</option>
			<option ng-repeat="option in master_lovs" value="{{option.id}}">{{option.roll_name}}</option>
			</select></td> 					
		  
	  </tr>				
  </table>
				
	<table  class="table " > 
				 
				  <tr>
					<th>Menu</th>    
					<th>Status</th>      
					<th>Add</th> 
                  </tr>
				  
				
                  <tr ng-repeat="layer in  [0,FormInputArray[0].list_of_values.length-1] | toRange">
				  
                    
					<td><select name="select" 
						class="form-control" ng-model="FormInputArray[0].list_of_values[layer].FieldVal" >
                      <option  value="0">Select</option>
                      <option ng-repeat="option in menu_list" value="{{option.id}}">{{option.name}}</option>
                    </select></td> 
										
					
					<td>
						<select name="select" 
							class="form-control" ng-model="FormInputArray[0].list_of_values[layer].active_inactive" >
						  <option  value="0">Select</option>
						  <option ng-repeat="option in active_inactive_list" value="{{option.FieldID}}">{{option.FieldVal}}</option>
						</select>					</td>
					   
					<td  align="left"><button class="btn-block btn-info" ng-click="add_entry('lov_list')" >Add</button></td>					
					<!--<td  align="left">
					<button class="btn-block btn-danger" 
					ng-click="delete_product(FormInputArray[0].details_income_passengers[layer].id_detail)" 
					onClick="return confirm('Do you want to Delete This Record ?');" >Delete</button>					</td>-->
                  </tr>
				  
				  <tr><td  align="center" colspan="5" class="panel-footer" style="margin-bottom:-14px;">
				<button type="button" class="btn btn-danger" id="Save" name="Save" 	ng-click="savedata()">Final Submit</button>
				</td>				
				</tr>
				</table>		


</div>	</div>	</div>	</div>	