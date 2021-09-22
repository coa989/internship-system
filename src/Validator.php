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
                if (!is_string($rule)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === 'required' && !$value) {
                    $this->errors[] = "$attribute field is required";
                }
            }
        }
        return empty($this->errors);
    }
}