<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
| 	www.your-site.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://www.codeigniter.com/user_guide/general/routing.html
*/

// Catalogue
$route['simpleshop/category/(:num)(.*)'] = 'simpleshop/index/$1';
$route['simpleshop/product/(:num)(.*)'] = 'simpleshop/product/$1';

// Admin Routes
$route['simpleshop/admin/catalogue(.*)'] = 'admin$1';
$route['simpleshop/admin/products(.*)'] = 'admin_products$1';
$route['simpleshop/admin/categories(.*)'] = 'admin_categories$1';
$route['simpleshop/admin/settings(.*)'] = 'admin_settings$1';
