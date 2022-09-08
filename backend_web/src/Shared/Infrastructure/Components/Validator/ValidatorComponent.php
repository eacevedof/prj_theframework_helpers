<?php

namespace App\Shared\Infrastructure\Components\Validator;

final class ValidatorComponent
{
    private array $rules = [];
    private array $errors = [];
    private array $request;

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public static function get_self(array $body): self
    {
        return new self($body["request"] ?? []);
    }

    private function _check_rules(): void
    {
        foreach ($this->rules as $rule) {
            $field = $rule["field"];
            $label = $this->request["label-$field"] ?? "";
            $value = $this->request[$field] ?? null;

            $message = $rule["fn"]([
                "data" => $this->request,
                "field" => $field,
                "value" => $value,
                "label" => $label
            ]);

            if ($message)
                $this->_add_error($field, $rule["rule"], $value, $message, $label);

        }
    }

    private function _add_error(string $field, string $rule, $value, string $message, string $label): self
    {
        $this->errors[] = [
            "field" => $field,
            "rule" => $rule,
            "value" => $value,
            "label" => $label,
            "message" => $message,
        ];
        return $this;
    }

    public function get_errors(): array
    {
        if ($this->errors) return $this->errors;
        $this->_check_rules();
        return $this->errors;
    }

    public function add_rule(string $field, string $rule, callable $fn): self
    {
        $this->rules[] = ["field" => $field, "rule" => $rule, "fn" => $fn];
        return $this;
    }
}
