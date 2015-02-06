/**
 * myMenu jQuery plugin
 * 
 */
(function($){$.fn.extend({
	myMenu: function () {
		var navigation = $('.navigation', this);
		navigation
			.find("> li").addClass("top").end()
			.find("> li > a").addClass("toplink").end()
			.find("> li > ul").addClass("group").end()
			.find(".cols + ul").addClass("cols").end()
			.find(".cols + ul > li > a, .cols + ul span").addClass("cols-headlink").end()
			.find(".cols + ul > li").addClass("cols-group").end()
			.find("ul li.active > a").addClass("activelink").end();
		
		var url = location.href;
		var prev_match = '';
		
		navigation.find(".group a, .top > a").each(function () {
			if($(this).hasClass('no-active')) return;
			var current = $(this).attr('href');
			var match = url.match(current);
			if(match && match[0].length > prev_match.length) {
				$(this).parent().parent().find('li').removeClass('active');
				$(this).parent().addClass('active');
				$(this).parents('.top').addClass('active');
				prev_match = match[0];
			}
		});
	
		var getHtml = function (obj) {
			var html = '';
			var size = $(obj).find("li").size();
			var max_lines = $(obj).parent().find("a,span").attr("rel");

			if (max_lines > 0)
			{
				$(obj).find("li").each(function (it) {
					if(it % max_lines == 0) html += "<ul style='float:left'>";
					
					//	outerHTML jQuery workaround:
 				    html += $('<div>').append($(this).clone()).html();
 				    
 	                if(it % max_lines == (max_lines-1) || it == size) html += '</ul>';
				});
			}

			return html;
		};

		navigation.find(".cols + ul ul").each(function () {
			var html = getHtml(this);

			if(html != '') $(this).replaceWith(html);
		});
		
		navigation.find(".group").each(function () {
			var html = getHtml(this);

			if(html != '') $(this).html(html);
		});
		
		$("> li", navigation).each(function () {
			if($(this).find("ul").size())
			{
				$(this).addClass("top-submenu");
				link = $(this).find(".toplink");
				link.html( '<span>' + link.html() + '</span>' );
			}
		});

		$(".group", navigation).each(function ()
		{
			var width = $(this).parent().width() + 8;
			if(width > $(this).width()) $(this).width(width);
		});

		var tout;
		$("> li", navigation).hover(
			function () {
				$(this).find("ul").css('z-index', 100).show();
				if(typeof tout == 'object' && tout.obj == $(this).text()) {
					clearTimeout(tout.tid);
				}
			},
			function () {
				var This = this;
				var tid = setTimeout(function () {
					$(This).find("ul").css('z-index', 0).hide();
				}, 50);
			
				tout = {'tid': tid, 'obj':$(This).text()};
			}
		);
		
		// Handle hidden elements
		// Fix by Gotys
		navigation.find("> li > a.hide").removeClass('hide').parent().hide();
	}
})})(jQuery);