<?php
/**
 * @var App\Shared\Infrastructure\Views\AppView $this
 */
use App\Shared\Infrastructure\Helpers\RoutesHelper as Routes;
$urlback = Routes::url("home.index");
?>
<h1><?=$h1?></h1>
<p class="zoom-area">
  <b><?=$error[0]?></b>
</p>
<section class="error-container">
  <span>4</span>
  <span><span class="screen-reader-text">0</span></span>
  <span>3</span>
</section>
<div class="link-container">
  <a href="<?php $this->_echo($urlback);?>" class="more-link"><?=__("Back to home")?></a>
</div>