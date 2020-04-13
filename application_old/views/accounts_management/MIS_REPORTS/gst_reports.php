<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div class="panel panel-primary" >
	
	  <div class="panel-body" align="center" style="background-color:#99CC00">
		<h3><span class="label label-default"></span>
		<span class="label label-default">
		GST Report
		</span></h3>
	  </div>
</div>

<form action="<?php echo ADMIN_BASE_URL?>Accounts_controller/gst_reports/Download/" 
name="frmreport" id="frmreport" method="post">
	
<div class="panel panel-primary"  style="background-color:#E67753">
 <div class="panel-footer">
 <div class="form-row"> 

		<div class="form-group col-md-4">
		 <input type="text" id="fromdate" class="form-control" name="fromdate" />
		</div>
		<div class="form-group col-md-4">
		 <input type="text" id="todate" class="form-control" name="todate" />
		</div>
		
		<div class="form-group col-md-4">
		 <button type="submit" class="btn btn-primary" id="Save" name="Save">Save</button>
		</div>
		<div class="panel-body" align="center">
		
  </div>  
</div></div></div>
  
</form>


<script>
  
     $("#tran_date").datepicker({
      changeMonth: true,
      changeYear: true
    });
 	
	$("#tran_date").change(function() {
	 var  trandate = $('#tran_date').val();
	 trandate=
	 trandate.substring(6, 10)+'-'+
	 trandate.substring(0, 2)+'-'+
	 trandate.substring(3, 5);
	 $("#tran_date").val(trandate);
	});
	
	
	 $("#chqdate").datepicker({
      changeMonth: true,
      changeYear: true
    });
 	
	$("#chqdate").change(function() {
	 var  trandate = $('#chqdate').val();
	 trandate=
	 trandate.substring(6, 10)+'-'+
	 trandate.substring(0, 2)+'-'+
	 trandate.substring(3, 5);
	 $("#chqdate").val(trandate);
	});
	
     $("#fromdate").datepicker({
      changeMonth: true,
      changeYear: true
    });
 	
	$("#fromdate").change(function() {
	 var  trandate = $('#fromdate').val();
	 trandate=
	 trandate.substring(6, 10)+'-'+
	 trandate.substring(0, 2)+'-'+
	 trandate.substring(3, 5);
	 $("#fromdate").val(trandate);
	});
	
	 $("#todate").datepicker({
      changeMonth: true,
      changeYear: true
    });
 	
	$("#todate").change(function() {
	 var  trandate = $('#todate').val();
	 trandate=
	 trandate.substring(6, 10)+'-'+
	 trandate.substring(0, 2)+'-'+
	 trandate.substring(3, 5);
	 $("#todate").val(trandate);
	});
	
  </script>
  