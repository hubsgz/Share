<?php
/**
 *	地区站项目 共享代码公共父类
 *
 *  @author zsg <xxx@gmail.com>
 */
/**
 *	地区站项目 共享代码公共父类
 *
 *  @author zsg <xxx@gmail.com>
 */
class AreastationShare extends CommonShare
{
	/**
	 * 地区律师列表
	 *  
	 * @params str $page     当前页
	 * @params str $pageSize 每页数
	 * @params str $params   其它参数
	 * 
	 * @return array
	 * @author zsg
	 */
	public function areaLawyerlist($page, $pageSize, $params)
	{
		return array($page, $pageSize, $params);
	}

	/**
	 * 地区站测试方法
	 *  
	 * @params str $page     当前页
	 * @params str $pageSize 每页数
	 * @params str $params   其它参数
	 * 
	 * @return array
	 * @author zsg
	 */
	public function areatestMethod($page, $pageSize, $params)
	{
		return array($page, $pageSize, $params);
	}
}