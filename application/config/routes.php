<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
// Admin Panel - separate sign-in (controllers/Adminlogin.php)
$route['adminpanel/login'] = 'adminlogin/index';
$route['adminpanel/login/captcha'] = 'adminlogin/captcha';
$route['adminpanel/login/captcha_refresh'] = 'adminlogin/captcha_refresh';
$route['adminpanel/logout'] = 'adminlogin/logout';

|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = 'home';
//$route['admin'] = "admin/login";
$route['404_override'] = 'home/not_found';
$route['translate_uri_dashes'] = FALSE;
$route['seo/sitemap\.xml'] = "seo/xml";
$route['sitemap\.xml'] = "seo/xml";

//======================Added by Rahul dey 24-01-2019==================================

$route['admin/page/view'] = 'Page/viewPage';
$route['admin/page/add'] = 'Page/addPage';
$route['admin/page/edit/(:any)'] = 'Page/editPage/$1';
$route['admin/page/update/(:any)'] = 'Page/update/$1';

// ---------------------------------------------------------------------------
// Security (Nov 2026): internal helper methods are public in several
// controllers, so a URL could call them directly - e.g. /home/sendMail/... would
// send an e-mail from ICCR's mail relay with attacker text. These URLs now go
// to the normal "page not found" page. The methods still work when called from
// inside the code. Case-insensitive because PHP method names are.
// ---------------------------------------------------------------------------
$route['(?i)(?:[a-z0-9_]+/){1,2}(?:sendmail|createdir|createsfsdir|createcaptcha|strip_quotes|random_num|isvalidcaptch|logindemo1?|__destruct|__construct)(?:/.*)?'] = 'home/not_found';
