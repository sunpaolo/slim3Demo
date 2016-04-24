<?php
namespace Lib;
/*
 * 参考：https://github.com/akrabat/rka-slim-session-middleware/blob/master/RKA/Session.php
 */
class Session
{
    public function get($key, $default = null)
    {
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }
        return $default;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function delete($key)
    {
        if (array_key_exists($key, $_SESSION)) {
            unset($_SESSION[$key]);
        }
    }

    public function clearAll()
    {
        $_SESSION = [];
    }

    public function __set($key, $value)
    {
        $this->set($key, $value);
    }

    public function __get($key)
    {
        return $this->get($key);
    }

    public function __isset($key)
    {
        return array_key_exists($key, $_SESSION);
    }

    public function __unset($key)
    {
        $this->delete($key);
    }

    public static function regenerate()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }

    public static function destroy()
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 86400,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        if (session_status() == PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
}