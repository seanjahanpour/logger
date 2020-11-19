<?php
namespace Jahan\Logger;

Use Jahan\Interfaces\LoggerInterface;

abstract class AbstractLogger implements LoggerInterface
{
	const EMERGENCY = 7;	//System is unusable.
	const ALERT     = 6;	//Action must be taken immediately. e.g. website is down
	const CRITICAL  = 5;	//Critical conditions.  e.g. Component is down
	const ERROR     = 4;	//Runtime errors that do not require immediate action but should typically be logged and monitored.
	const WARNING   = 3;	//Exceptional occurrences that are not errors.
	const NOTICE    = 2;	//Normal but significant events.
	const INFO      = 1;	//Interesting events.
	const DEBUG     = 0;	//Detailed debug information.

	const LEVEL	= ['debug','info','notice','warning','error','critical','alert','emergency'];

	/**
	 * System is unusable.
	 *
	 * @param string $message
	 * @param array  $context
	 *
	 * @return void
	 */
	public function emergency(string $message, array $context = [])
	{
		$this->log(self::EMERGENCY, $message, $context);
	}

	/**
	 * Action must be taken immediately.
	 *
	 * Example: Entire website down, database unavailable, etc. This should
	 * trigger the SMS alerts and wake you up.
	 *
	 * @param string $message
	 * @param array  $context
	 *
	 * @return void
	 */
	public function alert(string $message, array $context = [])
	{
		$this->log(self::ALERT, $message, $context);
	}

	/**
	 * Critical conditions.
	 *
	 * Example: Application component unavailable, unexpected exception.
	 *
	 * @param string $message
	 * @param array  $context
	 *
	 * @return void
	 */
	public function critical(string $message, array $context = [])
	{
		$this->log(self::CRITICAL, $message, $context);
	}

	/**
	 * Runtime errors that do not require immediate action but should typically
	 * be logged and monitored.
	 *
	 * @param string $message
	 * @param array  $context
	 *
	 * @return void
	 */
	public function error(string $message, array $context = [])
	{
		$this->log(self::ERROR, $message, $context);
	}

	/**
	 * Exceptional occurrences that are not errors.
	 *
	 * Example: Use of deprecated APIs, poor use of an API, undesirable things
	 * that are not necessarily wrong.
	 *
	 * @param string $message
	 * @param array  $context
	 *
	 * @return void
	 */
	public function warning(string $message, array $context = [])
	{
		$this->log(self::WARNING, $message, $context);
	}

	/**
	 * Normal but significant events.
	 *
	 * @param string $message
	 * @param array  $context
	 *
	 * @return void
	 */
	public function notice(string $message, array $context = [])
	{
		$this->log(self::NOTICE, $message, $context);
	}

	/**
	 * Interesting events.
	 *
	 * Example: User logs in, SQL logs.
	 *
	 * @param string $message
	 * @param array  $context
	 *
	 * @return void
	 */
	public function info(string $message, array $context = [])
	{
		$this->log(self::INFO, $message, $context);
	}

	/**
	 * Detailed debug information.
	 *
	 * @param string $message
	 * @param array  $context
	 *
	 * @return void
	 */
	public function debug(string $message, array $context = [])
	{
		$this->log(self::DEBUG, $message, $context);
	}


	public function log(int $level,string $message, array $context = [])
	{

	}

	protected function interpolate(string $message, array $context = [])
	{
		// build a replacement array with braces around the context keys
		$replace = [];
		foreach ($context as $key => $val) {
			// check that the value can be cast to string
			if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
			$replace['{' . $key . '}'] = $val;
			}
		}

		// interpolate replacement values into the message and return
		return strtr($message, $replace);
	}
}