<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of uploader
 *
 * @author Rana
 */
class Uploader {
    var $config;
    public function __construct() {
        $this->ci =& get_instance();
        
        $this->config =  array(
                  'upload_path'     => BASE_PATH_ADMIN."uploads/",
                  'upload_url'      => BASE_PATH_ADMIN."uploads/",
                  'allowed_types'   => "gif|jpg|png|jpeg|pdf|doc|xml",
                  'overwrite'       => TRUE,
                  'max_size'        => "1000KB",
                  'max_height'      => "768",
                  'max_width'       => "1024"   
                );
    }
    
    public function do_upload(){
        
        $this->remove_dir($this->config["upload_path"], false);
        
        $this->ci->load->library('upload', $this->config);
        if($this->ci->upload->do_upload())
        {
            $this->ci->data['status']->message = "File Uploaded Successfully";
            $this->ci->data['status']->success = TRUE;
            $this->ci->data["uploaded_file"] = $this->ci->upload->data();
        }
        else
        {
            $this->ci->data['status']->message = $this->ci->upload->display_errors();
            $this->ci->data['status']->success = FALSE;
        }
    }
    
    function remove_dir($dir, $DeleteMe) {
        if(!$dh = @opendir($dir)) return;
        while (false !== ($obj = readdir($dh))) {
            if($obj=='.' || $obj=='..') continue;
            if (!@unlink($dir.'/'.$obj)) $this->remove_dir($dir.'/'.$obj, true);
        }
 
        closedir($dh);
        if ($DeleteMe){
            @rmdir($dir);
        }
    
    }
}
