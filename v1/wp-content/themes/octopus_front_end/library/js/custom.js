jQuery(document).ready(function($) {
	setTimeout(function(){

		if ($('.js-select-client').length){
			$('.js-select-user, .js-select-site').prop('disabled', true);
			selectByClient();
		} else {
			$('.js-select-user').prop('disabled', true);
			selectBySite();
		}
		
	}, 1000);



	function selectByClient(){
		$('body').on('change', '.js-select-client', function(){
			var value = $(this).val();
			$('.js-select-user, .js-select-site').prop('disabled', true);

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
			$('.js-select-user').prop('disabled', true);
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

  });
});