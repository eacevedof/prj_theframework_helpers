<?php

namespace application\modules\shared\Components;

/**
 * @property int $code http status code
 * @property int $status success | error it depends on the code
 * @property string $message any message u want to send
 * @property mixed $data array | object | int | string | null
 */
final class ResponseDto
{
    private string $status;
    private string $message;
    private int $code;
    private $data;

    public function __construct(array $primitives)
    {
        $this->code = (int)($primitives["code"] ?? 200);
        $this->status = $this->getStatusByCode();
        $this->message = (string)($primitives["message"] ?? "");
        $this->data = $primitives["data"] ?? [];
    }

    private function getStatusByCode(): string
    {
        $responseCode = (string) $this->code;
        $two = "2";
        if (substr($responseCode, 0, strlen($two)) === $two)
            return "success";
        return "error";
    }

    public static function fromPrimitives(array $primitives): self
    {
        return new self($primitives);
    }

    public function status(): int
    {
        return $this->status;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function code(): int
    {
        return $this->code;
    }

    public function data()
    {
        return $this->data;
    }

    private function toArray(): array
    {
        return [
            "code" => $this->code,
            "status" => $this->status,
            "message" => $this->message,
            "data" => $this->data
        ];
    }

    public function getAsJson(): string
    {
        return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE);
    }

}
