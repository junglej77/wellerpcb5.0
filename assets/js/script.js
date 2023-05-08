(function ($) {

	"use strict";

	//Update Header Style and Scroll to Top
	function headerStyle() {
		if ($('.main-header').length) {
			var windowpos = $(window).scrollTop();
			var siteWrap = $('.wellerpcb-wrapper');
			var scrollLink = $('.scroll-to-top');
			if (windowpos > 20) {
				siteWrap.addClass('fixed-header');
				scrollLink.fadeIn(300);
			} else {
				siteWrap.removeClass('fixed-header');
				scrollLink.fadeOut(300);
			}
		}
	}
	headerStyle();

	// 菜单激活
	function liCurrent() {
		$('li.current').parents('li').addClass('current');
	}

	// 手机菜单展示
	$(".nav_btn_wrap").on('click', function () {
		if ($(this).hasClass('mobile-open')) {
			$(this).removeClass('mobile-open')
			$('.main-mobile-menu').removeClass('mobile-open')
			$('.wellerpcb-wrapper').removeClass('mobile-open')

		} else {
			$(this).addClass('mobile-open')
			$('.main-mobile-menu').addClass('mobile-open')
			$('.wellerpcb-wrapper').addClass('mobile-open')
		}
	});


	// Scroll to a Specific Div
	if ($('.scroll-to-target').length) {
		$(".scroll-to-target").on('click', function () {
			var target = $(this).attr('data-target');
			// animate
			$('html, body').animate({
				scrollTop: $(target).offset().top
			}, 1500);

		});
	}

	// Elements Animation
	if ($('.wow').length) {
		var wow = new WOW(
			{
				boxClass: 'wow',      // animated element css class (default is wow)
				animateClass: 'animated', // animation css class (default is animated)
				offset: 0,          // distance to the element when triggering the animation (default is 0)
				mobile: false,       // trigger animations on mobile devices (default is true)
				live: true       // act on asynchronously loaded content (default is true)
			}
		);
		wow.init();
	}

	if ($('.page-screen').length) {
		if ($(window).width() > 1200) {
			$('.page-screen').height($(window).height())
		}
	}


	if ($('.chooseDtail').length) {
		$(".chooseDtail").on('click', function () {
			$(".chooseDtail_text_wrap").removeClass('open')
			var p = $(this).find('.text').text();
			$('.chooseDtail_text_wrap .content').html(p);
			$(".chooseDtail_text_wrap .chooseDtail_text").css({ 'visibility': 'visible', 'animation-name': 'bounceIn' })
			setTimeout(function () {
				$(".chooseDtail_text_wrap").addClass('open')
			}, 1)
		});
	}

	if ($('.chooseDtail_text_wrap .close_btn').length) {
		$(".chooseDtail_text_wrap .close_btn").on('click', function () {
			$(".chooseDtail_text_wrap .chooseDtail_text").css({ 'animation-name': 'bounceOut' })
			setTimeout(function () {
				$(".chooseDtail_text_wrap").removeClass('open')
			}, 1000)
		});
	}


	// Banner Swiper
	if ($('#indexBanner').length) {
		var mySwiper = new Swiper('#indexBanner', {
			autoplay: true,//可选选项，自动滑动
			loop: true,
			loopFillGroupWithBlank: true,
			delay: 2500,
			allowTouchMove: true,
			effect: 'fade',
			on: {
				init: function () {
					swiperAnimateCache(this); //隐藏动画元素
					swiperAnimate(this); //初始化完成开始动画
				},
				slideChangeTransitionEnd: function () {
					this.slides.eq(this.activeIndex).find('.ani').attr('swiper-animate-effect', (this.activeIndex - this.previousIndex) > 0 ? 'fadeInLeft' : 'fadeInRight')
					swiperAnimate(this); //每个slide切换结束时也运行当前slide动画
					//this.slides.eq(this.activeIndex).find('.ani').removeClass('ani'); 动画只展现一次，去除ani类名
				}
			}
		});
		//不使用自带的按钮组件，使用lock控制按钮锁定时间
		mySwiper.$el.find('.button-next').on('click', function () {
			mySwiper.slideNext();
		})
		mySwiper.$el.find('.button-prev').on('click', function () {
			mySwiper.slidePrev();
		})
	}

	if ($('#PartnerSwiper').length) {
		var myPartnerSwiper = new Swiper('#PartnerSwiper', {
			autoplay: true,//可选选项，自动滑动
			delay: 2000,
			slidesPerView: 1,
			loop: true,
			grabCursor: true,
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
			},
			breakpoints: {
				400: {
					slidesPerView: 2,
					spaceBetween: 10,
				},
				576: {
					slidesPerView: 3,
					spaceBetween: 10,
				},
				700: {
					slidesPerView: 4,
					spaceBetween: 20
				},
				850: {
					slidesPerView: 5,
					spaceBetween: 20
				},
				1000: {  //当屏幕宽度大于等于1000
					slidesPerView: 6,
					spaceBetween: 30
				},
				1200: {  //当屏幕宽度大于等于1200
					slidesPerView: 8,
					spaceBetween: 60
				}
			}
		})
	}

	if ($('#myCustomersSwiper').length) {
		var myPartnerSwiper = new Swiper('#myCustomersSwiper', {
			// autoplay: true,//可选选项，自动滑动
			loop: true,
			speed: 1000,
			slidesPerView: 1,
			centeredSlides: true,
			watchSlidesProgress: true,
			on: {
				setTranslate: function () {
					var slides = this.slides
					for (var i = 0; i < slides.length; i++) {
						var slide = slides.eq(i)
						var progress = slides[i].progress
						//slide.html(progress.toFixed(2)); 看清楚progress是怎么变化的
						slide.css({ 'opacity': '', 'background': '' }); slide.transform('');//清除样式
						slide.css('opacity', (1 - Math.abs(progress) / 6));
						slide.transform('translate3d(0,' + Math.abs(progress) * 10 + 'px, 0) scale(' + (1 - Math.abs(progress) / 5) + ')');
					}
				},
				setTransition: function (transition) {
					for (var i = 0; i < this.slides.length; i++) {
						var slide = this.slides.eq(i)
						slide.transition(transition);
					}
				},
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
			},
			breakpoints: {
				768: {
					slidesPerView: 2,
				},
				992: {
					slidesPerView: 3,
				},
				1200: {  //当屏幕宽度大于等于1200
					slidesPerView: 3,
					spaceBetween: 10,
				}
			}
		})
	}

	if ($('#blogSwiper').length) {
		var myPartnerSwiper = new Swiper('#blogSwiper', {
			// autoplay: true,//可选选项，自动滑动
			loop: true,
			speed: 1000,
			slidesPerView: 1,
			spaceBetween: 20,
			centeredSlides: false,
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
			},
			breakpoints: {
				576: {
					centeredSlides: true,
					slidesPerView: 2,
					spaceBetween: 20,
				},
				768: {
					slidesPerView: 2,
					spaceBetween: 15,
				},
				1200: {  //当屏幕宽度大于等于1200
					centeredSlides: true,
					slidesPerView: 3,
					spaceBetween: 10,
				}
			}
		})
	}
	//Fact Counter + Text Count
	if ($('.count-box').length) {
		$('.count-box').appear(function () {

			var $t = $(this),
				n = $t.find(".count-text").attr("data-stop"),
				r = parseInt($t.find(".count-text").attr("data-speed"), 10);

			if (!$t.hasClass("counted")) {
				$t.addClass("counted");
				$({
					countNum: $t.find(".count-text").text()
				}).animate({
					countNum: n
				}, {
					duration: r,
					easing: "linear",
					step: function () {
						$t.find(".count-text").text(Math.floor(this.countNum));
					},
					complete: function () {
						$t.find(".count-text").text(this.countNum);
					}
				});
			}

		}, { accY: 0 });
	}
	//Sortable Masonary with Filters
	function enableMasonry() {
		if ($('.sortable-masonry').length) {

			var winDow = $(window);
			// Needed variables
			var $container = $('.sortable-masonry .items-container');
			var $filter = $('.filter-btns');

			$container.isotope({
				filter: '*',
				masonry: {
					columnWidth: '.masonry-item.col-lg-3'
				},
				animationOptions: {
					duration: 500,
					easing: 'linear'
				}
			});


			// Isotope Filter
			$filter.find('li').on('click', function () {
				var selector = $(this).attr('data-filter');

				try {
					$container.isotope({
						filter: selector,
						animationOptions: {
							duration: 500,
							easing: 'linear',
							queue: false
						}
					});
				} catch (err) {

				}
				return false;
			});


			winDow.on('resize', function () {
				var selector = $filter.find('li.active').attr('data-filter');

				$container.isotope({
					filter: selector,
					animationOptions: {
						duration: 500,
						easing: 'linear',
						queue: false
					}
				});
			});


			var filterItemA = $('.filter-btns li');

			filterItemA.on('click', function () {
				var $this = $(this);
				if (!$this.hasClass('active')) {
					filterItemA.removeClass('active');
					$this.addClass('active');
				}
			});
		}
	}

	enableMasonry();
	// 询盘邮件发送
	$('.get-quote').on('click', function () {
		$('.dialog_popup_Email').removeClass('hidden')
		$(".dialog_content").css('animation-name', 'flipInY').css('visibility', 'visible');
	})
	$('.dialog_close').on('click', function () {
		$(".dialog_content").css('animation-name', 'flipOutY').css('visibility', 'hieden');
		setTimeout(function () {
			$('.dialog_popup_Email').addClass('hidden')
		}, 2000)
	})
	// 发送邮件
	var file;
	$('#email_attachment').on('change', function () {
		// 获取上传的文件
		file = this.files[0];
	});

	$('#sendEmail').click(
		function () {
			let body = '',
				path_attachment = $('#email_attachment');
			body += '<h1><b>name:</b> ' + $('#from_name').val() + '</h1>'
			body += '<h1><b>email:</b> ' + $('#from_email').val() + '</h1>'
			body += '<h1><b>message:</b> ' + $('#email_body').val() + '</h1>'
			if (path_attachment) {
				const formData = new FormData();
				formData.append('file', file);
				formData.append('width', 1);
				formData.append('height', 2);
				$.ajax(
					{
						url: '/wp-json/myself/upload',
						type: 'Post',
						data: formData,
						contentType: false,
						processData: false,
						success: function (response) {
							console.log(response);
							$.post('/wp-json/info/email/send', {
								to_email: 'jiangjungle7@gmail.com',
								to_name: 'jungle',
								subject: 'new inquiry',
								body: body,
								attachment_path: response.url
							})
								.then(function (response) {
									console.log(response);
								})
								.catch(function (error) {
									console.log(error);
								});
						},
						error: function (jqXHR, textStatus, errorThrown) {
							console.log(errorThrown);
						}
					},
				)

			} else {
				$.post('/wp-json/info/email/send', {
					to_email: '447494332@qq.com',
					to_name: 'jungle',
					subject: 'new inquiry',
					body: body,
					attachment_path: path_attachment
				})
					.then(function (response) {
						console.log(response);
					})
					.catch(function (error) {
						console.log(error);
					});
			}

		}
	)

	/* ==========================================================================
	   When document is Scrollig, do
	   ========================================================================== */

	$(window).on('scroll', function () {
		headerStyle();
		$(".chooseDtail_text_wrap .chooseDtail_text").css({ 'animation-name': 'bounceOut' })
		setTimeout(function () {
			$(".chooseDtail_text_wrap").removeClass('open')
		}, 1000)
	});
	$(window).on('load', function () {
		enableMasonry();
		liCurrent();
	});
	/* ==========================================================================
	   When document is loading, do
	   ========================================================================== */

})(window.jQuery);