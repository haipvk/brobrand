<?php 

namespace SupportTitle\Classes;

class MetaSeo{

	protected $CI;

	protected $dataitem;

	protected $masteritem;

	protected $datatable;

	protected $titleSEO;

	protected $desSEO;

	protected $keySEO;

	protected $siteName;

	public function __construct($dataitem,$masteritem,$datatable){

		$this->CI = &get_instance();

		$this->dataitem = $this->getRealDataItem($dataitem);

		$this->masteritem = $masteritem;

		$this->datatable = $datatable;

		$this->titleSEO = $this->getDefaultTitleSeo();

		$this->desSEO = $this->getDefaultDesSeo();

		$this->keySEO = $this->getDefaultKeySeo();

		$this->siteName = $this->getSiteName();

	}

	public function show(){

		$ret=  "<base href='".base_url()."'/>";

		$ret .=  $this->getMetaNoFollow();

		$ret .= $this->getStandardMeta();

		$ret .= $this->getMetaFacebook();

		$ret .= $this->getMetaTwitter();

		$ret .= $this->getMetaImageShare();

		$ret .= $this->getOtherMeta();

		$ret .= $this->getFavicon();

		return $ret;

	}	

	private function getFavicon(){

		$meta = '';

		$meta .='<meta name="apple-mobile-web-app-capable" content="yes">';

		$meta .='<meta name="apple-mobile-web-app-status-bar-style" content="black">';

		$meta .=sprintf('<meta name="apple-mobile-web-app-title" content="%s">',$this->siteName);

		$meta .=$this->tech5sGetFavicion(72);

		$meta .=$this->tech5sGetFavicion(96);

		$meta .=$this->tech5sGetFavicion(128);

		$meta .=$this->tech5sGetFavicion(144);

		$meta .=$this->tech5sGetFavicion(152);

		$meta .=$this->tech5sGetFavicion(192);

		$meta .=$this->tech5sGetFavicion(384);

		$meta .=$this->tech5sGetFavicion(512);



		$meta .=$this->tech5sAppleIcon(152);

		return $meta;

	}

	private function tech5sAppleIcon($size,$onlyLink = false){

		if($onlyLink){

			return tech5sGetFavicion(152,true);

		}

		$fav = tech5sGetFavicion(152,true);

		if($fav!=""){

			return sprintf('<link rel="apple-touch-icon" href="%s">',$fav);

		}

		return "";

	}

	private function tech5sGetFavicion($size,$onlyLink = false){

		$fav =json_decode($this->CI->Dindex->getSettings('FAVICON'.$size),true);

		$fav = @$fav ?$fav["path"].$fav["file_name"]:"";

		if($fav == ""){

			$fav =json_decode($this->CI->Dindex->getSettings('FAVICON'),true);

			$fav = @$fav ?$fav["path"].$fav["file_name"]:"";

		}

		if($fav != "" && file_exists($fav)){

			$fav = base_url($fav);

			if($onlyLink){

				return $fav;

			}

			return sprintf('<link rel="icon" type="image/png" sizes="%sx%s" href="%s">',$size,$size,$fav);	

		}

		return "";

		

	}

	private function getOtherMeta(){

		$meta = '';

		$meta .= '<meta property="og:locale" content="vi_vn">';

		$wmt = $this->CI->Dindex->getSettings('WMT');

		if(!isNull($wmt)){

			$meta .=sprintf('<meta name="google-site-verification" content="%s" />',$wmt);

		}

		$fbappid = $this->CI->Dindex->getSettings('FBAPPID');

		if('FBAPPID'!=$fbappid){

			$meta .= sprintf('<meta property="fb:app_id" content="%s">',$fbappid);

		}

		$lang = 'vi';

		if(function_exists('pGetLanguage')){

			$lang  = pGetLanguage();

		}

		$meta .= sprintf('<meta name="lang" content="%s">',$lang);

		$meta .=sprintf('<link rel="canonical" href="%s">',$this->tech5sGetCanonical());



		$fav =json_decode($this->CI->Dindex->getSettings('FAVICON'),true);

		$fav = @$fav ?$fav["path"].$fav["file_name"]:"";

		if($fav !="" && file_exists($fav)){

			$fav = base_url($fav);

			$meta .= sprintf('<link rel="shortcut icon" href="%s">',$fav);

		}

		$themeColor = $this->CI->Dindex->getSettings('THEME_COLOR');

		if(!isNull($themeColor)){

			$meta .=sprintf('<meta name="theme-color" content="%s">',$themeColor);

		}

		$manifest  = 'manifest.json';

		if(file_exists($manifest)){

			$meta .= sprintf('<link rel="manifest" href="%s">',base_url('manifest.json'));

		}

		return $meta;

	}

	private function getMetaImageShare(){

		$img = $this->getImageShare();

		$meta = '';

		$meta .= sprintf('<meta property="og:image" content="%s">',$img);

		$meta .= sprintf('<meta name="twitter:image" content="%s">',$img);

		$meta .= sprintf('<meta property="og:image:alt" content="%s">',$this->titleSEO);

		return $meta;

	}

	public function getImageShare(){

		if(base_url()==current_url()){

			return $this->getImageShareHome();

		}

		else{

			return $this->getImageShareSubPage();

		}

	}

	private function getImageShareSubPage(){

		$img = (@$this->dataitem && @$this->dataitem['img'])?$this->dataitem['img']:"";

		if(isNull($img)){

			$tmp = (@$this->dataitem && @$this->dataitem['content'])?$this->dataitem['content']:"";

			$img = $this->CI->Dindex->getSettings('FBSHARE');

			$img = json_decode($img,true);



			if(@$img){

				$img = $img["path"].$img["file_name"];

			}

			else{

				$img = "";

			}

			$img = getImageFromContent($tmp,$img);

			if(isNull($img) || $img =='FBSHARE'){

				$logo = json_decode($this->CI->Dindex->getSettings("LOGO"),true);

				$img = @$logo ? $logo["path"].$logo["file_name"]:"";

			}

		}else{

			$img = json_decode($img,true);

			$img =@$img? $img["path"].$img["file_name"]:"";

		}

		$pos = strpos($img , 'http');

		if($pos === FALSE) $img = base_url($img);

		return $img;

	}

	private function getImageShareHome(){

		$img = $this->CI->Dindex->getSettings('FBSHARE');

		$img = json_decode($img,true);

		if(isset($img) && array_key_exists('path', $img)){

			$img = $img["path"].$img["file_name"];

		}

		else{

			$logo = json_decode($this->CI->Dindex->getSettings("LOGO"),true);

			$img = isset($logo) ? $logo["path"].$logo["file_name"]:"";

		}

		$pos = strpos($img , 'http');

		if($pos === FALSE) $img = base_url($img);

		return $img;

	}

	private function getSiteName(){

		$siteName = $this->CI->Dindex->getSettings('SITE_NAME');

	    $siteName = (isNull($siteName)?$this->titleSEO:$siteName);

	    return $siteName;

	}

	private function getMetaTwitter(){

		$meta = '';

		$meta .= sprintf('<meta name="twitter:url" content="%s">',current_url());

		$meta .= sprintf('<meta name="twitter:title" content="%s">',$this->titleSEO);

		$meta .= sprintf('<meta name="twitter:description" content="%s">',$this->desSEO);

		return $meta;

	}

	private function getMetaFacebook(){

		$meta = '';

		$meta .= sprintf('<meta property="og:site_name" content="%s">',$this->siteName);

		$meta .= sprintf('<meta property="og:url" content="%s">',current_url());

		$meta .= '<meta property="og:type" content="article">';

		$meta .= sprintf('<meta property="og:title" content="%s">',$this->titleSEO);

		$meta .= sprintf('<meta property="og:description" content="%s">',$this->desSEO);

		return $meta;

	}

	private function getStandardMeta(){

		$meta = '';

		$meta .= sprintf('<title>%s</title>',$this->titleSEO);

	    $meta .= sprintf('<meta name="description" content="%s">',$this->desSEO);

	    $meta .= sprintf('<meta name="keywords" content="%s">',$this->keySEO);

	    return $meta;

	}

	private function getRealDataItem($dataitem){

		if(current_url()==base_url()) return null;

		return $dataitem;

	}

	

	private function getDefaultTitleSeo(){

		return $this->getDefaultSeo('TITLE_SEO','s_title');

	}

	private function getDefaultKeySeo(){

		return $this->getDefaultSeo('KEY_SEO','s_key');

	}

	private function getDefaultDesSeo(){

		return $this->getDefaultSeo('DES_SEO','s_des');

	}

	private function getDefaultSeo($configKey,$key){

		$tmp = $this->CI->Dindex->getSettings($configKey);

		return addslashes(getFieldSeoByLang($key,$this->dataitem,$tmp));

	}

	private function tech5sGetCanonical(){

		$segs = $this->CI->uri->segment_array();

		if(count($segs)>1){

			$idx = count($segs);

			$lastSeg = $segs[$idx];

			if(is_numeric($lastSeg)){

				unset($segs[$idx]);

				return base_url(implode('/', $segs));

			}

		}

		return current_url();

	}

	function getMetaNoFollow(){

		$item = $this->dataitem;

		$idx = 'index';
		if(isset($item)){
			if(isset($item['noindex']) && $item['noindex'] == 1){
				$idx = 'noindex';
			}
		}
		$follow = 'follow';
		if(isset($item)){
			if(isset($item["nofollow"]) && $item["nofollow"]==1){
				$follow = 'nofollow';
			}
		}
	   	$idx = $idx.",".$follow;

	   	return sprintf('<meta name="robots" content="%s" />',$idx);

	}

}