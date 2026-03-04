<?php

namespace Core;

class View
{
    public static function render($view, $params = [])
    {
        extract($params);
        require BASE_PATH . '/View/' . $view;
    }
}
