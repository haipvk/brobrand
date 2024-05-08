<?php
namespace SyncDataCms\Synchronizations;
use SyncDataCms\Constants\ConnectMethod;
use SyncDataCms\Contracts\BaseConnect;
use SyncDataCms\Models\HaravanAccount;
use SyncDataCms\Models\HaravanProduct;
use SyncDataCms\Constants\Api;

class Product extends BaseConnect{
    public function __construct($account){
        parent::__construct($account,Api::URL_ALL_PRODUCT);
    }
    public function execute(){
        $startIdx = $this->account->getLastProductIndex();
        $total = $this->getTotalProduct();
        if($total < $startIdx)return;
        $page = 1;
        $current = 0;
        $totalData = [];
        do {
            $this->reInit();
            $this->setHeaders($this->account->getHeader());
            $this->setmethod(ConnectMethod::GET);
            $result = $this->_execute(["limit"=>50,'page'=>$page]);
            $result = json_decode($result,true);
            $data = isset($result["products"])?$result["products"]:[];
            $current +=  count($data);
            $totalData = array_merge($totalData,$data);
            $page++;
        }
        while($current < $total);
        foreach ($totalData as $k => $item) {
            $startIdx++;
            $product = HaravanProduct::createFromJson($item,$this->account->id,$startIdx);
            unset($totalData[$k]);
        }
    }

    private function getTotalProduct(){
        $total = new ProductTotal($this->account);
        $totals = $total->execute();
        return isset($totals['count'])?$totals['count']:0;
    }
}