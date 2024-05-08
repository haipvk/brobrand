<?php
$hook['tech5s_vindex_init'][] = array( 
  'class'    => 'PageAll',
  'function' => 'initVindex',
  'filename' => 'PageAll.php',
  'filepath' => 'plugins/page_all',
);
$hook['tech5s_baseview_before_show'][] = array( 
  'class'    => 'PageAll',
  'function' => '_beforeShow',
  'filename' => 'PageAll.php',
  'filepath' => 'plugins/page_all',
);
$hook['tech5s_before_get_data'][] = array( 
  'class'    => 'PageAll',
  'function' => '_beforeGetData',
  'filename' => 'PageAll.php',
  'filepath' => 'plugins/page_all',
);
