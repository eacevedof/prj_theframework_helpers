(function ($) {
    "use strict";
    var G5PlusMenuFood = {
        vars: {
            is_processing: 0,
            galleries: []
        },

        init: function() {

            /**
             * Process switch tab
             */
            $('a','.food-tabs').off('click').click(function(e){
                e.preventDefault();
                var $tab = $(this).attr('data-tab');
                var $section_id = '#' + $(this).attr('data-section-id');
                var $group_selected = $('div[data-tab="' + $tab + '"]',$section_id);
                if($group_selected.length>0){
                    $('a',$section_id).removeClass('active');
                    $(this).addClass('active');
                    $('.menu-food-group > div',$section_id).hide();
                    $group_selected.fadeIn(600);
                }
            });

            /**
             * Process view more
             */
            $('a','.view-more-wrap').off('click').click(function(e){
                var $this =  $(this);
                var $section_id = '#' + $(this).attr('data-section-id');
                var $next_page = $(this).attr('data-next-page');
                var $category = $(this).attr('data-category');
                var $layout = $($section_id).attr('data-layout');
                var $columns = $($section_id).attr('data-columns');
                var $post_per_page = $($section_id).attr('data-post-per-page');
                var $total_items = $($section_id).attr('data-total-items');
                var $image_position = $($section_id).attr('data-image-position');
                var $post_type = $($section_id).attr('data-post-type');
                var $show_category = $($section_id).attr('data-show-category');
                var $is_exists_loading_function = typeof G5Plus !='undefined' && typeof G5Plus.common !='undefined' && $.isFunction(G5Plus.common.startLoading);
                e.preventDefault();
                if($is_exists_loading_function){
                    G5Plus.common.startLoading($this);
                }
                if(G5PlusMenuFood.vars.is_processing==1){
                    return false;
                }
                G5PlusMenuFood.vars.is_processing = 1;

                $.ajax({
                    url: g5plus_app_variable.ajax_url,
                    type: 'GET',
                    data: ({
                        action: 'gf_menu_food_load_more',
                        data_source: '',
                        category: $category,
                        menu_layout: $layout,
                        columns: $columns,
                        post_per_page: $post_per_page,
                        total_items: $total_items,
                        current_page: $next_page,
                        image_position: $image_position,
                        post_type: $post_type,
                        show_category: $show_category
                    }),
                    success: function (data) {

                        var $items = $('.menu-food-group .row > div',data);
                        var $has_view_more = $('.bt-view-more',data);
                        var $tab_group = $('div[data-tab="' + $category + '"]',$section_id);
                        var $container = $('.row',$tab_group);

                        $items.css('transition', 'opacity 1.5s linear, transform 1s');
                        $items.css('-webkit-transition', 'opacity 1.5s linear, transform 1s');
                        $items.css('-moz-transition', 'opacity 1.5s linear, transform 1s');
                        $items.css('-ms-transition', 'opacity 1.5s linear, transform 1s');
                        $items.css('-o-transition', 'opacity 1.5s linear, transform 1s');
                        $items.css('opacity', 0);
                        $items.css('transform', 'scale(0.2)');
                        $items.css('-ms-transform', 'scale(0.2)');
                        $items.css('-webkit-transform', 'scale(0.2)');
                        $items.addClass('apply-effect');
                        $container.append($items);

                        $items =  $('div.apply-effect',$container);

                        for (var $i = 0; $i < $items.length; $i++) {
                            (function ($index) {
                                var $delay = 100 * ($i+1);
                                setTimeout(function () {
                                    $($items[$index]).css('opacity', 1);
                                    $($items[$index]).css('transform', 'scale(1)');
                                    $($items[$index]).css('-ms-transform', 'scale(1)');
                                    $($items[$index]).css('-webkit-transform', 'scale(1)');
                                    $($items[$index]).removeClass('apply-effect');
                                }, $delay);
                            })($i);
                        }
                        G5PlusMenuFood.registerViewGallery($container);

                        if($is_exists_loading_function){
                            G5Plus.common.stopLoading($this);
                        }

                        if($has_view_more.length>0){
                            var next_page = $('.bt-view-more',data).attr('data-next-page');
                            $this.attr('data-next-page',next_page);
                        }else{
                            $this.remove();
                        }

                        G5PlusMenuFood.vars.is_processing = 0;
                    },
                    error: function () {
                       /* if (typeof l != 'undefined') {
                            l.stop();
                            $this.removeClass('onclick');
                        }*/
                        if($is_exists_loading_function){
                            G5Plus.common.stopLoading($this);
                        }
                        G5PlusMenuFood.vars.is_processing = 0;
                    }
                });
            });

            G5PlusMenuFood.registerViewGallery($( '.menu-food-wrapper'));
        },
        registerViewGallery: function($container){
            $('a.view-gallery', $container).click(function () {
                var $post_id = $(this).attr('data-post-id');
                var $post_type = $(this).attr('data-post-type');
                var $this = $(this);
                var l = null;
                if ($this.hasClass('ladda-button')) {
                    $this.addClass('onclick');
                    l = Ladda.create(this);
                    l.start();
                }
                if(G5PlusMenuFood.vars.is_processing==1){
                    return false;
                }
                $this.parent().addClass('processing');
                G5PlusMenuFood.vars.is_processing = 1;
                if(typeof G5PlusMenuFood.vars.galleries[$post_id] == 'undefined'){
                    $.ajax({
                        url: g5plus_app_variable.ajax_url,
                        type: 'GET',
                        data: ({
                            action: 'gf_menu_food_load_gallery',
                            post_id: $post_id,
                            post_type: $post_type
                        }),
                        success: function (data) {
                            $this.parent().removeClass('processing');
                            if (typeof l != 'undefined') {
                                l.stop();
                                $this.removeClass('onclick');
                            }
                            var $galleries = JSON.parse(data);
                            $(this).lightGallery({
                                dynamic: true,
                                dynamicEl: $galleries,
                                hash: false
                            });
                            G5PlusMenuFood.vars.galleries[$post_id] = JSON.parse(data);
                            G5PlusMenuFood.vars.is_processing = 0;
                        },
                        error: function () {
                            if (typeof l != 'undefined') {
                                l.stop();
                                $this.removeClass('onclick');
                            }
                            G5PlusMenuFood.vars.is_processing = 0;
                            $this.parent().removeClass('processing');
                        }
                    });
                }else{
                    $this.parent().removeClass('processing');
                    $(this).lightGallery({
                        dynamic: true,
                        dynamicEl: G5PlusMenuFood.vars.galleries[$post_id]
                    });
                    if (typeof l != 'undefined') {
                        l.stop();
                        $this.removeClass('onclick');
                    }
                    G5PlusMenuFood.vars.is_processing = 0;
                }

            });
        }
    };
    $(document).ready(G5PlusMenuFood.init);
})(jQuery);
