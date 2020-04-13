<table width="100%" cellspacing="1" cellpadding="6" class="tborder">
          <thead>
            <tr>
              <td align="left" colspan="4" class="tcat">User Section </td>
            </tr>
          </thead>
          <tbody>
		  	<tr class="alt2">
			   <td align="left" class="media1" colspan="7">
			   <a href="<?php echo $project_addedit; ?>">Add User</a>
			   </td>
		    </tr>
			<tr class="alt2">
			   <td align="left" class="redbuttonelements" onclick="window.location = '<?php echo ADMIN_BASE_URL.$this->uri->segment(1).'/'.$this->uri->segment(2)?>'" colspan="7">
			   <?php echo $msg; ?>			   </td>
		    </tr>
			<tr class="alt1">
              <td width="11%" align="center" class="leftBarText">Sl No </td>
              <td width="67%" align="left" class="leftBarText">User Name  </td>
              <td width="11%" align="center" class="leftBarText">Status</td>
              <td width="11%" align="center" class="leftBarText">Action</td>
            </tr>
		    <?php
			if(count($projectlist) > 0){
			$i = 1;
			foreach ($projectlist as $row){
				$alt = ($i%2==0)?'alt1':'alt2';
			?>
			<tr class="<?php echo $alt;?>">
              <td align="center"><?php echo $i; ?></td>
              <td align="left"><?php echo $row->user_name; ?></td>
              <td align="center"><?php echo ($row->status=='A')?'Active':'Inactive'; ?></td>
              <td align="center">
			  <a href="<?php echo $project_addedit.$row->a_id; ?>"><img width="16" height="16" border="0" alt="View" src="<?php echo base_url()?>theme_files/img/edit.gif"></a>
			 
			  <a onclick="return confirm('Would You Like To Delete This Page ?');" href="<?php echo $project_del.$row->a_id;?>"><img width="16" height="16" border="0" alt="Delete" src="<?php echo base_url()?>theme_files/img/drop.gif"></a>				  </td>
            </tr>
			<?php
			$i++;
			}
			}else{
			?>
			<tr class="alt2">
              <td colspan="4" align="center" class="msg">No Record.	</td>
            </tr>
			<?php } ?>
			
			
			<tr class="alt2">
			  <td align="right" class="media1" colspan="4"><?php echo $this->pagination->create_links();?></td>
		    </tr>
          </tbody>
        </table>
<blockquote>&nbsp;</blockquote>


