<?php

namespace app\src;

class Mentor extends Model
{
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $group_id = '';

    public function tableName(): string
    {
        return 'mentors';
    }

    public function attributes(): array
    {
        return ['first_name', 'last_name', 'email', 'group_id'];
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email'],
            'group_id' => ['required', 'exists'],
        ];
    }
}