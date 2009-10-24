<?php
/**
 * Bootstrap for Nette application
 *
 * @package WebCreatio
 * @author Tomas Goldir <tomas.goldir@gmail.com>
 * @copyright Copyleft (@) http://www.gnu.org/copyleft
 */


/**
 * Step 0: Check presents of Nette Framework and dibi
 */
if (!is_dir(LIBS_DIR . '/Nette')) {
	throw new Exception('Install Nette Framework\'s directory \'Nette\' into this project\'s directory '.realpath(LIBS_DIR).' !');
}
if (!is_dir(LIBS_DIR . '/dibi')) {
	throw new Exception('Install dibi\'s directory \'dibi\' into this project\'s directory '.realpath(LIBS_DIR).' !');
}


/**
 * Step 1: Load Nette Framework 
 * this allows Nette to load classes automatically so that
 * you don't have to litter your code with 'require' statements
 */
require_once LIBS_DIR . '/Nette/loader.php';


/**
 * Step 2: Configure environment
 */

if (@file_put_contents(APP_DIR . '/log/_check') === FALSE) {
	throw new Exception('Make a directory \'' . APP_DIR . '/log/\' writable!');
}
// Enable Nette\Debug for better exception and error visualisation
Debug::enable(NULL, APP_DIR . '/log/php_error.log');

// Load configuration from config.ini file
Environment::loadConfig();

// Connect to database using dibi abstraction
$dbconfig = Environment::getConfig('database');
dibi::connect($dbconfig);
dibi::addSubst('wc', $dbconfig->prefix);
unset($dbconfig);

// Check if directory /app/temp is writable
if (@file_put_contents(Environment::expand('%tempDir%/_check'), '') === FALSE) {
        throw new Exception('Make a directory \'' . Environment::getVariable('tempDir') . '\' writable!');
} 
if (@file_put_contents(APP_DIR . '/sessions/_check') === FALSE) {
	throw new Exception('Make a directory \'' . APP_DIR . '/sessions/\' writable!');
}

// Setup sessions
$session = Environment::getSession();
$session->setExpiration('+ 14 days');
$session->setSavePath(APP_DIR . '/sessions/');
$session->setCookieParams('/');


/**
 * Step 3: Configure application
 */
// Get front controller
$application = Environment::getApplication();
// Setup front controller
$application->errorPresenter = 'Error';
$application->catchExceptions = TRUE;


/**
 * Step 4: Setup application router
 */
/* $router = $application->getRouter();

$router[] = new Route('index.php', array(
        'presenter' => 'Homepage',
        'action' => 'default',
), Route::ONE_WAY);

$router[] = new Route('<presenter>/<action>/<id>', array(
        'presenter' => 'Homepage',
        'action' => 'default',
        'id' => NULL,
)); */


/**
 * Step 5: Run the application!
 */
$application->run();
