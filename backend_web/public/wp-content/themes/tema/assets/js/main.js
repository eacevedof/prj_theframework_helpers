var G5Plus = G5Plus || {};
(function ($) {
    "use strict";

    var $window = $(window),
        $body = $('body'),
        isRTL = $body.hasClass('rtl'),
        deviceAgent = navigator.userAgent.toLowerCase(),
        isMobile = deviceAgent.match(/(iphone|ipod|android|iemobile)/),
        isMobileAlt = deviceAgent.match(/(iphone|ipod|ipad|android|iemobile)/),
        isAppleDevice = deviceAgent.match(/(iphone|ipod|ipad)/),
        isIEMobile = deviceAgent.match(/(iemobile)/),
        $is_handler_tab = 0,
        $is_process_cat_filter = 0,
        $is_process_product_filter = 0,
        $products = [];

    G5Plus.common = {
        init: function () {
            this.owlCarousel();
            this.lightGallery();
            this.canvasSidebar();
            this.count_down();
            this.sliderResize();
            this.initVCTab();
        },
        windowResized: function () {
            this.canvasSidebar();
        },
        lightGallery: function () {
            $("[data-rel='lightGallery']").each(function () {
                var $this = $(this),
                    galleryId = $this.data('gallery-id');
                $this.on('click', function (event) {
                    event.preventDefault();
                    var _data = [];
                    var $index = 0;
                    var $current_src = $(this).attr('href');
                    var $current_thumb_src = $(this).data('thumb-src');
                    if (typeof galleryId != 'undefined') {
                        $('[data-gallery-id="' + galleryId + '"]').each(function (index) {
                            var src = $(this).attr('href'),
                                thumb = $(this).data('thumb-src');
                            if (src == $current_src && thumb == $current_thumb_src) {
                                $index = index;
                            }
                            _data.push({
                                'src': src,
                                'downloadUrl': src,
                                'thumb': thumb
                            });
                        });
                        $this.lightGallery({
                            hash: false,
                            galleryId: galleryId,
                            dynamic: true,
                            dynamicEl: _data,
                            thumbWidth: 80,
                            index: $index
                        })
                    }
                });
            });
            $('a.view-video').click(function (event) {
                event.preventDefault();
                var $src = $(this).attr('data-src');
                $(this).lightGallery({
                    dynamic: true,
                    dynamicEl: [{
                        'src': $src,
                        'thumb': '',
                        'subHtml': ''
                    }]
                });
            });
        },
        owlCarousel: function () {
            $('.owl-carousel:not(.manual):not(.owl-loaded)').each(function () {
                var slider = $(this);
                var defaults = {
                    items: 4,
                    nav: false,
                    navText: ['<i class="fa fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                    dots: false,
                    loop: true,
                    center: false,
                    mouseDrag: true,
                    touchDrag: true,
                    pullDrag: true,
                    freeDrag: false,
                    margin: 0,
                    stagePadding: 0,
                    merge: false,
                    mergeFit: true,
                    autoWidth: false,
                    startPosition: 0,
                    rtl: isRTL,
                    smartSpeed: 250,
                    fluidSpeed: false,
                    dragEndSpeed: false,
                    autoplayHoverPause: true
                };
                var config = $.extend({}, defaults, slider.data("plugin-options"));
                // Initialize Slider
                slider.owlCarousel(config);

                slider.on('initialized.owl.carousel', function (event) {
                    G5Plus.common.owlCarousel();
                });
            });
        },
        canvasSidebar: function () {
            var canvas_sidebar_mobile = $('.sidebar-mobile-canvas');
            var changed_class = 'changed';
            if (typeof(canvas_sidebar_mobile) != 'undefined') {
                if (!$('body').find('#wrapper').next().hasClass('overlay-canvas-sidebar')) {
                    $('#wrapper').after('<div class="overlay-canvas-sidebar"></div>');
                }
                if (!G5Plus.common.isDesktop()) {
                    canvas_sidebar_mobile.css('height', $(window).height() + 'px');
                    canvas_sidebar_mobile.css('overflow-y', 'auto');
                    if ($.isFunction($.fn.perfectScrollbar)) {
                        canvas_sidebar_mobile.perfectScrollbar({
                            wheelSpeed: 0.5,
                            suppressScrollX: true
                        });
                    }
                } else {
                    canvas_sidebar_mobile.css('overflow-y', 'hidden');
                    canvas_sidebar_mobile.css('height', 'auto');
                    canvas_sidebar_mobile.scrollTop(0);
                    if ($.isFunction($.fn.perfectScrollbar) && canvas_sidebar_mobile.hasClass('ps-active-y')) {
                        canvas_sidebar_mobile.perfectScrollbar('destroy');
                    }
                    canvas_sidebar_mobile.removeAttr('style');
                    $('.overlay-canvas-sidebar').removeClass(changed_class);
                    $('.sidebar-mobile-canvas', '#wrapper').removeClass(changed_class);
                    $('.sidebar-mobile-canvas-icon', '#wrapper').removeClass(changed_class);

                }
                $('.sidebar-mobile-canvas-icon').on('click', function () {
                    var $canvas_sidebar = $(this).parent().children('.sidebar-mobile-canvas');
                    $(this).addClass(changed_class);
                    $canvas_sidebar.addClass(changed_class);
                    $('.overlay-canvas-sidebar').addClass(changed_class);

                });
                $('.overlay-canvas-sidebar').on('click', function () {
                    if ($('.sidebar-mobile-canvas-icon').hasClass(changed_class)) {
                        $(this).removeClass(changed_class);
                        $('.sidebar-mobile-canvas', '#wrapper').removeClass(changed_class);
                        $('.sidebar-mobile-canvas-icon', '#wrapper').removeClass(changed_class);
                    }
                });
            }
        },
        isDesktop: function () {
            var responsive_breakpoint = 991;
            var $menu = $('.x-nav-menu');
            if (($menu.length > 0) && (typeof ($menu.attr('responsive-breakpoint')) != "undefined" ) && !isNaN(parseInt($menu.attr('responsive-breakpoint'), 10))) {
                responsive_breakpoint = parseInt($menu.attr('responsive-breakpoint'), 10);
            }
            return window.matchMedia('(min-width: ' + (responsive_breakpoint + 1) + 'px)').matches;
        },
        count_down: function () {
            $('.g5plus-countdown').each(function () {
                var date_end = $(this).data('date-end');
                var show_month = $(this).data('show-month');
                var $this = $(this);
                $this.countdown(date_end, function (event) {
                    count_down_callback(event, $this);
                }).on('update.countdown', function (event) {
                    count_down_callback(event, $this);
                }).on('finish.countdown', function (event) {
                    $('.countdown-seconds', $this).html('00');
                    var $url_redirect = $this.attr('data-url-redirect');
                    if (typeof $url_redirect != 'undefined' && $url_redirect != '') {
                        window.location.href = $url_redirect;
                    }
                });
            });

            function count_down_callback(event, $this) {
                var seconds = parseInt(event.offset.seconds);
                var minutes = parseInt(event.offset.minutes);
                var hours = parseInt(event.offset.hours);
                var days = parseInt(event.offset.totalDays);
                var show_month = $this.data('show-month');
                var months = 0;

                if (show_month == 'show') {
                    if (days >= 30) {
                        months = parseFloat(parseInt(days / 30));
                        var days_tem = days % 30;
                        days = days_tem;
                    }
                }

                if (months == 0) {
                    $('.countdown-section.months', $this).remove();
                }

                if ((seconds == 0) && (minutes == 0) && (hours == 0) && (days == 0) && (months == 0)) {
                    var $url_redirect = $this.attr('data-url-redirect');
                    if (typeof $url_redirect != 'undefined' && $url_redirect != '') {
                        window.location.href = $url_redirect;
                    }
                    return;
                }
                if (months < 10) months = '0' + months;
                if (days < 10) days = '0' + days;
                if (hours < 10) hours = '0' + hours;
                if (minutes < 10) minutes = '0' + minutes;
                if (seconds < 10) seconds = '0' + seconds;

                $('.countdown-month', $this).text(months);
                $('.countdown-day', $this).text(days);
                $('.countdown-hours', $this).text(hours);
                $('.countdown-minutes', $this).text(minutes);
                $('.countdown-seconds', $this).text(seconds);
            }
        },
        sliderResize: function () {
            $(window).resize(function () {
                $('.owl-carousel').on('resized.owl.carousel', function (event) {
                    G5Plus.blog.gridLayout();
                })
            });
            $(window).on('orientationchange', function () {
                $('.owl-carousel').on('resized.owl.carousel', function (event) {
                    G5Plus.blog.gridLayout();
                })
            });
        },
        initVCTab: function () {
            /**
             * process tab click
             */
            $('a', '.vc_tta-tabs.gf-tab ul.vc_tta-tabs-list').off('click').click(function (e) {
                e.preventDefault();
                if ($is_handler_tab == 1 || $(this).parent().hasClass('vc_active')) {
                    return false;
                }
                $is_handler_tab = 1;
                var $ul = $(this).parent().parent();
                var $current_tab = $($(this).attr('href'), '.vc_tta-panels-container');
                var $tab_id = '';
                var $tab_active = '';
                if (typeof $ul != 'undefined') {
                    $('li', $ul).removeClass('vc_active');
                    $(this).parent().addClass('vc_active');
                    $('li a', $ul).each(function () {
                        $tab_id = $(this).attr('href');
                        if ($($tab_id + '.vc_active', '.vc_tta-panels-container').length > 0) {
                            $tab_active = $($tab_id + '.vc_active', '.vc_tta-panels-container');
                        }
                    });
                    $tab_active.fadeOut(400, function () {
                        $tab_active.removeClass('vc_active');
                        $tab_active.fadeIn();
                        $current_tab.fadeIn(0, function () {
                            $current_tab.addClass('vc_active');
                            $is_handler_tab = 0;
                        });
                    })
                }
                return false;
            });
        },
        startLoading: function (elm) {
            var $loading = jQuery('<div class="loading-wrap"><span class="l-1 bg-accent"></span><span class="l-2 bg-accent"></span>' +
                '<span class="l-3 bg-accent"></span><span class="l-4 bg-accent"></span>' +
                '<span class="l-5 bg-accent"></span><span class="l-6 bg-accent"></span></div>');
            $(elm).before($loading);
            $(elm).hide();
        },
        stopLoading: function (elm) {
            var $loading = $(elm).prev();
            if (typeof $loading != 'undefined' && $loading.hasClass('loading-wrap')) {
                $loading.remove();
            }
            $(elm).fadeIn();
        },
    };

    G5Plus.page = {
        init: function () {
            this.parallax();
            this.parallaxDisable();
            this.pageTitle();
            this.button();
            this.footerParallax();
            this.footerWidgetCollapse();
            this.events();
            this.pageTransition();
            this.backToTop();
        },
        events: function () {
            $('.g5plus-event.style2 .nav').each(function () {
                if ($(this).height() > 560) {
                    $(this).addClass('overflow-y-scroll');
                }
                else {
                    $(this).removeClass('overflow-y-scroll');
                }
            });
        },
        windowLoad: function () {
            this.fadePageIn();
        },
        windowResized: function () {
            this.parallaxDisable();
            this.pageTitle();
            this.button();
            this.footerParallax();
            this.footerWidgetCollapse();
            this.wpb_image_grid();
            this.events();
        },
        parallax: function () {
            $.stellar({
                horizontalScrolling: false,
                scrollProperty: 'scroll',
                positionProperty: 'position',
                responsive: false
            });
        },
        parallaxDisable: function () {
            if (G5Plus.common.isDesktop()) {
                $('.parallax').removeClass('parallax-disabled');
            } else {
                $('.parallax').addClass('parallax-disabled');
            }
        },
        pageTitle: function () {
            var $this = $('.page-title-layout-normal'),
                $container = $('.container', $this),
                $pageTitle = $('h1', $this),
                $breadcrumbs = $('.breadcrumbs', $this);
            $this.removeClass('left');
            if (($pageTitle.width() + $breadcrumbs.width()) > $container.width()) {
                $this.addClass('left');
            }
        },
        backToTop : function() {
            var $backToTop = $('.back-to-top');
            if ($backToTop.length > 0) {
                $backToTop.on("click",function(event) {
                    event.preventDefault();
                    $('html,body').animate({scrollTop: '0px'},800);
                });
                $window.on('scroll', function (event) {
                    var scrollPosition = $window.scrollTop();
                    var windowHeight = $window.height() / 2;
                    if (scrollPosition > windowHeight) {
                        $backToTop.addClass('in');
                    }
                    else {
                        $backToTop.removeClass('in');
                    }
                });
            }
        },
        button: function () {
            $('.btn.btn-block.btn-icon,.mc-style4 .btn.btn-icon').each(function () {
                var $width = $(this).width() - $('i', $(this)).width() - parseInt($('i', $(this)).css('margin-left').replace('px', ''), 10) - parseInt($('i', $(this)).css('margin-right').replace('px', ''), 10);
                $('span', $(this)).css({
                    'width': $width + 'px'
                });
                if ($(this).height() > $('span', $(this)).height()) {
                    $('span', $(this)).css({
                        'width': ($width - 1) + 'px'
                    });
                }
            });
        },
        footerParallax: function () {
            if (window.matchMedia('(max-width: 767px)').matches) {
                $body.css('margin-bottom', '');
            }
            else {
                setTimeout(function () {
                    var $footer = $('footer.main-footer-wrapper');
                    if ($footer.hasClass('enable-parallax')) {
                        var headerSticky = $('header.main-header .sticky-wrapper').length > 0 ? 55 : 0,
                            $adminBar = $('#wpadminbar'),
                            $adminBarHeight = $adminBar.length > 0 ? $adminBar.outerHeight() : 0;
                        if (($window.height() >= ($footer.outerHeight() + headerSticky + $adminBarHeight))) {
                            $body.css('margin-bottom', ($footer.outerHeight()) + 'px');
                            $footer.removeClass('static');
                        } else {
                            $body.css('margin-bottom', '');
                            $footer.addClass('static');
                        }
                    }
                }, 100);
            }

        },
        footerWidgetCollapse: function () {
            if (window.matchMedia('(max-width: 767px)').matches) {
                $('footer.footer-collapse-able aside.widget').each(function () {
                    var $title = $('h4.widget-title', this);
                    var $content = $title.next();
                    $title.addClass('title-collapse');
                    if (($content != null) && (typeof($content) != 'undefined')) {
                        $content.hide();
                    }
                    $title.off();
                    $title.on('click', function () {
                        var $content = $(this).next();

                        if ($(this).hasClass('title-expanded')) {
                            $(this).removeClass('title-expanded');
                            $title.addClass('title-collapse');
                            $content.slideUp();
                        }
                        else {
                            $(this).addClass('title-expanded');
                            $title.removeClass('title-collapse');
                            $content.slideDown();
                        }

                    });

                });
            } else {
                $('footer aside.widget').each(function () {
                    var $title = $('h4.widget-title', this);
                    $title.off();
                    var $content = $title.next();
                    $title.removeClass('collapse');
                    $title.removeClass('expanded');
                    $content.show();
                });
            }
        },
        wpb_image_grid: function () {
            $(".wpb_gallery_slides.wpb_image_grid .wpb_image_grid_ul").each(function (index) {
                var $imagesGrid = $(this);
                setTimeout(function () {
                    $imagesGrid.isotope('layout');
                }, 1000);
            });
        },
        page404: function () {
            if (!$body.hasClass('error404')) return;
            var windowHeight = $window.outerHeight();
            var page404Height = 0;
            var $header = null;
            if (G5Plus.common.isDesktop()) {
                $header = $('header.main-header');
            }
            else {
                $header = $('header.header-mobile');
            }
            if ($header.length == 0) return;
            page404Height = windowHeight - $header.offset().top - $header.outerHeight() - $('body.error404 .content-wrap').outerHeight();
            if (page404Height < 200) {
                page404Height = 200;
            }
            page404Height /= 2;
            $('body.error404 .page404').css('padding', page404Height + 'px 0');
        },
        pageTransition: function () {
            if ($body.hasClass('page-transitions')) {
                var linkElement = '.animsition-link, a[href]:not([target="_blank"]):not([href^="#"]):not([href*="javascript"]):not([href*=".jpg"]):not([href*=".jpeg"]):not([href*=".gif"]):not([href*=".png"]):not([href*=".mov"]):not([href*=".swf"]):not([href*=".mp4"]):not([href*=".flv"]):not([href*=".avi"]):not([href*=".mp3"]):not([href^="mailto:"]):not([class*="no-animation"]):not([class*="prettyPhoto"]):not([class*="add_to_wishlist"]):not([class*="add_to_cart_button"])';
                $(linkElement).on('click', function (event) {
                    if ($(event.target).closest($('b.x-caret', this)).length > 0) {
                        event.preventDefault();
                        return;
                    }
                    event.preventDefault();
                    var $self = $(this);
                    var url = $self.attr('href');

                    // middle mouse button issue #24
                    // if(middle mouse button || command key || shift key || win control key)
                    if (event.which === 2 || event.metaKey || event.shiftKey || navigator.platform.toUpperCase().indexOf('WIN') !== -1 && event.ctrlKey) {
                        window.open(url, '_blank');
                    } else {
                        G5Plus.page.fadePageOut(url);
                    }

                });
            }
        },
        fadePageIn: function () {
            if ($body.hasClass('page-loading')) {
                var preloadTime = 1000,
                    $loading = $('.site-loading');
                $loading.css('opacity', '0');
                setTimeout(function () {
                    $loading.css('display', 'none');
                }, preloadTime);
            }
        },
        fadePageOut: function (link) {

            $('.site-loading').css('display', 'block').animate({
                opacity: 1,
                delay: 200
            }, 600, "linear");

            $('html,body').animate({scrollTop: '0px'}, 800);

            setTimeout(function () {
                window.location = link;
            }, 600);
        }
    };

    G5Plus.blog = {
        init: function () {
            this.masonryLayout();
            setTimeout(this.masonryLayout, 300);
            this.postMeta();
            this.loadMore();
            this.infiniteScroll();
            this.commentReplyTitle();
            this.gridLayout();

        },
        windowResized: function () {
            this.postMeta();
        },
        postMeta: function () {
            $('article.post-large-image .entry-meta-wrap,article.post-medium-image .entry-meta-wrap,article.post-masonry .entry-meta-wrap').each(function () {
                var $this = $(this),
                    $moreLink = $('.read-more', $this),
                    $meta = $('.entry-post-meta', $this);
                $this.removeClass('left');
                if (($moreLink.outerWidth() + $meta.outerWidth() + 10) > $this.outerWidth()) {
                    $this.addClass('left');
                }
            });
        },
        loadMore: function () {
            $('.paging-navigation').on('click', '.blog-load-more', function (event) {
                event.preventDefault();
                var $this = $(this).button('loading'),
                    link = $(this).attr('data-href'),
                    contentWrapper = '.blog-wrap',
                    element = '.blog-wrap article';

                $.get(link, function (data) {
                    var next_href = $('.blog-load-more', data).attr('data-href'),
                        $newElems = $(element, data).css({
                            opacity: 0
                        });
                    $(contentWrapper).append($newElems);
                    $newElems.imagesLoaded({background: true}, function () {
                        G5Plus.common.owlCarousel();
                        G5Plus.blog.postMeta();
                        $newElems.animate({
                            opacity: 1
                        });
                        if ($('.archive-wrap').hasClass('archive-grid-image')) {
                            $(contentWrapper).isotope('appended', $newElems);
                            setTimeout(function () {
                                $(contentWrapper).isotope('layout');
                            }, 400);
                        }
                        if ($('.archive-wrap').hasClass('archive-masonry')) {
                            $(contentWrapper).isotope('appended', $newElems);
                            setTimeout(function () {
                                $(contentWrapper).isotope('layout');
                            }, 400);
                        }
                    });
                    if (typeof(next_href) == 'undefined') {
                        $this.parent().remove();
                    } else {
                        $this.button('reset');
                        $this.attr('data-href', next_href);
                    }
                });
            });

        },
        infiniteScroll: function () {
            var $container = $('.blog-wrap');
            $container.infinitescroll({
                navSelector: '#infinite_scroll_button',    // selector for the paged navigation
                nextSelector: '#infinite_scroll_button a',  // selector for the NEXT link (to page 2)
                itemSelector: 'article',     // selector for all items you'll retrieve
                animate: true,
                loading: {
                    finishedMsg: 'No more pages to load.',
                    selector: '#infinite_scroll_loading',
                    img: g5plus_app_variable.theme_url + 'assets/images/ajax-loader.gif',
                    msgText: 'Loading...'
                }
            }, function (newElements) {
                var $newElems = $(newElements).css({
                    opacity: 0
                });

                $newElems.imagesLoaded({background: true}, function () {
                    G5Plus.common.owlCarousel();
                    G5Plus.blog.postMeta();
                    $newElems.animate({
                        opacity: 1
                    });
                    if ($('.archive-wrap').hasClass('archive-grid-image')) {
                        $container.isotope('appended', $newElems);
                        setTimeout(function () {
                            $container.isotope('layout');
                        }, 400);
                    }
                    if ($('.archive-wrap').hasClass('archive-masonry')) {
                        $container.isotope('appended', $newElems);
                        setTimeout(function () {
                            $container.isotope('layout');
                        }, 400);
                    }
                });
            });

        },
        masonryLayout: function () {
            var $container = $('.archive-masonry .blog-wrap');
            $container.imagesLoaded({background: true}, function () {
                $container.isotope({
                    itemSelector: 'article',
                    layoutMode: "masonry",
                    isOriginLeft: !isRTL
                });
                setTimeout(function () {
                    $container.isotope('layout');
                }, 500);
            });

        },
        gridLayout: function () {
            var $blog_grid = $('.blog-style-grid');
            $blog_grid.imagesLoaded(function () {
                $blog_grid.isotope({
                    itemSelector: 'article',
                    layoutMode: "fitRows",
                    isOriginLeft: !isRTL
                });
                setTimeout(function () {
                    $blog_grid.isotope('layout');
                }, 500);
            });
        },
        commentReplyTitle: function () {
            var $replyTitle = $('h3#reply-title');
            $replyTitle.addClass('widget-title mg-top-40');
            var $smallTag = $('small', $replyTitle);
            $smallTag.remove();
            $replyTitle.html('<span>' + $replyTitle.text() + '</span> ');
            $replyTitle.append($smallTag);
        },
    };

    G5Plus.header = {
        timeOutSearch: null,
        xhrSearchAjax: null,
        init: function () {
            this.anchoPreventDefault();
            this.topDrawerToggle();
            this.switchMenu();
            this.sticky();
            this.menuOnePage();
            this.menuCategories();
            this.searchProduct();
            this.searchButton();
            this.closeButton();
            this.searchAjaxButtonClick();
            this.closestElement();
            this.menuMobileToggle();
            $('[data-search="ajax"]').each(function () {
                G5Plus.header.searchAjax($(this));
            });

            this.escKeyPress();
            this.mobileNavOverlay();
        },
        windowsScroll: function () {
            this.sticky();
            this.menuDropFlyPosition();
        },
        windowResized: function () {
            this.sticky();
            this.menuDropFlyPosition();
        },
        windowLoad: function () {
        },
        topDrawerToggle: function () {
            $('.top-drawer-toggle').on('click', function () {
                $('.top-drawer-inner').slideToggle();
                $('.top-drawer-wrapper').toggleClass('in');
            });
        },
        switchMenu: function () {
            $('header .menu-switch').on('click', function () {
                $('.header-nav-inner').toggleClass('in');
            });
        },
        menuCategories: function () {
            $('.menu-categories-select > i').on('click', function () {
                $('.menu-categories').toggleClass('in');
            });
        },
        sticky: function () {
            $('.sticky-wrapper').each(function () {
                var $this = $(this);
                var stickyHeight = 60;
                if (G5Plus.common.isDesktop()) {
                    stickyHeight = 55;
                }
                if ($(document).outerHeight() - $this.outerHeight() - $this.offset().top <= $window.outerHeight() - stickyHeight) {
                    $this.removeClass('is-sticky');
                    $('.sticky-region', $this).css('top', '');
                    return;
                }
                var adminBarHeight = 0;
                if ($('#wpadminbar').length && ($('#wpadminbar').css('position') == 'fixed')) {
                    adminBarHeight = $('#wpadminbar').outerHeight();
                }
                if ($(window).scrollTop() > $this.offset().top - adminBarHeight) {
                    $this.addClass('is-sticky');
                    $('.sticky-region', $this).css('top', adminBarHeight + 'px');
                }
                else {
                    $this.removeClass('is-sticky');
                    $('.sticky-region', $this).css('top', '');
                }
            });
        },
        menuOnePage : function() {
            $('.menu-one-page').onePageNav({
                currentClass: 'menu-current',
                changeHash: false,
                scrollSpeed: 750,
                scrollThreshold: 0,
                filter: '',
                easing: 'swing'
            });
        },

        searchProduct: function () {
            $('.search-product-wrapper .categories').each(function () {
                var $this = $(this);
                $('> span', $this).on('click', function () {
                    $('.search-product-wrapper .search-category-dropdown').slideToggle();
                    $(this).toggleClass('in');
                    $('.search-product-wrapper .search-ajax-result').html('');
                    $('.search-product-wrapper input[type="text"]').val('');
                });
                $('.search-category-dropdown span', $this).on('click', function () {
                    $('> span', $this).html($(this).html());
                    $('> span', $this).attr('data-id', $(this).attr('data-id'));
                    $('.search-product-wrapper .search-category-dropdown').slideToggle();
                    $('> span', $this).toggleClass('in');
                });
            });
        },

        searchButton: function () {
            var $itemSearch = $('.header-customize-item.item-search > a, .mobile-search-button > a');
            if (!$itemSearch.length) {
                return;
            }
            var $searchPopup = $('#search_popup_wrapper');
            if (!$searchPopup.length) {
                return;
            }
            if ($itemSearch.hasClass('search-ajax')) {
                $itemSearch.on('click', function () {
                    $window.scrollTop(0);
                    $searchPopup.addClass('in');
                    $('body').addClass('overflow-hidden');
                    var $input = $('input[type="text"]', $searchPopup);
                    $input.focus();
                    $input.val('');

                    var $result = $('.search-ajax-result', $searchPopup);
                    $result.html('');
                });
            }
            else {
                var dlgSearch = new DialogFx($searchPopup[0]);
                $itemSearch.on('click', dlgSearch.toggle.bind(dlgSearch));
                $itemSearch.on('click', function () {
                    var $input = $('input[type="text"]', $searchPopup);

                    $input.focus();
                    $input.val('');
                });
            }
        },
        searchAjax: function ($wrapper) {
            $('input[type="text"]', $wrapper).on('keyup', function (event) {
                if (event.altKey || event.ctrlKey || event.shiftKey || event.metaKey) {
                    return;
                }
                var keys = ["Control", "Alt", "Shift"];
                if (keys.indexOf(event.key) != -1) return;
                switch (event.which) {
                    case 27:	// ESC
                        $('.search-ajax-result', $wrapper).html('');
                        $wrapper.removeClass('in');
                        $(this).val('');
                        break;
                    case 38:	// UP
                        G5Plus.header.searchAjaxKeyUp($wrapper);
                        event.preventDefault();
                        break;
                    case 40:	// DOWN
                        G5Plus.header.searchAjaxKeyDown($wrapper);
                        event.preventDefault();
                        break;
                    case 13:
                        G5Plus.header.searchAjaxKeyEnter($wrapper);
                        break;
                    default:
                        clearTimeout(G5Plus.header.timeOutSearch);
                        G5Plus.header.timeOutSearch = setTimeout(G5Plus.header.searchAjaxSearchProcess, 500, $wrapper, false);
                        break;
                }
            });
        },
        searchAjaxKeyUp: function ($wrapper) {
            var $item = $('.search-ajax-result li.selected', $wrapper);
            if ($('.search-ajax-result li', $wrapper).length < 2) return;
            var $prev = $item.prev();
            $item.removeClass('selected');
            if ($prev.length) {
                $prev.addClass('selected');
            }
            else {
                $('.search-ajax-result li:last', $wrapper).addClass('selected');
                $prev = $('.search-ajax-result li:last', $wrapper);
            }
            if ($prev.position().top < $('.ajax-search-result', $wrapper).scrollTop()) {
                $('.ajax-search-result', $wrapper).scrollTop($prev.position().top);
            }
            else if ($prev.position().top + $prev.outerHeight() > $('.ajax-search-result', $wrapper).scrollTop() + $('.ajax-search-result', $wrapper).height()) {
                $('.ajax-search-result', $wrapper).scrollTop($prev.position().top - $('.ajax-search-result', $wrapper).height() + $prev.outerHeight());
            }
        },
        searchAjaxKeyDown: function ($wrapper) {
            var $item = $('.search-ajax-result li.selected', $wrapper);
            if ($('.search-ajax-result li', $wrapper).length < 2) return;
            var $next = $item.next();
            $item.removeClass('selected');
            if ($next.length) {
                $next.addClass('selected');
            }
            else {
                $('.search-ajax-result li:first', $wrapper).addClass('selected');
                $next = $('.search-ajax-result li:first', $wrapper);
            }
            if ($next.position().top < $('.search-ajax-result', $wrapper).scrollTop()) {
                $('.search-ajax-result', $wrapper).scrollTop($next.position().top);
            }
            else if ($next.position().top + $next.outerHeight() > $('.search-ajax-result', $wrapper).scrollTop() + $('.search-ajax-result', $wrapper).height()) {
                $('.search-ajax-result', $wrapper).scrollTop($next.position().top - $('.search-ajax-result', $wrapper).height() + $next.outerHeight());
            }
        },
        searchAjaxKeyEnter: function ($wrapper) {
            var $item = $('.search-ajax-result li.selected a', $wrapper);
            if ($item.length > 0) {
                window.location = $item.attr('href');
            }
        },
        searchAjaxSearchProcess: function ($wrapper, isButtonClick) {
            var keyword = $('input[type="text"]', $wrapper).val();
            if (!isButtonClick && keyword.length < 3) {
                $('.search-ajax-result', $wrapper).html('');
                return;
            }
            $('.search-button i', $wrapper).addClass('fa-spinner fa-spin');
            $('.search-button i', $wrapper).removeClass('fa-search');
            if (G5Plus.header.xhrSearchAjax) {
                G5Plus.header.xhrSearchAjax.abort();
            }
            var action = $wrapper.attr('data-ajax-action');
            var data = 'action=' + action + '&keyword=' + keyword;
            if ($('.categories > span[data-id]', $wrapper)) {
                data += '&cate_id=' + $('.categories > span[data-id]', $wrapper).attr('data-id');
            }

            G5Plus.header.xhrSearchAjax = $.ajax({
                type: 'POST',
                data: data,
                url: g5plus_app_variable.ajax_url,
                success: function (data) {
                    $('.search-button i', $wrapper).removeClass('fa-spinner fa-spin');
                    $('.search-button i', $wrapper).addClass('fa-search');
                    $wrapper.addClass('in');
                    $('.search-ajax-result', $wrapper).html(data);
                },
                error: function (data) {
                    if (data && (data.statusText == 'abort')) {
                        return;
                    }
                    $('.search-button i', $wrapper).removeClass('fa-spinner fa-spin');
                    $('.search-button i', $wrapper).addClass('fa-search');
                }
            });
        },
        searchAjaxButtonClick: function () {
            $('.search-button').on('click', function () {
                var $wrapper = $($(this).attr('data-search-wrapper'));
                G5Plus.header.searchAjaxSearchProcess($wrapper, true);
            });
        },
        menuMobileToggle: function () {
            $('.toggle-icon-wrapper > .toggle-icon').on('click', function () {
                var $this = $(this);
                var $parent = $this.parent();
                var dropType = $parent.attr('data-drop-type');
                $parent.toggleClass('in');
                if (dropType == 'menu-drop-fly') {
                    $('body').toggleClass('mobile-nav-in');
                }
                else {
                    $('.nav-menu-mobile').slideToggle();
                }
            });
        },
        escKeyPress: function () {
            $(document).on('keyup', function (event) {
                if (event.altKey || event.ctrlKey || event.shiftKey || event.metaKey) {
                    return;
                }
                var keys = ["Control", "Alt", "Shift"];
                if (keys.indexOf(event.key) != -1) return;
                if (event.which == 27) {
                    if ($('#search_popup_wrapper').hasClass('in')) {
                        $('#search_popup_wrapper').removeClass('in');
                        setTimeout(function () {
                            $('body').removeClass('overflow-hidden');
                        }, 500);

                    }

                }
            });
        },
        anchoPreventDefault: function () {
            $('.prevent-default').on('click', function (event) {
                event.preventDefault();
            });
        },
        closeButton: function () {
            $('.close-button').on('click', function () {
                var $closeButton = $(this);
                var ref = $closeButton.attr('data-ref');
                if ($('#search_popup_wrapper').hasClass('in')) {
                    setTimeout(function () {
                        $('body').removeClass('overflow-hidden');
                    }, 500);
                }
                $(ref).removeClass('in');
            });

        },
        closestElement: function () {
            $($window).click(function (event) {
                if ($(event.target).closest('.search-product-wrapper .categories').length == 0) {
                    $('.search-product-wrapper .search-category-dropdown').slideUp();
                    $('.search-product-wrapper .categories > span').removeClass('in');
                }

                if ($(event.target).closest('.search-product-wrapper').length == 0) {
                    $('.search-ajax-result').html('');
                    $('.search-product-wrapper').removeClass('in');
                    $('input[type="text"]', '.search-product-wrapper').val('');
                }
            });
        },
        mobileNavOverlay: function () {
            $('.mobile-nav-overlay').on('click', function () {
                $('body').removeClass('mobile-nav-in');
                $('.toggle-mobile-menu').removeClass('in');
            })
        },
        menuDropFlyPosition: function () {
            var adminBarHeight = 0;
            if ($('#wpadminbar').length && ($('#wpadminbar').css('position') == 'fixed')) {
                adminBarHeight = $('#wpadminbar').outerHeight();
            }
            $('.header-mobile-nav.menu-drop-fly').css('top', adminBarHeight + 'px');
        }
    };

    G5Plus.menu = {
        init: function () {
            this.processMobileMenu();
            this.mobileMenuItemClick();
        },
        processMobileMenu: function () {
            $('.nav-menu-mobile:not(.x-nav-menu) li > a').each(function () {
                var $this = $(this);
                var html = '<span>' + $this.html() + '</span>';
                if ($('> ul', $this.parent()).length) {
                    html += '<b class="menu-caret"></b>';
                }
                $this.html(html);
            });
        },
        mobileMenuItemClick: function () {
            $('.nav-menu-mobile:not(.x-nav-menu) li').on('click', function () {
                if ($('> ul', this).length == 0) {
                    return;
                }
                if ($(event.target).closest($('> ul', this)).length > 0) {
                    return;
                }

                if ($(event.target).closest($('> a > span', this)).length > 0) {
                    var baseUri = '';
                    if ((typeof (event.target) != "undefined") && (event.target != null) && (typeof (event.target.baseURI) != "undefined") && (event.target.baseURI != null)) {
                        var arrBaseUri = event.target.baseURI.split('#');
                        if (arrBaseUri.length > 0) {
                            baseUri = arrBaseUri[0];
                        }

                        var $aClicked = $('> a', this);
                        if ($aClicked.length > 0) {
                            var clickUrl = $aClicked.attr('href');
                            if (clickUrl != '#') {
                                if ((typeof (clickUrl) != "undefined") && (clickUrl != null)) {
                                    clickUrl = clickUrl.split('#')[0];
                                }
                                if (baseUri != clickUrl) {
                                    return;
                                }
                            }

                        }
                    }
                }

                event.preventDefault();
                $(this).toggleClass('menu-open');
                $('> ul', this).slideToggle();
            });
        }
    };

    G5Plus.woocommerce = {
        init: function () {
            this.addCartQuantity();
            this.setCartScrollBar();
            this.singleThumbnail();
            this.shoppingCart();
            this.paymentMethod();
            this.ajaxCategory();
            this.processViewMore();
            this.pagingAjax();
            this.addtoCard();
            this.responsiveCate();
            this.initWidgetFilter();
            this.initPriceFilter();
            this.saleCountdown();
        },
        setCartScrollBar: function () {
            $('.shopping-cart-list .cart_list').perfectScrollbar({
                wheelSpeed: 0.5,
                suppressScrollX: true
            });
        },
        addCartQuantity: function () {
            $(document).off('click', '.quantity .btn-number').on('click', '.quantity .btn-number', function (event) {
                event.preventDefault();
                var type = $(this).data('type'),
                    input = $('input', $(this).parent()),
                    current_value = parseFloat(input.val()),
                    max = parseFloat(input.attr('max')),
                    min = parseFloat(input.attr('min')),
                    step = parseFloat(input.attr('step')),
                    stepLength = 0;
                if (input.attr('step').indexOf('.') > 0) {
                    stepLength = input.attr('step').split('.')[1].length;
                }

                if (isNaN(max)) {
                    max = 1000;
                }
                if (isNaN(min)) {
                    min = 0;
                }
                if (isNaN(step)) {
                    step = 1;
                    stepLength = 0;
                }

                if (!isNaN(current_value)) {
                    if (type == 'minus') {
                        if (current_value > min) {
                            current_value = (current_value - step).toFixed(stepLength);
                            input.val(current_value).change();
                        }

                        if (parseFloat(input.val()) <= min) {
                            input.val(min).change();
                            $(this).attr('disabled', true);
                        }
                    }

                    if (type == 'plus') {
                        if (current_value < max) {
                            current_value = (current_value + step).toFixed(stepLength);
                            input.val(current_value).change();
                        }
                        if (parseFloat(input.val()) >= max) {
                            input.val(max).change();
                            $(this).attr('disabled', true);
                        }
                    }
                } else {
                    input.val(min);
                }
            });

            $('input', '.quantity').focusin(function () {
                $(this).data('oldValue', $(this).val());
            });

            $('input', '.quantity').on('change', function () {
                var input = $(this),
                    max = parseFloat(input.attr('max')),
                    min = parseFloat(input.attr('min')),
                    current_value = parseFloat(input.val()),
                    step = parseFloat(input.attr('step'));

                if (isNaN(max)) {
                    max = 1000;
                }
                if (isNaN(min)) {
                    min = 0;
                }

                if (isNaN(step)) {
                    step = 1;
                }


                var btn_add_to_cart = $('.add_to_cart_button', $(this).parent().parent().parent());
                if (current_value >= min) {
                    $(".btn-number[data-type='minus']", $(this).parent()).removeAttr('disabled');
                    if (typeof(btn_add_to_cart) != 'undefined') {
                        btn_add_to_cart.attr('data-quantity', current_value);
                    }

                } else {
                    alert('Sorry, the minimum value was reached');
                    $(this).val($(this).data('oldValue'));

                    if (typeof(btn_add_to_cart) != 'undefined') {
                        btn_add_to_cart.attr('data-quantity', $(this).data('oldValue'));
                    }
                }

                if (current_value <= max) {
                    $(".btn-number[data-type='plus']", $(this).parent()).removeAttr('disabled');
                    if (typeof(btn_add_to_cart) != 'undefined') {
                        btn_add_to_cart.attr('data-quantity', current_value);
                    }
                } else {
                    alert('Sorry, the maximum value was reached');
                    $(this).val($(this).data('oldValue'));
                    if (typeof(btn_add_to_cart) != 'undefined') {
                        btn_add_to_cart.attr('data-quantity', $(this).data('oldValue'));
                    }
                }

            });
        },
        singleThumbnail: function () {
            $('.images', '.single-product-thumbnail-wrap').addClass('owl-carousel');
            $('.images', '.single-product-thumbnail-wrap').owlCarousel({
                items: 1,
                nav: true,
                navText: ['<i class="fa fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                dots: false,
                loop: false,
                center: false,
                mouseDrag: true,
                touchDrag: true,
                pullDrag: true,
                freeDrag: false,
                margin: 0,
                stagePadding: 0,
                merge: false,
                mergeFit: true,
                autoWidth: false,
                startPosition: 0,
                rtl: isRTL,
                smartSpeed: 250,
                fluidSpeed: false,
                dragEndSpeed: false,
                autoplayHoverPause: true
            });
        },
        paymentMethod: function () {
            var $orderReview = $('#order_review');
            $orderReview.on('click', 'input[name=payment_method]', function () {
                $('.g5plus_payment_box_title').removeClass('active');
                $(this).parent().addClass('active');
            });
        },
        ajaxCategory: function () {
            $('a.category-item', '.list-categories').off('click').click(function (e) {
                e.preventDefault();
                if ($is_process_product_filter == 1)
                    return false;
                $('a.category-item', '.list-categories').removeClass('active');
                $(this).addClass('active');
                var $max_page = $(this).attr('data-max-page')
                $is_process_product_filter == 1
                var $this = $(this),
                    $ladda = null;
                if ($this.hasClass('ladda-button')) {
                    $this.addClass('onclick');
                    $ladda = Ladda.create(this);
                    $ladda.start();
                }

                $is_process_product_filter = 1;
                var cate = $(this).attr('data-category'),
                    align_cate = $(this).parent('li').parent('ul').attr('data-align-cate'),
                    item_per_page = $(this).parent('li').parent('ul').attr('data-item-perpage'),
                    columns = $(this).parent('li').parent('ul').attr('data-columns'),
                    show_rating = $(this).parent('li').parent('ul').attr('data-show-rating'),
                    show_quickview = $(this).parent('li').parent('ul').attr('data-show-quickview');
                    $('.button-view-more-wrap', '.g5plus-woocommerce-content').remove();

                $.ajax({
                    url: g5plus_app_variable.ajax_url,
                    type: 'GET',
                    data: ({
                        action: 'gf_archive_product_ajax',
                        cate: cate,
                        align_cate: align_cate,
                        item_per_page: item_per_page,
                        columns: columns,
                        show_rating: show_rating,
                        show_quickview: show_quickview,
                    }),
                    success: function (data) {
                        $('.overlay-canvas-sidebar').click();
                        var $container = $('.g5plus-archive-product.g5plus-list-product');
                        $container.empty();
                        var $items = $('.products.g5plus-list-product > div', data);

                        $items.css('-webkit-transition', 'opacity 1.5s linear, transform 1s');
                        $items.css('-moz-transition', 'opacity 1.5s linear, transform 1s');
                        $items.css('-ms-transition', 'opacity 1.5s linear, transform 1s');
                        $items.css('-o-transition', 'opacity 1.5s linear, transform 1s');
                        $items.css('opacity', '0');
                        $items.css('transform', 'scale(0.2)');
                        $items.css('-ms-transform', 'scale(0.2)');
                        $items.css('-webkit-transform', 'scale(0.2)');
                        $items.addClass('apply-effect product');
                        $container.append($items);

                        $items = $('div.apply-effect', $container);
                        var items_lenght = $items.length;
                        for (var $i = 0; $i < $items.length; $i++) {
                            (function ($index) {
                                var $delay = 200 * ($i + 1);
                                setTimeout(function () {
                                    $($items[$index]).css('opacity', '1');
                                    $($items[$index]).css('transform', 'scale(1)');
                                    $($items[$index]).css('-ms-transform', 'scale(1)');
                                    $($items[$index]).css('-webkit-transform', 'scale(1)');
                                    $($items[$index]).removeClass('apply-effect');
                                }, $delay);
                            })($i);
                        }
                        if (typeof $ladda != 'undefined' && $ladda != null) {
                            $ladda.stop();
                            $this.removeClass('onclick');
                        }

                        $('.woocommerce .archive-product-wrap .category-shop-wrap i.icon-cate-mobile').click();
                        var cate_html = $this.find('span.ladda-label').html();
                        $('.woocommerce .archive-product-wrap .category-shop-wrap .text-cate-mobile').html(cate_html);

                        var $view_more_result = $('.button-view-more-wrap', data);
                        if (typeof $view_more_result != 'undefined' && $view_more_result != null) {
                            $($container, '.g5plus-woocommerce-content').after($view_more_result);
                            G5Plus.woocommerce.processViewMore();
                        }
                        $is_process_product_filter = 0;
                        G5Plus.woocommerce.saleCountdown();
                    },

                    error: function () {
                        if (typeof $ladda != 'undefined' && $ladda != null) {
                            $ladda.stop();
                            $this.removeClass('onclick');
                        }
                        $is_process_product_filter = 0;
                    }
                })

                return false;
            });

        },
        processViewMore: function () {
            $('.button-view-more-wrap .button.button-view-more').off('click').click(function (e) {
                e.preventDefault();
                G5Plus.common.startLoading($(this));
                if ($is_process_product_filter == 1)
                    return false;

                $is_process_product_filter == 1
                var $this = $(this),
                    $ladda = null;
                if ($this.hasClass('ladda-button')) {
                    $this.addClass('onclick');
                    $ladda = Ladda.create(this);
                    $ladda.start();
                }

                $is_process_product_filter = 1;
                var $parent = $(this).parent(),
                    cate = $parent.attr('data-category'),
                    align_cate = $parent.attr('data-align-cate'),
                    item_per_page = $parent.attr('data-item-perpage'),
                    columns = $parent.attr('data-columns'),
                    show_rating = $parent.attr('data-show-rating'),
                    show_quickview = $parent.attr('data-show-quickview'),
                    current_page = $parent.attr('data-current-page'),
                    max_page = $parent.attr('data-max-page'),
                    addition_attr = $parent.data('addition-attr');
                current_page++;
                $.ajax({
                    url: g5plus_app_variable.ajax_url,
                    type: 'GET',
                    data: ({
                        action: 'gf_viewmore_ajax',
                        cate: cate,
                        align_cate: align_cate,
                        item_per_page: item_per_page,
                        columns: columns,
                        show_rating: show_rating,
                        show_quickview: show_quickview,
                        current_page: current_page,
                        addition_attr: addition_attr
                    }),
                    success: function (data) {
                        var $container = $('.g5plus-archive-product.g5plus-list-product');
                        var $items = $('.products.g5plus-list-product > div', data);

                        $items.css('-webkit-transition', 'opacity 1.5s linear, transform 1s');
                        $items.css('-moz-transition', 'opacity 1.5s linear, transform 1s');
                        $items.css('-ms-transition', 'opacity 1.5s linear, transform 1s');
                        $items.css('-o-transition', 'opacity 1.5s linear, transform 1s');
                        $items.css('opacity', '0');
                        $items.css('transform', 'scale(0.2)');
                        $items.css('-ms-transform', 'scale(0.2)');
                        $items.css('-webkit-transform', 'scale(0.2)');
                        $items.addClass('apply-effect product');
                        $container.append($items);
                        G5Plus.common.stopLoading($this);

                        $('.button-view-more-wrap', '.g5plus-woocommerce-content').remove();
                        var $view_more_result = $('.button-view-more-wrap', data);
                        if (typeof $view_more_result != 'undefined' && $view_more_result != null) {
                            $($container, '.g5plus-woocommerce-content').after($view_more_result);
                            G5Plus.woocommerce.processViewMore();
                        }

                        $items = $('div.apply-effect', $container);

                        for (var $i = 0; $i < $items.length; $i++) {
                            (function ($index) {
                                var $delay = 200 * ($i + 1);
                                setTimeout(function () {
                                    $($items[$index]).css('opacity', '1');
                                    $($items[$index]).css('transform', 'scale(1)');
                                    $($items[$index]).css('-ms-transform', 'scale(1)');
                                    $($items[$index]).css('-webkit-transform', 'scale(1)');
                                    $($items[$index]).removeClass('apply-effect');
                                }, $delay);
                            })($i);
                        }
                        if (typeof $ladda != 'undefined' && $ladda != null) {
                            $ladda.stop();
                            $this.removeClass('onclick');
                        }
                        $is_process_product_filter = 0;
                    },
                    error: function () {
                        if (typeof $ladda != 'undefined' && $ladda != null) {
                            $ladda.stop();
                            $this.removeClass('onclick');
                        }
                        $is_process_product_filter = 0;
                    }
                })

                return false;
            });
        },
        pagingAjax: function () {

            $('.button-view-more-wrap', '.archive-product-inner').each(function (e) {
                var $link_button = $('a', this),
                    $max_page = parseInt($link_button.attr('data-max-page')),
                    $current_page = parseInt($link_button.attr('data-current-page'));
                if ($max_page <= $current_page) {
                    $(this).hide();
                } else {
                    $(this).show();
                }

            });

            $('a', '.woocommerce-pagination .page-numbers').click(function (e) {
                var $href = $(this).attr('href').tr.split('/');
                var $page_number = 0;
                if ($href.length > 0) {
                    $page_number = $href[$href.length - 1];
                }
                e.preventDefault();
                return false;
            });
        },
        addtoCard: function () {
            $(document).on('click', '.add_to_cart_button', function () {
                var button = $(this),
                    buttonWrap = button.parent();
                G5Plus.common.startLoading(button);
                buttonWrap.parent().parent().parent().addClass('active');
                if (!button.hasClass('single_add_to_cart_button') && button.is('.product_type_simple')) {
                    buttonWrap.addClass("added-spinner");
                }

            });

            $body.bind("added_to_cart", function (event, fragments, cart_hash, $thisbutton) {
                var is_single_product = $thisbutton.hasClass('single_add_to_cart_button');
                if (is_single_product) return;
                var button = $thisbutton,
                    buttonWrap = button.parent(),
                    buttonViewCart = buttonWrap.find('.added_to_cart'),
                    addedTitle = buttonViewCart.text(),
                    productthumbnailWrap = buttonWrap.parent().parent().parent();
                buttonViewCart.addClass('button');
                buttonViewCart.css('display', 'none');
                button.remove();
                setTimeout(function () {
                    G5Plus.common.stopLoading(buttonViewCart);
                    buttonWrap.tooltip('hide').attr('title', addedTitle).tooltip('fixTitle');
                }, 500);
                setTimeout(function () {
                    productthumbnailWrap.removeClass('active');
                }, 1000);

            });
        },
        shoppingCart: function(){
            var $cartContent = $('.shopping-cart-list .cart_list');
            $cartContent.perfectScrollbar({
                wheelSpeed: 0.5,
                suppressScrollX: true
            });
        },
        responsiveCate: function(){
            $('.woocommerce .archive-product-wrap .category-shop-wrap i.icon-cate-mobile').click(function (){
                if (window.matchMedia('(max-width: 767px)').matches) {
                    $(this).parent().toggleClass('show-cate');
                    $(this).parent().find('ul.list-categories').slideToggle('slow');
                    $(this).toggleClass('show-icon');
                    $(this).parent().find('.ladda-button').attr('data-spinner-color', '#fff');
                }
            })
        },
        initWidgetFilter: function () {
            $('a', '.ajax-filter.widget.woocommerce').each(function () {
                var $this = $(this),
                    $ladda = null,
                    $view_more_wrap = $('.button-view-more-wrap', '.g5plus-woocommerce-content'),
                    item_per_page = $view_more_wrap.attr('data-item-perpage'),
                    align_cate = $view_more_wrap.attr('data-align-cate'),
                    columns = $view_more_wrap.attr('data-columns'),
                    show_rating = $view_more_wrap.attr('data-show-rating'),
                    show_quickview = $view_more_wrap.attr('data-show-quickview');

                if (!$this.hasClass('ladda-button')) {
                    $this.addClass('ladda-button');
                    $this.attr('data-style', 'zoom-out');
                    $this.attr('data-spinner-color', '#666');
                }
                $this.click(function (e) {
                    e.preventDefault();
                    $this.parent().parent().find('li').removeClass('current-cat');
                    $this.parent().addClass('current-cat');

                    $ladda = Ladda.create(this);
                    $ladda.start();
                    var $cat = '',
                        $tag = '';
                    if($this.parent().hasClass('cat-item')){
                        $cat = $(this).attr('href').replace(/\|/g, '');
                    }
                    if($this.parent().hasClass('tagcloud')){
                        $('li.cat-item.current-cat','.widget_product_categories').removeClass('current-cat');
                        $tag = $this.attr('href').replace(/\|/g, '');
                    }

                    if($('#min_price').length> 0 && $('#max_price').length > 0 && $.isFunction($.fn.slider)){
                        var $min = $('#min_price').attr('data-min'),
                            $max = $('#max_price').attr('data-max');
                        jQuery('.price_slider').slider({
                            values: [ $min, $max ]
                        });
                    }

                    $cat = G5Plus.woocommerce.getSlugFromHref($cat);
                    $tag = G5Plus.woocommerce.getSlugFromHref($tag);

                    $.ajax({
                        url: g5plus_app_variable.ajax_url,
                        type: 'GET',
                        data: ({
                            action: 'gf_archive_product_ajax',
                            cate: $cat,
                            tag: $tag,
                            align_cate: align_cate,
                            item_per_page: item_per_page,
                            columns: columns,
                            show_rating: show_rating,
                            show_quickview: show_quickview
                        }),
                        success: function (data) {
                            $('.overlay-canvas-sidebar').click();
                            var $container = $('.g5plus-archive-product.g5plus-list-product');
                            $container.empty();
                            var $items = $('.products.g5plus-list-product > div', data);


                            $items.css('-webkit-transition', 'opacity 1.5s linear, transform 1s');
                            $items.css('-moz-transition', 'opacity 1.5s linear, transform 1s');
                            $items.css('-ms-transition', 'opacity 1.5s linear, transform 1s');
                            $items.css('-o-transition', 'opacity 1.5s linear, transform 1s');
                            $items.css('opacity', '0');
                            $items.css('transform', 'scale(0.2)');
                            $items.css('-ms-transform', 'scale(0.2)');
                            $items.css('-webkit-transform', 'scale(0.2)');
                            $items.addClass('apply-effect product');
                            $container.append($items);

                            $items = $('div.apply-effect', $container);
                            for (var $i = 0; $i < $items.length; $i++) {
                                (function ($index) {
                                    var $delay = 200 * ($i + 1);
                                    setTimeout(function () {
                                        $($items[$index]).css('opacity', '1');
                                        $($items[$index]).css('transform', 'scale(1)');
                                        $($items[$index]).css('-ms-transform', 'scale(1)');
                                        $($items[$index]).css('-webkit-transform', 'scale(1)');
                                        $($items[$index]).removeClass('apply-effect');
                                    }, $delay);
                                })($i);
                            }
                            if (typeof $ladda != 'undefined' && $ladda != null) {
                                $ladda.stop();
                                $this.removeClass('onclick');
                            }
                            $('.button-view-more-wrap', '.g5plus-woocommerce-content').remove();
                            var $view_more_result = $('.button-view-more-wrap', data);
                            if (typeof $view_more_result != 'undefined' && $view_more_result != null) {
                                $($container, '.g5plus-woocommerce-content').after($view_more_result);
                                G5Plus.woocommerce.processViewMore();
                            }
                            $is_process_product_filter = 0;
                            G5Plus.woocommerce.saleCountdown();
                            $("html, body").animate({ scrollTop: ($('#primary-content').offset().top - 70)}, 1000);

                        },

                        error: function () {
                            if (typeof $ladda != 'undefined' && $ladda != null) {
                                $ladda.stop();
                                $this.removeClass('onclick');
                            }
                            $is_process_product_filter = 0;
                        }
                    });

                    return false;
                })
            })
        },
        initPriceFilter: function () {
            var $button = $('button.button', '.widget_price_filter.ajax-filter');
            if (!$button.hasClass('ladda-button')) {
                $button.addClass('ladda-button');
                $button.attr('data-style', 'zoom-out');
                $button.attr('data-spinner-color', '#666');
            }


            $('button.button', '.widget_price_filter.ajax-filter').off('click').click(function (e) {
                e.preventDefault();
                var $ladda = Ladda.create(this),
                    $this = $(this);
                $ladda.start();

                $('li.cat-item','.widget_product_categories').removeClass('current-cat');

                var $min_price = $('#min_price').val(),
                    $max_price = $('#max_price').val(),
                    $view_more_wrap = $('.button-view-more-wrap', '.g5plus-woocommerce-content'),
                    item_per_page = $view_more_wrap.attr('data-item-perpage'),
                    align_cate = $view_more_wrap.attr('data-align-cate'),
                    columns = $view_more_wrap.attr('data-columns'),
                    show_rating = $view_more_wrap.attr('data-show-rating'),
                    show_quickview = $view_more_wrap.attr('data-show-quickview');

                $.ajax({
                    url: g5plus_app_variable.ajax_url,
                    type: 'GET',
                    data: ({
                        action: 'gf_archive_product_price_ajax',
                        align_cate: align_cate,
                        item_per_page: item_per_page,
                        columns: columns,
                        show_rating: show_rating,
                        show_quickview: show_quickview,
                        min_price: $min_price,
                        max_price: $max_price
                    }),
                    success: function (data) {
                        if (typeof $ladda != 'undefined' && $ladda != null) {
                            $ladda.stop();
                        }
                        $('.overlay-canvas-sidebar').click();
                        var $container = $('.g5plus-archive-product.g5plus-list-product');
                        $container.empty();
                        var $items = $('.products.g5plus-list-product > div', data);

                        $items.css('-webkit-transition', 'opacity 1.5s linear, transform 1s');
                        $items.css('-moz-transition', 'opacity 1.5s linear, transform 1s');
                        $items.css('-ms-transition', 'opacity 1.5s linear, transform 1s');
                        $items.css('-o-transition', 'opacity 1.5s linear, transform 1s');
                        $items.css('opacity', '0');
                        $items.css('transform', 'scale(0.2)');
                        $items.css('-ms-transform', 'scale(0.2)');
                        $items.css('-webkit-transform', 'scale(0.2)');
                        $items.addClass('apply-effect product');
                        $container.append($items);

                        $items = $('div.apply-effect', $container);
                        for (var $i = 0; $i < $items.length; $i++) {
                            (function ($index) {
                                var $delay = 200 * ($i + 1);
                                setTimeout(function () {
                                    $($items[$index]).css('opacity', '1');
                                    $($items[$index]).css('transform', 'scale(1)');
                                    $($items[$index]).css('-ms-transform', 'scale(1)');
                                    $($items[$index]).css('-webkit-transform', 'scale(1)');
                                    $($items[$index]).removeClass('apply-effect');
                                }, $delay);
                            })($i);
                        }
                        if (typeof $ladda != 'undefined' && $ladda != null) {
                            $ladda.stop();
                            $this.removeClass('onclick');
                        }
                        $('.button-view-more-wrap', '.g5plus-woocommerce-content').remove();
                        var $view_more_result = $('.button-view-more-wrap', data);
                        if (typeof $view_more_result != 'undefined' && $view_more_result != null) {
                            $($container, '.g5plus-woocommerce-content').after($view_more_result);
                            G5Plus.woocommerce.processViewMore();
                        }
                        $is_process_product_filter = 0;
                        G5Plus.woocommerce.saleCountdown();
                        $("html, body").animate({ scrollTop: ($('#primary-content').offset().top - 70)}, 1000);
                    },

                    error: function () {
                        if (typeof $ladda != 'undefined' && $ladda != null) {
                            $ladda.stop();
                            $this.removeClass('onclick');
                        }
                        $is_process_product_filter = 0;
                    }
                });

            });
        },
        getSlugFromHref:function($href){
            var lastChar = $href.slice(-1);
            if (lastChar == '/') {
                $href = $href.slice(0, -1);
            }
            $href = $href.split('/');
            return $href[$href.length - 1];
        },
        saleCountdown:function(){
            $('.sale-countdown').each(function(){
                var elm = $(this);
                var $time = $(elm).attr('data-time');
                $(elm).countdown($time,function(event){
                    setTimeout(function(){
                        $(elm).css('opacity','1');
                    },500);

                });
                $(elm).countdown($time).on('update.countdown', function(event) {
                    var second = parseInt(event.strftime('%S'));
                    var minutes = parseInt(event.strftime('%M'));
                    var hours = parseInt(event.strftime('%H'));
                    var days = parseInt(event.strftime('%D'));
                    if(second<10)
                        second = '0' + second;
                    if(minutes<10)
                        minutes = '0' + minutes;
                    if(hours<10)
                        hours = '0' + hours;
                    if(days<10)
                        days = '0' + days;

                    $('#second',elm).html(second);
                    $('#minutes',elm).html(minutes);
                    $('#hours',elm).html(hours);
                    $('#days',elm).html(days);

                }).on('finish.countdown', function(event){
                    var post_id = $(elm).attr('data-post-id');
                    if(typeof  post_id !='undefined'){
                        $('.onsale','.post-' + post_id).css('display','none');
                        $('del','.post-' + post_id).addClass('active');
                        $('ins','.post-' + post_id).addClass('deactive');
                        $(elm).hide();
                    }
                });
            })
        }
    }

    G5Plus.onReady = {
        init: function () {
            G5Plus.common.init();
            G5Plus.menu.init();
            G5Plus.page.init();
            G5Plus.header.init();
            G5Plus.blog.init();
            G5Plus.woocommerce.init();
        }
    };

    G5Plus.onLoad = {
        init: function () {
            G5Plus.header.windowLoad();
            G5Plus.page.windowLoad();
        }
    };

    G5Plus.onResize = {
        init: function () {
            G5Plus.header.windowResized();
            G5Plus.common.windowResized();
            G5Plus.page.windowResized();
            G5Plus.blog.windowResized();
        }
    };

    G5Plus.onScroll = {
        init: function () {
            G5Plus.header.windowsScroll();
        }
    };

    $(window).resize(G5Plus.onResize.init);
    $(window).scroll(G5Plus.onScroll.init);
    $(document).ready(G5Plus.onReady.init);
    $(window).load(G5Plus.onLoad.init);

})(jQuery);

