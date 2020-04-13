<?php
class Authmod extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('form_validation', 'trackback', 'pagination', 'mylib'));
		$this->load->database();
    }
    
    function is_admin_login(){
		$admin_login = $this->session->userdata('admin_login');
		if(!isset($admin_login) || $admin_login!= TRUE){
			 redirect('auth/login/', 'refresh');
			 exit();
		}else{
			if( $this->session->userdata('usertype') > 2){
				$this->logout();
			}
		}
	}
	
	function get_admin_info(){
		$admin_login = $this->session->userdata('admin_login');

  		  if(!isset($admin_login) || $admin_login != true){
			 redirect('auth/login/', 'refresh');
			 return false;
			 exit();
		}else{
			$a_id = $this->session->userdata('a_id');
			$query = $this->db->query("SELECT * FROM p_webmaster WHERE a_id = '$a_id' ");
			return $query->result();
		}
	}
	
	function admin_get_login($data){
		
		$user_name = $data['username'];
		$user_pass = $this->encoded($data['password']);
		$query = $this->db->query("SELECT `a_id`, `user_name`, `usertype` FROM p_webmaster WHERE user_name = '$user_name' AND user_pass = '$user_pass' AND usertype = 1");
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$row->admin_login = TRUE;
			}
			$this->session->set_userdata($row);
			$this->session->set_userdata('alert_msg', '');
			redirect('auth/', 'refresh');
			exit();
		}else{
			redirect('auth/login/', 'refresh');
			exit();
		}
	}
	
	function logout(){
		
		$this->session->unset_userdata('admin_login');
		$this->session->unset_userdata('user_name');
		$this->session->unset_userdata('a_id');
		
		redirect('auth/login/', 'refresh');
		exit();
	}
	
	function encoded($str)
	{
		return str_replace(array('=','+','/'),'',base64_encode(base64_encode($str)));
	}
	
	function decoded($str)
	{
		return base64_decode(base64_decode($str));
	}
	
    function update_entry()
    {
        $this->title   = $_POST['title'];
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->update('entries', $this, array('id' => $_POST['id']));
    }
	
	function update_password($data){
		
		$pass = $this->encoded($data['pass1']);
		$a_id = $this->session->userdata('a_id');
		$query = $this->db->query("SELECT `a_id`, `user_name` FROM p_webmaster WHERE a_id = '$a_id' AND user_pass = '$pass' AND   usertype = 1");
		if ($query->num_rows() > 0){
			$pass = $this->encoded($data['pass2']);
			$query = $this->db->query("UPDATE `p_webmaster` SET user_pass = '$pass' WHERE `a_id` = '$a_id' ");
			$this->logout();
		}
	}
	
	
	function category_list($pid=0){
		$sql = "SELECT * FROM p_category WHERE pid = 0 AND status = 'A'  ";
		$query = $this->db->query($sql);
		$data['lft'] = $query->result();
		return $data;
	}
	

}




?>