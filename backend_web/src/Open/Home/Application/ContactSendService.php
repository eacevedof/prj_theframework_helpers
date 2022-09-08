<?php
namespace App\Open\Home\Application;

use App\Shared\Infrastructure\Services\AppService;
use App\Shared\Infrastructure\Factories\ComponentFactory as CF;
use App\Shared\Infrastructure\Components\Checker\CheckerComponent;
use App\Shared\Infrastructure\Components\Email\FuncEmailComponent;
use App\Shared\Infrastructure\Components\Validator\ValidatorComponent;
use App\Shared\Infrastructure\Exceptions\BadRequestException;

final class ContactSendService extends AppService
{
    public function __construct(array $input)
    {
        $this->input = [
            "email" => htmlentities(trim($input["email"] ?? "")),
            "name" => htmlentities(trim($input["name"] ?? "")),
            "message" => htmlentities(trim($input["message"] ?? "")),
        ];
    }

    private function _validate(): array
    {
        $validator = ValidatorComponent::get_self(["request"=>$this->input]);
        $validator
            ->add_rule("name", "name", function ($data) {
                $value = $data["value"];
                if (!$value)
                    return __("Empty value is not allowed");

                if (!is_string($value))
                    return __("Invalid {0} format", __("Name"));

                if (strlen($value)<5 || strlen($value)>25)
                    return __("{0} must be greater than {1} and lighter than {2}", __("Name"), 5, 25);

                if (!CheckerComponent::name_format($value))
                    return __("Invalid {0} format", __("Name"));
            })
            ->add_rule("email", "email", function ($data) {
                $value = $data["value"];
                if (!$value)
                    return __("Empty value is not allowed");
                if (!is_string($value))
                    return __("Invalid {0} format", __("Email"));
                if (strlen($value)<5 || strlen($value)>35)
                    return __("{0} must be greater than {1} and lighter than {2}", __("Email"), 5, 35);
                if (!CheckerComponent::is_valid_email($value))
                    return __("Invalid {0} format", __("Email"));
            })
            ->add_rule("message", "message", function ($data) {
                $value = $data["value"];
                if (!$value)
                    return __("Empty value is not allowed");
                if (!is_string($value))
                    return __("Invalid {0} format", __("Message"));
                if (strlen($value)<10 || strlen($value)>2000)
                    return __("{0} must be greater than {1} and lighter than {2}", __("Message"), 10, 2000);
            });
        return $validator->get_errors();
    }

    public function __invoke(): array
    {
        if ($this->errors = $this->_validate()) {
            throw new BadRequestException(__("Bad request. Check form errors"));
        }

        /**
         * @var FuncEmailComponent $email
         */
        $email = CF::get(FuncEmailComponent::class);
        $email
            ->set_from(getenv("APP_EMAIL_FROM1"))
            ->add_to(getenv("APP_EMAIL_TO"))
            ->add_to("eacevedof@gmail.com")
            ->set_subject("elchalanaruba.com - contacto")
            ->set_content("
            <html><head></head>
            <body>
            <ul>
            <li><b>Nombre:</b> {$this->input["name"]}</li>
            <li><b>Email:</b>{$this->input["email"]}</li>
            <li><b>Mensaje:</b><p>{$this->input["message"]}</p></li>
            </ul>
            </body>
            </html>
            ")
            ->send()
        ;
        return [
            "description" => __("Thank you! Your information has been sent successfully."),
        ];
    }
}