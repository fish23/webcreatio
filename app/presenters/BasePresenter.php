<?php

abstract class BasePresenter extends Presenter
{

	// nette-0.9 registruje filtr CurlyBracketsFilter automaticky
	/*protected function beforeRender()
	{
		//$this->template->registerFilter('CurlyBracketsFilter::invoke');	// nette-0.8 vyzaduje explicitni zapnuti CurlyBracketFilteru
	}*/
}
