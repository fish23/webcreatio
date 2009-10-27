<?php

class Translator implements ITranslator
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
	public function translate($message, $count = NULL)
	{
		Environment::setVariable('lang', $locale);
		if (!preg_match($this->countRegexp, $message)) {                
			$message = gettext($message);
		} else {
			$split = preg_split($this->countRegexp, $message);
			$n = preg_match($this->paramsRegexp, $split[0]);
		  
			if (!isset($pars[$n+1]))
				throw new InvalidArgumentException('Insufficient number of arguments in translate function');
		  
			$message = ngettext($message, $message, $pars[$n+1]);
		}
	    
		if (count($pars)>1) {
			array_shift($pars);
			return vsprintf($message, $pars); // parametrizovane preklady zatim nefunguji
		}

		return $message;   
	}
}
