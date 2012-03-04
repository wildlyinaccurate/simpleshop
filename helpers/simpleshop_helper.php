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
 * Build a breadcrumb string from a collection of Category entities. Will also
 * accept a collection of NodeWrapper objects.
 *
 * Entities are expected to implement __toString().
 *
 * @param	array	$collection
 * @param	string	$separator
 * @param	string	$uri		will be parsed with sprintf()
 * @return	string
 * @author  Joseph Wynn <joe@chromaagency.com>
 */
function category_breadcrumbs($collection, $separator = '<span class="separator">&raquo;</span>')
{
	$breadcrumbs = '';

	foreach ($collection as $node)
	{
		if ($node instanceof \DoctrineExtensions\NestedSet\NodeWrapper)
		{
			$node = $node->getNode();
		}

		// TODO: Provide a way of specifying a different URI, e.g. for front-end
		$node_link = anchor("admin/simpleshop/catalogue?category_id={$node->getId()}", $node);
		$breadcrumbs .= $node_link . $separator;
	}

	return $breadcrumbs;
}

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
