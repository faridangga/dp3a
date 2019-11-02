<?php defined("BASEPATH") OR exit("No direct script access allowed");

$route["en"] = "home/index";
$route["en/posts"] = "home/posts";
$route["en/post/(:any)"] = "home/post/$1";
$route["en/video/(:any)"] = "home/video/$1";
$route["en/videos"] = "home/videos";
$route["en/video/(:any)/(:num)"] = "home/video/$1/$2";
$route["en/profile/(:any)"] = "home/profile/$1";
$route["en/gallery"] = "home/gallery";
$route["en/contact"] = "home/contact";
$route["en/category/(:any)"] = "home/category/$1";
$route["en/tag/(:any)"] = "home/tag/$1";
$route["en/reading-list"] = "home/reading_list";
$route["en/search"] = "home/search";
$route["en/rss-feeds"] = "home/rss_feeds";
$route["en/rss/posts"] = "rss/rss_all_posts";
$route["en/rss/popular-posts"] = "rss/rss_popular_posts";
$route["en/rss/latest-posts"] = "rss/rss_latest_posts";
$route["en/rss/category/(:any)"] = "rss/rss_by_category/$1";
$route["en/rss/videos"] = "rss/rss_videos";
$route["en/login"] = "auth/login";
$route["en/register"] = "auth/register";
$route["en/profile-update"] = "auth/update_profile";
$route["en/change-password"] = "auth/change_password";
$route["en/reset-password"] = "auth/reset_password";
$route["en/(:any)"] = "home/page/$1";

?>