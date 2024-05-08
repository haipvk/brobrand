<?php

$hook['tech5s_before_baseview'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'init',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['tech5s_extra_function'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'managerMultiLanguage',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['tech5s_extra_function'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'editContent',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['tech5s_extra_function'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'ajaxLanguageFlag',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['tech5s_before_get_data_detail'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'accessGetDataDetail',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['tech5s_vindex_init'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'initVindex',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

// $hook['tech5s_before_input_echor'][] = array( 

//   'class'    => 'MultiLanguage',

//   'function' => 'initEchor',

//   'filename' => 'MultiLanguage.php',

//   'filepath' => 'plugins/multi_language',

// );

$hook['tech5s_after_in_update_before_update_routes'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'doUpdateRoutes',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['tech5s_after_in_update_before_insert_routes'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'doUpdateRoutes',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['tech5s_after_insert_success_before_insert_routes'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'doUpdateRoutes',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['tech5s_before_get_data'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'doGetRoutes',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['tech5s_after_get_related'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'changeGetRelated',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['tech5s_dashboard_bottom'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'injectAdminJs',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['tech5s_baseview_before_catch_404'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'catch404',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['tech5s_get_setting'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'getSetting',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['plugin_alternative_menu_pre_select_data'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'injectPrintMenu',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['vth_url_helper_exact_link'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'injectExactLink',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['tech5s_before_echor'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'injectBeforeEchor',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['plugin_alternative_menu_pre_get_active_menu'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'injectActiveMenu',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['tech5s_my_lang_get_lang'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'getLang',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['tech5s_before_get_num_data_detail'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'accessGetNum',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['tech5s_base_all_item'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'changeBaseAllItem',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['tech5s_baseview_before_pagination_page'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'changePaginationPage',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['plugins_multi_page_link_page'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'customLinkPage',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['plugins_multi_page_link_table'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'customLinkTable',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['tech5s_before_delete'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'deleteAdmin',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['tech5s_before_delete_all'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'deleteAdminAll',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['tech5s_before_function_view'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'changeViewLink',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

$hook['tech5s_admin_pre_recursive_table'][] = array( 

  'class'    => 'MultiLanguage',

  'function' => 'changeRecursiveTable',

  'filename' => 'MultiLanguage.php',

  'filepath' => 'plugins/multi_language',

);

// $hook['tech5s_base_url'][] = array( 

//   'class'    => 'MultiLanguage',

//   'function' => 'changeBaseUrl',

//   'filename' => 'MultiLanguage.php',

//   'filepath' => 'plugins/multi_language',

// );