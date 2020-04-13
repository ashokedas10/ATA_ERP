<form onsubmit="return changepassword_validation()" method="post" action="<?php echo ADMIN_BASE_URL?>project_controller/changepassword_act" name="frm_changpass"> 
		  <p>
		   <input type="hidden" value="changepass" name="act">
            <input type="hidden" value="1" name="id">
          </p>
         <span class="validation_style">
		 <?php echo validation_errors(); ?>
		 <?php echo $msg; ?>
		 </span>
          <table width="662" class="srstable"> 
            <thead> 
              <tr> 
                <td height="21" colspan="2" align="left" class="tcat">Change Password </td> 
              </tr> 
            </thead> 
            <tbody> 
             
              <tr class="alt1"> 
                <td class="srscell-head-lft">User Name</td> 
                <td class="srscell-body">
				<?php echo $this->session->userdata('login_userid') ?></td> 
              </tr> 
              <tr class="alt2"> 
                <td class="srscell-head-lft"> Old Password <font color="#FF0000">*</font></td> 
                <td class="srscell-body"><input type="password" id="pass1" class="srs-txt" name="pass1"></td> 
              </tr> 
              <tr class="alt1"> 
                <td class="srscell-head-lft">New Password <font color="#FF0000">*</font></td> 
                <td class="srscell-body"><input type="password" id="pass2" class="srs-txt"  name="pass2"></td> 
              </tr> 
              <tr class="alt1">
                <td class="srscell-head-lft">Confirm Password <font color="#FF0000">*</font></td>
                <td class="srscell-body"><input type="password" id="pass3" class="srs-txt"  name="pass3"></td>
              </tr>
              <tr > 
               
                <td colspan="2" align="center"><input type="submit" value="Submit" class="btn btn-green" name="Submit">
                  &nbsp; 
               <?php /*?> <input type="reset" class="btn btn-green" id="Reset" name="Reset"><?php */?></td></tr> 
				
            </tbody> 
          </table> 
      </form>