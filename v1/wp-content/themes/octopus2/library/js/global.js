/* globals global */
jQuery(function($){
	var searchRequest;
	$('.search-autocomplete').autoComplete({
		minChars: 2,
		source: function(term, suggest){
			try { searchRequest.abort(); } catch(e){}
			searchRequest = $.post(global.ajax, { search: term, action: 'search_site' }, function(res) {
				suggest(res.data);
			});
		}
	});
});