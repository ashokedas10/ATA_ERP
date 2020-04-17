<?php
class Accounts_model extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
    }
//Ledger Transaction

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

			if($TRAN_TYPE=='SUPPLIER_PAYMENT')
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

		if($TRAN_TYPE=='payment_rcv')
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


function all_mis_report($REPORT_NAME,$param_array)
{
	$trading_ac_output=$output=$data=$rsval=array();
	$tranlink=ADMIN_BASE_URL.'Accounts_controller/all_mis_reports/';
	//print_r($param_array);
	//echo $param_array['fromdate'].' todate::'.$param_array['todate'];
		$mainindx=0;

		$current_hq_id=$this->projectmodel->get_hierarchy_id_of_current_user();



		if($REPORT_NAME=='PRODUCT_GROUP')
		{
					
			$records="select * from  brands WHERE brandtype='BRAND' order by brand_name ";
			$records = $this->projectmodel->get_records_from_sql($records);	
			foreach ($records as $records)
			{
				$opening_amount=0;
				$rsval[$mainindx]['id']=$records->id;
				$rsval[$mainindx]['particular']=$records->brand_name; 
				$rate=$records->pkg2_value;
				$product_id=$records->id;

				$rsval[$mainindx]['href']=$tranlink.'PRODUCT_BATCH/'.$product_id;	

				$tot_purchase=$tot_sale=$tot_sample=$SELL_RTN=$PRUCHAR_RTN=0;
				$products = "select sum(totqnty) totqnty from invoice_details where product_id=".$records->id." and  status='PURCHASE' " ;
				$products = $this->projectmodel->get_records_from_sql($products);
				if(count($products)>0){foreach ($products as $product){$tot_purchase=$product->totqnty;}}

				$products = "select sum(totqnty) totqnty from invoice_details where product_id=".$records->id." and  status='SALE' " ;
				$products = $this->projectmodel->get_records_from_sql($products);
				if(count($products)>0){foreach ($products as $product){$tot_sale=$product->totqnty;}}

				$products = "select sum(totqnty) totqnty from invoice_details where product_id=".$records->id." and  status='SALE_RTN' " ;
				$products = $this->projectmodel->get_records_from_sql($products);
				if(count($products)>0){foreach ($products as $product){$SELL_RTN=$product->totqnty;}}

				$products = "select sum(totqnty) totqnty from invoice_details where product_id=".$records->id." and  status='PRUCHAR_RTN' " ;
				$products = $this->projectmodel->get_records_from_sql($products);
				if(count($products)>0){foreach ($products as $product){$PRUCHAR_RTN=$product->totqnty;}}

						
				$qnty_available=$tot_purchase-$tot_sale+$SELL_RTN-$PRUCHAR_RTN-$tot_sample;

				$rsval[$mainindx]['qnty_available']=$qnty_available;
				$rsval[$mainindx]['rate']=$rate;	
				$rsval[$mainindx]['total']=$qnty_available*$rate;				
				
				$mainindx=$mainindx+1;
			}
		

			return $rsval;
			

		}
	
		if($REPORT_NAME=='PRODUCT_BATCH') 
		{
			
			$mainindx=0;
			$records="select batchno,exp_monyr,mfg_monyr  from invoice_details where 	product_id=".$param_array['param1']." group by batchno,exp_monyr,mfg_monyr";
			$records = $this->projectmodel->get_records_from_sql($records);	
			foreach ($records as $records)
			{
				$opening_amount=0;
				//$rsval[$mainindx]['id']=$records->id;
				$rsval[$mainindx]['batchno']=$records->batchno; 
				$rsval[$mainindx]['exp_monyr']=$records->exp_monyr; 
				$rsval[$mainindx]['mfg_monyr']=$records->mfg_monyr; 
				$rsval[$mainindx]['total_purchase']=$rsval[$mainindx]['total_sale']=
				$rsval[$mainindx]['TOTAL_SELL_RTN']=$rsval[$mainindx]['TOTAL_PRUCHAR_RTN']=$rsval[$mainindx]['tot_sample']=0;
			
				//and exp_monyr='".$records->exp_monyr."' and mfg_monyr='".$records->mfg_monyr."'
				$products = "select sum(totqnty) totqnty from invoice_details where 
				product_id=".$param_array['param1']." and 	batchno='".$records->batchno."'  and status='PURCHASE' " ;				
				$products = $this->projectmodel->get_records_from_sql($products);
				if(count($products)>0){foreach ($products as $product){$rsval[$mainindx]['total_purchase']=$product->totqnty;	}}

				$products = "select sum(totqnty) totqnty from invoice_details where 
				product_id=".$param_array['param1']." and 	batchno='".$records->batchno."' and status='SALE' " ;				
				$products = $this->projectmodel->get_records_from_sql($products);
				if(count($products)>0){foreach ($products as $product){$rsval[$mainindx]['total_sale']=$product->totqnty;	}}

				$products = "select sum(totqnty) totqnty from invoice_details where 
				product_id=".$param_array['param1']." and 	batchno='".$records->batchno."' 	 and status='SALE_RTN' " ;				
				$products = $this->projectmodel->get_records_from_sql($products);
				if(count($products)>0){foreach ($products as $product){$rsval[$mainindx]['TOTAL_SELL_RTN']=$product->totqnty;}}

				$products = "select sum(totqnty) totqnty from invoice_details where 
				product_id=".$param_array['param1']." and 	batchno='".$records->batchno."' and status='PRUCHAR_RTN' " ;				
				$products = $this->projectmodel->get_records_from_sql($products);
				if(count($products)>0){foreach ($products as $product){$rsval[$mainindx]['TOTAL_PRUCHAR_RTN']=$product->totqnty;}}

				$products = "select sum(totqnty) totqnty from sample_tran_details where product_id=".$param_array['param1']." and 
				batchno='".$records->batchno."'  and  status='SAMPLE_RCV' " ;
				$products = $this->projectmodel->get_records_from_sql($products);
				if(count($products)>0){foreach ($products as $product){$rsval[$mainindx]['tot_sample']= $product->totqnty;}}

				$qnty_available=$rsval[$mainindx]['total_available_qnty']=
				$rsval[$mainindx]['total_purchase']-$rsval[$mainindx]['total_sale']+
				$rsval[$mainindx]['TOTAL_SELL_RTN']-$rsval[$mainindx]['TOTAL_PRUCHAR_RTN']-$rsval[$mainindx]['tot_sample'];

				$rate=$rsval[$mainindx]['rate']=$this->projectmodel->GetSingleVal('pkg2_value','brands',' id='.$param_array['param1']); 
				// $whr="product_id=".$param_array['param1']." and 	batchno='".$records->batchno."'  and status='PURCHASE' ";
				// $rate=$rsval[$mainindx]['rate']=$this->projectmodel->GetSingleVal('mrp','invoice_details',$whr);
				$rsval[$mainindx]['total_amt']=$qnty_available*$rate;
				
				$rsval[$mainindx]['href']=$tranlink.'PRODUCT_BATCH_TRANSACTIONS/'.$param_array['param1'].'/'.$records->batchno;				

				$rsval[$mainindx]['qnty_available']=$qnty_available;
				$rsval[$mainindx]['rate']=$rate;	
				$rsval[$mainindx]['total']=$qnty_available*$rate;				
				
				$mainindx=$mainindx+1;
			}

			return $rsval;			
		}

		if($REPORT_NAME=='PRODUCT_BATCH_TRANSACTIONS') 
		{
			//delete invalid	
			$status='';
			$inv_detail_id='';
			$mfg_monyr='';
			$exp_monyr='';
			$totqnty='';
		
			$records="select id,invoice_summary_id from invoice_details  ";
			$records = 	$this->projectmodel->get_records_from_sql($records);
			foreach ($records as $record)
			{	
				$dlts="select count(*) cnt from invoice_summary where id=".$record->invoice_summary_id;
				$dlts = 	$this->projectmodel->get_records_from_sql($dlts);
				foreach ($dlts as $dlt)
				{	
					if($dlt->cnt==0)
					{
						//echo 'Invalid sale detail id :'.$record->id.' | summary id :'.$record->invoice_summary_id.'<br>';
						$this->db->Query("delete from invoice_details where invoice_summary_id=".$record->invoice_summary_id);
					}
				}			
			}
		
			//delete invalid
			
				$mainindx=$balance=0;
				$records="select a.id,a.tbl_party_id,a.status,a.invoice_no,a.invoice_date ,b.totqnty
				from invoice_summary a,invoice_details b where a.id=b.invoice_summary_id and 
				b.product_id=".$param_array['param1']."  and b.batchno='".$param_array['param2']."' order by a.invoice_date,a.id";
				$records = $this->projectmodel->get_records_from_sql($records);
				foreach ($records as $key=>$record)
				{ 
				
					$rsval[$mainindx]['invoice_no']=$record->invoice_no; 
					$rsval[$mainindx]['invoice_date']=$record->invoice_date; 
					$rsval[$mainindx]['party_name']=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$record->tbl_party_id); 
					$rsval[$mainindx]['qnty']=$record->totqnty; 
					$rsval[$mainindx]['status']=$record->status; 
					if($record->status=='PURCHASE' 	or $record->status=='SALE_RTN' or $record->status=='OPEN_BALANCE')
					{$balance=$balance+$record->totqnty;}
					if($record->status=='SALE')
					{$balance=$balance-$record->totqnty;}
					$rsval[$mainindx]['balance']=$balance;

					$rsval[$mainindx]['href']='';
					$mainindx=$mainindx+1;
				}
				return $rsval;		
		}

		//SAMPLE PRODUCT STOCK SECTION
		if($REPORT_NAME=='PRODUCT_GROUP_SAMPLE')
		{
			
			$mainindx=0;
			$records="select * from  brands where brandtype='BRAND' order by brand_name ";
			$records = $this->projectmodel->get_records_from_sql($records);	
			foreach ($records as $records)
			{
				$opening_amount=0;
				$rsval[$mainindx]['id']=$records->id;
				$rsval[$mainindx]['particular']=$records->brand_name; 
				$rate=$records->pkg1_srate;
				$product_id=$records->id;

				$rsval[$mainindx]['href']=$tranlink.'PRODUCT_BATCH_SAMPLE/'.$product_id;	
				$tot_sample_issue=$tot_sample=0;

				$products = "select sum(totqnty) totqnty from sample_tran_details where product_id=".$records->id." and  status='SAMPLE_RCV' " ;
				$products = $this->projectmodel->get_records_from_sql($products);
				if(count($products)>0){foreach ($products as $product){$tot_sample=$product->totqnty;}}
			
				$products = "select sum(totqnty) totqnty from sample_tran_details where product_id=".$records->id." and  status='SAMPLE_ISU' " ;
				$products = $this->projectmodel->get_records_from_sql($products);
				if(count($products)>0){foreach ($products as $product){$tot_sample_issue=$product->totqnty;}}

				$qnty_available=$tot_sample-$tot_sample_issue;

				$rsval[$mainindx]['qnty_available']=$qnty_available;
				$rsval[$mainindx]['rate']=$rate;	
				$rsval[$mainindx]['total']=$qnty_available*$rate;				
				
				$mainindx=$mainindx+1;
			}

			return $rsval;
		}

		if($REPORT_NAME=='PRODUCT_BATCH_SAMPLE') 
		{
			
			$mainindx=0;
			$records="select batchno,exp_monyr,mfg_monyr  from invoice_details where 	product_id=".$param_array['param1']." group by batchno,exp_monyr,mfg_monyr";
			$records = $this->projectmodel->get_records_from_sql($records);	
			foreach ($records as $records)
			{
				$opening_amount=0;
				//$rsval[$mainindx]['id']=$records->id;
				$rsval[$mainindx]['batchno']=$records->batchno; 
				$rsval[$mainindx]['exp_monyr']=$records->exp_monyr; 
				$rsval[$mainindx]['mfg_monyr']=$records->mfg_monyr; 
				$rsval[$mainindx]['total_purchase']=$rsval[$mainindx]['total_sale']=
				$rsval[$mainindx]['TOTAL_SELL_RTN']=$rsval[$mainindx]['TOTAL_PRUCHAR_RTN']=
				$rsval[$mainindx]['tot_sample']=$rsval[$mainindx]['tot_sample_issue']=0;
			
				
				$products = "select sum(totqnty) totqnty from sample_tran_details where product_id=".$param_array['param1']." and 
				batchno='".$records->batchno."'  and  status='SAMPLE_RCV' " ;
				$products = $this->projectmodel->get_records_from_sql($products);
				if(count($products)>0){foreach ($products as $product){$rsval[$mainindx]['tot_sample']= $product->totqnty;}}

				$products = "select sum(totqnty) totqnty from sample_tran_details where product_id=".$param_array['param1']." and 
				batchno='".$records->batchno."'  and  status='SAMPLE_ISU' " ;
				$products = $this->projectmodel->get_records_from_sql($products);
				if(count($products)>0){foreach ($products as $product){$rsval[$mainindx]['tot_sample_issue']= $product->totqnty;}}

				$qnty_available=$rsval[$mainindx]['total_available_qnty']=$rsval[$mainindx]['tot_sample']-$rsval[$mainindx]['tot_sample_issue'];

				$rate=$rsval[$mainindx]['rate']=$this->projectmodel->GetSingleVal('pkg1_srate','brands',' id='.$param_array['param1']); 
				$rsval[$mainindx]['total_amt']=$qnty_available*$rate;
				
				$rsval[$mainindx]['href']=$tranlink.'PRODUCT_BATCH_TRANSACTIONS_SAMPLE/'.$param_array['param1'].'/'.$records->batchno;				

				$rsval[$mainindx]['qnty_available']=$qnty_available;
				$rsval[$mainindx]['rate']=$rate;	
				$rsval[$mainindx]['total']=$qnty_available*$rate;				
				
				$mainindx=$mainindx+1;
			}

			return $rsval;			
		}

		if($REPORT_NAME=='PRODUCT_BATCH_TRANSACTIONS_SAMPLE') 
		{
			//delete invalid	
			$status='';
			$inv_detail_id='';
			$mfg_monyr='';
			$exp_monyr='';
			$totqnty='';
			
			
				$mainindx=$balance=0;
				$records="select a.id,a.tbl_party_id,a.status,a.invoice_no,a.invoice_date ,b.totqnty
				from sample_tran_summary a,sample_tran_details b where a.id=b.invoice_summary_id and 
				b.product_id=".$param_array['param1']."  and b.batchno='".$param_array['param2']."'  order by a.invoice_date,a.id";
				$records = $this->projectmodel->get_records_from_sql($records);
				foreach ($records as $key=>$record)
				{ 
				
					$rsval[$mainindx]['invoice_no']=$record->invoice_no; 
					$rsval[$mainindx]['invoice_date']=$record->invoice_date; 
					if($record->status=='SAMPLE_RCV')
					{$rsval[$mainindx]['party_name']=$this->projectmodel->GetSingleVal('party_name','tbl_party',' id='.$record->tbl_party_id); }
					if($record->status=='SAMPLE_ISU')
					{$rsval[$mainindx]['party_name']=$this->projectmodel->GetSingleVal('hierarchy_name','tbl_hierarchy_org',' id='.$record->tbl_party_id); }
					
					$rsval[$mainindx]['qnty']=$record->totqnty; 
					$rsval[$mainindx]['status']=$record->status; 
					if($record->status=='SAMPLE_RCV'){$balance=$balance+$record->totqnty;}
					if($record->status=='SAMPLE_ISU'){$balance=$balance-$record->totqnty;}					
					$rsval[$mainindx]['balance']=$balance;

					$rsval[$mainindx]['href']='';
					$mainindx=$mainindx+1;
				}

				return $rsval;		
		}
	
		if($REPORT_NAME=='PRODUCT_TRANSACTIONS') 
		{
			//delete invalid	
			$status='';
			$inv_detail_id='';
			$mfg_monyr='';
			$exp_monyr='';
			$totqnty='';
					
			//delete invalid
			
				$mainindx=$balance=0;
				$records="select a.id,a.tbl_party_id,a.status,a.invoice_no,a.invoice_date ,b.totqnty
				from invoice_summary a,invoice_details b where a.id=b.invoice_summary_id and 
				b.product_id=".$param_array['param1']."  and b.status='".$param_array['param2']."' order by a.invoice_date,a.id";
				$records = $this->projectmodel->get_records_from_sql($records);
				foreach ($records as $key=>$record)
				{ 
				
					$rsval[$mainindx]['invoice_no']=$record->invoice_no; 
					$rsval[$mainindx]['invoice_date']=$record->invoice_date; 
					$rsval[$mainindx]['party_name']=$this->projectmodel->GetSingleVal('retail_name','stockist',' id='.$record->tbl_party_id); 
					$rsval[$mainindx]['qnty']=$record->totqnty; 
					$rsval[$mainindx]['status']=$record->status; 
					if($record->status=='PURCHASE' 	or $record->status=='SELL_RTN')
					{$balance=$balance+$record->totqnty;}
					if($record->status=='SELL')
					{$balance=$balance-$record->totqnty;}
					$rsval[$mainindx]['balance']=$balance;

					$rsval[$mainindx]['href']='';
					$mainindx=$mainindx+1;
				}
				
				
				$records="select a.id,a.tbl_party_id,a.status,a.invoice_no,a.invoice_date ,b.totqnty
				from sample_tran_summary a,sample_tran_details b where a.id=b.invoice_summary_id and 
				b.product_id=".$param_array['param1']."   and b.status='SAMPLE_RCV' order by a.invoice_date,a.id";
				$records = $this->projectmodel->get_records_from_sql($records);
				foreach ($records as $key=>$record)
				{ 
				
					$rsval[$mainindx]['invoice_no']=$record->invoice_no; 
					$rsval[$mainindx]['invoice_date']=$record->invoice_date; 
					$rsval[$mainindx]['party_name']=$this->projectmodel->GetSingleVal('retail_name','stockist',' id='.$record->tbl_party_id); 
					$rsval[$mainindx]['qnty']=$record->totqnty; 
					$rsval[$mainindx]['status']=$record->status; 
					$balance=$balance-$record->totqnty;
					$rsval[$mainindx]['balance']=$balance;

					$rsval[$mainindx]['href']='';
					$mainindx=$mainindx+1;
				}

				return $rsval;		
		}

	
		//GST RELATED REPORT

		if($REPORT_NAME=='GST_REPORT') 
		{
				
				
				$mainindx=$balance=0;	
				$startingdate=$data['startingdate']=$param_array['fromdate'];
				$closingdate=$data['closingdate']=$param_array['todate'];

				$excel2 = PHPExcel_IOFactory::createReader('Excel5');
				$excel2 = $excel2->load('./uploads/gst_format.xls'); // Empty Sheet

					//$excel2 = PHPExcel_IOFactory::createReader('Excel2007');
				//	$excel2 = $excel2->load('./uploads/gst_format_xlsx.xlsx'); // Empty Sheet
						// $excel2->setActiveSheetIndex(1);
						// $excel2->getActiveSheet(0)->setCellValue('C6', '4')
						// 	->setCellValue('C7', '111')
						// 	->setCellValue('C8', '222')       
						// 	->setCellValue('C9', '33');

					//B2B SECTION START
						
					$excel2->setActiveSheetIndex(0);
					//GST REGISTERED PARTY
					$stckist_ids='0';
					$other_records=" select b.* from stockist a,acc_group_ledgers b where a.GSTNO<>'' and a.id=b.ref_table_id AND ref_table_name='stockist' and b.parent_id=28 ";
					$other_records =
					$this->projectmodel->get_records_from_sql($other_records);	
					foreach ($other_records as $other_record)
					{$stckist_ids=$stckist_ids.','.$other_record->id;}
									
									
					$cell=5;
					$total_invoice_val=$total_taxable_value=0;
					$records="select sum(b.subtotal) invoice_val,sum(b.taxable_amt) taxable_amt,b.tax_per,b.invoice_summary_id
					from invoice_summary a,invoice_details b where  a.status='SALE' 
					and  a.invoice_date between 	'".$startingdate."' and '".$closingdate."' and a.tbl_party_id in (".$stckist_ids.") 
					and  a.id=b.invoice_summary_id group by a.invoice_no,b.tax_per";
					$records =$this->projectmodel->get_records_from_sql($records);	
					foreach ($records as $record)
					{
						
						$total_invoice_val=$total_invoice_val+$record->invoice_val;
						$total_taxable_value=$total_taxable_value+$record->taxable_amt;
					

						//$invoice_no=$this->projectmodel->GetSingleVal('invoice_no','invoice_summary',' id='.$record->invoice_summary_id); 		
						 $whr="id=".$record->invoice_summary_id;
						 $multi_rs=$this->projectmodel->GetMultipleVal('*','invoice_summary',$whr);

						 $invoice_date=date_create($multi_rs[0]['invoice_date']);
						 $invoice_date=date_format($invoice_date,"d-M-Y");

						 $stockist_id=$this->projectmodel->GetSingleVal('ref_table_id','acc_group_ledgers',' id='.$multi_rs[0]['tbl_party_id']); 
						 $GSTNO=$this->projectmodel->GetSingleVal('GSTNO','stockist',' id='.$stockist_id); 
						 $STATE_CODE=$this->projectmodel->GetSingleVal('STATE_CODE','stockist',' id='.$stockist_id); 
						 $STATE_NAME=$this->projectmodel->GetSingleVal('STATE_NAME','stockist',' id='.$stockist_id); 
						
						$excel2->getActiveSheet(0)
						->setCellValue('A'.$cell, $GSTNO)
						->setCellValue('B'.$cell, strval($multi_rs[0]['invoice_no']))
						->setCellValue('C'.$cell, $invoice_date)  
						->setCellValue('D'.$cell, $record->invoice_val)
						->setCellValue('E'.$cell, $STATE_CODE.'-'.$STATE_NAME)
						->setCellValue('F'.$cell, '')
						->setCellValue('G'.$cell, 'Regular')
						->setCellValue('H'.$cell, '')
						->setCellValue('I'.$cell, $record->tax_per)
						->setCellValue('J'.$cell, $record->taxable_amt)
						->setCellValue('K'.$cell, '');
						$cell=$cell+1;
					}

					// No. of Recipients
					$No_of_invoice_no=$No_of_Recipients=0;
					 $records="select count(distinct(tbl_party_id)) No_of_Recipients
					from invoice_summary where status='SALE' 	and  invoice_date between '".$startingdate."' and '".$closingdate."' 
					and tbl_party_id in (".$stckist_ids.") ";
					$records =$this->projectmodel->get_records_from_sql($records);	
					foreach ($records as $record)	{$No_of_Recipients=$record->No_of_Recipients;}

						// No. of Invoices
							$records="select count(invoice_no) No_of_invoice_no
						from invoice_summary  where  status='SALE' and  invoice_date between 	'".$startingdate."' and '".$closingdate."' 
						and tbl_party_id in (".$stckist_ids.") ";
						$records =$this->projectmodel->get_records_from_sql($records);	
						foreach ($records as $record)	{$No_of_invoice_no=$record->No_of_invoice_no;}


					$excel2->getActiveSheet(0)
					->setCellValue('A3', $No_of_Recipients)
					->setCellValue('B3', $No_of_invoice_no)					
					->setCellValue('D3', $total_invoice_val)
					->setCellValue('J3', $total_taxable_value)
					->setCellValue('K3', '');

					//B2B SECTION END



					//B2CL SECTION START
					$sheet_no=1;	
					$excel2->setActiveSheetIndex($sheet_no);
					//GST REGISTERED PARTY
					$stckist_ids='0';
					$other_records=" select b.* from stockist a,acc_group_ledgers b where a.GSTNO='' and a.id=b.ref_table_id AND ref_table_name='stockist' and b.parent_id=28 ";
					$other_records =
					$this->projectmodel->get_records_from_sql($other_records);	
					foreach ($other_records as $other_record)
					{$stckist_ids=$stckist_ids.','.$other_record->id;}
									
									
					$cell=5;
					$total_invoice_val=$total_taxable_value=0;
					$records="select sum(b.subtotal) invoice_val,sum(b.taxable_amt) taxable_amt,b.tax_per,b.invoice_summary_id
					from invoice_summary a,invoice_details b where  a.status='SALE' 
					and  a.invoice_date between 	'".$startingdate."' and '".$closingdate."' and a.tbl_party_id in (".$stckist_ids.") 
					and  a.id=b.invoice_summary_id and a.total_amt>=250000 group by a.invoice_no,b.tax_per";
					$records =$this->projectmodel->get_records_from_sql($records);	
					foreach ($records as $record)
					{
						
						$total_invoice_val=$total_invoice_val+$record->invoice_val;
						$total_taxable_value=$total_taxable_value+$record->taxable_amt;
					

						//$invoice_no=$this->projectmodel->GetSingleVal('invoice_no','invoice_summary',' id='.$record->invoice_summary_id); 		
						 $whr="id=".$record->invoice_summary_id;
						 $multi_rs=$this->projectmodel->GetMultipleVal('*','invoice_summary',$whr);

						 $invoice_date=date_create($multi_rs[0]['invoice_date']);
						 $invoice_date=date_format($invoice_date,"d-M-Y");

						 $stockist_id=$this->projectmodel->GetSingleVal('ref_table_id','acc_group_ledgers',' id='.$multi_rs[0]['tbl_party_id']); 
						 $GSTNO=$this->projectmodel->GetSingleVal('GSTNO','stockist',' id='.$stockist_id); 
						 $STATE_CODE=$this->projectmodel->GetSingleVal('STATE_CODE','stockist',' id='.$stockist_id); 
						 $STATE_NAME=$this->projectmodel->GetSingleVal('STATE_NAME','stockist',' id='.$stockist_id); 
						
						$excel2->getActiveSheet($sheet_no)						
						->setCellValue('A'.$cell, strval($multi_rs[0]['invoice_no']))
						->setCellValue('B'.$cell, $invoice_date)  
						->setCellValue('C'.$cell, $record->invoice_val)		
						->setCellValue('D'.$cell, $STATE_CODE.'-'.$STATE_NAME)						
						->setCellValue('E'.$cell, $record->tax_per)
						->setCellValue('F'.$cell, $record->taxable_amt)
						->setCellValue('G'.$cell, '')
						->setCellValue('H'.$cell, '')
						->setCellValue('I'.$cell,'')
						->setCellValue('J'.$cell, '');
						$cell=$cell+1;
					}

					// No. of Recipients
					$No_of_invoice_no=$No_of_Recipients=0;
					$records="select count(distinct(tbl_party_id)) No_of_Recipients
					from invoice_summary where status='SALE' 	and  invoice_date between '".$startingdate."' and '".$closingdate."' 
					and tbl_party_id in (".$stckist_ids.") and total_amt>=250000";
					$records =$this->projectmodel->get_records_from_sql($records);	
					foreach ($records as $record)	{$No_of_Recipients=$record->No_of_Recipients;}

					// No. of Invoices
					$records="select count(invoice_no) No_of_invoice_no
					from invoice_summary  where  status='SALE' and  invoice_date between 	'".$startingdate."' and '".$closingdate."' 
					and tbl_party_id in (".$stckist_ids.") and total_amt>=250000";
					$records =$this->projectmodel->get_records_from_sql($records);	
					foreach ($records as $record)	{$No_of_invoice_no=$record->No_of_invoice_no;}


					$excel2->getActiveSheet($sheet_no)
					->setCellValue('A3', $No_of_invoice_no)
					->setCellValue('C3', $total_invoice_val)					
					->setCellValue('F3', $total_taxable_value)
					->setCellValue('G3', '')
					->setCellValue('H3', '');

					//B2CL SECTION END


					//B2CS SECTION START

						$sheet_no=2;	
						$excel2->setActiveSheetIndex($sheet_no);
					
						$stockist_records=" select a.* from stockist a,acc_group_ledgers b where a.GSTNO='' and a.id=b.ref_table_id AND ref_table_name='stockist' and b.parent_id=28 ";
						$stockist_records =$this->projectmodel->get_records_from_sql($stockist_records);	
						foreach ($stockist_records as $stockist_record)
						{	
								$STATE_CODE=$stockist_record->STATE_CODE;
								if($STATE_CODE=='')
								{$STATE_CODE=19;}		

								$stckist_ids='0';
								$other_records=" select b.* from stockist a,acc_group_ledgers b where 
								a.GSTNO='' and a.id=b.ref_table_id AND ref_table_name='stockist' and b.parent_id=28 and a.STATE_CODE=".$STATE_CODE;
								$other_records =
								$this->projectmodel->get_records_from_sql($other_records);	
								foreach ($other_records as $other_record)
								{	$stckist_ids=$stckist_ids.','.$other_record->id;}
										
										
								$cell=5;
								$total_invoice_val=$total_taxable_value=0;
								$records="select sum(b.taxable_amt) taxable_amt,b.tax_per
								from invoice_summary a,invoice_details b where  a.status='SALE' 
								and  a.invoice_date between 	'".$startingdate."' and '".$closingdate."' and a.tbl_party_id in (".$stckist_ids.") 
								and  a.id=b.invoice_summary_id and a.total_amt<250000 group by b.tax_per";
								$records =$this->projectmodel->get_records_from_sql($records);	
								foreach ($records as $record)
								{
									$total_taxable_value=$total_taxable_value+$record->taxable_amt;

									$excel2->getActiveSheet($sheet_no)						
									->setCellValue('A'.$cell, 'OE')
									->setCellValue('B'.$cell, $stockist_record->STATE_CODE.'-'.$stockist_record->STATE_NAME)  
									->setCellValue('C'.$cell, $record->tax_per)		
									->setCellValue('D'.$cell, $record->taxable_amt)						
									->setCellValue('E'.$cell, '')
									->setCellValue('F'.$cell, '');
									$cell=$cell+1;
								}
						}
	
						$excel2->getActiveSheet($sheet_no)
						->setCellValue('D3', $total_taxable_value)
						->setCellValue('E3', $total_invoice_val);
	
						//B2CS SECTION END


						//HSN SECTION START

							$sheet_no=9;	
							$excel2->setActiveSheetIndex($sheet_no);
							$no_of_hsn=$totqnty=$subtotal=$taxable_amt=$cgst_amt=$sgst_amt=$igst_amt=0;
							$cell=5;
							$product_records=" select * from brands WHERE brandtype='BRAND' group by hsncode ";
							$product_records =$this->projectmodel->get_records_from_sql($product_records);	
							foreach ($product_records as $product_record)
							{												
									$no_of_hsn=$no_of_hsn+1;
									$product_ids='0';
									$other_records=" select * from brands where hsncode='".$product_record->hsncode."'";
									$other_records =
									$this->projectmodel->get_records_from_sql($other_records);	
									foreach ($other_records as $other_record)
									{	$product_ids=$product_ids.','.$other_record->id;}
									
									$records="select 
									sum(b.totqnty) totqnty,
									sum(b.subtotal) subtotal,
									sum(b.taxable_amt) taxable_amt,
									sum(b.cgst_amt) cgst_amt,
									sum(b.sgst_amt) sgst_amt,
									sum(b.igst_amt) igst_amt
									from invoice_summary a,invoice_details b where  a.status='SALE' 
									and  a.invoice_date between 	'".$startingdate."' and '".$closingdate."' and b.product_id in (".$product_ids.") 
									and  a.id=b.invoice_summary_id ";
									$records =$this->projectmodel->get_records_from_sql($records);	
									foreach ($records as $record)
									{	
									
										$subtotal=$subtotal+$record->subtotal;
										$taxable_amt=$taxable_amt+$record->taxable_amt;
										$cgst_amt=$cgst_amt+$record->cgst_amt;
										$sgst_amt=$sgst_amt+$record->sgst_amt;
										$igst_amt=$igst_amt+$record->igst_amt;

										$excel2->getActiveSheet($sheet_no)						
										->setCellValue('A'.$cell,$product_record->hsncode)
										->setCellValue('B'.$cell, $product_record->brand_name)  
										->setCellValue('C'.$cell, 'OTH')		
										->setCellValue('D'.$cell, $record->totqnty)						
										->setCellValue('E'.$cell, $record->subtotal)
										->setCellValue('F'.$cell, $record->taxable_amt)
										->setCellValue('G'.$cell, $record->igst_amt)
										->setCellValue('H'.$cell, $record->cgst_amt)
										->setCellValue('I'.$cell, $record->sgst_amt)
										->setCellValue('J'.$cell, '');									
									}
										
									 $cell=$cell+1;
									
							}
		
							$excel2->getActiveSheet($sheet_no)		
							->setCellValue('A3', $no_of_hsn)					
							->setCellValue('E3', $subtotal)
							->setCellValue('F3', $taxable_amt)
							->setCellValue('G3', $igst_amt)
							->setCellValue('H3', $cgst_amt)
							->setCellValue('I3', $sgst_amt)
							->setCellValue('J3', '');
							
							//HSN SECTION START
							
							//CDNR SECTION START
							$sheet_no=3;
							$excel2->setActiveSheetIndex($sheet_no);
							//GST REGISTERED PARTY
							// $debtor_creditor_ids='0';
							// $other_records=" select b.* from stockist a,acc_group_ledgers b where a.GSTNO<>'' and a.id=b.ref_table_id AND ref_table_name='stockist' and b.parent_id=28 ";
							// $other_records =
							// $this->projectmodel->get_records_from_sql($other_records);	
							// foreach ($other_records as $other_record)
							// {$debtor_creditor_ids=$debtor_creditor_ids.','.$other_record->id;}
											
											
							$cell=5;
							$total_invoice_val=$total_taxable_value=0;
							$records="select sum(b.subtotal) invoice_val,sum(b.taxable_amt) taxable_amt,b.tax_per,b.invoice_summary_id,a.status 
							from invoice_summary a,invoice_details b where  (a.status='SALE_RTN' or  a.status='PURCHASE_RTN')
							and  a.invoice_date between 	'".$startingdate."' and '".$closingdate."' 	and  a.id=b.invoice_summary_id group by a.invoice_no,b.tax_per";
							$records =$this->projectmodel->get_records_from_sql($records);	
							foreach ($records as $record)
							{
								
								$total_invoice_val=$total_invoice_val+$record->invoice_val;
								$total_taxable_value=$total_taxable_value+$record->taxable_amt;
								
								//$invoice_no=$this->projectmodel->GetSingleVal('invoice_no','invoice_summary',' id='.$record->invoice_summary_id); 		
								 $whr="id=".$record->invoice_summary_id;
								 $multi_rs=$this->projectmodel->GetMultipleVal('*','invoice_summary',$whr);
		
								 $invoice_date=date_create($multi_rs[0]['invoice_date']);
								 $invoice_date=date_format($invoice_date,"d-M-Y");
								 $GSTNO=$STATE_CODE=$STATE_NAME='';
								 
								 if($multi_rs[0]['status']=='SALE_RTN')
								 {
									  $doc_type='C';$doc_reason='01-Sales Return';
									  $stockist_id=$this->projectmodel->GetSingleVal('ref_table_id','acc_group_ledgers',' id='.$multi_rs[0]['tbl_party_id']); 
										$GSTNO=$this->projectmodel->GetSingleVal('GSTNO','stockist',' id='.$stockist_id); 
										$STATE_CODE=$this->projectmodel->GetSingleVal('STATE_CODE','stockist',' id='.$stockist_id); 
										$STATE_NAME=$this->projectmodel->GetSingleVal('STATE_NAME','stockist',' id='.$stockist_id); 
								 }
								 if($multi_rs[0]['status']=='PURCHASE_RTN')
								 {
									 $doc_type='D';$doc_reason='03-Deficiency in services';
									 $party_id=$this->projectmodel->GetSingleVal('ref_table_id','acc_group_ledgers',' id='.$multi_rs[0]['tbl_party_id']); 
									 $GSTNO=$this->projectmodel->GetSingleVal('GSTNO','tbl_party',' id='.$party_id); 
									 $STATE_CODE=$this->projectmodel->GetSingleVal('State_stateCode','tbl_party',' id='.$party_id); 
									// $STATE_NAME=$this->projectmodel->GetSingleVal('STATE_NAME','tbl_party',' id='.$party_id); 								
							   }
								 
								
								$excel2->getActiveSheet($sheet_no)
								->setCellValue('A'.$cell, $GSTNO)
								->setCellValue('B'.$cell, '')
								->setCellValue('C'.$cell,'')  
								->setCellValue('D'.$cell, strval($multi_rs[0]['invoice_no']))  
								->setCellValue('E'.$cell, $invoice_date)  
								->setCellValue('F'.$cell, $doc_type)
								->setCellValue('G'.$cell, $doc_reason)
								->setCellValue('H'.$cell, $STATE_CODE.'-'.$STATE_NAME)
								->setCellValue('I'.$cell, $record->invoice_val)
								->setCellValue('J'.$cell, $record->tax_per)
								->setCellValue('K'.$cell, $record->taxable_amt)
								->setCellValue('L'.$cell, '')
								->setCellValue('M'.$cell, 'N');
							
								$cell=$cell+1;
							}
		
							// No. of Recipients

							// $No_of_invoice_no=$No_of_Recipients=0;
							//  $records="select count(distinct(tbl_party_id)) No_of_Recipients
							// from invoice_summary where status='SALE' 	and  invoice_date between '".$startingdate."' and '".$closingdate."' 
							// and tbl_party_id in (".$stckist_ids.") ";
							// $records =$this->projectmodel->get_records_from_sql($records);	
							// foreach ($records as $record)	{$No_of_Recipients=$record->No_of_Recipients;}
		
							// 	// No. of Invoices
							
							// 		$records="select count(invoice_no) No_of_invoice_no
							// 	from invoice_summary  where  status='SALE' and  invoice_date between 	'".$startingdate."' and '".$closingdate."' 
							// 	and tbl_party_id in (".$stckist_ids.") ";
							// 	$records =$this->projectmodel->get_records_from_sql($records);	
							// 	foreach ($records as $record)	{$No_of_invoice_no=$record->No_of_invoice_no;}
		
		
							// $excel2->getActiveSheet($sheet_no)
							// ->setCellValue('A3', $No_of_Recipients)
							// ->setCellValue('B3', $No_of_invoice_no)					
							// ->setCellValue('D3', $total_invoice_val)
							// ->setCellValue('J3', $total_taxable_value)
							// ->setCellValue('K3', '');

							//CDNR SECTION END

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
					//$objWriter = PHPExcel_IOFactory::createWriter($excel2, 'Excel2007');   
					
					//force user to download the Excel file without writing it to server's HD
					$objWriter->save('php://output');
			
				//test section end








				
			// 	$mainindx=$balance=0;	
			// 	$startingdate=$data['startingdate']=$param_array['fromdate'];
			// 	$closingdate=$data['closingdate']=$param_array['todate'];
				
		  // 	$sheet = $this->excel->getActiveSheet();     
				     
			// 	// SHEET B2B
			// 	$i=1;
			// 	$objWorkSheet1 = $this->excel->createSheet($i); //Setting index when creating
			// 	 $total_invoice_value=0;
			// 		$objWorkSheet1->setCellValue('A1', 'Summary For B2B(4)')
			// 							 ->setCellValue('A2', 'No. of Recipients!')
			// 							 ->setCellValue('B2', 'No. of Invoices')
			// 							 ->setCellValue('D2', 'Total Invoice Value');
		
			// 	 $objWorkSheet1->setCellValue('A4', 'GSTIN/UIN of Recipient')
			// 				->setCellValue('B4', 'Party Name')
			// 				->setCellValue('C4', 'Invoice Number')
			// 							 ->setCellValue('D4', 'Invoice date')
			// 							 ->setCellValue('E4', 'Invoice Value')
			// 			 ->setCellValue('F4', 'Place Of Supply')
			// 			 ->setCellValue('G4', 'Reverse Charge')
			// 			 ->setCellValue('H4', 'Invoice Type')
			// 			 ->setCellValue('I4', 'E-Commerce GSTIN')
			// 			 ->setCellValue('J4', 'Rate')
			// 			 ->setCellValue('K4', 'Taxable Value')
			// 			 ->setCellValue('L4', 'Cess Amount');
		
			// 		// DATA portion
					
					
			// 		$stckist_ids=0;
			// 		$other_records=" select b.* from tbl_party a,acc_group_ledgers b where a.GSTNo<>'' and a.id=b.ref_table_id and b.VOUCHER_TYPE='SUNDRY_DEBTORS' ";
			// 		$other_records =
			// 		$this->projectmodel->get_records_from_sql($other_records);	
			// 		foreach ($other_records as $other_record)
			// 		{$stckist_ids=$other_record->id.','.$stckist_ids;}
			// 		$len=strlen($stckist_ids);
			// 		 $stckist_ids=substr($stckist_ids,0,$len-1);
			// 		$stckist_ids=$stckist_ids.'0';
			// 		if( $stckist_ids=='')
			// 		{ $stckist_ids=0;}
					
									
			// 		$cell=5;
			// 		$records="select * from invoice_summary where  status='SALE'  ";
			// 		if($startingdate<>'' and $closingdate<>'')
			// 		{
			// 			$records=$records." and invoice_date between 
			// 			'".$startingdate."' and '".$closingdate."' ";							
			// 		}		
			// 		 $records=$records." order by invoice_date";
			// 		$records =$this->projectmodel->get_records_from_sql($records);	
			// 		foreach ($records as $record)
			// 		{
					
			// 		$statename_code=$gstno='';
			// 		 $other_records=" select a.* from stockist a,acc_group_ledgers b where a.id=b.ref_table_id and b.ref_table_name='stockist' and
			// 		  a.GSTNO<>'' and b.id=".$record->tbl_party_id;
			// 		$other_records =
			// 		$this->projectmodel->get_records_from_sql($other_records);	
			// 		foreach ($other_records as $other_record)
			// 		{
			// 			$gstno=$other_record->GSTNO;
			// 			$partyname=$other_record->retail_name;
			// 			$statename_code=$other_record->STATE_CODE;

			// 			// $whr="id=".$other_record->State_stateCode;
			// 			// $rs=$this->projectmodel->GetMultipleVal('*','misc_mstr',$whr);
			// 			// $json_array_count=sizeof($rs);	 
			// 			// for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			// 			// {$statename_code=$rs[$fieldIndex]['name_value'].'-'.$rs[$fieldIndex]['name'];}				
	
			// 			//$statename_code=$other_record->STATE_CODE.'-'.$other_record->STATE_NAME;
			// 		}
					
				
			// 		$gstrate=$taxable_amt=0;
			// 		$other_records="select * from invoice_details where invoice_summary_id=".$record->id."";
			// 		$other_records =
			// 		$this->projectmodel->get_records_from_sql($other_records);	
			// 		foreach ($other_records as $other_record)
			// 		{
			// 			$gstrate=$other_record->tax_per;
			// 			$taxable_amt=$taxable_amt+$other_record->taxable_amt;
			// 		}
			// 		//$taxable_amt=round($taxable_amt*$gstrate/100,2);
					
			// 		$month='';
			// 		if(substr($record->invoice_date,5,2)=='01')
			// 		{ $month='JAN';  }
			// 		if(substr($record->invoice_date,5,2)=='02')
			// 		{  $month='FEB';  }
			// 		if(substr($record->invoice_date,5,2)=='03')
			// 		{  $month='MAR';  }
			// 		if(substr($record->invoice_date,5,2)=='04')
			// 		{  $month='APR';  }
			// 		if(substr($record->invoice_date,5,2)=='05')
			// 		{  $month='MAY';  }
			// 		if(substr($record->invoice_date,5,2)=='06')
			// 		{  $month='JUN';  }
			// 		if(substr($record->invoice_date,5,2)=='07')
			// 		{  $month='JUL';  }
			// 		if(substr($record->invoice_date,5,2)=='08')
			// 		{ $month='AUG';   }
			// 		if(substr($record->invoice_date,5,2)=='09')
			// 		{  $month='SEP';  }
			// 		if(substr($record->invoice_date,5,2)=='10')
			// 		{  $month='OCT';  }
			// 		if(substr($record->invoice_date,5,2)=='11')
			// 		{  $month='NOV';  }
			// 		if(substr($record->invoice_date,5,2)=='12')
			// 		{  $month='DEC';  }
					
					
			// 		$newdate=
			// 		substr($record->invoice_date,8,2).'-'.
			// 		$month.'-'.
			// 		substr($record->invoice_date,2,2);
					
			// 			if($gstno<>'')
			// 			{
			// 				$total_invoice_value=$total_invoice_value+$record->grandtot;
							
			// 				$objWorkSheet1->setCellValue('A'.$cell, $gstno)
			// 					 ->setCellValue('B'.$cell, $partyname)
			// 					 ->setCellValue('C'.$cell, $record->invoice_no)
			// 					 ->setCellValue('D'.$cell, $newdate)
			// 					 ->setCellValue('E'.$cell, $record->grandtot)
			// 					 ->setCellValue('F'.$cell, $statename_code)
			// 					 ->setCellValue('G'.$cell, 'N/Y')
			// 					 ->setCellValue('H'.$cell, 'Regular')
			// 					 ->setCellValue('I'.$cell, '')
			// 					 ->setCellValue('J'.$cell, $gstrate)
			// 					 ->setCellValue('K'.$cell, $taxable_amt)
			// 					 ->setCellValue('L'.$cell, '');
						
			// 					$cell=$cell+1;	   
			// 			 }
			// 		}
					
					
			// 		$No_of_invoice=$No_of_Recipients=0;
			// 		$records="select distinct(tbl_party_id) No_of_Recipients  from invoice_summary where  status='SALE' 
			// 		and  tbl_party_id in (".$stckist_ids.") ";
			// 		if($startingdate<>'' and $closingdate<>'')
			// 		{
			// 			$records=$records." and invoice_date between 
			// 			'".$startingdate."' and '".$closingdate."' ";							
			// 		}	
			// 		$records =$this->projectmodel->get_records_from_sql($records);	
			// 		foreach ($records as $record)
			// 		{ $No_of_Recipients=$No_of_Recipients+1;}
					
			// 		$records="select count(*) 	No_of_invoice  from invoice_summary where  status='SALE' 	and  tbl_party_id in (".$stckist_ids.") ";
			// 		if($startingdate<>'' and $closingdate<>'')
			// 		{
			// 			$records=$records." and invoice_date between 
			// 			'".$startingdate."' and '".$closingdate."' ";							
			// 		}		
			// 		$records =$this->projectmodel->get_records_from_sql($records);	
			// 		foreach ($records as $record)
			// 		{ $No_of_invoice=$record->No_of_invoice;}
					
					
			// 		$objWorkSheet1->setCellValue('A3', $No_of_Recipients)
			// 							 ->setCellValue('B3',  $No_of_invoice)
			// 							 ->setCellValue('D3', $total_invoice_value);
					
					
					
			// 				// Rename sheet
			// 			 $objWorkSheet1->setTitle("B2B");
		
			
			
			//  /*  ================================================================  */
						
			//   //B2CS SECTION  START
			// 	 $total_invoice_value=0;	
			// 	 $i=2;
			// 		$objWorkSheet2 = $this->excel->createSheet($i); //Setting index when creating
				
			// 		$objWorkSheet2->setCellValue('A1', 'Summary For B2CS(7)')
			// 					 ->setCellValue('D2', 'Total Taxable  Value')
			// 					 ->setCellValue('E2', 'Total Cess');
				
			// 		$objWorkSheet2->setCellValue('A4', 'Type')
			// 					 ->setCellValue('B4', 'Place Of Supply')
			// 					 ->setCellValue('C4', 'Rate')
			// 					 ->setCellValue('D4', 'Taxable Value')
			// 					 ->setCellValue('E4', 'Cess Amount')
			// 					 ->setCellValue('F4', 'E-Commerce GSTIN')
			// 						->setCellValue('G4', 'Total tax Amount')
			// 					->setCellValue('H4', 'Grand Total');
								 
		
			// 		// DATA portion
			// 		$cell=5;
			// 		$records="select * from invoice_summary where  status='SALE'  ";
			// 		if($startingdate<>'' and $closingdate<>'')
			// 		{
			// 			$records=$records." and invoice_date between 
			// 			'".$startingdate."' and '".$closingdate."' ";							
			// 		}		
			// 		$records=$records." order by invoice_date";
			// 		$records =$this->projectmodel->get_records_from_sql($records);	
			// 		foreach ($records as $record)
			// 		{
					
			// 		$statename_code='19-West Bengal';
			// 		$gstno='';
			// 		$other_records=" select a.* from tbl_party a,acc_group_ledgers b where a.GSTNo<>'' and b.id=".$record->tbl_party_id;
			// 		$other_records =
			// 		$this->projectmodel->get_records_from_sql($other_records);	
			// 		foreach ($other_records as $other_record)
			// 		{
			// 			$gstno=$other_record->GSTNo;
	
			// 			$whr="id=".$other_record->State_stateCode;
			// 			$rs=$this->projectmodel->GetMultipleVal('*','misc_mstr',$whr);
			// 			$json_array_count=sizeof($rs);	 
			// 			for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			// 			{$statename_code=$rs[$fieldIndex]['name_value'].'-'.$rs[$fieldIndex]['name'];}	
					
			// 		}
					
					
			// 			if($gstno=='')
			// 			{
							
			// 				$total_value=$tax_amount=$gstrate=$taxable_amt=0;
			// 				$other_records="select * from invoice_details 	where invoice_summary_id=".$record->id."";
			// 				$other_records =
			// 				$this->projectmodel->get_records_from_sql($other_records);	
			// 				foreach ($other_records as $other_record)
			// 				{
			// 					$gstrate=$other_record->tax_per;
			// 					$taxable_amt=$taxable_amt+$other_record->taxable_amt;
			// 					$tax_amount=$tax_amount+$other_record->cgst_amt+
			// 					$other_record->sgst_amt+$other_record->igst_amt;
			// 				}
							
							
			// 				 $total_invoice_value=$total_invoice_value+$taxable_amt;
			// 				 $objWorkSheet2->setCellValue('A'.$cell, 'E')
			// 					 ->setCellValue('B'.$cell, $statename_code)
			// 					 ->setCellValue('C'.$cell, $gstrate)
			// 					 ->setCellValue('D'.$cell, $taxable_amt)
			// 					 ->setCellValue('E'.$cell, 'Cess Amount')
			// 					 ->setCellValue('F'.$cell, 'E-Commerce GSTIN')
			// 					 ->setCellValue('G'.$cell, $tax_amount)
			// 					 ->setCellValue('H'.$cell, $tax_amount+$taxable_amt);
						
			// 					$cell=$cell+1;	   
			// 			 }
			// 		  }
					
					
			// 		 $objWorkSheet2->setCellValue('D3', $total_invoice_value);
			// 				// Rename sheet
			// 			 $objWorkSheet2->setTitle("B2CS");
					
			// 		//B2CS SECTION  END 
					
			// 		 /*  ================================================================  */
					
					
					
			// 		 //HSN SECTION  START 
					
			// 		 $total_invoice_value=0;	
			// 		 $i=3;
			// 		$objWorkSheet = $this->excel->createSheet($i); //Setting index when creating
				
			// 		$objWorkSheet->setCellValue('A1', 'Summary For HSN(12)')
			// 					 ->setCellValue('A2', 'No. of HSN')
			// 					 ->setCellValue('E2', 'Total Value')
			// 					 ->setCellValue('F2', 'Total Taxable Value')
			// 					 ->setCellValue('G2', 'Total Integrated Tax')
			// 					 ->setCellValue('H2', 'Total Central Tax')
			// 					 ->setCellValue('I2', 'Total State/UT Tax')
			// 					 ->setCellValue('J2', 'Total Cess');
				
			// 		$objWorkSheet->setCellValue('A4', 'HSN')
			// 					 ->setCellValue('B4', 'Description')
			// 					 ->setCellValue('C4', 'UQC')
			// 					 ->setCellValue('D4', 'Total Quantity')
			// 					 ->setCellValue('E4', 'Total Value')
			// 					 ->setCellValue('F4', 'Taxable Value')
			// 					 ->setCellValue('G4', 'Integrated Tax Amount')
			// 					 ->setCellValue('H4', 'Central Tax Amount')
			// 					 ->setCellValue('I4', 'State/UT Tax Amount')
			// 					 ->setCellValue('J4', 'Cess Amount');
								 
		
			// 		// DATA portion
			// 		$cell=5;
					
			// 		$invoice_summary_id=0;
			// 		$records="select * from invoice_summary where  status='SALE'  ";
			// 		if($startingdate<>'' and $closingdate<>'')
			// 		{
			// 			$records=$records." and invoice_date between 
			// 			'".$startingdate."' and '".$closingdate."' ";							
			// 		}		
			// 		$records =$this->projectmodel->get_records_from_sql($records);	
			// 		foreach ($records as $record)
			// 		{$invoice_summary_id=$invoice_summary_id.','.$record->id;}
			// 		$invoice_summary_id=rtrim($invoice_summary_id, ',');
					
			// 		$TotalValueGrand=$TaxableValueGrand=$CentralTaxAmountGrand=0;
			// 		$StateTaxAmountGrand=0;
			// 		$IntegratedTaxAmountGrand=0;
					
			// 		$gstno='';
			// 		$other_records=" select * from brands 	where brandtype='BRAND' AND  hsncode<>''";
			// 		$other_records =
			// 		$this->projectmodel->get_records_from_sql($other_records);	
			// 		foreach ($other_records as $other_record)
			// 		{  
			// 			$hsncode=$other_record->hsncode;
			// 			$product_id=$other_record->id;
			// 			$brand_name=$other_record->brand_name;
					
			// 			$gstrate=$taxable_amt=0;
			// 			$other_records="select 
			// 			sum(qnty) TotalQuantity,
			// 			sum(subtotal) TotalValue,
			// 			sum(taxable_amt) TaxableValue,
			// 			sum(cgst_amt) CentralTaxAmount,
			// 			sum(sgst_amt) StateTaxAmount,
			// 			sum(igst_amt) IntegratedTaxAmount
						
			// 			 from invoice_details 
			// 			where invoice_summary_id in (".$invoice_summary_id.") 
			// 			and product_id=".$product_id;
			// 			$other_records =
			// 			$this->projectmodel->get_records_from_sql($other_records);	
			// 			foreach ($other_records as $other_record)
			// 			{
			// 				$TotalQuantity=$other_record->TotalQuantity;
			// 				//$TotalValue=$other_record->TotalValue;
			// 				$TaxableValue=$other_record->TaxableValue;
							
			// 				$CentralTaxAmount=$other_record->CentralTaxAmount;
			// 				$StateTaxAmount=$other_record->StateTaxAmount;
			// 				$IntegratedTaxAmount=$other_record->IntegratedTaxAmount;
							
			// 				$TotalValue=$TaxableValue+$CentralTaxAmount+
			// 				$StateTaxAmount+$IntegratedTaxAmount;
							
			// 				$TotalValueGrand=
			// 				$TotalValueGrand+$TotalValue;
							
			// 				$TaxableValueGrand=
			// 				$TaxableValueGrand+$other_record->TaxableValue;
							
			// 				$CentralTaxAmountGrand=
			// 				$CentralTaxAmountGrand+$other_record->CentralTaxAmount;
							
			// 				$StateTaxAmountGrand=
			// 				$StateTaxAmountGrand+$other_record->StateTaxAmount;
							
			// 				$IntegratedTaxAmountGrand=
			// 				$IntegratedTaxAmountGrand+$other_record->IntegratedTaxAmount;
							
			// 			}
						
			// 				 $objWorkSheet->setCellValue('A'.$cell, $hsncode)
			// 					 ->setCellValue('B'.$cell, $brand_name)
			// 					 ->setCellValue('C'.$cell, '-')
			// 					 ->setCellValue('D'.$cell, $TotalQuantity)
			// 					 ->setCellValue('E'.$cell, $TotalValue)
			// 					 ->setCellValue('F'.$cell, $TaxableValue)
			// 					 ->setCellValue('G'.$cell, $IntegratedTaxAmount)
			// 					 ->setCellValue('H'.$cell, $CentralTaxAmount)
			// 					 ->setCellValue('I'.$cell, $StateTaxAmount)
			// 					 ->setCellValue('J'.$cell, 'Cess Amount');
							
			// 					$cell=$cell+1;	   
			// 		}
					
			// 			$objWorkSheet->setCellValue('E3', $TotalValueGrand)
			// 					 ->setCellValue('F3', $TaxableValueGrand)
			// 					 ->setCellValue('G3', $IntegratedTaxAmountGrand)
			// 					 ->setCellValue('H3', $CentralTaxAmountGrand)
			// 					 ->setCellValue('I3', $StateTaxAmountGrand)
			// 					 ->setCellValue('J3', 'Total Cess');
					
			// 		// $objWorkSheet->setCellValue('D3', $total_invoice_value);
			// 				// Rename sheet
			// 			 $objWorkSheet->setTitle("HSN");
					
					
					
			// 		//HSN SECTION  END  
					
					
				
			// 	$filename='GST.xls'; //save our workbook as this file name
			// 	header('Content-Type: application/vnd.ms-excel'); //mime type
			// 	header('Content-Disposition: attachment;filename="'.$filename.'"'); 
			// 	//tell browser what's the file name
			// 	header('Cache-Control: max-age=0'); //no cache
							
			// 	//save it to Excel5 format (excel 2003 .XLS file), 
			// 	//change this to 'Excel2007' (and adjust the filename 
			// 	//extension, also the header mime type)
			// 	//if you want to save it as .XLSX Excel 2007 format
			// 	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
			// 	//force user to download the Excel file without writing it to server's HD
			// 	$objWriter->save('php://output');

		}


		if($REPORT_NAME=='BILL_WISE_PURCHASE') 
		{
			//delete invalid	
			$status='';
			$inv_detail_id='';
			$mfg_monyr='';
			$exp_monyr='';
			$totqnty='';
			
			
				$mainindx=$balance=0;
				$records="select * 	from invoice_summary where  invoice_date 	between '".$param_array['fromdate']."' and '".$param_array['todate']."' 
				and status='PURCHASE' order by invoice_date,id";
				$records = $this->projectmodel->get_records_from_sql($records);
				foreach ($records as $key=>$record)
				{ 
				
					$rsval[$mainindx]['invoice_no']=$record->invoice_no; 
					$rsval[$mainindx]['invoice_date']=$record->invoice_date; 
					$whr="id=".$record->tbl_party_id;
					$tbl_party_id=$this->projectmodel->GetSingleVal('ref_table_id','acc_group_ledgers',$whr); 
					$rsval[$mainindx]['party_name']=$this->projectmodel->GetSingleVal('party_name','tbl_party',' id='.$tbl_party_id); 
					$rsval[$mainindx]['GSTNO']=$this->projectmodel->GetSingleVal('GSTNo','tbl_party',' id='.$tbl_party_id); 
					$rsval[$mainindx]['destination']=$this->projectmodel->GetSingleVal('address','tbl_party',' id='.$tbl_party_id); ; 
					
					//INPUT GST
					//5% gst section
					$tax_ledger_id=1810;
					$details = "select sum(taxable_amt) taxable_amt,sum(cgst_amt) cgst_amt,sum(sgst_amt) sgst_amt,sum(igst_amt) igst_amt from invoice_details 
					where  	tax_ledger_id=".$tax_ledger_id." and invoice_summary_id=".$record->id ;
					$details = $this->projectmodel->get_records_from_sql($details);
					if(count($details)>0){foreach ($details as $detail)
					{
						
						$rsval[$mainindx]['taxable_amt_5']=$detail->taxable_amt; 
						$rsval[$mainindx]['CGST_5']=$detail->cgst_amt; 
						$rsval[$mainindx]['SGST_5']=$detail->sgst_amt; 
						$rsval[$mainindx]['IGST_5']=$detail->igst_amt; 
						$rsval[$mainindx]['amount_with_tax_5']=$detail->taxable_amt+$detail->cgst_amt+$detail->sgst_amt+$detail->igst_amt; 					
					}}
	
	
					//12% gst section
					$tax_ledger_id=1811;
					$details = "select sum(taxable_amt) taxable_amt,sum(cgst_amt) cgst_amt,sum(sgst_amt) sgst_amt,sum(igst_amt) igst_amt from invoice_details 
					where  	tax_ledger_id=".$tax_ledger_id." and invoice_summary_id=".$record->id ;
					$details = $this->projectmodel->get_records_from_sql($details);
					if(count($details)>0){foreach ($details as $detail)
					{
						
						$rsval[$mainindx]['taxable_amt_12']=$detail->taxable_amt; 
						$rsval[$mainindx]['CGST_12']=$detail->cgst_amt; 
						$rsval[$mainindx]['SGST_12']=$detail->sgst_amt; 
						$rsval[$mainindx]['IGST_12']=$detail->igst_amt; 
						$rsval[$mainindx]['amount_with_tax_12']=$detail->taxable_amt+$detail->cgst_amt+$detail->sgst_amt+$detail->igst_amt; 					
					}}
	
					//18% gst section
					$tax_ledger_id=1812;
					$details = "select sum(taxable_amt) taxable_amt,sum(cgst_amt) cgst_amt,sum(sgst_amt) sgst_amt,sum(igst_amt) igst_amt from invoice_details 
					where  	tax_ledger_id=".$tax_ledger_id." and invoice_summary_id=".$record->id ;
					$details = $this->projectmodel->get_records_from_sql($details);
					if(count($details)>0){foreach ($details as $detail)
					{
						
						$rsval[$mainindx]['taxable_amt_18']=$detail->taxable_amt; 
						$rsval[$mainindx]['CGST_18']=$detail->cgst_amt; 
						$rsval[$mainindx]['SGST_18']=$detail->sgst_amt; 
						$rsval[$mainindx]['IGST_18']=$detail->igst_amt; 
						$rsval[$mainindx]['amount_with_tax_18']=$detail->taxable_amt+$detail->cgst_amt+$detail->sgst_amt+$detail->igst_amt; 					
					}}
	
					// $rsval[$mainindx]['freegoods']=0;
					// $details = "select sum(freeqty*srate) freegoods_amt from invoice_details where   invoice_summary_id=".$record->id ;
					// $details = $this->projectmodel->get_records_from_sql($details);
					// if(count($details)>0){foreach ($details as $detail)
					// {
					// 	$rsval[$mainindx]['freegoods']=$detail->freegoods_amt; 
					// }}
					
					
					// $rsval[$mainindx]['interest_charge']=$record->interest_charge; 
					// $rsval[$mainindx]['delivery_charge']=$record->freight_charge; 
					// $rsval[$mainindx]['cash_discount']=$record->tot_cash_discount; 
	
					$rsval[$mainindx]['round_off']=$record->rndoff; 
					$rsval[$mainindx]['grand_total']=$record->grandtot; 
	
	
					$rsval[$mainindx]['href']='';
					$mainindx=$mainindx+1;
				}
	
				return $rsval;		
		}


		if($REPORT_NAME=='BILL_WISE_SALE') 
		{
			//delete invalid	
			$status='';
			$inv_detail_id='';
			$mfg_monyr='';
			$exp_monyr='';
			$totqnty='';
				
				$debtor_ledges=$this->projectmodel->gethierarchy_list($current_hq_id,'HQ_WISE_DEBTOR_LEDGERS');

				$mainindx=$balance=0;
				if($param_array['ledger_ac']==0)
				{
					$records="select * 	from invoice_summary where  invoice_date 	between '".$param_array['fromdate']."' and '".$param_array['todate']."' 
					and status='SALE' and tbl_party_id in (".$debtor_ledges.") order by invoice_date,id";
				}
				else
				{
					$records="select * 	from invoice_summary where tbl_party_id=".$param_array['ledger_ac']." 
					and  invoice_date 	between '".$param_array['fromdate']."' and '".$param_array['todate']."' 
					and status='SALE' order by invoice_date,id";
				}
				
				$records = $this->projectmodel->get_records_from_sql($records);
				foreach ($records as $key=>$record)
				{ 
				
					$rsval[$mainindx]['invoice_no']=$record->invoice_no; 
					$rsval[$mainindx]['invoice_date']=$record->invoice_date; 
					$whr="id=".$record->tbl_party_id;
					$tbl_party_id=$this->projectmodel->GetSingleVal('ref_table_id','acc_group_ledgers',$whr); 
					$rsval[$mainindx]['party_name']=$this->projectmodel->GetSingleVal('retail_name','stockist',' id='.$tbl_party_id); 
					$rsval[$mainindx]['GSTNO']=$this->projectmodel->GetSingleVal('GSTNO','stockist',' id='.$tbl_party_id); 
					$rsval[$mainindx]['destination']=$this->projectmodel->GetSingleVal('retail_address','stockist',' id='.$tbl_party_id); ; 
					
	
					//5% gst section
					$tax_ledger_id=319;
					$details = "select sum(taxable_amt) taxable_amt,sum(cgst_amt) cgst_amt,sum(sgst_amt) sgst_amt,sum(igst_amt) igst_amt from invoice_details 
					where  	tax_ledger_id=".$tax_ledger_id." and invoice_summary_id=".$record->id ;
					$details = $this->projectmodel->get_records_from_sql($details);
					if(count($details)>0){foreach ($details as $detail)
					{
						
						$rsval[$mainindx]['taxable_amt_5']=$detail->taxable_amt; 
						$rsval[$mainindx]['CGST_5']=$detail->cgst_amt; 
						$rsval[$mainindx]['SGST_5']=$detail->sgst_amt; 
						$rsval[$mainindx]['IGST_5']=$detail->igst_amt; 
						$rsval[$mainindx]['amount_with_tax_5']=$detail->taxable_amt+$detail->cgst_amt+$detail->sgst_amt+$detail->igst_amt; 					
					}}
	
	
					//12% gst section
					$tax_ledger_id=320;
					$details = "select sum(taxable_amt) taxable_amt,sum(cgst_amt) cgst_amt,sum(sgst_amt) sgst_amt,sum(igst_amt) igst_amt from invoice_details 
					where  	tax_ledger_id=".$tax_ledger_id." and invoice_summary_id=".$record->id ;
					$details = $this->projectmodel->get_records_from_sql($details);
					if(count($details)>0){foreach ($details as $detail)
					{
						
						$rsval[$mainindx]['taxable_amt_12']=$detail->taxable_amt; 
						$rsval[$mainindx]['CGST_12']=$detail->cgst_amt; 
						$rsval[$mainindx]['SGST_12']=$detail->sgst_amt; 
						$rsval[$mainindx]['IGST_12']=$detail->igst_amt; 
						$rsval[$mainindx]['amount_with_tax_12']=$detail->taxable_amt+$detail->cgst_amt+$detail->sgst_amt+$detail->igst_amt; 					
					}}
	
					//18% gst section
					$tax_ledger_id=321;
					$details = "select sum(taxable_amt) taxable_amt,sum(cgst_amt) cgst_amt,sum(sgst_amt) sgst_amt,sum(igst_amt) igst_amt from invoice_details 
					where  	tax_ledger_id=".$tax_ledger_id." and invoice_summary_id=".$record->id ;
					$details = $this->projectmodel->get_records_from_sql($details);
					if(count($details)>0){foreach ($details as $detail)
					{
						
						$rsval[$mainindx]['taxable_amt_18']=$detail->taxable_amt; 
						$rsval[$mainindx]['CGST_18']=$detail->cgst_amt; 
						$rsval[$mainindx]['SGST_18']=$detail->sgst_amt; 
						$rsval[$mainindx]['IGST_18']=$detail->igst_amt; 
						$rsval[$mainindx]['amount_with_tax_18']=$detail->taxable_amt+$detail->cgst_amt+$detail->sgst_amt+$detail->igst_amt; 					
					}}
	
					// $rsval[$mainindx]['freegoods']=0;
					// $details = "select sum(freeqty*srate) freegoods_amt from invoice_details where   invoice_summary_id=".$record->id ;
					// $details = $this->projectmodel->get_records_from_sql($details);
					// if(count($details)>0){foreach ($details as $detail)
					// {
					// 	$rsval[$mainindx]['freegoods']=$detail->freegoods_amt; 
					// }}
					
					
					// $rsval[$mainindx]['interest_charge']=$record->interest_charge; 
					// $rsval[$mainindx]['delivery_charge']=$record->freight_charge; 
					// $rsval[$mainindx]['cash_discount']=$record->tot_cash_discount; 
	
					$rsval[$mainindx]['round_off']=$record->rndoff; 
					$rsval[$mainindx]['grand_total']=$record->grandtot; 
					$rsval[$mainindx]['href']='';
					$mainindx=$mainindx+1;
				}
	
				return $rsval;		
		}
	
	
		if($REPORT_NAME=='HSN_WISE_SALE') 
		{
		
					$mainindx=$balance=0;		

					$debtor_ledges=$this->projectmodel->gethierarchy_list($current_hq_id,'HQ_WISE_DEBTOR_LEDGERS');

					// $mainindx=$balance=0;
					// if($param_array['ledger_ac']==0)
					// {
					// 	$records="select * 	from invoice_summary where  invoice_date 	between '".$param_array['fromdate']."' and '".$param_array['todate']."' 
					// 	and status='SALE' and tbl_party_id in (".$debtor_ledges.") order by invoice_date,id";
					// }
	
				  $records = "select b.product_id,c.brand_name,c.hsncode from invoice_summary a,invoice_details b,brands c 
					where a.invoice_date 	between '".$param_array['fromdate']."' and '".$param_array['todate']."'
				  and a.status='SALE' and a.tbl_party_id in (".$debtor_ledges.") and a.id=b.invoice_summary_id and b.product_id=c.id group by b.product_id " ;
					$records = $this->projectmodel->get_records_from_sql($records);
					if(count($records)>0){foreach ($records as $record)
					{
	
						$details = "select sum(b.qnty) tot_qnty,sum(b.subtotal) tot_value
						,sum(b.taxable_amt) taxable_amt,sum(b.cgst_amt) cgst_amt,sum(b.sgst_amt) sgst_amt,sum(b.igst_amt) igst_amt from 
						invoice_summary a,invoice_details b	where  	
						a.invoice_date 	between '".$param_array['fromdate']."' and '".$param_array['todate']."' 
						and a.status='SALE' and a.tbl_party_id in (".$debtor_ledges.") and a.id=b.invoice_summary_id and b.product_id=".$record->product_id ;
						$details = $this->projectmodel->get_records_from_sql($details);
						if(count($details)>0){foreach ($details as $detail)
						{
							$rsval[$mainindx]['hsn_code']=$record->hsncode; 
							$rsval[$mainindx]['hsn_desc']=$record->brand_name; 
							$rsval[$mainindx]['uqc']=''; 
							$rsval[$mainindx]['tot_qnty']=$detail->tot_qnty; 										
							$rsval[$mainindx]['taxable_amt']=$detail->taxable_amt;
							$rsval[$mainindx]['igst_amt']=$detail->igst_amt;
							$rsval[$mainindx]['cgst_amt']=$detail->cgst_amt;
							$rsval[$mainindx]['sgst_amt']=$detail->sgst_amt;

							$rsval[$mainindx]['tot_value']=$rsval[$mainindx]['taxable_amt']+$rsval[$mainindx]['igst_amt']+$rsval[$mainindx]['cgst_amt']+$rsval[$mainindx]['sgst_amt']; 	
							$rsval[$mainindx]['href']='';
							$mainindx=$mainindx+1;
						}}
	
				}}
				return $rsval;		
		}
		
		
		if($REPORT_NAME=='HSN_WISE_SUMMARY') 
		{
				
					$mainindx=$balance=0;		

					$records = "select c.output_gst_ledger_id,c.hsncode from invoice_summary a,invoice_details b,brands c 
					where a.invoice_date 	between '".$param_array['fromdate']."' and '".$param_array['todate']."'
					and a.status='SALE' and a.id=b.invoice_summary_id and b.product_id=c.id group by c.hsncode " ;
					$records = $this->projectmodel->get_records_from_sql($records);
					if(count($records)>0){foreach ($records as $record)
					{

						$product_ids=$this->get_product_ids_hsnwise($record->hsncode);

						$details = "select sum(b.qnty) tot_qnty,sum(b.subtotal) tot_value
						,sum(b.taxable_amt) taxable_amt,sum(b.cgst_amt) cgst_amt,sum(b.sgst_amt) sgst_amt,sum(b.igst_amt) igst_amt from 
						invoice_summary a,invoice_details b	where  	
						a.invoice_date 	between '".$param_array['fromdate']."' and '".$param_array['todate']."' 
						and a.status='SALE' and a.id=b.invoice_summary_id and b.product_id  in (".$product_ids.")" ;
						$details = $this->projectmodel->get_records_from_sql($details);
						if(count($details)>0){foreach ($details as $detail)
						{
							$rsval[$mainindx]['hsn_code']=$record->hsncode; 
							$rsval[$mainindx]['gst_per']=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$record->output_gst_ledger_id); 					
							$rsval[$mainindx]['tot_qnty']=$detail->tot_qnty; 
									
							$rsval[$mainindx]['taxable_amt']=$detail->taxable_amt;
							$rsval[$mainindx]['igst_amt']=$detail->igst_amt;
							$rsval[$mainindx]['cgst_amt']=$detail->cgst_amt;
							$rsval[$mainindx]['sgst_amt']=$detail->sgst_amt;

							$rsval[$mainindx]['tot_value']=$detail->tot_value+$detail->igst_amt+$detail->cgst_amt+$detail->sgst_amt; 		
							$rsval[$mainindx]['href']='';
							$mainindx=$mainindx+1;
						}}

				}}
				return $rsval;		
		}
	
		//GST RELATED REPORT END
		
		if($REPORT_NAME=='DEBTORS_SUMMARY' || $REPORT_NAME=='CREDITORS_SUMMARY') 
		{return $this->all_mis_report('GENERAL_LEDGER',$param_array);}
		
		if($REPORT_NAME=='PRODUCT_WISE_PURCHASE' || $REPORT_NAME=='PRODUCT_WISE_SALE') 
		{
				//delete invalid	
				$status='';
				$inv_detail_id='';
				$mfg_monyr='';
				$exp_monyr='';
				$totqnty='';

				$mainindx=$balance=0;
				$records="select * 	from invoice_summary a,invoice_details b,brands c where  
				a.id=b.invoice_summary_id and b.product_id=c.id and b.RELATED_TO_MIXER='NO' and
				a.invoice_date  between '".$param_array['fromdate']."' and '".$param_array['todate']."'  ";
	
				if($REPORT_NAME=='PRODUCT_WISE_PURCHASE')
				{$status='PURCHASE'; $records=$records." and a.status='$status'  order by c.id,a.id";}
				if($REPORT_NAME=='PRODUCT_WISE_SALE')
				{
					$status='SALE';
					$debtor_ledges=$this->projectmodel->gethierarchy_list($current_hq_id,'HQ_WISE_DEBTOR_LEDGERS');
					$records=$records." and a.status='$status' and a.tbl_party_id in (".$debtor_ledges.")  order by c.id,a.id";
				}			
				
				$records = $this->projectmodel->get_records_from_sql($records);
				foreach ($records as $key=>$record)
				{ 
				
					$rsval[$mainindx]['invoice_no']=$record->invoice_no; 
					$rsval[$mainindx]['invoice_date']=$record->invoice_date; 
					$rsval[$mainindx]['party_name']=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$record->tbl_party_id); 
					$rsval[$mainindx]['product']=$this->projectmodel->GetSingleVal('brand_name','brands',' id='.$record->product_id); 
				
					$rsval[$mainindx]['qnty']=$record->qnty; 
					if($REPORT_NAME=='PRODUCT_WISE_PURCHASE')
					{$rsval[$mainindx]['rate']=$record->rate;}
					if($REPORT_NAME=='PRODUCT_WISE_SALE')
					{$rsval[$mainindx]['rate']=$record->srate;}
	
					
					$rsval[$mainindx]['total']=$record->subtotal;
					$rsval[$mainindx]['discount']=$record->disc_amt;
					$rsval[$mainindx]['grandtot']=$record->taxable_amt;
	
					$rsval[$mainindx]['href']='';
					$mainindx=$mainindx+1;
				}
	
				return $rsval;		
		}
	
		/************ ACCOUNT REPORT SECTIONS  START *************/

		if($REPORT_NAME=='GENERAL_LEDGER')
		{
			//LEFT SECTION
			//print_r($param_array);
			
			$mainindx=0;
			$ledger_ac=$param_array['ledger_ac'];
			$fromdate=$param_array['fromdate'];
			$todate=$param_array['todate'];
			$cr_open_balance=$dr_open_balance=0;
			if($ledger_ac>0)
			{
				
				$cr_open_balance=$this->ledger_opening_balance($ledger_ac,$fromdate,'CR');	
				$dr_open_balance=$this->ledger_opening_balance($ledger_ac,$fromdate,'DR');				
	
				if($cr_open_balance>0 || $dr_open_balance>0)
				{
					$rsval[$mainindx]['href']='';
					$rsval[$mainindx]['tran_date']=$fromdate;
					$rsval[$mainindx]['tran_type']='';
					$rsval[$mainindx]['tran_code']='';
					$rsval[$mainindx]['id']=0;
					$rsval[$mainindx]['particular']='Opening Balance';
					$rsval[$mainindx]['debit_amount']=$cr_open_balance;
					$rsval[$mainindx]['credit_amount']=$dr_open_balance ;	
					$rsval[$mainindx]['tran_table_name']='';
					$rsval[$mainindx]['tran_table_id']=0;
					$mainindx=$mainindx+1;
				}
	
				 $records="select a.id hdr_id,a.tran_table_id,b.id dtl_id, a.tran_code,a.tran_date,b.amount,b.cr_ledger_account,b.dr_ledger_account,
				a.comment,a.TRAN_TYPE,b.matching_tran_id,a.tran_table_name,a.tran_table_id from acc_tran_header a,acc_tran_details b 
				where a.id=b.acc_tran_header_id  and a.tran_date between '".$fromdate."' and '".$todate."' 
				and (b.cr_ledger_account=".$ledger_ac."  or b.dr_ledger_account=".$ledger_ac.") order by a.tran_date";						
				$records = $this->projectmodel->get_records_from_sql($records);	
				foreach ($records as $record)
				{								
	
					$credit_amount=$debit_amount=$opening_amount=0;
	
					$hdr_id=$record->hdr_id;
					$dtl_id=$record->dtl_id;
					$matching_tran_id=$record->matching_tran_id;
					
					$href=ADMIN_BASE_URL.'Accounts_controller/load_form_report/';
	
					// if($record->TRAN_TYPE=='PURCHASE')
					// {$rsval[$mainindx]['href']=$rsval[$mainindx]['href'].'Purchase/'.$record->tran_table_id;}
					// if($record->TRAN_TYPE=='FREIGHT')
					// {$rsval[$mainindx]['href']=$rsval[$mainindx]['href'].'Service_purchase/'.$record->tran_table_id;}
					// if($record->TRAN_TYPE=='SALE')
					// {$rsval[$mainindx]['href']=$rsval[$mainindx]['href'].'sale_entry/'.$record->tran_table_id;}
					// if($record->TRAN_TYPE=='PAYMENT')
					// {$rsval[$mainindx]['href']=$rsval[$mainindx]['href'].'AccountsPayment/'.$record->hdr_id;}
					// if($record->TRAN_TYPE=='RECEIVE')
					// {$rsval[$mainindx]['href']=$rsval[$mainindx]['href'].'AccountsReceive/'.$record->hdr_id;}
					// if($record->TRAN_TYPE=='JOURNAL')
					// {$rsval[$mainindx]['href']=$rsval[$mainindx]['href'].'AccountsJournal/'.$record->hdr_id;}
					// if($record->TRAN_TYPE=='CONTRA')
					// {$rsval[$mainindx]['href']=$rsval[$mainindx]['href'].'AccountsContra/'.$record->hdr_id;}
					
					// $rsval[$mainindx]['tran_date']=$record->tran_date;
					// $rsval[$mainindx]['tran_type']=$record->TRAN_TYPE;
					// $rsval[$mainindx]['tran_code']=$record->tran_code;
	
					$rsval[$mainindx]['details'][0]['particular']='';						
					$rsval[$mainindx]['details'][0]['qnty']='';
					$rsval[$mainindx]['details'][0]['rate']='';
					$rsval[$mainindx]['details'][0]['total']=''; 
					$rsval[$mainindx]['details'][0]['crdr']=''; 
					
					
					
					if($record->cr_ledger_account==$ledger_ac)
					{
						$credit_amount=$record->amount;
	
						$whr="  acc_tran_header_id=".$hdr_id." and matching_tran_id=".$matching_tran_id." and  dr_ledger_account>0 ";
						$rs=$this->projectmodel->GetMultipleVal('*','acc_tran_details',	$whr,'id ASC ');
						$json_array_count=sizeof($rs);	 
						for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
						{	
							
							
							if($record->TRAN_TYPE=='PURCHASE')
							{$rsval[$mainindx]['href']=$href.'Purchase/'.$record->tran_table_id;}
							if($record->TRAN_TYPE=='FREIGHT')
							{$rsval[$mainindx]['href']=$href.'Service_purchase/'.$record->tran_table_id;}
							if($record->TRAN_TYPE=='SALE')
							{$rsval[$mainindx]['href']=$href.'Sale_test/'.$record->tran_table_id;}
							if($record->TRAN_TYPE=='PAYMENT')
							{$rsval[$mainindx]['href']=$href.'AccountsPayment/'.$record->hdr_id;}
							if($record->TRAN_TYPE=='RECEIVE')
							{$rsval[$mainindx]['href']=$href.'AccountsReceive/'.$record->hdr_id;}
							if($record->TRAN_TYPE=='JOURNAL')
							{$rsval[$mainindx]['href']=$href.'AccountsJournal/'.$record->hdr_id;}
							if($record->TRAN_TYPE=='CONTRA')
							{$rsval[$mainindx]['href']=$href.'AccountsContra/'.$record->hdr_id;}
							
							$rsval[$mainindx]['tran_date']=$record->tran_date;
							$rsval[$mainindx]['tran_type']=$record->TRAN_TYPE;
							$rsval[$mainindx]['tran_code']=$record->tran_code;
							$rsval[$mainindx]['tran_table_name']=$record->tran_table_name;
							$rsval[$mainindx]['tran_table_id']=$record->tran_table_id;
	
							$rsval[$mainindx]['id']=$record->hdr_id;
							$rsval[$mainindx]['particular_ledger_account']=$rs[$fieldIndex]['dr_ledger_account'];
							$rsval[$mainindx]['particular']=
							$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$rs[$fieldIndex]['dr_ledger_account']); 		
							
							$parentid=$this->projectmodel->GetSingleVal('parent_id','acc_group_ledgers',' id='.$rs[$fieldIndex]['dr_ledger_account']); 
							if($record->TRAN_TYPE=='PURCHASE' && $parentid==14)
							{
								$dtl_records="select * from invoice_details where invoice_summary_id=".$record->tran_table_id;						
								$dtl_records = $this->projectmodel->get_records_from_sql($dtl_records);	
								foreach ($dtl_records as $key=>$dtl_record)
								{	
									$rsval[$mainindx]['details'][$key]['particular']=
									$parentid.$this->projectmodel->GetSingleVal('brand_name','brands',' id='.$dtl_record->product_id);
									$rsval[$mainindx]['details'][$key]['qnty']=	$dtl_record->qnty.' ';
									//$this->projectmodel->GetSingleVal('unit_name','unit_master',' id='.$dtl_record->unit_type_id); ;
									$rsval[$mainindx]['details'][$key]['rate']=$dtl_record->rate;
									$rsval[$mainindx]['details'][$key]['total']=$dtl_record->subtotal; 
									if($record->cr_ledger_account==$ledger_ac){$rsval[$mainindx]['details'][$key]['crdr']='Cr';}
									else {$rsval[$mainindx]['details'][$key]['crdr']='Dr'; }
								}
	
							}
							
	
							$debit_amount=$rs[$fieldIndex]['amount'];				
							if($credit_amount<=$debit_amount)
							{$rsval[$mainindx]['debit_amount']=$credit_amount;}
							else
							{$rsval[$mainindx]['debit_amount']=$debit_amount;}							
							$rsval[$mainindx]['credit_amount']='';	
							$mainindx=$mainindx+1;
						}
	
					}
	
					if($record->dr_ledger_account==$ledger_ac)
					{
						$debit_amount=$record->amount;
	
						$whr=" acc_tran_header_id=".$hdr_id." and matching_tran_id=".$matching_tran_id." and cr_ledger_account>0 ";
						$rs=$this->projectmodel->GetMultipleVal('*','acc_tran_details',	$whr,'id ASC ');
						$json_array_count=sizeof($rs);	 
						for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
						{
	
							if($record->TRAN_TYPE=='PURCHASE')
							{$rsval[$mainindx]['href']=$href.'Purchase/'.$record->tran_table_id;}
							if($record->TRAN_TYPE=='FREIGHT')
							{$rsval[$mainindx]['href']=$href.'Service_purchase/'.$record->tran_table_id;}
							if($record->TRAN_TYPE=='SALE')
							{$rsval[$mainindx]['href']=$href.'Sale_test/'.$record->tran_table_id;}
							if($record->TRAN_TYPE=='PAYMENT')
							{$rsval[$mainindx]['href']=$href.'AccountsPayment/'.$record->hdr_id;}
							if($record->TRAN_TYPE=='RECEIVE')
							{$rsval[$mainindx]['href']=$href.'AccountsReceive/'.$record->hdr_id;}
							if($record->TRAN_TYPE=='JOURNAL')
							{$rsval[$mainindx]['href']=$href.'AccountsJournal/'.$record->hdr_id;}
							if($record->TRAN_TYPE=='CONTRA')
							{$rsval[$mainindx]['href']=$href.'AccountsContra/'.$record->hdr_id;}
							
							$rsval[$mainindx]['tran_date']=$record->tran_date;
							$rsval[$mainindx]['tran_type']=$record->TRAN_TYPE;
							$rsval[$mainindx]['tran_code']=$record->tran_code;
							$rsval[$mainindx]['tran_table_name']=$record->tran_table_name;
							$rsval[$mainindx]['tran_table_id']=$record->tran_table_id;
							
							$rsval[$mainindx]['id']=$record->hdr_id;
							$rsval[$mainindx]['particular_ledger_account']=$rs[$fieldIndex]['cr_ledger_account'];
	
							$rsval[$mainindx]['particular']=
							$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$rs[$fieldIndex]['cr_ledger_account']); 						
							
							$parentid=$this->projectmodel->GetSingleVal('parent_id','acc_group_ledgers',' id='.$rs[$fieldIndex]['cr_ledger_account']); 							
							if($record->TRAN_TYPE=='SALE' && $parentid==15)
							{
								$dtl_records="select * from invoice_details where invoice_summary_id=".$record->tran_table_id;						
								$dtl_records = $this->projectmodel->get_records_from_sql($dtl_records);	
								foreach ($dtl_records as $key=>$dtl_record)
								{	
									$rsval[$mainindx]['details'][$key]['particular']=
									$this->projectmodel->GetSingleVal('brand_name','brands',' id='.$dtl_record->product_id);
									$rsval[$mainindx]['details'][$key]['qnty']=$dtl_record->qnty;
									//$this->projectmodel->GetSingleVal('unit_name','unit_master',' id='.$dtl_record->unit_type_id); ;
									$rsval[$mainindx]['details'][$key]['rate']=$dtl_record->rate;
									$rsval[$mainindx]['details'][$key]['total']=$dtl_record->subtotal; 
									if($record->cr_ledger_account==$ledger_ac){$rsval[$mainindx]['details'][$key]['crdr']='Cr';}
									else {$rsval[$mainindx]['details'][$key]['crdr']='Dr'; }
								}
							}
	
							$credit_amount=$rs[$fieldIndex]['amount'];						
							if($debit_amount<=$credit_amount)
							{$rsval[$mainindx]['credit_amount']=$debit_amount;}
							else
							{$rsval[$mainindx]['credit_amount']=$credit_amount;}
							$rsval[$mainindx]['debit_amount']='';	
							$mainindx=$mainindx+1;
						}
	
					}							
						
					
				}
	
				return $rsval;
			}
		}
		
		
		if($REPORT_NAME=='PROFIT_LOSS_ACCOUNT')
		{

			$trial_balance_output=$this->all_mis_report('TRIAL_BALANCE',$param_array);
			//echo '<pre>';print_r($trial_balance_output);echo '<pre>';

				//UPDATE TRADING ACCOUNT

				$trading_left_index=1;
				$trading_right_index=0;

				$trading_cnt_total=sizeof($trial_balance_output); 						
				if($trading_cnt_total>0)
				{  

					for($trading_cnt=0;$trading_cnt<$trading_cnt_total;$trading_cnt++)
					{	
							

							//opening stock
							if($trial_balance_output[$trading_cnt]['id']==1818)
							{
								$trading_ac_output[0]['left_ac_name']=$trial_balance_output[$trading_cnt]['name'];
								$trading_ac_output[0]['left_ac_debit_amt']=$trial_balance_output[$trading_cnt]['debit_amt'];
								$trading_ac_output[0]['left_ac_credit_amt']=$trial_balance_output[$trading_cnt]['credit_amt'];
								$trading_ac_output[0]['left_ac_index']=$trial_balance_output[$trading_cnt]['index'];
								$trading_ac_output[0]['left_ac_acc_type']=$trial_balance_output[$trading_cnt]['acc_type'];
							}

							if($trial_balance_output[$trading_cnt]['FINAL_AC_TYPE']=='TRADING_LEFT')
							{
								$trading_ac_output[$trading_left_index]['left_ac_name']=$trial_balance_output[$trading_cnt]['name'];
								$trading_ac_output[$trading_left_index]['left_ac_debit_amt']=$trial_balance_output[$trading_cnt]['debit_amt'];
								$trading_ac_output[$trading_left_index]['left_ac_credit_amt']=$trial_balance_output[$trading_cnt]['credit_amt'];
								$trading_ac_output[$trading_left_index]['left_ac_index']=$trial_balance_output[$trading_cnt]['index'];
								$trading_ac_output[$trading_left_index]['left_ac_acc_type']=$trial_balance_output[$trading_cnt]['acc_type'];
								$trading_left_index=$trading_left_index+1;
							}
							
							if($trial_balance_output[$trading_cnt]['FINAL_AC_TYPE']=='TRADING_RIGHT')
							{
								$trading_ac_output[$trading_right_index]['right_ac_name']=$trial_balance_output[$trading_cnt]['name'];
								$trading_ac_output[$trading_right_index]['right_ac_debit_amt']=$trial_balance_output[$trading_cnt]['debit_amt'];
								$trading_ac_output[$trading_right_index]['right_ac_credit_amt']=$trial_balance_output[$trading_cnt]['credit_amt'];
								$trading_ac_output[$trading_right_index]['right_ac_index']=$trial_balance_output[$trading_cnt]['index'];
								$trading_ac_output[$trading_right_index]['right_ac_acc_type']=$trial_balance_output[$trading_cnt]['acc_type'];
								$trading_right_index=$trading_right_index+1;
							}

							if($trial_balance_output[$trading_cnt]['id']==1819)
							{
								$right_ac_name_closing=$trial_balance_output[$trading_cnt]['name'];
								$right_ac_closing_debit_amt=$trial_balance_output[$trading_cnt]['debit_amt'];
								$right_ac_closing_credit_amt=$trial_balance_output[$trading_cnt]['credit_amt'];
								$right_ac_closing_index=$trial_balance_output[$trading_cnt]['index'];
								$right_ac_closing_type=$trial_balance_output[$trading_cnt]['acc_type'];
							}

					}

						$trading_ac_output[$trading_right_index]['right_ac_name']=$right_ac_name_closing;
						$trading_ac_output[$trading_right_index]['right_ac_debit_amt']=$right_ac_closing_debit_amt;
						$trading_ac_output[$trading_right_index]['right_ac_credit_amt']=	$right_ac_closing_credit_amt;
						$trading_ac_output[$trading_right_index]['right_ac_index']=$right_ac_closing_index;
						$trading_ac_output[$trading_right_index]['right_ac_acc_type']=$right_ac_closing_type;

				}

				return $trading_ac_output;

		}

		if($REPORT_NAME=='BALANCE_SHEET')
		{}

		if($REPORT_NAME=='TRIAL_BALANCE')
		{
					//dynamic TREE HIERARCHY ARRAY CREATE VIDEO
					//https://www.youtube.com/watch?v=lewf32viAwA
					
					//ARRAY SEARCH
					//	$array_index = array_search($output[$trading_cnt]['parent_id'], array_column($output, 'id')); 

					$mainindx=0;
					$output=array();	
					$fromdate=$param_array['fromdate'];
					$todate=$param_array['todate'];

					$this->stock_transactions($fromdate,$todate);

					$parent_id=0;		
					$rsval=$this->accounts_group_ledger_hierarchy(1,0,$fromdate, $todate);
					$rsval=$this->accounts_group_ledger_hierarchy(1,0,$fromdate, $todate);

					$JSON = json_encode(array_values($rsval));
					$jsonIterator = new RecursiveIteratorIterator(
					new RecursiveArrayIterator(json_decode($JSON, TRUE)),
					RecursiveIteratorIterator::SELF_FIRST);
					$mainindx=0;
					foreach ($jsonIterator as $key => $val) 
					{
							
							if(!is_array($val)) 
							{
									if($key == "id") {$output[$mainindx][$key]=$val;}
									if($key == "parent_id") {$output[$mainindx][$key]=$val;}
									if($key == "index") {$output[$mainindx][$key]=$val;}
									if($key == "name") {$output[$mainindx][$key]=$val;}
									if($key == "SHOW_IN_TRIAL_BALANCE") {$output[$mainindx][$key]=$val;}
									if($key == "FINAL_AC_TYPE") {$output[$mainindx][$key]=$val;}
									if($key == "acc_type") {$output[$mainindx][$key]=$val;$mainindx=$mainindx+1;}
							}			
				}
		
				//UPDATE LEDGER BALANCE
				$trading_cnt_total=sizeof($output); 						
				if($trading_cnt_total>0){  
				for($trading_cnt=0;$trading_cnt<$trading_cnt_total;$trading_cnt++)
				{	
						
					$records="select * FROM acc_group_ledgers where  id=".$output[$trading_cnt]['id'];						
					$records = $this->projectmodel->get_records_from_sql($records);	
					foreach ($records as $record)
					{			
						$output[$trading_cnt]['debit_amt']=$record->temp_debit_balance;
						$output[$trading_cnt]['credit_amt']=$record->temp_credit_balance;
					}
				}}

			//	echo '<pre>';print_r($output);echo '<pre>';

				return $output;
		
		}
		
		
		/************ ACCOUNT REPORT SECTIONS  END *************/
		
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