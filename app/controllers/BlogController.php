<?php

namespace app\controllers;

use app\models\Comment;
use app\models\Post;
use app\models\User;
use app\system\nucleus\Validator;
use app\system\Request;

class BlogController
{
    public function show($id)
    {
        if (!$post = Post::id($id)) return Request::error404();
        $post->comments = Comment::where('post_id', $post->id);
        foreach ($post->comments as $comment) $comment->user = User::id($comment->user_id);
        return view('pages.post', ['post' => $post]);
    }

    public function listed()
    {
        $list = Post::all();
        return view('pages.list', ['posts_list' => $list]);
    }

    public function showPost()
    {
        return view('pages.add-post');
    }

    public function post()
    {
        $data = Request::fetch('name:ne', 'announce:ne', 'content:ne');
        if (!User::checkAuth()) back([
            'flash' => [
                'danger::Вы не авторизованы!'
            ],
            'form_data' => $data
        ]);
        if (!Validator::ok()) {
            back([
                'flash' => Validator::$errors,
                'form_data' => $data
            ]);
        }
        $post = new Post();
        $post->fromArray($data);
        $post->user_id = User::current()->id;
        $post->save();
        go($post->url());
    }

    public function postComment($post_id)
    {
        $data = Request::fetch('text:ne', 'name:any');
        if (!Validator::ok()) {
            back([
                'flash' => Validator::$errors,
                'form_data' => $data
            ]);
        }

        $comment = new Comment();
        $comment->fromArray($data);
        if (User::checkAuth()) $comment->user_id = User::current()->id;
        $comment->post_id = $post_id;
        $comment->save();
        back([
            'flash' => [
                'success::Комментарий успешно отправлен!'
            ]
        ]);
    }
}