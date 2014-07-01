<?php

class ShareComment
{
	static $tags = array();

	/**
	  * ����ע�ͱ�ǲ���
	  *
	  * @params str $comment comment
	  *
	  * @return array
	  */
	static function parseTags($comment)
	{
		$idx = md5($comment);
		if (!isset(self::$tags[$idx])) {
			$re = preg_match_all('/^\s+\*\s+@(\w+)\s+(.+?)\n/ims', $comment, $matchs);
			$arr = array();
			if ($re) {
				foreach ($matchs[1] as $k=>$tagname) {
					$arr[$tagname][] = $matchs[2][$k];
				}
			}
			self::$tags[$idx] = $arr;
		}
		return self::$tags[$idx];
	}
	
	/**
	  * ��ȡ���߱�ǲ���
	  *
	  * @params str $comment comment
	  *
	  * @return string
	  */
	static function getAuthor($comment)
	{
		$arr = self::parseTags($comment);
		return isset($arr['author']) ? $arr['author'][0] : '';
	}

	/**
	  * ��ȡcacheTime����
	  *
	  * @params str $comment comment
	  *
	  * @return int
	  */
	static function getCacheTime($comment)
	{
		$arr = self::parseTags($comment);
		return isset($arr['cachetime']) ? intval($arr['cachetime'][0]) : 0;
	}
}