<?php
/**
 *	����վ��Ŀ ������빫������
 *
 *  @author zsg <xxx@gmail.com>
 */
/**
 *	����վ��Ŀ ������빫������
 *
 *  @author zsg <xxx@gmail.com>
 */
class AreastationAreastation extends ShareCommon
{
	/**
	 * ������ʦ�б�
	 *  
	 * @params str $page     ��ǰҳ
	 * @params str $pageSize ÿҳ��
	 * @params str $params   ��������
	 * 
	 * @return array
	 */
	public function areaLawyerlist($page, $pageSize, $params)
	{
		return array($page, $pageSize, $params);
	}

	/**
	 * ����վ���Է���
	 *  
	 * @params str $page     ��ǰҳ
	 * @params str $pageSize ÿҳ��
	 * @params str $params   ��������
	 * 
	 * @return array
	 */
	public function testMethod($page, $pageSize, $params)
	{
		return array($page, $pageSize, $params);
	}
}