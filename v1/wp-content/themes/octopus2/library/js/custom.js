jQuery(document).ready(function($) {
	setTimeout(function(){

		if ($('.js-select-client').length){
			$('.js-select-user, .js-select-site').prop('disabled', false);
			selectByClient();
		} else {
			$('.js-select-user').prop('disabled', false);
			selectBySite();
		}
		
	}, 1000);



	function selectByClient(){
		$('body').on('change', '.js-select-client', function(){
			var value = $(this).val();
			$('.js-select-user, .js-select-site').prop('disabled', false);

			if (value && value != '') {
				$.ajax({
					url: nfFrontEnd.adminAjax,
					type: 'POST',
					data: {action: 'getUsersAndSites', client_id: value},
				})
				.done(function(result) {

					$('.js-select-user').html(result.data.users);
					$('.js-select-user').prop('disabled', false);

					$('.js-select-site').html(result.data.sites);
					$('.js-select-site').prop('disabled', false);
				});
			}
			
		});
	}

	function selectBySite(){
		$('body').on('change', '.js-select-site', function(){
			var value = $(this).val();
			$('.js-select-user').prop('disabled', false);
			if (value && value != '') {
				$.ajax({
					url: nfFrontEnd.adminAjax,
					type: 'POST',
					data: {action: 'getUsersBySite', siteId: value},
				})
				.done(function(result) {
					$('.js-select-user').html(result.data.users);
					$('.js-select-user').prop('disabled', false);
				});
			}
		});
	}

	$('.text-field').on('save', function(e, params){
		var post_id = $(this).data('pk');
		var meta_key = $(this).attr('name');

		var data = {
			action: 'updatePostMeta',
			post_id : post_id,
			meta_key : meta_key,
			meta_value : params.newValue
		};

		if (post_id == '') {
			post_id = global_post_id;
		}

		$.ajax({
			url: myajax.url,
			type: 'POST',
			data: data,
		});
	});
});
jQuery(document).ready(function($){

	$('.star').on('click', function () {
      $(this).toggleClass('star-checked');
    });

    $('.ckbox label').on('click', function () {
      $(this).parents('tr').toggleClass('selected');
    });

    $('.btn-filter').on('click', function () {
		$(this).toggleClass('active').siblings().removeClass('active');
		

      var $target = $(this).data('target');
      if ($target != 'all') {
        $('.table tr').css('display', 'none');
        $('.table tr[data-status="' + $target + '"]').fadeIn('slow');
      } else {
        $('.table tr').css('display', 'none').fadeIn('slow');
      }
    });

 });
 jQuery(document).ready(function($){
 $('#interest_tabs').on('click', 'a[data-toggle="tab"]', function(e) {
	e.preventDefault();

	var $link = $(this);

	if (!$link.parent().hasClass('active')) {

	  //remove active class from other tab-panes
	  $('.tab-content:not(.' + $link.attr('href').replace('#','') + ') .tab-pane').removeClass('active');

	  // click first submenu tab for active section
	  $('a[href="' + $link.attr('href') + '_all"][data-toggle="tab"]').click();

	  // activate tab-pane for active section
	  $('.tab-content.' + $link.attr('href').replace('#','') + ' .tab-pane:first').addClass('active');
	}
	$("ul.nav-tabs a").click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	  });
  });
});
// toggle password visibility
jQuery(document).ready(function($){
	$('#password + .glyphicon').on('click', function() {
		$(this).toggleClass('glyphicon-eye-close').toggleClass('glyphicon-eye-open'); // toggle our classes for the eye icon
		$(this).prev().toggleClass('password');
		});
	});
jQuery(document).ready(function($){ 
	$('a[data-toggle="tab"]').on('click', function(e) {
        window.localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = window.localStorage.getItem('activeTab');
    if (activeTab) {
        $('#myTab a[href="' + activeTab + '"]').tab('show');
        window.localStorage.removeItem("activeTab");
    }
});
jQuery(document).ready(function($) {
	var map = null;
	var myMarker;
	var myLatlng;
  
	function initializeGMap(lat, lng) {
	  myLatlng = new google.maps.LatLng(lat, lng);
  
	  var myOptions = {
		zoom: 12,
		zoomControl: true,
		center: myLatlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	  };
  
	  map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
  
	  myMarker = new google.maps.Marker({
		position: myLatlng
	  });
	  myMarker.setMap(map);
	}
  
	// Re-init map before show modal
	$('#sitemap').on('show.bs.modal', function(event) {
	  var button = $(event.relatedTarget);
	  initializeGMap(button.data('lat'), button.data('lng'));
	  $("#location-map").css("width", "100%");
	  $("#map_canvas").css("width", "100%");
	});
  
	// Trigger map resize event after modal shown
	$('#sitemap').on('shown.bs.modal', function() {
	  google.maps.event.trigger(map, "resize");
	  map.setCenter(myLatlng);
	});
  });