//creating a General service Factory for using other app(module)
'use strict';


var domain_name="http://localhost/pharma_management/staford/";

//var domain_name="http://adequatesolutions.co.in/homeopathi/";

var GeneralServices=angular.module('GeneralServices',[]);

// Consignment Autocomplete section
GeneralServices.factory('AutocompleteConsignment',['$http','$rootScope',function($http,$rootScope){
    // var baseurl=
    //define an object
    var factoryobj={};

    $rootScope.selectedIndex = -1;
	console.log('domain_name '+domain_name);
	var BaseUrl=domain_name+"Primary_sale_controller/ConsignmentEntry_angular/";
	
	console.log(BaseUrl);
	
	var data_link=BaseUrl+"consignee/consignee";
	$http.get(data_link)
	.then(function(response) {
	$rootScope.list_consignee_name=response.data	;
	});

	var data_link=BaseUrl+"consignor/consignor";
	$http.get(data_link)
	.then(function(response) {
	$rootScope.list_consignor_name=response.data	;
	});

	var data_link=BaseUrl+"source_dest/source_dest";
	$http.get(data_link)
	.then(function(response) {
	$rootScope.list_source_dest=response.data	;
	});
	
	var data_link=BaseUrl+"general_master/CLIENT_TYPE";
	$http.get(data_link)
	.then(function(response) {
	$rootScope.list_client_type_name=response.data;
	});	

	var data_link=BaseUrl+"general_master/billing_party";
	$http.get(data_link)
	.then(function(response) {
	$rootScope.list_billing_party=response.data;
	});	

	var data_link=BaseUrl+"general_master/PAYMENT_DONE";
	$http.get(data_link)
	.then(function(response) {
	$rootScope.list_PAYMENT_DONE=response.data;
	});	

	var data_link=BaseUrl+"general_master/RISK_TYPE";
	$http.get(data_link)
	.then(function(response) {
	$rootScope.list_risk_id=response.data;
	});	

	var data_link=BaseUrl+"general_master/PACK_TYPE";
	$http.get(data_link)
	.then(function(response) {
	$rootScope.list_pack_type=response.data;
	});	

	
		
	factoryobj.list_items=function(param){
		$rootScope.searchItems=[];
		console.log(param);

		if(param=='consignee_name'){		
			angular.forEach($rootScope.list_consignee_name, function(value, key) {
				$rootScope.searchItems.push(value.name);
				});						
		}
		if(param=='consignor_name'){		
			angular.forEach($rootScope.list_consignor_name, function(value, key) {
				$rootScope.searchItems.push(value.name);
				});						
		}
		if(param=='origin_name' ||  param=='destination_name'){		
			angular.forEach($rootScope.list_source_dest, function(value, key) {
				$rootScope.searchItems.push(value.name);
				});						
		}
		if(param=='client_type_name')
		{		
				angular.forEach($rootScope.list_client_type_name, function(value, key) {
				$rootScope.searchItems.push(value.name);
				});						
		}
		if(param=='billing_party')
		{		
				angular.forEach($rootScope.list_billing_party, function(value, key) {
				$rootScope.searchItems.push(value.name);
				});						
		}
		if(param=='PAYMENT_DONE')
		{		
				angular.forEach($rootScope.list_PAYMENT_DONE, function(value, key) {
				$rootScope.searchItems.push(value.name);
				});						
		}
		if(param=='risk_id')
		{		
				angular.forEach($rootScope.list_risk_id, function(value, key) {
				$rootScope.searchItems.push(value.name);
				});						
		}
		if(param=='pack_type')
		{		
				angular.forEach($rootScope.list_pack_type, function(value, key) {
				$rootScope.searchItems.push(value.name);
				});						
		}
		
		

		
        return $rootScope.searchItems;
	}

    
    
    factoryobj.CurrentDate=function(CurrentDate){

		//var date = new Date();
		var year = CurrentDate.getFullYear();
		var month = CurrentDate.getMonth()+1;
		var dt = CurrentDate.getDate();

		if (dt < 10) {
		dt = '0' + dt;
		}
		if (month < 10) {
		month = '0' + month;
		}
			var finaldt=year+'-' + month + '-'+dt;

        return finaldt;
    };

    return factoryobj;
 
 }]);
 
// Accounts Sections

 GeneralServices.factory('PurchaseEntry',['$http','$rootScope',function($http,$rootScope)
 {
    // var baseurl=
    //define an object
    var factoryobj={};

    $rootScope.selectedIndex = -1;
	//var domain_name="http://localhost/abir_das_unitedlab/road_transport_final/";	
	//var domain_name="http://durgapurtransport.co.in/";
	var BaseUrl=domain_name+"Accounts_controller/AccountsTransactions/PurchaseEntry/";
	console.log(BaseUrl);
	//ReceiveTransacions

	var data_link=BaseUrl+"tbl_party_id_name";
	$http.get(data_link)
	.then(function(response) {
	$rootScope.list_party=response.data	;
	});


	var data_link=BaseUrl+"product_id_name";
	$http.get(data_link)
	.then(function(response) {
	$rootScope.list_products=response.data	;
	});


	factoryobj.list_items=function(param,trantype){
		$rootScope.searchItems=[];
		console.log(param);

		if(param=='tbl_party_id_name'){		
			angular.forEach($rootScope.list_party, function(value, key) {
				$rootScope.searchItems.push(value.name);
				});						
		}	
		
		if(param=='product_id_name'){		
			angular.forEach($rootScope.list_products, function(value, key) {
				$rootScope.searchItems.push(value.name);
				});						
		}	
		
		
        return $rootScope.searchItems;
	}
    
    return factoryobj;
 
 }]);

 GeneralServices.factory('purchase_rtn',['$http','$rootScope',function($http,$rootScope)
 {
    // var baseurl=
    //define an object
    var factoryobj={};

    $rootScope.selectedIndex = -1;
	//var domain_name="http://localhost/abir_das_unitedlab/road_transport_final/";	
	//var domain_name="http://durgapurtransport.co.in/";
	var BaseUrl=domain_name+"Accounts_controller/AccountsTransactions/purchase_rtn/";
	console.log(BaseUrl);
	//ReceiveTransacions

	var data_link=BaseUrl+"tbl_party_id_name";
	$http.get(data_link)
	.then(function(response) {
	$rootScope.list_party=response.data	;
	});


	var data_link=BaseUrl+"product_id_name";
	$http.get(data_link)
	.then(function(response) {
	$rootScope.list_products=response.data	;
	});


	factoryobj.list_items=function(param,trantype){
		$rootScope.searchItems=[];
		console.log(param);

		if(param=='tbl_party_id_name'){		
			angular.forEach($rootScope.list_party, function(value, key) {
				$rootScope.searchItems.push(value.name);
				});						
		}	
		
		if(param=='product_id_name'){		
			angular.forEach($rootScope.list_products, function(value, key) {
				$rootScope.searchItems.push(value.name);
				});						
		}	
		
		
        return $rootScope.searchItems;
	}
    
    return factoryobj;
 
 }]);


 

 GeneralServices.factory('Sale_test',['$http','$rootScope',function($http,$rootScope)
 {
    // var baseurl=
    //define an object
    var factoryobj={};

    $rootScope.selectedIndex = -1;
	//var domain_name="http://localhost/abir_das_unitedlab/road_transport_final/";	
	//var domain_name="http://durgapurtransport.co.in/";
	var BaseUrl=domain_name+"Accounts_controller/AccountsTransactions/SaleEntry/";
	console.log(BaseUrl);
	//ReceiveTransacions

	var data_link=BaseUrl+"tbl_party_id_name";
	$http.get(data_link)
	.then(function(response) {
	$rootScope.list_party=response.data	;
	});

	
	// var data_link=BaseUrl+"product_id_name";
	// console.log(data_link);
	// $http.get(data_link)
	// .then(function(response) {
	// $rootScope.list_products=response.data	;
	// });
	
	
	// var data_link=BaseUrl+"product_id_name_mixer";
	// $http.get(data_link)
	// .then(function(response) {
	// $rootScope.list_products_mixer=response.data	;
	// });

	var data_link=BaseUrl+"doctor_ledger_id_name";

	$http.get(data_link)
	.then(function(response) {
	$rootScope.list_doctor_ledger_id_name=response.data;
	});

	

	factoryobj.list_items=function(param,product_id){
		$rootScope.searchItems=[];
		
		if(param=='batchno'){	
			
			var data_link=BaseUrl+"batchno/"+product_id;
			console.log(data_link);			
			$http.get(data_link)
			.then(function(response) {
			$rootScope.list_batch=response.data	;
			});			
			angular.forEach($rootScope.list_batch, function(value, key) {
				$rootScope.searchItems.push(value.name);
				});						
		}	
		

		if(param=='tbl_party_id_name'){		
			angular.forEach($rootScope.list_party, function(value, key) {
				$rootScope.searchItems.push(value.name);
				});						
		}	
		
		if(param=='product_id_name'){	

			// angular.forEach($rootScope.list_products, function(value, key) {
			// 	$rootScope.searchItems.push(value.name);
			// 	});		
				
				var data_link=BaseUrl+"product_id_name/"+product_id;
				console.log(data_link);			
				$http.get(data_link)
				.then(function(response) {
				$rootScope.list_products=response.data	;
				});			
				angular.forEach($rootScope.list_products, function(value, key) {
				$rootScope.searchItems.push(value.name);
				});		

		}	

		if(param=='product_id_name_mixer'){		
			// angular.forEach($rootScope.list_products_mixer, function(value, key) {
			// 	$rootScope.searchItems.push(value.name);
			// 	});		
				
				var data_link=BaseUrl+"product_id_name/"+product_id;
				console.log(data_link);			
				$http.get(data_link)
				.then(function(response) {
				$rootScope.list_products=response.data	;
				});			
				angular.forEach($rootScope.list_products, function(value, key) {
				$rootScope.searchItems.push(value.name);
				});		
		}	

		if(param=='doctor_ledger_id_name'){		
			angular.forEach($rootScope.list_doctor_ledger_id_name, function(value, key) {
				$rootScope.searchItems.push(value.name);
				});	
			}
		
        return $rootScope.searchItems;
	}
    
    return factoryobj;
 
 }]);



 
 GeneralServices.factory('AccountsTransaction',['$http','$rootScope',function($http,$rootScope){
    // var baseurl=
    //define an object
    var factoryobj={};

    $rootScope.selectedIndex = -1;
	//var domain_name="http://localhost/abir_das_unitedlab/road_transport_final/";	
	//var domain_name="http://durgapurtransport.co.in/";
	
	//RECEIVE SECTION
	var BaseUrl=domain_name+"Accounts_controller/AccountsTransactions/RECEIVE/";	
	var data_link=BaseUrl+"ledger_account_name/CR/";
	console.log(data_link);
	$http.get(data_link)
	.then(function(response) {
	$rootScope.CRledgers_RECEIVE=response.data	;
	});
	
	var data_link=BaseUrl+"ledger_account_name/DR/";
	$http.get(data_link)
	.then(function(response) {
	$rootScope.DRledgers_RECEIVE=response.data	;
	});

	//PAYMENT SECTION
	var BaseUrl=domain_name+"Accounts_controller/AccountsTransactions/PAYMENT/";	
	var data_link=BaseUrl+"ledger_account_name/CR/";
	console.log(data_link);
	$http.get(data_link)
	.then(function(response) {
	$rootScope.CRledgers_PAYMENT=response.data	;
	});
	
	var data_link=BaseUrl+"ledger_account_name/DR/";
	$http.get(data_link)
	.then(function(response) {
	$rootScope.DRledgers_PAYMENT=response.data	;
	});

	//JOURNAL SECTION
	var BaseUrl=domain_name+"Accounts_controller/AccountsTransactions/JOURNAL/";	
	var data_link=BaseUrl+"ledger_account_name/CR/";
	console.log(data_link);
	$http.get(data_link)
	.then(function(response) {
	$rootScope.CRledgers_JOURNAL=response.data	;
	});
	
	var data_link=BaseUrl+"ledger_account_name/DR/";
	$http.get(data_link)
	.then(function(response) {
	$rootScope.DRledgers_JOURNAL=response.data	;
	});

	//CONTRA SECTION
	var BaseUrl=domain_name+"Accounts_controller/AccountsTransactions/CONTRA/";	
	var data_link=BaseUrl+"ledger_account_name/CR/";
	console.log(data_link);
	$http.get(data_link)
	.then(function(response) {
	$rootScope.CRledgers_CONTRA=response.data	;
	});
	
	var data_link=BaseUrl+"ledger_account_name/DR/";
	$http.get(data_link)
	.then(function(response) {
	$rootScope.DRledgers_CONTRA=response.data	;
	});
	
	
	var data_link=BaseUrl+"EMPLOYEE_NAME/";	
	$http.get(data_link)
	.then(function(response) {
	$rootScope.EMPLOYEE_NAME=response.data	;
	});

	factoryobj.list_items=function(element_name,parent_element_id,CRDR_TYPE,AcTranType,detailtype){
		
		 console.log('element_name '+element_name
		 +' parent_element_id '+parent_element_id+' AcTranType'+AcTranType);
		
		$rootScope.searchItems=[];	
				
		// if(element_name=='truck_no'){		
		// 	angular.forEach($rootScope.truck_no, function(value, key) {
		// 		$rootScope.searchItems.push(value.name);
		// 		});		
		// 	}

		if(element_name=='EMPLOYEE_NAME'){		
			angular.forEach($rootScope.EMPLOYEE_NAME, function(value, key) {
				$rootScope.searchItems.push(value.name);
				});		
			}

		if(AcTranType=='RECEIVE')
		{
			if(element_name=='ledger_account_name' && CRDR_TYPE=='CR'){		
				angular.forEach($rootScope.CRledgers_RECEIVE, function(value, key) {
					$rootScope.searchItems.push(value.name);
					});		
				}
	
			if(element_name=='ledger_account_name' && CRDR_TYPE=='DR'){		
				angular.forEach($rootScope.DRledgers_RECEIVE, function(value, key) {
					$rootScope.searchItems.push(value.name);
					});		
				}
	
			if(element_name=='BILL_INSTRUMENT_NO')
			{		
				var BaseUrl=domain_name+"Accounts_controller/AccountsTransactions/RECEIVE/";
				var data_link=BaseUrl+"BILLNO/"+parent_element_id+'/';
				console.log(data_link);
				$http.get(data_link)
				.then(function(response) {
				$rootScope.bills=response.data	;
				});
	
				angular.forEach($rootScope.bills, function(value, key) {
					$rootScope.searchItems.push(value.name);
					});		
			}	
		}

		if(AcTranType=='PAYMENT')
		{
			if(element_name=='ledger_account_name' && CRDR_TYPE=='CR'){		
				angular.forEach($rootScope.CRledgers_PAYMENT, function(value, key) {
					$rootScope.searchItems.push(value.name);
					});		
				}
	
			if(element_name=='ledger_account_name' && CRDR_TYPE=='DR'){		
				angular.forEach($rootScope.DRledgers_PAYMENT, function(value, key) {
					$rootScope.searchItems.push(value.name);
					});		
				}
	
			if(element_name=='BILL_INSTRUMENT_NO')
			{		
				var BaseUrl=domain_name+"Accounts_controller/AccountsTransactions/PAYMENT/";
				var data_link=BaseUrl+"BILLNO/"+parent_element_id+'/';
				$http.get(data_link)
				.then(function(response) {
				$rootScope.bills=response.data	;
				});
	
				angular.forEach($rootScope.bills, function(value, key) {
					$rootScope.searchItems.push(value.name);
					});		
			}	
		}

		if(AcTranType=='JOURNAL')
		{
			if(element_name=='ledger_account_name' && CRDR_TYPE=='CR'){		
				angular.forEach($rootScope.CRledgers_JOURNAL, function(value, key) {
					$rootScope.searchItems.push(value.name);
					});		
				}
	
			if(element_name=='ledger_account_name' && CRDR_TYPE=='DR'){		
				angular.forEach($rootScope.DRledgers_JOURNAL, function(value, key) {
					$rootScope.searchItems.push(value.name);
					});		
				}
	
			if(element_name=='BILLNO')
			{		
				var BaseUrl=domain_name+"Accounts_controller/AccountsTransactions/JOURNAL/";
				var data_link=BaseUrl+"BILLNO/"+parent_element_id+'/';
				$http.get(data_link)
				.then(function(response) {
				$rootScope.bills=response.data	;
				});
	
				angular.forEach($rootScope.bills, function(value, key) {
					$rootScope.searchItems.push(value.name);
					});		
			}	
		}

		if(AcTranType=='CONTRA')
		{
			if(element_name=='ledger_account_name' && CRDR_TYPE=='CR'){		
				angular.forEach($rootScope.CRledgers_CONTRA, function(value, key) {
					$rootScope.searchItems.push(value.name);
					});		
				}
	
			if(element_name=='ledger_account_name' && CRDR_TYPE=='DR'){		
				angular.forEach($rootScope.DRledgers_CONTRA, function(value, key) {
					$rootScope.searchItems.push(value.name);
					});		
				}	
			
		}
		

        return $rootScope.searchItems;
	}

	factoryobj.bill_summary=function(index_value)
	{
		var billdetail_length=$rootScope.FormInputArray[index_value].details.length;
		var total_bill_amt=0;
		for(var i=0; i<=billdetail_length-1;i++)
		{			
			total_bill_amt=total_bill_amt+
			Number($rootScope.FormInputArray[index_value].details[i].AMOUNT |0);
		}
		console.log('total_bill_amt:'+total_bill_amt);
		return total_bill_amt;
	}
	    
    return factoryobj;
 
 }]);
 