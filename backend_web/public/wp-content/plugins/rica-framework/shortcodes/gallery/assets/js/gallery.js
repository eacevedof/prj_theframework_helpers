(function ($) {
    "use strict";
    var G5PlusGallery = {
        vars: {
            is_processing: 0,
            galleries: []
        },

        init: function () {
            G5PlusGallery.initIsotope();
            G5PlusGallery.initIsotopeFilter();
        },

        initIsotope:function(){
            var $container = $('.gallery-items','.gallery-wrap.isotope');
            $container.imagesLoaded(function () {
                $container.isotope({
                    itemSelector: '.isotope-item',
                    percentPosition: true,
                    masonry: {
                        columnWidth: '.w-item'
                    }
                });
                G5PlusGallery.initGrayScale($container);
            });

            var $container_grid = $('.gallery-items','.gallery-wrap.isotope-grid');
            $container_grid.imagesLoaded(function () {
                $container_grid.isotope({
                    itemSelector: '.isotope-item'
                });
                G5PlusGallery.initGrayScale($container_grid);
            });
        },

        initIsotopeFilter:function(){
            $('a.isotope-filter').off('click').click(function(e){
                e.preventDefault();
                if($(this).hasClass('active')){
                    return false;
                }
                var $section = $(this).attr('data-section-id'),
                    $filter = $(this).attr('data-filter'),
                    $container = $('#gallery-' + $section);
                $('.gallery-categories a',$container).removeClass('active');
                $(this).addClass('active');
                $('.gallery-items',$container).isotope({ filter: $filter });
                G5PlusGallery.reInitLightGallery($filter);

                return false;
            });
        },

        initGrayScale:function($container){
            $(".item-grayscale:not(.grayscale-inited) img",$container).fadeIn(500);
            // clone image
            $('.item-grayscale:not(.grayscale-inited) img',$container).each(function(){
                var el = $(this);
                el.wrap("<div class='img_wrapper' style='display: inline-block'>").clone().addClass('img_grayscale').css({"position":"absolute","opacity":"0"}).insertBefore(el).queue(function(){
                    var el = $(this);
                    el.parent().css({"width":'100%',"height":'100%'});
                    el.dequeue();
                });
                this.src = G5PlusGallery.grayscale(this.src);
            });
            $('.item-grayscale:not(.grayscale-inited)',$container).addClass('grayscale-inited');
        },

        // Grayscale w canvas method
        grayscale: function (src) {
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');
            var imgObj = new Image();
            imgObj.src = src;
            canvas.width = imgObj.width;
            canvas.height = imgObj.height;
            ctx.drawImage(imgObj, 0, 0);
            var imgPixels = ctx.getImageData(0, 0, canvas.width, canvas.height);
            for (var y = 0; y < imgPixels.height; y++) {
                for (var x = 0; x < imgPixels.width; x++) {
                    var i = (y * 4) * imgPixels.width + x * 4;
                    var avg = (imgPixels.data[i] + imgPixels.data[i + 1] + imgPixels.data[i + 2]) / 3;
                    imgPixels.data[i] = avg;
                    imgPixels.data[i + 1] = avg;
                    imgPixels.data[i + 2] = avg;
                }
            }
            ctx.putImageData(imgPixels, 0, 0, 0, 0, imgPixels.width, imgPixels.height);
            return canvas.toDataURL();
        },

        reInitLightGallery:function($filter){
            $("[data-rel='lightGallery']").each(function () {
                var $this = $(this),
                    galleryId = $this.data('gallery-id');
                $this.off('click').on('click', function (event) {
                    event.preventDefault();
                    var _data = [],
                        $index = 0,
                        $current_src = $(this).attr('href'),
                        $current_thumb_src = $(this).data('thumb-src');
                    if (typeof galleryId != 'undefined') {
                        $('[data-gallery-id="' + galleryId + '"]','.isotope-item' + $filter).each(function (index) {
                            var src = $(this).attr('href'),
                                thumb = $(this).data('thumb-src');
                            if(src==$current_src && thumb==$current_thumb_src){
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
        }
    };
    $(document).ready(G5PlusGallery.init);
})(jQuery);
