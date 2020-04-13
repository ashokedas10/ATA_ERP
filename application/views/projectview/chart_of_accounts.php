<script src="https://bossanova.uk/jsuites/v2/jsuites.js"></script>
<link rel="stylesheet" href="https://bossanova.uk/jsuites/v2/jsuites.css" type="text/css" />


<style type="text/css">
<!--
.style2 {
	color: #990000;
	font-weight: bold;
	font-size:18px;
}
-->
</style>
<div ng-app="Accounts" ng-controller="CHART_OF_ACCOUNTS" 
ng-click="hideMenu($event)" ng-init="initarray('TRIP_ENTRY')" id="myBody">


<div class="panel panel-primary" >
	
    <div class="panel-body" align="center" style="background-color:#CCCCCC">  	
	  <span class="blink_me style2">{{savemsg}}</span></div>
</div>
			
		

	<table  class="table table-striped" >
			
			<tr>
			  <th colspan="7">Chart Of Accounts</th>
			</tr>
				
				  
				<tr>
					<td width="338"  align="left">Select Code Name </td>
					<td width="442"  align="left" > 
					<select ng-model="FormInputArray[0].id_header" class="form-control" ng-click="view_list(FormInputArray[0].id_header)">
					<option  value="0">Select</option>
					<option ng-repeat="option in chart_of_accounts_list" value="{{option.id}}">{{option.value}}</option>
					</select></td> 					
				  
			  </tr>
				
  </table>
				
	<table  class="table " >  
				 
				  <tr>
					<th>Code</th>    
					<th>Description</th>     
					<th>Status</th> 
					<th>Link data</th> 
					<th>Start Date</th> 
					<th>End Date</th> 
					<th>Add</th> 
                  </tr>
				  
				
                  <tr ng-repeat="layer in  [0,FormInputArray[0].list_of_values.length-1] | toRange">
				  
                    
					<td><input  type="text" style="text-align:left"	class="form-control" 
					 ng-model="FormInputArray[0].list_of_values[layer].code"/>
					 </td> 		
					
					<td><input  type="text" style="text-align:left"	class="form-control" 
					 ng-model="FormInputArray[0].list_of_values[layer].FieldVal"/>
					 </td>
					 
					 <td>
						<select name="select" 
							class="form-control" ng-model="FormInputArray[0].list_of_values[layer].active_inactive" >
						  <option  value="0">Select</option>
						  <option ng-repeat="option in active_inactive_list" value="{{option.FieldID}}">{{option.FieldVal}}</option>
						</select>
					</td>
					 
					 <td>&nbsp;</td>
					 <td><input  type="text" 	class="form-control "  data-mask='yyyy-mm-dd'  placeholder="yyyy-mm-dd"
					 ng-model="FormInputArray[0].list_of_values[layer].startdate"/></td> 
					 		
					 <td><input  type="text" 	class="form-control" data-mask='yyyy-mm-dd' placeholder="yyyy-mm-dd"
					 ng-model="FormInputArray[0].list_of_values[layer].enddate"/></td> 		
					   
					<td  align="left"><button class="btn-block btn-info" ng-click="add_entry('lov_list')" >Add</button></td>					
					<!--<td  align="left">
					<button class="btn-block btn-danger" 
					ng-click="delete_product(FormInputArray[0].details_income_passengers[layer].id_detail)" 
					onClick="return confirm('Do you want to Delete This Record ?');" >Delete</button>					</td>-->
                  </tr>
				  
				  <tr><td   align="center" colspan="7">
				<button type="button" class="btn btn-danger" id="Save" name="Save" 	ng-click="savedata()">Final Submit</button>
				<!--<button type="button" class="btn btn-primary" name="Save" ng-click="print_bill(id_header)">Print</button>-->
				
				</tr>
				</table>	
				
				
				