<?php
namespace System\Session;

class Session
{
	public static function start()
	{
		if ( ! isset($_SESSION)) {
			session_start();
      ini_set('session.use_strict_mode', 1);
		}
    if (empty($_SESSION['session_code']) || time() - $_SESSION['session_time'] > 3600) {
      self::regenerate();
    }
	}

	public static function set($name = null, $value = null)
	{
		$_SESSION[$name] = $value;
	}

	public static function get($name = null)
	{
		if (isset($_SESSION[$name])) {
			return $_SESSION[$name];
		}

		return false;
	}

  public static function regenerate()
  {
    session_destroy();
    session_start();
    //
    if (session_status() != PHP_SESSION_ACTIVE) {
      session_start();
    }
    $sessionId = session_create_id('zig_');
    $_SESSION['session_code'] = $sessionId;
    $_SESSION['session_time'] = time();
    session_commit();
    ini_set('session.use_strict_mode', 0);
    session_id($sessionId);
    session_start();
  }

	public static function hasSession($name = null)
	{
		if (isset($_SESSION[$name])) {
			return true;
		}

		return false;
	}

	public static function logout()
	{
    self::regenerate();
	}

    /**
    * --------------------------------------------------------------------------
    * Methods about flash message
    * --------------------------------------------------------------------------
    */
	public static function flash($name = null, $value = null)
	{
		$key = 'flash_' . $name;
		$_SESSION[$key] = $value;
	}

	public static function hasFlash($name = null)
	{
		$name = 'flash_' . $name;
		if (isset($_SESSION[$name])) {
			return true;
		}

		return false;
	}

	public static function getFlash($name = null)
	{
		$name = 'flash_' . $name;
		return $_SESSION[$name];
	}
}
