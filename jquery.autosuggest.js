/*
 *  jQuery.autoSuggest v0.1
 * 
 *  Created by Bartosz Krawczyk
 * 	http://bkwebdesign.pl/
 * 
 *  MIT License
 * 
 */

jQuery.fn.highlight = function (str) {
	var regex = new RegExp(str, "gi");
	return this.each(function () {
		$(this).contents().filter(function() {
			return this.nodeType == 3 && regex.test(this.nodeValue);
		}).replaceWith(function() {
			return (this.nodeValue || "").replace(regex, function(match) {
				return "<b>" + match + "</b>";
			});
		});
	});
};


$.fn.autosuggest = function (options) {
	
	var settings = $.extend({
		server: 'asg_server.php',
		delay: 600,
		start: 2
	}, options);
	
	var input = $(this),
		input_id = $(this).attr('id'),
		input_w = $(this).width(),
		start = settings.start - 1;
	
	input.wrap('<div class="cp-asuggest-wrap"></div>');
	input.closest('.cp-asuggest-wrap').append('<div class="cp-asuggest-list-box"></div>');
	input.next('.cp-asuggest-list-box').css({'min-width': input_w});
	
	input.on('keyup', function () {
		input.attr('data-id', '0');
		$('.cp-asuggest-list-box').empty();
		var selected = 0;
		var list_elems = 0;
		if (input.val().trim().length >= start)
		{
			timer = 0;
			function asgSearch (){ 
				selected = 0;
				var qr = input.val().trim();
				if (input.val().trim().length > start)
				{
					input.next('.cp-asuggest-list-box').empty();
					$.ajax({
						url: settings.server,
						method: 'POST',
						dataType: 'json',
						data: { query: qr },
						success: function(response) {
							$.each(response, function(index, value) {
								if (value.error == 1) {
									var err_class = ' cp-asuggest-list-error';
								} else {
									var err_class = '';
								}
								input.next('.cp-asuggest-list-box').append('<div data-id="'+value.id+'" class="cp-asuggest-list'+err_class+' cp-asg-onlist-'+value.count+'">'+value.name+'</div>')
							});
							list_elems = input.closest('.cp-asuggest-wrap').find('.cp-asuggest-list').length;
							input.closest('.cp-asuggest-wrap').find('.cp-asuggest-list').highlight(qr);
						}
					});
				} else {
					input.next('.cp-asuggest-list-box').empty();
				}
			}
			input.off('keyup').on('keyup', function(e){
				input.attr('data-id', '0');
				if ((e.which != 38) && (e.which != 40) && (e.which != 13)) {
					if (timer) {
						clearTimeout(timer);
					}
					timer = setTimeout(asgSearch, settings.delay);
				} else {
					if (e.which == 40) {
						if (selected == list_elems) {
							selected = list_elems;
						} else {
							selected++;	
						}
						input.closest('.cp-asuggest-wrap').find('.cp-asuggest-list').removeClass('cp-asg-selected');
						input.closest('.cp-asuggest-wrap').find('.cp-asg-onlist-'+selected).addClass('cp-asg-selected');
					}
					if (e.which == 38) {
						if (selected > 0) {
							if (selected == 1) {
							selected = 1;
							} else {
								selected--;	
							}
							input.closest('.cp-asuggest-wrap').find('.cp-asuggest-list').removeClass('cp-asg-selected');
							input.closest('.cp-asuggest-wrap').find('.cp-asg-onlist-'+selected).addClass('cp-asg-selected');
						}
						var tmpStr = input.val();
						input.val('');
						input.val(tmpStr);
					}
					if (e.which == 13) {
						if (selected > 0) {
							var text = input.closest('.cp-asuggest-wrap').find('.cp-asg-onlist-'+selected).text();
							var result_id = input.closest('.cp-asuggest-wrap').find('.cp-asg-onlist-'+selected).attr('data-id');
							input.next('.cp-asuggest-list-box').empty();
							input.val(text).attr('data-id', result_id);
						}
					}
				}
			});
		}
	});
	
	$(document).off('click', '.cp-asuggest-list').on('click', '.cp-asuggest-list', function (e) {
		var text = $(this).text(),
			result_id = $(this).attr('data-id');
		
		if (result_id != '0') {
			$(this).closest('.cp-asuggest-wrap').find('input').val(text).attr('data-id', result_id);
			$(this).closest('.cp-asuggest-list-box').empty();
		}
		
		e.preventDefault();
		return false;
	});
	
	$(document).on('click', 'html', function (e) {
		$('.cp-asuggest-list-box').empty();
	});
};















