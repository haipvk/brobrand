<?php
namespace SyncDataCms\Models;
use TechSupport\Models\BaseModel;

class HaravanCollect extends BaseModel{
    protected $table = 'haravan_collects';

    public static function createFromJson($item,$accountId,$idx){
        $object = new static;
        if($idx>0){
            $object->idx = $idx;
        }
        if($accountId>0){
            $object->account_id = $accountId;
        }
        $object->haravan_id = $item["id"] ?? 0;
        $object->product_id = $item["product_id"] ?? 0;
        $object->collection_id = $item["collection_id"] ?? 0;
        $object->position = $item["position"] ?? 0;
        $object->sort_value = $item["sort_value"] ?? '';
        $object->created_at = $item['created_at'] ?? '';
        $object->created_at = $item['created_at'] ?? '';
        $lastId = $object->save();
        return $object;
    }

}