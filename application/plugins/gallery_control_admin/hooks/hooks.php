<?php 
$hook['tech5s_edit1_insert_bottom'][] = array( 
  'class'    => 'GalleryControlAdmin',
  'function' => 'injectAdminEditJs',
  'filename' => 'GalleryControlAdmin.php',
  'filepath' => 'plugins/gallery_control_admin',
);
$hook['tech5s_view2_insert_bottom'][] = array( 
  'class'    => 'GalleryControlAdmin',
  'function' => 'injectAdminEditJs',
  'filename' => 'GalleryControlAdmin.php',
  'filepath' => 'plugins/gallery_control_admin',
);
