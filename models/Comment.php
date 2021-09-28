<?php

namespace app\models;

use app\src\Model;

class Comment extends Model
{
    public string $body = '';
    public string $mentor_id = '';
    public string $intern_id = '';

    public function tableName(): string
    {
        return 'comments';
    }

    public function attributes(): array
    {
        return ['body', 'mentor_id', 'intern_id'];
    }

    public function rules(): array
    {
        return [
            'body' => ['required'],
            'mentor_id' => ['required', 'exist'],
            'intern_id' => ['required', 'exist']
        ];
    }
}