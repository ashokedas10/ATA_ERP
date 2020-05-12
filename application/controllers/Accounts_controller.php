<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts_controller  extends CI_Controller {

//http://learntallyerp9.blogspot.in/2009/11/list-of-ledgers.html

	public function __construct()
		{
			parent::__construct();
			$this->load->helper('url');
			$this->load->helper('form');
			$this->load->library('email');
			$this->load->model('project_model', 'projectmodel');
			$this->load->model('modeltree');
			$this->load->model('accounts_model');			
			$this->load->library(array('form_validation', 'trackback','pagination'));
			$this->load->library('numbertowords');
			$this->load->library('general_library');
			$this->load->library('pdf'); 
			$this->load->helper('file'); 			
			$this->login_validate();
			$this->load->library('excel');
			
			ini_set("allow_url_fopen", 1);
			
			 /* Open the file
			Click CTRL + F
			Select "Current document" in "Find in" 
			(You can also select the folder if you have multiple files)
			Search in "Source code"
			Tick "Use regular expression"
			Type "[\r\n]{2,}" (without quotes) in "Find"
			Type "\n" (without quotes) in "Replace"
			Press "Replace All"*/
			
		}	

	//ACCOUNTS TRANSACTIONS

	public function dynamic_angularjs_form()
	{
		
			$form_data=json_decode(file_get_contents("php://input"));						
			$pageno=mysql_real_escape_string($form_data->id);			
			
			$rs="select * 	from frmrpttemplatedetails where frmrpttemplatehdrID=".$pageno." ";
			$rs = $this->projectmodel->get_records_from_sql($rs);	
			$this->projectmodel->send_json_output($rs);					

	}
	
	public function load_form_report($TranPageName='')
	{
		$output =$data= array();
		$view_path_name='accounts_management/transaction/'.$TranPageName;
		$this->page_layout_display($view_path_name,$data);		
		
	}
	
	
	public function query_result($frmrpt_simple_query_builder_ID=0,$param1='',$param2='',$param3='',$param4='',$param5='')
		{
		
			//QUERY BUILDER TABLE
			$whr=" id=".$frmrpt_simple_query_builder_ID;
			$rs=$this->projectmodel->GetMultipleVal('*','frmrpt_simple_query_builder',$whr);
		
				
			if($rs[0]['type']=='RESULT')
			{
				$whr=$rs[0]['where_cond'];
				$rs_result=$this->projectmodel->GetMultipleVal('*',$rs[0]['table_name'],$whr);
			}
			if($rs[0]['type']=='RESULT_WITH_CONDITION')
			{
				$whr=$rs[0]['where_cond'].$param1;
				$rs_result=$this->projectmodel->GetMultipleVal('*',$rs[0]['table_name'],$whr);
				$json_array_count=sizeof($rs_result);	 
				for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
				{$rs_result[$fieldIndex]['name']=$rs_result[$fieldIndex][$rs[0]['field_name']];}
			}
		
			//$rs[$fieldIndex]['name']=
			$this->projectmodel->send_json_output($rs_result);		
		
		}

	
public function AccountsTransactions($TranPageName='',$datatype='',$cond='',
$id_header='',$id_detail='',$fromdate='',$todate='')
{
	$output =$data= array();

	
	//PurchaseEntry
	if($TranPageName=='PurchaseEntry')
	{
		
		if($datatype=='DELETE_INVOICE')
		{
			
			$form_data1=json_decode(file_get_contents("php://input"));	
			$id=mysql_real_escape_string($form_data1->id);				
			$this->db->query("delete from invoice_summary where id=".$id);
			$this->db->query("delete from invoice_details where invoice_summary_id=".$id);
			$status='PURCHASE';
			//$status='SALE';
			//$status='PURCHASE_RTN';
			$this->accounts_model->ledger_transactions_delete($id,$status);

			$return_data['id_header']=$id;				
			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($return_data);		
			
		}
		
		if($datatype=='previous_transaction_details')
		{
			$invoice_summary_id=$rate=$maxid=0;

			$records="select max(id) maxid from invoice_details where id>0 and status='PURCHASE' ";

			if($cond>0)
			{$records=$records." and product_id=".$cond."";}
			if($id_header<>'')
			{$records=$records." and batchno='".$id_header."'  ";}
			$records =$this->projectmodel->get_records_from_sql($records);
			foreach ($records as $record)
			{$maxid=$record->maxid;}	

			$invoice_summary_id=$this->projectmodel->GetSingleVal('invoice_summary_id','invoice_details',' id='.$maxid);	
			$rate=$this->projectmodel->GetSingleVal('rate','invoice_details',' id='.$maxid);

			$party_id=$this->projectmodel->GetSingleVal('tbl_party_id','invoice_summary',' id='.$invoice_summary_id);	
			$invoice_date=$this->projectmodel->GetSingleVal('invoice_date','invoice_summary',' id='.$invoice_summary_id);	

			$party_name=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$party_id);
			
			$rs[0]['msg']='Last Purchase To '.$party_name.' Date:'.$invoice_date.' @ Rs'.$rate;
			$this->projectmodel->send_json_output($rs);	

		}


		if($datatype=='product_list')
		{
			$whr="id>0";
			$rs=$this->projectmodel->GetMultipleVal('id,brand_name','brands',$whr);	
			$this->projectmodel->send_json_output($rs);	
		}


		if($datatype=='product_id')
		{			
			$whr="id=".$cond;;
			$rs=$this->projectmodel->GetMultipleVal('*','brands',$whr,'brand_name Asc');
			$json_array_count=sizeof($rs);	 
			for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			{					
				$rs[$fieldIndex]['name']=$rs[$fieldIndex]['brand_name'];
				$tax_per=$rs[$fieldIndex]['tax_per']=$this->projectmodel->GetSingleVal('default_value','acc_group_ledgers',
				' id='.$rs[$fieldIndex]['output_gst_ledger_id']);				
			
			}				
			$this->projectmodel->send_json_output($rs);	
		}

		if($datatype=='batchno')
		{				
			$whr="product_id=".$cond." and (status='OPEN_BALANCE' or status='PURCHASE' or status='SALE_RTN')";
			$rs=$this->projectmodel->GetMultipleVal('*','invoice_details',$whr,'batchno Asc');
			$json_array_count=sizeof($rs);	 
			for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			{					
				$rs[$fieldIndex]['PURCHASEID']=$rs[$fieldIndex]['id'];
				$AVAILABLE_QTY=$this->accounts_model->batch_wise_product_available($rs[$fieldIndex]['batchno'],$cond);
				$rs[$fieldIndex]['AVAILABLE_QTY']=$AVAILABLE_QTY;
			}				
			$this->projectmodel->send_json_output($rs);	
		}

		if($datatype=='BATCH_DETAILS')
		{
			$whr="product_id=".$cond." and (status='OPEN_BALANCE' or status='PURCHASE' or status='SALE_RTN')";
			$rs=$this->projectmodel->GetMultipleVal('*','invoice_details',$whr,'batchno Asc');
			$json_array_count=sizeof($rs);	 
			for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			{					
				$AVAILABLE_QTY=
				$this->accounts_model->batch_wise_product_available(
					$rs[$fieldIndex]['batchno'],$cond);
				$rs[$fieldIndex]['AVAILABLE_QTY']=$AVAILABLE_QTY;
			}				
			$this->projectmodel->send_json_output($rs);	
		}
		
		if($datatype=='SAVE')
		{
			$id_header=$id_detail='';
			$form_data=json_decode(file_get_contents("php://input"));
			$data=$return_data=$save_details=$save_hdr=array();
		
			//HEADER SECTION		
			//$save_hdr['comment']=mysql_real_escape_string($form_data->comment);
			$RELATED_TO_MIXER=
			mysql_real_escape_string($form_data->RELATED_TO_MIXER);

			
			$save_hdr['invoice_no']=mysql_real_escape_string($form_data->invoice_no);
			$save_hdr['invoice_date']=mysql_real_escape_string($form_data->invoice_date);
			$save_hdr['challan_no']=mysql_real_escape_string($form_data->challan_no);
			$save_hdr['challan_date']=mysql_real_escape_string($form_data->challan_date);
			$save_hdr['tbl_party_id']=mysql_real_escape_string($form_data->tbl_party_id);
			//	$save_hdr['tot_cash_discount']=mysql_real_escape_string($form_data->tot_cash_discount);
			//	$save_hdr['hq_id']=mysql_real_escape_string($form_data->hq_id);

			$save_hdr['lrno']=mysql_real_escape_string($form_data->lrno);
			$save_hdr['lrdate']=mysql_real_escape_string($form_data->lrdate);
			$save_hdr['orderno']=mysql_real_escape_string($form_data->orderno);
			$save_hdr['orderdate']=mysql_real_escape_string($form_data->orderdate);
			$save_hdr['transporter']=mysql_real_escape_string($form_data->transporter);
			$save_hdr['no_of_case']=mysql_real_escape_string($form_data->no_of_case);

			$save_hdr['status']='PURCHASE';
			$save_hdr['invoice_time']=date('H:i');
			$save_hdr['emp_name']=$this->session->userdata('login_name');
			$save_hdr['emp_id']=$this->session->userdata('login_emp_id');

				if($save_hdr['invoice_date']=='')
				{$save_hdr['invoice_date']=date('Y-m-d');}
				$finyr=$this->general_library->get_fin_yr($save_hdr['invoice_date']);
				$save_hdr['finyr']=$finyr;	
			
			if(mysql_real_escape_string($form_data->id_header)>0)
			{						
				$id_header=mysql_real_escape_string($form_data->id_header);
				$this->projectmodel->save_records_model($id_header,'invoice_summary',$save_hdr);
			}
			else
			{
				$this->projectmodel->save_records_model('','invoice_summary',$save_hdr);
				$id_header=$this->db->insert_id();
			}	

				$save_details['invoice_summary_id']=$id_header;
				$save_details['status']=$save_hdr['status'];
				$product_id=$save_details['product_id']=mysql_real_escape_string($form_data->product_id);					
				$save_details['product_name']=$this->projectmodel->GetSingleVal('brand_name','brands',' id='.$save_details['product_id']);
				$save_details['PRODUCT_TYPE']='FINISH';
				$save_details['PURCHASEID']=mysql_real_escape_string($form_data->PURCHASEID);
				$save_details['batchno']=mysql_real_escape_string($form_data->batchno);				
				$save_details['exp_monyr']=mysql_real_escape_string($form_data->exp_monyr);
				$save_details['mfg_monyr']=mysql_real_escape_string($form_data->mfg_monyr);
				$save_details['qnty']=mysql_real_escape_string($form_data->qnty);
				$save_details['rate']=mysql_real_escape_string($form_data->rate);
				$save_details['mrp']=mysql_real_escape_string($form_data->mrp);
				$save_details['ptr']=mysql_real_escape_string($form_data->ptr);
				$save_details['srate']=mysql_real_escape_string($form_data->srate);
				$save_details['tax_per']=mysql_real_escape_string($form_data->tax_per);
				$save_details['tax_ledger_id']=mysql_real_escape_string($form_data->tax_ledger_id);
				$save_details['disc_per']=mysql_real_escape_string($form_data->disc_per);				
				$save_details['disc_per2']=mysql_real_escape_string($form_data->disc_per2);
				$save_details['ptr']=mysql_real_escape_string($form_data->ptr);
				$save_details['freeqty']=mysql_real_escape_string($form_data->freeqty);			
				$save_details['totqnty']=$save_details['qnty']+$save_details['freeqty'];

			//	$product_details['Synonym']=$save_details['Synonym'];

			if($save_details['product_id']>0 )
			{
				if(mysql_real_escape_string($form_data->id_detail)>0)
				{
					$id_detail=mysql_real_escape_string($form_data->id_detail);
					$this->projectmodel->save_records_model($id_detail,'invoice_details',$save_details);
				}
				else
				{
					$this->projectmodel->save_records_model('','invoice_details',$save_details);
					//$id_detail=$this->db->insert_id();
				}	
			//	$this->projectmodel->save_records_model($product_id,'productmstr',$product_details);
			}
									
				$this->transaction_update($id_header);

				//RETURN SECTION				
				$return_data['id_header']=$id_header;	
				$return_data['MIX_RAW_LINK_ID']=0;
			//	$return_data['MIX_RAW_LINK_ID']=$MIX_RAW_LINK_ID;	

				$rowrecords="select * from  invoice_summary where id=".$id_header;
				$rowrecords = $this->projectmodel->get_records_from_sql($rowrecords);	
				foreach ($rowrecords as $rowrecord)
				{					
					$return_data['invoice_no']=$rowrecord->invoice_no;	
					$return_data['invoice_date']=$rowrecord->invoice_date;	
					$return_data['challan_no']=$rowrecord->challan_no;
					$return_data['challan_date']=$rowrecord->challan_date;	
					$return_data['tbl_party_id']=$rowrecord->tbl_party_id;
					$return_data['comment']=$rowrecord->comment;

					$return_data['tbl_party_id_name']=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$rowrecord->tbl_party_id);
				
				}

			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($return_data);

		}
		
		if($datatype=='DTLLIST')
		{
			$whr="PRODUCT_TYPE in ('MIXTURE','FINISH') and  invoice_summary_id=".$cond;
			$rs=$this->projectmodel->GetMultipleVal('*','invoice_details',$whr,'id Asc');
			$json_array_count=sizeof($rs);	 
			for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			{					
				$rs[$fieldIndex]['mixer_name']=$rs[$fieldIndex]['product_name'];

				$rs[$fieldIndex]['product_id_name']=$this->projectmodel->GetSingleVal('brand_name','brands',' id='.$rs[$fieldIndex]['product_id']);
				$rs[$fieldIndex]['tax_ledger']=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$rs[$fieldIndex]['tax_ledger_id']);	
				$rs[$fieldIndex]['NET_TOTAL']=$rs[$fieldIndex]['taxable_amt']+$rs[$fieldIndex]['cgst_amt']+$rs[$fieldIndex]['sgst_amt']+$rs[$fieldIndex]['igst_amt'];
			}				
			$this->projectmodel->send_json_output($rs);					
		}


		if($datatype=='VIEWDTL')
		{
			$whr="id=".$cond;
			$rs=$this->projectmodel->GetMultipleVal('*','invoice_details',$whr,'id Asc');
			$json_array_count=sizeof($rs);	 
			for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			{	
				$rs[$fieldIndex]['product_id_name']=$this->projectmodel->GetSingleVal('brand_name','brands',' id='.$rs[$fieldIndex]['product_id']);
				$rs[$fieldIndex]['tax_per']=$this->projectmodel->GetSingleVal('default_value','acc_group_ledgers',' id='.$rs[$fieldIndex]['tax_ledger_id']);
			}				
			$this->projectmodel->send_json_output($rs);	
		}

		if($datatype=='VIEWALLVALUE')
		{				
			$whr="id=".$cond;
			$rs=$this->projectmodel->GetMultipleVal('*','invoice_summary',$whr,'id Asc');
			$json_array_count=sizeof($rs);	 
			for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			{	
				$rs[$fieldIndex]['id_header']=$rs[$fieldIndex]['id'];				
				$rs[$fieldIndex]['hq_id_name']=$this->projectmodel->GetSingleVal('hierarchy_name','tbl_hierarchy_org',' id='.$rs[$fieldIndex]['hq_id']);
				$rs[$fieldIndex]['tbl_party_id_name']=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$rs[$fieldIndex]['tbl_party_id']);
			}				
			$this->projectmodel->send_json_output($rs);				
		}

		if($datatype=='GetAllList')
		{
			$whr="invoice_date between '".$fromdate."' and '".$todate."' AND status='PURCHASE' ";
			$rs=$this->projectmodel->GetMultipleVal('*','invoice_summary',$whr,'id Asc');
			$json_array_count=sizeof($rs);	 
			for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			{	
				$rs[$fieldIndex]['id_header']=$rs[$fieldIndex]['id'];	
				$rs[$fieldIndex]['party_name']=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$rs[$fieldIndex]['tbl_party_id']);

			}				
			$this->projectmodel->send_json_output($rs);			
			
		}
	
	}
	//PURCHASE ENTRY END

	//SALE ENTRY
	if($TranPageName=='SaleEntry')
	{
		
		if($datatype=='DELETE_INVOICE')
		{
			
			$form_data1=json_decode(file_get_contents("php://input"));	
			$id=mysql_real_escape_string($form_data1->id);				
			$this->db->query("delete from invoice_summary where id=".$id);
			$this->db->query("delete from invoice_details where invoice_summary_id=".$id);
			//$status='PURCHASE';
			$status='SALE';
			//$status='PURCHASE_RTN';
			$this->accounts_model->ledger_transactions_delete($id,$status);

			$return_data['id_header']=$id;				
			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($return_data);		
			
		}
		
		if($datatype=='previous_transaction_details')
		{
			$invoice_summary_id=$rate=$maxid=0;

			$records="select max(id) maxid from invoice_details where id>0 and status='SALE' ";

			if($cond>0)
			{$records=$records." and product_id=".$cond."";}
			if($id_header<>'')
			{$records=$records." and batchno='".$id_header."'  ";}
			$records =$this->projectmodel->get_records_from_sql($records);
			foreach ($records as $record)
			{$maxid=$record->maxid;}	

			$invoice_summary_id=$this->projectmodel->GetSingleVal('invoice_summary_id','invoice_details',' id='.$maxid);	
			$rate=$this->projectmodel->GetSingleVal('rate','invoice_details',' id='.$maxid);

			$party_id=$this->projectmodel->GetSingleVal('tbl_party_id','invoice_summary',' id='.$invoice_summary_id);	
			$invoice_date=$this->projectmodel->GetSingleVal('invoice_date','invoice_summary',' id='.$invoice_summary_id);	

			$party_name=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$party_id);
			
			$rs[0]['msg']='Last Sale To '.$party_name.' Date:'.$invoice_date.' @ Rs'.$rate;
			$this->projectmodel->send_json_output($rs);	

		}

		if($datatype=="print_invoice")
		{			
			$this->load->library('zend');
			$this->zend->load('Zend/Barcode');

			$barcodetext=$cond;
			$image='BILL-'.$cond.'.png';
			$imageResource = Zend_Barcode::factory('code128', 
		   'image', array('text'=>$barcodetext,'barThickWidth'=>6,'barThinWidth'=>2,
		   'drawText' => false), array())->draw();
		   
			imagepng($imageResource, 'uploads/'.$image);

			$report_path='accounts_management/MIS_REPORTS/invoice_print_sell';
			$data_print['table_name']='invoice_summary';
			$data_print['table_id']=$cond;		
			$data_print['datatype']=$datatype;

			
			$this->pdf->load_view($report_path, $data_print);			
			$this->pdf->render();
			$this->pdf->stream("uploads/invoice.pdf");				
						
		//	$this->report_page_layout_display($report_path,$data_print);

		}

		if($datatype=='product_list')
		{
			$whr="id>0";
			$rs=$this->projectmodel->GetMultipleVal('id,brand_name','brands',$whr);	
			$this->projectmodel->send_json_output($rs);	
		}

		if($datatype=='product_id_name')
		{				
			// $cond=strtoupper($cond);
			// $cond=preg_replace('/\s+/', '', $cond);

			$sqlfields="select * from brands  order by brand_name ";
			$fields = $this->projectmodel->get_records_from_sql($sqlfields);
			foreach ($fields as $field)
			{
				$rs['name']=$field->brand_name.'(#'.$field->id.')';
				array_push($output,$rs);
			}

			 header('Access-Control-Allow-Origin: *');
			 header("Content-Type: application/json");
			 echo json_encode($output);
		
		}

		if($datatype=='product_id')
		{			
			$whr="id=".$cond;;
			$rs=$this->projectmodel->GetMultipleVal('*','brands',$whr,'brand_name Asc');
			$json_array_count=sizeof($rs);	 
			for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			{					
				$rs[$fieldIndex]['name']=$rs[$fieldIndex]['brand_name'];
				$rs[$fieldIndex]['tax_per']=$this->projectmodel->GetSingleVal('default_value','acc_group_ledgers',
				' id='.$rs[$fieldIndex]['output_gst_ledger_id']);

			}				
			$this->projectmodel->send_json_output($rs);	
		}

		if($datatype=='hq_id_name')
		{
			$tockist_id=$this->projectmodel->GetSingleVal('ref_table_id','acc_group_ledgers',' id='.$cond);
			$tbl_hierarchy_org_id='0';
			$sqlfields="select * from stockist_hq_map  where stockist_id=".$tockist_id;
			$fields = $this->projectmodel->get_records_from_sql($sqlfields);
			foreach ($fields as $field)
			{$tbl_hierarchy_org_id=$tbl_hierarchy_org_id.','.$field->tbl_hierarchy_org_id;}

			$hqs='0';
			$sqlfields="select * from tbl_hierarchy_org  where id in (".$tbl_hierarchy_org_id.")";
			$fields = $this->projectmodel->get_records_from_sql($sqlfields);
			foreach ($fields as $field)
			{$hqs=$hqs.','.$field->under_tbl_hierarchy_org 	;}
		
			$whr=" id in (".$hqs.")";
			//$whr="acc_type='LEDGER'	and parent_id=312";
			$rs=$this->projectmodel->GetMultipleVal('*','tbl_hierarchy_org',$whr);
			$json_array_count=sizeof($rs);	 
			for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			{$rs[$fieldIndex]['name']=$rs[$fieldIndex]['hierarchy_name'];}		

			$this->projectmodel->send_json_output($rs);	
		}	
		
		
		if($datatype=='batchno')
		{				
			$whr="product_id=".$cond." and (status='OPEN_BALANCE' or status='PURCHASE' or status='SALE_RTN')";
			$rs=$this->projectmodel->GetMultipleVal('*','invoice_details',$whr,'batchno Asc');
			$json_array_count=sizeof($rs);	 
			for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			{					
				$rs[$fieldIndex]['PURCHASEID']=$rs[$fieldIndex]['id'];
				$AVAILABLE_QTY=$this->accounts_model->batch_wise_product_available($rs[$fieldIndex]['batchno'],$cond);
				$rs[$fieldIndex]['AVAILABLE_QTY']=$AVAILABLE_QTY;
			}				
			$this->projectmodel->send_json_output($rs);	
		}

		if($datatype=='BATCH_DETAILS')
		{
			$whr="product_id=".$cond." and (status='OPEN_BALANCE' or status='PURCHASE' or status='SALE_RTN')";
			$rs=$this->projectmodel->GetMultipleVal('*','invoice_details',$whr,'batchno Asc');
			$json_array_count=sizeof($rs);	 
			for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			{					
				$AVAILABLE_QTY=$this->accounts_model->batch_wise_product_available($rs[$fieldIndex]['batchno'],$cond);
				$rs[$fieldIndex]['AVAILABLE_QTY']=$AVAILABLE_QTY;
			}				
			$this->projectmodel->send_json_output($rs);	
		}
		
		if($datatype=='SAVE')
		{
			$id_header=$id_detail='';
			$form_data=json_decode(file_get_contents("php://input"));
			$data=$return_data=$save_details=$save_hdr=array();
		
			//HEADER SECTION		
			//$save_hdr['comment']=mysql_real_escape_string($form_data->comment);
			$RELATED_TO_MIXER=
			mysql_real_escape_string($form_data->RELATED_TO_MIXER);

			$save_hdr['invoice_date']=mysql_real_escape_string($form_data->invoice_date);
			$save_hdr['challan_no']=mysql_real_escape_string($form_data->challan_no);
			$save_hdr['challan_date']=mysql_real_escape_string($form_data->challan_date);
			$save_hdr['tbl_party_id']=mysql_real_escape_string($form_data->tbl_party_id);
			$save_hdr['tot_cash_discount']=mysql_real_escape_string($form_data->tot_cash_discount);
			$save_hdr['hq_id']=mysql_real_escape_string($form_data->hq_id);

			$save_hdr['lrno']=mysql_real_escape_string($form_data->lrno);
			$save_hdr['lrdate']=mysql_real_escape_string($form_data->lrdate);
			$save_hdr['orderno']=mysql_real_escape_string($form_data->orderno);
			$save_hdr['orderdate']=mysql_real_escape_string($form_data->orderdate);
			$save_hdr['transporter']=mysql_real_escape_string($form_data->transporter);
			$save_hdr['no_of_case']=mysql_real_escape_string($form_data->no_of_case);

			$save_hdr['status']='SALE';
			$save_hdr['invoice_time']=date('H:i');
			$save_hdr['emp_name']=$this->session->userdata('login_name');
			$save_hdr['emp_id']=$this->session->userdata('login_emp_id');
			
			if(mysql_real_escape_string($form_data->id_header)>0)
			{						
			
				$save_hdr['invoice_no']=mysql_real_escape_string($form_data->invoice_no);
				$id_header=mysql_real_escape_string($form_data->id_header);
				$this->projectmodel->save_records_model($id_header,'invoice_summary',$save_hdr);
			}
			else
			{
				$save_hdr['invoice_date']=mysql_real_escape_string($form_data->invoice_date);
				
				if($save_hdr['invoice_date']=='')
				{$save_hdr['invoice_date']=date('Y-m-d');}
				$finyr=$this->general_library->get_fin_yr($save_hdr['invoice_date']);
				$save_hdr['finyr']=$finyr;	
				
				$invsrl=1;
				$sql="select max(srl) srl  from invoice_summary 
				where  finyr='$finyr' and status='SALE' ";				
				$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
				foreach ($rowrecord as $row1)
				{ $invsrl=$row1->srl+1;}									
				$save_hdr['invoice_no']=$invsrl.'/'.$finyr;
				$save_hdr['srl']=$invsrl;	

				$this->projectmodel->save_records_model('','invoice_summary',$save_hdr);
				$id_header=$this->db->insert_id();
			}	

				$save_details['invoice_summary_id']=$id_header;
				$save_details['status']=$save_hdr['status'];
				$product_id=$save_details['product_id']=mysql_real_escape_string($form_data->product_id);					
				$save_details['product_name']=$this->projectmodel->GetSingleVal('brand_name','brands',' id='.$save_details['product_id']);
				$save_details['PRODUCT_TYPE']='FINISH';
				$save_details['PURCHASEID']=mysql_real_escape_string($form_data->PURCHASEID);
				$save_details['batchno']=mysql_real_escape_string($form_data->batchno);				
				$save_details['exp_monyr']=mysql_real_escape_string($form_data->exp_monyr);
				$save_details['mfg_monyr']=mysql_real_escape_string($form_data->mfg_monyr);
				$save_details['qnty']=mysql_real_escape_string($form_data->qnty);
				$save_details['rate']=mysql_real_escape_string($form_data->rate);
				$save_details['mrp']=mysql_real_escape_string($form_data->mrp);
				$save_details['ptr']=mysql_real_escape_string($form_data->ptr);
				$save_details['srate']=mysql_real_escape_string($form_data->srate);
				$save_details['tax_per']=mysql_real_escape_string($form_data->tax_per);
				$save_details['tax_ledger_id']=mysql_real_escape_string($form_data->tax_ledger_id);
				$save_details['disc_per']=mysql_real_escape_string($form_data->disc_per);		
				$save_details['purchase_rate']=mysql_real_escape_string($form_data->purchase_rate);
				//$save_details['disc_per2']=mysql_real_escape_string($form_data->disc_per2);
				$save_details['disc_per2']=0;
				$save_details['ptr']=mysql_real_escape_string($form_data->ptr);
				$save_details['freeqty']=mysql_real_escape_string($form_data->freeqty);			
				$save_details['totqnty']=$save_details['qnty']+$save_details['freeqty'];

			//	$product_details['Synonym']=$save_details['Synonym'];

			if($save_details['product_id']>0 )
			{
				if(mysql_real_escape_string($form_data->id_detail)>0)
				{
					$id_detail=mysql_real_escape_string($form_data->id_detail);
					$this->projectmodel->save_records_model($id_detail,'invoice_details',$save_details);
				}
				else
				{
					$this->projectmodel->save_records_model('','invoice_details',$save_details);
					//$id_detail=$this->db->insert_id();
				}	
			//	$this->projectmodel->save_records_model($product_id,'productmstr',$product_details);
			}
									
				$this->transaction_update($id_header);

				//RETURN SECTION				
				$return_data['id_header']=$id_header;	
				$return_data['MIX_RAW_LINK_ID']=0;
			//	$return_data['MIX_RAW_LINK_ID']=$MIX_RAW_LINK_ID;	

				$rowrecords="select * from  invoice_summary where id=".$id_header;
				$rowrecords = $this->projectmodel->get_records_from_sql($rowrecords);	
				foreach ($rowrecords as $rowrecord)
				{					
					$return_data['invoice_no']=$rowrecord->invoice_no;	
					$return_data['invoice_date']=$rowrecord->invoice_date;	
					$return_data['challan_no']=$rowrecord->challan_no;
					$return_data['challan_date']=$rowrecord->challan_date;	
					$return_data['tbl_party_id']=$rowrecord->tbl_party_id;
					$return_data['comment']=$rowrecord->comment;
					$return_data['tbl_party_id_name']=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$rowrecord->tbl_party_id);
				
				}

			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($return_data);

		}
		
		if($datatype=='DTLLIST')
		{
			$whr="PRODUCT_TYPE in ('MIXTURE','FINISH') and  invoice_summary_id=".$cond;
			$rs=$this->projectmodel->GetMultipleVal('*','invoice_details',$whr,'id Asc');
			$json_array_count=sizeof($rs);	 
			for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			{					
				$rs[$fieldIndex]['mixer_name']=$rs[$fieldIndex]['product_name'];

				$rs[$fieldIndex]['product_id_name']=$this->projectmodel->GetSingleVal('brand_name','brands',' id='.$rs[$fieldIndex]['product_id']);
				$rs[$fieldIndex]['tax_ledger']=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$rs[$fieldIndex]['tax_ledger_id']);	
				$rs[$fieldIndex]['NET_TOTAL']=$rs[$fieldIndex]['taxable_amt']+$rs[$fieldIndex]['cgst_amt']+$rs[$fieldIndex]['sgst_amt']+$rs[$fieldIndex]['igst_amt'];
			}				
			$this->projectmodel->send_json_output($rs);					
		}

		if($datatype=='VIEWDTL')
		{
			$whr="id=".$cond;
			$rs=$this->projectmodel->GetMultipleVal('*','invoice_details',$whr,'id Asc');
			$json_array_count=sizeof($rs);	 
			for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			{	
				$rs[$fieldIndex]['product_id_name']=$this->projectmodel->GetSingleVal('brand_name','brands',' id='.$rs[$fieldIndex]['product_id']);
				$rs[$fieldIndex]['tax_per']=$this->projectmodel->GetSingleVal('default_value','acc_group_ledgers',' id='.$rs[$fieldIndex]['tax_ledger_id']);
			}				
			$this->projectmodel->send_json_output($rs);	
		}

		if($datatype=='VIEWALLVALUE')
		{				
			$whr="id=".$cond;
			$rs=$this->projectmodel->GetMultipleVal('*','invoice_summary',$whr,'id Asc');
			$json_array_count=sizeof($rs);	 
			for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			{	
				$rs[$fieldIndex]['id_header']=$rs[$fieldIndex]['id'];				
				$rs[$fieldIndex]['hq_id_name']=$this->projectmodel->GetSingleVal('hierarchy_name','tbl_hierarchy_org',' id='.$rs[$fieldIndex]['hq_id']);
				$rs[$fieldIndex]['tbl_party_id_name']=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$rs[$fieldIndex]['tbl_party_id']);
			}				
			$this->projectmodel->send_json_output($rs);				
		}

		if($datatype=='GetAllList')
		{
			$whr="invoice_date between '".$fromdate."' and '".$todate."' AND status='SALE' ";
			$rs=$this->projectmodel->GetMultipleVal('*','invoice_summary',$whr,'id Asc');
			$json_array_count=sizeof($rs);	 
			for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			{	
				$rs[$fieldIndex]['id_header']=$rs[$fieldIndex]['id'];	
				$rs[$fieldIndex]['party_name']=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$rs[$fieldIndex]['tbl_party_id']);

			}				
			$this->projectmodel->send_json_output($rs);			
			
		}
	
	}
	//SALE ENTRY END


		//Purchase return Entry
		if($TranPageName=='purchase_rtn')
		{
			
			if($datatype=='DELETE_INVOICE')
			{
				
				$form_data1=json_decode(file_get_contents("php://input"));	
				$id=mysql_real_escape_string($form_data1->id);				
				$this->db->query("delete from invoice_summary where id=".$id);
				$this->db->query("delete from invoice_details where invoice_summary_id=".$id);
				//$status='PURCHASE';
				//$status='SALE';
				$status='PURCHASE_RTN';
				$this->accounts_model->ledger_transactions_delete($id,$status);
	
				$return_data['id_header']=$id;				
				header('Access-Control-Allow-Origin: *');
				header("Content-Type: application/json");
				echo json_encode($return_data);		
				
			}
			
			if($datatype=='previous_transaction_details')
			{
				$invoice_summary_id=$rate=$maxid=0;
	
				$records="select max(id) maxid from invoice_details where id>0 and status='$status' ";
	
				if($cond>0)
				{$records=$records." and product_id=".$cond."";}
				if($id_header<>'')
				{$records=$records." and batchno='".$id_header."'  ";}
				$records =$this->projectmodel->get_records_from_sql($records);
				foreach ($records as $record)
				{$maxid=$record->maxid;}	
	
				$invoice_summary_id=$this->projectmodel->GetSingleVal('invoice_summary_id','invoice_details',' id='.$maxid);	
				$rate=$this->projectmodel->GetSingleVal('rate','invoice_details',' id='.$maxid);
	
				$party_id=$this->projectmodel->GetSingleVal('tbl_party_id','invoice_summary',' id='.$invoice_summary_id);	
				$invoice_date=$this->projectmodel->GetSingleVal('invoice_date','invoice_summary',' id='.$invoice_summary_id);	
	
				$party_name=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$party_id);
				
				$rs[0]['msg']='Last Purchase To '.$party_name.' Date:'.$invoice_date.' @ Rs'.$rate;
				$this->projectmodel->send_json_output($rs);	
	
			}
			
			if($datatype=="print_invoice")
			{			
				$this->load->library('zend');
				$this->zend->load('Zend/Barcode');
	
				$barcodetext=$cond;
				$image='BILL-'.$cond.'.png';
				$imageResource = Zend_Barcode::factory('code128', 
				 'image', array('text'=>$barcodetext,'barThickWidth'=>6,'barThinWidth'=>2,
				 'drawText' => false), array())->draw();
				 
				imagepng($imageResource, 'uploads/'.$image);
	
				$report_path='accounts_management/MIS_REPORTS/credit_note_print';
				$data_print['table_name']='invoice_summary';
				$data_print['table_id']=$cond;		
				$data_print['datatype']=$datatype;
	
				
				$this->pdf->load_view($report_path, $data_print);			
				$this->pdf->render();
				$this->pdf->stream("uploads/invoice.pdf");				
							
			//	$this->report_page_layout_display($report_path,$data_print);
	
			}
	
			if($datatype=='product_list')
			{
				$whr="id>0";
				$rs=$this->projectmodel->GetMultipleVal('id,brand_name','brands',$whr);	
				$this->projectmodel->send_json_output($rs);	
			}
	
	
			if($datatype=='product_id')
			{			
				$whr="id=".$cond;;
				$rs=$this->projectmodel->GetMultipleVal('*','brands',$whr,'brand_name Asc');
				$json_array_count=sizeof($rs);	 
				for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
				{					
					$rs[$fieldIndex]['name']=$rs[$fieldIndex]['brand_name'];
					$tax_per=$rs[$fieldIndex]['tax_per']=$this->projectmodel->GetSingleVal('default_value','acc_group_ledgers',
					' id='.$rs[$fieldIndex]['input_gst_ledger_id']);				
				
				}				
				$this->projectmodel->send_json_output($rs);	
			}
	
			if($datatype=='batchno')
			{				
				$whr="product_id=".$cond." and (status='OPEN_BALANCE' or status='PURCHASE' or status='SALE_RTN')";
				$rs=$this->projectmodel->GetMultipleVal('*','invoice_details',$whr,'batchno Asc');
				$json_array_count=sizeof($rs);	 
				for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
				{					
					$rs[$fieldIndex]['PURCHASEID']=$rs[$fieldIndex]['id'];
					$AVAILABLE_QTY=$this->accounts_model->batch_wise_product_available($rs[$fieldIndex]['batchno'],$cond);
					$rs[$fieldIndex]['AVAILABLE_QTY']=$AVAILABLE_QTY;
				}				
				$this->projectmodel->send_json_output($rs);	
			}
	
			if($datatype=='BATCH_DETAILS')
			{
				$AVAILABLE_QTY=0;
				$whr="product_id=".$cond." and (status='OPEN_BALANCE' or status='PURCHASE' or status='SALE_RTN')";
				$rs=$this->projectmodel->GetMultipleVal('*','invoice_details',$whr,'batchno Asc');
				$json_array_count=sizeof($rs);	 
				for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
				{					
					$AVAILABLE_QTY=$this->accounts_model->batch_wise_product_available($rs[$fieldIndex]['batchno'],$cond);
					$rs[$fieldIndex]['AVAILABLE_QTY']=$AVAILABLE_QTY;
				}				
				$this->projectmodel->send_json_output($rs);	
			}
			
			if($datatype=='SAVE')
			{
				$id_header=$id_detail='';
				$form_data=json_decode(file_get_contents("php://input"));
				$data=$return_data=$save_details=$save_hdr=array();
			
				//HEADER SECTION		
				//$save_hdr['comment']=mysql_real_escape_string($form_data->comment);
				$RELATED_TO_MIXER=
				mysql_real_escape_string($form_data->RELATED_TO_MIXER);
	
				
				$save_hdr['invoice_no']=mysql_real_escape_string($form_data->invoice_no);
				$save_hdr['invoice_date']=mysql_real_escape_string($form_data->invoice_date);
				$save_hdr['challan_no']=mysql_real_escape_string($form_data->challan_no);
				$save_hdr['challan_date']=mysql_real_escape_string($form_data->challan_date);
				$save_hdr['tbl_party_id']=mysql_real_escape_string($form_data->tbl_party_id);
				//	$save_hdr['tot_cash_discount']=mysql_real_escape_string($form_data->tot_cash_discount);
				//	$save_hdr['hq_id']=mysql_real_escape_string($form_data->hq_id);
	
			//$save_hdr['lrno']=mysql_real_escape_string($form_data->lrno);
			//	$save_hdr['lrdate']=mysql_real_escape_string($form_data->lrdate);
			//	$save_hdr['orderno']=mysql_real_escape_string($form_data->orderno);
			//	$save_hdr['orderdate']=mysql_real_escape_string($form_data->orderdate);
			//	$save_hdr['transporter']=mysql_real_escape_string($form_data->transporter);
			//	$save_hdr['no_of_case']=mysql_real_escape_string($form_data->no_of_case);
	
				$save_hdr['status']='PURCHASE_RTN';
				$save_hdr['invoice_time']=date('H:i');
				$save_hdr['emp_name']=$this->session->userdata('login_name');
				$save_hdr['emp_id']=$this->session->userdata('login_emp_id');
	
					if($save_hdr['invoice_date']=='')
					{$save_hdr['invoice_date']=date('Y-m-d');}
					$finyr=$this->general_library->get_fin_yr($save_hdr['invoice_date']);
					$save_hdr['finyr']=$finyr;	
				
				if(mysql_real_escape_string($form_data->id_header)>0)
				{						
					$id_header=mysql_real_escape_string($form_data->id_header);
					$this->projectmodel->save_records_model($id_header,'invoice_summary',$save_hdr);
				}
				else
				{

					$save_hdr['invoice_date']=mysql_real_escape_string($form_data->invoice_date);
				
					if($save_hdr['invoice_date']=='')
					{$save_hdr['invoice_date']=date('Y-m-d');}
					$finyr=$this->general_library->get_fin_yr($save_hdr['invoice_date']);
					$save_hdr['finyr']=$finyr;	
					
					$invsrl=1;
					$sql="select max(srl) srl  from invoice_summary where  finyr='$finyr' and status='PURCHASE_RTN' ";				
					$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
					foreach ($rowrecord as $row1)
					{ $invsrl=$row1->srl+1;}									
					$save_hdr['invoice_no']=$invsrl.'/PRTN/'.$finyr;
					$save_hdr['srl']=$invsrl;	

					
					$this->projectmodel->save_records_model('','invoice_summary',$save_hdr);
					$id_header=$this->db->insert_id();
				}	
	
					$save_details['invoice_summary_id']=$id_header;
					$save_details['status']=$save_hdr['status'];
					$product_id=$save_details['product_id']=mysql_real_escape_string($form_data->product_id);					
					$save_details['product_name']=$this->projectmodel->GetSingleVal('brand_name','brands',' id='.$save_details['product_id']);
					$save_details['PRODUCT_TYPE']='FINISH';
					$save_details['PURCHASEID']=mysql_real_escape_string($form_data->PURCHASEID);
					$save_details['batchno']=mysql_real_escape_string($form_data->batchno);				
					$save_details['exp_monyr']=mysql_real_escape_string($form_data->exp_monyr);
					$save_details['mfg_monyr']=mysql_real_escape_string($form_data->mfg_monyr);
					$save_details['qnty']=mysql_real_escape_string($form_data->qnty);
					$save_details['rate']=mysql_real_escape_string($form_data->rate);
					$save_details['mrp']=mysql_real_escape_string($form_data->mrp);
					$save_details['ptr']=mysql_real_escape_string($form_data->ptr);
					$save_details['srate']=mysql_real_escape_string($form_data->srate);
					$save_details['tax_per']=mysql_real_escape_string($form_data->tax_per);
					$save_details['tax_ledger_id']=mysql_real_escape_string($form_data->tax_ledger_id);
					$save_details['disc_per']=mysql_real_escape_string($form_data->disc_per);				
					$save_details['disc_per2']=mysql_real_escape_string($form_data->disc_per2);
					$save_details['ptr']=mysql_real_escape_string($form_data->ptr);
					$save_details['freeqty']=mysql_real_escape_string($form_data->freeqty);			
					$save_details['totqnty']=$save_details['qnty']+$save_details['freeqty'];
	
				//	$product_details['Synonym']=$save_details['Synonym'];
	
				if($save_details['product_id']>0 )
				{
					if(mysql_real_escape_string($form_data->id_detail)>0)
					{
						$id_detail=mysql_real_escape_string($form_data->id_detail);
						$this->projectmodel->save_records_model($id_detail,'invoice_details',$save_details);
					}
					else
					{
						$this->projectmodel->save_records_model('','invoice_details',$save_details);
						//$id_detail=$this->db->insert_id();
					}	
				//	$this->projectmodel->save_records_model($product_id,'productmstr',$product_details);
				}
										
					$this->transaction_update($id_header);
	
					//RETURN SECTION				
					$return_data['id_header']=$id_header;	
					$return_data['MIX_RAW_LINK_ID']=0;
				//	$return_data['MIX_RAW_LINK_ID']=$MIX_RAW_LINK_ID;	
	
					$rowrecords="select * from  invoice_summary where id=".$id_header;
					$rowrecords = $this->projectmodel->get_records_from_sql($rowrecords);	
					foreach ($rowrecords as $rowrecord)
					{					
						$return_data['invoice_no']=$rowrecord->invoice_no;	
						$return_data['invoice_date']=$rowrecord->invoice_date;	
						$return_data['challan_no']=$rowrecord->challan_no;
						$return_data['challan_date']=$rowrecord->challan_date;	
						$return_data['tbl_party_id']=$rowrecord->tbl_party_id;
						$return_data['comment']=$rowrecord->comment;
	
						$return_data['tbl_party_id_name']=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$rowrecord->tbl_party_id);
					
					}
	
				header('Access-Control-Allow-Origin: *');
				header("Content-Type: application/json");
				echo json_encode($return_data);
	
			}
			
			if($datatype=='DTLLIST')
			{
				$whr="PRODUCT_TYPE in ('MIXTURE','FINISH') and  invoice_summary_id=".$cond;
				$rs=$this->projectmodel->GetMultipleVal('*','invoice_details',$whr,'id Asc');
				$json_array_count=sizeof($rs);	 
				for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
				{					
					$rs[$fieldIndex]['mixer_name']=$rs[$fieldIndex]['product_name'];
	
					$rs[$fieldIndex]['product_id_name']=$this->projectmodel->GetSingleVal('brand_name','brands',' id='.$rs[$fieldIndex]['product_id']);
					$rs[$fieldIndex]['tax_ledger']=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$rs[$fieldIndex]['tax_ledger_id']);	
					$rs[$fieldIndex]['NET_TOTAL']=$rs[$fieldIndex]['taxable_amt']+$rs[$fieldIndex]['cgst_amt']+$rs[$fieldIndex]['sgst_amt']+$rs[$fieldIndex]['igst_amt'];
				}				
				$this->projectmodel->send_json_output($rs);					
			}
	
	
			if($datatype=='VIEWDTL')
			{
				$whr="id=".$cond;
				$rs=$this->projectmodel->GetMultipleVal('*','invoice_details',$whr,'id Asc');
				$json_array_count=sizeof($rs);	 
				for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
				{	
					$rs[$fieldIndex]['product_id_name']=$this->projectmodel->GetSingleVal('brand_name','brands',' id='.$rs[$fieldIndex]['product_id']);
					$rs[$fieldIndex]['tax_per']=$this->projectmodel->GetSingleVal('default_value','acc_group_ledgers',' id='.$rs[$fieldIndex]['tax_ledger_id']);
				}				
				$this->projectmodel->send_json_output($rs);	
			}
	
			if($datatype=='VIEWALLVALUE')
			{				
				$whr="id=".$cond;
				$rs=$this->projectmodel->GetMultipleVal('*','invoice_summary',$whr,'id Asc');
				$json_array_count=sizeof($rs);	 
				for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
				{	
					$rs[$fieldIndex]['id_header']=$rs[$fieldIndex]['id'];				
					$rs[$fieldIndex]['hq_id_name']=$this->projectmodel->GetSingleVal('hierarchy_name','tbl_hierarchy_org',' id='.$rs[$fieldIndex]['hq_id']);
					$rs[$fieldIndex]['tbl_party_id_name']=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$rs[$fieldIndex]['tbl_party_id']);
				}				
				$this->projectmodel->send_json_output($rs);				
			}
	
			if($datatype=='GetAllList')
			{
				$whr="invoice_date between '".$fromdate."' and '".$todate."' AND status='PURCHASE_RTN' ";
				$rs=$this->projectmodel->GetMultipleVal('*','invoice_summary',$whr,'id Asc');
				$json_array_count=sizeof($rs);	 
				for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
				{	
					$rs[$fieldIndex]['id_header']=$rs[$fieldIndex]['id'];	
					$rs[$fieldIndex]['party_name']=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$rs[$fieldIndex]['tbl_party_id']);
	
				}				
				$this->projectmodel->send_json_output($rs);			
				
			}
		
		}
		//PURCHASE RETURN ENTRY END


		//SALE ENTRY
	if($TranPageName=='sale_rtn')
	{
		
		if($datatype=='DELETE_INVOICE')
		{
			
			$form_data1=json_decode(file_get_contents("php://input"));	
			$id=mysql_real_escape_string($form_data1->id);				
			$this->db->query("delete from invoice_summary where id=".$id);
			$this->db->query("delete from invoice_details where invoice_summary_id=".$id);
			//$status='PURCHASE';
			$status='SALE_RTN';
			//$status='PURCHASE_RTN';
			$this->accounts_model->ledger_transactions_delete($id,$status);

			$return_data['id_header']=$id;				
			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($return_data);		
			
		}
		
		if($datatype=='previous_transaction_details')
		{
			$invoice_summary_id=$rate=$maxid=0;

			$records="select max(id) maxid from invoice_details where id>0 and status='$status' ";

			if($cond>0)
			{$records=$records." and product_id=".$cond."";}
			if($id_header<>'')
			{$records=$records." and batchno='".$id_header."'  ";}
			$records =$this->projectmodel->get_records_from_sql($records);
			foreach ($records as $record)
			{$maxid=$record->maxid;}	

			$invoice_summary_id=$this->projectmodel->GetSingleVal('invoice_summary_id','invoice_details',' id='.$maxid);	
			$rate=$this->projectmodel->GetSingleVal('rate','invoice_details',' id='.$maxid);

			$party_id=$this->projectmodel->GetSingleVal('tbl_party_id','invoice_summary',' id='.$invoice_summary_id);	
			$invoice_date=$this->projectmodel->GetSingleVal('invoice_date','invoice_summary',' id='.$invoice_summary_id);	

			$party_name=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$party_id);
			
			$rs[0]['msg']='Last Sale To '.$party_name.' Date:'.$invoice_date.' @ Rs'.$rate;
			$this->projectmodel->send_json_output($rs);	

		}

		if($datatype=="print_invoice")
		{			
			$this->load->library('zend');
			$this->zend->load('Zend/Barcode');

			$barcodetext=$cond;
			$image='BILL-'.$cond.'.png';
			$imageResource = Zend_Barcode::factory('code128', 
		   'image', array('text'=>$barcodetext,'barThickWidth'=>6,'barThinWidth'=>2,
		   'drawText' => false), array())->draw();
		   
			imagepng($imageResource, 'uploads/'.$image);

			$report_path='accounts_management/MIS_REPORTS/debit_note_print';
			$data_print['table_name']='invoice_summary';
			$data_print['table_id']=$cond;		
			$data_print['datatype']=$datatype;

			
			$this->pdf->load_view($report_path, $data_print);			
			$this->pdf->render();
			$this->pdf->stream("uploads/invoice.pdf");				
						
			//	$this->report_page_layout_display($report_path,$data_print);

		}

		if($datatype=='product_list')
		{
			$whr="id>0";
			$rs=$this->projectmodel->GetMultipleVal('id,brand_name','brands',$whr);	
			$this->projectmodel->send_json_output($rs);	
		}

		if($datatype=='product_id_name')
		{				
			// // $cond=strtoupper($cond);
			// // $cond=preg_replace('/\s+/', '', $cond);

			// $sqlfields="select * from brands  order by brand_name ";
			// $fields = $this->projectmodel->get_records_from_sql($sqlfields);
			// foreach ($fields as $field)
			// {
			// 	$rs['name']=$field->brand_name.'(#'.$field->id.')';
			// 	array_push($output,$rs);
			// }

			//  header('Access-Control-Allow-Origin: *');
			//  header("Content-Type: application/json");
			//  echo json_encode($output);
		
		}

		if($datatype=='product_id')
		{			
			$whr="id=".$cond;;
			$rs=$this->projectmodel->GetMultipleVal('*','brands',$whr,'brand_name Asc');
			$json_array_count=sizeof($rs);	 
			for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			{					
				$rs[$fieldIndex]['name']=$rs[$fieldIndex]['brand_name'];
				$rs[$fieldIndex]['tax_per']=$this->projectmodel->GetSingleVal('default_value','acc_group_ledgers',
				' id='.$rs[$fieldIndex]['output_gst_ledger_id']);

			}				
			$this->projectmodel->send_json_output($rs);	
		}

		if($datatype=='hq_id_name')
		{
			$tockist_id=$this->projectmodel->GetSingleVal('ref_table_id','acc_group_ledgers',' id='.$cond);
			$tbl_hierarchy_org_id='0';
			$sqlfields="select * from stockist_hq_map  where stockist_id=".$tockist_id;
			$fields = $this->projectmodel->get_records_from_sql($sqlfields);
			foreach ($fields as $field)
			{$tbl_hierarchy_org_id=$tbl_hierarchy_org_id.','.$field->tbl_hierarchy_org_id;}

			$hqs='0';
			$sqlfields="select * from tbl_hierarchy_org  where id in (".$tbl_hierarchy_org_id.")";
			$fields = $this->projectmodel->get_records_from_sql($sqlfields);
			foreach ($fields as $field)
			{$hqs=$hqs.','.$field->under_tbl_hierarchy_org 	;}
		
			$whr=" id in (".$hqs.")";
			//$whr="acc_type='LEDGER'	and parent_id=312";
			$rs=$this->projectmodel->GetMultipleVal('*','tbl_hierarchy_org',$whr);
			$json_array_count=sizeof($rs);	 
			for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			{$rs[$fieldIndex]['name']=$rs[$fieldIndex]['hierarchy_name'];}		

			$this->projectmodel->send_json_output($rs);	
		}	
		
		
		if($datatype=='batchno')
		{				
				$party_id=$id_header;

				$records="select b.* from invoice_summary a,invoice_details b 
				where a.id=b.invoice_summary_id and  a.tbl_party_id=".$party_id." and b.product_id=".$cond." and a.status='SALE' group by b.batchno";
				$records = $this->projectmodel->get_records_from_sql($records);	
				foreach ($records as $key=>$record)
				{

					$rs[$key]['id']=$record->id;				
					$rs[$key]['PURCHASEID']=$record->id;			
					$rs[$key]['batchno']=$record->batchno;			
					$rs[$key]['rate']=$record->purchase_rate;			
					$rs[$key]['exp_monyr']=$record->exp_monyr;			
					$rs[$key]['mfg_monyr']=$record->mfg_monyr;			
					$rs[$key]['srate']=$record->rate;			
					$rs[$key]['mrp']=$record->mrp;
					$rs[$key]['ptr']=$record->ptr;					
					$rs[$key]['AVAILABLE_QTY']=$this->accounts_model->batch_wise_product_available($record->batchno,$cond);

				}


			// $whr="product_id=".$cond." and (status='OPEN_BALANCE' or status='PURCHASE' or status='SALE_RTN')";
			// $rs=$this->projectmodel->GetMultipleVal('*','invoice_details',$whr,'batchno Asc');
			// $json_array_count=sizeof($rs);	 
			// for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			// {					
			// 	$rs[$fieldIndex]['PURCHASEID']=$rs[$fieldIndex]['id'];
			// 	$AVAILABLE_QTY=$this->accounts_model->batch_wise_product_available($rs[$fieldIndex]['batchno'],$cond);
			// 	$rs[$fieldIndex]['AVAILABLE_QTY']=$AVAILABLE_QTY;
			// }				
			$this->projectmodel->send_json_output($rs);	
		}

		if($datatype=='BATCH_DETAILS')
		{
			$whr="product_id=".$cond." and (status='OPEN_BALANCE' or status='PURCHASE' or status='SALE_RTN')";
			$rs=$this->projectmodel->GetMultipleVal('*','invoice_details',$whr,'batchno Asc');
			$json_array_count=sizeof($rs);	 
			for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			{					
				$AVAILABLE_QTY=$this->accounts_model->batch_wise_product_available($rs[$fieldIndex]['batchno'],$cond);
				$rs[$fieldIndex]['AVAILABLE_QTY']=$AVAILABLE_QTY;
			}				
			$this->projectmodel->send_json_output($rs);	
		}
		
		if($datatype=='SAVE')
		{
			$id_header=$id_detail='';
			$form_data=json_decode(file_get_contents("php://input"));
			$data=$return_data=$save_details=$save_hdr=array();
		
			//HEADER SECTION		
			//$save_hdr['comment']=mysql_real_escape_string($form_data->comment);
			$RELATED_TO_MIXER=
			mysql_real_escape_string($form_data->RELATED_TO_MIXER);

			$save_hdr['invoice_date']=mysql_real_escape_string($form_data->invoice_date);
			$save_hdr['challan_no']=mysql_real_escape_string($form_data->challan_no);
			$save_hdr['challan_date']=mysql_real_escape_string($form_data->challan_date);
			$save_hdr['tbl_party_id']=mysql_real_escape_string($form_data->tbl_party_id);
			$save_hdr['tot_cash_discount']=mysql_real_escape_string($form_data->tot_cash_discount);
			$save_hdr['hq_id']=mysql_real_escape_string($form_data->hq_id);

			$save_hdr['lrno']=mysql_real_escape_string($form_data->lrno);
			$save_hdr['lrdate']=mysql_real_escape_string($form_data->lrdate);
			$save_hdr['orderno']=mysql_real_escape_string($form_data->orderno);
			$save_hdr['orderdate']=mysql_real_escape_string($form_data->orderdate);
			$save_hdr['transporter']=mysql_real_escape_string($form_data->transporter);
			$save_hdr['no_of_case']=mysql_real_escape_string($form_data->no_of_case);

			$save_hdr['status']='SALE_RTN';
			$save_hdr['invoice_time']=date('H:i');
			$save_hdr['emp_name']=$this->session->userdata('login_name');
			$save_hdr['emp_id']=$this->session->userdata('login_emp_id');
			
			if(mysql_real_escape_string($form_data->id_header)>0)
			{						
				$id_header=mysql_real_escape_string($form_data->id_header);
				$this->projectmodel->save_records_model($id_header,'invoice_summary',$save_hdr);
			}
			else
			{
				$save_hdr['invoice_date']=mysql_real_escape_string($form_data->invoice_date);
				
				if($save_hdr['invoice_date']=='')
				{$save_hdr['invoice_date']=date('Y-m-d');}
				$finyr=$this->general_library->get_fin_yr($save_hdr['invoice_date']);
				$save_hdr['finyr']=$finyr;	
				
				$invsrl=1;
				$sql="select max(srl) srl  from invoice_summary where  finyr='$finyr' and status='SALE_RTN' ";				
				$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
				foreach ($rowrecord as $row1)
				{ $invsrl=$row1->srl+1;}									
				$save_hdr['invoice_no']=$invsrl.'/SRTN/'.$finyr;
				$save_hdr['srl']=$invsrl;	

				$this->projectmodel->save_records_model('','invoice_summary',$save_hdr);
				$id_header=$this->db->insert_id();
			}	

				$save_details['invoice_summary_id']=$id_header;
				$save_details['status']=$save_hdr['status'];
				$product_id=$save_details['product_id']=mysql_real_escape_string($form_data->product_id);					
				$save_details['product_name']=$this->projectmodel->GetSingleVal('brand_name','brands',' id='.$save_details['product_id']);
				$save_details['PRODUCT_TYPE']='FINISH';
				$save_details['PURCHASEID']=mysql_real_escape_string($form_data->PURCHASEID);
				$save_details['batchno']=mysql_real_escape_string($form_data->batchno);				
				$save_details['exp_monyr']=mysql_real_escape_string($form_data->exp_monyr);
				$save_details['mfg_monyr']=mysql_real_escape_string($form_data->mfg_monyr);
				$save_details['qnty']=mysql_real_escape_string($form_data->qnty);
				$save_details['rate']=mysql_real_escape_string($form_data->rate);
				$save_details['mrp']=mysql_real_escape_string($form_data->mrp);
				$save_details['ptr']=mysql_real_escape_string($form_data->ptr);
				$save_details['srate']=mysql_real_escape_string($form_data->srate);
				$save_details['tax_per']=mysql_real_escape_string($form_data->tax_per);
				$save_details['tax_ledger_id']=mysql_real_escape_string($form_data->tax_ledger_id);
				$save_details['disc_per']=mysql_real_escape_string($form_data->disc_per);		
				$save_details['purchase_rate']=mysql_real_escape_string($form_data->purchase_rate);
				//$save_details['disc_per2']=mysql_real_escape_string($form_data->disc_per2);
				$save_details['disc_per2']=0;
				$save_details['ptr']=mysql_real_escape_string($form_data->ptr);
				$save_details['freeqty']=mysql_real_escape_string($form_data->freeqty);			
				$save_details['totqnty']=$save_details['qnty']+$save_details['freeqty'];

			//	$product_details['Synonym']=$save_details['Synonym'];

			if($save_details['product_id']>0 )
			{
				if(mysql_real_escape_string($form_data->id_detail)>0)
				{
					$id_detail=mysql_real_escape_string($form_data->id_detail);
					$this->projectmodel->save_records_model($id_detail,'invoice_details',$save_details);
				}
				else
				{
					$this->projectmodel->save_records_model('','invoice_details',$save_details);
					//$id_detail=$this->db->insert_id();
				}	
			//	$this->projectmodel->save_records_model($product_id,'productmstr',$product_details);
			}
									
				$this->transaction_update($id_header);

				//RETURN SECTION				
				$return_data['id_header']=$id_header;	
				$return_data['MIX_RAW_LINK_ID']=0;
			//	$return_data['MIX_RAW_LINK_ID']=$MIX_RAW_LINK_ID;	

				$rowrecords="select * from  invoice_summary where id=".$id_header;
				$rowrecords = $this->projectmodel->get_records_from_sql($rowrecords);	
				foreach ($rowrecords as $rowrecord)
				{					
					$return_data['invoice_no']=$rowrecord->invoice_no;	
					$return_data['invoice_date']=$rowrecord->invoice_date;	
					$return_data['challan_no']=$rowrecord->challan_no;
					$return_data['challan_date']=$rowrecord->challan_date;	
					$return_data['tbl_party_id']=$rowrecord->tbl_party_id;
					$return_data['comment']=$rowrecord->comment;
					$return_data['tbl_party_id_name']=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$rowrecord->tbl_party_id);
				
				}

			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($return_data);

		}
		
		if($datatype=='DTLLIST')
		{
			$whr="PRODUCT_TYPE in ('MIXTURE','FINISH') and  invoice_summary_id=".$cond;
			$rs=$this->projectmodel->GetMultipleVal('*','invoice_details',$whr,'id Asc');
			$json_array_count=sizeof($rs);	 
			for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			{					
				$rs[$fieldIndex]['mixer_name']=$rs[$fieldIndex]['product_name'];

				$rs[$fieldIndex]['product_id_name']=$this->projectmodel->GetSingleVal('brand_name','brands',' id='.$rs[$fieldIndex]['product_id']);
				$rs[$fieldIndex]['tax_ledger']=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$rs[$fieldIndex]['tax_ledger_id']);	
				$rs[$fieldIndex]['NET_TOTAL']=$rs[$fieldIndex]['taxable_amt']+$rs[$fieldIndex]['cgst_amt']+$rs[$fieldIndex]['sgst_amt']+$rs[$fieldIndex]['igst_amt'];
			}				
			$this->projectmodel->send_json_output($rs);					
		}

		if($datatype=='VIEWDTL')
		{
			$whr="id=".$cond;
			$rs=$this->projectmodel->GetMultipleVal('*','invoice_details',$whr,'id Asc');
			$json_array_count=sizeof($rs);	 
			for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			{	
				$rs[$fieldIndex]['product_id_name']=$this->projectmodel->GetSingleVal('brand_name','brands',' id='.$rs[$fieldIndex]['product_id']);
				$rs[$fieldIndex]['tax_per']=$this->projectmodel->GetSingleVal('default_value','acc_group_ledgers',' id='.$rs[$fieldIndex]['tax_ledger_id']);
			}				
			$this->projectmodel->send_json_output($rs);	
		}

		if($datatype=='VIEWALLVALUE')
		{				
			$whr="id=".$cond;
			$rs=$this->projectmodel->GetMultipleVal('*','invoice_summary',$whr,'id Asc');
			$json_array_count=sizeof($rs);	 
			for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			{	
				$rs[$fieldIndex]['id_header']=$rs[$fieldIndex]['id'];				
				$rs[$fieldIndex]['hq_id_name']=$this->projectmodel->GetSingleVal('hierarchy_name','tbl_hierarchy_org',' id='.$rs[$fieldIndex]['hq_id']);
				$rs[$fieldIndex]['tbl_party_id_name']=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$rs[$fieldIndex]['tbl_party_id']);
			}				
			$this->projectmodel->send_json_output($rs);				
		}

		if($datatype=='GetAllList')
		{
			$whr="invoice_date between '".$fromdate."' and '".$todate."' AND status='SALE_RTN' ";
			$rs=$this->projectmodel->GetMultipleVal('*','invoice_summary',$whr,'id Asc');
			$json_array_count=sizeof($rs);	 
			for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
			{	
				$rs[$fieldIndex]['id_header']=$rs[$fieldIndex]['id'];	
				$rs[$fieldIndex]['party_name']=$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',' id='.$rs[$fieldIndex]['tbl_party_id']);

			}				
			$this->projectmodel->send_json_output($rs);			
			
		}
	
	}
	//SALE ENTRY END
		

	if($TranPageName=='DELETE_PRODUCT')
	{
			$form_data1=json_decode(file_get_contents("php://input"));	
		//	print_r($form_data1);
			$id=mysql_real_escape_string($form_data1->id);			
			
		$invoice_summary_id=$this->projectmodel->GetSingleVal('invoice_summary_id','invoice_details',' id='.$id);	
		$this->db->query("delete from invoice_details where id=".$id);
		$this->transaction_update($invoice_summary_id);
		
		$cnt=0;
		$rowrecords="select count(*) cnt from  invoice_details where invoice_summary_id=".$invoice_summary_id;
		$rowrecords = $this->projectmodel->get_records_from_sql($rowrecords);	
		foreach ($rowrecords as $rowrecord)
		{$cnt=$rowrecord->cnt;}
		if($cnt==0)
		{	$this->db->query("delete from  invoice_summary where id=".$invoice_summary_id);}


			$return_data['id_header']=$invoice_summary_id;				
			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($return_data);		
	
	}

	
	
	//RECEIVE/PAYMENT/JOURNAL/CONTRA

	if($TranPageName=='RECEIVE' or $TranPageName=='PAYMENT' or $TranPageName=='CONTRA' or $TranPageName=='JOURNAL')
	{

		if($datatype=='ledger_account_name')
		{
		
				$whr=" FieldID='".$TranPageName."' and  Status='".$TranPageName."'";

				if($cond=='DR')
				{
					$val=$this->projectmodel->GetSingleVal('DEBIT_LEDGER','frmrptgeneralmaster',$whr);
					$LEDGERS=$val;
					
					$val=$this->projectmodel->GetSingleVal('DEBIT_GROUP','frmrptgeneralmaster',$whr);
					$GROUPS=$val;
				}
				if($cond=='CR')
				{
					$val=$this->projectmodel->GetSingleVal('CREDIT_LEDGER','frmrptgeneralmaster',$whr);
					$LEDGERS=$val;
					
					$val=$this->projectmodel->GetSingleVal('CREDIT_GROUP','frmrptgeneralmaster',$whr);
					$GROUPS=$val;
				}
				//echo	$cond;
				$sqlfields="select * from acc_group_ledgers where parent_id in (".$GROUPS.") and acc_type='LEDGER' ";
				$fields = $this->projectmodel->get_records_from_sql($sqlfields);
				foreach ($fields as $field)
				{$LEDGERS=$LEDGERS.','.$field->id;}
				
				$sql="select * from  acc_group_ledgers 	where id in (".$LEDGERS.")	order by  acc_name";			
				$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
				foreach ($rowrecord as $row1)
				{		
					$save_data['name']=$row1->acc_name.'(#'.$row1->id.')';		
					array_push($output,$save_data);
				}
				header('Access-Control-Allow-Origin: *');
				header("Content-Type: application/json");
				echo json_encode($output);
		}

	
		if($datatype=='ledger_account_id')
		{
			$sql="select * from  acc_group_ledgers 	where id=".$cond;
			$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
			foreach ($rowrecord as $row1)
			{		
				$save_data['id']=$row1->id;
				$save_data['name']=$row1->acc_name;	

				$whr=' id='.$row1->parent_id;	
				$VOUCHER_TYPE=$this->projectmodel->GetSingleVal('VOUCHER_TYPE','acc_group_ledgers',$whr);
				
				//or $VOUCHER_TYPE=='SUNDRY_CREDITORS'

				if($TranPageName=='RECEIVE')
				{
					$save_data['COST_CENTER']='NA';

					if($VOUCHER_TYPE=='BANK_ACCOUNT')
					{$save_data['COST_CENTER']='BANK';}				
					else if ($VOUCHER_TYPE=='SUNDRY_DEBTORS')
					{$save_data['COST_CENTER']='SALE_BILL';}					
					else
					{
						$whr=' id='.$cond;	
						$save_data['COST_CENTER']=$this->projectmodel->GetSingleVal('COST_CENTER','acc_group_ledgers',$whr);					
					}

				}

				if($TranPageName=='PAYMENT')
				{
					$save_data['COST_CENTER']='NA';

					if($VOUCHER_TYPE=='BANK_ACCOUNT')
					{$save_data['COST_CENTER']='BANK';}
					 else if ($VOUCHER_TYPE=='SUNDRY_CREDITORS')
					 {$save_data['COST_CENTER']='PURCHASE_BILL';}
					else
					{
						$whr=' id='.$cond;	
						$save_data['COST_CENTER']=$this->projectmodel->GetSingleVal('COST_CENTER','acc_group_ledgers',$whr);					
					}

				}
				
				
				if($TranPageName=='JOURNAL')
				{
					// $whr=' id='.$cond;	
					// $save_data['COST_CENTER']=$this->projectmodel->GetSingleVal('COST_CENTER',
					// 'acc_group_ledgers',$whr);	
					
					$save_data['COST_CENTER']='NA';
				}

				if($TranPageName=='CONTRA')
				{
					$save_data['COST_CENTER']='NA';
					if($VOUCHER_TYPE=='BANK_ACCOUNT')
					{$save_data['COST_CENTER']='BANK';}		
					
				}

				$save_data['balance']=$this->accounts_model->ledger_opening_balance($row1->id,date('Y-m-d'),'CR');

				array_push($output,$save_data);
			}
			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($output);
		}

	
				
		if($datatype=='BILLNO')
		{
			if($TranPageName=='RECEIVE')
			{
				$sql="select * from  invoice_summary  where status='SALE' and tbl_party_id=".$cond." order by  invoice_no   ";
				$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
				foreach ($rowrecord as $row1)
				{		
					
					$balance_due=0;
					if($this->accounts_model->bill_wise_outstanding('invoice_summary',$row1->id)>0)
					{ 
						$balance_due=$this->accounts_model->bill_wise_outstanding('invoice_summary',$row1->id);
						$save_data['name']=$row1->invoice_no.'|Dt:'.$row1->invoice_date.'|Due:'.$balance_due.'(#'.$row1->id.')';	
						array_push($output,$save_data);

					}
					

				}

			}
			if($TranPageName=='PAYMENT')
			{
				$sql="select * from  invoice_summary  where status='PURCHASE' and tbl_party_id=".$cond." order by  invoice_no ";
				$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
				foreach ($rowrecord as $row1)
				{	
					$balance_due=0;
					if($this->accounts_model->bill_wise_outstanding('invoice_summary',$row1->id)>0)
					{ 
						$balance_due=$this->accounts_model->bill_wise_outstanding('invoice_summary',$row1->id);
						$save_data['name']=$row1->invoice_no.'|Dt:'.$row1->invoice_date.'|Due:'.$balance_due.'(#'.$row1->id.')';	
						array_push($output,$save_data);

					}
				}

			}
			
			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($output);
		}

		if($datatype=='BILLID')
		{			
				$sql="select * from  invoice_summary  where id=".$cond." ";
				$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
				foreach ($rowrecord as $row1)
				{		
					
					$save_data['TABLE_NAME']='invoice_summary';
					$save_data['id']=$row1->id;
					$save_data['name']=$row1->invoice_no;		
					$save_data['bill_due_amt']=$this->accounts_model->bill_wise_outstanding($save_data['TABLE_NAME'],$save_data['id']);	
					array_push($output,$save_data);
				}	
				
			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($output);
		}

	



		if($datatype=='EMPLOYEE_NAME')
		{
			$sql="select * from  tbl_employee_mstr  where login_status<>'ADMIN' and  status='ACTIVE' order by  name  ";
			$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
			foreach ($rowrecord as $row1)
			{		
				$save_data['name']=$row1->name.' - '.$row1->login_status.'(#'.$row1->id.')';	
				array_push($output,$save_data);
			}
			
			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($output);
		}

		if($datatype=='employee_id')
		{
			$sql="select * from  tbl_employee_mstr  where id=".$cond." ";
			$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
			foreach ($rowrecord as $row1)
			{		
				$save_data['TABLE_NAME']='tbl_employee_mstr';
				$save_data['id']=$row1->id;
				$save_data['name']=$row1->name;		
				$save_data['bill_due_amt']='';	
								
				array_push($output,$save_data);
			}

			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($output);
		}


		if($datatype=='SAVE')
		{
			$id_header=$id_detail='';
			$data=$return_data=$save_details=$save_hdr=array();				
			$RAW_DATA=file_get_contents("php://input");
			$form_data=json_decode(file_get_contents("php://input"));
			$json_array_count=sizeof($form_data);

			//acc_tran_header SECTION
		
			$save_hdr['TRAN_TYPE']=$TranPageName;	
			$id_header=$form_data[0]->id_header;				 
			$save_hdr['tran_date']=$form_data[0]->tran_date;					
			$save_hdr['comment']=$form_data[0]->transaction_details;
			
			//$save_hdr['comment']=$RAW_DATA;
		
			
			//ACCOUNTS HEADER ENTRY

			if($id_header=='')
			{
				
			$finyr=$this->general_library->get_fin_yr($save_hdr['tran_date']);
			$save_hdr['finyr']=$finyr;	
				
			$invsrl=1;
			$sql="select max(srl) srl  from acc_tran_header 
			where  finyr='$finyr' ";				
			$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
			foreach ($rowrecord as $row1)
			{ $invsrl=$row1->srl+1;}									
			$save_hdr['tran_code']=$invsrl.'/'.$finyr;
			$save_hdr['srl']=$invsrl;	

				$this->projectmodel->save_records_model('','acc_tran_header',$save_hdr);
				$id_header=$this->db->insert_id();
			}
			else
			{$this->projectmodel->save_records_model($id_header,'acc_tran_header',$save_hdr);}
					
			
			//ACCOUNTS DETAIL ENTRY
			
			for($i=0;$i<=$json_array_count-1;$i++)
			{
				$save_detail['acc_tran_header_id']=$id_header;
				$id_detail=$form_data[$i]->id_detail;
				$CRDR_TYPE=$form_data[$i]->CRDR_TYPE;			
				$save_detail['detailtype']=$form_data[$i]->detailtype;
				
				$save_detail['cr_ledger_account']=$save_detail['dr_ledger_account']=0;

				if($CRDR_TYPE=='CR')
				{$save_detail['cr_ledger_account']=$form_data[$i]->ledger_account_id;}
				if($CRDR_TYPE=='DR')
				{$save_detail['dr_ledger_account']=$form_data[$i]->ledger_account_id;}

				$save_detail['amount']=$form_data[$i]->ledger_amount;
				//$save_detail['detailtype']=sizeof($form_data[$i]->details);
				
				if($id_detail=='')
				{
					$this->projectmodel->save_records_model('','acc_tran_details',$save_detail);
					$id_detail=$this->db->insert_id();
				}
				else
				{$this->projectmodel->save_records_model($id_detail,'acc_tran_details',$save_detail);}


				//acc_tran_details_details SECTION
				$this->db->query("delete from acc_tran_details_details 	where acc_tran_details_id=".$id_detail);

				$details=sizeof($form_data[$i]->details);

				for($bil=0;$bil<=$details-1;$bil++)
				{
					$DETAILS['acc_tran_details_id']=$id_detail;

					$DETAILS['TABLE_NAME']=$form_data[$i]->details[$bil]->TABLE_NAME;
					$DETAILS['TABLE_ID']=	$form_data[$i]->details[$bil]->TABLE_ID;
					$DETAILS['BILL_INSTRUMENT_NO']=$form_data[$i]->details[$bil]->BILL_INSTRUMENT_NO;
					$DETAILS['EMPLOYEE_NAME']=$form_data[$i]->details[$bil]->EMPLOYEE_NAME;
					$DETAILS['AMOUNT']=$form_data[$i]->details[$bil]->AMOUNT;
					$DETAILS['CHQDATE']=$form_data[$i]->details[$bil]->CHQDATE;
					$DETAILS['BANKNAME']=$form_data[$i]->details[$bil]->BANKNAME;
					$DETAILS['BRANCH']=$form_data[$i]->details[$bil]->BRANCH;
					$DETAILS['STATUS']=$save_hdr['TRAN_TYPE'];
					$DETAILS['OPERATION_TYPE']='MINUS';

					if($DETAILS['AMOUNT']>0){$this->projectmodel->save_records_model('','acc_tran_details_details',$DETAILS);	}
				}

			}

			$return_data['id_header']='';
			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($return_data);

		}
				
		$arraindx=0;
		if($datatype=='VIEWALLVALUE')
		{
							
			$sql="select * from  acc_tran_header 	where id=".$cond;
			$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
			foreach ($rowrecord as $row1)
			{		
				$id_header=$row1->id;
				$tran_code=$row1->tran_code;
				$tran_date=$row1->tran_date;
				$transaction_details=$row1->comment;
				$TRAN_TYPE=$row1->TRAN_TYPE;
			}
			
			
			$sql_credits="select * from  acc_tran_details 	where 
			acc_tran_header_id=".$id_header." ORDER BY id";
			$sql_credits = $this->projectmodel->get_records_from_sql($sql_credits);	
			foreach ($sql_credits as $sql_credit)
			{	
				

				$acc_tran_details['id_header']=$id_header;
				$acc_tran_details['tran_code']=$tran_code;
				$acc_tran_details['tran_date']=$tran_date;
				$acc_tran_details['trantype']=$TRAN_TYPE;

				$acc_tran_details['transaction_details']=$transaction_details;
				$id_detail=$acc_tran_details['id_detail']=$sql_credit->id;				
				$acc_tran_details['detailtype']=$sql_credit->detailtype;

				$acc_tran_details['truck_id']='';
				$acc_tran_details['truck_no']='';
				$acc_tran_details['employee_id']='';
				$acc_tran_details['employee_name']='';

				if($sql_credit->cr_ledger_account>0)
				{
					$acc_tran_details['CRDR_TYPE']='CR';
					$acc_tran_details['ledger_account_id']=$sql_credit->cr_ledger_account;
					$acc_tran_details['ledger_account_name']=
					$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',
					' id='.$sql_credit->cr_ledger_account);
				}
				if($sql_credit->dr_ledger_account>0)
				{
					$acc_tran_details['CRDR_TYPE']='DR';
					$acc_tran_details['ledger_account_id']=$sql_credit->dr_ledger_account;
					$acc_tran_details['ledger_account_name']=
					$this->projectmodel->GetSingleVal('acc_name','acc_group_ledgers',
					' id='.$sql_credit->dr_ledger_account);
				}
				$acc_tran_details['ledger_amount']=$sql_credit->amount;
				

				//declare
				
				//delete array elements				
				for($bil=0;$bil<=300-1;$bil++)
				{unset($acc_tran_details['details'][$bil]);}

					$arraindx=0;
					$acc_tran_details['details'][$arraindx]['TABLE_NAME']='';
					$acc_tran_details['details'][$arraindx]['TABLE_ID']='';					
					$acc_tran_details['details'][$arraindx]['BILL_INSTRUMENT_NO']='';								
					$acc_tran_details['details'][$arraindx]['EMPLOYEE_NAME']='';
					$acc_tran_details['details'][$arraindx]['AMOUNT']='';				
					$acc_tran_details['details'][$arraindx]['CHQDATE']='';
					$acc_tran_details['details'][$arraindx]['BANKNAME']='';
					$acc_tran_details['details'][$arraindx]['BRANCH']='';
				
					$sql_bills="select * from  acc_tran_details_details where 
					acc_tran_details_id=".$id_detail." ORDER BY id";
					
					$sql_bills = $this->projectmodel->get_records_from_sql($sql_bills);	
					foreach ($sql_bills as $sql_bill)
					{				
						$acc_tran_details['details'][$arraindx]['TABLE_NAME']=$sql_bill->TABLE_NAME;
						$acc_tran_details['details'][$arraindx]['TABLE_ID']=$sql_bill->TABLE_ID;						
						$acc_tran_details['details'][$arraindx]['BILL_INSTRUMENT_NO']=$sql_bill->BILL_INSTRUMENT_NO;				
						$acc_tran_details['details'][$arraindx]['EMPLOYEE_NAME']=$sql_bill->EMPLOYEE_NAME;
						$acc_tran_details['details'][$arraindx]['AMOUNT']=$sql_bill->AMOUNT;
						$acc_tran_details['details'][$arraindx]['CHQDATE']=$sql_bill->CHQDATE;
						$acc_tran_details['details'][$arraindx]['BANKNAME']=$sql_bill->BANKNAME;
						$acc_tran_details['details'][$arraindx]['BRANCH']=$sql_bill->BRANCH;
						$arraindx=$arraindx+1;
					}
			

				array_push($output,$acc_tran_details);
				
			}	

			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($output);
		}

		if($datatype=='GetAllList')
		{
			$sql="select * from  acc_tran_header where 
			tran_date between '$fromdate' and '$todate' AND TRAN_TYPE='$cond'
				order by tran_date ";
			$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
			foreach ($rowrecord as $row1)
			{		
				$save_data['id_header']=$row1->id;
				$save_data['tran_code']=$row1->tran_code;
				$save_data['tran_date']=$row1->tran_date;
				$save_data['comment']=$row1->comment;
				array_push($output,$save_data);
			}
			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($output);
		}
	

	}
	
}


	private function transaction_update($id_header=0)	
	{
		
		if($id_header>0)
		{
			$bank_charge_fine=0;
			$freight_charge=0;
			$interest_charge=0;
			$gst2nos='';

			$sql="select * from invoice_summary where id=".$id_header;			
			$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
			foreach ($rowrecord as $row_hdr)
			{
				$BILL_TYPE=$row_hdr->BILL_TYPE;
				$disc_per=$row_hdr->disc_per;
				$bank_charge_fine=$row_hdr->bank_charge_fine;
				$freight_charge=$row_hdr->freight_charge;
				$interest_charge=$row_hdr->interest_charge;
				$cash_disc=$row_hdr->cash_disc;
				$tot_cash_discount=$row_hdr->tot_cash_discount;
				$status=$row_hdr->status;
				$tbl_party_id=$row_hdr->tbl_party_id;

				$ref_table_id=$this->projectmodel->GetSingleVal('ref_table_id','acc_group_ledgers',' id='.$tbl_party_id);
				$ref_table_name=$this->projectmodel->GetSingleVal('ref_table_name','acc_group_ledgers',' id='.$tbl_party_id);
				$party_records="select * from ".$ref_table_name." where id=".$ref_table_id." ";
				$party_records = $this->projectmodel->get_records_from_sql($party_records);	

				if($status=='PURCHASE'  or $status=='PURCHASE_RTN')
				{$gst2nos=substr($party_records[0]->GSTNo,0,2);}

				if($status=='SALE'  or $status=='SALE_RTN')
				{$gst2nos=substr($party_records[0]->GSTNO,0,2);}

			}
			
			$save_hdr['total_amt']=0;
			$save_hdr['tot_discount']=0;
			$save_hdr['totvatamt']=0;
			$BILL_TYPE='VATBILL';
			
			if($status=='PURCHASE' or $status=='SALE' or $status=='PURCHASE_RTN' or $status=='SALE_RTN')
			{
				$sql="select * from invoice_details where PRODUCT_TYPE<>'RAW' AND 	invoice_summary_id=".$id_header;			
				$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
				foreach ($rowrecord as $row1)
				{

				$inv_details['ptr']=$row1->ptr;					
				$inv_details['rate']=$row1->rate;				

				$inv_details['subtotal']=$inv_details['rate']*$row1->qnty;					
				$disc_amt=$inv_details['disc_amt']=$inv_details['subtotal']*$row1->disc_per/100;
							
				$taxable_amt=$row1->totqnty*$row1->rate;
				$inv_details['taxable_amt']=$taxable_amt;
				$inv_details['taxable_amt']=$inv_details['taxable_amt']-$inv_details['disc_amt'];
				
				//$inv_details['taxable_amt']=($row1->totqnty*$row1->rate)-$disc_amt;	
				
				$this->projectmodel->save_records_model($row1->id,'invoice_details',$inv_details);

				//$inv_details['taxable_amt']=8956;
				//GST PORTION
				if($gst2nos=='' || $gst2nos==19)
				{
					$inv_details['cgst_rate']=$row1->tax_per/2;
					$inv_details['sgst_rate']=$row1->tax_per/2;
					$inv_details['igst_rate']=0;
				}
				else
				{
					$inv_details['cgst_rate']=0;
					$inv_details['sgst_rate']=0;
					$inv_details['igst_rate']=$row1->tax_per;
				}	
			
				$inv_details['cgst_amt']=
				$inv_details['taxable_amt']*$inv_details['cgst_rate']/100;
				$inv_details['sgst_amt']=
				$inv_details['taxable_amt']*$inv_details['sgst_rate']/100;
				$inv_details['igst_amt']=
				$inv_details['taxable_amt']*$inv_details['igst_rate']/100;
				
				//TOTAL TAX AMOUNT
				$inv_details['taxamt']=$inv_details['cgst_amt']+
				$inv_details['sgst_amt']+$inv_details['igst_amt'];
									
				$this->projectmodel->save_records_model($row1->id,'invoice_details',$inv_details);
			
				
				//UPDATE SUMMARY TABLE										
				$save_hdr['total_amt']=$save_hdr['total_amt']+$inv_details['subtotal'];
				$save_hdr['tot_discount']=$save_hdr['tot_discount']+$inv_details['disc_amt'];
				$save_hdr['tot_cash_discount']= $tot_cash_discount;

				// $save_hdr['tot_cash_discount']= 
				// ($save_hdr['total_amt']-$save_hdr['tot_discount'])*$cash_disc/100;
				
				$save_hdr['totvatamt']=$save_hdr['totvatamt']+$inv_details['taxamt'];		

				$grandtot=$save_hdr['total_amt']-$save_hdr['tot_discount']-$save_hdr['tot_cash_discount']+$save_hdr['totvatamt'];
				
				$grandtot=sprintf("%01.2f",$grandtot);
				$grandtot1=sprintf("%01.0f",$grandtot);
				$rndoff=$grandtot-$grandtot1;
				$save_hdr['rndoff']=sprintf("%01.2f",$rndoff);	
				$save_hdr['grandtot']=$grandtot-$rndoff;
				
				$this->projectmodel->save_records_model($id_header,'invoice_summary',$save_hdr);	
			}

			$this->accounts_model->ledger_transactions($id_header,$status);
			
			}

		}




	}


	

	public function reports($frmrpttemplatehdrID=0,$operation_type='list')
	{
		$layout_data=array();
		$data=array();
		$data['sql_error'] ='';
		$data['fromdate'] =$data['todate'] =date('Y-m-d');
		$data['frmrpttemplatehdrID']=$frmrpttemplatehdrID;

		if($frmrpttemplatehdrID==29 ) //SALE REGISTER
		{
			$data['party_id'] =0;

			$data['GridHeader']= array("Invoice No-left", "Date-left","Party-left", "Total Amt-right", "Discount-right", "Tax Amount-right"
			, "Grand Total-right","Doctor-left");
			
			$records="select * from frmrpttemplatehdr where id=".$frmrpttemplatehdrID;
			$records = $this->projectmodel->get_records_from_sql($records);	
			foreach ($records as $record)
			{	
					$data['DisplayGrid']=$record->DisplayGrid;
					$data['NEWENTRYBUTTON']=$record->NEWENTRYBUTTON;
					$data['FormRptName']=$record->FormRptName;
					$ControllerFunctionLink=$record->ControllerFunctionLink.$frmrpttemplatehdrID.'/';	 
					$data['tran_link'] = ADMIN_BASE_URL.$ControllerFunctionLink; 
					$view_path_name=$record->ViewPath; 
					$data['rs']=$this->projectmodel->GetMultipleVal('*',$record->TableName,$record->WhereCondition,$record->OrderBy);

					if($operation_type=='save')
					{
						$data['party_id'] =$this->input->post('party_id');
						if($data['party_id']<>0)
						{
							$whr='tbl_party_id='.$data['party_id'];
							$data['rs']=$this->projectmodel->GetMultipleVal('*',$record->TableName,$whr,$record->OrderBy);
						}
					
						$data['fromdate'] =$this->input->post('fromdate');
						$data['todate'] =$this->input->post('todate');
					}
					
			}
		}


		if($frmrpttemplatehdrID==30 ) //PURCHASE REGISTER
		{
			$data['party_id'] =0;
			
			$data['GridHeader']= array("Invoice No-left", "Date-left","Party-left", "Total Amt-right", "Discount-right", "Tax Amount-right"
			, "Grand Total-right");
			
			$records="select * from frmrpttemplatehdr where id=".$frmrpttemplatehdrID;
			$records = $this->projectmodel->get_records_from_sql($records);	
			foreach ($records as $record)
			{	
					$data['DisplayGrid']=$record->DisplayGrid;
					$data['NEWENTRYBUTTON']=$record->NEWENTRYBUTTON;
					$data['FormRptName']=$record->FormRptName;
					$ControllerFunctionLink=$record->ControllerFunctionLink.$frmrpttemplatehdrID.'/';	 
					$data['tran_link'] = ADMIN_BASE_URL.$ControllerFunctionLink; 
					$view_path_name=$record->ViewPath; 
					$data['rs']=$this->projectmodel->GetMultipleVal('*',$record->TableName,$record->WhereCondition,$record->OrderBy);

					if($operation_type=='save')
					{
						$data['party_id'] =$this->input->post('party_id');
						if($data['party_id']<>0)
						{
							$whr='tbl_party_id='.$data['party_id'];
							$data['rs']=$this->projectmodel->GetMultipleVal('*',$record->TableName,$whr,$record->OrderBy);
						}
					
						$data['fromdate'] =$this->input->post('fromdate');
						$data['todate'] =$this->input->post('todate');
					}
					
			}
		}

		$view_path_name=$view_path_name;
   		$this->page_layout_display($view_path_name,$data);

	}

	//MIS REPORTS SECTIONS

	//ALL REPORT SECTIONS	
	public function all_mis_reports($REPORT_NAME='PRODUCT_GROUP',$param1=0,$param2=0,$param3=0,$param4=0,$param5=0)
	{	
		
			$data=array();
			$data['tran_link']=ADMIN_BASE_URL.'Accounts_controller/all_mis_reports/'.$REPORT_NAME.'/';
			$data['REPORT_NAME'] =$REPORT_NAME;	
			$data['param1'] =$param1;
			$data['param2'] =$param2;
			$data['param3'] =$param3;
			$data['param4'] =$param4;
			$data['param5'] =$param5;
			$data['ledger_ac']=0;
			$data['report_data'] ='';
			$data['fromdate']=date('Y-m-d');
			$data['todate']=date('Y-m-d');
			$data['with_paran']='NO';

			$data['REPORT_TYPE']='REPORT_TYPE-1';
					
			if($REPORT_NAME=='PTOP_ACCOUNTS')
			{
					//$data['fromdate']=date('Y-m-d');
					//$data['todate']=date('Y-m-d');
					$sqlinv="select * from invoice_summary where status='REQUISITION'  order by req_number ";			
			  	$data['ledger_accounts'] =$this->projectmodel->get_records_from_sql($sqlinv);
			}

			if($REPORT_NAME=='OTOC_REPORT')
			{
					//$data['fromdate']=date('Y-m-d');
					//$data['todate']=date('Y-m-d');
					$sqlinv="select * from invoice_summary where status='SALES_ORDER'  order by req_number ";			
			  	$data['ledger_accounts'] =$this->projectmodel->get_records_from_sql($sqlinv);
			}
			
			if($REPORT_NAME=='TRIAL_BALANCE' || $REPORT_NAME=='PROFIT_LOSS_ACCOUNT' || $REPORT_NAME=='BALANCE_SHEET')
			{
				//	$sql="update acc_group_ledgers set temp_debit_balance=0,temp_credit_balance=0   ";
				//	$this->db->query($sql);
					$data['fromdate']=date('Y-m-d');
					$data['todate']=date('Y-m-d');			
					$data['REPORT_TYPE']='REPORT_TYPE-2';	
			}
			

				
			if(isset($_POST['Save']))
			{						 
				$data['with_paran']='YES';

				// if($REPORT_NAME=='PRODUCT_GROUP')
				// {$data['todate']=$this->input->post('todate');}
				
			
				if($REPORT_NAME=='PTOP_ACCOUNTS')
				{
					$data['ledger_ac']=$this->input->post('param1');
				}
				if($REPORT_NAME=='OTOC_REPORT')
				{
					$data['ledger_ac']=$this->input->post('param1');
				}	
				
				if($REPORT_NAME=='TRIAL_BALANCE' || $REPORT_NAME=='PROFIT_LOSS_ACCOUNT' || $REPORT_NAME=='BALANCE_SHEET')
				{
					$data['fromdate']=$this->input->post('fromdate');
					$data['todate']=$this->input->post('todate');
				}


			}


			
			if(	$data['with_paran']=='YES')
			{$data['report_data'] =$this->accounts_model->all_mis_report($REPORT_NAME,$data);}
			
			$data['report_parameter'] = $this->load->view('accounts_management/MIS_REPORTS/all_mis_reports_parameters',$data, true);			
			//$data['report_data'] =$this->accounts_model->all_mis_report($REPORT_NAME,$data);
			$view_path_name='accounts_management/MIS_REPORTS/all_mis_reports';
			$this->page_layout_display($view_path_name,$data);

}

	public function sale_purchase_crnote_drnote_register($frmrpttemplatehdrID=0,$operation_type='list')
	{
		$layout_data=array();
		$data=array();
		$data['sql_error'] ='';
		$data['fromdate'] =$data['todate'] =date('Y-m-d');	
		$data['party_id'] =0;
		$data['frmrpttemplatehdrID']=$frmrpttemplatehdrID;

		if($frmrpttemplatehdrID==23 or $frmrpttemplatehdrID==25) //SALE SECTION
		{$data['GridHeader']= array("SysId#-left", "Party-left","GST NO-left", "Outstanding-right");}
			
		$records="select * from frmrpttemplatehdr where id=".$frmrpttemplatehdrID;
		$records = $this->projectmodel->get_records_from_sql($records);	
		foreach ($records as $record)
		{	
				$data['DisplayGrid']=$record->DisplayGrid;
				$data['NEWENTRYBUTTON']=$record->NEWENTRYBUTTON;
				$data['FormRptName']=$record->FormRptName;
				$ControllerFunctionLink=$record->ControllerFunctionLink.$frmrpttemplatehdrID.'/';	 
				$data['tran_link'] = ADMIN_BASE_URL.$ControllerFunctionLink; 
				$view_path_name=$record->ViewPath; 
				$data['rs']=$this->projectmodel->GetMultipleVal('*',$record->TableName,$record->WhereCondition,$record->OrderBy);

				if($operation_type=='save')
				{
					$data['party_id'] =$this->input->post('party_id');
					if($data['party_id']<>0)
					{
						$whr='id='.$data['party_id'];
						$data['rs']=$this->projectmodel->GetMultipleVal('*',$record->TableName,$whr,$record->OrderBy);
					}
				
					 $data['fromdate'] =$this->input->post('fromdate');
					 $data['todate'] =$this->input->post('todate');
				}
				
		}

		$view_path_name=$view_path_name;
   		$this->page_layout_display($view_path_name,$data);

	}

	public function gst_reports($operation_type='listing')
	{
		//$this->excel->setActiveSheetIndex(0);
		$data['fromdate']=date('Y-m-d');
		$data['todate']=date('Y-m-d');
		
		if(isset($_POST) && $operation_type=='Download')
		{
			 $startingdate=$data['fromdate']=$this->input->post('fromdate');
			 $closingdate=$data['todate']=$this->input->post('todate');
			$sheet = $this->excel->getActiveSheet();
     
      // SHEET B2B
	  	$i=1;
      $objWorkSheet1 = $this->excel->createSheet($i); //Setting index when creating
    	 $total_invoice_value=0;
	 		 $objWorkSheet1->setCellValue('A1', 'Summary For B2B(4)')
                   ->setCellValue('A2', 'No. of Recipients!')
                   ->setCellValue('B2', 'No. of Invoices')
                   ->setCellValue('D2', 'Total Invoice Value');
	
			 $objWorkSheet1->setCellValue('A4', 'GSTIN/UIN of Recipient')
	 			   ->setCellValue('B4', 'Party Name')
                   ->setCellValue('C4', 'Invoice Number')
                   ->setCellValue('D4', 'Invoice date')
                   ->setCellValue('E4', 'Invoice Value')
				   ->setCellValue('F4', 'Place Of Supply')
				   ->setCellValue('G4', 'Reverse Charge')
				   ->setCellValue('H4', 'Invoice Type')
				   ->setCellValue('I4', 'E-Commerce GSTIN')
				   ->setCellValue('J4', 'Rate')
				   ->setCellValue('K4', 'Taxable Value')
				   ->setCellValue('L4', 'Cess Amount');
	
				// DATA portion
				
				
				$stckist_ids=0;
				$other_records=" select b.* from tbl_party a,acc_group_ledgers b where a.GSTNo<>'' and a.id=b.ref_table_id and b.VOUCHER_TYPE='SUNDRY_DEBTORS' ";
				$other_records =
				$this->projectmodel->get_records_from_sql($other_records);	
				foreach ($other_records as $other_record)
				{$stckist_ids=$other_record->id.','.$stckist_ids;}
				$len=strlen($stckist_ids);
				 $stckist_ids=substr($stckist_ids,0,$len-1);
				$stckist_ids=$stckist_ids.'0';
				if( $stckist_ids=='')
				{ $stckist_ids=0;}
				
								
				$cell=5;
				$records="select * from invoice_summary where  status='SALE'  ";
				if($startingdate<>'' and $closingdate<>'')
				{
					$records=$records." and invoice_date between 
					'".$startingdate."' and '".$closingdate."' ";							
				}		
				 $records=$records." order by invoice_date";
				$records =$this->projectmodel->get_records_from_sql($records);	
				foreach ($records as $record)
				{
				
				$statename_code=$gstno='';
				$other_records=" select a.* from tbl_party a,acc_group_ledgers b where a.GSTNo<>'' and b.id=".$record->tbl_party_id;
				$other_records =
				$this->projectmodel->get_records_from_sql($other_records);	
				foreach ($other_records as $other_record)
				{
					$gstno=$other_record->GSTNo;
					$partyname=$other_record->party_name;

					$whr="id=".$other_record->State_stateCode;
					$rs=$this->projectmodel->GetMultipleVal('*','misc_mstr',$whr);
					$json_array_count=sizeof($rs);	 
					for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
					{$statename_code=$rs[$fieldIndex]['name_value'].'-'.$rs[$fieldIndex]['name'];}				

					//$statename_code=$other_record->STATE_CODE.'-'.$other_record->STATE_NAME;
				}
				
			
				$gstrate=$taxable_amt=0;
				$other_records="select * from invoice_details where invoice_summary_id=".$record->id."";
				$other_records =
				$this->projectmodel->get_records_from_sql($other_records);	
				foreach ($other_records as $other_record)
				{
					$gstrate=$other_record->tax_per;
					$taxable_amt=$taxable_amt+$other_record->taxable_amt;
				}
				//$taxable_amt=round($taxable_amt*$gstrate/100,2);
				
				$month='';
				if(substr($record->invoice_date,5,2)=='01')
				{ $month='JAN';  }
				if(substr($record->invoice_date,5,2)=='02')
				{  $month='FEB';  }
				if(substr($record->invoice_date,5,2)=='03')
				{  $month='MAR';  }
				if(substr($record->invoice_date,5,2)=='04')
				{  $month='APR';  }
				if(substr($record->invoice_date,5,2)=='05')
				{  $month='MAY';  }
				if(substr($record->invoice_date,5,2)=='06')
				{  $month='JUN';  }
				if(substr($record->invoice_date,5,2)=='07')
				{  $month='JUL';  }
				if(substr($record->invoice_date,5,2)=='08')
				{ $month='AUG';   }
				if(substr($record->invoice_date,5,2)=='09')
				{  $month='SEP';  }
				if(substr($record->invoice_date,5,2)=='10')
				{  $month='OCT';  }
				if(substr($record->invoice_date,5,2)=='11')
				{  $month='NOV';  }
				if(substr($record->invoice_date,5,2)=='12')
				{  $month='DEC';  }
				
				
				$newdate=
				substr($record->invoice_date,8,2).'-'.
				$month.'-'.
				substr($record->invoice_date,2,2);
				
					if($gstno<>'')
					{
						$total_invoice_value=$total_invoice_value+$record->grandtot;
						
						$objWorkSheet1->setCellValue('A'.$cell, $gstno)
						   ->setCellValue('B'.$cell, $partyname)
						   ->setCellValue('C'.$cell, $record->invoice_no)
						   ->setCellValue('D'.$cell, $newdate)
						   ->setCellValue('E'.$cell, $record->grandtot)
						   ->setCellValue('F'.$cell, $statename_code)
						   ->setCellValue('G'.$cell, 'N/Y')
						   ->setCellValue('H'.$cell, 'Regular')
						   ->setCellValue('I'.$cell, '')
						   ->setCellValue('J'.$cell, $gstrate)
						   ->setCellValue('K'.$cell, $taxable_amt)
						   ->setCellValue('L'.$cell, 'Cess Amount');
					
					    $cell=$cell+1;	   
					 }
				}
				
				
				$No_of_invoice=$No_of_Recipients=0;
				$records="select distinct(tbl_party_id) No_of_Recipients  from invoice_summary where  status='SALE' 
				and  tbl_party_id in (".$stckist_ids.") ";
				if($startingdate<>'' and $closingdate<>'')
				{
					$records=$records." and invoice_date between 
					'".$startingdate."' and '".$closingdate."' ";							
				}	
				$records =$this->projectmodel->get_records_from_sql($records);	
				foreach ($records as $record)
				{ $No_of_Recipients=$No_of_Recipients+1;}
				
				$records="select count(*)  
				No_of_invoice  from invoice_summary where  status='SALE' 
				and  tbl_party_id in (".$stckist_ids.") ";
				if($startingdate<>'' and $closingdate<>'')
				{
					$records=$records." and invoice_date between 
					'".$startingdate."' and '".$closingdate."' ";							
				}		
				$records =$this->projectmodel->get_records_from_sql($records);	
				foreach ($records as $record)
				{ $No_of_invoice=$record->No_of_invoice;}
				
				
				$objWorkSheet1->setCellValue('A3', $No_of_Recipients)
                   ->setCellValue('B3',  $No_of_invoice)
                   ->setCellValue('D3', $total_invoice_value);
				
				
				
      			// Rename sheet
    			 $objWorkSheet1->setTitle("B2B");
	
		
		
		 /*  ================================================================  */
		
		
		
		
		//B2CS SECTION  START
			 $total_invoice_value=0;	
			 $i=2;
			  $objWorkSheet2 = $this->excel->createSheet($i); //Setting index when creating
			
			  $objWorkSheet2->setCellValue('A1', 'Summary For B2CS(7)')
						   ->setCellValue('D2', 'Total Taxable  Value')
						   ->setCellValue('E2', 'Total Cess');
			
			  $objWorkSheet2->setCellValue('A4', 'Type')
						   ->setCellValue('B4', 'Place Of Supply')
						   ->setCellValue('C4', 'Rate')
						   ->setCellValue('D4', 'Taxable Value')
						   ->setCellValue('E4', 'Cess Amount')
						   ->setCellValue('F4', 'E-Commerce GSTIN')
						    ->setCellValue('G4', 'Total tax Amount')
							->setCellValue('H4', 'Grand Total');
						   
	
				// DATA portion
				$cell=5;
				$records="select * from invoice_summary where  status='SALE'  ";
				if($startingdate<>'' and $closingdate<>'')
				{
					$records=$records." and invoice_date between 
					'".$startingdate."' and '".$closingdate."' ";							
				}		
				$records=$records." order by invoice_date";
				$records =$this->projectmodel->get_records_from_sql($records);	
				foreach ($records as $record)
				{
				
				$statename_code='19-West Bengal';
				$gstno='';
				$other_records=" select a.* from tbl_party a,acc_group_ledgers b where a.GSTNo<>'' and b.id=".$record->tbl_party_id;
				$other_records =
				$this->projectmodel->get_records_from_sql($other_records);	
				foreach ($other_records as $other_record)
				{
					$gstno=$other_record->GSTNo;

					$whr="id=".$other_record->State_stateCode;
					$rs=$this->projectmodel->GetMultipleVal('*','misc_mstr',$whr);
					$json_array_count=sizeof($rs);	 
					for($fieldIndex=0;$fieldIndex<$json_array_count;$fieldIndex++)
					{$statename_code=$rs[$fieldIndex]['name_value'].'-'.$rs[$fieldIndex]['name'];}	
				
				}
				
				
					if($gstno=='')
					{
						
						$total_value=$tax_amount=$gstrate=$taxable_amt=0;
						$other_records="select * from invoice_details 
						where invoice_summary_id=".$record->id."";
						$other_records =
						$this->projectmodel->get_records_from_sql($other_records);	
						foreach ($other_records as $other_record)
						{
							$gstrate=$other_record->tax_per;
							$taxable_amt=$taxable_amt+$other_record->taxable_amt;
							$tax_amount=$tax_amount+$other_record->cgst_amt+
							$other_record->sgst_amt+$other_record->igst_amt;
						}
						
						
						 $total_invoice_value=$total_invoice_value+$taxable_amt;
						 $objWorkSheet2->setCellValue('A'.$cell, 'E')
						   ->setCellValue('B'.$cell, $statename_code)
						   ->setCellValue('C'.$cell, $gstrate)
						   ->setCellValue('D'.$cell, $taxable_amt)
						   ->setCellValue('E'.$cell, 'Cess Amount')
						   ->setCellValue('F'.$cell, 'E-Commerce GSTIN')
						   ->setCellValue('G'.$cell, $tax_amount)
						   ->setCellValue('H'.$cell, $tax_amount+$taxable_amt);
					
					    $cell=$cell+1;	   
					 }
				}
				
				
				 $objWorkSheet2->setCellValue('D3', $total_invoice_value);
      			// Rename sheet
    			 $objWorkSheet2->setTitle("B2CS");
				
				//B2CS SECTION  END 
				
				 /*  ================================================================  */
				
				
				
			   //HSN SECTION  START 
				
			   $total_invoice_value=0;	
			   $i=3;
			  $objWorkSheet = $this->excel->createSheet($i); //Setting index when creating
			
			  $objWorkSheet->setCellValue('A1', 'Summary For HSN(12)')
						   ->setCellValue('A2', 'No. of HSN')
						   ->setCellValue('E2', 'Total Value')
						   ->setCellValue('F2', 'Total Taxable Value')
						   ->setCellValue('G2', 'Total Integrated Tax')
						   ->setCellValue('H2', 'Total Central Tax')
						   ->setCellValue('I2', 'Total State/UT Tax')
						   ->setCellValue('J2', 'Total Cess');
			
			  $objWorkSheet->setCellValue('A4', 'HSN')
						   ->setCellValue('B4', 'Description')
						   ->setCellValue('C4', 'UQC')
						   ->setCellValue('D4', 'Total Quantity')
						   ->setCellValue('E4', 'Total Value')
						   ->setCellValue('F4', 'Taxable Value')
						   ->setCellValue('G4', 'Integrated Tax Amount')
						   ->setCellValue('H4', 'Central Tax Amount')
						   ->setCellValue('I4', 'State/UT Tax Amount')
						   ->setCellValue('J4', 'Cess Amount');
						   
	
				// DATA portion
				$cell=5;
				
				$invoice_summary_id=0;
				$records="select * from invoice_summary where  status='SALE'  ";
				if($startingdate<>'' and $closingdate<>'')
				{
					$records=$records." and invoice_date between 
					'".$startingdate."' and '".$closingdate."' ";							
				}		
				$records =$this->projectmodel->get_records_from_sql($records);	
				foreach ($records as $record)
				{$invoice_summary_id=$invoice_summary_id.','.$record->id;}
				$invoice_summary_id=rtrim($invoice_summary_id, ',');
				
				$TotalValueGrand=$TaxableValueGrand=$CentralTaxAmountGrand=0;
				$StateTaxAmountGrand=0;
				$IntegratedTaxAmountGrand=0;
				
				$gstno='';
				$other_records=" select * from productmstr 	where  hsncode<>''";
				$other_records =
				$this->projectmodel->get_records_from_sql($other_records);	
				foreach ($other_records as $other_record)
				{  
				    $hsncode=$other_record->hsncode;
					$product_id=$other_record->id;
					$brand_name=$other_record->productname;
				
					$gstrate=$taxable_amt=0;
					$other_records="select 
					sum(qnty) TotalQuantity,
					sum(subtotal) TotalValue,
					sum(taxable_amt) TaxableValue,
					sum(cgst_amt) CentralTaxAmount,
					sum(sgst_amt) StateTaxAmount,
					sum(igst_amt) IntegratedTaxAmount
					
					 from invoice_details 
					where invoice_summary_id in (".$invoice_summary_id.") 
					and product_id=".$product_id;
					$other_records =
					$this->projectmodel->get_records_from_sql($other_records);	
					foreach ($other_records as $other_record)
					{
						$TotalQuantity=$other_record->TotalQuantity;
						//$TotalValue=$other_record->TotalValue;
						$TaxableValue=$other_record->TaxableValue;
						
						$CentralTaxAmount=$other_record->CentralTaxAmount;
						$StateTaxAmount=$other_record->StateTaxAmount;
						$IntegratedTaxAmount=$other_record->IntegratedTaxAmount;
						
						$TotalValue=$TaxableValue+$CentralTaxAmount+
						$StateTaxAmount+$IntegratedTaxAmount;
						
						$TotalValueGrand=
						$TotalValueGrand+$TotalValue;
						
						$TaxableValueGrand=
						$TaxableValueGrand+$other_record->TaxableValue;
						
						$CentralTaxAmountGrand=
						$CentralTaxAmountGrand+$other_record->CentralTaxAmount;
						
						$StateTaxAmountGrand=
						$StateTaxAmountGrand+$other_record->StateTaxAmount;
						
						$IntegratedTaxAmountGrand=
						$IntegratedTaxAmountGrand+$other_record->IntegratedTaxAmount;
						
					}
					
						 $objWorkSheet->setCellValue('A'.$cell, $hsncode)
						   ->setCellValue('B'.$cell, $brand_name)
						   ->setCellValue('C'.$cell, '-')
						   ->setCellValue('D'.$cell, $TotalQuantity)
						   ->setCellValue('E'.$cell, $TotalValue)
						   ->setCellValue('F'.$cell, $TaxableValue)
						   ->setCellValue('G'.$cell, $IntegratedTaxAmount)
						   ->setCellValue('H'.$cell, $CentralTaxAmount)
						   ->setCellValue('I'.$cell, $StateTaxAmount)
						   ->setCellValue('J'.$cell, 'Cess Amount');
						
					    $cell=$cell+1;	   
				}
				
				  $objWorkSheet->setCellValue('E3', $TotalValueGrand)
						   ->setCellValue('F3', $TaxableValueGrand)
						   ->setCellValue('G3', $IntegratedTaxAmountGrand)
						   ->setCellValue('H3', $CentralTaxAmountGrand)
						   ->setCellValue('I3', $StateTaxAmountGrand)
						   ->setCellValue('J3', 'Total Cess');
				
				// $objWorkSheet->setCellValue('D3', $total_invoice_value);
      			// Rename sheet
    			 $objWorkSheet->setTitle("HSN");
				
				
				
				//HSN SECTION  END  
				
				
			
			$filename='GST.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); 
			//tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
						
			//save it to Excel5 format (excel 2003 .XLS file), 
			//change this to 'Excel2007' (and adjust the filename 
			//extension, also the header mime type)
			//if you want to save it as .XLSX Excel 2007 format
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');

		}

		$view_path_name='accounts_management/MIS_REPORTS/gst_reports';
	    $this->page_layout_display($view_path_name,$data);


	}


	// ACCOUNTS REPORTS SECTIONS
	
	public function load_ajax()
	{
		 $data_list['viewname'] = $this->input->post('viewname');
		 $data_list['tran_table_name'] = $this->input->post('tran_table_name');
		 $data_list['fldname'] = $this->input->post('fldname');
		$this->load->view('accounts_management/transaction/main_ajax_view', $data_list);
		
	}
	
	
	
	private function login_validate(){
       if($this->session->userdata('login_userid')=='')
		{ $this->projectmodel->logout();}
	}	
	
	
	private function report_page_layout_display($view_path_name,$data)
	{
		   $layout_data['data_info'] = 
		   $this->load->view($view_path_name,$data, true);			
		   $layout_data['body'] = $this->load->view('common/body', $layout_data, true);		 
		   $this->load->view('report_layout', $layout_data);
		   $this->session->set_userdata('alert_msg', '');	
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


}

?>