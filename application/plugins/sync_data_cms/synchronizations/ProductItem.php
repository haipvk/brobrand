<?php
namespace SyncDataCms\Synchronizations;
use SyncDataCms\Constants\ConnectMethod;
use SyncDataCms\Contracts\BaseConnect;
use SyncDataCms\Models\HaravanAccount;
use SyncDataCms\Models\HaravanProduct;
class ProductItem extends BaseConnect{
    public function __construct($account,$id){
        parent::__construct($account,Api::URL_DETAIL_PRODUCT);
    }
    public function execute(){
        $this->reInit();
        $this->setHeaders($this->account->getHeaderKiot());
        $this->setmethod(ConnectMethod::GET);
        $result = $this->_execute([]);
        $result = json_decode($result,true);
        return $result;
    }
}