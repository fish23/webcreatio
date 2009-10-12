<?php

class Translator implements ITranslator
{
    public $countRegexp = '#\%([0-9]+\$)*d#';
    public $paramsRegexp = '#\%([0-9]+\$)*[fs]#';
    
    /**
     * Gets the Gettext ready
     *
     * @param string $locale
     * @param string $directory
     * @param string $domain
     */
    public function __construct($locale, $directory, $domain = 'messages')
    {
        putenv("LANG=$locale");
        setlocale(LC_ALL, $locale);
        
        // language pack path: $directory/$locale/LC_$domain/$domain.mo
        // example: application/locale/cs/LC_MESSAGES/messages.mo
        bindtextdomain($domain, $directory);
        textdomain($domain);
        bind_textdomain_codeset($domain, 'UTF-8');
    }
    
    /**
     * Translates the given string.
     * @param  string   message
     * @param  int      count
     * @return string
     */
    public function translate($message, $count = NULL)
    {
        $pars = func_get_args();
        
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
