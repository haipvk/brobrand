<?php
namespace SyncDataCms\Synchronizations;
use SyncDataCms\Constants\ConnectMethod;
use \SyncDataCms\Contracts\BaseConnect;
use SyncDataCms\Models\HaravanAccount;
use SyncDataCms\Models\HaravanCollect;
use SyncDataCms\Constants\Api;

class Collect extends BaseConnect{
    public function __construct($account){
        parent::__construct($account,Api::URL_ALL_COLLECT);
    }
    public function execute(){
        $startIdx = $this->account->getLastCollectIndex();
        $total = $this->getTotalCollect();
        var_dump($total);die();
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
            $data = isset($result["collects"])?$result["collects"]:[];
            $current +=  count($data);
            $totalData = array_merge($totalData,$data);
            $page++;
        }
        while($current < $total);
        foreach ($totalData as $k => $item) {
            $startIdx++;
            $product = HaravanCollect::createFromJson($item,$this->account->id,$startIdx);
            unset($totalData[$k]);
        }
    }

    private function getTotalCollect(){
        $total = new CollectTotal($this->account);
        $totals = $total->execute();
        return isset($totals['count'])?$totals['count']:0;
    }
}