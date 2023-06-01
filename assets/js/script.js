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
// ajax 请求文章页
jQuery(function ($) {
	// 点击排序按钮时
	$('.sort-posts').on('click', function () {
		$(this).addClass('active').siblings().removeClass('active');
		$('#orderby').val($(this).data('orderby'))
		$('#order').val($('#order').val() == 'DESC' ? 'ASC' : 'DESC')
		console.log($(this).children('.updowm').attr('class'));
		if ($('#order').val() == 'DESC') {
			$(this).children('.updowm').removeClass('fa-caret-up').addClass('fa-caret-down')
		} else {
			$(this).children('.updowm').removeClass('fa-caret-down').addClass('fa-caret-up')
		}
		post_sort()
	});
	// 点击搜索按钮时
	$('.keyword_search_submit_btn').on('click', function () {
		$('#paged').val(1)
		post_sort(true)
	});
	// 焦点在搜索框时， 按enter键
	$(".keyword_search_input").keydown(function (e) {//input[name=pwd]当前所在焦点
		if (e.keyCode == "13") {
			$('#paged').val(1)
			post_sort(true)
		}
	})
	// 清空搜索内容并搜索
	$('#search_clear').on('click', function () {
		$('.keyword_search_input').val('')
		$('#paged').val(1)
		post_sort(true)
	});


	// 点击翻页按钮时
	$('#post-container').on('click', '.page-numbers', function () {
		var currentPage = $(this).text();
		// 前后翻页判断
		if (currentPage.indexOf('Next') >= 0) {
			currentPage = parseInt($('#paged').val()) + 1
		} else if (currentPage.indexOf('Previous') >= 0) {
			currentPage = parseInt($('#paged').val()) - 1
		}
		$('#paged').val(Boolean(parseInt(currentPage)) ? currentPage : 1)
		post_sort()
	});

	function post_sort(isRecordKeyword) {
		var data = {
			action: 'post_sort',
			keyword: $.trim($('.keyword_search_input').val()),
			post_type: $('#postType').val(),
			cat: $('#cat').val(),
			posts_per_page: $('#pages').val(),
			paged: $('#paged').val(),
			orderby: $('#orderby').val(),
			order: $('#order').val(),
			meta_key: $('#meta_key').val(),
		};
		//1.如果有搜索词，就去掉内容类型
		//2.blog list 的导航Posts变成All
		//3.isRecordKeyword 为true , 就记录该关键搜索
		if (data.keyword.length != 0) {
			delete data.post_type;
			$('#postsToAll').text('All')
			data.isRecordKeyword = isRecordKeyword
		} else {
			$('#postsToAll').text('Posts')
		}
		// 如果排序方式是meta_value_num， 则添加一个字段
		if (data.orderby == 'post_modified') {
			delete data.meta_key
		}
		$.ajax({
			url: '/wp-admin/admin-ajax.php',
			type: 'POST',
			data: data,
			success: function (response) {
				$('#post-container').html(response);
			}
		});
	}
});