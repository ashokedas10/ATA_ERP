<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project_controller  extends CI_Controller {

// auto complete
//http://codeigniterlover.blogspot.in/2013/01/jquery-autocomplete-in-codeigniter-php.html
//http://www.php-guru.in/2013/html-to-pdf-conversion-in-codeigniter/

// DB BACKUP AND MAIL  ...
//http://snipt.org/wponh

//file:///E:/ALL_WEBSITE_NEW/xampp/htdocs/money_market/psrgroupnew/jquery_jqwidgets
//demos/jqxtree/checkboxes.htm

	public function __construct()
		{
			parent::__construct();
			
			$this->load->helper(array('form', 'url'));
			
			//$this->load->model('authmod');
			//$this->authmod->is_admin_login();
		  $this->load->library(array('form_validation','trackback', 'pagination'));
			$this->load->model('Project_model', 'projectmodel');
			$this->load->model('Form_report_create_model', 'FrmRptModel');
			$this->load->model('accounts_model');
			$this->load->model('company_structure_model', 'comp_struc_model');
			//$this->load->helper(array('dompdf', 'file'));
			$this->load->library('numbertowords');
			$this->load->library('pdf');
			$this->load->helper('file'); 
			$this->load->library('Highcharts');	
			$this->load->library('general_library');
			$this->load->library('excel');
			$this->load->library('Excel_reader');
			$this->load->library('curl');
		
			
			//$this->load->library('treeview');
			// https://github.com/chrisnharvey/CodeIgniter-PDF-Generator-Library
			//$this->load->library('To_excel');
}

	public function experimental_form_grid($datatype='',$hindx=0,$flfindx=0)
	{						
		
		//CHECK DATASAVE TABLE
		// $rs=$resval=$form_structure=$output=$save_details=array();
		// $whr=" id=1";	
		// $raw_data=$this->projectmodel->GetSingleVal('test_data','test_table',$whr);
		// $form_data=json_decode($raw_data);
		// $headers=json_decode(json_encode($form_data[0]->header), true );
		// $save_details=$this->FrmRptModel->create_save_array($headers);
		// echo '<pre>';
		// print_r($save_details);
		// echo '</pre>';

		/*
		$header_id=$id='';
		foreach($save_details as $key1=>$tables)
		{
			
			foreach($tables as $key2=>$fields)
			{
					$table_name=$key2;		
					$savedata=array();	
					$save_statue=true;
										
					foreach($fields as $key3=>$value)
					{
						//HERE REQUIRE CUSTOMIZATION
						if($key3=='id' )
						{
							if($value>0)
							{$header_id=$value;}
							else 
							{$header_id='';}  											
						}
						else if ($key3<>'id')
						{$savedata[$key3]=$value;}															
					}

					//HEADER SECTION
					$this->projectmodel->save_records_model($header_id,$table_name,$savedata);
					if($key1==0 && $header_id==''){$header_id=$this->db->insert_id();}												
				  echo $key1.' - '.$header_id;
			}	

		}
		echo $key1.' - '.$header_id;
		
		*/

		//CHECK DATASAVE TABLE


				// $form_id=31;
				// $id=5;
				// $whr=" id=".$form_id;	
				// $DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
				// $TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	

				// $rs[0]['section_type']='FORM';	
				// $rs[0]['frmrpttemplatehdr_id']=$form_id;
				// $rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']=$TableName;
				// $rs[0]['fields']=$DataFields;
				// $rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." where id=".$id;	

				// $form_structure=$this->FrmRptModel->create_form($rs,$id);
		  	// $form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);
				// echo '<pre>';
				// 	print_r($form_structure);
				// 	echo '</pre>';


		
				
			

					// echo 'test ';
					// $url="http://122.176.31.190/realitycsapi/api/Leaderboard/GetComparison_SalesRevenueTrunover?StartDate=01%2F01%2F2018&EndDate=01%2F31%2F2018";
					// $return_data=	$setting=	$rs=$resval=$form_structure=$output=array();			
					// $form_data1=json_decode($url);

					// echo '<pre>';
					// print_r($url);
					// echo '</pre>';

			/*
				$id=0;
				$setting=$this->projectmodel->user_wise_setting(); 

				$rs[0]['section_type']='FORM';	
				$rs[0]['frmrpttemplatehdr_id']=41;
				$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='invoice_summary';
				$rs[0]['fields']='id,req_operating_unit,req_number,req_type,req_preparer,req_description,req_currency_id,req_total,status,created_by,last_updated_by,create_date_time,last_updated_date_time';
				$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." where id=".$id;		

				//BODY OR GRID ENTRY SECTION					
				$rs[1]['section_type']='GRID_ENTRY';		
				$rs[1]['frmrpttemplatehdr_id']=48;
				$rs[1]['id']=0;	$rs[1]['parent_id']=$id;$rs[1]['TableName']='invoice_details';		
				//	$rs[1]['fields']='id,invoice_summary_id,item_id,qnty,uom,price,company_id,account_id,cost_center_id,segment4,segment5,segment6,segment7,segment8,segment9';
				$rs[1]['fields']='id,invoice_summary_id,item_id,qnty,uom,price'.$setting['segments'];
				$rs[1]['sql_query']="select ".$rs[1]['fields']." from ".$rs[1]['TableName']." where  invoice_summary_id=".$id;		

				//FOOTER SECTION
				$rs[2]['section_type']='FORM';	
				$rs[2]['frmrpttemplatehdr_id']=41;
				$rs[2]['id']=$id;	$rs[2]['parent_id']='';$rs[2]['TableName']='invoice_summary';
				$rs[2]['fields']='req_destination_type,req_source,req_requiester,req_supplier,req_organization,req_site,req_location,req_contact,req_subinventory,req_phone,req_status';
				$rs[2]['sql_query']="select ".$rs[2]['fields']." from ".$rs[2]['TableName']." where id=".$id;	
							
				$form_structure=$this->FrmRptModel->create_form($rs,$id);
				$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);

				 echo '<pre>';
				 print_r($form_structure);
				 echo '</pre>';
			*/
				 		// $form_name='requisition_approve';
						// $id= $indx=0;
					  // 	$form_id=81;
						// $whr=" id=".$form_id;	
						// $DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
						// $TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
						// $section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
						// $rs[$indx]['section_type']=$section_type;	
						// $rs[$indx]['frmrpttemplatehdr_id']=$form_id;
						// $rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
						// $rs[$indx]['fields']=$DataFields;
						// $rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;

																
						// $form_structure=$this->FrmRptModel->create_form($rs,$id);
						// $form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);
						// $form_structure=$this->projectmodel->other_setting($form_structure,$form_name);

					//	$form_name='SALES_ORDER';
					// 	$id=0;
					// //	$form_structure=$this->form_view($form_name,$id);


					// $id=33;	
					// 				$rs[0]['section_type']='GRID_ENTRY';	
					// 				$rs[0]['frmrpttemplatehdr_id']=41;
					// 				$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='invoice_summary';
					// 				$rs[0]['fields']='id,req_operating_unit,req_number,req_type,req_preparer,req_description,req_status,req_currency_id,req_total';
					// 				$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." where status='SALES_ORDER'";		
					// 				$resval=$this->FrmRptModel->create_report($rs,$id); 
				//	$resval=$this->FrmRptModel->create_report($rs,$id); 


				$setting=$this->projectmodel->user_wise_setting(); 
				$someArray=array();

				// $field_qualifier_name='';
				// $cnts=sizeof($setting['segment']);
				// for($cnt=0;$cnt<$cnts;$cnt++)
				// {
				// 	$field_qualifier_name=$setting['segment'][$cnt]['field_qualifier_name'];
				// 	if($field_qualifier_name=='account_id')
				// 	{$form_structure["header"][0]['fields'][0]['ledger_id']['datafields']=$setting['segment'][$cnt]['value_set'];}											
				// }


				// $rs="select * from  invoice_payment_receive_details where invoice_summary_id=".$detail_id." 
				// and invoice_payment_receive_id=".$tran_table_id." ";
				// $rs = $this->get_records_from_sql($rs);	
				// foreach ($rs as $rs_dtl)
				// {$payment_detail_id=$rs_dtl->id;}

					$id=1;
					$indx=0;
					$form_id=91;
					$whr=" id=".$form_id;	
					$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
					$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
					$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
					$rs[$indx]['section_type']=$section_type;	
					$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
					$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
					$rs[$indx]['fields']=$DataFields;
					$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;


					$indx=1;
					$form_id=92;
					$opm_batch_summary_id=$id;
					$whr=" id=".$form_id;	

					$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);
					$DataFields2=$this->projectmodel->GetSingleVal('DataFields2','frmrpttemplatehdr',$whr);
					$DataFields3=$this->projectmodel->GetSingleVal('DataFields3','frmrpttemplatehdr',$whr);
					$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
					$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	

					$rs[$indx]['section_type']='GRID_ENTRY';		
					$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
					$rs[$indx]['id']=0;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
					$rs[$indx]['fields']=$DataFields;
					$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']."
					 where product_type=152 and opm_batch_summary_id=".$opm_batch_summary_id;


					 $indx=2;					 
					 $rs[$indx]['section_type']='GRID_ENTRY';		
					 $rs[$indx]['frmrpttemplatehdr_id']=$form_id;
					 $rs[$indx]['id']=0;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
					 $rs[$indx]['fields']=$DataFields2;
					 $rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']."
						where product_type=154 and opm_batch_summary_id=".$opm_batch_summary_id;

						$indx=3;
						$rs[$indx]['section_type']='GRID_ENTRY';		
						$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
						$rs[$indx]['id']=0;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
						$rs[$indx]['fields']=$DataFields3;
						$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']."
						 where product_type=153 and opm_batch_summary_id=".$opm_batch_summary_id;
				

					$form_structure=$this->FrmRptModel->create_form($rs,$id);
					$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);

			
				echo '<pre>';
				print_r($form_structure);
				echo '</pre>';




	}	

	


	public function experimental_form($datatype='')
	{
					
			$return_data=$setting=$rs=$resval=$form_structure=$output=array();	

			$form_data1=json_decode(file_get_contents("php://input"));	
			$form_name=$form_data1->form_name;	//PARAMETERS		
			$subtype=$form_data1->subtype;

			$setting=$this->projectmodel->user_wise_setting(); 
			

						 //CHART OF ACCOUNT NEW
		
							if($form_name=='CHART_OF_ACCOUNTS')
							{
									
								if($subtype=='view_list')
								{

									$indx=0;
									$form_id=75;
									$id=$form_data1->id;	
									//$id=1;			    
									$whr=" id=".$form_id;	
									$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
									$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
									$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
									$rs[$indx]['section_type']=$section_type;	
									$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
									$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
									$rs[$indx]['fields']=$DataFields;
									$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;


									$indx=1;
									$form_id=77;				    
									$parent_id=$form_data1->id;	
									//$parent_id=1;			   
									$whr=" id=".$form_id;	
									$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
									$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
									$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
									$rs[$indx]['section_type']='GRID_ENTRY';		
									$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
									$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
									$rs[$indx]['fields']=$DataFields;
									$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where parent_id=".$parent_id;

														

									$form_structure=$this->FrmRptModel->create_form($rs,$id);
									$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);
									array_push($output,$form_structure);
									header('Access-Control-Allow-Origin: *');
									header("Content-Type: application/json");
									echo json_encode($output);	

								}

								if($subtype=='SAVE_DATA')
								{
										
									//VALIDATION PORTION
																
									$data_for_validation = json_decode($form_data1->raw_data, true);								
									//$VALID_STATUS=$this->FrmRptModel->validation_data($data_for_validation);
									$VALID_STATUS='VALID';
									//VALIDATION PORTION
								
									if($VALID_STATUS=='VALID')
									{

											$form_data=json_decode($form_data1->raw_data);

											//$main_id=json_decode($form_data1->id);
											
											//$save_details2['test_data']=$form_data1->raw_data;
											//$save_details2['test_data']=json_decode(json_encode($form_data1->raw_data), 
											//	true );
											//$this->projectmodel->save_records_model(1,'test_table',$save_details2);

											$headers=json_decode(json_encode($form_data[0]->header), true );
											$header_scount=sizeof($headers);
											$id_header=0;	
											$count=sizeof($form_data[0]->header);		
											$headers=json_decode(json_encode($form_data[0]->header), true );
										//	$save_details=$this->create_save_array($headers);
											$save_details=$this->FrmRptModel->create_save_array($headers);
										

											// echo '<pre>';
											// print_r($save_details);
											// echo '</pre>';
											$main_id=0;
											$header_id=$activity_id=$resource_id='';
											foreach($save_details as $key1=>$tables)
											{
															
												foreach($tables as $key2=>$fields)
												{
														$table_name=$key2;		
														$savedata=array();	
														$save_statue=true;
																			
													foreach($fields as $key3=>$value)
													{
														//HERE REQUIRE CUSTOMIZATION
														if($key3=='id' && $table_name=='tbl_chart_of_accounts')
														{
															if($value>0)
															{$header_id=$value;}
															else 
															{$header_id='';}  											
														}
														
														else if ($key3=='parent_id' && $table_name=='tbl_chart_of_accounts')
														{$savedata[$key3]=$main_id; }
														
														else 
														{$savedata[$key3]=$value;}

													}
													

														//HEADER SECTION
														if($table_name=='tbl_chart_of_accounts')
														{
															$this->projectmodel->save_records_model($header_id,$table_name,$savedata);
															if($key1==0 && $header_id=='')
															{$header_id=$this->db->insert_id();}

															if($main_id==0)
															{$main_id=$header_id;}	

														}

														
												}	

											}

											$return_data['id_header']=$main_id;
						
											header('Access-Control-Allow-Origin: *');
											header("Content-Type: application/json");
											echo json_encode($return_data);

									}

								}	

								if($subtype=='VALUE_SET_LIST')
								{

									$indx=0;
										$form_id=78;
										$segment_id=$form_data1->id;	

										$whr=" id=".$segment_id." and trantype='CHART_OF_ACCOUNT_SEGMENT'";	
									$main_id=$this->projectmodel->GetSingleVal('parent_id','tbl_chart_of_accounts',$whr);


										$count=0;
									$records="select count(*) cnt from tbl_chart_of_accounts where  parent_id=".$segment_id;
									$records = $this->projectmodel->get_records_from_sql($records);	
									foreach ($records as $record)
									{$count=$record->cnt;}	
											
										$id=$count;


									$whr=" id=".$form_id;	
									$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
									$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
										
									$rs[$indx]['section_type']='GRID_ENTRY';
									$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
									$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
									$rs[$indx]['fields']=$DataFields;
									$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where parent_id=".$segment_id;
									
									$form_structure=$this->FrmRptModel->create_form($rs,$id);
											$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);



									$cnts=sizeof($form_structure["header"][0]['fields']);
									for($i=0;$i<$cnts;$i++)
									{
										$sql="select  id FieldID,title FieldVal  from tbl_chart_of_accounts where  trantype='CHART_OF_ACCOUNT_VALUESET'  
										and acc_type=157 and parent_id=".$segment_id;
										$datafields_array =$this->projectmodel->get_records_from_sql($sql);
										$form_structure["header"][0]['fields'][$i]['parent_data_id']['datafields']=json_decode(json_encode($datafields_array), true);	
																			
										// $whr=" id=".
										// $form_structure["header"][0]['fields'][$i]['parent_data_id']['Inputvalue_id'];	
										// $form_structure["header"][0]['fields'][$i]['parent_data_id']['Inputvalue']=$this->projectmodel->GetSingleVal('title','tbl_chart_of_accounts',$whr);																		
										
										// $sql="select  id FieldID,FieldVal  from frmrptgeneralmaster where  status='CHART_OF_AC_QUALIFIER'";
										// $datafields_array =$this->projectmodel->get_records_from_sql($sql);
										// $form_structure["header"][1]['fields'][$i]['field_qualifier']['datafields']=json_decode(json_encode($datafields_array), true);

										// $whr=" id=".$form_structure["header"][1]['fields'][$i]['field_qualifier']['Inputvalue_id'];	
										// $form_structure["header"][1]['fields'][$i]['field_qualifier']['Inputvalue']=$this->projectmodel->GetSingleVal('FieldVal','frmrptgeneralmaster',$whr);		


									}


									array_push($output,$form_structure);
									header('Access-Control-Allow-Origin: *');
									header("Content-Type: application/json");
									echo json_encode($output);	

								}


								if($subtype=='VALUE_SET_SAVE')
								{
										
									//VALIDATION PORTION
																
									$data_for_validation = json_decode($form_data1->raw_data, true);								
									//$VALID_STATUS=$this->FrmRptModel->validation_data($data_for_validation);
									$VALID_STATUS='VALID';
									//VALIDATION PORTION
								
									if($VALID_STATUS=='VALID')
									{

											$form_data=json_decode($form_data1->raw_data);
											$segment_id=$form_data1->activity_id;

											// $whr=" id=".$opm_define_operations_activity_details_id;	
											// $opm_define_operations_summary_id=
											// $this->projectmodel->GetSingleVal('opm_define_operations_summary_id','opm_define_operations_activity_details',$whr);	



											//$save_details2['test_data']=$form_data1->raw_data;
											//$save_details2['test_data']=json_decode(json_encode($form_data1->raw_data), 
											//	true );
											//$this->projectmodel->save_records_model(1,'test_table',$save_details2);

											$headers=json_decode(json_encode($form_data[0]->header), true );
											$header_scount=sizeof($headers);
											$id_header=0;	
											$count=sizeof($form_data[0]->header);		
											$headers=json_decode(json_encode($form_data[0]->header), true );
										//	$save_details=$this->create_save_array($headers);
											$save_details=$this->FrmRptModel->create_save_array($headers);
										
											// echo '<pre>';
											// print_r($save_details);
											// echo '</pre>';

										$header_id=$resource_id='';
										foreach($save_details as $key1=>$tables)
										{
														
											foreach($tables as $key2=>$fields)
											{
													$table_name=$key2;		
													$savedata=array();	
													$save_statue=true;
																		
												foreach($fields as $key3=>$value)
												{
													//HERE REQUIRE CUSTOMIZATION
													if($key3=='id' && $table_name=='tbl_chart_of_accounts')
													{
														if($value>0)
														{$header_id=$value;}
														else 
														{$header_id='';}  											
													}
													
													// else if ($key3<>'id' && $table_name=='tbl_chart_of_accounts')
													// {$savedata[$key3]=$value;}

													else 
													{$savedata[$key3]=$value;}

												}
													
													$savedata['parent_id']=$segment_id;

													// $savedata['opm_define_operations_summary_id']=
													// $opm_define_operations_summary_id;


												//HEADER SECTION
												if($table_name=='tbl_chart_of_accounts')
												{
													$this->projectmodel->save_records_model($header_id,$table_name,$savedata);
													//if($key1==0 && $header_id=='')
													//{$header_id=$this->db->insert_id();}												
												}


											}	

										}
												



											$return_data['id_header']=$header_id;
						
											header('Access-Control-Allow-Origin: *');
											header("Content-Type: application/json");
											echo json_encode($return_data);

									}

								}	


								if($subtype=='MAIN_GRID')
								{
								


									$indx=0;
									$form_id=75;
									$id=0;	
									$whr=" id=".$form_id;	
									$GridHeader=$this->projectmodel->GetSingleVal('GridHeader','frmrpttemplatehdr',$whr);	
									$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
									$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
									$WhereCondition=$this->projectmodel->GetSingleVal('WhereCondition','frmrpttemplatehdr',$whr);	

									$rs[$indx]['section_type']='GRID_ENTRY';
									$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
									$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
									$rs[$indx]['fields']=$GridHeader;
									$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." ";
									$resval=$this->FrmRptModel->create_report($rs,$id); 

									// $id=33;	
									// $rs[0]['section_type']='GRID_ENTRY';	
									// $rs[0]['frmrpttemplatehdr_id']=41;
									// $rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='invoice_summary';
									// $rs[0]['fields']='id,req_operating_unit,req_number,req_type,req_preparer,req_description,req_status,req_currency_id,req_total';
									// $rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." where status='SALES_ORDER'";		
									// $resval=$this->FrmRptModel->create_report($rs,$id); 

								}

							
							
							}

						//CHART OF ACCOUNT NEW END

					

					//PROCURE TO PAY START 

						if($form_name=='requisition')
						{
											
								if($subtype=='view_list')
								{			
								
									$id=mysql_real_escape_string($form_data1->id);						
									$form_structure=$this->form_view($form_name,$id);

									array_push($output,$form_structure);
									header('Access-Control-Allow-Origin: *');
									header("Content-Type: application/json");
									echo json_encode($output);
								}

								//save section
								if($subtype=='SAVE_DATA')
								{
									$this->projectmodel->save_data($form_data1->raw_data,$form_name);
								}	

								if($subtype=='MAIN_GRID')
								{
								
									$id=33;	
									$rs[0]['section_type']='GRID_ENTRY';	
									$rs[0]['frmrpttemplatehdr_id']=41;
									$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='invoice_summary';
									$rs[0]['fields']='id,req_operating_unit,req_number,req_type,req_preparer,req_description,req_status,req_currency_id,req_total';
									$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." where status='REQUISITION'";		
									$resval=$this->FrmRptModel->create_report($rs,$id); 

								}

								if($subtype=='other_search')
								{			
															
									$someArray=array();

									$header_index=$form_data1->header_index;
									$field_index=$form_data1->field_index;
									$searchelement=$form_data1->searchelement;
										$someArray = json_decode($form_data1->raw_data, true);

									if($searchelement=='req_supplier')
									{							
										$supplier_id=$someArray[0]['header'][$header_index]['fields'][$field_index]['req_supplier']['Inputvalue_id'];
										$whr=" id=".$supplier_id;							
										$someArray[0]['header'][$header_index]['fields'][$field_index]['req_contact']['Inputvalue']=$this->projectmodel->GetSingleVal('contact_person','mstr_supplier',$whr);
										$someArray[0]['header'][$header_index]['fields'][$field_index]['req_phone']['Inputvalue']=$this->projectmodel->GetSingleVal('phone_no','mstr_supplier',$whr);		
										
										$this->FrmRptModel->tranfer_data($someArray);
									}

								}


						}


						if($form_name=='requisition_approve')
						{
											
								if($subtype=='view_list')
								{			
									
									$id=mysql_real_escape_string($form_data1->id);
									$indx=0;
										$form_id=81;
									$whr=" id=".$form_id;	
									$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
									$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
									$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
									$rs[$indx]['section_type']=$section_type;	
									$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
									$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
									$rs[$indx]['fields']=$DataFields;
									$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;

																			
									$form_structure=$this->FrmRptModel->create_form($rs,$id);
									$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);
									$form_structure=$this->projectmodel->other_setting($form_structure,$form_name);

									array_push($output,$form_structure);
									header('Access-Control-Allow-Origin: *');
									header("Content-Type: application/json");
									echo json_encode($output);						

								}

								//save section
								if($subtype=='SAVE_DATA')
								{
									
									$this->projectmodel->save_data($form_data1->raw_data,$form_name);	
								}	

								if($subtype=='MAIN_GRID')
								{
								
									$id=33;	
									$rs[0]['section_type']='GRID_ENTRY';	
									$rs[0]['frmrpttemplatehdr_id']=41;
									$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='invoice_summary';
									$rs[0]['fields']='id,req_operating_unit,req_number,req_type,req_preparer,req_description,req_status,req_currency_id,req_total';
									$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." where status='REQUISITION' and req_status='91'";		
									$resval=$this->FrmRptModel->create_report($rs,$id); 

								}

								if($subtype=='other_search')
								{			
															
									$someArray=array();

									$header_index=$form_data1->header_index;
									$field_index=$form_data1->field_index;
									$searchelement=$form_data1->searchelement;
									$someArray = json_decode($form_data1->raw_data, true);

								}


						}

						if($form_name=='po_entry')
						{
											
								if($subtype=='view_list')
								{			
									
										$id=mysql_real_escape_string($form_data1->id);
										$form_structure=$this->form_view($form_name,$id);
										array_push($output,$form_structure);
										header('Access-Control-Allow-Origin: *');
										header("Content-Type: application/json");
										echo json_encode($output);						

								}

								//save section
								if($subtype=='SAVE_DATA')
								{
									$this->projectmodel->save_data($form_data1->raw_data,$form_name);
								}	

								if($subtype=='MAIN_GRID')
								{
								
									$id=33;	
									$rs[0]['section_type']='GRID_ENTRY';	
									$rs[0]['frmrpttemplatehdr_id']=41;
									$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='invoice_summary';
									$rs[0]['fields']='id,req_operating_unit,req_number,req_type,req_preparer,req_description,req_status,req_currency_id,req_total';
									$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." where status='PO_ENTRY'";		
									$resval=$this->FrmRptModel->create_report($rs,$id); 

								}

								if($subtype=='other_search')
								{			
															
									$output= $someArray=array();

									$header_index=mysql_real_escape_string($form_data1->header_index);
									$field_index=mysql_real_escape_string($form_data1->field_index);
									$searchelement=mysql_real_escape_string($form_data1->searchelement);
									$someArray = json_decode($form_data1->raw_data, true);
									
									if($searchelement=='parent_id')
									{
																		
										$id=0;
										$parent_id=
										$someArray[0]["header"][$header_index]['fields'][$field_index]['parent_id']['Inputvalue_id'];
										
										$entry_type='EDIT';
										$whr=" parent_id=".$parent_id;	
										$id=$this->projectmodel->GetSingleVal('id','invoice_summary',$whr); //PO ID

										if($id==0)
										{
											$whr=" id=".$parent_id;	
											$id=$this->projectmodel->GetSingleVal('id','invoice_summary',$whr); //requisition id
											$entry_type='NEW';
										}	

										$form_structure=$this->form_view($form_name,$id);


										$whr=" id=".$parent_id;	
										$req_number=
										$this->projectmodel->GetSingleVal('req_number','invoice_summary',$whr); 

										$form_structure["header"][$header_index]['fields'][$field_index]['parent_id']['Inputvalue']=$req_number;
										$form_structure["header"][$header_index]['fields'][$field_index]['parent_id']['Inputvalue_id']=$parent_id;


										if($entry_type=='NEW')
										{
											$form_structure["header"][$header_index]['fields'][$field_index]['id']['Inputvalue']='';
											$form_structure["header"][$header_index]['fields'][$field_index]['id']['Inputvalue_id']=0;

											$count_parent=sizeof($form_structure['header'][1]['fields']);		
											for($cnt_parent=0;$cnt_parent<=$count_parent-1;$cnt_parent++)
											{	
											$form_structure["header"][1]['fields'][$cnt_parent]['id']['Inputvalue']='';
											$form_structure["header"][1]['fields'][$cnt_parent]['id']['Inputvalue_id']=0;
											}	

										}
										array_push($output,$form_structure);
										header('Access-Control-Allow-Origin: *');
										header("Content-Type: application/json");
										echo json_encode($output);			

									}

						

								}

						}

						if($form_name=='po_approve')
						{
											
								if($subtype=='view_list')
								{			
									
										
									$id=mysql_real_escape_string($form_data1->id);
									$indx=0;
										$form_id=83;
									$whr=" id=".$form_id;	
									$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
									$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
									$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
									$rs[$indx]['section_type']=$section_type;	
									$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
									$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
									$rs[$indx]['fields']=$DataFields;
									$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;

																			
									$form_structure=$this->FrmRptModel->create_form($rs,$id);
									$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);
									$form_structure=$this->projectmodel->other_setting($form_structure,$form_name);

									array_push($output,$form_structure);
									header('Access-Control-Allow-Origin: *');
									header("Content-Type: application/json");
									echo json_encode($output);					






									// 	$id=mysql_real_escape_string($form_data1->id);

									// 	//HEADER SECTION
									// 	$rs[0]['section_type']='FORM';	
									// 	$rs[0]['frmrpttemplatehdr_id']=41;
									// 	$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='invoice_summary';
									// 	$rs[0]['fields']='id,req_operating_unit,req_number,req_type,req_status,forward_to,last_updated_by,last_updated_date_time';
									// 	$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." where id=".$id;		

																			
									// 	$form_structure=$this->FrmRptModel->create_form($rs,$id);
									// 	$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);

									// 	//FORM SETTING//

									// 	$form_structure["header"][0]['fields'][0]['req_status']['InputType']='text';
									// 	$form_structure["header"][0]['fields'][0]['req_status']['DIVClass']=6;						

									// 	$sql="select  id FieldID,name FieldVal  from tbl_employee_mstr
									// 		where  login_status<>'SUPER' and status='ACTIVE' and account_setup_id=".$setting['account_setup_id']." 
									// 		and id<>".$setting['login_emp_id']." order by name	";
									// 	$datafields_array =$this->projectmodel->get_records_from_sql($sql);
									// 	$form_structure["header"][0]['fields'][0]['forward_to']['datafields']=json_decode(json_encode($datafields_array), true);	
									

									// array_push($output,$form_structure);
									// header('Access-Control-Allow-Origin: *');
									// header("Content-Type: application/json");
									// echo json_encode($output);						

								}

								//save section
								if($subtype=='SAVE_DATA')
								{	$this->projectmodel->save_data($form_data1->raw_data,$form_name); }	

								if($subtype=='MAIN_GRID')
								{
								
									$id=33;	
									$rs[0]['section_type']='GRID_ENTRY';	
									$rs[0]['frmrpttemplatehdr_id']=41;
									$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='invoice_summary';
									$rs[0]['fields']='id,req_operating_unit,req_number,req_type,req_preparer,req_description,req_status,req_currency_id,req_total';
									$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." where status='PO_ENTRY' and req_status='91'";		
									$resval=$this->FrmRptModel->create_report($rs,$id); 

								}

								if($subtype=='other_search')
								{			
															
									$someArray=array();

									$header_index=$form_data1->header_index;
									$field_index=$form_data1->field_index;
									$searchelement=$form_data1->searchelement;
										$someArray = json_decode($form_data1->raw_data, true);

								}

						}
					
						if($form_name=='receipt_of_goods')
						{
											
								if($subtype=='view_list')
								{			
									
										$id=mysql_real_escape_string($form_data1->id);
										$form_structure=$this->form_view($form_name,$id);
										array_push($output,$form_structure);
										header('Access-Control-Allow-Origin: *');
										header("Content-Type: application/json");
										echo json_encode($output);	
								}

								//save section
								if($subtype=='SAVE_DATA')
								{$this->projectmodel->save_data($form_data1->raw_data,$form_name);}	

								if($subtype=='MAIN_GRID')
								{
								
									$id=33;	
									$rs[0]['section_type']='GRID_ENTRY';	
									$rs[0]['frmrpttemplatehdr_id']=41;
									$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='invoice_summary';
									$rs[0]['fields']='id,req_operating_unit,req_number,req_type,req_preparer,req_description,req_status,req_currency_id,req_total';
									$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." where status='GRN_ENTRY'";		
									$resval=$this->FrmRptModel->create_report($rs,$id); 

								}

								if($subtype=='other_search')
								{			
									
									$output= $someArray=array();
									$header_index=mysql_real_escape_string($form_data1->header_index);
									$field_index=mysql_real_escape_string($form_data1->field_index);
									$searchelement=mysql_real_escape_string($form_data1->searchelement);
										$someArray = json_decode($form_data1->raw_data, true);

								
									if($searchelement=='parent_id')
									{						
									
										$id=0;
										$parent_id=
										$someArray[0]["header"][$header_index]['fields'][$field_index]['parent_id']['Inputvalue_id'];
										
										$entry_type='EDIT';
										$whr=" parent_id=".$parent_id;	
										$id=$this->projectmodel->GetSingleVal('id','invoice_summary',$whr); //PO ID

										if($id==0)
										{
											$whr=" id=".$parent_id;	
											$id=$this->projectmodel->GetSingleVal('id','invoice_summary',$whr); //requisition id
											$entry_type='NEW';
										}	

										$form_structure=$this->form_view($form_name,$id);


										
										$whr=" id=".$parent_id;	
											$req_number=$this->projectmodel->GetSingleVal('req_number','invoice_summary',$whr); //requisition id
										$form_structure["header"][$header_index]['fields'][$field_index]['parent_id']['Inputvalue']=$req_number;
										$form_structure["header"][$header_index]['fields'][$field_index]['parent_id']['Inputvalue_id']=$parent_id;

										if($entry_type=='NEW')
										{
												$form_structure["header"][$header_index]['fields'][$field_index]['id']['Inputvalue']='';
												$form_structure["header"][$header_index]['fields'][$field_index]['id']['Inputvalue_id']=0;
												
												$count_parent=sizeof($form_structure['header'][1]['fields']);		
												if($count_parent>0)
												{
													for($cnt_parent=0;$cnt_parent<=$count_parent-1;$cnt_parent++)
													{	
														//modify parent
														$form_structure["header"][1]['fields'][$cnt_parent]['parent_id']['Inputvalue']=
														$form_structure["header"][1]['fields'][$cnt_parent]['id']['Inputvalue'];

														$form_structure["header"][1]['fields'][$cnt_parent]['parent_id']['Inputvalue_id']=
														$form_structure["header"][1]['fields'][$cnt_parent]['id']['Inputvalue_id'];
														
														$form_structure["header"][1]['fields'][$cnt_parent]['id']['Inputvalue']='';
														$form_structure["header"][1]['fields'][$cnt_parent]['id']['Inputvalue_id']=0;
													}	
												}
										

										}
									}

										array_push($output,$form_structure);
										header('Access-Control-Allow-Origin: *');
										header("Content-Type: application/json");
										echo json_encode($output);			


								}

						}

						if($form_name=='INSPECTION')
						{
											
								if($subtype=='view_list')
								{			
									
									$id=mysql_real_escape_string($form_data1->id);
									$form_structure=$this->form_view($form_name,$id);
									array_push($output,$form_structure);
									header('Access-Control-Allow-Origin: *');
									header("Content-Type: application/json");
									echo json_encode($output);	
								}

								//save section

								if($subtype=='SAVE_DATA')
								{$this->projectmodel->save_data($form_data1->raw_data,$form_name);}	

								if($subtype=='MAIN_GRID')
								{
								
									$id=33;	
									$rs[0]['section_type']='GRID_ENTRY';	
									$rs[0]['frmrpttemplatehdr_id']=41;
									$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='invoice_summary';
									$rs[0]['fields']='id,req_operating_unit,req_number,req_type,req_preparer,req_description,req_status,req_currency_id,req_total';
									$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." where status='INSPECTION'";		
									$resval=$this->FrmRptModel->create_report($rs,$id); 

								}

								if($subtype=='other_search')
								{			
															
									$output= $someArray=array();
									$header_index=mysql_real_escape_string($form_data1->header_index);
									$field_index=mysql_real_escape_string($form_data1->field_index);
									$searchelement=mysql_real_escape_string($form_data1->searchelement);
										$someArray = json_decode($form_data1->raw_data, true);

								
									if($searchelement=='parent_id')
									{						
									
										$id=0;
										$parent_id=
										$someArray[0]["header"][$header_index]['fields'][$field_index]['parent_id']['Inputvalue_id'];
										
										$entry_type='EDIT';
										$whr=" parent_id=".$parent_id;	
										$id=$this->projectmodel->GetSingleVal('id','invoice_summary',$whr); //PO ID

										if($id==0)
										{
											$whr=" id=".$parent_id;	
											$id=$this->projectmodel->GetSingleVal('id','invoice_summary',$whr); //requisition id
											$entry_type='NEW';
										}	

										$form_structure=$this->form_view($form_name,$id);


										
										$whr=" id=".$parent_id;	
											$req_number=$this->projectmodel->GetSingleVal('req_number','invoice_summary',$whr); //requisition id
										$form_structure["header"][$header_index]['fields'][$field_index]['parent_id']['Inputvalue']=$req_number;
										$form_structure["header"][$header_index]['fields'][$field_index]['parent_id']['Inputvalue_id']=$parent_id;

										if($entry_type=='NEW')
										{
												
												$form_structure["header"][$header_index]['fields'][$field_index]['id']['Inputvalue']='';
												$form_structure["header"][$header_index]['fields'][$field_index]['id']['Inputvalue_id']=0;
												$count_parent=sizeof($form_structure['header'][1]['fields']);		
												if($count_parent>0)
												{
													for($cnt_parent=0;$cnt_parent<=$count_parent-1;$cnt_parent++)
													{	
														
													//modify parent
													$form_structure["header"][1]['fields'][$cnt_parent]['parent_id']['Inputvalue']=
													$form_structure["header"][1]['fields'][$cnt_parent]['id']['Inputvalue'];

													$form_structure["header"][1]['fields'][$cnt_parent]['parent_id']['Inputvalue_id']=
													$form_structure["header"][1]['fields'][$cnt_parent]['id']['Inputvalue_id'];
														
														$form_structure["header"][1]['fields'][$cnt_parent]['id']['Inputvalue']='';
														$form_structure["header"][1]['fields'][$cnt_parent]['id']['Inputvalue_id']=0;
													}	
												}	

										}



									}

									array_push($output,$form_structure);
									header('Access-Control-Allow-Origin: *');
									header("Content-Type: application/json");
									echo json_encode($output);	

								}

						}
								
						
						if($form_name=='purchase_invoice')
						{

								if($subtype=='view_list')
								{			
									
										$id=mysql_real_escape_string($form_data1->id);						
										$form_structure=$this->form_view($form_name,$id);

										array_push($output,$form_structure);
										header('Access-Control-Allow-Origin: *');
										header("Content-Type: application/json");
										echo json_encode($output);	
								}

								//save section
								if($subtype=='SAVE_DATA')
								{$this->projectmodel->save_data($form_data1->raw_data,$form_name);}


								if($subtype=='MAIN_GRID')
								{


									$indx=0;
									$form_id=87;
									$whr=" id=".$form_id;	
									$DataFields=$this->projectmodel->GetSingleVal('GridHeader','frmrpttemplatehdr',$whr);	
									$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
									$WhereCondition=$this->projectmodel->GetSingleVal('WhereCondition','frmrpttemplatehdr',$whr);	
									$id=12;
									$rs[$indx]['section_type']='GRID_ENTRY';	
									$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
									$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
									$rs[$indx]['fields']=$DataFields;
									$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where ".$WhereCondition;
																	
									$resval=$this->FrmRptModel->create_report($rs,$id); 

								}

								if($subtype=='MATCH_PO')
								{
								
									$output= $someArray=array();					
									$someArray = json_decode($form_data1->raw_data, true);

									$req_operating_unit=$someArray[0]["header"][0]['fields'][0]['req_operating_unit']['Inputvalue_id'];
									$req_supplier_id=$someArray[0]["header"][0]['fields'][0]['req_supplier']['Inputvalue_id'];
									
									$po_ids=0;
									$details="select * from  invoice_summary  where status='PURCHASE_INVOICE' 
									and req_operating_unit=".$req_operating_unit." and req_status=91 and req_supplier=".$req_supplier_id." ";					
									$details = $this->projectmodel->get_records_from_sql($details);	
									foreach ($details as $key2=>$detail)
									{	$po_ids=$po_ids.','.$detail->parent_id;}
									
									$id=33;	
									$rs[0]['section_type']='GRID_ENTRY';	
									$rs[0]['frmrpttemplatehdr_id']=41;
									$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='invoice_summary';
									$rs[0]['fields']='id,req_operating_unit,req_number,req_type,req_preparer,ledger_id,req_status,req_total';
									$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." 
									where status='PO_ENTRY' and id not in (".$po_ids.")	and req_operating_unit=".$req_operating_unit." and req_supplier=".$req_supplier_id." ";		
									$resval=$this->FrmRptModel->create_report($rs,$id); 

								}

								if($subtype=='PO_DATA')
								{
								
									$output= $someArray=array();					
									$someArray = json_decode($form_data1->raw_data, true);
									$parent_id=$form_data1->id;

										$entry_type='EDIT';
										$whr=" status='PURCHASE_INVOICE' and parent_id=".$parent_id;	
										$id=$this->projectmodel->GetSingleVal('id','invoice_summary',$whr); //PO ID

										if($id==0)
										{
											$whr=" id=".$parent_id;	
											$id=$this->projectmodel->GetSingleVal('id','invoice_summary',$whr); //requisition id
											$entry_type='NEW';
										}			
										
											$form_structure=$this->form_view($form_name,$id);
										
											if($entry_type=='NEW')
											{
												$header_index=$field_index=0;
												$form_structure["header"][0]['fields'][$field_index]['id']['Inputvalue']='';
												$form_structure["header"][0]['fields'][$field_index]['id']['Inputvalue_id']=0;
												$form_structure["header"][0]['fields'][0]['parent_id']['Inputvalue']=$parent_id;;
												$form_structure["header"][0]['fields'][0]['parent_id']['Inputvalue_id']=$parent_id;;													
											
												$count_parent=sizeof($form_structure['header'][1]['fields']);		
												for($cnt_parent=0;$cnt_parent<=$count_parent-1;$cnt_parent++)
												{	
													$form_structure["header"][1]['fields'][$cnt_parent]['id']['Inputvalue']='';
													$form_structure["header"][1]['fields'][$cnt_parent]['id']['Inputvalue_id']=0;
												}	

											}
											
											//FORM CUSTOM SETTING END


									array_push($output,$form_structure);
									header('Access-Control-Allow-Origin: *');
									header("Content-Type: application/json");
									echo json_encode($output);						


								}

								if($subtype=='other_search')
								{			
															
									$output= $someArray=array();

									$header_index=mysql_real_escape_string($form_data1->header_index);
									$field_index=mysql_real_escape_string($form_data1->field_index);
									$searchelement=mysql_real_escape_string($form_data1->searchelement);
									$someArray = json_decode($form_data1->raw_data, true);

									if($searchelement=='parent_id')
									{

									}

								}

						}


						if($form_name=='payment_rcv')
						{
											
								if($subtype=='view_list')
								{			
									
										$id=mysql_real_escape_string($form_data1->id);
										$form_structure=$this->form_view($form_name,$id);

										//FORM WISE SETTING
									
										if($form_structure["header"][0]['fields'][0]['req_currency_id']['Inputvalue_id']=='')
										{								
											$form_structure["header"][0]['fields'][0]['req_currency_id']['Inputvalue_id']=$setting['currency_id'];							
											$form_structure["header"][0]['fields'][0]['req_currency_id']['Inputvalue']=$setting['currency_name'];
										}
									
										//FORM WISE SETTING

									array_push($output,$form_structure);
									header('Access-Control-Allow-Origin: *');
									header("Content-Type: application/json");
									echo json_encode($output);						

								}

								//save section
								if($subtype=='SAVE_DATA')
								{
									
											$form_data=json_decode($form_data1->raw_data);
											
											// $save_details2['test_data']=$form_data1->raw_data;
											// //$save_details2['test_data']=json_decode(json_encode($form_data1->raw_data), true );
											// $this->projectmodel->save_records_model('','test_table',$save_details2);

											$headers=json_decode(json_encode($form_data[0]->header), true );
											$header_scount=sizeof($headers);
											$id_header=0;	
											$count=sizeof($form_data[0]->header);		
											$headers=json_decode(json_encode($form_data[0]->header), true );
										//	$save_details=$this->create_save_array($headers);
											$save_details=$this->FrmRptModel->create_save_array($headers);
										

											$header_id=$id='';
											foreach($save_details as $key1=>$tables)
											{
												
												foreach($tables as $key2=>$fields)
												{
														$table_name=$key2;		
														$savedata=array();	
														$save_statue=true;
																			
														foreach($fields as $key3=>$value)
														{
															//HERE REQUIRE CUSTOMIZATION
															if($key3=='id' && $table_name=='invoice_payment_receive')
															{
																if($value>0)
																{$header_id=$value;}
																else 
																{$header_id='';}  											
															}
															else if ($key3<>'id' && $table_name=='invoice_payment_receive')
															{$savedata[$key3]=$value;}
															else if ($key3=='id' && $table_name=='invoice_summary')
															{if($value>0){$id=$value;}else {$id='';}   }
															else if ($key3=='invoice_payment_id' && $table_name=='invoice_summary')
															{$savedata[$key3]=$header_id; }
															else 
															{$savedata[$key3]=$value; }

														}

														//HEADER SECTION
														if($table_name=='invoice_payment_receive')
														{
															$this->projectmodel->save_records_model($header_id,$table_name,$savedata);
															if($key1==0 && $header_id==''){$header_id=$this->db->insert_id();}												
														}
														if($table_name=='invoice_summary')
														{
															if($savedata['req_submit_approval']=='YES'){$this->projectmodel->save_records_model($id,$table_name,$savedata);}												
														}
												}	

											}
											$this->projectmodel->update_transactions($header_id,$form_name);
											$this->accounts_model->ledger_transactions($header_id,$form_name);
											$return_data['id_header']=$header_id;

											
						
											header('Access-Control-Allow-Origin: *');
											header("Content-Type: application/json");
											echo json_encode($return_data);


								}	

								if($subtype=='MAIN_GRID')
								{
								

									$id=33;
									$indx=0;
									$form_id=55;
									$whr=" id=".$form_id;	
									$DataFields=$this->projectmodel->GetSingleVal('GridHeader','frmrpttemplatehdr',$whr);									
									$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);
									$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
									$WhereCondition=$this->projectmodel->GetSingleVal('WhereCondition','frmrpttemplatehdr',$whr);	
																		
									$rs[$indx]['section_type']='GRID_ENTRY';	
									$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
									$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
									$rs[$indx]['fields']=$DataFields;
									$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where ".$WhereCondition;		
									$resval=$this->FrmRptModel->create_report($rs,$id); 


								}

								if($subtype=='other_search')
								{			
															
									$someArray=array();

									$header_index=$form_data1->header_index;
									$field_index=$form_data1->field_index;
									$searchelement=$form_data1->searchelement;
									$someArray = json_decode($form_data1->raw_data, true);

									if($searchelement=='req_supplier')
									{							
											$supplier_id=$someArray[0]['header'][$header_index]['fields'][$field_index]['req_supplier']['Inputvalue_id'];
											$req_operating_unit=$someArray[0]['header'][0]['fields'][0]['req_operating_unit']['Inputvalue_id'];

											$whr=" id=".$supplier_id;							
											$someArray[0]['header'][$header_index]['fields'][$field_index]['req_contact']['Inputvalue']=$this->projectmodel->GetSingleVal('contact_person','mstr_supplier',$whr);
											$someArray[0]['header'][$header_index]['fields'][$field_index]['req_phone']['Inputvalue']=$this->projectmodel->GetSingleVal('phone_no','mstr_supplier',$whr);		
												
											// $rs="select * from  invoice_payment_receive_details where invoice_summary_id=".$detail_id." 
											// and invoice_payment_receive_id=".$tran_table_id." ";
											// $rs = $this->get_records_from_sql($rs);	
											// foreach ($rs as $rs_dtl)
											// {$payment_detail_id=$rs_dtl->id;}
											
											$id=17;																							
											$indx=3;
											$form_id=56;
											$whr=" id=".$form_id;	
											$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
											$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
											$rs[$indx]['section_type']='GRID_ENTRY';	
											$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
											$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
											$rs[$indx]['fields']=$DataFields;
											$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." 
											where invoice_due_total>0 and  req_supplier=".$supplier_id." 
											and req_operating_unit=".$req_operating_unit." and status='PURCHASE_INVOICE'	 ";	
											
											$cnt=0;
											$records="select count(*) cnt from ".$rs[$indx]['TableName']." 
											where invoice_due_total>0 and  req_supplier=".$supplier_id." 
											and req_operating_unit=".$req_operating_unit." and status='PURCHASE_INVOICE'	 ";

											$records =$this->projectmodel->get_records_from_sql($records);	
											foreach ($records as $record)
											{$cnt=$record->cnt;}

											if($cnt>0)
											{
												$form_structure=$this->FrmRptModel->create_form($rs,$id);								
												$someArray[0]['header'][3]=$form_structure['header'][3];
												$someArray=$this->FrmRptModel->re_arrange_input_index_type2($someArray);
											
											}
											else
											{
												$id=0;
												$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." 
												where id=0	 ";	

												$form_structure=$this->FrmRptModel->create_form($rs,$id);								
												$someArray[0]['header'][3]=$form_structure['header'][3];
												$someArray=$this->FrmRptModel->re_arrange_input_index_type2($someArray);

											}
										
											$this->FrmRptModel->tranfer_data($someArray);

									}

								

								}


						}

						//PROCURE TO PAY END 





						//ORDER TO CASH START

						if($form_name=='SALES_ORDER')
						{
											
								if($subtype=='view_list')
								{			
									
										$id=mysql_real_escape_string($form_data1->id);
										$form_structure=$this->form_view($form_name,$id);
										array_push($output,$form_structure);
										header('Access-Control-Allow-Origin: *');
										header("Content-Type: application/json");
										echo json_encode($output);						

								}

								//save section
								if($subtype=='SAVE_DATA')
								{
									$this->projectmodel->save_data($form_data1->raw_data,$form_name);
								}	


								if($subtype=='MAIN_GRID')
								{
								
									$id=33;	
									$rs[0]['section_type']='GRID_ENTRY';	
									$rs[0]['frmrpttemplatehdr_id']=41;
									$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='invoice_summary';
									$rs[0]['fields']='id,req_operating_unit,req_number,req_type,req_preparer,req_description,req_status,req_currency_id,req_total';
									$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." where status='SALES_ORDER'";		
									$resval=$this->FrmRptModel->create_report($rs,$id); 

								}

								if($subtype=='other_search')
								{			
															
									$output= $someArray=array();

									$header_index=mysql_real_escape_string($form_data1->header_index);
									$field_index=mysql_real_escape_string($form_data1->field_index);
									$searchelement=mysql_real_escape_string($form_data1->searchelement);
									$someArray = json_decode($form_data1->raw_data, true);
									
								
							

								}

						}

						if($form_name=='SALES_ORDER_APPROVE')
						{
											
								if($subtype=='view_list')
								{			
									
										$id=mysql_real_escape_string($form_data1->id);
										$indx=0;
										$form_id=88;
										$whr=" id=".$form_id;	
										$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
										$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
										$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
										$rs[$indx]['section_type']=$section_type;	
										$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
										$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
										$rs[$indx]['fields']=$DataFields;
										$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;

										$form_structure=$this->FrmRptModel->create_form($rs,$id);
										$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);
									

										$sql="select  id FieldID,name FieldVal  from tbl_employee_mstr
										where  login_status<>'SUPER' and status='ACTIVE' and account_setup_id=".$setting['account_setup_id']." 
										and id<>".$setting['login_emp_id']." order by name	";
										$datafields_array =$this->projectmodel->get_records_from_sql($sql);
										$form_structure["header"][0]['fields'][0]['forward_to']['datafields']=
										json_decode(json_encode($datafields_array), true);	
									

										array_push($output,$form_structure);
										header('Access-Control-Allow-Origin: *');
										header("Content-Type: application/json");
										echo json_encode($output);						

								}

								//save section
								if($subtype=='SAVE_DATA')
								{
									$this->projectmodel->save_data($form_data1->raw_data,$form_name);
								}	


								if($subtype=='MAIN_GRID')
								{
								
									$id=33;	
									$rs[0]['section_type']='GRID_ENTRY';	
									$rs[0]['frmrpttemplatehdr_id']=41;
									$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='invoice_summary';
									$rs[0]['fields']='id,req_operating_unit,req_number,req_type,req_preparer,req_description,req_status,req_currency_id,req_total';
									$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." where status='SALES_ORDER' and req_status='91'";		
									$resval=$this->FrmRptModel->create_report($rs,$id); 

								}

								if($subtype=='other_search')
								{			
															
									$someArray=array();

									$header_index=$form_data1->header_index;
									$field_index=$form_data1->field_index;
									$searchelement=$form_data1->searchelement;
									$someArray = json_decode($form_data1->raw_data, true);

								}

						}

						if($form_name=='DESPATCH_GOODS')
						{
											
								if($subtype=='view_list')
								{			
									
										$id=mysql_real_escape_string($form_data1->id);
										$form_structure=$this->form_view($form_name,$id);
										array_push($output,$form_structure);
										header('Access-Control-Allow-Origin: *');
										header("Content-Type: application/json");
										echo json_encode($output);			
								}

								//save section
								if($subtype=='SAVE_DATA')
								{
									$this->projectmodel->save_data($form_data1->raw_data,$form_name);
								}	

								if($subtype=='MAIN_GRID')
								{
								
									$id=33;	
									$rs[0]['section_type']='GRID_ENTRY';	
									$rs[0]['frmrpttemplatehdr_id']=41;
									$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='invoice_summary';
									$rs[0]['fields']='id,req_operating_unit,req_number,req_type,req_preparer,req_description,req_status,req_currency_id,req_total';
									$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." where status='ORDER_DESPATCH'";		
									$resval=$this->FrmRptModel->create_report($rs,$id); 

								}

								if($subtype=='other_search')
								{			
															
									$output= $someArray=array();
									$header_index=mysql_real_escape_string($form_data1->header_index);
									$field_index=mysql_real_escape_string($form_data1->field_index);
									$searchelement=mysql_real_escape_string($form_data1->searchelement);
									$someArray = json_decode($form_data1->raw_data, true);

									if($searchelement=='parent_id')
									{
									
										$id=0;
										$parent_id=$someArray[0]["header"][$header_index]['fields'][$field_index]['parent_id']['Inputvalue_id'];
										
										$entry_type='EDIT';
										$whr=" parent_id=".$parent_id;	
										$id=$this->projectmodel->GetSingleVal('id','invoice_summary',$whr); //PO ID

										if($id==0)
										{
											$whr=" id=".$parent_id;	
											$id=$this->projectmodel->GetSingleVal('id','invoice_summary',$whr); //requisition id
											$entry_type='NEW';
										}		
										
										$form_structure=$this->form_view($form_name,$id);
										
										$whr=" id=".$parent_id;	
										$req_number=$this->projectmodel->GetSingleVal('req_number','invoice_summary',$whr); //requisition id
										$form_structure["header"][$header_index]['fields'][$field_index]['parent_id']['Inputvalue']=$req_number;
										$form_structure["header"][$header_index]['fields'][$field_index]['parent_id']['Inputvalue_id']=$parent_id;

										if($entry_type=='NEW')
										{
													$form_structure["header"][$header_index]['fields'][$field_index]['id']['Inputvalue']='';
													$form_structure["header"][$header_index]['fields'][$field_index]['id']['Inputvalue_id']=0;
													
													$count_parent=sizeof($form_structure['header'][1]['fields']);		
													if($count_parent>0)
													{
															for($cnt_parent=0;$cnt_parent<=$count_parent-1;$cnt_parent++)
															{	
																	//modify parent
																	$form_structure["header"][1]['fields'][$cnt_parent]['parent_id']['Inputvalue']=
																	$form_structure["header"][1]['fields'][$cnt_parent]['id']['Inputvalue'];

																	$form_structure["header"][1]['fields'][$cnt_parent]['parent_id']['Inputvalue_id']=
																	$form_structure["header"][1]['fields'][$cnt_parent]['id']['Inputvalue_id'];
																	
																	$form_structure["header"][1]['fields'][$cnt_parent]['id']['Inputvalue']='';
																	$form_structure["header"][1]['fields'][$cnt_parent]['id']['Inputvalue_id']=0;
															}	
													}
										

										}

										array_push($output,$form_structure);
										$this->FrmRptModel->tranfer_data($output);

									}

							

								}

						}


						if($form_name=='sale_invoice')
						{

								if($subtype=='view_list')
								{			
									
										$id=mysql_real_escape_string($form_data1->id);						
										$form_structure=$this->form_view($form_name,$id);

										array_push($output,$form_structure);
										header('Access-Control-Allow-Origin: *');
										header("Content-Type: application/json");
										echo json_encode($output);	
								}

								if($subtype=='SAVE_DATA')
								{
									$this->projectmodel->save_data($form_data1->raw_data,$form_name);
								}	


								if($subtype=='MAIN_GRID')
								{
								
									$id=33;	
									$rs[0]['section_type']='GRID_ENTRY';	
									$rs[0]['frmrpttemplatehdr_id']=41;
									$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='invoice_summary';
									$rs[0]['fields']='id,req_operating_unit,req_number,req_type,req_preparer,ledger_id,req_status,req_total';
									$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." where status='SALES_INVOICE'";		
									$resval=$this->FrmRptModel->create_report($rs,$id); 

								}
								if($subtype=='MATCH_PO')
								{
								
									$output= $someArray=array();					
									$someArray = json_decode($form_data1->raw_data, true);

									$req_operating_unit=$someArray[0]["header"][0]['fields'][0]['req_operating_unit']['Inputvalue_id'];
									$req_supplier_id=$someArray[0]["header"][0]['fields'][0]['req_supplier']['Inputvalue_id'];
									
									$po_ids=0;
									$details="select * from  invoice_summary  where status='SALES_INVOICE' 
									and req_operating_unit=".$req_operating_unit." and req_supplier=".$req_supplier_id." ";					
									$details = $this->projectmodel->get_records_from_sql($details);	
									foreach ($details as $key2=>$detail)
									{	$po_ids=$po_ids.','.$detail->parent_id;}
									
									$id=33;	
									$rs[0]['section_type']='GRID_ENTRY';	
									$rs[0]['frmrpttemplatehdr_id']=41;
									$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='invoice_summary';
									$rs[0]['fields']='id,req_operating_unit,req_number,req_type,req_preparer,ledger_id,req_status,req_total';
									$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." 
									where status='SALES_ORDER' and id not in (".$po_ids.")	and req_operating_unit=".$req_operating_unit." and req_supplier=".$req_supplier_id." ";		
									$resval=$this->FrmRptModel->create_report($rs,$id); 

								}

								if($subtype=='PO_DATA')
								{
								
									$output= $someArray=array();					
									$someArray = json_decode($form_data1->raw_data, true);
									$parent_id=$form_data1->id;

										$entry_type='EDIT';
										$whr=" status='SALES_INVOICE' and parent_id=".$parent_id;	
										$id=$this->projectmodel->GetSingleVal('id','invoice_summary',$whr); //PO ID

										if($id==0)
										{
											$whr=" id=".$parent_id;	
											$id=$this->projectmodel->GetSingleVal('id','invoice_summary',$whr); //requisition id
											$entry_type='NEW';
										}						
										
									///

									$indx=0;
									$rs[$indx]['section_type']='FORM';	
									$rs[$indx]['frmrpttemplatehdr_id']=57;
									$rs[$indx]['TableName']='invoice_summary';
									$rs[$indx]['fields']='id,req_operating_unit,req_supplier,req_number,req_accounting_date,req_currency_id,Gl_date,Terms_date,Terms,Payment_method,Pay_group,parent_id';
									$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;	
						
						
									//BODY OR GRID ENTRY SECTION	
											

									$indx=1;				
									$rs[$indx]['section_type']='GRID_ENTRY';		
									$rs[$indx]['frmrpttemplatehdr_id']=93;
									$rs[$indx]['TableName']='invoice_details';								
									$rs[$indx]['fields']='id,invoice_summary_id,item_id,qnty,uom,price,total_amount,Gl_date'.$setting['segments'].',asset_book,tax_ledger_id,tax_rate,tax_amount';
									$rs[$indx]['id']=0;	$rs[$indx]['parent_id']=$id;
									$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where  invoice_summary_id=".$id;
					

									// $rs[$indx]['section_type']='GRID_ENTRY';		
									// $rs[$indx]['frmrpttemplatehdr_id']=48;
									// $rs[$indx]['TableName']='invoice_details';								
									// $rs[$indx]['fields']='id,invoice_summary_id,item_id,total_amount,Gl_date'.$setting['segments'].',asset_book,tax_ledger_id,tax_rate,tax_amount';
									// $rs[$indx]['id']=0;	$rs[$indx]['parent_id']=$id;$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where  invoice_summary_id=".$id;								
						
									//,tax_ledger_id,tax_rate,tax_amount
						
									//TAX SECTION
									// $indx=2;
									// $rs[$indx]['section_type']='GRID_ENTRY';		
									// $rs[$indx]['frmrpttemplatehdr_id']=53;
									// $rs[$indx]['TableName']='invoice_tax_details';								
									// $rs[$indx]['fields']='id,invoice_summary_id,tax_ledger_id,tax_rate,tax_amount,status,tax_type';
									// $rs[$indx]['id']=0;	$rs[$indx]['parent_id']=$id;
									// $rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where  invoice_summary_id=".$id;	
									
									$indx=2;
									$rs[$indx]['section_type']='FORM';	
									$rs[$indx]['frmrpttemplatehdr_id']=57;
									$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';$rs[$indx]['TableName']='invoice_summary';
									$rs[$indx]['fields']='invoice_tot_items,invoice_retainage,invoice_prepayment_amount,invoice_withholding,invoice_subtotal,tax_amount,freight_amount,Misc_amount,invoice_grand_total';
									$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;		
									
									$indx=3;							
									$rs[$indx]['section_type']='FORM';	
									$rs[$indx]['frmrpttemplatehdr_id']=57;
									$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';$rs[$indx]['TableName']='invoice_summary';
									$rs[$indx]['fields']='invoice_status,invoice_accounted,req_status,parent_id,req_type,status';
									$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;						
														
									$form_structure=$this->FrmRptModel->create_form($rs,$id);
									$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);
						
						
									//aanatuaral account ...link to credit account
									$field_qualifier_name='';
									$cnts=sizeof($setting['segment']);
									for($cnt=0;$cnt<$cnts;$cnt++)
									{
										$field_qualifier_name=$setting['segment'][$cnt]['field_qualifier_name'];
										if($field_qualifier_name=='account_id')
										{$form_structure["header"][0]['fields'][0]['ledger_id']['datafields']=$setting['segment'][$cnt]['value_set'];}											
									}
						
									$field_qualifier_name='';
									$cnts=sizeof($setting['segment']);
									for($cnt=0;$cnt<$cnts;$cnt++)
									{
										$field_qualifier_name=$setting['segment'][$cnt]['field_qualifier_name'];
										$form_structure["header"][1]['fields'][0][$field_qualifier_name]['datafields']=$setting['segment'][$cnt]['value_set'];
										$form_structure["header"][1]['fields'][0][$field_qualifier_name]['LabelName']=$setting['segment'][$cnt]['segment_name'];
									}
						
									$cnts=sizeof($form_structure["header"][1]['fields']);
									for($i=0;$i<$cnts;$i++)
									{
										$field_qualifier_name='';
										$cnts2=sizeof($setting['segment']);
										for($cnt=0;$cnt<$cnts2;$cnt++)
										{
											$field_qualifier_name=$setting['segment'][$cnt]['field_qualifier_name'];
											$form_structure["header"][1]['fields'][$i][$field_qualifier_name]['datafields']=$setting['segment'][$cnt]['value_set'];
										}
									}
						
									//created_by,create_date_time,req_preparer
									//FORM WISE SETTING
						
									//for new entry
									
									$form_structure["header"][0]['fields'][0]['req_number']['LabelName']='Invoice No';
									$form_structure["header"][0]['fields'][0]['req_accounting_date']['LabelName']='Invoice Date';		
									$form_structure["header"][0]['fields'][0]['req_currency_id']['LabelName']='Pay Currency';
									$form_structure["header"][0]['fields'][0]['parent_id']['InputType']='hidden';
									// $form_structure["header"][0]['fields'][0]['req_supplier']['LabelName']='Customer';
											
									
									$indx=3;
									$form_structure["header"][$indx]['fields'][0]['req_type']['Inputvalue']='Sales Invoice';
									$form_structure["header"][$indx]['fields'][0]['req_type']['Inputvalue_id']=144;
									$form_structure["header"][$indx]['fields'][0]['status']['Inputvalue']='SALES_INVOICE';
									$form_structure["header"][$indx]['fields'][0]['parent_id']['InputType']='hidden';
									$form_structure["header"][$indx]['fields'][0]['req_type']['InputType']='hidden';
									$form_structure["header"][$indx]['fields'][0]['status']['InputType']='hidden';
									$form_structure["header"][$indx]['fields'][0]['req_status']['InputType']='hidden';

									///


									// $form_structure["header"][0]['fields'][0]['req_number']['LabelName']='Invoice No';
									// $form_structure["header"][0]['fields'][0]['req_accounting_date']['LabelName']='Invoice Date';
									// $form_structure["header"][0]['fields'][0]['req_total']['LabelName']='Invoice Amount';
									// $form_structure["header"][0]['fields'][0]['req_currency_id']['LabelName']='Pay Currency';
									// $form_structure["header"][0]['fields'][0]['last_updated_by']['Inputvalue_id']=$setting['login_emp_id'];
									// $form_structure["header"][0]['fields'][0]['last_updated_date_time']['Inputvalue_id']=date('Y-m-d H:i:s');
								
									// $form_structure["header"][0]['fields'][0]['parent_id']['InputType']='LABEL';


									// $indx=3;
									// $form_structure["header"][$indx]['fields'][0]['req_type']['Inputvalue']='Receive Invoice';
									// $form_structure["header"][$indx]['fields'][0]['req_type']['Inputvalue_id']=95;
									// $form_structure["header"][$indx]['fields'][0]['status']['Inputvalue']='PURCHASE_INVOICE';

									// $form_structure["header"][$indx]['fields'][0]['parent_id']['InputType']='hidden';
									// $form_structure["header"][$indx]['fields'][0]['req_type']['InputType']='hidden';
									// $form_structure["header"][$indx]['fields'][0]['status']['InputType']='hidden';


									if($entry_type=='NEW')
									{
										$header_index=$field_index=0;
										$form_structure["header"][0]['fields'][$field_index]['id']['Inputvalue']='';
										$form_structure["header"][0]['fields'][$field_index]['id']['Inputvalue_id']=0;

										// $form_structure["header"][0]['fields'][0]['parent_id']['Inputvalue']=$parent_id;
										// $form_structure["header"][0]['fields'][0]['parent_id']['Inputvalue_id']=$parent_id;

										// $form_structure["header"][0]['fields'][0]['parent_id']['Inputvalue']=0;
										// $form_structure["header"][0]['fields'][0]['parent_id']['Inputvalue_id']=0;

										$form_structure["header"][0]['fields'][0]['parent_id']['Inputvalue']=$parent_id;;
										$form_structure["header"][0]['fields'][0]['parent_id']['Inputvalue_id']=$parent_id;;
																
										$count_parent=sizeof($form_structure['header'][1]['fields']);		
										for($cnt_parent=0;$cnt_parent<=$count_parent-1;$cnt_parent++)
										{	
											$form_structure["header"][1]['fields'][$cnt_parent]['id']['Inputvalue']='';
											$form_structure["header"][1]['fields'][$cnt_parent]['id']['Inputvalue_id']=0;
										}	

									}
											
											//FORM CUSTOM SETTING END


									array_push($output,$form_structure);
									header('Access-Control-Allow-Origin: *');
									header("Content-Type: application/json");
									echo json_encode($output);						


								}

							

								if($subtype=='other_search')
								{			
															
									$output= $someArray=array();

									$header_index=mysql_real_escape_string($form_data1->header_index);
									$field_index=mysql_real_escape_string($form_data1->field_index);
									$searchelement=mysql_real_escape_string($form_data1->searchelement);
									$someArray = json_decode($form_data1->raw_data, true);

									if($searchelement=='parent_id')
									{

									}

								}

						}


						if($form_name=='receive_amt')
						{
											
								if($subtype=='view_list')
								{			
									
										$id=mysql_real_escape_string($form_data1->id);
										$form_structure=$this->form_view($form_name,$id);

										//FORM WISE SETTING
									
										if($form_structure["header"][0]['fields'][0]['req_currency_id']['Inputvalue_id']=='')
										{								
											$form_structure["header"][0]['fields'][0]['req_currency_id']['Inputvalue_id']=$setting['currency_id'];							
											$form_structure["header"][0]['fields'][0]['req_currency_id']['Inputvalue']=$setting['currency_name'];
										}
									
										//FORM WISE SETTING

									array_push($output,$form_structure);
									header('Access-Control-Allow-Origin: *');
									header("Content-Type: application/json");
									echo json_encode($output);						

								}

								//save section
								if($subtype=='SAVE_DATA')
								{
									
											$form_data=json_decode($form_data1->raw_data);
											
											// $save_details2['test_data']=$form_data1->raw_data;
											// //$save_details2['test_data']=json_decode(json_encode($form_data1->raw_data), true );
											// $this->projectmodel->save_records_model('','test_table',$save_details2);

											$headers=json_decode(json_encode($form_data[0]->header), true );
											$header_scount=sizeof($headers);
											$id_header=0;	
											$count=sizeof($form_data[0]->header);		
											$headers=json_decode(json_encode($form_data[0]->header), true );
										//	$save_details=$this->create_save_array($headers);
											$save_details=$this->FrmRptModel->create_save_array($headers);
										

											$header_id=$id='';
											foreach($save_details as $key1=>$tables)
											{
												
												foreach($tables as $key2=>$fields)
												{
														$table_name=$key2;		
														$savedata=array();	
														$save_statue=true;
																			
														foreach($fields as $key3=>$value)
														{
															//HERE REQUIRE CUSTOMIZATION
															if($key3=='id' && $table_name=='invoice_payment_receive')
															{
																if($value>0)
																{$header_id=$value;}
																else 
																{$header_id='';}  											
															}
															else if ($key3<>'id' && $table_name=='invoice_payment_receive')
															{$savedata[$key3]=$value;}
															else if ($key3=='id' && $table_name=='invoice_summary')
															{if($value>0){$id=$value;}else {$id='';}   }
															else if ($key3=='invoice_payment_id' && $table_name=='invoice_summary')
															{$savedata[$key3]=$header_id; }
															else 
															{$savedata[$key3]=$value; }

														}

														//HEADER SECTION
														if($table_name=='invoice_payment_receive')
														{
															$this->projectmodel->save_records_model($header_id,$table_name,$savedata);
															if($key1==0 && $header_id==''){$header_id=$this->db->insert_id();}												
														}
														if($table_name=='invoice_summary')
														{
															if($savedata['req_submit_approval']=='YES'){$this->projectmodel->save_records_model($id,$table_name,$savedata);}												
														}
												}	

											}

											$this->projectmodel->update_transactions($header_id,$form_name);
											$this->accounts_model->ledger_transactions($header_id,$form_name);
											$return_data['id_header']=$header_id;
						
											header('Access-Control-Allow-Origin: *');
											header("Content-Type: application/json");
											echo json_encode($return_data);


								}	

								if($subtype=='MAIN_GRID')
								{
								
									// $id=33;	
									// $rs[0]['section_type']='GRID_ENTRY';	
									// $rs[0]['frmrpttemplatehdr_id']=55;
									// $rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='invoice_payment_receive';
									// $rs[0]['fields']='id,req_operating_unit,req_supplier,req_number,req_accounting_date,req_total,req_currency_id,bank_id';
									// $rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." ";		
									// $resval=$this->FrmRptModel->create_report($rs,$id); 


									$id=33;
									$indx=0;
									$form_id=63;
									$whr=" id=".$form_id;	
									$DataFields=$this->projectmodel->GetSingleVal('GridHeader','frmrpttemplatehdr',$whr);									
									$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);
									$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
									$WhereCondition=$this->projectmodel->GetSingleVal('WhereCondition','frmrpttemplatehdr',$whr);	
																		
									$rs[$indx]['section_type']='GRID_ENTRY';	
									$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
									$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
									$rs[$indx]['fields']=$DataFields;
									$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where ".$WhereCondition;		
									$resval=$this->FrmRptModel->create_report($rs,$id); 
					


								}

								if($subtype=='other_search')
								{			
															
									$someArray=array();

									$header_index=$form_data1->header_index;
									$field_index=$form_data1->field_index;
									$searchelement=$form_data1->searchelement;
									$someArray = json_decode($form_data1->raw_data, true);

									if($searchelement=='req_supplier')
									{							
											$supplier_id=$someArray[0]['header'][$header_index]['fields'][$field_index]['req_supplier']['Inputvalue_id'];
											$req_operating_unit=$someArray[0]['header'][0]['fields'][0]['req_operating_unit']['Inputvalue_id'];

											$whr=" id=".$supplier_id;							
											$someArray[0]['header'][$header_index]['fields'][$field_index]['req_contact']['Inputvalue']=
											$this->projectmodel->GetSingleVal('contact_person','mstr_supplier',$whr);

											$someArray[0]['header'][$header_index]['fields'][$field_index]['req_phone']['Inputvalue']=
											$this->projectmodel->GetSingleVal('phone_no','mstr_supplier',$whr);		
												
										
											
											$id=17;																							
											$indx=3;
											$form_id=56;
											$whr=" id=".$form_id;	
											$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
											$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
											$rs[$indx]['section_type']='GRID_ENTRY';	
											$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
											$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
											$rs[$indx]['fields']=$DataFields;
											$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." 
											where invoice_due_total>0 and  req_supplier=".$supplier_id." 
											and req_operating_unit=".$req_operating_unit." and status='SALES_INVOICE'	 ";	
											
											$cnt=0;
											$records="select count(*) cnt from ".$rs[$indx]['TableName']." 
											where invoice_due_total>0 and  req_supplier=".$supplier_id." 
											and req_operating_unit=".$req_operating_unit." and status='SALES_INVOICE'	 ";

											$records =$this->projectmodel->get_records_from_sql($records);	
											foreach ($records as $record)
											{$cnt=$record->cnt;}

											if($cnt>0)
											{
												$form_structure=$this->FrmRptModel->create_form($rs,$id);								
												$someArray[0]['header'][3]=$form_structure['header'][3];
												$someArray=$this->FrmRptModel->re_arrange_input_index_type2($someArray);
											
											}
											else
											{
												$id=0;
												$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." 
												where id=0	 ";	

												$form_structure=$this->FrmRptModel->create_form($rs,$id);								
												$someArray[0]['header'][3]=$form_structure['header'][3];
												$someArray=$this->FrmRptModel->re_arrange_input_index_type2($someArray);

											}
										
											$this->FrmRptModel->tranfer_data($someArray);

											// $id=17;																							
											// $indx=3;
											// $form_id=56;
											// $whr=" id=".$form_id;	
											// $DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
											// $TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
											// $rs[$indx]['section_type']='GRID_ENTRY';	
											// $rs[$indx]['frmrpttemplatehdr_id']=$form_id;
											// $rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
											// $rs[$indx]['fields']=$DataFields;
											// $rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." 
											// where invoice_due_total>0 and  req_supplier=".$supplier_id." and req_operating_unit=".$req_operating_unit." and status='SALES_INVOICE'	 ";				
											
											// $form_structure=$this->FrmRptModel->create_form($rs,$id);								
											// $someArray[0]['header'][3]=$form_structure['header'][3];
											// $someArray=$this->FrmRptModel->re_arrange_input_index_type2($someArray);
										
											// $this->FrmRptModel->tranfer_data($someArray);


									}

								}


						}

		  			//ORDER TO CASH END


					//OPM SECTION

					//opm_operation_summary
					if($form_name=='opm_operation_summary')
					{
							
						if($subtype=='view_list')
						{

									$indx=0;
									$form_id=67;
									$id=$form_data1->id;	
									//$id=4;
									$whr=" id=".$form_id;	
									$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
									$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
									$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
									$rs[$indx]['section_type']=$section_type;	
									$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
									$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
									$rs[$indx]['fields']=$DataFields;
									$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;


									$indx=1;
									$form_id=68;
									//$id=0;	
									$opm_define_operations_summary_id=$form_data1->id;
									//$opm_define_operations_summary_id=4;
									$whr=" id=".$form_id;	
									$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
									$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
									$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
									$rs[$indx]['section_type']='GRID_ENTRY';		
									$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
									$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
									$rs[$indx]['fields']=$DataFields;
									$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where opm_define_operations_summary_id=".$opm_define_operations_summary_id;
									
									

									$form_structure=$this->FrmRptModel->create_form($rs,$id);
											$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);
									array_push($output,$form_structure);
									header('Access-Control-Allow-Origin: *');
									header("Content-Type: application/json");
									echo json_encode($output);	

						}


						if($subtype=='MAIN_GRID')
						{						
						
							$id=33;
							$indx=0;
							$form_id=67;
							$whr=" id=".$form_id;	
							$DataFields=$this->projectmodel->GetSingleVal('GridHeader','frmrpttemplatehdr',$whr);									
							$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);
							$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
							$WhereCondition=$this->projectmodel->GetSingleVal('WhereCondition','frmrpttemplatehdr',$whr);	
																
							$rs[$indx]['section_type']='GRID_ENTRY';	
							$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
							$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
							$rs[$indx]['fields']=$DataFields;
							$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where ".$WhereCondition;		
							$resval=$this->FrmRptModel->create_report($rs,$id); 
			


						}

						if($subtype=='SAVE_DATA')
						{
								
									//VALIDATION PORTION
																
									$data_for_validation = json_decode($form_data1->raw_data, true);								
									//$VALID_STATUS=$this->FrmRptModel->validation_data($data_for_validation);
									$VALID_STATUS='VALID';
									//VALIDATION PORTION
								
									if($VALID_STATUS=='VALID')
									{

											$form_data=json_decode($form_data1->raw_data);
											$save_details2['test_data']=$form_data1->raw_data;
											$save_details2['test_data']=json_decode(json_encode($form_data1->raw_data), 
												true );
											$this->projectmodel->save_records_model(1,'test_table',$save_details2);

											$headers=json_decode(json_encode($form_data[0]->header), true );
											$header_scount=sizeof($headers);
											$id_header=0;	
											$count=sizeof($form_data[0]->header);		
											$headers=json_decode(json_encode($form_data[0]->header), true );
										//	$save_details=$this->create_save_array($headers);
											$save_details=$this->FrmRptModel->create_save_array($headers);
										

											// echo '<pre>';
											// print_r($save_details);
											// echo '</pre>';

										$header_id=$activity_id=$resource_id='';
										foreach($save_details as $key1=>$tables)
										{
														
											foreach($tables as $key2=>$fields)
											{
													$table_name=$key2;		
													$savedata=array();	
													$save_statue=true;
																		
												foreach($fields as $key3=>$value)
												{
													//HERE REQUIRE CUSTOMIZATION
													if($key3=='id' && $table_name=='opm_define_operations_summary')
													{
														if($value>0)
														{$header_id=$value;}
														else 
														{$header_id='';}  											
													}
													
													else if ($key3<>'id' && $table_name=='opm_define_operations_summary')
													{$savedata[$key3]=$value;}
													
													//for opm_define_operations_activity_details
													else if ($key3=='id' 
														&& $table_name=='opm_define_operations_activity_details')
													{if($value>0){$activity_id=$value;}else {$activity_id='';}   }
													
													else if ($key3=='opm_define_operations_summary_id' && $table_name=='opm_define_operations_activity_details')
													{$savedata[$key3]=$header_id; }
													
													//for opm_define_operations_resource_details

													else if ($key3=='id' 
														&& $table_name=='opm_define_operations_resource_details')
													{if($value>0){$resource_id=$value;}else {$resource_id='';}   }
													
													else if ($key3=='opm_define_operations_summary_id' 
														&& $table_name=='opm_define_operations_resource_details')
													{$savedata[$key3]=$header_id; }

													else if ($key3=='opm_define_operations_activity_details_id' 
														&& $table_name=='opm_define_operations_resource_details')
													{$savedata[$key3]=$activity_id; }

													else 
													{$savedata[$key3]=$value;}

												}
													//echo $table_name.' - '.$header_id.' - '.$id;
													// echo '<br>';
													// echo '<pre>';
													// print_r($savedata);
													// echo '</pre>';

													//HEADER SECTION
													if($table_name=='opm_define_operations_summary')
													{
														$this->projectmodel->save_records_model($header_id,$table_name,$savedata);
														if($key1==0 && $header_id=='')
															{$header_id=$this->db->insert_id();}												
													}

													if($save_statue && $table_name=='opm_define_operations_activity_details')
													{
														$this->projectmodel->save_records_model($activity_id,$table_name,$savedata);
														if($key1==0 && $activity_id=='')
															{$activity_id=$this->db->insert_id();}	
													}

													if($save_statue && $table_name=='opm_define_operations_resource_details')
													{
														$this->projectmodel->save_records_model($resource_id,$table_name,$savedata);
														if($key1==0 && $resource_id=='')
															{$resource_id=$this->db->insert_id();}	
													}


											}	

										}

									
										$sql="update  opm_define_operations_activity_details set activity=''
										where  activity='0'";
										$this->db->query($sql);
									
										$sql="delete from opm_define_operations_activity_details 
										where opm_define_operations_summary_id=".$header_id." and activity=''";
										$this->db->query($sql);


										$return_data['id_header']=$header_id;
					
										header('Access-Control-Allow-Origin: *');
										header("Content-Type: application/json");
										echo json_encode($return_data);

									}

						}	

						if($subtype=='resource_list')
						{

							$indx=0;
							$form_id=69;
							$opm_define_operations_activity_details_id=$form_data1->id;	

							$count=0;
							$records="select count(*) cnt from opm_define_operations_resource_details where 
							opm_define_operations_activity_details_id=".$opm_define_operations_activity_details_id;
							$records = $this->projectmodel->get_records_from_sql($records);	
							foreach ($records as $record)
							{$count=$record->cnt;}	

								$id=$count;

							$whr=" id=".$opm_define_operations_activity_details_id;	
							$opm_define_operations_summary_id=
							$this->projectmodel->GetSingleVal('opm_define_operations_summary_id','opm_define_operations_activity_details',$whr);	


							$whr=" id=".$form_id;	
							$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
							$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
							//$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
							$rs[$indx]['section_type']='GRID_ENTRY';

							$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
							$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
							$rs[$indx]['fields']=$DataFields;
							$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where opm_define_operations_summary_id=".$opm_define_operations_summary_id." and 
							opm_define_operations_activity_details_id=".$opm_define_operations_activity_details_id;
							


							$form_structure=$this->FrmRptModel->create_form($rs,$id);
							$form_structure=$this->FrmRptModel->re_arrange_input_index3($form_structure);
							array_push($output,$form_structure);
							header('Access-Control-Allow-Origin: *');
							header("Content-Type: application/json");
							echo json_encode($output);	

						}


						if($subtype=='resource_save')
						{
								
							//VALIDATION PORTION
														
							$data_for_validation = json_decode($form_data1->raw_data, true);								
							//$VALID_STATUS=$this->FrmRptModel->validation_data($data_for_validation);
							$VALID_STATUS='VALID';
							//VALIDATION PORTION
						
							if($VALID_STATUS=='VALID')
							{

									$form_data=json_decode($form_data1->raw_data);
									$opm_define_operations_activity_details_id=$form_data1->activity_id;

									$whr=" id=".$opm_define_operations_activity_details_id;	
									$opm_define_operations_summary_id=
									$this->projectmodel->GetSingleVal('opm_define_operations_summary_id','opm_define_operations_activity_details',$whr);	



									//$save_details2['test_data']=$form_data1->raw_data;
									//$save_details2['test_data']=json_decode(json_encode($form_data1->raw_data), 
									//	true );
									//$this->projectmodel->save_records_model(1,'test_table',$save_details2);

									$headers=json_decode(json_encode($form_data[0]->header), true );
									$header_scount=sizeof($headers);
									$id_header=0;	
									$count=sizeof($form_data[0]->header);		
									$headers=json_decode(json_encode($form_data[0]->header), true );
								//	$save_details=$this->create_save_array($headers);
									$save_details=$this->FrmRptModel->create_save_array($headers);
								
									// echo '<pre>';
									// print_r($save_details);
									// echo '</pre>';

								$header_id=$resource_id='';
								foreach($save_details as $key1=>$tables)
								{
												
									foreach($tables as $key2=>$fields)
									{
											$table_name=$key2;		
											$savedata=array();	
											$save_statue=true;
																
										foreach($fields as $key3=>$value)
										{
											//HERE REQUIRE CUSTOMIZATION
											if($key3=='id' && $table_name=='opm_define_operations_resource_details')
											{
												if($value>0)
												{$header_id=$value;}
												else 
												{$header_id='';}  											
											}
											
											else if 
											($key3<>'id' && $table_name=='opm_define_operations_resource_details')
											{$savedata[$key3]=$value;}

											else 
											{$savedata[$key3]=$value;}

										}
											
											$savedata['opm_define_operations_activity_details_id']=
											$opm_define_operations_activity_details_id;

											$savedata['opm_define_operations_summary_id']=
											$opm_define_operations_summary_id;


											//HEADER SECTION
											if($table_name=='opm_define_operations_resource_details')
											{
												$this->projectmodel->save_records_model($header_id,$table_name,$savedata);
												if($key1==0 && $header_id=='')
												{$header_id=$this->db->insert_id();}												
											}

											$this->projectmodel->update_transactions($header_id,$form_name);


									}	

								}
										
								$sql="delete from opm_define_operations_resource_details 	where  resource=0";
								$this->db->query($sql);


									$return_data['id_header']=$header_id;
				
									header('Access-Control-Allow-Origin: *');
									header("Content-Type: application/json");
									echo json_encode($return_data);

							}

						}	
					
					
					}

					//opm_routing
					if($form_name=='opm_routing')
					{
							
							if($subtype=='view_list')
							{

								$indx=0;
								$form_id=70;
								$id=$form_data1->id;	
								$whr=" id=".$form_id;	
								$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
								$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
								$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
								$rs[$indx]['section_type']=$section_type;	
								$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
								$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
								$rs[$indx]['fields']=$DataFields;
								$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;



								$indx=1;
								$form_id=71;
								$opm_define_routing_summery_id=$form_data1->id;				    
								$whr=" id=".$form_id;	
								$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
								$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
								$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
								$rs[$indx]['section_type']='GRID_ENTRY';		
								$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
								$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
								$rs[$indx]['fields']=$DataFields;
								$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where opm_define_routing_summery_id=".$opm_define_routing_summery_id;

								

								$form_structure=$this->FrmRptModel->create_form($rs,$id);
										$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);
								array_push($output,$form_structure);
								header('Access-Control-Allow-Origin: *');
								header("Content-Type: application/json");
								echo json_encode($output);	

							}

							if($subtype=='SAVE_DATA')
							{
									
								//VALIDATION PORTION
															
								$data_for_validation = json_decode($form_data1->raw_data, true);								
								//$VALID_STATUS=$this->FrmRptModel->validation_data($data_for_validation);
								$VALID_STATUS='VALID';
								//VALIDATION PORTION
							
								if($VALID_STATUS=='VALID')
								{

										$form_data=json_decode($form_data1->raw_data);
										//$save_details2['test_data']=$form_data1->raw_data;
										//$save_details2['test_data']=json_decode(json_encode($form_data1->raw_data), 
										//	true );
										//$this->projectmodel->save_records_model(1,'test_table',$save_details2);

										$headers=json_decode(json_encode($form_data[0]->header), true );
										$header_scount=sizeof($headers);
										$id_header=0;	
										$count=sizeof($form_data[0]->header);		
										$headers=json_decode(json_encode($form_data[0]->header), true );
										//	$save_details=$this->create_save_array($headers);
										$save_details=$this->FrmRptModel->create_save_array($headers);
									

										// echo '<pre>';
										// print_r($save_details);
										// echo '</pre>';

										$header_id=$id='';
										foreach($save_details as $key1=>$tables)
										{
											
											foreach($tables as $key2=>$fields)
										{
											$table_name=$key2;		
											$savedata=array();	
											$save_statue=true;
																
											foreach($fields as $key3=>$value)
											{
												//HERE REQUIRE CUSTOMIZATION
												if($key3=='id' && $table_name=='opm_define_routing_summery')
												{
													if($value>0)
													{$header_id=$value;}
													else 
													{$header_id='';}  											
												}
												else if ($key3<>'id' && $table_name=='opm_define_routing_summery')
												{$savedata[$key3]=$value;}

												else if ($key3=='id' && $table_name=='opm_define_routing_details')
												{if($value>0){$id=$value;}else {$id='';}   }
												
												else if ($key3=='opm_define_routing_summery_id' 
													&& $table_name=='opm_define_routing_details')
													{$savedata[$key3]=$header_id; }

												else 
												{$savedata[$key3]=$value; }

											}

													//echo $table_name.' - '.$header_id.' - '.$id;
													// echo '<br>';
													// echo '<pre>';
													// print_r($savedata);
													// echo '</pre>';

													//HEADER SECTION
													if($table_name=='opm_define_routing_summery')
													{
														$this->projectmodel->save_records_model($header_id,$table_name,$savedata);
														if($key1==0 && $header_id==''){$header_id=$this->db->insert_id();}												
													}

													if($save_statue && $table_name=='opm_define_routing_details')
													{
														$this->projectmodel->save_records_model($id,$table_name,$savedata);
													}
											}	

										}
										
										$return_data['id_header']=$header_id;
					
										header('Access-Control-Allow-Origin: *');
										header("Content-Type: application/json");
										echo json_encode($return_data);

								}

							}	


							if($subtype=='MAIN_GRID')
							{						
							
								$id=33;
								$indx=0;
								$form_id=70;
								$whr=" id=".$form_id;	
								$DataFields=$this->projectmodel->GetSingleVal('GridHeader','frmrpttemplatehdr',$whr);									
								$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);
								$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
								$WhereCondition=$this->projectmodel->GetSingleVal('WhereCondition','frmrpttemplatehdr',$whr);	
																	
								$rs[$indx]['section_type']='GRID_ENTRY';	
								$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
								$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
								$rs[$indx]['fields']=$DataFields;
								$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where ".$WhereCondition;		
								$resval=$this->FrmRptModel->create_report($rs,$id); 
							}


					
					}


						//opm_formula			
						if($form_name=='opm_formula')
						{
								
									if($subtype=='view_list')
									{
	
												$indx=0;
												$form_id=73;
												$id=$form_data1->id;	
												$whr=" id=".$form_id;	
												$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
												$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
												$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
												$rs[$indx]['section_type']=$section_type;	
												$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
												$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
												$rs[$indx]['fields']=$DataFields;
												$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;
	
	
	
												$indx=1;
												$form_id=74;
												$opm_define_formula_summery_id=$form_data1->id;				    
												$whr=" id=".$form_id;	
												$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
												$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
												$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
												$rs[$indx]['section_type']='GRID_ENTRY';		
												$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
												$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
												$rs[$indx]['fields']=$DataFields;
												$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where opm_define_formula_summery_id=".$opm_define_formula_summery_id;
	
	
	
												$form_structure=$this->FrmRptModel->create_form($rs,$id);
													$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);
												array_push($output,$form_structure);
												header('Access-Control-Allow-Origin: *');
												header("Content-Type: application/json");
												echo json_encode($output);	
	
									}
	
									if($subtype=='SAVE_DATA')
									{
											
										//VALIDATION PORTION
																	
													$data_for_validation = json_decode($form_data1->raw_data, true);								
													//$VALID_STATUS=$this->FrmRptModel->validation_data($data_for_validation);
													$VALID_STATUS='VALID';
													//VALIDATION PORTION
												
													if($VALID_STATUS=='VALID')
													{
				
																	$form_data=json_decode($form_data1->raw_data);
																	//$save_details2['test_data']=$form_data1->raw_data;
																	//$save_details2['test_data']=json_decode(json_encode($form_data1->raw_data), 
																	//	true );
																	//$this->projectmodel->save_records_model(1,'test_table',$save_details2);
				
																	$headers=json_decode(json_encode($form_data[0]->header), true );
																	$header_scount=sizeof($headers);
																	$id_header=0;	
																	$count=sizeof($form_data[0]->header);		
																	$headers=json_decode(json_encode($form_data[0]->header), true );
																	//	$save_details=$this->create_save_array($headers);
																	$save_details=$this->FrmRptModel->create_save_array($headers);
																
				
																	// echo '<pre>';
																	// print_r($save_details);
																	// echo '</pre>';
				
																		$header_id=$id='';
																		foreach($save_details as $key1=>$tables)
																		{
																			
																					foreach($tables as $key2=>$fields)
																					{
																						$table_name=$key2;		
																						$savedata=array();	
																						$save_statue=true;
																									
																						foreach($fields as $key3=>$value)
																						{
																							//HERE REQUIRE CUSTOMIZATION
																							if($key3=='id' && $table_name=='opm_define_formula_summery')
																							{
																								if($value>0)
																								{$header_id=$value;}
																								else 
																								{$header_id='';}  											
																							}
																							else if ($key3<>'id' && $table_name=='opm_define_formula_summery')
																							{$savedata[$key3]=$value;}

																							else if ($key3=='id' && $table_name=='opm_define_formula_details')
																							{if($value>0){$id=$value;}else {$id='';}   }
																							
																							else if ($key3=='opm_define_formula_summery_id' 
																								&& $table_name=='opm_define_formula_details')
																								{$savedata[$key3]=$header_id; }

																							else 
																							{$savedata[$key3]=$value; }

																						}

																								//echo $table_name.' - '.$header_id.' - '.$id;
																								// echo '<br>';
																								// echo '<pre>';
																								// print_r($savedata);
																								// echo '</pre>';

																								//HEADER SECTION
																								if($table_name=='opm_define_formula_summery')
																								{
																									$this->projectmodel->save_records_model($header_id,$table_name,$savedata);
																									if($key1==0 && $header_id==''){$header_id=$this->db->insert_id();}												
																								}

																								if($save_statue && $table_name=='opm_define_formula_details')
																								{
																									$this->projectmodel->save_records_model($id,$table_name,$savedata);
																								}
																					}	
				
																		}

																		// $sql="update  opm_define_formula_details set activity=''
																		// where  activity='0'";
																		// $this->db->query($sql);
																	
																		$sql="delete from opm_define_formula_details 
																		where opm_define_formula_summery_id=".$header_id." and product=0";
																		$this->db->query($sql);
								
																		
																		$return_data['id_header']=$header_id;

													
																		header('Access-Control-Allow-Origin: *');
																		header("Content-Type: application/json");
																		echo json_encode($return_data);
				
														}
	
									}	
											
									
								if($subtype=='MAIN_GRID')
								{						
								
									$id=33;
									$indx=0;
									$form_id=73;
									$whr=" id=".$form_id;	
									$DataFields=$this->projectmodel->GetSingleVal('GridHeader','frmrpttemplatehdr',$whr);									
									$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);
									$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
									$WhereCondition=$this->projectmodel->GetSingleVal('WhereCondition','frmrpttemplatehdr',$whr);	
																		
									$rs[$indx]['section_type']='GRID_ENTRY';	
									$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
									$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
									$rs[$indx]['fields']=$DataFields;
									$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where ".$WhereCondition;		
									$resval=$this->FrmRptModel->create_report($rs,$id); 
								}
						
						}

					//opm_receipe
					if($form_name=='opm_receipe')
					{
							
							if($subtype=='view_list')
							{

									$indx=0;
										$form_id=72;
										$id=$form_data1->id;	
										$whr=" id=".$form_id;	
									$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
									$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
									$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
									$rs[$indx]['section_type']=$section_type;	
									$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
									$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
									$rs[$indx]['fields']=$DataFields;
									$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;


									$form_structure=$this->FrmRptModel->create_form($rs,$id);
											$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);
									array_push($output,$form_structure);
									header('Access-Control-Allow-Origin: *');
									header("Content-Type: application/json");
									echo json_encode($output);	

							}

							if($subtype=='SAVE_DATA')
							{
									
								//VALIDATION PORTION
															
								$data_for_validation = json_decode($form_data1->raw_data, true);								
								//$VALID_STATUS=$this->FrmRptModel->validation_data($data_for_validation);
								$VALID_STATUS='VALID';
								//VALIDATION PORTION
							
								if($VALID_STATUS=='VALID')
								{

										$form_data=json_decode($form_data1->raw_data);
										//$save_details2['test_data']=$form_data1->raw_data;
										//$save_details2['test_data']=json_decode(json_encode($form_data1->raw_data), 
										//	true );
										//$this->projectmodel->save_records_model(1,'test_table',$save_details2);

										$headers=json_decode(json_encode($form_data[0]->header), true );
										$header_scount=sizeof($headers);
										$id_header=0;	
										$count=sizeof($form_data[0]->header);		
										$headers=json_decode(json_encode($form_data[0]->header), true );
										//	$save_details=$this->create_save_array($headers);
										$save_details=$this->FrmRptModel->create_save_array($headers);
									

										// echo '<pre>';
										// print_r($save_details);
										// echo '</pre>';

										$header_id=$id='';
										foreach($save_details as $key1=>$tables)
										{
											
											foreach($tables as $key2=>$fields)
										{
											$table_name=$key2;		
											$savedata=array();	
											$save_statue=true;
																
											foreach($fields as $key3=>$value)
											{
												//HERE REQUIRE CUSTOMIZATION
												if($key3=='id' && $table_name=='opm_define_recipe_summery')
												{
													if($value>0)
													{$header_id=$value;}
													else 
													{$header_id='';}  											
												}
												else if ($key3<>'id' && $table_name=='opm_define_recipe_summery')
												{$savedata[$key3]=$value;}


											}

													//echo $table_name.' - '.$header_id.' - '.$id;
													// echo '<br>';
													// echo '<pre>';
													// print_r($savedata);
													// echo '</pre>';

													//HEADER SECTION
													if($table_name=='opm_define_recipe_summery')
													{
														$this->projectmodel->save_records_model($header_id,$table_name,$savedata);
														if($key1==0 && $header_id==''){$header_id=$this->db->insert_id();}												
													}

											}	

										}
										
										$return_data['id_header']=$header_id;
					
										header('Access-Control-Allow-Origin: *');
										header("Content-Type: application/json");
										echo json_encode($return_data);

								}

							}	

							if($subtype=='MAIN_GRID')
							{						
							
								$id=33;
								$indx=0;
								$form_id=72;
								$whr=" id=".$form_id;	
								$DataFields=$this->projectmodel->GetSingleVal('GridHeader','frmrpttemplatehdr',$whr);									
								$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);
								$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
								$WhereCondition=$this->projectmodel->GetSingleVal('WhereCondition','frmrpttemplatehdr',$whr);	
																	
								$rs[$indx]['section_type']='GRID_ENTRY';	
								$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
								$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
								$rs[$indx]['fields']=$DataFields;
								$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where ".$WhereCondition;		
								$resval=$this->FrmRptModel->create_report($rs,$id); 
							}


					
					}

			 	

					if($form_name=='batch_create_final')
					{
										
							if($subtype=='view_list')
							{			
								
									$id=mysql_real_escape_string($form_data1->id);
									$form_structure=$this->form_view($form_name,$id);
									array_push($output,$form_structure);
									header('Access-Control-Allow-Origin: *');
									header("Content-Type: application/json");
									echo json_encode($output);						
		
							}
		
							//save section
							if($subtype=='SAVE_DATA')
							{
								
								$return_data=$setting=$rs=$resval=$output=array();
								$form_data=json_decode($form_data1->raw_data);
								$headers=json_decode(json_encode($form_data[0]->header), true );
								$header_scount=sizeof($headers);
								$id_header=0;	
								$count=sizeof($form_data[0]->header);		
								$headers=json_decode(json_encode($form_data[0]->header), true );
								$save_details=$this->FrmRptModel->create_save_array($headers);
								
								// $data_for_validation = json_decode($form_structure, true);								
								// //$VALID_STATUS=$this->FrmRptModel->validation_data($data_for_validation);
								// $VALID_STATUS='VALID';
								
								// if($VALID_STATUS=='VALID')
								// {

								// 	$form_data=json_decode($form_structure);
								// 	$headers=json_decode(json_encode($form_data[0]->header), true );
								// 	$header_scount=sizeof($headers);
								// 	$id_header=0;	
								// 	$count=sizeof($form_data[0]->header);		
								// 	$headers=json_decode(json_encode($form_data[0]->header), true );
								// 	$save_details=$this->FrmRptModel->create_save_array($headers);
								// 	$header_id=$id='';
								// }
								

								foreach($save_details as $key1=>$tables)
								{
									
									foreach($tables as $key2=>$fields)
									{
										$table_name=$key2;		
										$savedata=array();	
										$save_statue=true;
															
										foreach($fields as $key3=>$value)
										{
											//HERE REQUIRE CUSTOMIZATION
											if($key3=='id' && $table_name=='opm_batch_summary')
											{
												if($value>0)
												{$header_id=$value;}
												else 
												{$header_id='';}  											
											}
											else if ($key3<>'id' && $table_name=='opm_batch_summary')
											{$savedata[$key3]=$value;}
											else if ($key3=='id' && $table_name=='opm_batch_details')
											{if($value>0){$id=$value;}else {$id='';}   }
											else if ($key3=='opm_batch_summary_id' && $table_name=='opm_batch_details')
											{$savedata[$key3]=$header_id; }
											else 
											{
													$savedata[$key3]=$value; 											
													//if($savedata['product_id']==0){$save_statue=false;}
											
											}

										}

										//HEADER SECTION
										if($table_name=='opm_batch_summary')
										{
											$this->projectmodel->save_records_model($header_id,$table_name,$savedata);
											if($key1==0 && $header_id==''){$header_id=$this->db->insert_id();}	
										}

										if($save_statue && $table_name=='opm_batch_details')
										{$this->projectmodel->save_records_model($id,$table_name,$savedata);}

									}	

								}
								


								$return_data['id_header']=$header_id;

								header('Access-Control-Allow-Origin: *');
								header("Content-Type: application/json");
								echo json_encode($return_data);
								
							
								
							}	
		
							if($subtype=='MAIN_GRID')
							{
							
								$id=33;
								$indx=0;
								$form_id=91;
								$whr=" id=".$form_id;	
								$DataFields=$this->projectmodel->GetSingleVal('GridHeader','frmrpttemplatehdr',$whr);									
								$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);
								$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
								$WhereCondition=$this->projectmodel->GetSingleVal('WhereCondition','frmrpttemplatehdr',$whr);	
																	
								$rs[$indx]['section_type']='GRID_ENTRY';	
								$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
								$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
								$rs[$indx]['fields']=$DataFields;
								$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where ".$WhereCondition;		
								$resval=$this->FrmRptModel->create_report($rs,$id); 
		
							}
		
							if($subtype=='other_search')
							{			
														
								$output= $someArray=array();
		
								 $header_index=mysql_real_escape_string($form_data1->header_index);
								 $field_index=mysql_real_escape_string($form_data1->field_index);
								 $searchelement=mysql_real_escape_string($form_data1->searchelement);
								 $someArray = json_decode($form_data1->raw_data, true);
								 
		
							}
		
					}
			 
			 		//OPM SECTION



	}


	public function form_view($form_name,$id)
	{
	
		$return_data=	$setting=	$rs=$resval=$form_structure=$output=array();		
		$setting=$this->projectmodel->user_wise_setting(); 

		if($form_name=='requisition')
		{
							
				$indx=0;
			  	$form_id=79;
				$whr=" id=".$form_id;	
				$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
				$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
				$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
				$rs[$indx]['section_type']=$section_type;	
				$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
				$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
				$rs[$indx]['fields']=$DataFields;
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;


				$indx=1;
			  	$form_id=80;
			    $invoice_summary_id=$id;
				$whr=" id=".$form_id;	
				$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);
				$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
				$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
				$rs[$indx]['section_type']='GRID_ENTRY';		
				$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
				$rs[$indx]['id']=0;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
				$rs[$indx]['fields']=$DataFields.$setting['segments'];
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where invoice_summary_id=".$invoice_summary_id;


				$indx=2;
			  	$form_id=79;
				$whr=" id=".$form_id;	
				$DataFields=$this->projectmodel->GetSingleVal('DataFields2','frmrpttemplatehdr',$whr);	
				$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
				$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
				$rs[$indx]['section_type']=$section_type;	
				$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
				$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
				$rs[$indx]['fields']=$DataFields;
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;

				$form_structure=$this->FrmRptModel->create_form($rs,$id);
				$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);
				$form_structure=$this->projectmodel->other_setting($form_structure,$form_name);
				
				return $form_structure;

		}


		if($form_name=='po_entry')
		{


				$indx=0;
			  $form_id=82;
				$whr=" id=".$form_id;	
				$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
				$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
				$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
				$rs[$indx]['section_type']=$section_type;	
				$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
				$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
				$rs[$indx]['fields']=$DataFields;
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;


				$indx=1;
			  $form_id=48;
			  $invoice_summary_id=$id;
				$whr=" id=".$form_id;	
				$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);
				$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
				$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
				$rs[$indx]['section_type']='GRID_ENTRY';		
				$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
				$rs[$indx]['id']=0;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
				$rs[$indx]['fields']='id,invoice_summary_id,item_id,qnty,uom,price,billing_address,shipping_address'
				.$setting['segments'];
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where invoice_summary_id=".$invoice_summary_id;



				$indx=2;
			  $form_id=82;
				$whr=" id=".$form_id;	
				$DataFields=$this->projectmodel->GetSingleVal('DataFields2','frmrpttemplatehdr',$whr);	
				$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
				$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
				$rs[$indx]['section_type']=$section_type;	
				$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
				$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
				$rs[$indx]['fields']=$DataFields;
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;

				$form_structure=$this->FrmRptModel->create_form($rs,$id);
				$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);
				$form_structure=$this->projectmodel->other_setting($form_structure,$form_name);
				
				return $form_structure;

		}

		if($form_name=='receipt_of_goods')
		{	

				$indx=0;
			  $form_id=84;
				$whr=" id=".$form_id;	
				$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
				$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
				$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
				$rs[$indx]['section_type']=$section_type;	
				$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
				$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
				$rs[$indx]['fields']=$DataFields;
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;


				$indx=1;
				$rs[$indx]['section_type']='GRID_ENTRY';		
				$rs[$indx]['frmrpttemplatehdr_id']=48;
				$rs[$indx]['id']=0;	$rs[$indx]['parent_id']=$id;$rs[$indx]['TableName']='invoice_details';		
				$rs[$indx]['fields']='id,invoice_summary_id,parent_id,item_id,qnty,received_qnty,uom,batch_no';	
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where  invoice_summary_id=".$id;		

				$form_structure=$this->FrmRptModel->create_form($rs,$id);
				$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);
				$form_structure=$this->projectmodel->other_setting($form_structure,$form_name);
				
				return $form_structure;

		}

		if($form_name=='INSPECTION')
		{

			$indx=0;
		  	$form_id=86;
			$whr=" id=".$form_id;	
			$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
			$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
			$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
			$rs[$indx]['section_type']=$section_type;	
			$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
			$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
			$rs[$indx]['fields']=$DataFields;
			$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;


			$indx=1;
			$rs[$indx]['section_type']='GRID_ENTRY';		
			$rs[$indx]['frmrpttemplatehdr_id']=48;
			$rs[$indx]['id']=0;	$rs[$indx]['parent_id']=$id;$rs[$indx]['TableName']='invoice_details';		
			$rs[$indx]['fields']='id,invoice_summary_id,parent_id,item_id,qnty,received_qnty,uom,grn_status';	
			$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where  invoice_summary_id=".$id;		



			$form_structure=$this->FrmRptModel->create_form($rs,$id);
			$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);
			$form_structure=$this->projectmodel->other_setting($form_structure,$form_name);
			
			return $form_structure;

		}	
			

		if($form_name=='purchase_invoice')
		{

				$indx=0;
				$form_id=87;
				$whr=" id=".$form_id;	
				$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
				$DataFields2=$this->projectmodel->GetSingleVal('DataFields2','frmrpttemplatehdr',$whr);	
				$DataFields3=$this->projectmodel->GetSingleVal('DataFields3','frmrpttemplatehdr',$whr);	
				$DataFields4=$this->projectmodel->GetSingleVal('DataFields4','frmrpttemplatehdr',$whr);	
				$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
				$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
				$rs[$indx]['section_type']=$section_type;	
				$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
				$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
				$rs[$indx]['fields']=$DataFields;
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;


				//BODY OR GRID ENTRY SECTION	
				$indx=1;				
				$rs[$indx]['section_type']='GRID_ENTRY';		
				$rs[$indx]['frmrpttemplatehdr_id']=93;
				$rs[$indx]['TableName']='invoice_details';								
				$rs[$indx]['fields']='id,invoice_summary_id,item_id,qnty,uom,price,total_amount,Gl_date'.$setting['segments'].',asset_book,tax_ledger_id,tax_rate,tax_amount';
				$rs[$indx]['id']=0;	$rs[$indx]['parent_id']=$id;
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where  invoice_summary_id=".$id;								
			
				$indx=2;
				$rs[$indx]['section_type']=$section_type;	
				$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
				$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
				$rs[$indx]['fields']=$DataFields2;
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;

				$indx=3;		
				$rs[$indx]['section_type']=$section_type;	
				$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
				$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
				$rs[$indx]['fields']=$DataFields3;
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;

									
				$form_structure=$this->FrmRptModel->create_form($rs,$id);
				$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);
				$form_structure=$this->projectmodel->other_setting($form_structure,$form_name);


					//FORM CUSTOM SETTING END
					return $form_structure;

		}	

		if($form_name=='payment_rcv')
		{
				//HEADER SECTION
				$form_id=55;
				$whr=" id=".$form_id;	
				$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
				$DataFields2=$this->projectmodel->GetSingleVal('DataFields2','frmrpttemplatehdr',$whr);
				$DataFields3=$this->projectmodel->GetSingleVal('DataFields3','frmrpttemplatehdr',$whr);
				$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);
				$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
				
				$indx=0;
				$rs[$indx]['section_type']=$section_type;	
				$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
				$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
				$rs[$indx]['fields']=$DataFields;
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where  id=".$id;
			
										
				//SUPPLIER SECTION
				$indx=1;
				$rs[$indx]['section_type']=$section_type;	
				$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
				$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
				$rs[$indx]['fields']=$DataFields2;
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where  id=".$id;

			
				$indx=2;
				$rs[$indx]['section_type']=$section_type;	
				$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
				$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
				$rs[$indx]['fields']=$DataFields3;
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where  id=".$id;


				$indx=3;
				$form_id=56;
				$whr=" id=".$form_id;	
				$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
				$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
				$rs[$indx]['section_type']='GRID_ENTRY';	
				$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
				$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
				$rs[$indx]['fields']=$DataFields;
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where  invoice_payment_id=".$id;


							
				$form_structure=$this->FrmRptModel->create_form($rs,$id);
				$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);


				//-------------------
				// $supplier_id=$form_structure['header'][$header_index]['fields'][$field_index]['req_supplier']['Inputvalue_id'];
				// $req_operating_unit=$form_structure['header'][0]['fields'][0]['req_operating_unit']['Inputvalue_id'];

				// $whr=" id=".$supplier_id;							
				// $form_structur['header'][$header_index]['fields'][$field_index]['req_contact']['Inputvalue']=$this->projectmodel->GetSingleVal('contact_person','mstr_supplier',$whr);
				// $form_structure['header'][$header_index]['fields'][$field_index]['req_phone']['Inputvalue']=$this->projectmodel->GetSingleVal('phone_no','mstr_supplier',$whr);		
					
				// $details="select count(*) count from  invoice_summary  where invoice_payment_id=0 and 
				// req_supplier=".$supplier_id." and req_operating_unit=".$req_operating_unit." and status='PURCHASE_INVOICE'";					
				// $details = $this->projectmodel->get_records_from_sql($details);	
				// if($details[0]->count>0)
				// {

				// 	$id=17;
				// 	$indx=3;
				// 	$rs[$indx]['section_type']='GRID_ENTRY';		
				// 	$rs[$indx]['frmrpttemplatehdr_id']=56;
				// 	$rs[$indx]['id']=0;	$rs[$indx]['parent_id']=$id;$rs[$indx]['TableName']='invoice_summary';								
				// 	$rs[$indx]['fields']='id,parent_id,req_number,req_accounting_date,invoice_subtotal,invoice_paid_total,Gl_date,req_submit_approval,invoice_payment_id';
				// 	$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." 
				// 	where invoice_payment_id=0 and  req_supplier=".$supplier_id." 
				// 	and req_operating_unit=".$req_operating_unit." and status='PURCHASE_INVOICE'	 ";				
							
				// 	$form_structure=$this->FrmRptModel->create_form($rs,$id);								
				// 	//$someArray[0]['header'][3]=$form_structure['header'][3];
				// //	$form_structure=$this->FrmRptModel->re_arrange_input_index_type2($form_structure);

				// }

				//-------------------

				return $form_structure;

		}	


		//ORDER TO CASH
		if($form_name=='SALES_ORDER')
		{

			$indx=0;
			$form_id=57;
			$whr=" id=".$form_id;	
			$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
			$DataFields2=$this->projectmodel->GetSingleVal('DataFields2','frmrpttemplatehdr',$whr);	
			$DataFields3=$this->projectmodel->GetSingleVal('DataFields3','frmrpttemplatehdr',$whr);	
			$DataFields4=$this->projectmodel->GetSingleVal('DataFields4','frmrpttemplatehdr',$whr);	
			$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
			$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
			$rs[$indx]['section_type']=$section_type;	
			$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
			$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
			$rs[$indx]['fields']=$DataFields;
			$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;


			//BODY OR GRID ENTRY SECTION	
			$indx=1;				
			$rs[$indx]['section_type']='GRID_ENTRY';		
			$rs[$indx]['frmrpttemplatehdr_id']=58;
			$rs[$indx]['id']=0;	$rs[1]['parent_id']=$id;$rs[$indx]['TableName']='invoice_details';		
			$rs[$indx]['fields']='id,invoice_summary_id,item_id,qnty,uom,price,billing_address,shipping_address'.$setting['segments'];								
			$rs[$indx]['sql_query']="select ".$rs[1]['fields']." from ".$rs[1]['TableName']." where  invoice_summary_id=".$id;	


			$indx=2;
			$rs[$indx]['section_type']=$section_type;	
			$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
			$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
			$rs[$indx]['fields']=$DataFields2;
			$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;
			
										
				$form_structure=$this->FrmRptModel->create_form($rs,$id);
				$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);
				$form_structure=$this->projectmodel->other_setting($form_structure,$form_name);

				return $form_structure;

		}

		if($form_name=='DESPATCH_GOODS')
		{

					$indx=0;
					$form_id=59;
					$whr=" id=".$form_id;	
					$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
					//$DataFields2=$this->projectmodel->GetSingleVal('DataFields2','frmrpttemplatehdr',$whr);	
					//$DataFields3=$this->projectmodel->GetSingleVal('DataFields3','frmrpttemplatehdr',$whr);	
					//$DataFields4=$this->projectmodel->GetSingleVal('DataFields4','frmrpttemplatehdr',$whr);	
					$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
					$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
					$rs[$indx]['section_type']=$section_type;	
					$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
					$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
					$rs[$indx]['fields']=$DataFields;
					$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;


					//BODY OR GRID ENTRY SECTION	

					$indx=1;				
					$form_id=60;
					$whr=" id=".$form_id;	
					$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);							
					$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
					//$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
					$rs[$indx]['section_type']='GRID_ENTRY';		
					$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
					$rs[$indx]['id']=0;	$rs[1]['parent_id']=$id;$rs[$indx]['TableName']=$TableName;		
					$rs[$indx]['fields']=$DataFields.$setting['segments'];								
					$rs[$indx]['sql_query']="select ".$rs[1]['fields']." from ".$rs[1]['TableName']." where  invoice_summary_id=".$id;	
		
					
					$form_structure=$this->FrmRptModel->create_form($rs,$id);
					$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);
					$form_structure=$this->projectmodel->other_setting($form_structure,$form_name);

					return $form_structure;

		}	


		if($form_name=='sale_invoice')
		{

				$indx=0;
				$form_id=89;
				$whr=" id=".$form_id;	
				$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
				$DataFields2=$this->projectmodel->GetSingleVal('DataFields2','frmrpttemplatehdr',$whr);	
				$DataFields3=$this->projectmodel->GetSingleVal('DataFields3','frmrpttemplatehdr',$whr);	
				$DataFields4=$this->projectmodel->GetSingleVal('DataFields4','frmrpttemplatehdr',$whr);	
				$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
				$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
				$rs[$indx]['section_type']=$section_type;	
				$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
				$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
				$rs[$indx]['fields']=$DataFields;
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;


				//BODY OR GRID ENTRY SECTION	

				$indx=1;				
				$rs[$indx]['section_type']='GRID_ENTRY';		
				$rs[$indx]['frmrpttemplatehdr_id']=93;
				$rs[$indx]['TableName']='invoice_details';								
				$rs[$indx]['fields']='id,invoice_summary_id,item_id,qnty,uom,price,total_amount,Gl_date'.$setting['segments'].',asset_book,tax_ledger_id,tax_rate,tax_amount';
				$rs[$indx]['id']=0;	$rs[$indx]['parent_id']=$id;
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where  invoice_summary_id=".$id;

				// $indx=1;				
				// $rs[$indx]['section_type']='GRID_ENTRY';		
				// $rs[$indx]['frmrpttemplatehdr_id']=48;
				// $rs[$indx]['TableName']='invoice_details';								
				// $rs[$indx]['fields']='id,invoice_summary_id,item_id,total_amount,Gl_date'.$setting['segments'].',asset_book,tax_ledger_id,tax_rate,tax_amount';
				// $rs[$indx]['id']=0;	$rs[$indx]['parent_id']=$id;
				// $rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where  invoice_summary_id=".$id;								
			
				$indx=2;
				$rs[$indx]['section_type']=$section_type;	
				$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
				$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
				$rs[$indx]['fields']=$DataFields2;
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;

				$indx=3;		
				$rs[$indx]['section_type']=$section_type;	
				$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
				$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
				$rs[$indx]['fields']=$DataFields3;
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;

									
				$form_structure=$this->FrmRptModel->create_form($rs,$id);
				$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);
				$form_structure=$this->projectmodel->other_setting($form_structure,$form_name);

				return $form_structure;

		}	

		if($form_name=='receive_amt')
		{


				$form_id=63;
				$whr=" id=".$form_id;	
				$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
				$DataFields2=$this->projectmodel->GetSingleVal('DataFields2','frmrpttemplatehdr',$whr);
				$DataFields3=$this->projectmodel->GetSingleVal('DataFields3','frmrpttemplatehdr',$whr);
				$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);
				$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
				
				$indx=0;
				$rs[$indx]['section_type']=$section_type;	
				$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
				$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
				$rs[$indx]['fields']=$DataFields;
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where  id=".$id;
			
										
				//SUPPLIER SECTION
				$indx=1;
				$rs[$indx]['section_type']=$section_type;	
				$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
				$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
				$rs[$indx]['fields']=$DataFields2;
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where  id=".$id;

			
				$indx=2;
				$rs[$indx]['section_type']=$section_type;	
				$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
				$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
				$rs[$indx]['fields']=$DataFields3;
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where  id=".$id;
			

				$indx=3;
				$form_id=56;
				$whr=" id=".$form_id;	
				$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
				$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
				$rs[$indx]['section_type']='GRID_ENTRY';	
				$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
				$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
				$rs[$indx]['fields']=$DataFields;
				$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where  invoice_payment_id=".$id;
							
				$form_structure=$this->FrmRptModel->create_form($rs,$id);
				$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);

				return $form_structure;


			
		}


		if($form_name=='batch_create_final')
		{

					$indx=0;
					$form_id=91;
					$whr=" id=".$form_id;	
					$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
					$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
					$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
					$rs[$indx]['section_type']=$section_type;	
					$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
					$rs[$indx]['id']=$id;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
					$rs[$indx]['fields']=$DataFields;
					$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']." where id=".$id;


					$indx=1;
					$form_id=92;
					$opm_batch_summary_id=$id;
					$whr=" id=".$form_id;	

					$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);
					$DataFields2=$this->projectmodel->GetSingleVal('DataFields2','frmrpttemplatehdr',$whr);
					$DataFields3=$this->projectmodel->GetSingleVal('DataFields3','frmrpttemplatehdr',$whr);
					$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
					$section_type=$this->projectmodel->GetSingleVal('Type','frmrpttemplatehdr',$whr);	
					$rs[$indx]['section_type']='GRID_ENTRY';		
					$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
					$rs[$indx]['id']=0;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
					$rs[$indx]['fields']=$DataFields;
					$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']."
					 where product_type=152 and opm_batch_summary_id=".$opm_batch_summary_id;


					 $indx=2;					 
					 $rs[$indx]['section_type']='GRID_ENTRY';		
					 $rs[$indx]['frmrpttemplatehdr_id']=$form_id;
					 $rs[$indx]['id']=0;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
					 $rs[$indx]['fields']=$DataFields2;
					 $rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']."
						where product_type=154 and opm_batch_summary_id=".$opm_batch_summary_id;

						$indx=3;
						$rs[$indx]['section_type']='GRID_ENTRY';		
						$rs[$indx]['frmrpttemplatehdr_id']=$form_id;
						$rs[$indx]['id']=0;	$rs[$indx]['parent_id']='';	$rs[$indx]['TableName']=$TableName;
						$rs[$indx]['fields']=$DataFields3;
						$rs[$indx]['sql_query']="select ".$rs[$indx]['fields']." from ".$rs[$indx]['TableName']."
						 where product_type=153 and opm_batch_summary_id=".$opm_batch_summary_id;
				

					$form_structure=$this->FrmRptModel->create_form($rs,$id);
					$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);
					$form_structure=$this->projectmodel->other_setting($form_structure,$form_name);
					
					return $form_structure;

		}	


	}


	public function master_form()
	{
			

			$return_data=	$setting=	$rs=$resval=$form_structure=$output=array();			
			$form_data1=json_decode(file_get_contents("php://input"));	
			//$form_name=$form_data1->form_name;	//PARAMETERS		
			$form_id=$form_data1->form_id;
			$subtype=$form_data1->subtype;

			$setting=$this->projectmodel->user_wise_setting(); 
			
			if($subtype=='view_list')
			{			
					
					$setting=$this->projectmodel->user_wise_setting(); 
					
					$id=$form_data1->id;	
					$whr=" id=".$form_id;	
					$DataFields=$this->projectmodel->GetSingleVal('DataFields','frmrpttemplatehdr',$whr);	
					$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
					$rs[0]['section_type']='FORM';	
					$rs[0]['frmrpttemplatehdr_id']=$form_id;
					$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']=$TableName;
					$rs[0]['fields']=$DataFields;
					$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." where id=".$id;


					$form_structure=$this->FrmRptModel->create_form($rs,$id);
			  		$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);


			  		//Setting 
			  		if($form_id==37)//OPM ITEM SUMMARY
			  		{

			  		$form_structure["header"][0]['fields'][0]['organization']['Inputvalue_id']=
			  		$setting['req_organization_id'];							
						$form_structure["header"][0]['fields'][0]['organization']['Inputvalue']=
						$setting['req_organization_name'];	


						}
						if($form_id==91)//BATCH SUMMARY
			  		{
							$form_structure["header"][0]['fields'][0]['organisation_id']['Inputvalue_id']=
							$setting['req_organization_id'];							
							$form_structure["header"][0]['fields'][0]['organisation_id']['Inputvalue']=
							$setting['req_organization_name'];	

						}	
						


					array_push($output,$form_structure);
					header('Access-Control-Allow-Origin: *');
					header("Content-Type: application/json");
					echo json_encode($output);	
			}

			if($subtype=='SAVE_DATA')
			{
				
						//VALIDATION PORTION
													
						$data_for_validation = json_decode($form_data1->raw_data, true);								
						//$VALID_STATUS=$this->FrmRptModel->validation_data($data_for_validation);
						$VALID_STATUS='VALID';
						$server_msg='VALID';
						//VALIDATION PORTION
					
						if($VALID_STATUS=='VALID')
						{

							//$form_data=json_decode($form_data1->raw_data);
								
								// $save_details2['test_data']=$form_data1->raw_data;
								// $save_details2['test_data']=json_decode(json_encode($form_data1->raw_data), true );
								// $this->projectmodel->save_records_model(1,'test_table',$save_details2);

										$form_data=json_decode($form_data1->raw_data);
										$headers=json_decode(json_encode($form_data[0]->header), true );
										$header_scount=sizeof($headers);
										$id_header=0;	
										$count=sizeof($form_data[0]->header);		
										$headers=json_decode(json_encode($form_data[0]->header), true );								
										$save_details=$this->FrmRptModel->create_save_array($headers);
									
										$header_id=$id='';
										foreach($save_details as $key1=>$tables)
										{
											
											foreach($tables as $key2=>$fields)
											{
													$table_name=$key2;		
													$savedata=array();	
													$save_statue=true;
																		
													foreach($fields as $key3=>$value)
													{
														//HERE REQUIRE CUSTOMIZATION
														if($key3=='id' )
														{
															if($value>0)
															{$header_id=$value;}
															else 
															{$header_id='';}  											
														}
														else if ($key3<>'id')
														{$savedata[$key3]=$value;}															
													}
		
													//HEADER SECTION
													$this->projectmodel->save_records_model($header_id,$table_name,$savedata);
													if($key1==0 && $header_id==''){$header_id=$this->db->insert_id();$server_msg="Record has been inserted Successfully!";}	
													else if($key1==0 && $header_id>0){$server_msg="Record has been Updated Successfully!";}										
												
											}	
		
										}

										if($form_id==91)
										{	$this->projectmodel->update_transactions($header_id,'BATCH_CREATE'); }	
										
										$return_data['id_header']=$header_id;
										$return_data['server_msg']=$server_msg;


					
										header('Access-Control-Allow-Origin: *');
										header("Content-Type: application/json");
										echo json_encode($return_data);

							}
			}	

			if($subtype=='MAIN_GRID')
			{
			
				$whr=" id=".$form_id;	
				$GridHeader=$this->projectmodel->GetSingleVal('GridHeader','frmrpttemplatehdr',$whr);	
				$TableName=$this->projectmodel->GetSingleVal('TableName','frmrpttemplatehdr',$whr);	
				$WhereCondition=$this->projectmodel->GetSingleVal('WhereCondition','frmrpttemplatehdr',$whr);	
				$id=33;	
				$rs[0]['section_type']='GRID_ENTRY';	
				$rs[0]['frmrpttemplatehdr_id']=$form_id;
				$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']=$TableName;
				$rs[0]['fields']=$GridHeader;
				$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." where ".$WhereCondition;					
				$resval=$this->FrmRptModel->create_report($rs,$id); 

			}


			if($subtype=='other_search')
			{			
										
				 $someArray=array();

				 $header_index=$form_data1->header_index;
				 $field_index=$form_data1->field_index;
				 $searchelement=$form_data1->searchelement;
				 $someArray = json_decode($form_data1->raw_data, true);

				if($form_id==40)
				{							
						$chart_of_ac_id=$someArray[0]['header'][0]['fields'][0]['chart_of_account_id']['Inputvalue_id'] ;

					  $setting=$this->projectmodel->get_ac_segments($chart_of_ac_id); 
						$field_qualifier_name='';
						$cnts=sizeof($setting['segment']);
						for($cnt=0;$cnt<$cnts;$cnt++)
						{
							$field_qualifier_name=$setting['segment'][$cnt]['field_qualifier_name'];
							if($field_qualifier_name=='account_id')
							{

								$someArray[0]['header'][0]['fields'][0]['p2p_grn_dr']['datafields']=
								$setting['segment'][$cnt]['value_set'];

								$someArray[0]['header'][0]['fields'][0]['p2p_grn_cr']['datafields']=
								$setting['segment'][$cnt]['value_set'];

								$someArray[0]['header'][0]['fields'][0]['p2p_service_dr']['datafields']=
								$setting['segment'][$cnt]['value_set'];

								$someArray[0]['header'][0]['fields'][0]['p2p_service_cr']['datafields']=
								$setting['segment'][$cnt]['value_set'];

								$someArray[0]['header'][0]['fields'][0]['p2p_invoice_dr']['datafields']=
								$setting['segment'][$cnt]['value_set'];

								$someArray[0]['header'][0]['fields'][0]['o2c_despatch_dr']['datafields']=
								$setting['segment'][$cnt]['value_set'];

								$someArray[0]['header'][0]['fields'][0]['o2c_despatch_cr']['datafields']=
								$setting['segment'][$cnt]['value_set'];

								$someArray[0]['header'][0]['fields'][0]['o2c_service_dr']['datafields']=
								$setting['segment'][$cnt]['value_set'];

								$someArray[0]['header'][0]['fields'][0]['o2c_service_cr']['datafields']=
								$setting['segment'][$cnt]['value_set'];

								$someArray[0]['header'][0]['fields'][0]['o2c_invoice_cr']['datafields']=
								$setting['segment'][$cnt]['value_set'];
						
								
							}											
						}
						

					
						$this->FrmRptModel->tranfer_data($someArray);


				}


				//Bank,Supplier,Customer
				if($form_id==38 || $form_id==33 || $form_id==35)
				{							
						//$chart_of_ac_id=$someArray[0]['header'][0]['fields'][0]['chart_of_account_id']['Inputvalue_id'] ;
						// $setting=$this->projectmodel->get_ac_segments($chart_of_ac_id); 

						$setting=$this->projectmodel->user_wise_setting();  
						$field_qualifier_name='';
						$cnts=sizeof($setting['segment']);
						for($cnt=0;$cnt<$cnts;$cnt++)
						{
							$field_qualifier_name=$setting['segment'][$cnt]['field_qualifier_name'];
							if($field_qualifier_name=='account_id')
							{
								$someArray[0]['header'][0]['fields'][0]['chart_of_account_ledger_id']['datafields']=
								$setting['segment'][$cnt]['value_set'];
							}											
						}					
						$this->FrmRptModel->tranfer_data($someArray);
				}


			

			}





	}


	public function experimental_report($datatype='')
	{
			$return_data=	$setting=	$rs=$resval=$form_structure=$output=array();			
			$form_data1=json_decode(file_get_contents("php://input"));	
			$form_name=$form_data1->form_name;	//PARAMETERS		
			$subtype=$form_data1->subtype;
			$month_year=$form_data1->id;

			$setting=$this->projectmodel->user_wise_setting(); 

			if($form_name=='po_entry')
			{
								
					if($subtype=='view_list')
					{			
						
							$id=mysql_real_escape_string($form_data1->id);

							//$id=0;//for NEW entry			
							//$id=40;//for old entry
							//$id=51;
							//HEADER SECTION
							$rs[0]['section_type']='FORM';	
							$rs[0]['frmrpttemplatehdr_id']=41;
							$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='invoice_summary';
							$rs[0]['fields']='id,parent_id,req_operating_unit,created_date_time,req_number,req_type,req_supplier,req_site,req_contact,comment,status';
							//,	req_preparer,req_organization,req_location,req_accounting_date,status,last_updated_by,last_updated_date_time,created_by,create_date_time

							//BODY OR GRID ENTRY SECTION					
							$rs[1]['section_type']='GRID_ENTRY';		
							$rs[1]['frmrpttemplatehdr_id']=48;
							$rs[1]['id']=0;	$rs[1]['parent_id']=$id;$rs[1]['TableName']='invoice_details';		
							$rs[1]['fields']='id,invoice_summary_id,item_id,qnty,uom,price,billing_address,shipping_address';
												
							// //FOOTER SECTION
							$rs[2]['section_type']='FORM';	
							$rs[2]['frmrpttemplatehdr_id']=41;
							$rs[2]['id']=$id;	$rs[2]['parent_id']='';$rs[2]['TableName']='invoice_summary';
							$rs[2]['fields']='req_preparer,req_organization,req_location,req_accounting_date,last_updated_by,last_updated_date_time,created_by,create_date_time,req_status';

							$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." where id=".$id;					
							$rs[1]['sql_query']="select ".$rs[1]['fields']." from ".$rs[1]['TableName']." where  invoice_summary_id=".$id;	
							$rs[2]['sql_query']="select ".$rs[2]['fields']." from ".$rs[2]['TableName']." where id=".$id;							
							
							$form_structure=$this->FrmRptModel->create_form($rs,$id);
							$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);

							//FORM CUSTOM SETTING

							$form_structure["header"][0]['fields'][0]['req_type']['Inputvalue']='Standard Purchase Order';
							$form_structure["header"][0]['fields'][0]['req_type']['Inputvalue_id']=93;
							$form_structure["header"][0]['fields'][0]['status']['Inputvalue']='PO_ENTRY';
							$form_structure["header"][2]['fields'][0]['last_updated_by']['Inputvalue_id']=$setting['login_emp_id'];
							$form_structure["header"][2]['fields'][0]['last_updated_date_time']['Inputvalue_id']=date('Y-m-d H:i:s');

							//USER
							if($form_structure["header"][2]['fields'][0]['req_preparer']['Inputvalue_id']=='')
							{				

								$form_structure["header"][2]['fields'][0]['req_preparer']['Inputvalue_id']=$setting['login_emp_id'];							
								$form_structure["header"][2]['fields'][0]['req_preparer']['Inputvalue']=$setting['login_emp_name'];
								// $form_structure["header"][2]['fields'][0]['req_requiester']['Inputvalue_id']=$setting['login_emp_id'];							
								// $form_structure["header"][2]['fields'][0]['req_requiester']['Inputvalue']=$setting['login_emp_name'];			
								$form_structure["header"][2]['fields'][0]['req_organization']['Inputvalue_id']=$setting['req_organization_id'];							
								$form_structure["header"][2]['fields'][0]['req_organization']['Inputvalue']=$setting['req_organization_name'];	
								$form_structure["header"][2]['fields'][0]['req_location']['Inputvalue']=$setting['req_location'];	
								$form_structure["header"][2]['fields'][0]['req_accounting_date']['Inputvalue']=date('Y-m-d');
								$form_structure["header"][2]['fields'][0]['created_by']['Inputvalue_id']=	$setting['login_emp_id'];
								$form_structure["header"][2]['fields'][0]['create_date_time']['Inputvalue_id']=	date('Y-m-d H:i:s');

							}
						
							// if($form_structure["header"][0]['fields'][0]['req_currency_id']['Inputvalue_id']=='')
							// {								
							// 	$form_structure["header"][0]['fields'][0]['req_currency_id']['Inputvalue_id']=$setting['currency_id'];							
							// 	$form_structure["header"][0]['fields'][0]['req_currency_id']['Inputvalue']=$setting['currency_name'];
							// }
											
							$sql="select  id FieldID,req_number FieldVal  from invoice_summary where  status='REQUISITION' AND req_status=91 ";
							$datafields_array =$this->projectmodel->get_records_from_sql($sql);
							$form_structure["header"][0]['fields'][0]['parent_id']['datafields']=json_decode(json_encode($datafields_array), true);		
							$form_structure["header"][0]['fields'][0]['parent_id']['LabelName']='Enter Requisition';	

							//FORM CUSTOM SETTING END



						array_push($output,$form_structure);
						header('Access-Control-Allow-Origin: *');
						header("Content-Type: application/json");
						echo json_encode($output);						

					}

					//save section
					if($subtype=='SAVE_DATA')
					{
						
								$form_data=json_decode($form_data1->raw_data);
								
							//	$save_details2['test_data']=$form_data1->raw_data;
								//$save_details2['test_data']=json_decode(json_encode($form_data1->raw_data), true );
							//	$this->projectmodel->save_records_model(1,'test_table',$save_details2);

								$headers=json_decode(json_encode($form_data[0]->header), true );
								$header_scount=sizeof($headers);
								$id_header=0;	
								$count=sizeof($form_data[0]->header);		
								$headers=json_decode(json_encode($form_data[0]->header), true );
							//	$save_details=$this->create_save_array($headers);
								$save_details=$this->FrmRptModel->create_save_array($headers);
							

								// echo '<pre>';
								// print_r($save_details);
								// echo '</pre>';

								$header_id=$id='';
								foreach($save_details as $key1=>$tables)
								{
									
									foreach($tables as $key2=>$fields)
									{
											$table_name=$key2;		
											$savedata=array();	
											$save_statue=true;
																
											foreach($fields as $key3=>$value)
											{
												//HERE REQUIRE CUSTOMIZATION
												if($key3=='id' && $table_name=='invoice_summary')
												{
													if($value>0)
													{$header_id=$value;}
													else 
													{$header_id='';}  											
												}
												else if ($key3<>'id' && $table_name=='invoice_summary')
												{$savedata[$key3]=$value;}
												else if ($key3=='id' && $table_name=='invoice_details')
												{if($value>0){$id=$value;}else {$id='';}   }
												else if ($key3=='invoice_summary_id' && $table_name=='invoice_details')
												{$savedata[$key3]=$header_id; }
												else 
												{$savedata[$key3]=$value; if($savedata['item_id']==0){$save_statue=false;}}

											}

											 //echo $table_name.' - '.$header_id.' - '.$id;
											// echo '<br>';
											// echo '<pre>';
											// print_r($savedata);
											// echo '</pre>';

											//HEADER SECTION
											if($table_name=='invoice_summary')
											{
												$this->projectmodel->save_records_model($header_id,$table_name,$savedata);
												if($key1==0 && $header_id==''){$header_id=$this->db->insert_id();}												
											}

											if($save_statue && $table_name=='invoice_details')
											{
												$this->projectmodel->save_records_model($id,$table_name,$savedata);
											}
									}	

								}
								
								$return_data['id_header']=$header_id;
			
								header('Access-Control-Allow-Origin: *');
								header("Content-Type: application/json");
								echo json_encode($return_data);


					}	

					if($subtype=='MAIN_GRID')
					{
					
						$id=33;	
						$rs[0]['section_type']='GRID_ENTRY';	
						$rs[0]['frmrpttemplatehdr_id']=41;
						$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='invoice_summary';
						$rs[0]['fields']='id,req_operating_unit,req_number,req_type,req_preparer,req_description,req_status,req_currency_id,req_total';
						$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." where status='PO_ENTRY'";		
						$resval=$this->FrmRptModel->create_report($rs,$id); 

					}

					if($subtype=='other_search')
					{			
												
						$output= $someArray=array();

						 $header_index=mysql_real_escape_string($form_data1->header_index);
						 $field_index=mysql_real_escape_string($form_data1->field_index);
						 $searchelement=mysql_real_escape_string($form_data1->searchelement);
					   $someArray = json_decode($form_data1->raw_data, true);

						// if($searchelement=='item_id')
						// {
						// 	$sql="select  id FieldID,name FieldVal  from tbl_currency_master where id in (1,2) ";
						// 	$datafields_array =$this->projectmodel->get_records_from_sql($sql);
						// 	$someArray[0]["header"][$header_index]['fields'][$field_index]['qnty']['datafields']=json_decode(json_encode($datafields_array), true);
							
						// 	$this->FrmRptModel->tranfer_data($someArray);						
						// }

						if($searchelement=='parent_id')
						{
								//$id=$parent_id=$someArray[0]["header"][$header_index]['fields'][$field_index]['parent_id']['Inputvalue_id'];
								//$whr=" id=".$parent_id;	
								//	$id=$this->projectmodel->GetSingleVal('id','invoice_summary',$whr);

							
									$id=0;
									$parent_id=$someArray[0]["header"][$header_index]['fields'][$field_index]['parent_id']['Inputvalue_id'];
									
									$entry_type='EDIT';
									$whr=" parent_id=".$parent_id;	
									$id=$this->projectmodel->GetSingleVal('id','invoice_summary',$whr); //PO ID

									if($id==0)
									{
										$whr=" id=".$parent_id;	
										$id=$this->projectmodel->GetSingleVal('id','invoice_summary',$whr); //requisition id
										$entry_type='NEW';
									}						
						 

									$rs[0]['section_type']='FORM';	
									$rs[0]['frmrpttemplatehdr_id']=41;
									$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='invoice_summary';
									$rs[0]['fields']='id,parent_id,req_operating_unit,created_date_time,req_number,req_type,req_supplier,req_site,req_contact,comment,status';
									//,	req_preparer,req_organization,req_location,req_accounting_date,status,last_updated_by,last_updated_date_time,created_by,create_date_time
		
									//BODY OR GRID ENTRY SECTION					
									$rs[1]['section_type']='GRID_ENTRY';		
									$rs[1]['frmrpttemplatehdr_id']=48;
									$rs[1]['id']=0;	$rs[1]['parent_id']=$id;$rs[1]['TableName']='invoice_details';		
									$rs[1]['fields']='id,invoice_summary_id,item_id,qnty,uom,price,billing_address,shipping_address';
														
									// //FOOTER SECTION
									$rs[2]['section_type']='FORM';	
									$rs[2]['frmrpttemplatehdr_id']=41;
									$rs[2]['id']=$id;	$rs[2]['parent_id']='';$rs[2]['TableName']='invoice_summary';
									$rs[2]['fields']='req_preparer,req_organization,req_location,req_accounting_date,last_updated_by,last_updated_date_time,created_by,create_date_time,req_status';
		
									$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." where id=".$id;					
									$rs[1]['sql_query']="select ".$rs[1]['fields']." from ".$rs[1]['TableName']." where  invoice_summary_id=".$id;	
									$rs[2]['sql_query']="select ".$rs[2]['fields']." from ".$rs[2]['TableName']." where id=".$id;							
									
									$form_structure=$this->FrmRptModel->create_form($rs,$id);
									$form_structure=$this->FrmRptModel->re_arrange_input_index($form_structure);
 
									$whr=" id=".$parent_id;	
										$req_number=$this->projectmodel->GetSingleVal('req_number','invoice_summary',$whr); //requisition id
									$form_structure["header"][$header_index]['fields'][$field_index]['parent_id']['Inputvalue']=$req_number;
									$form_structure["header"][$header_index]['fields'][$field_index]['parent_id']['Inputvalue_id']=$parent_id;

									if($entry_type=='NEW')
									{
										$form_structure["header"][$header_index]['fields'][$field_index]['id']['Inputvalue']='';
										$form_structure["header"][$header_index]['fields'][$field_index]['id']['Inputvalue_id']=0;
										
										$count_parent=sizeof($form_structure['header'][1]['fields']);		
										for($cnt_parent=0;$cnt_parent<=$count_parent-1;$cnt_parent++)
										{	
											$form_structure["header"][1]['fields'][$cnt_parent]['id']['Inputvalue']='';
											$form_structure["header"][1]['fields'][$cnt_parent]['id']['Inputvalue_id']=0;
										}	

									}

									//FORM CUSTOM SETTING

							$form_structure["header"][0]['fields'][0]['req_type']['Inputvalue']='Standard Purchase Order';
							$form_structure["header"][0]['fields'][0]['req_type']['Inputvalue_id']=93;
							$form_structure["header"][0]['fields'][0]['status']['Inputvalue']='PO_ENTRY';

							$form_structure["header"][2]['fields'][0]['last_updated_by']['Inputvalue_id']=$setting['login_emp_id'];
							$form_structure["header"][2]['fields'][0]['last_updated_date_time']['Inputvalue_id']=date('Y-m-d H:i:s');

							//USER
							if($form_structure["header"][2]['fields'][0]['req_preparer']['Inputvalue_id']=='')
							{				

								$form_structure["header"][2]['fields'][0]['req_preparer']['Inputvalue_id']=$setting['login_emp_id'];							
								$form_structure["header"][2]['fields'][0]['req_preparer']['Inputvalue']=$setting['login_emp_name'];

								// $form_structure["header"][2]['fields'][0]['req_requiester']['Inputvalue_id']=$setting['login_emp_id'];							
								// $form_structure["header"][2]['fields'][0]['req_requiester']['Inputvalue']=$setting['login_emp_name'];			
								
								$form_structure["header"][2]['fields'][0]['req_organization']['Inputvalue_id']=$setting['req_organization_id'];							
								$form_structure["header"][2]['fields'][0]['req_organization']['Inputvalue']=$setting['req_organization_name'];	
								
								$form_structure["header"][2]['fields'][0]['req_location']['Inputvalue']=$setting['req_location'];	
								$form_structure["header"][2]['fields'][0]['req_accounting_date']['Inputvalue']=date('Y-m-d');

								$form_structure["header"][2]['fields'][0]['created_by']['Inputvalue_id']=	$setting['login_emp_id'];
								$form_structure["header"][2]['fields'][0]['create_date_time']['Inputvalue_id']=	date('Y-m-d H:i:s');

							}
						
							// if($form_structure["header"][0]['fields'][0]['req_currency_id']['Inputvalue_id']=='')
							// {								
							// 	$form_structure["header"][0]['fields'][0]['req_currency_id']['Inputvalue_id']=$setting['currency_id'];							
							// 	$form_structure["header"][0]['fields'][0]['req_currency_id']['Inputvalue']=$setting['currency_name'];
							// }
											

							$sql="select  id FieldID,req_number FieldVal  from invoice_summary where  status='REQUISITION' AND req_status=90 ";
							$datafields_array =$this->projectmodel->get_records_from_sql($sql);
							$form_structure["header"][0]['fields'][0]['parent_id']['datafields']=json_decode(json_encode($datafields_array), true);		
							$form_structure["header"][0]['fields'][0]['parent_id']['LabelName']='Enter Requisition';					


							//FORM CUSTOM SETTING END




	
							array_push($output,$form_structure);
							$this->FrmRptModel->tranfer_data($output);

						}

				

					}

			}
		
			//CHART OF ACCOUNT --VALUE SET
			if($form_name=='top_20')
			{
						
					if($subtype=='MAIN_GRID')
					{
						$id=1;	
						$rs[0]['section_type']='GRID_ENTRY';	
						$rs[0]['frmrpttemplatehdr_id']=50;
						$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='item_wise_sale';
						$rs[0]['fields']='id,item_number,product_name,uom,curr_qty,curr_value,prev_qty,prev_val,percentige_change';
						$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']."  ORDER BY curr_value DESC	LIMIT 0 , 20";		
						$resval=$this->FrmRptModel->create_report($rs,$id); 
					}
					if($subtype=='CREATE_CHART')
					{
						$id=1;	
						$rs[0]['section_type']='GRID_ENTRY';	
						$rs[0]['frmrpttemplatehdr_id']=50;
						$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='item_wise_sale';
						$rs[0]['fields']='id,item_number,curr_value,prev_val';
						$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']."  ORDER BY curr_value DESC	LIMIT 0 , 20";		
						$resval=$this->FrmRptModel->create_report($rs,$id); 

					}					

			}

			if($form_name=='bottom_20')
			{
						
					if($subtype=='MAIN_GRID')
					{
						$id=1;	
						$rs[0]['section_type']='GRID_ENTRY';	
						$rs[0]['frmrpttemplatehdr_id']=50;
						$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='item_wise_sale';
						$rs[0]['fields']='id,item_number,product_name,uom,curr_qty,curr_value,prev_qty,prev_val,percentige_change';
						$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']."  ORDER BY curr_value ASC	LIMIT 0 , 20";		
						$resval=$this->FrmRptModel->create_report($rs,$id); 
					}
					if($subtype=='CREATE_CHART')
					{
						$id=1;	
						$rs[0]['section_type']='GRID_ENTRY';	
						$rs[0]['frmrpttemplatehdr_id']=50;
						$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='item_wise_sale';
						$rs[0]['fields']='id,item_number,curr_value,prev_val';
						$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']."  ORDER BY curr_value ASC	LIMIT 0 , 20";		
						$resval=$this->FrmRptModel->create_report($rs,$id); 

					}					

			}

			if($form_name=='category_wise_sale')
			{
			
					if($subtype=='MAIN_GRID')
					{
						$id=1;	
						$rs[0]['section_type']='GRID_ENTRY';	
						$rs[0]['frmrpttemplatehdr_id']=51;
						$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='category_wise_sale';
						$rs[0]['fields']='id,sub_category, sum(current_period_value) current_period_value';
						$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." group by sub_category";		
						$resval=$this->FrmRptModel->create_report($rs,$id); 
					}

					if($subtype=='CREATE_CHART')
					{
												
						$id=1;	
						$rs[0]['section_type']='GRID_ENTRY';	
						$rs[0]['frmrpttemplatehdr_id']=51;
						$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='category_wise_sale';
						$rs[0]['fields']='id,sub_category, sum(current_period_value) current_period_value';
						$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." group by sub_category";		
						$resval=$this->FrmRptModel->create_report($rs,$id); 

					}					

			}
			
		
			if($form_name=='sales_trend')
			{
			
					if($subtype=='MAIN_GRID')
					{
						
							// $details="select * from  sales_trend  ";					
							// $details = $this->projectmodel->get_records_from_sql($details);	
							// foreach ($details as $key2=>$detail)
							// {	
							// 	$invoice_date=substr($detail->invoice_date,0,7);
							// 	$this->db->query("update sales_trend set month_year='".$invoice_date."'  where id=".$detail->id);
							// }

							// $id=1;	
							// $rs[0]['section_type']='GRID_ENTRY';	
							// $rs[0]['frmrpttemplatehdr_id']=52;
							// $rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='sales_trend';
							// $rs[0]['fields']='id,month_year, customer_name,sum(inv_value) inv_value';
							// $rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." group by month_year,customer_name";		
							// $resval=$this->FrmRptModel->create_report($rs,$id); 

							$id=1;	
							$rs[0]['section_type']='GRID_ENTRY';	
							$rs[0]['frmrpttemplatehdr_id']=52;
							$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='sales_trend';
							$rs[0]['fields']='id,month_year,sum(inv_value) inv_value,sum(previous_inv_value) 	previous_inv_value';
							$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." group by month_year";		
							$resval=$this->FrmRptModel->create_report($rs,$id); 


					}

					if($subtype=='CREATE_CHART')
					{
												
							$id=1;	
							$rs[0]['section_type']='GRID_ENTRY';	
							$rs[0]['frmrpttemplatehdr_id']=52;
							$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='sales_trend';
							$rs[0]['fields']='id,month_year,sum(inv_value) inv_value,sum(previous_inv_value) 	previous_inv_value';
							$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." group by month_year";		
							$resval=$this->FrmRptModel->create_report($rs,$id); 

					}					

			}

			if($form_name=='party_wise_sale')
			{
			
					if($subtype=='MAIN_GRID')
					{
						$id=1;	
						$rs[0]['section_type']='GRID_ENTRY';	
						$rs[0]['frmrpttemplatehdr_id']=51;
						$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='category_wise_sale';
						$rs[0]['fields']='id,sub_category, sum(current_period_value) current_period_value';
						$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." group by sub_category";		
						$resval=$this->FrmRptModel->create_report($rs,$id); 
					}

					if($subtype=='CREATE_CHART')
					{				
						
						$id=1;	
						$rs[0]['section_type']='GRID_ENTRY';	
						$rs[0]['frmrpttemplatehdr_id']=52;
						$rs[0]['id']=$id;	$rs[0]['parent_id']='';	$rs[0]['TableName']='sales_trend';
						$rs[0]['fields']='id,customer_name,sum(inv_value) inv_value';
						$rs[0]['sql_query']="select ".$rs[0]['fields']." from ".$rs[0]['TableName']." where month_year='".$month_year."' group by customer_name";		
						$resval=$this->FrmRptModel->create_report($rs,$id); 

					}					

			}

	}

public function Master_upload()
{
	//$this->accounts_model->trn_rcv_expense_table_update('Receive',0);	
	//$this->accounts_model->trn_rcv_expense_update('RECEIVE',13889);
	
	$this->login_validate();
	$data=array();
	//define('SITE_ROOT', dirname(__FILE__));
	//echo $file_path = SITE_ROOT;	
	
		
	$data['DisplayGrid']='NO';
	$data['msgdelete']="";
	if(isset($_POST['Upload']))
	{	
		
	
	if($_FILES['image1']['tmp_name']!='')
	{
			$setname='upload';	
			$uploads_dir='./uploads/';
			$tmp_name = $_FILES["image1"]["tmp_name"];
			$fileextension = substr(strrchr($_FILES["image1"]["name"], '.'), 1);
			$file_name=$setname.'.'.$fileextension;
			move_uploaded_file($tmp_name, "$uploads_dir/$file_name");	
			
				
			$frmrpttemplatehdrID=$this->input->post('SettingName');
			$temp_original=$this->input->post('temp_original');
			//$file_name='DOCTOR_FORMAT_FINALNEW.xls';
			//$file=HEARD_PATH.'uploads/'.$file_name;
			
			$this->excel_reader->read('./uploads/upload.xls');
			// Get the contents of the first worksheet
			$worksheet = $this->excel_reader->sheets[0];
			$highestRow = $worksheet['numRows']; // ex: 14
			$numCols = $worksheet['numCols']; // ex: 4
			$cells = $worksheet['cells']; // the 1st row are usually the field's name

			//DOCTOR_MASTER -SECTION
			if($frmrpttemplatehdrID=='DOCTOR_MASTER')
			{	
				//temporary UPLOAD
				if($temp_original=='TEMPORARY')
				{
					$COLUMNS=11;//GENETICALAB
					//$COLUMNS=12;//UNITED LAB
					
					$this->db->query("delete from import_doctor_master");
					for ($row = 2; $row <= $highestRow; ++$row) 
					{			
						for ($ColNo = 1; $ColNo <= $COLUMNS;  $ColNo++)
						{	
												
							if( isset($cells[$row][$ColNo]) )
							{
								$header_name =$cells[1][$ColNo];								
								$save_hdr[$header_name]=$cells[$row][$ColNo];
							}
							else
							{								
								$header_name =$cells[1][$ColNo];								
								$save_hdr[$header_name]='0';							
							}
						}
						
						//INSERT SECTION
						 $this->projectmodel->save_records_model('',
						 'import_doctor_master',$save_hdr);
					}

					$this->db->query("delete from import_doctor_master 
					where SVLNO=0 and DOCNAME='0'");
				
				}

				//FINAL UPLOAD
				if($temp_original=='FINAL')
				{
					//$this->comp_struc_model->delete_invalid_location();
					$this->comp_struc_model->update_HQID_FIELDID('DOCTOR');
					$this->comp_struc_model->UPDATE_MASTER('DOCTOR');
					$this->comp_struc_model->update_teritory();		
					
					//FOR UNITED LAB (LINK CHEMIST
					//$this->comp_struc_model->UPDATE_MASTER('RETAILER');
				}
			
			}//DOCTOR_MASTER -SECTION


			//RETAILER_MASTER -SECTION
			if($frmrpttemplatehdrID=='RETAILER_MASTER')
			{
									
					//temporary UPLOAD
					if($temp_original=='TEMPORARY')
					{
						$COLUMNS=6;//GENETICALAB
						//$COLUMNS=12;//UNITED LAB
						$this->db->query("delete from import_retailer_master");
						for ($row = 2; $row <= $highestRow; ++$row) 
						{	
							for ($ColNo = 1; $ColNo <=$COLUMNS;  $ColNo++) 
							{	
								if( isset($cells[$row][$ColNo]) )
								{
									$header_name =$cells[1][$ColNo];								
									$save_hdr[$header_name]=$cells[$row][$ColNo];
								}
								else
								{								
									$header_name =$cells[1][$ColNo];								
									$save_hdr[$header_name]='0';							
								}
							}
							//INSERT SECTION
							$this->projectmodel->save_records_model('',
							'import_retailer_master',$save_hdr);
						}

						$this->db->query("delete from import_retailer_master 
						where CODE='0' and NAME='0'");

					}

					//FINAL UPLOAD
					if($temp_original=='FINAL')
					{
						//$this->comp_struc_model->delete_invalid_location();
						$this->comp_struc_model->update_HQID_FIELDID('RETAILER');
						$this->comp_struc_model->UPDATE_MASTER('RETAILER');
						$this->comp_struc_model->update_teritory();		
						//$this->comp_struc_model->delete_invalid_location();
					}
					
			
			}//RETAILER_MASTER -SECTION
			
			
			//STCKIST -SECTION
			if($frmrpttemplatehdrID=='STOCKIST_MASTER')
			{
				
				$COLUMNS=5;//GENETICALAB
				//$COLUMNS=12;//UNITED LAB
				$this->db->query("delete from import_retailer_master");
				for ($row = 2; $row <= $highestRow; ++$row) 
				{	
					for ($ColNo = 1; $ColNo <=$COLUMNS;  $ColNo++) 
					{	
						if( isset($cells[$row][$ColNo]) )
						{
							$header_name =$cells[1][$ColNo];								
							$save_hdr[$header_name]=$cells[$row][$ColNo];
						}
						else
						{								
							$header_name =$cells[1][$ColNo];								
							$save_hdr[$header_name]='0';							
						}
					}
					//INSERT SECTION
					//print_r($save_hdr);
					//echo '<br>';
					$this->projectmodel->save_records_model('',
					'stockist',$save_hdr);
				}

				$this->db->query("delete from stockist 
				where retail_code='0' and retail_name='0'");

					
			
			}//STOCKIST_MASTER -SECTION
						
			
			//FARE CHART -SECTION
			if($frmrpttemplatehdrID=='FARECHART')
			{
									
					//temporary UPLOAD
					if($temp_original=='TEMPORARY')
					{
						$COLUMNS=6;//GENETICALAB
						//$COLUMNS=12;//UNITED LAB
						$this->db->query("delete from tbl_expense_map");
						for ($row = 2; $row <= $highestRow; ++$row) 
						{	
							for ($ColNo = 1; $ColNo <=$COLUMNS;  $ColNo++) 
							{	
								if( isset($cells[$row][$ColNo]) )
								{
									$header_name =$cells[1][$ColNo];								
									$save_hdr[$header_name]=$cells[$row][$ColNo];
								}
								else
								{								
									$header_name =$cells[1][$ColNo];								
									$save_hdr[$header_name]='0';							
								}
							}
							//INSERT SECTION
							$this->projectmodel->save_records_model('','tbl_expense_map',$save_hdr);
						}
					}
			}//FARE CHART -SECTION

			//GST_TEST
				if($frmrpttemplatehdrID=='GST_TEST')
				{	

					//echo 'tttttt';
					// $excel2 = PHPExcel_IOFactory::createReader('Excel2007');
					// $excel2 = $excel2->load('./uploads/GSTR1.xlsx');
					// $excel2->setLoadAllSheets();
					// $excel2->setActiveSheetIndex(0);
					// $excel2->getActiveSheet()->setCellValue('C6', '4')
					// ->setCellValue('C7', '5')->setCellValue('C8', '6')->setCellValue('C9', '7');
					
					// $excel2->setActiveSheetIndex(1);
					// $excel2->getActiveSheet()->setCellValue('A7', '4')
					// ->setCellValue('C7', '5');

					// $objWriter = PHPExcel_IOFactory::createWriter($excel2, 'Excel2007');
					// $objWriter->save('GSTR1.xlsx');


					$excel2 = PHPExcel_IOFactory::createReader('Excel5');
					$excel2 = $excel2->load('./uploads/upload.xls'); // Empty Sheet
					$excel2->setActiveSheetIndex(0);
					$excel2->getActiveSheet(0)->setCellValue('C6', '4')
						->setCellValue('C7', '5')
						->setCellValue('C8', '6')       
						->setCellValue('C9', '7');




					$filename='GST.xls'; //save our workbook as this file name
					header('Content-Type: application/vnd.ms-excel'); //mime type
					header('Content-Disposition: attachment;filename="'.$filename.'"'); 
					//tell browser what's the file name
					header('Cache-Control: max-age=0'); //no cache
								
					//save it to Excel5 format (excel 2003 .XLS file), 
					//change this to 'Excel2007' (and adjust the filename 
					//extension, also the header mime type)
					//if you want to save it as .XLSX Excel 2007 format
					$objWriter = PHPExcel_IOFactory::createWriter($excel2, 'Excel5');  
					//force user to download the Excel file without writing it to server's HD
					$objWriter->save('php://output');
					
				
				}//GST_TEST

		}

		
		
	}			
		
		$view_path_name='ActiveReport/Transactions/UploadExcell';
	  	$this->page_layout_display($view_path_name,$data);
		
}

public function load_form_report($TranPageName='',$pagetype='',$form_id=0)
{

	$output =$data= array();
	$this->session->set_userdata('form_id', $form_id);
	$this->session->set_userdata('TranPageName', $TranPageName);

	if($pagetype=='acc_tran')
	{
			if($TranPageName=='purchase_invoice' || $TranPageName=='sale_invoice' )
			{
				$TranPageName='purchase_invoice';
				$view_path_name='accounts_management/transaction/'.$TranPageName;		
				
			}	
			else if($TranPageName=='payment_rcv' || $TranPageName=='receive_amt')
			{			
				$TranPageName='payment_rcv';
				$view_path_name='accounts_management/transaction/'.$TranPageName;
			
			}	
			else if($TranPageName=='opm_operation_summary' )
			{			
				$TranPageName='opm_operation';
				$view_path_name='accounts_management/transaction/'.$TranPageName;
			
			}
			else if($TranPageName=='CHART_OF_ACCOUNTS' )
			{			
				$TranPageName='chart_of_accounts';
				$view_path_name='accounts_management/transaction/'.$TranPageName;
			
			}
			else if($TranPageName=='batch_create_final' )
			{			
				$TranPageName='batch_processing';
				$view_path_name='accounts_management/transaction/'.$TranPageName;
			
			}
			
			
		else
		{
			$TranPageName='requisition';
			$view_path_name='accounts_management/transaction/'.$TranPageName;
		}	
	}
	else if($pagetype=='report')
	{
		$TranPageName='experimental_report';
		$view_path_name='accounts_management/reports/'.$TranPageName;
	}
	else if($pagetype=='master_form')
	{
		$TranPageName='master_form';
		$view_path_name='accounts_management/transaction/'.$TranPageName;

		$whr=" id=".$form_id;	
		$TranPageName=$this->projectmodel->GetSingleVal('FormRptName','frmrpttemplatehdr',$whr);		
		$this->session->set_userdata('TranPageName', $TranPageName);

	}
	
	else
	{$view_path_name='projectview/'.$TranPageName;}

	$this->page_layout_display($view_path_name,$data);		
	
}

public function currency_related()
{

		$symbols="USD,INR";
			$postData = array(				
				'symbols' => $symbols
			);			

			$url="https://api.exchangeratesapi.io/latest?symbols=USD,INR";
			$ch = curl_init();
			curl_setopt_array($ch, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true
			));

			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);	
			$output = curl_exec($ch);
			print_r($output);


			if(curl_errno($ch))
			{echo 'error:' . curl_error($ch);}			
			curl_close($ch);			
			return $output;


}


public function dynamic_angularjs_form($datatype='',$form_rpt_ids=0,$master_table_id=0,$header_index=0,$grid_index=0,$others='')
{

		$rs=$resval=$form_structure=$output=array();
		
		if($datatype=='VIEWALLVALUE')
		{
						// $section=0;
						
						$whr=" id=".$form_rpt_ids;	
						$child_ids=$this->projectmodel->GetSingleVal('child_ids','frmrpttemplatehdr',$whr);
						if($child_ids<>''){$form_rpt_ids=$form_rpt_ids.','.$child_ids;}
						

						//$headers="select * from  frmrpttemplatehdr where id=8 or parent_id=8 order by id";

						//$headers="select * from  frmrpttemplatehdr where id=".$cond." order by id";	
						$headers="select * from  frmrpttemplatehdr where id in (".$form_rpt_ids.") order by id";					
						$headers = $this->projectmodel->get_records_from_sql($headers);	
						foreach ($headers as $key1=>$header)
						{				
								$form_structure['header'][$key1]['id']=$header->id;
								$form_structure['header'][$key1]['Type']=$header->Type;
								$form_structure['header'][$key1]['DataFields']=$header->DataFields;
								$form_structure['header'][$key1]['WhereCondition']=$header->WhereCondition;
								$form_structure['header'][$key1]['OrderBy']=$header->OrderBy;
																							
								$form_structure['header'][$key1]['FormRptName']=$header->FormRptName;
								$form_structure['header'][$key1]['Type']=$header->Type;	
								$form_structure['header'][$key1]['parent_id']=$header->parent_id;	
								$form_structure['header'][$key1]['parent_table_field_name']=$header->parent_table_field_name;
								$form_structure['header'][$key1]['child_table_field_name']=$header->child_table_field_name;
								$form_structure['header'][$key1]['TableName']=$header->TableName;

								$form_structure['header'][$key1]['Table_Id']='';
								$form_structure['header'][$key1]['grid_list']='';	
								$form_structure['header'][$key1]['grid_list2']='';
								$form_structure['header'][$key1]['row_num']=0;

										
								//DETAIL SECTION OF THIS HEADER SECTION
								$details="select * from  frmrpttemplatedetails  where frmrpttemplatehdrID=".$header->id." order by FieldOrder";					
								$details = $this->projectmodel->get_records_from_sql($details);	
								foreach ($details as $key2=>$detail)
								{	
									$form_structure['header'][$key1]['body'][$key2]['id']=$detail->id;			

									//RELATED TO DROP DWON MASTER TABLE AND LINK FIELD NAME
									$form_structure['header'][$key1]['body'][$key2]['MainTable']=$detail->MainTable;
									$form_structure['header'][$key1]['body'][$key2]['LinkField']=$detail->LinkField;
									//RELATED TO DROP DWON MASTER TABLE AND LINK FIELD NAME
									
									$form_structure['header'][$key1]['body'][$key2]['frmrpttemplatehdrID']=$detail->frmrpttemplatehdrID;
									$form_structure['header'][$key1]['body'][$key2]['DIVClass']=$detail->DIVClass;
									$form_structure['header'][$key1]['body'][$key2]['Section']=$detail->Section;
									$form_structure['header'][$key1]['body'][$key2]['SectionType']=$detail->SectionType;
									
									$form_structure['header'][$key1]['body'][$key2]['LabelName']=$detail->LabelName;
									$form_structure['header'][$key1]['body'][$key2]['InputName']=$detail->InputName;						
									$form_structure['header'][$key1]['body'][$key2]['Inputvalue']='';		
									$form_structure['header'][$key1]['body'][$key2]['Inputvalue_id']=0;

									if($detail->InputType=='text'){$form_structure['header'][$key1]['body'][$key2]['InputType']='text';}
									//else if($detail->InputType=='text_area'){$form_structure['header'][$key1]['body'][$key2]['InputType']='text_area';}
									else if($detail->InputType=='hidden'){$form_structure['header'][$key1]['body'][$key2]['InputType']='hidden';}
									else if($detail->InputType=='password'){$form_structure['header'][$key1]['body'][$key2]['InputType']='password';}
									else {$form_structure['header'][$key1]['body'][$key2]['InputType']='text';}
									

									$form_structure['header'][$key1]['body'][$key2]['Inputvalue']=$detail->Inputvalue;
									if($detail->datafields<>'')
									{$form_structure['header'][$key1]['body'][$key2]['datafields']=$this->projectmodel->get_records_from_sql($detail->datafields);}
									else
									{$form_structure['header'][$key1]['body'][$key2]['datafields']='';}				
								}	

								if($key1==0) ///MAIN LIST 
								{
									$records=$this->projectmodel->GetMultipleVal($header->DataFields,$header->TableName,$header->WhereCondition,$header->OrderBy);
									foreach($records as $key=>$record)
									{															
										foreach($record as $field_name=>$field_val)
										{
												// TO CHECK WICH FIELD ....RELATED TO MASTER TABLE
												$body_counts=sizeof($form_structure['header'][$key1]['body']);		
												for($body_count=0;$body_count<=$body_counts-1;$body_count++)
												{
													if($form_structure['header'][$key1]['body'][$body_count]['datafields']<>'')
													{
														$field_master_table=$form_structure['header'][$key1]['body'][$body_count]['MainTable'];
														$LinkField=$form_structure['header'][$key1]['body'][$body_count]['LinkField'];
	
														if($field_name==$form_structure['header'][$key1]['body'][$body_count]['InputName'])
														{$records[$key][$field_name]=$this->projectmodel->GetSingleVal($LinkField,$field_master_table,' id='.$field_val);}
	
													}																		
												}																
	
										}	
	
									}	
									$form_structure['header'][$key1]['grid_list']=$records;

									//GRIDLIST 2
									$whr="status='REQUISITION' ";
									$records=$this->projectmodel->GetMultipleVal('*','invoice_summary',$whr,'req_accounting_date');
									$form_structure['header'][$key1]['grid_list2']=$records;

								}

						}


						// echo '<pre>';print_r($form_structure);echo '</pre>';

						//data populate 
						if($master_table_id>0)
						{

							$count=sizeof($form_structure['header']);		
							for($cnt=0;$cnt<=$count-1;$cnt++)
							{			
								
												$TableName=$form_structure['header'][$cnt]['TableName'];
													
												$parent_id=$form_structure['header'][$cnt]['parent_id']; // PARENT FORM OR SECTION.....
												$parent_table_field_name=$form_structure['header'][$cnt]['parent_table_field_name']; // PARENT TABLE ID
												$child_table_field_name=$form_structure['header'][$cnt]['child_table_field_name']; // CHILD  TABLE FIELD NAME FOREIGN KEY OF PARENT TABLE
												$parent_table_id_val=0;		
					
												//grid related section	
												$Type=$form_structure['header'][$cnt]['Type'];
												$DataFields=$form_structure['header'][$cnt]['DataFields'];
												$WhereCondition=$form_structure['header'][$cnt]['WhereCondition'];
												$OrderBy=$form_structure['header'][$cnt]['OrderBy'];
											
												if($cnt==0){$form_structure['header'][$cnt]['Table_Id']=$master_table_id;}
												$Table_Id=$form_structure['header'][$cnt]['Table_Id'];
												

												$body_counts=sizeof($form_structure['header'][$cnt]['body']);		
												for($body_count=0;$body_count<=$body_counts-1;$body_count++)
												{			
													
																if($form_structure['header'][$cnt]['body'][$body_count]['datafields']<>'')
																{
																	
																	$whr=" id=".$Table_Id;	
																	$Inputvalue_id=$this->projectmodel->GetSingleVal($form_structure['header'][$cnt]['body'][$body_count]['InputName'],$TableName,$whr);
																	$inputval='';
																	$datafields_array = json_decode(json_encode($form_structure['header'][$cnt]['body'][$body_count]['datafields']), true);
																	//print_r($datafields_array);
																		$count_parent=sizeof($datafields_array);		
																		for($cnt_parent=0;$cnt_parent<=$count_parent-1;$cnt_parent++)
																		{	
																			//echo $datafields_array[$cnt_parent]['FieldID'];
																			if($datafields_array[$cnt_parent]['FieldID']==$Inputvalue_id)
																				{	
																					$inputval=$datafields_array[$cnt_parent]['FieldVal'];
																					//$WhereCondition=$WhereCondition." and ".$child_table_field_name."=".$save_details[$child_table_field_name];																				
																				}
																		}	
																	
																	$form_structure['header'][$cnt]['body'][$body_count]['Inputvalue']=$inputval;		
																	$form_structure['header'][$cnt]['body'][$body_count]['Inputvalue_id']=$Inputvalue_id;
																}
																else
																{
																	$whr=" id=".$Table_Id;	
																	$inputval=$this->projectmodel->GetSingleVal($form_structure['header'][$cnt]['body'][$body_count]['InputName'],$TableName,$whr);
																	$form_structure['header'][$cnt]['body'][$body_count]['Inputvalue']=$inputval;		
																	$form_structure['header'][$cnt]['body'][$body_count]['Inputvalue_id']='';	
																}

																//grid list data ...
												}	


												//LINK CHILD TABLE WITH PARENT TABLE
												$parent_table_id=0;
												if($parent_id>0) //CHILD FORM...
												{
														//SEARCH THE PARENT ROW
														$count_parent=sizeof($form_structure['header']);		
														for($cnt_parent=0;$cnt_parent<=$count_parent-1;$cnt_parent++)
														{	
																if($form_structure['header'][$cnt_parent]['id']==$parent_id)
																{	
																	$parent_table_id=$form_structure['header'][$cnt_parent]['Table_Id'];
																	$WhereCondition=$WhereCondition." and ".$child_table_field_name."=".$parent_table_id;																
																}
														}	
												}
												
												if($Type=='GRID')								
												{
												
														$records=$this->projectmodel->GetMultipleVal($DataFields,$TableName,$WhereCondition,$OrderBy);

														foreach($records as $key=>$record)
														{															
															foreach($record as $field_name=>$field_val)
															{
																	
																	// TO CHECK WICH FIELD ....RELATED TO MASTER TABLE
																	$body_counts=sizeof($form_structure['header'][$cnt]['body']);		
																	for($body_count=0;$body_count<=$body_counts-1;$body_count++)
																	{
																		if($form_structure['header'][$cnt]['body'][$body_count]['datafields']<>'')
																		{
																			$field_master_table=$form_structure['header'][$cnt]['body'][$body_count]['MainTable'];
																			$LinkField=$form_structure['header'][$cnt]['body'][$body_count]['LinkField'];

																			if($field_name==$form_structure['header'][$cnt]['body'][$body_count]['InputName'])
																			{$records[$key][$field_name]=$this->projectmodel->GetSingleVal($LinkField,$field_master_table,' id='.$field_val);}

																		}																		
																	}																

															}	

														}

														$form_structure['header'][$cnt]['grid_list']=$records;
													
												}
												//LINK CHILD TABLE WITH PARENT TABLE

												//AFTER CLICKING OF GRID VIEW DISPLAY AT TEXT FIELD..
											//	echo $header_index.' - '.$grid_index.' -'.$others.' - '.$Type;
											//	echo '<br>';
												if($grid_index>=0 and $others=='VIEW_LIST' and $Type=='GRID')
												{
														$Table_Id= $form_structure['header'][$header_index]['Table_Id']=$form_structure['header'][$header_index]['grid_list'][$grid_index]['id'];
														$TableName=$form_structure['header'][$header_index]['TableName'];
														$WhereCondition=" id=".$Table_Id;
														$body_counts=sizeof($form_structure['header'][$header_index]['body']);		
														for($body_count=0;$body_count<=$body_counts-1;$body_count++)
														{		
																$records=$this->projectmodel->GetMultipleVal('*',$TableName,$WhereCondition,$OrderBy);
																foreach($records as $key=>$record)
																{															
																	foreach($record as $field_name=>$field_val)
																	{
																			if($form_structure['header'][$header_index]['body'][$body_count]['InputName']==$field_name)
																			{
																				
																					$Inputvalue_id=	$inputval=$field_val;																				
																					if($form_structure['header'][$header_index]['body'][$body_count]['datafields']<>'')
																					{
																					
																						$MainTable=	$form_structure['header'][$header_index]['body'][$body_count]['MainTable'];
																						$LinkField=$form_structure['header'][$header_index]['body'][$body_count]['LinkField'];
																					
																						$whr=" id=".$Inputvalue_id;	
																						$inputval=$this->projectmodel->GetSingleVal($LinkField,$MainTable,$whr);																						
																					}		
																					else
																					{$Inputvalue_id='';}			

																					$form_structure['header'][$header_index]['body'][$body_count]['Inputvalue']=$inputval;		
																					$form_structure['header'][$header_index]['body'][$body_count]['Inputvalue_id']=$Inputvalue_id;	

																			}															
																	}
																}
														}

												}
												//AFTER CLICKING OF GRID VIEW DISPLAY AT TEXT FIELD..


								}//END OF HEADER INDEX LOOP
						}

						// echo '<pre>';print_r($form_structure);echo '</pre>';
						
						//$form_structure['header'][0]['nodes']=$form_structure;
						array_push($output,$form_structure);	
					//	$resval=$this->create_form_structure($resval,$cond,0);
					//	array_push($output,$resval);	

						// echo '<pre>';print_r($output);echo '</pre>';

						header('Access-Control-Allow-Origin: *');
						header("Content-Type: application/json");
						echo json_encode($output);
				
		}


		if($datatype=='SAVE')
		{
			$id_header=$id_detail='';
			$key=0;
			$all_grid_data=$data=$return_data=$save_hdr=array();		

			$RAW_DATA=file_get_contents("php://input");
			$form_data=json_decode(file_get_contents("php://input"));
			$json_array_count=sizeof($form_data);

			//	print_r($RAW_DATA);
				
				// $save_details['brand_name']=3;
				// $save_details['orderno']=3;
				// $this->projectmodel->save_records_model('','brands',$save_details);
				// $id_header=$this->db->insert_id();

				//$form_data[0]->header[$cnt]->Table_Id=$Table_Id;

				//$id_header=$form_data[0]->id_header;		
			
			$id_header=0;	
			$count=sizeof($form_data[0]->header);		
			for($cnt=0;$cnt<=$count-1;$cnt++)
			{			
										
							$TableName=$form_data[0]->header[$cnt]->TableName;
							$Table_Id=$form_data[0]->header[$cnt]->Table_Id;						
							$parent_id=$form_data[0]->header[$cnt]->parent_id; // PARENT FORM OR SECTION.....
							$parent_table_field_name=$form_data[0]->header[$cnt]->parent_table_field_name; // PARENT TABLE ID
							$child_table_field_name=$form_data[0]->header[$cnt]->child_table_field_name; // CHILD  TABLE FIELD NAME FOREIGN KEY OF PARENT TABLE
							$parent_table_id_val=0;		

							//grid related section	
							$Type=$form_data[0]->header[$cnt]->Type;
							$DataFields=$form_data[0]->header[$cnt]->DataFields;
							$WhereCondition=$form_data[0]->header[$cnt]->WhereCondition;
							$OrderBy=$form_data[0]->header[$cnt]->OrderBy;

							
									$save_details=array();	
									$datasave=false;
									//field and their values
									$fields=sizeof($form_data[0]->header[$cnt]->body);		
									for($field_cnt=0;$field_cnt<=$fields-1;$field_cnt++)
									{													
											if(intval($form_data[0]->header[$cnt]->body[$field_cnt]->Inputvalue_id)>0)  // for integer value ....select ,multiselect..etc
											{$save_details[$form_data[0]->header[$cnt]->body[$field_cnt]->InputName]=$form_data[0]->header[$cnt]->body[$field_cnt]->Inputvalue_id;}
											else //for text or string value
											{$save_details[$form_data[0]->header[$cnt]->body[$field_cnt]->InputName]=$form_data[0]->header[$cnt]->body[$field_cnt]->Inputvalue;}

											if($save_details[$form_data[0]->header[$cnt]->body[$field_cnt]->InputName]<>''){$datasave=true;}
											// if($form_data[0]->header[$cnt]->Type=='GRID')
											// {
											// 	$form_data[0]->header[$cnt]->body[$field_cnt]->Inputvalue_id=0;
											// 	$form_data[0]->header[$cnt]->body[$field_cnt]->Inputvalue='';											
											// }

									}


									//LINK CHILD TABLE WITH PARENT TABLE
									if($parent_id>0 && $datasave) //CHILD FORM...
									{
											//SEARCH THE PARENT ROW
											$count_parent=sizeof($form_data[0]->header);		
											for($cnt_parent=0;$cnt_parent<=$count_parent-1;$cnt_parent++)
											{	
													if($form_data[0]->header[$cnt_parent]->id==$parent_id)
													{	
														$save_details[$child_table_field_name]=$form_data[0]->header[$cnt_parent]->Table_Id;
														$WhereCondition=$WhereCondition." and ".$child_table_field_name."=".$save_details[$child_table_field_name];
													
													}
											}	
									}
									//LINK CHILD TABLE WITH PARENT TABLE

								if($Table_Id=='' && $datasave)
								{
									$this->projectmodel->save_records_model('',$TableName,$save_details);	
									$id_header=$this->db->insert_id();	
									$form_data[0]->header[$cnt]->Table_Id=$id_header;
									//$return_data['server_msg']='Record has been Successfully Inserted !';	
									//$form_data[0]->header[0]->FormRptName=$form_data[0]->header[0]->FormRptName.' - Record has been Successfully Inserted !';
									
								}
								else
								{
									$this->projectmodel->save_records_model($Table_Id,$TableName,$save_details);
									$form_data[0]->header[$cnt]->Table_Id=$Table_Id;
									$id_header=$Table_Id;
									//$return_data['server_msg']='Record has been Successfully Updated !';	
									//$form_data[0]->header[0]->FormRptName=$form_data[0]->header[0]->FormRptName.' - Record has been Successfully Updated !';
								}
							

								// if($Type=='GRID')								
								// {
								// 	 $sql="select ".$DataFields." from ".$TableName." where ".$WhereCondition." order by ".$OrderBy." ";
								// 	 $form_data[0]->header[$cnt]->grid_list= $this->projectmodel->get_records_from_sql($sql);	

								// }


			}

			


			// Converting object to associative array 
			// $return_data = json_decode(json_encode($form_data), true); 
			// $return_data['form_data']=$return_data;
			$return_data['id_header']=$form_data[0]->header[0]->Table_Id;
			
			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($return_data);

		}
		
	

}

public function receipt_of_goods($datatype='')
{

		$rs=$resval=$form_structure=$output=array();
			
		if($datatype=='view_list')
		{
			
			 // $form_data1=json_decode(file_get_contents("php://input"));	
			//	$id=mysql_real_escape_string($form_data1->id);	//PARAMETERS		
				
			
			$headers="select a.id,a.parent_id,a.status,a.req_operating_unit,a.req_accounting_date,a.req_supplier,a.req_description,a.req_type,a.req_number,a.req_preparer,a.req_currency_id,
			a.req_total,a.req_destination_type,a.req_requiester,a.req_organization,a.req_location,
			b.id detail_id,b.item_id,b.qnty,b.uom,b.price 
			 from  invoice_summary a,invoice_details b where a.id=b.invoice_summary_id  ";					
			$headers = $this->projectmodel->get_records_from_sql($headers);	
			foreach ($headers as $key=>$header)
			{				
					$form_structure['header'][$key]['id']=$header->id;
					$form_structure['header'][$key]['parent_id']=$header->parent_id;
					$form_structure['header'][$key]['status']=$header->status;
					
					$form_structure['header'][$key]['req_number']=$header->req_number; //as po no
					$form_structure['header'][$key]['req_accounting_date']=$header->req_accounting_date; //as po no

					$req_operating_unit=$form_structure['header'][$key]['req_operating_unit']=$header->req_operating_unit;
					$whr=" id=".$req_operating_unit;					
					$form_structure['header'][$key]['req_operating_name']=$this->projectmodel->GetSingleVal('hierarchy_name','tbl_hierarchy_org',$whr);
					$form_structure['header'][$key]['req_type']=$header->req_type;

					$form_structure['header'][$key]['req_supplier']=$header->req_supplier;
					$form_structure['header'][$key]['req_supplier_name']=$this->projectmodel->GetSingleVal('name','supplier_master',"id=".$header->req_supplier);
					
					$form_structure['header'][$key]['detail_id']=$header->detail_id;
					
					$form_structure['header'][$key]['item_id']=$header->item_id;
					$form_structure['header'][$key]['item_name']='product name';
					$form_structure['header'][$key]['qnty']=$header->qnty;
					$form_structure['header'][$key]['price']=$header->price;
					$form_structure['header'][$key]['uom']=$header->uom;
					$form_structure['header'][$key]['uom_name']='UOM NAME';
					$form_structure['header'][$key]['grn_approve']='N';

					
			}

			

			array_push($output,$form_structure);

			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($output);						

		}
		

}


public function invoice_entry($datatype='')
{

		$rs=$resval=$form_structure=$output=array();
			
		if($datatype=='view_list')
		{
			
			  //$form_data1=json_decode(file_get_contents("php://input"));	
				//$id=mysql_real_escape_string($form_data1->id);	//PARAMETERS		
							
			$headers="select b.invoice_summary_id,b.item_id,b.qnty,b.uom,b.price  from  invoice_summary a,invoice_details b where a.id=b.invoice_summary_id ";					
			$headers = $this->projectmodel->get_records_from_sql($headers);	
			$headers = json_decode(json_encode($headers), true);
			foreach ($headers as $key=>$header)
			{	
				//echo $key.$header;
				foreach ($header as $key2=>$field_val)
				{	
					$form_structure['header'][0]['section_type']='FORM';
					$form_structure['header'][0]['fields'][$key][$key2]=$this->create_fields_parameter(48,$key2,$field_val);
				}
			}

			// $headers="select b.invoice_summary_id,b.item_id,b.qnty,b.uom,b.price  from  invoice_summary a,invoice_details b where a.id=b.invoice_summary_id ";					
			// $headers = $this->projectmodel->get_records_from_sql($headers);	
			// $headers = json_decode(json_encode($headers), true);
			// foreach ($headers as $key=>$header)
			// {	
			// 	foreach ($header as $key2=>$field_val)
			// 	{	
			// 		$form_structure['header'][1]['section_type']='GRID';
			// 		$form_structure['header'][1]['fields'][$key][$key2]=$this->create_fields_parameter(48,$key2,$field_val);
			// 	}
			// }

			// echo '<pre>';
			// print_r($form_structure);
			// echo '</pre>';

			//print_r($headers);	

			array_push($output,$form_structure);
			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($output);						

		}
		

}

public function get_current_form_report_name()
{
	$return_data['TranPageName']=$this->session->userdata('TranPageName');			
	header('Access-Control-Allow-Origin: *');
	header("Content-Type: application/json");
	echo json_encode($return_data);
}

	

public function currency_daily_rate($datatype='',$cond=0)
{


	 $output=array();

		if($datatype=='SAVE')
		{
			$id_header=$id_detail='';
			$data=$return_data=$save_details=$save_hdr=array();				
			$RAW_DATA=file_get_contents("php://input");
			$form_data=json_decode(file_get_contents("php://input"));
			$json_array_count=sizeof($form_data);

						
			//$id_header=$form_data[0]->id_header;			
			
			
			$count=sizeof($form_data[0]->code_structure1);		
			for($cnt=0;$cnt<=$count-1;$cnt++)
			{			
					$id1=$form_data[0]->code_structure1[$cnt]->id;
					$save_details1['from_currency_id']=$form_data[0]->code_structure1[$cnt]->from_currency_id;		
					$save_details1['to_currency_id']=$form_data[0]->code_structure1[$cnt]->to_currency_id;		
					$save_details1['trandate']=$form_data[0]->code_structure1[$cnt]->trandate;		
					$save_details1['from_to_rate']=$form_data[0]->code_structure1[$cnt]->from_to_rate;		
					$save_details1['to_from_rate']=$form_data[0]->code_structure1[$cnt]->to_from_rate;						

					if($id1==0)
					{$this->projectmodel->save_records_model('','tbl_currency_daily_rate',$save_details1);	$id1=$this->db->insert_id();	}
					else
					{$this->projectmodel->save_records_model($id1,'tbl_currency_daily_rate',$save_details1);	}

			}

			$return_data['id_header']=$id_header;
			
			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($return_data);

		}



		if($datatype=='VIEWALLVALUE')
		{
							
					$arraindx=0;

					$acc_tran_details['code_structure1'][$arraindx]['id']=0;
					$acc_tran_details['code_structure1'][$arraindx]['from_currency_id']=0;		
					$acc_tran_details['code_structure1'][$arraindx]['to_currency_id']='';		
					$acc_tran_details['code_structure1'][$arraindx]['trandate']='';		
					$acc_tran_details['code_structure1'][$arraindx]['from_to_rate']=0;				
					$acc_tran_details['code_structure1'][$arraindx]['to_from_rate']=0;				
																
					if($cond>0)
					{
						$sql_bills="select * from  tbl_currency_daily_rate  ORDER BY trandate desc";					
						$sql_bills = $this->projectmodel->get_records_from_sql($sql_bills);	
						foreach ($sql_bills as $key1=>$sql_bill)
						{				
							$acc_tran_details['code_structure1'][$key1]['id']=$sql_bill->id;
							$acc_tran_details['code_structure1'][$key1]['from_currency_id']=$sql_bill->from_currency_id;	
							$acc_tran_details['code_structure1'][$key1]['to_currency_id']=$sql_bill->to_currency_id;	
							$acc_tran_details['code_structure1'][$key1]['trandate']=$sql_bill->trandate;
							$acc_tran_details['code_structure1'][$key1]['from_to_rate']=$sql_bill->from_to_rate;				
							$acc_tran_details['code_structure1'][$key1]['to_from_rate']=$sql_bill->to_from_rate;
						}
					}
			
					array_push($output,$acc_tran_details);

				//	$sql_bills="select * from  tbl_currency_daily_rate  ORDER BY id";					
				//	$sql_bills = $this->projectmodel->get_records_from_sql($sql_bills);	


					header('Access-Control-Allow-Origin: *');
					header("Content-Type: application/json");
					echo json_encode($output);
					//echo json_encode($sql_bills);
		}

		
	

}

public function Employee_priviledge_set($tbl_employee_mstr_id=0,$operation_type='display')
	{		
			$this->login_validate();
			$layout_data=array();
			$data=array();
		//	$data['OPERATION'] =$this->projectmodel->priviledge_value(34);	
			$data['OPERATION']='ADD_EDIT';
			$data['tbl_employee_mstr_id']=$tbl_employee_mstr_id;
			

			$whr=" id=".$tbl_employee_mstr_id;	
			$rollid=$this->projectmodel->GetSingleVal('software_archi_role_manage_id','tbl_employee_mstr',$whr);

			$menu_records = "select a.* from  software_architecture_details a,software_archi_role_manage b where 
			a.id=b.software_architecture_details_id and b.parent_id=".$rollid." and b.status='ACTIVE'  ";
			$data['records']=$this->projectmodel->get_records_from_sql($menu_records);	
			$maxkey=sizeof($data['records']);   
								
			if(isset($_POST))
			{	
							// if($operation_type=='display')
							// {$data['tbl_employee_mstr_id']=$this->input->post('tbl_employee_mstr_id');}	
						
							//echo $operation_type;

							

							if($operation_type=='save')
							{				
								
									  $tbl_employee_mstr_id=$save_dtl['tbl_employee_mstr_id']=$this->input->post('tbl_employee_mstr_id');		
										$this->db->query("delete from menu_user_priviledge where tbl_employee_mstr_id=".$tbl_employee_mstr_id);		
										//DETAIL SECTION
										//$maxkey=30;
										for($i=0;$i<=$maxkey;$i++)
										{			
											$save_dtl['menu_details_id']=$this->input->post('menu_details_id'.$i);
											//echo '<br>';
												$save_dtl['OPERATION']=$this->input->post('OPERATION'.$i);							
												if( $save_dtl['menu_details_id']>0)
												{ $this->projectmodel->save_records_model('','menu_user_priviledge',$save_dtl);}
										}
						
							}	// end post
			
					$view_path_name='projectview/employee_priviledge_set';
					$this->page_layout_display($view_path_name,$data);
			}	
}

	public function list_of_values($datatype='',$cond=0)
	{
	

		$output=array();

			if($datatype=='SAVE')
			{
				$id_header=$id_detail='';
				$data=$return_data=$save_details=$save_hdr=array();				
				$RAW_DATA=file_get_contents("php://input");
				$form_data=json_decode(file_get_contents("php://input"));
				$json_array_count=sizeof($form_data);

							
				$id_header=$form_data[0]->id_header;			

				$count=sizeof($form_data[0]->list_of_values);		
				for($cnt=0;$cnt<=$count-1;$cnt++)
				{			
						$id_detail=$form_data[0]->list_of_values[$cnt]->id_detail;
						$save_details['parent_id']=$id_header;
						$save_details['Status']='LIST';
						$save_details['active_inactive']=$form_data[0]->list_of_values[$cnt]->active_inactive;
						$save_details['FieldID']=$save_details['FieldVal']=$form_data[0]->list_of_values[$cnt]->FieldVal;	
						$save_details['comment']=$form_data[0]->list_of_values[$cnt]->comment;	
						$save_details['display_order']=$form_data[0]->list_of_values[$cnt]->display_order;	
						
						$this->projectmodel->save_records_model($id_detail,'frmrptgeneralmaster',$save_details);						
							
				}

				$return_data['id_header']=$id_header;
				
				header('Access-Control-Allow-Origin: *');
				header("Content-Type: application/json");
				echo json_encode($return_data);

			}




			if($datatype=='VIEWALLVALUE')
			{
							
					$acc_tran_details['id_header']=$cond;

					//delete array elements				
					// for($bil=0;$bil<=300-1;$bil++)
					// {unset($acc_tran_details['list_of_values'][$bil]);}
					
						$arraindx=0;
						$acc_tran_details['list_of_values'][$arraindx]['id_detail']='';
						$acc_tran_details['list_of_values'][$arraindx]['FieldVal']=0;				
						$acc_tran_details['list_of_values'][$arraindx]['comment']='';								
						$acc_tran_details['list_of_values'][$arraindx]['display_order']='';
						$acc_tran_details['list_of_values'][$arraindx]['active_inactive']='';		
					
						if($cond>0)
						{
							$sql_bills="select * from  frmrptgeneralmaster where 	parent_id=".$cond." ORDER BY id";					
							$sql_bills = $this->projectmodel->get_records_from_sql($sql_bills);	
							foreach ($sql_bills as $sql_bill)
							{				
								$acc_tran_details['list_of_values'][$arraindx]['id_detail']=$sql_bill->id;
								$acc_tran_details['list_of_values'][$arraindx]['FieldVal']=$sql_bill->FieldVal;		
								$acc_tran_details['list_of_values'][$arraindx]['comment']=$sql_bill->comment;						
								$acc_tran_details['list_of_values'][$arraindx]['display_order']=$sql_bill->display_order;
								$acc_tran_details['list_of_values'][$arraindx]['active_inactive']=$sql_bill->active_inactive;
	
								$arraindx=$arraindx+1;
							}
						}
				
						array_push($output,$acc_tran_details);
						header('Access-Control-Allow-Origin: *');
						header("Content-Type: application/json");
						echo json_encode($output);
			}

			
			// $arraindx=0;
			// if($datatype=='VIEWALLVALUE')
			// {		 
				
			// 	$records="select * from  frmrptgeneralmaster where  parent_id=".$cond." ORDER BY id";
			// 	$records = $this->projectmodel->get_records_from_sql($records);	
					
			// 	header('Access-Control-Allow-Origin: *');
			// 	header("Content-Type: application/json");
			// 	echo json_encode($records);
			// }
			
			// if($datatype=='GetAllList')
			// {				
			// 	$whr=" 	invoice_date between '$fromdate' and '$todate' and status='SELL' ";
			// 	$rs=$this->projectmodel->GetMultipleVal('*','trip_invoice_summary',$whr,'invoice_date desc ');
			// 	$json_array_count=sizeof($rs);	 
			// 	for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			// 	{
			// 		$rs[$fieldIndex]['vno']=$this->projectmodel->GetSingleVal('retail_name','stockist',' id='.$rs[$fieldIndex]['vehicle_no']);
					
			// 		$source_name=$this->projectmodel->GetSingleVal('source_name','tbl_destination',' id='.$rs[$fieldIndex]['source_destion_id']);
			// 		$destination_name=$this->projectmodel->GetSingleVal('destination_name','tbl_destination',' id='.$rs[$fieldIndex]['source_destion_id']);
			// 			$rs[$fieldIndex]['source_dest']=$source_name.'-'.$destination_name;
					
			// 	}				
			// 	$this->projectmodel->send_json_output($rs);
			
			// }		

	}


	public function calendar($datatype='',$cond=0)
	{
	

		$output=array();

			if($datatype=='SAVE')
			{
				$id_header=$id='';
				$data=$return_data=$save_details=$save_hdr=array();				
				$RAW_DATA=file_get_contents("php://input");
				$form_data=json_decode(file_get_contents("php://input"));
				$json_array_count=sizeof($form_data);

							
				$id_header=$form_data[0]->id_header;			

				$count=sizeof($form_data[0]->list_of_values);		
				for($cnt=0;$cnt<=$count-1;$cnt++)
				{			
						$id=$form_data[0]->list_of_values[$cnt]->id;
						$save_details['parent_id']=$id_header;						
						$save_details['period_type']=$form_data[0]->list_of_values[$cnt]->period_type;
						$save_details['period_per_year']=$form_data[0]->list_of_values[$cnt]->period_per_year;	
						$save_details['description']=$form_data[0]->list_of_values[$cnt]->description;	
						$save_details['prefix']=$form_data[0]->list_of_values[$cnt]->prefix;	

						$save_details['year']=$form_data[0]->list_of_values[$cnt]->year;	
						$save_details['quater']=$form_data[0]->list_of_values[$cnt]->quater;	
						$save_details['month_num']=$form_data[0]->list_of_values[$cnt]->month_num;	
						$save_details['fromdate']=$form_data[0]->list_of_values[$cnt]->fromdate;	
						$save_details['todate']=$form_data[0]->list_of_values[$cnt]->todate;	
						$save_details['status']=$form_data[0]->list_of_values[$cnt]->status;	
						$save_details['name']=$form_data[0]->list_of_values[$cnt]->name;				
						
						
						$this->projectmodel->save_records_model($id,'tbl_calender',$save_details);						
							
				}

				$return_data['id_header']=$id_header;
				
				header('Access-Control-Allow-Origin: *');
				header("Content-Type: application/json");
				echo json_encode($return_data);

			}


			if($datatype=='VIEWALLVALUE')
			{
							
					$acc_tran_details['id_header']=$cond;

					//delete array elements				
					// for($bil=0;$bil<=300-1;$bil++)
					// {unset($acc_tran_details['list_of_values'][$bil]);}
					
						$arraindx=0;
						$acc_tran_details['list_of_values'][$arraindx]['id']='';						
						$acc_tran_details['list_of_values'][$arraindx]['period_type']='';								
						$acc_tran_details['list_of_values'][$arraindx]['period_per_year']='';
						$acc_tran_details['list_of_values'][$arraindx]['description']='';
						$acc_tran_details['list_of_values'][$arraindx]['prefix']=0;				
						$acc_tran_details['list_of_values'][$arraindx]['year']='';								
						$acc_tran_details['list_of_values'][$arraindx]['quater']='';
						$acc_tran_details['list_of_values'][$arraindx]['month_num']='';		
						$acc_tran_details['list_of_values'][$arraindx]['fromdate']=0;				
						$acc_tran_details['list_of_values'][$arraindx]['todate']='';								
						$acc_tran_details['list_of_values'][$arraindx]['status']='';
						$acc_tran_details['list_of_values'][$arraindx]['name']='';		
					
						if($cond>0)
						{
							$sql_bills="select * from  tbl_calender where 	parent_id=".$cond." ORDER BY id";					
							$sql_bills = $this->projectmodel->get_records_from_sql($sql_bills);	
							foreach ($sql_bills as $sql_bill)
							{				
								
								$acc_tran_details['list_of_values'][$arraindx]['id']=$sql_bill->id;								
								$acc_tran_details['list_of_values'][$arraindx]['period_type']=$sql_bill->period_type;								
								$acc_tran_details['list_of_values'][$arraindx]['period_per_year']=$sql_bill->period_per_year;
								$acc_tran_details['list_of_values'][$arraindx]['description']=$sql_bill->description;
								$acc_tran_details['list_of_values'][$arraindx]['prefix']=$sql_bill->prefix;				
								$acc_tran_details['list_of_values'][$arraindx]['year']=$sql_bill->year;						
								$acc_tran_details['list_of_values'][$arraindx]['quater']=$sql_bill->quater;
								$acc_tran_details['list_of_values'][$arraindx]['month_num']=$sql_bill->month_num;
								$acc_tran_details['list_of_values'][$arraindx]['fromdate']=$sql_bill->fromdate;			
								$acc_tran_details['list_of_values'][$arraindx]['todate']=$sql_bill->todate;							
								$acc_tran_details['list_of_values'][$arraindx]['status']=$sql_bill->status;
								$acc_tran_details['list_of_values'][$arraindx]['name']=$sql_bill->name;		
								$arraindx=$arraindx+1;
							}
						}
				
						array_push($output,$acc_tran_details);
						header('Access-Control-Allow-Origin: *');
						header("Content-Type: application/json");
						echo json_encode($output);
			}

			
		

	}


	public function roll_mapping($datatype='',$cond=0)
	{
	

		$output=array();

			if($datatype=='SAVE')
			{
				$id_header=$id_detail='';
				$data=$return_data=$save_details=$save_hdr=array();				
				$RAW_DATA=file_get_contents("php://input");
				$form_data=json_decode(file_get_contents("php://input"));
				$json_array_count=sizeof($form_data);

							
				$id_header=$form_data[0]->id_header;			

				$count=sizeof($form_data[0]->list_of_values);		
				for($cnt=0;$cnt<=$count-1;$cnt++)
				{			
						$id_detail=$form_data[0]->list_of_values[$cnt]->id_detail;
						$save_details['parent_id']=$id_header;
						$save_details['data_type']='DETAILS';
						$save_details['status']=$form_data[0]->list_of_values[$cnt]->active_inactive;
						$save_details['software_architecture_details_id']=$form_data[0]->list_of_values[$cnt]->FieldVal;							
						$this->projectmodel->save_records_model($id_detail,'software_archi_role_manage',$save_details);						
							
				}

				$return_data['id_header']=$id_header;
				
				header('Access-Control-Allow-Origin: *');
				header("Content-Type: application/json");
				echo json_encode($return_data);

			}




			if($datatype=='VIEWALLVALUE')
			{
							
					$acc_tran_details['id_header']=$cond;

					//delete array elements				
					// for($bil=0;$bil<=300-1;$bil++)
					// {unset($acc_tran_details['list_of_values'][$bil]);}
					
						$arraindx=0;
						$acc_tran_details['list_of_values'][$arraindx]['id_detail']='';
						$acc_tran_details['list_of_values'][$arraindx]['FieldVal']=0;				
						$acc_tran_details['list_of_values'][$arraindx]['comment']='';								
						$acc_tran_details['list_of_values'][$arraindx]['display_order']='';
						$acc_tran_details['list_of_values'][$arraindx]['active_inactive']='';		
					
						if($cond>0)
						{
							$sql_bills="select * from  software_archi_role_manage where 	parent_id=".$cond." ORDER BY id";					
							$sql_bills = $this->projectmodel->get_records_from_sql($sql_bills);	
							foreach ($sql_bills as $sql_bill)
							{				
								$acc_tran_details['list_of_values'][$arraindx]['id_detail']=$sql_bill->id;
								$acc_tran_details['list_of_values'][$arraindx]['FieldVal']=$sql_bill->software_architecture_details_id;		
								$acc_tran_details['list_of_values'][$arraindx]['comment']='';						
								$acc_tran_details['list_of_values'][$arraindx]['display_order']='';
								$acc_tran_details['list_of_values'][$arraindx]['active_inactive']=$sql_bill->status;
	
								$arraindx=$arraindx+1;
							}
						}
				
						array_push($output,$acc_tran_details);
						header('Access-Control-Allow-Origin: *');
						header("Content-Type: application/json");
						echo json_encode($output);
			}

			
		

	}

	

	public function code_structure($datatype='',$cond=0)
	{
	

		$output=array();

			if($datatype=='SAVE')
			{
				$id_header=$id_detail='';
				$data=$return_data=$save_details=$save_hdr=array();				
				$RAW_DATA=file_get_contents("php://input");
				$form_data=json_decode(file_get_contents("php://input"));
				$json_array_count=sizeof($form_data);

							
				//$id_header=$form_data[0]->id_header;			
				
				
				$count=sizeof($form_data[0]->code_structure1);		
				for($cnt=0;$cnt<=$count-1;$cnt++)
				{			
						$id1=$form_data[0]->code_structure1[$cnt]->id;
						$save_details1['parent_id']=$form_data[0]->code_structure1[$cnt]->parent_id;		
						$save_details1['code']=$form_data[0]->code_structure1[$cnt]->code;		
						$save_details1['value']=$form_data[0]->code_structure1[$cnt]->value;		
						$save_details1['code_type_id']=$form_data[0]->code_structure1[$cnt]->code_type_id;		
						$save_details1['code_main_id']=$form_data[0]->code_structure1[$cnt]->code_main_id;		
						$save_details1['active_inactive']=$form_data[0]->code_structure1[$cnt]->active_inactive;		
						$save_details1['startdate']=$form_data[0]->code_structure1[$cnt]->startdate;		
						$save_details1['enddate']=$form_data[0]->code_structure1[$cnt]->enddate;			
						$save_details1['description']=$form_data[0]->code_structure1[$cnt]->description;

						if($id1==0)
						{$this->projectmodel->save_records_model('','tbl_chart_of_accounts',$save_details1);	$id1=$this->db->insert_id();	}
						else
						{$this->projectmodel->save_records_model($id1,'tbl_chart_of_accounts',$save_details1);	}


							//CODE STRUCTURE 2
							$count2=sizeof($form_data[0]->code_structure1[$cnt]->code_structure2);		
							for($cnt2=0;$cnt2<=$count2-1;$cnt2++)
							{			
									$id2=$form_data[0]->code_structure1[$cnt]->code_structure2[$cnt2]->id;
									$save_details2['parent_id']=$id1;		
									$save_details2['code']=$form_data[0]->code_structure1[$cnt]->code_structure2[$cnt2]->code;		
									$save_details2['value']=$form_data[0]->code_structure1[$cnt]->code_structure2[$cnt2]->value;		
									$save_details2['code_type_id']=$form_data[0]->code_structure1[$cnt]->code_structure2[$cnt2]->code_type_id;		
									$save_details2['code_main_id']=$form_data[0]->code_structure1[$cnt]->code_structure2[$cnt2]->code_main_id;		
									$save_details2['active_inactive']=$form_data[0]->code_structure1[$cnt]->code_structure2[$cnt2]->active_inactive;		
									$save_details2['startdate']=$form_data[0]->code_structure1[$cnt]->code_structure2[$cnt2]->startdate;		
									$save_details2['enddate']=$form_data[0]->code_structure1[$cnt]->code_structure2[$cnt2]->enddate;			
									$save_details2['description']=$form_data[0]->code_structure1[$cnt]->code_structure2[$cnt2]->description;
			
									if($id2==0)
									{$this->projectmodel->save_records_model('','tbl_chart_of_accounts',$save_details2);	$id2=$this->db->insert_id();	}
									else
									{$this->projectmodel->save_records_model($id2,'tbl_chart_of_accounts',$save_details2);	}


											//CODE STRUCTURE 3 - CHART OF ACCOUNT
											$count3=sizeof($form_data[0]->code_structure1[$cnt]->code_structure2[$cnt2]->code_structure3);		
											for($cnt3=0;$cnt3<=$count3-1;$cnt3++)
											{			
													$id3=$form_data[0]->code_structure1[$cnt]->code_structure2[$cnt2]->code_structure3[$cnt3]->id;
													$save_details3['parent_id']=$id2;		
													$save_details3['code']=$form_data[0]->code_structure1[$cnt]->code_structure2[$cnt2]->code_structure3[$cnt3]->code;		
													$save_details3['value']=$form_data[0]->code_structure1[$cnt]->code_structure2[$cnt2]->code_structure3[$cnt3]->value;		
													$save_details3['code_type_id']=$form_data[0]->code_structure1[$cnt]->code_structure2[$cnt2]->code_structure3[$cnt3]->code_type_id;		
													$save_details3['code_main_id']=$form_data[0]->code_structure1[$cnt]->code_structure2[$cnt2]->code_structure3[$cnt3]->code_main_id;		
													$save_details3['active_inactive']=$form_data[0]->code_structure1[$cnt]->code_structure2[$cnt2]->code_structure3[$cnt3]->active_inactive;		
													$save_details3['startdate']=$form_data[0]->code_structure1[$cnt]->code_structure2[$cnt2]->code_structure3[$cnt3]->startdate;		
													$save_details3['enddate']=$form_data[0]->code_structure1[$cnt]->code_structure2[$cnt2]->code_structure3[$cnt3]->enddate;			
													$save_details3['description']=$form_data[0]->code_structure1[$cnt]->code_structure2[$cnt2]->code_structure3[$cnt3]->description;
							
													if($id1==0)
													{$this->projectmodel->save_records_model('','tbl_chart_of_accounts',$save_details3);	$id3=$this->db->insert_id();	}
													else
													{$this->projectmodel->save_records_model($id3,'tbl_chart_of_accounts',$save_details3);	}
							
											}

							}

										
							
				}

				$return_data['id_header']=$id_header;
				
				header('Access-Control-Allow-Origin: *');
				header("Content-Type: application/json");
				echo json_encode($return_data);

			}




			if($datatype=='VIEWALLVALUE')
			{
								
						$arraindx=0;

						$acc_tran_details['code_structure1'][$arraindx]['id']=0;
						$acc_tran_details['code_structure1'][$arraindx]['parent_id']=0;		
						$acc_tran_details['code_structure1'][$arraindx]['code']='';		
						$acc_tran_details['code_structure1'][$arraindx]['value']='';		
						$acc_tran_details['code_structure1'][$arraindx]['code_type_id']=0;				
						$acc_tran_details['code_structure1'][$arraindx]['code_main_id']=0;				
						$acc_tran_details['code_structure1'][$arraindx]['active_inactive']='ACTIVE';		
						$acc_tran_details['code_structure1'][$arraindx]['startdate']='';				
						$acc_tran_details['code_structure1'][$arraindx]['enddate']='';				
						$acc_tran_details['code_structure1'][$arraindx]['description']='';		

						$acc_tran_details['code_structure1'][$arraindx]['code_structure2'][$arraindx]['id']=0;
						$acc_tran_details['code_structure1'][$arraindx]['code_structure2'][$arraindx]['parent_id']=0;		
						$acc_tran_details['code_structure1'][$arraindx]['code_structure2'][$arraindx]['code']='';		
						$acc_tran_details['code_structure1'][$arraindx]['code_structure2'][$arraindx]['value']='';		
						$acc_tran_details['code_structure1'][$arraindx]['code_structure2'][$arraindx]['code_type_id']=0;				
						$acc_tran_details['code_structure1'][$arraindx]['code_structure2'][$arraindx]['code_main_id']=0;				
						$acc_tran_details['code_structure1'][$arraindx]['code_structure2'][$arraindx]['active_inactive']='ACTIVE';		
						$acc_tran_details['code_structure1'][$arraindx]['code_structure2'][$arraindx]['startdate']='';				
						$acc_tran_details['code_structure1'][$arraindx]['code_structure2'][$arraindx]['enddate']='';				
						$acc_tran_details['code_structure1'][$arraindx]['code_structure2'][$arraindx]['description']='';		

						$acc_tran_details['code_structure1'][$arraindx]['code_structure2'][$arraindx]['code_structure3'][$arraindx]['id']=0;
						$acc_tran_details['code_structure1'][$arraindx]['code_structure2'][$arraindx]['code_structure3'][$arraindx]['parent_id']=0;		
						$acc_tran_details['code_structure1'][$arraindx]['code_structure2'][$arraindx]['code_structure3'][$arraindx]['code']='';		
						$acc_tran_details['code_structure1'][$arraindx]['code_structure2'][$arraindx]['code_structure3'][$arraindx]['value']='';		
						$acc_tran_details['code_structure1'][$arraindx]['code_structure2'][$arraindx]['code_structure3'][$arraindx]['code_type_id']=0;				
						$acc_tran_details['code_structure1'][$arraindx]['code_structure2'][$arraindx]['code_structure3'][$arraindx]['code_main_id']=0;				
						$acc_tran_details['code_structure1'][$arraindx]['code_structure2'][$arraindx]['code_structure3'][$arraindx]['active_inactive']='ACTIVE';		
						$acc_tran_details['code_structure1'][$arraindx]['code_structure2'][$arraindx]['code_structure3'][$arraindx]['startdate']='';				
						$acc_tran_details['code_structure1'][$arraindx]['code_structure2'][$arraindx]['code_structure3'][$arraindx]['enddate']='';				
						$acc_tran_details['code_structure1'][$arraindx]['code_structure2'][$arraindx]['code_structure3'][$arraindx]['description']='';		

									
						if($cond>0)
						{
							$sql_bills="select * from  tbl_chart_of_accounts where parent_id=0 ORDER BY id";					
							$sql_bills = $this->projectmodel->get_records_from_sql($sql_bills);	
							foreach ($sql_bills as $key1=>$sql_bill)
							{				
								$acc_tran_details['code_structure1'][$key1]['id']=$sql_bill->id;
								$acc_tran_details['code_structure1'][$key1]['parent_id']=$sql_bill->parent_id;	
								$acc_tran_details['code_structure1'][$key1]['code']=$sql_bill->code;	
								$acc_tran_details['code_structure1'][$key1]['value']=$sql_bill->value;
								$acc_tran_details['code_structure1'][$key1]['code_type_id']=$sql_bill->code_type_id;				
								$acc_tran_details['code_structure1'][$key1]['code_main_id']=$sql_bill->code_main_id;			
								$acc_tran_details['code_structure1'][$key1]['active_inactive']=$sql_bill->active_inactive;	
								$acc_tran_details['code_structure1'][$key1]['startdate']=$sql_bill->startdate;	
								$acc_tran_details['code_structure1'][$key1]['enddate']=$sql_bill->enddate;			
								$acc_tran_details['code_structure1'][$key1]['description']=$sql_bill->description;	
							

								$records2="select * from  tbl_chart_of_accounts where parent_id=".$sql_bill->id." ORDER BY id";					
								$records2 = $this->projectmodel->get_records_from_sql($records2);	
								foreach ($records2 as $key2=>$record2)
								{				
									$acc_tran_details['code_structure1'][$key1]['code_structure2'][$key2]['id']=$record2->id;
									$acc_tran_details['code_structure1'][$key1]['code_structure2'][$key2]['parent_id']=$record2->parent_id;	
									$acc_tran_details['code_structure1'][$key1]['code_structure2'][$key2]['code']=$record2->code;	
									$acc_tran_details['code_structure1'][$key1]['code_structure2'][$key2]['value']=$record2->value;
									$acc_tran_details['code_structure1'][$key1]['code_structure2'][$key2]['code_type_id']=$record2->code_type_id;				
									$acc_tran_details['code_structure1'][$key1]['code_structure2'][$key2]['code_main_id']=$record2->code_main_id;			
									$acc_tran_details['code_structure1'][$key1]['code_structure2'][$key2]['active_inactive']=$record2->active_inactive;	
									$acc_tran_details['code_structure1'][$key1]['code_structure2'][$key2]['startdate']=$record2->startdate;	
									$acc_tran_details['code_structure1'][$key1]['code_structure2'][$key2]['enddate']=$record2->enddate;			
									$acc_tran_details['code_structure1'][$key1]['code_structure2'][$key2]['description']=$record2->description;	



											$records3="select * from  tbl_chart_of_accounts where parent_id=".$record2->id." ORDER BY id";					
											$records3 = $this->projectmodel->get_records_from_sql($records3);	
											foreach ($records3 as $key3=>$record3)
											{				
												$acc_tran_details['code_structure1'][$key1]['code_structure2'][$key2]['code_structure3'][$key3]['id']=$record3->id;
												$acc_tran_details['code_structure1'][$key1]['code_structure2'][$key2]['code_structure3'][$key3]['parent_id']=$record3->parent_id;	
												$acc_tran_details['code_structure1'][$key1]['code_structure2'][$key2]['code_structure3'][$key3]['code']=$record3->code;	
												$acc_tran_details['code_structure1'][$key1]['code_structure2'][$key2]['code_structure3'][$key3]['value']=$record3->value;
												$acc_tran_details['code_structure1'][$key1]['code_structure2'][$key2]['code_structure3'][$key3]['code_type_id']=$record3->code_type_id;				
												$acc_tran_details['code_structure1'][$key1]['code_structure2'][$key2]['code_structure3'][$key3]['code_main_id']=$record3->code_main_id;			
												$acc_tran_details['code_structure1'][$key1]['code_structure2'][$key2]['code_structure3'][$key3]['active_inactive']=$record3->active_inactive;	
												$acc_tran_details['code_structure1'][$key1]['code_structure2'][$key2]['code_structure3'][$key3]['startdate']=$record3->startdate;	
												$acc_tran_details['code_structure1'][$key1]['code_structure2'][$key2]['code_structure3'][$key3]['enddate']=$record3->enddate;			
												$acc_tran_details['code_structure1'][$key1]['code_structure2'][$key2]['code_structure3'][$key3]['description']=$record3->description;	
											}	


								}



	
								//$arraindx=$arraindx+1;
							}
						}
				
						array_push($output,$acc_tran_details);
						header('Access-Control-Allow-Origin: *');
						header("Content-Type: application/json");
						echo json_encode($output);
			}

			
		

	}

	
	public function chart_of_accounts($datatype='',$cond=0)
	{
	
		$output=array();

			if($datatype=='SAVE')
			{
				$id_header=$id_detail='';
				$data=$return_data=$save_details=$save_hdr=array();				
				$RAW_DATA=file_get_contents("php://input");
				$form_data=json_decode(file_get_contents("php://input"));
				$json_array_count=sizeof($form_data);

							
				$id_header=$form_data[0]->id_header;			

				$count=sizeof($form_data[0]->list_of_values);		
				for($cnt=0;$cnt<=$count-1;$cnt++)
				{			
						$id_detail=$form_data[0]->list_of_values[$cnt]->id_detail;
						$save_details['parent_id']=$id_header;					
						$save_details['value']=$form_data[0]->list_of_values[$cnt]->FieldVal;
						$save_details['code']=$form_data[0]->list_of_values[$cnt]->code;	
						$save_details['active_inactive']=$form_data[0]->list_of_values[$cnt]->active_inactive;			
						$save_details['startdate']=$form_data[0]->list_of_values[$cnt]->startdate;
						$save_details['enddate']=$form_data[0]->list_of_values[$cnt]->enddate;			
						$this->projectmodel->save_records_model($id_detail,'tbl_chart_of_accounts',$save_details);						
							
				}

				$return_data['id_header']=$id_header;
				
				header('Access-Control-Allow-Origin: *');
				header("Content-Type: application/json");
				echo json_encode($return_data);

			}


			if($datatype=='VIEWALLVALUE')
			{
							
					$acc_tran_details['id_header']=$cond;

					//delete array elements				
					// for($bil=0;$bil<=300-1;$bil++)
					// {unset($acc_tran_details['list_of_values'][$bil]);}
					
						$arraindx=0;
						$acc_tran_details['list_of_values'][$arraindx]['id_detail']='';
						$acc_tran_details['list_of_values'][$arraindx]['FieldVal']=0;				
						$acc_tran_details['list_of_values'][$arraindx]['code']='';								
						$acc_tran_details['list_of_values'][$arraindx]['code_main_id']='';
						$acc_tran_details['list_of_values'][$arraindx]['active_inactive']='';		
						$acc_tran_details['list_of_values'][$arraindx]['startdate']='';	
						$acc_tran_details['list_of_values'][$arraindx]['enddate']='';	
					
						if($cond>0)
						{
							$sql_bills="select * from  tbl_chart_of_accounts  where parent_id=".$cond." ORDER BY id";					
							$sql_bills = $this->projectmodel->get_records_from_sql($sql_bills);	
							foreach ($sql_bills as $sql_bill)
							{				
								$acc_tran_details['list_of_values'][$arraindx]['id_detail']=$sql_bill->id;
								$acc_tran_details['list_of_values'][$arraindx]['FieldVal']=$sql_bill->value;		
								$acc_tran_details['list_of_values'][$arraindx]['code']=$sql_bill->code;
								$acc_tran_details['list_of_values'][$arraindx]['active_inactive']=$sql_bill->active_inactive;
								$acc_tran_details['list_of_values'][$arraindx]['startdate']=$sql_bill->startdate;
								$acc_tran_details['list_of_values'][$arraindx]['enddate']=$sql_bill->enddate;
	
								$arraindx=$arraindx+1;
							}
						}
				
						array_push($output,$acc_tran_details);
						header('Access-Control-Allow-Origin: *');
						header("Content-Type: application/json");
						echo json_encode($output);
			}		
		

	}




public function treeview($parent_id=0,$treetype='LEGAL_ENTITY')
{
	
			$mainindx=0;
			$final=	$data=$output=array();

			$data['legal_unit_name']='Tree View';
			$data['op_unit_name']='';

			$data['treetype']=$treetype;
			if($treetype=='LEGAL_ENTITY')
			{
				
					$rsval=$this->tree_view_legal_entity($parent_id);
				
					$JSON = json_encode(array_values($rsval));
					$jsonIterator = new RecursiveIteratorIterator(
					new RecursiveArrayIterator(json_decode($JSON, TRUE)),
					RecursiveIteratorIterator::SELF_FIRST);
					$mainindx=0;
					foreach ($jsonIterator as $key => $val) 
					{
						
						if(!is_array($val) ) 
						{
						
								if($key == "id") {$output[$mainindx][$key]=$val;}
								if($key == "index") {$output[$mainindx][$key]=$val;}
								if($key == "parent_id"){$output[$mainindx][$key]=$val;}
								if($key == "company_type"){$output[$mainindx][$key]=$val;}								
								if($key == "name") {$output[$mainindx][$key]=$val;$mainindx=$mainindx+1;}	
						}			
					}

			}

			if($treetype=='OPERATION_ENTITY')
			{
				$whr="id=".$parent_id." ";
				$data['legal_unit_name']=$this->projectmodel->GetSingleVal('NAME','company_details',$whr);
				
					$whr="company_details_id=".$parent_id." and under_tbl_hierarchy_org=0";
					 $opid=$this->projectmodel->GetSingleVal('id','tbl_hierarchy_org',$whr);
					if($opid==''){$opid=-1;}

					$whr="id=".$opid." ";
					$data['op_unit_name']=$this->projectmodel->GetSingleVal('hierarchy_name','tbl_hierarchy_org',$whr);

						$rsval=$this->tree_view_operation_entity($opid);
				
						$JSON = json_encode(array_values($rsval));
						$jsonIterator = new RecursiveIteratorIterator(
						new RecursiveArrayIterator(json_decode($JSON, TRUE)),
						RecursiveIteratorIterator::SELF_FIRST);
						$mainindx=0;
						foreach ($jsonIterator as $key => $val) 
						{
							
							if(!is_array($val) ) 
							{
							
									if($key == "id") {$output[$mainindx][$key]=$val;}
									if($key == "index") {$output[$mainindx][$key]=$val;}
									if($key == "parent_id"){$output[$mainindx][$key]=$val;}
									if($key == "name") {$output[$mainindx][$key]=$val;$mainindx=$mainindx+1;}	
							}			
						}

			}
			if($treetype=='LOCATION_TREE')
			{
				
					$rsval=$this->tree_view_location($parent_id);
				
					$JSON = json_encode(array_values($rsval));
					$jsonIterator = new RecursiveIteratorIterator(
					new RecursiveArrayIterator(json_decode($JSON, TRUE)),
					RecursiveIteratorIterator::SELF_FIRST);
					$mainindx=0;
					foreach ($jsonIterator as $key => $val) 
					{
						
						if(!is_array($val) ) 
						{
						
								if($key == "id") {$output[$mainindx][$key]=$val;}
								if($key == "index") {$output[$mainindx][$key]=$val;}
								if($key == "parent_id"){$output[$mainindx][$key]=$val;}
								if($key == "location_type"){$output[$mainindx][$key]=$val;}								
								if($key == "name") {$output[$mainindx][$key]=$val;$mainindx=$mainindx+1;}	
						}			
					}

			}

			
			
			$output[0]['parent_id']='';

		
			
			// echo '<pre>';
			// print_r($output);
			// echo '</pre>';
			

		$data['treeview_array']=$output;

	 $view_path_name='projectview/treeview';
	 $this->report_page_layout_display($view_path_name,$data);

}

//COMPANY TREE VIEW

function tree_view_legal_entity($parent_id=0,$index=0)
	{
			$output=array();
			$records="select * FROM company_details where  parent_id=".$parent_id;						
			$records = $this->projectmodel->get_records_from_sql($records);	
			foreach ($records as $record)
			{								
				$sub_array=array();
				$sub_array['index']=$index;
				$sub_array['id']=$record->id;
				$sub_array['parent_id']=$record->parent_id;
				$sub_array['company_type']=$this->projectmodel->GetSingleVal('FieldVal','frmrptgeneralmaster','id='.$record->company_type); 
				$sub_array['name']=$record->NAME;	
				$sub_array['nodes']=array_values($this->tree_view_legal_entity($record->id,$index+1));		
				$output[]=$sub_array;
			}

			return $output;
	}

	function tree_view_operation_entity($parent_id=0,$index=0)
	{
			$output=array();
			$records="select * FROM tbl_hierarchy_org where  under_tbl_hierarchy_org=".$parent_id;						
			$records = $this->projectmodel->get_records_from_sql($records);	
			foreach ($records as $record)
			{								
				$sub_array=array();
				$sub_array['index']=$index;
				$sub_array['id']=$record->id;
				$sub_array['parent_id']=$record->under_tbl_hierarchy_org;
				$sub_array['name']=$record->hierarchy_name;	
				$sub_array['nodes']=array_values($this->tree_view_operation_entity($record->id,$index+1));		
				$output[]=$sub_array;
			}

			return $output;
	}


	

// COMPANY TREE VIEW


public function OrganisationStructure($frmrpttemplatehdrID=2,$operation='',$id_header='',$id_detail='')
 {	
			
			$this->login_validate();
			//DATA GRID SECTION
			//echo 'test 33333...................................'.$operation;
			 $data['id']=$id_header;	
			 if($frmrpttemplatehdrID==14) //Retailer  Mastet
			 {$data['GridHeader']=   array("SysId#-left","DesigNation-left", "Hierarchy Name-left", "Under Position-left", "Employee-left");}
			
			$data['frmrpttemplatehdrID']=$frmrpttemplatehdrID;
			

			$records="select * from frmrpttemplatehdr where id=".$frmrpttemplatehdrID;
			$records = $this->projectmodel->get_records_from_sql($records);	
			foreach ($records as $record)
			{	
				 $data['DisplayGrid']=$record->DisplayGrid;
				 $data['NEWENTRYBUTTON']=$record->NEWENTRYBUTTON;
				 
				 $data['FormRptName']=$record->FormRptName;
				 $data['DataFields']=$record->DataFields;
				 $data['TableName']=$record->TableName;
				 $data['WhereCondition']=$record->WhereCondition;
				 $data['OrderBy']=$record->OrderBy;	
				 $ControllerFunctionLink=
				 $record->ControllerFunctionLink.$frmrpttemplatehdrID.'/';	 
				 $data['tran_link'] = ADMIN_BASE_URL.$ControllerFunctionLink; 
				 $view_path_name=$record->ViewPath; 
				 $data['body']=$this->projectmodel->Activequery($data,'LIST');
			}
			
			//echo 'test.........444444..........................'.$operation;

			if($operation=="save" )
		    {
						//HEADER SECTION
						$records="select * from frmrpttemplatedetails 
						where frmrpttemplatehdrID=".$frmrpttemplatehdrID."
						and SectionType='HEADER' order by Section ";
						$records = $this->projectmodel->get_records_from_sql($records);	
						foreach ($records as $record)
						{		
							$id_header=$this->input->post('id');
							$save_hdr[$record->InputName]=
							$this->input->post(trim($record->InputName));
							$tran_table_name=$record->tran_table_name;
									
						}
						
						$teritory_list=$save_hdr['teritory_list'];							
						$save_hdr['teritory_list']='0';				
						if (count($teritory_list) > 0) {
						for ($i=0;$i<count($teritory_list);$i++) {
						if($teritory_list[$i]>0)
						{
						$save_hdr['teritory_list']=$save_hdr['teritory_list'].','.
						$teritory_list[$i];
						}
						
						}} 	
						
						$save_hdr['teritory_list']=substr($save_hdr['teritory_list'],2);
								
						if($id_header==0) 
						{					
							if($data['NEWENTRYBUTTON']=='YES')
							{
								$this->projectmodel->save_records_model($id_header,$tran_table_name,$save_hdr);
								$id_header=$this->db->insert_id();
							}
						}	
						
						if($id_header>0)// update data....
						{$this->projectmodel->save_records_model($id_header,$tran_table_name,$save_hdr);}
						
						//UPDATE PARENT
						
						$query ="update  tbl_hierarchy_org set under_tbl_hierarchy_org=0 
						where under_tbl_hierarchy_org=".$id_header; 
						$this->db->query($query);
					
						$teritory_list=$save_hdr['teritory_list'];							
						$teritory_list = explode(",",$teritory_list);	
						foreach($teritory_list as $teritory)
						{
							if($teritory>0)
							{
								$save_parent['under_tbl_hierarchy_org']=$id_header;
								$this->projectmodel->save_records_model($teritory,$tran_table_name,$save_parent);
							}
						}
				

						//hierarchy
						
						$query ="update  tbl_hierarchy_org set employee_id=0 where tbl_designation_id=6"; 
						
						$this->db->query($query);
						//ORGANISATION CHAIN SECTION			
						$query ="delete from tbl_organisation_chain"; 
						$this->db->query($query);
						
						$sql="select * from tbl_hierarchy_org order by tbl_designation_id,id";
						$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
						foreach ($rowrecord as $row1)
						{
						$lastid=$row1->id;
						//if($lastid==6085){
						$this->create_chain($lastid,$row1->tbl_designation_id,'create');
						//} //
						}
									
						$query ="DELETE FROM tbl_organisation_chain where  	parentuid=0"; 
						$this->db->query($query);
						
						$query ="DELETE FROM tbl_organisation_chain where  	parentuid=childuid"; 
						$this->db->query($query);
						
						$this->comp_struc_model->update_teritory();		

						//HEADER SECTION END 
						//redirect($ControllerFunctionLink.'addeditview/'.$id_header.'/0/');
						redirect($ControllerFunctionLink.'list/0/0/');
			}

		

		if($operation=="hierarchy" )
		    {	
			
				$query ="update  tbl_hierarchy_org set employee_id=0 where tbl_designation_id=6"; 
				
				$this->db->query($query);
				//ORGANISATION CHAIN SECTION			
				$query ="delete from tbl_organisation_chain"; 
				$this->db->query($query);
				
				$sql="select * from tbl_hierarchy_org order by tbl_designation_id,id";
				$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
				foreach ($rowrecord as $row1)
				{
				$lastid=$row1->id;				
				$this->create_chain($lastid,$row1->tbl_designation_id,'create');				
				}
							
				$query ="DELETE FROM tbl_organisation_chain where  	parentuid=0"; 
				$this->db->query($query);
				
				$query ="DELETE FROM tbl_organisation_chain where  	parentuid=childuid"; 
				$this->db->query($query);
					
				$this->comp_struc_model->update_teritory();		
				redirect($ControllerFunctionLink.'list/0/0/');
			}
				
		$view_path_name=$view_path_name;
	   $this->page_layout_display($view_path_name,$data);   
	  
		
}	

private function create_chain($id,$desigs,$status,$curparentid=0)
{	
	if($status=='create')// CREATE ..END
	{
			$lastid=$id;	
			$sql_clnt5="select * from tbl_hierarchy_org where id=".$lastid." " ;
			//echo '<br>';
			$rowrecord = $this->projectmodel->get_records_from_sql($sql_clnt5);	
			foreach ($rowrecord as $row1){  
			$parentid=$row1->under_tbl_hierarchy_org;
			$childid=$lastid;
			$desinsrl=$row1->tbl_designation_id;
			$mssrlds=$desinsrl;
			}
			//559,550,542,543,544,545,546,547,551,552,568,569,570,539,540,541
			//for($i=1;$i<=$mssrlds;$i++)
			$i=17;
			$records="select max(srlno) maxsrl from tbl_designation " ;
			$records = $this->projectmodel->get_records_from_sql($records);	
			foreach ($records as $record){ $i=$record->maxsrl; }
			

			for($i=1;$i<=17;$i++)
			
			//for($i=1;$i<=6;$i++)
			{
				if($parentid!="")
				{ 
					$sql="insert into tbl_organisation_chain(id,parentuid,childuid,child_desig_srl) 
					values(null,".$parentid.",".$childid.",".$mssrlds.")";
					$this->db->query($sql);		
					
					$sql_clnt5="select * from tbl_hierarchy_org where id=".$parentid." " ;
					$rowrecord = $this->projectmodel->get_records_from_sql($sql_clnt5);	
					foreach ($rowrecord as $row1)
					{  
						$hierarchy_name=$row1->hierarchy_name;
						$parentid=$row1->under_tbl_hierarchy_org;
						$desinsrl=$row1->tbl_designation_id;
					}
					//echo $hierarchy_name.' parent :'.$parentid.' desig'.$mssrlds.'<br>';
				}
				
			}
			
	} // CREATE ..END
	
} 
	

public function TempleteForm($frmrpttemplatehdrID=2,$operation='',$id_header='',$id_detail='')
{
		//DATA GRID SECTION
		 $data['id']=$id_header;	
		 $data['OPERATION'] ='ADD_EDIT_DELETE';
		$fromdate=$todate=$data['fromdate']= $data['todate']= date('Y-m-d');
		 
		if($frmrpttemplatehdrID==8) //COMPANY Mastet
		{
			$data['GridHeader']=array("SysId#-left", "NAME-left","ADDRESS-left");
			$data['OPERATION'] =$this->projectmodel->priviledge_value(32);		
		}

		if($frmrpttemplatehdrID==27) //LOCATION MASTER
		{
			$data['GridHeader']=array("SysId#-left", "Name-left","Type-left");
			$data['OPERATION'] =$this->projectmodel->priviledge_value(33);	
		} 	

		if($frmrpttemplatehdrID==10) //USER  Mastet
		{	
			$data['GridHeader']=array("SysId#-left","Name-left","UserID-left","Status-left");
			$data['OPERATION'] =$this->projectmodel->priviledge_value(34);	
		}

		if($frmrpttemplatehdrID==14) //operation unit
		 {
			 $data['GridHeader']=array("SysId#-left", "Unit name-left");
			 $data['OPERATION'] =$this->projectmodel->priviledge_value(35);
			}
		
		 if($frmrpttemplatehdrID==7) //General Mastet
		 {	
		   $data['GridHeader']=array("SysId#-left", "FieldID-left","FieldVal-left","Status-left");
		 }		 
		
		 if($frmrpttemplatehdrID==28) //software architecture
		 {$data['GridHeader']=array("SysId#-left", "Name-left","Status-left","Data Type-left");}

		 if($frmrpttemplatehdrID==29) //menu manage
		 {$data['GridHeader']=array("SysId#-left", "Name-left","Parent-left","Status-left");}
		
		 if($frmrpttemplatehdrID==30) //Roll manage
		 {$data['GridHeader']=array("SysId#-left", "Roll Name-left","Status-left");}

		 if($frmrpttemplatehdrID==31) //currenciew
		 {$data['GridHeader']=array("SysId#-left", "Code-left","Name-left");}

		 if($frmrpttemplatehdrID==32) //Period Type
		 {$data['GridHeader']=array("SysId#-left", "Period Type-left");}

		 if($frmrpttemplatehdrID==33) 
		 {$data['GridHeader']=array("SysId#-left", "Country-left","Bank Name-left","Alternate Bank Name-left");}

		 if($frmrpttemplatehdrID==35) //customer
		 {$data['GridHeader']=array("SysId#-left", "Customer Name-left","Billing Name-left","Credit Limit-left");}

		 if($frmrpttemplatehdrID==36) //Employee Setup
		 {$data['GridHeader']=array("SysId#-left", "F-Name-left","L-Name-left","Address-left","Contact No-left");}

		 if($frmrpttemplatehdrID==37) //Product Setup
		 {$data['GridHeader']=array("SysId#-left", "Name-left","Description-left","Status-left");}

		 if($frmrpttemplatehdrID==38) //Supplier Setup
		 {$data['GridHeader']=array("SysId#-left", "Name-left","Address-left","Contact No-left");}

		 if($frmrpttemplatehdrID==40) //Account Setup
		 {$data['GridHeader']=array("SysId#-left", "Name-left");}

		
		 if($frmrpttemplatehdrID==21) //ACCOUNT GROUP
		 {$data['GridHeader']=array("SysId#-left", "Code-left","A/c name-left","Under A/c-left","temp_debit_balance-right","temp_credit_balance-right");}
		 
		 if($frmrpttemplatehdrID==22) //ACCOUNT LEDGER
		 {$data['GridHeader']=array("SysId#-left", "Code-left","A/c name-left","Under A/c-left");}
		
		 if($frmrpttemplatehdrID==25) //QUERY BUILDER    id,FormRptName,query_name
		 {$data['GridHeader']=array("SysId#-left", "FormRptName-left","query_name-left");}
		
		
		
		
		if($operation=="TRANEDIT" )
		{		
			$fromdate=$data['fromdate']=$this->input->post('fromdate');
			$todate= $data['todate']=$this->input->post('todate');		
		}
				
		
		$data['frmrpttemplatehdrID']=$frmrpttemplatehdrID;		
		$records="select * from frmrpttemplatehdr where id=".$frmrpttemplatehdrID;
		$records = $this->projectmodel->get_records_from_sql($records);	
		foreach ($records as $record)
		{	
			 $data['DisplayGrid']=$record->DisplayGrid;
			 $data['NEWENTRYBUTTON']=$record->NEWENTRYBUTTON;
			 
			 $data['FormRptName']=$record->FormRptName;
			 $data['DataFields']=$record->DataFields;
			 $data['TableName']=$record->TableName;
			 $data['WhereCondition']=$record->WhereCondition;
			 
			//  if($frmrpttemplatehdrID==21) //OTC SCHEME
			//  {$data['WhereCondition']=$data['WhereCondition']." and month_year_date between '$fromdate' and '$todate' ";}


			 if($frmrpttemplatehdrID==12) //RETAILER LIST
			 {
				
				if($this->session->userdata('HIERARCHY_STATUS')=='NORMAL_USER')
				{$empid=$this->session->userdata('login_emp_id');}
				
				if($this->session->userdata('HIERARCHY_STATUS')=='SUPERUSER')
				{$empid=$this->session->userdata('billing_emp_id');}
				
				$Whr=' employee_id='.$empid;
				$parentid=$this->projectmodel->GetSingleVal('id','tbl_hierarchy_org',$Whr);
				$fieldlist=$this->projectmodel->gethierarchy_list($parentid,'FIELD');

				$data['WhereCondition']=$data['WhereCondition']." and retail_field 	in (".$fieldlist.")  ";
				
				
				}


						 
			 $data['OrderBy']=$record->OrderBy;	
			 $ControllerFunctionLink=$record->ControllerFunctionLink.$frmrpttemplatehdrID.'/';	 
			 $data['tran_link'] = ADMIN_BASE_URL.$ControllerFunctionLink; 
			 $view_path_name=$record->ViewPath; 
			 $data['body']=$this->projectmodel->Activequery($data,'LIST');
		}
		
				
		if($operation=="save" )
		{
			//HEADER SECTION
			$records="select * from frmrpttemplatedetails 
			where frmrpttemplatehdrID=".$frmrpttemplatehdrID."
			 and SectionType='HEADER' order by Section ";
			$records = $this->projectmodel->get_records_from_sql($records);	
			foreach ($records as $record)
			{		
			 $id_header=$this->input->post('id');
			//echo $record->InputName.'<br>';
			 $save_hdr[$record->InputName]=$this->input->post(trim($record->InputName));
			 $tran_table_name=$record->tran_table_name;
			}
					
			
						
			if($id_header==0) 
			{					
				if($data['NEWENTRYBUTTON']=='YES'){
				
					$this->projectmodel->save_records_model($id_header,
					$tran_table_name,$save_hdr);
					$id_header=$this->db->insert_id();
				}
				
			}	
			
			if($id_header>0)// update data....
			{
				$this->projectmodel->save_records_model($id_header,
				$tran_table_name,$save_hdr);
			}
			
			if($frmrpttemplatehdrID==24) //General Mastet
		 	{$this->accounts_model->ledger_master_create('tbl_party',$id_header,27,'SUNDRY_CREDITORS');}
			
			
		
			
			//HEADER SECTION END 
			//redirect($ControllerFunctionLink.'addeditview/'.$id_header.'/0/');
			redirect($ControllerFunctionLink.'addeditview/0/0/');
		}
				
		   
	   $view_path_name=$view_path_name;
	   $this->page_layout_display($view_path_name,$data);

}



public function TempleteFormReport($displaytype='',$id_header='',$id_detail='')
{

		$data['tran_link'] = ADMIN_BASE_URL.'Project_controller/TempleteFormReport/'; 
		$view_path_name='ActiveReport/TemplateFormRptMaster';	
		$sqlinv="select * from  frmrpttemplatehdr  order by  FormRptName ";		
		$data['projectlist'] =$this->projectmodel->get_records_from_sql($sqlinv);
		$data['MainTable'] =$data['tran_table_name']='';
		
				
		if($displaytype=="list")
		{
			//HEADER TABLE
			$data['id_header']=0;
			$data['id_detail']=0;
			$data['parent_id']=0;
			
			$data['NEWENTRYBUTTON']=$data['DisplayGrid']='';
			$data['FormRptName']=$data['Type']='';

			$data['GridHeader_name']=$data['DataFields_name']='';
			$data['DataFields2_name']=$data['DataFields3_name']=$data['DataFields4_name']='';

			$data['GridHeader']=$data['DataFields']='';
			$data['DataFields2']=$data['DataFields3']=$data['DataFields4']='';
			$data['TableName']=$data['WhereCondition']='';
			$data['OrderBy']=$data['ControllerFunctionLink']='';
			$data['child_ids']=$data['ViewPath']=$data['parent_table_field_name']=
			$data['child_table_field_name']='';
			
			
			//DETAIL TABLE
			$data['frmrpttemplatehdrID']=0;
			$data['InputName']=$data['InputType']=$data['Inputvalue']='';
			$data['LogoType']=$data['RecordSet']=$data['LabelName']='';
			$data['DIVClass']=$data['Section']='';
			$data['validation_type']=146;
		}
		
		
		if($displaytype=='addeditview')
		{
			//HEADER TABLE
			$data['id_header']=0;
			$data['id_detail']=0;
			$data['parent_id']=0;
			$data['NEWENTRYBUTTON']=$data['DisplayGrid']='';
			$data['FormRptName']=$data['Type']='';

			$data['GridHeader_name']=$data['DataFields_name']='';
			$data['DataFields2_name']=$data['DataFields3_name']=$data['DataFields4_name']='';
			$data['GridHeader']=$data['DataFields']='';
			$data['DataFields2']=$data['DataFields3']=$data['DataFields4']='';
			$data['TableName']=$data['WhereCondition']='';
			$data['OrderBy']=$data['ControllerFunctionLink']='';
			$data['child_ids']=$data['ViewPath']=$data['parent_table_field_name']=$data['child_table_field_name']='';
			
			//DETAIL TABLE
			$data['frmrpttemplatehdrID']=0;
			$data['InputName']=$data['InputType']=$data['Inputvalue']='';
			$data['LogoType']=$data['RecordSet']=$data['LabelName']='';
			$data['DIVClass']=$data['Section']='';
			$data['validation_type']=146;
			$data['tran_table_name']='';
			  
					$maxhdrid=0;
					$sqlinv="select max(id) maxhdrid from  frmrpttemplatedetails 		where  	frmrpttemplatehdrID=".$id_header;
					$rows =$this->projectmodel->get_records_from_sql($sqlinv);	
					foreach ($rows as $row)
					{ $maxhdrid=$row->maxhdrid;}
				
				 if($maxhdrid>0)
			   	{	
				   $sqlinv="select * from  frmrpttemplatedetails 
					where  	id=".$maxhdrid;
					$rows =$this->projectmodel->get_records_from_sql($sqlinv);	
					foreach ($rows as $row)
					{ 
					$data['tran_table_name']=$row->tran_table_name;
					$data['MainTable']=$row->MainTable;
					}
				}
				
				//tran header
				$sqlinv="select * from  frmrpttemplatehdr where id=".$id_header;
				$rows =$this->projectmodel->get_records_from_sql($sqlinv);	
				foreach ($rows as $row)
				{ 	
					$data['id_header']=$id_header;
					$data['Type']=$row->Type;
					$data['FormRptName']=$row->FormRptName;

					$data['GridHeader_name']=$row->GridHeader_name;
					$data['DataFields_name']=$row->DataFields_name;
					$data['DataFields2_name']=$row->DataFields2_name;
					$data['DataFields3_name']=$row->DataFields3_name;
					$data['DataFields4_name']=$row->DataFields4_name;

					$data['GridHeader']=$row->GridHeader;
					$data['DataFields']=$row->DataFields;
					$data['DataFields2']=$row->DataFields2;
					$data['DataFields3']=$row->DataFields3;
					$data['DataFields4']=$row->DataFields4;;
					$data['TableName']=$row->TableName;
					$data['WhereCondition']=$row->WhereCondition;
					$data['OrderBy']=$row->OrderBy;
					$data['ControllerFunctionLink']=$row->ControllerFunctionLink;
					$data['ViewPath']=$row->ViewPath;
					$data['NEWENTRYBUTTON']=$row->NEWENTRYBUTTON;
					$data['DisplayGrid']=$row->DisplayGrid;
					$data['parent_id']=$row->parent_id;
					$data['parent_table_field_name']=$row->parent_table_field_name;
					$data['child_table_field_name']=$row->child_table_field_name;
					$data['child_ids']=$row->child_ids;
				}
		}	
		
		
		if(isset($_POST) and $displaytype=='save')
		{
			
			//HEADER ENTRY part
			
			$save_hdr['FormRptName']=$this->input->post('FormRptName');;
			$save_hdr['Type']=$this->input->post('Type');


			$save_hdr['GridHeader_name']=$this->input->post('GridHeader_name');
			$save_hdr['DataFields_name']=$this->input->post('DataFields_name');
			$save_hdr['DataFields2_name']=$this->input->post('DataFields2_name');
			$save_hdr['DataFields3_name']=$this->input->post('DataFields3_name');
			$save_hdr['DataFields4_name']=$this->input->post('DataFields4_name');
			
			$save_hdr['GridHeader']=$this->input->post('GridHeader');
			$save_hdr['DataFields']=$this->input->post('DataFields');
			$save_hdr['DataFields2']=$this->input->post('DataFields2');
			$save_hdr['DataFields3']=$this->input->post('DataFields3');
			$save_hdr['DataFields4']=$this->input->post('DataFields4');

			
			$save_hdr['TableName']=$this->input->post('TableName');
			$save_hdr['WhereCondition']=$this->input->post('WhereCondition');
			$save_hdr['OrderBy']=$this->input->post('OrderBy');
			$save_hdr['ControllerFunctionLink']=$this->input->post('ControllerFunctionLink');
			$save_hdr['ViewPath']=$this->input->post('ViewPath');
			$save_hdr['NEWENTRYBUTTON']=$this->input->post('NEWENTRYBUTTON');
			$save_hdr['DisplayGrid']=$this->input->post('DisplayGrid');

			$save_hdr['parent_id']=$this->input->post('parent_id');
			$save_hdr['parent_table_field_name']=$this->input->post('parent_table_field_name');
			$save_hdr['child_table_field_name']=$this->input->post('child_table_field_name');
			$save_hdr['child_ids']=$this->input->post('child_ids');
			
			if($id_header==0) 
			{					
				$this->projectmodel->save_records_model($id_header,
				'frmrpttemplatehdr',$save_hdr);
				$id_header=$this->db->insert_id();
				$this->session->set_userdata('alert_msg',
				'One Record Inserted Successfully');
			}	
			
			if($id_header>0)// update data....
			{
				$this->projectmodel->save_records_model($id_header,
				'frmrpttemplatehdr',$save_hdr);
				$this->session->set_userdata('alert_msg', 
				'One Record Updated Successfully');						
			}
				
			//DETAIL SECTIONS 
				//ADD SECTION
				$save_dtl['frmrpttemplatehdrID']=$id_header;
				$save_dtl['InputName']=trim($this->input->post('InputName'));
				$save_dtl['InputType']=trim($this->input->post('InputType'));
				$save_dtl['Inputvalue']=trim($this->input->post('Inputvalue'));
				$save_dtl['LabelName']=trim($this->input->post('LabelName'));
				$save_dtl['LogoType']=trim($this->input->post('LogoType'));
				$save_dtl['DIVClass']=trim($this->input->post('DIVClass'));
				$save_dtl['Section']=trim($this->input->post('Section'));
				$save_dtl['tran_table_name']=trim($this->input->post('tran_table_name'));
				
				$save_dtl['FieldOrder']=trim($this->input->post('FieldOrder'));
				$save_dtl['datafields']=trim($this->input->post('datafields'));
				//$save_dtl['table_name']=$this->input->post('table_name');
				//$save_dtl['where_condition']=$this->input->post('where_condition');
				//$save_dtl['orderby']=$this->input->post('orderby');
				$save_dtl['SectionType']=trim($this->input->post('SectionType'));
				$save_dtl['MainTable']=trim($this->input->post('MainTable'));
				$save_dtl['LinkField']=trim($this->input->post('LinkField'));
				$save_dtl['validation_type']=trim($this->input->post('validation_type'));
				
			

				/*$save_dtl['RecordSet']=$this->input->post('RecordSet');*/
												
				if($save_dtl['InputName']<>'')
				{
					$this->projectmodel->save_records_model('',
					'frmrpttemplatedetails',$save_dtl);
				}
				
			//EDIT SECTION	
			$sql="select *  from frmrpttemplatedetails 
			where frmrpttemplatehdrID=".$id_header."  ";
			$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
			foreach ($rowrecord as $row1)
			{ 
				$dtl_id=$row1->id;
				$save_dtl['frmrpttemplatehdrID']=$id_header;
				$save_dtl['InputName']=trim($this->input->post('InputName'.$dtl_id));
				$save_dtl['InputType']=trim($this->input->post('InputType'.$dtl_id));
				$save_dtl['Inputvalue']=trim($this->input->post('Inputvalue'.$dtl_id));
				$save_dtl['LogoType']=trim($this->input->post('LogoType'.$dtl_id));
				$save_dtl['LabelName']=trim($this->input->post('LabelName'.$dtl_id));
				$save_dtl['DIVClass']=trim($this->input->post('DIVClass'.$dtl_id));
				$save_dtl['Section']=trim($this->input->post('Section'.$dtl_id));
				$save_dtl['tran_table_name']=trim($this->input->post('tran_table_name'.$dtl_id));
				
				$save_dtl['FieldOrder']=trim($this->input->post('FieldOrder'.$dtl_id));
				$save_dtl['datafields']=trim($this->input->post('datafields'.$dtl_id));
				$save_dtl['table_name']=trim($this->input->post('table_name'.$dtl_id));
				$save_dtl['where_condition']=trim($this->input->post('where_condition'.$dtl_id));
				$save_dtl['orderby']=trim($this->input->post('orderby'.$dtl_id));
				$save_dtl['SectionType']=trim($this->input->post('SectionType'.$dtl_id));
				$save_dtl['MainTable']=trim($this->input->post('MainTable'.$dtl_id));
				$save_dtl['LinkField']=trim($this->input->post('LinkField'.$dtl_id));
				$save_dtl['validation_type']=trim($this->input->post('validation_type'.$dtl_id));

			   $data['MainTable'] =$save_dtl['MainTable'];
			   $data['tran_table_name']=$save_dtl['tran_table_name'];
										
				if($save_dtl['InputName']<>'')
				{
				$this->projectmodel->save_records_model($dtl_id,
					'frmrpttemplatedetails',$save_dtl);
				}
			
			}		
				
				redirect('Project_controller/TempleteFormReport/addeditview/'.
				$id_header.'/0/');
		}
		
			
		if($displaytype=='delete')
		{
		$sql="delete from frmrpttemplatedetails  where id=".$id_detail;
		$this->db->query($sql);
		redirect('Project_controller/TempleteFormReport/addeditview/'.
				$id_header.'/0/');
		}
		
		if($displaytype=='deleteAll')
		{
			$sql="delete from  frmrpttemplatedetails 
			 where frmrpttemplatehdrID=".$id_header;
			$this->db->query($sql);	
			$this->session->set_userdata('alert_msg','Deleted!');
					
			$sql="delete from  frmrpttemplatehdr  where id=".$id_header;
			$this->db->query($sql);	
		    redirect('Project_controller/TempleteFormReport/list/0/0/');
		}

		if($displaytype=='copy_create')
		{
			

			$sql="insert into frmrpttemplatehdr(parent_id,section_order,parent_table_field_name,child_table_field_name,child_ids,FormRptName,Type,GridHeader,DataFields,DataFields2,DataFields3,DataFields4,TableName,WhereCondition,OrderBy,ControllerFunctionLink,ViewPath,DisplayGrid,NEWENTRYBUTTON) 

			select parent_id,section_order,parent_table_field_name,child_table_field_name,child_ids,FormRptName,Type,GridHeader,DataFields,DataFields2,DataFields3,DataFields4,TableName,WhereCondition,OrderBy,ControllerFunctionLink,ViewPath,DisplayGrid,NEWENTRYBUTTON from  frmrpttemplatehdr where id=".$id_header;
			$this->db->query($sql);	
			$id_header_copy=$this->db->insert_id();

						
			$records="select *  from frmrpttemplatedetails 	where frmrpttemplatehdrID=".$id_header."  ";
			$records = $this->projectmodel->get_records_from_sql($records);	
			foreach ($records as $record)
			{ 
				
				$save_dtl['frmrpttemplatehdrID']=$id_header_copy;
				$save_dtl['InputName']=$record->InputName;
				$save_dtl['InputType']=$record->InputType;
				$save_dtl['Inputvalue']=$record->Inputvalue;
				$save_dtl['LogoType']=$record->LogoType;
				$save_dtl['LabelName']=$record->LabelName;
				$save_dtl['DIVClass']=$record->DIVClass;
				$save_dtl['Section']=$record->Section;
				$save_dtl['tran_table_name']=$record->tran_table_name;
				
				$save_dtl['FieldOrder']=$record->FieldOrder;;
				$save_dtl['datafields']=$record->datafields;;
				$save_dtl['table_name']=$record->table_name;;
				$save_dtl['where_condition']=$record->where_condition;;
				$save_dtl['orderby']=$record->orderby;;
				$save_dtl['SectionType']=$record->SectionType;;
				$save_dtl['MainTable']=$record->MainTable;;
				$save_dtl['LinkField']=$record->LinkField;;
				$save_dtl['validation_type']=$record->validation_type;

				$this->projectmodel->save_records_model('','frmrpttemplatedetails',$save_dtl);
			
			}	


			$this->session->set_userdata('alert_msg','Created!');

		    redirect('Project_controller/TempleteFormReport/list/'.$id_header_copy.'/0/');
		}

		
		$this->page_layout_display($view_path_name,$data);
		
		
}

public function TemplateReports($reportname,$operation='view')
{
       $data['parameters']='NO';
	   $data['excelpdfimage']='YES';
	   
	   if($reportname=='Products')
	   {
			$data['reportname']=$reportname;
			$data['parameters']='NO';
			$data['reportfooter']='NO';
			
			//REPORT PARAMETER
			$Inputvalue='';$RecordSet='';
			$InputType='text';$LogoType='fa-edit';$InputName='fromdate';
			$LabelName='From Date';
			$data['fromdate']=
			 $this->projectmodel->create_field($InputType,$LogoType,
			 $LabelName,$InputName,$Inputvalue,$RecordSet);
			
			 $InputType='text';$LogoType='fa-edit';$InputName='todate';
			$LabelName='To Date';
			$data['todate']=
			 $this->projectmodel->create_field($InputType,$LogoType,
			 $LabelName,$InputName,$Inputvalue,$RecordSet);
			
			
			/*$InputType='SingleSelect';$LogoType='fa-edit';$InputName='todate';
			$LabelName='To Date';
			$data['todate']=
			 $this->general_library->create_field($InputType,$LogoType,
			 $LabelName,$InputName,$Inputvalue,$RecordSet);*/
			 
			
			 
		  //LIST HEADER
		   $data['header']= 
		   array("SysId#-left", "Product Name-left", "Order No-right","S.Rate-right");
		   
		   //LIST BODY
		  $data['datafields']='id,brand_name,orderno,pkg1_srate';
		  $data['table_name']='brands';	 
		  $data['where_condition']="id>0 and brandtype='BRAND' ";
		  $data['orderby']="brand_name ASC ";
		  $data['body']=$this->projectmodel->Activequery($data,'LIST');
		 
			//LIST FOOTER		
			
			/*$data['datafields']='RTKM';
			$sumval=$this->projectmodel->Activequery($data,'SUM');
			foreach($sumval as $key =>$value){$data['footer_RTKM']= $sumval[$key]->RTKM;}*/
				
		}
		   
	   $view_path_name='ActiveReportForm/Reports';
	   $this->page_layout_display($view_path_name,$data);
}


	/*LOGIN PROCESS  AND OTHERS...*/	

	public function index($msg='')
	{	
	$layout_data = array();
	$data = array();
	$layout_date['body'] = $this->load->view('login',$data,true);
	$this->load->view('login', $layout_date);
	}
	
	
	private function home()
	{
		$layout_data = array();
		$data = array();
		$layout_data['left_bar'] = $this->load->view('common/left_bar', '', true);
		$layout_data['top_menu'] = $this->load->view('common/top_menu', $data, true);
		$layout_data['data_info'] = $this->load->view('adminindex', $data, true);
		$layout_data['body'] = $this->load->view('common/body', $layout_data, true);
		$this->load->view('layout', $layout_data);
	}
	
	public function logout()
	{
		$this->projectmodel->logout(); 
	}
	
	public function login_process(){
        // Validate the user can login
        $result = $this->projectmodel->validate();
        // Now we verify the result
        if(! $result){
            // If user did not validate, then show them login page again
            $this->index();
        }else{
           
		   $this->dashboard();
        }    
		
				
	}
	
	function changepassword($msg=''){
	
		$layout_data = array();
		$data = array();
		$data['msg'] = $msg;
		//$this->authmod->is_admin_login();
		$data['user_name'] = $this->session->userdata('user_name');
		$layout_data['left_bar'] = $this->load->view('common/left_bar', '', true);
		$layout_data['top_menu'] = $this->load->view('common/top_menu', $data, true);
		$layout_data['data_info'] = $this->load->view('changepass', $data, true);
		$layout_data['body'] = $this->load->view('common/body', $layout_data, true);
		$this->load->view('layout', $layout_data);
	
	}
	
	function changepassword_act()
	{
			$this->form_validation->set_rules('pass1', 'Old Password', 'required');
			$this->form_validation->set_rules('pass2', 'New Password', 'required');
			$this->form_validation->set_rules('pass3', 
			'For Confermation Same New Password is', 'required|matches[pass2]');
			if ($this->form_validation->run())
			{
				$value = $this->input->post();
				if(!$this->projectmodel->update_password($value))
				{
					$this->changepassword("Invalid old password");
				}
			}
			else
			{
				$value = $this->input->post();
				$this->changepassword();
			}		
	}
	private function login_validate()
	{
       if($this->session->userdata('login_userid')=='')
		{ $this->logout();}
			else
	   {
	         $COMP_ID='';
			 $sqlemp="select * from company_details where id=1";
			 $rowrecordemp = $this->projectmodel->get_records_from_sql($sqlemp);	
			 foreach ($rowrecordemp as $rowemp)
			 {$this->session->set_userdata('COMP_ID', $rowemp->COMP_ID);}	
	   }	
	   
    }

	public function dashboard($page='',$msg='')	
	 {
		$this->login_validate();
		$layout_data=array();
		$data=array(); 	
		
		//$this->create_office_calender(date('Y-m-d'));
		
		//INVOICE NO FORMAT CREATE
		$nextfinyrdate=$this->general_library->get_date(date('Y-m-d'),0,0,1);
		
		$data['user_name'] = $this->session->userdata('user_name');
		$layout_data['left_bar'] = $this->load->view('common/left_bar', '', true);
		$layout_data['top_menu'] = $this->load->view('common/top_menu', $data, true);
		$layout_data['data_info'] = $this->load->view('projectview/dashboard',$data, true);
		$layout_data['body'] = $this->load->view('common/body', $layout_data, true);
		$this->load->view('layout', $layout_data);		
	 }
	 
	 public function presentation($page='',$msg='')	
	 {
		$this->login_validate();
		$layout_data=array();
		$data=array();
		$data['user_name'] = $this->session->userdata('user_name');
		$layout_data['left_bar'] = $this->load->view('common/left_bar', '', true);
		$layout_data['top_menu'] = $this->load->view('common/top_menu', $data, true);
		$layout_data['data_info'] = $this->load->view('projectview/presentation',$data, true);
		$layout_data['body'] = $this->load->view('common/body', $layout_data, true);
		$this->load->view('report_layout', $layout_data);		
	 }
	 
	
		
		private function page_layout_display($view_path_name,$data)
		{
				
			$data['user_name'] = $this->session->userdata('user_name');
			$layout_data['left_bar'] = $this->load->view('common/left_bar', '', true);
			$layout_data['top_menu'] = $this->load->view('common/top_menu', $data, true);
			$layout_data['data_info'] = 
			$this->load->view($view_path_name,$data, true);			
			$layout_data['body'] = $this->load->view('common/body', $layout_data, true);
			$this->load->view('layout', $layout_data);
			$this->session->set_userdata('alert_msg', '');	
			
		}

		private function report_page_layout_display($view_path_name,$data)
		{
			$layout_data['data_info'] = 
			$this->load->view($view_path_name,$data, true);			
			$layout_data['body'] = $this->load->view('common/body', $layout_data, true);		 
			$this->load->view('report_layout', $layout_data);
			$this->session->set_userdata('alert_msg', '');	
			
		}

		

	/*LOGIN PROCESS  AND OTHERS...*/	
	
}

?>
