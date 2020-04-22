<?php
class Accounts_model extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
    parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('Form_report_create_model', 'FrmRptModel');
		$this->load->model('Project_model', 'projectmodel');
    }
//Ledger Transaction



		

	function all_mis_report($REPORT_NAME,$param_array)
	{
				$trading_ac_output=$output=$data=$rsval=array();
				$tranlink=ADMIN_BASE_URL.'Accounts_controller/all_mis_reports/';
				//print_r($param_array);
				//echo $param_array['fromdate'].' todate::'.$param_array['todate'];
					$mainindx=0;

					//$fromdate=$param_array['fromdate'];
					//	$todate=$param_array['todate'];


			if($REPORT_NAME=='PTOP_ACCOUNTS')
			{
			
							$req_id=$param_array['ledger_ac'];

							//REQUISITION
							$mainindx=0;	

							$records = "select * from invoice_summary where id=".$req_id ;
							$records = $this->projectmodel->get_records_from_sql($records);
							
							$rsval['header'][$mainindx]['Tran Type']=$records[0]->status;
							$rsval['header'][$mainindx]['Operating Unit']=
							$this->projectmodel->GetSingleVal('hierarchy_name','tbl_hierarchy_org',' id='.$records[0]->req_operating_unit);;
							$rsval['header'][$mainindx]['Date']=$records[0]->req_accounting_date;
							$rsval['header'][$mainindx]['Tran No']=$records[0]->req_number;
							$rsval['header'][$mainindx]['Vendor']=
							$this->projectmodel->GetSingleVal('name','mstr_supplier',' id='.$records[0]->req_supplier);

							$rsval['header'][$mainindx]['Dr Account']='NA';
							$rsval['header'][$mainindx]['Dr Amount']='';

							$rsval['header'][$mainindx]['Cr Account']='NA';
							$rsval['header'][$mainindx]['Cr Amount']='';
							$mainindx=$mainindx+1;		

							//PO ENTRY
							$records = "select * from invoice_summary where parent_id=".$records[0]->id ;
							$records = $this->projectmodel->get_records_from_sql($records);
							
							$rsval['header'][$mainindx]['Tran Type']=$records[0]->status;
							$rsval['header'][$mainindx]['Operating Unit']=
							$this->projectmodel->GetSingleVal('hierarchy_name','tbl_hierarchy_org',' id='.$records[0]->req_operating_unit);
						
							$rsval['header'][$mainindx]['Date']=$records[0]->req_accounting_date;
							$rsval['header'][$mainindx]['Tran No']=$records[0]->req_number;
							$rsval['header'][$mainindx]['Vendor']=
							$this->projectmodel->GetSingleVal('name','mstr_supplier',' id='.$records[0]->req_supplier);

							$rsval['header'][$mainindx]['Dr Account']='NA';
							$rsval['header'][$mainindx]['Dr Amount']='';

							$rsval['header'][$mainindx]['Cr Account']='NA';
							$rsval['header'][$mainindx]['Cr Amount']='';
							$mainindx=$mainindx+1;		

							//GRN ENTRY
							$records = "select * from invoice_summary where parent_id=".$records[0]->id ;
							$records = $this->projectmodel->get_records_from_sql($records);

							$rsval['header'][$mainindx]['Tran Type']=$records[0]->status;
							$rsval['header'][$mainindx]['Operating Unit']=
							$this->projectmodel->GetSingleVal('hierarchy_name','tbl_hierarchy_org',' id='.$records[0]->req_operating_unit);

							$rsval['header'][$mainindx]['Date']=$records[0]->req_accounting_date;
							$rsval['header'][$mainindx]['Tran No']=$records[0]->req_number;
							$rsval['header'][$mainindx]['Vendor']=
							$this->projectmodel->GetSingleVal('name','mstr_supplier',' id='.$records[0]->req_supplier);

							$ledger_tran = "select b.* from acc_tran_header a,acc_tran_details b   
							where a.id=b.acc_tran_header_id and 
							a.tran_table_name='invoice_summary' and a.tran_table_id=".$records[0]->id."  order by b.id" ;
							$ledger_tran = $this->projectmodel->get_records_from_sql($ledger_tran);
							
						//	print_r($ledger_tran);

							$rsval['header'][$mainindx]['Dr Account']=
							$this->projectmodel->GetSingleVal('title','tbl_chart_of_accounts',' id='.$ledger_tran[1]->dr_ledger_account);	
							$rsval['header'][$mainindx]['Dr Amount']=$ledger_tran[1]->amount;

							$rsval['header'][$mainindx]['Cr Account']=
							$this->projectmodel->GetSingleVal('title','tbl_chart_of_accounts',' id='.$ledger_tran[0]->cr_ledger_account);			
							$rsval['header'][$mainindx]['Cr Amount']=$ledger_tran[0]->amount;
							$mainindx=$mainindx+1;		

							//INSPECTION
							$records = "select * from invoice_summary where parent_id=".$records[0]->id ;
							$records = $this->projectmodel->get_records_from_sql($records);

							$rsval['header'][$mainindx]['Tran Type']=$records[0]->status;
							$rsval['header'][$mainindx]['Operating Unit']=
							$this->projectmodel->GetSingleVal('hierarchy_name','tbl_hierarchy_org',' id='.$records[0]->req_operating_unit);

							$rsval['header'][$mainindx]['Date']=$records[0]->req_accounting_date;
							$rsval['header'][$mainindx]['Tran No']=$records[0]->req_number;
							$rsval['header'][$mainindx]['Vendor']=
							$this->projectmodel->GetSingleVal('name','mstr_supplier',' id='.$records[0]->req_supplier);

							$rsval['header'][$mainindx]['Dr Account']='NA';
							$rsval['header'][$mainindx]['Dr Amount']='';

							$rsval['header'][$mainindx]['Cr Account']='NA';
							$rsval['header'][$mainindx]['Cr Amount']='';
							$mainindx=$mainindx+1;
							
							//INVOICE

							$records="select * 	from invoice_summary where	status='PURCHASE_INVOICE' and parent_id=".$req_id ;			
							$records = $this->projectmodel->get_records_from_sql($records);	
						
						// $records = "select * from invoice_summary where status='PURCHASE_INVOICE' and parent_id=".$req_id ;
							// $records = $this->projectmodel->get_records_from_sql($records);
							$invoice_summary_id=$records[0]->id;
							$rsval['header'][$mainindx]['Tran Type']=$records[0]->status;
							$rsval['header'][$mainindx]['Operating Unit']=
							$this->projectmodel->GetSingleVal('hierarchy_name','tbl_hierarchy_org',' id='.$records[0]->req_operating_unit);

							$rsval['header'][$mainindx]['Date']=$records[0]->req_accounting_date;
							$rsval['header'][$mainindx]['Tran No']=$records[0]->req_number;
							$rsval['header'][$mainindx]['Vendor']=
							$this->projectmodel->GetSingleVal('name','mstr_supplier',' id='.$records[0]->req_supplier);

							$rsval['header'][$mainindx]['Dr Account']='NA';
							$rsval['header'][$mainindx]['Dr Amount']='';

							$rsval['header'][$mainindx]['Cr Account']='NA';
							$rsval['header'][$mainindx]['Cr Amount']='';

							$ledger_tran = "select count(*) cnt from acc_tran_header a,acc_tran_details b   
							where a.id=b.acc_tran_header_id and a.tran_table_name='invoice_summary' and a.tran_table_id=".$records[0]->id ;
							$ledger_tran = $this->projectmodel->get_records_from_sql($ledger_tran);

							if($ledger_tran[0]->cnt>0)
							{
								$ledger_tran = "select b.* from acc_tran_header a,acc_tran_details b   
								where a.id=b.acc_tran_header_id 
								and a.tran_table_name='invoice_summary' and a.tran_table_id=".$records[0]->id." order by b.id " ;
								$ledger_tran = $this->projectmodel->get_records_from_sql($ledger_tran);

								$rsval['header'][$mainindx]['Dr Account']=
								$this->projectmodel->GetSingleVal('title','tbl_chart_of_accounts',' id='.$ledger_tran[1]->dr_ledger_account);	
								$rsval['header'][$mainindx]['Dr Amount']=$ledger_tran[1]->amount;

								$rsval['header'][$mainindx]['Cr Account']=
								$this->projectmodel->GetSingleVal('title','tbl_chart_of_accounts',' id='.$ledger_tran[0]->cr_ledger_account);			
								$rsval['header'][$mainindx]['Cr Amount']=$ledger_tran[0]->amount;
								$mainindx=$mainindx+1;		
							}

						
							

							
							//PAYMENT SECTION
							$payments="select a.*,b.invoice_summary_id 	from invoice_payment_receive a,invoice_payment_receive_details b
							 where a.id=b.invoice_payment_receive_id and	a.status='PAYMENT' and b.invoice_summary_id=".$invoice_summary_id ;			
							$payments = $this->projectmodel->get_records_from_sql($payments);	
							foreach ($payments as $record)
							{ 

									$rsval['header'][$mainindx]['Tran Type']=$record->status;
									$rsval['header'][$mainindx]['Operating Unit']=
									$this->projectmodel->GetSingleVal('hierarchy_name','tbl_hierarchy_org',' id='.$record->req_operating_unit);

									$rsval['header'][$mainindx]['Date']=$record->req_accounting_date;
									$rsval['header'][$mainindx]['Tran No']=$record->req_number;
									$rsval['header'][$mainindx]['Vendor']=
									$this->projectmodel->GetSingleVal('name','mstr_supplier',' id='.$record->req_supplier);

									$rsval['header'][$mainindx]['Dr Account']='NA';
									$rsval['header'][$mainindx]['Dr Amount']='';
		
									$rsval['header'][$mainindx]['Cr Account']='NA';
									$rsval['header'][$mainindx]['Cr Amount']='';

									$ledger_tran = "select count(*) cnt from acc_tran_header a,acc_tran_details b   
									where a.id=b.acc_tran_header_id and a.tran_table_name='invoice_payment_receive' and a.tran_table_id=".$record->id ;
									$ledger_tran = $this->projectmodel->get_records_from_sql($ledger_tran);

									if($ledger_tran[0]->cnt>0)
									{
										$ledger_tran = "select b.* from acc_tran_header a,acc_tran_details b   
										where a.id=b.acc_tran_header_id 
										and a.tran_table_name='invoice_payment_receive' and a.tran_table_id=".$record->id." order by b.id " ;
										$ledger_tran = $this->projectmodel->get_records_from_sql($ledger_tran);
	
										$rsval['header'][$mainindx]['Dr Account']=
										$this->projectmodel->GetSingleVal('title','tbl_chart_of_accounts',' id='.$ledger_tran[1]->dr_ledger_account);	
										$rsval['header'][$mainindx]['Dr Amount']=$ledger_tran[1]->amount;
	
										$rsval['header'][$mainindx]['Cr Account']=
										$this->projectmodel->GetSingleVal('title','tbl_chart_of_accounts',' id='.$ledger_tran[0]->cr_ledger_account);			
										$rsval['header'][$mainindx]['Cr Amount']=$ledger_tran[0]->amount;
										$mainindx=$mainindx+1;		
									}
							

							}

						return $rsval;				


			}



				//ORDER TO CASH
			if($REPORT_NAME=='OTOC_REPORT')
			{
			
							$req_id=$param_array['ledger_ac'];

							//ORDER TO CASH
							$mainindx=0;	

						 	$records = "select * from invoice_summary where id=".$req_id ;
							$records = $this->projectmodel->get_records_from_sql($records);
							
							$rsval['header'][$mainindx]['Tran Type']=$records[0]->status;
							$rsval['header'][$mainindx]['Operating Unit']=
							$this->projectmodel->GetSingleVal('hierarchy_name','tbl_hierarchy_org',' id='.$records[0]->req_operating_unit);;
							$rsval['header'][$mainindx]['Date']=$records[0]->req_accounting_date;
							$rsval['header'][$mainindx]['Tran No']=$records[0]->req_number;
							$rsval['header'][$mainindx]['Vendor']=
							$this->projectmodel->GetSingleVal('name','mstr_supplier',' id='.$records[0]->req_supplier);

							$rsval['header'][$mainindx]['Dr Account']='NA';
							$rsval['header'][$mainindx]['Dr Amount']='';

							$rsval['header'][$mainindx]['Cr Account']='NA';
							$rsval['header'][$mainindx]['Cr Amount']='';
							$mainindx=$mainindx+1;		

					
							//DESPATCH ENTRY
							$records = "select * from invoice_summary where parent_id=".$records[0]->id ;
							$records = $this->projectmodel->get_records_from_sql($records);

							$rsval['header'][$mainindx]['Tran Type']=$records[0]->status;
							$rsval['header'][$mainindx]['Operating Unit']=
							$this->projectmodel->GetSingleVal('hierarchy_name','tbl_hierarchy_org',' id='.$records[0]->req_operating_unit);

							$rsval['header'][$mainindx]['Date']=$records[0]->req_accounting_date;
							$rsval['header'][$mainindx]['Tran No']=$records[0]->req_number;
							$rsval['header'][$mainindx]['Vendor']=
							$this->projectmodel->GetSingleVal('name','mstr_supplier',' id='.$records[0]->req_supplier);

							$ledger_tran = "select b.* from acc_tran_header a,acc_tran_details b   
							where a.id=b.acc_tran_header_id and 
							a.tran_table_name='invoice_summary' and a.tran_table_id=".$records[0]->id."  order by b.id" ;
							$ledger_tran = $this->projectmodel->get_records_from_sql($ledger_tran);
							
						//	print_r($ledger_tran);

							$rsval['header'][$mainindx]['Dr Account']=
							$this->projectmodel->GetSingleVal('title','tbl_chart_of_accounts',' id='.$ledger_tran[1]->dr_ledger_account);	
							$rsval['header'][$mainindx]['Dr Amount']=$ledger_tran[1]->amount;

							$rsval['header'][$mainindx]['Cr Account']=
							$this->projectmodel->GetSingleVal('title','tbl_chart_of_accounts',' id='.$ledger_tran[0]->cr_ledger_account);			
							$rsval['header'][$mainindx]['Cr Amount']=$ledger_tran[0]->amount;
							$mainindx=$mainindx+1;		

												
							//INVOICE

							$records="select * 	from invoice_summary where	status='SALES_INVOICE' and parent_id=".$req_id ;			
							$records = $this->projectmodel->get_records_from_sql($records);	
						
						// $records = "select * from invoice_summary where status='PURCHASE_INVOICE' and parent_id=".$req_id ;
							// $records = $this->projectmodel->get_records_from_sql($records);
							$invoice_summary_id=$records[0]->id;
							$rsval['header'][$mainindx]['Tran Type']=$records[0]->status;
							$rsval['header'][$mainindx]['Operating Unit']=
							$this->projectmodel->GetSingleVal('hierarchy_name','tbl_hierarchy_org',' id='.$records[0]->req_operating_unit);

							$rsval['header'][$mainindx]['Date']=$records[0]->req_accounting_date;
							$rsval['header'][$mainindx]['Tran No']=$records[0]->req_number;
							$rsval['header'][$mainindx]['Vendor']=
							$this->projectmodel->GetSingleVal('name','mstr_supplier',' id='.$records[0]->req_supplier);

							$rsval['header'][$mainindx]['Dr Account']='NA';
							$rsval['header'][$mainindx]['Dr Amount']='';

							$rsval['header'][$mainindx]['Cr Account']='NA';
							$rsval['header'][$mainindx]['Cr Amount']='';

							$ledger_tran = "select count(*) cnt from acc_tran_header a,acc_tran_details b   
							where a.id=b.acc_tran_header_id and a.tran_table_name='invoice_summary' and a.tran_table_id=".$records[0]->id ;
							$ledger_tran = $this->projectmodel->get_records_from_sql($ledger_tran);

							if($ledger_tran[0]->cnt>0)
							{
								$ledger_tran = "select b.* from acc_tran_header a,acc_tran_details b   
								where a.id=b.acc_tran_header_id 
								and a.tran_table_name='invoice_summary' and a.tran_table_id=".$records[0]->id." order by b.id " ;
								$ledger_tran = $this->projectmodel->get_records_from_sql($ledger_tran);

								$rsval['header'][$mainindx]['Dr Account']=
								$this->projectmodel->GetSingleVal('title','tbl_chart_of_accounts',' id='.$ledger_tran[1]->dr_ledger_account);	
								$rsval['header'][$mainindx]['Dr Amount']=$ledger_tran[1]->amount;

								$rsval['header'][$mainindx]['Cr Account']=
								$this->projectmodel->GetSingleVal('title','tbl_chart_of_accounts',' id='.$ledger_tran[0]->cr_ledger_account);			
								$rsval['header'][$mainindx]['Cr Amount']=$ledger_tran[0]->amount;
								$mainindx=$mainindx+1;		
							}

						
							

							
							//RECEIVE SECTION
							$payments="select a.*,b.invoice_summary_id 	from invoice_payment_receive a,invoice_payment_receive_details b
							 where a.id=b.invoice_payment_receive_id and	a.status='RECEIVE' and b.invoice_summary_id=".$invoice_summary_id ;			
							$payments = $this->projectmodel->get_records_from_sql($payments);	
							foreach ($payments as $record)
							{ 

									$rsval['header'][$mainindx]['Tran Type']=$record->status;
									$rsval['header'][$mainindx]['Operating Unit']=
									$this->projectmodel->GetSingleVal('hierarchy_name','tbl_hierarchy_org',' id='.$record->req_operating_unit);

									$rsval['header'][$mainindx]['Date']=$record->req_accounting_date;
									$rsval['header'][$mainindx]['Tran No']=$record->req_number;
									$rsval['header'][$mainindx]['Vendor']=
									$this->projectmodel->GetSingleVal('name','mstr_supplier',' id='.$record->req_supplier);

									$rsval['header'][$mainindx]['Dr Account']='NA';
									$rsval['header'][$mainindx]['Dr Amount']='';
		
									$rsval['header'][$mainindx]['Cr Account']='NA';
									$rsval['header'][$mainindx]['Cr Amount']='';

									$ledger_tran = "select count(*) cnt from acc_tran_header a,acc_tran_details b   
									where a.id=b.acc_tran_header_id and a.tran_table_name='invoice_payment_receive' and a.tran_table_id=".$record->id ;
									$ledger_tran = $this->projectmodel->get_records_from_sql($ledger_tran);

									if($ledger_tran[0]->cnt>0)
									{
										$ledger_tran = "select b.* from acc_tran_header a,acc_tran_details b   
										where a.id=b.acc_tran_header_id 
										and a.tran_table_name='invoice_payment_receive' and a.tran_table_id=".$record->id." order by b.id " ;
										$ledger_tran = $this->projectmodel->get_records_from_sql($ledger_tran);
	
										$rsval['header'][$mainindx]['Dr Account']=
										$this->projectmodel->GetSingleVal('title','tbl_chart_of_accounts',' id='.$ledger_tran[1]->dr_ledger_account);	
										$rsval['header'][$mainindx]['Dr Amount']=$ledger_tran[1]->amount;
	
										$rsval['header'][$mainindx]['Cr Account']=
										$this->projectmodel->GetSingleVal('title','tbl_chart_of_accounts',' id='.$ledger_tran[0]->cr_ledger_account);			
										$rsval['header'][$mainindx]['Cr Amount']=$ledger_tran[0]->amount;
										$mainindx=$mainindx+1;		
									}
							

							}

						return $rsval;				


			}

	
	
	}
		



function get_ledger_id($ref_table_id='',$ref_table_name='')
 {
 		$ledger_account_header=0;	
		$sql_led="select * 	from acc_group_ledgers where
		ref_table_name='".$ref_table_name."' and  ref_table_id=".$ref_table_id;			
		$rowledgers = $this->projectmodel->get_records_from_sql($sql_led);	
		foreach ($rowledgers as $rowledger)
		{ return $ledger_account_header=$rowledger->id; }
 
 }
 
function acc_tran_details($acc_tran_header_id='',$cr_ledger_account='',$dr_ledger_account='',$amount='',$matching_tran_id=1)
 {
 		    
			$save_dtl['acc_tran_header_id']=$acc_tran_header_id;
			$save_dtl['cr_ledger_account']=$cr_ledger_account;
			$save_dtl['dr_ledger_account']=$dr_ledger_account;
			$save_dtl['amount']=$amount;
			$save_dtl['matching_tran_id']=$matching_tran_id;
			
			$this->projectmodel->save_records_model('','acc_tran_details',$save_dtl);
			return $this->db->insert_id();
 
 }
 
 function ledger_transactions_delete($tran_table_id='',$TRAN_TYPE='')
 {
 		 
			if($TRAN_TYPE=='GRN_ENTRY' || $TRAN_TYPE=='PURCHASE_INVOICE' || $TRAN_TYPE=='ORDER_DESPATCH' || $TRAN_TYPE=='SALES_INVOICE')
			{
				
				  $acc_tran_details_id=$acc_tran_header_id=0;

					$sql_led="select * 	from acc_tran_header where
					tran_table_name='invoice_summary' and  
					tran_table_id=".$tran_table_id;			
					$rowledgers = $this->projectmodel->get_records_from_sql($sql_led);	
					foreach ($rowledgers as $rowledger)
					{ $acc_tran_header_id=$rowledger->id; }

					$sql_led="select * 	from acc_tran_details where
					acc_tran_header_id=".$acc_tran_header_id;			
					$rowledgers = $this->projectmodel->get_records_from_sql($sql_led);	
					foreach ($rowledgers as $rowledger)
					{ $acc_tran_details_id= $acc_tran_details_id.','.$rowledger->id; }
				
					$sql="delete from acc_tran_details_details  
					where acc_tran_details_id in (".$acc_tran_details_id.") ";
					$this->db->query($sql);

					$sql="delete from acc_tran_details  
					where acc_tran_header_id=".$acc_tran_header_id;
					$this->db->query($sql);
					
					$sql="delete from acc_tran_header  where id=".$acc_tran_header_id;
					$this->db->query($sql);
				
			}

			if($TRAN_TYPE=='SUPPLIER_PAYMENT' ||$TRAN_TYPE=='CUSTOMER_RECEIVE' )
			{
				
				   $acc_tran_details_id=$acc_tran_header_id=0;

					$sql_led="select * 	from acc_tran_header where
					tran_table_name='invoice_payment_receive' and  
					tran_table_id=".$tran_table_id;			
					$rowledgers = $this->projectmodel->get_records_from_sql($sql_led);	
					foreach ($rowledgers as $rowledger)
					{ $acc_tran_header_id=$rowledger->id; }

					$sql_led="select * 	from acc_tran_details where
					acc_tran_header_id=".$acc_tran_header_id;			
					$rowledgers = $this->projectmodel->get_records_from_sql($sql_led);	
					foreach ($rowledgers as $rowledger)
					{ $acc_tran_details_id= $acc_tran_details_id.','.$rowledger->id; }
				
					$sql="delete from acc_tran_details_details  
					where acc_tran_details_id in (".$acc_tran_details_id.") ";
					$this->db->query($sql);

					$sql="delete from acc_tran_details  
					where acc_tran_header_id=".$acc_tran_header_id;
					$this->db->query($sql);
					
					$sql="delete from acc_tran_header  where id=".$acc_tran_header_id;
					$this->db->query($sql);
				
			}

			
 }

 function acc_tran_details_details($acc_tran_details_id,$TABLE_NAME,$TABLE_ID,$BILL_INSTRUMENT_NO,$AMOUNT,$STATUS,$OPERATION_TYPE)
 {

	$save_hdr['acc_tran_details_id']=$acc_tran_details_id;
	$save_hdr['TABLE_NAME']=$TABLE_NAME;
	$save_hdr['TABLE_ID']=$TABLE_ID;
	$save_hdr['BILL_INSTRUMENT_NO']=$BILL_INSTRUMENT_NO;
	$save_hdr['AMOUNT']=$AMOUNT;
	$save_hdr['STATUS']=$STATUS;
	$save_hdr['OPERATION_TYPE']=$OPERATION_TYPE;

	$this->projectmodel->save_records_model('','acc_tran_details_details',$save_hdr);

 }

 function ledger_transactions($tran_table_id='',$TRAN_TYPE='')
 {
		
			$acc_tran_details_id=0;


			//PURCHASE SECTION

			if($TRAN_TYPE=='receipt_of_goods')//RECEIPT OF GOODS
			{	
				
					$TRAN_TYPE='GRN_ENTRY';
					$this->ledger_transactions_delete($tran_table_id,$TRAN_TYPE);
					
					$save_hdr['tran_table_name']='invoice_summary';
					$save_hdr['tran_table_id']=$tran_table_id;
				
					$sqlfld="SELECT * FROM  invoice_summary where id=".$tran_table_id; 
					$fields = $this->projectmodel->get_records_from_sql($sqlfld);	
					foreach ($fields as $field)
					{	
									
							//$tbl_party_id=$save_hdr['ledger_account_header']=$field->tbl_party_id;
							$save_hdr['tran_date']=$field->req_accounting_date;
							$save_hdr['tran_code']=$field->req_number;
							$save_hdr['TRAN_TYPE']=$TRAN_TYPE;
							$AMOUNT=$field->invoice_grand_total;

							$this->projectmodel->save_records_model('','acc_tran_header',$save_hdr);
							$id_header=$this->db->insert_id();
							
							$account_setup_id=$this->session->userdata('account_setup_id');
							$setup_records="select * from account_setup where id=".$account_setup_id;				
							$setup_records = $this->projectmodel->get_records_from_sql($setup_records);	
						
							//DETAILS OF TRANSACTIONS
							$matching_tran_id=1;
							$amount=$AMOUNT;
							$cr_ledger_account=$setup_records[0]->p2p_grn_cr; 
							$dr_ledger_account=$setup_records[0]->p2p_grn_dr; 

							if($amount>0)
							{				
								$this->acc_tran_details($id_header,$cr_ledger_account,0,$amount,$matching_tran_id);
								$acc_tran_details_id=$this->acc_tran_details($id_header,0,$dr_ledger_account,$amount,$matching_tran_id);
							}
					
					}
			}

			if($TRAN_TYPE=='purchase_invoice')//PURCHASE INVOICE
			{	
				
					$TRAN_TYPE='PURCHASE_INVOICE';
					$this->ledger_transactions_delete($tran_table_id,$TRAN_TYPE);
					
					$save_hdr['tran_table_name']='invoice_summary';
					$save_hdr['tran_table_id']=$tran_table_id;
				
					$sqlfld="SELECT * FROM  invoice_summary where id=".$tran_table_id; 
					$fields = $this->projectmodel->get_records_from_sql($sqlfld);	
					foreach ($fields as $field)
					{	
									
							//$tbl_party_id=$save_hdr['ledger_account_header']=$field->tbl_party_id;
							$save_hdr['tran_date']=$field->req_accounting_date;
							$save_hdr['tran_code']=$field->req_number;
							$save_hdr['TRAN_TYPE']=$TRAN_TYPE;
							$AMOUNT=$field->invoice_grand_total;

							$this->projectmodel->save_records_model('','acc_tran_header',$save_hdr);
							$id_header=$this->db->insert_id();
							
							$account_setup_id=$this->session->userdata('account_setup_id');
							$setup_records="select * from account_setup where id=".$account_setup_id;				
							$setup_records = $this->projectmodel->get_records_from_sql($setup_records);	
						
							//DETAILS OF TRANSACTIONS
							$matching_tran_id=1;
							$amount=$AMOUNT;
							$cr_ledger_account=$this->projectmodel->GetSingleVal('chart_of_account_ledger_id','mstr_supplier','id='.$field->req_supplier);  
							$dr_ledger_account=$setup_records[0]->p2p_invoice_dr; 

							if($amount>0)
							{				
								$this->acc_tran_details($id_header,$cr_ledger_account,0,$amount,$matching_tran_id);
								$acc_tran_details_id=$this->acc_tran_details($id_header,0,$dr_ledger_account,$amount,$matching_tran_id);
							}
					
					}
			}

			if($TRAN_TYPE=='payment_rcv')//PAYMENT TO VENDOR
			{

					$TRAN_TYPE='SUPPLIER_PAYMENT';
					$this->ledger_transactions_delete($tran_table_id,$TRAN_TYPE);
					
					$save_hdr['tran_table_name']='invoice_payment_receive';
					$save_hdr['tran_table_id']=$tran_table_id;
				
					$sqlfld="SELECT * FROM  invoice_payment_receive where id=".$tran_table_id; 
					$fields = $this->projectmodel->get_records_from_sql($sqlfld);	
					foreach ($fields as $field)
					{	
									
							//$tbl_party_id=$save_hdr['ledger_account_header']=$field->tbl_party_id;
							$save_hdr['tran_date']=$field->req_accounting_date;
							$save_hdr['tran_code']=$field->req_number;
							$save_hdr['TRAN_TYPE']=$TRAN_TYPE;
							$AMOUNT=$field->cleared_amount;

							$this->projectmodel->save_records_model('','acc_tran_header',$save_hdr);
							$id_header=$this->db->insert_id();
							
							$account_setup_id=$this->session->userdata('account_setup_id');
							$setup_records="select * from account_setup where id=".$account_setup_id;				
							$setup_records = $this->projectmodel->get_records_from_sql($setup_records);	
						
							//DETAILS OF TRANSACTIONS
							$matching_tran_id=1;
							$amount=$AMOUNT;
							$cr_ledger_account=$this->projectmodel->GetSingleVal('chart_of_account_ledger_id','mstr_bank','id='.$field->bank_id); 
							$dr_ledger_account=$this->projectmodel->GetSingleVal('chart_of_account_ledger_id','mstr_supplier','id='.$field->req_supplier);  

							if($amount>0)
							{				
								$this->acc_tran_details($id_header,$cr_ledger_account,0,$amount,$matching_tran_id);
								$acc_tran_details_id=$this->acc_tran_details($id_header,0,$dr_ledger_account,$amount,$matching_tran_id);
							}
					
					}


			}	


			//SALES SECTION
			
			if($TRAN_TYPE=='DESPATCH_GOODS')//RECEIPT OF GOODS
			{	
				
					$TRAN_TYPE='ORDER_DESPATCH';
					$this->ledger_transactions_delete($tran_table_id,$TRAN_TYPE);
					
					$save_hdr['tran_table_name']='invoice_summary';
					$save_hdr['tran_table_id']=$tran_table_id;
				
					$sqlfld="SELECT * FROM  invoice_summary where id=".$tran_table_id; 
					$fields = $this->projectmodel->get_records_from_sql($sqlfld);	
					foreach ($fields as $field)
					{	
									
							//$tbl_party_id=$save_hdr['ledger_account_header']=$field->tbl_party_id;
							$save_hdr['tran_date']=$field->req_accounting_date;
							$save_hdr['tran_code']=$field->req_number;
							$save_hdr['TRAN_TYPE']=$TRAN_TYPE;
							$AMOUNT=$field->invoice_grand_total;

							$this->projectmodel->save_records_model('','acc_tran_header',$save_hdr);
							$id_header=$this->db->insert_id();
							
							$account_setup_id=$this->session->userdata('account_setup_id');
							$setup_records="select * from account_setup where id=".$account_setup_id;				
							$setup_records = $this->projectmodel->get_records_from_sql($setup_records);	
						
							//DETAILS OF TRANSACTIONS
							$matching_tran_id=1;
							$amount=$AMOUNT;
							$cr_ledger_account=$setup_records[0]->o2c_despatch_cr; 
							$dr_ledger_account=$setup_records[0]->o2c_despatch_dr; 

							if($amount>0)
							{				
								$this->acc_tran_details($id_header,$cr_ledger_account,0,$amount,$matching_tran_id);
								$acc_tran_details_id=$this->acc_tran_details($id_header,0,$dr_ledger_account,$amount,$matching_tran_id);
							}
					
					}
			}


			if($TRAN_TYPE=='sale_invoice')//PURCHASE INVOICE
			{	
				
					$TRAN_TYPE='SALES_INVOICE';
					$this->ledger_transactions_delete($tran_table_id,$TRAN_TYPE);
					
					$save_hdr['tran_table_name']='invoice_summary';
					$save_hdr['tran_table_id']=$tran_table_id;
				
					$sqlfld="SELECT * FROM  invoice_summary where id=".$tran_table_id; 
					$fields = $this->projectmodel->get_records_from_sql($sqlfld);	
					foreach ($fields as $field)
					{	
									
							//$tbl_party_id=$save_hdr['ledger_account_header']=$field->tbl_party_id;
							$save_hdr['tran_date']=$field->req_accounting_date;
							$save_hdr['tran_code']=$field->req_number;
							$save_hdr['TRAN_TYPE']=$TRAN_TYPE;
							$AMOUNT=$field->invoice_grand_total;

							$this->projectmodel->save_records_model('','acc_tran_header',$save_hdr);
							$id_header=$this->db->insert_id();
							
							$account_setup_id=$this->session->userdata('account_setup_id');
							$setup_records="select * from account_setup where id=".$account_setup_id;				
							$setup_records = $this->projectmodel->get_records_from_sql($setup_records);	
						
							//DETAILS OF TRANSACTIONS
							$matching_tran_id=1;
							$amount=$AMOUNT;
							$cr_ledger_account=$setup_records[0]->o2c_invoice_cr;
							$dr_ledger_account=	$this->projectmodel->GetSingleVal('chart_of_account_ledger_id','mstr_customer','id='.$field->req_supplier);  ; 

							if($amount>0)
							{				
								$this->acc_tran_details($id_header,$cr_ledger_account,0,$amount,$matching_tran_id);
								$acc_tran_details_id=$this->acc_tran_details($id_header,0,$dr_ledger_account,$amount,$matching_tran_id);
							}
					
					}
			}

			
			if($TRAN_TYPE=='receive_amt')//PAYMENT TO VENDOR
			{

					$TRAN_TYPE='CUSTOMER_RECEIVE';
					$this->ledger_transactions_delete($tran_table_id,$TRAN_TYPE);
					
					$save_hdr['tran_table_name']='invoice_payment_receive';
					$save_hdr['tran_table_id']=$tran_table_id;
				
					$sqlfld="SELECT * FROM  invoice_payment_receive where id=".$tran_table_id; 
					$fields = $this->projectmodel->get_records_from_sql($sqlfld);	
					foreach ($fields as $field)
					{	
									
							//$tbl_party_id=$save_hdr['ledger_account_header']=$field->tbl_party_id;
							$save_hdr['tran_date']=$field->req_accounting_date;
							$save_hdr['tran_code']=$field->req_number;
							$save_hdr['TRAN_TYPE']=$TRAN_TYPE;
							$AMOUNT=$field->cleared_amount;

							$this->projectmodel->save_records_model('','acc_tran_header',$save_hdr);
							$id_header=$this->db->insert_id();
							
							$account_setup_id=$this->session->userdata('account_setup_id');
							$setup_records="select * from account_setup where id=".$account_setup_id;				
							$setup_records = $this->projectmodel->get_records_from_sql($setup_records);	
						
							//DETAILS OF TRANSACTIONS
							$matching_tran_id=1;
							$amount=$AMOUNT;
							$dr_ledger_account=$this->projectmodel->GetSingleVal('chart_of_account_ledger_id','mstr_bank','id='.$field->bank_id); 
							$cr_ledger_account=$this->projectmodel->GetSingleVal('chart_of_account_ledger_id','mstr_customer','id='.$field->req_supplier);  

							if($amount>0)
							{				
								$this->acc_tran_details($id_header,$cr_ledger_account,0,$amount,$matching_tran_id);
								$acc_tran_details_id=$this->acc_tran_details($id_header,0,$dr_ledger_account,$amount,$matching_tran_id);
							}
					
					}


			}	


			/*

					if($TRAN_TYPE=='SALE')//sell invoice section
					{	
						$this->ledger_transactions_delete($tran_table_id,$TRAN_TYPE);
						
						$save_hdr['tran_table_name']='invoice_summary';
						$save_hdr['tran_table_id']=$tran_table_id;
						
						$sqlfld="SELECT * FROM  invoice_summary where id=".$tran_table_id; 
						$fields = $this->projectmodel->get_records_from_sql($sqlfld);	
						foreach ($fields as $field)
						{	
							$tbl_party_id=$save_hdr['ledger_account_header']=$field->tbl_party_id;
							$save_hdr['tran_date']=$field->invoice_date;
							$save_hdr['tran_code']=$field->invoice_no;
							$save_hdr['TRAN_TYPE']='SALE';
							$AMOUNT=$field->grandtot;

							$this->projectmodel->save_records_model('','acc_tran_header',$save_hdr);
							$id_header=$this->db->insert_id();
							
							//DETAILS OF TRANSACTIONS
							$matching_tran_id=1;
							$amount=$field->total_amt-$field->tot_discount-$field->tot_cash_discount;
							$cr_ledger_account=323; //sales a/c
							$dr_ledger_account=$tbl_party_id; //stockist a/c sundry debtors
							if($amount>0)
							{
							$this->acc_tran_details($id_header,$cr_ledger_account,0,$amount,$matching_tran_id);
							$acc_tran_details_id=$this->acc_tran_details($id_header,0,$dr_ledger_account,$amount,$matching_tran_id);

							$this->acc_tran_details_details($acc_tran_details_id,$save_hdr['tran_table_name'],$save_hdr['tran_table_id'],$save_hdr['tran_code'],
							$AMOUNT,$save_hdr['TRAN_TYPE'],'PLUS');
							}
							
							$matching_tran_id=$matching_tran_id+1;			
							$amount=$field->interest_charge;
							$cr_ledger_account=95; //Interest Receive
							$dr_ledger_account=$tbl_party_id; //stockist a/c sundry debtors
							if($amount>0)
							{
							$this->acc_tran_details($id_header,$cr_ledger_account,0,$amount,$matching_tran_id);
							$this->acc_tran_details($id_header,0,$dr_ledger_account,$amount,$matching_tran_id);
							}
							
							$matching_tran_id=$matching_tran_id+1;					
							$amount=$field->freight_charge;
							$dr_ledger_account=94; //Freight Charge
							$cr_ledger_account=$tbl_party_id; //stockist a/c sundry debtors
							if($amount>0)
							{
							$this->acc_tran_details($id_header,$cr_ledger_account,0,$amount,$matching_tran_id);
							$this->acc_tran_details($id_header,0,$dr_ledger_account,$amount,$matching_tran_id);
							}
							
							//TAX SECTION
							$sql_vatper="select distinct(tax_ledger_id) tax_ledger_id
							from invoice_details where invoice_summary_id=".$tran_table_id."  ";
							$rowsql_vatper = $this->projectmodel->get_records_from_sql($sql_vatper);	
							foreach ($rowsql_vatper as $rows_vatper)
							{ 
								$tax_ledger_id=$rows_vatper->tax_ledger_id;	
								
								$taxamt=0;	
								$sql_vatamt="select sum(taxamt) taxamt
								from invoice_details where invoice_summary_id=".$tran_table_id." 
								and  tax_ledger_id=".$tax_ledger_id;
								$rowsql_vatamt = $this->projectmodel->get_records_from_sql($sql_vatamt);	
								foreach ($rowsql_vatamt as $rows_vatamt)
								{$taxamt=$rows_vatamt->taxamt;}
								
								$matching_tran_id=$matching_tran_id+1;		
								$amount=$taxamt;
								$dr_ledger_account=$tbl_party_id;
								$cr_ledger_account=$tax_ledger_id; 								
								if($amount>0)
								{
								$this->acc_tran_details($id_header,$cr_ledger_account,0,$amount,$matching_tran_id);
								$this->acc_tran_details($id_header,0,$dr_ledger_account,$amount,$matching_tran_id);
								}
							}
						
						
						}
					}
					//sell invoice section end
					
					//PURCHASE SECTION	
					if($TRAN_TYPE=='PURCHASE')//sell invoice section
					{	
						$this->ledger_transactions_delete($tran_table_id,$TRAN_TYPE);
						
						$save_hdr['tran_table_name']='invoice_summary';
						$save_hdr['tran_table_id']=$tran_table_id;
						
						$sqlfld="SELECT * FROM  invoice_summary where id=".$tran_table_id; 
						$fields = $this->projectmodel->get_records_from_sql($sqlfld);	
						foreach ($fields as $field)
						{				
							$tbl_party_id=$save_hdr['ledger_account_header']=$field->tbl_party_id;
							$save_hdr['tran_date']=$field->invoice_date;
							$save_hdr['tran_code']=$field->invoice_no;
							$save_hdr['TRAN_TYPE']='PURCHASE';
							$AMOUNT=$field->grandtot;

							$this->projectmodel->save_records_model('','acc_tran_header',$save_hdr);
							$id_header=$this->db->insert_id();
										
							//DETAILS OF TRANSACTIONS
							$matching_tran_id=0;
							$matching_tran_id=$matching_tran_id+1;		
							$amount=$field->total_amt-$field->tot_cash_discount-$field->tot_discount;
							$dr_ledger_account=322; //purchase ledger
							$cr_ledger_account=$tbl_party_id; // a/c sundry creditor
							if($amount>0)
							{
							
							$acc_tran_details_id=$this->acc_tran_details($id_header,$cr_ledger_account,0,$amount,$matching_tran_id);			
							$this->acc_tran_details_details($acc_tran_details_id,$save_hdr['tran_table_name'],$save_hdr['tran_table_id'],$save_hdr['tran_code'],
							$AMOUNT,$save_hdr['TRAN_TYPE'],'PLUS');

							$this->acc_tran_details($id_header,0,$dr_ledger_account,$amount,$matching_tran_id);
							}
							
							//TAX SECTION
							$sql_vatper="select distinct(tax_ledger_id) tax_ledger_id
							from invoice_details where invoice_summary_id=".$tran_table_id."  ";
							$rowsql_vatper = $this->projectmodel->get_records_from_sql($sql_vatper);	
							foreach ($rowsql_vatper as $rows_vatper)
							{ 
								$tax_ledger_id=$rows_vatper->tax_ledger_id;	
								
								$taxamt=0;	
								$sql_vatamt="select sum(taxamt) taxamt
								from invoice_details where invoice_summary_id=".$tran_table_id." 
								and  tax_ledger_id=".$tax_ledger_id;
								$rowsql_vatamt = $this->projectmodel->get_records_from_sql($sql_vatamt);	
								foreach ($rowsql_vatamt as $rows_vatamt)
								{$taxamt=$rows_vatamt->taxamt;}
								
								$matching_tran_id=$matching_tran_id+1;		
								$amount=$taxamt;
								$cr_ledger_account=$tbl_party_id;
								$dr_ledger_account=$tax_ledger_id; 								
								if($amount>0)
								{
								$this->acc_tran_details($id_header,$cr_ledger_account,0,$amount,$matching_tran_id);
								$this->acc_tran_details($id_header,0,$dr_ledger_account,$amount,$matching_tran_id);
								}
							}
							
						}
						
					}
					//PURCHASE SECTION END
			

			*/

	
}



function bill_wise_outstanding($TABLE_NAME='',$TABLE_ID='',$status='')
{
	
	$tot_due=$plus_amt=$minus_amt=0;

	$balancesheets="select sum(AMOUNT) plus_amt from acc_tran_details_details 
	where  TABLE_NAME='".$TABLE_NAME."' AND TABLE_ID='".$TABLE_ID."' and OPERATION_TYPE='PLUS' ";
	$balancesheets =$this->projectmodel->get_records_from_sql($balancesheets);
	foreach ($balancesheets as $balancesheet)
	{$plus_amt=$balancesheet->plus_amt;}

	$balancesheets="select sum(AMOUNT) minus_amt from acc_tran_details_details 
	where  TABLE_NAME='".$TABLE_NAME."' AND TABLE_ID='".$TABLE_ID."' and OPERATION_TYPE='MINUS' ";
	$balancesheets =$this->projectmodel->get_records_from_sql($balancesheets);
	foreach ($balancesheets as $balancesheet)
	{$minus_amt=$balancesheet->minus_amt;}

	$tot_due=$plus_amt-$minus_amt;

	if($status=='PLUS'){$tot_due=$plus_amt;}
	if($status=='MINUS'){$tot_due=$minus_amt;}

	return $tot_due;


}


function bill_wise_due($invoice_id='')
{
	$tot_payment=0;	
	$balancesheets="select sum(AMOUNT) tot_payment from acc_tran_details_details where  bill_id=".$invoice_id." ";
	$balancesheets =$this->projectmodel->get_records_from_sql($balancesheets);
	foreach ($balancesheets as $balancesheet)
	{$tot_payment=$balancesheet->tot_payment;}
	
	return $tot_payment;
}


function ledger_master_create($ref_table_name='',
$ref_table_id='',$parent_id='',$TRAN_TYPE='')
{
	//TALLY LEDGER MASTER DETAILS	
	//https://teachoo.com/725/228/Tally-Ledger-Groups-List-(Ledger-under-Which-Head-or-Group-in-Accounts)/category/Ledger-Creation-and-Alteration/
	
	
			$id='';
			$sqlfld="SELECT id  FROM  acc_group_ledgers where 
			ref_table_name='".$ref_table_name."' and ref_table_id=".$ref_table_id;
			
			$fields = $this->projectmodel->get_records_from_sql($sqlfld);	
			foreach ($fields as $field)
			{$id=$field->id;}
			
			
			$sqlfld="SELECT * FROM  acc_group_ledgers 
			where id=".$parent_id;
			$fields = $this->projectmodel->get_records_from_sql($sqlfld);	
			foreach ($fields as $field)
			{
			$save_ledger['VOUCHER_TYPE']=$field->VOUCHER_TYPE;
			$save_ledger['acc_nature']=$field->acc_nature;
			}
			
			$sqlfld="SELECT * FROM  ".$ref_table_name." where id=".$ref_table_id;
			$fields = $this->projectmodel->get_records_from_sql($sqlfld);	
			foreach ($fields as $field)
			{
				if($ref_table_name=='stockist')
				{$save_ledger['acc_name']=$field->retail_name;}
				
				if($ref_table_name=='tbl_party')
				{$save_ledger['acc_name']=$field->party_name;}
				
				if($ref_table_name=='doctor_mstr')
				{$save_ledger['acc_name']=$field->name;}
			
			}
			
			$save_ledger['parent_id']=$parent_id;
			$save_ledger['acc_type']='LEDGER';
			$save_ledger['EDIT_STATUS']='NO';			
			$save_ledger['ref_table_name']=$ref_table_name;
			$save_ledger['ref_table_id']=$ref_table_id;
			
			
			$this->projectmodel->save_records_model($id,'acc_group_ledgers',$save_ledger);	
}

function batch_wise_product_available($batchno=0,$product_id=0)
{
	$AVAILABLE_QTY=$OPEN_BALANCE=$PURCHASEQNTY=$SALEQNTY=$PURCHASE_RTN=$SALE_RTN=0;

	$sqlqty="select SUM(totqnty) qnty from invoice_details where product_id=".$product_id." 
	and batchno='".$batchno."' and status='OPEN_BALANCE' ";
	$avlqty = $this->projectmodel->get_records_from_sql($sqlqty);
	foreach ($avlqty as $rowq){	
	$OPEN_BALANCE=$rowq->qnty;
	}

	//purchase
	$sqlqty="select SUM(totqnty) qnty from invoice_details where product_id=".$product_id." 
	and batchno='".$batchno."' and status='PURCHASE' ";
	$avlqty = $this->projectmodel->get_records_from_sql($sqlqty);
	foreach ($avlqty as $rowq){	
	$PURCHASEQNTY=$rowq->qnty;
	}
	//sale
	$sqlqty="select SUM(totqnty) qnty from invoice_details where product_id=".$product_id." 
	and batchno='".$batchno."' and status='SALE' ";
	$avlqty = $this->projectmodel->get_records_from_sql($sqlqty);
	foreach ($avlqty as $rowq){	
	$SALEQNTY=$rowq->qnty;
	}
	//PURCHASE RETURN
	$sqlqty="select SUM(totqnty) qnty from invoice_details where product_id=".$product_id." 
	and batchno='".$batchno."' and status='PURCHASE_RTN' ";
	$avlqty = $this->projectmodel->get_records_from_sql($sqlqty);
	foreach ($avlqty as $rowq){	
	$PURCHASE_RTN=$rowq->qnty;
	}
	//SALE RETURN
	$sqlqty="select SUM(totqnty) qnty from invoice_details where product_id=".$product_id." 
	and batchno='".$batchno."' and status='SALE_RTN' ";
	$avlqty = $this->projectmodel->get_records_from_sql($sqlqty);
	foreach ($avlqty as $rowq){	
	$SALE_RTN=$rowq->qnty;
	}
	
	$AVAILABLE_QTY=$OPEN_BALANCE+$PURCHASEQNTY-$SALEQNTY-$PURCHASE_RTN+$SALE_RTN;
	return $AVAILABLE_QTY;
}

	
	
	function get_product_ids_hsnwise($hsncode='')
	{

		$product_ids='0';
		$records="select * FROM brands where  hsncode='".$hsncode."' and brandtype='BRAND'";						
		$records = $this->projectmodel->get_records_from_sql($records);	
		foreach ($records as $record)
		{	$product_ids=$product_ids.','.$record->id;}

		return $product_ids;		
	}
	
	function accounts_group_ledger_hierarchy($parent_id='',$index=0,$fromdate, $todate)
	{
			$output=array();
			$records="select * FROM acc_group_ledgers where  parent_id=".$parent_id;						
			$records = $this->projectmodel->get_records_from_sql($records);	
			foreach ($records as $record)
			{								
				$sub_array=array();
				$sub_array['index']=$index;
				$sub_array['id']=$record->id;
				$sub_array['parent_id']=$record->parent_id;
				$sub_array['name']=$record->acc_name;
				$sub_array['SHOW_IN_TRIAL_BALANCE']=$record->SHOW_IN_TRIAL_BALANCE;
				$sub_array['FINAL_AC_TYPE']=$record->FINAL_AC_TYPE;
				$sub_array['acc_type']=$record->acc_type;

				$whr='id='.$record->parent_id;
				$FINAL_AC_TYPE=$this->projectmodel->GetSingleVal('FINAL_AC_TYPE','acc_group_ledgers',$whr);
				if($FINAL_AC_TYPE<>'NA')
				{$this->db->query("update acc_group_ledgers set FINAL_AC_TYPE='".$FINAL_AC_TYPE."' where parent_id=".$record->parent_id);}

				//get ledger balance--
				if($record->acc_type=='LEDGER')
				{

					if($record->id ==1818 || $record->id ==1819) //STOCK OPEING,CLOSING LEDGER
					{
						$dr_balance_total=$cr_balance_total=0;
						 $totals="select sum(temp_debit_balance) temp_debit_balance,sum(temp_credit_balance) temp_credit_balance
						FROM acc_group_ledgers where  id=".$record->id;						
						$totals = $this->projectmodel->get_records_from_sql($totals);	
						foreach ($totals as $total)
						{$dr_balance_total=$total->temp_debit_balance; $cr_balance_total=$total->temp_credit_balance;	}	
						if(is_null($dr_balance_total)){$dr_balance_total=0;}
						if(is_null($cr_balance_total)){$cr_balance_total=0;}
						
							$sql="update acc_group_ledgers 
						set temp_debit_balance=temp_debit_balance+".$dr_balance_total.",temp_credit_balance=temp_credit_balance+".$cr_balance_total." where id=".$parent_id;
						//	echo '<br>';
						$this->db->query($sql);	
	
					}
					else //OTHER LEDGERS
					{
						$rs=$this->ledger_wise_transactions($record->id,$fromdate, $todate);
						$this->db->query("update acc_group_ledgers 
						set temp_debit_balance=".$rs[0]['dr_balance'].",temp_credit_balance=".$rs[0]['cr_balance']." where id=".$record->id);	
						
						$this->db->query("update acc_group_ledgers 
						set temp_debit_balance=temp_debit_balance+".$rs[0]['dr_balance'].",temp_credit_balance=temp_credit_balance+".$rs[0]['cr_balance']." where id=".$parent_id);	
	
					}
				
				}
				//UPDATE GROUP WISE BALANCE
				if($record->acc_type=='GROUP')
				{
					$dr_balance_total=$cr_balance_total=0;
					$totals="select sum(temp_debit_balance) temp_debit_balance,sum(temp_credit_balance) temp_credit_balance
					FROM acc_group_ledgers where acc_type='GROUP' and parent_id=".$record->id;						
					$totals = $this->projectmodel->get_records_from_sql($totals);	
					foreach ($totals as $total)
					{$dr_balance_total=$total->temp_debit_balance; $cr_balance_total=$total->temp_credit_balance;	}	
						if(is_null($dr_balance_total)){$dr_balance_total=0;}
						if(is_null($cr_balance_total)){$cr_balance_total=0;}

					$this->db->query("update acc_group_ledgers 	set temp_debit_balance=".$dr_balance_total.",
					temp_credit_balance=".$cr_balance_total." where id=".$record->id);
				}
				
				$sub_array['nodes']=array_values($this->accounts_group_ledger_hierarchy($record->id,$index+1,$fromdate, $todate));
				// if($record->acc_type=='GROUP')
				// {$sub_array['nodes']=array_values($this->accounts_group_ledger_hierarchy($record->id,$index+1));}
				$output[]=$sub_array;
			}
			return $output;
	}

	// PROFIT AND LOSS - BALANCESHEET RELATED FUNCTIONS
	function ledger_wise_transactions($ledger_ac='', $fromdate='', $todate='')
	{
		$rsval=array();

		$cr_open_balance=$this->ledger_opening_balance($ledger_ac,$fromdate,'CR');
		$dr_open_balance=$this->ledger_opening_balance($ledger_ac,$fromdate,'DR');
		//$cr_open_balance=$dr_open_balance=0;

		$sqlinv="select sum(b.amount) amount 		from acc_tran_header a,acc_tran_details b 
		where a.id=b.acc_tran_header_id and   a.tran_date between '".$fromdate."' and '".$todate."' and b.cr_ledger_account=".$ledger_ac." ";
		$cr_ledger_accounts =$this->projectmodel->get_records_from_sql($sqlinv);
		foreach ($cr_ledger_accounts as $cr_ledger_account)
		{$cr_open_balance=$cr_open_balance+$cr_ledger_account->amount;}		
			
		$sqlinv="select sum(b.amount) amount	from acc_tran_header a,acc_tran_details b 
		where a.id=b.acc_tran_header_id and   a.tran_date between '".$fromdate."' and '".$todate."' and b.dr_ledger_account=".$ledger_ac." ";
		$dr_ledger_accounts =$this->projectmodel->get_records_from_sql($sqlinv);
		foreach ($dr_ledger_accounts as $dr_ledger_account)
		{$dr_open_balance=$dr_open_balance+$dr_ledger_account->amount;}		
			
		$retuer_value='';
		$key=0;
		$rsval[$key]['dr_balance']=$rsval[$key]['cr_balance']=0;

		if($dr_open_balance>=$cr_open_balance)
		{$rsval[$key]['dr_balance']=$dr_open_balance-$cr_open_balance;}
		else
		{$rsval[$key]['cr_balance']=$cr_open_balance-$dr_open_balance;}

	
		return $rsval;
	}
	
	function ledger_opening_balance($ledger_ac='',$from_date='',$ac_tran_type='CR')
	{
		
					$FINAL_AC_TYPE='NA';
					$cr_open_balance=$dr_open_balance=$TRAN_TYPE='CR';
					$OB_AMT=0;

					//BALANCE AS PER MASTER
					$whr='id='.$ledger_ac;
					$FINAL_AC_TYPE=$this->projectmodel->GetSingleVal('FINAL_AC_TYPE','acc_group_ledgers',$whr);
					$TRAN_TYPE=$this->projectmodel->GetSingleVal('TRAN_TYPE','acc_group_ledgers',$whr);
					$OB_AMT=$this->projectmodel->GetSingleVal('OB_AMT','acc_group_ledgers',$whr);		
					if($TRAN_TYPE=='CR')
					{$cr_open_balance=$OB_AMT;$dr_open_balance=0;}
					else
					{ $cr_open_balance=0;$dr_open_balance=$OB_AMT;}

					//TRANSACTIONAL BALANCE

					if($FINAL_AC_TYPE=='BALANCE_SHEET_ASSET' || $FINAL_AC_TYPE=='BALANCE_SHEET_LIABILITY') // BALANCESHEET LEDGERS
					{
						$from_date=$this->general_library->get_date($from_date,-1,0,0);

						$sqlinv="select sum(b.amount) amount 	from acc_tran_header a,acc_tran_details b 
						where a.id=b.acc_tran_header_id and  a.tran_date<='".$from_date."' and b.cr_ledger_account=".$ledger_ac." ";
						$cr_ledger_accounts =$this->projectmodel->get_records_from_sql($sqlinv);
						foreach ($cr_ledger_accounts as $cr_ledger_account)
						{$cr_open_balance=$cr_open_balance+$cr_ledger_account->amount;}		
						
						$sqlinv="select sum(b.amount) amount	from acc_tran_header a,acc_tran_details b 
						where a.id=b.acc_tran_header_id and   a.tran_date<='".$from_date."' and b.dr_ledger_account=".$ledger_ac." ";
						$cr_ledger_accounts =$this->projectmodel->get_records_from_sql($sqlinv);
						foreach ($cr_ledger_accounts as $cr_ledger_account)
						{$dr_open_balance=$dr_open_balance+$cr_ledger_account->amount;}		

					}					
					else //NON BALANCESHEET LEDGERS
					{					
						$cr_open_balance=$dr_open_balance=0;
						$finyr=$this->general_library->get_fin_yr_yyyy($from_date);
						$finyr_start_date=substr($finyr,0,4).'-04-01';

						if($finyr_start_date<$from_date)
						{$from_date=$this->general_library->get_date($from_date,-1,0,0);}					
					
						$sqlinv="select sum(b.amount) amount 	from acc_tran_header a,acc_tran_details b 
						where a.id=b.acc_tran_header_id and a.tran_date>='".$finyr_start_date."' and  
						a.tran_date<='".$from_date."' and b.cr_ledger_account=".$ledger_ac." ";
						$cr_ledger_accounts =$this->projectmodel->get_records_from_sql($sqlinv);
						foreach ($cr_ledger_accounts as $cr_ledger_account)
						{$cr_open_balance=$cr_open_balance+$cr_ledger_account->amount;}		
						
						$sqlinv="select sum(b.amount) amount	from acc_tran_header a,acc_tran_details b 
						where a.id=b.acc_tran_header_id and a.tran_date>='".$finyr_start_date."' and  
						a.tran_date<='".$from_date."' and b.dr_ledger_account=".$ledger_ac." ";
						$cr_ledger_accounts =$this->projectmodel->get_records_from_sql($sqlinv);
						foreach ($cr_ledger_accounts as $cr_ledger_account)
						{$dr_open_balance=$dr_open_balance+$cr_ledger_account->amount;}		
					
					}
								
					if($cr_open_balance<=$dr_open_balance)
					{	$dr_open_balance=$dr_open_balance-$cr_open_balance;$cr_open_balance=0;}
					else
					{	$cr_open_balance=$cr_open_balance-$dr_open_balance;$dr_open_balance=0;}
									
					if($ac_tran_type=='CR'){return $cr_open_balance;}
					else	{return $dr_open_balance;}
					
	}

	function stock_transactions($fromdate='',$todate='')
	{

		//opening balance
			$purchase=$sale=$sale_rtn=$purchase_rtn=0;
			$records="select sum(b.subtotal) amount  from invoice_summary a,invoice_details b where a.id=b.invoice_summary_id 
			and  a.status='PURCHASE' and a.invoice_date<'$fromdate'  ";
			$records=$this->projectmodel->get_records_from_sql($records);
			foreach ($records as $key=>$record){$total_value=$record->amount;}if(is_null($total_value)){$total_value=0;}
			$purchase= round($total_value,2);

			$records="select sum(b.purchase_rate*totqnty) amount  from invoice_summary a,invoice_details b where a.id=b.invoice_summary_id 
			and  a.status='SALE' and a.invoice_date<'$fromdate'  ";
			$records=$this->projectmodel->get_records_from_sql($records);
			foreach ($records as $key=>$record){$total_value=$record->amount;}if(is_null($total_value)){$total_value=0;}
			$sale= round($total_value,2);

			$records="select sum(b.purchase_rate*totqnty) amount  from invoice_summary a,invoice_details b where a.id=b.invoice_summary_id 
			and  a.status='SALE_RTN' and a.invoice_date<'$fromdate'  ";
			$records=$this->projectmodel->get_records_from_sql($records);
			foreach ($records as $key=>$record){$total_value=$record->amount;}if(is_null($total_value)){$total_value=0;}
			$sale_rtn= round($total_value,2);

			$records="select sum(b.purchase_rate*totqnty) amount  from invoice_summary a,invoice_details b where a.id=b.invoice_summary_id 
			and  a.status='PURCHASE_RTN' and a.invoice_date<'$fromdate'  ";
			$records=$this->projectmodel->get_records_from_sql($records);
			foreach ($records as $key=>$record){$total_value=$record->amount;}if(is_null($total_value)){$total_value=0;}
			$purchase_rtn= round($total_value,2);

			$OPEING=$purchase+$sale_rtn-$sale-$purchase_rtn;

			$sql="update acc_group_ledgers set temp_debit_balance=".$OPEING." where id='1818'  ";
			$this->db->query($sql);	


			//CLOSING STOCK BALANCE
			$purchase=$sale=$sale_rtn=$purchase_rtn=0;
			$records="select sum(b.subtotal) amount  from invoice_summary a,invoice_details b where a.id=b.invoice_summary_id 
			and  a.status='PURCHASE' and a.invoice_date<='$todate'  ";
			$records=$this->projectmodel->get_records_from_sql($records);
			foreach ($records as $key=>$record){$total_value=$record->amount;}if(is_null($total_value)){$total_value=0;}
			$purchase= round($total_value,2);

			$records="select sum(b.purchase_rate*totqnty) amount  from invoice_summary a,invoice_details b where a.id=b.invoice_summary_id 
			and  a.status='SALE' and a.invoice_date<='$todate'  ";
			$records=$this->projectmodel->get_records_from_sql($records);
			foreach ($records as $key=>$record){$total_value=$record->amount;}if(is_null($total_value)){$total_value=0;}
			$sale= round($total_value,2);

			$records="select sum(b.purchase_rate*totqnty) amount  from invoice_summary a,invoice_details b where a.id=b.invoice_summary_id 
			and  a.status='SALE_RTN' and a.invoice_date<='$todate'  ";
			$records=$this->projectmodel->get_records_from_sql($records);
			foreach ($records as $key=>$record){$total_value=$record->amount;}if(is_null($total_value)){$total_value=0;}
			$sale_rtn= round($total_value,2);

			$records="select sum(b.purchase_rate*totqnty) amount  from invoice_summary a,invoice_details b where a.id=b.invoice_summary_id 
			and  a.status='PURCHASE_RTN' and a.invoice_date<='$todate'  ";
			$records=$this->projectmodel->get_records_from_sql($records);
			foreach ($records as $key=>$record){$total_value=$record->amount;}if(is_null($total_value)){$total_value=0;}
			$purchase_rtn= round($total_value,2);

			$CLOSING=$purchase+$sale_rtn-$sale-$purchase_rtn;

			$sql="update acc_group_ledgers set temp_credit_balance=".$CLOSING." where id='1819'  ";
			$this->db->query($sql);
		

	}


}

?>