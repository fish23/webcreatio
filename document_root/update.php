<?php
/**
 * Marking web for automatic update
 *
 * @author Tomas Goldir <tomas.goldir@gmail.com>
 * @copyright Copyleft (@) http://www.gnu.org/copyleft
 * @package webcreatio
 */

/**
 * Configuration
 */
// file to mark update (use absolute path, eg.: dirname(__FILE__).'/relative/path/from/this/file')
$update_file = dirname(__FILE__) . '/../app/temp/_update';



/**
 * Mark for update
 */
header('Content-Type: text/plain');

if (file_exists($update_file)) {
	$before = time() - filemtime($update_file);
	die('Update was sheduled yet before '.floor($before/60).' minutes and '.($before%60).' seconds.');
}

if (@touch($update_file))
	die('This WebCreatio instance is now marked for update.');
else
	die('This WebCreatio instance can\'t be updated! Please contact administrator.');
