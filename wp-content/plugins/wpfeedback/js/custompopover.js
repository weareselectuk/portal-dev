var clone,wpf_bootstrap_version,wpf_popover_template;
jQuery(document).ready(function () {
    /*======Start check bootstrap version code=====*/
    function getBootstrapVersion() {
      var deferred = jQuery.Deferred();
      var script = jQuery('script[src*="bootstrap"]');
      if (script.length == 0) {
        return deferred.reject();
      }
      var src = script.attr('src');
      jQuery.get(src).done(function(response) {
        var matches = response.match(/(?!v)([.\d]+[.\d])/);
        if (matches && matches.length > 0) {
          version = matches[0];
          deferred.resolve(version);
        }
      });
      return deferred;
    };
    /*======End check bootstrap version code=====*/

    getBootstrapVersion().done(function(version) {
        //var wpf_bootstrap_version_tmp=jQuery.fn.tooltip.Constructor.VERSION;
        wpf_bootstrap_version_tmp = version
        var wpf_bootstrap_version_arr = wpf_bootstrap_version_tmp.split('.');
        wpf_bootstrap_version = wpf_bootstrap_version_arr[0];
        if(wpf_bootstrap_version==3){
            wpf_popover_template = '<div class="popover wpf_comment_container" role="tooltip"><div class="arrow wpf_arrow"></div><h3 class="popover-header"></h3><div class="popover-content"></div></div>';
        }
        else{
            wpf_popover_template = '<div class="popover wpf_comment_container" role="tooltip"><div class="arrow wpf_arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>';
        }
        jQuery('#wpadminbar').attr("data-html2canvas-ignore", "true");
        init_popover();
    });
});

function init_popover() {
    jQuery('[rel="popover"]').popover({
        html: true,
        trigger: 'click',
        // title: "PopOver with TABS",
        // template: '<div class="popover wpf_comment_container" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-content"></div></div>',
        template: wpf_popover_template,
        content: function () {
            if (jQuery(jQuery(this).data('popover-content')).clone(true).hasClass('hide')) {
                clone = jQuery(jQuery(this).data('popover-content')).clone(true).removeClass('hide');
            }
            $clone = jQuery('#popoverContent').remove().html();
            return clone;
        }
    });

    jQuery('.nav-tabs a').click(function (e) {
        e.preventDefault();
        jQuery(this).tab('show');
        return false;
    });
    jQuery('.nav-tabs a').on('touchstart', function (e) {
        e.preventDefault();
        jQuery(this).tab('show');
        return false;
    });
    jQuery('[data-toggle="popover"]').on('inserted.bs.popover', function () {
        jQuery('.popover').attr("data-html2canvas-ignore", "true");
    });
}

function init_custom_popover(id) {
    var clone;
    var clone1;
    jQuery('[rel="popover-' + id + '"]').popover({
        html: true,
        trigger: 'click',
        placement: 'auto',
        // title: "PopOver with TABS",
        // template: '<div class="popover wpf_comment_container" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-content"></div></div>',
        template: wpf_popover_template,
        content: function () {
            if (jQuery(jQuery(this).data('popover-content')).clone(true).hasClass('hide')) {
                clone1 = jQuery(jQuery(this).data('popover-content')).clone(true).removeClass('hide');
            }
            $clone1 = jQuery('#popover-content-c' + id).remove().html();
            return clone1;
        }
    });
    jQuery('[rel="popover-' + id + '"]').popover('show');
    jQuery('.nav-tabs a').click(function (e) {
        e.preventDefault();
        jQuery(this).tab('show');
        return false;
    });
    jQuery('.nav-tabs a').on('touchstart', function (e) {
        e.preventDefault();
        jQuery(this).tab('show');
        return false;
    });
    jQuery('.close').click(function (e) {
        jQuery(this).parents('.popover').popover('hide');
    });
    jQuery('[data-toggle="popover"]').on('inserted.bs.popover', function () {
        jQuery('.popover').attr("data-html2canvas-ignore", "true");
    });
    jQuery('#wpfbscreenshot-tab-' + id).click(function (e) {
        jQuery(this).parents('.popover').attr("data-html2canvas-ignore", "true");
    });
    jQuery('.wpf_task_temp_delete_btn').click(function(){
        var btn_taskid = jQuery(this).data('btn_elemid');
        jQuery('.wpfbsysinfo_temp_delete_task_id_'+btn_taskid).show();
    });
    jQuery('.wpf_task_temp_delete').click(function(){
        var elemid = jQuery(this).data('elemid');
        jQuery('#popover-content-c'+elemid+' .close').trigger('click');
        jQuery('#bubble-'+elemid).remove();
        comment_count--;
    });
    jQuery(document).find("#wpf_delete_container_"+id).on("click",".wpf_task_delete_btn",function(e) {
        var btn_elemid = jQuery(this).data('btn_elemid');
        jQuery('.wpfbsysinfo_delete_task_id_'+btn_elemid).show();
    });
    jQuery(document).find("#wpf_delete_container_"+id).on("click",".wpf_task_delete",function(e) {
        var elemid = jQuery(this).data('elemid');
        var task_id = jQuery(this).data('taskid');
        wpf_delete_task(elemid,task_id);
        jQuery('#popover-content-c'+elemid+' .close').trigger('click');
        jQuery('#bubble-'+elemid).remove();
        comment_count--;
    });
    jQuery("#wpf_uploadfile_"+id).change(function () {
        wpf_upload_file(this);
    });
    jQuery('.wpf_task_uploaded_image').on('click',function(){
        var redirectWindow = window.open(jQuery(this).attr("src"), '_blank');
        redirectWindow.location;
    });
}

function init_custom_popover_first(id) {
    var clone;
    var clone1;
    jQuery('[rel="popover-' + id + '"]').popover({
        html: true,
        trigger: 'click',
        placement: 'auto',
        template: wpf_popover_template,
        content: function () {
            if (jQuery(jQuery(this).data('popover-content')).clone(true).hasClass('hide')) {
                clone1 = jQuery(jQuery(this).data('popover-content')).clone(true).removeClass('hide');
            }
            $clone1 = jQuery('#popover-content-c' + id).remove().html();
            return clone1;
        }
    });
    jQuery('.nav-tabs a').click(function (e) {
        e.preventDefault();
        jQuery(this).tab('show');
        return false;
    });
    jQuery('.nav-tabs a').on('touchstart', function (e) {
        e.preventDefault();
        jQuery(this).tab('show');
        return false;
    });
    jQuery('[data-toggle="popover"]').on('inserted.bs.popover', function () {
        jQuery('.popover').attr("data-html2canvas-ignore", "true");
        jQuery('#task_comments_' + id).animate({scrollTop: jQuery('#task_comments_' + id).prop("scrollHeight")}, 2000);

    });
    jQuery("#wpf_uploadfile_"+id).change(function () {
        wpf_upload_file(this);
    });
    jQuery('.wpf_task_uploaded_image').on('click',function(){
        var redirectWindow = window.open(jQuery(this).attr("src"), '_blank');
        redirectWindow.location;
    });
}