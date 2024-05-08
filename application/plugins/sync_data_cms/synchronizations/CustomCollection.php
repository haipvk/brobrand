<?php
namespace SyncDataCms\Synchronizations;
use SyncDataCms\Constants\ConnectMethod;
use SyncDataCms\Contracts\BaseConnect;
use SyncDataCms\Models\HaravanAccount;
use SyncDataCms\Models\HaravanCustomCollection;
use SyncDataCms\Constants\Api;

class CustomCollection extends BaseConnect{
    public function __construct($account){
        parent::__construct($account,Api::URL_ALL_CUSTOM_COLLECTION);
    }
    public function execute(){
        $startIdx = $this->account->getLastCustomCollectionIndex();
        var_dump($startIdx);die();
        $total = $this->getTotalCustomCollection();
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
            $data = isset($result["custom_collections"])?$result["custom_collections"]:[];
            $current +=  count($data);
            $totalData = array_merge($totalData,$data);
            $page++;
        }
        while($current < $total);
        foreach ($totalData as $k => $item) {
            $startIdx++;
            $product = HaravanCustomCollection::createFromJson($item,$this->account->id,$startIdx);
            unset($totalData[$k]);
        }
    }

    private function getTotalCustomCollection(){
        $total = new CustomCollectionTotal($this->account);
        $totals = $total->execute();
        return isset($totals['count'])?$totals['count']:0;
    }
}