<?php

/*
 |-----------------------------------------------------------------
 | Routes
 |-----------------------------------------------------------------
 |
 | Normal routes are designed to follow the format shown below.
 |
 | http://example.com/[controller-class]/[controller-method]/[method-arguments]
 |
 | You can how ever use custom routes by defining them here. If you want to use
 | something like what is shown below instead of the default format.
 |
 | @example example.com/product/1/
 |
 | $route['product/(:num)'] = 'product/category/$1';
 |
 | Note! The routes are read from top to bottom and the searching ends
 | once the first match is found within the route
 |
 | Use the following wildcards for your patterns
 | (:any) = matches any thing such as letters, numbers, special characters etc.
 | (:let) = matches only letters
 | (:num) = matches only numbers
 |
 | Warning: Do not define other routes before using (:any) as a pattern
 | since it will match all the other routes and cause undesireable results.
 | The right way is to put the (:any) route at the end of your route definitions.
 |
 | ...other routes
 | $route['(:any)'] = 'contact/phone/$1';
 |
 | Examples of using custom routes is shown below
 |
 | $route['services/(:any)'] = 'services/category';
 | $route['product/(:num)/edit/(:num)'] = 'product/$1/edit/$2';
 | $route['product/(:let)'] = 'product/$1';
 | $route['product/(:num)'] = 'product/$1';
 | $route['contact/phone'] = 'contact/form';
 | $route['gallery/videos'] = 'media/videos';
 | $route['about'] = 'about/mission';
 | $route['(:num)'] = 'home/index/$1';
 |
 | Reserved Routes
 |
 | Warning: Do not rename the following route keys.
 | Only their values should be changed
 |
 | $route['default-controller'] = 'home';
 |
 | The above route is the default home controller which should be changed
 | if you ever rename the default controller filename.
 |
 | $route['page-not-found'] = 'errors/page-missing';
 |
 | The above route is the default 404 error controller which can
 | be changed to your own custom controller to handle errors.
 | Refer to the default errors controller class for details.
 |
 */

// Default routes
$route['default-controller'] = 'welcome';
$route['page-not-found'] = 'errors/page-not-found';

// Custom routes
$route['contact'] = 'contact/form';
$route['(:any)'] = 'welcome/index/$1';
