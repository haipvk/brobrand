<?php

namespace MediaSupport\Classes;

use MediaSupport\Classes\File;
use MediaSupport\Databases\Media as MediaDB;

class Media
{
    private $CI;
    private $extimgs;
    private $extvideos;
    private $extfiles;
    private $extmusic;
    private $extmisc;
    private $max_size;
    private $max_width;
    private $max_height;
    private $mediaDB;
    private $allowedTypes;
    private $overwrite;
    public function __construct($maxSize = 0, $allowedTypes = [], $overwrite = false)
    {
        $this->CI = &get_instance();
        $this->CI->load->config('filemanager');
        $this->extimgs = $this->CI->config->item('ext_img');
        $this->extvideos = $this->CI->config->item('ext_video');
        $this->extfiles = $this->CI->config->item('ext_file');
        $this->extmusic = $this->CI->config->item('ext_music');
        $this->extmisc = $this->CI->config->item('ext_misc');
        $this->max_size = $maxSize > 0 ? $maxSize : $this->CI->config->item('max_size');
        $this->max_width = $this->CI->config->item('max_width');
        $this->max_height = $this->CI->config->item('max_height');
        $this->mediaDB = new MediaDB;
        $this->allowedTypes = $allowedTypes;
        $this->overwrite = $overwrite;
    }


    public function uploadFile($path, $field = 'file', $idDir = -1)
    {
        $config['upload_path'] = $path;
        $config['allowed_types'] = $this->getAllowedTypes();
        $config['max_size'] = $this->max_size;
        $config['max_width']  = $this->max_width;
        $config['max_height']  = $this->max_height;
        $config['overwrite']  = $this->overwrite;
        $this->CI->load->library("upload", $config);
        $results = array();
        $files = $_FILES[$field];
        if(is_array($files['name'])){
            foreach ($files['name'] as $key => $image) {
                $tmpName = $files['name'][$key];
                $tmpRealName = substr($tmpName, 0, strrpos($tmpName, "."));
                $ext = strtolower(substr($tmpName, strrpos($tmpName, ".")));
                $config['file_name'] = replaceURL($tmpRealName) . $ext;
                $_FILES[$field . '[]']['name'] = $files['name'][$key];
                $_FILES[$field . '[]']['type'] = $files['type'][$key];
                $_FILES[$field . '[]']['tmp_name'] = $files['tmp_name'][$key];
                $_FILES[$field . '[]']['error'] = $files['error'][$key];
                $_FILES[$field . '[]']['size'] = $files['size'][$key];
                $this->CI->upload->initialize($config);
                if ($this->CI->upload->do_upload($field . '[]')) {
                    $getFileUpload = $this->CI->upload->data();
                    if ($idDir >= 0) {
                        $ret = $this->mediaDB->insertFile($config['upload_path'], $getFileUpload['file_name'], $idDir);
                        array_push($results, $ret);
                    }
                    else{
                        array_push($results, $config['upload_path'].$getFileUpload['file_name']);
                    }   
                }
            }
        }
        else{
            $tmpName = $files['name'];
            $tmpRealName = substr($tmpName, 0, strrpos($tmpName, "."));
            $ext = strtolower(substr($tmpName, strrpos($tmpName, ".")));
            $config['file_name'] = replaceURL($tmpRealName) . $ext;
            $this->CI->load->library('upload', $config);
            if ($this->CI->upload->do_upload($field))
            {
                $getFileUpload = $this->CI->upload->data();
                if ($idDir >= 0) {
                    $ret = $this->mediaDB->insertFile($config['upload_path'], $getFileUpload['file_name'], $idDir);
                    array_push($results, $ret);
                }
                else{
                    array_push($results, $config['upload_path'].$getFileUpload['file_name']);
                }  
            }
        }
        return $results;
    }
    public function insertFile($path, $file, $idDir)
    {
        return $this->mediaDB->insertFile($path, $file, $idDir);
    }
    private function getAllowedTypes()
    {
        if ($this->allowedTypes) return $this->allowedTypes;
        $types = [
            implode("|", $this->extimgs),
            implode("|", $this->extvideos),
            implode("|", $this->extfiles),
            implode("|", $this->extmusic),
            implode("|", $this->extmisc),
        ];
        return $this->allowedTypes = implode("|", $types);
    }
    public function getOrCreateDir($name, $parent, $currentPath)
    {
        $id = $this->mediaDB->getMediaId($name, $parent);
        if ($id <= 0) {
            $id = $this->createDir($currentPath, $name, $parent);
        }
        return $id;
    }
    public function createDir($currentpath, $folder_name, $parent)
    {
        $this->createDirIfNotExist($currentpath . $folder_name);
        return $this->mediaDB->insertDirectory($currentpath, $folder_name, $parent);
    }
    private function createDirIfNotExist($path)
    {
        if (!file_exists($path)) {
            mkdir($path, 0777, TRUE);
        }
    }
}
