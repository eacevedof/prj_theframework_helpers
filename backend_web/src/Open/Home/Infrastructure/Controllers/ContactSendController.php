<?php
namespace App\Open\Home\Infrastructure\Controllers;

use App\Shared\Domain\Enums\PageType;
use App\Shared\Infrastructure\Controllers\Open\OpenController;
use App\Shared\Infrastructure\Traits\LogTrait;
use App\Shared\Infrastructure\Factories\ServiceFactory as SF;
use App\Shared\Infrastructure\Helpers\RoutesHelper as Routes;
use App\Restrict\Auth\Application\CsrfService;
use App\Open\Home\Application\ContactSendService;
use App\Shared\Domain\Enums\RequestActionType;
use App\Shared\Domain\Enums\ResponseType;
use App\Shared\Infrastructure\Exceptions\BadRequestException;
use App\Shared\Infrastructure\Traits\SessionTrait;
use \Exception;

final class ContactSendController extends OpenController
{
    use LogTrait;
    use SessionTrait;

    public function send(): void
    {
        if (!SF::get(CsrfService::class)->is_valid($this->_get_csrf()))
            $this->add_var(PageType::TITLE, __("Bad request"))
                ->add_var(PageType::H1, __("Invalid CSRF"))
                ->add_header(ResponseType::BAD_REQUEST)
                ->set_foldertpl("Open/Errors/Infrastructure/Views")
                ->set_template("400")
                ->render_nl();

        $post = $this->request->get_post();
        if (($post["_action"] ?? "") !== RequestActionType::HOME_CONTACT_SEND)
            $this->add_var(PageType::TITLE, __("Bad request"))
                ->add_var(PageType::H1, __("Wrong action"))
                ->add_header(ResponseType::BAD_REQUEST)
                ->set_foldertpl("Open/Errors/Infrastructure/Views")
                ->set_template("400")
                ->render_nl();

        try {
            $send = SF::get_callable(ContactSendService::class, $post);
            $result = $send();
            $this->_load_session()->add("contact-success", $result["description"]);
            $this->response->location(Routes::url("home.contact"));
        }
        catch (BadRequestException $e) {
            $this->_load_session()
                ->add("contact-error-post", $post)
                ->add("contact-error-message", $e->getMessage())
                ->add("contact-error-fields", $send->get_errors());
            $this->response->location(Routes::url("home.contact"));
        }
        catch (Exception $e) {
            $this->logerr($e->getMessage());
            $this->add_var(PageType::TITLE, __("Error"))
                ->add_var(PageType::H1, __("Unexpected error"))
                ->add_header(ResponseType::INTERNAL_SERVER_ERROR)
                ->set_foldertpl("Open/Errors/Infrastructure/Views")
                ->set_template("500")
                ->render_nl();
        }
    }
}



