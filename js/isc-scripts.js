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

        $('.brand-logo').find('img').each(function () {
                $(this).data('original-src', this.src);
        });
        // Swap image
        var imageResize = function () {
                var $img = $('.brand-logo:first').find('img');
                if ($(window).width() <= 992) {
                        var src = $img.data('original-src');
                        var smallSrc = src.replace('.svg', '-small.svg');
                        $img.attr('src', smallSrc);
                } else {
                        $img.attr('src', $img.data('original-src'));
                }
        };
        $(window).resize(imageResize);
        imageResize();

});
