(function ($) {
	"use strict";

	function initPopupGallery($scope, selector, hasPopup, key) {
		if (!$.fn.magnificPopup) {
			return;
		}

		if (!hasPopup) {
			$.magnificPopup.close();
			return;
		}

		$(selector).on('click', function (event) {
			event.stopPropagation();
			event.preventDefault();
		});

		$scope.find(selector).magnificPopup({
			key: key,
			type: 'image',
			image: {
				titleSrc: function (item) {
					return item.el.attr('title') ? item.el.attr('title') : item.el.find('img').attr('alt');
				}
			},
			zoom: {
				enabled: true,
				duration: 300,
				easing: 'ease-in-out',
				opener: function (openerElement) {
					return openerElement;
				}
			}
		});
	}

	function initPopupMultipleGallery($scope, selector, gallery, hasPopup, key) {
		if (!$.fn.magnificPopup) {
			return;
		}

		if (!hasPopup) {
			$.magnificPopup.close();
			return;
		}

		$(selector).on('click', function (event) {
			event.stopPropagation();
			event.preventDefault();
			$(this).next(gallery).magnificPopup('open');
		});

		$scope.on('click', selector, function (event) {
			$(this).next(gallery).magnificPopup('open');
		});

		$scope.find(gallery).each(function () {
			$(this).magnificPopup({
				key: key,
				delegate: 'a',
				type: 'image',
				image: {
					titleSrc: function (item) {
						return item.el.attr('title') ? item.el.attr('title') : item.el.find('img').attr('alt');
					}
				},
				gallery: {
					enabled: true
				},
				zoom: {
					enabled: true,
					duration: 300,
					easing: 'ease-in-out',
					opener: function (openerElement) {
						return openerElement;
					}
				}
			});
		});
	}

	function initPopupVideo($scope, selector, hasPopup, key) {
		if (!$.fn.magnificPopup) {
			return;
		}

		if (!hasPopup) {
			$.magnificPopup.close();
			return;
		}

		$(selector).on('click', function (event) {
			event.stopPropagation();
			event.preventDefault();
		});

		$scope.find(selector).magnificPopup({
			key: key,
			type: 'iframe',
			mainClass: "mfp-fade",
			overflowY: "hidden",
			iframe: {
				markup: '<div class="mfp-iframe-scaler">' +
					'<div class="mfp-close"></div>' +
					'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>' +
					'</div>',
				patterns: {
					youtube: {
						index: 'youtube.com/',
						id: 'v=',
						src: 'https://www.youtube.com/embed/%id%?autoplay=1'
					},
					vimeo: {
						index: 'vimeo.com/',
						id: '/',
						src: 'https://player.vimeo.com/video/%id%?autoplay=1'
					},
					gmaps: {
						index: 'https://maps.google.',
						src: '%id%&output=embed'
					},
					soundcloud: {
						index: 'soundcloud.com/',
						id: function (url) {
							return encodeURI(url)
						},
						src: '//w.soundcloud.com/player/?url=%id%&amp;auto_play=true&amp;hide_related=true&amp;show_comments=false&amp;show_user=false&amp;show_reposts=false&amp;visual=true;'
					}
				},
				srcAction: 'iframe_src'
			},
			zoom: {
				enabled: true,
				duration: 300,
				easing: 'ease-in-out',
				opener: function (openerElement) {
					return openerElement;
				}
			}
		});
	}

	function mobileAndTabletCheck() {
		var check = false;

		(function (a) { if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true; })(navigator.userAgent || navigator.vendor || window.opera);

		return check;
	}

	function isEditMode() {
		return Boolean(elementorFrontend.isEditMode());
	}

	function getElementorElementSettings($scope) {

		if (window.elementorFrontend && window.elementorFrontend.isEditMode() && $scope.hasClass('elementor-element-edit-mode')) {
			return getEditorElementSettings($scope);
		}

		return $scope.data('settings') || {};
	}

	function getEditorElementSettings($scope) {
		var modelCID = $scope.data('model-cid'),
			elementID = $scope.data('id'),
			elementData;

		if (!modelCID) {
			return {};
		}

		if (!elementor.hasOwnProperty('config')) {
			return {};
		}

		elementData = elementor.config.data.find(e =>
			e.id == elementID
		);
		if (!elementData) {
			return {};
		}

		return elementData.settings;
	}

	// function prepareWaypointOptions($scope, waypointOptions) {
	// 	var options = waypointOptions || {},
	// 		$parentPopup = $scope.closest('.techt-popup__container-inner, .elementor-popup-modal .dialog-message');

	// 	if ($parentPopup[0]) {
	// 		options.context = $parentPopup[0];
	// 	}

	// 	return options;
	// }

	function isRtl(){
		var direction = '';
		(document.dir != undefined) ? direction = document.dir : direction = document.getElementsByTagName("html")[0].getAttribute("dir");
		if(direction == 'rtl'){
			return true;
		} 
		return false;
	}

	function initAnimationsHandlers ( $selector ) {
		$selector.find( '[data-element_type]' ).each( function() {
			var $this       = $( this ),
				elementType = $this.data( 'element_type' );

			if ( !elementType ) {
				return;
			}

			window.elementorFrontend.hooks.doAction( 'frontend/element_ready/global', $this, $ );
		} );
	}
	/* ---------------------------------------------
	 Petrona Video Popup
	--------------------------------------------- */
	var VideoPopup = function ($scope) {
		var hasPopup = true;
		initPopupVideo($scope, '.lightbox-image', hasPopup, 'videopopup');
	};


	/* ---------------------------------------------
	 Petrona Bubble Heading
	--------------------------------------------- */
	var BubbleHeadings = function ($scope) {
		//Global Content
		var heading = $scope.find(".techt-bubble-border");
		heading.prepend("<i></i><i></i><i></i><i></i><i></i>");

		heading.isInViewport(function (status) {
			if (status === "entered") {
				heading.addClass("in");
			}
			else if (status === "leaved") {
				heading.removeClass("in");
			}
		});
	};

	/* ---------------------------------------------
	 Coming Soon Content
	--------------------------------------------- */
	var comingSoonCounter = function ($scope) {
		var $selector = $scope.find('.commingsoon-count');
		$selector.each(function () {
			var $this = $(this),
				data_year = $this.attr('data-year'),
				data_month = $this.attr('data-month'),
				data_day = $this.attr('data-day'),
				data_hour = $this.attr('data-hour'),
				data_minutes = $this.attr('data-minutes'),
				data_lang = $this.attr('data-lang');
			$this.syotimer({
				year: data_year,
				month: data_month,
				day: data_day,
				hour: data_hour,
				minute: data_minutes,
				lang: data_lang
			});
		});
	};

	/* ---------------------------------------------
	 Petrona Image Heading
	--------------------------------------------- */
	var techtImageHeading = function ($scope) {
		var mouseMove = $scope.find('.techt-image-title').attr('data-mouse');
		if (mouseMove == 'yes') {
			var mouseX, mouseY;
			var ww = $(window).width();
			var wh = $(window).height();
			var traX, traY;
			$(document).mousemove(function (e) {
				var mouseMove = $scope.find('.techt-image-title').attr('data-mouse');
				if (mouseMove == 'yes') {
					mouseX = e.pageX;
					mouseY = e.pageY;
					traX = ((4 * mouseX) / 570) + 40;
					traY = ((4 * mouseY) / 570) + 50;
					$scope.find(".techt-image-headings").css({ "background-position": traX + "%" + traY + "%" });
				}
			});
		}
	};

	/* ---------------------------------------------
	 Petrona Circle Heading
	--------------------------------------------- */

	var techtCircleProgress = function ($scope) {

		var $progress = $scope.find('.techt-circle-progress');

		if (!$progress.length) {
			return;
		}

		var $value = $progress.find('.techt-circle-progress__value'),
			$meter = $progress.find('.techt-circle-progress__meter'),
			$number = $scope.find('.techt-circle-counter__number'),
			percent = parseInt($value.data('value')),
			progress = percent / 100,
			duration = $scope.find('.techt-circle-progress-wrap').data('duration'),
			responsiveSizes = $progress.data('responsive-sizes'),
			desktopSizes = responsiveSizes.desktop,
			tabletSizes = responsiveSizes.tablet,
			mobileSizes = responsiveSizes.mobile,
			currentDeviceMode = elementorFrontend.getCurrentDeviceMode(),
			prevDeviceMode = currentDeviceMode,
			isAnimatedCircle = false;

		if ('tablet' === currentDeviceMode) {
			updateSvgSizes(tabletSizes.size, tabletSizes.viewBox, tabletSizes.center, tabletSizes.radius, tabletSizes.valStroke, tabletSizes.bgStroke, tabletSizes.circumference);
		}

		if ('mobile' === currentDeviceMode) {
			updateSvgSizes(mobileSizes.size, mobileSizes.viewBox, mobileSizes.center, mobileSizes.radius, mobileSizes.valStroke, mobileSizes.bgStroke, mobileSizes.circumference);
		}

		var intersectionObserver = elementorModules.utils.Scroll.scrollObserver({
			callback: event => {
				if (event.isInViewport) {
					// animate counter
					const data = $number.data(),
					decimalDigits = data.toValue.toString().match(/\.(.*)/);

					intersectionObserver.unobserve($number[0]);
					if (decimalDigits) {
						data.rounding = decimalDigits[1].length;
					}
					data.duration = duration;

					$number.numerator(data);
			
					// animate progress
					var circumference = parseInt($progress.data('circumference')),
					dashoffset = circumference * (1 - progress);

					$value.css({
						'transitionDuration': duration + 'ms',
						'strokeDashoffset': dashoffset
					});

					isAnimatedCircle = true;
				}
				
			}
		});
		intersectionObserver.observe($number[0]);

		$(window).on('resize.techtCircleProgress orientationchange.techtCircleProgress', circleResizeHandler);

		function circleResizeHandler(event) {
			currentDeviceMode = elementorFrontend.getCurrentDeviceMode();

			if ('desktop' === currentDeviceMode && 'desktop' !== prevDeviceMode) {
				updateSvgSizes(desktopSizes.size, desktopSizes.viewBox, desktopSizes.center, desktopSizes.radius, desktopSizes.valStroke, desktopSizes.bgStroke, desktopSizes.circumference);
				prevDeviceMode = 'desktop';
			}

			if ('tablet' === currentDeviceMode && 'tablet' !== prevDeviceMode) {
				updateSvgSizes(tabletSizes.size, tabletSizes.viewBox, tabletSizes.center, tabletSizes.radius, tabletSizes.valStroke, tabletSizes.bgStroke, tabletSizes.circumference);
				prevDeviceMode = 'tablet';
			}

			if ('mobile' === currentDeviceMode && 'mobile' !== prevDeviceMode) {
				updateSvgSizes(mobileSizes.size, mobileSizes.viewBox, mobileSizes.center, mobileSizes.radius, mobileSizes.valStroke, mobileSizes.bgStroke, mobileSizes.circumference);
				prevDeviceMode = 'mobile';
			}
		}

		function updateSvgSizes(size, viewBox, center, radius, valStroke, bgStroke, circumference) {
			var dashoffset = circumference * (1 - progress);

			$progress.attr({
				'width': size,
				'height': size,
				'data-radius': radius,
				'data-circumference': circumference
			});

			$progress[0].setAttribute('viewBox', viewBox);

			$meter.attr({
				'cx': center,
				'cy': center,
				'r': radius,
				'stroke-width': bgStroke
			});

			if (isAnimatedCircle) {
				$value.css({
					'transitionDuration': ''
				});
			}

			$value.attr({
				'cx': center,
				'cy': center,
				'r': radius,
				'stroke-width': valStroke
			});

			$value.css({
				'strokeDasharray': circumference,
				'strokeDashoffset': isAnimatedCircle ? dashoffset : circumference
			});
		}
	};

	/* ---------------------------------------------
	 Petrona Search Box
	--------------------------------------------- */

	var searchBox = function ($scope) {

		onSearchSectionActivated($scope);

		$(document).on('click', function (event) {

			var $widget = $scope.find('.techt-search'),
				$popupToggle = $('.techt-search__popup-trigger', $widget),
				$popupContent = $('.techt-search__popup-content', $widget),
				activeClass = 'techt-search-popup-active',
				transitionOut = 'techt-transition-out';

			if ($(event.target).closest($popupToggle).length || $(event.target).closest($popupContent).length) {
				return;
			}

			if (!$widget.hasClass(activeClass)) {
				return;
			}

			$widget.removeClass(activeClass);
			$widget.addClass(transitionOut);
			setTimeout(function () {
				$widget.removeClass(transitionOut);
			}, 300);

			event.stopPropagation();
		});
	};

	var onSearchSectionActivated = function ($scope) {
		if (!window.elementor) {
			return;
		}

		if (!window.TechtElementsEditor) {
			return;
		}

		if (!window.TechtElementsEditor.activeSection) {
			return;
		}

		var section = window.TechtElementsEditor.activeSection;

		var isPopup = -1 !== ['section_popup_style', 'section_popup_close_style', 'section_form_style'].indexOf(section);

		if (isPopup) {
			$scope.find('.techt-search').addClass(activeClass);
			$('body').addClass('techt-body-no-scroll');
		} else {
			$scope.find('.techt-search').removeClass(activeClass);
			$('body').removeClass('techt-body-no-scroll');
		}
	};

	var searchPopupSwitch = function (event) {

		//event.stopPropagation();

		var $this = $(this),
			$widget = $this.closest('.techt-search'),
			$input = $('.techt-search__field', $widget),
			activeClass = 'techt-search-popup-active',
			transitionIn = 'techt-transition-in',
			transitionOut = 'techt-transition-out';

		if (!$widget.hasClass(activeClass)) {
			$widget.addClass(transitionIn);
			setTimeout(function () {
				$widget.removeClass(transitionIn);
				$widget.addClass(activeClass);
				$('body').addClass('techt-body-no-scroll');
			}, 300);
			$input.focus();
		} else {
			$widget.removeClass(activeClass);
			$('body').removeClass('techt-body-no-scroll');
			$widget.addClass(transitionOut);
			setTimeout(function () {
				$widget.removeClass(transitionOut);
			}, 300);
		}
	};

	/* ---------------------------------------------
	 Petrona Login Register
	--------------------------------------------- */

	var loginRegister = function ($scope, $) {
		var container = $scope.find('.ox-user-register .ox-lr-f-user-pass .ox-reg-pass-hint'),
			ps = $scope.find('.ox-lr-f-user-pass .ox-password-field-show'),
			psh = $scope.find('.ox-lr-f-user-pass .ox-password-field-showh'),
			pat1 = $scope.find('.ox-pass-indicator.pattern-1'),
			pat2 = $scope.find('.ox-pass-indicator.pattern-2'),
			pat3 = $scope.find('.ox-pass-indicator.pattern-3'),
			pat4 = $scope.find('.ox-pass-indicator.pattern-4'),
			pat5 = $scope.find('.ox-pass-indicator.pattern-5'),
			passond = $scope.find('.ox-pass-indicator.pshd'),
			passonf = $scope.find('.ox-pass-indicator.pshf'),
			passonc = $scope.find('.ox-pass-indicator.pshc');

		if (ps.length) {
			$(ps).on("click", function () {
				if ($(this).hasClass("oxsi")) {
					var passhideicon = $(this).data("passhideicon");
					$(this).removeClass("oxsi");
					$(this).html(passhideicon);
				} else {
					var passshowicon = $(this).data("passshowicon");
					$(this).addClass("oxsi");
					$(this).html(passshowicon);
				}
				var input = $($(this).attr("toggle"));
				if (input.attr("type") == "password") {
					input.attr("type", "text");
				} else {
					input.attr("type", "password");
				}
			});
		}
		if (psh.length) {
			$(psh).on("click", function () {
				if ($(this).hasClass("oxsi")) {
					$(this).removeClass("oxsi");
					$(this).closest(".ox-user-register").find(".ox-pass-indicator").fadeIn(400);
				} else {
					$(this).addClass("oxsi");
					$(this).closest(".ox-user-register").find(".ox-pass-indicator").css("display", "none");
				}

			});
		}
		if (container.length) {
			if (passonf.length) {
				$(container).on("focus keyup", function () {
					$(this).closest(".ox-user-register").find(".ox-pass-indicator").fadeIn(400);
				});
				$(container).focusout(function () {
					$(this).closest(".ox-user-register").find(".ox-pass-indicator").css("display", "none");
				});
			}


			$(container).on("focus keyup", function () {
				var password = $(this).val(),
					cfindi = $(this).closest(".ox-user-register").find(".ox-pass-indicator"),
					cfclicki = $(this).closest(".ox-user-register").find(".ox-password-field-showh");

				var strength = 0;

				if (pat1.length || pat4.length || pat5.length) {
					//min 8 character
					if (password.length > 7) {
						cfindi.find(".ox-min-eight-character").addClass("ox-pass-success-ind");
						cfindi.find(".ox-min-eight-character i").removeClass("fa-question-circle").addClass("fa-check-circle");
						strength++;
					} else {
						cfindi.find(".ox-min-eight-character").removeClass("ox-pass-success-ind");
						cfindi.find(".ox-min-eight-character i").addClass("fa-question-circle").removeClass("fa-check-circle");
					}
				}

				if (pat1.length || pat2.length || pat3.length) {
					//numbers
					if (password.match(/([0-9])/)) {
						cfindi.find(".ox-one-number").addClass("ox-pass-success-ind");
						cfindi.find(".ox-one-number i").removeClass("fa-question-circle").addClass("fa-check-circle");
						strength++;
					} else {
						cfindi.find(".ox-one-number").removeClass("ox-pass-success-ind");
						cfindi.find(".ox-one-number i").addClass("fa-question-circle").removeClass("fa-check-circle");
					}
				}

				if (pat1.length || pat3.length) {
					//characters
					if (password.match(/([a-zA-Z])/)) {
						cfindi.find(".ox-low-lat-case").addClass("ox-pass-success-ind");
						cfindi.find(".ox-low-lat-case i").removeClass("fa-question-circle").addClass("fa-check-circle");
						strength++;
					} else {
						cfindi.find(".ox-low-lat-case").removeClass("ox-pass-success-ind");
						cfindi.find(".ox-low-lat-case i").addClass("fa-question-circle").removeClass("fa-check-circle");
					}
				}

				if (pat1.length) {
					//special character
					if (password.match(/([!,@,#,$,%,^,&,*,?,_,~,-,(,)])/)) {
						cfindi.find(".ox-one-special-char").addClass("ox-pass-success-ind");
						cfindi.find(".ox-one-special-char i").removeClass("fa-question-circle").addClass("fa-check-circle");
						strength++;
					} else {
						cfindi.find(".ox-one-special-char").removeClass("ox-pass-success-ind");
						cfindi.find(".ox-one-special-char i").addClass("fa-question-circle").removeClass("fa-check-circle");
					}
				}

				if (pat2.length) {
					//min 4 and max 8 character
					if (password.length > 3 && password.length < 9) {
						cfindi.find(".ox-four-eight-character").addClass("ox-pass-success-ind");
						cfindi.find(".ox-four-eight-character i").removeClass("fa-question-circle").addClass("fa-check-circle");
						strength++;
					} else {
						cfindi.find(".ox-four-eight-character").removeClass("ox-pass-success-ind");
						cfindi.find(".ox-four-eight-character i").addClass("fa-question-circle").removeClass("fa-check-circle");
					}
				}

				if (pat3.length) {
					//min 6 character
					if (password.length > 5) {
						cfindi.find(".ox-min-six-character").addClass("ox-pass-success-ind");
						cfindi.find(".ox-min-six-character i").removeClass("fa-question-circle").addClass("fa-check-circle");
						strength++;
					} else {
						cfindi.find(".ox-min-six-character").removeClass("ox-pass-success-ind");
						cfindi.find(".ox-min-six-character i").addClass("fa-question-circle").removeClass("fa-check-circle");
					}
				}

				if (pat4.length || pat5.length) {
					//lower and uppercase				
					if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
						cfindi.find(".ox-low-upper-case").addClass("ox-pass-success-ind");
						cfindi.find(".ox-low-upper-case i").removeClass("fa-question-circle").addClass("fa-check-circle");
						strength++;
					} else {
						cfindi.find(".ox-low-upper-case").removeClass("ox-pass-success-ind");
						cfindi.find(".ox-low-upper-case i").addClass("fa-question-circle").removeClass("fa-check-circle");
					}
				}

				if (pat4.length) {
					//numbers and characters
					if (password.match(/([a-zA-Z])/) || password.match(/([0-9])/)) {
						cfindi.find(".ox-digit-alpha").addClass("ox-pass-success-ind");
						cfindi.find(".ox-digit-alpha i").removeClass("fa-question-circle").addClass("fa-check-circle");
						strength++;
					} else {
						cfindi.find(".ox-digit-alpha").removeClass("ox-pass-success-ind");
						cfindi.find(".ox-digit-alpha i").addClass("fa-question-circle").removeClass("fa-check-circle");
					}
				}

				if (pat5.length) {
					//special character
					if (password.match(/([!,@,#,$,%,^,&,*,?,_,~,-,(,)])/) || password.match(/([0-9])/)) {
						cfindi.find(".ox-number-special").addClass("ox-pass-success-ind");
						cfindi.find(".ox-number-special i").removeClass("fa-question-circle").addClass("fa-check-circle");
						strength++;
					} else {
						cfindi.find(".ox-number-special").removeClass("ox-pass-success-ind");
						cfindi.find(".ox-number-special i").addClass("fa-question-circle").removeClass("fa-check-circle");
					}
				}

				if ((pat1.length && strength == 4) || (pat2.length && strength == 2) || (pat3.length && strength == 3 || pat4.length && strength == 3 || pat5.length && strength == 3)) {
					cfclicki.addClass('ox-done');
					$(this).closest(".ox-user-register").find(".ox-pass-indicator").addClass('ox-done');
					setTimeout(function () { cfclicki.fadeOut(400); }, 1000);
					$(this).closest(".ox-user-register").find("button.ox-button").removeAttr("disabled");
				} else {
					cfclicki.removeClass('ox-done');
					$(this).closest(".ox-user-register").find(".ox-pass-indicator").removeClass('ox-done');
					setTimeout(function () { cfclicki.fadeIn(400); }, 1000);
					$(this).closest(".ox-user-register").find("button.ox-button").attr("disabled", true);
				}

				if (password == false) {
					$(this).closest(".ox-user-register").find("button.ox-button").attr("disabled", true);
				}
			});

		}
	};

	/* ---------------------------------------------
	 Petrona Service Pricing
	--------------------------------------------- */

	var servicePricing = function ($scope) {
		var $target = $scope.find('.service-pricing'),
			$tooltips = $('.pricing-feature .pricing-feature__inner[data-tippy-content]', $target),
			settings = $target.data('tooltips-settings'),

			$fold_target = $scope.find('.service-pricing__fold-mask'),
			$fold_button = $scope.find('.service-pricing__fold-button'),
			$fold_mask = $fold_target,
			$fold_content = $('.service-pricing__features', $fold_target),
			fold_settings = $fold_target.data('fold-settings') || {},
			fold_enabled = fold_settings['fold_enabled'] || false,
			fold_maskHeight = 0,
			contentHeight = 0,
			unfoldDuration = fold_settings['unfoldDuration'],
			foldDuration = fold_settings['unfoldDuration'],
			unfoldEasing = fold_settings['unfoldEasing'],
			foldEasing = fold_settings['foldEasing'];

		if ($tooltips[0]) {
			$tooltips.each(function () {
				var $this = $(this),
					itemSelector = $this[0];

				if (itemSelector._tippy) {
					itemSelector._tippy.destroy();
				}

				tippy([itemSelector], {
					arrow: settings['tooltipArrow'] ? true : false,
					duration: [settings['tooltipShowDuration']['size'], settings['tooltipHideDuration']['size']],
					delay: settings['tooltipDelay']['size'],
					placement: settings['tooltipPlacement'],
					trigger: settings['tooltipTrigger'],
					animation: settings['tooltipAnimation'],
					appendTo: itemSelector,
					offset: [0, settings['tooltipDistance']['size']],
					allowHTML: true,
					popperOptions: {
						strategy: 'fixed',
					},
				});

			});
		}

		function maskHeight() {
			$scope.find('.service-pricing__fold-mask .fold_visible').each(function () {
				fold_maskHeight = fold_maskHeight + $(this).outerHeight(true);
			});
		}

		function fold_content_height() {
			contentHeight = 0;
			$scope.find('.service-pricing__fold-mask .pricing-feature').each(function () {
				contentHeight = contentHeight + $(this).outerHeight(true);
			})
		}

		if (fold_enabled) {

			maskHeight();
			fold_content_height();

			if (!$fold_target.hasClass('service-pricing-unfold-state')) {
				$fold_mask.css({
					'height': fold_maskHeight
				});
			}

			$scope.find('.service-pricing__fold-mask').css('max-height', 'none');

			$fold_button.on('click.techtPricingTable', function () {
				var $this = $(this),
					$buttonText = $('.service-pricing__fold-button-text', $this),
					$buttonIcon = $('.service-pricing__fold-button-icon', $this),
					unfoldText = $this.data('unfold-text'),
					foldText = $this.data('fold-text'),
					unfoldIcon = $this.data('unfold-icon'),
					foldIcon = $this.data('fold-icon');

				if (!$fold_target.hasClass('service-pricing-unfold-state')) {
					$fold_target.addClass('service-pricing-unfold-state');

					fold_content_height();

					$buttonIcon.html(foldIcon);
					$buttonText.html(foldText);

					anime({
						targets: $fold_mask[0],
						height: contentHeight,
						duration: unfoldDuration['size'] || unfoldDuration,
						easing: unfoldEasing
					});
				} else {
					$fold_target.removeClass('service-pricing-unfold-state');

					$buttonIcon.html(unfoldIcon);
					$buttonText.html(unfoldText);

					anime({
						targets: $fold_mask[0],
						height: fold_maskHeight,
						duration: foldDuration['size'] || foldDuration,
						easing: foldEasing
					});
				}
			});
		}
	};

	/* ---------------------------------------------
	 Petrona Animated Box
	--------------------------------------------- */

	var animatedBox = function ($scope) {

		onAnimatedBoxSectionActivated($scope);
		var $target = $scope.find('.techt-animated-box'),
			defaultSettings = {
				widgetId: null,
				switchEventType: 'hover',
				paperFoldDirection: 'left',
				slideOutDirection: 'left'
			},
			settings = $target.data('settings'),
			settings = $.extend({}, defaultSettings, settings),
			scrollOffset = $(window).scrollTop(),
			firstMouseEvent = true,
			editMode = Boolean(elementorFrontend.isEditMode());

		if (!$target.length) {
			return;
		}

		switch (settings['switchEventType']) {
			case 'hover':
				if (!editMode) {
					hoverSwitchType();
				} else {
					clickSwitchType();
				}

				break;

			case 'click':
				clickSwitchType();
				break;

			case 'toggle':
				toggleSwitchType();
				break;
		}


		function hoverSwitchType() {

			if ('ontouchend' in window || 'ontouchstart' in window) {
				$target.on('touchstart', function (event) {
					scrollOffset = $(window).scrollTop();
				});

				$target.on('touchend', function (event) {

					if (scrollOffset !== $(window).scrollTop()) {
						return false;
					}

					var $this = $(this);

					if ($this.hasClass('flipped-stop')) {
						return;
					}

					setTimeout(function () {
						$this.toggleClass('flipped');
					}, 10);
				});

				$(document).on('touchend', function (event) {

					if ($(event.target).closest($target).length) {
						return;
					}

					if ($target.hasClass('flipped-stop')) {
						return;
					}

					if (!$target.hasClass('flipped')) {
						return;
					}

					$target.removeClass('flipped');
				});
			} else {

				$target.on('mouseenter mouseleave', function (event) {

					if (firstMouseEvent && 'mouseleave' === event.type) {
						return;
					}

					if (firstMouseEvent && 'mouseenter' === event.type) {
						firstMouseEvent = false;
					}

					if (!$(this).hasClass('flipped-stop')) {
						$(this).toggleClass('flipped');
					}
				});
			}
		}

		function clickSwitchType() {
			if ('ontouchend' in window || 'ontouchstart' in window) {
				$target.on('touchstart', function (event) {
					scrollOffset = $(window).scrollTop();
				});

				$target.on('touchend', function (event) {

					if (scrollOffset !== $(window).scrollTop()) {
						return false;
					}

					var $this = $(this);

					if ($this.hasClass('flipped-stop')) {
						return;
					}

					setTimeout(function () {
						$this.toggleClass('flipped');
					}, 10);
				});

				$(document).on('touchend', function (event) {

					if ($(event.target).closest($target).length) {
						return;
					}

					if ($target.hasClass('flipped-stop')) {
						return;
					}

					if (!$target.hasClass('flipped')) {
						return;
					}

					$target.removeClass('flipped');
				});
			} else {
				$target.on('click', function (event) {

					if (!$target.hasClass('flipped-stop')) {
						$target.toggleClass('flipped');
					}
				});
			}
		}

		function toggleSwitchType() {
			if ('ontouchend' in window || 'ontouchstart' in window) {
				$target.on('touchstart', '.techt-animated-box__toggle', function (event) {

					if (!$target.hasClass('flipped-stop')) {
						$target.toggleClass('flipped');
					}
				});
			} else {
				$target.on('click', '.techt-animated-box__toggle', function (event) {

					if (!$target.hasClass('flipped-stop')) {
						$target.toggleClass('flipped');
					}
				});
			}
		}
	};

	var onAnimatedBoxSectionActivated = function ($scope) {
		if (!window.elementor) {
			return;
		}

		if (!window.TechtElementsEditor) {
			return;
		}

		if (!window.TechtElementsEditor.activeSection) {
			return;
		}

		var section = window.TechtElementsEditor.activeSection;
		var isBackSide = -1 !== ['section_back_content', 'section_action_button_style'].indexOf(section);

		if (isBackSide) {
			$scope.find('.techt-animated-box').addClass('flipped');
			$scope.find('.techt-animated-box').addClass('flipped-stop');
		} else {
			$scope.find('.techt-animated-box').removeClass('flipped');
			$scope.find('.techt-animated-box').removeClass('flipped-stop');
		}
	};

	/* ---------------------------------------------
	 Petrona Nav Menu
	--------------------------------------------- */

	var techtNavMenu = function ($scope) {
		if ($scope.data('initialized')) {
			return;
		}

		$scope.data('initialized', true);

		var hoverClass = 'techt-nav-hover',
			hoverOutClass = 'techt-nav-hover-out',
			mobileActiveClass = 'techt-mobile-menu-active';

		var offset = $scope.offset();
		var rightOffset = ($(window).width() - ($scope.offset().left + $scope.outerWidth()));

		var $megamenuFullWidth = $scope.find('.rbt-megamenu.grid-item-full');

		$megamenuFullWidth.each(function(){
			var $this = $(this);
			$this.css('right','-' + (rightOffset - 30) + 'px');
		});
		$scope.find('.techt-nav:not(.techt-nav--vertical-sub-bottom)').hoverIntent({
			over: function () {
				$(this).addClass(hoverClass);
			},
			out: function () {
				var $this = $(this);
				$this.removeClass(hoverClass);
				$this.addClass(hoverOutClass);
				setTimeout(function () {
					$this.removeClass(hoverOutClass);
				}, 200);
			},
			timeout: 200,
			selector: '.menu-item-has-children, .with-megamenu'
		});

		if (mobileAndTabletCheck()) {
			$scope.find('.techt-nav:not(.techt-nav--vertical-sub-bottom)').on('touchstart.techtNavMenu', '.menu-item > a', touchStartItem);
			$scope.find('.techt-nav:not(.techt-nav--vertical-sub-bottom)').on('touchend.techtNavMenu', '.menu-item > a', touchEndItem);

			$(document).on('touchstart.techtNavMenu', prepareHideSubMenus);
			$(document).on('touchend.techtNavMenu', hideSubMenus);
		} else {
			$scope.find('.techt-nav:not(.techt-nav--vertical-sub-bottom)').on('click.techtNavMenu', '.menu-item > a', clickItem);
		}

		if (!isEditMode()) {
			initMenuAnchorsHandler();
		}

		function touchStartItem(event) {
			var $currentTarget = $(event.currentTarget),
				$this = $currentTarget.closest('.menu-item');

			$this.data('offset', $(window).scrollTop());
			$this.data('elemOffset', $this.offset().top);
		}

		function touchEndItem(event) {
			var $this,
				$siblingsItems,
				$link,
				$currentTarget,
				subMenu,
				offset,
				elemOffset,
				$hamburgerPanel;

			event.preventDefault();
			//event.stopPropagation();

			$currentTarget = $(event.currentTarget);
			$this = $currentTarget.closest('.menu-item');
			$siblingsItems = $this.siblings('.menu-item.menu-item-has-children, .menu-item.with-megamenu'),
			$link = $('> a', $this);
			subMenu = $('.techt-nav__sub:first, .rbt-megamenu:first', $this);
			offset = $this.data('offset');
			elemOffset = $this.data('elemOffset');
			$hamburgerPanel = $this.closest('.techt-hamburger-panel');

			if (offset !== $(window).scrollTop() || elemOffset !== $this.offset().top) {
				return false;
			}

			if ($siblingsItems[0]) {
				$siblingsItems.removeClass(hoverClass);
				$('.menu-item-has-children, .with-megamenu', $siblingsItems).removeClass(hoverClass);
			}

			if (!$('.techt-nav__sub, .rbt-megamenu', $this)[0] || $this.hasClass(hoverClass)) {
				$link.trigger('click'); // Need for a smooth scroll when clicking on an anchor link
				window.location.href = $link.attr('href');

				if ($scope.find('.techt-nav-wrap').hasClass(mobileActiveClass)) {
					// $scope.find('.techt-nav-wrap').removeClass(mobileActiveClass);
				}

				if ($hamburgerPanel[0] && $hamburgerPanel.hasClass('open-state')) {
					$hamburgerPanel.removeClass('open-state');
					$('html').removeClass('techt-hamburger-panel-visible');
				}

				return false;
			}

			if (subMenu[0]) {
				$this.addClass(hoverClass);
			}
		}

		function clickItem(event) {
			var $currentTarget = $(event.currentTarget),
				$menuItem = $currentTarget.closest('.menu-item'),
				$hamburgerPanel = $menuItem.closest('.techt-hamburger-panel');

			if (!$menuItem.hasClass('menu-item-has-children') || !$menuItem.hasClass('with-megamenu') || $menuItem.hasClass(hoverClass)) {

				if ($hamburgerPanel[0] && $hamburgerPanel.hasClass('open-state')) {
					$hamburgerPanel.removeClass('open-state');
					$('html').removeClass('techt-hamburger-panel-visible');
				}

			}
		}

		var scrollOffset;

		function prepareHideSubMenus(event) {
			scrollOffset = $(window).scrollTop();
		}

		function hideSubMenus(event) {
			var $menu = $scope.find('.techt-nav');

			if ('touchend' === event.type && scrollOffset !== $(window).scrollTop()) {
				return;
			}

			if ($(event.target).closest($menu).length) {
				return;
			}

			var $openMenuItems = $('.menu-item-has-children.' + hoverClass + ', .with-megamenu.' + hoverClass, $menu);

			if (!$openMenuItems[0]) {
				return;
			}

			$openMenuItems.removeClass(hoverClass);
			$openMenuItems.addClass(hoverOutClass);

			setTimeout(function () {
				$openMenuItems.removeClass(hoverOutClass);
			}, 200);

			if ($menu.hasClass('techt-nav--vertical-sub-bottom')) {
				$('.techt-nav__sub, .rbt-megamenu', $openMenuItems).slideUp(200);
			}

			event.stopPropagation();
		}

		// START Vertical Layout: Sub-menu at the bottom
		$scope.find('.techt-nav--vertical-sub-bottom').on('click.techtNavMenu', '.menu-item > a', verticalSubBottomHandler);

		function verticalSubBottomHandler(event) {
			var $currentTarget = $(event.currentTarget),
				$menuItem = $currentTarget.closest('.menu-item'),
				$siblingsItems = $menuItem.siblings('.menu-item.menu-item-has-children, .menu-item.with-megamenu'),
				$subMenu = $('.techt-nav__sub:first, .rbt-megamenu:first', $menuItem),
				$hamburgerPanel = $menuItem.closest('.techt-hamburger-panel');

			if (!$menuItem.hasClass('menu-item-has-children') || !$menuItem.hasClass('.with-megamenu') || $menuItem.hasClass(hoverClass)) {

				if ($scope.find('.techt-nav-wrap').hasClass(mobileActiveClass)) {
					$scope.find('.techt-nav-wrap').removeClass(mobileActiveClass);
				}

				if ($hamburgerPanel[0] && $hamburgerPanel.hasClass('open-state')) {
					$hamburgerPanel.removeClass('open-state');
					$('html').removeClass('techt-hamburger-panel-visible');
				}

				return;
			}

			event.preventDefault();
			event.stopPropagation();

			if ($siblingsItems[0]) {
				$siblingsItems.removeClass(hoverClass);
				$('.menu-item-has-children, .with-megamenu', $siblingsItems).removeClass(hoverClass);
				$('.techt-nav__sub, .rbt-megamenu', $siblingsItems).slideUp(200);
			}

			if ($subMenu[0]) {
				$subMenu.slideDown(200);
				$menuItem.addClass(hoverClass);
			}
		}

		$(document).on('click.techtNavMenu', hideVerticalSubBottomMenus);

		function hideVerticalSubBottomMenus(event) {
			if (!$scope.find('.techt-nav').hasClass('techt-nav--vertical-sub-bottom')) {
				return;
			}

			hideSubMenus(event);
		}
		// END Vertical Layout: Sub-menu at the bottom

		// Mobile trigger click event
		$('.techt-nav__mobile-trigger', $scope).on('click.techtNavMenu', function (event) {
			$(this).closest('.techt-nav-wrap').toggleClass(mobileActiveClass);
		});

		// START Mobile Layout: Left-side, Right-side
		if ('ontouchend' in window) {
			$(document).on('touchend.techtMobileNavMenu', removeMobileActiveClass);
		} else {
			$(document).on('click.techtMobileNavMenu', removeMobileActiveClass);
		}

		function removeMobileActiveClass(event) {
			var mobileLayout = $scope.find('.techt-nav-wrap').data('mobile-layout'),
				$navWrap = $scope.find('.techt-nav-wrap'),
				$trigger = $scope.find('.techt-nav__mobile-trigger'),
				$menu = $scope.find('.techt-nav');

			if ('left-side' !== mobileLayout && 'right-side' !== mobileLayout) {
				return;
			}

			if ('touchend' === event.type && scrollOffset !== $(window).scrollTop()) {
				return;
			}

			if ($(event.target).closest($trigger).length || $(event.target).closest($menu).length) {
				return;
			}

			if (!$navWrap.hasClass(mobileActiveClass)) {
				return;
			}

			$navWrap.removeClass(mobileActiveClass);

			event.stopPropagation();
		}

		$('.techt-nav__mobile-close-btn', $scope).on('click.techtMobileNavMenu', function (event) {
			$(this).closest('.techt-nav-wrap').removeClass(mobileActiveClass);
		});

		// END Mobile Layout: Left-side, Right-side

		// START Mobile Layout: Full-width
		var initMobileFullWidthCss = false;

		setFullWidthMenuPosition();
		$(window).on('resize.techtMobileNavMenu', setFullWidthMenuPosition);

		function setFullWidthMenuPosition() {
			var mobileLayout = $scope.find('.techt-nav-wrap').data('mobile-layout');

			if ('full-width' !== mobileLayout) {
				return;
			}

			var $menu = $scope.find('.techt-nav'),
				currentDeviceMode = elementorFrontend.getCurrentDeviceMode();

			if ('mobile' !== currentDeviceMode) {
				if (initMobileFullWidthCss) {
					$menu.css({ 'left': '' });
					initMobileFullWidthCss = false;
				}
				return;
			}

			if (initMobileFullWidthCss) {
				$menu.css({ 'left': '' });
			}

			var offset = - $menu.offset().left;

			if(isRtl()){
				$menu.css({ 'right': -offset });
			}else{
				$menu.css({ 'left': offset });
			}
			initMobileFullWidthCss = true;
		}
		// END Mobile Layout: Full-width
		// Menu Anchors Handler
		function initMenuAnchorsHandler() {
			var $anchorLinks = $scope.find('.menu-item-link[href*="#"]');

			if ($anchorLinks[0]) {
				$anchorLinks.each(function () {
					if ('' !== this.hash && location.pathname === this.pathname) {
						menuAnchorHandler($(this));
					}
				});
			}
		}

		function menuAnchorHandler($anchorLink) {
			var anchorHash = $anchorLink[0].hash,
				activeClass = 'current-menu-item',
				rootMargin = '-50% 0% -50%',
				$anchor;

			try {
				$anchor = $(decodeURIComponent(anchorHash));
			} catch (e) {
				return;
			}

			if (!$anchor[0]) {
				return;
			}

			if ($anchor.hasClass('elementor-menu-anchor')) {
				rootMargin = '300px 0% -300px';
			}

			var observer = new IntersectionObserver(function (entries) {
				if (entries[0].isIntersecting) {
					$anchorLink.parent('.menu-item').addClass(activeClass);
				} else {
					$anchorLink.parent('.menu-item').removeClass(activeClass);
				}
			},
				{
					rootMargin: rootMargin
				}
			);

			observer.observe($anchor[0]);
		}

		if (isEditMode()) {
			$scope.data('initialized', false);
		}
	};

	/* ---------------------------------------------
	 Hamburger Panel
	--------------------------------------------- */
	var techtHamburgerPanel = function( $scope ) {
		var $panel        = $( '.techt-hamburger-panel', $scope ),
			$toggleButton = $( '.techt-hamburger-panel__toggle', $scope ),
			$instance     = $( '.techt-hamburger-panel__instance', $scope ),
			$cover        = $( '.techt-hamburger-panel__cover', $scope ),
			$inner        = $( '.techt-hamburger-panel__inner', $scope ),
			$closeButton  = $( '.techt-hamburger-panel__close-button', $scope ),
			$panelContent = $( '.techt-hamburger-panel__content', $scope),
			scrollOffset,
			timer,
			timer2,
			editMode      = Boolean( elementorFrontend.isEditMode() ),
			$html         = $( 'html' ),
			settings      = $panel.data( 'settings' ) || {},
			eContainer    = $scope.parents( '.e-container' );

		function fixElementorContainerZIndex( e, open = true ) {
			if ( open ) {
				eContainer.css( 'z-index', 999 );
				e.parent( '.e-container' ).css( 'z-index', 999 );
			} else if ( false === open ) {
				eContainer.css( 'z-index', '' );
				e.parent( '.e-container' ).css( 'z-index', '' );
			}
		}

		if ( 'ontouchend' in window || 'ontouchstart' in window ) {
			$toggleButton.on( 'touchstart', function( event ) {
				scrollOffset = $( window ).scrollTop();
			} );

			$toggleButton.on( 'touchend', function( event ) {
				if ( scrollOffset !== $( window ).scrollTop() ) {
					return false;
				}

				if ( timer ) {
					clearTimeout( timer );
				}

				if ( timer2 ) {
					clearTimeout( timer2 );
				}

				if ( ! $panel.hasClass( 'open-state' ) ) {
					timer = setTimeout( function() {
						fixElementorContainerZIndex( $( this ) );
						$panel.addClass( 'open-state' );
					}, 10 );
					$html.addClass( 'techt-hamburger-panel-visible' );
					initAnimationsHandlers( $inner );

					if ( settings['ajaxTemplate'] ) {
						ajaxLoadTemplate( $panelContent, settings );
					}
				} else {
					$panel.removeClass( 'open-state' );
					$html.removeClass( 'techt-hamburger-panel-visible' );
					timer2 = setTimeout( function() {
						fixElementorContainerZIndex( $( this ), false );
					}, 400 );
				}
			} );

		} else {
			$toggleButton.on( 'click', function( event ) {

				if ( timer ) {
					clearTimeout( timer );
				}

				if ( ! $panel.hasClass( 'open-state' ) ) {
					fixElementorContainerZIndex( $( this ) );
					$panel.addClass( 'open-state' );
					$html.addClass( 'techt-hamburger-panel-visible' );
					initAnimationsHandlers( $inner );

					if ( settings['ajaxTemplate'] ) {
						ajaxLoadTemplate( $panelContent, settings );
					}
				} else {
					$panel.removeClass( 'open-state' );
					$html.removeClass( 'techt-hamburger-panel-visible' );
					timer = setTimeout( function() {
						fixElementorContainerZIndex( $( this ), false );
					}, 400 );
				}
			} );

			$toggleButton.on( 'keydown', function( e ) {
				if ( e.key === "Enter" ) {
					if ( timer ) {
						clearTimeout( timer );
					}
					if ( ! $panel.hasClass( 'open-state' ) ) {
						fixElementorContainerZIndex( $( this ) );
						$panel.addClass( 'open-state' );
						$html.addClass( 'techt-hamburger-panel-visible' );
						initAnimationsHandlers( $inner );

						if ( settings['ajaxTemplate'] ) {
							ajaxLoadTemplate( $panelContent, settings );
						}
					} else {
						$panel.removeClass( 'open-state' );
						$html.removeClass( 'techt-hamburger-panel-visible' );
						timer = setTimeout( function() {
							fixElementorContainerZIndex( $( this ), false );
						}, 400 );
					}
				}
			} );
		}

		$closeButton.on( 'click', function( event ) {
			if ( timer ) {
				clearTimeout( timer );
			}

			if ( ! $panel.hasClass( 'open-state' ) ) {
				$panel.addClass( 'open-state' );
				$html.addClass( 'techt-hamburger-panel-visible' );
				initAnimationsHandlers( $inner );
			} else {
				$panel.removeClass( 'open-state' );
				$html.removeClass( 'techt-hamburger-panel-visible' );
				timer = setTimeout( function() {
					fixElementorContainerZIndex( $( this ), false );
				}, 400 );
			}
		} );

		$( document ).on( 'click', function( event ) {
			if ( ( $( event.target ).closest( $toggleButton ).length || $( event.target ).closest( $instance ).length )
				&& ! $( event.target ).closest( $cover ).length
			) {
				return;
			}

			if ( ! $panel.hasClass( 'open-state' ) ) {
				return;
			}

			$panel.removeClass( 'open-state' );

			if ( ! $( event.target ).closest( '.techt-hamburger-panel__toggle' ).length ) {
				$html.removeClass( 'techt-hamburger-panel-visible' );
			}

			event.stopPropagation();
		} );



		/**
		 * [ajaxLoadTemplate description]
		 * @param  {[type]} $index [description]
		 * @return {[type]}        [description]
		 */
		function ajaxLoadTemplate( $panelContent, $settings ) {
			var $contentHolder = $panelContent,
				templateLoaded = $contentHolder.data( 'template-loaded' ) || false,
				templateId     = $contentHolder.data( 'template-id' ),
				loader         = $( '.techt-hamburger-panel-loader', $contentHolder ),
				cachedTemplate = $settings['ajaxTemplateCache'],
				widgetId       = $settings['widget_id'],
				signature      = $settings['signature'];

			if ( templateLoaded ) {
				return false;
			}

			$( window ).trigger( 'techt/ajax-load-template/before', {
				target: $panel,
				contentHolder: $contentHolder
			} );

			$contentHolder.data( 'template-loaded', true );

			$.ajax( {
				type: 'post',
				url: window.techt_hamburger_panel_settings.ajaxurl,
				dataType: 'json',
				data: {
					'action'		: 'get_techt_template_content',
					'id'            : templateId,
					'dev'           : window.techt_hamburger_panel_settings.devMode,
					'cachedTemplate': cachedTemplate,
					'widget_id'     : widgetId,
					'signature'     : signature
				},
				beforeSend: function( jqXHR ) {
					jqXHR.setRequestHeader( 'X-WP-Nonce', window.techt_hamburger_panel_settings.restNonce );
				},
				success: function( responce, textStatus, jqXHR ) {
					var templateContent     = responce.data['template_content'];
					loader.remove();
					$contentHolder.append( templateContent );
					$( window ).trigger( 'techt/ajax-load-template/after', {
						target: $panel,
						contentHolder: $contentHolder,
						responce: responce
					} );
					// }, function( reason ) {
					// 	console.log( 'Script Loaded Error' );
					// });
				}
			} );//end
		}
	};

	/* ---------------------------------------------
	 Progress Bar
	--------------------------------------------- */
	var ProgressbarHandler = function ($scope, $) {
		$(".progress").each(function () {
			var $this = $(this);
			$this.find(".techt-progress-value").text($this.attr("data-progress-value"));
			$this.isInViewport(function (status) {
				if (status === "entered") {
					$this.find(".progress-bar").width($this.attr("data-progress-width"));
					$this.find(".techt-progress-value").css("right", "calc(" + $this.attr("data-progress-width") + " - 46px)");
				}
			});
		});
	};

	/* ---------------------------------------------
	 Accordion
	--------------------------------------------- */
	var techtAccordion = function ($scope) {
		var $target = $scope;
		$target.find(".techt-open .techt-accordion-content").show();
		$target.find('.techt-accordion-item').on("click", function() {
			if ($(this).hasClass("techt-open")) {
				$(this).removeClass("techt-open");
				$(this).children(".techt-accordion-content").slideUp("slow");
			} else {
				if ($(this).hasClass("multiple")) {}
				else {
					$(".techt-accordion-item").removeClass("techt-open");
					$(".techt-accordion-content").slideUp("slow");
				}
				$(this).addClass("techt-open");
				$(this).children(".techt-accordion-content").slideDown("slow");
			}
		});
	};
	/* ---------------------------------------------
	 Mini Cart
	--------------------------------------------- */
	var techtMiniCart = function ($scope) {
		var $target = $scope,
			instance = null;
		// editMode  = Boolean( elementor.isEditMode() );

		// if ( window.techtElements.hasOwnProperty( 'techtParallaxSections' ) || editMode ) {
		instance = new techtWooMiniCart($target);
		instance.init();
		// }
	};

	window.techtWooMiniCart = function($scope){
		var self 		= this,
			node  		= $scope,
			wrap  		= $scope.find('.techt-woo-mini-cart-container'),
			element 	= node.find('a.techt-woo-cart-contents'),
			behaviour 	= wrap.data('target'),
			isPreview	= false;

		self.init = function() {
			self.bindEvents();
		},

		self.bindEvents = function() {
			element.on('click', self.toggleCart);

			element.on('mouseover', function(e) {
				e.preventDefault();			
				self.showCart();
			});
			node.find('.techt-woo-mini-cart-wrap').on('mouseover', function(e) {
				e.preventDefault();			
				self.showCart();
			});
			element.on('mouseout', function(e) {
				e.preventDefault();			
				self.hideCart();
			});
			node.find('.techt-woo-mini-cart-wrap').on('mouseout', function(e) {
				e.preventDefault();			
				self.hideCart();
			});
		},

		self.showCart = function() {
			node.find('.techt-woo-mini-cart-wrap').addClass('show-mini-cart');
		},

		self.hideCart = function() {
			node.find('.techt-woo-mini-cart-wrap').removeClass('show-mini-cart');
		},

		self.toggleCart = function(e) {
			e.preventDefault();
			node.find('.techt-woo-mini-cart-wrap').toggleClass('show-mini-cart');
		},

		self.togglePreview = function() {
			if ( ! isPreview ) {
				isPreview = true;
				self.showCart();
			} else {
				isPreview = false;
				self.hideCart();
			}
		},

		self.renderPreview = function() {
			isPreview = true;
			self.showCart();
		}
	};	

	/* ---------------------------------------------
	 Initialize Elementor Front Script
	--------------------------------------------- */
	$(window).on('elementor/frontend/init', function () {

		if (elementorFrontend.isEditMode()) {
			var editMode = true;
		}

		// Bubble Header
		elementorFrontend.hooks.addAction('frontend/element_ready/techt-buble-headings.default', BubbleHeadings);

		// Bubble Header
		elementorFrontend.hooks.addAction('frontend/element_ready/techt-video-popup-btn.default', VideoPopup);

		// Coming Soon ELements
		elementorFrontend.hooks.addAction('frontend/element_ready/techt-coming-soon-counter.default', comingSoonCounter);

		elementorFrontend.hooks.addAction('frontend/element_ready/techt-image-headings.default', techtImageHeading);

		elementorFrontend.hooks.addAction('frontend/element_ready/techt-hamburger-panel.default', techtHamburgerPanel);

		elementorFrontend.hooks.addAction('frontend/element_ready/techt-nav-menu.default', techtNavMenu);

		elementorFrontend.hooks.addAction('frontend/element_ready/techt-circle-progress.default', techtCircleProgress);

		elementorFrontend.hooks.addAction('frontend/element_ready/techt-search-box.default', searchBox);

		elementorFrontend.hooks.addAction('frontend/element_ready/techt-login-register.default', loginRegister);

		elementorFrontend.hooks.addAction('frontend/element_ready/techt-service-pricing.default', servicePricing);

		elementorFrontend.hooks.addAction('frontend/element_ready/techt-animated-box.default', animatedBox);
		// Bubble Header
		elementorFrontend.hooks.addAction('frontend/element_ready/techt-progressbar.default', ProgressbarHandler);

		elementorFrontend.hooks.addAction('frontend/element_ready/techt-woo-mini-cart.default', techtMiniCart);

		elementorFrontend.hooks.addAction('frontend/element_ready/techt-accordion.default', techtAccordion);

		$(document).on('click', '.techt-search__popup-trigger', searchPopupSwitch)
			.on('click', '.techt-search__popup-close', searchPopupSwitch);

		/* ---------------------------------------------
			Blog Elements
		--------------------------------------------- */
		var WidgetBlogGridAjax = elementorModules.frontend.handlers.Base.extend({
			onInit: function () {
				elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);
				this.$container = this.$element.find('.techt-blog-wrapper');
				if (this.$container.length) {
					this.run();
				}
			},
			run: function () {
				var self = this;
				var $carousel = this.$container.children('.swiper-container').length ? this.$container.children('.swiper-container') : this.$container.children('.swiper'),
					$slider_options = JSON.parse($carousel.attr('data-slider-settings'));
				if (typeof Swiper !== 'undefined') {
					var mySwiper = new Swiper($carousel, $slider_options);
				} else {
					const asyncSwiper = elementorFrontend.utils.swiper;
					new asyncSwiper($carousel, $slider_options).then((newSwiperInstance) => {
						mySwiper = newSwiperInstance;
					});
					var Swiper = elementorFrontend.utils.swiper;
					// var get_data =  new Swiper( $carousel, $slider_options );
					$carousel.data('swiper', mySwiper);
				}
			},
		});
		/* ---------------------------------------------
		 Petrona Portfolio
		--------------------------------------------- */
		var portfolioGrid = elementorModules.frontend.handlers.Base.extend({
			onInit: function () {
				elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);
				var itemLayout = this.getElementSettings('portfolio_layout');
				if (itemLayout == 'carousel') {
					this.$container = this.$element.find('.techt-portfolio-wrapper');
					this.carousel();
				} else {
					this.$container = this.$element.find('.portfolio-grid');
					this.run();
					this.runFilter();
				}
			},
			getLayoutMode: function () {
				var layout = this.getElementSettings('masonry_layout');
				return (layout === 'even' || 'justify' ? 'masonry' : layout);
			},
			getDefaultSettings: function () {

				var _originLeft = '';

				if (isRtl()) {
					_originLeft = false;
				} else {
					_originLeft = true;
				}

				return {
					itemSelector: '.item',
					percentPosition: true,
					layoutMode: this.getLayoutMode(),
					originLeft: _originLeft
				};
			},
			onElementChange: function (changedProp) {
				if (['masonry_layout', 'number_grids'].indexOf(changedProp) !== -1) {
					this.run();
				}
			},
			runFilter: function () {
				var self = this;
				var filterElement = this.$element.find('.portfolio-filters li a');
				var isoargs = self.getDefaultSettings();

				filterElement.on('click', function (e) {
					e.preventDefault();
					filterElement.removeClass("active");
					$(this).addClass("active");

					var selector = $(this).attr('data-filter');
					self.$container.isotope({
						itemSelector: isoargs.itemSelector,
						originLeft: isoargs.originLeft,
						filter: selector,
						animationOptions: {
							duration: 750,
							easing: 'linear',
							queue: false,
						}
					});
				});
				self.$container.on('arrangeComplete', function () {
					$("[data-animate]").scrolla({
						mobile: true,
						once: false
					});
				});
				if (this.getElementSettings('pagination_types') !== 'load_more_ajax') {
					var mainContainer = self.$container;
					var getItem = mainContainer.find('.item');
					this.$element.find('.portfolio-filters li').each(function (i) {
						var getDataFilter = $(this).children('a').data("filter");
						if (getDataFilter !== '*') {
							var getCatFilter = $(this).children('a').data("filter");
							var element = mainContainer.find(getCatFilter).length;
							$(this).find('span').html(element);
						}
					});
				}
			},
			carousel: function () {
				var self = this;
				var $carousel = this.$container.children('.swiper-container').length ? this.$container.children('.swiper-container').length : this.$container.children('.swiper'),
					$slider_options = JSON.parse($carousel.attr('data-slider-settings'));
				if (typeof Swiper !== 'undefined') {
					var mySwiper = new Swiper($carousel, $slider_options);
				} else {
					const asyncSwiper = elementorFrontend.utils.swiper;
					new asyncSwiper($carousel, $slider_options).then((newSwiperInstance) => {
						mySwiper = newSwiperInstance;
					});
					var Swiper = elementorFrontend.utils.swiper;
					// var get_data =  new Swiper( $carousel, $slider_options );
					$carousel.data('swiper', mySwiper);
				}
				initPopupGallery(this.$element, '.techt-js-popup', true, 'portfolioimagegrid');
				initPopupVideo(this.$element, '.techt-js-video-popup', true, 'portfoliovideogrid');
				initPopupMultipleGallery(this.$element, '.techt-js-gallery-popup', '.portfolio-gallery-content', true, 'portfoliomultiplegrid');
			},
			run: function () {
				var self = this;
				var isoargs = self.getDefaultSettings();
				var mainContainer = self.$container;
				var $item = mainContainer.find('.item');
				var $featureItem = mainContainer.find('.item.feature');
				var colCount = this.getElementSettings('number_grids');
				if(mobileAndTabletCheck()){
					if($featureItem.length){
						var height = $item.eq(1).outerHeight(true);
						var itemPaddingLeft = $item.eq(1).css('padding-left');
						var itemPaddingRight = $item.eq(1).css('padding-right');
						var gutter = itemPaddingLeft + itemPaddingRight;
						$featureItem.height(height + gutter);
						$featureItem.find('img').height(height);
					}
				}
				if (isoargs.layoutMode != 'justify') {
					this.$container.isotope(isoargs);
					this.$container.imagesLoaded().progress(function () {
						self.$container.isotope('layout');
					});
				}

				if (this.getElementSettings('pagination_types') === 'load_more_ajax') {
					var mainContainer = this.$container;
					var getItem = mainContainer.find('.item');
					var filterElement = this.$element.find('.portfolio-filters li');
					filterElement.each(function (i) {
						var getDataFilter = $(this).children('a').data("filter");
						if (getDataFilter !== '*') {
							var getCatFilter = $(this).children('a').data("filter");
							var element = mainContainer.find(getCatFilter).length;
							$(this).find('span').html(element);
						}
					});
					if (this.$element.find('.pagination-block').length) {
						var defaults = {
							path: '.pagination-block a.next',
							append: '.item',
							status: '.infinite-scroll-status'
						}, data = {};
						var data = {
							button: '.btn-more-works', // Load posts on button click.
							scrollThreshold: false, // Disable loading on scroll.
							history: false
						};
						$.extend(data, defaults);
						mainContainer.infiniteScroll(data);
						var elementContent = this.$element;
						mainContainer.on('append.infiniteScroll', function (event, response, path, items) {
							$(items).hide();
							$(items).imagesLoaded(function () {
								$(items).fadeIn();
								mainContainer.isotope('insert', items);
								$("[data-animate]").scrolla({
									mobile: true,
									once: true
								});
							});
							$('.infinite-scroll-status').hide();
							var count = mainContainer.find('.item').length;
							var getCategorySlug = mainContainer.find('.item');
							filterElement.each(function (i) {
								var getDataFilter = $(this).children('a').data("filter");
								if (getDataFilter !== '*') {
									var getCatFilter = $(this).children('a').data("filter");
									var element = mainContainer.find(getCatFilter).length;
									$(this).find('span').html(element);
								} else {
									$(this).find('#all').children('span').html(count);
								}
							});
							initPopupGallery(elementContent, '.techt-js-popup', true, 'portfolioimagegrid');
							initPopupVideo(elementContent, '.techt-js-video-popup', true, 'portfoliovideogrid');
							initPopupMultipleGallery(elementContent, '.techt-js-gallery-popup', '.portfolio-gallery-content', true, 'portfoliomultiplegrid');
						});
					}
				}
				initPopupGallery(this.$element, '.techt-js-popup', true, 'portfolioimagegrid');
				initPopupVideo(this.$element, '.techt-js-video-popup', true, 'portfoliovideogrid');
				initPopupMultipleGallery(this.$element, '.techt-js-gallery-popup', '.portfolio-gallery-content', true, 'portfoliomultiplegrid');
			}
		});
		/* ---------------------------------------------
		 Petrona Testimonial Carousel
		--------------------------------------------- */
		var testimonialCarousel = elementorModules.frontend.handlers.Base.extend({
			onInit: function () {
				elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);
				this.$container = this.$element.find('.techt-testimonial-wrapper');
				this.run();
			},
			run: function () {
				var self = this;
				var $carousel = this.$container.children('.swiper-container').length ? this.$container.children('.swiper-container') : this.$container.children('.swiper'),
					$slider_options = JSON.parse($carousel.attr('data-slider-settings'));
				if (typeof Swiper !== 'undefined') {
					var mySwiper = new Swiper($carousel, $slider_options);
				} else {
					const asyncSwiper = elementorFrontend.utils.swiper;
					new asyncSwiper($carousel, $slider_options).then((newSwiperInstance) => {
						mySwiper = newSwiperInstance;
					});
					var Swiper = elementorFrontend.utils.swiper;
					$carousel.data('swiper', mySwiper);
				}
			}
		});
		/* ---------------------------------------------
		 Petrona Slider
		--------------------------------------------- */
		var WidgetSlider = elementorModules.frontend.handlers.Base.extend({
			onInit: function () {
				elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);
				this.$container = this.$element.find('.techt-slider-wrapper');
				if (this.$container.length) {
					this.run();
				}

			},
			getDefaultSettings: function () {
				return {
					selectors: {
						slider: '.tecSlider_wrap',
						slideInnerContents: '.tecSlider-slide-contents',
					},
					attributes: {
						dataAnimation: 'animation'
					}
				};
			},
			getDefaultElements: function () {
				const selectors = this.getSettings('selectors');

				return {
					$slider: this.$element.find(selectors.slider),
					$slideInnerContents: this.$element.find(selectors.slideInnerContents),
				};

			},
		
			run: function () {
				var settings = this.getSettings(),
					$thisSlider = this.elements.$slider,
					$slider_options = JSON.parse($thisSlider.attr('data-slider-settings')),
					$slideElements = this.elements.$slides,
					// $mainContainer = this.elements.$mainSwiper,
					dataAnimation = settings.attributes.dataAnimation,
					contentsAnimation = $thisSlider.data(dataAnimation),
					$animationElements = this.elements.$slideInnerContents.children();
					// $activeSlide = $slider.find('.swiper-slide-active');
					
				$animationElements.each(function () {
					
					var animation = $(this).data(dataAnimation) ? $(this).data(dataAnimation) : contentsAnimation;
					if (animation != 'none'){
						$(this).addClass('animated ' + animation);
					}
					
				});
				this.elements.$slider.tecSlider($slider_options);
			},

		});

		/* ---------------------------------------------
		 Petrona woo_product
		--------------------------------------------- */
		var WidgetWooProduct = elementorModules.frontend.handlers.Base.extend({
			getDefaultSettings: function () {
				return {
					selectors: {
						productsCarouselWrap:  '.swiper-container-wrap',
						productsCarousel:      '.pp-woo-products-inner',
						productsSliderWrapper: '.pp-woo-products-slider',
					},
				};
			},

			getDefaultElements: function () {
				const selectors = this.getSettings( 'selectors' );
				return {
					$productsCarouselWrap: this.$element.find( selectors.productsCarouselWrap ).eq( 0 ),
					$productsCarousel: this.$element.find( selectors.productsCarousel ).eq( 0 ),
					$productsSliderWrapper: this.$element.find( selectors.productsSliderWrapper ),
				};
			},

			bindEvents: function () {
				if ( this.elements.$productsSliderWrapper.length > 0 ) {
					jQuery( this.elements.$productsCarouselWrap ).closest('.elementor-widget-wrap').addClass('e-swiper-container');
					jQuery( this.elements.$productsCarouselWrap ).closest('.elementor-widget').addClass('swiper');
					jQuery( this.elements.$productsCarouselWrap ).find('.products').addClass('swiper-wrapper');

					if ( this.elements.$productsCarousel.length > 0 ) {
						var asyncSwiper           = elementorFrontend.utils.swiper,
							productssliderOptions = JSON.parse( this.$element.find( this.elements.$productsSliderWrapper ).attr( 'data-woo_slider' ) );

						var that = this;
		
						new asyncSwiper( this.elements.$productsCarousel, productssliderOptions ).then( function( newSwiperInstance ) {
							var mySwiper = newSwiperInstance;
							that.ppSwiperSliderAfterinit( that.$element, that.elements.$productsCarousel, that.elements.$productsCarouselWrap, productssliderOptions, mySwiper, 'product' );
						} );
					}
				}

				if ( !elementorFrontend.isEditMode() ) {
					/* Common */
					// this.RegisterPPQuickView( this.$element, $ );
					/* Style specific cart button */
					this.RegisterPPAddCart( this.$element, $ );
				}
		
				if ( elementorFrontend.isEditMode() ) {
					// this.RegisterPPQuickView( this.$element, $ );
				}
		
				var $variableProducts = this.$element.find( '.product_type_variable' );
				$variableProducts.each(function() {
					var variableProduct = $(this);
					variableProduct.removeClass( 'ajax_add_to_cart' );
				});

				if ( 0 === $('body').find( '.yith-wcan-filters' ).length ) {
					$( document )
					.off( 'click', '.woocommerce-pagination a.page-numbers' )
					.on( 'click', '.woocommerce-pagination a.page-numbers', function( e ) {
			
						var $productScope = $( this ).closest( '.elementor-widget-techt-woo-products' );
			
						if ( $productScope.find( '.pp-woocommerce' ).hasClass( 'pp-woo-query-main' ) ) {
							return;
						}
			
						e.preventDefault();
			
						$productScope.find( 'ul.products' ).after( '<div class="pp-woo-loader"><div class="pp-loader"></div><div class="pp-loader-overlay"></div></div>' );
			
						var widget_id = $productScope.data( 'id' ),
							page_id = $productScope.find( '.pp-woocommerce' ).data('page'),
							page_number = 1,
							curr = parseInt( $productScope.find( '.woocommerce-pagination .page-numbers.current' ).html() ),
							skin = $productScope.find( '.pp-woocommerce' ).data( 'skin' ),
							product_id = $productScope.find( '.pp-woocommerce' ).data( 'product-id' );
			
						if ( $( this ).hasClass( 'next' ) ) {
							page_number = curr + 1;
						} else if ( $( this ).hasClass( 'prev' ) ) {
							page_number = curr - 1;
						} else {
							page_number = $( this ).html();
						}

						$.ajax({
							url: pp_woo_products_script.ajax_url,
							data: {
								action: 'pp_get_products',
								page_id: page_id,
								widget_id: widget_id,
								skin: skin,
								page_number: page_number,
								product_id: product_id,
								nonce: pp_woo_products_script.get_product_nonce,
							},
							dataType: 'json',
							type: 'POST',
							success: function ( data ) {
								$productScope.find( '.pp-woo-loader' ).remove();
			
								$('html, body').animate({
									scrollTop: ( ( $productScope.find( '.pp-woocommerce' ).offset().top ) - 30 )
								}, 'slow');
			
								var sel = $productScope.find( '.pp-woo-products-inner ul.products' );
			
								sel.replaceWith( data.data.html );
								$productScope.find( '.woocommerce-pagination' ).replaceWith( data.data.pagination );
			
								var $variableProducts = $productScope.find( '.product_type_variable' );
								$variableProducts.each(function() {
									var variableProduct = $(this);
									variableProduct.removeClass( 'ajax_add_to_cart' );
								});
							}
						});
					} );
				}
			},

			ppSwiperSliderAfterinit: function ($scope, carousel, carouselWrap, elementSettings, mySwiper, slider_type) {
				this.equalHeight( $scope, slider_type );

				var that = this;

				mySwiper.on('slideChange', function () {
					that.equalHeight( $scope, slider_type );
				});

				if ( true === elementSettings.autoplay.pauseOnHover ) {
					carousel.on( 'mouseover', function() {
						mySwiper.autoplay.stop();
					});

					carousel.on( 'mouseout', function() {
						mySwiper.autoplay.start();
					});
				}

				if ( elementorFrontend.isEditMode() ) {
					carouselWrap.resize( function() {
						mySwiper.update();
					});
				}

				var $triggers = [
					'ppe-tabs-switched',
					'ppe-toggle-switched',
					'ppe-accordion-switched',
					'ppe-popup-opened',
				];

				$triggers.forEach(function(trigger) {
					if ( 'undefined' !== typeof trigger ) {
						$(document).on(trigger, function(e, wrap) {
							if ( wrap.find( '.pp-swiper-slider' ).length > 0 ) {
								setTimeout(function() {
									mySwiper.update();
								}, 100);
							}
						});
					}
				});

				var $containers = {
					".pp-advanced-tabs": ".pp-advanced-tabs-title",
					".pp-toggle-container": ".pp-toggle-switch",
					".elementor-tabs": ".elementor-tab-title",
				};

				$.each( $containers, function (main_parent, click_element) {
					if ($(mySwiper).closest(main_parent).length > 0) {
						$(mySwiper)
							.closest(main_parent)
							.find(click_element)
							.on("click", function () {
								setTimeout(function() {
									mySwiper.update();
								}, 100);
							});
					}
				});
			},

			equalHeight: function ($scope, slider_type) {
				var activeSlide = $scope.find( '.swiper-slide-visible' ),
					maxHeight   = -1;
		
				activeSlide.each( function() {
					var $this      = $( this );
						if ( 'product' === slider_type ) {
							var product    = $this.find( '.pp-woo-product-wrapper' ),
								productHeight = product.outerHeight();
								if ( maxHeight < productHeight ) {
									maxHeight = productHeight;
								}
						}
		
						if ( 'category' === slider_type ) {
							var category   = $this.find( '.pp-grid-item' ),
								categoryHeight = category.outerHeight();
							if ( maxHeight < categoryHeight ) {
								maxHeight = categoryHeight;
							}
						}
				});
		
				activeSlide.each( function() {
					if ( 'product' === slider_type ) {
						var selector = $( this ).find( '.pp-woo-product-wrapper' );
					}
					if ( 'category' === slider_type ) {
						var selector = $( this ).find( '.pp-grid-item' );
					}
					selector.animate({ height: maxHeight }, { duration: 200, easing: 'linear' });
				});
			},

			RegisterPPQuickView: function ($scope, $) {
				var scope_id = $scope.data("id");
				var quick_view_btn = $scope.find(".pp-quick-view-btn");
				var modal_wrap = $scope.find(".pp-quick-view-" + scope_id);

				modal_wrap.appendTo(document.body);

				var pp_quick_view_bg = modal_wrap.find(".pp-quick-view-bg"),
					pp_qv_modal = modal_wrap.find("#pp-quick-view-modal"),
					pp_qv_content = pp_qv_modal.find("#pp-quick-view-content"),
					pp_qv_close_btn = pp_qv_modal.find("#pp-quick-view-close"),
					pp_qv_wrapper = pp_qv_modal.find(".pp-content-main-wrapper"),
					pp_qv_wrapper_w = pp_qv_wrapper.width(),
					pp_qv_wrapper_h = pp_qv_wrapper.height();

				$scope
					.off("click", ".pp-quick-view-btn")
					.on("click", ".pp-quick-view-btn", function (e) {
						e.preventDefault();

						var $this = $(this);
						var wrap = $this.closest("li.product");
						var product_id = $this.data("product_id");

						if (!pp_qv_modal.hasClass("loading")) {
							pp_qv_modal.addClass("loading");
						}

						if (!pp_quick_view_bg.hasClass("pp-quick-view-bg-ready")) {
							pp_quick_view_bg.addClass("pp-quick-view-bg-ready");
						}

						$(document).trigger("pp_quick_view_loading");

						pp_qv_ajax_call($this, product_id);
					});

				var pp_qv_ajax_call = function (t, product_id) {
					pp_qv_modal.css("opacity", 0);

					$.ajax({
						url: pp_woo_products_script.ajax_url,
						data: {
							action: "pp_woo_quick_view",
							product_id: product_id,
						},
						dataType: "html",
						type: "POST",
						success: function (data) {
							pp_qv_content.html(data);
							pp_qv_content_height();
						},
					});
				};

				var pp_qv_content_height = function () {
					// Variation Form
					var form_variation = pp_qv_content.find(".variations_form");

					form_variation.trigger("check_variations");
					form_variation.trigger("reset_image");

					if (!pp_qv_modal.hasClass("open")) {
						pp_qv_modal.removeClass("loading").addClass("open");

						var scrollbar_width = pp_get_scrollbar_width();
						var $html = $("html");

						$html.css("margin-right", scrollbar_width);
						$html.addClass("pp-quick-view-is-open");
					}

					var var_form = pp_qv_modal.find(".variations_form");
					if (
						var_form.length > 0 &&
						"function" === typeof var_form.wc_variation_form
					) {
						var_form.wc_variation_form();
						var_form.find("select").change();
					}

					pp_qv_content.imagesLoaded(function (e) {
						var image_slider_wrap = pp_qv_modal.find(".pp-qv-image-slider");

						if (image_slider_wrap.find("li").length > 1) {
							image_slider_wrap.flexslider({
								animation: "slide",
								start: function (slider) {
									setTimeout(function () {
										pp_update_summary_height(true);
									}, 300);
								},
							});
						} else {
							setTimeout(function () {
								pp_update_summary_height(true);
							}, 300);
						}
					});

					// stop loader
					$(document).trigger("pp_quick_view_loader_stop");
				};

				var pp_qv_close_modal = function () {
					// Close box by click overlay
					pp_qv_wrapper.on("click", function (e) {
						if (this === e.target) {
							pp_qv_close();
						}
					});

					// Close box with esc key
					$(document).keyup(function (e) {
						if (e.keyCode === 27) {
							pp_qv_close();
						}
					});

					// Close box by click close button
					pp_qv_close_btn.on("click", function (e) {
						e.preventDefault();
						pp_qv_close();
					});

					var pp_qv_close = function () {
						pp_quick_view_bg.removeClass("pp-quick-view-bg-ready");
						pp_qv_modal.removeClass("open").removeClass("loading");
						$("html").removeClass("pp-quick-view-is-open");
						$("html").css("margin-right", "");

						setTimeout(function () {
							pp_qv_content.html("");
						}, 600);
					};
				};

				var pp_update_summary_height = function (update_css) {
					var quick_view = pp_qv_content,
						img_height = quick_view
							.find(".product .pp-qv-image-slider")
							.first()
							.height(),
						summary = quick_view.find(".product .summary.entry-summary"),
						content = summary.css("content");

					if (
						"undefined" != typeof content &&
						544 == content.replace(/[^0-9]/g, "") &&
						0 != img_height &&
						null !== img_height
					) {
						summary.css("height", img_height);
					} else {
						summary.css("height", "");
					}

					if (true === update_css) {
						pp_qv_modal.css("opacity", 1);
					}
				};

				var pp_get_scrollbar_width = function () {
					var div = $(
						'<div style="width:50px;height:50px;overflow:hidden;position:absolute;top:-200px;left:-200px;"><div style="height:100px;"></div>'
					);
					// Append our div, do our calculation and then remove it
					$("body").append(div);
					var w1 = $("div", div).innerWidth();
					div.css("overflow-y", "scroll");
					var w2 = $("div", div).innerWidth();
					$(div).remove();

					return w1 - w2;
				};

				pp_qv_close_modal();
				//pp_update_summary_height();

				window.addEventListener("resize", function (event) {
					pp_update_summary_height();
				});

				/* Add to cart ajax */
				/**
				 * pp_add_to_cart_ajax class.
				 */
				var pp_add_to_cart_ajax = function () {
					modal_wrap
						.off(
							"click",
							"#pp-quick-view-content .single_add_to_cart_button"
						)
						.off("pp_added_to_cart")
						.on(
							"click",
							"#pp-quick-view-content .single_add_to_cart_button",
							this.onAddToCart
						)
						.on("pp_added_to_cart", this.updateButton);
				};

				/**
				 * Handle the add to cart event.
				 */
				pp_add_to_cart_ajax.prototype.onAddToCart = function (e) {
					e.preventDefault();

					var $form = $(this).closest('form');

					// If the form inputs are invalid
					if ( ! $form[0].checkValidity() ) {
						$form[0].reportValidity();
						return false;
					}

					var $thisbutton = $(this),
						product_id = $(this).val(),
						variation_id = $('input[name="variation_id"]').val() || "",
						quantity = $('input[name="quantity"]').val();

					// Set Quantity.
					//
					// For grouped product quantity should be array instead of single value
					// For that set the quantity as array for grouped product.
					if ( $scope.find('.woocommerce-grouped-product-list-item' ).length ) {
						var quantities = $('input.qty'),
							quantity   = [];
						$.each( quantities, function(index, val) {

							var name = $( this ).attr( 'name' );

							name = name.replace('quantity[','');
							name = name.replace(']','');
							name = parseInt( name );

							if ( $( this ).val() ) {
								quantity[ name ] = $( this ).val();
							}
						} );
					}

					var cartFormData = $form.serialize();

					if ( $thisbutton.is(".single_add_to_cart_button") ) {
						$thisbutton.removeClass("added");
						$thisbutton.addClass("loading");

						// Ajax action.
						if (variation_id != "") {
							jQuery.ajax({
								url: pp_woo_products_script.ajax_url,
								type: "POST",
								data:
									"action=pp_add_cart_single_product&product_id=" +
									product_id +
									"&nonce=" + pp_woo_products_script.add_cart_nonce +
									"&" + cartFormData,

								success: function (results) {
									// Trigger event so themes can refresh other areas.
									$(document.body).trigger("wc_fragment_refresh");
									$(document.body).trigger("pp_added_to_cart", [
										$thisbutton,
									]);
									$thisbutton.removeClass("loading");
									$thisbutton.addClass("added");
								},
							});
						} else {
							jQuery.ajax({
								url: pp_woo_products_script.ajax_url,
								type: "POST",
								data:
									"action=pp_add_cart_single_product&product_id=" +
									product_id +
									"&nonce=" + pp_woo_products_script.add_cart_nonce +
									"&" + cartFormData,

								success: function (results) {
									// Trigger event so themes can refresh other areas.
									$(document.body).trigger("wc_fragment_refresh");
									modal_wrap.trigger("pp_added_to_cart", [
										$thisbutton,
									]);
								},
							});
						}
					}
				};

				/**
				 * Update cart page elements after add to cart events.
				 */
				pp_add_to_cart_ajax.prototype.updateButton = function (e, button) {
					button = typeof button === "undefined" ? false : button;

					if ($(button)) {
						$(button).removeClass("loading");
						$(button).addClass("added");
						$(button).addClass("testng");

						// View cart text.
						if (
							! pp_woo_products_script.is_cart && 
							$(button).parent().find('.added_to_cart').length === 0
						) {
							$(button).after(
								' <a href="' +
								pp_woo_products_script.cart_url +
								'" class="added_to_cart wc-forward" title="' +
								pp_woo_products_script.view_cart +
								'">' + 
								pp_woo_products_script.view_cart + 
								'</a>'
							);
						}
					}
				};

				/**
				 * Init pp_add_to_cart_ajax.
				 */
				new pp_add_to_cart_ajax();
			},

			RegisterPPAddCart: function ($scope, $) {
				/* Add to cart for styles */
				var style_add_to_cart = function () {
					//fa-spinner
		
					$(document.body)
						.off(
							"click",
							".pp-product-actions .pp-add-to-cart-btn.product_type_simple"
						)
						.off("pp_product_actions_added_to_cart")
						.on(
							"click",
							".pp-product-actions .pp-add-to-cart-btn.product_type_simple",
							this.onAddToCart
						)
						.on("pp_product_actions_added_to_cart", this.updateButton);
				};
		
				/**
				 * Handle the add to cart event.
				 */
				style_add_to_cart.prototype.onAddToCart = function (e) {
					e.preventDefault();
		
					var $thisbutton = $(this),
						product_id = $thisbutton.data("product_id"),
						quantity = 1,
						cart_icon = $thisbutton.find("pp-action-item");
		
					$thisbutton.removeClass("added");
					$thisbutton.addClass("loading");
		
					jQuery.ajax({
						url: pp_woo_products_script.ajax_url,
						type: "POST",
						data:
							"action=pp_add_cart_single_product&product_id=" +
							product_id +
							"&quantity=" +
							quantity +
							"&nonce=" + pp_woo_products_script.add_cart_nonce,
		
						success: function (results) {
							// Trigger event so themes can refresh other areas.
							$(document.body).trigger("wc_fragment_refresh");
							$(document.body).trigger(
								"pp_product_actions_added_to_cart",
								[$thisbutton]
							);
						},
					});
				};
		
				/**
				 * Update cart page elements after add to cart events.
				 */
				style_add_to_cart.prototype.updateButton = function (e, button) {
					button = typeof button === "undefined" ? false : button;
		
					if ($(button)) {
						$(button).removeClass("loading");
						$(button).addClass("added");
		
						// Show view cart notice.
						if (
							!pp_woo_products_script.is_cart &&
							$(button).parent().find(".added_to_cart").length === 0 &&
							pp_woo_products_script.is_single_product
						) {
							$(button).after(
								' <a href="' +
									pp_woo_products_script.cart_url +
									'" class="added_to_cart wc-forward" title="' +
									pp_woo_products_script.view_cart +
									'">' +
									pp_woo_products_script.view_cart +
									"</a>"
							);
						}
					}
				};
		
				/**
				 * Init style_add_to_cart.
				 */
				new style_add_to_cart();
			}
		});

		var WidgetMapAgencies = elementorModules.frontend.handlers.Base.extend({
			onInit: function () {
				elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);
				this.$container = this.$element.find('.elementor-iran-map-widget');
				if (typeof Highcharts === 'undefined') {
					return false;
				} else {
					this.renderWidgets();
				}
			},
			
			renderWidgets: function() {
				this.$container.each(function() {
					var $widget = $(this);
					var widgetID = $widget.attr('id');
					var settings = $widget.data('settings');
					
					// تنظیمات پیش‌فرض
					var defaultSettings = {
						mapTitle: 'نقشه ایران',
						activeProvince: '',
						hoverColor: '#ff7f00',
						selectedColor: '#ff0000',
						normalColor: '#90cdf4',
						borderColor: '#ffffff',
						borderWidth: 1,
						provinceLabelColor: '#333333',
						provinceLabelFontSize: 12,
						delegations: {}
					};
					
					settings = $.extend({}, defaultSettings, settings);

					var provincesData = [];
					var iranMapData = Highcharts.maps['countries/ir/ir-all'];

					// ایجاد داده‌های اولیه برای تمام استان‌ها
					iranMapData.features.forEach(function(feature) {
						var provinceName = feature.properties.name;
						var isActive = (settings.activeProvince && feature.properties['hc-key'] === settings.activeProvince);
						
						provincesData.push({
							'hc-key': feature.properties['hc-key'],
							name: provinceName,
							value: isActive ? 2 : 1, // مقدار برای رنگ‌آمیزی
							selected: isActive // آیا استان انتخاب شده است یا نه
						});
					});

					
					// ایجاد نقشه
					Highcharts.mapChart(widgetID, {
						chart: {
							map: 'countries/ir/ir-all',
							backgroundColor: 'transparent'
						},
						title: {
							text: settings.mapTitle,
							style: {
								color: settings.provinceLabelColor,
								fontSize: '16px'
							}
						},
						mapNavigation: {
							enabled: true,
							buttonOptions: {
								verticalAlign: 'bottom',
								theme: {
									fill: '#f7f7f7',
									stroke: '#e6e6e6',
									'stroke-width': 1,
									states: {
										hover: {
											fill: '#e6e6e6'
										},
										select: {
											fill: '#e0e0e0'
										}
									}
								}
							}
						},
						colorAxis: {
							min: 0,
							minColor: settings.normalColor,
							maxColor: settings.hoverColor
						},
						plotOptions: {
							series: {
								borderColor: settings.borderColor,
								borderWidth: settings.borderWidth,
								dataLabels: {
									style: {
										color: settings.provinceLabelColor,
										fontSize: settings.provinceLabelFontSize + 'px',
										textOutline: 'none',
										fontWeight: 'normal'
									}
								}
							}
						},
						series: [{
							data: provincesData, // استفاده از داده‌های واقعی به جای آرایه خالی
							name: 'ایران',
							states: {
								hover: {
									color: settings.hoverColor,
									borderColor: settings.borderColor,
									brightness: 0.1
								},
								select: {
									color: settings.selectedColor,
									borderColor: settings.borderColor
								}
							},
							dataLabels: {
								enabled: true,
								format: '{point.name}'
							},
							allowPointSelect: true,
							point: {
								events: {
									click: function() {
										var provinceName = this.name;
										var provinceKey = this['hc-key'];
										var delegations = settings.delegations[provinceKey] || [];
										
										// نمایش نمایندگی‌ها
										var delegationsHTML = '<h3>نمایندگی‌های استان ' + provinceName + '</h3>';
										
										if (delegations.length === 0) {
											delegationsHTML += '<p>هیچ نمایندگی ثبت نشده است</p>';
										} else {
											delegationsHTML += '<ul>';
											delegations.forEach(function(delegation) {
												delegationsHTML += '<li><strong>' + delegation.name + '</strong><br>' + delegation.address + '</li>';
											});
											delegationsHTML += '</ul>';
										}
										
										$widget.find('.iran-map-delegations').html(delegationsHTML);
									}
								}
							}
						}],
						tooltip: {
							headerFormat: '',
							pointFormat: '<b>{point.name}</b>',
							style: {
								fontSize: '14px'
							}
						}
					});
					
					// انتخاب استان فعال اگر تعریف شده باشد
					if (settings.activeProvince) {
						var chart = $('#' + widgetID).highcharts();
						var points = chart.series[0].points;
						
						for (var i = 0; i < points.length; i++) {
							if (points[i]['hc-key'] === settings.activeProvince) {
								// نمایش نمایندگی‌های استان فعال
								var delegations = settings.delegations[settings.activeProvince] || [];
								var delegationsHTML = '<h3>نمایندگی‌های استان ' + points[i].name + '</h3>';
								
								if (delegations.length === 0) {
									delegationsHTML += '<p>هیچ نمایندگی ثبت نشده است</p>';
								} else {
									delegationsHTML += '<ul>';
									delegations.forEach(function(delegation) {
										delegationsHTML += '<li><strong>' + delegation.name + '</strong><br>' + delegation.address + '</li>';
									});
									delegationsHTML += '</ul>';
								}
								
								$widget.find('.iran-map-delegations').html(delegationsHTML);
								break;
							}
						}
					}
				});
			}
		});

		var WidgetMapAgencies3 = elementorModules.frontend.handlers.Base.extend({
			onInit: function () {
				elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);
				this.$container = this.$element.find('.techt-map-container');
				var configs = elementorFrontend.config.configs || {};
				if (typeof Highcharts === 'undefined') {
					return false;
				} else {
					this.renderWidgets();
				}
			},
			
			renderWidgets: function() {
				var widgetId = this.$container.attr('id');
				var container = document.getElementById(widgetId);
				var mapContainer = container.querySelector('.map-container');
				var agenciesContainer = container.querySelector('.agencies-list');
				// var configJson = configs.config;
				var mapConfig = JSON.parse(container.getAttribute('data-config'));

				// تابع نمایش نمایندگی‌ها (با تغییرات جدید)
				function showAgencies(provinceCode) {
					const agencies = mapConfig.agencies[provinceCode] || [];
					const provinceName = mapConfig.provincesNames[provinceCode] || provinceCode;
					
					let html = '<h4>' + provinceName + '</h4>';
					if (agencies.length === 0) {
						html += '<p class="no-agency">' + mapConfig.noAgenciesText + '</p>';
					} else {
						html += '<ul class="agency-items">';
						agencies.forEach(agency => {
							html += `
							<li class="agency-item" data-province="${provinceCode}">
								<strong>${agency.name}</strong>
								<p class="agency-address"><span class="dashicons dashicons-location"></span> ${agency.address}</p>
								${agency.phone ? `<p class="agency-phone"><span class="dashicons dashicons-phone"></span> ${agency.phone}</p>` : ''}
								${agency.email ? `<p class="agency-email"><span class="dashicons dashicons-email-alt"></span> ${agency.email}</p>` : ''}
							</li>`;
						});
						html += '</ul>';
					}
					
					agenciesContainer.innerHTML = html;
					// setupAgencyClickHandlers(); // تنظیم event listeners جدید
				}
				

				// ایجاد نقشه
				var mapChart = Highcharts.mapChart(mapContainer, {
					chart: {
						map: 'countries/ir/ir-all',
						borderWidth: 1,
						borderColor: '#e0e0e0',
						borderRadius: 5,
						events: {
							load: function() {
								// انتخاب استان فعال پس از بارگذاری نقشه
								if (mapConfig.activeProvince) {
									var points = this.series[0].points;
									for (var i = 0; i < points.length; i++) {
										if (points[i]['hc-key'] === mapConfig.activeProvince) {
											points[i].select(true, false);
											break;
										}
									}
								}

								setTimeout(() => addMarkers(this, mapConfig), 500);
							}
            			}
     
					},
					title: {
						text: mapConfig.mapTitle,
						style: {
							color: mapConfig.textColor,
							fontSize: '16px',
							fontWeight: 'bold'
						}
					},
					mapNavigation: {
						enabled: true,
						buttonOptions: {
							verticalAlign: 'bottom',
							theme: {
								fill: '#f5f5f5',
								stroke: '#e0e0e0',
								'stroke-width': 1,
								states: {
									hover: {
										fill: '#e0e0e0'
									},
									select: {
										fill: '#d0d0d0'
									}
								}
							}
						}
					},
					colorAxis: {
						min: 1,
						max: 3,
						dataClasses: [{
							from: 0,
							to: 1,
							color: mapConfig.defaultColor,
							name: 'بدون نمایندگی'
						}, {
							from: 1,
							to: 2,
							color: mapConfig.hasAgencyColor,
							name: 'دارای نمایندگی'
						}, {
							from: 2,
							to: 3,
							color: mapConfig.activeColor,
							name: 'استان فعال'
						}]
					},
					legend: {
						enabled: false
					},
					// mapView: {
					// 	// center: [-4, 51], // Example: Center on a location in Europe
					// 	zoom: -1.2 // Example: Zoom level
					// },
					series: [{
						data: Object.keys(mapConfig.provincesNames).map(function(code) {
							var hasAgency = mapConfig.provincesWithAgencies.includes(code);
                			var isActive = code === mapConfig.activeProvince;
							return {
								keys: ['hc-key', 'value'],
								joinBy: 'hc-key',
								'hc-key': code,
								'value': isActive ? 2 : (hasAgency ? 1 : 0),
								customData: {
									hasAgency: hasAgency,
									isActive: isActive
            					}
							};
						}),
						name: mapConfig.mapTitle,
						dataLabels: {
							enabled: true,
							format: '{point.name}',
							style: {
								color: mapConfig.textColor,
								fontSize: '10px',
								textOutline: 'none'
							}
						},
						// color: '#000000',
						borderColor: mapConfig.borderColor,
						borderWidth: 1,
						states: {
							hover: {
								color: mapConfig.hoverColor,
								borderColor: '#000000',
								brightness: 0
							},
							select: {
								color: mapConfig.activeColor
							}
						},
						allowPointSelect: true,
						point: {
							events: {
								click: function() {
									showAgencies(this['hc-key']);
								},
								select: function() {
									showAgencies(this['hc-key']);
								}
							}
						}
					}
					// {
					// 	type: 'mappoint',
					// 	name: 'Agencies Markers',
					// 	color: mapConfig.markerColor,
					// 	data: mapConfig.showMarkers ? 
					// 		mapConfig.provincesWithAgencies.map(function(code) {
					// 			const center = getProvinceCenter(mapChart, code);
					// 			return {
					// 				name: mapConfig.provincesNames[code],
					// 				'hc-key': code,
					// 				x: center.x,
            		// 				y: center.y,
					// 				'marker': {
					// 					radius: mapConfig.markerSize,
					// 					fillColor: mapConfig.markerColor,
					// 					lineWidth: 2,
					// 					lineColor: '#ffffff',
					// 					symbol: 'circle'
					// 				}
					// 			};
					// 		}) : [],
					// 	enableMouseTracking: false,
					// 	showInLegend: false,
					// 	tooltip: {
        			// 		pointFormat: '<b>{point.name}</b>'
    				// 	}
					// }
					]

				});
				
				function addMarkers(chart, config) {
					if (!chart || !chart.series || chart.series.length === 0) {
						console.error('Chart not ready for markers');
						return;
					}
					// پیدا کردن نقاط استان‌های دارای نمایندگی
					const markersData  = config.provincesWithAgencies.map(code => {
						const provincePoint = chart.series[0].points.find(p => p['hc-key'] === code);
						return {
							'hc-key': code,
							name: config.provincesNames[code],
							x: provincePoint.bounds.midX || 0,
							y: provincePoint.bounds.midY || 0
						};
					});
					// اضافه کردن سری مارکرها
					chart.addSeries({
						type: 'mappoint',
						name: 'Agencies',
						data: config.showMarkers ? markersData : [],
						color: config.markerColor,
						marker: {
							radius: config.markerSize,
							fillColor: config.markerColor,
							lineWidth: 2,
							lineColor: '#ffffff',
							symbol: 'mapmarker',
							// states: {
							// 	hover: {
							// 		fillColor: Highcharts.Color(config.markerColor).brighten(0.2).get()
							// 	}
                			// }
						},
						dataLabels: {
                			enabled: true,
            			},
						tooltip: {
							pointFormat: '<b>{point.name}</b>'
						}
					}, false);

					chart.redraw(); 
				}
				

				// تنظیم سطح زوم اولیه
				if (mapConfig.zoomLevel) {
					mapChart.mapView.zoomBy(parseFloat(mapConfig.zoomLevel));
				}
				
				// نمایش نمایندگی‌های استان فعال (اگر تنظیم شده باشد)
				if (mapConfig.activeProvince) {
					showAgencies(mapConfig.activeProvince);
				}
				
				// پشتیبانی از تاچ در دستگاه‌های موبایل
				if ('ontouchstart' in window) {
					var observer = new MutationObserver(function(mutations) {
						mutations.forEach(function(mutation) {
							if (mutation.addedNodes) {
								var points = mapContainer.querySelectorAll('.highcharts-point');
								points.forEach(function(point) {
									point.addEventListener('touchstart', function() {
										var classes = this.getAttribute('class');
										var match = classes.match(/highcharts-key-(ir-\d+)/);
										if (match && match[1]) {
											showAgencies(match[1]);
										}
									});
								});
							}
						});
					});
					
					observer.observe(mapContainer, {
						childList: true,
						subtree: true
					});
				}

				// تابع برای فعال‌سازی استان روی نقشه
				// function highlightProvince(provinceCode) {
				// 	// غیرفعال کردن انتخاب قبلی
				// 	mapChart.series[0].points.forEach(point => {
				// 		point.select(false);
				// 	});

				// 	// غیرفعال کردن کلاس active از همه آیتم‌ها
				// 	document.querySelectorAll('.agency-item').forEach(item => {
				// 		item.classList.remove('active');
				// 	});

				// 	// پیدا کردن استان مورد نظر
				// 	const provincePoint = mapChart.series[0].points.find(p => p['hc-key'] === provinceCode);
				// 	if (provincePoint) {
				// 		// فعال کردن استان جدید
				// 		provincePoint.select(true);
						
				// 		// زوم روی استان انتخاب شده
				// 		mapChart.mapZoom(7, 
				// 			provincePoint.properties['hc-middle-x'], 
				// 			provincePoint.properties['hc-middle-y']
				// 		);

				// 		const bounds = provincePoint.bounds;
				// 		const x = bounds.midX;
				// 		const y = bounds.midY;
				// 		mapChart.mapView.setView([x, y], 0.001);
				// 	}

				// 	// اضافه کردن کلاس active به آیتم‌های مربوطه
				// 	const agencyNodes = document.querySelectorAll('.agency-item[data-province="' + provinceCode + '"]');
				// 	agencyNodes.forEach(item => {
				// 		item.classList.add('active');
				// 	});
				// }

				// اضافه کردن event listener به آیتم‌های نمایندگی
				// function setupAgencyClickHandlers() {
				// 	agenciesContainer.querySelectorAll('.agency-item').forEach(item => {
				// 		item.addEventListener('click', function() {
				// 			const provinceCode = this.getAttribute('data-province');
				// 			highlightProvince(provinceCode);
				// 		});
				// 	});
				// }
			}
		});

		var handlersClassMap = {
			'techt-portfolio.default': portfolioGrid,
			'techt-blog-grids.default': WidgetBlogGridAjax,
			'techt-testimonial-slider.default': testimonialCarousel,
			'techt-slider.default': WidgetSlider,
			'techt-woo-products.default': WidgetWooProduct,
			'techt-map-agencies-2.default': WidgetMapAgencies,
			'techt-map-agencies-3.default': WidgetMapAgencies3,
		};
		$.each(handlersClassMap, function (widgetName, handlerClass) {
			elementorFrontend.hooks.addAction('frontend/element_ready/' + widgetName, function ($scope) {
				elementorFrontend.elementsHandler.addHandler(handlerClass, { $element: $scope });
			});
		});
	});
}(jQuery));


