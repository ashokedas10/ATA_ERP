//CRUD VIDEO
// https://www.youtube.com/watch?v=DB-kVs76XZ4
//https://www.codeproject.com/Tips/872181/CRUD-in-Angular-js
//https://github.com/chieffancypants/angular-hotkeys/ 
//http://www.codexworld.com/angularjs-crud-operations-php-mysql/
'use strict';

//var domain_name="http://astraford.co.in/";

//var domain_name="http://astraford.co.in/astaford_erp/";

//var domain_name="http://astraford.co.in/erp_test/";

//var domain_name="http://ataproject.co.in/ataerp/";

var domain_name="http://localhost/pharma_management/astaford_erp/";

var query_result_link=domain_name+"Accounts_controller/query_result/";
//************************ACCOUNT RECEIVE START*****************************************//
var app = angular.module('Accounts',['GeneralServices']);

app.controller('LOV',['$scope','$rootScope','$http',
function($scope,$rootScope,$http){
	"use strict";
	
			$scope.products={};
			$scope.ledgers={};
			$rootScope.FormInputArray=[];	

			var BaseUrl=domain_name+"Project_controller/list_of_values/";
			var AcTranType;
			// $scope.initarray=function(trantype){		
			// 	BaseUrl=BaseUrl+trantype+'/';	
			// 	AcTranType=trantype;
			// }

			var CurrentDate=new Date();
			var year = CurrentDate.getFullYear();
			var month = CurrentDate.getMonth()+1;
			var dt = CurrentDate.getDate();
			if (dt < 10) {	dt = '0' + dt;}
			if (month < 10) {month = '0' + month;}
			$scope.tran_date=year+'-' + month + '-'+dt;
			
			
			var data_link=query_result_link+"32/";$http.get(data_link).then(function(response) {$scope.master_lovs=response.data;});
			console.log(data_link);
			var data_link=query_result_link+"33/";$http.get(data_link).then(function(response) {$scope.active_inactive_list=response.data;});

			console.log(data_link);
						
			$scope.entry_index=0;
			$scope.transetting='ENTRY';	
			$scope.id_header=0;

			$rootScope.FormInputArray[0] =
			{	
					id_header:0,	
					list_of_values:[{id_detail:'',FieldVal:'',comment:'',display_order:'',active_inactive:'ACTIVE'}]				
			};

			$scope.new_entry=function()
			{
				$rootScope.FormInputArray[0] =
				{	
						id_header:0,	
						list_of_values:[{id_detail:'',FieldVal:'',comment:'',display_order:'',active_inactive:'ACTIVE'}]				
				};
			}

			$scope.add_entry=function(detail_type)
			{
				console.log(detail_type);
				if(detail_type=='lov_list')
				{
					var length=$rootScope.FormInputArray[0].list_of_values.length;					
					$scope.FormInputArray[0].list_of_values[length]={id_detail:'',FieldVal:'',comment:'',display_order:'',active_inactive:'ACTIVE'};				

				}			
			}
			
			$scope.view_list=function(id_header)
			{
				var data_link=BaseUrl+"VIEWALLVALUE/"+id_header+'/';
				console.log(data_link);
				$http.get(data_link).then(function(response) 
				{
					angular.forEach(response.data,function(value,key)
					{
						$rootScope.FormInputArray[0] =
							{	
								id_header:value.id_header,											
								list_of_values:value.list_of_values							
							};		
					});	
				});	

				// $scope.id_header=id_header;
				// $rootScope.transetting='ENTRY';	
				// $scope.form_control();

			}		
		
							
			$scope.savedata=function()
			{
				var data_link=BaseUrl+"SAVE/";
				console.log(data_link);
				var success={};		
			
				var data_save = JSON.stringify($rootScope.FormInputArray);	
			    	console.log(data_save);

				var config = {headers : 
					{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
				}		
				$http.post(data_link,data_save,config)
				.then (function success(response){	
					$scope.savemsg=response.data.server_msg;
					$scope.id_header=response.data.id_header;
					console.log($scope.savemsg);
					$scope.new_entry();

				},
				function error(response){
					$scope.errorMessage = 'Error - Receord Not Saved!';
					$scope.message = '';
				});

			}
	
}]);


app.controller('ROLLE_MAPPING',['$scope','$rootScope','$http',
function($scope,$rootScope,$http){
	"use strict";
	
			$scope.products={};
			$scope.ledgers={};
			$rootScope.FormInputArray=[];	

			var BaseUrl=domain_name+"Project_controller/roll_mapping/";
			var AcTranType;
			// $scope.initarray=function(trantype){		
			// 	BaseUrl=BaseUrl+trantype+'/';	
			// 	AcTranType=trantype;
			// }

			var CurrentDate=new Date();
			var year = CurrentDate.getFullYear();
			var month = CurrentDate.getMonth()+1;
			var dt = CurrentDate.getDate();
			if (dt < 10) {	dt = '0' + dt;}
			if (month < 10) {month = '0' + month;}
			$scope.tran_date=year+'-' + month + '-'+dt;
			
			var data_link=query_result_link+"34/";$http.get(data_link).then(function(response) {$scope.menu_list=response.data;});
			console.log(data_link);
			
			var data_link=query_result_link+"38/";$http.get(data_link).then(function(response) {$scope.master_lovs=response.data;});
			console.log(data_link);
			var data_link=query_result_link+"33/";$http.get(data_link).then(function(response) {$scope.active_inactive_list=response.data;});
			console.log(data_link);
						
			$scope.entry_index=0;
			$scope.transetting='ENTRY';	
			$scope.id_header=0;

			$rootScope.FormInputArray[0] =
			{	
					id_header:0,	
					list_of_values:[{id_detail:'',FieldVal:'',comment:'',display_order:'',active_inactive:'ACTIVE'}]				
			};

			$scope.new_entry=function()
			{
				$rootScope.FormInputArray[0] =
				{	
						id_header:0,	
						list_of_values:[{id_detail:'',FieldVal:'',comment:'',display_order:'',active_inactive:'ACTIVE'}]				
				};
			}

			$scope.add_entry=function(detail_type)
			{
				console.log(detail_type);
				if(detail_type=='lov_list')
				{
					var length=$rootScope.FormInputArray[0].list_of_values.length;					
					$scope.FormInputArray[0].list_of_values[length]={id_detail:'',FieldVal:'',comment:'',display_order:'',active_inactive:'ACTIVE'};				

				}			
			}
			
			$scope.view_list=function(id_header)
			{
				var data_link=BaseUrl+"VIEWALLVALUE/"+id_header+'/';
				console.log(data_link);
				$http.get(data_link).then(function(response) 
				{
					angular.forEach(response.data,function(value,key)
					{
						$rootScope.FormInputArray[0] =
							{	
								id_header:value.id_header,											
								list_of_values:value.list_of_values							
							};		
					});	
				});	

				// $scope.id_header=id_header;
				// $rootScope.transetting='ENTRY';	
				// $scope.form_control();

			}		
		
							
			$scope.savedata=function()
			{
				var data_link=BaseUrl+"SAVE/";
				console.log(data_link);
				var success={};		
			
				var data_save = JSON.stringify($rootScope.FormInputArray);	
			    	console.log(data_save);

				var config = {headers : 
					{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
				}		
				$http.post(data_link,data_save,config)
				.then (function success(response){	
					$scope.savemsg=response.data.server_msg;
					$scope.id_header=response.data.id_header;
					console.log($scope.savemsg);
					$scope.new_entry();

				},
				function error(response){
					$scope.errorMessage = 'Error - Receord Not Saved!';
					$scope.message = '';
				});

			}
	
}]);


app.controller('CODE_STRUCTURE',['$scope','$rootScope','$http',
function($scope,$rootScope,$http){
	"use strict";
	
			$scope.products={};
			$scope.ledgers={};
			$rootScope.FormInputArray=[];	
			$scope.codestructure1_id=0;

			var BaseUrl=domain_name+"Project_controller/code_structure/";
			var AcTranType;
			// $scope.initarray=function(trantype){		
			// 	BaseUrl=BaseUrl+trantype+'/';	
			// 	AcTranType=trantype;
			// }

			var CurrentDate=new Date();
			var year = CurrentDate.getFullYear();
			var month = CurrentDate.getMonth()+1;
			var dt = CurrentDate.getDate();
			if (dt < 10) {	dt = '0' + dt;}
			if (month < 10) {month = '0' + month;}
			$scope.tran_date=year+'-' + month + '-'+dt;
			
			var data_link=query_result_link+"40/";$http.get(data_link).then(function(response) {$scope.qualifier_list1=response.data;});			
			var data_link=query_result_link+"43/";$http.get(data_link).then(function(response) {$scope.qualifier_list2=response.data;});
			console.log(data_link);

			var data_link=query_result_link+"39/";$http.get(data_link).then(function(response) {$scope.code_type_id_list=response.data;});
			var data_link=query_result_link+"33/";$http.get(data_link).then(function(response) {$scope.active_inactive_list=response.data;});	
		
		


									
			$scope.entry_index=0;
			$scope.transetting='ENTRY';	
			$scope.id_header=0;

			$rootScope.FormInputArray[0] =
			{	
					id_header:0,
					code_structure1:
					[
						{
							id:0,parent_id:0,code:'',value:'',code_type_id:0,code_main_id:0,active_inactive:'ACTIVE',startdate:'',enddate:'',description:'',
								code_structure2:
								[
									{		id:0,parent_id:0,code:'',value:'',code_type_id:0,code_main_id:0,active_inactive:'ACTIVE',startdate:'',enddate:'',description:'',
											code_structure3:
											[{id:0,parent_id:0,code:'',value:'',code_type_id:0,code_main_id:0,active_inactive:'ACTIVE',startdate:'',enddate:'',description:''}]
									}
								]
					  }					
					]								
			};

			$scope.new_entry=function()
			{
				$rootScope.FormInputArray[0] =
				{	
						id_header:0,
						code_structure1:
						[
							{
								id:0,parent_id:0,code:'',value:'',code_type_id:0,code_main_id:0,active_inactive:'ACTIVE',startdate:'',enddate:'',description:'',
									code_structure2:
									[
										{		id:0,parent_id:0,code:'',value:'',code_type_id:0,code_main_id:0,active_inactive:'ACTIVE',startdate:'',enddate:'',description:'',
												code_structure3:
												[{id:0,parent_id:0,code:'',value:'',code_type_id:0,code_main_id:0,active_inactive:'ACTIVE',startdate:'',enddate:'',description:''}]
										}
									]
							}					
						]								
				};
				
			}

			$scope.add_code_structure=function(struc_type,indxno,indxno2)
			{
					console.log(struc_type);
					if(struc_type=='1')
					{
						var length=$rootScope.FormInputArray[0].code_structure1.length;					
						$scope.FormInputArray[0].code_structure1[length]=
						{
							id:'',parent_id:0,code:'',value:'',code_type_id:0,code_main_id:0,active_inactive:'ACTIVE',startdate:'',enddate:'',description:'',
								code_structure2:
								[
									{		id:'',parent_id:0,code:'',value:'',code_type_id:0,code_main_id:0,active_inactive:'ACTIVE',startdate:'',enddate:'',description:'',
											code_structure3:
											[{id:'',parent_id:0,code:'',value:'',code_type_id:0,code_main_id:0,active_inactive:'ACTIVE',startdate:'',enddate:'',description:''}]
									}
								]
						};				
					}		
					
					if(struc_type=='2')
					{
						var length=$rootScope.FormInputArray[0].code_structure1[indxno].code_structure2.length;					
						$scope.FormInputArray[0].code_structure1[indxno].code_structure2[length]=
						{id:'',parent_id:0,code:'',value:'',code_type_id:0,code_main_id:0,active_inactive:'ACTIVE',startdate:'',enddate:'',description:'',
							code_structure3:
							[{id:'',parent_id:0,code:'',value:'',code_type_id:0,code_main_id:0,active_inactive:'ACTIVE',startdate:'',enddate:'',description:''}]
						};				
					}			

					if(struc_type=='3')
					{
						var length=$rootScope.FormInputArray[0].code_structure1[indxno].code_structure2[indxno2].code_structure3.length;					
						$scope.FormInputArray[0].code_structure1[indxno].code_structure2[indxno2].code_structure3[length]=
						{id:'',parent_id:0,code:'',value:'',code_type_id:0,code_main_id:0,active_inactive:'ACTIVE',startdate:'',enddate:'',description:''};
										
					}			

					var data_save = JSON.stringify($rootScope.FormInputArray);	
			    	console.log(data_save);
			}

		

			$scope.open_code_structure2=function(event,indx_val,divid)
			{
				//console.log('event.keyCode'+event.keyCode+' val:'+val);
				$scope.code1_index=indx_val;
				if(event.keyCode === 120)
				{ 
					//console.log('event.keyCode'+event.keyCode);
					$scope.code1_index=indx_val;
					window.shortcut(event.keyCode,divid);
				
				}				
			}

			$rootScope.$watch('code1_index',function(val){		
				if(val !== -1) {			
					//$scope[$rootScope.searchelement] =$rootScope.suggestions[$rootScope.selectedIndex]['name'];			
					$scope.code1_index=val;	
				}
			});		

			$scope.open_code_structure3=function(event,indx1_val,indx2_val,divid)
			{
				$scope.code1_index=indx1_val;
				$scope.code2_index=indx2_val;
				if(event.keyCode === 120)
				{ 
					window.shortcut(event.keyCode,divid);				
				}				
			}
			$rootScope.$watch('code2_index',function(val){		
				if(val !== -1) {			
					//$scope[$rootScope.searchelement] =$rootScope.suggestions[$rootScope.selectedIndex]['name'];			
					$scope.code2_index=val;	
				}
			});		


			
			$scope.view_list=function(id_header)
			{
				var data_link=BaseUrl+"VIEWALLVALUE/"+id_header+'/';
				console.log(data_link);
				$http.get(data_link).then(function(response) 
				{
					angular.forEach(response.data,function(value,key)
					{
						$rootScope.FormInputArray[0] =
							{	
								id_header:value.id_header,											
								code_structure1:value.code_structure1							
							};		
					});	
				});	

				// $scope.id_header=id_header;
				// $rootScope.transetting='ENTRY';	
				// $scope.form_control();

			}		
			$scope.view_list(1);
			
		
							
			$scope.savedata=function()
			{
				var data_link=BaseUrl+"SAVE/";
				console.log(data_link);
				var success={};		
			
				var data_save = JSON.stringify($rootScope.FormInputArray);	
			    	console.log(data_save);

				var config = {headers : 
					{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
				}		
				$http.post(data_link,data_save,config)
				.then (function success(response){	
					$scope.savemsg=response.data.server_msg;
					$scope.id_header=response.data.id_header;
					console.log($scope.savemsg);
					$scope.new_entry();
					$scope.view_list(1);

				},
				function error(response){
					$scope.errorMessage = 'Error - Receord Not Saved!';
					$scope.message = '';
				});

			}

			
	
}]);

app.controller('calendar',['$scope','$rootScope','$http',
function($scope,$rootScope,$http){
	"use strict";
	
			$scope.products={};
			$scope.ledgers={};
			$rootScope.FormInputArray=[];	

			var BaseUrl=domain_name+"Project_controller/calendar/";
			var AcTranType;


			var CurrentDate=new Date();
			var year = CurrentDate.getFullYear();
			var month = CurrentDate.getMonth()+1;
			var dt = CurrentDate.getDate();
			if (dt < 10) {	dt = '0' + dt;}
			if (month < 10) {month = '0' + month;}
			$scope.tran_date=year+'-' + month + '-'+dt;
			
			
			var data_link=query_result_link+"44/";$http.get(data_link).then(function(response) {$scope.master_lovs=response.data;});
			console.log(data_link);
			var data_link=query_result_link+"33/";$http.get(data_link).then(function(response) {$scope.active_inactive_list=response.data;});

			console.log(data_link);
						
			$scope.entry_index=0;
			$scope.transetting='ENTRY';	
			$scope.id_header=0;

			$rootScope.FormInputArray[0] =
			{	
					id_header:0,	
					list_of_values:[{id:'',period_type:'',period_per_year:'',description:'',prefix:'',year:'',quater:'',month_num:'',fromdate:'',todate:''
					,status:'ACTIVE',name:''}]				
			};

			$scope.new_entry=function()
			{
				$rootScope.FormInputArray[0] =
				{	
						id_header:0,	
						list_of_values:[{id:'',period_type:'',period_per_year:'',description:'',prefix:'',year:'',quater:'',month_num:'',fromdate:'',todate:''
						,status:'ACTIVE',name:''}]				
				};
			}

			$scope.add_entry=function(detail_type)
			{
				console.log(detail_type);
				if(detail_type=='lov_list')
				{
					var length=$rootScope.FormInputArray[0].list_of_values.length;					
					$scope.FormInputArray[0].list_of_values[length]=
					{id:'',period_type:'',period_per_year:'',description:'',prefix:'',year:'',quater:'',month_num:'',fromdate:'',todate:'',status:'ACTIVE',name:''};				

				}			
			}
			
			$scope.view_list=function(id_header)
			{
				var data_link=BaseUrl+"VIEWALLVALUE/"+id_header+'/';
				console.log(data_link);
				$http.get(data_link).then(function(response) 
				{
					angular.forEach(response.data,function(value,key)
					{
						$rootScope.FormInputArray[0] =
							{	
								id_header:value.id_header,											
								list_of_values:value.list_of_values							
							};		
					});	
				});	

				// $scope.id_header=id_header;
				// $rootScope.transetting='ENTRY';	
				// $scope.form_control();

			}		
		
							
			$scope.savedata=function()
			{
				var data_link=BaseUrl+"SAVE/";
				console.log(data_link);
				var success={};		
			
				var data_save = JSON.stringify($rootScope.FormInputArray);	
			    	console.log(data_save);

				var config = {headers : 
					{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
				}		
				$http.post(data_link,data_save,config)
				.then (function success(response){	
					$scope.savemsg=response.data.server_msg;
					$scope.id_header=response.data.id_header;
					console.log($scope.savemsg);
					$scope.new_entry();

				},
				function error(response){
					$scope.errorMessage = 'Error - Receord Not Saved!';
					$scope.message = '';
				});

			}
	
}]);

app.controller('currency_daily_rate',['$scope','$rootScope','$http',
function($scope,$rootScope,$http){
	"use strict";
	
			$scope.products={};
			$scope.ledgers={};
			$rootScope.FormInputArray=[];	
			$scope.codestructure1_id=0;

			var BaseUrl=domain_name+"Project_controller/currency_daily_rate/";
			var AcTranType;
			// $scope.initarray=function(trantype){		
			// 	BaseUrl=BaseUrl+trantype+'/';	
			// 	AcTranType=trantype;
			// }

			var CurrentDate=new Date();
			var year = CurrentDate.getFullYear();
			var month = CurrentDate.getMonth()+1;
			var dt = CurrentDate.getDate();
			if (dt < 10) {	dt = '0' + dt;}
			if (month < 10) {month = '0' + month;}
			$scope.tran_date=year+'-' + month + '-'+dt;
			
			//var currency_list="https://api.exchangeratesapi.io/latest?symbols=USD,INR";
			//var data_link=query_result_link+"42/";
			//var data_link=currency_list

			var data_link=query_result_link+"42/";
			$http.get(data_link).then(function(response) {$scope.currency_master_list=response.data;});
			
			//console.log(currency_list);
									
			$scope.entry_index=0;
			$scope.transetting='ENTRY';	
			$scope.id_header=0;

			$rootScope.FormInputArray[0] =
			{	
					id_header:0,
					code_structure1:
					[{id:0,from_currency_id:0,to_currency_id:0,trandate:'',from_to_rate:'',to_from_rate:''}]								
			};

			$scope.new_entry=function()
			{
				$rootScope.FormInputArray[0] =
				{	
						id_header:0,
						code_structure1:
						[{id:0,from_currency_id:0,to_currency_id:0,trandate:'',from_to_rate:'',to_from_rate:''}]								
				};				
			}

			$scope.add_code_structure=function()
			{
					
					var length=$rootScope.FormInputArray[0].code_structure1.length;					
					$scope.FormInputArray[0].code_structure1[length]=
					{id:0,from_currency_id:0,to_currency_id:0,trandate:'',from_to_rate:'',to_from_rate:''};			

					var data_save = JSON.stringify($rootScope.FormInputArray);	
			    	console.log(data_save);
			}
			
			$scope.view_list=function(id_header)
			{
				var data_link=BaseUrl+"VIEWALLVALUE/"+id_header+'/';
				console.log(data_link);
				$http.get(data_link).then(function(response) 
				{
					angular.forEach(response.data,function(value,key)
					{
						$rootScope.FormInputArray[0] =
							{	
								id_header:value.id_header,											
								code_structure1:value.code_structure1							
							};		
					});	
				});	

				// $scope.id_header=id_header;
				// $rootScope.transetting='ENTRY';	
				// $scope.form_control();

			}		
			$scope.view_list(1);
			
		
							
			$scope.savedata=function()
			{
				var data_link=BaseUrl+"SAVE/";
				console.log(data_link);
				var success={};		
			
				var data_save = JSON.stringify($rootScope.FormInputArray);	
			    	console.log(data_save);

				var config = {headers : 
					{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
				}		
				$http.post(data_link,data_save,config)
				.then (function success(response){	
					$scope.savemsg=response.data.server_msg;
					$scope.id_header=response.data.id_header;
					console.log($scope.savemsg);
					$scope.new_entry();
					$scope.view_list(1);

				},
				function error(response){
					$scope.errorMessage = 'Error - Receord Not Saved!';
					$scope.message = '';
				});

			}			
	
}]);

//************************INVALID PORTION*****************************************//

app.controller('CODE_STRUCTURE_ORIGINAL',['$scope','$rootScope','$http',
function($scope,$rootScope,$http){
	"use strict";
	
			$scope.products={};
			$scope.ledgers={};
			$rootScope.FormInputArray=[];	

			$scope.codestructure1_id=0;

			var BaseUrl=domain_name+"Project_controller/code_structure/";
			var AcTranType;
			// $scope.initarray=function(trantype){		
			// 	BaseUrl=BaseUrl+trantype+'/';	
			// 	AcTranType=trantype;
			// }

			var CurrentDate=new Date();
			var year = CurrentDate.getFullYear();
			var month = CurrentDate.getMonth()+1;
			var dt = CurrentDate.getDate();
			if (dt < 10) {	dt = '0' + dt;}
			if (month < 10) {month = '0' + month;}
			$scope.tran_date=year+'-' + month + '-'+dt;
			
			// var data_link=query_result_link+"34/";$http.get(data_link).then(function(response) {$scope.menu_list=response.data;});
			// console.log(data_link);
	
			
			var data_link=query_result_link+"39/";$http.get(data_link).then(function(response) {$scope.code_type_id_list=response.data;});
			console.log(data_link);
			var data_link=query_result_link+"40/";$http.get(data_link).then(function(response) {$scope.main_id_list=response.data;});
			console.log(data_link);
						
			$scope.entry_index=0;
			$scope.transetting='ENTRY';	
			$scope.id_header=0;

			$rootScope.FormInputArray[0] =
			{	
					id_header:0,	
					list_of_values:[{id_detail:'',FieldVal:'',code_type_id:'',code_main_id:'',active_inactive:'ACTIVE'}]				
			};

			$scope.new_entry=function()
			{
				$rootScope.FormInputArray[0] =
				{	
						id_header:0,	
						list_of_values:[{id_detail:'',FieldVal:'',code_type_id:'',code_main_id:'',active_inactive:'ACTIVE'}]				
				};
				
			}

			$scope.add_entry=function(detail_type)
			{
				console.log(detail_type);
				if(detail_type=='lov_list')
				{
					var length=$rootScope.FormInputArray[0].list_of_values.length;					
					$scope.FormInputArray[0].list_of_values[length]={id_detail:'',FieldVal:'',code_type_id:'',code_main_id:'',active_inactive:'ACTIVE'};				

				}			
			}
			
			$scope.view_list=function(id_header)
			{
				var data_link=BaseUrl+"VIEWALLVALUE/"+id_header+'/';
				console.log(data_link);
				$http.get(data_link).then(function(response) 
				{
					angular.forEach(response.data,function(value,key)
					{
						$rootScope.FormInputArray[0] =
							{	
								id_header:value.id_header,											
								list_of_values:value.list_of_values							
							};		
					});	
				});	

				// $scope.id_header=id_header;
				// $rootScope.transetting='ENTRY';	
				// $scope.form_control();

			}		
			$scope.view_list(1);
			
		
							
			$scope.savedata=function()
			{
				var data_link=BaseUrl+"SAVE/";
				console.log(data_link);
				var success={};		
			
				var data_save = JSON.stringify($rootScope.FormInputArray);	
			    	console.log(data_save);

				var config = {headers : 
					{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
				}		
				$http.post(data_link,data_save,config)
				.then (function success(response){	
					$scope.savemsg=response.data.server_msg;
					$scope.id_header=response.data.id_header;
					console.log($scope.savemsg);
					$scope.new_entry();
					$scope.view_list(1);

				},
				function error(response){
					$scope.errorMessage = 'Error - Receord Not Saved!';
					$scope.message = '';
				});

			}


		

			$scope.open_code_structure2=function(event,val)
			{
				//console.log('event.keyCode'+event.keyCode+' val:'+val);
				$scope.codestructure1_id=val;

				if(event.keyCode === 120)
				{ 
					//console.log('event.keyCode'+event.keyCode);
					$scope.codestructure1_id=val;
					window.shortcut(event.keyCode);
				
				}				
			}

			$rootScope.$watch('codestructure1_id',function(val){		
				if(val !== -1) {			
					//$scope[$rootScope.searchelement] =$rootScope.suggestions[$rootScope.selectedIndex]['name'];			
					$scope.codestructure1_id=val;	
				}
			});		
	
}]);


app.controller('CHART_OF_ACCOUNTS',['$scope','$rootScope','$http',
function($scope,$rootScope,$http){
	"use strict";
	
			$scope.products={};
			$scope.ledgers={};
			$rootScope.FormInputArray=[];	

			var BaseUrl=domain_name+"Project_controller/chart_of_accounts/";
			var AcTranType;
			// $scope.initarray=function(trantype){		
			// 	BaseUrl=BaseUrl+trantype+'/';	
			// 	AcTranType=trantype;
			// }

			var CurrentDate=new Date();
			var year = CurrentDate.getFullYear();
			var month = CurrentDate.getMonth()+1;
			var dt = CurrentDate.getDate();
			if (dt < 10) {	dt = '0' + dt;}
			if (month < 10) {month = '0' + month;}
			$scope.tran_date=year+'-' + month + '-'+dt;
			
			// var data_link=query_result_link+"34/";$http.get(data_link).then(function(response) {$scope.menu_list=response.data;});
			// console.log(data_link);
			
			var data_link=query_result_link+"41/";$http.get(data_link).then(function(response) {$scope.chart_of_accounts_list=response.data;});
			console.log(data_link);

			var data_link=query_result_link+"33/";$http.get(data_link).then(function(response) {$scope.active_inactive_list=response.data;});
			console.log(data_link);
						
			$scope.entry_index=0;
			$scope.transetting='ENTRY';	
			$scope.id_header=0;

			$rootScope.FormInputArray[0] =
			{	
					id_header:0,	
					list_of_values:[{id_detail:'',FieldVal:'',code:'',startdate:'',enddate:'',active_inactive:'ACTIVE'}]				
			};

			$scope.new_entry=function()
			{
				$rootScope.FormInputArray[0] =
				{	
						id_header:0,	
						list_of_values:[{id_detail:'',FieldVal:'',code:'',startdate:'',enddate:'',active_inactive:'ACTIVE'}]				
				};
			}

			$scope.add_entry=function(detail_type)
			{
				console.log(detail_type);
				if(detail_type=='lov_list')
				{
					var length=$rootScope.FormInputArray[0].list_of_values.length;					
					$scope.FormInputArray[0].list_of_values[length]={id_detail:'',FieldVal:'',code:'',startdate:'',enddate:'',active_inactive:'ACTIVE'};				

				}			
			}
			
			$scope.view_list=function(id_header)
			{
				var data_link=BaseUrl+"VIEWALLVALUE/"+id_header+'/';
				console.log(data_link);
				$http.get(data_link).then(function(response) 
				{
					angular.forEach(response.data,function(value,key)
					{
						$rootScope.FormInputArray[0] =
							{	
								id_header:value.id_header,											
								list_of_values:value.list_of_values							
							};		
					});	
				});	

				// $scope.id_header=id_header;
				// $rootScope.transetting='ENTRY';	
				// $scope.form_control();

			}		
		
							
			$scope.savedata=function()
			{
				var data_link=BaseUrl+"SAVE/";
				console.log(data_link);
				var success={};		
			
				var data_save = JSON.stringify($rootScope.FormInputArray);	
			    	console.log(data_save);

				var config = {headers : 
					{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
				}		
				$http.post(data_link,data_save,config)
				.then (function success(response){	
					$scope.savemsg=response.data.server_msg;
					$scope.id_header=response.data.id_header;
					console.log($scope.savemsg);
					$scope.new_entry();

				},
				function error(response){
					$scope.errorMessage = 'Error - Receord Not Saved!';
					$scope.message = '';
				});

			}
	
}]);



app.controller('PurchaseEntry',['$scope','$rootScope','$http','Sale_test',
function($scope,$rootScope,$http,Sale_test)
{
	"use strict";

	//$scope.appState='EMIPAYMENT';
	//var domain_name="http://localhost/abir_das_unitedlab/SATNAM/";	
	var BaseUrl=domain_name+"Accounts_controller/AccountsTransactions/PurchaseEntry/";
		$scope.tran_date=$rootScope.tran_date;
		document.getElementById('0').focus();
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


		$scope.mainOperation=function(event,element_name)
		{	
			
				console.log('element_name '+element_name);

		  	if(event.keyCode === 13)
				{	
				
					if(element_name===18)
					{document.getElementById('exp_monyr').focus();}		

					if(element_name===19)
					{document.getElementById('mfg_monyr').focus();}				
				
					element_name=Number(element_name+1);			
					document.getElementById(element_name).focus();		
				}		
				if(element_name===21)
				{
					$scope.get_set_value('','','DRCRCHECKING');
				  document.getElementById(12).focus();			
				}			

		 }

		$scope.delete_product=function(id)
		{	
		 
			var data_link=domain_name+"Accounts_controller/AccountsTransactions/DELETE_PRODUCT";			
			var success={};		
			var data_save = {'id': $scope.get_set_value(id,'num','SETVALUE')	};	
			console.log(data_save);	
			var config = {headers : 
				{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
			}
			//$http.post(data_link, data,config)
			$http.post(data_link,data_save,config).then (function success(response){

				$scope.get_set_value(response.data.id_header,'','VIEWALLVALUE');
				document.getElementById('product_id_name').focus();
				$scope.savemsg='Record Has been Deleted Successfully!';
				//console.log('ID HEADER '+response.data.id_header);
				//	$scope.get_set_value(response.data,'','REFRESH');
				//	document.getElementById('product_id_name').focus();
			},
			function error(response){
				$scope.errorMessage = 'Error adding user!';
				$scope.message = '';
			});

		}

		$scope.delete_invoice=function(id)
		{	
				var data_link=BaseUrl+"DELETE_INVOICE";		
				console.log(data_link);	
				var success={};		
				var data_save = {'id': $scope.get_set_value(id,'num','SETVALUE')	};	
				console.log(data_save);	
				var config = {headers : 
					{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
				}
				//$http.post(data_link, data,config)
				$http.post(data_link,data_save,config).then (function success(response){
					$scope.savemsg='invoice Has been Deleted Successfully!';
					$scope.GetAllList($scope.startdate,$scope.enddate);
					$scope.get_set_value(response.data,'','REFRESH');

				},
				function error(response){
					$scope.errorMessage = 'Error adding user!';
					$scope.message = '';
				});
		}


		$rootScope.partylist= [];		
		$rootScope.productlist=[];		
		$rootScope.hqlist=[];	
		$rootScope.batchlist=[];
		
		var data_link=query_result_link+"34/";
		console.log(data_link);
		$http.get(data_link).then(function(response){
			angular.forEach(response.data,function(value,key){					
				$rootScope.productlist.push({id: value.id,name:value.brand_name});
			});
		});
		
		var data_link=query_result_link+"35/";
		console.log(data_link);
		$http.get(data_link).then(function(response){
			angular.forEach(response.data,function(value,key){					
				$rootScope.partylist.push({id:value.id,name:value.acc_name});
			});
		});

		

		$rootScope.search = function(searchelement)
		{			
				
				$rootScope.searchelement=searchelement;
				$rootScope.suggestions = [];
				$rootScope.searchItems=[];
					
				console.log(searchelement);

				if($rootScope.searchelement=='product_id_name')
				{$rootScope.searchItems=$rootScope.productlist;}			
				else if($rootScope.searchelement=='batchno')
				{
					var data_link=BaseUrl+"batchno/"+$scope.product_id;	
					console.log(data_link);
					$http.get(data_link).then(function(response){
						angular.forEach(response.data,function(value,key){	
							if($rootScope.batchlist.indexOf($rootScope.batchlist[key]) === -1) {				
							$rootScope.batchlist.push({id:value.id,name:value.batchno,PURCHASEID:value.PURCHASEID
								,AVAILABLE_QTY:value.AVAILABLE_QTY,exp_monyr:value.exp_monyr,mfg_monyr:value.mfg_monyr});
							}
						});
					});		
					$rootScope.searchItems=$rootScope.batchlist;
				}	
				else if($rootScope.searchelement=='tbl_party_id_name')
				{$rootScope.searchItems=$rootScope.partylist; }	
				else if($rootScope.searchelement=='hq_id_name')
				{
					var data_link=BaseUrl+"hq_id_name/"+$scope.tbl_party_id;	
					console.log(data_link);
					$http.get(data_link).then(function(response){
						angular.forEach(response.data,function(value,key){	
							if($rootScope.hqlist.indexOf($rootScope.hqlist[key]) === -1) {				
							$rootScope.hqlist.push({id:value.id,name:value.name});
							}
						});
					});		
					$rootScope.searchItems=$rootScope.hqlist;
				}	
				else
				{}				
				
				$rootScope.searchItems.sort();	
				var myMaxSuggestionListLength = 0;
				for(var i=0; i<$rootScope.searchItems.length; i++)
				{					
						var searchItemsSmallLetters = angular.uppercase($rootScope.searchItems[i].name);
						var searchTextSmallLetters = angular.uppercase($scope[$rootScope.searchelement]);
						if( searchItemsSmallLetters.indexOf(searchTextSmallLetters) >=0)
						{
							if($rootScope.searchelement=='batchno')
							{
								$rootScope.suggestions.push({id:$rootScope.searchItems[i].id,name:$rootScope.searchItems[i].name,PURCHASEID:$rootScope.searchItems[i].PURCHASEID
									,AVAILABLE_QTY:$rootScope.searchItems[i].AVAILABLE_QTY,exp_monyr:$rootScope.searchItems[i].exp_monyr,mfg_monyr:$rootScope.searchItems[i].mfg_monyr});
							}
							else
							{$rootScope.suggestions.push({id: $rootScope.searchItems[i].id,name:$rootScope.searchItems[i].name} );}
							

							myMaxSuggestionListLength += 1;
							if(myMaxSuggestionListLength === 1500)
							{break;}
						}						
				}

				console.log($rootScope.suggestions);
		};
	
	$rootScope.$watch('selectedIndex',function(val){		
		if(val !== -1) {			
			$scope[$rootScope.searchelement] =$rootScope.suggestions[$rootScope.selectedIndex]['name'];				
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
		}
		else if(event.keyCode === 9){ //enter tab key
			//console.log($rootScope.selectedIndex);
			if($rootScope.selectedIndex>-1){
				$rootScope.AssignValueAndHide($rootScope.selectedIndex);
			}			

		}else if(event.keyCode === 27){ //ESC key, empty suggestions array
			$rootScope.AssignValueAndHide($rootScope.selectedIndex);
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
			// $rootScope.searchItems=[];
			// $rootScope.suggestions = [];			
			// $rootScope.selectedIndex = -1;
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
		$scope['tbl_party_id']=$rootScope.suggestions[index]['id'];  //ACTUAL ID
		$scope['tbl_party_id_name']=$rootScope.suggestions[index]['name'];  // NAME 			
	}

	if($rootScope.searchelement=='product_id_name')
	{		
		var id=$rootScope.suggestions[index]['id'];	
		var data_link=BaseUrl+"product_id/"+id;					
		console.log(data_link);					
		$http.get(data_link).then(function(response){
			angular.forEach(response.data,function(value,key){
				$scope['product_id']=value.id;  //ACTUAL ID
				$scope['product_id_name']=value.name; // NAME 	
				$scope['tax_ledger_id']=value.input_gst_ledger_id; // NAME 	
				$scope['tax_per']=value.tax_per; // NAME 				
				//$scope.previous_transaction_details(value.id);														
			});
		});
	
	}

		if($rootScope.searchelement=='hq_id_name')
		{
			$scope['hq_id']=$rootScope.suggestions[index]['id'];  //ACTUAL ID
			$scope['hq_id_name']=$rootScope.suggestions[index]['name'];  // NAME
		}

		if($rootScope.searchelement=='batchno')
		{			
			$scope['batchno']= $rootScope.suggestions[index]['name'];
			$scope['exp_monyr']= $rootScope.suggestions[index]['exp_monyr'];
			$scope['mfg_monyr']=$rootScope.suggestions[index]['mfg_monyr']; 
			$scope['rate']=$rootScope.suggestions[index]['rate']; 
			$scope['srate']=$rootScope.suggestions[index]['srate']; 
			$scope['mrp']=$rootScope.suggestions[index]['mrp']; 
			$scope['ptr']=$rootScope.suggestions[index]['ptr']; 
			$scope['AVAILABLE_QTY']=$rootScope.suggestions[index]['AVAILABLE_QTY'];  
		}
			
		 $rootScope.suggestions=[];
		 $rootScope.searchItems=[];		
		 $rootScope.selectedIndex = -1;
	};
	//===================END SEARCH SECTION =========================================




	$scope.savedata=function()
	{
		console.log('freeqty'+$scope.freeqty);

		
		var data_link=BaseUrl+"SAVE";
		var success={};		
		var data_save = {
			'id_header': $scope.get_set_value($scope.id_header,'num','SETVALUE'),
			'id_detail': $scope.get_set_value($scope.id_detail,'num','SETVALUE'),
			'hq_id': $scope.get_set_value($scope.hq_id,'num','SETVALUE'),
			'product_id': $scope.get_set_value($scope.product_id,'num','SETVALUE'),
			'MIX_RAW_LINK_ID': $scope.get_set_value($scope.MIX_RAW_LINK_ID,'num','SETVALUE'),
			'RELATED_TO_MIXER': $scope.get_set_value($scope.RELATED_TO_MIXER,'str','SETVALUE'),	
			'tbl_party_id': $scope.get_set_value($scope.tbl_party_id,'num','SETVALUE'),
			'invoice_no': $scope.get_set_value($scope.invoice_no,'str','SETVALUE'),
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
			'freeqty': $scope.get_set_value($scope.freeqty,'num','SETVALUE'),
			'ptr': $scope.get_set_value($scope.ptr,'num','SETVALUE'),
			'disc_per2': $scope.get_set_value($scope.disc_per2,'num','SETVALUE'),
			'tot_cash_discount': $scope.get_set_value($scope.tot_cash_discount,'num','SETVALUE'),
			'lrno': $scope.get_set_value($scope.lrno,'str','SETVALUE'),	
			'lrdate': $scope.get_set_value($scope.lrdate,'str','SETVALUE'),
			'orderno': $scope.get_set_value($scope.orderno,'str','SETVALUE'),
			'orderdate': $scope.get_set_value($scope.orderdate,'str','SETVALUE'),
			'transporter': $scope.get_set_value($scope.transporter,'str','SETVALUE'),
			'no_of_case': $scope.get_set_value($scope.no_of_case,'num','SETVALUE')

		};	
	
		var config = {headers : 
			{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
		}
		//$http.post(data_link, data,config)
		$http.post(data_link,data_save,config)
		.then (function success(response){
			console.log('ID HEADER '+response.data.id_header);
			$scope.get_set_value(response.data,'','REFRESH');
			document.getElementById('11').focus();
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

			$scope.lrno=$scope.lrdate=$scope.orderno=$scope.orderdate=$scope.transporter=$scope.no_of_case='';

			//DETAIL SECTION
			$scope.id_detail='';	
			$scope.product_id_name='';			
			$scope.product_id=$scope.batchno=$scope.qnty='';
			$scope.exp_monyr=$scope.mfg_monyr=$scope.rate='';
			$scope.mrp=$scope.ptr=$scope.srate=$scope.tax_per='';
			$scope.tax_ledger_id=$scope.disc_per='';
			$scope.product_id_name_mixer=$scope.disc_per2=$scope.Synonym=$scope.label_print='';
			$scope.ptr=	$scope.freeqty='';
			

			//data list
			 var data_link=BaseUrl+"DTLLIST/"+$scope.id_header;
			 console.log(data_link);
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
					$scope['freeqty']=value.freeqty;
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
					$scope['hq_id']=value.hq_id;
					$scope['hq_id_name']=value.hq_id_name;

					$scope['lrno']=value.lrno;
					$scope['lrdate']=value.lrdate;
					$scope['orderno']=value.orderno;
					$scope['orderdate']=value.orderdate;
					$scope['transporter']=value.transporter;
					$scope['no_of_case']=value.no_of_case;

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


//************************INVALID PORTION END*****************************************//

app.directive('datepicker', function () {
	return {
			require: 'ngModel',
			link: function (scope, element, attrs, ngModelCtrl) {         
					element.datetimepicker({               
							mask: true,              
							timepicker: false,
							format: 'm/d/Y',             
							onSelect: function (dateText, inst) {
									ngModelCtrl.$setViewValue(dateText);
									scope.$apply();
							}
							}).on('blur', function () {    
							$(this).valida();                
					});
			}
	}
});


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



//DYNAMIC FORM CREATE USING ANGULAR JS **************************

//************************ACCOUNT SALE START*****************************************//

app.controller('dynamic_angularjs_form',['$scope','$rootScope','$http','$window','Sale_test',
function($scope,$rootScope,$http,$window,Sale_test)
{
	"use strict";

		$scope.return_object={};
		$scope.ledgers={};
		$rootScope.FormInputArray=[];	
		$rootScope.FormInputArray_template=[];	
		$scope.codestructure1_id=0;
		$scope.server_msg='';

	
	console.log($scope.usersName);
		 //$scope.form_id=41;
		// $scope.master_table_id=75;

		// $rootScope.form_id=0;
		// $scope.master_table_id=2;
		

			var BaseUrl=domain_name+"Project_controller/dynamic_angularjs_form/";

			

			$scope.view_list=function(form_id,master_table_id,header_index,grid_index,others)
			{
				
				$rootScope.form_id=form_id;
				$scope.master_table_id=master_table_id;
				
				var data_link=BaseUrl+"VIEWALLVALUE/"+form_id+'/'+master_table_id+'/'+header_index+'/'+grid_index+'/'+others+'/';
					console.log(data_link);
					$http.get(data_link).then(function(response) 
					{
						angular.forEach(response.data,function(value,key)
						{
							$rootScope.FormInputArray_template[0]=$rootScope.FormInputArray[0] ={	header:value.header};		
							//$rootScope.FormInputArray_template[0]=$rootScope.FormInputArray[0];
						});	
					});	
			}		
			//console.log($rootScope.FormInputArray);

			$scope.mainOperation=function(event,element_id)
			{	
				
				//console.log('element_name '+element_id);
				if(event.keyCode === 13)
					{	
						element_id=Number(element_id+1);			
						document.getElementById(element_id).focus();		
					}				

					// if(element_name===20)
					// {
					// 	$scope.get_set_value('','','DRCRCHECKING');
					// 	document.getElementById(8).focus();			
					// }
					// if(element_name===114)
					// {
					// 	$scope.get_set_value('','','ADDMIXTURE');
					// 	document.getElementById(102).focus();			
					// }
			}

			$scope.new_entry=function()
			{$scope.view_list($scope.form_id,0,0,-1,'NA');}

			//$scope.view_list($scope.form_id,$scope.master_table_id,0,-1,'NA');

			$scope.update_header_section=function(header_index,body_index,section)
			{$rootScope.FormInputArray[0].header[header_index].row_num=$rootScope.FormInputArray[0].header[header_index].body[body_index].section;}




			$rootScope.search = function(searchelement,indx1,index2)
			{			
					
					$rootScope.searchelement=searchelement;
					//$rootScope.row_index=row_index;
					$rootScope.indx1=indx1;
					$rootScope.index2=index2;

					$rootScope.suggestions = [];
					$rootScope.searchItems=[];

				//	console.log($rootScope.FormInputArray[0].header[indx1].body[index2].Inputvalue);

					var array_length=$rootScope.FormInputArray[0].header[indx1].body[index2].datafields.length;
					var searchTextSmallLetters = angular.uppercase($rootScope.FormInputArray[0].header[indx1].body[index2].Inputvalue);
						
					//console.log(searchelement+' '+searchTextSmallLetters+' '+indx1+' - '+index2+' count :'+$rootScope.FormInputArray[0].header[indx1].body[index2].datafields.length);

					if(array_length>0)
					{$rootScope.searchItems=$rootScope.FormInputArray[0].header[indx1].body[index2].datafields;}
										
					$rootScope.searchItems.sort();	
					var myMaxSuggestionListLength = 0;
					for(var i=0; i<$rootScope.searchItems.length; i++)
					{					
							var searchItemsSmallLetters = angular.uppercase($rootScope.searchItems[i].FieldVal);							
							if( searchItemsSmallLetters.indexOf(searchTextSmallLetters) >=0)
							{
								$rootScope.suggestions.push({id: $rootScope.searchItems[i].FieldID,name:$rootScope.searchItems[i].FieldVal} );

							//	console.log('$rootScope.suggestions:'+$rootScope.suggestions[i].name);

								myMaxSuggestionListLength += 1;
								if(myMaxSuggestionListLength === 1500)
								{break;}
							}						
					}
	
				//	console.log('$rootScope.suggestions:'+$rootScope.suggestions);

			};
		
		$rootScope.$watch('selectedIndex',function(val){		
			if(val !== -1) {
				$rootScope.FormInputArray[0].header[$rootScope.indx1].body[$rootScope.index2].Inputvalue=$rootScope.suggestions[$rootScope.selectedIndex]['name'];	
				$rootScope.FormInputArray[0].header[$rootScope.indx1].body[$rootScope.index2].Inputvalue_id=$rootScope.suggestions[$rootScope.selectedIndex]['id'];	
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
			}
			else if(event.keyCode === 9){ //enter tab key
				//console.log($rootScope.selectedIndex);
				if($rootScope.selectedIndex>-1){
					$rootScope.AssignValueAndHide($rootScope.selectedIndex);
				}			
	
			}else if(event.keyCode === 27){ //ESC key, empty suggestions array
				$rootScope.AssignValueAndHide($rootScope.selectedIndex);
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
				// $rootScope.searchItems=[];
				// $rootScope.suggestions = [];			
				// $rootScope.selectedIndex = -1;
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
				
			 $rootScope.suggestions=[];
			 $rootScope.searchItems=[];		
			 $rootScope.selectedIndex = -1;
		};
	
		


		//MOST IMPORTANT ---SEARCH-AUTO COMPLETE

		//SAVE SECTION...

		$scope.form_data_save=function()
		{$scope.savedata();}
		

	$scope.savedata=function()
	{
		//console.log('purchase_rate'+$scope.purchase_rate);
		
		$scope.spiner='ON';
		//	$scope.savemsg='Please Wait data saving....';
		var data_link=BaseUrl+"SAVE";
		var success={};	
		var data_save = JSON.stringify($rootScope.FormInputArray);	
	
		var config = {headers : 
			{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
		}
		//$http.post(data_link, data,config)
		$http.post(data_link,data_save,config)
		.then (function success(response){

			console.log('id_header : '+response.data.id_header);	
			$scope.view_list($scope.form_id,response.data.id_header,0,-1,'NA');
			$scope.refresh_form();

		},
		function error(response){
			$scope.errorMessage = 'Error adding user!';
			$scope.message = '';
	  });

	}
		



			// $scope.savedata=function()
			// {
			// 		var data_link=BaseUrl+"SAVE/";
			// 		console.log(data_link);
			// 		var success={};	
			// 		var data_save = JSON.stringify($rootScope.FormInputArray);	
			// 			//	console.log(data_save);
			// 		var config = {headers : 
			// 			{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
			// 		}		
			// 		$http.post(data_link,data_save,config)
			// 		.then (function success(response){	

						


			// 		},
			// 		function error(response){
			// 			$scope.errorMessage = 'Error - Receord Not Saved!';
			// 			$scope.message = '';
			// 		});

			// }

			console.log('$rootScope.FormInputArray[0]'+$rootScope.FormInputArray[0]);

			$scope.refresh_form=function()
			{				
				var headerlength=$rootScope.FormInputArray[0].header.length-1;
				console.log('headerlength'+headerlength);
				for(var i=0; i<=headerlength;i++)
				{		
						
						if($rootScope.FormInputArray[0].header[i].Type=='GRID' )
						{
								$rootScope.FormInputArray[0].header[i].Table_Id='';
								var body_length=$rootScope.FormInputArray[0].header[i].body.length-1;
								for(var j=0; j<=body_length;j++)
								{	
									$rootScope.FormInputArray[0].header[i].body[j].Inputvalue_id=0;
									$rootScope.FormInputArray[0].header[i].body[j].Inputvalue='';
								}
						}
				}

			}

		//SAVE SECTION...
}]);




app.controller('receipt_of_goods',['$scope','$rootScope','$http','$window','Sale_test',
function($scope,$rootScope,$http,$window,Sale_test)
{
	"use strict";

		$scope.return_object={};
		$scope.ledgers={};
		
		$rootScope.FormInputArray_template=[];	
		$scope.codestructure1_id=0;
		$scope.server_msg='';
		
			$rootScope.FormInputArray=[];	
			var BaseUrl=domain_name+"Project_controller/receipt_of_goods/";
			$scope.view_list=function(id)
			{	
					var data_link=BaseUrl+"view_list";		
					console.log(data_link);	
					var success={};		
				//	var data_save = {'id': $scope.get_set_value(id,'num','SETVALUE')	};	
				  var data_save = {'id':0	};
					console.log(data_save);	
					var config = {headers :{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}				
					$http.post(data_link,data_save,config).then (function success(response){					
					angular.forEach(response.data,function(value,key)
					{
					$rootScope.FormInputArray[0] ={	header:value.header};		
						//$rootScope.FormInputArray_template[0]=$rootScope.FormInputArray[0];
					});	
					console.log('response.data '+$rootScope.FormInputArray[0]);
				
					},
					function error(response){
						$scope.errorMessage = 'Error adding user!';
						$scope.message = '';
					});
			}

		//	$scope.view_list(0);
		$scope.mainOperation=function(event,element_id)
		{	
			
			console.log('event :'+event.keyCode);
			if(event.keyCode === 13)
				{	
					element_id=Number(element_id+1);			
					document.getElementById(element_id).focus();		
				}				

		}


			$scope.update_header_section=function(header_index,body_index,section)
			{$rootScope.FormInputArray[0].header[header_index].row_num=$rootScope.FormInputArray[0].header[header_index].body[body_index].section;}


			$rootScope.search = function(searchelement,indx1,index2)
			{			
					console.log('searchelement'+searchelement+' index2'+index2);
					$rootScope.searchelement=searchelement;
					//$rootScope.row_index=row_index;
					$rootScope.indx1=indx1;
					$rootScope.index2=index2;

					$rootScope.suggestions = [];
					$rootScope.searchItems=[];

				//	console.log($rootScope.FormInputArray[0].header[indx1].body[index2].Inputvalue);

					var array_length=$rootScope.FormInputArray[0].header[indx1].body[index2].datafields.length;
					var searchTextSmallLetters = angular.uppercase($rootScope.FormInputArray[0].header[indx1].body[index2].Inputvalue);
						
					//console.log(searchelement+' '+searchTextSmallLetters+' '+indx1+' - '+index2+' count :'+$rootScope.FormInputArray[0].header[indx1].body[index2].datafields.length);

					if(array_length>0)
					{$rootScope.searchItems=$rootScope.FormInputArray[0].header[indx1].body[index2].datafields;}
										
					$rootScope.searchItems.sort();	
					var myMaxSuggestionListLength = 0;
					for(var i=0; i<$rootScope.searchItems.length; i++)
					{					
							var searchItemsSmallLetters = angular.uppercase($rootScope.searchItems[i].FieldVal);							
							if( searchItemsSmallLetters.indexOf(searchTextSmallLetters) >=0)
							{
								$rootScope.suggestions.push({id: $rootScope.searchItems[i].FieldID,name:$rootScope.searchItems[i].FieldVal} );

							//	console.log('$rootScope.suggestions:'+$rootScope.suggestions[i].name);

								myMaxSuggestionListLength += 1;
								if(myMaxSuggestionListLength === 1500)
								{break;}
							}						
					}
	
				//	console.log('$rootScope.suggestions:'+$rootScope.suggestions);

			};
		
		$rootScope.$watch('selectedIndex',function(val){		
			if(val !== -1) {
				$rootScope.FormInputArray[0].header[$rootScope.indx1].body[$rootScope.index2].Inputvalue=$rootScope.suggestions[$rootScope.selectedIndex]['name'];	
				$rootScope.FormInputArray[0].header[$rootScope.indx1].body[$rootScope.index2].Inputvalue_id=$rootScope.suggestions[$rootScope.selectedIndex]['id'];	
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
			}
			else if(event.keyCode === 9){ //enter tab key
				//console.log($rootScope.selectedIndex);
				if($rootScope.selectedIndex>-1){
					$rootScope.AssignValueAndHide($rootScope.selectedIndex);
				}			
	
			}else if(event.keyCode === 27){ //ESC key, empty suggestions array
				$rootScope.AssignValueAndHide($rootScope.selectedIndex);
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
				// $rootScope.searchItems=[];
				// $rootScope.suggestions = [];			
				// $rootScope.selectedIndex = -1;
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
				
			 $rootScope.suggestions=[];
			 $rootScope.searchItems=[];		
			 $rootScope.selectedIndex = -1;
		};
	
		


		//MOST IMPORTANT ---SEARCH-AUTO COMPLETE

		//SAVE SECTION...

		$scope.form_data_save=function()
		{$scope.savedata();}
		

	$scope.savedata=function()
	{
		//console.log('purchase_rate'+$scope.purchase_rate);
		
		$scope.spiner='ON';
		//	$scope.savemsg='Please Wait data saving....';
		var data_link=BaseUrl+"SAVE";
		var success={};	
		var data_save = JSON.stringify($rootScope.FormInputArray);	
	
		var config = {headers : 
			{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
		}
		//$http.post(data_link, data,config)
		$http.post(data_link,data_save,config)
		.then (function success(response){

			console.log('id_header : '+response.data.id_header);	
			$scope.view_list($scope.form_id,response.data.id_header,0,-1,'NA');
			$scope.refresh_form();

		},
		function error(response){
			$scope.errorMessage = 'Error adding user!';
			$scope.message = '';
	  });

	}
		



			// $scope.savedata=function()
			// {
			// 		var data_link=BaseUrl+"SAVE/";
			// 		console.log(data_link);
			// 		var success={};	
			// 		var data_save = JSON.stringify($rootScope.FormInputArray);	
			// 			//	console.log(data_save);
			// 		var config = {headers : 
			// 			{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
			// 		}		
			// 		$http.post(data_link,data_save,config)
			// 		.then (function success(response){	

						


			// 		},
			// 		function error(response){
			// 			$scope.errorMessage = 'Error - Receord Not Saved!';
			// 			$scope.message = '';
			// 		});

			// }

			console.log('$rootScope.FormInputArray[0]'+$rootScope.FormInputArray[0]);

			$scope.refresh_form=function()
			{				
				var headerlength=$rootScope.FormInputArray[0].header.length-1;
				console.log('headerlength'+headerlength);
				for(var i=0; i<=headerlength;i++)
				{		
						
						if($rootScope.FormInputArray[0].header[i].Type=='GRID' )
						{
								$rootScope.FormInputArray[0].header[i].Table_Id='';
								var body_length=$rootScope.FormInputArray[0].header[i].body.length-1;
								for(var j=0; j<=body_length;j++)
								{	
									$rootScope.FormInputArray[0].header[i].body[j].Inputvalue_id=0;
									$rootScope.FormInputArray[0].header[i].body[j].Inputvalue='';
								}
						}
				}

			}

		//SAVE SECTION...
}]);



app.controller('invoice_entry',['$scope','$rootScope','$http','$window','Sale_test',
function($scope,$rootScope,$http,$window,Sale_test)
{
	"use strict";

		$scope.return_object={};
		$scope.ledgers={};
		
		$rootScope.FormInputArray_template=[];	
		$scope.codestructure1_id=0;
		$scope.server_msg='';
		
			$rootScope.FormInputArray=[];	
			var BaseUrl=domain_name+"Project_controller/invoice_entry/";
			$scope.view_list=function(id)
			{	
					var data_link=BaseUrl+"view_list";		
					console.log(data_link);	
					var success={};		
				//	var data_save = {'id': $scope.get_set_value(id,'num','SETVALUE')	};	
				  var data_save = {'id':0	};
					console.log(data_save);	
					var config = {headers :{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}				
					$http.post(data_link,data_save,config).then (function success(response){					
					angular.forEach(response.data,function(value,key)
					{
					$rootScope.FormInputArray[0] ={	header:value.header};		
						//$rootScope.FormInputArray_template[0]=$rootScope.FormInputArray[0];
					});	
					console.log('response.data '+$rootScope.FormInputArray[0]);
				
					},
					function error(response){
						$scope.errorMessage = 'Error adding user!';
						$scope.message = '';
					});
			}

		//	$scope.view_list(0);
		$scope.mainOperation=function(event,element_id)
		{	
			
			console.log('event :'+event.keyCode);
			if(event.keyCode === 13)
				{	
					element_id=Number(element_id+1);			
					document.getElementById(element_id).focus();		
				}				

		}


			$scope.update_header_section=function(header_index,body_index,section)
			{$rootScope.FormInputArray[0].header[header_index].row_num=$rootScope.FormInputArray[0].header[header_index].body[body_index].section;}


			$rootScope.search = function(searchelement,indx1,index2,index3,index4)
			{			
					console.log('searchelement '+searchelement+' indx1 '+indx1+' index2 '+index2+' index3 '+index3+' index4 '+index4);
					$rootScope.searchelement=searchelement;
					//$rootScope.row_index=row_index;
					$rootScope.indx1=indx1;
					$rootScope.index2=index2;
					$rootScope.index3=index3;
					$rootScope.index3=index4;

					$rootScope.suggestions = [];
					$rootScope.searchItems=[];
					$rootScope.searchTextSmallLetters='';

				//	console.log('searchelement '+$rootScope.FormInputArray[0]['header'][indx1]['fields']);
					angular.forEach($rootScope.FormInputArray[0]['header'][indx1]['fields'][$rootScope.index2][$rootScope.searchelement], function (values, key) 
					{ 
						
							if(key=='Inputvalue')
							{	$rootScope.searchTextSmallLetters = angular.uppercase(values);}
						
							if(values!='' && key=='datafields')
							{
									var array_length=values.length;
									if(array_length>0)
									{$rootScope.searchItems=values;}
							}
					}); 

				//	console.log('$rootScope.searchItems'+$rootScope.searchItems);
										
					$rootScope.searchItems.sort();	
					var myMaxSuggestionListLength = 0;
					for(var i=0; i<$rootScope.searchItems.length; i++)
					{					
							var searchItemsSmallLetters = angular.uppercase($rootScope.searchItems[i].FieldVal);							
							if( searchItemsSmallLetters.indexOf($rootScope.searchTextSmallLetters) >=0)
							{
								$rootScope.suggestions.push({id: $rootScope.searchItems[i].FieldID,name:$rootScope.searchItems[i].FieldVal} );
								myMaxSuggestionListLength += 1;
								if(myMaxSuggestionListLength === 1500)
								{break;}
							}						
					}

			};
		
		$rootScope.$watch('selectedIndex',function(val){		
			if(val !== -1) 
			{
				$rootScope.FormInputArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['Inputvalue']=
				$rootScope.suggestions[$rootScope.selectedIndex]['name'];
				$rootScope.FormInputArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['Inputvalue_id']=
				$rootScope.suggestions[$rootScope.selectedIndex]['id'];
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
			}
			else if(event.keyCode === 9){ //enter tab key
				//console.log($rootScope.selectedIndex);
				if($rootScope.selectedIndex>-1){
					$rootScope.AssignValueAndHide($rootScope.selectedIndex);
				}			
	
			}else if(event.keyCode === 27){ //ESC key, empty suggestions array
				$rootScope.AssignValueAndHide($rootScope.selectedIndex);
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
				// $rootScope.searchItems=[];
				// $rootScope.suggestions = [];			
				// $rootScope.selectedIndex = -1;
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

				$rootScope.FormInputArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['Inputvalue']=
				$rootScope.suggestions[index]['name'];
				$rootScope.FormInputArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['Inputvalue_id']=
				$rootScope.suggestions[index]['id'];
				
			 $rootScope.suggestions=[];
			 $rootScope.searchItems=[];		
			 $rootScope.selectedIndex = -1;
		};
	

		//MOST IMPORTANT ---SEARCH-AUTO COMPLETE

		//SAVE SECTION...

		$scope.form_data_save=function()
		{$scope.savedata();}
		

	$scope.savedata=function()
	{
		//console.log('purchase_rate'+$scope.purchase_rate);
		
		$scope.spiner='ON';
		//	$scope.savemsg='Please Wait data saving....';
		var data_link=BaseUrl+"SAVE";
		var success={};	
		var data_save = JSON.stringify($rootScope.FormInputArray);	
	
		var config = {headers : 
			{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
		}
		//$http.post(data_link, data,config)
		$http.post(data_link,data_save,config)
		.then (function success(response){

			console.log('id_header : '+response.data.id_header);	
			$scope.view_list($scope.form_id,response.data.id_header,0,-1,'NA');
			$scope.refresh_form();

		},
		function error(response){
			$scope.errorMessage = 'Error adding user!';
			$scope.message = '';
	  });

	}

			console.log('$rootScope.FormInputArray[0]'+$rootScope.FormInputArray[0]);

			$scope.refresh_form=function()
			{				
				var headerlength=$rootScope.FormInputArray[0].header.length-1;
				console.log('headerlength'+headerlength);
				for(var i=0; i<=headerlength;i++)
				{		
						
						if($rootScope.FormInputArray[0].header[i].Type=='GRID' )
						{
								$rootScope.FormInputArray[0].header[i].Table_Id='';
								var body_length=$rootScope.FormInputArray[0].header[i].body.length-1;
								for(var j=0; j<=body_length;j++)
								{	
									$rootScope.FormInputArray[0].header[i].body[j].Inputvalue_id=0;
									$rootScope.FormInputArray[0].header[i].body[j].Inputvalue='';
								}
						}
				}

			}

		//SAVE SECTION...
}]);



		app.controller('experimental_form',['$scope','$rootScope','$http','$window','Sale_test',
		function($scope,$rootScope,$http,$window,Sale_test)
		{
			"use strict";

			
				$scope.return_object={};
				$scope.match_po_object={};
				$scope.ledgers={};
				$scope.input_id_index=0;
				$rootScope.temp=[];	
				$rootScope.FormInputArray_template=[];	
				$rootScope.FormInputArray=[];	
				$rootScope.ResourceArray=[];
				$rootScope.main_grid=[];
				$scope.formname='';
				$rootScope.array_name='';

				//$scope.codestructure1_id=0;
				$scope.server_msg='';
				$rootScope.current_form_report='TEST';

				$rootScope.current_form_report=localStorage.getItem("TranPageName");

				if($rootScope.current_form_report=='requisition')
				{$scope.formname='Requisition Entry';}
				if($rootScope.current_form_report=='po_entry')
				{$scope.formname='PO Entry';}
				if($rootScope.current_form_report=='po_approve')
				{$scope.formname='PO Approval';}
				if($rootScope.current_form_report=='receipt_of_goods')
				{$scope.formname='Receipt of Goods';}
				if($rootScope.current_form_report=='purchase_invoice')
				{$scope.formname='Generate Invoice';}
				if($rootScope.current_form_report=='SALES_ORDER')
				{$scope.formname='Sales Order';}
				if($rootScope.current_form_report=='SALES_ORDER_APPROVE')
				{$scope.formname='Sales Order Approve';}
				if($rootScope.current_form_report=='DESPATCH_GOODS')
				{$scope.formname='Despatch of Goods';}
				if($rootScope.current_form_report=='sale_invoice')
				{$scope.formname='Sales Invoice';}
				if($rootScope.current_form_report=='receive_amt')
				{$scope.formname='Receive';}
				if($rootScope.current_form_report=='payment_rcv')
				{$scope.formname='Payment';}
				
				

				//console.log($scope.formname+' ------- '+$rootScope.current_form_report);	

					$scope.test=function()
					{
						//console.log('searchelement '+$rootScope.searchelement+' header index '+$rootScope.indx1+' Field Index '+$rootScope.index2);
						var data_save = domain_name+'Project_controller/experimental_form_grid/'+$rootScope.searchelement+'/'+$rootScope.indx1+'/'+$rootScope.index2;
						console.log(data_save);
					}

					var BaseUrl=domain_name+"Project_controller/experimental_form/";

					$scope.main_grid=function(id)
					{	
							var data_link=BaseUrl;
							var success={};		
							//	var data_save = {'id': $scope.get_set_value(id,'num','SETVALUE')	};	
							var data_save = {'form_name':$rootScope.current_form_report,'subtype':'MAIN_GRID','id':id	};
							//console.log(data_save);	
							var config = {headers :{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}				
							$http.post(data_link,data_save,config).then (function success(response){
								$scope.return_object=response.data.header;
							},
							function error(response){
								$scope.errorMessage = 'Error adding user!';
								$scope.message = '';
							});
					}
					$scope.main_grid(1);
			

					$scope.view_list=function(id)
					{										
							var data_link=BaseUrl;
							var success={};		
							
							var data_save = {'form_name':$rootScope.current_form_report,'subtype':'view_list','id':id};
							console.log('form_name '+$rootScope.current_form_report+'id :'+id);	
							

							var config = {headers :{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}				
							$http.post(data_link,data_save,config).then (function success(response){					
							angular.forEach(response.data,function(value,key)
							{	
								$rootScope.FormInputArray[0] ={	header:value.header};	
							});	
							},
							function error(response){
								$scope.errorMessage = 'Error adding user!';
								$scope.message = '';
							});
					}

					$scope.view_list(0);



			$scope.other_search=function(id,subtype,header_index,field_index,searchelement)
			{										
					var data_link=BaseUrl;
					var success={};		
					
					var data = JSON.stringify($rootScope.FormInputArray);			
					//console.log(' value id '+id+$rootScope.searchelement+$rootScope.indx1+$rootScope.index2+' data :'+data);			
					var data_save = {'form_name':$rootScope.current_form_report,'subtype':'other_search','id':id,
					'raw_data':data,'header_index':$rootScope.indx1,'field_index':$rootScope.index2,'searchelement':$rootScope.searchelement	};

					console.log(' value id '+id+$rootScope.searchelement+$rootScope.indx1+$rootScope.index2+' data :'+data);

					var config = {headers :{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}				
					$http.post(data_link,data_save,config).then (function success(response){		
						console.log(' value 1 '+response.data.header);	
					angular.forEach(response.data,function(value,key)
					{	
						$rootScope.FormInputArray[0] ={	header:value.header};	
					//	console.log(' value 1 '+value.header);	
					});	
					},
					function error(response){
						$scope.errorMessage = 'Error adding user!';
						$scope.message = '';
					});

			}

			$scope.match_po=function(id)
			{	
					var data_link=BaseUrl;
					var success={};		
				  //	var data_save = {'id': $scope.get_set_value(id,'num','SETVALUE')	};
				  var data = JSON.stringify($rootScope.FormInputArray);		
				 var data_save = {'form_name':$rootScope.current_form_report,'subtype':'MATCH_PO','id':id,'raw_data':data	};
					console.log(data_save);	
					var config = {headers :{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}				
					$http.post(data_link,data_save,config).then (function success(response){
						$scope.match_po_object=response.data.header;
					},
					function error(response){
						$scope.errorMessage = 'Error adding user!';
						$scope.message = '';
					});
			}


			$scope.po_data=function(id)
			{										
					var data_link=BaseUrl;
					var success={};		
					var data = JSON.stringify($rootScope.FormInputArray);
					var data_save = {'form_name':$rootScope.current_form_report,'subtype':'PO_DATA','id':id,'raw_data':data};
					console.log('form_name'+$rootScope.current_form_report+'subtype'+'PO_DATA'+'id'+id);	
					var config = {headers :{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}				
					$http.post(data_link,data_save,config).then (function success(response){		
						
						console.log('response : '+response.data);
					angular.forEach(response.data,function(value,key)
					{	
						$rootScope.FormInputArray[0] ={	header:value.header};	
					});	
					},
					function error(response){
						$scope.errorMessage = 'Error adding user!';
						$scope.message = '';
					});
			}

			$scope.tax_details=function(id)
			{										
					var data_link=BaseUrl;
					var success={};		
					var data = JSON.stringify($rootScope.FormInputArray);
					var data_save = {'form_name':$rootScope.current_form_report,'subtype':'TAX_DETAILS','id':id,'raw_data':data};
					console.log('form_name'+$rootScope.current_form_report+'subtype'+'TAX_DETAILS'+'id'+id+'raw_data'+data);	
					var config = {headers :{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}				
					$http.post(data_link,data_save,config).then (function success(response){		
						
						console.log('response : '+response.data);
					angular.forEach(response.data,function(value,key)
					{	
						$rootScope.FormInputArray[0] ={	header:value.header};	
					});	
					},
					function error(response){
						$scope.errorMessage = 'Error adding user!';
						$scope.message = '';
					});
			}


				$scope.mainOperation=function(event,header_index,field_index,Index2,index3,input_id_index)
				{	
					//console.log('event :'+event.keyCode+'header_index:'+header_index+' field_index:'+field_index+' Index2:'+Index2+' index3:'+index3+input_id_index);

					if(event.keyCode === 13)
						{						
								input_id_index=Number(input_id_index+1);			
								document.getElementById(input_id_index).focus();

								if($rootScope.searchelement=='req_supplier' && $rootScope.current_form_report=='requisition')	
								{$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}		
								
								if($rootScope.searchelement=='req_supplier' && $rootScope.current_form_report=='payment_rcv')	
								{$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}		
								
								if($rootScope.searchelement=='req_supplier' && $rootScope.current_form_report=='receive_amt')	
								{$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}	
								
								if($rootScope.searchelement=='parent_id')	
								{$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}

								if($rootScope.searchelement=='item_id' && $rootScope.current_form_report=='SALES_ORDER')	
								{$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}	

								if($rootScope.searchelement=='opm_batch_details_id' && $rootScope.current_form_report=='SALES_ORDER')	
								{$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}	
													
						}		
						if(event.keyCode === 39)
						{	
							input_id_index=Number(input_id_index+1);			
							document.getElementById(input_id_index).focus();		
						}		
						if(event.keyCode === 37)
						{	
							input_id_index=Number(input_id_index-1);			
							document.getElementById(input_id_index).focus();		
						}					
						

				}


				$scope.update_input_id_index=function()
				{$scope.input_id_index=$scope.input_id_index+1;}

						

						$rootScope.search = function(searchelement,indx1,index2,index3,index4,array_name)
						{			
							
							console.log('searchelement '+searchelement+' indx1 '+indx1+' index2 '+index2+
								' index3 '+index3+' index4 '+index4+' array name '+array_name);
								$rootScope.searchelement=searchelement;
								$rootScope.array_name=array_name;
								console.log('resource '+ $rootScope.array_name);

								//$rootScope.row_index=row_index;
								$rootScope.indx1=indx1;
								$rootScope.index2=index2;
								$rootScope.index3=index3;
								$rootScope.index3=index4;
								console.log($rootScope.searchelement);

								if($rootScope.array_name=='resource')
								{

								}
								else
								{

									if($rootScope.FormInputArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['InputType']=='datefield')
									{
										var inputid=$rootScope.FormInputArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['input_id_index'];
										$("#"+inputid).datepicker({changeMonth: true,dateFormat: 'yy-mm-dd',changeYear: true});					 
										$("#"+inputid).change(function() {var  trandate = $("#"+inputid).val();$("#"+inputid).val(trandate);});
										console.log(inputid);
									}

									if($rootScope.current_form_report=='purchase_invoice' || $rootScope.current_form_report=='sale_invoice')	
									{							
									
										var req_total,invoice_subtotal;
										var cnt=2;
										req_total=invoice_subtotal=$rootScope.FormInputArray[0]['header'][cnt]['fields'][0]['invoice_tot_items']['Inputvalue'];						

										var invoice_retainage=  $rootScope.FormInputArray[0]['header'][cnt]['fields'][0]['invoice_retainage']['Inputvalue'];
										var invoice_prepayment_amount=  $rootScope.FormInputArray[0]['header'][cnt]['fields'][0]['invoice_prepayment_amount']['Inputvalue'];
										var invoice_withholding=	$rootScope.FormInputArray[0]['header'][cnt]['fields'][0]['invoice_withholding']['Inputvalue'];

										invoice_subtotal=Number(req_total-invoice_retainage-invoice_prepayment_amount-invoice_withholding);
										$rootScope.FormInputArray[0]['header'][cnt]['fields'][0]['invoice_grand_total']['Inputvalue']=
										$rootScope.FormInputArray[0]['header'][cnt]['fields'][0]['invoice_subtotal']['Inputvalue']=invoice_subtotal;
										
										var tax_amount=	Number($rootScope.FormInputArray[0]['header'][cnt]['fields'][0]['tax_amount']['Inputvalue']);
										var freight_amount=	Number($rootScope.FormInputArray[0]['header'][cnt]['fields'][0]['freight_amount']['Inputvalue']);
										var Misc_amount=	Number($rootScope.FormInputArray[0]['header'][cnt]['fields'][0]['Misc_amount']['Inputvalue']);	

										var invoice_grand_total=Number($rootScope.FormInputArray[0]['header'][cnt]['fields'][0]['invoice_grand_total']['Inputvalue']);
										invoice_grand_total=Number(invoice_grand_total+tax_amount+freight_amount+Misc_amount);
										$rootScope.FormInputArray[0]['header'][cnt]['fields'][0]['invoice_grand_total']['Inputvalue']=invoice_grand_total;
															
									}


									// if($rootScope.searchelement=='item_id' )	
									// {$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}

									if($rootScope.searchelement=='parent_id')	
									{$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}

									if($rootScope.searchelement=='req_operating_unit' && $rootScope.current_form_report=='requisition')	
									{$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}

									if($rootScope.searchelement=='req_supplier' && $rootScope.current_form_report=='requisition')	
									{$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}					


									if($rootScope.searchelement=='chart_of_account_id' && $rootScope.current_form_report=='CHART_OF_ACCOUNT_VALUESET')	
									{$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}

									if($rootScope.searchelement=='segment_id' && $rootScope.current_form_report=='CHART_OF_ACCOUNT_VALUESET')	
									{$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}
								
									if($rootScope.searchelement=='activity' && $rootScope.current_form_report=='opm_operation_summary')	
									{$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}		
									
									if($rootScope.searchelement=='item_id' && $rootScope.current_form_report=='SALES_ORDER')	
									{$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}	
									


									
								}	
									
								
								//console.log('searchelement '+$rootScope.searchelement+' header_index '+$rootScope.indx1+' field_index '+$rootScope.index2);
							
								$rootScope.suggestions = [];
								$rootScope.searchItems=[];
								$rootScope.searchTextSmallLetters='';

							//	console.log('searchelement '+$rootScope.FormInputArray[0]['header'][indx1]['fields']);
								
								
								if($rootScope.array_name=='resource')
								{

									angular.forEach($rootScope.ResourceArray[0]['header'][indx1]['fields'][$rootScope.index2][$rootScope.searchelement], function (values, key) 
									{ 
										console.log('resource '+key);
										if(key=='Inputvalue')
										{	$rootScope.searchTextSmallLetters = angular.uppercase(values);}
									
										if(values!='' && key=='datafields')
										{
												var array_length=values.length;
												if(array_length>0)
												{$rootScope.searchItems=values;}
										}
									}); 

								}
								else
								{

									angular.forEach($rootScope.FormInputArray[0]['header'][indx1]['fields'][$rootScope.index2][$rootScope.searchelement], function (values, key) 
									{ 
										
										if(key=='Inputvalue')
										{	$rootScope.searchTextSmallLetters = angular.uppercase(values);}
									
										if(values!='' && key=='datafields')
										{
												var array_length=values.length;
												if(array_length>0)
												{$rootScope.searchItems=values;}
										}
									}); 

								}
								

							//	console.log('$rootScope.searchItems'+$rootScope.searchItems);
													
								$rootScope.searchItems.sort();	
								var myMaxSuggestionListLength = 0;
								for(var i=0; i<$rootScope.searchItems.length; i++)
								{					
										var searchItemsSmallLetters = angular.uppercase($rootScope.searchItems[i].FieldVal);							
										if( searchItemsSmallLetters.indexOf($rootScope.searchTextSmallLetters) >=0)
										{
											$rootScope.suggestions.push({id: $rootScope.searchItems[i].FieldID,name:$rootScope.searchItems[i].FieldVal} );
											myMaxSuggestionListLength += 1;
											if(myMaxSuggestionListLength === 1500)
											{break;}
										}						
								}

						};
					
					$rootScope.$watch('selectedIndex',function(val)
					{		
						if(val !== -1) 
						{
							
							if($rootScope.array_name=='resource')
							{

								$rootScope.ResourceArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['Inputvalue']=
								$rootScope.suggestions[$rootScope.selectedIndex]['name'];
								$rootScope.ResourceArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['Inputvalue_id']=
								$rootScope.suggestions[$rootScope.selectedIndex]['id'];

							}
							else
							{

							$rootScope.FormInputArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['Inputvalue']=
							$rootScope.suggestions[$rootScope.selectedIndex]['name'];
							$rootScope.FormInputArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['Inputvalue_id']=
							$rootScope.suggestions[$rootScope.selectedIndex]['id'];

							}


							
						}
					});		
					
					$rootScope.checkKeyDown = function(event,header_index,field_index,Index2,index3,input_id_index)
					{
						
						console.log(event.keyCode);
							if(event.keyCode === 40){//down key, increment selectedIndex
							event.preventDefault();
							if($rootScope.selectedIndex+1 < $rootScope.suggestions.length){
								$rootScope.selectedIndex++;
							}else{
								$rootScope.selectedIndex = 0;
							}

							//$scope.mainOperation(event,header_index,field_index,Index2,index3,input_id_index);
							//console.log('event.keyCode:'+event.keyCode+' header_index:'+header_index+' field_index:'+field_index);
							//console.log('Index2:'+Index2+' index3:'+index3+' input_id_index:'+input_id_index);
						
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
							//$scope.mainOperation(event,header_index,field_index,Index2,index3,input_id_index);
						}
						else if(event.keyCode === 9){ //enter tab key
							//console.log($rootScope.selectedIndex);
							if($rootScope.selectedIndex>-1){
								$rootScope.AssignValueAndHide($rootScope.selectedIndex);
							}			
				
						}
						else if(event.keyCode === 27){ //ESC key, empty suggestions array
							$rootScope.AssignValueAndHide($rootScope.selectedIndex);
						}
						else if(event.keyCode === 39){ //right key
							//$rootScope.AssignValueAndHide($rootScope.selectedIndex);
							$scope.mainOperation(event,header_index,field_index,Index2,index3,input_id_index);
						}
						else if(event.keyCode === 37){ //left key
						//	$rootScope.AssignValueAndHide($rootScope.selectedIndex);
						$scope.mainOperation(event,header_index,field_index,Index2,index3,input_id_index);
						}
						else if(event.keyCode === 113){ //F2 KEY FOR ADD
							//	$rootScope.AssignValueAndHide($rootScope.selectedIndex);
							$scope.mainOperation(event,header_index,field_index,Index2,index3,input_id_index);
							}
						
						else{
							$rootScope.search();	
						}
					};
					
					//ClickOutSide
					var exclude1 = document.getElementById($rootScope.searchelement);
					$rootScope.hideMenu = function($event){
						$rootScope.search();
						//make a condition for every object you wat to exclude
						if($event.target !== exclude1) {
							// $rootScope.searchItems=[];
							// $rootScope.suggestions = [];			
							// $rootScope.selectedIndex = -1;
						}
					};
					//======================================
					
					//Function To Call on ng-keyup
					$rootScope.checkKeyUp = function(event)
					{ 
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
						$rootScope.AssignValueAndHide = function(index)
						{

							//console.log('$rootScope.searchelement'+$rootScope.searchelement);

							if($rootScope.array_name=='resource')
							{

								$rootScope.ResourceArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['Inputvalue']=
								$rootScope.suggestions[index]['name'];
								$rootScope.ResourceArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['Inputvalue_id']=
								$rootScope.suggestions[index]['id'];

							}
							else
							{

								$rootScope.FormInputArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['Inputvalue']=
								$rootScope.suggestions[index]['name'];
								$rootScope.FormInputArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['Inputvalue_id']=
								$rootScope.suggestions[index]['id'];

							}

							
						$rootScope.suggestions=[];
						$rootScope.searchItems=[];		
						$rootScope.selectedIndex = -1;
					};
	

		//MOST IMPORTANT ---SEARCH-AUTO COMPLETE

					//SAVE SECTION...

					$scope.form_data_save=function()
					{$scope.savedata();}
					

				$scope.savedata=function()
				{
					//console.log('purchase_rate'+$scope.purchase_rate);
					
					$scope.spiner='ON';
					//	$scope.savemsg='Please Wait data saving....';
					//var data_link=BaseUrl+"SAVE";
					var data_link=BaseUrl;
					var success={};	
					var data = JSON.stringify($rootScope.FormInputArray);	
					var data_save = {'form_name':$scope.current_form_report,'subtype':'SAVE_DATA','raw_data':data};
					console.log(data_save);
					var config = {headers : 
						{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
					}
					//$http.post(data_link, data,config)
					$http.post(data_link,data_save,config)
					.then (function success(response){

						$scope.view_list(response.data.id_header);
						console.log('id_header : '+response.data.id_header);	
						//$scope.view_list($scope.form_id,response.data.id_header,0,-1,'NA');
						//$scope.refresh_form();

					},
					function error(response){
						$scope.errorMessage = 'Error adding user!';
						$scope.message = '';
					});

				}

				//SAVE SECTION...



				//opm --operation-resource
				$scope.opm_operation_resource=function(id)
				{										
					
					//console.log('activity id :'+id)

					$rootScope.activity_id=id;

					var data_link=BaseUrl;
					var success={};		
					var data = JSON.stringify($rootScope.ResourceArray);
					var data_save = {'form_name':$rootScope.current_form_report,
					'subtype':'resource_list','id':id,'raw_data':data};		
					//console.log('form_name'+$rootScope.current_form_report+'subtype'+'PO_DATA'+'id'+id);			

					var config = {headers :{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}				
					$http.post(data_link,data_save,config).then (function success(response){		
						
					//	console.log('response : '+response.data);
					angular.forEach(response.data,function(value,key)
					{	
						$rootScope.ResourceArray[0] ={	header:value.header};	
					});	
					},
					function error(response){
						$scope.errorMessage = 'Error adding user!';
						$scope.message = '';
					});
				}

				$scope.opm_operation_resource(0);

				
				$scope.opm_operation_savedata=function()
				{
					//console.log('purchase_rate'+$scope.purchase_rate);
					
					$scope.spiner='ON';
					//	$scope.savemsg='Please Wait data saving....';
					//var data_link=BaseUrl+"SAVE";
					var data_link=BaseUrl;
					var success={};	
					var data = JSON.stringify($rootScope.ResourceArray);	
					var data_save = {'form_name':$scope.current_form_report,
					'subtype':'resource_save','raw_data':data,'activity_id':$rootScope.activity_id};
					console.log(data_save);
					var config = {headers : 
						{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
					}
					//$http.post(data_link, data,config)
					$http.post(data_link,data_save,config)
					.then (function success(response){

						$scope.opm_operation_resource($rootScope.activity_id);
						//$scope.view_list(response.data.id_header);
						//console.log('id_header : '+response.data.id_header);	
						//$scope.view_list($scope.form_id,response.data.id_header,0,-1,'NA');
						//$scope.refresh_form();

					},
					function error(response){
						$scope.errorMessage = 'Error adding user!';
						$scope.message = '';
					});

			}

		//opm --operation-resource




				//chart_of_account_values
				
				$scope.chart_of_account_values=function(id)
				{	
					$rootScope.activity_id=id;
					var data_link=BaseUrl;
					var success={};		
					var data = JSON.stringify($rootScope.ResourceArray);
					var data_save = {'form_name':$rootScope.current_form_report,
					'subtype':'VALUE_SET_LIST','id':id,'raw_data':data};		
					
					console.log('form_name'+$rootScope.current_form_report+'subtype'+'PO_DATA'+'id'+id);			

					var config = {headers :{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}				
					$http.post(data_link,data_save,config).then (function success(response){		
						
					//	console.log('response : '+response.data);
					angular.forEach(response.data,function(value,key)
					{	
						$rootScope.ResourceArray[0] ={	header:value.header};	
					});	
					},
					function error(response){
						$scope.errorMessage = 'Error adding user!';
						$scope.message = '';
					});
				}

				$scope.chart_of_account_values(0);

				
				$scope.chart_of_account_values_save=function()
				{
					$scope.spiner='ON';
					//	$scope.savemsg='Please Wait data saving....';
					//var data_link=BaseUrl+"SAVE";
					var data_link=BaseUrl;
					var success={};	
					var data = JSON.stringify($rootScope.ResourceArray);	
					var data_save = {'form_name':$scope.current_form_report,
					'subtype':'VALUE_SET_SAVE','raw_data':data,'activity_id':$rootScope.activity_id};
					console.log(data_save);
					var config = {headers : 
						{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
					}
					//$http.post(data_link, data,config)
					$http.post(data_link,data_save,config)
					.then (function success(response){
						$scope.chart_of_account_values($rootScope.activity_id);
						
					},
					function error(response){
						$scope.errorMessage = 'Error adding user!';
						$scope.message = '';
					});

				}

				//opm --operation-resource

		
}]);



app.controller('master_form',['$scope','$rootScope','$http','$window','Sale_test',
function($scope,$rootScope,$http,$window,Sale_test)
{
	"use strict";
	
		$scope.return_object={};
		$scope.match_po_object={};
		$scope.ledgers={};
		$scope.input_id_index=0;
		$rootScope.temp=[];	
		$rootScope.FormInputArray_template=[];	
		$rootScope.FormInputArray=[];	
		$rootScope.main_grid=[];
		$scope.formname='';
		$scope.lov_status=false;

			//$scope.codestructure1_id=0;
			$scope.server_msg='';
			$rootScope.current_form_report='TEST';
			$rootScope.current_form_report=$rootScope.form_name=localStorage.getItem("TranPageName");
			$rootScope.form_id=localStorage.getItem("form_id");

			$scope.test=function()
			{
				//console.log('searchelement '+$rootScope.searchelement+' header index '+$rootScope.indx1+' Field Index '+$rootScope.index2);
				var data_save = domain_name+'Project_controller/experimental_form_grid/'+$rootScope.searchelement+'/'+$rootScope.indx1+'/'+$rootScope.index2;
				console.log(data_save);
			}

			var BaseUrl=domain_name+"Project_controller/master_form/";
			
			$scope.new_entry=function()
			{	
				$scope.view_list(0);
				document.getElementById(0).focus();	
				$scope.server_msg="Please Enter the details";
			}	

			$scope.view_list=function(id)
			{										
					var data_link=BaseUrl;
					var success={};		
					
					var data_save = {'form_id':$rootScope.form_id,'subtype':'view_list','id':id};
					console.log('id '+id + 'form_id  '+$rootScope.form_id);	
					var config = {headers :{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}				
					$http.post(data_link,data_save,config).then (function success(response){					
					angular.forEach(response.data,function(value,key)
					{	
						$rootScope.FormInputArray[0] ={	header:value.header};	
					});	
					},
					function error(response){
						$scope.errorMessage = 'Error adding user!';
						$scope.message = '';
					});
			}
			$scope.view_list(0);



			$scope.main_grid=function(id)
			{	
					var data_link=BaseUrl;
					var success={};		
					//	var data_save = {'id': $scope.get_set_value(id,'num','SETVALUE')	};	
				  var data_save = {'form_id':$rootScope.form_id,'subtype':'MAIN_GRID','id':id	};
					//console.log(data_save);	
					var config = {headers :{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}				
					$http.post(data_link,data_save,config).then (function success(response){
						$scope.return_object=response.data.header;
					},
					function error(response){
						$scope.errorMessage = 'Error adding user!';
						$scope.message = '';
					});
			}
			$scope.main_grid(1);
	

			$scope.other_search=function(id,subtype,header_index,field_index,searchelement)
			{										
					var data_link=BaseUrl;
					var success={};		
					
					var data = JSON.stringify($rootScope.FormInputArray);			
					//console.log(' value id '+id+$rootScope.searchelement+$rootScope.indx1+$rootScope.index2+' data :'+data);			
					var data_save = {'form_id':$rootScope.form_id,'subtype':'other_search','id':id,
					'raw_data':data,'header_index':$rootScope.indx1,'field_index':$rootScope.index2,'searchelement':$rootScope.searchelement	};

					console.log(' value id '+id+$rootScope.searchelement+$rootScope.indx1+$rootScope.index2+' data :'+data);

					var config = {headers :{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}				
					$http.post(data_link,data_save,config).then (function success(response){		
						console.log(' value 1 '+response.data.header);	
					angular.forEach(response.data,function(value,key)
					{	
						$rootScope.FormInputArray[0] ={	header:value.header};	
					//	console.log(' value 1 '+value.header);	
					});	
					},
					function error(response){
						$scope.errorMessage = 'Error adding user!';
						$scope.message = '';
					});

			}


		$scope.mainOperation=function(event,header_index,field_index,Index2,index3,input_id_index)
		{	
			//console.log('event :'+event.keyCode+'header_index:'+header_index+' field_index:'+field_index+' Index2:'+Index2+' index3:'+index3+input_id_index);

			 if(event.keyCode === 13)
				{						
						input_id_index=Number(input_id_index+1);			
						document.getElementById(input_id_index).focus();

						if($rootScope.searchelement=='req_supplier' && $rootScope.current_form_report=='requisition')	
						{$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}		
						
						// if($rootScope.searchelement=='req_supplier' && $rootScope.current_form_report=='payment_rcv')	
						// {$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}		
						
						// if($rootScope.searchelement=='req_supplier' && $rootScope.current_form_report=='receive_amt')	
						// {$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}	
						
						// if($rootScope.searchelement=='parent_id')	
						// {$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}
											
				}		
				if(event.keyCode === 39)
				{	
					input_id_index=Number(input_id_index+1);			
					document.getElementById(input_id_index).focus();		
				}		
				if(event.keyCode === 37)
				{	
					input_id_index=Number(input_id_index-1);			
					document.getElementById(input_id_index).focus();		
				}					
				

		}


			$scope.update_input_id_index=function()
			{$scope.input_id_index=$scope.input_id_index+1;}

		

			$rootScope.search = function(searchelement,indx1,index2,index3,index4)
			{			
				
				$scope.lov_size=0;
				$scope.lov_bodymain=12;
				
				//console.log('searchelement '+searchelement+' indx1 '+indx1+' index2 '+index2+' index3 '+index3+' index4 '+index4);
					$rootScope.searchelement=searchelement;
					//$rootScope.row_index=row_index;
					$rootScope.indx1=indx1;
					$rootScope.index2=index2;
					$rootScope.index3=index3;
					$rootScope.index3=index4;
					console.log($rootScope.searchelement);

					if($rootScope.FormInputArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['InputType']=='datefield')
						{
							var inputid=$rootScope.FormInputArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['input_id_index'];
							$("#"+inputid).datepicker({changeMonth: true,dateFormat: 'yy-mm-dd',changeYear: true});					 
							$("#"+inputid).change(function() {var  trandate = $("#"+inputid).val();$("#"+inputid).val(trandate);});
							console.log(inputid);
						}


						if($rootScope.form_id==40 || $rootScope.form_id==33 || $rootScope.form_id==35 || $rootScope.form_id==38)	
						{
							$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);						
						}

					if($rootScope.searchelement=='item_id' )	
					{$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}

				
					$rootScope.suggestions = [];
					$rootScope.searchItems=[];
					$rootScope.searchTextSmallLetters='';
				
					angular.forEach($rootScope.FormInputArray[0]['header'][indx1]['fields'][$rootScope.index2][$rootScope.searchelement], function (values, key) 
					{ 
							if(key=='Inputvalue')
							{	$rootScope.searchTextSmallLetters = angular.uppercase(values);}
						
							if(values!='' && key=='datafields')
							{
									var array_length=values.length;
									if(array_length>0)
									{$rootScope.searchItems=values;
										$scope.lov_size=3;
										$scope.lov_bodymain=9;
									}
							}
					}); 
										
					$rootScope.searchItems.sort();	
					var myMaxSuggestionListLength = 0;
					for(var i=0; i<$rootScope.searchItems.length; i++)
					{					
							var searchItemsSmallLetters = angular.uppercase($rootScope.searchItems[i].FieldVal);							
							if( searchItemsSmallLetters.indexOf($rootScope.searchTextSmallLetters) >=0)
							{
								$rootScope.suggestions.push({id: $rootScope.searchItems[i].FieldID,name:$rootScope.searchItems[i].FieldVal} );
								myMaxSuggestionListLength += 1;
								if(myMaxSuggestionListLength === 1500)
								{break;}
							}						
					}

			};
		
		$rootScope.$watch('selectedIndex',function(val){		
			if(val !== -1) 
			{
				$rootScope.FormInputArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['Inputvalue']=
				$rootScope.suggestions[$rootScope.selectedIndex]['name'];
				$rootScope.FormInputArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['Inputvalue_id']=
				$rootScope.suggestions[$rootScope.selectedIndex]['id'];
			}
		});		
		
		$rootScope.checkKeyDown = function(event,header_index,field_index,Index2,index3,input_id_index){
			
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
			}
			else if(event.keyCode === 9){ //enter tab key
				//console.log($rootScope.selectedIndex);
				if($rootScope.selectedIndex>-1){
					$rootScope.AssignValueAndHide($rootScope.selectedIndex);
				}			
	
			}
			else if(event.keyCode === 27){ //ESC key, empty suggestions array
				$rootScope.AssignValueAndHide($rootScope.selectedIndex);
			}
			else if(event.keyCode === 39){ //right key
				$scope.mainOperation(event,header_index,field_index,Index2,index3,input_id_index);
			}
			else if(event.keyCode === 37){ //left key
			$scope.mainOperation(event,header_index,field_index,Index2,index3,input_id_index);
			}
			else if(event.keyCode === 113){ //F2 KEY FOR ADD
				$scope.mainOperation(event,header_index,field_index,Index2,index3,input_id_index);
				}
			
			else{
				$rootScope.search();	
			}
		};
		
		//ClickOutSide
		var exclude1 = document.getElementById($rootScope.searchelement);
		$rootScope.hideMenu = function($event){
			$rootScope.search();
			//make a condition for every object you wat to exclude
			if($event.target !== exclude1) {
				// $rootScope.searchItems=[];
				// $rootScope.suggestions = [];			
				// $rootScope.selectedIndex = -1;
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

				//console.log('$rootScope.searchelement'+$rootScope.searchelement);

				$rootScope.FormInputArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['Inputvalue']=
				$rootScope.suggestions[index]['name'];
				$rootScope.FormInputArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['Inputvalue_id']=
				$rootScope.suggestions[index]['id'];
				
			 $rootScope.suggestions=[];
			 $rootScope.searchItems=[];		
			 $rootScope.selectedIndex = -1;
		};
	

		//MOST IMPORTANT ---SEARCH-AUTO COMPLETE

		//SAVE SECTION...

		$scope.form_data_save=function()
		{$scope.savedata();}
		

	$scope.savedata=function()
	{
		//console.log('purchase_rate'+$scope.purchase_rate);
		
		$scope.spiner='ON';
		//	$scope.savemsg='Please Wait data saving....';
		//var data_link=BaseUrl+"SAVE";
		var data_link=BaseUrl;
		var success={};	
		var data = JSON.stringify($rootScope.FormInputArray);	
		var data_save = {'form_id':$rootScope.form_id,'subtype':'SAVE_DATA','raw_data':data};
		//console.log(data_save);
		var config = {headers : 
			{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
		}
		//$http.post(data_link, data,config)
		$http.post(data_link,data_save,config)
		.then (function success(response){

			$scope.view_list(0);
			$scope.server_msg=response.data.server_msg;
			document.getElementById(0).focus();	

			//console.log('id_header : '+response.data.id_header);	
			//$scope.view_list($scope.form_id,response.data.id_header,0,-1,'NA');
			//$scope.refresh_form();

		},
		function error(response){
			$scope.errorMessage = 'Error adding user!';
			$scope.message = '';
	  });

	}
		//SAVE SECTION...

}]);


/*

app.controller('experimental_report',['$scope','$rootScope','$http','$window','Sale_test',
function($scope,$rootScope,$http,$window,Sale_test)
{
	"use strict";

		$scope.return_object={};
		$scope.chart_object={};
		$scope.ledgers={};
		$scope.input_id_index=0;
		$rootScope.temp=[];	
		$rootScope.FormInputArray_template=[];	
		$rootScope.FormInputArray=[];	
		$rootScope.main_grid=[];

		$rootScope.temparry = [];
		$rootScope.temparry_data = [];

		$scope.formname='';
		$scope.server_msg='';

		$rootScope.current_form_report='TEST';
		$rootScope.current_form_report=localStorage.getItem("TranPageName");

	//	$rootScope.current_form_report='sales_trend';

	
		if($rootScope.current_form_report=='bottom_20')
		{$scope.formname='Bottom 20 Sale';$rootScope.temparry = ['Product Code', 'Current Value', 'Previous Value'];}
		if($rootScope.current_form_report=='top_20')
		{$scope.formname='top 20 Sale';$rootScope.temparry = ['Product Code', 'Current Value', 'Previous Value'];}
		if($rootScope.current_form_report=='category_wise_sale')
		{$scope.formname='Category Wise Sale'; $rootScope.temparry = ['Category Name', 'Current Value'];}
		if($rootScope.current_form_report=='sales_trend')
		{
			$scope.formname='Sales Trend';
			 $rootScope.temparry = ['Month -Year', 'Current Value', 'Previous Value'];
		}
		if($rootScope.current_form_report=='purchase_invoice')
		{$scope.formname='Generate Invoice';}		

			$scope.test=function()
			{
				//console.log('searchelement '+$rootScope.searchelement+' header index '+$rootScope.indx1+' Field Index '+$rootScope.index2);
				var data_save = domain_name+'Project_controller/experimental_form_grid/'+$rootScope.searchelement+'/'+$rootScope.indx1+'/'+$rootScope.index2;
				console.log(data_save);
			}

			var BaseUrl=domain_name+"Project_controller/experimental_report/";

			$scope.main_grid=function(id)
			{	
					var data_link=BaseUrl;
					var success={};		
				//	var data_save = {'id': $scope.get_set_value(id,'num','SETVALUE')	};	
				  var data_save = {'form_name':$rootScope.current_form_report,'subtype':'MAIN_GRID','id':id	};
					//console.log(data_save);	
					var config = {headers :{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}				
					$http.post(data_link,data_save,config).then (function success(response){
						$scope.return_object=response.data.header;
					},
					function error(response){
						$scope.errorMessage = 'Error adding user!';
						$scope.message = '';
					});
			}
			$scope.main_grid(1);

			
			
			$rootScope.FormInputArray.push($rootScope.temparry);

			$scope.create_chart=function(id)
			{	
					var data_link=BaseUrl;
					var success={};		
				//	var data_save = {'id': $scope.get_set_value(id,'num','SETVALUE')	};	
				  var data_save = {'form_name':$rootScope.current_form_report,'subtype':'CREATE_CHART','id':id	};
					//console.log(data_save);	
					var config = {headers :{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}				
					$http.post(data_link,data_save,config).then (function success(response){

						angular.forEach(response.data.header,function(values,key1)
						{
							console.log('key :'+key1);							
							$rootScope.temparry_data = [];
							angular.forEach(values,function(value,key2)
							{
								
								var tempval;	
								if($rootScope.current_form_report=='top_20' || $rootScope.current_form_report=='bottom_20')
								{	
									if(key2=='item_number')
									{$rootScope.temparry_data.push(value);  }
									else if (key2=='id')
									{tempval=Number(value);}
									else
									{
										tempval=Number(value);
										$rootScope.temparry_data.push(tempval);														
									}
								}		

								if($rootScope.current_form_report=='category_wise_sale')
								{	
									if(key2=='sub_category')
									{$rootScope.temparry_data.push(value);  }
									else if (key2=='id')
									{tempval=Number(value);}
									else
									{
										tempval=Number(value);
										$rootScope.temparry_data.push(tempval);														
									}
								}		

								if($rootScope.current_form_report=='sales_trend')
								{	
									if(key2=='month_year')
									{$rootScope.temparry_data.push(value);  }
									else if (key2=='id')
									{tempval=Number(value);}
									else
									{
										tempval=Number(value);
										$rootScope.temparry_data.push(tempval);														
									}
								}		


						});	

						$rootScope.FormInputArray.push($rootScope.temparry_data);
						});	

						//chart testing
						if($rootScope.current_form_report=='top_20' || $rootScope.current_form_report=='bottom_20')
						{	
								google.charts.load('current', {'packages':['bar']});
								google.charts.setOnLoadCallback(drawChart);
								function drawChart() {
										var data = google.visualization.arrayToDataTable($rootScope.FormInputArray);
									var options = {
										chart: {
											title: $rootScope.current_form_report,
											subtitle: 'Sales, Expenses, and Profit: 2014-2017',
										},
										bars: 'horizontal' // Required for Material Bar Charts.
									};
									var chart = new google.charts.Bar(document.getElementById('barchart_material'));
									chart.draw(data, google.charts.Bar.convertOptions(options));
								}
						}

						if($rootScope.current_form_report=='category_wise_sale')
						{	
								google.charts.load('current', {'packages':['bar']});								
								google.charts.setOnLoadCallback(drawChart);
								function drawChart() {
										var data = google.visualization.arrayToDataTable($rootScope.FormInputArray);
									var options = {
										chart: {
											title: 'Category Wise Sales',
											subtitle: 'Sales, Expenses, and Profit: 2014-2017',
										},
										bars: 'horizontal' // Required for Material Bar Charts.
									};
									var chart = new google.charts.Bar(document.getElementById('barchart_material'));
									chart.draw(data, google.charts.Bar.convertOptions(options));
								}
						}

						if($rootScope.current_form_report=='sales_trend')
						{	
							//	google.charts.load('current', {'packages':['bar']});
								google.charts.load('current', {'packages':['corechart']});
								google.charts.setOnLoadCallback(drawChart);
								function drawChart() {
										var data = google.visualization.arrayToDataTable($rootScope.FormInputArray);
								
										var options = {
											title: 'Company Performance',
											curveType: 'function',
											legend: { position: 'bottom' }
										};
										var chart = new google.visualization.LineChart(document.getElementById('barchart_material'));
										chart.draw(data, options);

										google.visualization.events.addListener(chart, 'select', selectHandler);

										function selectHandler(e)
										{
											//alert('A table row was selected'+chart);

											var selection = chart.getSelection();
											var message = '';
											var  row,col;
											for (var i = 0; i < selection.length; i++) {
												var item = selection[i];
												
												if (item.row != null && item.column != null) {
													row=item.row;col=item.column;
													var str = data.getFormattedValue(item.row, item.column);
													message += '{row:' + item.row + ',column:' + item.column + '} = ' + str + '\n';
												} else if (item.row != null) {
													row=item.row;
													var str = data.getFormattedValue(item.row, 0);
													message += '{row:' + item.row + ', column:none}; value (col 0) = ' + str + '\n';
												} else if (item.column != null) {
													col=item.column;
													var str = data.getFormattedValue(0, item.column);
													message += '{row:none, column:' + item.column + '}; value (row 0) = ' + str + '\n';
												}
											}
											if (message == '') {
												message = 'nothing';
											}
											alert('You selected ' + message+ ' row:'+row+' col'+col+data.getFormattedValue(row, 0));

										}
	
								
									// 	var options = {
									// 	chart: {
									// 		title: 'Sales Trend',
									// 		subtitle: 'Sales, Expenses, and Profit: 2014-2017',
									// 	},
									// 	bars: 'vertical' // Required for Material Bar Charts.
									// };
										//var chart = new google.charts.Bar(document.getElementById('barchart_material'));
								//	chart.draw(data, google.charts.Bar.convertOptions(options));

								
								
								}
						}
					//chart testing


					},
					function error(response){
						$scope.errorMessage = 'Error adding user!';
						$scope.message = '';
					});


			}
			$scope.create_chart(1);

			console.log('chart_object :'+$scope.chart_object);


			$scope.view_list=function(id)
			{										
					var data_link=BaseUrl;
					var success={};		
					
					var data_save = {'form_name':$rootScope.current_form_report,'subtype':'view_list','id':id};
					//console.log('form_name '+data_save);	
					var config = {headers :{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}				
					$http.post(data_link,data_save,config).then (function success(response){					
					angular.forEach(response.data,function(value,key)
					{	
						$rootScope.FormInputArray[0] ={	header:value.header};	
					});	
					},
					function error(response){
						$scope.errorMessage = 'Error adding user!';
						$scope.message = '';
					});
			}
			$scope.view_list(0);

			$scope.other_search=function(id,subtype,header_index,field_index,searchelement)
			{										
					var data_link=BaseUrl;
					var success={};		
					
					var data = JSON.stringify($rootScope.FormInputArray);			
					//console.log(' value id '+id+$rootScope.searchelement+$rootScope.indx1+$rootScope.index2+' data :'+data);			
					var data_save = {'form_name':$rootScope.current_form_report,'subtype':'other_search','id':id,
					'raw_data':data,'header_index':$rootScope.indx1,'field_index':$rootScope.index2,'searchelement':$rootScope.searchelement	};
					
					var config = {headers :{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}				
					$http.post(data_link,data_save,config).then (function success(response){		
						console.log(' value 1 '+response.data.header);	
					angular.forEach(response.data,function(value,key)
					{	
						$rootScope.FormInputArray[0] ={	header:value.header};	
					//	console.log(' value 1 '+value.header);	
					});	
					},
					function error(response){
						$scope.errorMessage = 'Error adding user!';
						$scope.message = '';
					});


			}
			

		

		$scope.mainOperation=function(event,header_index,field_index,Index2,index3,input_id_index)
		{	
			//console.log('event :'+event.keyCode+'header_index:'+header_index+' field_index:'+field_index+' Index2:'+Index2+' index3:'+index3+input_id_index);

			 if(event.keyCode === 13)
				{						
						input_id_index=Number(input_id_index+1);			
						document.getElementById(input_id_index).focus();

						if($rootScope.searchelement=='req_supplier' && $rootScope.current_form_report=='requisition')	
				  	{$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}			
											
					
				}		
				if(event.keyCode === 39)
				{	
					input_id_index=Number(input_id_index+1);			
					document.getElementById(input_id_index).focus();		
				}		
				if(event.keyCode === 37)
				{	
					input_id_index=Number(input_id_index-1);			
					document.getElementById(input_id_index).focus();		
				}					
				

		}


			$scope.update_input_id_index=function()
			{$scope.input_id_index=$scope.input_id_index+1;}


			$rootScope.search = function(searchelement,indx1,index2,index3,index4)
			{			
				
				//console.log('searchelement '+searchelement+' indx1 '+indx1+' index2 '+index2+' index3 '+index3+' index4 '+index4);
					$rootScope.searchelement=searchelement;
					//$rootScope.row_index=row_index;
					$rootScope.indx1=indx1;
					$rootScope.index2=index2;
					$rootScope.index3=index3;
					$rootScope.index3=index4;
					console.log($rootScope.searchelement);

					if($rootScope.searchelement=='item_id' )	
					{$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}

					if($rootScope.searchelement=='parent_id')	
					{$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}

					if($rootScope.searchelement=='req_operating_unit' && $rootScope.current_form_report=='requisition')	
					{$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}

					if($rootScope.searchelement=='req_supplier' && $rootScope.current_form_report=='requisition')	
					{$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}					


					if($rootScope.searchelement=='chart_of_account_id' && $rootScope.current_form_report=='CHART_OF_ACCOUNT_VALUESET')	
					{$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}

					if($rootScope.searchelement=='segment_id' && $rootScope.current_form_report=='CHART_OF_ACCOUNT_VALUESET')	
					{$scope.other_search(1,'other_search',$rootScope.indx1,$rootScope.index2,$rootScope.searchelement);}
					
					//console.log('searchelement '+$rootScope.searchelement+' header_index '+$rootScope.indx1+' field_index '+$rootScope.index2);
				
					$rootScope.suggestions = [];
					$rootScope.searchItems=[];
					$rootScope.searchTextSmallLetters='';

				//	console.log('searchelement '+$rootScope.FormInputArray[0]['header'][indx1]['fields']);
					angular.forEach($rootScope.FormInputArray[0]['header'][indx1]['fields'][$rootScope.index2][$rootScope.searchelement], function (values, key) 
					{ 
						
							if(key=='Inputvalue')
							{	$rootScope.searchTextSmallLetters = angular.uppercase(values);}
						
							if(values!='' && key=='datafields')
							{
									var array_length=values.length;
									if(array_length>0)
									{$rootScope.searchItems=values;}
							}
					}); 

				//	console.log('$rootScope.searchItems'+$rootScope.searchItems);
										
					$rootScope.searchItems.sort();	
					var myMaxSuggestionListLength = 0;
					for(var i=0; i<$rootScope.searchItems.length; i++)
					{					
							var searchItemsSmallLetters = angular.uppercase($rootScope.searchItems[i].FieldVal);							
							if( searchItemsSmallLetters.indexOf($rootScope.searchTextSmallLetters) >=0)
							{
								$rootScope.suggestions.push({id: $rootScope.searchItems[i].FieldID,name:$rootScope.searchItems[i].FieldVal} );
								myMaxSuggestionListLength += 1;
								if(myMaxSuggestionListLength === 1500)
								{break;}
							}						
					}

			};
		
		$rootScope.$watch('selectedIndex',function(val){		
			if(val !== -1) 
			{
				$rootScope.FormInputArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['Inputvalue']=
				$rootScope.suggestions[$rootScope.selectedIndex]['name'];
				$rootScope.FormInputArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['Inputvalue_id']=
				$rootScope.suggestions[$rootScope.selectedIndex]['id'];
			}
		});		
		
		$rootScope.checkKeyDown = function(event,header_index,field_index,Index2,index3,input_id_index){
			
			console.log(event.keyCode);
				if(event.keyCode === 40){//down key, increment selectedIndex
				event.preventDefault();
				if($rootScope.selectedIndex+1 < $rootScope.suggestions.length){
					$rootScope.selectedIndex++;
				}else{
					$rootScope.selectedIndex = 0;
				}

				//$scope.mainOperation(event,header_index,field_index,Index2,index3,input_id_index);
				//console.log('event.keyCode:'+event.keyCode+' header_index:'+header_index+' field_index:'+field_index);
				//console.log('Index2:'+Index2+' index3:'+index3+' input_id_index:'+input_id_index);
			
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
				//$scope.mainOperation(event,header_index,field_index,Index2,index3,input_id_index);
			}
			else if(event.keyCode === 9){ //enter tab key
				//console.log($rootScope.selectedIndex);
				if($rootScope.selectedIndex>-1){
					$rootScope.AssignValueAndHide($rootScope.selectedIndex);
				}			
	
			}
			else if(event.keyCode === 27){ //ESC key, empty suggestions array
				$rootScope.AssignValueAndHide($rootScope.selectedIndex);
			}
			else if(event.keyCode === 39){ //right key
				//$rootScope.AssignValueAndHide($rootScope.selectedIndex);
				$scope.mainOperation(event,header_index,field_index,Index2,index3,input_id_index);
			}
			else if(event.keyCode === 37){ //left key
			//	$rootScope.AssignValueAndHide($rootScope.selectedIndex);
			$scope.mainOperation(event,header_index,field_index,Index2,index3,input_id_index);
			}
			else if(event.keyCode === 113){ //F2 KEY FOR ADD
				//	$rootScope.AssignValueAndHide($rootScope.selectedIndex);
				$scope.mainOperation(event,header_index,field_index,Index2,index3,input_id_index);
				}
			
			else{
				$rootScope.search();	
			}
		};
		
		//ClickOutSide
		var exclude1 = document.getElementById($rootScope.searchelement);
		$rootScope.hideMenu = function($event){
			$rootScope.search();
			//make a condition for every object you wat to exclude
			if($event.target !== exclude1) {
				// $rootScope.searchItems=[];
				// $rootScope.suggestions = [];			
				// $rootScope.selectedIndex = -1;
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

				//console.log('$rootScope.searchelement'+$rootScope.searchelement);

				$rootScope.FormInputArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['Inputvalue']=
				$rootScope.suggestions[index]['name'];
				$rootScope.FormInputArray[0]['header'][$rootScope.indx1]['fields'][$rootScope.index2][$rootScope.searchelement]['Inputvalue_id']=
				$rootScope.suggestions[index]['id'];
				
			 $rootScope.suggestions=[];
			 $rootScope.searchItems=[];		
			 $rootScope.selectedIndex = -1;
		};
	

		//MOST IMPORTANT ---SEARCH-AUTO COMPLETE

		//SAVE SECTION...

		$scope.form_data_save=function()
		{$scope.savedata();}
		

	$scope.savedata=function()
	{
		//console.log('purchase_rate'+$scope.purchase_rate);
		
		$scope.spiner='ON';
		//	$scope.savemsg='Please Wait data saving....';
		//var data_link=BaseUrl+"SAVE";
		var data_link=BaseUrl;
		var success={};	
		var data = JSON.stringify($rootScope.FormInputArray);	
		var data_save = {'form_name':$scope.current_form_report,'subtype':'SAVE_DATA','raw_data':data};
		console.log(data_save);
		var config = {headers : 
			{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'	}
		}
		//$http.post(data_link, data,config)
		$http.post(data_link,data_save,config)
		.then (function success(response){

			$scope.view_list(response.data.id_header);
			console.log('id_header : '+response.data.id_header);	
			//$scope.view_list($scope.form_id,response.data.id_header,0,-1,'NA');
			//$scope.refresh_form();

		},
		function error(response){
			$scope.errorMessage = 'Error adding user!';
			$scope.message = '';
	  });

	}

		

		//SAVE SECTION...
}]);



app.controller('experimental_report_dashboard',['$scope','$rootScope','$http','$window','Sale_test',
function($scope,$rootScope,$http,$window,Sale_test)
{
		"use strict";

		$scope.return_object={};
		$scope.chart_object={};
		$scope.ledgers={};
		$scope.input_id_index=0;
		$rootScope.temp=[];	
		$rootScope.FormInputArray_template=[];	
		$rootScope.category_wise_sale=[];	
		$rootScope.top_twenty=[];		
		$rootScope.bottom_twenty=[];		
		$rootScope.party_wise_sale=[];		

		$rootScope.FormInputArray=[];	
		$rootScope.main_grid=[];
		$rootScope.temparry = [];
		$rootScope.temparry_data = [];
		$rootScope.current_form_report='';

		//$rootScope.temparry = ['Product Code', 'Current Value', 'Previous Value'];	

		$scope.test=function()
		{
			//console.log('searchelement '+$rootScope.searchelement+' header index '+$rootScope.indx1+' Field Index '+$rootScope.index2);
			var data_save = domain_name+'Project_controller/experimental_form_grid/'+$rootScope.searchelement+'/'+$rootScope.indx1+'/'+$rootScope.index2;
			console.log(data_save);
		}

		var BaseUrl=domain_name+"Project_controller/experimental_report/";



	


			
		$scope.category_wise_sale=function(chart_name)
		{	
					$rootScope.category_wise_sale=[];	
					//$rootScope.current_form_report=chart_name;
					var id=0;				
					if(chart_name=='category_wise_sale')
					{$scope.formname='Category Wise Sale'; $rootScope.temparry = ['Category Name', 'Current Value'];}

					$rootScope.category_wise_sale.push($rootScope.temparry);
					//console.log($rootScope.current_form_report);


					var data_link=BaseUrl;
					var success={};		
					//	var data_save = {'id': $scope.get_set_value(id,'num','SETVALUE')	};	
				  var data_save = {'form_name':chart_name,'subtype':'CREATE_CHART','id':id	};
					//console.log(data_save);	
					var config = {headers :{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}				
					$http.post(data_link,data_save,config).then (function success(response){

						angular.forEach(response.data.header,function(values,key1)
						{
							//console.log('key :'+key1);							
							$rootScope.temparry_data = [];
							angular.forEach(values,function(value,key2)
							{								
								var tempval;	

								if(chart_name=='category_wise_sale')
								{	
									if(key2=='sub_category')
									{$rootScope.temparry_data.push(value);  }
									else if (key2=='id')
									{tempval=Number(value);}
									else
									{
										tempval=Number(value);
										$rootScope.temparry_data.push(tempval);														
									}
								}		


						});	

						$rootScope.category_wise_sale.push($rootScope.temparry_data);
						});	


						google.charts.load('current', {'packages':['bar']});								
						google.charts.setOnLoadCallback(drawChart);
						function drawChart() {
								var data = google.visualization.arrayToDataTable($rootScope.category_wise_sale);
							var options = {
								chart: {
									title: 'Category Wise Sales',
									subtitle: 'Sales, Expenses, and Profit: 2014-2017',
								},
								vAxis : { 
									textStyle : {
										color: "#000",
										fontName: "sans-serif",
										fontSize: 11,
										bold: true,
										italic: false
											
									}					
							},								
								bars: 'horizontal' // Required for Material Bar Charts.
							};
							var chart = new google.charts.Bar(document.getElementById('category_wise_sale'));
							chart.draw(data, google.charts.Bar.convertOptions(options));
						}

					},
					function error(response){
						$scope.errorMessage = 'Error adding user!';
						$scope.message = '';
					});

			}

			
		$scope.top_twenty=function(chart_name)
		{	
					$rootScope.top_twenty=[];					
					var id=0;
					$scope.formname='top 20 Sale';$rootScope.temparry = ['Product Code', 'Current Value', 'Previous Value'];
					$rootScope.top_twenty.push($rootScope.temparry);

					var data_link=BaseUrl;
					var success={};		
					//	var data_save = {'id': $scope.get_set_value(id,'num','SETVALUE')	};	
				  var data_save = {'form_name':chart_name,'subtype':'CREATE_CHART','id':id	};
					console.log(data_save);	
					var config = {headers :{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}				
					$http.post(data_link,data_save,config).then (function success(response){

						angular.forEach(response.data.header,function(values,key1)
						{
							//console.log('key :'+key1);							
							$rootScope.temparry_data = [];
							angular.forEach(values,function(value,key2)
							{								
								var tempval;	
								if(chart_name=='top_20')
								{	
									if(key2=='item_number')
									{$rootScope.temparry_data.push(value);  }
									else if (key2=='id')
									{tempval=Number(value);}
									else
									{
										tempval=Number(value);
										$rootScope.temparry_data.push(tempval);														
									}
								}	

						});	

						$rootScope.top_twenty.push($rootScope.temparry_data);
						});	

						google.charts.load('current', {'packages':['bar']});
						google.charts.setOnLoadCallback(drawChart);
						function drawChart() {
								var data = google.visualization.arrayToDataTable($rootScope.top_twenty);
							var options = {
								chart: {
									title: 'Top 20',
									subtitle: 'Sales, Expenses, and Profit: 2014-2017',
								},
								vAxis : { 
									textStyle : {
										color: "#000",
										fontName: "sans-serif",
										fontSize: 11,
										bold: true,
										italic: false
											
									}
					
							},
								bars: 'horizontal' // Required for Material Bar Charts.
							};
							var chart = new google.charts.Bar(document.getElementById('top_20'));
							chart.draw(data, google.charts.Bar.convertOptions(options));
						}
						

					},
					function error(response){
						$scope.errorMessage = 'Error adding user!';
						$scope.message = '';
					});

			}


			$scope.bottom_twenty=function(chart_name)
			{	
						$rootScope.bottom_twenty=[];					
						var id=0;
						$scope.formname='Bottom 20 Sale';$rootScope.temparry = ['Product Code', 'Current Value', 'Previous Value'];
						$rootScope.bottom_twenty.push($rootScope.temparry);
	
						var data_link=BaseUrl;
						var success={};		
						//	var data_save = {'id': $scope.get_set_value(id,'num','SETVALUE')	};	
						var data_save = {'form_name':chart_name,'subtype':'CREATE_CHART','id':id	};
						console.log(data_save);	
						var config = {headers :{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}				
						$http.post(data_link,data_save,config).then (function success(response){
	
							angular.forEach(response.data.header,function(values,key1)
							{
								//console.log('key :'+key1);							
								$rootScope.temparry_data = [];
								angular.forEach(values,function(value,key2)
								{								
									var tempval;	
									if(chart_name=='bottom_20')
									{	
										if(key2=='item_number')
										{$rootScope.temparry_data.push(value);  }
										else if (key2=='id')
										{tempval=Number(value);}
										else
										{
											tempval=Number(value);
											$rootScope.temparry_data.push(tempval);														
										}
									}	
	
							});	
	
							$rootScope.bottom_twenty.push($rootScope.temparry_data);
							});	
	
							google.charts.load('current', {'packages':['bar']});
							google.charts.setOnLoadCallback(drawChart);
							function drawChart() {
									var data = google.visualization.arrayToDataTable($rootScope.bottom_twenty);
								var options = {
									chart: {
										title: 'Bottom 20',
										subtitle: 'test',
									},
									vAxis : { 
										textStyle : {
											color: "#000",
											fontName: "sans-serif",
											fontSize: 11,
											bold: true,
											italic: false
												
										}
						
								},
									bars: 'horizontal' // Required for Material Bar Charts.
								};
								var chart = new google.charts.Bar(document.getElementById('bottom_20'));
								chart.draw(data, google.charts.Bar.convertOptions(options));
							}
							
	
						},
						function error(response){
							$scope.errorMessage = 'Error adding user!';
							$scope.message = '';
						});
	
				}


				$scope.sales_trend=function(chart_name)
				{	
							$rootScope.FormInputArray=[];					
							var id=0;				
							$scope.formname='Sales Trend';$rootScope.temparry = ['Month -Year', 'Current Value', 'Previous Value'];
							$rootScope.FormInputArray.push($rootScope.temparry);
		
							console.log($rootScope.current_form_report);
		
		
							var data_link=BaseUrl;
							var success={};		
							//	var data_save = {'id': $scope.get_set_value(id,'num','SETVALUE')	};	
							var data_save = {'form_name':chart_name,'subtype':'CREATE_CHART','id':id	};
							//console.log(data_save);	
							var config = {headers :{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}				
							$http.post(data_link,data_save,config).then (function success(response){
		
								angular.forEach(response.data.header,function(values,key1)
								{
									//console.log('key :'+key1);							
									$rootScope.temparry_data = [];
									angular.forEach(values,function(value,key2)
									{								
										var tempval;	
										if(key2=='month_year')
										{$rootScope.temparry_data.push(value);  }
										else if (key2=='id')
										{tempval=Number(value);}
										else
										{
											tempval=Number(value);
											$rootScope.temparry_data.push(tempval);														
										}
		
								});	
		
								$rootScope.FormInputArray.push($rootScope.temparry_data);
								});	
		
									//	google.charts.load('current', {'packages':['bar']});
									google.charts.load('current', {'packages':['corechart']});
									google.charts.setOnLoadCallback(drawChart);
									function drawChart() {
											var data = google.visualization.arrayToDataTable($rootScope.FormInputArray);
									
											var options = {
												title: 'Company Performance',
												curveType: 'function',
												legend: { position: 'bottom' }
											};
											var chart = new google.visualization.LineChart(document.getElementById('sales_trend'));
											chart.draw(data, options);
		
									google.visualization.events.addListener(chart, 'select', selectHandler);
		
									function selectHandler(e)
									{
										//alert('A table row was selected'+chart);
		
										var selection = chart.getSelection();
										var message = '';
										var  row,col;
										for (var i = 0; i < selection.length; i++) {
											var item = selection[i];
											
											if (item.row != null && item.column != null) {
												row=item.row;col=item.column;
												var str = data.getFormattedValue(item.row, item.column);
												message += '{row:' + item.row + ',column:' + item.column + '} = ' + str + '\n';
											} else if (item.row != null) {
												row=item.row;
												var str = data.getFormattedValue(item.row, 0);
												message += '{row:' + item.row + ', column:none}; value (col 0) = ' + str + '\n';
											} else if (item.column != null) {
												col=item.column;
												var str = data.getFormattedValue(0, item.column);
												message += '{row:none, column:' + item.column + '}; value (row 0) = ' + str + '\n';
											}
										}
										if (message == '') {
											message = 'nothing';
										}
		
										$scope.party_wise_sale('party_wise_sale',data.getFormattedValue(row, 0));
		
										//alert('You selected ' + message+ ' row:'+row+' col'+col+data.getFormattedValue(row, 0));
		
									}
		
							
							}
		
		
							},
							function error(response){
								$scope.errorMessage = 'Error adding user!';
								$scope.message = '';
							});
		
					}
				
		$scope.party_wise_sale=function(chart_name,id)
		{	
					$rootScope.party_wise_sale=[];	
					//$rootScope.current_form_report=chart_name;
					//var id=0;				
					if(chart_name=='party_wise_sale')
					{$scope.formname='Category Wise Sale'; $rootScope.temparry = ['Party Name', 'Current Value'];}

					$rootScope.party_wise_sale.push($rootScope.temparry);
					console.log('chart_name :'+chart_name+' month year: '+id);


					var data_link=BaseUrl;
					var success={};		
					//	var data_save = {'id': $scope.get_set_value(id,'num','SETVALUE')	};	
				  var data_save = {'form_name':chart_name,'subtype':'CREATE_CHART','id':id	};
					//console.log(data_save);	
					var config = {headers :{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}				
					$http.post(data_link,data_save,config).then (function success(response){

						angular.forEach(response.data.header,function(values,key1)
						{
							//console.log('key :'+key1);							
							$rootScope.temparry_data = [];
							angular.forEach(values,function(value,key2)
							{								
								var tempval;	

								if(chart_name=='party_wise_sale')
								{	
									if(key2=='customer_name')
									{$rootScope.temparry_data.push(value);  }
									else if (key2=='id')
									{tempval=Number(value);}
									else
									{
										tempval=Number(value);
										$rootScope.temparry_data.push(tempval);														
									}
								}		


						});	
						
					//	$rootScope.temparry_data.push('color: #e5e4e2');

						$rootScope.party_wise_sale.push($rootScope.temparry_data);
						});	


						google.charts.load('current', {packages:["corechart"]});								
						google.charts.setOnLoadCallback(drawChart);
						function drawChart() {
								var data = google.visualization.arrayToDataTable($rootScope.party_wise_sale);
								// data.setColumns([0, 1,
								// 	{ calc: "stringify",
								// 		sourceColumn: 1,
								// 		type: "string",
								// 		role: "annotation" },
								// 	2]);

							var options = {
								chart: {
									title: 'Party Wise Sales',
									subtitle: 'Period:'+id,
								},
								vAxis : { 
									textStyle : {
										color: "#000",
										fontName: "sans-serif",
										fontSize: 11,
										bold: true,
										italic: false
											
									}					
							},								
								bars: 'horizontal' // Required for Material Bar Charts.
							};
							var chart = new google.charts.Bar(document.getElementById('party_wise_sale'));
							chart.draw(data, google.charts.Bar.convertOptions(options));
						}

					},
					function error(response){
						$scope.errorMessage = 'Error adding user!';
						$scope.message = '';
					});

			}




			 $scope.bottom_twenty('bottom_20');
			 $scope.top_twenty('top_20');
			$scope.category_wise_sale('category_wise_sale');
			$scope.sales_trend('sales_trend');

		
}]);

*/