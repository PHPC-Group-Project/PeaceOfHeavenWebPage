<?php 

class Session {
    
    public static function exists($name) {
        return (isset($_SESSION[$name])) ? true : false;

    }
    public static function put($name, $value) {
        return $_SESSION[$name] = $value;
    }

    public static function get($name) {
        return $_SESSION[$name];
    }

    public static function delete($name) {
        if (self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    /**
     * Flash a message to user that will be gone once it refreshes
     * @param mixed $name
     * @param mixed $string
     * @return void
     */
    public static function flash($name, $string = '') {
        if(Self::exists($name)) {
            $session = Self::get($name);
            self::delete($name);
            return $session;
        } else {
            self::put($name,$string);
        }
        return '';
    }

}