<?php if($parameters=='YES'){ ?>    
<form id="frm" name="frm" method="post" 
action="../activereports/<?php echo ADMIN_BASE_URL?>Primary_sale_controller/Reports/<?php echo $reportname; ?>" >
	<div class="row">
    <div class="col-md-6">
      <div class="box box-danger">
   		 <div class="box-body">
		<?php echo $fromdate.$todate; ?>
 		</div>
	</div>
	</div>
	  </div>
</form>

          <!-- /.col -->
</div>
<?php } ?>  

	
<div id="printablediv" class="block"  style="overflow:scroll"> 	
	<section class="invoice">
	<?php if($excelpdfimage=='YES'){ ?> 
 <div class="row">
	  <div class="col-xs-2">
		<img src="<?php echo BASE_PATH_ADMIN;?>theme_files/ExcelImage.png" 
		width="70" height="63"  onclick="myExportToExcel();"/> 
	  </div>	
<?php } ?>  
<?php 
   $sql="select * from company_details where id=1 ";
	$rowrecord = $this->projectmodel->get_records_from_sql($sql);	
	foreach ($rowrecord as $fld)
	{$NAME =$fld->NAME ;}
?>
        <div class="row">
          <div class="col-xs-12">
            <h2 class="page-header">
              <i class="fa fa-globe"></i> <?php echo $NAME ; ?>
              <small class="pull-right">Date:<?php echo date('d/m/Y'); ?></small>
            </h2>
          </div><!-- /.col -->
        </div>
        <!-- info row -->      
        <!-- Table row -->
        <div class="row" >
          <div class="col-xs-12 table-responsive">
		  		  
      <table class="table">
	    <thead>
	        <tr class="danger">
			<?php 
			//print_r($header);
			//echo $header[1];
			foreach($header as $key=>$hdr){
			 $cn_values =explode("-", trim($hdr));			
			 ?>
	            <td  align="<?php echo $cn_values[1]; ?>"><?php echo $cn_values[0]; ?></td>
	        <?php } ?>   
            </tr>
        </thead>
       
	   <tbody>
			<?php foreach($body as $key=>$bd){$column=0;?>
			<tr>
				<?php foreach($bd as $key1=>$bdr)
				{ 
					$align=$header[$column];
					$align =explode("-", trim($align));	
					$column=$column+1;
				?>
				<td align="<?php echo $align[1]; ?>"><?php echo $bdr; ?></td>
				<?php } ?>
			</tr>
			<?php } ?>		
		
		<?php  if($reportfooter=='YES'){?>     
		 <tfoot>
	        <tr class="danger">
			   <td colspan="2">&nbsp;</td>
	           <td align="right"><?php echo $footer_RTKM; ?></td>
            </tr>
        </tfoot>
        <?php } ?>  
	</tbody>
    </table>
			
 
          </div><!-- /.col -->
        </div><!-- /.row -->
</div>	
      </section><!-- /.content -->
</div>