<div ng-app="Accounts" ng-controller="CODE_STRUCTURE" ng-click="hideMenu($event)" ng-init="initarray('TRIP_ENTRY')" id="myBody" >

	<div class="container">
	<div class="row" >   
		<div class="panel panel-danger"   >	
		
		<div class="panel-heading">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-info-sign">Code Structure Step1</span>{{savemsg}}</h4>
		</div>	
		
		
		<div class="row modal-body" style="padding: 3px; ">		
			<div class="col-lg-3 col-md-3 col-sm-3">Name</div>
			<div class="col-lg-3 col-md-3 col-sm-3">Data Type</div>
			<div class="col-lg-3 col-md-3 col-sm-3">Type</div>
			<div class="col-lg-3 col-md-3 col-sm-3">Add</div>			
		</div>
		
		
		<div class="row modal-body" style="padding: 3px; " ng-repeat="layer in  [0,FormInputArray[0].list_of_values.length-1] | toRange">		
			<div class="col-lg-3 col-md-3 col-sm-3" style="padding-bottom: 3px;">
			<input  type="text" id="name" style="text-align:right"	class="form-control" 
			 ng-model="FormInputArray[0].list_of_values[layer].FieldVal" 
			 ng-keydown="open_code_structure2($event,FormInputArray[0].list_of_values[layer].FieldVal)" 
			 ng-keyup="open_code_structure2($event,FormInputArray[0].list_of_values[layer].FieldVal)" 
			 ng-focus="open_code_structure2($event,FormInputArray[0].list_of_values[layer].FieldVal)"/>
			 </div>
			 
			<div class="col-lg-3 col-md-3 col-sm-3" style="padding-bottom: 3px;">
			
			<select name="select" 
						class="form-control" ng-model="FormInputArray[0].list_of_values[layer].code_type_id" >
                         <option ng-repeat="option in code_type_id_list" value="{{option.id}}">{{option.FieldVal}}</option>
             </select>
			 </div>
			 
			<div class="col-lg-3 col-md-3 col-sm-3" style="padding-bottom: 3px;">
			<select name="select" 
				class="form-control" ng-model="FormInputArray[0].list_of_values[layer].code_main_id" >
			  <option  value="0">NA</option>
			  <option ng-repeat="option in main_id_list" value="{{option.id}}">{{option.FieldVal}}</option>
			</select>			
			</div>
			
			<div class="col-lg-3 col-md-3 col-sm-3"><button class="btn btn-success" ng-click="add_entry('lov_list')" >Add</button></div>			
		</div>
		
		
		<div class="panel-footer" style="margin-bottom:-14px;" align="center">
		<button type="button" class="btn btn-danger" id="Save" name="Save" 	ng-click="savedata()">Final Submit</button>		
		</div>
		
		
	</div></div></div>
			
	<!--=====================codestructure2   -->	
		
	
	<div class="container codestructure2"  id="myForm"  >
	<div class="row" >   
		<div class="panel panel-danger"   >	
		
			<div class="panel-heading">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-info-sign">Code Structure Step2 {{ codestructure1_id}}
					</span>{{savemsg}}</h4>
			</div>	
			
			<div class="row modal-body" style="padding: 3px; " ng-repeat="layer in  [0,FormInputArray[0].list_of_values.length-1] | toRange">		
			<div class="col-lg-3 col-md-3 col-sm-3" style="padding-bottom: 3px;"><input  type="text" id="name" style="text-align:right"	class="form-control" 
					 ng-model="FormInputArray[0].list_of_values[layer].FieldVal" ng-click="add_edit_segment_sum('lov_list')"/>
			 </div>
			 
			<div class="col-lg-3 col-md-3 col-sm-3" style="padding-bottom: 3px;">
			
			<select name="select" 
						class="form-control" ng-model="FormInputArray[0].list_of_values[layer].code_type_id" >
                         <option ng-repeat="option in code_type_id_list" value="{{option.id}}">{{option.FieldVal}}</option>
             </select>
			 </div>
			 
			<div class="col-lg-3 col-md-3 col-sm-3" style="padding-bottom: 3px;">
			<select name="select" 
				class="form-control" ng-model="FormInputArray[0].list_of_values[layer].code_main_id" >
			  <option  value="0">NA</option>
			  <option ng-repeat="option in main_id_list" value="{{option.id}}">{{option.FieldVal}}</option>
			</select>			
			</div>
			
			<div class="col-lg-3 col-md-3 col-sm-3"><button class="btn btn-success" ng-click="add_entry('lov_list')" >Add</button></div>			
		</div>
		
		<div class="panel-footer" style="margin-bottom:-14px;" align="center">
		<button type="button" class="btn btn-danger" id="Save" name="Save" 	ng-click="savedata()">Final Submit</button>	
		
		<button type="button" class="btn btn-dark" id="Save" name="Save"  onclick="closeForm()"	>Close</button>		
		</div>
				
		</div></div></div>		

</div>

<style>

.codestructure2
{
  position:fixed;
  left:200px;
  top:100px;
  width:600px;
  
 display:none;
}

</style>

<script type = "text/javascript">
/*Final Submit(F8) | New Mixer(F9) | Print Invoice(F10) | Print POS(F11) | New Entry (F1) */
	 function shortcut(codeVal) 
	 {	
		if(codeVal==120) //New Mixer(F9)
		{ document.getElementById("myForm").style.display = "block";
		}
	 }

		 
</script>  	
	
	
<script>
	function openForm() {
	
	  document.getElementById("myForm").style.display = "block";
	}
	
	function closeForm() {
	  document.getElementById("myForm").style.display = "none";
	}
</script>	



<script>

var m = document.getElementById('myForm');
m.addEventListener('mousedown', mouseDown, false);
window.addEventListener('mouseup', mouseUp, false);

function mouseUp() {
    window.removeEventListener('mousemove', move, true);
}

function mouseDown(e) {
    window.addEventListener('mousemove', move, true);
}

function move(e) {
    m.style.top = e.clientY + 'px';
    m.style.left = e.clientX + 'px';
};
</script>







</div>
	
	
	
	
