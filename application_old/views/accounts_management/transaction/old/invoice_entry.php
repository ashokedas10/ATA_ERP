<link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH_ADMIN;?>theme_files/style_main.css" media="screen" />
<style>

div.ex1 {
  background-color: lightblue;
  width: 100%;
  height: 200px;
  overflow: scroll;
}

.input_field_height
{
height:20px;
font-family:Arial, Helvetica, sans-serif bold;
font-size:12px;
color:#000000;
font-weight:300;
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




<div  ng-app="Accounts">
	
<div class="container" style="width:100%"  ng-controller="invoice_entry" ng-init="view_list(0)" id="myBody" onkeypress = "shortcut()">
			
	<div  class="form-row"  >
	
		<div class="panel panel-danger"   >		
				<div class="panel-heading">
					<div class="row">
						<div class="col-sm-12">
							<h4 class="panel-title" id="contactLabel">
							<span class="glyphicon glyphicon-info-sign"></span>Generate Invoice</h4>
						</div>
					</div>
				</div>
			</div>	
						
		
		<div class="form-row col-md-9 nopadding" > 	
			<div class="panel panel-default">		
											
				
				<div  ng-repeat="header_index in [0,FormInputArray[0]['header'].length] | toRange"   >	
				
					<!--SECTION main -->
					<div  ng-repeat="field_index in [0,FormInputArray[0]['header'][header_index]['fields'].length] | toRange"   >
								
						<div ng-repeat="steps in FormInputArray[0]['header'][header_index]['fields'][field_index]" ng-init="Index2 = $index">	
								<div  ng-repeat="(key,value) in steps" >
										<div class="col-sm-3"  ng-if="$index==8 && steps['InputType'] != 'hidden'">
										
											<input id="{{'item_name'+key}}" autofocus type="text" name="{{key}}"   placeholder="{{key}}"  
											ng-keydown="checkKeyDown($event)" ng-keyup="checkKeyUp($event)"
											ng-model="steps[key]"
											ng-change="search(steps.InputName,header_index,field_index,Index2,$index)" 
											ng-focus="search(steps.InputName,header_index,field_index,Index2,$index)" 
											class="form-control input_field_height" ng-keypress="mainOperation($event,2)" autocomplete="off" />
										</div>
								</div>
						</div>
						
					</div>
					
				</div>
				
				
				
			
			</div>
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
				
	
	Return Object: {{FormInputArray[0]}}
	
	</div>
</div>

