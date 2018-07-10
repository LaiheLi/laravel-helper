<?php

if(!function_exists('isWeChat')){
	/**
	 * 检测是否是微信浏览器
	 *
	 * @return bool
	 */
	function isWeChat()
	{
		return str_contains(app('request')->server('HTTP_USER_AGENT'), ['MicroMessenger']);
	}
}