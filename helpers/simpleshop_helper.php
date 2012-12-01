<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * SimpleShop Helper
 *
 * Various helper functions specific to the SimpleShop Module
 *
 * @author  Joseph Wynn
 * @since   1.0
 */

function simpleshop_product_url($product)
{
    return site_url("simpleshop/product/{$product->getId()}/{$product->getSlug()}");
}

/**
 * Build a breadcrumb string a root NodeWrapper object.
 *
 * Entities are expected to implement __toString().
 *
 * @param	NodeWrapper	$root_category
 * @param	bool		$include_root
 * @param	string		$separator
 * @return	string
 * @author  Joseph Wynn <joseph@wildlyinaccurate.com>
 */
function simpleshop_category_breadcrumbs($root_category, $include_root = false)
{
    if ( ! $root_category) {
        return '';
    }

    $breadcrumbs = '';
    $separator = config_item('simpleshop_breadcrumb_separator');
    $categories = $root_category->getAncestors($include_root);

    foreach ($categories as $node) {
        if ($node instanceof \DoctrineExtensions\NestedSet\NodeWrapper) {
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

    if (is_null($var) || is_bool($var)) {
        // Null and booleans won't show up in print_r
        var_dump($var);
    } else {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }

    if ($exit) {
        exit;
    }
}
