<?php
/**
 * BasePresenter is parent presenter of all WebCreatio's Presenters
 *
 * @author Tomas Goldir <tomas.goldir@gmail.com>
 * @copyright Copyleft (@) http://www.gnu.org/copyleft
 * @package webcreatio
 */

abstract class BasePresenter extends Presenter
{
	protected function beforeRender()
	{
		// nette-0.9 registers CurlyBracketsFilter automaticaly
		//$this->template->registerFilter('CurlyBracketsFilter::invoke');	// nette-0.8 requires CurlyBracketFilter explicitly

		/**
		 * @TODO setlocale('cs') or 'en' doesn't work on linux (cs_CZ works). Is it working on windows? Change language by browser settings.
		 */
		Environment::setVariable('lang', 'cs_CZ');

		$translator = new Translator(
			Environment::getVariable('lang'), APP_DIR . '/locale');
		$this->template->setTranslator($translator);

		$this->template->user = Environment::getUser();
	}
}
