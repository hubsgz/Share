<?php

class ShareComment
{
	/**
	  * 解析注释标记参数
	  *
	  * @params str $comment comment
	  *
	  * @return array
	  */
	static function getTags($comment)
	{
		$re = preg_match_all('/^\s+\*\s+@(\w+)\s+(.+?)\n/ims', $comment, $matchs);
		$arr = array();
		if ($re) {
			foreach ($matchs[1] as $k=>$tagname) {
				$arr[$tagname][] = $matchs[2][$k];
			}
		}
		return $arr;
	}
	
	/**
	  * 获取作者标记参数
	  *
	  * @params str $comment comment
	  *
	  * @return array
	  */
	static function getAuthor($comment)
	{
		$arr = self::getTags($comment);
		return isset($arr['author']) ? $arr['author'][0] : '';
	}
}