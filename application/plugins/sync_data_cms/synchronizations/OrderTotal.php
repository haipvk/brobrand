<?php
namespace SyncDataCms\synchronizations;
use SyncDataCms\constants\ConnectMethod;
use SyncDataCms\contracts\BaseConnect;
use SyncDataCms\Constants\Api;

class OrderTotal extends BaseConnect{
    public function __construct($account){
        parent::__construct($account,Api::URL_COUNT_ORDER);
    }
    public function execute(){
        $this->reInit();
        $this->setHeaders($this->account->getHeader());
        $this->setmethod(ConnectMethod::GET);
        $result = $this->_execute([]);
        $result = json_decode($result,true);
        return $result;
    }
}