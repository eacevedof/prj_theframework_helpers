/**
 * Created by trungpq on 20/06/2016.
 */
(function ($) {
    "use strict";
    var G5PlusSpace = {
        init: function() {
            var css = '';
            $('.g5plus-space').each(function(){
                var sid = $(this).data('id');
                var tablet = $(this).data('tablet');
                var tablet_portrait = $(this).data('tablet-portrait');
                var mobile = $(this).data('mobile');
                var mobile_landscape = $(this).data('mobile-landscape');
                if(tablet != '' || tablet == '0' || tablet == 0)
                {
                    css += ' @media (max-width: 1199px) { .space-'+sid+' { height:'+tablet+'px  !important;} } ';
                }
                if(typeof tablet_portrait != 'undefined' && (tablet_portrait != '' || tablet_portrait == '0' || tablet_portrait == 0))
                {
                    css += ' @media (max-width: 991px) { .space-'+sid+' { height:'+tablet_portrait+'px  !important;} } ';
                }
                if(typeof mobile_landscape != 'undefined' && (mobile_landscape != '' || mobile_landscape == '0' || mobile_landscape == 0))
                {
                    css += ' @media (max-width: 767px) { .space-'+sid+' { height:'+mobile_landscape+'px  !important;} } ';
                }
                if(mobile != '' || mobile == '0' || mobile == 0)
                {
                    css += ' @media (max-width: 479px) { .space-'+sid+' { height:'+mobile+'px  !important;} } ';
                }
            });
            if(css != '')
            {
                css = '<style>'+css+'</style>';
                $('head').append(css);
            }
        }
    };
    $(document).ready(G5PlusSpace.init);
})(jQuery);