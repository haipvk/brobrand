<?php 
use SyncDataCms\Constants\Url;
use SyncDataCms\Models\HaravanAccount;
use VthSupport\Classes\RequestHelper as Request;
use VthSupport\Classes\ResponseHelper as Response;
use VthSupport\Classes\LangHelper as LG;
use SyncDataCms\Processors\Sync;

class SyncDataCms extends IPlugin
{
	public function __construct(){
		parent::__construct();
		$this->CI = &get_instance();
	}
	
	public function install(){
		$this->addRoutes("Vindex/callBackPermistionHaravan",Url::CALLBACK_PERMISTION_HARAVAN);
		$this->addRoutes("Vindex/registerPermistionHaravan",Url::REGISTER_PERMISTION_HARAVAN);
		$this->addRoutes("Vindex/syncDataHaravan",Url::URL_SYNC_DATA_HARAVAN);
		
	}
	public function uninstall(){	
		$this->removeRoutes(Url::CALLBACK_PERMISTION_HARAVAN);
		$this->removeRoutes(Url::CALLBACK_PERMISTION_HARAVAN);
	}
	public function initVindex(){
		$vindex = &get_instance();
		$page = $this;
		$vindex::macro("callBackPermistionHaravan", function($itemRoutes) use($page){
			$page->callBackPermistionHaravan($itemRoutes);
		});
		$vindex::macro("registerPermistionHaravan", function($itemRoutes) use($page){
			$page->registerPermistionHaravan($itemRoutes);
		});
		$vindex::macro("syncDataHaravan", function($itemRoutes) use($page){
			$page->syncDataHaravan($itemRoutes);
		});
	}

	public function syncDataHaravan($itemRoutes){
		$name = Request::getString('name','betagalaxy');
		$accounts = HaravanAccount::where([['act','=',1],['name','=',$name]]);
		if(count($accounts)==0){
			return Response::jsonOrRedirect(100,LG::lang('INVALID_REQUEST','Yêu cầu không hợp lệ'),false);
		}
		$account = $accounts[0];
		$sync = new Sync($account);
		$sync->execute();
	}

	public function callBackPermistionHaravan($itemRoutes){
		var_dump($_POST);die();
	}

	public function registerPermistionHaravan($itemRoutes){
		$name = Request::getString('name','betagalaxy');
		$accounts = HaravanAccount::where([['act','=',1],['name','=',$name]]);
		if(count($accounts)==0){
			return Response::jsonOrRedirect(100,LG::lang('INVALID_REQUEST','Yêu cầu không hợp lệ'),false);
		}
		$account = $accounts[0];
		$responseMode = 'form_post';
		$responseType = 'code id_token';
		$scope = 'openid profile email org userinfo';
		$clientId = !$account->isEmpty()?$account->client_id:'';
		$redirectUri = base_url(Url::CALLBACK_PERMISTION_HARAVAN);
		//$url = vsprintf(Url::URL_CONNECT_AUTHORIZE,['%s',$responseMode,$responseType,$scope,$clientId,$redirectUri]);
		$url = 'https://accounts.haravan.com/connect/authorize?response_mode='.$responseMode.'&response_type='.$responseType.'&scope='.urlencode($scope).'&client_id='.$clientId.'&redirect_uri='.urlencode($redirectUri).'nonce=tech@123';
		$url = "https://betagalaxy.myharavan.com/admin/oauth/authorize?client_id={$clientId}&scope=". urlencode($scope)."&response_type=".$responseType."response_mode=".$responseMode."&redirect_uri=".urlencode($redirectUri)."&nonce=tech@123";
		var_dump($url);die();
		return redirect($url,'fresh');
	}



	
}
