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
$route['404_override'] = 'home/error_404';
$route['translate_uri_dashes'] = FALSE;
$route['index'] = 'home/index';
$route['error-404'] = 'home/error_404';



$route['posts'] = 'home/posts';
$route['post/(:any)'] = 'home/post/$1';
$route['video/(:any)'] = 'home/video/$1';
$route['videos'] = 'home/videos';
$route['video/(:any)/(:num)'] = 'home/video/$1/$2';
$route['profile/(:any)'] = 'home/profile/$1';
$route['gallery'] = 'home/gallery';
$route['contact'] = 'home/contact';
$route['category/(:any)'] = 'home/category/$1';
$route['tag/(:any)'] = 'home/tag/$1';
$route['reading-list'] = 'home/reading_list';
$route['reading-history'] = 'home/reading_history';
$route['leaderboard'] = 'home/leaderboard';
$route['search'] = 'home/search';
$route['download-audio']['post'] = 'home/download_audio';
$route['termsofuse'] = 'home/term_of_use';
$route['termofuse'] = 'home/term_of_use';
$route['aboutus'] = 'home/aboutus';
$route['en/aboutus'] = 'home/aboutus';
$route['en/termsofuse'] = 'home/term_of_use';
$route['privacy_policy'] = 'home/privacy_policy';
$route['about-ajar'] = 'home/aboutus';
$route['kita-bisa'] = 'home/kita_bisa';
$route['post/$1'] = '$1';


//rss routes
$route['rss-feeds'] = 'home/rss_feeds';
$route['rss/posts'] = 'rss/rss_all_posts';
$route['rss/popular-posts'] = 'rss/rss_popular_posts';
$route['rss/latest-posts'] = 'rss/rss_latest_posts';
$route['rss/category/(:any)'] = 'rss/rss_by_category/$1';
$route['rss/videos'] = 'rss/rss_videos';

//auth routes
$route['login'] = 'auth/login';
$route['register'] = 'auth/register';
$route['profile-update'] = 'auth/update_profile';
$route['change-password'] = 'auth/change_password';
$route['reset-password'] = 'auth/reset_password';

$route['logout'] = 'auth/logout';
$route['admin'] = 'admin/index';
$route['admin/login'] = 'auth/admin_login';


$route['resultquiz'] = 'home/result_quiz';

//Api Regsiter
$route['api/register'] = 'ApiController/registrasi';
//Api Login Parameter Body : email & password | method POST 
$route['api/login'] = 'ApiController/postLogin';
//Api Profile Access Header Parameter : token & userid | method GET
$route['api/profile'] = 'ApiController/getProfile';
//API Profile Update Access Header Parameter : token & userid | Method POST
$route['api/profile/update'] = 'ApiController/postUpdateProfile';
//API Profile Update Access Header Parameter : token & userid | Body Parameter post_id | Method POST
$route['api/subscribers'] = 'ApiController/subscribersList';
//API Profile Update Access Header Parameter : token & userid | Type Parameter URI (3) editorPick / latest / popular , URI (4) ID POST | Method GET
$route['api/posts/(:any)/(:num)'] = 'ApiController/feed';
//API Profile Update Access Header Parameter : token & userid | Type Parameter URI (3) ID POST | Method GET
$route['api/posts/(:num)'] = 'ApiController/showArticle';
//API Profile Update Access Header Parameter : token & userid | Type Parameter URI (3) ID POST | Method GET
$route['api/comments/(:num)'] = 'ApiController/articleComments';
//API Destroy Token | Access Header Parameter : token & userid | No BODY INPUT
$route['api/logout'] = 'ApiController/logout';

//Api Login Parameter Body : email & password | method POST 
$route['apiapp/login'] = 'ApiApps/postLogin';
//Api Regsiter
$route['apiapp/register'] = 'ApiApps/register';
//Cek OTP
$route['apiapp/checkOTP'] = 'ApiApps/checkOTP';
//Api Profile Access Header Parameter : token & userid | method GET
$route['apiapp/profile'] = 'ApiApps/getProfile';
//API Profile Update Access Header Parameter : token & userid | Method POST
$route['apiapp/profile/update'] = 'ApiApps/postUpdateProfile';
//API Profile Update Access Header Parameter : token & userid | Body Parameter post_id | Method POST
$route['apiapp/subscribers'] = 'ApiApps/subscribersList';
//API Profile Update Access Header Parameter : token & userid | Type Parameter URI (3) editorPick / latest / popular , URI (4) ID POST | Method GET
$route['apiapp/posts/(:any)/(:num)'] = 'ApiApps/feed';
$route['apiapp/postsPage/(:any)/(:num)/:num'] = 'ApiApps/feedPage';
//API Search
$route['apiapp/search/(:num)/:num/(:any)'] = 'ApiApps/search';
//API Profile Update Access Header Parameter : token & userid | Type Parameter URI (3) ID POST | Method GET
$route['apiapp/posts/(:num)'] = 'ApiApps/showArticle';
//API Profile Update Access Header Parameter : token & userid | Type Parameter URI (3) ID POST | Method GET
$route['apiapp/comments/(:num)'] = 'ApiApps/articleComments';
//API favorite
$route['apiapp/favorite/(:num)/(:num)'] = 'ApiApps/favorit';
$route['apiapp/preference/(:num)/(:num)'] = 'ApiApps/preference';
$route['apiapp/favorite/(:num)/(:num)/(:num)'] = 'ApiApps/listFavorite';
//API Destroy Token | Access Header Parameter : token & userid | No BODY INPUT
$route['apiapp/logout'] = 'ApiApps/logout';
$route['apiapp/master/(:any)'] = 'ApiApps/masterData';
$route['apiapp/activityReport/(:any)'] = 'ApiApps/activityReport';



$route['switch-lang/id'] = 'home/change_to_id';

//plugin AJAR Form routes
$route['trainer'] = 'home/kita_bisa';

require APPPATH . 'config/routes_lang.php';


$route['(:any)'] = 'home/post/$1';
