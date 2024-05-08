<?php
namespace SyncDataCms\Models;
use TechSupport\Models\BaseModel;
use SyncDataCms\Auth\AccessToken;
class HaravanAccount extends BaseModel{
    protected $table = 'haravan_accounts';
    private function getAccessToken(){
        /*if($this->end_time<time() ||isNull( $this->access_token)){
            $accessToken = new AccessToken($this);
            $accessToken->setAccount($this);
            $accessString = $accessToken->execute();
            $this->access_token = $accessString;
            $this->end_time = time()+50000;
            $this->save();
        }*/
        return $this->access_token;
    }
    public function getHeader(){
		$headers[] = 'Authorization: Bearer '.$this->getAccessToken();
		return $headers;
    }

    public function getLastProductIndex(){

        $items = HaravanProduct::where([['account_id','=',$this->id]],'*','0,1','id desc');
        if(count($items)>0){
            return $items[0]->idx;
        }
        return 0;
    }

    public function getLastCollectIndex(){
        $items = HaravanCollect::where([['account_id','=',$this->id]],'*','0,1','id desc');
        if(count($items)>0){
            return $items[0]->idx;
        }
        return 0;
    }

    public function getLastCustomCollectionIndex(){
        $items = HaravanCustomCollection::where([['account_id','=',$this->id]],'*','0,1','id desc');
        if(count($items)>0){
            return $items[0]->idx;
        }
        return 0;
    }
}