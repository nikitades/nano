<?php

use app\system\Path;

/**
 * Be careful to put the non-variable paths above the variable-containing ones.
 * Otherwise the variable-containing paths will suppress the iteration and cause the paths misuse.
 */

Path::track('/login', 'AuthController@showLogin');
Path::track('/login', 'AuthController@login', 'post');
Path::track('/register', 'AuthController@showRegister');
Path::track('/register', 'AuthController@register', 'post');
Path::track('/logout', 'AuthController@logout');

Path::track('/', 'BlogController@listed');
Path::track('/post', 'BlogController@showPost');
Path::track('/post', 'BlogController@post', 'post');
Path::track('/postComment/#id#', 'BlogController@postComment', 'post');
Path::track('/#id#', 'BlogController@show');

/* Examples:

Path::track('/blog/#id#/', 'BlogController@show');
Path::track('/catalog/#category_code#/#id#/', 'CatalogController@show');

*/