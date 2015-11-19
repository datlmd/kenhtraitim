<?php 
$route['default_controller'] = 'frontend/tintuc';
$route['404_override'] = '';
$route['root'] = 'users/admin_users/login';
$route['tai-khoan'] = 'users';
$route['menus'] = 'menus';
$route['custom_fields'] = 'custom_fields';
$route['module_fields'] = 'module_fields';
$route['modules'] = 'modules';
$route['comments'] = 'comments';
$route['votes'] = 'votes';
$route['languages'] = 'languages';
$route['html_templates'] = 'html_templates';
$route['nhac'] = 'musics';
$route['tin-tuc'] = 'articles';
$route['photos'] = 'photos';
$route['pages'] = 'pages';
$route['surveys'] = 'surveys';
$route['trang-chu'] = 'frontend';
$route['router_configs'] = 'router_configs';
$route['video-clip'] = 'musics';
$route['home-page'] = 'frontend/tintuc';
$route['game_racing'] = 'frontend/game_racing';
$route['model_list/(:num)'] = 'frontend/model_list/$1';
$route['search/(:num)'] = 'frontend/search/$1';
$route['model_detail/(:num)'] = 'frontend/model_detail/$1';
$route['mobile/trang_chu'] = 'frontend/mobile';
$route['mobile/the-le'] = 'frontend/mobile/the_le';
$route['mobile/tin-tuc/(:any)'] = 'frontend/mobile/danh_sach_tin_tuc/$1';
$route['mobile/hinh-anh/(:any)'] = 'frontend/mobile/danh_sach_hinh_anh/$1';
$route['mobile/video/(:any)'] = 'frontend/mobile/danh_sach_video/$1';
$route['mobile/chi_tiet_tin_tuc/(:num)'] = 'frontend/mobile/chi_tiet_tin_tuc/$1';
$route['mobile/chi_tiet_hinh_anh/(:num)'] = 'frontend/mobile/chi_tiet_hinh_anh/$1';
$route['mobile/chi_tiet_video/(:num)'] = 'frontend/mobile/chi_tiet_video/$1';
$route['thoat'] = 'frontend/open_login/logout';

$route['phim-(:any)-(:num).html'] = 'frontend/detail/$2/$1';
$route['(:any).html'] = 'frontend/categories/$1';
$route['(:any).html/(:any)'] = 'frontend/categories/$1/$2';

//admin
$route['admin'] = 'users/admin_users/dashboard';
