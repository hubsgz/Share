<?php
/**
 *	ask��Ŀ -- �����
 *
 *  @author zsg <xxx@gmail.com>
 */
/**
 *	ask��Ŀ -- �����
 *
 *  @author zsg <xxx@gmail.com>
 */
class AskBrowseShare extends AskShare
{
	/**
	 * ��ȡ���������б�
	 *  
	 * @params str $num ��ȡ����
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
	 * ��ȡ���������б�01
	 *  
	 * @params str $num ��ȡ����
	 * 
	 * @return array
	 */
	public function newQuestionList01($num)
	{
		return array(111, 222, 'gse21531gse5g4');
	}

}