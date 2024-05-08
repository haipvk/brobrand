<?php
namespace SyncDataCms\Models;
use TechSupport\Models\BaseModel;

class HaravanCustomCollection extends BaseModel{
    protected $table = 'haravan_custom_collections';
    public static function createFromJson($item,$accountId,$idx){
        $object = new static;
        if($idx>0){
            $object->idx = $idx;
        }
        if($accountId>0){
            $object->account_id = $accountId;
        }
        $object->haravan_id = $item["id"] ?? 0;
        $object->title = $item["title"] ?? '';
        $object->handle = $item["handle"] ?? '';
        $object->body_html = $item["body_html"] ?? '';
        $object->published_at = $item["published_at"] ?? '';
        $object->published_scope = $item["published_scope"] ?? '';
        $object->sort_order = $item["sort_order"] ?? '';
        $object->template_suffix = $item["template_suffix"] ?? '';
        $object->updated_at = $item["updated_at"] ?? 0;
        $lastId = $object->save();
        return $object;
    }

}