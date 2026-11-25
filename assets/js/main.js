(function ($) {
	"use strict";
	
	var hgApp = {
		/* ---------------------------------------------
		 Content Loading
		--------------------------------------------- */	
		contentLoading: function() {
			$("body").imagesLoaded( function() {
				$("body").addClass('techt-body-loaded');
				if($('.preloader, .el_preloader').length) {
					$('.preloader, .el_preloader').fadeOut('slow');
					setTimeout(function() {
						// Page Animation Script
						$("[data-animate]").scrolla({
						    mobile: true,
						    once: true 
						});
					}, 100); //Here you can change preloader time
				} else {
					// Page Animation Script
					$("[data-animate]").scrolla({
					    mobile: true,
					    once: true 
					});
				}
			});

			$('.search-wrapper a').on('click', function(e) {
				e.preventDefault();
				$('.full-screen-search-overlay').addClass('open');
				$(".eff-background").addClass("animated").one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", function() {
					$("html").toggleClass("is-scroll-disabled");
				    $(this).removeClass("animated");
				});
			});			

			$('.fullscreen-close').on('click', function(e) {
				e.preventDefault();
				$('.full-screen-search-overlay').removeClass('open');
				$(".eff-background").addClass("animated").one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", function() {
					$("html").removeClass("is-scroll-disabled");
				    $(this).removeClass("animated");
				});
			});

			$('.product .product-header .button').wrap('<div class="add-to-cart-wrapper"></div>');
		},	
		/* ---------------------------------------------
		 One Page Menu Script
		--------------------------------------------- */
		onePageMenu: function() {
			function onePageNav($selector) {
				var $navSelector = $($selector);
				$navSelector
				.not('[href="#"]')
				.not('[href="#0"]')
				.on('click', function(event) {
				    if ( location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname ) {
				      	var target = $(this.hash);
				      	target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

				      	$navSelector.removeClass("active");
				      	if( target.length) {
					      	if($(this)[0].hash.slice(1) === target[0].id) {
					      		$(this).addClass("active");
					      	} else {
					      		$(this).removeClass("active");
					      	}
				      	}
				     	
					    if (target.length) {
					        event.preventDefault();
					        $('html, body').animate({
					          	scrollTop: target.offset().top
					        }, 1000);
					    }
				    }
				});

				$navSelector.each(function(event) {
			      	var target = $(this.hash);
			      	if( target.length) {
				      	if(location.hash.slice(1) === target[0].id) {
				      		$(this).addClass("active");
				      	} else if(!location.hash) {
				      		
				      	} else {
				      		$(this).removeClass("active");
				      	}
			      	}
				});

				function onScroll(event){
				    var scrollPos = $(document).scrollTop();
				    $navSelector.each(function () {
				        var currLink = $(this);
		                if(currLink[0].hash !== "" && $(currLink[0].hash).position() !== undefined) {

	                		var $getNavHas = $(currLink).prop('href').split('#')[1],
	                			$getSection = $('#' + $getNavHas); 

	                		$getSection.each(function() {
		                		var $topPos = $(this).offset().top,
		                			$topPosRound = Math.round($topPos - 120 ),
		                			$presentPos = Math.round(scrollPos);

		                		if ($topPosRound <= $presentPos && $topPosRound + $(this).height() > $presentPos) {
		                		    $(currLink).parent().addClass("active"); 
		                		} else {
		                			$(currLink).parent().removeClass("active");
		                		}
	                		});
		                } else {
		                	return false;
		                }
				    });
				}

				$(document).on("scroll", onScroll);	     
			}
			onePageNav('.mainmenu li a');
		},

		/* ---------------------------------------------
		 Menu Script
		--------------------------------------------- */
		menu_script: function() {
			var $submenuIndicator = $('.site-header .mainmenu li .sub-menu');
			$submenuIndicator.prev().append('<i class="fas fa-angle-down"></i>');

			var $submenu = $('.site-header .mainmenu').find('li').has('.sub-menu');
			$submenu.prepend("<span class='menu-click'><i class='menu-arrow fas fa-plus'></i></span>");

			var $mobileSubMenuOpen = $(".menu-click");
			$mobileSubMenuOpen.each(function() {
				var $self = $(this);
				$self.on("click", function(e) {
					e.stopImmediatePropagation();
				    $self.siblings(".sub-menu").slideToggle("slow");
				    $self.children(".menu-arrow").toggleClass("menu-extend");
				});
			});

			var mobileMenu = $('.hamburger-menu.hamburger-mobile');
			mobileMenu.on('click', function(e) {
				e.stopImmediatePropagation();
				e.preventDefault();
				$('.mainmenu').toggleClass('menuopen');
				$('.hamburger-menu').toggleClass('is-active');
				$('.disable-content-menu').toggleClass('is-active');
				if( $('.hamburger-menu').hasClass('is-active') ){
					$('body').addClass('techt-body-no-scroll');
				}else{
					$('body').removeClass('techt-body-no-scroll');
				}
			});


		    var mainmenu = $('.hamburger-wrapper .mainmenu'),
		    	menulinks = mainmenu.find('> li > a'),
		    	tl = new TimelineMax({paused:true});

		    	tl.staggerTo(menulinks, 0.3, { y:"0", strictUnits:true }, 0.07 );

			var desktopHamburger = $('.hamburger-menu.hamburger-desktop');
			desktopHamburger.on('click', function(e) {
				e.preventDefault();
				$('.hamburger-wrapper').toggleClass('menu-show');
				$('.hamburger-menu').toggleClass('is-active');
				tl.timeScale(1).restart();
				$(".eff-background").addClass("animated").one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", function() {
					$("html").toggleClass("is-scroll-disabled");
				    $(this).removeClass("animated");
				});
			});

			var widgetHamburger = $('.hamburger-menu.hamburger-widget-display');
			widgetHamburger.on('click', function(e) {
				e.preventDefault();
				$('.widget-hamburger-blocks').toggleClass('menu-show');
				$('.hamburger-menu').toggleClass('is-active');
			});			

			var widgetHamburgerClose = $('.widget-hamburger-blocks .hamburger-close');
			widgetHamburgerClose.on('click', function(e) {
				e.preventDefault();
				$('.widget-hamburger-blocks').toggleClass('menu-show');
				$('.hamburger-menu').toggleClass('is-active');
			});

			var closeHamburger = $('.hamburger-close');
			closeHamburger.on('click', function() {
				$('.hamburger-wrapper').removeClass('menu-show');
				$('.hamburger-menu').removeClass('is-active');
				tl.timeScale(1).restart();
				$(".eff-background").addClass("animated").one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", function() {
					$("html").removeClass("is-scroll-disabled");
				    $(this).removeClass("animated");
				});
			});

			//Hamburger
			$('.hamburger-wrapper .mainmenu li a').wrap('<div class="menu-inside"></div>');
			var $submenuIndicatorHamburger = $('.hamburger-wrapper .mainmenu').find('li').has('.sub-menu');
				$submenuIndicatorHamburger.children('.menu-inside').append("<span class='menu-click'><i class='menu-arrow fas fa-arrow-right'></i></span>");

			var $submenuHamburger = $('.hamburger-wrapper .mainmenu').find('li .sub-menu');
			$submenuHamburger.prepend("<li class='back-menu'><span class='back-click'><i class='menu-arrow fas fa-arrow-left'></i></span></li>");

			var span = $('.hamburger-wrapper .mainmenu li');
			var main_menu = $('.hamburger-wrapper .mainmenu');
			var active_sub_menu = new TimelineMax({paused:true});
			span.each(function() {
				var _this = $(this).find('> .menu-inside > .menu-click'),
					sub_menu = _this.parent().next('.sub-menu'),
					sub_menu_back = sub_menu.find('>li:eq(0) .back-click'),
					sub_menu_links = sub_menu.find('> li > .menu-inside > a'),
					sub_tl = new TimelineMax({ 
						paused:true, 
					});

				sub_tl
					.set(main_menu, { minHeight: sub_menu.outerHeight() })
					.to(main_menu, 0.5, { x:"-=100%" }, "start")
					.to(_this.parents().siblings().find('>.menu-inside'), 0.5, { autoAlpha:0 }, "start")
					.to(_this.parent(), 0.5, { autoAlpha:0 }, "start")
					.to(sub_menu, 0.5, { autoAlpha: 1 }, "start")
					.staggerTo(sub_menu_links, 0.2, { y:"0"}, 0.1, "start" );

				_this.on('click', function() {
					active_sub_menu = sub_tl;
					sub_tl.play();
					return false;
				});

				sub_menu_back.on('click', function() {
					sub_tl.reverse();
					return false;
				});

			});

			var disabledContent = $('.disable-content-menu');
			disabledContent.on('click', function() {
				$('.mainmenu').removeClass('menuopen');
				$('.hamburger-menu').removeClass('is-active');
				$('.disable-content-menu').removeClass('is-active');
				$('body').removeClass('techt-body-no-scroll');
			});
		},

		/* ---------------------------------------------
		 Background Image
		--------------------------------------------- */
		background_image: function() {
			//Background 
			$("[data-bg-color], [data-bg-image], [data-bg-particles]").each(function() {
			    var $this = $(this);

			    if( $this.hasClass("pt-separate-bg-element") ){
			        $this.append('<div class="pt-background">');

			        // Background Color

			        if( $("[data-bg-color]") ){
			            $this.find(".hg-background").css("background-color", $this.attr("data-bg-color") );
			        }

			        // Particles
			        if( $this.attr("data-bg-particles-line-color") || $this.attr("data-bg-particles-dot-color") ){
			            $this.find(".hg-background").append('<div class="hg-background-particles">');
			            $(".hg-background-particles").each(function () {
			                var lineColor = $this.attr("data-bg-particles-line-color");
			                var dotColor = $this.attr("data-bg-particles-dot-color");
			                var parallax = $this.attr("data-bg-particles-parallax");
			                $(this).particleground({
			                    density: 15000,
			                    lineWidth: 0.2,
			                    lineColor: lineColor,
			                    dotColor: dotColor,
			                    parallax: parallax,
			                    proximity: 200
			                });
			            });
			        }

			        // Background Image

			        if( $this.attr("data-bg-image") !== undefined ){
			            $this.find(".hg-background").append('<div class="hg-background-image">');
			            $this.find(".hg-background-image").css("background-image", "url("+ $this.attr("data-bg-image") +")" );
			            $this.find(".hg-background-image").css("background-size", $this.attr("data-bg-size") );
			            $this.find(".hg-background-image").css("background-position", $this.attr("data-bg-position") );
			            $this.find(".hg-background-image").css("opacity", $this.attr("data-bg-image-opacity") );

			            $this.find(".hg-background-image").css("background-size", $this.attr("data-bg-size") );
			            $this.find(".hg-background-image").css("background-repeat", $this.attr("data-bg-repeat") );
			            $this.find(".hg-background-image").css("background-position", $this.attr("data-bg-position") );
			            $this.find(".hg-background-image").css("background-blend-mode", $this.attr("data-bg-blend-mode") );
			        }

			        // Parallax effect

			        if( $this.attr("data-bg-parallax") !== undefined ){
			            $this.find(".hg-background-image").addClass("hg-parallax-element");
			        }
			    }
			    else {

			        if(  $this.attr("data-bg-color") !== undefined ){
			            $this.css("background-color", $this.attr("data-bg-color") );
			            if( $this.hasClass("btn") ) {
			                $this.css("border-color", $this.attr("data-bg-color"));
			            }
			        }

			        if( $this.attr("data-bg-image") !== undefined ){
			            $this.css("background-image", "url("+ $this.attr("data-bg-image") +")" );

			            $this.css("background-size", $this.attr("data-bg-size") );
			            $this.css("background-repeat", $this.attr("data-bg-repeat") );
			            $this.css("background-position", $this.attr("data-bg-position") );
			            $this.css("background-blend-mode", $this.attr("data-bg-blend-mode") );
			        }

			    }
			});

			//Background Parallax
			$("[data-bg-parallax='scroll']").each(function() {
			    var speed = $(this).attr("data-bg-parallax-speed");
			    var $this = $(this);
			    var isVisible;
			    var backgroundPosition;

			    $this.isInViewport(function(status) {
			        if (status === "entered") {
			            isVisible = 1;
			            var position;

			            $(window).scroll(function () {
			                if( isVisible === 1 ){
			                    position = $(window).scrollTop() - $this.offset().top;
			                    backgroundPosition = (100 - (Math.abs((-$(window).height()) - position) / ($(window).height()+$this.height()))*100);
			                    if( $this.find(".hg-parallax-element").hasClass("hg-background-image") ){
			                        $this.find(".hg-background-image.hg-parallax-element").css("background-position-y", (position/speed) + "px");
			                    }
			                    else {
			                        $this.find(".hg-parallax-element").css("transform", "translateY(" +(position/speed)+ "px)");
			                    }
			                }
			            });
			        }
			        if (status === "leaved"){
			            isVisible = 0;
			        }
			    });
			});
		},		
		
		/* ---------------------------------------------
		Isotope Activation
		 --------------------------------------------- */
		isotope_activation: function() {
			var IsoGriddoload = $('.portfolio-grid-single');
			IsoGriddoload.isotope({
			    itemSelector: '.portfolio-grid-single > .item',
			    percentPosition: true,
			    layoutMode: 'packery',
			});	

			if ($('.masonry-contents').length > 0) {
			    var container = $('.masonry-contents');
			    container.imagesLoaded(function () {
			        container.masonry({
			            itemSelector: '.masonry-contents > [class*="col-"]',
			            columnWidth: '.small-items',
			            percentPosition: true
			        });
			    });
			    $(window).on('resize', function() {
			        container.masonry('layout');
			    });
			}	
		},
		
		/* ---------------------------------------------
		 Scroll Scripts
		--------------------------------------------- */
	    scroll_script: function () {
	    	//Fixed Navbar
	    	var $fixedHeader = $('.fixed-header');
	    	$(window).on('scroll', function() {
	    		if($(this).scrollTop() >= 350) {
	    			$fixedHeader
	    			.addClass('sticky-enable');
	    		} else {
	    			$fixedHeader
	    			.removeClass('sticky-enable');
	    		}
	    	});
			
			var $scrolltop = $('#scroll-top');
			$(window).on('scroll', function() {
				if($(this).scrollTop() > $(this).height()) {
					$scrolltop
					.addClass('btn-show')
					.removeClass('btn-hide');
				} else {
					$scrolltop
					.addClass('btn-hide')
					.removeClass('btn-show');
				}
			});
			$("a[href='#top']").on('click', function() {
				$("html, body").animate({
					scrollTop: 0
				}, "normal");
				return false;
			});
		},
		/* ---------------------------------------------
		 Tool Tips Script
		--------------------------------------------- */
		// tooltipScript: function() {
		// 	$('[data-toggle="tooltip"]').tooltip(); 
		// },		

		/* ---------------------------------------------
		Coming Soon Timer
		 --------------------------------------------- */
		blog_post_load_more: function() {
			// Post Load More
			var $loadMore = $('.posts-loadmore a');
			var $loadingImage = $('<i class="fas fa-spinner fa-spin"></i> <span>'+petrona.please_wait_text+'</span>');
			var olderPostsUrl = $('.posts-loadmore a').attr('href');

			var blogLayout = petrona.blog_layout;
			if( blogLayout == 'grid_main' ) {
				var $postsContainer = $('#main .blog-latest-items > .row');
			} else {
				var $postsContainer = $('#main .blog-latest-items > .row > .col-lg-12 ');
			}

			/* show message if end of the post list */
			if (olderPostsUrl === undefined) {
			    $loadMore.text(petrona.no_more_post_text);
			}

			$loadMore.on('click', function(e) {
			    e.preventDefault();
			    // If there are posts to get
			    if (olderPostsUrl !== undefined) {
			        $loadMore.html($loadingImage);


			        $.get(olderPostsUrl, function(result) {
			            var $html = $(result);
			            if( blogLayout == 'grid_main' ) {
			            	var $newContent = $('#main .blog-latest-items > .row ', $html).contents();
			            } else {
			            	var $newContent = $('#main .blog-latest-items > .row > .col-lg-12 ', $html).contents();
			            }
			            $postsContainer.append($newContent);

			            $postsContainer.imagesLoaded(function() {

			                if ($('.masonry-contents').length) {
		                        $('.masonry-contents').masonry( 'appended', $newContent, true );
				            }

			                // Get the url for more posts
			                olderPostsUrl = $('.posts-loadmore a', $html).attr('href');

			                // Inform the user if there are no more posts
			                if (olderPostsUrl == undefined) {
			                    $loadMore.html(petrona.no_more_post_to_load_text);
			                    $loadMore.slideUp();
			                } else {
			                    $loadMore.html(petrona.load_more_post_text);
			                }

			                //reset $html variable
			                $html = "";
			            });
			        });
			    }
			});
		},
		/* ---------------------------------------------
		 Sticky Content
		 --------------------------------------------- */
		fixed_content_scroll: function() {
			if( $('.sticky-content').length ) {			
				$('.sticky-content').theiaStickySidebar({
			      // Settings
			      additionalMarginTop: 30
			    });
			}

			// This function gets called with the user has scrolled the window.
			$(window).on('scroll', function () {
			    if ($(this).scrollTop() > 0) {
			        // Add the scrolled class to those elements that you want changed
			        $(".mainmenu.menuopen").addClass("scroll");
			    } else {
			        $(".mainmenu.menuopen").removeClass("scroll");
			    }
			});
		},
		/* ---------------------------------------------
		 Post Share
		 --------------------------------------------- */
		postShare: function() {
			function windowPopup(url, width, height) {
			    var left = (screen.width / 2) - (width / 2),
			        top = (screen.height / 2) - (height / 2);

			    window.open(
			        url, "",
			        "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width=" + width + ",height=" + height + ",top=" + top + ",left=" + left
			    );
			}
			var $shareSelector = $(".techt-social-share-link");
			$shareSelector.on("click", function(e) {
				e.preventDefault();
			   	windowPopup($(this).attr("href"), 600, 400);
			});

		},
		
		/* ---------------------------------------------
		 scroll_elements Script
		--------------------------------------------- */
		scroll_elements: function() {
			var scrollBarStatus = petrona.enable_custom_scroll;
			if( scrollBarStatus === '1' ) {
				$('html').addClass('techt-custom-scrollbar');
			}
			if( $('.widget-hamburger-blocks').length ) {			
				$('.widget-hamburger-blocks').addClass('techt-custom-scrollbar');
			}

			if( $('.hamburger-wrapper .menu-inner').length ) {			
				$('.hamburger-wrapper .menu-inner').addClass('techt-custom-scrollbar');
			}
			function debouncer(func, timeout) {
				var timeoutID, timeout = timeout || 500;
				return function () {
					var scope = this,
						args = arguments;
					clearTimeout(timeoutID);
					timeoutID = setTimeout(function () {
						func.apply(scope, Array.prototype.slice.call(args));
					}, timeout);
				}
			}

			if( $('.footer-fixed').length ) {
				var h,
					container = $('.footer-fixed');
				function run() {				
					container.imagesLoaded( { background: true }, function() {
						h = container.outerHeight();
						$('.techt-body').css('padding-bottom', h);
					});
				}
				run();
				$(window).on('resize', debouncer(function(){
					run();
				}, 50) );
			}

			var $stickyHeader = $('.sticky-header').not( ".sticky-header-template-wrap" );
			var $stickyHeaderTemplate = $('.sticky-header-template-wrap');
			var delta = 20;
			var headerHeight =  $stickyHeader.outerHeight();
			var lastScrollTop = 0;
		
			$(window).on('scroll', function(){
				hasScrolled($(this));
			});
            $( window ).on( "resize", function() {
				hasScrolled($(this));
			});
			function hasScrolled($this) {
				var st = $this.scrollTop();

				// if mobile menu is active do not any thing
				if($('.techt-mobile-menu-active').length){
					return;
				}
					
				// Make sure they scroll more than delta
				if(Math.abs(lastScrollTop - st) <= delta)
					return;
				
				// If they scrolled down and are past the navbar, add class .nav-up.
				// This is necessary so you never see what is "behind" the navbar.
				if (st > lastScrollTop && st > headerHeight){
					// Scroll Down
					if(! $stickyHeader.hasClass('has-sticky-template')){
						$stickyHeader
						.addClass('sticky-hide')
						.removeClass('sticky-show');
					}else{
						$stickyHeaderTemplate
						.addClass('sticky-hide')
						.removeClass('sticky-show');
						$stickyHeaderTemplate.find('.techt-mobile-menu.techt-nav-wrap .techt-nav').css('display', 'none');
					}
				} else if(st > headerHeight){
					// Scroll Up
					if(! $stickyHeader.hasClass('has-sticky-template')){
						$stickyHeader
						.addClass('sticky-show')
						.removeClass('sticky-hide');
					}else{
						$stickyHeader
						.addClass('sticky-hide')
						.removeClass('sticky-show');
						$stickyHeaderTemplate
						.addClass('sticky-show')
						.removeClass('sticky-hide');
						// $stickyHeaderTemplate.find('.techt-mobile-menu.techt-nav-wrap .techt-nav').show();
						$stickyHeaderTemplate.find('.techt-mobile-menu.techt-nav-wrap .techt-nav').css('display', 'flex');
					}
				} else {
					if(! $stickyHeader.hasClass('has-sticky-template')){
						$stickyHeader
						.removeClass('sticky-hide')
						.removeClass('sticky-show');
					}else{
						$stickyHeader
						.removeClass('sticky-hide')
						.removeClass('sticky-show');
						if(! $stickyHeaderTemplate.hasClass('sticky-hide')){
							$stickyHeaderTemplate
							.addClass('sticky-hide')
							.removeClass('sticky-show');
							$stickyHeaderTemplate.find('.techt-mobile-menu.techt-nav-wrap .techt-nav').css('display', 'none');
						}
					}
				}
				
				lastScrollTop = st;
			}
		},
		/* ---------------------------------------------
		 function initializ
		 --------------------------------------------- */
		initializ: function() {
			hgApp.contentLoading();
			hgApp.onePageMenu();
			hgApp.menu_script();
			hgApp.background_image();
			// hgApp.tooltipScript();
			hgApp.scroll_script();
			hgApp.blog_post_load_more();
			hgApp.fixed_content_scroll();
			hgApp.postShare();
			hgApp.scroll_elements();
		}
	};
	/* ---------------------------------------------
	 Document ready function
	 --------------------------------------------- */
	$(function() {
		hgApp.initializ();
	});

	$(window).on('load', function() {
		// hgApp.initializ();
		
		hgApp.isotope_activation();
	});
})(jQuery);