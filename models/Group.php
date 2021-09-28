<?php

namespace app\models;

use app\src\Model;

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
