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

    private const CACHE_TIME_IN_SECS = 3600 * 8;

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

    public function we(): void
    {
        $seo = SeoService::get_meta("home.we");
        $this->set_layout("open/tema/home")
            ->add_var(PageType::TITLE, $seo["title"])
            ->add_var(PageType::H1, $seo["h1"])
            ->add_var("seo", $seo)
            ->cache(self::CACHE_TIME_IN_SECS);
        unset($seo);
        $this->view->render();
    }

    public function the_menu(): void
    {
        $seo = SeoService::get_meta("home.themenu");
        $this->set_layout("open/tema/home")
            ->add_var(PageType::TITLE, $seo["title"])
            ->add_var(PageType::H1, $seo["h1"])
            ->add_var("seo", $seo)
            ->cache(self::CACHE_TIME_IN_SECS);
        unset($seo);
        $this->view->render();
    }

    public function events(): void
    {
        $seo = SeoService::get_meta("home.events");
        $this->set_layout("open/tema/home")
            ->add_var(PageType::TITLE, $seo["title"])
            ->add_var(PageType::H1, $seo["h1"])
            ->add_var("seo", $seo)
            ->cache(self::CACHE_TIME_IN_SECS);
        unset($seo);
        $this->view->render();
    }

    public function search(): void
    {
        $this->response->location(Routes::url("home.index"));
    }

    public function contact(): void
    {
        $this->_load_session();
        $post = $this->session->get_once("contact-error-post", []);
        $error = $this->session->get_once("contact-error-message", "");
        $success = $this->session->get_once("contact-success", "");
        $fields = $this->session->get_once("contact-error-fields", []);

        $seo = SeoService::get_meta("home.contact");
        $this->set_layout("open/tema/home")
            ->add_var(PageType::TITLE, $seo["title"])
            ->add_var(PageType::H1, $seo["h1"])
            ->add_var(PageType::CSRF, SF::get(CsrfService::class)->get_token())
            ->add_var("seo", $seo)
            ->add_var("post", $post)
            ->add_var("error", $error)
            ->add_var("fields", $fields)
            ->add_var( "success", $success);
        unset($post, $error, $success, $fields, $seo);
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



