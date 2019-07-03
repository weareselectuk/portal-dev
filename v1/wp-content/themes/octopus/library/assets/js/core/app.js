/* ------------------------------------------------------------------------------
*
*  # Template JS core
*
*  Core JS file with default functionality configuration
*
*  Version: 1.3
*  Latest update: Aug 10, 2016
*
* ---------------------------------------------------------------------------- */


// Allow CSS transitions when page is loaded
jQuery(window).on('load', function() {
    jQuery('body').removeClass('no-transitions');
});


jQuery(function() {

    // Disable CSS transitions on page load
    jQuery('body').addClass('no-transitions');



    // ========================================
    //
    // Content area height
    //
    // ========================================


    // Calculate min height
    function containerHeight() {
        var availableHeight = jQuery(window).height() - jQuery('.page-container').offset().top - jQuery('.navbar-fixed-bottom').outerHeight();

        jQuery('.page-container').attr('style', 'min-height:' + availableHeight + 'px');
    }

    // Initialize
    containerHeight();




    // ========================================
    //
    // Heading elements
    //
    // ========================================


    // Heading elements toggler
    // -------------------------

    // Add control button toggler to page and panel headers if have heading elements
    jQuery('.panel-footer').has('> .heading-elements:not(.not-collapsible)').prepend('<a class="heading-elements-toggle"><i class="icon-more"></i></a>');
    jQuery('.page-title, .panel-title').parent().has('> .heading-elements:not(.not-collapsible)').children('.page-title, .panel-title').append('<a class="heading-elements-toggle"><i class="icon-more"></i></a>');


    // Toggle visible state of heading elements
    jQuery('.page-title .heading-elements-toggle, .panel-title .heading-elements-toggle').on('click', function() {
        jQuery(this).parent().parent().toggleClass('has-visible-elements').children('.heading-elements').toggleClass('visible-elements');
    });
    jQuery('.panel-footer .heading-elements-toggle').on('click', function() {
        jQuery(this).parent().toggleClass('has-visible-elements').children('.heading-elements').toggleClass('visible-elements');
    });



    // Breadcrumb elements toggler
    // -------------------------

    // Add control button toggler to breadcrumbs if has elements
    jQuery('.breadcrumb-line').has('.breadcrumb-elements').prepend('<a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>');


    // Toggle visible state of breadcrumb elements
    jQuery('.breadcrumb-elements-toggle').on('click', function() {
        jQuery(this).parent().children('.breadcrumb-elements').toggleClass('visible-elements');
    });




    // ========================================
    //
    // Navbar
    //
    // ========================================


    // Navbar navigation
    // -------------------------

    // Prevent dropdown from closing on click
    jQuery(document).on('click', '.dropdown-content', function (e) {
        e.stopPropagation();
    });

    // Disabled links
    jQuery('.navbar-nav .disabled a').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
    });

    // Show tabs inside dropdowns
    jQuery('.dropdown-content a[data-toggle="tab"]').on('click', function (e) {
        jQuery(this).tab('show');
    });




    // ========================================
    //
    // Element controls
    //
    // ========================================


    // Reload elements
    // -------------------------

    // Panels
    jQuery('.panel [data-action=reload]').click(function (e) {
        e.preventDefault();
        var block = jQuery(this).parent().parent().parent().parent().parent();
        jQuery(block).block({ 
            message: '<i class="icon-spinner2 spinner"></i>',
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.8,
                cursor: 'wait',
                'box-shadow': '0 0 0 1px #ddd'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'none'
            }
        });

        // For demo purposes
        window.setTimeout(function () {
           jQuery(block).unblock();
        }, 2000); 
    });


    // Sidebar categories
    jQuery('.category-title [data-action=reload]').click(function (e) {
        e.preventDefault();
        var block = jQuery(this).parent().parent().parent().parent();
        jQuery(block).block({ 
            message: '<i class="icon-spinner2 spinner"></i>',
            overlayCSS: {
                backgroundColor: '#000',
                opacity: 0.5,
                cursor: 'wait',
                'box-shadow': '0 0 0 1px #000'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'none',
                color: '#fff'
            }
        });

        // For demo purposes
        window.setTimeout(function () {
           jQuery(block).unblock();
        }, 2000); 
    }); 


    // Light sidebar categories
    jQuery('.sidebar-default .category-title [data-action=reload]').click(function (e) {
        e.preventDefault();
        var block = jQuery(this).parent().parent().parent().parent();
        jQuery(block).block({ 
            message: '<i class="icon-spinner2 spinner"></i>',
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.8,
                cursor: 'wait',
                'box-shadow': '0 0 0 1px #ddd'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'none'
            }
        });

        // For demo purposes
        window.setTimeout(function () {
           jQuery(block).unblock();
        }, 2000); 
    }); 



    // Collapse elements
    // -------------------------

    //
    // Sidebar categories
    //

    // Hide if collapsed by default
    jQuery('.category-collapsed').children('.category-content').hide();


    // Rotate icon if collapsed by default
    jQuery('.category-collapsed').find('[data-action=collapse]').addClass('rotate-180');


    // Collapse on click
    jQuery('.category-title [data-action=collapse]').click(function (e) {
        e.preventDefault();
        var $categoryCollapse = jQuery(this).parent().parent().parent().nextAll();
        jQuery(this).parents('.category-title').toggleClass('category-collapsed');
        jQuery(this).toggleClass('rotate-180');

        containerHeight(); // adjust page height

        $categoryCollapse.slideToggle(150);
    });


    //
    // Panels
    //

    // Hide if collapsed by default
    jQuery('.panel-collapsed').children('.panel-heading').nextAll().hide();


    // Rotate icon if collapsed by default
    jQuery('.panel-collapsed').find('[data-action=collapse]').addClass('rotate-180');


    // Collapse on click
    jQuery('.panel [data-action=collapse]').click(function (e) {
        e.preventDefault();
        var $panelCollapse = jQuery(this).parent().parent().parent().parent().nextAll();
        jQuery(this).parents('.panel').toggleClass('panel-collapsed');
        jQuery(this).toggleClass('rotate-180');

        containerHeight(); // recalculate page height

        $panelCollapse.slideToggle(150);
    });



    // Remove elements
    // -------------------------

    // Panels
    jQuery('.panel [data-action=close]').click(function (e) {
        e.preventDefault();
        var $panelClose = jQuery(this).parent().parent().parent().parent().parent();

        containerHeight(); // recalculate page height

        $panelClose.slideUp(150, function() {
            jQuery(this).remove();
        });
    });


    // Sidebar categories
    jQuery('.category-title [data-action=close]').click(function (e) {
        e.preventDefault();
        var $categoryClose = jQuery(this).parent().parent().parent().parent();

        containerHeight(); // recalculate page height

        $categoryClose.slideUp(150, function() {
            jQuery(this).remove();
        });
    });




    // ========================================
    //
    // Main navigation
    //
    // ========================================


    // Main navigation
    // -------------------------

    // Add 'active' class to parent list item in all levels
    jQuery('.navigation').find('li.active').parents('li').addClass('active');

    // Hide all nested lists
    jQuery('.navigation').find('li').not('.active, .category-title').has('ul').children('ul').addClass('hidden-ul');

    // Highlight children links
    jQuery('.navigation').find('li').has('ul').children('a').addClass('has-ul');

    // Add active state to all dropdown parent levels
    jQuery('.dropdown-menu:not(.dropdown-content), .dropdown-menu:not(.dropdown-content) .dropdown-submenu').has('li.active').addClass('active').parents('.navbar-nav .dropdown:not(.language-switch), .navbar-nav .dropup:not(.language-switch)').addClass('active');

    

    // Main navigation tooltips positioning
    // -------------------------

    // Left sidebar
    jQuery('.navigation-main > .navigation-header > i').tooltip({
        placement: 'right',
        container: 'body'
    });



    // Collapsible functionality
    // -------------------------

    // Main navigation
    jQuery('.navigation-main').find('li').has('ul').children('a').on('click', function (e) {
        e.preventDefault();

        // Collapsible
        jQuery(this).parent('li').not('.disabled').not(jQuery('.sidebar-xs').not('.sidebar-xs-indicator').find('.navigation-main').children('li')).toggleClass('active').children('ul').slideToggle(250);

        // Accordion
        if (jQuery('.navigation-main').hasClass('navigation-accordion')) {
            jQuery(this).parent('li').not('.disabled').not(jQuery('.sidebar-xs').not('.sidebar-xs-indicator').find('.navigation-main').children('li')).siblings(':has(.has-ul)').removeClass('active').children('ul').slideUp(250);
        }
    });

        
    // Alternate navigation
    jQuery('.navigation-alt').find('li').has('ul').children('a').on('click', function (e) {
        e.preventDefault();

        // Collapsible
        jQuery(this).parent('li').not('.disabled').toggleClass('active').children('ul').slideToggle(200);

        // Accordion
        if (jQuery('.navigation-alt').hasClass('navigation-accordion')) {
            jQuery(this).parent('li').not('.disabled').siblings(':has(.has-ul)').removeClass('active').children('ul').slideUp(200);
        }
    }); 




    // ========================================
    //
    // Sidebars
    //
    // ========================================


    // Mini sidebar
    // -------------------------

    // Toggle mini sidebar
    jQuery('.sidebar-main-toggle').on('click', function (e) {
        e.preventDefault();

        // Toggle min sidebar class
        jQuery('body').toggleClass('sidebar-xs');
    });



    // Sidebar controls
    // -------------------------

    // Disable click in disabled navigation items
    jQuery(document).on('click', '.navigation .disabled a', function (e) {
        e.preventDefault();
    });


    // Adjust page height on sidebar control button click
    jQuery(document).on('click', '.sidebar-control', function (e) {
        containerHeight();
    });


    // Hide main sidebar in Dual Sidebar
    jQuery(document).on('click', '.sidebar-main-hide', function (e) {
        e.preventDefault();
        jQuery('body').toggleClass('sidebar-main-hidden');
    });


    // Toggle second sidebar in Dual Sidebar
    jQuery(document).on('click', '.sidebar-secondary-hide', function (e) {
        e.preventDefault();
        jQuery('body').toggleClass('sidebar-secondary-hidden');
    });


    // Hide detached sidebar
    jQuery(document).on('click', '.sidebar-detached-hide', function (e) {
        e.preventDefault();
        jQuery('body').toggleClass('sidebar-detached-hidden');
    });


    // Hide all sidebars
    jQuery(document).on('click', '.sidebar-all-hide', function (e) {
        e.preventDefault();

        jQuery('body').toggleClass('sidebar-all-hidden');
    });



    //
    // Opposite sidebar
    //

    // Collapse main sidebar if opposite sidebar is visible
    jQuery(document).on('click', '.sidebar-opposite-toggle', function (e) {
        e.preventDefault();

        // Opposite sidebar visibility
        jQuery('body').toggleClass('sidebar-opposite-visible');

        // If visible
        if (jQuery('body').hasClass('sidebar-opposite-visible')) {

            // Make main sidebar mini
            jQuery('body').addClass('sidebar-xs');

            // Hide children lists
            jQuery('.navigation-main').children('li').children('ul').css('display', '');
        }
        else {

            // Make main sidebar default
            jQuery('body').removeClass('sidebar-xs');
        }
    });


    // Hide main sidebar if opposite sidebar is shown
    jQuery(document).on('click', '.sidebar-opposite-main-hide', function (e) {
        e.preventDefault();

        // Opposite sidebar visibility
        jQuery('body').toggleClass('sidebar-opposite-visible');
        
        // If visible
        if (jQuery('body').hasClass('sidebar-opposite-visible')) {

            // Hide main sidebar
            jQuery('body').addClass('sidebar-main-hidden');
        }
        else {

            // Show main sidebar
            jQuery('body').removeClass('sidebar-main-hidden');
        }
    });


    // Hide secondary sidebar if opposite sidebar is shown
    jQuery(document).on('click', '.sidebar-opposite-secondary-hide', function (e) {
        e.preventDefault();

        // Opposite sidebar visibility
        jQuery('body').toggleClass('sidebar-opposite-visible');

        // If visible
        if (jQuery('body').hasClass('sidebar-opposite-visible')) {

            // Hide secondary
            jQuery('body').addClass('sidebar-secondary-hidden');

        }
        else {

            // Show secondary
            jQuery('body').removeClass('sidebar-secondary-hidden');
        }
    });


    // Hide all sidebars if opposite sidebar is shown
    jQuery(document).on('click', '.sidebar-opposite-hide', function (e) {
        e.preventDefault();

        // Toggle sidebars visibility
        jQuery('body').toggleClass('sidebar-all-hidden');

        // If hidden
        if (jQuery('body').hasClass('sidebar-all-hidden')) {

            // Show opposite
            jQuery('body').addClass('sidebar-opposite-visible');

            // Hide children lists
            jQuery('.navigation-main').children('li').children('ul').css('display', '');
        }
        else {

            // Hide opposite
            jQuery('body').removeClass('sidebar-opposite-visible');
        }
    });


    // Keep the width of the main sidebar if opposite sidebar is visible
    jQuery(document).on('click', '.sidebar-opposite-fix', function (e) {
        e.preventDefault();

        // Toggle opposite sidebar visibility
        jQuery('body').toggleClass('sidebar-opposite-visible');
    });



    // Mobile sidebar controls
    // -------------------------

    // Toggle main sidebar
    jQuery('.sidebar-mobile-main-toggle').on('click', function (e) {
        e.preventDefault();
        jQuery('body').toggleClass('sidebar-mobile-main').removeClass('sidebar-mobile-secondary sidebar-mobile-opposite sidebar-mobile-detached');
    });


    // Toggle secondary sidebar
    jQuery('.sidebar-mobile-secondary-toggle').on('click', function (e) {
        e.preventDefault();
        jQuery('body').toggleClass('sidebar-mobile-secondary').removeClass('sidebar-mobile-main sidebar-mobile-opposite sidebar-mobile-detached');
    });


    // Toggle opposite sidebar
    jQuery('.sidebar-mobile-opposite-toggle').on('click', function (e) {
        e.preventDefault();
        jQuery('body').toggleClass('sidebar-mobile-opposite').removeClass('sidebar-mobile-main sidebar-mobile-secondary sidebar-mobile-detached');
    });


    // Toggle detached sidebar
    jQuery('.sidebar-mobile-detached-toggle').on('click', function (e) {
        e.preventDefault();
        jQuery('body').toggleClass('sidebar-mobile-detached').removeClass('sidebar-mobile-main sidebar-mobile-secondary sidebar-mobile-opposite');
    });



    // Mobile sidebar setup
    // -------------------------

    jQuery(window).on('resize', function() {
        setTimeout(function() {
            containerHeight();
            
            if(jQuery(window).width() <= 768) {

                // Add mini sidebar indicator
                jQuery('body').addClass('sidebar-xs-indicator');

                // Place right sidebar before content
                jQuery('.sidebar-opposite').insertBefore('.content-wrapper');

                // Place detached sidebar before content
                jQuery('.sidebar-detached').insertBefore('.content-wrapper');

                // Add mouse events for dropdown submenus
                jQuery('.dropdown-submenu').on('mouseenter', function() {
                    jQuery(this).children('.dropdown-menu').addClass('show');
                }).on('mouseleave', function() {
                    jQuery(this).children('.dropdown-menu').removeClass('show');
                });
            }
            else {

                // Remove mini sidebar indicator
                jQuery('body').removeClass('sidebar-xs-indicator');

                // Revert back right sidebar
                jQuery('.sidebar-opposite').insertAfter('.content-wrapper');

                // Remove all mobile sidebar classes
                jQuery('body').removeClass('sidebar-mobile-main sidebar-mobile-secondary sidebar-mobile-detached sidebar-mobile-opposite');

                // Revert left detached position
                if(jQuery('body').hasClass('has-detached-left')) {
                    jQuery('.sidebar-detached').insertBefore('.container-detached');
                }

                // Revert right detached position
                else if(jQuery('body').hasClass('has-detached-right')) {
                    jQuery('.sidebar-detached').insertAfter('.container-detached');
                }

                // Remove visibility of heading elements on desktop
                jQuery('.page-header-content, .panel-heading, .panel-footer').removeClass('has-visible-elements');
                jQuery('.heading-elements').removeClass('visible-elements');

                // Disable appearance of dropdown submenus
                jQuery('.dropdown-submenu').children('.dropdown-menu').removeClass('show');
            }
        }, 100);
    }).resize();




    // ========================================
    //
    // Other code
    //
    // ========================================


    // Plugins
    // -------------------------

    // Popover
    jQuery('[data-popup="popover"]').popover();


    // Tooltip
    jQuery('[data-popup="tooltip"]').tooltip();

});
