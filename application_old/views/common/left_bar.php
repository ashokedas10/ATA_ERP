
<?php /*?><?php
if($this->uri->segment(1)=="administrator" || $this->uri->segment(1)=="auth" ){
	$show_p_n_img = base_url().'theme_files/images/neg_new.gif';
	$mnu_dis_div = '';
}else{
	$show_p_n_img = base_url().'theme_files/images/plus_new.gif';
	$mnu_dis_div = 'style="display:none;"';
}
?>
<?php */?>
<?php /*?>
<table width="200" cellpadding="0" cellspacing="0" border="0">
<tr>
<td width="200" bgcolor="#C5C5C5">

<table border="0" cellpadding="3" cellspacing="1" width="100%">
<tbody><tr class="thead">
<td align="left"><a id="xadminindex" href="javascript:Toggle('adminindex','<?php echo base_url()?>theme_files/images/');"><img src="<?php echo $show_p_n_img; ?>" border="0" height="11" hspace="0" vspace="0" width="11"></a><a class="leftBar" id="xadminindex" href="javascript:Toggle('adminindex','<?php echo base_url()?>theme_files/images/');"> &nbsp;Administration &nbsp;</a></td>
</tr>
</tbody></table>

<div id="adminindex" <?php echo $mnu_dis_div?> >
<table width="100%" border="0" cellspacing="1" cellpadding="3">
<tr>
<td align="left" class="alt2"><img src='<?php echo base_url()?>theme_files/images/spacer.gif' width="8" height="8" />&nbsp;&nbsp;
<?php if($this->uri->segment(1)=="administrator" && ($this->uri->segment(2)=="index" || $this->uri->segment(2)=="") ) { ?>
	<img src='<?php echo base_url()?>theme_files/images/dot_yellowh.gif' border='0' />
<?php } else { ?>
	<img src='<?php echo base_url()?>theme_files/images/frm_linevrlt.gif' border='0' />
<?php } ?>
<a class="leftBarText" target ="_self" href="<?php echo base_url()?>index.php/administrator/index">Admin Index</a>
</td>
</tr>

<tr>
<td align="left" class="alt1"><img src='<?php echo base_url()?>theme_files/images/spacer.gif' width="8" height="8" />&nbsp;&nbsp;
<?php if($this->uri->segment(1)=="login.php") { ?>
	<img src='<?php echo base_url()?>theme_files/images/dot_yellowh.gif' border='0' />
<?php } else { ?>
	<img src='<?php echo base_url()?>theme_files/images/frm_linevrlt.gif' border='0' />
<?php } ?>
<a class="leftBarText" target ="_self" href="<?php echo base_url()?>index.php/auth/logout">Logout</a>
</td>
</tr>
<tr>
<td align="left" class="alt2"><img src='<?php echo base_url()?>theme_files/images/spacer.gif' width="8" height="8" />&nbsp;&nbsp;
<?php if($this->uri->segment(2)=="changepassword") { ?>
	<img src='<?php echo base_url()?>theme_files/images/dot_yellowh.gif' border='0' />
<?php } else { ?>
	<img src='<?php echo base_url()?>theme_files/images/frm_linevrlt.gif' border='0' />
<?php } ?>
<a class="leftBarText" target ="_self" href="<?php echo base_url()?>index.php/auth/changepassword">Change Password</a></td>
</tr>


</table>
</div>



<?php
if($this->uri->segment(1)=="user" ){
	$show_p_n_img = base_url().'theme_files/images/neg_new.gif';
	$mnu_dis_div = '';
}else{
	$show_p_n_img = base_url().'theme_files/images/plus_new.gif';
	$mnu_dis_div = 'style="display:none;"';
}
?>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
<tr class="thead">
<td align="left"><a id="xuser" href="javascript:Toggle('user','<?php echo base_url()?>theme_files/images/');"> <img src='<?php echo $show_p_n_img?>' width='11' height='11' hspace='0' vspace='0' border='0' /></a><a class="leftBar" id="xuser" href="javascript:Toggle('user','<?php echo base_url()?>theme_files/images/');">&nbsp;Manage User</a></td>
</tr>
</table>
<div id="user" <?php echo $mnu_dis_div?> >
<table width="100%" border="0" cellspacing="1" cellpadding="3">

<tr>
<td align="left" class="alt2"><img src='<?php echo base_url()?>theme_files/images/spacer.gif' width="8" height="8" />&nbsp;&nbsp;
<?php if($this->uri->segment(2)=="listing" || $this->uri->segment(2)=="addedit_user") { ?>
	<img src='<?php echo base_url()?>theme_files/images/dot_yellowh.gif' border='0' />
<?php } else { ?>
	<img src='<?php echo base_url()?>theme_files/images/frm_linevrlt.gif' border='0' />
<?php } ?>
<a class="leftBarText" target ="_self" href="<?php echo ADMIN_BASE_URL?>user/listing/">&nbsp;Retailer </a></td>
</tr>

</table>
</div>




<?php
if($this->uri->segment(1)=="catalog" ){
	$show_p_n_img = base_url().'theme_files/images/neg_new.gif';
	$mnu_dis_div = '';
}else{
	$show_p_n_img = base_url().'theme_files/images/plus_new.gif';
	$mnu_dis_div = 'style="display:none;"';
}
?>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
<tr class="thead">
<td align="left"><a id="xproject" href="javascript:Toggle('project','<?php echo base_url()?>theme_files/images/');"> <img src='<?php echo $show_p_n_img?>' width='11' height='11' hspace='0' vspace='0' border='0' /></a><a class="leftBar" id="xproject" href="javascript:Toggle('project','<?php echo base_url()?>theme_files/images/');">&nbsp;Catalog</a></td>
</tr>
</table>
<div id="project" <?php echo $mnu_dis_div?> >
<table width="100%" border="0" cellspacing="1" cellpadding="3">

<tr>
<td align="left" class="alt2"><img src='<?php echo base_url()?>theme_files/images/spacer.gif' width="8" height="8" />&nbsp;&nbsp;
<?php if($this->uri->segment(2)=="category" || $this->uri->segment(2)=="addedit_category") { ?>
	<img src='<?php echo base_url()?>theme_files/images/dot_yellowh.gif' border='0' />
<?php } else { ?>
	<img src='<?php echo base_url()?>theme_files/images/frm_linevrlt.gif' border='0' />
<?php } ?>
<a class="leftBarText" target ="_self" href="<?php echo ADMIN_BASE_URL?>catalog/category/">&nbsp;Category </a></td>
</tr>

<tr>
<td align="left" class="alt2"><img src='<?php echo base_url()?>theme_files/images/spacer.gif' width="8" height="8" />&nbsp;&nbsp;
<?php if($this->uri->segment(2)=="atricolor" || $this->uri->segment(2)=="addedit_atricolor") { ?>
	<img src='<?php echo base_url()?>theme_files/images/dot_yellowh.gif' border='0' />
<?php } else { ?>
	<img src='<?php echo base_url()?>theme_files/images/frm_linevrlt.gif' border='0' />
<?php } ?>
<a class="leftBarText" target ="_self" href="<?php echo ADMIN_BASE_URL?>catalog/atricolor/">&nbsp;Atribute Size </a></td>
</tr>

<tr>
<td align="left" class="alt2"><img src='<?php echo base_url()?>theme_files/images/spacer.gif' width="8" height="8" />&nbsp;&nbsp;
<?php if($this->uri->segment(2)=="addedit_product" || $this->uri->segment(2)=="projectlist" ) { ?>
	<img src='<?php echo base_url()?>theme_files/images/dot_yellowh.gif' border='0' />
<?php } else { ?>
	<img src='<?php echo base_url()?>theme_files/images/frm_linevrlt.gif' border='0' />
<?php } ?>
<a class="leftBarText" target ="_self" href="<?php echo ADMIN_BASE_URL?>catalog/projectlist/">&nbsp;Product </a></td>
</tr>

</table>
</div>

<?php
if($this->uri->segment(1)=="cart" ){
	$show_p_n_img = base_url().'theme_files/images/neg_new.gif';
	$mnu_dis_div = '';
}else{
	$show_p_n_img = base_url().'theme_files/images/plus_new.gif';
	$mnu_dis_div = 'style="display:none;"';
}
?>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
<tr class="thead">
<td align="left"><a id="xcart" href="javascript:Toggle('cart','<?php echo base_url()?>theme_files/images/');"> <img src='<?php echo $show_p_n_img?>' width='11' height='11' hspace='0' vspace='0' border='0' /></a><a class="leftBar" id="xcart" href="javascript:Toggle('cart','<?php echo base_url()?>theme_files/images/');">&nbsp;Manage Order</a></td>
</tr>
</table>
<div id="cart" <?php echo $mnu_dis_div?> >
<table width="100%" border="0" cellspacing="1" cellpadding="3">

<tr>
<td align="left" class="alt2"><img src='<?php echo base_url()?>theme_files/images/spacer.gif' width="8" height="8" />&nbsp;&nbsp;
<?php if($this->uri->segment(1)=="cart" && ($this->uri->segment(2)=="" || $this->uri->segment(2)=="index")) { ?>
	<img src='<?php echo base_url()?>theme_files/images/dot_yellowh.gif' border='0' />
<?php } else { ?>
	<img src='<?php echo base_url()?>theme_files/images/frm_linevrlt.gif' border='0' />
<?php } ?>
<a class="leftBarText" target ="_self" href="<?php echo ADMIN_BASE_URL?>cart/index/">&nbsp;Order </a></td>
</tr>



</table>
</div>


<td colspan="2"><img src='<?php echo base_url()?>theme_files/images/spacer.gif' width="5" height="10" /></td>
</tr>
</table>
<?php */?>



<!--Left Navigation -->
        <div class="grid_2">
            <div class="box sidemenu">
                <div class="block" id="section-menu">
                    <ul class="section menu">
					
					 <li><a class="menuitem">Dashboard</a></li>
					
					
                        <li><a class="menuitem">Master Section</a>
                            <ul class="submenu">
                              <?php /*?>  <li><a target ="_self" href="<?php echo ADMIN_BASE_URL?>
								project_controller/productlisting/">Example</a> </li><?php */?>
								
							<?php /*?>	  <li><a target ="_self" href="<?php echo ADMIN_BASE_URL?>
								product/datatable_demo/">Example</a> </li><?php */?>
							   
							    <li><a target ="_self" href="<?php echo ADMIN_BASE_URL?>
								project_controller/destination_listing/">Destination</a> 
								</li>
								
								 <li><a target ="_self" href="<?php echo ADMIN_BASE_URL?>
								project_controller/party_listing/">Party</a> </li>
								
								 <li><a target ="_self" href="<?php echo ADMIN_BASE_URL?>
								project_controller/mst_rcvexp_listing/">Receive/Expense</a> </li>
								<li><a target ="_self" href="<?php echo ADMIN_BASE_URL?>
								project_controller/mst_goods_listing/">Goods</a> </li>
								<li><a target ="_self" href="<?php echo ADMIN_BASE_URL?>
								project_controller/mst_lorry_listing/">Lorry</a> </li>
								
                            </ul>
                        </li>
                        <li><a class="menuitem">Transaction</a>
                            <ul class="submenu">
                               
							    <li><a target ="_self" href="<?php echo ADMIN_BASE_URL?>
								project_controller/destination_listing/">Builty Entry</a> </li>
								
								<li><a target ="_self" href="<?php echo ADMIN_BASE_URL?>
								project_controller/destination_listing/">Challan Create</a> </li>
								
								<li><a target ="_self" href="<?php echo ADMIN_BASE_URL?>
								project_controller/destination_listing/">Update Builty</a> </li>
								
                            </ul>
                        </li>
                        
						<li><a class="menuitem">Receive/Expense</a>
                            <ul class="submenu">
                               <li><a target ="_self" href="<?php echo ADMIN_BASE_URL?>
								project_controller/trn_rcvexp_listing/">Receive Entry</a> </li>
								
								<li><a target ="_self" href="<?php echo ADMIN_BASE_URL?>
								project_controller/trn_rcvexp_listing/">Expense Entry</a> </li>
								
								<li><a target ="_self" href="<?php echo ADMIN_BASE_URL?>
								project_controller/trn_rcvexp_listing/">Lorry Maintainance (Expense) </a>
								</li>
								
                            </ul>
                        </li>
						
						<li><a class="menuitem">Reports</a>
                            <ul class="submenu">
                                
								<li><a target ="_self" href="<?php echo ADMIN_BASE_URL?>
								project_controller/destination_listing/">Date Wise Builty</a>
								</li>
								
								<li><a target ="_self" href="<?php echo ADMIN_BASE_URL?>
								project_controller/destination_listing/">Date wise Challan</a>
								</li>
								
								<li><a target ="_self" href="<?php echo ADMIN_BASE_URL?>
								project_controller/destination_listing/">Receive Details</a>
								</li>
								
								
								<li><a target ="_self" href="<?php echo ADMIN_BASE_URL?>
								project_controller/destination_listing/">Expense Details</a>
								</li>
								
								<li><a target ="_self" href="<?php echo ADMIN_BASE_URL?>
								project_controller/destination_listing/">Receive/Expense Statement</a>
								</li>
								
								<li><a target ="_self" href="<?php echo ADMIN_BASE_URL?>
								project_controller/destination_listing/">Lorry Maintainance Report</a>
								</li>
								
								
                            </ul>
                        </li>
						
						<li><a class="menuitem">User Management</a>
                            <ul class="submenu">
                               <li><a target ="_self" href="<?php echo ADMIN_BASE_URL?>
								project_controller/destination_listing/">User Setting</a>
								</li>
								
								<li><a target ="_self" href="<?php echo ADMIN_BASE_URL?>
								project_controller/destination_listing/">Privilege  Setting</a>
								</li>
								
								<li><a target ="_self" href="<?php echo ADMIN_BASE_URL?>
								project_controller/destination_listing/">Change Password </a>
								</li>
								
								
                            </ul>
                        </li>
						
                       
                    </ul>
                </div>
            </div>
        </div>
		
<!--Left Navigation End-->