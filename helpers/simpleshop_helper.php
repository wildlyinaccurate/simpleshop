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
function simpleshop_category_breadcrumbs($root_category, $include_root = false, $separator = '<span class="separator">&raquo;</span>')
{
    if ( ! $root_category) {
        return '';
    }

    $breadcrumbs = '';
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
