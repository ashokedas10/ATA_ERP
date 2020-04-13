<?php
class Form_report_create_model extends CI_Model {
   

function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		//$this->load->model('thumb_model', 'thumb');
    }
	
    /*LOGIN LOGOUT*/
			    
public function create_save_array($headers=array())
{
    $output=array();
    $header_scount=sizeof($headers);
    for($hcount=0;$hcount<$header_scount;$hcount++)
    {
        $field_scount=sizeof($headers[$hcount]['fields']);
        $tablename=$headers[$hcount]['TableName'];
        $save_details=array();
        for($fcount=0;$fcount<$field_scount;$fcount++)
        {
            $id='';        
            foreach($headers[$hcount]['fields'][$fcount] as $key1=>$field)
            {
                foreach($field as $key2=>$field_val)
                {
                        if($key2=='InputName')
                        {
                            $inputname=$field['InputName'];	
                        
                            if($field['Inputvalue_id']>0)
                            {$save_details[$tablename][$inputname]=$field['Inputvalue_id'];}
                            else
                            {	$save_details[$tablename][$inputname]=$field['Inputvalue'];}
                        }
                }	

            }

            array_push($output,$save_details);	
                        
        }	

    }

    return $output;

}

public function create_report($rs=array(),$id=0)
{
    $return_data=$output=array();
    $resval=$this->create_form($rs,$id); 
    foreach($resval['header'][0]['fields'] as $key1=>$flds)
    {
            foreach($flds as $key2=>$fld)
            {
                //$save_details[$key2]=$fld['Inputvalue'];
                $save_details[$fld['InputName']]=$fld['Inputvalue'];						
            }							
            if($save_details['id']>0){array_push($output,$save_details);}
    }
    $return_data['header']=$output;			
    header('Access-Control-Allow-Origin: *');
    header("Content-Type: application/json");
    echo json_encode($return_data);
}

public function create_form($rs=array(),$id=0)
{
    $resval=$form_structure=$output=array();    

    if($id>0)
    {
        $input_id_index=0;			
        foreach ($rs as $key=>$sections)
        {			
        
            $headers=$sections['sql_query'];					
            $headers = $this->projectmodel->get_records_from_sql($headers);	
            //print_r($headers);
            $headers = json_decode(json_encode($headers), true);
            foreach ($headers as $key1=>$header)
            {	
                
                foreach ($header as $key2=>$field_val)
                {
                    if($sections['section_type']=='GRID_ENTRY')
                    {
    
                        $form_structure['header'][$key]['section_type']=$sections['section_type'];
                        $form_structure['header'][$key]['id']=$sections['id'];
                        $form_structure['header'][$key]['parent_id']=$sections['parent_id'];
                        $form_structure['header'][$key]['TableName']=$sections['TableName'];
                        $form_structure['header'][$key]['fields'][0][$key2]=$this->create_fields_parameter($sections['frmrpttemplatehdr_id'],$key2,0,$input_id_index);
                        $input_id_index=$input_id_index+1;
    
                        $form_structure['header'][$key]['section_type']=$sections['section_type'];
                        $form_structure['header'][$key]['id']=$sections['id'];
                        $form_structure['header'][$key]['parent_id']=$sections['parent_id'];
                        $form_structure['header'][$key]['TableName']=$sections['TableName'];
                        //here
                        $form_structure['header'][$key]['fields'][$key1+1][$key2]=$this->create_fields_parameter($sections['frmrpttemplatehdr_id'],$key2,$field_val,$input_id_index);
                        $input_id_index=$input_id_index+1;
    
                    }
                    else
                    {
                        $form_structure['header'][$key]['section_type']=$sections['section_type'];
                        $form_structure['header'][$key]['id']=$sections['id'];
                        $form_structure['header'][$key]['parent_id']=$sections['parent_id'];
                        $form_structure['header'][$key]['TableName']=$sections['TableName'];
                        //here
                        $form_structure['header'][$key]['fields'][$key1][$key2]=
                        $this->create_fields_parameter($sections['frmrpttemplatehdr_id'],$key2,$field_val,$input_id_index);
                        $input_id_index=$input_id_index+1;
    
                    }
                
                }
            }
    
        }

    }
    else //NEW ENTRY FORM
    {
            $input_id_index=0;			
            foreach ($rs as $key=>$sections)
            {	
                    $field_array = explode(',', $sections['fields']);
                    foreach ($field_array as $key1=>$field)
                    {	
                        $form_structure['header'][$key]['section_type']=$sections['section_type'];
                        $form_structure['header'][$key]['id']=$sections['id'];
                        $form_structure['header'][$key]['parent_id']=$sections['parent_id'];
                        $form_structure['header'][$key]['TableName']=$sections['TableName'];
                        $form_structure['header'][$key]['fields'][0][$field]=
                        $this->create_fields_parameter($sections['frmrpttemplatehdr_id'],$field,'',$input_id_index);
                        
                        $input_id_index=$input_id_index+1;
                    }					
            }

    }

   
    
	return $form_structure;
	
}


public function create_fields_parameter($frmrpttemplatedetails_id='',$InputName='',$Inputvalue='',$input_id_index=0)
{
	$output=array();

	$details="select * from  frmrpttemplatedetails  where frmrpttemplatehdrID=".$frmrpttemplatedetails_id." and InputName='$InputName' order by FieldOrder";					
	$details = $this->projectmodel->get_records_from_sql($details);	
	foreach ($details as $key2=>$detail)
	{	
	
		//RELATED TO DROP DWON MASTER TABLE AND LINK FIELD NAME
		$output['MainTable']=$detail->MainTable;
		$output['LinkField']=$detail->LinkField;
		//RELATED TO DROP DWON MASTER TABLE AND LINK FIELD NAME
		
		$output['frmrpttemplatehdrID']=$detail->frmrpttemplatehdrID;
		$output['DIVClass']=$detail->DIVClass;
		$output['Section']=$detail->Section;
		$output['SectionType']=$detail->SectionType;
		$output['input_id_index']=$input_id_index;
		
		$output['LabelName']=$detail->LabelName;
		$output['InputName']=$detail->InputName;						
		$output['Inputvalue']='';		
        $output['Inputvalue_id']=0;
        $output['InputType']=$detail->InputType;
        if($detail->InputType=='SingleSelect'){$output['InputType']='text';}
        

        $output['validation_type']=$detail->validation_type;
        $output['validation_msg']='';
        

		// if($detail->InputType=='text'){$output['InputType']='text';}
		// //else if($detail->InputType=='text_area'){$form_structure['header'][$key1]['body'][$key2]['InputType']='text_area';}
		// else if($detail->InputType=='hidden'){$output['InputType']='hidden';}
        // else if($detail->InputType=='password'){$output['InputType']='password';}
        // else if($detail->InputType=='LABEL'){$output['InputType']='LABEL';}
		// else {$output['InputType']='text';}
		

			$output['Inputvalue']=$detail->Inputvalue;
			if($detail->datafields<>'')
			{$output['datafields']=$this->projectmodel->get_records_from_sql($detail->datafields);}
			else
			{$output['datafields']='';}				

			$inputval='';
			if($output['datafields']<>'')
			{			
				$Inputvalue_id=$Inputvalue;			
				$datafields_array = json_decode(json_encode($output['datafields']), true);
				$count_parent=sizeof($datafields_array);		
					for($cnt_parent=0;$cnt_parent<=$count_parent-1;$cnt_parent++)
					{	
							if($datafields_array[$cnt_parent]['FieldID']==$Inputvalue)
							{	$inputval=$datafields_array[$cnt_parent]['FieldVal'];}
					}	
				
					$output['Inputvalue']=$inputval;		
					$output['Inputvalue_id']=$Inputvalue_id;
            }
            else if($detail->Inputvalue<>'')
			{
                $output['Inputvalue']=$detail->Inputvalue;
                $output['Inputvalue_id']='';
            }   
			else
			{
				$output['Inputvalue']=$Inputvalue;		
				$output['Inputvalue_id']='';	
			}

	}	

	return $output;


}

public function re_arrange_input_index($someArray=array())
{
    $input_id_index=0;
    foreach ($someArray['header'] as $header_index=>$header)
        {
            foreach ($someArray['header'][$header_index]['fields'] as $field_indx=>$field)
            {
                foreach ($someArray['header'][$header_index]['fields'][$field_indx] as $field_indx2=>$field2)
                {	
                    //$someArray['header'][$header_index]['fields'][$field_indx][$field_indx2]['LabelName'];
                    //echo '<br>';
                    if($someArray['header'][$header_index]['fields'][$field_indx][$field_indx2]['InputType']<>'hidden')
                    {
                        //echo $someArray['header'][$header_index]['fields'][$field_indx][$field_indx2]['InputType'];
                        $someArray['header'][$header_index]['fields'][$field_indx][$field_indx2]['input_id_index']=$input_id_index;
                        $input_id_index=$input_id_index+1;
                    }
                    else
                    {
                        //echo $someArray['header'][$header_index]['fields'][$field_indx][$field_indx2]['InputType'];
                        $someArray['header'][$header_index]['fields'][$field_indx][$field_indx2]['input_id_index']=9000;
                    }		
                }
        
            }

        }                
       return $someArray;
}

public function re_arrange_input_index_type2($someArray=array())
{
    $input_id_index=0;
    foreach ($someArray[0]['header'] as $header_index=>$header)
        {
            foreach ($someArray[0]['header'][$header_index]['fields'] as $field_indx=>$field)
            {
                foreach ($someArray[0]['header'][$header_index]['fields'][$field_indx] as $field_indx2=>$field2)
                {	
                    if($someArray[0]['header'][$header_index]['fields'][$field_indx][$field_indx2]['InputType']<>'hidden')
                    {
                        //echo $someArray['header'][$header_index]['fields'][$field_indx][$field_indx2]['InputType'];
                        $someArray[0]['header'][$header_index]['fields'][$field_indx][$field_indx2]['input_id_index']=$input_id_index;
                        $input_id_index=$input_id_index+1;
                    }
                    else
                    {
                        //echo $someArray['header'][$header_index]['fields'][$field_indx][$field_indx2]['InputType'];
                        $someArray[0]['header'][$header_index]['fields'][$field_indx][$field_indx2]['input_id_index']=9000;
                    }		
                }
        
            }

        }                
       return $someArray;
}
  
    public function validation_data($someArray=array())
    {
       // $someArray[0]['header'][$header_index]['fields'][$field_index]['req_supplier']['Inputvalue_id']

       //print_r($someArray);
        // echo '<pre>';
        // print_r($someArray['header']);
        // echo '</pre>';

        foreach ($someArray['header'] as $header_index=>$headervalue)
        {
            foreach ($someArray['header'][$header_index]['fields'] as $field_index=>$fieldvalues)
            {
                foreach ($someArray['header'][$header_index]['fields'][$field_index] as $field_name=>$field_value)
                {
                   // echo $field_name.' ---------- '.'<br><br>';

                    foreach ($someArray['header'][$header_index]['fields'][$field_index][$field_name] as $fld_indx=>$fld_value)
                    {
                        
                        $validation_type =$someArray['header'][$header_index]['fields'][$field_index][$field_name]['validation_type'];
                        $Inputvalue =$someArray['header'][$header_index]['fields'][$field_index][$field_name]['Inputvalue'];
                        $Inputvalue_id =$someArray['header'][$header_index]['fields'][$field_index][$field_name]['Inputvalue_id'];


                       // echo $fld_indx.' - '.$fld_value.'<br>';
                        // $someArray[0]['header'][$header_index]['fields'][$field_index]
                        //REQUIRED VALIDATION
                        // if($fld_indx=='validation_type' && $fld_value==145)
                        // {

                        //  echo  $inputval= $someArray['header'][$header_index]['fields'][$field_index]['InputName'];
                        
                        // }
                        
                    }  
                   // echo '<br><br>';
                   // echo $field_name.' - '.$field_value.'<br>';
                   // $someArray[0]['header'][$header_index]['fields'][$field_index]
                    
                }               
                
            }

        }




    }

    
    public function create_form_structure($form_structure=array(),$parent_id=0,$key1=0)
	{
		

		$output=array();
		
		//  echo '<pre>';print_r($form_structure);echo '</pre>';

		 $headers="select * from  frmrpttemplatehdr where parent_id=".$parent_id." order by id";
			$headers = $this->projectmodel->get_records_from_sql($headers);	
			foreach ($headers as $indx=>$header)
			{				
					//echo $key1.'<br>';	
					$form_structure['header'][$indx]['id']=$header->id;
					$form_structure['header'][$indx]['Type']=$header->Type;
					$form_structure['header'][$indx]['DataFields']=$header->DataFields;
					$form_structure['header'][$indx]['WhereCondition']=$header->WhereCondition;
					$form_structure['header'][$indx]['OrderBy']=$header->OrderBy;
					

					$form_structure['header'][$indx]['FormRptName']=$header->FormRptName;
					$form_structure['header'][$indx]['Type']=$header->Type;	
					$form_structure['header'][$indx]['parent_id']=$header->parent_id;	
					$form_structure['header'][$indx]['parent_table_field_name']=$header->parent_table_field_name;
					$form_structure['header'][$indx]['child_table_field_name']=$header->child_table_field_name;
					$form_structure['header'][$indx]['TableName']=$header->TableName;

					$form_structure['header'][$indx]['Table_Id']='';
					$form_structure['header'][$indx]['grid_list']='';							
							
					//DETAIL SECTION OF THIS HEADER SECTION
					$details="select * from  frmrpttemplatedetails  where frmrpttemplatehdrID=".$header->id;					
					$details = $this->projectmodel->get_records_from_sql($details);	
					foreach ($details as $key2=>$detail)
					{	
						$form_structure['header'][$indx]['body'][$key2]['id']=$detail->id;	
						$form_structure['header'][$indx]['body'][$key2]['frmrpttemplatehdrID']=$detail->frmrpttemplatehdrID;
						$form_structure['header'][$indx]['body'][$key2]['DIVClass']=$detail->DIVClass;
						$form_structure['header'][$indx]['body'][$key2]['LabelName']=$detail->LabelName;
						$form_structure['header'][$indx]['body'][$key2]['InputName']=$detail->InputName;						
						$form_structure['header'][$indx]['body'][$key2]['Inputvalue']='';		
						$form_structure['header'][$indx]['body'][$key2]['Inputvalue_id']=0;
						$form_structure['header'][$indx]['body'][$key2]['InputType']=$detail->InputType;
						$form_structure['header'][$indx]['body'][$key2]['Inputvalue']=$detail->Inputvalue;
						if($detail->datafields<>'')
						{$form_structure['header'][$indx]['body'][$key2]['datafields']=$this->projectmodel->get_records_from_sql($detail->datafields);}
						else
						{$form_structure['header'][$indx]['body'][$key2]['datafields']='';}				
					}	

					//call recursive function ...
					//$indx=$key1+1;
					$this->create_form_structure($form_structure,$header->id,$indx);

				  	// $form_structure['header'][$key1]['nodes']=array_values();		
					  // $output[]=$form_structure;

					//$output[]=array_values($this->create_form_structure($form_structure,$header->id,$key1+1));	

			}

			return $form_structure;
    }
    
    public function tranfer_data($someArray=array())
    {
        header('Access-Control-Allow-Origin: *');
        header("Content-Type: application/json");
        echo json_encode($someArray);	
    }

	
}
?>