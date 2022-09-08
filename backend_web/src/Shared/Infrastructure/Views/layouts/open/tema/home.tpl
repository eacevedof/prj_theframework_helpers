<?php
/**
 * @var App\Shared\Infrastructure\Views\AppView $this
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php
$this->_element("open/tema/head");
?>
</head>
<body class="home page-template-default page page-id-9 wp-embed-responsive theme-tema chrome header-is-float vc_responsive" data-responsive="991" data-header="header-3">
<?php
$this->_element("common/elem-band-env");
?>
<div id="wrapper">
  <header class="main-header header-3">
    <div class="sticky-wrapper">
      <div class="header-wrapper clearfix float-header sticky-region">
        <div class="container-fluid">
          <div class="header-above-inner container-inner clearfix">
            <div class="logo-header">
              <a class="no-sticky" href="/"
                 title="El Chalán-Podrás disfrutar de la mejor gastronomía peruana, Pescados Mariscos comida Criolla y los mejores Postres y  Bebidas.">
                <img src="/wp-content/uploads/2020/01/el-chalan-logo.png"
                     alt="El Chalán-Podrás disfrutar de la mejor gastronomía peruana, Pescados Mariscos comida Criolla y los mejores Postres y  Bebidas." />
              </a>
            </div>
            <?php
            $this->_element("open/tema/elem-nav-main");
            ?>
            <div class="header-customize-wrapper header-customize-nav">
              <div class="header-customize-item item-custom-text">
                <div class="reservation-phone">
                  <a href="tel:+297 5827591" rel="noreferrer noopener nofollow">
                    <i class="pe-7s-bell"></i>RESERVATION: +297 5827591
                  </a>
                </div>
              </div>
              <div class="header-customize-item item-search">
                <a href="index.html#" class="prevent-default search-standard"><i class="fa fa-search"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <header class="header-mobile header-mobile-1">
    <div class="header-mobile-wrapper sticky-wrapper">
      <div class="header-mobile-inner sticky-region">
        <div class="container header-mobile-container">
          <div class="header-mobile-container-inner clearfix">
            <div class="logo-mobile-wrapper">
              <a href="/"
                 title="El Chalán-Podrás disfrutar de la mejor gastronomía peruana, Pescados Mariscos comida Criolla y los mejores Postres y  Bebidas.">
                <img src="/wp-content/uploads/2020/01/el-chalan-logo.png"
                     alt="El Chalán-Podrás disfrutar de la mejor gastronomía peruana, Pescados Mariscos comida Criolla y los mejores Postres y  Bebidas." />
              </a>
            </div>
            <div class="toggle-icon-wrapper toggle-mobile-menu" data-drop-type="menu-drop-fly">
              <div class="toggle-icon"><span></span></div>
            </div>

            <div class="mobile-search-button">
              <a href="index.html#" class="prevent-default search-standard"><i class="fa fa-search"></i></a>
            </div>
          </div>
          <?php
          $this->_element("open/tema/elem-nav-mobile");
          ?>
        </div>
      </div>
    </div>
  </header>

  <div id="wrapper-content" class="clearfix">
    <div id="primary-content" class="page-wrap">
      <div class="page-inner">
<?php
$this->_template();
?>
      </div>
    </div>
  </div>
<?php
$this->_element("open/tema/elem-footer");
?>
</div>
<a class="back-to-top" href="javascript:;"><i class="fa fa-angle-up"></i></a>
<?php
$this->_element("open/tema/elem-js-bottom-slider");
?>
</body>
</html>