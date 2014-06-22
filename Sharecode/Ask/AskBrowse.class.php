<?php


class AskBrowse extends AskAsk
{
	
	public function newQuestionList($num)
	{
		sleep(1);
		return array(111, 222);
	}

	public function newAnswerList($num)
	{
		return array(6666, 222);
	}
}