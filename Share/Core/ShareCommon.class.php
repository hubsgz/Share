<?php
/**
 *	����������
 */

class ShareCommon
{
	private $__share_cache_time = 0;

	public function cacheTime($val = 0) 
	{
		if ($val>0) {
			$this->__share_cache_time = $val;
		}
		return $this->__share_cache_time;
	}
	
}