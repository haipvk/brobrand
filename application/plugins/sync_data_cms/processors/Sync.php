<?php
namespace SyncDataCms\Processors;
use SyncDataCms\Models\HaravanAccount;
use SyncDataCms\Synchronizations\Product;
use SyncDataCms\Synchronizations\Order;
use SyncDataCms\Synchronizations\Collect;
use SyncDataCms\Synchronizations\CustomCollection;
class Sync
{
    protected $account;
    public function __construct($account){
        $this->account= $account;
    }
    public function execute(){
		//$this->syncProduct();
		//$this->syncOrder();
		$this->syncCollect();
		//$this->syncCustomCollection();
    }

	private function syncProduct(){
		$product = new Product($this->account);
		$product->execute();
	}

	private function syncOrder(){
		$order = new Order($this->account);
		$order->execute();
	}

	private function syncCollect(){
		$collect = new Collect($this->account);
		$collect->execute();
	}

	private function syncCustomCollection(){
		$customCollection = new CustomCollection($this->account);
		$customCollection->execute();
	}
}