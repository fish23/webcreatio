<?php

abstract class BasePresenter extends Presenter
{

	protected function beforeRender()
	{
		// nette-0.9 registruje filtr CurlyBracketsFilter automaticky
		//$this->template->registerFilter('CurlyBracketsFilter::invoke');	// nette-0.8 vyzaduje explicitni zapnuti CurlyBracketFilteru
		/**
		 * @TODO setlocale('cs') or 'en' doesn't work on linux (cs_CZ works). Is it working on windows? Change language by browser settings.
		 */
		Environment::setVariable('lang', 'cs_CZ');

		$translator = new Translator(
			Environment::getVariable('lang'), APP_DIR . '/locale');
		$this->template->setTranslator($translator);
	}
}
