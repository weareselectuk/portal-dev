<?php
if (!defined('ABSPATH')) {
    exit;
}
ob_start();
$pid=$_GET['id'];
$pauthor = urldecode($_GET['wsdesk_author']);
$ticket = eh_crm_get_ticket(array("ticket_id"=>$pid));
?>
<center>
    <div class="satisfaction-div wsdesk_wrapper">
        <?php
            if($ticket)
            {
                $status = eh_crm_get_ticketmeta($ticket[0]['ticket_id'], "ticket_rating");
                if(!$status)
                {
                    if($ticket[0]['ticket_email'] === $pauthor)
                    {
                        $ticket_title = eh_crm_wpml_translations($ticket[0]['ticket_title'], 'ticket_title','ticket_title');
                        echo "<h3>".__('How is our Support?', 'wsdesk')."</h3>";
                        echo "<h4><u>Ticket (#".$pid.") : [ ".$ticket_title." ]</u></h4>";
                        ?>
                        <input type="hidden" id="satisfaction_id" value="<?php echo $pid;?>">
                        <input type="hidden" id="satisfaction_author" value="<?php echo $pauthor;?>">
                        <table class="satisfaction-thumbs">
                            <tr>
                                <td style="width: 50%;text-align: center;">
                                    <div style="margin-right: 10px;">
                                        <input id="satisfaction-good" name="satisfaction-thumb" checked type="radio" class="glyphicon with-font with-good glyphicon-thumbs-up" value="good" />
                                        <label for="satisfaction-good" class="satisfaction-label"><?php _e('Good !', 'wsdesk'); ?></label>
                                    </div>
                                </td>
                                <td style="width: 50%;text-align: center;">
                                    <div style="margin-left: 10px;">
                                        <input id="satisfaction-bad" name="satisfaction-thumb" type="radio" class="glyphicon with-font with-bad glyphicon-thumbs-up" value="bad"/>
                                        <label for="satisfaction-bad" class="satisfaction-label"><?php _e('Bad !', 'wsdesk'); ?></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <textarea rows="5" style="width: 100%" id="satisfaction_comment"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: center">
                                    <button class="btn btn-primary" id="submit_satisfaction" data-loading-text="<?php _e('Submitting...', 'wsdesk'); ?>"><?php _e('Submit', 'wsdesk'); ?></button>
                                </td>
                            </tr>
                        </table>
                        <?php
                    }
                    else
                    {
                        ?>
                        <h1><?php _e('Oops!', 'wsdesk'); ?></h1><h4><?php _e('Unauthorized Access!', 'wsdesk'); ?></h4>
                        <?php
                    }
                }
                else
                {
                    if($ticket[0]['ticket_email'] === $pauthor)
                    {
                        ?>
                        <h1><?php _e('Thank you', 'wsdesk'); ?></h1><p><?php _e('Already took Satisfaction Survey for the ticket', 'wsdesk'); ?>( #<?php echo $pid;?> )</p>
                        <?php
                    }
                    else
                    {
                        ?>
                        <h1><?php _e('Oops!', 'wsdesk'); ?></h1><h4><?php _e('Unauthorized Access!', 'wsdesk'); ?></h4>
                        <?php
                    }
                }
            }
            else
            {
                ?>
                <h1><?php _e('Oops!', 'wsdesk'); ?></h1><h4><?php _e('Access Denied!', 'wsdesk'); ?></h4>
                <?php
            }
        ?>
        <br>
        <?php
        if(!defined('WSDESK_POWERED_SUPPORT'))
        {
            echo '<div class="powered_wsdesk"><span>'.__('Powered by','wsdesk').'</span> <a href="https://elextensions.com/plugin/wsdesk-wordpress-support-desk-plugin/" target="_blank" rel="nofollow">WSDesk</a></div>';
        }
        ?>
    </div>
</center>
<?php
return ob_get_clean();