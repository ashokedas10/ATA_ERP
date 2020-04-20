      <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="#"><b>Soft</b>Ware <?php  echo CI_VERSION; ?></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Soft</b>Ware</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
       
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="hidden-xs">
				  <?php echo $this->session->userdata('login_name'); ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                   <!-- 
				   <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
				   -->
                    <p>
                      Hello	<?php echo $this->session->userdata('login_name'); ?>
                      <small><?php echo date('d/m/Y');?></small>
                    </p>
                  </li>
               
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Change Password</a>
                    </div>
                    <div class="pull-right">
                      <a href="#" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
           			  
            </ul>
          </div>
        </nav>
      </header>
	  
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel"></div>
        
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
          <!--<li class="header">SELL SECTION</li>-->
           
		    <li><a href="<?php echo ADMIN_BASE_URL?>
				Project_controller/dashboard/"><i class="fa fa-book"></i> 
			<span>Dash Board</span></a>
			</li> 
		
<?php 
$login_status=$this->session->userdata('login_status');

if($login_status=='SUPER') {?>	   
		
	<li class="header">DYNAMIC FORM-RPT TEMPLATE</li>
	
	<li class="treeview">
              <a href="#">
                <i class="fa fa-table"></i> <span>Master Create</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
 		 <ul class="treeview-menu">
		 
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/TempleteFormReport/list/"><i class="fa fa-circle-o"></i>TEMPLATE FORM SET</a></li> 		
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/Master_upload/"><i class="fa fa-circle-o"></i>Master Data Upload</a></li> 		
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/TempleteForm/25/list/"><i class="fa fa-circle-o"></i>Query Builder</a> </li>	
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/TempleteForm/7/list/"><i class="fa fa-circle-o"></i>General Master</a></li> 	
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/TempleteForm/26/list/"><i class="fa fa-circle-o"></i>Account Group setting</a> </li>	
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/TempleteForm/10/list/"><i class="fa fa-circle-o"></i>User Master</a></li> 	
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/TempleteForm/29/list/"><i class="fa fa-circle-o"></i>Menu Management</a></li>
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/TempleteForm/28/list/"><i class="fa fa-circle-o"></i>Application Architecture</a></li> 	
			
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/treeview"><i class="fa fa-circle-o"></i>Tree View</a> </li>		
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/currency_related"><i class="fa fa-circle-o"></i>currency_related</a> </li>	
		
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/angularjs_dynamic_form/"><i class="fa fa-circle-o"></i>
		Angularjs Dynamik Form</a> </li>	
		
		
		<?php /*?><li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/requisition/acc_tran/41/">
		<i class="fa fa-circle-o"></i>
		Requisition</a> </li><?php */?>
		
		
		
		
						 
        </ul>
	  </li>
	  
	  
	  
<?php } ?>	

<?php if($login_status=='ADMIN' || $login_status=='SUPER') {?>	
	
	<li class="header">MENU MANAGEMENT</li>
	<li class="treeview"><a href="#"><i class="fa fa-table"></i> <span>Menu Manage</span><i class="fa fa-angle-left pull-right"></i></a>
 		
		<ul class="treeview-menu">
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/TempleteFormReport/list/"><i class="fa fa-circle-o"></i>TEMPLATE FORM SET</a></li> 	
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/TempleteForm/7/list/"><i class="fa fa-circle-o"></i>General Master</a></li> 
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/TempleteForm/29/list/"><i class="fa fa-circle-o"></i>Menu Management</a></li>	
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/TempleteForm/30/list/"><i class="fa fa-circle-o"></i>Create Role</a></li>
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/role_mapping/"><i class="fa fa-circle-o"></i>Role maping </a></li>	
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/TempleteForm/10/list/"><i class="fa fa-circle-o"></i>User Master</a></li> 
		
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/TempleteForm/31/list/"><i class="fa fa-circle-o"></i>
		Currency master -old </a> </li>
		
		 <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/master_form/master_form/31/"><i class="fa fa-circle-o"></i>
		Currency master test-angularjs </a> </li>	
		
		 
		 <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/CHART_OF_ACCOUNTS/acc_tran/75/">
		 <i class="fa fa-circle-o"></i>New Chart of  Account </a> </li>
		
		
		<?php /*?> <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/master_form/master_form/65/">
		 <i class="fa fa-circle-o"></i>1.Inventory Items </a> </li>
		 
		 <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/master_form/master_form/66/">
		 <i class="fa fa-circle-o"></i>2.Resource </a> </li>
		
		 <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/opm_operation_summary/acc_tran/67/">
		 <i class="fa fa-circle-o"></i>3.Operation </a> </li>
		 
		 
		 <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/opm_routing/acc_tran/67/">
		 <i class="fa fa-circle-o"></i>4.Routing </a> </li>
		 
		 <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/opm_receipe/acc_tran/67/">
		 <i class="fa fa-circle-o"></i>5.Receipe </a> </li>
		 
		 <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/opm_formula/acc_tran/67/">
		 <i class="fa fa-circle-o"></i>6.Formula </a> </li><?php */?>
		 
		 
		  <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/master_form/master_form/8/">
		 <i class="fa fa-circle-o"></i>1.Inventory Items </a> </li>
		 
			 
        </ul>
	</li>
	
	
	
	<?php 
	$records="select * from software_architecture_details where status='ACTIVE' and data_type=71 order by orderby";
	$records = $this->projectmodel->get_records_from_sql($records);	
	foreach ($records as $record)
	{
	$menu_header_id=$record->id;
	?>
	<li class="header"><?php echo $record->name;?></li>
	
	<?php 
	
	$tbl_employee_mstr_id=$this->session->userdata('login_emp_id');
	$whr=" id=".$tbl_employee_mstr_id;	
	$rollid=$this->projectmodel->GetSingleVal('software_archi_role_manage_id','tbl_employee_mstr',$whr);
		
	$software_architecture_details_ids='0';
	$sub_headers="select * from software_archi_role_manage where  status='ACTIVE' and  parent_id=".$rollid;
	$sub_headers = $this->projectmodel->get_records_from_sql($sub_headers);	
	foreach ($sub_headers as $sub_header)
	{$software_architecture_details_ids=$software_architecture_details_ids.','.$sub_header->software_architecture_details_id;}
	
	
	$sub_headers="select * from software_architecture_details where data_type=72 and parent_id=".$menu_header_id." and status='ACTIVE' order by orderby";
	$sub_headers = $this->projectmodel->get_records_from_sql($sub_headers);	
	foreach ($sub_headers as $sub_header)
	{
	$sub_header_id=$sub_header->id;
	?>
	
	<li class="treeview"><a href="#"><i class="fa fa-table"></i> 
	<span><?php echo $sub_header->name;?></span>
    <i class="fa fa-angle-left pull-right"></i></a>
	
				<ul class="treeview-menu">
					<?php 
					$OPERATION='ADD';
					$record_details="select * from software_architecture_details where  status='ACTIVE' 
					and id in (".$software_architecture_details_ids.") order by orderby " ;
					$record_details = $this->projectmodel->get_records_from_sql($record_details);	
					foreach ($record_details as $record_detail)
					{
					$controller_path=$record_detail->controller_path;
					$menu_details_name=$record_detail->name;
					$OPERATION=$this->projectmodel->priviledge_value($record_detail->id);
					
					if($OPERATION<>'CAN_NOT_OPEN'){
					?>
					<li><a href="<?php echo ADMIN_BASE_URL?><?php echo $controller_path;?>"><i class="fa fa-circle-o"></i><?php echo $menu_details_name;?></a> </li>
					
					<?php }} ?>
			  </ul>
			  
	<?php }} ?>
			

	
	<li class="header">Transaction</li>
	
	<li class="treeview">
              <a href="#">
                <i class="fa fa-table"></i> <span>Procure To Pay </span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
 		 <ul class="treeview-menu">
		 
		 <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/requisition/acc_tran/47/"><i class="fa fa-circle-o"></i>
		Requisition </a> </li>
		
		 <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/requisition_approve/acc_tran/47/"><i class="fa fa-circle-o"></i>
		 Requisition Approve </a> </li>
				
		 <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/po_entry/acc_tran/47/"><i class="fa fa-circle-o"></i>
		Po Entry </a> </li>
		
		 <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/po_approve/acc_tran/47/"><i class="fa fa-circle-o"></i>
		 PO Approve </a> </li>
		
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/receipt_of_goods/acc_tran/47/"><i class="fa fa-circle-o"></i>
		Receipt of Goods</a> </li>
		
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/INSPECTION/acc_tran/47/"><i class="fa fa-circle-o"></i>
		Inspection</a> </li>
		
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/purchase_invoice/acc_tran/47/"><i class="fa fa-circle-o"></i>
		Generate Invoice</a> </li>
		
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/payment_rcv/acc_tran/47/"><i class="fa fa-circle-o"></i>
		Payment</a> </li>
						 
        </ul>
	  </li>
	
	
	<li class="treeview">
              <a href="#">
                <i class="fa fa-table"></i> <span>Order To Cash</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
 		 <ul class="treeview-menu">
		 
				
		 <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/SALES_ORDER/acc_tran/47/">
		 <i class="fa fa-circle-o"></i>
		 Sales Order </a> 
		 </li>
		
		 <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/SALES_ORDER_APPROVE/acc_tran/47/"><i class="fa fa-circle-o"></i>
		 Sales Order Approve </a> </li>
		
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/DESPATCH_GOODS/acc_tran/47/"><i class="fa fa-circle-o"></i>
		Despatch</a> </li>
		
				
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/sale_invoice/acc_tran/47/"><i class="fa fa-circle-o"></i>
		Bill</a> </li>
		
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/receive_amt/acc_tran/47/"><i class="fa fa-circle-o"></i>
		Receipt</a> </li>
						 
        </ul>
	  </li>
	
	
	<li class="treeview">
              <a href="#">
                <i class="fa fa-table"></i> <span>OPM Setup</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
 		 <ul class="treeview-menu">
		 
		 
		 <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/master_form/master_form/66/">
		 <i class="fa fa-circle-o"></i>1.Resource </a> </li>
		
		 <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/opm_operation_summary/acc_tran/67/">
		 <i class="fa fa-circle-o"></i>2.Operation </a> </li>
		 
		 <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/opm_routing/acc_tran/67/">
		 <i class="fa fa-circle-o"></i>3.Routing </a> </li>
		 		 
		 <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/opm_formula/acc_tran/67/">
		 <i class="fa fa-circle-o"></i>4.Formula </a> </li>
		 
		 <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/opm_receipe/acc_tran/67/">
		 <i class="fa fa-circle-o"></i>5.Receipe </a> </li>
		
		 <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/master_form/master_form/91/">
		 <i class="fa fa-circle-o"></i>6.Batch Create </a> </li>
		 
		 
		 <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/batch_create_final/acc_tran/47/">
		 <i class="fa fa-circle-o"></i>
		 View Batch </a> 
		 </li>
		 
		 
						 
        </ul>
	  </li>
	
	
   			
	<?php /*?>
	
	<li class="header">Charts</li>
	
	<li class="treeview">
	<a href="#">
	<i class="fa fa-table"></i> <span>Charts</span>
    <i class="fa fa-angle-left pull-right"></i>
    </a>
 		 <ul class="treeview-menu">
		 
		  <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/sales_trend/report/47/"><i class="fa fa-circle-o"></i>
		  Sales Trend </a> </li>
		 
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/category_wise_sale/report/47/"><i class="fa fa-circle-o"></i>
		Category Wise Sale </a> </li>
				
		 <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/top_20/report/47/"><i class="fa fa-circle-o"></i>
		Top 20 </a> </li>
		
		 <li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/bottom_20/report/47/"><i class="fa fa-circle-o"></i>
		Bottom 20 </a> </li>
		
		
        </ul>
	  </li>
	
	
	
	<li class="header">ACTIVITY SECTION</li>
		
	<li class="treeview">
              <a href="#">
                <i class="fa fa-table"></i> <span>Organisation Structure</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
 		<ul class="treeview-menu">
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/load_form_report/list_of_value"><i class="fa fa-circle-o"></i>List of values</a></li> 	
		
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/TempleteForm/8/list/"><i class="fa fa-circle-o"></i>Legal Entity</a></li> 
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/TempleteForm/27/list/"><i class="fa fa-circle-o"></i>Location</a></li> 		
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/TempleteForm/10/list/"><i class="fa fa-circle-o"></i>User Master</a></li> 		
		<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/TempleteForm/14/list/"><i class="fa fa-circle-o"></i>Operational Unit</a></li> 			 
        </ul>
	  </li><?php */?>
	  
	
	  	  
<?php } ?>	



			
	<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/logout">
	<i class="fa fa-circle-o text-red"></i> <span>Log Out</span></a></li>
		
	<li><a href="<?php echo ADMIN_BASE_URL?>Project_controller/changepassword">
	<i class="fa fa-circle-o text-yellow"></i><span>Change Password</span></a></li>
	
			
			  </ul>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>