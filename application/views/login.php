<?php 
   
     	 /* $data['DataFields']='*';
          $data['TableName']='company_details'; 
          $data['WhereCondition']="id=1 ";
		  $data['OrderBy']="";
          $rowrecord=$this->projectmodel->Activequery($data,'LIST'); 
			foreach ($rowrecord as $fld)
			{$NAME =$fld->NAME ;}*/
			
			$NAME='ATA ERP';
			
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Login/Logout animation concept</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
  
  <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans'>

      <link rel="stylesheet" href="<?php echo BASE_PATH_ADMIN;?>theme_files/loginPage/css/style.css">

  
</head>

<body>
  <div class="cont">
  <div class="demo">
    <div class="login">
      <div class="login__check"><h1 align="center">Welcome To <br><?php echo $NAME; ?></h1></div>
	   <form action="<?php echo ADMIN_BASE_URL;?>project_controller/login_process" 
		method="post">
		
      <div class="login__form">
        <div class="login__row">
          <svg class="login__icon name svg-icon" viewBox="0 0 20 20">
            <path d="M0,20 a10,8 0 0,1 20,0z M10,0 a4,4 0 0,1 0,8 a4,4 0 0,1 0,-8" />
          </svg>
          <input type="text" name="username" class="login__input name" placeholder="Username"/>
        </div>
        <div class="login__row">
          <svg class="login__icon pass svg-icon" viewBox="0 0 20 20">
            <path d="M0,20 20,20 20,8 0,8z M10,13 10,16z M4,8 a6,8 0 0,1 12,0" />
          </svg>
          <input type="password" name="password" class="login__input pass" placeholder="Password"/>
        </div>
        <button type="submit" class="login__submit">Sign in</button><br>
		 <a href="<?php echo ADMIN_BASE_URL;?>"><button type="button" class="login__submit">Download Android App</button></a>
      
      </div>
	  
	  </form>
	  
    </div>
   
  </div>
</div>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script  src="<?php echo BASE_PATH_ADMIN;?>theme_files/loginPage/js/index.js"></script>

</body>
</html>
