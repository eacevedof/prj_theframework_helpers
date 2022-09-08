<?php
namespace App\Open\Home\Infrastructure\Controllers;

use App\Shared\Infrastructure\Controllers\Open\OpenController;
use App\Shared\Infrastructure\Traits\SessionTrait;
use App\Shared\Infrastructure\Helpers\RoutesHelper as Routes;
use App\Shared\Infrastructure\Factories\ServiceFactory as SF;
use App\Open\Home\Application\SeoService;
use App\Restrict\Auth\Application\CsrfService;
use App\Shared\Domain\Enums\PageType;

final class HomeController extends OpenController
{
    use SessionTrait;

    private const CACHE_TIME_IN_SECS = 0;// 3600 * 8;

    public function index(): void
    {
        $seo = SeoService::get_meta("home.index");
        $this->set_layout("open/tema/home")
            ->add_var(PageType::TITLE, $seo["title"])
            ->add_var(PageType::H1, $seo["h1"])
            ->add_var("seo", $seo)
            ->cache(self::CACHE_TIME_IN_SECS);
        unset($seo);
        $this->view->render();
    }

    public function versions(): void
    {
        $seo = SeoService::get_meta("home.versions");
        $this->set_layout("open/tema/home")
            ->add_var(PageType::TITLE, $seo["title"])
            ->add_var(PageType::H1, $seo["h1"])
            ->add_var("seo", $seo)
            ->cache(self::CACHE_TIME_IN_SECS);
        unset($seo);
        $this->view->render();
    }

    public function joke(): void
    {
        http_response_code(404);
        exit("<pre style=\"font-size: 24px;\">🤨 ...mmm What are you trying to do BB?");
    }

    public function trs(): void
    {
        echo "<pre>";
        \App\Shared\Infrastructure\Components\Translation\TranslationComponent::get_self()->run();
    }
}



