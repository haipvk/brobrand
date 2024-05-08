<?php 
if(!class_exists('VthSupport')){
	$file = FCPATH."/application/plugins/vth_support/VthSupport.php";
	if(file_exists($file)){
		require_once $file;
		$vth = new VthSupport;
	}
	$file = FCPATH."/application/plugins/tech_support/TechSupport.php";
	if(file_exists($file)){
		require_once $file;
	}
}
use CustomMedia\Tables\CustomMediaImageMeta;
use MediaSupport\Classes\File;

class CustomMedia extends IPlugin{
	protected $CI;
	protected $linkCronResizeImage = "cron-resize";
	protected $fileInfo;
	public function __construct(){
		parent::__construct();
		$this->CI = &get_instance();
		$this->fileInfo = new File;
	}
	public function install(){
		$this->publishFile("theme/js/script.js");
		$this->publishFile("theme/js/script_detail.js");
		$this->publishFile("theme/css/style.css");
		$this->addRoutes("Vindex/cronResize",$this->linkCronResizeImage);
		CustomMediaImageMeta::instance()->install();
	}
	public function uninstall(){
		$this->removeFile();
		$this->removeRoutes($this->linkCronResizeImage);
		CustomMediaImageMeta::instance()->uninstall();
	}
	public function initVindex(){
		$vindex = &get_instance();
		$page = $this;
		$vindex::macro("cronResize", function($itemRoutes) use($page){
			$page->cronResize($itemRoutes);
        });
	}
	public function initTechsystem(){
		// require_once 'helper.php';
		var_dump("expression");die;
		return true;
	}
	public function addHtmlMedia(){
		echo '<div class="move_selection"></div><div class="selection-rect"></div>';
		return true;
	}
	public function addJsMedia(){
		echo '<script type="text/javascript" src="'.$this->urlFile("theme/js/script.js").'"></script>';
		return true;
	}
	public function addCssMedia(){
		echo '<style>'.file_get_contents($this->urlFile("theme/css/style.css")).'</style>';
		return true;
	}
	public function addJsEdit(){
		echo '<script type="text/javascript" src="'.$this->urlFile("theme/js/script_detail.js").'"></script>';
		return true;
	}
	public function changeUpload($args){
		$fileuploaded = $args['fileuploaded'];
		$this->CI->load->config('filemanager');
		$extimgs = $this->CI->config->item('ext_img');
		$tmpName = basename($fileuploaded);
		$ext = strtolower(substr($tmpName, strrpos($tmpName, '.')));
		if(in_array(substr($ext,1), $extimgs)){
			$cmi = [];
			$cmi['act'] = 0;
			$cmi['name'] = $fileuploaded;
			$cmi['create_time'] = time();
			$this->insertCustomMediaImage($cmi);
		}
		return ['ext'=>CustomMedia::class];
	}

	public function cronResize(){
		$images = $this->getCustomMediaImages();
		$this->CI->load->config('filemanager');
		$config['upload_path']=$this->CI->config->item('path_uploads');
		foreach ($images as $key => $image) {
			$imageUrl = $image['name'];
			if(!$this->isSVGImage($imageUrl)){
				$this->convertToWebp($imageUrl);	
	    		$arrSizes = $this->getSizes($imageUrl);
	    		$filename = basename($imageUrl);
	    		$upload_path = str_replace($filename, '', $imageUrl);
	    		if(count($arrSizes)>0){
	    			$new_image = '';
	    			foreach ($arrSizes as $size) {
	    				$this->resizeImage($upload_path,$filename,$size['width'],$size['height'],$size['quality'],$size['name']);
	    			}
	    		}

			}
			$this->updateExtraMedia($upload_path,$filename);
    		$this->updateCustomMediaImage($image['id']);
		}
	}
	private function isSVGImage($image){
		$ext = pathinfo($image, PATHINFO_EXTENSION);
		return strtolower($ext) == 'svg';
	}
	private function convertToWebp($source){
		if(!$this->CI->config->item('webp')) return;
		$destination = $this->getWebpFile($source);
		$options = [];
		try {
			\WebPConvert\WebPConvert::convert($source, $destination, $options);	
		}
		catch (\Exception $e) {
		}
		if(file_exists($destination)){
			return $destination;
		}
		return '';
	}
	private function getWebpFile($file){
		$path = pathinfo($file);
		$dirname = $path['dirname'];
		$extension = $path['extension'];
		$filename = $path['filename'];
		$destination = $dirname.'/'.$filename.'.webp';
		return $destination;
	}
	private function getSizes($file){
		if(file_exists($file)){
			$json = $this->CI->Admindao->getConfigSite('size_image','');
			$arr = json_decode($json,true);
			$arr = @$arr?$arr:array();
			$s = getimagesize($file);
			$w = count($s)>0 && $s[0] > 0 ?$s[0]:1;
			$h = count($s)>1?$s[1]:1;
			foreach ($arr as $k => $v) {
				if($v['width']>$w){
					unset($arr[$k]);
				}
			}
			array_push($arr,array('name'=>'def','width'=>100,'height'=>(int)($h*100/$w),'quality'=>80));
			return $arr;
		}
		return array();
	}
	private function resizeImage($upload_path,$getFileUpload,$widthImage,$heightImage,$quality,$name){
		$filename = is_array($getFileUpload)?$getFileUpload['file_name']:$getFileUpload;
		$this->CI->load->library('image_lib');
      	$config['image_library'] = 'gd2';
      	$config['source_image'] = $upload_path.$filename;
      	$config['create_thumb'] = false;
      	$p = $upload_path.'thumbs/'.$name.'/';
        if(!is_dir($p)){
        	mkdir($p,0777,1);
        }
      	$config['new_image'] = $p.$filename;
        if($heightImage<=0){
        	$config['maintain_ratio'] = TRUE;
        	$config['width'] = $widthImage;
        }
        else if($widthImage<=0){
        	$config['maintain_ratio'] = TRUE;
        	$config['height']   = $heightImage;	
        }
        else{
        	$config['maintain_ratio'] = FALSE;
        	$config['width'] = $widthImage;
        	$config['height']   = $heightImage;	
        }
      	$config['quality'] = $quality;
    	$this->CI->image_lib->initialize($config);
    	$this->CI->image_lib->resize();
    	$this->convertToWebp($config['new_image']);
    	return $config['new_image'];
	}
	private function insertCustomMediaImage($data){
		$this->CI->db->insert('custom_media_images',$data);
	}
	private function getCustomMediaImages(){
		$this->CI->db->where('act',0);
		$q = $this->CI->db->get('custom_media_images',5);
		$images = $q->result_array();
		return $images;
	}
	private function updateExtraMedia($file_path,$filename){
		$info = $this->fileInfo->getFileInfoJson($filename, $file_path);
		$this->CI->db->update('medias',['extra'=>$info],['path'=>$file_path,'file_name'=>$filename]);
	}
	private function updateCustomMediaImage($id){
		$this->CI->db->update('custom_media_images',['act'=>1,'update_time'=>time()],['id'=>$id]);
	}
}