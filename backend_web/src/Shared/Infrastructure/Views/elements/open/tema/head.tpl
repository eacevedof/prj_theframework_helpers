<?php
/**
 * @var App\Shared\Infrastructure\Views\AppView $this
 * @var string $pagetitle
 * @var array $seo
 */
$this->_element("common/elem-gtag-js");
?>
<!-- head -->
<script>document.documentElement.className = document.documentElement.className + " yes-js js_active js"</script>
<?php
$this->_element("common/elem-fb");
?>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="shortcut icon" href="/wp-content/uploads/2020/01/el-chalan-favicon.png" />
<title><?php $this->_echo_nohtml($pagetitle);?></title>
<meta name="description" content="<?php $this->_echo($seo["description"]);?>"/>
<meta name="keywords" content="<?php $this->_echo($seo["keywords"]);?>"/>
<link rel="canonical" href="<?php $this->_echo($seo["canonical"]);?>"/>
<link rel="shortlink" href="<?php $this->_echo($seo["route"]);?>"/>
<!--
<link rel="alternate" type="application/rss+xml" title="El Chalán RSS Feed" href="/feed" />
<link rel="alternate" type="application/atom+xml" title="El Chalán Atom Feed" href="/feed/atom" />
-->
<meta name='robots' content='max-image-preview:large' />
<link rel='stylesheet' id='rs-plugin-settings-css' href='/wp-content/plugins/js_composer/assets/css/js_composer.min.css' type='text/css' media='all' />
<!-- front debe ir despues de js_composer-->
<link rel='stylesheet' id='rica_framework_frontend-css' href='/wp-content/plugins/rica-framework/assets/css/frontend.css' type='text/css' media='all' />
<link rel='stylesheet' id='pe-icon-7-stroke-helper-css' href='/wp-content/themes/tema/assets/plugins/pe-icon-7-stroke/css/helper.css' type='text/css' media='all' />
<link rel='stylesheet' id='fontawesome-css' href='/wp-content/themes/tema/assets/plugins/fonts-awesome/css/font-awesome.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='fontawesome_animation-css' href='/wp-content/themes/tema/assets/plugins/fonts-awesome/css/font-awesome-animation.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='bootstrap-css' href='/wp-content/themes/tema/assets/plugins/bootstrap/css/bootstrap.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='owl-carousel-css' href='/wp-content/themes/tema/assets/plugins/owl-carousel/assets/owl.carousel.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='ligh-gallery-css' href='/wp-content/themes/tema/assets/plugins/light-gallery/css/lightgallery.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='ladda-css' href='/wp-content/themes/tema/assets/plugins/ladda/ladda.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='perffect-scrollbar-css' href='/wp-content/themes/tema/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='rica_framework__preset_style-css' href='/wp-content/themes/tema/assets/preset/5.style.min.css' type='text/css' media='all' />
<script type='text/javascript' src='/wp-includes/js/jquery/jquery.min.js' id='jquery-core-js'></script>
<script type='text/javascript' src='/wp-includes/js/jquery/jquery-migrate.min.js' id='jquery-migrate-js'></script>
<script type='text/javascript' src='/wp-content/plugins/revslider/public/assets/js/revolution.tools.min.js?ver=6.0' id='tp-tools-js'></script>
<script type='text/javascript' src='/wp-content/plugins/revslider/public/assets/js/rs6.min.js' id='revmin-js'></script>
<script type='text/javascript' src='/wp-content/plugins/js_composer/assets/js/dist/js_composer_front.min.js'></script>
<script>
//es la letra ligada
if (typeof WebFontConfig === "undefined") {
  WebFontConfig = new Object();
}
WebFontConfig['google'] = { families: ['Open+Sans:300,400,600,700,800,300italic,400italic,600italic,700italic,800italic', 'Meddon:400'] };
(function () {
  var wf = document.createElement('script');
  wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.5.3/webfont.js';
  wf.type = 'text/javascript';
  wf.async = 'true';
  var s = document.getElementsByTagName('script')[0];
  s.parentNode.insertBefore(wf, s);
})();
</script>
<style type="text/css" data-type="vc_custom-css">
.vc_row.wpb_row.vc_inner.vc_row-fluid.boton-chalan {
  justify-content: center;
  display: flex;
  text-align: center;
}
/*estilo para fondo de la carta*/
.vc_custom_1579277967706 {
  background-image: url(/wp-content/uploads/2020/01/heading-background-1.jpg) !important;
}
.vc_custom_1469001339038 {
  margin-top: -45px !important;
  background-image: url(/wp-content/uploads/2016/07/menu-bg.jpg) !important;
  background-position: 0 0 !important;
  background-repeat: repeat !important;
}

.vc_custom_1579280082775 {
  background-image: url(/wp-content/uploads/2020/01/heading-background-2.jpg) !important;
}
.vc_custom_1579286870650 {
  background-color: #f8f8f8 !important;
}
.vc_custom_1581719490638 {
  background-color: #c40c27 !important;
}
.vc_custom_1616937509195 {
  margin-top: 48px !important;
}
.vc_custom_1469000322461 {
  padding-top: 26px !important;
  padding-right: 26px !important;
  padding-left: 26px !important;
  background-color: #ffffff !important;
}
</style>
<style type="text/css" title="dynamic-css" class="options-output">
body {
  background-repeat: no-repeat;
  background-size: cover;
  background-attachment: fixed;
  background-position: center center;
  font-family: "Open Sans";
  font-weight: 400;
  font-style: normal;
  font-size: 14px;
  opacity: 1;
  visibility: visible;
  -webkit-transition: opacity 0.24s ease-in-out;
  -moz-transition: opacity 0.24s ease-in-out;
  transition: opacity 0.24s ease-in-out;
}
.wf-loading body {
    opacity: 0;
}
.ie.wf-loading body {
    visibility: hidden;
}
.x {
    font-family: Meddon;
    opacity: 1;
    visibility: visible;
    -webkit-transition: opacity 0.24s ease-in-out;
    -moz-transition: opacity 0.24s ease-in-out;
    transition: opacity 0.24s ease-in-out;
}
.wf-loading {
    opacity: 0;
}
.ie.wf-loading {
    visibility: hidden;
}
h1 {
    font-family: "Open Sans";
    font-weight: 600;
    font-style: normal;
    font-size: 36px;
    opacity: 1;
    visibility: visible;
    -webkit-transition: opacity 0.24s ease-in-out;
    -moz-transition: opacity 0.24s ease-in-out;
    transition: opacity 0.24s ease-in-out;
}
.wf-loading h1 {
    opacity: 0;
}
.ie.wf-loading h1 {
    visibility: hidden;
}
h2 {
    font-family: "Open Sans";
    font-weight: 600;
    font-style: normal;
    font-size: 30px;
    opacity: 1;
    visibility: visible;
    -webkit-transition: opacity 0.24s ease-in-out;
    -moz-transition: opacity 0.24s ease-in-out;
    transition: opacity 0.24s ease-in-out;
}
.wf-loading h2 {
    opacity: 0;
}
.ie.wf-loading h2 {
    visibility: hidden;
}
h3 {
    font-family: "Open Sans";
    font-weight: 700;
    font-style: normal;
    font-size: 20px;
    opacity: 1;
    visibility: visible;
    -webkit-transition: opacity 0.24s ease-in-out;
    -moz-transition: opacity 0.24s ease-in-out;
    transition: opacity 0.24s ease-in-out;
}
.wf-loading h3 {
    opacity: 0;
}
.ie.wf-loading h3 {
    visibility: hidden;
}
h4 {
    font-family: "Open Sans";
    font-weight: 400;
    font-style: normal;
    font-size: 18px;
    opacity: 1;
    visibility: visible;
    -webkit-transition: opacity 0.24s ease-in-out;
    -moz-transition: opacity 0.24s ease-in-out;
    transition: opacity 0.24s ease-in-out;
}
.wf-loading h4 {
    opacity: 0;
}
.ie.wf-loading h4 {
    visibility: hidden;
}
h5 {
    font-family: "Open Sans";
    font-weight: 600;
    font-style: normal;
    font-size: 16px;
    opacity: 1;
    visibility: visible;
    -webkit-transition: opacity 0.24s ease-in-out;
    -moz-transition: opacity 0.24s ease-in-out;
    transition: opacity 0.24s ease-in-out;
}
.wf-loading h5 {
    opacity: 0;
}
.ie.wf-loading h5 {
    visibility: hidden;
}
h6 {
    font-family: "Open Sans";
    font-weight: 600;
    font-style: normal;
    font-size: 14px;
    opacity: 1;
    visibility: visible;
    -webkit-transition: opacity 0.24s ease-in-out;
    -moz-transition: opacity 0.24s ease-in-out;
    transition: opacity 0.24s ease-in-out;
}
.wf-loading h6 {
    opacity: 0;
}
.ie.wf-loading h6 {
    visibility: hidden;
}
</style>
<noscript>
<style>
.wpb_animate_when_almost_visible {
    opacity: 1;
}
</style>
</noscript>
<!--/head-->