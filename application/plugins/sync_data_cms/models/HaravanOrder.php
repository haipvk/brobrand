<?php
namespace SyncDataCms\Models;
use TechSupport\Models\BaseModel;

class HaravanOrder extends BaseModel{
    protected $table = 'haravan_orders';

    public static function createFromJson($item,$accountId,$idx){
        $object = new static;
        $maintain =0;
        if($idx>0){
            $object->sapo_idx = $idx;
        }
        if($accountId>0){
            $object->account_id = $accountId;
        }
        $object->sapo_id = $item["id"];
        $object->buyer_accepts_marketing = $item["name"];
        $object->cancel_reason = $item["cancel_reason"];
        $object->cancelled_on = new \Datetime($item['cancelled_on']);
        $object->closed_on = new \Datetime($item['closed_on']);
        $object->created_on = new \Datetime($item['created_on']);
        $object->processed_on = new \Datetime($item['processed_on']);
        $object->modified_on = new \Datetime($item['modified_on']);
        $object->cart_token = $item['cart_token'];
        $object->checkout_token = $item['checkout_token'];
        $object->currency = $item['currency'];
        $object->email = $item['email'];
        $object->fulfillment_status = $item['fulfillment_status'];
        $object->financial_status = $item['financial_status'];
        $object->status = $item['status'];
        $object->name = $item['name'];
        $object->note = $item['note'];
        $object->order_number = $item['order_number'];
        $object->processing_method = $item['processing_method'];
        $object->source_url = $item['source_url'];
        $object->source_name = $item['source_name'];
        $object->landing_site = $item['landing_site'];
        $object->landing_site_ref = $item['landing_site_ref'];
        $object->referring_site = $item['referring_site'];
        $object->reference = $item['reference'];
        $object->source_identifier = $item['source_identifier'];
        $object->gateway = $item['gateway'];
        $object->sub_total_price = $item['sub_total_price'];
        $object->token = $item['token'];
        $object->total_discounts = $item['total_discounts'];
        $object->total_line_items_price = $item['total_line_items_price'];
        $object->total_price = $item['total_price'];
        $object->total_weight = $item['total_weight'];
        $object->tags = $item['tags'];
        $object->pay_adjustment_status = $item['pay_adjustment_status'];
        $object->test = $item['test'];
        $object->billing_address = json_encode(array_key_exists("billing_address", $item)?$item["billing_address"]:[]);
        $object->shipping_address = json_encode(array_key_exists("shipping_address", $item)?$item["shipping_address"]:[]);
        $object->customer = json_encode(array_key_exists("customer", $item)?$item["customer"]:[]);
        $object->line_items = json_encode(array_key_exists("line_items", $item)?$item["line_items"]:[]);
        $object->shipping_lines = json_encode(array_key_exists("shipping_lines", $item)?$item["shipping_lines"]:[]);
        $object->fulfillments = json_encode(array_key_exists("fulfillments", $item)?$item["fulfillments"]:[]);
        $object->refunds = json_encode(array_key_exists("refunds", $item)?$item["refunds"]:[]);
        $object->note_attributes = json_encode(array_key_exists("note_attributes", $item)?$item["note_attributes"]:[]);
        $object->discount_codes = json_encode(array_key_exists("discount_codes", $item)?$item["discount_codes"]:[]);
        $object->client_details = json_encode(array_key_exists("client_details", $item)?$item["client_details"]:[]);
        $object->discount_applications = json_encode(array_key_exists("discount_applications", $item)?$item["discount_applications"]:[]);
        $lastId = $object->save();
        return $object;
    }

}