<?php

class DbTranslator implements ITranslator
{


	/**
	 * detect lang
	 */
	public function __construct()
	{
		// autodetection of language by browser settings
		if ($locale === NULL) {
			$langs = explode(',', Environment::getConfig('translator')->langs);
			switch (Environment::getHttpRequest()->detectLanguage($langs)) {
				case 'cs': $locale = 'cs_CZ'; break;
				default:
				case 'en': $locale = 'en_US'; break;
			}
      $locale = 'cs';
			Environment::setVariable('lang', $locale);
		}
		putenv("LANG=$locale");
		setlocale(LC_ALL, $locale);
	}



	/**
	 * Translates the given string.
	 * @param  string   message
	 * @param  int      count
	 * @return string
	 */
	public function translate($message, $count = 0)
	{
    $table = ':wc:messages_'.Environment::getVariable('lang');
		$result = dibi::fetch('SELECT * FROM :wc:messages LEFT JOIN '.$table.' ON :wc:messages.id = '.$table.'.id AND '.$table.'.num <= %i', $count);

		return $result;   
	}
}
