<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/


/*define('INVOICE_MAIL_IDS', 'ashokedas@gmail.com');
define('COMPANY_NAME', 'ASTRAFORD');  
define("BASE_PATH_ADMIN", "http://astraford.co.in/"); 
define("ADMIN_BASE_URL", "http://astraford.co.in/");
define("ENC_KEY", "APANtByIGI1BpVXZTJgcsAG8GZl8pdwwa84");
define("FCKEDITOR_BASEPATH", "/azhar_ncc/fckeditor/");
define("HEARD_PATH", "D:/web_projects/xampp/htdocs/pharma_management/geneticalabs.net/");
define("HOST","localhost");
define("USER", "astrafor_pharma"); 
define("PWD","oul=Zg}zbA?H");
define("DATABASE", "astrafor_pharma");*/


define('INVOICE_MAIL_IDS', 'ashokedas@gmail.com,unilab.wm@gmail.com,unilab.oe@gmail.com');
define('COMPANY_NAME', 'UNITED LAB');  
define("BASE_PATH_ADMIN", "http://localhost/pharma_management/astaford_erp/"); 
define("ADMIN_BASE_URL", "http://localhost/pharma_management/astaford_erp/");
define("ENC_KEY", "APANtByIGI1BpVXZTJgcsAG8GZl8pdwwa84");
define("FCKEDITOR_BASEPATH", "/azhar_ncc/fckeditor/");
define("HEARD_PATH", "D:/web_projects/xampp/htdocs/pharma_management/staford/");
define("HOST","localhost");
define("USER", "root"); 
define("PWD","");
//define("DATABASE", "astaford_erp");  
define("DATABASE", "astaford_erp_test");  


//define("DATABASE", "pharma_medichem_mew");
//define("DATABASE", "pharma_sanjeevani");


define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */