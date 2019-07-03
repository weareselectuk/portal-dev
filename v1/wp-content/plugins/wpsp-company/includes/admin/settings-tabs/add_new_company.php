<?php
if ( ! defined( 'ABSPATH' ) )
    exit; // Exit if accessed directly
?>
<?php
$section_href='admin.php?page=wp-support-plus&setting=addons&section=company-settings';
?>
<br>

<div id="tab_container" style="clear: both;">

    <div class="wpsp_company_setting_div">

        <form method="post" action="" onsubmit="return validate_create_company_form(this);">

            <input type="hidden" name="action" value="update"/>
            <input type="hidden" name="update_setting" value="wpsp_add_company"/>
            <?php wp_nonce_field('wpbdp_tab_general_section_general'); ?>

            <h3><?php echo __('Add New Company / Usergroup','wpsp-company') ?><a class="backtoconditionlist" href="<?php echo $section_href;?>"> Back To List</a></h3>
            <hr>

            <table class="form-table">

                <tr>
                    <th><?php _e('Name','wpsp-company');?>:</th>
                    <td><input type="text" id="wpsp_company_name" name="wpsp_company_name"></td>
                </tr>

                <tr>
                    <th><?php _e('Add User','wpsp-company');?>:</th>
                    <td>

                        <div class="wpsp-autocomplete-drop-down" id="wpsp-agent" style="float: left;" >
                            <span id="wpsp-agent-label"><?php _e('Select Users','wpsp-company')?></span>
                            <input id="wpsp-agent-id" type="hidden" name="wpsp_agent[agent_id]" />
                            <span style="float: right;" class="dashicons dashicons-arrow-down-alt2"></span>
                        </div>

                        <div class="wpsp-autocomplete-drop-down-panel" style="float: left;">
                            <input style="margin: 0;width: 100%;padding: 8px;" onkeyup="wpsp_search_keypress(event,this);" type="text" id="wpsp-autocomplete-search" placeholder="<?php _e('Search Agents...','wpsp-company')?>" autocomplete="off" />
                            <div id="wpsp-autocomplete-search-results"></div>
                        </div>
                        
                        <button id="wpsp_add_agent" class="page-title-action" style="margin: 15px 15px;" onclick="wpsp_add_user_tbl(event)"><?php _e('Add User','wpsp-company')?></button>
                    </td>
                </tr>

                <tr>
                    <th><?php _e('Company / Usergroup Users','wpsp-company');?>:</th>
                    <td>
                        <table id="wpsp_company_selected_users">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Supervisor</th>
                                    <th style="width: 50px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </td>
                </tr>

            </table>

            <p class="submit">
                <input id="submit" class="button button-primary" name="submit" value="<?php _e('Save Changes', 'wpsp-company'); ?>" type="submit">
            </p>

        </form>
    </div>
</div>

<script>
    jQuery(document).ready(function(){

        wpspjq('.wpsp-autocomplete-drop-down-panel').hide();

        wpspjq('#wpsp_agent_frm').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
              e.preventDefault();
              return false;
            }
        });

        wpspjq('#wpsp-agent').click(function(){
            wpspjq('#wpsp-agent-id').val('');
            wpspjq('#wpsp-autocomplete-search').val('');
            wpspjq('.wpsp-autocomplete-drop-down-panel').toggle();
            wpspjq('#wpsp-autocomplete-search').focus();
            wpsp_search_users_for_add_agent();
        });

        wpspjq('[name="wpsp_agent[agent_id]"]').val("");

        wpspjq(document).on('click', '.delete-row', function () {
            wpspjq(this).closest("tr").remove();

        });

    });

    function wpsp_aut_item_select(obj){

        wpspjq('.wpsp-autocomplete-result-item').removeClass('wpsp-autocomplete-result-item-selected');
        wpspjq(obj).addClass('wpsp-autocomplete-result-item-selected');
    }

    function wpsp_aut_choose_item(obj){

        var agent_id    = parseInt(wpspjq(obj).attr('id'));
        var agent_name  = wpspjq(obj).text();
        wpspjq('#wpsp-agent-id').val(agent_id);
        wpspjq('#wpsp-agent-label').text(agent_name);
        wpspjq('.wpsp-autocomplete-drop-down-panel').hide();
    }

    function wpsp_search_keypress(evt,t){

        if( evt.keyCode == 40 ){
            if(wpspjq('.wpsp-autocomplete-result-item-selected').next().is('.wpsp-autocomplete-result-item')){
                wpsp_aut_item_select(wpspjq('.wpsp-autocomplete-result-item-selected').next());
            }
            return;
        }

        if( evt.keyCode == 38 ){
            if(wpspjq('.wpsp-autocomplete-result-item-selected').prev().is('.wpsp-autocomplete-result-item')){
                wpsp_aut_item_select(wpspjq('.wpsp-autocomplete-result-item-selected').prev());
            }
            return;
        }

        if( evt.keyCode == 13 ){
            wpsp_aut_choose_item( wpspjq('.wpsp-autocomplete-result-item-selected') );
            return;
        }

        wpsp_search_users_for_add_agent(t.value);

    }

    function wpsp_search_users_for_add_agent( s = '' ){

        var data = {
            'action': 'search_users_for_company',
            's': s,
            'nonce' : wpspjq('input[name="nonce"]').val()
        };

        wpspjq.post(wpsp_company_data.wpsp_ajax_url, data, function(response) {
            wpspjq('#wpsp-autocomplete-search-results').html(response);
        });
    }

    function wpsp_add_user_tbl(e){

        select_user_id=wpspjq('[name="wpsp_agent[agent_id]"]').val();

        if(select_user_id!=""){
            var select_user_array=new Array();
            wpspjq('#wpsp_company_selected_users tbody tr').find('input[name="cuserid[]"]').each(function (){
                select_user_array.push(wpspjq(this).val());
            });

            if( !(wpspjq.inArray(select_user_id,select_user_array) > -1)){
                select_user_name=wpspjq('#wpsp-agent-label').html();
                var markup = "<tr><td>" + select_user_name + "</td><td><input type='checkbox' name='csupervisor[]' value='"+select_user_id+"'>"+
                                "<input type='hidden' name='cuserid[]' value='"+select_user_id+"'/> </td>"+
                        "<td><span class='delete-row'>Remove</span></td> </tr>";
                wpspjq("#wpsp_company_selected_users tbody").append(markup);
            }
        }else{
            alert(wpsp_company_data.insert_user);
        }
        e.preventDefault();
    }

    function validate_create_company_form(obj){

        var error_flag = true;

        if(wpspjq.trim(wpspjq('#wpsp_company_name').val())==""){
            alert(wpsp_company_data.insert_name);
            error_flag=false;
        }

        var rows= wpspjq('#wpsp_company_selected_users tbody tr').length;
        if(error_flag && rows==0){
            alert(wpsp_company_data.at_least_one_user);
            error_flag=false;
        }

        var supervisor= wpspjq('#wpsp_company_selected_users tbody tr').find('input[name="csupervisor[]"]:checked').length;
        if(error_flag && supervisor==0){
            alert(wpsp_company_data.at_least_one_supervisor);
            error_flag=false;
        }

        return error_flag;
    }
</script>

<style>
    .wpsp-autocomplete-drop-down{
        background: #f5f5f5 linear-gradient(to top, #f5f5f5, #fafafa) repeat scroll 0 0;
        border-color: #dfdfdf;
        border-style: solid;
        border-width: 1px;
        clear: both;
        margin: 5px 0 0 0;
        padding: 10px;
        cursor: pointer;
        width: 310px;
    }
    .wpsp-autocomplete-drop-down-panel{
        border-color: #dfdfdf;
        border-style: solid;
        border-width: 1px;
        clear: both;
        padding: 10px;
        width: 310px;
    }
    #wpsp-autocomplete-search-results{
        border-color: #dfdfdf;
        border-style: solid;
        border-width: 1px;
    }
    .wpsp-autocomplete-result-item{
        padding: 5px;
        margin: 0;
        cursor: pointer;
    }
    .wpsp-autocomplete-result-item-selected{
        background-color: #0073aa;
        color: #fff;
    }
    #wpsp_company_name{
        width: 330px;
        font-size: 14px;
    }
    #wpsp_company_selected_users{border: 1px solid #cebcbc; border-collapse: collapse;}
    #wpsp_company_selected_users th{border: 1px solid #cebcbc;padding: 5px;}
    #wpsp_company_selected_users td{border: 1px solid #cebcbc;padding: 5px;}
    .delete-row{color: #eb572e; cursor: pointer;}
</style>
