<?php
/**
 *	����վ��Ŀ ��ҳ��������
 *
 *  @author zsg <xxx@gmail.com>
 */
/**
 *	����վ��Ŀ ��ҳ��������
 *
 *  @author zsg <xxx@gmail.com>
 */
class AreastationIndexShare extends AreastationShare
{
	/**
	 * �������°����б�
	 *  
	 * @params str $getnum ��ȡ����
	 * 
	 * @return array
	 * @author zsg
	 */
	public function areaNewAnliList($getnum)
	{
		return array($getnum);
	}
	
	/**
	 * ���������ļ��б�
	 *  
	 * @params str $getnum ��ȡ����
	 * 
	 * @return array
	 * @author zsg
	 */
	public function areaNewWenjiList($getnum)
	{
		return array($getnum);
	}
}