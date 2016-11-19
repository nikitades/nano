<?php

namespace app\models;

use app\system\nucleus\Model;

class Post extends Model
{
    protected $table = 'blog';
    protected $writable = [
        'name',
        'announce',
        'content',
        'user_id'
    ];

    public function url()
    {
        return '/' . $this->id;
    }
}