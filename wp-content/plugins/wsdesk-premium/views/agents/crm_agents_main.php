<?php
ob_start();
?>
<div class="container" id="main_agent_settings">
    <div class="row">
        <ol class="breadcrumb crm-panel-right set-up-min" style="margin-left: 0 !important;vertical-align: middle;">
            <li class="agent_bread_li" style="vertical-align: middle;margin-top: 5px;"><?php _e("WSDesk Agents", 'wsdesk'); ?></li>
            <button type="button" id="agent_add_button" class="btn btn-primary pull-right"> <span class="glyphicon glyphicon-plus"></span> <?php _e('Add Agent / Supervisor','wsdesk'); ?></button>
        </ol>
        <div class="col-md-12" style="padding-left: 0px !important;">
            <div class="panel panel-default crm-panel">
                <div class="panel-body" style="padding: 5px !important">
                    <div class="alert alert-success" style="display: none;" role="alert">
                        <div id="success_alert_text"></div>
                    </div>
                    <div class="alert alert-warning" style="display: none;" role="alert">
                        <div id="danger_alert_text"></div>
                    </div>
                    <div class="tab-content setup-agent-tab">
                         <div id="add_agents_tab" style="display: none;">
                            <?php echo include(EH_CRM_MAIN_VIEWS."agents/crm_agents_add.php"); ?>
                        </div>
                        <div class="tab-pane active" id="manage_agents_tab">
                            <?php echo include(EH_CRM_MAIN_VIEWS."agents/crm_agents_manage.php"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
return ob_get_clean();