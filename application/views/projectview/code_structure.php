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

<div ng-app="Accounts" ng-controller="CODE_STRUCTURE" ng-click="hideMenu($event)" >


	<div class="container codestructure1" >
	<div class="row" >   
		<div class="panel panel-danger"   >	
		
		<div class="panel-heading">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-info-sign">Key Flexfield Segment</span>{{savemsg}}</h4>
		</div>	
		
		
		<div class="row bg-primary modal-body " style="padding: 3px; ">		
			<div class="col-lg-3 col-md-3 col-sm-3">Code</div>
			<div class="col-lg-3 col-md-3 col-sm-3">Title</div>
			<div class="col-lg-3 col-md-3 col-sm-3">Description</div>
			<div class="col-lg-3 col-md-3 col-sm-3">Add</div>			
		</div>
		
		<div class="row modal-body" style="padding: 3px; " ng-repeat="layer in  [0,FormInputArray[0].code_structure1.length-1]  | toRange">		
						
			<div class="col-lg-3 col-md-3 col-sm-3" style="padding-bottom: 3px;">
			
			<input  type="text" id="name" style="text-align:left"	class="form-control  input_field_hight"  
			 ng-model="FormInputArray[0].code_structure1[layer].code" 
			 ng-keydown="open_code_structure2($event,$index,'codestructure2')" 
			 ng-keyup="open_code_structure2($event,$index,'codestructure2')" 
			 ng-focus="open_code_structure2($event,$index,'codestructure2')" />
			 </div>
			 
			<div class="col-lg-3 col-md-3 col-sm-3" style="padding-bottom: 3px;">
			
			<input  type="text" id="name" style="text-align:left"	class="form-control  input_field_hight"  
			 ng-model="FormInputArray[0].code_structure1[layer].value"/>
			 
			 </div>
			 
			<div class="col-lg-3 col-md-3 col-sm-3" style="padding-bottom: 3px;">
			<input  type="text" id="name" style="text-align:left"	class="form-control  input_field_hight"  
			 ng-model="FormInputArray[0].code_structure1[layer].description"/>
			</div>
			
			<div class="col-lg-3 col-md-3 col-sm-3"><button class="btn btn-success" ng-click="add_code_structure(1)" >Add</button></div>			
		</div>
		
		
		
		
		
	</div></div></div>
			
	<!--=====================codestructure2   -->		
	
	<div class="container codestructure2"  id="codestructure2">
	<div class="row" >   
		<div class="panel panel-danger">	
		
			<div class="panel-heading">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-info-sign">
					</span>Segments Summary(Accounting Flexfield)-{{FormInputArray[0].code_structure1[code1_index].value}}    {{savemsg}}</h4>
			</div>	
			
		<div class="row bg-primary" >		
			<div class="col-lg-2 col-md-2 col-sm-2">Code</div>
			<div class="col-lg-3 col-md-3 col-sm-3">Name</div>
			<div class="col-lg-3 col-md-3 col-sm-3">Data Type</div>
			<div class="col-lg-3 col-md-3 col-sm-3">Field Qualifier</div>
			<div class="col-lg-1 col-md-1 col-sm-1">Add</div>			
		</div>
			
			<div class="row modal-body" style="padding: 3px; " ng-repeat="layer in  
			[0,FormInputArray[0].code_structure1[code1_index].code_structure2.length-1] | toRange">		
			
			<div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 3px;">
			<input  type="text" id="name" style="text-align:left"	class="form-control  input_field_hight"  
			 ng-model="FormInputArray[0].code_structure1[code1_index].code_structure2[layer].code" 
			 ng-keydown="open_code_structure3($event,code1_index,$index,'codestructure3')" 
			 ng-keyup="open_code_structure3($event,code1_index,$index,'codestructure3')" 
			 ng-focus="open_code_structure3($event,code1_index,$index,'codestructure3')" />
			 </div>
			 
			 <div class="col-lg-3 col-md-3 col-sm-3" style="padding-bottom: 3px;">
			<input  type="text" id="name" style="text-align:left"	class="form-control  input_field_hight"  
			 ng-model="FormInputArray[0].code_structure1[code1_index].code_structure2[layer].value" />
			 </div>
			 
			<div class="col-lg-3 col-md-3 col-sm-3" style="padding-bottom: 3px;">
			 <select name="select" class="form-control  input_field_hight"  ng-model="FormInputArray[0].code_structure1[code1_index].code_structure2[layer].code_type_id" >
                <option ng-repeat="option in code_type_id_list" value="{{option.id}}">{{option.FieldVal}}</option>
             </select>
			 </div>
			 
			 <div class="col-lg-3 col-md-3 col-sm-3" style="padding-bottom: 3px;">
			 <select name="select" class="form-control  input_field_hight"  ng-model="FormInputArray[0].code_structure1[code1_index].code_structure2[layer].code_main_id" >
                <option ng-repeat="option in qualifier_list1" value="{{option.id}}">{{option.FieldVal}}</option>
             </select>
			 </div>
			 			
			<div class="col-lg-1 col-md-1 col-sm-1"><button class="btn btn-success" ng-click="add_code_structure(2,code1_index)" >Add</button></div>	
			
					
		</div>
		
		<div class="panel-footer" style="margin-bottom:-14px;" align="center">		
		<button type="button" class="btn btn-dark" id="Save" name="Save"  onclick="closeForm()"	>Close</button>		
		</div>
				
		</div></div></div>		
		
	<!--=====================codestructure3   -->		
	
	<div class="container codestructure3"  id="codestructure3">
	<div class="row" >   
		<div class="panel panel-danger">	
		
			<div class="panel-heading">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-info-sign">					
					</span>Chart Of Account -{{FormInputArray[0].code_structure1[code1_index].code_structure2[code2_index].value}} of {{FormInputArray[0].code_structure1[code1_index].value}}{{savemsg}}</h4>
			</div>	
			
		<div class="row  bg-primary" style="padding: 3px; ">		
			<div class="col-lg-2 col-md-2 col-sm-2">Code</div>
			<div class="col-lg-2 col-md-2 col-sm-2">Description</div>
			<div class="col-lg-1 col-md-1 col-sm-2">Status</div>
			<div class="col-lg-2 col-md-2 col-sm-2">Field Qualifier</div>
			<!--<div class="col-lg-2 col-md-2 col-sm-2">Start Date</div>
			<div class="col-lg-2 col-md-2 col-sm-2">End Date</div>-->
			<div class="col-lg-1 col-md-1 col-sm-1">Add</div>			
		</div>
			
			<div class="row modal-body" style="padding: 3px; " ng-repeat="layer in  
			[0,FormInputArray[0].code_structure1[code1_index].code_structure2[code2_index].code_structure3.length-1] | toRange">		
			
			<div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 3px;">
			<input  type="text" id="name" style="text-align:left"	class="form-control  input_field_hight"  
			 ng-model="FormInputArray[0].code_structure1[code1_index].code_structure2[code2_index].code_structure3[layer].code" />
			 </div>
			 
			 <div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 3px;">
			<input  type="text" id="name" style="text-align:left"	class="form-control  input_field_hight"  
			 ng-model="FormInputArray[0].code_structure1[code1_index].code_structure2[code2_index].code_structure3[layer].value" />
			 </div>
			 
			<div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 3px;">
			 <select name="select" class="form-control  input_field_hight"  
			 ng-model="FormInputArray[0].code_structure1[code1_index].code_structure2[code2_index].code_structure3[layer].active_inactive" >
                <option ng-repeat="option in active_inactive_list" value="{{option.id}}">{{option.FieldVal}}</option>
             </select>
			 </div>
			 
			 <div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 3px;">
			 <select name="select" class="form-control  input_field_hight"  
			 ng-model="FormInputArray[0].code_structure1[code1_index].code_structure2[code2_index].code_structure3[layer].code_type_id" >
                <option ng-repeat="option in qualifier_list2" value="{{option.id}}">{{option.FieldVal}}</option>
             </select>
			 </div>
			 
			<!-- <div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 3px;">
			<input  type="text" id="name" style="text-align:left"	class="form-control  input_field_hight"  
			 ng-model="FormInputArray[0].code_structure1[code1_index].code_structure2[code2_index].code_structure3[layer].code" />
			 </div>
			 
			 <div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 3px;">
			<input  type="text" id="name" style="text-align:left"	class="form-control  input_field_hight"  
			 ng-model="FormInputArray[0].code_structure1[code1_index].code_structure2[code2_index].code_structure3[layer].code" />
			 </div>-->
			 			
			<div class="col-lg-1 col-md-1 col-sm-1"><button class="btn btn-success" ng-click="add_code_structure(3,code1_index,code2_index)" >Add</button></div>	
			
					
		</div>
		
		<div class="panel-footer" style="margin-bottom:-14px;" align="center">		
		<button type="button" class="btn btn-dark" id="Save" name="Save"  onclick="closeForm()"	>Close</button>		
		</div>
				
		</div></div></div>		
	

		<div class="panel-footer" style="margin-bottom:-14px;" align="center">
		<button type="button" class="btn btn-danger" id="Save" name="Save" 	ng-click="savedata()">Final Submit</button>		
		</div>
</div>

<style>

.codestructure1
{
  position:relative
  left:10px;
  top:5px;
  width:80%;    
}

.codestructure2
{
  position:relative
  left:10px;
  top:5px;
  width:80%;  
  display:none;
}
.codestructure3
{
  position:relative
  left:10px;
  top:5px;
  width:80%;  
  display:none;
}

</style>

<script type = "text/javascript">
/*Final Submit(F8) | New Mixer(F9) | Print Invoice(F10) | Print POS(F11) | New Entry (F1) */
	 function shortcut(codeVal,divid) 
	 {	
		if(codeVal==120) //New Mixer(F9)
		{ document.getElementById(divid).style.display = "block";
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

/*var m = document.getElementById('myForm');
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
};*/
</script>







</div>
	
	
	
	
