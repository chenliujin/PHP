<?php

class SessionRedis
{
	/**
	 * @site http://www.chenliujin.com
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-01-19
	 * @param type $key
	 * @param type $val
	 */
	static public function Write($key, $val)
	{
		$redis = new Redis;
		$redis->connect('127.0.0.1', 6379);
		$redis->setex($key, 1800, $val);
	}
	
	/**
	 * @site http://www.chenliujin.com
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-01-19
	 * @param type $key
	 */
	static public function Read($key)
	{
		$redis = new Redis;
		$redis->connect('127.0.0.1', 6379);
		$val = $redis->get($key);
		
		return $val ? $val : '';
	}
	
	/**
	 * @site http://www.chenliujin.com
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-01-19
	 */
	static public function Open()
	{
		
	}

	/**
	 * @site http://www.chenliujin.com
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-01-19
	 */	
	static public function Close()
	{
		
	}
	
	/**
	 * @site http://www.chenliujin.com
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-01-19
	 */	
	static public function Destroy($key)
	{
		
	}
	
	/**
	 * @site http://www.chenliujin.com
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-01-19
	 */	
	static public function GC($maxlifetime)
	{
		
	}
}

session_set_save_handler("SessionRedis::Open", "SessionRedis::Close", "SessionRedis::Read", "SessionRedis::Write", "SessionRedis::Destroy", "SessionRedis::GC");
session_start();