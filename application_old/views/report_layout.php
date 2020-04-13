<?php 
   $sql="select * from company_details where id=1 ";
	$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
	foreach ($rowrecord as $fld)
	{$NAME =$fld->NAME ;}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html><head>
<title><?php echo $NAME; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


	<style>
	@import url(http://fonts.googleapis.com/css?family=Bree+Serif);
	body, h1, h2, h3, h4, h5, h6{
		font-family: 'Bree Serif', serif;
	}
	.style1 {font-size: 10px ; font-family: Arial, Helvetica, sans-serif }
	
	<!--dddd-->
	.style2 {font-size: 16px}
    .style4 {font-size: 24px}
    </style>
	
	<STYLE TYPE="text/css">
     P.breakhere {page-break-before: always}
.style4 {font-size: 10px; color: #0000CC; }
.style8 {font-size: 12px; font-family: "Times New Roman", Times, serif; }
.style11 {font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
    .style12 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 12px;
}
.style18 {font-family: "Times New Roman", Times, serif; font-size: 14px;}
    .style6 {font-size: 24px; color: #990000; font-weight: bold; }
    </STYLE>
   
</head>
<body>
 <div class="container_12"><?php echo $body; ?></div>
	
  <?php /*?>  <div class="clear"></div>
    <div id="site_info">
	<p>Copyright <a href="http://dataspec.org/"> dataspec.org</a>. All Rights Reserved.</p>
	</div><?php */?>

<br>
</body></html>