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
.input_field_hight
{
height:27px;
font-family:Arial, Helvetica, sans-serif bold;
font-size:12px;
color:#000000;
font-weight:300;
}

input:focus {
  background-color: yellow;
}

-->
</style>

<div ng-app="Accounts" ng-controller="LOV" 
ng-click="hideMenu($event)" ng-init="initarray('TRIP_ENTRY')" id="myBody">


<!--<div class="panel panel-primary" >
	
    <div class="panel-body" align="center" style="background-color:#CCCCCC">  	
	  <span class="blink_me style2">{{savemsg}}</span></div>
	</div>-->
	
	
	<div class="container" style="width:95%">
	<div class="row" style="overflow:auto" >   
		<div class="panel panel-danger srstable"   >	
		
		<div class="panel-heading">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-info-sign">List of values</span>{{savemsg}}</h4>
		</div>	
		
			<form id="Transaction_form" name="Transaction_form" >

			
				
			<table  class="table"  style="100%" cellpadding="0" cellspacing="0" border="0"> 
					
			<tr>
					<td  align="right" >Type :</td>
					<td  align="left" >
					 <select ng-model="FormInputArray[0].id_header" class="form-control" ng-click="view_list(FormInputArray[0].id_header)">
					<option  value="0">Select</option>
					<option ng-repeat="option in master_lovs" value="{{option.id}}">{{option.FieldVal}}</option>
					</select></td>
					 
			  </tr>				 
				 
				  <tr class="bg-primary" >
                    <th >Value </th>
                    <th >Description</th>    
					<th >Display Order</th>    
					<th >Status</th>      
					<th>Add</th> 
                  </tr>
				  
				
                  <tr ng-repeat="layer in  [0,FormInputArray[0].list_of_values.length-1] | toRange"  style="padding-top:0px;">
				  
                    
					<!--<td><select name="select" 
						class="form-control" ng-model="FormInputArray[0].details_income_passengers[layer].account_id" >
                      <option  value="0">Select</option>
                      <option ng-repeat="option in LIST_OF_INCOME_LEDGERS_PASSENGER" value="{{option.id}}">{{option.acc_name}}</option>
                    </select></td> -->
					
					<!--{{FormInputArray[0].details_income_passengers[layer].account_name}}</td>-->
					
                   
					<td align="right"  ><input  type="text" style="text-align:left;"	class="form-control input_field_hight" 
					 ng-model="FormInputArray[0].list_of_values[layer].FieldVal"/></td> 
					 
					<td align="right"  ><input  type="text" style="text-align:left"	class="form-control input_field_hight" 
					 ng-model="FormInputArray[0].list_of_values[layer].comment"/></td>  
					
					<td align="right"  ><input  type="text" style="text-align:left"	class="form-control input_field_hight" 
					 ng-model="FormInputArray[0].list_of_values[layer].display_order"/></td> 
					
					<td  >
						<select name="select" 
							class="form-control input_field_hight" ng-model="FormInputArray[0].list_of_values[layer].active_inactive" >
						  <option  value="0">Select</option>
						  <option ng-repeat="option in active_inactive_list" value="{{option.FieldID}}">{{option.FieldVal}}</option>
						</select>
					</td>
					   
					<td  align="left"  ><button class="btn btn-warning" ng-click="add_entry('lov_list')" >Add</button></td>					
					<!--<td  align="left">
					<button class="btn-block btn-danger" 
					ng-click="delete_product(FormInputArray[0].details_income_passengers[layer].id_detail)" 
					onClick="return confirm('Do you want to Delete This Record ?');" >Delete</button>					</td>-->
                  </tr>
				  
				  <tr>
				  <td   align="center" colspan="5"   >
				  
					<button type="button" class="btn btn-danger" id="Save" name="Save" 	ng-click="savedata()">Final Submit</button>				
				</td>
				
				<!--<button type="button" class="btn btn-primary" name="Save" ng-click="print_bill(id_header)">Print</button>-->
				
				</tr>
				</table>		
				
</form>
			
	</div></div></div>

</div>

