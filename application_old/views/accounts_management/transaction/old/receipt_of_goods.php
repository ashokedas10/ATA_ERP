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
	
<div class="container" style="width:100%"  ng-controller="receipt_of_goods" ng-init="view_list(0)" id="myBody" onkeypress = "shortcut()">
			
	<div  class="form-row"  >
	
		<div class="panel panel-danger"   >		
				<div class="panel-heading">
					<div class="row">
						<div class="col-sm-12">
							<h4 class="panel-title" id="contactLabel">
							<span class="glyphicon glyphicon-info-sign"></span>Receipt of Goods </h4>
						</div>
					</div>
				</div>
			</div>	
			
			
			
			
		 
		<div class="form-row col-md-9 nopadding" > 
			<div class="panel panel-default">	
					<!--BODY FILDSET-->
					<div class="bg-primary clearfix">&nbsp;</div>	
					
					<!--<div ng-repeat="step in FormInputArray[0].header">
						<div ng-repeat="(key, value) in step">
							{{key}} : {{value}}
						</div>
					</div>		-->	
										
					<table class="table table-bordered table-hover table-condensed" >	
						
						<tr>
						<td  align="left" class="bg-warning "><label>Item</label></td>
						<td  align="left" class="bg-warning "><label>Qnty</label></td>
						<td  align="left" class="bg-warning "><label>Uom</label></td>
						<td  align="right" class="bg-warning "><label>Price</label></td>
						<td  align="left" class="bg-warning "><label>Approve(Y/N)</label></td>
						</tr>
						
						<tbody>
						
						<tr ng-repeat="(key, value) in FormInputArray[0].header">
						
						<td  align="left"   >						
							<input id="{{'item_name'+key}}" autofocus type="text" name="{{key}}"   placeholder="Item"  
							ng-keydown="checkKeyDown($event)" ng-keyup="checkKeyUp($event)"
							ng-model="value.item_name"
							ng-change="search('item_name',key,$index)" 
							ng-focus="search('item_name',key,$index)" 
							class="form-control input_field_height" ng-keypress="mainOperation($event,2)" autocomplete="off" readonly=""/>
						</td>	
						
						<td  align="left"   >
							<input id="{{'qnty'+key}}" autofocus type="text" name="{{key}}"   placeholder="Qnty"  
							ng-keydown="checkKeyDown($event)" ng-keyup="checkKeyUp($event)"
							ng-model="value.qnty"	
							ng-change="search('item_name',key,$index)" 
							ng-focus="search('item_name',key,$index)"						
							class="form-control input_field_height" ng-keypress="mainOperation($event,2)" style="width:{{50*3}}px;" autocomplete="off"/>
						</td>	
						
						<td  align="left"   >
							<input id="{{'uom_name'+key}}" autofocus type="text" name="{{key}}"   placeholder="Uom"  
							ng-keydown="checkKeyDown($event)" ng-keyup="checkKeyUp($event)"
							ng-model="value.uom_name"
							ng-change="search('uom_name',key,$index)" 
							ng-focus="search('uom_name',key,$index)" 
							class="form-control input_field_height" ng-keypress="mainOperation($event,2)" style="width:{{50*3}}px;" autocomplete="off"/>
						</td>	
						
						<td  align="right" >
							<input id="{{'price'+key}}" autofocus type="text" name="{{key}}"   placeholder="price"  
							ng-keydown="checkKeyDown($event)" ng-keyup="checkKeyUp($event)"
							ng-model="value.price"
							ng-change="search('item_name',key,$index)" 
							ng-focus="search('item_name',key,$index)"
							class="form-control input_field_height" 
							ng-keypress="mainOperation($event,2)" style="width:{{50*3}}px; text-align:right" readonly="" autocomplete="off"/>
						</td>		
						
						<td  align="left">
							<input id="{{'grn_approve'+key}}" autofocus type="text" name="{{key}}"   placeholder="price"  
							ng-keydown="checkKeyDown($event)" ng-keyup="checkKeyUp($event)"
							ng-model="value.grn_approve"
							ng-change="search('grn_approve',key,$index)" 
							ng-focus="search('grn_approve',key,$index)"
							class="form-control input_field_height" ng-keypress="mainOperation($event,2)" style="width:{{50*1}}px;" maxlength="1" autocomplete="off"/>
						</td>																									
							
							
						</tr>
						
						
						
						</tbody>
																												
					</table>
					
					<div class="bg-primary clearfix">&nbsp;</div>
					<table class="table table-bordered table-hover table-condensed" >	
						
						<tr>
						<td  align="left" class="bg-info" ><label>PO No</label></td><td  align="left">{{FormInputArray[0].header[indx1].req_number}}</td>	
						<td  align="left" class="bg-info"><label>PO Date</label></td><td  align="left">{{FormInputArray[0].header[indx1].req_accounting_date}}</td>							
						</tr>
						
						<tr>
						<td  align="left" class="bg-info"><label>Operating Unit</label></td><td  align="left" >{{FormInputArray[0].header[indx1].req_operating_name}}</td>						
						<td  align="left" class="bg-info"><label>Order Type</label></td><td  align="left" >{{FormInputArray[0].header[indx1].req_type}}</td>
						<td  align="left" class="bg-info"><label>Supplier</label></td><td  align="left" >{{FormInputArray[0].header[indx1].req_supplier_name}}</td>
						</tr>
						
						
						<tr>
						<td  align="center" colspan="6" ><button type="button" class="btn btn-success" id="Save" name="Save" 
								ng-click="view_list(form_id,field.id,0,-1,'NA')">Submit</button></td>
						</tr>
						
						
																												
					</table>
					<p>&nbsp;</p>
										
					<!--BODY FILDSET END-->
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
				
	
	<!--Return Object: {{FormInputArray[0]}}-->
	</div>
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
 
 $("#7").datepicker({
   changeMonth: true,
   changeYear: true
 });
  
 $("#7").change(function() {
  var  trandate = $('#7').val();
  trandate=
  trandate.substring(6, 10)+'-'+
  trandate.substring(0, 2)+'-'+
  trandate.substring(3, 5);
  $("#7").val(trandate);
 });
 
  
 
  $("#grn_approve0").datepicker({
   changeMonth: true,
   changeYear: true
 });
  
 $("#grn_approve0").change(function() {
  var  trandate = $('#grn_approve0').val();
  trandate=
  trandate.substring(6, 10)+'-'+
  trandate.substring(0, 2)+'-'+
  trandate.substring(3, 5);
  $("#grn_approve0").val(trandate);
 });
 
 $("#enddate").datepicker({
   changeMonth: true,
   changeYear: true
 });
  
 $("#enddate").change(function() {
  var  trandate = $('#enddate').val();
  trandate=
  trandate.substring(6, 10)+'-'+
  trandate.substring(0, 2)+'-'+
  trandate.substring(3, 5);
  $("#enddate").val(trandate);
 });
	 
 	 
</script>

<script>
  Inputmask.extendAliases({
  "yyyy-mm": {
    mask: "y-2",
    placeholder: "yyyy-mm",
    alias: "datetime",
    separator: "-"
  }
})

$("#exp_monyr").inputmask("yyyy-mm");
$("#mfg_monyr").inputmask("yyyy-mm");

$("#mfg_monyr_mixture").inputmask("yyyy-mm");
$("#exp_monyr_mixture").inputmask("yyyy-mm");

  
</script>		

