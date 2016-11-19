<?php

namespace app\models;

use app\system\nucleus\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $writable = [
        'user_id',
        'post_id',
        'text'
    ];
}