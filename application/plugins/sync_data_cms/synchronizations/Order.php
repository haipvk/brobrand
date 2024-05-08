<?php
namespace SyncDataCms\Synchronizations;
use SyncDataCms\Constants\ConnectMethod;
use SyncDataCms\Contracts\BaseConnect;
use SyncDataCms\Models\HaravanAccount;
use SyncDataCms\Models\HaravanOrder;
use SyncDataCms\Constants\Api;

class Order extends BaseConnect{
    public function __construct($account){
        parent::__construct($account,Api::URL_ALL_ORDER);
    }
    public function execute(){
        $startIdx = 1;/*$this->account->getLastOrderIndex();*/
        $total = $this->getTotalOrder();
        if($total < $startIdx)return;
        $page = 1;
        $current = 0;
        $totalData = [];
        do {
            $this->reInit();
            $this->setHeaders($this->account->getHeader());
            $this->setmethod(ConnectMethod::GET);
            $result = $this->_execute(['page'=>$page]);
            $result = json_decode($result,true);
            $data = isset($result["orders"])?$result["orders"]:[];
            $current +=  count($data);
            $totalData = array_merge($totalData,$data);
            $page++;
        }
        while($current < $total);
        foreach ($totalData as $k => $item) {
            $startIdx++;
            $product = HaravanOrder::createFromJson($item,$this->account->id,$startIdx);
            unset($totalData[$k]);
        }
    }

    private function getTotalOrder(){
        $total = new OrderTotal($this->account);
        $totals = $total->execute();
        return isset($totals['count'])?$totals['count']:0;
    }
}