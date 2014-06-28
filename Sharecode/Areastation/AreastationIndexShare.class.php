<?php
/**
 *	地区站项目 首页共享代码
 *
 *  @author zsg <xxx@gmail.com>
 */
/**
 *	地区站项目 首页共享代码
 *
 *  @author zsg <xxx@gmail.com>
 */
class AreastationIndexShare extends AreastationShare
{
	/**
	 * 地区最新案例列表
	 *  
	 * @params str $getnum 获取条数
	 * 
	 * @return array
	 */
	public function areaNewAnliList($getnum)
	{
		return array($getnum);
	}
	
	/**
	 * 地区最新文集列表
	 *  
	 * @params str $getnum 获取条数
	 * 
	 * @return array
	 */
	public function areaNewWenjiList($getnum)
	{
		return array($getnum);
	}
}