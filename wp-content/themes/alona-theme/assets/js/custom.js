jQuery(document).ready(function($) {

"use strict";


/*===========================================================*/
/*  Globals
/*===========================================================*/

var $mainContent = $('.main-content');
var flipDuration = 600;

/*===========================================================*/
/*  Remove Empty Paragraphs (Shortcodes)
/*===========================================================*/
$('p:empty').remove();

/*===========================================================*/
/* Velocity UI Effects
/*===========================================================*/

$.Velocity.RegisterUI( 'flipIn', {
	calls: [
	[ { rotateY: [ 0, 90 ], transformPerspective: [ 300, 300 ], transformOrigin:["X Y","0% 100%"], perspectiveOriginX:["0%"] } ]
	]
});

$.Velocity.RegisterUI( 'flipOut', {
	calls: [
	[ { rotateY: [ 90, 0 ], transformPerspective: [ 300, 300 ], transformOrigin:["X Y","0% 100%"], perspectiveOriginX:["0%"] } ]
	]
});

$.Velocity.RegisterUI( 'loaderSpin', {
	calls: [
	[ { transformPerspective: 100, rotateX: '-=180' }, 0.5 ],
	[ { transformPerspective: 100, rotateY:  '-=180' }, 0.5 ],
	]
});


/*===========================================================*/
/*  Flipping Effect
/*===========================================================*/

$('.flip, .flip-onload').velocity({
	rotateY: 90,
},{
	duration: 0
})

function flipElements(flipDuration){

	$('.flip-onload').velocity( 'flipIn', {
		duration: flipDuration,
		stagger: function(elementIndex, element) {
			return $(this).data('pos') * flipDuration;
		}
	});

}

/*===========================================================*/
/*  Loader Spin
/*===========================================================*/


var isLoaded = false;
var spinnerInterval = null;
var spinnerTimeout = null;
var $loaderOverlay = $('#loader-overlay');



$(window).load(function() {

	isLoaded = true;

	$loaderOverlay.velocity({ opacity: 0 }, {
		display: "none",
		duration: 450,
		complete: function() {
			clearInterval(spinnerInterval);
			clearTimeout(spinnerTimeout);

			flipElements(300);
		}
	});


});



var spinnerTimeout = setTimeout(function(){

	if(!isLoaded){

		$('.spinner').velocity({ opacity: [ 1, 0 ] }, {
			display: "auto",
			duration: 200,
			begin: function() {
				spinnerInterval = setInterval(function() {
					$('.spinner').velocity( 'loaderSpin', { duration: 1700 });
				});
			}
		});
	}

}, 1000 )


/*===========================================================*/
/*  Full Height of container
/*===========================================================*/

function fullHeight(){

	var dH = $(document).height();
	var wH = $(window).height();
	var contentPadding = parseInt($mainContent.css('padding-top'), 10) + parseInt($mainContent.css('padding-bottom'), 10);
	var contentHeight = dH - contentPadding;
	var viewportHeight = wH - contentPadding;

	$('.full-height, .portfolio-vertical, .portfolio-vertical .item').css('height', contentHeight);

	$('.full-slider, .full-slider .sd-single-slide').css('height', viewportHeight);

}

var $fullHeightElements = $('.full-height, .portfolio-vertical, .portfolio-vertical .item, .full-slider, .full-slider .sd-single-slide')

function calculateFullHeight(){
	$fullHeightElements.hide();
	fullHeight();
	$fullHeightElements.show();
}

calculateFullHeight();

$(window).on("resize", function(){
	calculateFullHeight();
});


/*===========================================================*/
/*	Agency Slider
/*===========================================================*/

var agencySlider = $('.agency-slider .sd-slides').bxSlider({
	mode: 'fade',
	auto: false,
	speed: 0,
	adaptiveHeight: true,
	nextText: '',
	prevText: '',
	controls: false,
	pager: false,
	onSliderLoad: function(currentIndex) {

		// Scale In Caption
		$('.agency-slider .sd-slides > li').eq(currentIndex).imagesLoaded(function(){

			$('.flip', $('.agency-slider .sd-slides > li') .eq(currentIndex)).velocity( 'flipIn', {
				duration: flipDuration,
				stagger: function(elementIndex, element) {
					return $(this).data('pos') * flipDuration;
				}
			});

		});

	},
	onSlideBefore: function($slideElement, oldIndex, newIndex) {},
	onSlideAfter: function($slideElement, oldIndex, newIndex) {

		$('.flip', $('.agency-slider .sd-slides > li') .eq(newIndex)).velocity( 'flipIn', {
			duration: flipDuration,
			stagger: function(elementIndex, element) {
				return $(this).data('pos') * flipDuration;
			},
			complete: function() {

				$('.sd-slider-next, .sd-slider-prev',$('.agency-slider')).velocity({ opacity: 1 }, { duration : 300, display: 'auto' });

			}
		});

	},
	onSlideNext: function($slideElement, oldIndex, newIndex) {}
});


/*===========================================================*/
/*   Custom Agency Slider Nav
/*===========================================================*/

$('.sd-slider-next, .sd-slider-prev', $('.agency-slider')).on('click', function(event){

	event.preventDefault();

	$(this).velocity({ opacity: 0 }, { duration : 0, display: 'none' });

	var currentIndex = agencySlider.getCurrentSlide();
	var posArray = [];

	$('.flip', $('.agency-slider .sd-slides > li').eq(currentIndex)).each(function(){
		posArray.push($(this).data('pos'))
	});

	var maxPos = Math.max.apply( null, posArray ); //The biggest data-pos in the queue
	var maxStagger = maxPos * flipDuration; //The biggest delay in the queue

	$('.flip', $('.agency-slider .sd-slides > li').eq(currentIndex)).velocity( 'flipOut', {
		duration: flipDuration,
		stagger: function(elementIndex, element) {
			return maxStagger - $(this).data('pos') * flipDuration;
		},
		backwards: true,
		complete: function() {
			if( $(this).hasClass('sd-slider-next')){
				agencySlider.goToNextSlide();
			} else {
				agencySlider.goToPrevSlide();
			}

		}
	});

})



/*===========================================================*/
/*	Add Icons to nav menu
/*===========================================================*/

$('#nav-container a').each(function(){

	var $this = $(this);

	if ( $this.next().hasClass('sub-menu') ) {
		$this.prepend('<i class="fa fa-angle-down"></i>');
	}

})


/*===========================================================*/
/*  Superfish
/*===========================================================*/

var $sfmenu = $('.sf-menu')

initSuperfish();

function initSuperfish(){
	var windowsize = $(window).width();
	if(windowsize < 992) {
		$sfmenu.superfish('destroy');
	} else {
		$sfmenu.superfish({
			delay: 300
		});
	}
}

$(window).on('resize', function(){
	initSuperfish();
});

/*===========================================================*/
/*  Current Menu Class
/*===========================================================*/


$('#nav-container a').each(function(){
	var itemLink = $(this).attr('href');
	var url = window.location.pathname;
	var lastSegment = url.split('/').pop();

	if (itemLink == lastSegment) {
		$(this).parent('li').addClass('current-menu-item');
	}
})


/*===========================================================*/
/*	fitVids
/*===========================================================*/
$('body').fitVids();

/*===========================================================*/
/*  Sidebar Scrollbar
/*===========================================================*/

function scrollbarCheck() {

	var $window = $(window);
	var windowsize = $window.width();

	if (windowsize >= 992){

		$('#header').perfectScrollbar({
			wheelSpeed: 200,
			suppressScrollX: true
		});

	} else {
		$('#header').perfectScrollbar('destroy');
	}

}

scrollbarCheck();

$(window).bind("resize", function(){
	scrollbarCheck();
});

/*===========================================================*/
/*  Portfolio Vertical
/*===========================================================*/

var owl = $(".portfolio-vertical");

owl.owlCarousel({
	loop: true,
	dots: false,
	nav: true,
	navText: false,
	responsive:{
		0:{
			items: 1
		},
		768:{
			items: 2
		},
		992:{
			items: 3
		}
	}
})

owl.on('mousewheel', '.owl-stage', function () {
	if (event.deltaY > 0) {
		owl.trigger('prev.owl');
	} else {
		owl.trigger('next.owl');
	}
	owl.trigger('refresh.owl.carousel');
	event.preventDefault();
});

/*===========================================================*/
/*	Portfolio Grid Isotope
/*===========================================================*/

var $container = $('.masonry-grid, .blog-posts');

var columns = $container.data('cols');

window.setCols = function () {
	var windowsize = $(document).width();

	if ( windowsize <= 478 ) {
		columns = 1;
	}
	else if ( windowsize <= 767 ) {
		columns = 2;
	} else {
		columns = $container.data('cols');
	}

	var itemWidth = null;

	$container.children().each(function(){
		var $this = $(this);
		if ( $this.data('width') == 'full' ){
			itemWidth = 100;
		} else {
			itemWidth = 100 / columns;
		}
		$this.css('width', itemWidth + '%');
	})


}

setCols();

$(window).on('resize', function () {
	setCols();
	$container.isotope({
		resizable: false,
		masonry: {
			columnWidth: $container.width() / columns - 0.5
		}
	});

	// var columnWidth = $container.width() / columns - 0.3;

}).trigger('resize');

$container.imagesLoaded(function () {
	$(window).trigger('resize');
	$container.isotope('layout')
});

/*===========================================================*/
/*   Owls Carousel Adaptive Height
/*===========================================================*/
function adaptiveHeight(slider){
	slider.imagesLoaded(function () {
		slider.find('.owl-height').css('height', slider.find('.owl-item.active').height() );
	});
}

/*===========================================================*/
/*  Project Slider
/*===========================================================*/

var $projectOwl = $('.post-slider .sd-slides');
var numProjectSlides = $projectOwl.find('img').length + $projectOwl.find('iframe').length;

var loop = null;
if(numProjectSlides == 1){
	var loop = false;
} else {
	var loop= true;
}

$projectOwl.on('initialized.owl.carousel resized.owl.carousel', function(event){
	adaptiveHeight($projectOwl);
	var numProjectSlides = event.item.count;
})

$projectOwl.owlCarousel({
	loop: loop,
	autoplay: false,
	autoHeight: true,
	video: true,
	navText: '',
	dots: false,
	items: 1
});

$projectOwl.imagesLoaded( function() {
	adaptiveHeight($projectOwl);
})



$('.sd-slider-next', '.post-slider').on('click', function(event){
	event.preventDefault();
	$projectOwl.trigger('next.owl.carousel');
})

$('.sd-slider-prev', '.post-slider').on('click', function(event){
	event.preventDefault();
	$projectOwl.trigger('prev.owl.carousel');
})


/*===========================================================*/
/*   Blog
/*===========================================================*/

var $blogContainer = $('.blog-posts');
var $blogSlider = $(".blog-slides");

function initBlogSlider(){

	$blogSlider.on('initialized.owl.carousel resized.owl.carousel', function(){
		adaptiveHeight($blogSlider);

		setTimeout( function(){
			$blogContainer.isotope('layout');
		}, 400)
	})


	$blogSlider.owlCarousel({
		loop: true,
		autoplay: true,
		autoHeight: true,
		video: true,
		navText: '',
		dots: false,
		items: 1
	});

}


$blogContainer.imagesLoaded( function() {

	initBlogSlider();
	$blogContainer.isotope({
		itemSelector: '.blog-item',
	});

})



/*===========================================================*/
/*	Filter items when filter link is clicked
/*===========================================================*/

$('.filter a').on('click', function(){

	var selector = $(this).attr('data-filter');
	$(this).parents('.filters').find('.selected').removeClass('selected');
	$(this).parent().addClass('selected');
	$container.isotope({ filter: selector });
	return false;

});




/*===========================================================*/
/* Background Image
/*===========================================================*/
$('.bgimage').each(function(){

	var bgImg  = $(this).data('bgimage');

	if (bgImg && bgImg !='') {
		$(this).css({
			'background-image' : "url('" + bgImg + "')",
			'background-repeat' : 'no-repeat',
			'background-size' : 'cover',
			'background-position' : 'center'
		});

	}

})

/*===========================================================*/
/*   Search Input
/*===========================================================*/

$('.blog-searchform button').on('click', function(event){

	var $this = $(this);
	var $searchInput = $('.blog-searchform .searchinput');

	if ( !$searchInput.hasClass('toggled') ){
		event.preventDefault();
		$searchInput.velocity({ width: [200, 0], padding: [10, 0] }, {
			display: "block",
			duration: 450,
			complete: function() {
				$(this).addClass('toggled');
			}
		});
	}
	if ( !$searchInput.val() ){
		event.preventDefault();
	}

})


$(document).mouseup(function (e)
{
   var $searchInput = $('.blog-searchform .searchinput');
   var $searchButton = $('.blog-searchform button');

    if (!$searchInput.is(e.target)
	    && !$searchInput.val()
	    && $searchInput.hasClass('toggled') )
    {

        $searchInput.velocity({ width: 0, padding: [0, 10] }, {
        	display: "none",
        	duration: 450,
        	complete: function() {
        		$(this).removeClass('toggled');
        	}
        });


    }
});


/*===========================================================*/
/*  Accordion Toggle Class
/*===========================================================*/

$('.panel-group .collapse.in').prev('.panel-heading').addClass('active');

$('.panel-group').on('show.bs.collapse', function(e){
	$(e.target).prev('.panel-heading').addClass('active');
});

$('.panel-group').on('hide.bs.collapse', function(e){
	$(e.target).prev('.panel-heading').removeClass('active');
});


/*===========================================================*/
/*  Accordion Toggle Class
/*===========================================================*/

$('.agency-block .col-sm-6, .services-list .col-sm-6, .clients-list .col-sm-4, .row-contacts .col-sm-6').matchHeight();


});