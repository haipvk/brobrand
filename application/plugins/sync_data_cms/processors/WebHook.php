<?php

namespace Warranty\Processors;



use VthSupport\Classes\RequestHelper;

use Warranty\Models\KiotProduct;



class WebHook

{

    private $type;

    public function __construct(){

        $this->type = RequestHelper::getString('type','');

    }



    public function execute(){

        if($this->type=='product.update'){

            $this->updateProduct();

        }

        else if($this->type=='product.delete'){

            $this->deleteProducts();

            

        }

    }

    private function deleteProducts(){

        $json = file_get_contents('php://input');

        $post = json_decode($json,true);

        $ids = $post['RemoveId'];

        foreach ($ids as $k => $id) {

            $dbObject = KiotProduct::findBy('kiot_id',$id);

            if(!$dbObject->isEmpty()){

                $dbObject->act= 0;

                $dbObject->save();

            }

        }

    }

    private function updateProduct(){

        $json = file_get_contents('php://input');
        file_put_contents('test.txt',  $json);
        $post = json_decode($json,true);

        $data = isset($post['Notifications'][0]['Data'])?$post['Notifications'][0]['Data']:[];

        foreach ($data as $k => $item) {

            $obj = KiotProduct::parseFromJson($item);

            $dbObject = KiotProduct::findBy('kiot_id',$obj->kiot_id);

            if(!$dbObject->isEmpty()){

                $obj->id = $dbObject->id;

                $obj->save();

            }

        }

    }

}