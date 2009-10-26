<?php

class DefaultPresenter extends BasePresenter
{
	public function renderDefault()
	{
		$this->template->title = 'WebCreatio';
	}	

	public function renderLoremIpsum()
	{
		$this->template->title = 'Lorem ipsum';
	}
}
