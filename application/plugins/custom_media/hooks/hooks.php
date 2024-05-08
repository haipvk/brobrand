<?php 

$hook['tech5s_media_before_body'][] = array( 

  'class'    => 'CustomMedia',

  'function' => 'addHtmlMedia',

  'filename' => 'CustomMedia.php',

  'filepath' => 'plugins/custom_media',

);

$hook['tech5s_media_before_body'][] = array( 

  'class'    => 'CustomMedia',

  'function' => 'addCssMedia',

  'filename' => 'CustomMedia.php',

  'filepath' => 'plugins/custom_media',

);

$hook['tech5s_media_before_body'][] = array( 

  'class'    => 'CustomMedia',

  'function' => 'addJsMedia',

  'filename' => 'CustomMedia.php',

  'filepath' => 'plugins/custom_media',

);

$hook['tech5s_edit1_insert_bottom'][] = array( 

  'class'    => 'CustomMedia',

  'function' => 'addJsEdit',

  'filename' => 'CustomMedia.php',

  'filepath' => 'plugins/custom_media',

);

$hook['tech5s_media_after_upload'][] = array( 

  'class'    => 'CustomMedia',

  'function' => 'changeUpload',

  'filename' => 'CustomMedia.php',

  'filepath' => 'plugins/custom_media',

);

$hook['tech5s_vindex_init'][] = array( 

  'class'    => 'CustomMedia',

  'function' => 'initVindex',

  'filename' => 'CustomMedia.php',

  'filepath' => 'plugins/custom_media',

);
$hook['tech5s_techsystem_init'][] = array( 
  'class'    => 'BaseWebsite',
  'function' => 'initTechsystem',
  'filename' => 'BaseWebsite.php',
  'prevent_progress' => true,
  'filepath' => 'plugins/base_website',
);