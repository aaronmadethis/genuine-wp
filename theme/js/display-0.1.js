jQuery(document).ready(function($) {
	var win_w = $(window).width(),
		win_h = $(window).height(),
		has_video = $('html.video').length > 0 ? true : false,
		win_ratio,
		orientation,
		is_horizontal,
		animating = false;

	/* ---------------------------------------------------------------------------------------
	TEST ORIENTATION OF TABLET AND PHONE
	--------------------------------------------------------------------------------------- */
	function doOnOrientationChange(){
		switch(window.orientation){  
			case -90:
			case 90:
				$('body').addClass('landscape').removeClass('portrait');
				orientation = 'landscape';
				break; 
			case 0:
				$('body').addClass('portrait').removeClass('landscape');
				orientation = 'portrait';
				break; 
		}
		win_w = $(window).width();
		win_h = $(window).height();
	}
	window.addEventListener('orientationchange', doOnOrientationChange);
	doOnOrientationChange();


	/* ---------------------------------------------------------------------------------------
	iPad 7 FIXES HELP
	--------------------------------------------------------------------------------------- */
	if (navigator.userAgent.match(/iPad;.*CPU.*OS 7_\d/i)) {
	    $('html').addClass('ipad ios7');
	}


	/* ---------------------------------------------------------------------------------------
	HOME PAGE FIXES
	--------------------------------------------------------------------------------------- */
	if (Modernizr.touch) {
		/* cache dom references */ 
		var $body = jQuery('body'); 

		/* bind events */
		$(document)
		.on('focus', 'input', function(e) {
			$body.addClass('fixfixed');
		})
		.on('blur', 'input', function(e) {
			$body.removeClass('fixfixed');
		});

		$('.project-slideshow').swipe( {
			//Generic swipe handler for all directions
			swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
				if (direction == 'left') {
					change_slideshow($('.left-arrow'), 'click');
				}else if(direction =="right"){
					change_slideshow($('.right-arrow'), 'click');
				};
				//console.log("You swiped " + direction );
			},
			excludedElements: ""
		});
		
	}
	if(!Modernizr.csstransitions) {
		$('.post-thumb div').remove();
		$('.post-thumb span').remove();
	}

	/* ---------------------------------------------------------------------------------------
	LOAD PORTFOLIO IMAGES
	--------------------------------------------------------------------------------------- */
	if( $('.layout-project').length > 0 ){
		init_slideshow();
	}

	function push_the_history(url){
		var new_url = url;
		history.pushState({}, '', new_url);
	}

	function init_slideshow(){
		var $view = "<div class='nav-view'><h5>View</h5><a class='single active' href='#'>Single</a><a class='grid' href='#'>Grid</a></div>";
		$('.nav-container').append( $view );

		$('.nav-view .grid').bind('click', function(el, ev) {
			open_grid($(this), ev);
			el.preventDefault();
		});

		$('.nav-view .single').bind('click', function(el, ev) {
			close_grid($(this), ev);
			el.preventDefault();
		});

		var current = $('ul.slides li.first').index();

		check_color(current);
		$('ul.slides li').eq(current).css({'visibility': 'visible'}).addClass('active').animate({opacity: 1}, 50);

		$('ul.slides li').eq(current).imagesLoaded( function() {
			$('ul.slides li').eq(current).find('.preloader_png').fadeOut(500);
			$('ul.slides li').eq(current).find('img').css({'visibility': 'visible'}).animate({opacity: 1}, 750);
			$('ul.slides li').eq(current).find('span').css({'visibility': 'visible'}).animate({opacity: 1}, 750);
		});
		
		var $arrows = "<div class='arrow left-arrow transition-2'><a class='transition-2' href='#'></a></div><div class='arrow right-arrow transition-2'><a class='transition-2' href='#'></a></div>";
		$('.project-slideshow').prepend( $arrows );

		$('.arrow, .img-next').bind('click', function(el, ev) {
			change_slideshow($(this), ev);
			el.preventDefault();
		});
	}

	$('.thumb-grid .thumb').click(function(e) {
		jump_image($(this), e);
		swap_active($('.nav-view .single'));
		e.preventDefault();
	});

	function jump_image(obj, ev){
		$('body').removeClass('nav-grid-open').addClass('nav-grid-close');

		var current,
			next = obj.parent('li').index(),
			newURL = $('ul.slides li').eq(next).find('img').data('url');

		push_the_history(newURL);

		if( $('ul.slides li.active').length > 0 ){
			current = $('ul.slides li.active').index();
		}else{
			current = $('ul.slides li:first').index();
		}

		check_color(next);
		$('ul.thumb-menu li.active').removeClass('active');
		$('ul.thumb-menu li').eq(next).addClass('active');

		$('ul.slides li').eq(current).removeClass('active').animate({opacity: 0}, 750, function(){
			$('ul.slides li').eq(next).addClass('active').css({'visibility': 'visible'}).animate({opacity: 1}, 750, function(){
				$(this).imagesLoaded( function() {
					$('ul.slides li').eq(next).find('.preloader_png').fadeOut({ duration: 100, queue: false, complete: function (){
						}
					});
					$('ul.slides li').eq(next).find('img').css({'visibility': 'visible'}).animate({opacity: 1}, { duration: 750, queue: false });
					$('ul.slides li').eq(next).find('span').css({'visibility': 'visible'}).animate({opacity: 1}, { duration: 750, queue: false });
				});
			});
		});
	}

	function close_grid(obj, ev){
		obj.unbind(ev);
		swap_active(obj);
		var open = $('body').is('.nav-grid-open');
		if(open){
			$('body').removeClass('nav-grid-open').addClass('nav-grid-close');
		}
		obj.click(function(e) { close_grid(obj); e.preventDefault(); });
	}

	function open_grid(obj, ev){
		obj.unbind(ev);
		swap_active(obj);
		var open = $('body').is('.nav-grid-open');
		if(!open){
			$('body').removeClass('nav-grid-close').addClass('nav-grid-open');
		}
		obj.click(function(e) { open_grid(obj); e.preventDefault(); });
	}

	function change_slideshow(obj, ev){

		var direction = 'right',
			current,
			next,
			max = $('ul.slides li').length;

		if( obj.hasClass('left-arrow') ){ direction = 'left'; }

		if( $('ul.slides li.active').length > 0 ){
			current = $('ul.slides li.active').index();
		}else{
			current = $('ul.slides li:first').index();
		}

		if(direction == 'right' ){
			if( current+1 > max-1){ next = 0 }else{ next = current+1 }
		}else if(direction == 'left'){
			if( current-1 < 0 ){ next = max-1 }else{ next = current-1 }
		}

		if(!animating){
			var newURL = $('ul.slides li').eq(next).find('img').data('url');
			push_the_history(newURL);
			
			obj.unbind(ev);
			check_color(next);
			$('ul.thumb-menu li.active').removeClass('active');
			$('ul.thumb-menu li').eq(next).addClass('active');

			$('ul.slides li').eq(current).removeClass('active').animate({opacity: 0}, 750, function(){
				$(this).css({'visibility': 'visible'});
				$('ul.slides li').eq(next).addClass('active').css({'visibility': 'visible'}).animate({opacity: 1}, 750, function(){
					$(this).imagesLoaded( function() {
						$('ul.slides li').eq(next).find('.preloader_png').fadeOut({ duration: 100, queue: false, complete: function (){
								obj.click(function(e) { change_slideshow(obj); e.preventDefault(); });
								animating = false;
							}
						});
						$('ul.slides li').eq(next).find('img').css({'visibility': 'visible'}).animate({opacity: 1}, { duration: 750, queue: false });
						$('ul.slides li').eq(next).find('span').css({'visibility': 'visible'}).animate({opacity: 1}, { duration: 750, queue: false });
					});
				});
			});
		}

		animating = true;
	}


	function check_color(next){
		if( $('ul.slides li').eq(next).hasClass('light') ){  
			$('.project-slideshow').addClass('light');
		}else{
			$('.project-slideshow').removeClass('light');
		}
	}

	function swap_active(obj){
		$('.nav-view .active').removeClass('active');
		obj.addClass('active');
	}

	/* ---------------------------------------------------------------------------------------
	NAV MENU OPEN AND CLOSE
	--------------------------------------------------------------------------------------- */
	if(Modernizr.touch){
		$('.side-nav-closed').click(function() {
			var open, top;
			top = $(document).scrollTop();
			open = $('body').is('.nav-menu-open');
			$('body').toggleClass('nav-menu-open', !open);

			$('.nav-menu-open .layout-container').children().click(function(){
				$('body').removeClass('nav-menu-open');
			});
		});
	}else{
		$('.side-nav-closed').hover(function() {
			var open, top;
			top = $(document).scrollTop();
			open = $('body').is('.nav-menu-open');
			$('body').toggleClass('nav-menu-open', !open);
		});
	}


	/* ---------------------------------------------------------------------------------------
	FEATURED POST IMAGE SIZE
	--------------------------------------------------------------------------------------- */
	$('.enlarge a').click(function(e) {
		var open;
		open = $('.layout-featured').is('.big-img');
		$('.layout-featured').toggleClass('big-img', !open);
		console.log('click');
		e.preventDefault();
	});

	$('.layout-featured .myclose a').click(function(e) {
		var open;
		open = $('.layout-featured').is('.big-img');
		$('.layout-featured').toggleClass('big-img', !open);
		console.log('click');
		e.preventDefault();
	});


	/* ---------------------------------------------------------------------------------------
	WINDOW RATIO
	--------------------------------------------------------------------------------------- */
	function set_window_ratio(){
		win_ratio = win_w / win_h;
		is_horizontal = false;
		
		if(win_ratio < 1) is_horizontal = true;
	}
	set_window_ratio();

	/* ---------------------------------------------------------------------------------------
	SET IMAGE RATIOS
	--------------------------------------------------------------------------------------- */
	function set_img_ratios(){
		
		$('.center.no-crop').each(function(i) {
			var img = $(this),
				p_w = $(this).closest('.p-wrap').width(),
				p_h = $(this).closest('.p-wrap').height(),
				p_r = p_w / p_h,
				img_w = $(img).attr('data-width'),
				img_h = $(img).attr('data-height'),
				img_r = img_w / img_h;

			if(p_r < img_r){
				//window is wide
				$(img).removeClass('vert').addClass('horz');
			}else{
				//window is high
				$(img).removeClass('horz').addClass('vert');
			}
		});
		$('.center.crop').each(function(i) {
			var img = $(this),
				p_w = $(this).closest('.p-wrap').width(),
				p_h = $(this).closest('.p-wrap').height(),
				p_r = p_w / p_h,
				img_w = $(img).attr('data-width'),
				img_h = $(img).attr('data-height'),
				img_r = img_w / img_h;

			if(p_r < img_r){
				//window is wide
				$(img).removeClass('horz').addClass('vert');
			}else{
				//window is high
				$(img).removeClass('vert').addClass('horz');
			}
		});

	}
	set_img_ratios();

	/* ---------------------------------------------------------------------------------------
	WINDOW RESIZE
	--------------------------------------------------------------------------------------- */		
	var rtime = new Date(1, 1, 2000, 12,00,00),
		timeout = false;
		delta = 50;
		
	$(window).resize(function() {
		$('#inset').attr({style: ''});
		rtime = new Date();
		if (timeout === false) {
			timeout = true;
			setTimeout(resize_end, delta);
		}
	});

	function resize_end() {
		if (new Date() - rtime < delta) {
			setTimeout(resize_end, delta);
		} else {
			timeout = false;
			win_w = $(window).width();
			win_h = $(window).height();
			set_window_ratio();
			set_img_ratios();
		}               
	}

});

