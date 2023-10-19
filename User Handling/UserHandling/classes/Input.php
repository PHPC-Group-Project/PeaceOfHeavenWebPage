<?php

/**
 * Summary of Input
 */
class Input {
    /**
     * Summary of exists
     * @param mixed $type
     * @return bool
     */
    public static function exists($type = 'post') {
        switch($type) {
            case 'post':
                return (!empty($_POST)) ? true : false;
            break;
            case 'get':
                return (!empty($_GET)) ? true : false;
            break;
            default:
                return false;
            break;
        }
    }

    /**
     * Summary of get
     * @param mixed $item
     * @return mixed
     */
    public static function get($item) {
        if(isset($_POST[$item])) {
            return $_POST[$item];
        } else if (isset($_GET[$item])) {
            return $_GET[$item];
        }
        return '';
    }
}