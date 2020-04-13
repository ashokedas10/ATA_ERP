<?php
class Modeltree extends CI_Model {

	var  $obarray, $list;
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('thumb_model', 'thumb');
    }
	
	
	//TREE VIEW ...
	function getTreeview()
	{
		$query = $this->db->query("select * from tbl_hierarchy_org 
		where  tbl_designation_id<=5 ");
		return $query->result_array();		
	}
	//COMPLETE 

		 
	 function buildTree($catArray)
	 {
	 	 global $obarray, $list;
	 	//print_r($catArray); 
		
	 	 $list = "<tr><td>"; 
		 if (!is_array($catArray)) return '';
		 $obarray = $catArray;
		 
		 foreach($obarray as $item){
		 	 if($item['under_tbl_hierarchy_org'] == 0){
		 	 	 $mainlist = $this->_buildElements($item, 0);
		 	 }
		 }
		 $list .= "</td></tr>";
		 return $list;
	 }
	 
	 private function _buildElements($parent, $append)
	 {
	 	 global $obarray, $list ;
	 	 
		 if($parent['tbl_designation_id']==1)
		 {
		 $list .= '<tr><td bgcolor="#993300">' . $parent['hierarchy_name'] . '</td></tr>';
		 }
		 else if($parent['tbl_designation_id']==2)
		 {
		 $list .= '<tr><td bgcolor="#3399CC">' . $parent['hierarchy_name'] . '</td></tr>';
		 }
		  else if ($parent['tbl_designation_id']==3)
		 {
		 $list .= '<tr><td bgcolor="#00FF00">' . $parent['hierarchy_name'] . '</td></tr>';
		 }
	 	  else if ($parent['tbl_designation_id']==4)
		 {
		 $list .= '<tr><td bgcolor="#CCFF33">' . $parent['hierarchy_name'] . '</td></tr>';
		 }		
		 else  if($parent['tbl_designation_id']==5)
		 {
		 $list .= '<tr><td bgcolor="#993399">' . $parent['hierarchy_name'] . '</td></tr>';
		 }
		 else {  }
		  
		  $table_data['tbl_designation_id']=$parent['tbl_designation_id'];
		  $table_data['tbl_hierarchy_org_id']=$parent['id'];
		  $table_data['tbl_hierarchy_org_name']=$parent['hierarchy_name'];
		  $table_data['status']='START';
		  
		  $this->save_records_model('','structure_tree',$table_data);
//$list .= '<tr><td bgcolor="#993399">' . $parent['hierarchy_name'] . '</td></tr>';

		 if($this->_hasChild($parent['id'])){
		 	 $append++;
		 	 $list .= "<tr><td>";
		 	 $child = $this->_buildArray($parent['id']);

			 foreach($child as $item){
				 $list .= $this->_buildElements($item, $append);
				
			 }
			 $list .= "</td></tr>";
		 }
		 
		  $table_data['tbl_designation_id']=$parent['tbl_designation_id'];
		  $table_data['tbl_hierarchy_org_id']=$parent['id'];
		  $table_data['tbl_hierarchy_org_name']=$parent['hierarchy_name'];
		  $table_data['status']='END';
		   $this->save_records_model('','structure_tree',$table_data);
		   
		 if($parent['tbl_designation_id']==1)
		 {
		 $list .= '<tr><td bgcolor="#993300">Total of ' . $parent['hierarchy_name'] . '</td></tr>';
		 }
		 else if($parent['tbl_designation_id']==2)
		 {
		 $list .= '<tr><td bgcolor="#3399CC">Total of ' . $parent['hierarchy_name'] . '</td></tr>';
		 }
		  else if ($parent['tbl_designation_id']==3)
		 {
		 $list .= '<tr><td bgcolor="#00FF00">Total of ' . $parent['hierarchy_name'] . '</td></tr>';
		 }
	 	  else if ($parent['tbl_designation_id']==4)
		 {
		 $list .= '<tr><td bgcolor="#CCFF33">Total of ' . $parent['hierarchy_name'] . '</td></tr>';
		 }		
		 else  if($parent['tbl_designation_id']==5)
		 {
		 $list .= '<tr><td bgcolor="#993399">Total of ' . $parent['hierarchy_name'] . '</td></tr>';
		 }
		 else {  }
		 
	 }
	 
	 private function _hasChild($parent)
	 {
	 	 global $obarray;
		 $counter = 0;
		 foreach($obarray as $item){
			 if($item['under_tbl_hierarchy_org'] == $parent){
				 ++$counter;
			 }
		 }
		 return $counter;
	 }
	 
	 private function _buildArray($parent)
	 {
	 	 global $obarray;
		 $bArray = array();
		 
		 foreach($obarray as $item){
			 if($item['under_tbl_hierarchy_org'] == $parent){
				 array_push($bArray, $item);
			 }
		 }
		 
		 return $bArray;
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
	

}
?>