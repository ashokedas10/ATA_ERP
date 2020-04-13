<?php
class Android_model extends CI_Model {


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		
    }
	


/*LOGIN LOGOUT*/
			
	public function validate(){
        // grab user input
        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean($this->input->post('password'));
        
        // Prep the query
        $this->db->where('userid', $username);
        $this->db->where('password', $password);
        $this->db->where('tbl_designation_id <',6);
        // Run the query
        $query = $this->db->get('tbl_employee_mstr');
        // Let's check if there are any results
        if($query->num_rows == 1)
        {
            // If there is a user, then create session data
		$this->session->set_userdata('billing_emp_desig', 2);
		$this->session->set_userdata('billing_emp_id',679);
					
			$row = $query->row();			
						           
            $data = array(
                    'login_userid' => $row->userid,
                    'login_name' => $row->name,
                    'login_emp_id' => $row->id,
					'login_tbl_designation_id'=> $row->tbl_designation_id,
					'login_status'=> $row->login_status,
                    'validated' => true
                    );
            $this->session->set_userdata($data);
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
	
	

		
	
}
?>