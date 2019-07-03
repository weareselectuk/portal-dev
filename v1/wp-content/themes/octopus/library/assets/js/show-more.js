;(function($){
var load = 'more';

$("#load-more").on('click',function (e) {
    // show the next hidden div.group, then disable load more once all divs have been displayed
    
    
    // if we are loading more
    if (load == 'more') {
        
        // get the amount of hidden groups
        var groups = $('.group:not(:visible)');
        
        // if there are some available
        if (groups.length > 0) {
            // show the first
            groups.first().show();
            
            // if that was the last group then set to load less
            if (groups.length == 1) {
                switchLoadTo('less');
            }
        }
    // we are loading less
    } else {
        // get the groups which are currently visible
        var groups = $('.group:visible');
        
        // if there is more than 1 (as we dont want to hide the initial group)
        if (groups.length > 1) {
            
            // hide the last avaiable
            groups.last().hide();
            // if that was the only group available, set to load more
            if (groups.length == 2) {
                switchLoadTo('more');
            }
        }
    }
});

function switchLoadTo(dir) {
    load = dir;
    $("#load-more").html('Load ' + dir);
}
})(jQuery);