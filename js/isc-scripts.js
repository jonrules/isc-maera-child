jQuery(function ($) {
	var $menu = $('#mobile-menu');
	var $anchors = $('article.page').find('h1,h2,h3,h4,h5,h6');
	var $scrollSpyAnchors = $();
	$anchors.each(function () {
		var $header = $(this);
		if (!$header.attr('id')) {
			return;
		}
		$header.addClass('scrollspy');
		var $menuItem = $('<li class="scroll-spy-menu-item"></li>');
		var $menuLink = $('<a class="scroll-spy-link waves-effect"></a>')
			.text($header.text())
			.attr('href', '#' + $header.attr('id'))
			.addClass($header[0].tagName.toLowerCase() + '-link');
		$menuItem.append($menuLink);
		$menuItem.insertBefore($menu.find('.left-sidebar-widget'));
		$scrollSpyAnchors = $scrollSpyAnchors.add($header);
	});
	$scrollSpyAnchors.scrollSpy();
});
