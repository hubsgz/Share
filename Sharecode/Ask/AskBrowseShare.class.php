<?php
/**
 *	ask项目 -- 问题库
 *
 *  @author zsg <xxx@gmail.com>
 */
/**
 *	ask项目 -- 问题库
 *
 *  @author zsg <xxx@gmail.com>
 */
class AskBrowseShare extends AskShare
{
	/**
	 * 获取最新问题列表
	 *  
	 * @params str $num 获取条数
	 * 
	 * @return array
	 */
	public function newQuestionList($num)
	{
		$this->cacheTime(10);
		sleep(3);
		return array(111, 222);
	}

	/**
	 * 获取最新问题列表01
	 *  
	 * @params str $num 获取条数
	 * 
	 * @return array
	 */
	public function newQuestionList01($num)
	{
		return array(111, 222, 'gse21531gse5g4');
	}

}