<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
require_once "HQuery.php";
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Filesystem\Filesystem;
class HBladeCompiler extends BladeCompiler{
	protected $getTags = ['{\(', '\)}']; 
	protected $settingsTags = ['{\[', '\]}']; 
    protected $langTags = ['{:', ':}']; 
    protected $getTagsRaw = ['{#', '#}']; 
    protected $getTagsPhp = ['{@', '@}']; 
    protected $getTagsFnc = ['{%', '%}']; 
    protected $getTagsImageV2 = ['\[\[', '\]\]']; 
	protected $getTagImageConfig = ['{<', '>}']; 
	protected static $macros = [];
    protected $CI;
	public function __construct(Filesystem $files, $cachePath){
		parent::__construct($files,$cachePath);
        $this->CI = &get_instance();
	}
    public static function macro($name, $macro)
    {
        static::$macros[$name] = $macro;
    }
    public static function hasMacro($name){
        return array_key_exists($name, static::$macros);
    }
    public function __call($method, $parameters)
    {
        if (! static::hasMacro($method)) {
            throw new BadMethodCallException("Method {$method} does not exist.");
        }
        $macro = static::$macros[$method];
        if ($macro instanceof Closure) {
            return call_user_func_array($macro->bindTo($this, static::class), $parameters);
        }
        return call_user_func_array($macro, $parameters);
    }
	protected function getEchoMethods()
    {
        $methods = [
            'compileDBGet' => 999,
            'compileRawEchos' => strlen(stripcslashes($this->rawTags[0])),
            'compileEscapedEchos' => strlen(stripcslashes($this->escapedTags[0])),
            'compileRegularEchos' => strlen(stripcslashes($this->contentTags[0])),
            'compileGetEchos' => strlen(stripcslashes($this->getTags[0])),
            'compileGetRawEchos' => strlen(stripcslashes($this->getTags[0])),
            'compileSettingEchos' => strlen(stripcslashes($this->settingsTags[0])),
            'compileLangEchos' => strlen(stripcslashes($this->langTags[0])),
            'compileImgV2' => strlen(stripcslashes($this->getTagsImageV2[0])),
            'compileImgConfig' => strlen(stripcslashes($this->getTagImageConfig[0])),
            'compilePhp' => strlen(stripcslashes($this->getTagsPhp[0])),
            'compileFnc' => 99,
            
        ];
        $resultHook = $this->CI->hooks->call_hook(['tech5s_h_blade_echo_methods','methods'=>$methods]);
        if(is_array($resultHook)){
            extract($resultHook);
        }
        uksort($methods, function ($method1, $method2) use ($methods) {
            if ($methods[$method1] > $methods[$method2]) {
                return -1;
            }
            if ($methods[$method1] < $methods[$method2]) {
                return 1;
            }
            if ($method1 === 'compileRawEchos') {
                return -1;
            }
            if ($method2 === 'compileRawEchos') {
                return 1;
            }

            if ($method1 === 'compileEscapedEchos') {
                return -1;
            }
            if ($method2 === 'compileEscapedEchos') {
                return 1;
            }

        });
        return $methods;
    }

    public function compileGetEchos($value,$basename='$dataitem'){
        $loadDefault = true;
        $result = '';
        $resultHook = $this->CI->hooks->call_hook(['tech5s_h_blade_complie_get_echos','value'=>$value,'loadDefault'=>$loadDefault]);
        if(is_array($resultHook)){
            extract($resultHook);
        }
        if($loadDefault){
            $pattern = sprintf('/%s\s*(.+?)\s*%s/', $this->getTags[0], $this->getTags[1]);
            preg_match_all($pattern, $value, $out);
            if(count($out)==0) return $value;
            $fos = $out[0];
            foreach ($fos as $key => $temp) {
                $temp = str_replace("(", "\(", $temp);
                $temp = str_replace(")", "\)", $temp);
                $pattern = "/".$temp."/";
                $callback = function ($matches) use($basename) {
                    if(count($matches)>0){
                        foreach ($matches as $m) {
                            $m = str_replace("{(", "", $m);
                            $m = str_replace(")}", "", $m);
                            $arrTmp = explode('.', $m);
                            if(count($arrTmp)==3){
                                return sprintf("<?php echom(%s,'%s',%s); ?>",'$'.$arrTmp[0],$arrTmp[1],$arrTmp[2]);
                            }
                            else if(count($arrTmp)==1){
                                return sprintf("<?php echom(%s,'%s',%s); ?>",$basename,$arrTmp[0],1);
                            }
                            else if(count($arrTmp)==2){
                                if($arrTmp[1]=="1"||$arrTmp[1]=="0"){
                                    return sprintf("<?php echom(%s,'%s',%s); ?>",$basename,$arrTmp[0],$arrTmp[1]);
                                }
                                else{
                                    return sprintf("<?php echom(%s,'%s',%s); ?>",'$'.$arrTmp[0],$arrTmp[1],1);
                                }
                            }
                        }
                        
                    }

                };
            $value=preg_replace_callback($pattern, $callback, $value);
                
            }
            return $value;
        }
        return $result;
    }
    protected function compileGetRawEchos($value){
        $loadDefault = true;
        $result = '';
        $resultHook = $this->CI->hooks->call_hook(['tech5s_h_blade_complie_get_raw_echos','value'=>$value,'loadDefault'=>$loadDefault]);
        if(is_array($resultHook)){
            extract($resultHook);
        }
        if($loadDefault){
            $pattern = sprintf('/%s((.+)\.)?(.+)\.(0|1)%s(\r?\n)?/', $this->getTagsRaw[0], $this->getTagsRaw[1]);
            $callback = function ($matches) {
                return sprintf("echor(%s,'%s',%s)",isNull($matches[2])?'$dataitem':"$".trim($matches[2]),trim($matches[3]),trim($matches[4]));
            };

            return preg_replace_callback($pattern, $callback, $value);
        }
        return $result;
    }
    protected function compileSettingEchos($value){
        $loadDefault = true;
        $result = '';
        $resultHook = $this->CI->hooks->call_hook(['tech5s_h_blade_complie_setting_echos','value'=>$value,'loadDefault'=>$loadDefault]);
        if(is_array($resultHook)){
            extract($resultHook);
        }
        if($loadDefault){
            $pattern = sprintf('/%s(.+?)%s(\r?\n)?/', $this->settingsTags[0], $this->settingsTags[1]);
            $callback = function ($matches) {
                return sprintf(@"<?php echo %s->CI->Dindex->getSettings('%s'); ?>",'$this',trim(strtoupper($matches[1])));
            };

            return preg_replace_callback($pattern, $callback, $value);
        }
        return $result;
        
    }
    protected function compileImgV2($value){
        $loadDefault = true;
        $result = '';
        $resultHook = $this->CI->hooks->call_hook(['tech5s_h_blade_complie_imgv2','value'=>$value,'loadDefault'=>$loadDefault]);
        if(is_array($resultHook)){
            extract($resultHook);
        }
        if($loadDefault){
            $pattern = sprintf('/%s(.+?)%s(\r?\n)?/', $this->getTagsImageV2[0], $this->getTagsImageV2[1]);
            $callback = function ($matches) {
                $tmp = $matches[1];
                $tmps = explode(".", $tmp);
                $item = count($tmps)>0?"$".$tmps[0]:'[]';
                $key = count($tmps)>1?"'".$tmps[1]."'":'';
                $folder = count($tmps)>2?"'".$tmps[2]."'":"''";
                $webp = count($tmps)>3?$tmps[3]:"false";
                return sprintf(@"<?php echo imgv2(%s,%s,%s,%s) ; ?>",$item,$key,$folder,$webp);
            };

            return preg_replace_callback($pattern, $callback, $value);
        }
        return $result;
    }
    protected function compileImgConfig($value){
        $loadDefault = true;
        $result = '';
        $resultHook = $this->CI->hooks->call_hook(['tech5s_h_blade_complie_img_config','value'=>$value,'loadDefault'=>$loadDefault]);
        if(is_array($resultHook)){
            extract($resultHook);
        }
        if($loadDefault){
            $pattern = sprintf('/%s(.+?)%s(\r?\n)?/', $this->getTagImageConfig[0], $this->getTagImageConfig[1]);
            $callback = function ($matches) {
                $tmp = $matches[1];
                $tmps = explode(".", $tmp);
                $key = count($tmps)>0?$tmps[0]:"";
                $webp = count($tmps)>1?$tmps[1]:"false";
                $folder = count($tmps)>2?"'".$tmps[2]."'":"''";
                $isShow = count($tmps)>3?"'".$tmps[3]."'":"false";
                return sprintf(@"<?php echo %s->CI->Dindex->getSettingImage('%s',%s,%s,%s); ?>",'$this',$key,$webp,$folder,$isShow);
            };

            return preg_replace_callback($pattern, $callback, $value);
        }
    	return $result;
    }

    protected function compileLangEchos($value){
        $loadDefault = true;
        $result = '';
        $resultHook = $this->CI->hooks->call_hook(['tech5s_h_blade_complie_lang_echos','value'=>$value,'loadDefault'=>$loadDefault]);
        if(is_array($resultHook)){
            extract($resultHook);
        }
        if($loadDefault){
            $pattern = sprintf('/%s(.+?)%s(\r?\n)?/', $this->langTags[0], $this->langTags[1]);
            $callback = function ($matches) {
                return sprintf("<?php echo lang('%s'); ?>",trim(strtoupper($matches[1])));
            };

            return preg_replace_callback($pattern, $callback, $value);
        }
        return $result;
    }

    protected function compileFnc($value){
        $loadDefault = true;
        $result = '';
        $resultHook = $this->CI->hooks->call_hook(['tech5s_h_blade_complie_fnc','value'=>$value,'loadDefault'=>$loadDefault]);
        if(is_array($resultHook)){
            extract($resultHook);
        }
        if($loadDefault){
            $pattern = sprintf('/%s(.+?)%s/s', $this->getTagsFnc[0], $this->getTagsFnc[1]);
            $tmpArr = $this->arrFnc;
            $resultHook = $this->CI->hooks->call_hook(['tech5s_h_blade_complie_fnc_arr','tmpArr'=>$tmpArr]);
            if(is_array($resultHook)){
                extract($resultHook);
            }
            $callback = function ($matches) use($tmpArr) {
                $key = $matches[1];
                $tmp = explode(".", $key);
                $realKey = $tmp[0];
                array_splice($tmp, 0,1);
                if(array_key_exists($realKey, $tmpArr)){
                    return vsprintf($tmpArr[$realKey],$tmp);    
                }
                
            };

            return preg_replace_callback($pattern, $callback, $value);
        }
        return $result;
    }

    protected function compilePhp($value){
        $loadDefault = true;
        $result = '';
        $resultHook = $this->CI->hooks->call_hook(['tech5s_h_blade_complie_php','value'=>$value,'loadDefault'=>$loadDefault]);
        if(is_array($resultHook)){
            extract($resultHook);
        }
        if($loadDefault){
            $value = preg_replace("/".$this->getTagsPhp[0]."/", "<?php ", $value);
            $value = preg_replace("/".$this->getTagsPhp[1]."/", " ?>", $value);
            return $value;
        }
        return $result;
    }
    protected function compileDBGet($value){
        $loadDefault = true;
        $result = '';
        $resultHook = $this->CI->hooks->call_hook(['tech5s_h_blade_complie_db_get','value'=>$value,'loadDefault'=>$loadDefault]);
        if(is_array($resultHook)){
            extract($resultHook);
        }
        if($loadDefault){
            $pattern = "/<!--(dbs|DBS)-(.+?)-->/";
            preg_match_all($pattern, $value, $out);
            if(count($out[2])>0){
                foreach ($out[2] as $region) {
                    $n = explode('|', $region);
                    if(count($n)<1) return $value;
                    $name = str_replace(".", "\.", $n[0]);
                    $pattern = "/<!--(dbs|DBS)-".$name."(.+)-->(.+)<!--(dbe|DBE)-".$name."-->/Uis";

                    $callback = function ($matches) use($value,$n) {
                        $h = new HQuery($value,$matches,$n);

                        return $h->getQuery();
                    };

                    $value =  preg_replace_callback($pattern, $callback, $value);
                          
                }
            }
            return $value;
        }
        return $result;
    }
    protected $arrFnc = array(
    'HEADER'=> '<?php echo CMS_TITLE(isset($dataitem)?$dataitem:NULL,isset($masteritem)?$masteritem:NULL,isset($datatable)?$datatable:NULL); ?>',

    'PAGINATION' => '<?php  echo $this->CI->pagination->create_links(); ?>',
    'BREADCRUMB' => '<?php $this->CI->Dindex->getBreadcrumb((isset($datatable)&& array_key_exists("table_parent", $datatable))?$datatable["table_parent"]:array(),@$dataitem["parent"]?$dataitem["parent"]:0,echor($dataitem,"name","1")); ?>',
    'CATEGORIES' => '<?php $this->CI->Dindex->printCategories($datatable,$dataitem,""); ?>',
    'RELATED' => '<?php $parent = @$dataitem["parent"]?$dataitem["parent"]:"";
                    $arrRelated = $this->CI->Dindex->getRelateItem($dataitem["id"],$parent,$masteritem["table"],"0,%s",%s); ?>',
    'LIBIMG' => '<?php $arrImg = json_decode($dataitem["lib_img"],true); if($arrImg==NULL){$arrImg = array();} ?>',
    'VISITED' => '<?php $arrVisited = $this->CI->Dindex->getVisited(); ?>',
    'IMAGE_CATEGORIES'=>'<?php echo $this->CI->Dindex->printImageCategories($datatable,$dataitem,""); ?>',
    'BASEURL' => '<?php echo base_url(); ?>',
    );
}
 ?>
