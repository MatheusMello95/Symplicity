<?php

class View
{
    public static function load($page, $data = null)
    {
        include $page;
    }
} 