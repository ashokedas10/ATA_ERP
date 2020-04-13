	<form id="frm" name="frm" method="post" action="<?php echo ADMIN_BASE_URL?>user/addedit_user">
        <p>
		  <input type="hidden" value="<?php echo $id; ?>" name="id">
      </p>
	    <table width="95%" cellspacing="1" cellpadding="6" class="tborder">
          <thead>
            <tr>
              <td align="left" colspan="2" class="tcat">User Section </td>
            </tr>
          </thead>
          <tbody>
            <tr class="alt1">
              <td align="left" class="alt1" colspan="2">			  </td>
            </tr>
            <tr class="alt2">
              <td align="left" class="redbuttonelements" colspan="2" onclick="window.location = '<?php echo ADMIN_BASE_URL?>user/addedit_user/<?php echo $id; ?>/'">
			  	<?php echo validation_errors(); ?>
		 		<?php echo $msg; ?>		
				</td>
            </tr>
			
			<tr class="alt2">
              <td width="18%" valign="top" align="left" class="leftBarText"> Username </td>
              <td width="82%" align="left">
			  <?php
			  
			  if($id > 0){
			  	echo $row->user_name;
			  ?>
			 	<input type="hidden" id="user_name" class="forminputelement" value="<?php echo $row->user_name; ?>" name="user_name">
			 <?php 
			 }else{
			 ?>
			  	<input type="text" id="user_name" class="forminputelement" value="<?php echo $row->user_name; ?>" name="user_name">		  
			 <?php } ?>
			 		  
			  </td>
            </tr>
			
			<tr class="alt2">
              <td width="18%" valign="top" align="left" class="leftBarText">Password </td>
              <td width="82%" align="left">
			  <input type="password" id="user_pass" class="forminputelement" value="" name="user_pass">	  
			  </td>
            </tr>
			
			<tr class="alt2">
              <td width="18%" valign="top" align="left" class="leftBarText">Name </td>
              <td width="82%" align="left">
			  <input type="text" id="name" class="forminputelement" value="<?php echo $row->name; ?>" name="name">	  
			  </td>
            </tr>
			
			<tr class="alt2">
              <td width="18%" valign="top" align="left" class="leftBarText">Email</td>
              <td width="82%" align="left">
			  <input type="text" id="email" class="forminputelement" value="<?php echo $row->email; ?>" name="email">	  
			  </td>
            </tr>
			
			<tr class="alt2">
              <td width="18%" valign="top" align="left" class="leftBarText">Contact</td>
              <td width="82%" align="left">
			  <input type="text" id="contact" class="forminputelement" value="<?php echo $row->contact; ?>" name="contact">	  
			  </td>
            </tr>
			
			<tr class="alt2">
              <td width="18%" valign="top" align="left" class="leftBarText">Status</td>
              <td width="82%" align="left">
			    <label><input name="status" type="radio" value="A" <?php echo ($row->status=='A')?'checked="checked"':''; ?> /> Active</label>
				<label><input name="status" type="radio" value="I" checked="checked" <?php echo ($row->status=='I')?'checked="checked"':''; ?> /> 
				Inactive</label>
				</td>
            </tr>
			<tr class="alt1">
              <td valign="top" align="center" colspan="2" class="leftBarText"> <a href="<?php echo ADMIN_BASE_URL;?>user/listing/">&lt;&lt;back</a>&nbsp;&nbsp;&nbsp; 
			  <input type="submit" class="greenbuttonelements" value="Save" id="Save" name="Save"> </td>
            </tr>
          </tbody>
        </table>
</form>
