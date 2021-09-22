<?php

namespace app\src;

class Validator
{
    private array $data;
    private array $rules;
    public array $errors;

    public function __construct($rules, $data)
    {
        $this->data = $data;
        $this->rules = $rules;
    }

    public function handle()
    {
        foreach ($this->rules as $attribute => $rules) {
            $value = $this->data[$attribute];
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if ($ruleName === 'required' && !$value) {
                    $this->errors[] = "$attribute field is required";
                }
                if ($ruleName === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[] = "$attribute must be valid email";
                }
            }
        }
        return empty($this->errors);
    }
}