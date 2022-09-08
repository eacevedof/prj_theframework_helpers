<?php
namespace App\Open\Errors\Infrastructure\Controllers;

use App\Shared\Infrastructure\Controllers\Open\OpenController;
use App\Shared\Domain\Enums\ResponseType;
use App\Shared\Domain\Enums\PageType;
use App\Shared\Infrastructure\Traits\SessionTrait;

final class ErrorsController extends OpenController
{
    use SessionTrait;

    private function _get_back_link(): string
    {
        $back = __("Back");
        return ($urlback = $this->request->get_referer()) ? "<a href=\"$urlback\" class=\"white\"><b>$back</b></a>" : "";
    }

    public function badrequest_400(): void
    {
        //$error = $this->_load_session()->get_once("global_error", []);
        $this->add_header($code = ResponseType::BAD_REQUEST)
            ->set_layout("open/tema/error")
            ->set_template("400")
            ->add_var(PageType::TITLE, $title = __("Bad request {0}!", $code))
            ->add_var(PageType::H1, $title)
            ->add_var("error", [
                __("Bad request"),
            ])
            ->add_var("code", $code)
            ->render();
    }

    public function notfound_404(): void
    {
        $this->add_header($code = ResponseType::NOT_FOUND)
            ->set_layout("open/tema/error")
            ->set_template("404")
            ->add_var(PageType::TITLE, $title = __("Error {0}!", $code))
            ->add_var(PageType::H1, $title)
            ->add_var("error", [
                __("Content not found"),
            ])
            ->add_var("code", $code)
            ->render();
    }

    public function forbidden_403(): void
    {
        $this->add_header($code = ResponseType::FORBIDDEN)
            ->set_layout("open/tema/error")
            ->set_template("403")
            ->add_var(PageType::TITLE, $title = __("Forbidden {0}!", $code))
            ->add_var(PageType::H1, $title)
            ->add_var("error", [
                __("You are not allowed to view this content")
            ])
            ->add_var("code", $code)
            ->render();
    }

    public function internal_500(): void
    {
        //$error = $this->_load_session()->get_once("global_error", []);
        $this->add_header($code = ResponseType::FORBIDDEN)
            ->set_layout("open/tema/error")
            ->set_template("500")
            ->add_var(PageType::TITLE, $title = __("An unexpected error occurred!", $code))
            ->add_var(PageType::H1, $title)
            ->add_var("error", [
                __("Woops! Something went wrong."),
                __("Please, try again later"),
            ])
            ->add_var("code", $code);
        $this->view->render();
    }
}
