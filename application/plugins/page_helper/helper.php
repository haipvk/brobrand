<?php

function getJsonBlock($key, $table)
{

  $CI = &get_instance();

  $value = $CI->Dindex->getDataDetail(array(

    'table' => $table,

    'where' => [['key' => 'act', 'compare' => '=', 'value' => '1'], ['key' => 'keyword', 'compare' => '=', 'value' => $key]]

  ));

  $lang = pGetLanguage();
  $current = $lang == 'vi' ? 'vi' : 'en';
  return extraJson($value[0][$current . '_value']);
}

function extraJson($json)
{

  json_decode($json);

  if (json_last_error() != JSON_ERROR_NONE) return array();

  return json_decode($json, true);
}

function getBlock($key, $table)
{

  $CI = &get_instance();

  $tmp = $CI->Dindex->getDataDetail(array(
    'table' => $table,
    'where' => [['key' => 'act', 'compare' => '=', 'value' => '1'], ['key' => 'keyword', 'compare' => '=', 'value' => $key]]
  ));
  $lang = pGetLanguage();
  $current = $lang == 'vi' ? 'vi' : 'en';
  if (isset($tmp[0]['keyword'])) {
    $keyword[$tmp[0]['keyword']] = $tmp[0][$current . '_value'];
    return $keyword;
  }
  return [];
}
function getNextPost($table, $dataitem)
{
  $CI = &get_instance();
  $lang = pgetLanguage();
  $id = (int)$dataitem['id'];
  $ord = (int)$dataitem['ord'];
  if ($ord == 0) return [];
  $sql = sprintf("SELECT * FROM %s WHERE act = 1 and ord = (SELECT max(ord) as now_ord FROM %s WHERE act = 1 and ord < %s) and plang = '%s' limit 1", $table, $table, $ord, $lang);
  $data = $CI->db->query($sql)->result_array();
  return $data;
}


function _countReconds($parent, $table)
{

  $CI = &get_instance();

  $tmp = $CI->Dindex->getDataDetail(array(

    'table' => $table,

    'where' => [['key' => 'act', 'compare' => '=', 'value' => '1'], ['key' => 'FIND_IN_SET(' . $parent . ',parent)', 'compare' => '>', 'value' => 0]]

  ));

  return count($tmp);
}

function _calClass($i, $j)
{
  if ($i == 1 && $j == 5 || $i == 3 && $j == 5) {
    return 'column--2 bigs';
  } else if ($i == 2 && $j == 4) {
    return 'bigs column--2';
  } else {
    return 'column--1';
  }
}
function getUrlInSegment($segment)
{
  $CI = &get_instance();
  return $CI->uri->segment($segment, '');
}
function getTplPageURL($fileName)
{

  $CI = &get_instance();

  $pages = $CI->Dindex->getDataDetail(array(

    'table' => 'pages',

    'where' => [

      ['key' => 'act', 'compare' => '=', 'value' => 1],

      ['key' => 'type', 'compare' => '=', 'value' => $fileName]

    ]

  ));

  if (isset($pages[0])) {

    $url = VthSupport\Classes\UrlHelper::exactLink($pages[0]['slug']);
  }

  return $url;
}
