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
<body>
</body>
<body>
<?php
$this->_element("common/elem-band-env");
?>
<div id="divMain" class="container-fluid">
  <?php
  $this->_element("common/elem-nav-main");
  ?>
  <div class="row"><br/><br/></div>
  <div class="jumbotron" style="padding:20px;">
    <h1 class="display-3"><?php $this->_echo($h1);?></h1>
    <p class="lead">
      <?php $this->_echo($resume);?>
    </p>
    <?php
    include("elem_buttondownload.php");
    ?>
  </div>
  <?php
  $this->_element("common/elem-breadscrums");
  $this->_element("common/elem-gettingstarted");
  ?>
  <div class="row">
    <?php
    $this->_template();
    ?>
  </div>
  <p class="text-center">
    <?php
    $this->_element("common/elem-totop");
    ?>
  </p>
</div>
<?php
$this->_element("common/elem-footer");
?>
<script src="/js/bundles/bundle.js"></script>
</body>
</html>