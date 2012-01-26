<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * SimpleShop Helper
 *
 * Various helper functions specific to the SimpleShop Module
 *
 * @author  Joseph Wynn
 * @since   1.0
 */


/**
 * Recursively print a variable in <pre> tags to aid in debugging.
 * By default, script execution is halted, but $exit can be specified as FALSE to prevent this.
 *
 * @param mixed $var
 * @param bool	$exit
 * @return	void
 */
function debug($var, $exit = TRUE)
{
	echo '<h2>Debugging</h2>';

	if (is_null($var) || is_bool($var))
	{
		// Null and booleans won't show up in print_r
		var_dump($var);
	}
	else
	{
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}

	if ($exit)
	{
		exit;
	}
}