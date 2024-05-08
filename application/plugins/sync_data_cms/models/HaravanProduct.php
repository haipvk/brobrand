<?php
namespace SyncDataCms\Models;
use TechSupport\Models\BaseModel;

class HaravanProduct extends BaseModel{
    protected $table = 'haravan_products';

    public static function createFromJson($item,$accountId,$idx){
        $object = new static;
        if($idx>0){
            $object->idx = $idx;
        }
        if($accountId>0){
            $object->account_id = $accountId;
        }
        $object->haravan_id = $item["id"] ?? '';
        $object->title = $item['title'] ?? '';
        $object->handle = $item['handle'] ?? '';
        $object->vendor = $item["vendor"] ?? '';
        $object->body_html = $item["body_html"] ?? '';
        $object->body_plain = $item["body_plain"] ?? '';
        $object->images = json_encode(array_key_exists("images", $item)?$item["variants"]:[]);
        $object->image = json_encode(array_key_exists("image", $item)?$item["variants"]:[]);
        $object->product_type = $item["product_type"] ?? '';
        $object->published_scope = $item["published_scope"] ?? '';
        $object->tags = $item["tags"] ?? '';
        $object->template_suffix = $item["template_suffix"] ?? '';
        $object->variants = json_encode(array_key_exists("variants", $item)?$item["variants"]:[]);
        $object->options = json_encode(array_key_exists("images", $item)?$item["options"]:[]);
        $object->only_hide_from_list = $item["only_hide_from_list"] ?? '';
        $object->not_allow_promotion = $item["not_allow_promotion"] ?? '';
        $object->created_at = isset($item["created_at"])?strtotime($item["created_at"]):time();
        $object->updated_at = isset($item["updated_at"])?strtotime($item["updated_at"]):time();
        $object->published_at = isset($item["published_at"])?strtotime($item["published_at"]):time();
        $lastId = $object->save();
        return $object;
    }

}