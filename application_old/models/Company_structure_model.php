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
	if($TRANTYPE=='DOCTOR')
	{		
		$recordsHDR="select * from import_doctor_master ";
		$recordsHDR = $this->projectmodel->get_records_from_sql($recordsHDR);	
		foreach ($recordsHDR as $recordHDR)
		{			
			
			$save_updte['code']=$recordHDR->SVLNO;
			$save_updte['name']=$recordHDR->DOCNAME;
			$save_updte['headq']=$recordHDR->field_id;
			$save_updte['hq_id']=$recordHDR->hq_id;
			$save_updte['doc_type']=$recordHDR->doc_type;
			$save_updte['dob']=$recordHDR->DOB;
			$save_updte['dom']=$recordHDR->DOA;
			$save_updte['address']='';
			$save_updte['contactno']=$recordHDR->CONTACTNO;
			$save_updte['email']=$recordHDR->EMAIL;
			$save_updte['qualification']=$recordHDR->QUALIFICATION;
			
			$brand_data['brand_name']=strtoupper($recordHDR->SPECIALITY);
			$brand_data['brandtype']='SPECIALITY';
			
			$speciality_id='';
			$sql2="select * from brands where 
			UCASE(brand_name)='".strtoupper($recordHDR->SPECIALITY)."' 
			and brandtype='SPECIALITY' ";				
			$rowrecord2 = $this->projectmodel->get_records_from_sql($sql2);	
			foreach ($rowrecord2 as $row2)
			{$speciality_id=$row2->id;}				
			
			if($speciality_id=='')
			{
				$this->projectmodel->save_records_model($speciality_id,
				'brands',$brand_data);
				$speciality_id=$this->db->insert_id();		
			}		
			
			$save_updte['speciality']=$speciality_id;
			
			$save_updte['status']='DOCTOR';
			$save_updte['ACTIVITY_STATUS']='ACTIVE';
			//CHECKING NOT DONE
			$id='';			
			$this->projectmodel->save_records_model($id,'mr_manager_doctor',$save_updte);
		}	
	}
	//529,2205,2206,2207 AREA SALES MANAGER(ASM)
	if($TRANTYPE=='RETAILER')
	{	
	
		//FOR GENETICA LAB	
		$recordsHDR="select * from import_retailer_master ";
		$recordsHDR = $this->projectmodel->get_records_from_sql($recordsHDR);	
		foreach ($recordsHDR as $recordHDR)
		{
			$save_updte['retail_code']=$recordHDR->CODE;
			$save_updte['retail_name']=$recordHDR->NAME;
			$save_updte['retail_address']=$recordHDR->ADDRESS;
			$save_updte['retail_field']=$recordHDR->field_id;
			$save_updte['hq_id']=$recordHDR->hq_id;			
			$save_updte['status']='ACTIVE';
		
			//CHECKING NOT DONE
			$id='';			
			$this->projectmodel->save_records_model($id,'retailer',$save_updte);
		}	
		
		//FOR UNITED LAB
		/*	$cnt=1;
			$sqlfld="SELECT * FROM  import_doctor_master "; 
			$fields = $this->projectmodel->get_records_from_sql($sqlfld);	
			foreach ($fields as $field)
			{	
				
				$cnt_retailer1=0;	
				echo $sqlfld1="SELECT COUNT(*) cnt FROM  
				retailer where 	
				UCASE(retail_name)='".strtoupper($field->link_chemist1)."' 
				and retail_field=".$field->field_id; 
				$fields1 = $this->projectmodel->get_records_from_sql($sqlfld1);	
				foreach ($fields1 as $field1)
				{$cnt_retailer1=$field1->cnt;}
			     echo '<br>';
			
				if($cnt_retailer1==0 && strtoupper($field->link_chemist1)<>'')
				{
				$save_emp['retail_code']=$cnt;
				$save_emp['retail_name']=strtoupper($field->link_chemist1);	
				$save_emp['retail_field']=$field->field_id;	
				$save_emp['hq_id']=$field->hq_id;	
				$this->projectmodel->save_records_model('','retailer',$save_emp);
				$cnt=$cnt+1;
				}
				
				$cnt_retailer2=0;	
				$sqlfld1="SELECT COUNT(*) cnt FROM  
				retailer where 	
				UCASE(retail_name)='".strtoupper($field->link_chemist2)."' 
				and retail_field=".$field->field_id; 
				$fields1 = $this->projectmodel->get_records_from_sql($sqlfld1);	
				foreach ($fields1 as $field1)
				{$cnt_retailer2=$field1->cnt;}
				
				if($cnt_retailer2==0 && strtoupper($field->link_chemist2)<>'')
				{
				$save_emp['retail_code']=$cnt;
				$save_emp['retail_name']=strtoupper($field->link_chemist2);	
				$save_emp['retail_field']=$field->field_id;	
				$save_emp['hq_id']=$field->hq_id;	
				$this->projectmodel->save_records_model('','retailer',$save_emp);
				$cnt=$cnt+1;
				}
				
				$cnt=$cnt+1;
			}*/
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