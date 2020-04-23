<?php
class Project_model extends CI_Model {
   

function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('thumb_model', 'thumb');
		$this->load->model('accounts_model');
    }
	
    /*LOGIN LOGOUT*/
			
	public function validate()
	{
        // grab user input
        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean($this->input->post('password'));
        
		
		 $COMP_ID='';
		 $sqlemp="select * from company_details where id=1";
		 $rowrecordemp = $this->projectmodel->get_records_from_sql($sqlemp);	
		 foreach ($rowrecordemp as $rowemp)
		 {$this->session->set_userdata('COMP_ID', $rowemp->COMP_ID);}	
		
      	 $count=0;
		 $sqlemp="select count(*) cnt from tbl_employee_mstr where 
		 userid='$username' and password='$password' and status <>'INACTIVE' and tbl_designation_id<>6";
		 $rowrecordemp = $this->projectmodel->get_records_from_sql($sqlemp);	
		 foreach ($rowrecordemp as $rowemp)
		 {$count=$rowemp->cnt;}	
		
		
		//echo 'ttttt'.$query->num_rows;
        if($count == 1)
        {	
			$sqlemp="select *  from tbl_employee_mstr where 
			userid='$username' and password='$password' and status <>'INACTIVE' and	 tbl_designation_id<>6";
			$rowrecordemp = $this->projectmodel->get_records_from_sql($sqlemp);	
			foreach ($rowrecordemp as $row)
			{						           
           			 $data = array(
                    'login_userid' => $row->userid,
                    'login_name' => $row->name,
                    'login_emp_id' => $row->id,
					'login_tbl_designation_id'=> $row->tbl_designation_id,
					'login_status'=> $row->login_status,
					'activity_status'=> $row->status,
					'account_setup_id'=>$row->account_setup_id,
                    'validated' => true
                    );
            		$this->session->set_userdata($data);
			}
            return true;
        }
        // If the previous process did not validate
        // then return false.
        return false;
		
		
    }
	function logout(){
		
		$this->session->unset_userdata('login_userid');
		$this->session->unset_userdata('login_name');
		$this->session->unset_userdata('login_emp_id');
		$this->session->unset_userdata('login_tbl_designation_id');
		$this->session->unset_userdata('login_status');
		$this->session->unset_userdata('validated');
		
		//redirect('project_controller/', 'refresh');
		redirect('/', 'refresh');
		exit();
	}
	
	function update_password($data){
		//$pass = $this->encoded($data['pass1']);
		$pass = $data['pass1'];
		$a_id = $this->session->userdata('login_emp_id');
		$query = $this->db->query("SELECT count(*) FROM tbl_employee_mstr WHERE id = '$a_id' AND password = '$pass' AND   login_status = 'USER'");
		if ($query->num_rows() > 0){
			//$pass = $this->encoded($data['pass2']);
			$pass =$data['pass2'];
			$query = $this->db->query("UPDATE 
			`tbl_employee_mstr` SET password = '$pass' WHERE `id` = '$a_id' ");
			$this->logout();
		}
	}
	/*LOGIN LOGOUT END*/

	

	function segment_update($header_id)
	{
		$setting=$update_data=array();	
		$setting=$this->user_wise_setting(); 
		$segment_value='';

		$details="select * from  invoice_details  where invoice_summary_id=".$header_id." ";					
		$details = $this->get_records_from_sql($details);	
		foreach ($details as $key2=>$detail)
		{	
			$parent_id=$detail->parent_id;

			$cnts2=sizeof($setting['segment']);
			for($cnt=0;$cnt<$cnts2;$cnt++)
			{
			$field_qualifier_name=$setting['segment'][$cnt]['field_qualifier_name'];
			$whr=" id=".$parent_id;	
			$segment_value=$this->GetSingleVal($field_qualifier_name,'invoice_details',$whr); 			
			$update_data[$field_qualifier_name]=$segment_value;
			}

			$this->projectmodel->save_records_model($detail->id,'invoice_details',$update_data);

		}
	}

	function user_wise_setting()
	{

		$setting=array();		
		$a_id = $this->session->userdata('login_emp_id');
		$setting['login_emp_id']= $this->session->userdata('login_emp_id');
		$whr=" id=".$this->session->userdata('login_emp_id');	
		$username=$this->GetSingleVal('name','tbl_employee_mstr',$whr); 
		$setting['login_emp_name']= $username;

		$setting['account_setup_id']=$this->session->userdata('account_setup_id');
		$whr=" id=".$this->session->userdata('account_setup_id');	
		$setting['legal_entity_id']=$this->GetSingleVal('legal_entity_id','account_setup',$whr); 
		$chart_of_account_id=$setting['chart_of_account_id']=$this->GetSingleVal('chart_of_account_id','account_setup',$whr); 

		$setting['calendar_id']=$this->GetSingleVal('calendar_id','account_setup',$whr); 
		$setting['currency_id']=$this->GetSingleVal('currency_id','account_setup',$whr); 
		$whr=" id=".$setting['currency_id'];	
		$setting['currency_name']=$this->GetSingleVal('code','tbl_currency_master',$whr); 

		$whr=" id=".$setting['legal_entity_id'];
		$setting['req_organization_id']= $setting['legal_entity_id'];	
		$setting['req_organization_name']=$this->GetSingleVal('NAME','company_details',$whr); 
		$location_id=$this->GetSingleVal('location_id','company_details',$whr);
		$whr=" id=".$location_id;
		$setting['req_location']=$this->GetSingleVal('name','tbl_location',$whr);
		$setting['segments']='';
		
		
		//SEGMENT AND VALUE SET
		$segment_name=$segments='';
		$cnt=0;
		$records="select * FROM tbl_chart_of_accounts where  parent_id=".$chart_of_account_id." 
		and trantype='CHART_OF_ACCOUNT_SEGMENT' and status='ACTIVE' ";						
		$records = $this->projectmodel->get_records_from_sql($records);	
		foreach ($records as $key=>$record)
		{								
			
			$sql="select  count(*) count  from tbl_chart_of_accounts where  parent_id=".$record->id." 
			and trantype='CHART_OF_ACCOUNT_VALUESET' AND acc_type=158 and status='ACTIVE'";
			$datafields_array =$this->projectmodel->get_records_from_sql($sql);
			if($datafields_array[0]->count>0)
			{
				$whr=" id=".$record->field_qualifier;
				$segment_name=$this->GetSingleVal('FieldID','frmrptgeneralmaster',$whr);
				 $segments=$segments.','.$segment_name;

				$whr=" id=".$record->field_qualifier;
				$setting['segment'][$cnt]['field_qualifier_name']=$this->GetSingleVal('FieldID','frmrptgeneralmaster',$whr);
				
				$setting['segment'][$cnt]['segment_name']=$record->title;	
				$sql="select  id FieldID,title FieldVal  from 
				tbl_chart_of_accounts where  parent_id=".$record->id." and
				 trantype='CHART_OF_ACCOUNT_VALUESET' AND acc_type=158 and status='ACTIVE'";
				$datafields_array =$this->projectmodel->get_records_from_sql($sql);	
				$setting['segment'][$cnt]['value_set']=json_decode(json_encode($datafields_array), true);
				$cnt=$cnt+1;
			}

		}
		 $setting['segments']=$segments;
		//substr($segments,-1);

		
		return $setting;

		
	}


	function get_ac_segments($chart_of_account_id)
	{

		$setting=array();		
		
		$setting['segments']='';
		//SEGMENT AND VALUE SET
		$segment_name=$segments='';
		$cnt=0;
		 $records="select * FROM tbl_chart_of_accounts where  parent_id=".$chart_of_account_id." and trantype='CHART_OF_ACCOUNT_SEGMENT' and status='ACTIVE' ";						
		$records = $this->projectmodel->get_records_from_sql($records);	
		foreach ($records as $key=>$record)
		{								
			
			$sql="select  count(*) count  from tbl_chart_of_accounts where  parent_id=".$record->id." 
			and trantype='CHART_OF_ACCOUNT_VALUESET' AND acc_type=158 and status='ACTIVE'";
			$datafields_array =$this->projectmodel->get_records_from_sql($sql);
			if($datafields_array[0]->count>0)
			{
				$whr=" id=".$record->field_qualifier;
				$segment_name=$this->GetSingleVal('FieldID','frmrptgeneralmaster',$whr);
				 $segments=$segments.','.$segment_name;

				$whr=" id=".$record->field_qualifier;
				$setting['segment'][$cnt]['field_qualifier_name']=$this->GetSingleVal('FieldID','frmrptgeneralmaster',$whr);
				
				$setting['segment'][$cnt]['segment_name']=$record->title;	
				$sql="select  id FieldID,title FieldVal  from 
				tbl_chart_of_accounts where  parent_id=".$record->id." and
				 trantype='CHART_OF_ACCOUNT_VALUESET' AND acc_type=158 and status='ACTIVE'";
				$datafields_array =$this->projectmodel->get_records_from_sql($sql);	
				$setting['segment'][$cnt]['value_set']=json_decode(json_encode($datafields_array), true);
				$cnt=$cnt+1;
			}

		}
		 $setting['segments']=$segments;
		//substr($segments,-1);

		
		return $setting;

		
	}



	function other_setting($form_structure=array(),$form_name='requisition')
	{
		$setting=$this->user_wise_setting(); 


		if($form_name=='requisition')
		{
			
			
			//aanatuaral account ...link to credit account

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
			
			
			$form_structure["header"][0]['fields'][0]['req_type']['Inputvalue']='Purchase Requisition';
			$form_structure["header"][0]['fields'][0]['req_type']['Inputvalue_id']=92;
			$form_structure["header"][0]['fields'][0]['req_status']['Inputvalue_id']=91;

			$sql="select  id FieldID,hierarchy_name FieldVal  from tbl_hierarchy_org
			where  company_details_id=".$setting['legal_entity_id']." order by hierarchy_name	";
			$datafields_array =$this->projectmodel->get_records_from_sql($sql);
			$form_structure["header"][2]['fields'][0]['req_subinventory']['datafields']=
			json_decode(json_encode($datafields_array), true);	

			if($form_structure["header"][0]['fields'][0]['req_currency_id']['Inputvalue_id']=='')
			{								
				$form_structure["header"][0]['fields'][0]['req_currency_id']['Inputvalue_id']=
				$setting['currency_id'];
				$form_structure["header"][0]['fields'][0]['req_currency_id']['Inputvalue']=
				$setting['currency_name'];
			}	


			if($form_structure["header"][0]['fields'][0]['req_preparer']['Inputvalue_id']=='')
			{								
			
				$form_structure["header"][2]['fields'][0]['req_requiester']['Inputvalue_id']=
				$setting['login_emp_id'];
				$form_structure["header"][2]['fields'][0]['req_requiester']['Inputvalue']=
				$setting['login_emp_name'];	
				$form_structure["header"][2]['fields'][0]['req_organization']['Inputvalue_id']=
				$setting['req_organization_id'];							
				
				$form_structure["header"][2]['fields'][0]['req_organization']['Inputvalue']=
				$setting['req_organization_name'];			
				$form_structure["header"][2]['fields'][0]['req_location']['Inputvalue']=
				$setting['req_location'];	
				$form_structure["header"][2]['fields'][0]['req_accounting_date']['Inputvalue']=date('Y-m-d');

												
			}

			$form_structure["header"][0]['fields'][0]['last_updated_by']['Inputvalue_id']=	
			$setting['login_emp_id'];

			$form_structure["header"][0]['fields'][0]['last_updated_date_time']['Inputvalue_id']=
			date('Y-m-d H:i:s');


		}

		if($form_name=='requisition_approve')
		{

			$sql="select  id FieldID,name FieldVal  from tbl_employee_mstr
			where  login_status<>'SUPER' and status='ACTIVE' 
			and account_setup_id=".$setting['account_setup_id']." 
			and id<>".$setting['login_emp_id']." order by name	";
			$datafields_array =$this->projectmodel->get_records_from_sql($sql);
			$form_structure["header"][0]['fields'][0]['forward_to']['datafields']=
			json_decode(json_encode($datafields_array), true);	

			if($form_structure["header"][0]['fields'][0]['req_preparer']['Inputvalue_id']=='')
			{								
			
				$form_structure["header"][0]['fields'][0]['req_requiester']['Inputvalue_id']=
				$setting['login_emp_id'];
				$form_structure["header"][0]['fields'][0]['req_requiester']['Inputvalue']=
				$setting['login_emp_name'];	
				$form_structure["header"][0]['fields'][0]['req_organization']['Inputvalue_id']=
				$setting['req_organization_id'];							
				
				$form_structure["header"][0]['fields'][0]['req_organization']['Inputvalue']=
				$setting['req_organization_name'];			
				$form_structure["header"][0]['fields'][0]['req_location']['Inputvalue']=
				$setting['req_location'];	
				$form_structure["header"][0]['fields'][0]['req_accounting_date']['Inputvalue']=date('Y-m-d');

				$form_structure["header"][0]['fields'][0]['req_preparer']['Inputvalue_id']=
				$setting['login_emp_id'];

				$form_structure["header"][0]['fields'][0]['req_preparer']['Inputvalue']=
				$setting['login_emp_name'];

				$form_structure["header"][0]['fields'][0]['created_by']['Inputvalue_id']=
				$setting['login_emp_id'];

				$form_structure["header"][0]['fields'][0]['create_date_time']['Inputvalue_id']=
				date('Y-m-d H:i:s');
												
			}

			$form_structure["header"][0]['fields'][0]['last_updated_by']['Inputvalue_id']=	
			$setting['login_emp_id'];

			$form_structure["header"][0]['fields'][0]['last_updated_date_time']['Inputvalue_id']=
			date('Y-m-d H:i:s');

		}


		if($form_name=='po_entry')
		{
			
			
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
						
			
			$form_structure["header"][0]['fields'][0]['req_type']['Inputvalue']='Standard Purchase Order';
			$form_structure["header"][0]['fields'][0]['req_type']['Inputvalue_id']=93;
			$form_structure["header"][0]['fields'][0]['req_status']['Inputvalue_id']=91;
			

			if($form_structure["header"][2]['fields'][0]['req_preparer']['Inputvalue_id']=='')
				{				

					$form_structure["header"][2]['fields'][0]['req_preparer']['Inputvalue_id']=
					$setting['login_emp_id'];		

					$form_structure["header"][2]['fields'][0]['req_preparer']['Inputvalue']=
					$setting['login_emp_name'];
					
					$form_structure["header"][2]['fields'][0]['req_organization']['Inputvalue_id']=
					$setting['req_organization_id'];			

					$form_structure["header"][2]['fields'][0]['req_organization']['Inputvalue']=
					$setting['req_organization_name'];	
					
					$form_structure["header"][2]['fields'][0]['req_location']['Inputvalue']=
					$setting['req_location'];	

					$form_structure["header"][2]['fields'][0]['req_accounting_date']['Inputvalue']=
					date('Y-m-d');

					$form_structure["header"][2]['fields'][0]['created_by']['Inputvalue_id']=
					$setting['login_emp_id'];

					$form_structure["header"][2]['fields'][0]['create_date_time']['Inputvalue_id']=	
					date('Y-m-d H:i:s');

				}

				$form_structure["header"][2]['fields'][0]['last_updated_by']['Inputvalue_id']=$setting['login_emp_id'];
				$form_structure["header"][2]['fields'][0]['last_updated_date_time']['Inputvalue_id']=date('Y-m-d H:i:s');
		

				$sql="select  id FieldID,req_number FieldVal  from invoice_summary where  status='REQUISITION' AND req_status=90 ";
				$datafields_array =$this->projectmodel->get_records_from_sql($sql);
				$form_structure["header"][0]['fields'][0]['parent_id']['datafields']=json_decode(json_encode($datafields_array), true);		
				$form_structure["header"][0]['fields'][0]['parent_id']['LabelName']='Enter Requisition';	

		}	


		if($form_name=='requisition_approve')
		{

			$sql="select  id FieldID,name FieldVal  from tbl_employee_mstr
			where  login_status<>'SUPER' and status='ACTIVE' 
			and account_setup_id=".$setting['account_setup_id']." 
			and id<>".$setting['login_emp_id']." order by name	";
			$datafields_array =$this->projectmodel->get_records_from_sql($sql);
			$form_structure["header"][0]['fields'][0]['forward_to']['datafields']=json_decode(json_encode($datafields_array), true);	

			if($form_structure["header"][0]['fields'][0]['req_preparer']['Inputvalue_id']=='')
			{								
			
				$form_structure["header"][0]['fields'][0]['req_requiester']['Inputvalue_id']=
				$setting['login_emp_id'];
				$form_structure["header"][0]['fields'][0]['req_requiester']['Inputvalue']=
				$setting['login_emp_name'];	
				$form_structure["header"][0]['fields'][0]['req_organization']['Inputvalue_id']=
				$setting['req_organization_id'];							
				
				$form_structure["header"][0]['fields'][0]['req_organization']['Inputvalue']=
				$setting['req_organization_name'];			
				$form_structure["header"][0]['fields'][0]['req_location']['Inputvalue']=
				$setting['req_location'];	
				$form_structure["header"][0]['fields'][0]['req_accounting_date']['Inputvalue']=date('Y-m-d');

				$form_structure["header"][0]['fields'][0]['req_preparer']['Inputvalue_id']=
				$setting['login_emp_id'];

				$form_structure["header"][0]['fields'][0]['req_preparer']['Inputvalue']=
				$setting['login_emp_name'];

				$form_structure["header"][0]['fields'][0]['created_by']['Inputvalue_id']=
				$setting['login_emp_id'];

				$form_structure["header"][0]['fields'][0]['create_date_time']['Inputvalue_id']=
				date('Y-m-d H:i:s');
												
			}

			$form_structure["header"][0]['fields'][0]['last_updated_by']['Inputvalue_id']=	
			$setting['login_emp_id'];

			$form_structure["header"][0]['fields'][0]['last_updated_date_time']['Inputvalue_id']=
			date('Y-m-d H:i:s');

		}

		if($form_name=='receipt_of_goods')
		{	

			//FORM WISE SETTING
				//$form_structure["header"][0]['fields'][0]['status']['Inputvalue']='GRN_ENTRY';
				//$form_structure["header"][0]['fields'][0]['status']['Inputvalue_id']=0;
			//	$form_structure["header"][0]['fields'][0]['status']['Inputvalue']='GRN_ENTRY';
				//FORM WISE SETTING


					//FORM CUSTOM SETTING

			$form_structure["header"][0]['fields'][0]['req_type']['Inputvalue']='Receipt Of Goods';
			$form_structure["header"][0]['fields'][0]['req_type']['Inputvalue_id']=94;
			

			$form_structure["header"][0]['fields'][0]['last_updated_by']['Inputvalue_id']=
			$setting['login_emp_id'];
			$form_structure["header"][0]['fields'][0]['last_updated_date_time']['Inputvalue_id']=
			date('Y-m-d H:i:s');

			$cnts=sizeof($form_structure["header"][1]['fields']);
			for($i=0;$i<$cnts;$i++)
			{$form_structure["header"][1]['fields'][$i]['price']['InputType']='hidden';}

			//USER
			if($form_structure["header"][0]['fields'][0]['req_preparer']['Inputvalue_id']=='')
			{				

				$form_structure["header"][0]['fields'][0]['req_preparer']['Inputvalue_id']=
				$setting['login_emp_id'];							
				$form_structure["header"][0]['fields'][0]['req_preparer']['Inputvalue']=
				$setting['login_emp_name'];

		
				$form_structure["header"][0]['fields'][0]['req_organization']['Inputvalue_id']=$setting['req_organization_id'];							
				$form_structure["header"][0]['fields'][0]['req_organization']['Inputvalue']=$setting['req_organization_name'];	
				
				$form_structure["header"][0]['fields'][0]['req_location']['Inputvalue']=$setting['req_location'];	
				$form_structure["header"][0]['fields'][0]['req_accounting_date']['Inputvalue']=date('Y-m-d');

				$form_structure["header"][0]['fields'][0]['created_by']['Inputvalue_id']=	$setting['login_emp_id'];
				$form_structure["header"][0]['fields'][0]['create_date_time']['Inputvalue_id']=	date('Y-m-d H:i:s');

			}

		}	


		if($form_name=='INSPECTION')
		{

			//FORM CUSTOM SETTING

			$form_structure["header"][0]['fields'][0]['req_type']['Inputvalue']='Inspection Of Goods';
			$form_structure["header"][0]['fields'][0]['last_updated_by']['Inputvalue_id']=$setting['login_emp_id'];
			$form_structure["header"][0]['fields'][0]['last_updated_date_time']['Inputvalue_id']=date('Y-m-d H:i:s');


			//USER
			if($form_structure["header"][0]['fields'][0]['req_preparer']['Inputvalue_id']=='')
			{				

				$form_structure["header"][0]['fields'][0]['req_preparer']['Inputvalue_id']=$setting['login_emp_id'];
				$form_structure["header"][0]['fields'][0]['req_preparer']['Inputvalue']=$setting['login_emp_name'];
				
				$form_structure["header"][0]['fields'][0]['req_organization']['Inputvalue_id']=
				$setting['req_organization_id'];							
				
				$form_structure["header"][0]['fields'][0]['req_organization']['Inputvalue']=
				$setting['req_organization_name'];	
				
				$form_structure["header"][0]['fields'][0]['req_location']['Inputvalue']=$setting['req_location'];	
				$form_structure["header"][0]['fields'][0]['req_accounting_date']['Inputvalue']=date('Y-m-d');

				$form_structure["header"][0]['fields'][0]['created_by']['Inputvalue_id']=	$setting['login_emp_id'];
				$form_structure["header"][0]['fields'][0]['create_date_time']['Inputvalue_id']=	date('Y-m-d H:i:s');

			}

		}	


		if($form_name=='purchase_invoice')
		{

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


			$form_structure["header"][0]['fields'][0]['req_number']['LabelName']='Invoice No';
			$form_structure["header"][0]['fields'][0]['req_accounting_date']['LabelName']='Invoice Date';
		 //	$form_structure["header"][0]['fields'][0]['req_total']['LabelName']='Invoice Amount';
			$form_structure["header"][0]['fields'][0]['req_currency_id']['LabelName']='Pay Currency';
			//	$form_structure["header"][0]['fields'][0]['last_updated_by']['Inputvalue_id']=$setting['login_emp_id'];
			//	$form_structure["header"][0]['fields'][0]['last_updated_date_time']['Inputvalue_id']=date('Y-m-d H:i:s');

			//$form_structure["header"][0]['fields'][0]['parent_id']['InputType']='LABEL';

			$indx=3;
			$form_structure["header"][$indx]['fields'][0]['req_type']['Inputvalue']='Receive Invoice';
			$form_structure["header"][$indx]['fields'][0]['req_type']['Inputvalue_id']=95;
			$form_structure["header"][$indx]['fields'][0]['status']['Inputvalue']='PURCHASE_INVOICE';
			$form_structure["header"][$indx]['fields'][0]['parent_id']['InputType']='hidden';
			$form_structure["header"][$indx]['fields'][0]['req_type']['InputType']='hidden';
			$form_structure["header"][$indx]['fields'][0]['status']['InputType']='hidden';

		}

		if($form_name=='SALES_ORDER')
		{

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
					$form_structure["header"][1]['fields'][$i]['qnty']['InputType']='text';
				}
			}


			$form_structure["header"][0]['fields'][0]['req_type']['Inputvalue']='Standard Sales Order';
			$form_structure["header"][0]['fields'][0]['req_type']['Inputvalue_id']=142;
			$form_structure["header"][0]['fields'][0]['req_accounting_date']['Inputvalue']=date('Y-m-d H:i:s');;
			
			
	   
			$form_structure["header"][2]['fields'][0]['last_updated_by']['Inputvalue_id']=$setting['login_emp_id'];
			$form_structure["header"][2]['fields'][0]['last_updated_date_time']['Inputvalue_id']=date('Y-m-d H:i:s');
			$form_structure["header"][2]['fields'][0]['req_status']['Inputvalue']='OPEN';
			$form_structure["header"][2]['fields'][0]['req_status']['Inputvalue_id']=91;

			if($form_structure["header"][2]['fields'][0]['created_by']['Inputvalue_id']==0)
			{				
				$form_structure["header"][2]['fields'][0]['req_preparer']['Inputvalue_id']=$setting['login_emp_id'];							
				$form_structure["header"][2]['fields'][0]['req_preparer']['Inputvalue']=$setting['login_emp_name'];
				$form_structure["header"][2]['fields'][0]['created_by']['Inputvalue_id']=	$setting['login_emp_id'];
				$form_structure["header"][2]['fields'][0]['create_date_time']['Inputvalue_id']=	date('Y-m-d H:i:s');
				$form_structure["header"][0]['fields'][0]['created_date_time']['Inputvalue']=date('Y-m-d H:i:s');
			}


		
		}

		if($form_name=='DESPATCH_GOODS')
		{

			
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
					$form_structure["header"][1]['fields'][$i]['qnty']['InputType']='text';
				}
			}
			
			
			
			$form_structure["header"][0]['fields'][0]['req_type']['Inputvalue']='ORDER DESPATCH';
			$form_structure["header"][0]['fields'][0]['req_type']['Inputvalue_id']=143;

			$form_structure["header"][0]['fields'][0]['last_updated_by']['Inputvalue_id']=$setting['login_emp_id'];
			$form_structure["header"][0]['fields'][0]['last_updated_date_time']['Inputvalue_id']=date('Y-m-d H:i:s');

			//USER
			if($form_structure["header"][0]['fields'][0]['req_preparer']['Inputvalue_id']=='')
			{				

				$form_structure["header"][0]['fields'][0]['req_preparer']['Inputvalue_id']=$setting['login_emp_id'];							
				$form_structure["header"][0]['fields'][0]['req_preparer']['Inputvalue']=$setting['login_emp_name'];									
				$form_structure["header"][0]['fields'][0]['req_organization']['Inputvalue_id']=$setting['req_organization_id'];							
				$form_structure["header"][0]['fields'][0]['req_organization']['Inputvalue']=$setting['req_organization_name'];										
				$form_structure["header"][0]['fields'][0]['req_location']['Inputvalue']=$setting['req_location'];	
				$form_structure["header"][0]['fields'][0]['req_accounting_date']['Inputvalue']=date('Y-m-d');	
				$form_structure["header"][0]['fields'][0]['created_by']['Inputvalue_id']=	$setting['login_emp_id'];
				$form_structure["header"][0]['fields'][0]['create_date_time']['Inputvalue_id']=	date('Y-m-d H:i:s');

			}

		}

		if($form_name=='sale_invoice')
		{

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

						
			$indx=3;
			$form_structure["header"][$indx]['fields'][0]['req_type']['Inputvalue']='Sales Invoice';
			

		}	

		if($form_name=='batch_create_final')
		{
			$batch_status=$form_structure["header"][0]['fields'][0]['batch_status']['Inputvalue_id'];

			
			if($batch_status==160)//canceled
			{$sql="select  id FieldID,FieldVal  from frmrptgeneralmaster where id=160";}
			else if($batch_status==161)//WIP
			{$sql="select  id FieldID,FieldVal  from frmrptgeneralmaster where id in (159,161)";}
			else if($batch_status==162)//Completed
			{$sql="select  id FieldID,FieldVal  from frmrptgeneralmaster where id in (162,161) ";}
			else if($batch_status==163)//CLOSED
			{$sql="select  id FieldID,FieldVal  from frmrptgeneralmaster where id=163";}
			else
			{$sql="select  id FieldID,FieldVal  from frmrptgeneralmaster where Status='BATCH_STATUS'";}


			$datafields_array =$this->projectmodel->get_records_from_sql($sql);
			$form_structure["header"][0]['fields'][0]['batch_status']['datafields']=
			json_decode(json_encode($datafields_array), true);	

		
		}
		
		


		return $form_structure;


	}	

	function save_data($form_structure=array(),$form_name='requisition')
	{
	
		$return_data=$setting=$rs=$resval=$output=array();
		$data_for_validation = json_decode($form_structure, true);								
		//$VALID_STATUS=$this->FrmRptModel->validation_data($data_for_validation);
		$VALID_STATUS='VALID';
		
		if($VALID_STATUS=='VALID')
		{

			$form_data=json_decode($form_structure);
			$headers=json_decode(json_encode($form_data[0]->header), true );
			$header_scount=sizeof($headers);
			$id_header=0;	
			$count=sizeof($form_data[0]->header);		
			$headers=json_decode(json_encode($form_data[0]->header), true );
			$save_details=$this->FrmRptModel->create_save_array($headers);
			$header_id=$id='';
		}

		if($form_name=='requisition' || $form_name=='requisition_approve' || $form_name=='po_entry'
		|| $form_name=='po_approve' || $form_name=='receipt_of_goods' || $form_name=='INSPECTION' 
		|| $form_name=='purchase_invoice' || $form_name=='SALES_ORDER'||$form_name=='SALES_ORDER_APPROVE' 
		|| $form_name=='DESPATCH_GOODS' || $form_name=='sale_invoice')
		{
			
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
							{
								$savedata[$key3]=$value; 
								if($form_name=='requisition' || $form_name=='po_entry' 
								|| $form_name=='SALES_ORDER' || $form_name=='DESPATCH_GOODS')
								{if($savedata['item_id']==0){$save_statue=false;}}

							}

						}

						//HEADER SECTION
						if($table_name=='invoice_summary')
						{
							$this->projectmodel->save_records_model($header_id,$table_name,$savedata);
							if($key1==0 && $header_id=='')
							{$header_id=$this->db->insert_id();$server_msg="Record has been inserted Successfully!";}	
							else if($key1==0 && $header_id>0){$server_msg="Record has been Updated Successfully!";}										
							

						}

						if($save_statue && $table_name=='invoice_details')
						{$this->projectmodel->save_records_model($id,$table_name,$savedata);}

					}	

				}

				
				

				 $this->update_transactions($header_id,$form_name);
			
				if($form_name=='receipt_of_goods' || $form_name=='purchase_invoice' 
				|| $form_name=='DESPATCH_GOODS' || $form_name=='sale_invoice')
				{
					$this->accounts_model->ledger_transactions($header_id,$form_name);
				}

				$return_data['id_header']=$header_id;
				$return_data['server_msg']=$server_msg;

				// if($form_name=='DESPATCH_GOODS')
				// {$this->segment_update($header_id);	}

		}


		header('Access-Control-Allow-Origin: *');
		header("Content-Type: application/json");
		echo json_encode($return_data);

	}


	public function get_available_qnty($product_type=0,$product_id=0,$TRAN_TYPE='')
	{
		$available_qnty=0;
		
		
		//$product_type==154 ==INGREDIENTS
		
		if($TRAN_TYPE=='BATCH_CREATE' && $product_type==154)
		{
			$issue_qnty=$received_qnty=0;
			
			 $records="select sum(received_qnty) received_qnty 
			from  invoice_summary a,invoice_details b  where a.id=b.invoice_summary_id
			 and b.item_id=".$product_id." and a.status='GRN_ENTRY' ";
			$records = $this->get_records_from_sql($records);	
			foreach ($records as $record)
			{$received_qnty=$record->received_qnty;}

			//BATCH WISE ISSUE

			 $records="select sum(transact_qnty) issue_qnty 
			from  opm_batch_summary a,opm_batch_details b  where a.id=b.opm_batch_summary_id  
			and b.product_id=".$product_id." and a.batch_status=163 ";
			$records = $this->get_records_from_sql($records);	
			foreach ($records as $record)
			{$issue_qnty=$record->issue_qnty;}

			$available_qnty=$received_qnty-$issue_qnty;

			return $available_qnty;
		}


		if($TRAN_TYPE=='FINAL_PRODUCT' && $product_type==152)
		{
			$batch_qnty=$received_qnty=0;
			
			$records="select sum(received_qnty) despatch_qnty 
			from  invoice_summary a,invoice_details b  where a.id=b.invoice_summary_id
			 and b.item_id=".$product_id." and a.status='ORDER_DESPATCH' ";
			$records = $this->get_records_from_sql($records);	
			foreach ($records as $record)
			{$sale_qnty=$record->despatch_qnty;}

			//BATCH WISE ISSUE

			$records="select sum(transact_qnty) batch_qnty 
			from  opm_batch_summary a,opm_batch_details b  where a.id=b.opm_batch_summary_id  
			and b.product_id=".$product_id." and a.batch_status=163 ";
			$records = $this->get_records_from_sql($records);	
			foreach ($records as $record)
			{$batch_qnty=$record->batch_qnty;}

			$available_qnty=$batch_qnty-$sale_qnty;
			return $available_qnty;
		}


		

	}


	public function update_transactions($tran_table_id='',$TRAN_TYPE='')
	{
		
		
		if($TRAN_TYPE=='requisition' )
		{	
			
			$sql="delete from invoice_details where invoice_summary_id=".$tran_table_id." and item_id=0";
			$this->db->query($sql);

			$save_header['req_total']=0;

			$records="select * from  invoice_details where invoice_summary_id=".$tran_table_id." ";
			$records = $this->get_records_from_sql($records);	
			foreach ($records as $record)
			{		
				$detail_id=$record->id;
				$save_detail['total_amount']=$record->qnty*$record->price;
				//$save_detail['tax_amount']=$save_detail['total_amount']*$record->tax_rate/100;

				$this->save_records_model($detail_id,'invoice_details',$save_detail);

				//HEADER SECTION
				$save_header['req_total']=$save_header['req_total']+$save_detail['total_amount'];
				//$save_header['tax_amount']=$save_header['tax_amount']+$save_detail['tax_amount'];
				$this->save_records_model($tran_table_id,'invoice_summary',$save_header);
			}
		
		}


		if($TRAN_TYPE=='receipt_of_goods' || $TRAN_TYPE=='INSPECTION')
		{	
			$sql="delete from invoice_details where invoice_summary_id=".$tran_table_id." and item_id=0";
			$this->db->query($sql);


		
			$save_header['invoice_grand_total']=$save_header['tax_amount']=$save_header['invoice_tot_items']=0;

			$records="select * from  invoice_details where invoice_summary_id=".$tran_table_id." ";
			$records = $this->get_records_from_sql($records);	
			foreach ($records as $record)
			{		
				$detail_id=$record->id;

				$save_detail['total_amount']=$record->received_qnty*$record->price;			
				$this->save_records_model($detail_id,'invoice_details',$save_detail);

				//HEADER SECTION
				$save_header['invoice_grand_total']=$save_header['invoice_grand_total']+$save_detail['total_amount'];
			
				$this->save_records_model($tran_table_id,'invoice_summary',$save_header);
			}


		}

		if($TRAN_TYPE=='purchase_invoice' || $TRAN_TYPE=='sale_invoice'  )
		{	
			
			$sql="delete from invoice_details where invoice_summary_id=".$tran_table_id." and item_id=0";
			$this->db->query($sql);

			$save_header['tax_amount']=$save_header['invoice_tot_items']=0;

			$records="select * from  invoice_details where invoice_summary_id=".$tran_table_id." ";
			$records = $this->get_records_from_sql($records);	
			foreach ($records as $record)
			{		
				$detail_id=$record->id;
				$save_detail['total_amount']=$record->qnty*$record->price;
				$save_detail['tax_amount']=$save_detail['total_amount']*$record->tax_rate/100;

				$this->save_records_model($detail_id,'invoice_details',$save_detail);

				//HEADER SECTION
				$save_header['invoice_tot_items']=$save_header['invoice_tot_items']+$save_detail['total_amount'];
				$save_header['tax_amount']=$save_header['tax_amount']+$save_detail['tax_amount'];
				$this->save_records_model($tran_table_id,'invoice_summary',$save_header);
			}

			$records="select * from  invoice_summary where id=".$tran_table_id." ";
			$records = $this->get_records_from_sql($records);	
			foreach ($records as $record)
			{		
				$detail_id=$record->id;
				
				$save_header['invoice_subtotal']=$record->invoice_tot_items-
				$record->invoice_retainage-$record->invoice_prepayment_amount-$record->invoice_withholding;

				$save_header['invoice_due_total']=$save_header['invoice_grand_total']=
				$save_header['invoice_subtotal']+$record->tax_amount+$record->freight_amount+$record->Misc_amount;

				$this->save_records_model($detail_id,'invoice_summary',$save_header);
			}


		
		}

		//SALES ORDER SECTION

		if($TRAN_TYPE=='DESPATCH_GOODS' )
		{	
			$save_header['invoice_tot_items']=0;
			$sql="delete from invoice_details where invoice_summary_id=".$tran_table_id." and item_id=0";
			$this->db->query($sql);

			//$save_header['tax_amount']=$save_header['invoice_tot_items']=0;

			$records="select * from  invoice_details where invoice_summary_id=".$tran_table_id." ";
			$records = $this->get_records_from_sql($records);	
			foreach ($records as $record)
			{		
				$detail_id=$record->id;
				$save_detail['total_amount']=$record->received_qnty*$record->price;
				//$save_detail['tax_amount']=$save_detail['total_amount']*$record->tax_rate/100;

				$this->save_records_model($detail_id,'invoice_details',$save_detail);

				//HEADER SECTION
				$save_header['invoice_tot_items']=$save_header['invoice_tot_items']+$save_detail['total_amount'];
				$save_header['invoice_grand_total']=$save_header['invoice_tot_items'];

				//$save_header['tax_amount']=$save_header['tax_amount']+$save_detail['tax_amount'];
				$this->save_records_model($tran_table_id,'invoice_summary',$save_header);
			}
		}

		if($TRAN_TYPE=='receive_amt' || $TRAN_TYPE=='payment_rcv' )
		{
			$save_header['req_total']=$save_header['cleared_amount']=0;

			$records="select * from  invoice_summary where 	invoice_payment_id=".$tran_table_id." ";
			$records = $this->get_records_from_sql($records);	
			foreach ($records as $record)
			{		
				$detail_id=$record->id;
				
				//payment details
				$payment_detail_id='';
				$rs="select * from  invoice_payment_receive_details where invoice_summary_id=".$detail_id." 
				and invoice_payment_receive_id=".$tran_table_id." ";
				$rs = $this->get_records_from_sql($rs);	
				foreach ($rs as $rs_dtl)
				{$payment_detail_id=$rs_dtl->id;}

				$rcv_payment['invoice_payment_receive_id']=$tran_table_id;
				$rcv_payment['invoice_summary_id']=$detail_id;
				$rcv_payment['amount']=$record->invoice_due_total;
				$this->save_records_model($payment_detail_id,'invoice_payment_receive_details',$rcv_payment);
				//payment details

				//total paid 
				$paid_total=0;
				$rs="select sum(amount) paid_total from  invoice_payment_receive_details 
				where invoice_summary_id=".$detail_id;
				$rs = $this->get_records_from_sql($rs);	
				foreach ($rs as $rs_dtl)
				{$paid_total=$rs_dtl->paid_total;}

				
				$summary['invoice_paid_total']=$paid_total;
				$summary['invoice_due_total']=$record->invoice_grand_total-$paid_total;
				$this->save_records_model($detail_id,'invoice_summary',$summary);

				
				$save_header['req_total']=$save_header['req_total']+$record->invoice_grand_total;
				$save_header['cleared_amount']=$save_header['cleared_amount']+$record->invoice_due_total;

				//invoice_due_total
				//invoice_payment_receive_details
				$this->save_records_model($tran_table_id,'invoice_payment_receive',$save_header);
			}

		}


		if($TRAN_TYPE=='BATCH_CREATE')
		{
			//opm_batch_summary

			$records="select * from  opm_batch_summary where id=".$tran_table_id." ";
			$records = $this->get_records_from_sql($records);	
			foreach ($records as $record)
			{		
				
				$batch_id=$record->id;
				$save_header['batch_status']=159;//PENDING STATUS

				$receipe_id=$record->receipe_id;
				$product_id=$record->product_id;
				$product_qnty=$record->product_qnty;
				$product_uom=$record->product_uom;
				$this->save_records_model($batch_id,'opm_batch_summary',$save_header);

				//get formula
				$formula_id=$this->projectmodel->GetSingleVal('formula_id','opm_define_recipe_summery','id='.$receipe_id); 
				$routing_id=$this->projectmodel->GetSingleVal('routing_id','opm_define_recipe_summery','id='.$receipe_id); 
				$line_no=1;
				$formula_details="select * from  opm_define_formula_details where opm_define_formula_summery_id=".$formula_id." ";
				$formula_details = $this->get_records_from_sql($formula_details);	
				foreach ($formula_details as $formula_detail)
				{
										
					$batch_details['opm_batch_summary_id']=$batch_id;
					$batch_details['line_no']=$line_no;
					$batch_details['product_id']=$formula_detail->product;
					$batch_details['transact_qnty']=$batch_details['target_qnty']=$formula_detail->qnty*$product_qnty;
					$batch_details['product_type']=$formula_detail->product_type;
					$batch_details['uom']=$formula_detail->uom;

					if($formula_detail->product_type==154)//INGREDIENTS
					{
						$batch_details['available_qnty']=
						$this->get_available_qnty($formula_detail->product_type,$formula_detail->product,$TRAN_TYPE);
					}
					
					$batch_details['batch_enable_status']=
					$this->GetSingleVal('batch_enable_status','mstr_product','id='.$formula_detail->product); 
					
					

					$opm_batch_details_id='';
					$formula_details="select * from  opm_batch_details 
					where product_id=".$formula_detail->product." and opm_batch_summary_id=".$batch_id;
					$formula_details = $this->get_records_from_sql($formula_details);	
					foreach ($formula_details as $formula_detail)
					{$opm_batch_details_id=$formula_detail->id;}	
					
					$this->save_records_model($opm_batch_details_id,'opm_batch_details',$batch_details);
					
					$line_no=$line_no+1;
				}	

				
			}


		}

	}
	
	public function priviledge_value($menu_details_id='')
	{
		$tbl_employee_mstr_id=$this->session->userdata('login_emp_id');
		$OPERATION='';
		$whr=" tbl_employee_mstr_id=".$tbl_employee_mstr_id." and menu_details_id=".$menu_details_id;
		$OPERATION=$this->GetSingleVal('OPERATION','menu_user_priviledge',$whr);
		return $OPERATION;
	}


	function find_by_id($id)
	{
			//return $this->db->where->('id',$id)->limit(1)->get('p_product')->row();
			
			$sql = "SELECT * FROM p_product WHERE id=$id";
			$query = $this->db->query($sql);
			return $query->result();
			
	}
	public function get_all_record($table_name,$where_array)
	{
		
			$res=$this->db->get_where($table_name,$where_array);
			//$res1=$res->result_array();
			return $res->result();
			//return $res1;
			
			/*$sql = "SELECT * FROM ".$table_name." WHERE id=".$id;
			$query = $this->db->query($sql);
			return $query->result();*/
			
	}	

	public function get_records_from_sql($sql)
	{
			//$sql = "SELECT * FROM ".$table_name." WHERE id=".$id;
			$query = $this->db->query($sql);
			return $query->result();
	}
		
	public function get_single_record($table_name,$id)
	{
			/*$res=$this->db->get_where($table_name,array('id'=>$id));
			$res1=$res->result_array();
			return $res1;*/
			
			$sql = "SELECT * FROM ".$table_name." WHERE id=".$id;
			$query = $this->db->query($sql);
			return $query->result();
			
	}

	
	public function save_records_model($id,$table_name,$tabale_data)
	{
			if($id>0)
			{
				$this->db->update($table_name, $tabale_data, array('id' => $id));
			}
			else
			{
				$this->db->insert($table_name,$tabale_data);
			}	
	}
		
	public function delete_record($id=0,$table_name)
	{
		//$this->db->delete('user',array('id'=>$id));
		$this->db->delete($table_name,array('id'=>$id));
	}
		
	public function Activequery($ActiveRecords,$QueryType='')
	{
		if($QueryType=='LIST')
		{		
			if($ActiveRecords['DataFields']<>''){
			$this->db->select($ActiveRecords['DataFields']);}
			
			if($ActiveRecords['TableName']<>''){
			$this->db->from($ActiveRecords['TableName']);	}
			
			if($ActiveRecords['WhereCondition']<>''){
			$this->db->where($ActiveRecords['WhereCondition']);}	
			
			if($ActiveRecords['OrderBy']<>''){
			$this->db->order_by($ActiveRecords['OrderBy']);}
			
			$query = $this->db->get(); 
			$query =json_encode($query->result());
			$query =json_decode($query);
			
			return $query;
			
			
		}
		
		if($QueryType=='SingleVal')
		{		
			if($ActiveRecords['DataFields']<>''){
			$this->db->select($ActiveRecords['DataFields']);}
			
			if($ActiveRecords['TableName']<>''){
			$this->db->from($ActiveRecords['TableName']);	}
			
			if($ActiveRecords['WhereCondition']<>''){
			$this->db->where($ActiveRecords['WhereCondition']);}	
			
			if($ActiveRecords['OrderBy']<>''){
			$this->db->order_by($ActiveRecords['OrderBy']);}
			
			$query = $this->db->get(); 
			$query =json_encode($query->result());
			$query =json_decode($query);
			$rtnval='';
			foreach($query as $key=>$bd){
			foreach($bd as $key1=>$bdr){	
			$rtnval=$bdr;
			}}	
			return $rtnval;
			
			
		}
		
		if($QueryType=='SUM')
		{	
			$this->db->select_sum($ActiveRecords['DataFields']);
			$this->db->from($ActiveRecords['TableName']);	
			$this->db->where($ActiveRecords['WhereCondition']);	
			$query = $this->db->get();
			return $query->result();
				
		}
		
		
	}	

	public function create_field($InputType,$LogoType,$LabelName,$InputName,$Inputvalue,$RecordSet,$colsize)
	{
			
		$inputval='';
		$empid=$this->session->userdata('login_emp_id');
			// if($this->session->userdata('HIERARCHY_STATUS')=='NORMAL_USER')
			// {$empid=$this->session->userdata('login_emp_id');}
			
			// if($this->session->userdata('HIERARCHY_STATUS')=='SUPERUSER')
			// {$empid=$this->session->userdata('billing_emp_id');}
			
			$Whr=' employee_id='.$empid;
			$parentid=$this->GetSingleVal('id','tbl_hierarchy_org',$Whr);
		
		if($InputType=='FieldHQSingleSelect') 
		{	
			$options='';		
			$fieldlist=$this->gethierarchy_list($parentid,'FIELD');
			
			$sql="select * from tbl_hierarchy_org where tbl_designation_id='6' 	and id in (".$fieldlist.") 
			order by  under_tbl_hierarchy_org,hierarchy_name ";
			$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
			foreach ($rowrecord as $row)
			{ 	
				$hq='';
				$sql_parent="select * from tbl_hierarchy_org 
				where id=".$row->under_tbl_hierarchy_org;
				$rowrecord_parents = 
				$this->projectmodel->get_records_from_sql($sql_parent);	
				foreach ($rowrecord_parents as $rowrecord_parent)
				{ $hq=$rowrecord_parent->hierarchy_name; }
			
				$id=$fieldval=$slcted='';
				if($row->id==$Inputvalue) 
				{$slcted='selected="selected"'; }
				$options=$options.'<option value="'.$row->id.'"'.$slcted.' >'
				.$row->hierarchy_name.'('.$hq.')'.'</option>';
			
			}
			
			$frmcontrol='form-control select2';
			//$frmcontrol='select2';
			$multiple='multiple';
			$placeholder='Select';
			$styletype='width: 100%;';
								
			$inputval='<label>'.$LabelName.'</label>
						<select class="'.$frmcontrol.'" name="'.$InputName.'">
						'.$options.'</select>';					 
		}
		
		
		if($InputType=='FieldHQMultiSelect') 
		{	
			$options='';
			$retail_field = explode(",",$Inputvalue);

			$fieldlist=$this->gethierarchy_list($parentid,'FIELD');
			
			$sql="select * from tbl_hierarchy_org where tbl_designation_id='6' and id in (".$fieldlist.") 
			order by  under_tbl_hierarchy_org desc,hierarchy_name ";
			$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
			foreach ($rowrecord as $row)
			{ 				
				$id=$fieldval=$slcted='';
				if (in_array($row->id, $retail_field)) 
				{ $slcted='selected="selected"'; }
				
				$sql_parent="select * from tbl_hierarchy_org 
				where id=".$row->under_tbl_hierarchy_org;
				$rowrecord_parents = 
				$this->projectmodel->get_records_from_sql($sql_parent);	
				foreach ($rowrecord_parents as $rowrecord_parent)
				{
				$options=$options.'<option value="'.$row->id.'"'.$slcted.' >'
				.$row->hierarchy_name.'('.$rowrecord_parent->hierarchy_name.')'.'</option>';
				}
			
			}
			
			$frmcontrol='form-control select2';
			$multiple='multiple';
			$placeholder='---Select---';
			$styletype='width: 100%;';
			$inputval='<label>'.$LabelName.'</label>
						<select class="'.$frmcontrol.'" name="retail_field[]"
						multiple="'.$multiple.'" data-placeholder="'.$placeholder.'" 
						style="'.$styletype.'">'.$options.'</select>';
						
		}
			
		if($InputType=='SingleSelect') 
		{	
			$colsize=$colsize*70;	
			$colsize='width:'.$colsize.'px;';
		
			$options='<option value="0">Select '.$LabelName.'</option>';
			foreach ($RecordSet as $row){
			$id=$fieldval=$slcted='';
			if($row->FieldID==$Inputvalue) 
			{$slcted='selected="selected"'; }
			$options=$options.
			'<option value="'.$row->FieldID.'"'.$slcted.' >'.$row->FieldVal.'</option>';
			}
			
			$frmcontrol='form-control select2 input_field_hight';		
			$multiple='multiple';
			$placeholder='Select';
			$styletype='width: 100%;';								
			$inputval='<select class="'.$frmcontrol.'" style="'.$colsize.'" name="'.$InputName.'" >'.$options.'</select>';		
						
		}

		if($InputType=='text')
		{
			 $colsize=$colsize*70;	
			 $colsize='width:'.$colsize.'px;';
			
			$inputval='<input type="text" id="'.$InputName.'" class="form-control input_field_hight" 
			 style="'.$colsize.'"	value="'.$Inputvalue.'" name="'.$InputName.'" />';
		}		

		if($InputType=='datefield')
		{
			$colsize=$colsize*70;	
			$colsize='width:'.$colsize.'px;';
			
					$inputval='<input type="text" id="'.$InputName.'" class="form-control input_field_hight"
					value="'.$Inputvalue.'" name="'.$InputName.'"  style="'.$colsize.'" />';
		}			
		
		if($InputType=='text_area')
		{
			$colsize=$colsize*70;	
			$colsize='width:'.$colsize.'px;';

			$inputval='<textarea id="'.$InputName.'" class="form-control input_field_hight"  style="'.$colsize.'"  name="'.$InputName.'" />'.$Inputvalue.'</textarea>	';
		
		}	

		
		if($InputType=='MultiSelect')
		{	
			$options='';
			$retail_field = explode(",",$Inputvalue);
			
			$sql="select * from tbl_hierarchy_org where tbl_designation_id='6'
			order by  under_tbl_hierarchy_org desc,hierarchy_name ";
			$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
			foreach ($rowrecord as $row)
			{ 				
				$id=$fieldval=$slcted='';
				if (in_array($row->id, $retail_field)) 
				{ $slcted='selected="selected"'; }
				
				$sql_parent="select * from tbl_hierarchy_org 
				where id=".$row->under_tbl_hierarchy_org;
				$rowrecord_parents = 
				$this->projectmodel->get_records_from_sql($sql_parent);	
				foreach ($rowrecord_parents as $rowrecord_parent)
				{
				$options=$options.'<option value="'.$row->id.'"'.$slcted.' >'
				.$row->hierarchy_name.'('.$rowrecord_parent->hierarchy_name.')'.'</option>';
				}
			
			}
			
			$frmcontrol='form-control select2 input_field_hight';
			$multiple='multiple';
			$placeholder='---Select---';
			$styletype='width: 100%;';
			$inputval='<select class="'.$frmcontrol.'" name="retail_field[]"
						multiple="'.$multiple.'" data-placeholder="'.$placeholder.'" 
						style="'.$styletype.'">'.$options.'</select>';
						
					
		}
		
	
		
		
		if($InputType=='password')
		{				  
			
			$colsize=$colsize*70;	
			$colsize='width:'.$colsize.'px;';
			$inputval='<input type="password" id="'.$InputName.'" class="form-control input_field_hight"
					value="'.$Inputvalue.'" name="'.$InputName.'" style="'.$colsize.'"/>';	 
					
		}			
		
		//$inputval='';
		if($InputType=='hidden')
		{
				$inputval='<input type="hidden" id="'.$InputName.'" class="form-control"
					value="'.$Inputvalue.'" name="'.$InputName.'" />';
		}			
		
		
	
		//echo $InputType;
		if($InputType=='FILE_UPLOAD')
		{
			
				$inputval='<input type="file" id="'.$InputName.'"   value="'.$Inputvalue.'" name="'.$InputName.'" />';
		}		

		

		if($InputType=='LABEL')
		{
				$inputval='<label>'.$LabelName.'</label><br>
				<label>'.$Inputvalue.'</label>
				<input type="hidden" id="'.$InputName.'" class="form-control"
				value="'.$Inputvalue.'" name="'.$InputName.'" />';
		}				   	
		
			
		if($InputType=='DEBIT_LEDGER' or $InputType=='CREDIT_LEDGER' 
		or $InputType=='DEBIT_GROUP' or $InputType=='CREDIT_GROUP') 
		{	
			
			$options='';
			$retail_field = explode(",",$Inputvalue);
			if($InputType=='DEBIT_LEDGER' or $InputType=='CREDIT_LEDGER' )
			{
			$sql="select * from acc_group_ledgers where  acc_type='LEDGER'
			order by  acc_name ";
			}
			if( $InputType=='DEBIT_GROUP' or $InputType=='CREDIT_GROUP' )
			{
			$sql="select * from acc_group_ledgers where  acc_type='GROUP'
			order by  acc_name ";
			}
			
			$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
			foreach ($rowrecord as $row)
			{ 				
				$id=$fieldval=$slcted='';
				if (in_array($row->id, $retail_field)) 
				{ $slcted='selected="selected"'; }
				
				$options=$options.'<option value="'.$row->id.'"'.$slcted.' >'
				.$row->acc_name.'</option>';
			
			}
			
			$frmcontrol='form-control select2';
			$multiple='multiple';
			$placeholder='---Select---';
			$styletype='width: 100%;';
			if($InputType=='DEBIT_LEDGER')
			{
			$inputval='<label>'.$LabelName.'</label>
						<select class="'.$frmcontrol.'" name="DEBIT_LEDGER[]"
						multiple="'.$multiple.'" data-placeholder="'.$placeholder.'" 
						>'.$options.'</select>';
			}
			if($InputType=='CREDIT_LEDGER' )
			{		 
			$inputval='<label>'.$LabelName.'</label>
						<select class="'.$frmcontrol.'" name="CREDIT_LEDGER[]"
						multiple="'.$multiple.'" data-placeholder="'.$placeholder.'" 
						>'.$options.'</select>';
			}
			
			if($InputType=='DEBIT_GROUP')
			{
			$inputval='<label>'.$LabelName.'</label>
						<select class="'.$frmcontrol.'" name="DEBIT_GROUP[]"
						multiple="'.$multiple.'" data-placeholder="'.$placeholder.'" 
						>'.$options.'</select>';
			}
			if($InputType=='CREDIT_GROUP' )
			{		 
			$inputval='<label>'.$LabelName.'</label>
						<select class="'.$frmcontrol.'" name="CREDIT_GROUP[]"
						multiple="'.$multiple.'" data-placeholder="'.$placeholder.'" 
						>'.$options.'</select>';
			}
			
										
		}
			
		
		return $inputval;
		
	}
	
	
	
	public function create_field_old($InputType,$LogoType,$LabelName,$InputName,
	$Inputvalue,$RecordSet)
	{
			
		$inputval='';

			if($this->session->userdata('HIERARCHY_STATUS')=='NORMAL_USER')
			{$empid=$this->session->userdata('login_emp_id');}
			
			if($this->session->userdata('HIERARCHY_STATUS')=='SUPERUSER')
			{$empid=$this->session->userdata('billing_emp_id');}
			
			$Whr=' employee_id='.$empid;
			$parentid=$this->GetSingleVal('id','tbl_hierarchy_org',$Whr);
		
		if($InputType=='FieldHQSingleSelect') 
		{	
			$options='';		
			$fieldlist=$this->gethierarchy_list($parentid,'FIELD');
			
			$sql="select * from tbl_hierarchy_org where tbl_designation_id='6' 	and id in (".$fieldlist.") 
			order by  under_tbl_hierarchy_org,hierarchy_name ";
			$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
			foreach ($rowrecord as $row)
			{ 	
				$hq='';
				$sql_parent="select * from tbl_hierarchy_org 
				where id=".$row->under_tbl_hierarchy_org;
				$rowrecord_parents = 
				$this->projectmodel->get_records_from_sql($sql_parent);	
				foreach ($rowrecord_parents as $rowrecord_parent)
				{ $hq=$rowrecord_parent->hierarchy_name; }
			
				$id=$fieldval=$slcted='';
				if($row->id==$Inputvalue) 
				{$slcted='selected="selected"'; }
				$options=$options.'<option value="'.$row->id.'"'.$slcted.' >'
				.$row->hierarchy_name.'('.$hq.')'.'</option>';
			
			}
			
			$frmcontrol='form-control select2';
			//$frmcontrol='select2';
			$multiple='multiple';
			$placeholder='Select';
			$styletype='width: 100%;';
								
			$inputval='<label>'.$LabelName.'</label>
						<select class="'.$frmcontrol.'" name="'.$InputName.'">
						'.$options.'</select>';					 
		}
		
		
		if($InputType=='FieldHQMultiSelect') 
		{	
			$options='';
			$retail_field = explode(",",$Inputvalue);

			$fieldlist=$this->gethierarchy_list($parentid,'FIELD');
			
			$sql="select * from tbl_hierarchy_org where tbl_designation_id='6' and id in (".$fieldlist.") 
			order by  under_tbl_hierarchy_org desc,hierarchy_name ";
			$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
			foreach ($rowrecord as $row)
			{ 				
				$id=$fieldval=$slcted='';
				if (in_array($row->id, $retail_field)) 
				{ $slcted='selected="selected"'; }
				
				$sql_parent="select * from tbl_hierarchy_org 
				where id=".$row->under_tbl_hierarchy_org;
				$rowrecord_parents = 
				$this->projectmodel->get_records_from_sql($sql_parent);	
				foreach ($rowrecord_parents as $rowrecord_parent)
				{
				$options=$options.'<option value="'.$row->id.'"'.$slcted.' >'
				.$row->hierarchy_name.'('.$rowrecord_parent->hierarchy_name.')'.'</option>';
				}
			
			}
			
			$frmcontrol='form-control select2';
			$multiple='multiple';
			$placeholder='---Select---';
			$styletype='width: 100%;';
			$inputval='<label>'.$LabelName.'</label>
						<select class="'.$frmcontrol.'" name="retail_field[]"
						multiple="'.$multiple.'" data-placeholder="'.$placeholder.'" 
						style="'.$styletype.'">'.$options.'</select>';
						
		}
			
		if($InputType=='SingleSelect') 
		{	
			$options='<option value="0">Select None</option>';
			foreach ($RecordSet as $row){
			$id=$fieldval=$slcted='';
			if($row->FieldID==$Inputvalue) 
			{$slcted='selected="selected"'; }
			$options=$options.
			'<option value="'.$row->FieldID.'"'.$slcted.' >'.$row->FieldVal.'</option>';
			}
			
			$frmcontrol='form-control select2';		
			$multiple='multiple';
			$placeholder='Select';
			$styletype='width: 100%;';
								
			$inputval='<label>'.$LabelName.'</label>
						<select class="'.$frmcontrol.'" name="'.$InputName.'">
						'.$options.'</select>';
			
						
		}
		
		if($InputType=='MultiSelect')
		{	
			$options='';
			$retail_field = explode(",",$Inputvalue);
			
			$sql="select * from tbl_hierarchy_org where tbl_designation_id='6'
			order by  under_tbl_hierarchy_org desc,hierarchy_name ";
			$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
			foreach ($rowrecord as $row)
			{ 				
				$id=$fieldval=$slcted='';
				if (in_array($row->id, $retail_field)) 
				{ $slcted='selected="selected"'; }
				
				$sql_parent="select * from tbl_hierarchy_org 
				where id=".$row->under_tbl_hierarchy_org;
				$rowrecord_parents = 
				$this->projectmodel->get_records_from_sql($sql_parent);	
				foreach ($rowrecord_parents as $rowrecord_parent)
				{
				$options=$options.'<option value="'.$row->id.'"'.$slcted.' >'
				.$row->hierarchy_name.'('.$rowrecord_parent->hierarchy_name.')'.'</option>';
				}
			
			}
			
			$frmcontrol='form-control select2';
			$multiple='multiple';
			$placeholder='---Select---';
			$styletype='width: 100%;';
			$inputval='<label>'.$LabelName.'</label>
						<select class="'.$frmcontrol.'" name="retail_field[]"
						multiple="'.$multiple.'" data-placeholder="'.$placeholder.'" 
						style="'.$styletype.'">'.$options.'</select>';
						
					
		}
		
		
		if($InputType=='DEBIT_LEDGER' or $InputType=='CREDIT_LEDGER' 
		or $InputType=='DEBIT_GROUP' or $InputType=='CREDIT_GROUP') 
		{	
			
			$options='';
			$retail_field = explode(",",$Inputvalue);
			if($InputType=='DEBIT_LEDGER' or $InputType=='CREDIT_LEDGER' )
			{
			$sql="select * from acc_group_ledgers where  acc_type='LEDGER'
			order by  acc_name ";
			}
			if( $InputType=='DEBIT_GROUP' or $InputType=='CREDIT_GROUP' )
			{
			$sql="select * from acc_group_ledgers where  acc_type='GROUP'
			order by  acc_name ";
			}
			
			$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
			foreach ($rowrecord as $row)
			{ 				
				$id=$fieldval=$slcted='';
				if (in_array($row->id, $retail_field)) 
				{ $slcted='selected="selected"'; }
				
				$options=$options.'<option value="'.$row->id.'"'.$slcted.' >'
				.$row->acc_name.'</option>';
			
			}
			
			$frmcontrol='form-control select2';
			$multiple='multiple';
			$placeholder='---Select---';
			$styletype='width: 100%;';
			if($InputType=='DEBIT_LEDGER')
			{
			$inputval='<label>'.$LabelName.'</label>
						<select class="'.$frmcontrol.'" name="DEBIT_LEDGER[]"
						multiple="'.$multiple.'" data-placeholder="'.$placeholder.'" 
						>'.$options.'</select>';
			}
			if($InputType=='CREDIT_LEDGER' )
			{		 
			$inputval='<label>'.$LabelName.'</label>
						<select class="'.$frmcontrol.'" name="CREDIT_LEDGER[]"
						multiple="'.$multiple.'" data-placeholder="'.$placeholder.'" 
						>'.$options.'</select>';
			}
			
			if($InputType=='DEBIT_GROUP')
			{
			$inputval='<label>'.$LabelName.'</label>
						<select class="'.$frmcontrol.'" name="DEBIT_GROUP[]"
						multiple="'.$multiple.'" data-placeholder="'.$placeholder.'" 
						>'.$options.'</select>';
			}
			if($InputType=='CREDIT_GROUP' )
			{		 
			$inputval='<label>'.$LabelName.'</label>
						<select class="'.$frmcontrol.'" name="CREDIT_GROUP[]"
						multiple="'.$multiple.'" data-placeholder="'.$placeholder.'" 
						>'.$options.'</select>';
			}
			
										
		}
		
		
		if($InputType=='password')
		{				  
				$inputval='<label>'.$LabelName.'</label>
							<input type="password" id="'.$InputName.'" class="form-control"
					value="'.$Inputvalue.'" name="'.$InputName.'" />';	 
					
		}		
		
		//$inputval='';
		if($InputType=='hidden')
		{
				$inputval='<input type="hidden" id="'.$InputName.'" class="form-control"
					value="'.$Inputvalue.'" name="'.$InputName.'" />';
		}			
		
		if($InputType=='text')
		{
				$inputval='<label>'.$LabelName.'</label>
				<input type="text" id="'.$InputName.'" class="form-control"
				value="'.$Inputvalue.'" name="'.$InputName.'" />';
		}				   
			
		
		return $inputval;
		
	}



	public function GetMultipleVal($DataFields='',$TableName='',$WhereCondition='',$OrderBy='')
		{
				$this->db->select($DataFields);		
				$this->db->from($TableName);		
				$this->db->where($WhereCondition);
				if($OrderBy<>''){$this->db->order_by($OrderBy);}
				
				$query = $this->db->get(); 
				$query =json_encode($query->result());
				$query =json_decode($query, true);
				//json_decode($jsonData, true);
				return $query;
			
		}
		
		public function send_json_output($rs)
		{
				header('Access-Control-Allow-Origin: *');
				header("Content-Type: application/json");
				echo json_encode($rs);
			
		}	
		
		public function GetSingleVal($DataFields='',$TableName='',$WhereCondition='')
		{
			$rtnval=0;
				
			if($DataFields<>'' and $TableName<>'' and $WhereCondition<>'' )
			{
				$this->db->select($DataFields);
				$this->db->from($TableName);
				$this->db->where($WhereCondition);
				
				$query = $this->db->get(); 
				$query =json_encode($query->result());
				$query =json_decode($query);
				$rtnval='';
				foreach($query as $key=>$bd){
				foreach($bd as $key1=>$bdr){	
				$rtnval=$bdr;
				}}	
			
			}
			return $rtnval;
		}
	
	
}
?>