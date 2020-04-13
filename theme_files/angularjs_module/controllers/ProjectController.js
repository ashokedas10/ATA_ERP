//CRUD VIDEO
// https://www.youtube.com/watch?v=DB-kVs76XZ4
//https://www.codeproject.com/Tips/872181/CRUD-in-Angular-js
//https://github.com/chieffancypants/angular-hotkeys/ 
//http://www.codexworld.com/angularjs-crud-operations-php-mysql/
'use strict';

var domain_name="http://localhost/pharma_management/staford/";

//var domain_name="http://adequatesolutions.co.in/homeopathi/";


//************************ACCOUNT RECEIVE START*****************************************//
var app = angular.module('Accounts',['GeneralServices']);

// app.config(['$routeProvider',function($routeProvider){
// $routeProvider.
// when('/Purchase/:Id',{
// 	templateUrl : 'Purchase.html',
// 	controller: 'PurchaseEntry'
// }).
// when("/Sale/:Id", {
// 	templateUrl: 'Sale_test.html',
// 	controller: 'Sale_test'
// });

// }]);

//app.config([])

//************************ACCOUNT PURCHASE START*****************************************//
app.controller('PurchaseEntry',['$scope','$routeParams','$rootScope','$http','PurchaseEntry',
function($scope,$routeParams,$rootScope,$http,PurchaseEntry,userPersistenceService){
	"use strict";

	//$scope.appState='EMIPAYMENT';
	//var domain_name="http://localhost/abir_das_unitedlab/SATNAM/";	
	var BaseUrl=domain_name+"Accounts_controller/AccountsTransactions/PurchaseEntry/";
		$scope.tran_date=$rootScope.tran_date;

		$scope.previous_transaction_details=function(product_id)
		{
			//$scope.savemsg=searchelement;
			//var product_id=$scope.product_id;
			//var batchno=$scope.batchno;

			var data_link=BaseUrl+"previous_transaction_details/"+product_id;					
			console.log(data_link);					
			$http.get(data_link).then(function(response){
				angular.forEach(response.data,function(value,key){
					$scope.savemsg=value.msg; 
				});
			});


		}

		$rootScope.search = function(searchelement)
		{
		
			$scope.SEARCHTYPE='PRODUCT';
			$rootScope.searchelement=searchelement;

			

			$rootScope.suggestions = [];
			$rootScope.searchItems=[];
			//console.log($rootScope.searchelement);
			PurchaseEntry.list_items($rootScope.searchelement,$scope.trantype);
			$rootScope.searchItems.sort();	
			var myMaxSuggestionListLength = 0;
			for(var i=0; i<$rootScope.searchItems.length; i++){
				var searchItemsSmallLetters = angular.uppercase($rootScope.searchItems[i]);
				var searchTextSmallLetters = angular.uppercase($scope[$rootScope.searchelement]);
				if( searchItemsSmallLetters.indexOf(searchTextSmallLetters) !== -1){
					$rootScope.suggestions.push(searchItemsSmallLetters);
					myMaxSuggestionListLength += 1;
					if(myMaxSuggestionListLength === 400){
						break;
					}
				}
			}
		};
	
	$rootScope.$watch('selectedIndex',function(val){		
		if(val !== -1) {
			$scope[$rootScope.searchelement] =
			$rootScope.suggestions[$rootScope.selectedIndex];
		}
	});		
	$rootScope.checkKeyDown = function(event){
		console.log(event.keyCode);

		if(event.keyCode === 40){//down key, increment selectedIndex
			event.preventDefault();
			if($rootScope.selectedIndex+1 < $rootScope.suggestions.length){
				$rootScope.selectedIndex++;
			}else{
				$rootScope.selectedIndex = 0;
			}
		}else if(event.keyCode === 38){ //up key, decrement selectedIndex
			event.preventDefault();
			if($rootScope.selectedIndex-1 >= 0){
				$rootScope.selectedIndex--;
			}else{
				$rootScope.selectedIndex = $rootScope.suggestions.length-1;
			}
		}
		else if(event.keyCode === 13){ //enter key, empty suggestions array
			$rootScope.AssignValueAndHide($rootScope.selectedIndex);
			//console.log($rootScope.selectedIndex);
			event.preventDefault();			
			$rootScope.suggestions = [];
			$rootScope.searchItems=[];
			$rootScope.selectedIndex = -1;
		}
		else if(event.keyCode === 9){ //enter tab key
			//console.log($rootScope.selectedIndex);
			if($rootScope.selectedIndex>-1){
				$rootScope.AssignValueAndHide($rootScope.selectedIndex);
			}			

		}else if(event.keyCode === 27){ //ESC key, empty suggestions array
			$rootScope.AssignValueAndHide($rootScope.selectedIndex);
			console.log($rootScope.selectedIndex);
			event.preventDefault();
			$rootScope.suggestions = [];
			$rootScope.searchItems=[];
			$rootScope.selectedIndex = -1;
		}else{
			$rootScope.search();	
		}
	};
	
	//ClickOutSide
	var exclude1 = document.getElementById($rootScope.searchelement);
	$rootScope.hideMenu = function($event){
		$rootScope.search();
		//make a condition for every object you wat to exclude
		if($event.target !== exclude1) {
			$rootScope.searchItems=[];
			$rootScope.suggestions = [];
			$rootScope.selectedIndex = -1;
		}
	};
	//======================================
	
	//Function To Call on ng-keyup
	$rootScope.checkKeyUp = function(event){ 
		if(event.keyCode !== 8 || event.keyCode !== 46){//delete or backspace
			if($scope[$rootScope.searchelement] === ""){
				$rootScope.suggestions = [];
				$rootScope.searchItems=[];
				$rootScope.selectedIndex = -1;
			}
		}
	};
	//======================================
	//List Item Events
	//Function To Call on ng-click
	$rootScope.AssignValueAndHide = function(index){
	$scope[$rootScope.searchelement]= $rootScope.suggestions[index];

		if($rootScope.searchelement=='tbl_party_id_name')
		{
			var str=$scope.tbl_party_id_name;
			var id=str.substring(str.lastIndexOf("#")+1,str.lastIndexOf(")"));	
			var data_link=BaseUrl+"tbl_party_id/"+id;					
			//console.log(data_link);					
			$http.get(data_link).then(function(response){
				angular.forEach(response.data,function(value,key){
					$scope['tbl_party_id']=value.id;  //ACTUAL ID
					$scope['tbl_party_id_name']=value.name; // NAME 					
				});
			});
		}
		if($rootScope.searchelement=='product_id_name')
		{
			var str=$scope.product_id_name;
			var id=str.substring(str.lastIndexOf("#")+1,str.lastIndexOf(")"));	
			var data_link=BaseUrl+"product_id/"+id;					
			//console.log(data_link);					
			$http.get(data_link).then(function(response){
				angular.forEach(response.data,function(value,key){
					$scope['product_id']=value.id;  //ACTUAL ID
					$scope['product_id_name']=value.name; // NAME 	
					$scope['tax_ledger_id']=value.tax_ledger_id; // NAME 	
					$scope['tax_per']=value.tax_per; // NAME 
					$scope.previous_transaction_details(value.id);															
				});
			});

			
		}
			
		 $rootScope.suggestions=[];
		 $rootScope.searchItems=[];
		 $rootScope.selectedIndex = -1;
	};
	//===================END SEARCH SECTION =========================================

	//=========batch wise search=====================

	$rootScope.search_batch = function(searchelement){	
		$scope.SEARCHTYPE='BATCH';		

		

		$rootScope.searchelement=searchelement;
		$rootScope.suggestions_batch = [];
		$rootScope.searchItems=[];

		var data_link=BaseUrl+"batchno/"+$scope.product_id;
		console.log(data_link);			
		$http.get(data_link)
		.then(function(response) {
		$rootScope.suggestions_batch=response.data	;
		});			

	};
	
	$rootScope.$watch('selectedIndex_batch',function(val){		
		if(val !== -1) {	
			$scope['batchno'] =
			$rootScope.suggestions_batch[$rootScope.selectedIndex_batch].batchno;		
		}
	});		

	$rootScope.checkKeyDown_batch = function(event){
		if(event.keyCode === 40){//down key, increment selectedIndex
			event.preventDefault();
			if($rootScope.selectedIndex_batch+1 < $rootScope.suggestions_batch.length){
				$rootScope.selectedIndex_batch++;
			}else{
				$rootScope.selectedIndex_batch = 0;
			}
		
		}else if(event.keyCode === 38){ //up key, decrement selectedIndex
			event.preventDefault();
			if($rootScope.selectedIndex_batch-1 >= 0){
				$rootScope.selectedIndex_batch--;
			}else{
				$rootScope.selectedIndex_batch = $rootScope.suggestions_batch.length-1;
			}
		}
		else if(event.keyCode === 13){ //enter key, empty suggestions array
			$rootScope.AssignValueAndHide_batch($rootScope.selectedIndex_batch);
			//console.log($rootScope.selectedIndex);
			event.preventDefault();			
			$rootScope.suggestions_batch = [];
			$rootScope.searchItems=[];		
			$rootScope.selectedIndex_batch = -1;
		}
		else if(event.keyCode === 9){ //enter tab key
			//console.log($rootScope.selectedIndex);
			if($rootScope.selectedIndex_batch>-1){
				$rootScope.AssignValueAndHide_batch($rootScope.selectedIndex_batch);
			}			

		}else if(event.keyCode === 27){ //ESC key, empty suggestions array
			$rootScope.AssignValueAndHide_batch($rootScope.selectedIndex_batch);			
			event.preventDefault();
			$rootScope.suggestions_batch = [];
			$rootScope.searchItems=[];		
			$rootScope.selectedIndex_batch = -1;
		}else{
			$rootScope.search_batch();	
		}
	};
	
	//ClickOutSide
	var exclude1 = document.getElementById($rootScope.batchno);
	$rootScope.hideMenu = function($event){
		$rootScope.search();
		//make a condition for every object you wat to exclude
		if($event.target !== exclude1) {
			$rootScope.searchItems=[];
			$rootScope.suggestions_batch = [];			
			$rootScope.selectedIndex_batch = -1;
		}
	};
	//======================================
	
	//Function To Call on ng-keyup
	$rootScope.checkKeyUp_batch = function(event){ 
		if(event.keyCode !== 8 || event.keyCode !== 46){//delete or backspace
			if($scope[$rootScope.searchelement] === ""){
				$rootScope.suggestions_batch = [];
				$rootScope.searchItems=[];			
				$rootScope.selectedIndex_batch = -1;
			}
		}
	};
	//======================================
	//List Item Events
	//Function To Call on ng-click
	$rootScope.AssignValueAndHide_batch = function(index)
	{

		$scope[$rootScope.searchelement]= $rootScope.suggestions_batch[index].batchno;
			//console.log($rootScope.suggestions_batch[index].exp_monyr);
		
		//	$scope.previous_transaction_details();
			
		$scope['exp_monyr']=$rootScope.suggestions_batch[index].exp_monyr;  
		$scope['mfg_monyr']=$rootScope.suggestions_batch[index].mfg_monyr; 
		$scope['rackno']=$rootScope.suggestions_batch[index].rackno; 
		$scope['rate']=$rootScope.suggestions_batch[index].rate; 
		$scope['srate']=$rootScope.suggestions_batch[index].srate; 
		$scope['mrp']=$rootScope.suggestions_batch[index].mrp; 
		$scope['ptr']=$rootScope.suggestions_batch[index].ptr; 
		$scope['AVAILABLE_QTY']=$rootScope.suggestions_batch[index].AVAILABLE_QTY; 
		
		$rootScope.suggestions_batch=[];
			$rootScope.searchItems=[];		
			$rootScope.selectedIndex = -1;
	};
	//===================END batch SEARCH SECTION =========================================






	$scope.savedata=function()
	{
		var data_link=BaseUrl+"SAVE";
		var success={};
		console.log('$scope.id_detail'+$scope.id_detail)
		var data_save = {
			'id_header': $scope.get_set_value($scope.id_header,'num','SETVALUE'),
			'id_detail': $scope.get_set_value($scope.id_detail,'num','SETVALUE'),
			'product_id': $scope.get_set_value($scope.product_id,'num','SETVALUE'),
			'tbl_party_id': $scope.get_set_value($scope.tbl_party_id,'num','SETVALUE'),
			'invoice_date': $scope.get_set_value($scope.invoice_date,'str','SETVALUE'),
			'challan_no': $scope.get_set_value($scope.challan_no,'str','SETVALUE'),
			'challan_date': $scope.get_set_value($scope.challan_date,'str','SETVALUE'),
			'tbl_party_id_name': $scope.get_set_value($scope.tbl_party_id_name,'str','SETVALUE'),
			'comment': $scope.get_set_value($scope.comment,'str','SETVALUE'),
			'product_id_name': $scope.get_set_value($scope.product_id_name,'str','SETVALUE'),
			'batchno': $scope.get_set_value($scope.batchno,'str','SETVALUE'),
			'qnty': $scope.get_set_value($scope.qnty,'num','SETVALUE'),
			'exp_monyr': $scope.get_set_value($scope.exp_monyr,'str','SETVALUE'),
			'mfg_monyr': $scope.get_set_value($scope.mfg_monyr,'str','SETVALUE'),
			'rate': $scope.get_set_value($scope.rate,'num','SETVALUE'),
			'mrp': $scope.get_set_value($scope.mrp,'num','SETVALUE'),
			'ptr': $scope.get_set_value($scope.ptr,'num','SETVALUE'),
			'srate': $scope.get_set_value($scope.srate,'num','SETVALUE'),
			'tax_per': $scope.get_set_value($scope.tax_per,'num','SETVALUE'),	
			'disc_per': $scope.get_set_value($scope.disc_per,'num','SETVALUE'),	
			'tax_ledger_id': $scope.get_set_value($scope.tax_ledger_id,'num','SETVALUE'),
			'disc_per2': $scope.get_set_value($scope.disc_per2,'num','SETVALUE'),
			'tot_cash_discount': $scope.get_set_value($scope.tot_cash_discount,'num','SETVALUE'),
			'rackno': $scope.get_set_value($scope.rackno,'num','SETVALUE')
		};	
	
		var config = {headers : 
			{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
		}
		//$http.post(data_link, data,config)
		$http.post(data_link,data_save,config)
		.then (function success(response){
			console.log('ID HEADER '+response.data.id_header);
			$scope.get_set_value(response.data,'','REFRESH');
			document.getElementById('product_id_name').focus();
		},
		function error(response){
			$scope.errorMessage = 'Error adding user!';
			$scope.message = '';
	  });

	}
	
	$scope.get_set_value=function(datavalue,datatype,operation)
	{
		if(operation=='SETVALUE')
		{
			if(angular.isUndefined(datavalue)==true)
			{
				if(datatype=='num')
				{return 0;}
				if(datatype=='str')
				{return '';}		
			}
			else
			{return datavalue;}
		}
		if(operation=='DRCRCHECKING')
		{
			var savestatus='OK';
						
			if($scope.invoice_date == null || $scope.invoice_date === "")			
			{
			savestatus='NOTOK';$scope.savemsg='ENTER INVOICE DATE';
			document.getElementById('invoice_date').focus();
			}
			if($scope.tbl_party_id == '0')			
			{
			savestatus='NOTOK';$scope.savemsg='ENTER PARTY';
			document.getElementById('tbl_party_id_name').focus();
			}

			if($scope.product_id == '0')			
			{
			savestatus='NOTOK';$scope.savemsg='ENTER PRODUCT';
			document.getElementById('product_id_name').focus();
			}
		
			if(savestatus=='OK')
			{
				$scope.savedata();
				$scope.savemsg='Receord Has been saved Successfully!';
			}
		}
		if(operation=='REFRESH')
		{		
			//HEADER SECTION
			$scope.id_header=datavalue.id_header;
			$scope.invoice_no=datavalue.invoice_no;
			$scope.invoice_date=datavalue.invoice_date;
			$scope.challan_no=datavalue.challan_no;
			$scope.challan_date=datavalue.challan_date;
			$scope.tbl_party_id_name=datavalue.tbl_party_id_name;
			$scope.tbl_party_id=datavalue.tbl_party_id;
			$scope.comment=datavalue.comment;

			//DETAIL SECTION
			$scope.id_detail='';	
			$scope.product_id_name='';			
			$scope.product_id=$scope.batchno=$scope.qnty='';
			$scope.exp_monyr=$scope.mfg_monyr=$scope.rate='';
			$scope.mrp=$scope.ptr=$scope.srate=$scope.tax_per='';
			$scope.tax_ledger_id=$scope.disc_per='';
			$scope.disc_per2=$scope.rackno='';

			//data list
			 var data_link=BaseUrl+"DTLLIST/"+$scope.id_header;
			 $http.get(data_link).then(function(response) 
			 {$scope.listOfDetails=response.data;});
			
			 $scope.VIEWALLVALUE($scope.id_header);

			//$scope.consignment_value();
			//$scope.GetAllConsignment($scope.startdate,$scope.enddate);

		}
		if(operation=='NEWENTRY')
		{		
			
			//HEADER SECTION
			$scope.id_header='';
			$scope.invoice_no='';
			$scope.invoice_date='';
			$scope.challan_no='';
			$scope.challan_date='';
			$scope.tbl_party_id_name='';
			$scope.tbl_party_id='';
			$scope.comment='';
			
			//DETAIL SECTION
			$scope.id_detail='';	
			$scope.product_id_name='';			
			$scope.product_id=$scope.batchno=$scope.qnty='';
			$scope.exp_monyr=$scope.mfg_monyr=$scope.rate='';
			$scope.mrp=$scope.ptr=$scope.srate=$scope.tax_per='';
			$scope.tax_ledger_id=$scope.disc_per='';
			$scope.disc_per2=$scope.rackno=$scope.tot_cash_discount='';

			//data list
			 var data_link=BaseUrl+"DTLLIST/"+0;
			 $http.get(data_link).then(function(response) 
			 {$scope.listOfDetails=response.data;});

			 document.getElementById('invoice_date').focus();
		}
		if(operation=='VIEWDTL')
		{	
			var data_link=BaseUrl+"VIEWDTL/"+datavalue;
			console.log(data_link);
			$http.get(data_link).then(function(response) 
			{
				angular.forEach(response.data,function(value,key){
					$scope['id_detail']=value.id;  
					$scope['product_id_name']=value.product_id_name;  
					$scope['product_id']=value.product_id;  					
					$scope['batchno']=value.batchno;  
					$scope['qnty']=value.qnty;  
					$scope['exp_monyr']=value.exp_monyr;  
					$scope['mfg_monyr']=value.mfg_monyr; 
					$scope['rate']=value.rate;
					$scope['mrp']=value.mrp;	
					$scope['ptr']=value.ptr;
					$scope['srate']=value.srate;
					$scope['tax_per']=value.tax_per;
					$scope['tax_ledger_id']=value.tax_ledger_id;
					$scope['disc_per']=value.disc_per;
					$scope['disc_per2']=value.disc_per2;
					$scope['rackno']=value.rackno;
				});			
				
			});
		}

		if(operation=='VIEWALLVALUE')
		{	
			var data_link=BaseUrl+"DTLLIST/"+datavalue;
			$http.get(data_link).then(function(response) 
			{$scope.listOfDetails=response.data;});

			$scope.VIEWALLVALUE(datavalue);
	
		}

	}


	$scope.VIEWALLVALUE=function(invoice_id)
	{

		var data_link=BaseUrl+"VIEWALLVALUE/"+invoice_id;
			console.log(data_link);
			$http.get(data_link).then(function(response) 
			{
				angular.forEach(response.data,function(value,key){

					$scope['id_header']=value.id_header;  					
					$scope['invoice_no']=value.invoice_no;  
					$scope['invoice_date']=value.invoice_date;  
					$scope['challan_no']=value.challan_no;  
					$scope['challan_date']=value.challan_date;  
					$scope['tbl_party_id_name']=value.tbl_party_id_name;  
					$scope['tbl_party_id']=value.tbl_party_id;								
					$scope['comment']=value.comment;
					$scope['tot_cash_discount']=value.tot_cash_discount;

					$scope['total_amt']=value.total_amt;  
					$scope['tot_discount']=value.tot_discount;	
					$scope['tot_taxable_amt']=$scope['total_amt']-$scope['tot_discount'];								
					$scope['totvatamt']=value.totvatamt;
					$scope['grandtot']=value.grandtot;
				});	
				
			});		

	}


	$scope.GetAllList=function(fromdate,todate)
	{
		var data_link=BaseUrl+"GRANDTOTAL/"+datavalue;
		console.log(data_link);
		$http.get(data_link).then(function(response) 
		{
			angular.forEach(response.data,function(value,key){

				$scope['id_header']=value.id_header;  					
				$scope['invoice_no']=value.invoice_no;  
				$scope['invoice_date']=value.invoice_date;  
				$scope['challan_no']=value.challan_no;  
				$scope['challan_date']=value.challan_date;  
				$scope['tbl_party_id_name']=value.tbl_party_id_name;  
				$scope['tbl_party_id']=value.tbl_party_id;								
				$scope['comment']=value.comment;
				$scope['tot_cash_discount']=value.tot_cash_discount;					
			});	
		});	

	}

	$scope.GetAllList=function(fromdate,todate){
			//var BaseUrl=domain_name+"Primary_sale_controller/ConsignmentList/";
			//data list GetAllConsignment			
			var data_link=BaseUrl+'GetAllList/PAYMENT/-/-/'+fromdate+'/'+todate;
			console.log(data_link);
			$http.get(data_link).then(function(response) 
			{$scope.ListOfTransactions=response.data;});
	}
	
	$scope.print_barcode = function(id_header) 
	{ 
		var BaseUrl=domain_name+"Project_controller/print_all/";
		var data_link=BaseUrl+id_header;
		window.popup(data_link); 
	};

}]);

//************************ACCOUNT PURCHASE END*****************************************//


//************************ACCOUNT SALE START*****************************************//
app.controller('Sale_test',['$scope','$routeParams','$rootScope','$http','Sale_test',
function($scope,$routeParams,$rootScope,$http,Sale_test)
{
	"use strict";

	//$scope.appState='EMIPAYMENT';
	//var domain_name="http://localhost/abir_das_unitedlab/SATNAM/";	
	var BaseUrl=domain_name+"Accounts_controller/AccountsTransactions/SaleEntry/";
		$scope.tran_date=$rootScope.tran_date;

		$scope.previous_transaction_details=function(product_id)
		{
			var data_link=BaseUrl+"previous_transaction_details/"+product_id;					
			console.log(data_link);					
			$http.get(data_link).then(function(response){
				angular.forEach(response.data,function(value,key){
					$scope.savemsg=value.msg; 
				});
			});
		}


		// var data_link=BaseUrl+"product_list/";
		// console.log(data_link);
		// $http.get(data_link).then(function(response) 
		// {$scope.product_list=response.data;});


		//product_list


		$rootScope.search = function(searchelement){			
		$rootScope.searchelement=searchelement;
		$rootScope.suggestions = [];
		$rootScope.searchItems=[];
		//console.log($rootScope.searchelement);		
		if($rootScope.searchelement=='product_id_name')
		{Sale_test.list_items($rootScope.searchelement,$scope.product_id_name);}
		else if($rootScope.searchelement=='product_id_name_mixer')
		{Sale_test.list_items($rootScope.searchelement,$scope.product_id_name_mixer);}
		else
		{Sale_test.list_items($rootScope.searchelement,$scope.product_id);}
		
		
		$rootScope.searchItems.sort();	
		var myMaxSuggestionListLength = 0;
		for(var i=0; i<$rootScope.searchItems.length; i++){
			var searchItemsSmallLetters = angular.uppercase($rootScope.searchItems[i]);
			var searchTextSmallLetters = angular.uppercase($scope[$rootScope.searchelement]);
			if( searchItemsSmallLetters.indexOf(searchTextSmallLetters) !== -1){
				$rootScope.suggestions.push(searchItemsSmallLetters);
				myMaxSuggestionListLength += 1;
				 if(myMaxSuggestionListLength === 1500)
				 {break;}
			}
		}
	};
	
	$rootScope.$watch('selectedIndex',function(val){		
		if(val !== -1) {					
			$scope[$rootScope.searchelement] =
			$rootScope.suggestions[$rootScope.selectedIndex];		
		}
	});		

	$rootScope.checkKeyDown = function(event){
		if(event.keyCode === 40){//down key, increment selectedIndex
			event.preventDefault();
			if($rootScope.selectedIndex+1 < $rootScope.suggestions.length){
				$rootScope.selectedIndex++;
			}else{
				$rootScope.selectedIndex = 0;
			}
		
		}else if(event.keyCode === 38){ //up key, decrement selectedIndex
			event.preventDefault();
			if($rootScope.selectedIndex-1 >= 0){
				$rootScope.selectedIndex--;
			}else{
				$rootScope.selectedIndex = $rootScope.suggestions.length-1;
			}
		}
		else if(event.keyCode === 13){ //enter key, empty suggestions array
			$rootScope.AssignValueAndHide($rootScope.selectedIndex);
			//console.log($rootScope.selectedIndex);
			event.preventDefault();			
			$rootScope.suggestions = [];
			$rootScope.searchItems=[];		
			$rootScope.selectedIndex = -1;
		}
		else if(event.keyCode === 9){ //enter tab key
			//console.log($rootScope.selectedIndex);
			if($rootScope.selectedIndex>-1){
				$rootScope.AssignValueAndHide($rootScope.selectedIndex);
			}			

		}else if(event.keyCode === 27){ //ESC key, empty suggestions array
			$rootScope.AssignValueAndHide($rootScope.selectedIndex);
			console.log($rootScope.selectedIndex);
			event.preventDefault();
			$rootScope.suggestions = [];
			$rootScope.searchItems=[];		
			$rootScope.selectedIndex = -1;
		}else{
			$rootScope.search();	
		}
	};
	
	//ClickOutSide
	var exclude1 = document.getElementById($rootScope.searchelement);
	$rootScope.hideMenu = function($event){
		$rootScope.search();
		//make a condition for every object you wat to exclude
		if($event.target !== exclude1) {
			$rootScope.searchItems=[];
			$rootScope.suggestions = [];			
			$rootScope.selectedIndex = -1;
		}
	};
	//======================================
	
	//Function To Call on ng-keyup
	$rootScope.checkKeyUp = function(event){ 
		if(event.keyCode !== 8 || event.keyCode !== 46){//delete or backspace
			if($scope[$rootScope.searchelement] === ""){
				$rootScope.suggestions = [];
				$rootScope.searchItems=[];			
				$rootScope.selectedIndex = -1;
			}
		}
	};
	//======================================
	//List Item Events
	//Function To Call on ng-click
	$rootScope.AssignValueAndHide = function(index){
	$scope[$rootScope.searchelement]= $rootScope.suggestions[index];

		if($rootScope.searchelement=='doctor_ledger_id_name')
		{
			var str=$scope.doctor_ledger_id_name;
			var id=str.substring(str.lastIndexOf("#")+1,str.lastIndexOf(")"));	
			var data_link=BaseUrl+"doctor_ledger_id/"+id;					
			//console.log(data_link);					
			$http.get(data_link).then(function(response){
				angular.forEach(response.data,function(value,key){
					$scope['doctor_ledger_id']=value.id;  //ACTUAL ID
					$scope['doctor_ledger_id_name']=value.name; // NAME 					
				});
			});
		}

		if($rootScope.searchelement=='tbl_party_id_name')
		{
			var str=$scope.tbl_party_id_name;
			var id=str.substring(str.lastIndexOf("#")+1,str.lastIndexOf(")"));	
			var data_link=BaseUrl+"tbl_party_id/"+id;					
			//console.log(data_link);					
			$http.get(data_link).then(function(response){
				angular.forEach(response.data,function(value,key){
					$scope['tbl_party_id']=value.id;  //ACTUAL ID
					$scope['tbl_party_id_name']=value.name; // NAME 					
				});
			});
		}
		

		if($rootScope.searchelement=='product_id_name')
		{
			var str=$scope.product_id_name;
			var id=str.substring(str.lastIndexOf("#")+1,str.lastIndexOf(")"));	
			var data_link=BaseUrl+"product_id/"+id;					
			console.log(data_link);					
			$http.get(data_link).then(function(response){
				angular.forEach(response.data,function(value,key){
					$scope['product_id']=value.id;  //ACTUAL ID
					$scope['product_id_name']=value.name; // NAME 	
					$scope['tax_ledger_id']=value.tax_ledger_id; // NAME 	
					$scope['tax_per']=value.tax_per; // NAME 	
					$scope['Synonym']=value.Synonym; // NAME 
					$scope.previous_transaction_details(value.id);														
				});
			});
		}

		if($rootScope.searchelement=='product_id_name_mixer')
		{
			var str=$scope.product_id_name_mixer;
			var id=str.substring(str.lastIndexOf("#")+1,str.lastIndexOf(")"));	
			var data_link=BaseUrl+"product_id/"+id;					
			//console.log(data_link);					
			$http.get(data_link).then(function(response){
				angular.forEach(response.data,function(value,key){
					$scope['product_id']=value.id;  //ACTUAL ID
					$scope['product_id_name_mixer']=value.name; // NAME 	
					$scope['tax_ledger_id']=value.tax_ledger_id; // NAME 	
					$scope['tax_per']=value.tax_per; // NAME 	
					$scope['Synonym']=value.Synonym; // NAME 
					$scope['TRANTYPE']='MIXER'; // NAME 
																			
				});
			});
		}

		if($rootScope.searchelement=='batchno')
		{			
			var data_link=BaseUrl+"BATCH_DETAILS/"+$scope.product_id+"/"+$scope.batchno;					
			//console.log(data_link);					
			$http.get(data_link).then(function(response){
				angular.forEach(response.data,function(value,key){
					$scope['exp_monyr']=value.exp_monyr;  
					$scope['mfg_monyr']=value.mfg_monyr; 
					$scope['rate']=value.rate; 
					$scope['srate']=value.srate; 
					$scope['mrp']=value.mrp; 
					$scope['ptr']=value.ptr; 
					$scope['AVAILABLE_QTY']=value.AVAILABLE_QTY; 
																	
				});
			});
		}
			
		 $rootScope.suggestions=[];
		 $rootScope.searchItems=[];		
		 $rootScope.selectedIndex = -1;
	};
	//===================END SEARCH SECTION =========================================

	$rootScope.search_batch = function(searchelement){			
		$rootScope.searchelement=searchelement;
		$rootScope.suggestions_batch = [];
		$rootScope.searchItems=[];

		var data_link=BaseUrl+"batchno/"+$scope.product_id;
		console.log(data_link);			
		$http.get(data_link)
		.then(function(response) {
		$rootScope.suggestions_batch=response.data	;
		});			

	};
	
	$rootScope.$watch('selectedIndex_batch',function(val){		
		if(val !== -1) {	
			$scope['batchno'] =
			$rootScope.suggestions_batch[$rootScope.selectedIndex_batch].batchno;		
		}
	});		

	$rootScope.checkKeyDown_batch = function(event){
		if(event.keyCode === 40){//down key, increment selectedIndex
			event.preventDefault();
			if($rootScope.selectedIndex_batch+1 < $rootScope.suggestions_batch.length){
				$rootScope.selectedIndex_batch++;
			}else{
				$rootScope.selectedIndex_batch = 0;
			}
		
		}else if(event.keyCode === 38){ //up key, decrement selectedIndex
			event.preventDefault();
			if($rootScope.selectedIndex_batch-1 >= 0){
				$rootScope.selectedIndex_batch--;
			}else{
				$rootScope.selectedIndex_batch = $rootScope.suggestions_batch.length-1;
			}
		}
		else if(event.keyCode === 13){ //enter key, empty suggestions array
			$rootScope.AssignValueAndHide_batch($rootScope.selectedIndex_batch);
			//console.log($rootScope.selectedIndex);
			event.preventDefault();			
			$rootScope.suggestions_batch = [];
			$rootScope.searchItems=[];		
			$rootScope.selectedIndex_batch = -1;
		}
		else if(event.keyCode === 9){ //enter tab key
			//console.log($rootScope.selectedIndex);
			if($rootScope.selectedIndex_batch>-1){
				$rootScope.AssignValueAndHide_batch($rootScope.selectedIndex_batch);
			}			

		}else if(event.keyCode === 27){ //ESC key, empty suggestions array
			$rootScope.AssignValueAndHide_batch($rootScope.selectedIndex_batch);			
			event.preventDefault();
			$rootScope.suggestions_batch = [];
			$rootScope.searchItems=[];		
			$rootScope.selectedIndex_batch = -1;
		}else{
			$rootScope.search_batch();	
		}
	};
	
	//ClickOutSide
	var exclude1 = document.getElementById($rootScope.batchno);
	$rootScope.hideMenu = function($event){
		$rootScope.search();
		//make a condition for every object you wat to exclude
		if($event.target !== exclude1) {
			$rootScope.searchItems=[];
			$rootScope.suggestions_batch = [];			
			$rootScope.selectedIndex_batch = -1;
		}
	};
	//======================================
	
	//Function To Call on ng-keyup
	$rootScope.checkKeyUp_batch = function(event){ 
		if(event.keyCode !== 8 || event.keyCode !== 46){//delete or backspace
			if($scope[$rootScope.searchelement] === ""){
				$rootScope.suggestions_batch = [];
				$rootScope.searchItems=[];			
				$rootScope.selectedIndex_batch = -1;
			}
		}
	};
	//======================================
	//List Item Events
	//Function To Call on ng-click
	$rootScope.AssignValueAndHide_batch = function(index)
	{

	$scope[$rootScope.searchelement]= $rootScope.suggestions_batch[index].batchno;
		//console.log($rootScope.suggestions_batch[index].exp_monyr);
	
		
	$scope['PURCHASEID']=$rootScope.suggestions_batch[index].PURCHASEID;  
	$scope['exp_monyr']=$rootScope.suggestions_batch[index].exp_monyr;  
	$scope['mfg_monyr']=$rootScope.suggestions_batch[index].mfg_monyr; 
	//$scope['rate']=$rootScope.suggestions_batch[index].rate; 
	$scope['rate']=$rootScope.suggestions_batch[index].srate; 
	$scope['srate']=$rootScope.suggestions_batch[index].srate; 
	$scope['mrp']=$rootScope.suggestions_batch[index].mrp; 
	$scope['ptr']=$rootScope.suggestions_batch[index].ptr; 
	$scope['AVAILABLE_QTY']=$rootScope.suggestions_batch[index].AVAILABLE_QTY; 
	
	$rootScope.suggestions_batch=[];
		 $rootScope.searchItems=[];		
		 $rootScope.selectedIndex = -1;
	};
	//===================END batch SEARCH SECTION =========================================


	$scope.savedata=function()
	{
		console.log('PURCHASEID'+$scope.PURCHASEID+
	    '$scope.RELATED_TO_MIXER'+$scope.RELATED_TO_MIXER+
	    '$scope.product_id'+$scope.product_id);
		
		
		var data_link=BaseUrl+"SAVE";
		var success={};		
		var data_save = {
			'id_header': $scope.get_set_value($scope.id_header,'num','SETVALUE'),
			'id_detail': $scope.get_set_value($scope.id_detail,'num','SETVALUE'),
			'doctor_ledger_id': $scope.get_set_value($scope.doctor_ledger_id,'num','SETVALUE'),
			'product_id': $scope.get_set_value($scope.product_id,'num','SETVALUE'),
			'MIX_RAW_LINK_ID': $scope.get_set_value($scope.MIX_RAW_LINK_ID,'num','SETVALUE'),
			'RELATED_TO_MIXER': $scope.get_set_value($scope.RELATED_TO_MIXER,'str','SETVALUE'),	
			'product_name_mixture': $scope.get_set_value($scope.product_name_mixture,'str','SETVALUE'),
			'batchno_mixture': $scope.get_set_value($scope.batchno_mixture,'str','SETVALUE'),
			'qnty_mixture': $scope.get_set_value($scope.qnty_mixture,'num','SETVALUE'),
			'rate_mixture': $scope.get_set_value($scope.rate_mixture,'num','SETVALUE'),
			'mfg_monyr_mixture': $scope.get_set_value($scope.mfg_monyr_mixture,'str','SETVALUE'),
			'exp_monyr_mixture': $scope.get_set_value($scope.exp_monyr_mixture,'str','SETVALUE'),		
			'tbl_party_id': $scope.get_set_value($scope.tbl_party_id,'num','SETVALUE'),
			'invoice_date': $scope.get_set_value($scope.invoice_date,'str','SETVALUE'),
			'challan_no': $scope.get_set_value($scope.challan_no,'str','SETVALUE'),
			'challan_date': $scope.get_set_value($scope.challan_date,'str','SETVALUE'),
			'tbl_party_id_name': $scope.get_set_value($scope.tbl_party_id_name,'str','SETVALUE'),
			'comment': $scope.get_set_value($scope.comment,'str','SETVALUE'),
			'product_id_name': $scope.get_set_value($scope.product_id_name,'str','SETVALUE'),
			'batchno': $scope.get_set_value($scope.batchno,'str','SETVALUE'),
			'qnty': $scope.get_set_value($scope.qnty,'num','SETVALUE'),
			'exp_monyr': $scope.get_set_value($scope.exp_monyr,'str','SETVALUE'),
			'mfg_monyr': $scope.get_set_value($scope.mfg_monyr,'str','SETVALUE'),
			'rate': $scope.get_set_value($scope.rate,'num','SETVALUE'),
			'mrp': $scope.get_set_value($scope.mrp,'num','SETVALUE'),
			'ptr': $scope.get_set_value($scope.ptr,'num','SETVALUE'),
			'srate': $scope.get_set_value($scope.srate,'num','SETVALUE'),
			'tax_per': $scope.get_set_value($scope.tax_per,'num','SETVALUE'),	
			'disc_per': $scope.get_set_value($scope.disc_per,'num','SETVALUE'),	
			'tax_ledger_id': $scope.get_set_value($scope.tax_ledger_id,'num','SETVALUE'),
			'PURCHASEID': $scope.get_set_value($scope.PURCHASEID,'num','SETVALUE'),
			'Synonym': $scope.get_set_value($scope.Synonym,'num','SETVALUE'),
			'label_print': $scope.get_set_value($scope.label_print,'num','SETVALUE'),
			'disc_per2': $scope.get_set_value($scope.disc_per2,'num','SETVALUE'),
			'tot_cash_discount': $scope.get_set_value($scope.tot_cash_discount,'num','SETVALUE')
											
		};	
	
		var config = {headers : 
			{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
		}
		//$http.post(data_link, data,config)
		$http.post(data_link,data_save,config)
		.then (function success(response){
			console.log('ID HEADER '+response.data.id_header);
			$scope.get_set_value(response.data,'','REFRESH');
			document.getElementById('product_id_name').focus();
		},
		function error(response){
			$scope.errorMessage = 'Error adding user!';
			$scope.message = '';
	  });

	}
	


	$scope.get_set_value=
	function(datavalue,datatype,operation)
	{
		if(operation=='SETVALUE')
		{
			if(angular.isUndefined(datavalue)==true)
			{
				if(datatype=='num')
				{return 0;}
				if(datatype=='str')
				{return '';}		
			}
			else
			{return datavalue;}
		}
		if(operation=='DRCRCHECKING')
		{
			var savestatus='OK';
						
			if($scope.invoice_date == null || $scope.invoice_date === "")			
			{
			savestatus='NOTOK';$scope.savemsg='ENTER INVOICE DATE';
			document.getElementById('invoice_date').focus();
			}
			if($scope.tbl_party_id == '0')			
			{
			savestatus='NOTOK';$scope.savemsg='ENTER PARTY';
			document.getElementById('tbl_party_id_name').focus();
			}

			if($scope.product_id == '0')			
			{
			savestatus='NOTOK';$scope.savemsg='ENTER PRODUCT';
			document.getElementById('product_id_name').focus();
			}
		
			if(savestatus=='OK')
			{
			
				$scope.product_name_mixture='NA';
				$scope.batchno_mixture='NA';
				$scope.qnty_mixture=0;
				$scope.rate_mixture=0;
				$scope.mfg_monyr_mixture='NA';
				$scope.exp_monyr_mixture='NA';
				$scope.MIX_RAW_LINK_ID=0;
				$scope.RELATED_TO_MIXER='NO';
				$scope.savedata();
				$scope.savemsg='Receord Has been saved Successfully!';
			}
		}

		if(operation=='ADDMIXTURE')
		{
			var savestatus='OK';
									
			if($scope.product_id == '0')			
			{
			savestatus='NOTOK';$scope.savemsg='ENTER PRODUCT';
			document.getElementById('product_id_name').focus();
			}

			if($scope.invoice_date == null || $scope.invoice_date === "")			
			{
			savestatus='NOTOK';$scope.savemsg='ENTER INVOICE DATE';
			document.getElementById('invoice_date').focus();
			}

			if($scope.tbl_party_id == '0')			
			{
			savestatus='NOTOK';$scope.savemsg='ENTER PARTY';
			document.getElementById('tbl_party_id_name').focus();
			}
		
			if(savestatus=='OK')
			{
				//$scope.savedata_mixture();
				$scope.RELATED_TO_MIXER='YES';
				$scope.savedata();					
				$scope.savemsg='Receord Has been saved Successfully!';
			}
		}

		if(operation=='RESET_MIXER_PAGE')
		{
			$scope.id_detail='';
			$scope.MIX_RAW_LINK_ID='';
		}

		
		if(operation=='REFRESH')
		{		
			//HEADER SECTION

			$scope.id_header=datavalue.id_header;
		  	//console.log('After save id_header :'+$scope.id_header)
			$scope.invoice_no=datavalue.invoice_no;
			$scope.invoice_date=datavalue.invoice_date;
			$scope.challan_no=datavalue.challan_no;
			$scope.challan_date=datavalue.challan_date;
			$scope.tbl_party_id_name=datavalue.tbl_party_id_name;
			$scope.tbl_party_id=datavalue.tbl_party_id;
			$scope.comment=datavalue.comment;
			$scope.MIX_RAW_LINK_ID=datavalue.MIX_RAW_LINK_ID;

			
			//DETAIL SECTION
			$scope.id_detail='';	
			$scope.product_id_name='';			
			$scope.product_id=$scope.batchno=$scope.qnty='';
			$scope.exp_monyr=$scope.mfg_monyr=$scope.rate='';
			$scope.mrp=$scope.ptr=$scope.srate=$scope.tax_per='';
			$scope.tax_ledger_id=$scope.disc_per='';
			$scope.product_id_name_mixer=$scope.disc_per2=$scope.Synonym=$scope.label_print='';
			

			//data list
			 var data_link=BaseUrl+"DTLLIST/"+$scope.id_header;
			 console.log(data_link);
			 $http.get(data_link).then(function(response) 
			 {$scope.listOfDetails=response.data;});

			 var data_link=BaseUrl+"DTLLISTMIX/"+$scope.MIX_RAW_LINK_ID;
			 console.log(data_link);
			$http.get(data_link).then(function(response) 
			{$scope.listOfDetails_mix=response.data;});
			
			$scope.VIEWALLVALUE($scope.id_header);

			//$scope.consignment_value();
			//$scope.GetAllConsignment($scope.startdate,$scope.enddate);

		}
		if(operation=='NEWENTRY')
		{		
			
			//HEADER SECTION
			$scope.id_header='';
			$scope.invoice_no='';
			$scope.invoice_date='';
			$scope.challan_no='';
			$scope.challan_date='';
			$scope.tbl_party_id_name='';
			$scope.tbl_party_id='';
			$scope.comment=$scope.comment='';
			
			//DETAIL SECTION
			$scope.id_detail='';	
			$scope.product_id_name='';			
			$scope.product_id=$scope.batchno=$scope.qnty='';
			$scope.exp_monyr=$scope.mfg_monyr=$scope.rate='';
			$scope.mrp=$scope.ptr=$scope.srate=$scope.tax_per='';
			$scope.tax_ledger_id=$scope.disc_per='';
			$scope.disc_per2=$scope.Synonym=$scope.label_print='';
			//data list
			 var data_link=BaseUrl+"DTLLIST/"+0;
			 $http.get(data_link).then(function(response) 
			 {$scope.listOfDetails=response.data;});

			 document.getElementById('invoice_date').focus();
		}

		if(operation=='VIEWDTL')
		{	
			var data_link=BaseUrl+"VIEWDTL/"+datavalue;
			$http.get(data_link).then(function(response) 
			{
				angular.forEach(response.data,function(value,key){
					$scope['id_detail']=value.id;  
					$scope['product_id_name']=value.product_id_name;  
					$scope['product_id_name_mixer']=value.product_id_name;  					
					$scope['product_id']=value.product_id;  					
					$scope['batchno']=value.batchno;  
					$scope['qnty']=value.qnty;  
					$scope['exp_monyr']=value.exp_monyr;  
					$scope['mfg_monyr']=value.mfg_monyr; 
					$scope['rate']=value.rate;
					$scope['mrp']=value.mrp;	
					$scope['ptr']=value.ptr;
					$scope['srate']=value.srate;
					$scope['tax_per']=value.tax_per;
					$scope['tax_ledger_id']=value.tax_ledger_id;
					$scope['disc_per']=value.disc_per;

					$scope['disc_per2']=value.disc_per;
					$scope['Synonym']=value.Synonym;
					$scope['label_print']=value.label_print;
				
				});			
				
			});
				
		}

		if(operation=='VIEWDTLMIX')
		{	
			
			$scope['product_id_name']='';  
			$scope['product_id_name_mixer']='';  					
			$scope['product_id']='0';   					
			$scope['batchno']='';  
			$scope['qnty']=='';  
			$scope['exp_monyr']='';  
			$scope['mfg_monyr']='';  
			$scope['rate']='';  
			$scope['mrp']='';  	
			$scope['ptr']='';  
			$scope['srate']='';  
			$scope['tax_per']='';  
			$scope['tax_ledger_id']='';  
			$scope['disc_per']='';  
			$scope['id_detail']='';

			var data_link=BaseUrl+"DTLLISTMIX/"+datavalue;
			$http.get(data_link).then(function(response) 
			{$scope.listOfDetails_mix=response.data;});
			
			var data_link=BaseUrl+"VIEWDTL/"+datavalue;
			console.log(data_link);
			$http.get(data_link).then(function(response) 
			{
				angular.forEach(response.data,function(value,key){
					//$scope['id_detail']=value.id;  
					$scope['product_name_mixture']=value.product_id_name; 
					$scope['batchno_mixture']=value.batchno;  
					$scope['qnty_mixture']=value.qnty;  
					$scope['rate_mixture']=value.rate;
					$scope['exp_monyr_mixture']=value.exp_monyr;  
					$scope['mfg_monyr_mixture']=value.mfg_monyr; 
					$scope['MIX_RAW_LINK_ID']=value.id; 
				});			
				
			});
		}

		

		if(operation=='VIEWALLVALUE')
		{	
			var data_link=BaseUrl+"DTLLIST/"+datavalue;
			$http.get(data_link).then(function(response) 
			{$scope.listOfDetails=response.data;});

			$scope.VIEWALLVALUE(datavalue);
	
		}

	}

	$scope.VIEWALLVALUE=function(invoice_id)
	{

		var data_link=BaseUrl+"VIEWALLVALUE/"+invoice_id;
			console.log(data_link);
			$http.get(data_link).then(function(response) 
			{
				angular.forEach(response.data,function(value,key){

					$scope['id_header']=value.id_header;  					
					$scope['invoice_no']=value.invoice_no;  
					$scope['invoice_date']=value.invoice_date;  
					$scope['challan_no']=value.challan_no;  
					$scope['challan_date']=value.challan_date;  
					$scope['tbl_party_id_name']=value.tbl_party_id_name;  
					$scope['tbl_party_id']=value.tbl_party_id;								
					$scope['comment']=value.comment;
					$scope['tot_cash_discount']=value.tot_cash_discount;
					$scope['total_amt']=value.total_amt;  
					$scope['tot_discount']=value.tot_discount;	
					$scope['tot_taxable_amt']=$scope['total_amt']-$scope['tot_discount'];								
					$scope['totvatamt']=value.totvatamt;
					$scope['grandtot']=value.grandtot;
				});	
				
			});		

	}

	
	$scope.barcode_value=function(barcodefrom,event){

		if(event.keyCode === 13){

			if(barcodefrom=='barcode')
			{	
				var str=$scope.barcode;
				var strid =str.split("|");
			}
			if(barcodefrom=='barcodemix')
			{	
				var str=$scope.barcodemix;
				var strid =str.split("|");
			}
			if(barcodefrom=='billbarcode')
			{	
				var str=$scope.billbarcode;
				var strid =str.split("|");			
				$scope.get_set_value(strid[0],'','VIEWALLVALUE')		
			}

			$scope.barcodemix=$scope.barcode=$scope.billbarcode='';

			if(barcodefrom=='barcode' || barcodefrom=='barcodemix')
			{
				var data_link=BaseUrl+"VIEWDTL/"+strid[0];
				console.log(data_link);
				$http.get(data_link).then(function(response) 
				{
						angular.forEach(response.data,function(value,key){
						$scope['id_detail']=value.id;  
						$scope['product_id_name']=value.product_id_name;  
						$scope['product_id_name_mixer']=value.product_id_name;  					
						$scope['product_id']=value.product_id;  					
						$scope['batchno']=value.batchno;  
						$scope['qnty']=value.qnty;  
						$scope['exp_monyr']=value.exp_monyr;  
						$scope['mfg_monyr']=value.mfg_monyr; 
						$scope['rate']=value.srate;
						$scope['mrp']=value.mrp;	
						$scope['ptr']=value.ptr;
						$scope['srate']=value.srate;
						$scope['tax_per']=value.tax_per;
						$scope['tax_ledger_id']=value.tax_ledger_id;
						$scope['disc_per']=value.disc_per;
					
					});			
					
				});
			}

			if(barcodefrom=='billbarcode')
			{
				var data_link=BaseUrl+"DTLLIST/"+strid[0];
				$http.get(data_link).then(function(response) 
				{$scope.listOfDetails=response.data;});

				var data_link=BaseUrl+"VIEWALLVALUE/"+strid[0];
				console.log(data_link);
				$http.get(data_link).then(function(response) 
				{
					angular.forEach(response.data,function(value,key){

						$scope['id_header']=value.id_header;  					
						$scope['invoice_no']=value.invoice_no;  
						$scope['invoice_date']=value.invoice_date;  
						$scope['challan_no']=value.challan_no;  
						$scope['challan_date']=value.challan_date;  
						$scope['tbl_party_id_name']=value.tbl_party_id_name;  
						$scope['tbl_party_id']=value.tbl_party_id;							
						$scope['doctor_ledger_id_name']=value.doctor_ledger_id_name;  
						$scope['doctor_ledger_id']=value.doctor_ledger_id;	
						$scope['comment']=value.comment;
					});	
					
				});		

			}

		}

	};

	$scope.GetAllList=function(fromdate,todate){
			//var BaseUrl=domain_name+"Primary_sale_controller/ConsignmentList/";
			//data list GetAllConsignment			
			var data_link=BaseUrl+'GetAllList/PAYMENT/-/-/'+fromdate+'/'+todate;
			console.log(data_link);
			$http.get(data_link).then(function(response) 
			{
				$scope.ListOfTransactions=response.data;
			});
	};
	
	$scope.print_invoice = function(printtype) 
	{ 
		var data_link=BaseUrl+"print_invoice/"+$scope.id_header+'/'+printtype;
		window.popup(data_link); 
		
	};


	$scope.print_label = function(id_header,PRINTTYPE) 
	{ 
		var BaseUrl=domain_name+"Project_controller/print_all/";
		var data_link=BaseUrl+id_header+'/'+PRINTTYPE;
		window.popup(data_link); 
	};


  
  

}]);
//************************ACCOUNT SALE END*****************************************//


//************************ACCOUNT PURCHASE RETURN START*****************************************//
app.controller('purchase_rtn',['$scope','$rootScope','$http','purchase_rtn',
function($scope,$rootScope,$http,purchase_rtn,userPersistenceService){
	"use strict";

	//$scope.appState='EMIPAYMENT';
	//var domain_name="http://localhost/abir_das_unitedlab/SATNAM/";	
	var BaseUrl=domain_name+"Accounts_controller/AccountsTransactions/purchase_rtn/";
		$scope.tran_date=$rootScope.tran_date;

		$rootScope.search = function(searchelement){
		
		$scope.SEARCHTYPE='PRODUCT';
		$rootScope.searchelement=searchelement;
		$rootScope.suggestions = [];
		$rootScope.searchItems=[];
		//console.log($rootScope.searchelement);
		
		if($rootScope.searchelement=='product_id_name')
		{purchase_rtn.list_items($rootScope.searchelement,$scope.trantype);}

		else
		
		purchase_rtn.list_items($rootScope.searchelement,$scope.trantype);


		$rootScope.searchItems.sort();	
		var myMaxSuggestionListLength = 0;
		for(var i=0; i<$rootScope.searchItems.length; i++){
			var searchItemsSmallLetters = angular.uppercase($rootScope.searchItems[i]);
			var searchTextSmallLetters = angular.uppercase($scope[$rootScope.searchelement]);
			if( searchItemsSmallLetters.indexOf(searchTextSmallLetters) !== -1){
				$rootScope.suggestions.push(searchItemsSmallLetters);
				myMaxSuggestionListLength += 1;
				if(myMaxSuggestionListLength === 400){
					break;
				}
			}
		}
	};
	
	$rootScope.$watch('selectedIndex',function(val){		
		if(val !== -1) {
			$scope[$rootScope.searchelement] =
			$rootScope.suggestions[$rootScope.selectedIndex];
		}
	});		
	$rootScope.checkKeyDown = function(event){
		console.log(event.keyCode);

		if(event.keyCode === 40){//down key, increment selectedIndex
			event.preventDefault();
			if($rootScope.selectedIndex+1 < $rootScope.suggestions.length){
				$rootScope.selectedIndex++;
			}else{
				$rootScope.selectedIndex = 0;
			}
		}else if(event.keyCode === 38){ //up key, decrement selectedIndex
			event.preventDefault();
			if($rootScope.selectedIndex-1 >= 0){
				$rootScope.selectedIndex--;
			}else{
				$rootScope.selectedIndex = $rootScope.suggestions.length-1;
			}
		}
		else if(event.keyCode === 13){ //enter key, empty suggestions array
			$rootScope.AssignValueAndHide($rootScope.selectedIndex);
			//console.log($rootScope.selectedIndex);
			event.preventDefault();			
			$rootScope.suggestions = [];
			$rootScope.searchItems=[];
			$rootScope.selectedIndex = -1;
		}
		else if(event.keyCode === 9){ //enter tab key
			//console.log($rootScope.selectedIndex);
			if($rootScope.selectedIndex>-1){
				$rootScope.AssignValueAndHide($rootScope.selectedIndex);
			}			

		}else if(event.keyCode === 27){ //ESC key, empty suggestions array
			$rootScope.AssignValueAndHide($rootScope.selectedIndex);
			console.log($rootScope.selectedIndex);
			event.preventDefault();
			$rootScope.suggestions = [];
			$rootScope.searchItems=[];
			$rootScope.selectedIndex = -1;
		}else{
			$rootScope.search();	
		}
	};
	
	//ClickOutSide
	var exclude1 = document.getElementById($rootScope.searchelement);
	$rootScope.hideMenu = function($event){
		$rootScope.search();
		//make a condition for every object you wat to exclude
		if($event.target !== exclude1) {
			$rootScope.searchItems=[];
			$rootScope.suggestions = [];
			$rootScope.selectedIndex = -1;
		}
	};
	//======================================
	
	//Function To Call on ng-keyup
	$rootScope.checkKeyUp = function(event){ 
		if(event.keyCode !== 8 || event.keyCode !== 46){//delete or backspace
			if($scope[$rootScope.searchelement] === ""){
				$rootScope.suggestions = [];
				$rootScope.searchItems=[];
				$rootScope.selectedIndex = -1;
			}
		}
	};
	//======================================
	//List Item Events
	//Function To Call on ng-click
	$rootScope.AssignValueAndHide = function(index){
	$scope[$rootScope.searchelement]= $rootScope.suggestions[index];

		if($rootScope.searchelement=='tbl_party_id_name')
		{
			var str=$scope.tbl_party_id_name;
			var id=str.substring(str.lastIndexOf("#")+1,str.lastIndexOf(")"));	
			var data_link=BaseUrl+"tbl_party_id/"+id;					
			//console.log(data_link);					
			$http.get(data_link).then(function(response){
				angular.forEach(response.data,function(value,key){
					$scope['tbl_party_id']=value.id;  //ACTUAL ID
					$scope['tbl_party_id_name']=value.name; // NAME 					
				});
			});
		}
		if($rootScope.searchelement=='product_id_name')
		{
			var str=$scope.product_id_name;
			var id=str.substring(str.lastIndexOf("#")+1,str.lastIndexOf(")"));	
			var data_link=BaseUrl+"product_id/"+id;					
			//console.log(data_link);					
			$http.get(data_link).then(function(response){
				angular.forEach(response.data,function(value,key){
					$scope['product_id']=value.id;  //ACTUAL ID
					$scope['product_id_name']=value.name; // NAME 	
					$scope['tax_ledger_id']=value.tax_ledger_id; // NAME 	
					$scope['tax_per']=value.tax_per; // NAME 															
				});
			});
		}
			
		 $rootScope.suggestions=[];
		 $rootScope.searchItems=[];
		 $rootScope.selectedIndex = -1;
	};
	//===================END SEARCH SECTION =========================================

	//=========batch wise search=====================

	$rootScope.search_batch = function(searchelement){	
		$scope.SEARCHTYPE='BATCH';		
		$rootScope.searchelement=searchelement;
		$rootScope.suggestions_batch = [];
		$rootScope.searchItems=[];

		var data_link=BaseUrl+"batchno/"+$scope.product_id;
		console.log(data_link);			
		$http.get(data_link)
		.then(function(response) {
		$rootScope.suggestions_batch=response.data	;
		});			

	};
	
	$rootScope.$watch('selectedIndex_batch',function(val){		
		if(val !== -1) {	
			$scope['batchno'] =
			$rootScope.suggestions_batch[$rootScope.selectedIndex_batch].batchno;		
		}
	});		

	$rootScope.checkKeyDown_batch = function(event){
		if(event.keyCode === 40){//down key, increment selectedIndex
			event.preventDefault();
			if($rootScope.selectedIndex_batch+1 < $rootScope.suggestions_batch.length){
				$rootScope.selectedIndex_batch++;
			}else{
				$rootScope.selectedIndex_batch = 0;
			}
		
		}else if(event.keyCode === 38){ //up key, decrement selectedIndex
			event.preventDefault();
			if($rootScope.selectedIndex_batch-1 >= 0){
				$rootScope.selectedIndex_batch--;
			}else{
				$rootScope.selectedIndex_batch = $rootScope.suggestions_batch.length-1;
			}
		}
		else if(event.keyCode === 13){ //enter key, empty suggestions array
			$rootScope.AssignValueAndHide_batch($rootScope.selectedIndex_batch);
			//console.log($rootScope.selectedIndex);
			event.preventDefault();			
			$rootScope.suggestions_batch = [];
			$rootScope.searchItems=[];		
			$rootScope.selectedIndex_batch = -1;
		}
		else if(event.keyCode === 9){ //enter tab key
			//console.log($rootScope.selectedIndex);
			if($rootScope.selectedIndex_batch>-1){
				$rootScope.AssignValueAndHide_batch($rootScope.selectedIndex_batch);
			}			

		}else if(event.keyCode === 27){ //ESC key, empty suggestions array
			$rootScope.AssignValueAndHide_batch($rootScope.selectedIndex_batch);			
			event.preventDefault();
			$rootScope.suggestions_batch = [];
			$rootScope.searchItems=[];		
			$rootScope.selectedIndex_batch = -1;
		}else{
			$rootScope.search_batch();	
		}
	};
	
	//ClickOutSide
	var exclude1 = document.getElementById($rootScope.batchno);
	$rootScope.hideMenu = function($event){
		$rootScope.search();
		//make a condition for every object you wat to exclude
		if($event.target !== exclude1) {
			$rootScope.searchItems=[];
			$rootScope.suggestions_batch = [];			
			$rootScope.selectedIndex_batch = -1;
		}
	};
	//======================================
	
	//Function To Call on ng-keyup
	$rootScope.checkKeyUp_batch = function(event){ 
		if(event.keyCode !== 8 || event.keyCode !== 46){//delete or backspace
			if($scope[$rootScope.searchelement] === ""){
				$rootScope.suggestions_batch = [];
				$rootScope.searchItems=[];			
				$rootScope.selectedIndex_batch = -1;
			}
		}
	};
	//======================================
	//List Item Events
	//Function To Call on ng-click
	$rootScope.AssignValueAndHide_batch = function(index)
	{

	$scope[$rootScope.searchelement]= $rootScope.suggestions_batch[index].batchno;
		//console.log($rootScope.suggestions_batch[index].exp_monyr);
		
	$scope['exp_monyr']=$rootScope.suggestions_batch[index].exp_monyr;  
	$scope['mfg_monyr']=$rootScope.suggestions_batch[index].mfg_monyr; 
	$scope['rackno']=$rootScope.suggestions_batch[index].rackno; 
	$scope['rate']=$rootScope.suggestions_batch[index].rate; 
	$scope['srate']=$rootScope.suggestions_batch[index].srate; 
	$scope['mrp']=$rootScope.suggestions_batch[index].mrp; 
	$scope['ptr']=$rootScope.suggestions_batch[index].ptr; 
	$scope['AVAILABLE_QTY']=$rootScope.suggestions_batch[index].AVAILABLE_QTY; 
	
	$rootScope.suggestions_batch=[];
		 $rootScope.searchItems=[];		
		 $rootScope.selectedIndex = -1;
	};
	//===================END batch SEARCH SECTION =========================================






	$scope.savedata=function(){
		var data_link=BaseUrl+"SAVE";
		var success={};
		console.log('$scope.id_detail'+$scope.id_detail)
		var data_save = {
			'id_header': $scope.get_set_value($scope.id_header,'num','SETVALUE'),
			'id_detail': $scope.get_set_value($scope.id_detail,'num','SETVALUE'),
			'product_id': $scope.get_set_value($scope.product_id,'num','SETVALUE'),
			'tbl_party_id': $scope.get_set_value($scope.tbl_party_id,'num','SETVALUE'),
			'invoice_date': $scope.get_set_value($scope.invoice_date,'str','SETVALUE'),
			'challan_no': $scope.get_set_value($scope.challan_no,'str','SETVALUE'),
			'challan_date': $scope.get_set_value($scope.challan_date,'str','SETVALUE'),
			'tbl_party_id_name': $scope.get_set_value($scope.tbl_party_id_name,'str','SETVALUE'),
			'comment': $scope.get_set_value($scope.comment,'str','SETVALUE'),
			'product_id_name': $scope.get_set_value($scope.product_id_name,'str','SETVALUE'),
			'batchno': $scope.get_set_value($scope.batchno,'str','SETVALUE'),
			'qnty': $scope.get_set_value($scope.qnty,'num','SETVALUE'),
			'exp_monyr': $scope.get_set_value($scope.exp_monyr,'str','SETVALUE'),
			'mfg_monyr': $scope.get_set_value($scope.mfg_monyr,'str','SETVALUE'),
			'rate': $scope.get_set_value($scope.rate,'num','SETVALUE'),
			'mrp': $scope.get_set_value($scope.mrp,'num','SETVALUE'),
			'ptr': $scope.get_set_value($scope.ptr,'num','SETVALUE'),
			'srate': $scope.get_set_value($scope.srate,'num','SETVALUE'),
			'tax_per': $scope.get_set_value($scope.tax_per,'num','SETVALUE'),	
			'disc_per': $scope.get_set_value($scope.disc_per,'num','SETVALUE'),	
			'tax_ledger_id': $scope.get_set_value($scope.tax_ledger_id,'num','SETVALUE'),
			'disc_per2': $scope.get_set_value($scope.disc_per2,'num','SETVALUE'),
			'tot_cash_discount': $scope.get_set_value($scope.tot_cash_discount,'num','SETVALUE'),
			'rackno': $scope.get_set_value($scope.rackno,'num','SETVALUE')
		};	
	
		var config = {headers : 
			{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
		}
		//$http.post(data_link, data,config)
		$http.post(data_link,data_save,config)
		.then (function success(response){
			console.log('ID HEADER '+response.data.id_header);
			$scope.get_set_value(response.data,'','REFRESH');
			document.getElementById('product_id_name').focus();
		},
		function error(response){
			$scope.errorMessage = 'Error adding user!';
			$scope.message = '';
	  });

	}
	
	$scope.get_set_value=
	function(datavalue,datatype,operation)
	{
		if(operation=='SETVALUE')
		{
			if(angular.isUndefined(datavalue)==true)
			{
				if(datatype=='num')
				{return 0;}
				if(datatype=='str')
				{return '';}		
			}
			else
			{return datavalue;}
		}
		if(operation=='DRCRCHECKING')
		{
			var savestatus='OK';
						
			if($scope.invoice_date == null || $scope.invoice_date === "")			
			{
			savestatus='NOTOK';$scope.savemsg='ENTER INVOICE DATE';
			document.getElementById('invoice_date').focus();
			}
			if($scope.tbl_party_id == '0')			
			{
			savestatus='NOTOK';$scope.savemsg='ENTER PARTY';
			document.getElementById('tbl_party_id_name').focus();
			}

			if($scope.product_id == '0')			
			{
			savestatus='NOTOK';$scope.savemsg='ENTER PRODUCT';
			document.getElementById('product_id_name').focus();
			}
		
			if(savestatus=='OK')
			{
				$scope.savedata();
				$scope.savemsg='Receord Has been saved Successfully!';
			}
		}
		if(operation=='REFRESH')
		{		
			//HEADER SECTION
			$scope.id_header=datavalue.id_header;
			$scope.invoice_no=datavalue.invoice_no;
			$scope.invoice_date=datavalue.invoice_date;
			$scope.challan_no=datavalue.challan_no;
			$scope.challan_date=datavalue.challan_date;
			$scope.tbl_party_id_name=datavalue.tbl_party_id_name;
			$scope.tbl_party_id=datavalue.tbl_party_id;
			$scope.comment=datavalue.comment;

			//DETAIL SECTION
			$scope.id_detail='';	
			$scope.product_id_name='';			
			$scope.product_id=$scope.batchno=$scope.qnty='';
			$scope.exp_monyr=$scope.mfg_monyr=$scope.rate='';
			$scope.mrp=$scope.ptr=$scope.srate=$scope.tax_per='';
			$scope.tax_ledger_id=$scope.disc_per='';
			$scope.disc_per2=$scope.rackno='';

			//data list
			 var data_link=BaseUrl+"DTLLIST/"+$scope.id_header;
			 $http.get(data_link).then(function(response) 
			 {$scope.listOfDetails=response.data;});
			
			//$scope.consignment_value();
			//$scope.GetAllConsignment($scope.startdate,$scope.enddate);

		}
		if(operation=='NEWENTRY')
		{		
			
			//HEADER SECTION
			$scope.id_header='';
			$scope.invoice_no='';
			$scope.invoice_date='';
			$scope.challan_no='';
			$scope.challan_date='';
			$scope.tbl_party_id_name='';
			$scope.tbl_party_id='';
			$scope.comment='';
			
			//DETAIL SECTION
			$scope.id_detail='';	
			$scope.product_id_name='';			
			$scope.product_id=$scope.batchno=$scope.qnty='';
			$scope.exp_monyr=$scope.mfg_monyr=$scope.rate='';
			$scope.mrp=$scope.ptr=$scope.srate=$scope.tax_per='';
			$scope.tax_ledger_id=$scope.disc_per='';
			$scope.disc_per2=$scope.rackno=$scope.tot_cash_discount='';

			//data list
			 var data_link=BaseUrl+"DTLLIST/"+0;
			 $http.get(data_link).then(function(response) 
			 {$scope.listOfDetails=response.data;});

			 document.getElementById('invoice_date').focus();
		}
		if(operation=='VIEWDTL')
		{	
			var data_link=BaseUrl+"VIEWDTL/"+datavalue;
			console.log(data_link);
			$http.get(data_link).then(function(response) 
			{
				angular.forEach(response.data,function(value,key){
					$scope['id_detail']=value.id;  
					$scope['product_id_name']=value.product_id_name;  
					$scope['product_id']=value.product_id;  					
					$scope['batchno']=value.batchno;  
					$scope['qnty']=value.qnty;  
					$scope['exp_monyr']=value.exp_monyr;  
					$scope['mfg_monyr']=value.mfg_monyr; 
					$scope['rate']=value.rate;
					$scope['mrp']=value.mrp;	
					$scope['ptr']=value.ptr;
					$scope['srate']=value.srate;
					$scope['tax_per']=value.tax_per;
					$scope['tax_ledger_id']=value.tax_ledger_id;
					$scope['disc_per']=value.disc_per;
					$scope['disc_per2']=value.disc_per2;
					$scope['rackno']=value.rackno;
				});			
				
			});
		}

		if(operation=='VIEWALLVALUE')
		{	
			var data_link=BaseUrl+"DTLLIST/"+datavalue;
			$http.get(data_link).then(function(response) 
			{$scope.listOfDetails=response.data;});

			var data_link=BaseUrl+"VIEWALLVALUE/"+datavalue;
			console.log(data_link);
			$http.get(data_link).then(function(response) 
			{
				angular.forEach(response.data,function(value,key){

					$scope['id_header']=value.id_header;  					
					$scope['invoice_no']=value.invoice_no;  
					$scope['invoice_date']=value.invoice_date;  
					$scope['challan_no']=value.challan_no;  
					$scope['challan_date']=value.challan_date;  
					$scope['tbl_party_id_name']=value.tbl_party_id_name;  
					$scope['tbl_party_id']=value.tbl_party_id;								
					$scope['comment']=value.comment;
					$scope['tot_cash_discount']=value.tot_cash_discount;
					
				});	
				
			});		
	
		}

	}
	
	$scope.GetAllList=function(fromdate,todate){
			//var BaseUrl=domain_name+"Primary_sale_controller/ConsignmentList/";
			//data list GetAllConsignment			
			var data_link=BaseUrl+'GetAllList/PAYMENT/-/-/'+fromdate+'/'+todate;
			console.log(data_link);
			$http.get(data_link).then(function(response) 
			{$scope.ListOfTransactions=response.data;});
	}
	
	$scope.print_barcode = function(id_header) 
	{ 
		var BaseUrl=domain_name+"Project_controller/print_all/";
		var data_link=BaseUrl+id_header;
		window.popup(data_link); 
	};

}]);

//************************ACCOUNT PURCHASE RETURN END*****************************************//





//************************ACCOUNT -RECEIVE,PAYMENT,JOURNAL,CONTRA START*****************************************//

app.directive('selectOnClick', ['$window', function ($window) {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            element.on('blur', function () {
                if (!$window.getSelection().toString()) {
                    // Required for mobile Safari
                    this.setSelectionRange(0, this.value.length)
                }
            });
        }
    };
}]);

app.filter('toRange', function(){
	return function(input) {
	  var lowBound, highBound;
	  if (input.length == 1) {       
		lowBound = 0;
		highBound = +input[0] - 1;      
	  } else if (input.length == 2) {      
		lowBound = +input[0];
		highBound = +input[1];
	  }
	  var i = lowBound;
	  var result = [];
	  while (i <= highBound) {
		result.push(i);
		i++;
	  }
	  return result;
	}
  });


  //************************ACCOUNT NEW RECEIVE  START*****************************************//
app.controller('AccountsTransaction',['$scope','$window','$rootScope','$http','$location','AccountsTransaction',
function($scope,$window,$rootScope,$http,$location,AccountsTransaction)
{
	"use strict";
	
	//var domain_name="http://localhost/abir_das_unitedlab/SATNAM/";	
	var BaseUrl=domain_name+"Accounts_controller/AccountsTransactions/";
	var AcTranType;
	var CRDR_TYPE;

	//CRDR_TYPE='CR';
	$scope.initarray=function(trantype){		
		BaseUrl=BaseUrl+trantype+'/';	
		AcTranType=trantype;
		if(AcTranType=='RECEIVE'){CRDR_TYPE='DR';}
		else
		{CRDR_TYPE='CR';}
	}
	console.log(BaseUrl);
	//ARRAY EXPERIMENT
	//$scope.FormInputArray={};
	$scope.accounts_id={};
	$scope.accounts_name={};
	$scope.accounts_amount={};
	$rootScope.FormInputArray=[];	
	document.getElementById('tran_date').focus();
	
	var CurrentDate=new Date();
	var year = CurrentDate.getFullYear();
	var month = CurrentDate.getMonth()+1;
	var dt = CurrentDate.getDate();
  
	if (dt < 10) {	dt = '0' + dt;}
	if (month < 10) {month = '0' + month;}
	$scope.fromdate=year+'-' + month + '-'+dt;
	$scope.todate=year+'-' + month + '-'+dt;
	
	//CALL GLOBAL FUNCTION
	//https://stackoverflow.com/questions/15025979/can-i-make-a-function-available-in-every-controller-in-angular

			$rootScope.FormInputArray[0] =
			{	
			id_header:'',
			id_detail:'',
			trantype:'',
			truck_id:'',
			truck_no:'',
			employee_id:'',
			employee_name:'',
			tran_code:'',	
			tran_date:$scope.todate,
			CRDR_TYPE:'CR',
			ledger_account_id:'',
			ledger_account_name:'',
			ledger_amount:'',				
			transaction_details:'',
			detailtype:'NA',//BANK,BILL/NA/TT_FUEL_EXP/TT_OTHER_EXP
			details:[{TABLE_NAME:'',TABLE_ID:'',BILL_INSTRUMENT_NO:'',EMPLOYEE_NAME:'',AMOUNT:'',CHQDATE:'',BANKNAME:'',BRANCH:''}]
		};
		
	$rootScope.FormInputArray[0].trantype=AcTranType;
	console.log('AcTranType '+AcTranType+$rootScope.FormInputArray[0].trantype);
	$rootScope.maxloopvalue=$rootScope.FormInputArray.length-1;

	//$rootScope.max_bill_count=$rootScope.FormInputArray[1]['billdetail'].length;	
	//console.log('BANK DETAILS '+$rootScope.FormInputArray[0]['bankdetail'][0].BRANCH);

	// console.log('BANK DETAILS '+$rootScope.FormInputArray[1]['bankdetail'][0].BRANCH);
	// console.log('arraindx billdetail '+
	// $rootScope.FormInputArray[0]['billdetail'][2]['testarray'][0].val);
	// console.log('$rootScope.max_bill_count '+$rootScope.max_bill_count);


	//https://stackoverflow.com/questions/18086865/angularjs-move-focus-to-next-control-on-enter

		$scope.mainOperation=function(event,element_name,index_value,child_index,searchItem,frmrpt_simple_query_builder_id)
		{	
					
			$rootScope.TotalDrAmt=0;
			$rootScope.TotalCrAmt=0;
			$rootScope.TotalBalanceAmt=0;
						
			if(searchItem=='searchItem')
			{$scope.search(element_name,index_value,child_index,$scope.FormInputArray[index_value].detailtype,frmrpt_simple_query_builder_id);}
			
			var CRDR_TYPE=angular.uppercase($scope.FormInputArray[index_value].CRDR_TYPE);

			if(CRDR_TYPE=='D' || CRDR_TYPE=='DR')
			{$scope.FormInputArray[index_value].CRDR_TYPE='DR';}
			else if(CRDR_TYPE=='C' || CRDR_TYPE=='CR')
			{$scope.FormInputArray[index_value].CRDR_TYPE='CR';}
			else
			{$scope.FormInputArray[index_value].CRDR_TYPE='';}

			//TOTAL DEBIT,CREDIT AND BALANCE AMOUNT CALCULATION
			for(var i=0; i<=$scope.maxloopvalue;i++)
			{			
				if($scope.FormInputArray[i].CRDR_TYPE=='CR')
				{
					$rootScope.TotalCrAmt=
					Number($rootScope.TotalCrAmt || 0)+Number($rootScope.FormInputArray[i].ledger_amount || 0);
				}
				if($scope.FormInputArray[i].CRDR_TYPE=='DR')
				{
					$rootScope.TotalDrAmt=
					Number($rootScope.TotalDrAmt || 0)+Number($rootScope.FormInputArray[i].ledger_amount || 0);
				}
			}

			$rootScope.TotalBalanceAmt=
			Number($rootScope.TotalDrAmt || 0)-Number($rootScope.TotalCrAmt || 0);
			//TOTAL DEBIT,CREDIT AND BALANCE AMOUNT CALCULATION



				if(event.keyCode === 13)
				{
					//OK
					if(element_name=='tran_date')
					{document.getElementById('CRDR_TYPE-0').focus();}
					//OK				
					if(element_name=='CRDR_TYPE')
					{document.getElementById('ledger_account_name-'+index_value).focus();}

					//OK
					if(element_name=='ledger_account_name')
					{document.getElementById('ledger_amount-'+index_value).focus();}
					//OK
					if(element_name=='ledger_amount')
					{						
						var indx=Number(index_value || 0)+1;
						var crtextamt=$rootScope.FormInputArray[index_value].ledger_amount;

						if($rootScope.TotalBalanceAmt!=0 && Number(crtextamt || 0)>0)
						{	
							var CRDR_TYPE='';
							var diffamt='';

							if($rootScope.TotalDrAmt>$rootScope.TotalCrAmt)
							{CRDR_TYPE='CR';}

							if($rootScope.TotalDrAmt<$rootScope.TotalCrAmt)
							{CRDR_TYPE='DR';}

						
							$rootScope.FormInputArray[$rootScope.FormInputArray.length] =
							{	
								id_header:'',
								id_detail:'',
								trantype:'',
								truck_id:'',
								truck_no:'',
								employee_id:'',
								employee_name:'',
								tran_code:'',	
								tran_date:$scope.todate,
								CRDR_TYPE:'DR',
								ledger_account_id:'',
								ledger_account_name:'',
								ledger_amount:'',				
								transaction_details:'',
								detailtype:'NA',//BANK,BILL/NA/TT_FUEL_EXP/TT_OTHER_EXP
								details:[{TABLE_NAME:'',TABLE_ID:'',BILL_INSTRUMENT_NO:'',EMPLOYEE_NAME:'',AMOUNT:'',CHQDATE:'',BANKNAME:'',BRANCH:''}]
							};

							$rootScope.maxloopvalue=$rootScope.FormInputArray.length-1;
						}

						//DELETE BLANK ELEMENT OF ARRAY
						
						for(var i=1; i<=$rootScope.maxloopvalue-1;i++)
						{							
							if(Number($scope.FormInputArray[i].ledger_amount || 0)<=0 || 
							Number($scope.FormInputArray[i].ledger_account_id || 0)==0)
							{$scope.FormInputArray.splice(i, 1);}
							$rootScope.maxloopvalue=$rootScope.FormInputArray.length-1;
						}


						if($scope.FormInputArray[index_value].detailtype=='NA')
						{document.getElementById('CRDR_TYPE-'+indx).focus();}						
						else if($scope.FormInputArray[index_value].detailtype!='NA')
						{document.getElementById('BILL_INSTRUMENT_NO-'+index_value+0).focus();}
						else($rootScope.TotalBalanceAmt==0)
						{document.getElementById('transaction_details').focus();}


					}

					//ARRAY DETAILS SECTION

					//BANK DETAILS
					if($scope.FormInputArray[index_value].detailtype=='BANK')
					{

						if(element_name=='BILL_INSTRUMENT_NO')
						{document.getElementById('CHQDATE-'+index_value+child_index).focus();}
						if(element_name=='CHQDATE')
						{document.getElementById('BANKNAME-'+index_value+child_index).focus();}
						if(element_name=='BANKNAME')
						{document.getElementById('BRANCH-'+index_value+child_index).focus();}
						if(element_name=='BRANCH')
						{document.getElementById('AMOUNT-'+index_value+child_index).focus();}

						if(element_name=='AMOUNT')
						{
							var crtextamt=$rootScope.FormInputArray[index_value].ledger_amount;
							var bank_amt=0;
							var bankdetail_length=$scope.FormInputArray[index_value].details.length;
							for(var i=0; i<=bankdetail_length-1;i++)
							{			
								bank_amt=bank_amt+
								Number($scope.FormInputArray[index_value].details[i].AMOUNT |0);
							}
							if(crtextamt>bank_amt && 
								Number($scope.FormInputArray[index_value].details[child_index].AMOUNT | 0)>0)
							{													
								$scope.FormInputArray[index_value].details[bankdetail_length]=
								{TABLE_NAME:'',TABLE_ID:'',BILL_INSTRUMENT_NO:'',EMPLOYEE_NAME:'',AMOUNT:'',CHQDATE:'',BANKNAME:'',BRANCH:''};	
							}
							

							if(crtextamt>bank_amt && 
								Number($scope.FormInputArray[index_value].details[child_index].AMOUNT | 0)>0)
							{							
								document.getElementById('BILL_INSTRUMENT_NO-'+index_value+Number(child_index+1 |0)).focus();
							}
							else
							{document.getElementById('CRDR_TYPE-'+Number(index_value+1)).focus();}

							for(var i=1; i<=bankdetail_length-1;i++)
							{							
								if(Number($scope.FormInputArray[index_value].details[i].AMOUNT || 0)<=0 )
								{$scope.FormInputArray[index_value].details.splice(i, 1);}
							}
						
						}
					}
					//BANK DETAILS END

					//BILL DETAILS
					if($scope.FormInputArray[index_value].detailtype=='SALE_BILL' || 
					$scope.FormInputArray[index_value].detailtype=='PURCHASE_BILL' || 
					$scope.FormInputArray[index_value].detailtype=='STAFF_DRIVERS')	
					{
						if(element_name=='BILL_INSTRUMENT_NO')
						{document.getElementById('AMOUNT-'+index_value+child_index).focus();}
						
						if(element_name=='AMOUNT')
						{
							var crtextamt=$rootScope.FormInputArray[index_value].ledger_amount;
							var total_bill_amt=AccountsTransaction.bill_summary(index_value);
							var current_bill_amt=Number($scope.FormInputArray[index_value].details[child_index].AMOUNT | 0);
							var billdetail_length=$rootScope.FormInputArray[index_value].details.length;
	
							if(crtextamt>total_bill_amt && current_bill_amt>0)
							{							
								$scope.FormInputArray[index_value].details[billdetail_length]=
								{TABLE_NAME:'',TABLE_ID:'',BILL_INSTRUMENT_NO:'',EMPLOYEE_NAME:'',AMOUNT:'',CHQDATE:'',BANKNAME:'',BRANCH:''};							
							
							}						
							
							if(crtextamt>total_bill_amt && Number($scope.FormInputArray[index_value].details[child_index].AMOUNT | 0)>0)
							{document.getElementById('BILL_INSTRUMENT_NO-'+index_value+Number(child_index+1 |0)).focus();}
							else
							{document.getElementById('CRDR_TYPE-'+Number(index_value+1)).focus();}
	
							for(var i=1; i<=billdetail_length-1;i++)
							{							
								if(Number($scope.FormInputArray[index_value].details[i].AMOUNT || 0)<=0 )
								{$scope.FormInputArray[index_value].details.splice(i, 1);}
							}
						
						}


					}				
					//BILL DETAILS END 	






				}
				//ENTER EVENT END 




		}//mainOperation END


	
	//===================SEARCH STRAT===============================================	
	

	//SEARCH SECTION
    $rootScope.search = function(element_name,index_value,child_index,detailtype,frmrpt_simple_query_builder_id)
    {
        
		$rootScope.element_name=element_name;
		$rootScope.element_value='';
		$rootScope.index_value=index_value;
		$rootScope.child_index=child_index;	
		$rootScope.detailtype=detailtype;	

		var CRDR_TYPE=$scope.FormInputArray[index_value].CRDR_TYPE;
		var parent_element_id=0;
		
		
		if(element_name=='ledger_account_name'){	
			$rootScope.element_value= $scope.FormInputArray[index_value].ledger_account_name;	
		}
		
		if(element_name=='BILL_INSTRUMENT_NO')
		{
			parent_element_id=$scope.FormInputArray[index_value].ledger_account_id;
			$rootScope.element_value= 
			$scope.FormInputArray[index_value]['details'][child_index].BILL_INSTRUMENT_NO;
		}
		

		$rootScope.suggestions = [];
		$rootScope.searchItems=[];		
		console.log(detailtype);

		AccountsTransaction.list_items(element_name,parent_element_id,CRDR_TYPE,AcTranType,detailtype);	
       	
        $rootScope.searchItems.sort();	
        var myMaxSuggestionListLength = 0;
        for(var i=0; i<$rootScope.searchItems.length; i++){
            var searchItemsSmallLetters = angular.uppercase($rootScope.searchItems[i]);
            var searchTextSmallLetters =angular.uppercase($rootScope.element_value);
            if( searchItemsSmallLetters.indexOf(searchTextSmallLetters) !== -1){
                $rootScope.suggestions.push(searchItemsSmallLetters);
                myMaxSuggestionListLength += 1;
                if(myMaxSuggestionListLength === 12){
                    break;
                }
            }
        }
    };

	$rootScope.$watch('selectedIndex',function(val)
	{			
		if(val !== -1) {    
			if($rootScope.element_name=='ledger_account_name'){	
				$scope.FormInputArray[$rootScope.index_value].ledger_account_name =
				$rootScope.suggestions[$rootScope.selectedIndex];	
			}	

			if($rootScope.element_name=='BILL_INSTRUMENT_NO')
			{
				$scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].BILL_INSTRUMENT_NO=
				$rootScope.suggestions[$rootScope.selectedIndex];	
			}
			
		}
	});		

		$rootScope.checkKeyDown = function(event)
		{
			if(event.keyCode === 40){//down key, increment selectedIndex
				event.preventDefault();
				if($rootScope.selectedIndex+1 < $rootScope.suggestions.length){
					$rootScope.selectedIndex++;
				}else{
					$rootScope.selectedIndex = 0;
				}
				
			}else if(event.keyCode === 38){ //up key, decrement selectedIndex
				event.preventDefault();
				if($rootScope.selectedIndex-1 >= 0){
					$rootScope.selectedIndex--;
				}else{
					$rootScope.selectedIndex = $rootScope.suggestions.length-1;
				}
			}
			else if(event.keyCode === 13){ //enter key, empty suggestions array

				if($rootScope.selectedIndex>-1){
					$rootScope.AssignValueAndHide($rootScope.selectedIndex);
				}	
			}
			else if(event.keyCode === 9){ //enter tab key
				if($rootScope.selectedIndex>-1){
					$rootScope.AssignValueAndHide($rootScope.selectedIndex);
				}			

			}else if(event.keyCode === 27){ //ESC key, empty suggestions array
				$rootScope.AssignValueAndHide($rootScope.selectedIndex);
				console.log($rootScope.selectedIndex);
				event.preventDefault();
				$rootScope.suggestions = [];
				$rootScope.searchItems=[];
				$rootScope.selectedIndex = -1;
			}else{
				$rootScope.search();	
			}
		};

		//ClickOutSide
		if($rootScope.element_name=='ledger_account_name'){			
			var exclude1 = document.getElementById($rootScope.element_name+'-'+$rootScope.index_value);
		}

		if($rootScope.element_name=='BILL_INSTRUMENT_NO')
		{	
			var exclude1 = document.getElementById($rootScope.element_name+'-'+$rootScope.index_value+
			$rootScope.child_index);
		}

	

		$rootScope.hideMenu = function($event){
			$rootScope.search();
			//make a condition for every object you wat to exclude
			if($event.target !== exclude1) {
				$rootScope.searchItems=[];
				$rootScope.suggestions = [];
				$rootScope.selectedIndex = -1;
			}
		};


	$rootScope.checkKeyUp = function(event){ 		
		if(event.keyCode !== 8 || event.keyCode !== 46){//delete or backspace

			if($rootScope.element_name=='ledger_account_name'){					
				if($scope.FormInputArray[$rootScope.index_value].ledger_account_name === ""){
					$rootScope.suggestions = [];
					$rootScope.searchItems=[];
					$rootScope.selectedIndex = -1;
				}
			}

			if($rootScope.element_name=='BILL_INSTRUMENT_NO'){		
						
				if($scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].BILL_INSTRUMENT_NO === "")
				{
					$rootScope.suggestions = [];
					$rootScope.searchItems=[];
					$rootScope.selectedIndex = -1;
				}
			}  
			
		
		}
	};	
	//======================================
	//List Item Events
	//Function To Call on ng-click
		$rootScope.AssignValueAndHide = function(index){

			if($rootScope.element_name=='ledger_account_name')
			{		
				$scope.FormInputArray[$rootScope.index_value].ledger_account_name =
				$rootScope.suggestions[index];	
				var str=$scope.FormInputArray[$rootScope.index_value].ledger_account_name;			
				var id=str.substring(str.lastIndexOf("#")+1,str.lastIndexOf(")"));	
				var data_link=BaseUrl+"ledger_account_id/"+id;					
				//console.log(data_link);					
				$http.get(data_link).then(function(response){
					angular.forEach(response.data,function(value,key){
						$scope.FormInputArray[$rootScope.index_value].ledger_account_id=value.id;
						$scope.FormInputArray[$rootScope.index_value].ledger_account_name=value.name;
						$scope.FormInputArray[$rootScope.index_value].detailtype=value.COST_CENTER;

						if(value.COST_CENTER=='BANK')
						{
							$scope.FormInputArray[$rootScope.index_value]['details'][0].BANKNAME=
							$scope.FormInputArray[$rootScope.index_value].ledger_account_name;

							$scope.FormInputArray[$rootScope.index_value]['details'][0].BANKNAME=
							$scope.FormInputArray[$rootScope.index_value].ledger_account_name;

						}
						
					});
				});
			}

			if($rootScope.element_name=='BILL_INSTRUMENT_NO')
			{		
				var str=$scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].BILL_INSTRUMENT_NO =
				$rootScope.suggestions[index];	
				
			//	var str=$scope.FormInputArray[$rootScope.index_value].ledger_account_name;			
				var id=str.substring(str.lastIndexOf("#")+1,str.lastIndexOf(")"));	

				if($rootScope.detailtype=='STAFF_DRIVERS')
				{var data_link=BaseUrl+"employee_id/"+id;}

				if($rootScope.detailtype=='SALE_BILL' || $rootScope.detailtype=='PURCHASE_BILL')
				{var data_link=BaseUrl+"BILLID/"+id;}
					
				$http.get(data_link).then(function(response){
					angular.forEach(response.data,function(value,key){

						$scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].TABLE_NAME =value.TABLE_NAME;
						$scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].TABLE_ID =value.id;
						$scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].BILL_INSTRUMENT_NO =value.name;
						$scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].AMOUNT =value.bill_due_amt;											
											
					});
				});
				
			}
			

			$rootScope.suggestions=[];
			$rootScope.searchItems=[];
			$rootScope.selectedIndex = -1;
		};
	
	//===================END SEARCH SECTION =========================================
	

	$scope.savedata=function()
	{
		var data_link=BaseUrl+"SAVE";
		var success={};		
		sessionStorage.setItem("selecteddate", $rootScope.FormInputArray[0].tran_date);

		var data_save = JSON.stringify($rootScope.FormInputArray);	
		console.log(data_save);

		var config = {headers : 
			{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
		}		
		$http.post(data_link,data_save,config)
		.then (function success(response){	
			$scope.savemsg='Receord Has been saved Successfully!';
			$scope.get_set_value(response.data,'','RE_INITIAL_INPUT_ARRAY');
		},
		function error(response){
			$scope.errorMessage = 'Error - Receord Not Saved!';
			$scope.message = '';
	  });

	}

	$scope.get_set_value=function(datavalue,datatype,operation)
	{
		if(operation=='SETVALUE')
		{
			if(angular.isUndefined(datavalue)==true)
			{
				if(datatype=='num')
				{return 0;}
				if(datatype=='str')
				{return '';}		
			}
			else
			{return datavalue;}
		}
		if(operation=='DRCRCHECKING')
		{	
			var operation_status='OK';
			if(Number($rootScope.TotalDrAmt)!=Number($rootScope.TotalCrAmt))
			{ 
				operation_status='NOTOK'
				$scope.savemsg='Debit and Credit Amount must be same';
			}		
			if(operation_status=='OK')
			{$scope.savedata();}

		}
		
		if(operation=='RE_INITIAL_INPUT_ARRAY')
		{		
			$rootScope.FormInputArray.length=0;		

			$rootScope.FormInputArray[0] =
			{	
			id_header:'',
			id_detail:'',
			trantype:'',
			truck_id:'',
			truck_no:'',
			employee_id:'',
			employee_name:'',
			tran_code:'',	
			tran_date:sessionStorage.getItem("selecteddate"),
			CRDR_TYPE:'CR',
			ledger_account_id:'',
			ledger_account_name:'',
			ledger_amount:'',				
			transaction_details:'',
			detailtype:'NA',//BANK,BILL/NA/TT_FUEL_EXP/TT_OTHER_EXP
			details:[{TABLE_NAME:'',TABLE_ID:'',BILL_INSTRUMENT_NO:'',dsl_qnty:''
			,dsl_rate:'',trip_cashamt:'',AMOUNT:'',CHQDATE:'',BANKNAME:'',BRANCH:''}]
		};

			$rootScope.TotalDrAmt=0;
			$rootScope.TotalCrAmt=0;
			$rootScope.TotalBalanceAmt=0;
			$rootScope.maxloopvalue=$rootScope.FormInputArray.length-1;
			document.getElementById('tran_date').focus();
		}

		if(operation=='VIEWALLVALUE')
		{	
			
			var data_link=BaseUrl+"VIEWALLVALUE/"+datavalue;
			console.log(data_link);
			$http.get(data_link).then(function(response) 
			{
				//console.log(response.data);
				angular.forEach(response.data,function(value,key){
					
						$rootScope.FormInputArray[key] =
						{	
							id_header:value.id_header,
							id_detail:value.id_detail,
							trantype:value.trantype,
							truck_id:value.truck_id,
							truck_no:value.truck_no,
							employee_id:value.employee_id,
							employee_name:value.employee_name,
							tran_code:value.tran_code,	
							tran_date:value.tran_date,
							CRDR_TYPE:value.CRDR_TYPE,
							ledger_account_id:value.ledger_account_id,
							ledger_account_name:value.ledger_account_name,
							ledger_amount:value.ledger_amount,				
							transaction_details:value.transaction_details,						
							detailtype:value.detailtype,//BANK,BILL/NA						
							details:value.details						
						};
						//console.log('Array key'+key+'cr_ledger_account_name '+value.ledger_account_name);
						
				});	
				for(var i=1; i<=$rootScope.maxloopvalue-1;i++)
				{							
					if(Number($scope.FormInputArray[i].cr_ledger_account || 0)==0)
					{$scope.FormInputArray.splice(i, 1);}					
				}
				$rootScope.maxloopvalue=$rootScope.FormInputArray.length-1;
				console.log('Array length'+$rootScope.FormInputArray.length);

			});		
	
		//	FormInputArray
		}


	}
	
	
	$scope.GetAllList=function(fromdate,todate){
			//var BaseUrl=domain_name+"Primary_sale_controller/ConsignmentList/";
			//data list GetAllConsignment			
			var data_link=BaseUrl+'GetAllList/'+AcTranType+'/-/-/'+fromdate+'/'+todate;
			console.log(data_link);
			$http.get(data_link).then(function(response) 
			{$scope.ListOfTransactions=response.data;});
	}
	
	$scope.print_consignment = function() 
	{ 
		var data_link=domain_name+"Primary_sale_controller/builty_print/print_builty/"+$scope.id_header;
		window.popup(data_link); 
	};

}]);

//************************ACCOUNT -RECEIVE,PAYMENT,JOURNAL,CONTRA  OLD*****************************************//
// app.controller('AccountsTransaction',['$scope','$window','$rootScope','$http','$location','AccountsTransaction',
// function($scope,$window,$rootScope,$http,$location,AccountsTransaction)
// {
// 	"use strict";
	
// 	//var domain_name="http://localhost/abir_das_unitedlab/SATNAM/";	
// 	var BaseUrl=domain_name+"Accounts_controller/AccountsTransactions/";
// 	var AcTranType;
// 	$scope.initarray=function(trantype){		
// 		BaseUrl=BaseUrl+trantype+'/';	
// 		AcTranType=trantype;
// 	}
// 	console.log(BaseUrl);
// 	//ARRAY EXPERIMENT
// 	//$scope.FormInputArray={};
// 	$scope.accounts_id={};
// 	$scope.accounts_name={};
// 	$scope.accounts_amount={};
// 	$rootScope.FormInputArray=[];	
// 	document.getElementById('tran_date').focus();
	
// 	var CurrentDate=new Date();
// 	var year = CurrentDate.getFullYear();
// 	var month = CurrentDate.getMonth()+1;
// 	var dt = CurrentDate.getDate();
  
// 	if (dt < 10) {	dt = '0' + dt;}
// 	if (month < 10) {month = '0' + month;}
// 	$scope.fromdate=year+'-' + month + '-'+dt;
// 	$scope.todate=year+'-' + month + '-'+dt;
	
// 	//CALL GLOBAL FUNCTION
// 	//https://stackoverflow.com/questions/15025979/can-i-make-a-function-available-in-every-controller-in-angular


// 			$rootScope.FormInputArray[0] =
// 			{	
// 			id_header:'',
// 			id_detail:'',
// 			trantype:'',
// 			truck_id:'',
// 			truck_no:'',
// 			employee_id:'',
// 			employee_name:'',
// 			tran_code:'',	
// 			tran_date:$scope.todate,
// 			CRDR_TYPE:'CR',
// 			ledger_account_id:'',
// 			ledger_account_name:'',
// 			ledger_amount:'',				
// 			transaction_details:'',
// 			detailtype:'NA',//BANK,BILL/NA/TT_FUEL_EXP/TT_OTHER_EXP
// 			details:[{bill_id:'',BILL_INSTRUMENT_NO:'',EMPLOYEE_NAME:'',
// 			employee_id:'',truck_no:'',truck_id:'',TRAN_DATE:'',tripId:'',dsl_qnty:''
// 			,dsl_rate:'',trip_cashamt:'',AMOUNT:'',CHQDATE:'',BANKNAME:'',BRANCH:''}]
// 		};
	
// 	$rootScope.FormInputArray[0].trantype=AcTranType;
// 	console.log('AcTranType '+AcTranType+$rootScope.FormInputArray[0].trantype);
// 	$rootScope.maxloopvalue=$rootScope.FormInputArray.length-1;

// 	//$rootScope.max_bill_count=$rootScope.FormInputArray[1]['billdetail'].length;	
// 	//console.log('BANK DETAILS '+$rootScope.FormInputArray[0]['bankdetail'][0].BRANCH);

// 	// console.log('BANK DETAILS '+$rootScope.FormInputArray[1]['bankdetail'][0].BRANCH);
// 	// console.log('arraindx billdetail '+
// 	// $rootScope.FormInputArray[0]['billdetail'][2]['testarray'][0].val);
// 	// console.log('$rootScope.max_bill_count '+$rootScope.max_bill_count);


// 	//https://stackoverflow.com/questions/18086865/angularjs-move-focus-to-next-control-on-enter

// 		$scope.mainOperation=function(event,element_name,index_value,child_index,searchItem)
// 		{	
					
// 			$rootScope.TotalDrAmt=0;
// 			$rootScope.TotalCrAmt=0;
// 			$rootScope.TotalBalanceAmt=0;
						
// 			if(searchItem=='searchItem')
// 			{$scope.search(element_name,index_value,child_index);}
			
// 			var CRDR_TYPE=angular.uppercase($scope.FormInputArray[index_value].CRDR_TYPE);

// 			if(CRDR_TYPE=='D' || CRDR_TYPE=='DR')
// 			{$scope.FormInputArray[index_value].CRDR_TYPE='DR';}
// 			else if(CRDR_TYPE=='C' || CRDR_TYPE=='CR')
// 			{$scope.FormInputArray[index_value].CRDR_TYPE='CR';}
// 			else
// 			{$scope.FormInputArray[index_value].CRDR_TYPE='';}

// 			//TOTAL DEBIT,CREDIT AND BALANCE AMOUNT CALCULATION
// 			for(var i=0; i<=$scope.maxloopvalue;i++)
// 			{			
// 				if($scope.FormInputArray[i].CRDR_TYPE=='CR')
// 				{
// 					$rootScope.TotalCrAmt=
// 					Number($rootScope.TotalCrAmt || 0)+Number($rootScope.FormInputArray[i].ledger_amount || 0);
// 				}
// 				if($scope.FormInputArray[i].CRDR_TYPE=='DR')
// 				{
// 					$rootScope.TotalDrAmt=
// 					Number($rootScope.TotalDrAmt || 0)+Number($rootScope.FormInputArray[i].ledger_amount || 0);
// 				}
// 			}

// 			$rootScope.TotalBalanceAmt=
// 			Number($rootScope.TotalDrAmt || 0)-Number($rootScope.TotalCrAmt || 0);
// 			//TOTAL DEBIT,CREDIT AND BALANCE AMOUNT CALCULATION



// 				if(event.keyCode === 13)
// 				{
// 					//OK
// 					if(element_name=='tran_date')
// 					{document.getElementById('CRDR_TYPE-0').focus();}
// 					//OK				
// 					if(element_name=='CRDR_TYPE')
// 					{document.getElementById('ledger_account_name-'+index_value).focus();}

// 					//OK
// 					if(element_name=='ledger_account_name')
// 					{document.getElementById('ledger_amount-'+index_value).focus();}
// 					//OK
// 					if(element_name=='ledger_amount')
// 					{						
// 						var indx=Number(index_value || 0)+1;
// 						var crtextamt=$rootScope.FormInputArray[index_value].ledger_amount;

// 						if($rootScope.TotalBalanceAmt!=0 && Number(crtextamt || 0)>0)
// 						{	
// 							var CRDR_TYPE='';
// 							var diffamt='';

// 							if($rootScope.TotalDrAmt>$rootScope.TotalCrAmt)
// 							{CRDR_TYPE='CR';}

// 							if($rootScope.TotalDrAmt<$rootScope.TotalCrAmt)
// 							{CRDR_TYPE='DR';}

// 							$rootScope.FormInputArray[$rootScope.FormInputArray.length] =
// 							{		
// 								id_header:'',
// 								id_detail:'',
// 								trantype:'',
// 								truck_id:'',
// 								truck_no:'',
// 								employee_id:'',
// 								employee_name:'',
// 								tran_code:'',	
// 								tran_date:$scope.todate,
// 								CRDR_TYPE:CRDR_TYPE,
// 								ledger_account_id:'',
// 								ledger_account_name:'',
// 								ledger_amount:diffamt,				
// 								transaction_details:'',
// 								detailtype:'NA',//BANK,BILL/NA/PUMP
// 								details:[{bill_id:'',BILL_INSTRUMENT_NO:'',EMPLOYEE_NAME:'',
// 								employee_id:'',truck_no:'',truck_id:'',TRAN_DATE:$scope.todate,tripId:'',dsl_qnty:''
// 								,dsl_rate:'',trip_cashamt:'',AMOUNT:'',CHQDATE:'',BANKNAME:'',BRANCH:''}]
// 							};

							
// 							$rootScope.maxloopvalue=$rootScope.FormInputArray.length-1;
// 						}

// 						//DELETE BLANK ELEMENT OF ARRAY
						
// 						for(var i=1; i<=$rootScope.maxloopvalue-1;i++)
// 						{							
// 							if(Number($scope.FormInputArray[i].ledger_amount || 0)<=0 || 
// 							Number($scope.FormInputArray[i].ledger_account_id || 0)==0)
// 							{$scope.FormInputArray.splice(i, 1);}
// 							$rootScope.maxloopvalue=$rootScope.FormInputArray.length-1;
// 						}

																
// 						//document.getElementById('BILLNO-'+index_value+0).focus();
// 						// console.log('HELLOW HELLOW'+
// 						// $scope.FormInputArray[index_value].detailtype+'index_value '+index_value);

// 						if($scope.FormInputArray[index_value].detailtype=='NA')
// 						{document.getElementById('CRDR_TYPE-'+indx).focus();}
						
// 						if($scope.FormInputArray[index_value].detailtype=='BANK')
// 						{document.getElementById('BILL_INSTRUMENT_NO-'+index_value+0).focus();}

// 						if($scope.FormInputArray[index_value].detailtype=='PURCHASE_BILL')
// 						{document.getElementById('BILLNO-'+index_value+0).focus();}

// 						if($scope.FormInputArray[index_value].detailtype=='SALE_BILL')
// 						{document.getElementById('BILLNO-'+index_value+0).focus();}

// 						if($scope.FormInputArray[index_value].detailtype=='TT_FUEL_EXP')
// 						{document.getElementById('truck_no-'+index_value+0).focus();}

// 						if($scope.FormInputArray[index_value].detailtype=='TT_OTHER_EXP')
// 						{document.getElementById('truck_no-'+index_value+0).focus();}
						

// 						// if($rootScope.TotalBalanceAmt>0)
// 						// {document.getElementById('CRDR_TYPE-'+indx).focus();}

// 						if($rootScope.TotalBalanceAmt==0)
// 						{document.getElementById('transaction_details').focus();}

// 					}

// 					//ARRAY DETAILS SECTION

// 					//BANK DETAILS
// 					if($scope.FormInputArray[index_value].detailtype=='BANK')
// 					{

// 						if(element_name=='BILL_INSTRUMENT_NO')
// 						{document.getElementById('CHQDATE-'+index_value+child_index).focus();}
// 						if(element_name=='CHQDATE')
// 						{document.getElementById('BANKNAME-'+index_value+child_index).focus();}
// 						if(element_name=='BANKNAME')
// 						{document.getElementById('BRANCH-'+index_value+child_index).focus();}
// 						if(element_name=='BRANCH')
// 						{document.getElementById('AMOUNT-'+index_value+child_index).focus();}

// 						if(element_name=='AMOUNT')
// 						{
// 							var crtextamt=$rootScope.FormInputArray[index_value].ledger_amount;
// 							var bank_amt=0;
// 							var bankdetail_length=$scope.FormInputArray[index_value].details.length;
// 							for(var i=0; i<=bankdetail_length-1;i++)
// 							{			
// 								bank_amt=bank_amt+
// 								Number($scope.FormInputArray[index_value].details[i].AMOUNT |0);
// 							}
// 							if(crtextamt>bank_amt && 
// 								Number($scope.FormInputArray[index_value].details[child_index].AMOUNT | 0)>0)
// 							{													
// 								$scope.FormInputArray[index_value].details[bankdetail_length]=
// 								{bill_id:'',BILL_INSTRUMENT_NO:'',EMPLOYEE_NAME:'',
// 								employee_id:'',truck_no:'',truck_id:'',TRAN_DATE:$scope.todate,tripId:'',dsl_qnty:''
// 								,dsl_rate:'',trip_cashamt:'',AMOUNT:'',CHQDATE:'',BANKNAME:'',BRANCH:''};	
// 							}
							

// 							if(crtextamt>bank_amt && 
// 								Number($scope.FormInputArray[index_value].details[child_index].AMOUNT | 0)>0)
// 							{							
// 								document.getElementById('BILL_INSTRUMENT_NO-'+index_value+Number(child_index+1 |0)).focus();
// 							}
// 							else
// 							{document.getElementById('CRDR_TYPE-'+Number(index_value+1)).focus();}

// 							for(var i=1; i<=bankdetail_length-1;i++)
// 							{							
// 								if(Number($scope.FormInputArray[index_value].details[i].AMOUNT || 0)<=0 )
// 								{$scope.FormInputArray[index_value].details.splice(i, 1);}
// 							}
						
// 						}
// 					}
// 					//BANK DETAILS END

// 					//BILL DETAILS
// 					if($scope.FormInputArray[index_value].detailtype=='PURCHASE_BILL' || 
// 					$scope.FormInputArray[index_value].detailtype=='SALE_BILL' )	
// 					{
// 						if(element_name=='BILLNO')
// 						{
// 							// var crtextamt=Number($rootScope.FormInputArray[index_value].ledger_amount |0 );
// 							// var total_bill_amt=Number(AccountsReceive.bill_summary(index_value) | 0 );
// 							// var current_bill_amt=Number($scope.FormInputArray[index_value].billdetail[child_index].BILLAMT | 0);
// 							// var billdetail_length=$rootScope.FormInputArray[index_value].billdetail.length;
// 							// if(crtextamt-total_bill_amt>0)
// 							// {	
// 							// 	$scope.FormInputArray[index_value].billdetail[child_index].BILLAMT=
// 							// 	crtextamt-total_bill_amt;							
// 							// }					
							
// 							document.getElementById('BILLAMT-'+index_value+child_index).focus();
						
// 						}
						
// 						if(element_name=='BILLAMT')
// 						{
// 							var crtextamt=$rootScope.FormInputArray[index_value].ledger_amount;
// 							var total_bill_amt=AccountsTransaction.bill_summary(index_value);
// 							var current_bill_amt=Number($scope.FormInputArray[index_value].details[child_index].AMOUNT | 0);
// 							var billdetail_length=$rootScope.FormInputArray[index_value].details.length;
	
// 							if(crtextamt>total_bill_amt && current_bill_amt>0)
// 							{							
// 								$scope.FormInputArray[index_value].details[billdetail_length]=
// 								{bill_id:'',BILL_INSTRUMENT_NO:'',EMPLOYEE_NAME:'',
// 								employee_id:'',truck_no:'',truck_id:'',TRAN_DATE:$scope.todate,tripId:'',dsl_qnty:''
// 								,dsl_rate:'',trip_cashamt:'',AMOUNT:'',CHQDATE:'',BANKNAME:'',BRANCH:''};							
							
// 							}						
							
// 							if(crtextamt>total_bill_amt && 
// 								Number($scope.FormInputArray[index_value].details[child_index].AMOUNT | 0)>0)
// 							{
// 								document.getElementById('BILLNO-'+index_value+Number(child_index+1 |0)).focus();
// 							}
// 							else
// 							{document.getElementById('CRDR_TYPE-'+Number(index_value+1)).focus();}
	
// 							for(var i=1; i<=billdetail_length-1;i++)
// 							{							
// 								if(Number($scope.FormInputArray[index_value].details[i].AMOUNT || 0)<=0 )
// 								{$scope.FormInputArray[index_value].details.splice(i, 1);}
// 							}
						
// 						}


// 					}				
// 					//BILL DETAILS END 	


// 					//TT_FUEL_EXP
// 					if($scope.FormInputArray[index_value].detailtype=='TT_FUEL_EXP' )	
// 					{
// 						if(element_name=='truck_no')
// 						{document.getElementById('dsl_rate-'+index_value+child_index).focus();}

// 						if(element_name=='dsl_rate')
// 						{document.getElementById('dsl_qnty-'+index_value+child_index).focus();}

// 						if(element_name=='dsl_qnty')
// 						{document.getElementById('trip_cashamt-'+index_value+child_index).focus();}

// 						if(element_name=='trip_cashamt')
// 						{document.getElementById('AMOUNT-'+index_value+child_index).focus();}
						
// 						$scope.FormInputArray[index_value].details[child_index].AMOUNT=
// 						Number($scope.FormInputArray[index_value].details[child_index].dsl_rate | 0)*
// 						Number($scope.FormInputArray[index_value].details[child_index].dsl_qnty | 0)+
// 						Number($scope.FormInputArray[index_value].details[child_index].trip_cashamt | 0);

// 						if(element_name=='AMOUNT')
// 						{
// 							var crtextamt=$rootScope.FormInputArray[index_value].ledger_amount;
// 							var total_bill_amt=AccountsTransaction.bill_summary(index_value);
// 							var current_bill_amt=Number($scope.FormInputArray[index_value].details[child_index].AMOUNT | 0);
// 							var billdetail_length=$rootScope.FormInputArray[index_value].details.length;
	
// 							if(crtextamt>total_bill_amt && current_bill_amt>0)
// 							{							
// 								$scope.FormInputArray[index_value].details[billdetail_length]=
// 								{bill_id:'',BILL_INSTRUMENT_NO:'',EMPLOYEE_NAME:'',
// 								employee_id:'',truck_no:'',truck_id:'',TRAN_DATE:$scope.todate,tripId:'',dsl_qnty:''
// 								,dsl_rate:'',trip_cashamt:'',AMOUNT:'',CHQDATE:'',BANKNAME:'',BRANCH:''};							
							
// 							}						
							
// 							if(crtextamt>total_bill_amt && 
// 								Number($scope.FormInputArray[index_value].details[child_index].AMOUNT | 0)>0)
// 							{
// 								document.getElementById('truck_no-'+index_value+Number(child_index+1 |0)).focus();
// 							}
// 							else
// 							{document.getElementById('CRDR_TYPE-'+Number(index_value+1)).focus();}
	
// 							for(var i=1; i<=billdetail_length-1;i++)
// 							{							
// 								if(Number($scope.FormInputArray[index_value].details[i].AMOUNT || 0)<=0 )
// 								{$scope.FormInputArray[index_value].details.splice(i, 1);}
// 							}
						
// 						}	

// 					}				
// 					//TT_FUEL_EXP

// 					//TT_OTHER_EXP
// 					if($scope.FormInputArray[index_value].detailtype=='TT_OTHER_EXP' )	
// 					{
// 						if(element_name=='truck_no')
// 						{document.getElementById('AMOUNT-'+index_value+child_index).focus();}
											
// 						if(element_name=='AMOUNT')
// 						{
// 							var crtextamt=$rootScope.FormInputArray[index_value].ledger_amount;
// 							var total_bill_amt=AccountsTransaction.bill_summary(index_value);
// 							var current_bill_amt=Number($scope.FormInputArray[index_value].details[child_index].AMOUNT | 0);
// 							var billdetail_length=$rootScope.FormInputArray[index_value].details.length;
	
// 							if(crtextamt>total_bill_amt && current_bill_amt>0)
// 							{							
// 								$scope.FormInputArray[index_value].details[billdetail_length]=
// 								{bill_id:'',BILL_INSTRUMENT_NO:'',EMPLOYEE_NAME:'',
// 								employee_id:'',truck_no:'',truck_id:'',TRAN_DATE:$scope.todate,tripId:'',dsl_qnty:''
// 								,dsl_rate:'',trip_cashamt:'',AMOUNT:'',CHQDATE:'',BANKNAME:'',BRANCH:''};							
							
// 							}						
							
// 							if(crtextamt>total_bill_amt && 
// 								Number($scope.FormInputArray[index_value].details[child_index].AMOUNT | 0)>0)
// 							{
// 								document.getElementById('truck_no-'+index_value+Number(child_index+1 |0)).focus();
// 							}
// 							else
// 							{document.getElementById('CRDR_TYPE-'+Number(index_value+1)).focus();}
	
// 							for(var i=1; i<=billdetail_length-1;i++)
// 							{							
// 								if(Number($scope.FormInputArray[index_value].details[i].AMOUNT || 0)<=0 )
// 								{$scope.FormInputArray[index_value].details.splice(i, 1);}
// 							}
						
// 						}	

// 					}				
// 					//TT_FUEL_EXP

// 					//STAFF= DRIVER AND OFFICE STAFF 
// 					if($scope.FormInputArray[index_value].detailtype=='STAFF' )	
// 					{
// 						if(element_name=='EMPLOYEE_NAME')
// 						{document.getElementById('truck_no-'+index_value+child_index).focus();}

// 						if(element_name=='truck_no')
// 						{document.getElementById('AMOUNT-'+index_value+child_index).focus();}
											
// 						if(element_name=='AMOUNT')
// 						{
// 							var crtextamt=$rootScope.FormInputArray[index_value].ledger_amount;
// 							var total_bill_amt=AccountsTransaction.bill_summary(index_value);
// 							var current_bill_amt=Number($scope.FormInputArray[index_value].details[child_index].AMOUNT | 0);
// 							var billdetail_length=$rootScope.FormInputArray[index_value].details.length;
	
// 							if(crtextamt>total_bill_amt && current_bill_amt>0)
// 							{							
// 								$scope.FormInputArray[index_value].details[billdetail_length]=
// 								{bill_id:'',BILL_INSTRUMENT_NO:'',EMPLOYEE_NAME:'',
// 								employee_id:'',truck_no:'',truck_id:'',TRAN_DATE:$scope.todate,tripId:'',dsl_qnty:''
// 								,dsl_rate:'',trip_cashamt:'',AMOUNT:'',CHQDATE:'',BANKNAME:'',BRANCH:''};							
							
// 							}						
							
// 							if(crtextamt>total_bill_amt && 
// 								Number($scope.FormInputArray[index_value].details[child_index].AMOUNT | 0)>0)
// 							{
// 								document.getElementById('EMPLOYEE_NAME-'+index_value+Number(child_index+1 |0)).focus();
// 							}
// 							else
// 							{document.getElementById('CRDR_TYPE-'+Number(index_value+1)).focus();}
	
// 							for(var i=1; i<=billdetail_length-1;i++)
// 							{							
// 								if(Number($scope.FormInputArray[index_value].details[i].AMOUNT || 0)<=0 )
// 								{$scope.FormInputArray[index_value].details.splice(i, 1);}
// 							}
						
// 						}	

// 					}				
// 					//DRIVER

// 				}
// 				//ENTER EVENT END 




// 		}//mainOperation END


	
// 	//===================SEARCH STRAT===============================================	
	

// 	//SEARCH SECTION
//     $rootScope.search = function(element_name,index_value,child_index)
//     {
        
// 		$rootScope.element_name=element_name;
// 		$rootScope.element_value='';
// 		$rootScope.index_value=index_value;
// 		$rootScope.child_index=child_index;	
// 		var CRDR_TYPE=$scope.FormInputArray[index_value].CRDR_TYPE;
// 		var parent_element_id=0;

// 		if(element_name=='ledger_account_name'){	
// 			$rootScope.element_value= $scope.FormInputArray[index_value].ledger_account_name;			
// 		}
		
// 		if(element_name=='BILLNO')
// 		{
// 			parent_element_id=$scope.FormInputArray[index_value].ledger_account_id;
// 			$rootScope.element_value= 
// 			$scope.FormInputArray[index_value]['details'][child_index].BILL_INSTRUMENT_NO;
// 		}
		
// 		if(element_name=='truck_no')
// 		{
// 			$rootScope.element_value= 
// 			$scope.FormInputArray[index_value]['details'][child_index].truck_no;
// 		}

// 		if(element_name=='EMPLOYEE_NAME')
// 		{
// 			$rootScope.element_value= 
// 			$scope.FormInputArray[index_value]['details'][child_index].EMPLOYEE_NAME;
// 		}

//         $rootScope.suggestions = [];
//         $rootScope.searchItems=[];		
//         AccountsTransaction.list_items(element_name,parent_element_id,CRDR_TYPE,AcTranType);		
//         $rootScope.searchItems.sort();	
//         var myMaxSuggestionListLength = 0;
//         for(var i=0; i<$rootScope.searchItems.length; i++){
//             var searchItemsSmallLetters = angular.uppercase($rootScope.searchItems[i]);
//             var searchTextSmallLetters =angular.uppercase($rootScope.element_value);
//             if( searchItemsSmallLetters.indexOf(searchTextSmallLetters) !== -1){
//                 $rootScope.suggestions.push(searchItemsSmallLetters);
//                 myMaxSuggestionListLength += 1;
//                 if(myMaxSuggestionListLength === 12){
//                     break;
//                 }
//             }
//         }
//     };

// 	$rootScope.$watch('selectedIndex',function(val)
// 	{			
// 		if(val !== -1) {    
// 			if($rootScope.element_name=='ledger_account_name'){	
// 				$scope.FormInputArray[$rootScope.index_value].ledger_account_name =
// 				$rootScope.suggestions[$rootScope.selectedIndex];	
// 			}		
// 			if($rootScope.element_name=='BILLNO')
// 			{
// 				$scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].BILL_INSTRUMENT_NO=
// 				$rootScope.suggestions[$rootScope.selectedIndex];	
// 			}

// 			if($rootScope.element_name=='truck_no')
// 			{
// 				$scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].truck_no=
// 				$rootScope.suggestions[$rootScope.selectedIndex];	
// 			}

// 			if($rootScope.element_name=='EMPLOYEE_NAME')
// 			{
// 				$scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].EMPLOYEE_NAME=
// 				$rootScope.suggestions[$rootScope.selectedIndex];	
// 			}

// 		}
// 	});		

// 		$rootScope.checkKeyDown = function(event)
// 		{
// 			if(event.keyCode === 40){//down key, increment selectedIndex
// 				event.preventDefault();
// 				if($rootScope.selectedIndex+1 < $rootScope.suggestions.length){
// 					$rootScope.selectedIndex++;
// 				}else{
// 					$rootScope.selectedIndex = 0;
// 				}
				
// 			}else if(event.keyCode === 38){ //up key, decrement selectedIndex
// 				event.preventDefault();
// 				if($rootScope.selectedIndex-1 >= 0){
// 					$rootScope.selectedIndex--;
// 				}else{
// 					$rootScope.selectedIndex = $rootScope.suggestions.length-1;
// 				}
// 			}
// 			else if(event.keyCode === 13){ //enter key, empty suggestions array

// 				if($rootScope.selectedIndex>-1){
// 					$rootScope.AssignValueAndHide($rootScope.selectedIndex);
// 				}	
// 			}
// 			else if(event.keyCode === 9){ //enter tab key
// 				if($rootScope.selectedIndex>-1){
// 					$rootScope.AssignValueAndHide($rootScope.selectedIndex);
// 				}			

// 			}else if(event.keyCode === 27){ //ESC key, empty suggestions array
// 				$rootScope.AssignValueAndHide($rootScope.selectedIndex);
// 				console.log($rootScope.selectedIndex);
// 				event.preventDefault();
// 				$rootScope.suggestions = [];
// 				$rootScope.searchItems=[];
// 				$rootScope.selectedIndex = -1;
// 			}else{
// 				$rootScope.search();	
// 			}
// 		};

// 		//ClickOutSide
// 		if($rootScope.element_name=='ledger_account_name'){			
// 			var exclude1 = document.getElementById($rootScope.element_name+'-'+$rootScope.index_value);
// 		}

// 		if($rootScope.element_name=='BILLNO')
// 		{	
// 			var exclude1 = document.getElementById($rootScope.element_name+'-'+$rootScope.index_value+
// 			$rootScope.child_index);
// 		}

// 		if($rootScope.element_name=='truck_no')
// 		{				
// 			var exclude1 = document.getElementById($rootScope.element_name+'-'+$rootScope.index_value+
// 			$rootScope.child_index);
// 		}

// 		if($rootScope.element_name=='EMPLOYEE_NAME')
// 		{				
// 			var exclude1 = document.getElementById($rootScope.element_name+'-'+$rootScope.index_value+
// 			$rootScope.child_index);
// 		}

// 		$rootScope.hideMenu = function($event){
// 			$rootScope.search();
// 			//make a condition for every object you wat to exclude
// 			if($event.target !== exclude1) {
// 				$rootScope.searchItems=[];
// 				$rootScope.suggestions = [];
// 				$rootScope.selectedIndex = -1;
// 			}
// 		};


// 	$rootScope.checkKeyUp = function(event){ 		
// 		if(event.keyCode !== 8 || event.keyCode !== 46){//delete or backspace

// 			if($rootScope.element_name=='ledger_account_name'){					
// 				if($scope.FormInputArray[$rootScope.index_value].ledger_account_name === ""){
// 					$rootScope.suggestions = [];
// 					$rootScope.searchItems=[];
// 					$rootScope.selectedIndex = -1;
// 				}
// 			}

// 			if($rootScope.element_name=='BILLNO'){		
						
// 				if($scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].BILL_INSTRUMENT_NO === "")
// 				{
// 					$rootScope.suggestions = [];
// 					$rootScope.searchItems=[];
// 					$rootScope.selectedIndex = -1;
// 				}
// 			}  
			
// 			if($rootScope.element_name=='truck_no')
// 			{				
// 				if($scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].truck_no === "")
// 				{
// 					$rootScope.suggestions = [];
// 					$rootScope.searchItems=[];
// 					$rootScope.selectedIndex = -1;
// 				}
// 			}

// 			if($rootScope.element_name=='EMPLOYEE_NAME')
// 			{		
// 				if($scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].EMPLOYEE_NAME === "")
// 				{
// 					$rootScope.suggestions = [];
// 					$rootScope.searchItems=[];
// 					$rootScope.selectedIndex = -1;
// 				}
// 			}
			
// 		}
// 	};	
// 	//======================================
// 	//List Item Events
// 	//Function To Call on ng-click
// 		$rootScope.AssignValueAndHide = function(index){

// 			if($rootScope.element_name=='ledger_account_name')
// 			{		
// 				$scope.FormInputArray[$rootScope.index_value].ledger_account_name =
// 				$rootScope.suggestions[index];	
// 				var str=$scope.FormInputArray[$rootScope.index_value].ledger_account_name;			
// 				var id=str.substring(str.lastIndexOf("#")+1,str.lastIndexOf(")"));	
// 				var data_link=BaseUrl+"ledger_account_id/"+id;					
// 				//console.log(data_link);					
// 				$http.get(data_link).then(function(response){
// 					angular.forEach(response.data,function(value,key){
// 						$scope.FormInputArray[$rootScope.index_value].ledger_account_id=value.id;
// 						$scope.FormInputArray[$rootScope.index_value].ledger_account_name=value.name;
// 						$scope.FormInputArray[$rootScope.index_value].detailtype=value.COST_CENTER;
// 						console.log('$scope.FormInputArray[$rootScope.index_value].detailtype'+
// 						$scope.FormInputArray[$rootScope.index_value].detailtype);

// 					});
// 				});
// 			}

// 			if($rootScope.element_name=='BILLNO')
// 			{		
// 				var str=$scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].BILL_INSTRUMENT_NO =
// 				$rootScope.suggestions[index];	
				
// 			//	var str=$scope.FormInputArray[$rootScope.index_value].ledger_account_name;			
// 				var id=str.substring(str.lastIndexOf("#")+1,str.lastIndexOf(")"));	
// 				var data_link=BaseUrl+"BILLID/"+id;					
// 				//console.log(data_link);					
// 				$http.get(data_link).then(function(response){
// 					angular.forEach(response.data,function(value,key){
// 						$scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].bill_id =value.id;
// 						$scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].BILL_INSTRUMENT_NO =value.name;
// 						$scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].AMOUNT =value.bill_due_amt;
											
// 					});
// 				});
				
// 			}

// 			if($rootScope.element_name=='truck_no')
// 			{				
				
// 				var str=$scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].truck_no =
// 				$rootScope.suggestions[index];					
// 				console.log(str);

// 				var id=str.substring(str.lastIndexOf("#")+1,str.lastIndexOf(")"));	
// 				var data_link=BaseUrl+"truck_id/"+id;		
					
// 				//console.log(data_link);					
// 				$http.get(data_link).then(function(response){
// 					angular.forEach(response.data,function(value,key){
// 						$scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].truck_id =value.id;
// 						$scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].truck_no =value.name;
											
// 					});
// 				});

// 			}

// 			if($rootScope.element_name=='EMPLOYEE_NAME')
// 			{	
// 				var str=$scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].EMPLOYEE_NAME =
// 				$rootScope.suggestions[index];					
// 				console.log(str);

// 				var id=str.substring(str.lastIndexOf("#")+1,str.lastIndexOf(")"));	
// 				var data_link=BaseUrl+"employee_id/"+id;		
					
// 				console.log(data_link);					
// 				$http.get(data_link).then(function(response){
// 					angular.forEach(response.data,function(value,key){
// 						$scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].employee_id =value.id;
// 						$scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].EMPLOYEE_NAME =value.name;
// 						$scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].truck_id =value.truck_id;
// 						$scope.FormInputArray[$rootScope.index_value]['details'][$rootScope.child_index].truck_no =value.truck_no;
											
// 					});
// 				});
// 			}

// 			$rootScope.suggestions=[];
// 			$rootScope.searchItems=[];
// 			$rootScope.selectedIndex = -1;
// 		};
	
// 	//===================END SEARCH SECTION =========================================
	

// 	$scope.savedata=function()
// 	{
// 		var data_link=BaseUrl+"SAVE";
// 		var success={};		
// 		sessionStorage.setItem("selecteddate", $rootScope.FormInputArray[0].tran_date);

// 		var data_save = JSON.stringify($rootScope.FormInputArray);	
// 		console.log(data_save);

// 		var config = {headers : 
// 			{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
// 		}		
// 		$http.post(data_link,data_save,config)
// 		.then (function success(response){	
// 			$scope.savemsg='Receord Has been saved Successfully!';
// 			$scope.get_set_value(response.data,'','RE_INITIAL_INPUT_ARRAY');
// 		},
// 		function error(response){
// 			$scope.errorMessage = 'Error - Receord Not Saved!';
// 			$scope.message = '';
// 	  });

// 	}

// 	$scope.get_set_value=function(datavalue,datatype,operation)
// 	{
// 		if(operation=='SETVALUE')
// 		{
// 			if(angular.isUndefined(datavalue)==true)
// 			{
// 				if(datatype=='num')
// 				{return 0;}
// 				if(datatype=='str')
// 				{return '';}		
// 			}
// 			else
// 			{return datavalue;}
// 		}
// 		if(operation=='DRCRCHECKING')
// 		{	
// 			var operation_status='OK';
// 			if(Number($rootScope.TotalDrAmt)!=Number($rootScope.TotalCrAmt))
// 			{ 
// 				operation_status='NOTOK'
// 				$scope.savemsg='Debit and Credit Amount must be same';
// 			}		
// 			if(operation_status=='OK')
// 			{$scope.savedata();}

// 		}
		
// 		if(operation=='RE_INITIAL_INPUT_ARRAY')
// 		{		
// 			$rootScope.FormInputArray.length=0;		

// 			$rootScope.FormInputArray[0] =
// 			{	
// 			id_header:'',
// 			id_detail:'',
// 			trantype:'',
// 			truck_id:'',
// 			truck_no:'',
// 			employee_id:'',
// 			employee_name:'',
// 			tran_code:'',	
// 			tran_date:sessionStorage.getItem("selecteddate"),
// 			CRDR_TYPE:'CR',
// 			ledger_account_id:'',
// 			ledger_account_name:'',
// 			ledger_amount:'',				
// 			transaction_details:'',
// 			detailtype:'NA',//BANK,BILL/NA/TT_FUEL_EXP/TT_OTHER_EXP
// 			details:[{bill_id:'',BILL_INSTRUMENT_NO:'',EMPLOYEE_NAME:'',
// 			employee_id:'',truck_no:'',truck_id:'',TRAN_DATE:'',tripId:'',dsl_qnty:''
// 			,dsl_rate:'',trip_cashamt:'',AMOUNT:'',CHQDATE:'',BANKNAME:'',BRANCH:''}]
// 		};

// 			$rootScope.TotalDrAmt=0;
// 			$rootScope.TotalCrAmt=0;
// 			$rootScope.TotalBalanceAmt=0;
// 			$rootScope.maxloopvalue=$rootScope.FormInputArray.length-1;
// 			document.getElementById('tran_date').focus();
// 		}

// 		if(operation=='VIEWALLVALUE')
// 		{	
			
// 			var data_link=BaseUrl+"VIEWALLVALUE/"+datavalue;
// 			console.log(data_link);
// 			$http.get(data_link).then(function(response) 
// 			{
// 				//console.log(response.data);
// 				angular.forEach(response.data,function(value,key){
					
// 						$rootScope.FormInputArray[key] =
// 						{	
// 							id_header:value.id_header,
// 							id_detail:value.id_detail,
// 							trantype:value.trantype,
// 							truck_id:value.truck_id,
// 							truck_no:value.truck_no,
// 							employee_id:value.employee_id,
// 							employee_name:value.employee_name,
// 							tran_code:value.tran_code,	
// 							tran_date:value.tran_date,
// 							CRDR_TYPE:value.CRDR_TYPE,
// 							ledger_account_id:value.ledger_account_id,
// 							ledger_account_name:value.ledger_account_name,
// 							ledger_amount:value.ledger_amount,				
// 							transaction_details:value.transaction_details,						
// 							detailtype:value.detailtype,//BANK,BILL/NA						
// 							details:value.details						
// 						};
// 						//console.log('Array key'+key+'cr_ledger_account_name '+value.ledger_account_name);
						
// 				});	
// 				for(var i=1; i<=$rootScope.maxloopvalue-1;i++)
// 				{							
// 					if(Number($scope.FormInputArray[i].cr_ledger_account || 0)==0)
// 					{$scope.FormInputArray.splice(i, 1);}					
// 				}
// 				$rootScope.maxloopvalue=$rootScope.FormInputArray.length-1;
// 				console.log('Array length'+$rootScope.FormInputArray.length);

// 			});		
	
// 		//	FormInputArray
// 		}


// 	}
	
	
// 	$scope.GetAllList=function(fromdate,todate){
// 			//var BaseUrl=domain_name+"Primary_sale_controller/ConsignmentList/";
// 			//data list GetAllConsignment			
// 			var data_link=BaseUrl+'GetAllList/'+AcTranType+'/-/-/'+fromdate+'/'+todate;
// 			console.log(data_link);
// 			$http.get(data_link).then(function(response) 
// 			{$scope.ListOfTransactions=response.data;});
// 	}
	
// 	$scope.print_consignment = function() 
// 	{ 
// 		var data_link=domain_name+"Primary_sale_controller/builty_print/print_builty/"+$scope.id_header;
// 		window.popup(data_link); 
// 	};

// }]);







