<!-- horizontal bar  -->
<?php
/**
 * @var App\Shared\Infrastructure\Views\AppView $this
 */
use App\Open\Home\Infrastructure\Helpers\NavMenuHelper;
$menu = NavMenuHelper::get_self()->get_selected();
?>
<nav class="primary-menu">
    <ul id="main-menu" class="main-menu x-nav-menu x-nav-menu_main-menu x-animate-sign-flip">
        <li id="menu-item-3003"
            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home <?=$menu["inicio"] ?? "" ?> page_item page-item-9 current_page_item x-menu-item x-item-menu-standard">
            <a href="/" class="x-menu-a-text"><span class="x-menu-text">Inicio</span></a>
        </li>
        <li id="menu-item-3023"
            class="menu-item menu-item-type-post_type menu-item-object-page x-menu-item x-item-menu-standard <?=$menu["nosotros"] ?? "" ?>">
            <a href="/nosotros" class="x-menu-a-text"><span class="x-menu-text">Nosotros</span></a>
        </li>
        <li id="menu-item-3094"
            class="menu-item menu-item-type-post_type menu-item-object-page x-menu-item x-item-menu-standard <?=$menu["la-carta"] ?? "" ?>">
            <a href="/la-carta" class="x-menu-a-text"><span class="x-menu-text">La Carta</span></a>
        </li>
        <li id="menu-item-3126"
            class="menu-item menu-item-type-post_type menu-item-object-page x-menu-item x-item-menu-standard <?=$menu["eventos"] ?? "" ?>">
            <a href="/eventos" class="x-menu-a-text"><span class="x-menu-text">Eventos</span></a>
        </li>
        <li id="menu-item-3098"
            class="menu-item menu-item-type-post_type menu-item-object-page x-menu-item x-item-menu-standard <?=$menu["contacto"] ?? "" ?>">
            <a href="/contacto" class="x-menu-a-text"><span class="x-menu-text">Contacto</span></a>
        </li>
        <li id="menu-item-mobile-1" class="menu-item menu-item-type-post_type menu-item-object-page x-menu-item x-item-menu-standard">
          <a href="https://mypromos.es/afiliado/el-chalan-5#promotions" target="_blank" class="x-menu-a-text">
            <span class="x-menu-text">Promociones</span>
          </a>
        </li>
    </ul>
</nav>
<!-- horizontal bar -->