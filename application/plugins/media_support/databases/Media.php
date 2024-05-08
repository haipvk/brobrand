<?php

namespace MediaSupport\Databases;

use MediaSupport\Classes\File;

class Media
{
    protected $table = 'medias';
    private $fileInfo;

    private static $currentFileInserted = [];


    public function __construct()
    {
        $this->CI = &get_instance();
        $this->fileInfo = new File;
    }

    public static function getFileInsertedByName($fileName){
        if(array_key_exists($fileName, static::$currentFileInserted)){
            $file = static::$currentFileInserted[$fileName];
            if($file['id']!=-1){
                return $file;
            }
        }
        return [];
    }
    public function insert($data)
    {
        $this->CI->db->trans_start();
        $this->CI->db->insert($this->table, $data);
        $lastId = $this->CI->db->insert_id();
        $this->CI->db->trans_complete();
        if ($this->CI->db->trans_status() === FALSE) {
            $this->CI->db->trans_rollback();
            return -1;
        } else {
            $this->CI->db->trans_commit();
            return $lastId;
        }
    }
    public function insertFile($path, $filename, $parent = 0)
    {
        $data["name"] = $filename;
        $data["file_name"] = $filename;
        $data["is_file"] = 1;
        $data["create_time"] = time();
        $data["parent"] = $parent;
        $data["path"] = $path;
        $data["extra"] = $this->fileInfo->getFileInfoJson($filename, $path . $filename);

        $data['id'] = $this->insert($data);
        static::$currentFileInserted[$filename] = $data;
        return $data['id'];
    }
    public function insertDirectory($currentpath, $folder_name, $parent)
    {
        $data["name"] = $folder_name;
        $data["file_name"] = $folder_name;
        $data["is_file"] = 0;
        $data["create_time"] = time();
        $data["parent"] = $parent;
        $data["path"] = $currentpath;
        $data["file_name"] = $folder_name;
        $data["extra"] = $this->fileInfo->getFileInfoJson($folder_name, $currentpath);
        return $this->insert($data);
    }
    public function getMediaId($name, $parent = -1)
    {
        $this->CI->db->where('name', $name);
        if ($parent > -1) {
            $this->CI->db->where('parent', $parent);
        }

        $ret = $this->CI->db->get('medias')->result_array();
        if (count($ret) > 0) {
            return $ret[0]['id'];
        }
        return 0;
    }

    public function getMedia($name)
    {
        $this->CI->db->where('name', $name);
        $ret = $this->CI->db->get('medias')->result_array();
        $result = [];
        if (count($ret) > 0) {
            $result = $ret[0];
        }
        return $result;
    }
}
