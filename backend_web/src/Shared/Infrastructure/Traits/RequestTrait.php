<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link eduardoaf.com
 * @name App\Traits\RequestTrait
 * @file RequestTrait.php 1.0.0
 * @date 18-11-2021 21:51 SPAIN
 * @observations
 */
namespace App\Shared\Infrastructure\Traits;
use App\Shared\Infrastructure\Factories\ComponentFactory as CF;
use App\Shared\Infrastructure\Components\Request\RequestComponent;
use App\Shared\Domain\Enums\RequestType;

/**
 * Trait RequestTrait
 * @package App\Traits
 * $this->request, _load_request, _get_csrf, _get_req_without_ops
 */
trait RequestTrait
{
    protected ?RequestComponent $request = null;

    protected function _load_request(): RequestComponent
    {
        if(!$this->request)
            $this->request = CF::get(RequestComponent::class);
        return $this->request;
    }

    protected function _get_req_without_ops(array $request=[]): array
    {
        if (!$request) $request = $this->request->get_post();
        
        $without = [];
        foreach ($request as $key=>$value)
            if(substr($key,0,1)!="_")
                $without[$key] = is_string($value) && trim($value)==="" ? null : trim($value);

        return $without;
    }

    protected function _get_csrf(array $request=[]): string
    {
        if(!$request) $request = $this->request->get_post();
        return $request[RequestType::CSRF] ?? "";
    }

}//RequestTrait
