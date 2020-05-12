<?php
class Company_structure_model extends CI_Model {


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
    }

function create_finnancial_year_setting($prefix='ULI',$finyear='')
{	
	$sql2="select count(*) cnt from auto_invoice_mstr where finyr='".$finyear."' ";
	$rowrecord2 = $this->projectmodel->get_records_from_sql($sql2);	
	foreach ($rowrecord2 as $row2)
	{ 
		if($row2->cnt==0)
		{	
			$save_data['finyr']=$finyear; 
			$save_data['srl']=1; 
			$save_data['state']='West_Bengal'; 
			
			$save_data['statecode']=$prefix; 
			$save_data['TRANTYPE']='SELL'; 
			$this->projectmodel->save_records_model('','auto_invoice_mstr',$save_data);
			
			$save_data['statecode']=$prefix.'/CN'; 
			$save_data['TRANTYPE']='SELL_RTN'; 
			$this->projectmodel->save_records_model('','auto_invoice_mstr',$save_data);
			
			$save_data['statecode']=$prefix.'/SR'; 
			$save_data['TRANTYPE']='SAMPLE_RCV'; 
			$this->projectmodel->save_records_model('','auto_invoice_mstr',$save_data);
			
			$save_data['statecode']=$prefix.'/SI'; 
			$save_data['TRANTYPE']='SAMPLE_RCV'; 
			$this->projectmodel->save_records_model('','auto_invoice_mstr',$save_data);
			
			$save_data['statecode']=$prefix.'/TR'; 
			$save_data['TRANTYPE']='TOUR_EXP'; 
			$this->projectmodel->save_records_model('','auto_invoice_mstr',$save_data);
			
		}
		
	}
			
}

function update_teritory()
{

		$recordsHDR="select * from tbl_hierarchy_org ";
		$recordsHDR = $this->projectmodel->get_records_from_sql($recordsHDR);	
		foreach ($recordsHDR as $recordHDR)
		{
			$id=$recordHDR->id;
			$teritory='';
			$recordsDTL="select * from tbl_hierarchy_org 
			where under_tbl_hierarchy_org=".$id;
			$recordsDTL = $this->projectmodel->get_records_from_sql($recordsDTL);	
			foreach ($recordsDTL as $recordDTL)
			{$teritory=$recordDTL->id.','.$teritory;}
			$save_updte['teritory_list']=rtrim($teritory,',');
						
			$this->projectmodel->save_records_model($id,'tbl_hierarchy_org',$save_updte);
		}	

}

function UPDATE_MASTER($TRANTYPE)
{
		
		//delete from tbl_chart_of_accounts where id>19
	
		//parent section	
		$records="select * from data_import where segment='$TRANTYPE' and acc_type=157 order by id";
		$records = $this->projectmodel->get_records_from_sql($records);	
		foreach ($records as $record)
		{			
			
			$save_updte['code']=$record->code;
			$save_updte['title']=$record->description;
			$save_updte['acc_type']=$record->acc_type;
			$save_updte['field_qualifier']=$record->field_qualifier;
			$save_updte['parent_id']=$record->segment_id;			
			

			$save_updte['status']='ACTIVE';
			$save_updte['trantype']='CHART_OF_ACCOUNT_VALUESET';

			$whr="code='".$record->mstr_parent_val."'";
			$save_updte['parent_data_id']=$this->projectmodel->GetSingleVal('id','tbl_chart_of_accounts',$whr); 
			
			
			$id='';			
			$this->projectmodel->save_records_model($id,'tbl_chart_of_accounts',$save_updte);
		}	

		//child section
		$records="select * from data_import where segment='$TRANTYPE' and acc_type=0 ";
		$records = $this->projectmodel->get_records_from_sql($records);	
		foreach ($records as $record)
		{			
			
			$save_updte['code']=$record->code;
			$save_updte['title']=$record->description;
			$save_updte['acc_type']=158;
			$save_updte['field_qualifier']=$record->field_qualifier;
			$save_updte['parent_id']=$record->segment_id;			
			
			$whr="code='".$record->mstr_parent_val."'";
			$save_updte['parent_data_id']=$this->projectmodel->GetSingleVal('id','tbl_chart_of_accounts',$whr); 

			$save_updte['status']='ACTIVE';
			$save_updte['trantype']='CHART_OF_ACCOUNT_VALUESET';
			
			$id='';			
			$this->projectmodel->save_records_model($id,'tbl_chart_of_accounts',$save_updte);
		}	

}


function update_HQID_FIELDID($TRANTYPE)
{
	if($TRANTYPE=='DOCTOR')
	{		
		$recordsHDR="select * from import_doctor_master ";
		$recordsHDR = $this->projectmodel->get_records_from_sql($recordsHDR);	
		foreach ($recordsHDR as $recordHDR)
		{
			$id=$recordHDR->id;
			$hqid=$this->get_HQ_ID($recordHDR->HQ);
			$field_id=$this->create_or_get_field($hqid,$recordHDR->FIELD);		
			$save_updte['hq_id']=$hqid;
			$save_updte['field_id']=$field_id;
			$this->projectmodel->save_records_model($id,'import_doctor_master',$save_updte);
		}	
	}
	
	if($TRANTYPE=='RETAILER')
	{		
		$recordsHDR="select * from import_retailer_master ";
		$recordsHDR = $this->projectmodel->get_records_from_sql($recordsHDR);	
		foreach ($recordsHDR as $recordHDR)
		{
			$id=$recordHDR->id;
			$hqid=$this->get_HQ_ID($recordHDR->HQ);
			$field_id=$this->create_or_get_field($hqid,$recordHDR->FIELD);		
			$save_updte['hq_id']=$hqid;
			$save_updte['field_id']=$field_id;
			$this->projectmodel->save_records_model($id,'import_retailer_master',
			$save_updte);
		}	
	}
	
	if($TRANTYPE=='STOCKIST')
	{		
		$recordsHDR="select * from import_stockist_master ";
		$recordsHDR = $this->projectmodel->get_records_from_sql($recordsHDR);	
		foreach ($recordsHDR as $recordHDR)
		{
			$id=$recordHDR->id;
			$hqid=$this->get_HQ_ID($recordHDR->HQ);
			$field_id=$this->create_or_get_field($hqid,$recordHDR->FIELD);		
			$save_updte['hq_id']=$hqid;
			$save_updte['field_id']=$field_id;
			$this->projectmodel->save_records_model($id,'import_stockist_master',
			$save_updte);
		}	
	}
	
	
	

}


function get_HQ_ID($HQ_name)
{
	$HQ_id=0;
	$sql="SELECT * FROM `tbl_hierarchy_org` 
	WHERE `tbl_designation_id`=5 and 
	UPPER(hierarchy_name)='".trim(strtoupper($HQ_name))."'"; 
	$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
	foreach ($rowrecord as $row1)
	{$HQ_id=$row1->id; }
	return $HQ_id;
	
}

function create_or_get_field($hqid,$field_name)
{
	$field_id='';
	$save_field['tbl_designation_id']=6;
	$save_field['hierarchy_name']=trim(strtoupper($field_name));
	$save_field['under_tbl_hierarchy_org']=0;
	$save_field['city_id']=0; 
	
	//hq_id
	$sql="SELECT * FROM `tbl_hierarchy_org` 
	WHERE `tbl_designation_id`=6 and 
	under_tbl_hierarchy_org='".$hqid."' and
	UPPER(hierarchy_name)='".trim(strtoupper($field_name))."'
	 "; 
	$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
	foreach ($rowrecord as $row1)
	{$field_id=$row1->id; }
	
	$sql="SELECT * FROM `tbl_hierarchy_org` 
	WHERE `tbl_designation_id`=5 and id='".$hqid."'"; 	
	$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
	foreach ($rowrecord as $row1)
	{
	$save_field['under_tbl_hierarchy_org']=$row1->id;
	$save_field['city_id']=$row1->city_id; 
	}	
	
	if($field_id=='' && $hqid>0)
	{				
	$this->projectmodel->save_records_model('','tbl_hierarchy_org',$save_field);
	$field_id=$this->db->insert_id();	
	}
	
	$query ="delete from tbl_hierarchy_org where 
	tbl_designation_id=6  and	under_tbl_hierarchy_org=0"; 
	$this->db->query($query);
	
	
	return $field_id;
	

}

function delete_invalid_location($hqid='')
{		
		if($hqid<>'')
		{
		$sql="SELECT * FROM `tbl_hierarchy_org` 
		WHERE `tbl_designation_id`=6 and 
		under_tbl_hierarchy_org=".$hqid." "; //FOR HQ LIST
		}
		else
		{
		$sql="SELECT * FROM `tbl_hierarchy_org` 
		WHERE `tbl_designation_id`=6 "; //FOR HQ LIST
		}		
		
		$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
		foreach ($rowrecord as $row1)
		{
		$field_id=$row1->id;
		
		$stockist_cnt=0;
		$sql_chk="SELECT count(*) cnt FROM stockist_hq_map where
		tbl_hierarchy_org_id=".$field_id." "; 
		$rowrecord_chk = $this->projectmodel->get_records_from_sql($sql_chk);	
		foreach ($rowrecord_chk as $row_chk)
		{$stockist_cnt=$row_chk->cnt;}		
		
		$doctor_cnt=0;
		$sql_chk="SELECT count(*) cnt FROM mr_manager_doctor where
		headq=".$field_id." "; 
		$rowrecord_chk = $this->projectmodel->get_records_from_sql($sql_chk);	
		foreach ($rowrecord_chk as $row_chk)
		{$doctor_cnt=$row_chk->cnt;}		
		
		$retailer_cnt=0;
		$sql_chk="SELECT count(*) cnt FROM retailer where
		retail_field=".$field_id." "; 
		$rowrecord_chk = $this->projectmodel->get_records_from_sql($sql_chk);	
		foreach ($rowrecord_chk as $row_chk)
		{$retailer_cnt=$row_chk->cnt;}		
		
		if($stockist_cnt==0 and  $doctor_cnt==0 and  $retailer_cnt==0)
		{ 
			 $query="delete from tbl_hierarchy_org where id=".$field_id." ";
			 $this->db->query($query);
		}
		
	}
		
}
	
	
	public function get_all_record($table_name,$where_array)
	{
		$res=$this->db->get_where($table_name,$where_array);
		return $res->result();
	}
	
	public function get_records_from_sql($sql)
	{
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	
	public function get_single_record($table_name,$id)
	{
		$sql = "SELECT * FROM ".$table_name." WHERE id=".$id;
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function save_records_model($id,$table_name,$tabale_data)
	{
		if($id>0)
		{$this->db->update($table_name, $tabale_data, array('id' => $id));}
		else
		{$this->db->insert($table_name,$tabale_data);}	
	}
	
	public function delete_record($id=0,$table_name)
	{$this->db->delete($table_name,array('id'=>$id));}
	
	
	
}
?>