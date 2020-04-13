
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



<div ng-app="Accounts" ng-controller="calendar" 
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
				<h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-info-sign">Accounting Calendar</span>{{savemsg}}</h4>
		</div>	
		
			<form id="Transaction_form" name="Transaction_form" >
				
			<table  class="table"  style="100%" cellpadding="0" cellspacing="0" border="0"> 
					
			<tr>
					<td  align="right" >Type :</td>
					<td  align="left" colspan="2" >
					 <select ng-model="FormInputArray[0].id_header" class="form-control" ng-click="view_list(FormInputArray[0].id_header)">
					<option  value="0">Select</option>
					<option ng-repeat="option in master_lovs" value="{{option.id}}">{{option.period_type}}</option>
					</select></td>
										 
			  </tr>				 
				 
				  <tr class="bg-primary" >
                    <th >Prefix </th>
                    <th >Type</th>    
					<th >Year</th>    
					<th >Quarter</th>  
					<th >Num</th>
					<th >From</th>
					<th >To</th>
					<th >Name</th>																			    
					<th>Add</th> 
                  </tr>
				  
				
                  <tr ng-repeat="layer in  [0,FormInputArray[0].list_of_values.length-1] | toRange"  style="padding-top:0px;">
                   
					<td align="right">
										
					<input  type="text" style="text-align:left;"	class="form-control input_field_hight" 
					 ng-model="FormInputArray[0].list_of_values[layer].prefix"/>
					 					
					 </td> 
					 
					<td align="right"  ><input  type="text" style="text-align:left"	class="form-control input_field_hight" 
					 ng-model="FormInputArray[0].list_of_values[layer].period_type"/></td>  
					
					<td align="right"  ><input  type="text" style="text-align:left"	class="form-control input_field_hight" 
					 ng-model="FormInputArray[0].list_of_values[layer].period_per_year"/></td> 
					 
					 <td align="right"  ><input  type="text" style="text-align:left"	class="form-control input_field_hight" 
					 ng-model="FormInputArray[0].list_of_values[layer].quater"/></td> 
					 
					 <td align="right"  ><input  type="text" style="text-align:left"	class="form-control input_field_hight" 
					 ng-model="FormInputArray[0].list_of_values[layer].month_num"/></td> 
					 
					 <td align="right"  >
					 <input  type="text" id="{{layer}}" style="text-align:left"	class="form-control input_field_hight" 
					 ng-model="FormInputArray[0].list_of_values[layer].fromdate" />
										 
					 </td> 
					 
					 <td align="right"  ><input  type="text" style="text-align:left"	class="form-control input_field_hight" 
					 ng-model="FormInputArray[0].list_of_values[layer].todate"/></td> 
					 
					 <td align="right"  ><input  type="text" style="text-align:left"	class="form-control input_field_hight" 
					 ng-model="FormInputArray[0].list_of_values[layer].name"/></td> 					
					   
					<td  align="left"  ><button class="btn btn-warning" ng-click="add_entry('lov_list')" >Add</button></td>					
					<!--<td  align="left">
					<button class="btn-block btn-danger" 
					ng-click="delete_product(FormInputArray[0].details_income_passengers[layer].id_detail)" 
					onClick="return confirm('Do you want to Delete This Record ?');" >Delete</button>					</td>-->
                  </tr>
				  
				  <tr>
				  <td   align="center" colspan="9">
					<button type="button" class="btn btn-danger" id="Save" name="Save" 	ng-click="savedata()">Final Submit</button>				
				</td>
				
				<!--<button type="button" class="btn btn-primary" name="Save" ng-click="print_bill(id_header)">Print</button>-->
				
				</tr>
				</table>		
				
</form>
			
	</div></div></div>

</div>


<script>
  
  $("#1").datepicker({
   changeMonth: true,
   changeYear: true
 });
  
 $("#1").change(function() {
  var  trandate = $('#1').val();
  trandate=
  trandate.substring(6, 10)+'-'+
  trandate.substring(0, 2)+'-'+
  trandate.substring(3, 5);
  $("#1").val(trandate);
 });
 
</script>

