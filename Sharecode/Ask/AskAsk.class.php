<?php
/**
 *	ask项目共享代码公共父类
 *
 *  @author zsg <xxx@gmail.com>
 */
/**
 *	ask项目共享代码公共父类
 *
 *  @author zsg <xxx@gmail.com>
 */
class AskAsk extends ShareCommon
{
	/**
	 * 这是一个测试方法
	 *  
	 * @params str $page     当前页
	 * @params str $pageSize 每页数
	 * @params str $params   其它参数
	 * 
	 * @return array
	 */
	public function testMethod($page, $pageSize, $params)
	{
		return array($page, $pageSize, $params);
	}
}