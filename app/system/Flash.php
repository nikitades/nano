<?php

namespace app\system;

class Flash
{

    public static $message_types = [
        'success', 'info', 'warning', 'danger'
    ];

    public static $info_types = [
        'data'
    ];

    /*
     * Types: success, info, warning, danger
     */

    public static function message($type, $text)
    {
        $_SESSION['flash'] = !empty($_SESSION['flash']) ? $_SESSION['flash'] : [];
        $_SESSION['flash'][$type][] = $text;
    }

    public static function data($content = false)
    {
        $data = $_SESSION['data'] = !empty($_SESSION['data']) ? $_SESSION['data'] : [];
        if ($content !== false) {
            $_SESSION['data'] = array_merge($_SESSION['data'], $content);
        } else {
            unset($_SESSION['data']);
            return $data;
        }
    }

    public static function display()
    {
        $flash = $_SESSION['flash'] = !empty($_SESSION['flash']) ? $_SESSION['flash'] : [];
        unset($_SESSION['flash']);
        foreach ($flash as $type => $content) {
            foreach ($content as $text) {
                nanolink('blocks.notification', ['type' => $type, 'text' => $text]);
            }
        }
    }

}