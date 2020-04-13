

<div ng-app="Accounts" ng-controller="currency_daily_rate" ng-click="hideMenu($event)" >


	<div class="container codestructure1">
	<div class="row" >   
		<div class="panel panel-danger"   >	
		
		<div class="panel-heading">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-info-sign">Currency daily rate</span>{{savemsg}}</h4>
		</div>	
		
		
		<div class="row modal-body" style="padding: 7px; background-color:#999999 ">		
			<div class="col-lg-2 col-md-2 col-sm-2">From</div>
			<div class="col-lg-2 col-md-2 col-sm-2">To</div>
			<div class="col-lg-2 col-md-2 col-sm-2">Date</div>
			<div class="col-lg-2 col-md-2 col-sm-2">From - To (Rate)</div>
			<div class="col-lg-2 col-md-2 col-sm-2">To - From(Rate)</div>	
			<div class="col-lg-2 col-md-2 col-sm-2">Add</div>			
		</div>
		
		<div class="row modal-body" style="padding: 3px; " ng-repeat="layer in  [0,FormInputArray[0].code_structure1.length-1]  | toRange">		
						
			<div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 3px;">			
			 <select name="select" class="form-control" ng-model="FormInputArray[0].code_structure1[layer].from_currency_id" >
                <option ng-repeat="option in currency_master_list" value="{{option.id}}">{{option.code}}</option>
             </select>		
			 </div>
			 
			<div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 3px;">
			 <select name="select" class="form-control" ng-model="FormInputArray[0].code_structure1[layer].to_currency_id" >
                <option ng-repeat="option in currency_master_list" value="{{option.id}}">{{option.code}}</option>
             </select>	
			 </div>
			 
			<div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 3px;">
			<input  type="text" id="name" style="text-align:left"	class="form-control" 
			 ng-model="FormInputArray[0].code_structure1[layer].trandate"/>
			</div>
			
			<div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 3px;">
			<input  type="text" id="name" style="text-align:left"	class="form-control" 
			 ng-model="FormInputArray[0].code_structure1[layer].from_to_rate"/>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 3px;">
			<input  type="text" id="name" style="text-align:left"	class="form-control" 
			 ng-model="FormInputArray[0].code_structure1[layer].to_from_rate"/>
			</div>
			
			
			<div class="col-lg-2 col-md-2 col-sm-2"><button class="btn btn-success" ng-click="add_code_structure(1)" >Add</button></div>			
		</div>
		
		
	</div></div></div>
			
		

		<div class="panel-footer" style="margin-bottom:-14px;" align="center">
		<button type="button" class="btn btn-danger" id="Save" name="Save" 	ng-click="savedata()">Final Submit</button>		
		</div>
</div>
