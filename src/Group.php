<?php

namespace app\src;

class Group extends Model
{
    public string $name = '';

    public function tableName(): string
    {
        return 'groups';
    }

    public function attributes(): array
    {
        return ['name'];
    }

    public function rules(): array
    {
        return [
            'name' => ['required']
        ];
    }
}