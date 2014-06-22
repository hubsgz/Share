<?php


class AskBrowse extends AskAsk
{
	
	public function newQuestionList($num)
	{
		$this->cacheTime(10);
		sleep(3);

		return array(111, 222);
	}

	public function newAnswerList($num)
	{
		return array(6666, 222);
	}
}