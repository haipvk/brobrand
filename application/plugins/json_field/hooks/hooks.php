<?php 
$hook['tech5s_edit1_insert_bottom'][] = array( 
  'class'    => 'JsonField',
  'function' => 'injectAdminEditJs',
  'filename' => 'JsonField.php',
  'filepath' => 'plugins/json_field',
);
$hook['tech5s_view2_insert_bottom'][] = array( 
  'class'    => 'JsonField',
  'function' => 'injectAdminEditJs',
  'filename' => 'JsonField.php',
  'filepath' => 'plugins/json_field',
);
