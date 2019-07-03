<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<tr>
  <td class="col_1">
    <?php $checked = in_array('compsupervisor', $recipients) ? 'checked="checked"' : '';?>
    <input type="checkbox" <?php echo $checked;?> name="wpsp_en_notification[recipients][]" value="compsupervisor">
  </td>
  <td class="col_2"><?php _e('Company Supervisor', 'wpsp-company');?></td>
</tr>
<tr>
  <td class="col_1">
    <?php $checked = in_array('compmembers', $recipients) ? 'checked="checked"' : '';?>
    <input type="checkbox" <?php echo $checked;?> name="wpsp_en_notification[recipients][]" value="compmembers">
  </td>
  <td class="col_2"><?php _e('Company Members', 'wpsp-company');?></td>
</tr>
