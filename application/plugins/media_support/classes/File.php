<?php



namespace MediaSupport\Classes {

    class File

    {

        protected $extimgs;

        protected $extvideos;

        protected $extfiles;

        protected $extmusic;

        protected $extmisc;

        protected $basepath;

        public function __construct()

        {

            $this->CI = &get_instance();
            $this->CI->load->config('filemanager');
            $this->extimgs = $this->CI->config->item('ext_img');

            $this->extvideos = $this->CI->config->item('ext_video');

            $this->extfiles = $this->CI->config->item('ext_file');

            $this->extmusic = $this->CI->config->item('ext_music');

            $this->extmisc = $this->CI->config->item('ext_misc');

            $this->basepath = $this->CI->config->item('base_path');

        }

        public function getInfoFile($filename, $file_path)

        {
            $fullPath = $file_path.$filename;

            $obj = new \stdClass();

            $obj->extension = $this->getExtension($filename);

            $obj->size = $this->getSize($fullPath);

            $obj->date = filemtime($fullPath);

            $obj->isfile = is_file($fullPath) ? 1 : 0;

            $onlyDir = $file_path;

            $obj->dir = $onlyDir;

            $obj->path = $onlyDir . $filename;

            if ($obj->isfile) {
                $obj->thumb = $this->getThumb($obj, $fullPath, $filename);

            }

            return $obj;

        }

        public function getFileInfoJson($filename, $file_path)

        {

            return json_encode($this->getInfoFile($filename, $file_path));

        }

        private function getExtension($filename)

        {

            return strtolower(substr(strrchr($filename, '.'), 1));

        }



        private function getSize($file_path)

        {

            return $this->humanFilesize(filesize($file_path));

        }

        private function humanFilesize($bytes, $decimals = 2)

        {

            $sz = 'BKMGTP';

            $factor = floor((strlen($bytes) - 1) / 3);

            return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . (" " . @$sz[$factor] . "B");

        }

        private function getFolderPath($file_path)

        {

            $onlyDir =  substr($file_path, 0, strrpos($file_path, "/") + 1);

            $onlyDir = str_replace(FCPATH . "/", "", $onlyDir);

            return $onlyDir;

        }

        private function getThumb($objectFile, $file_path, $filename)

        {

            $thumb = '';

            if (in_array($objectFile->extension, $this->extimgs)) {

                $thumb = $this->getThumbImage($objectFile, $file_path, $filename);

            } else if (

                $this->isVideoFile($objectFile)

                || $this->isFileFile($objectFile)

                || $this->isMusicFile($objectFile)

                || $this->isMiscFile($objectFile)

            ) {

                $thumb = $this->getDefaultThumb($objectFile, $file_path, $filename);

            } else {

                $thumb = $this->basepath . "theme/admin/images/file.jpg";

            }

            return $thumb;

        }

        private function isFileFile($objectFile)

        {

            return in_array($objectFile->extension, $this->extfiles);

        }

        private function isVideoFile($objectFile)

        {

            return in_array($objectFile->extension, $this->extvideos);

        }

        private function isMusicFile($objectFile)

        {

            return in_array($objectFile->extension, $this->extmusic);

        }

        private function isMiscFile($objectFile)

        {

            return in_array($objectFile->extension, $this->extmisc);

        }

        private function getThumbImage($objectFile, $file_path, $filename)

        {

            $thumb = '';

            $imagedetails = getimagesize($file_path);

            $objectFile->width = $imagedetails[0];

            $objectFile->height = $imagedetails[1];
            if (file_exists(FCPATH . $objectFile->dir . 'thumbs/def/' . $filename)) {

                $thumb = $this->basepath . $objectFile->dir . 'thumbs/def/' . $filename;

            } else {

                $thumb = $this->basepath . $objectFile->dir . $filename;

            }

            return $thumb;

        }

        private function getDefaultThumb($objectFile, $file_path, $filename)

        {

            $thumb = '';

            if (file_exists(FCPATH . "theme/admin/images/ico/" . $objectFile->extension . ".jpg")) {

                $thumb = $this->basepath . "theme/admin/images/ico/" . $objectFile->extension . ".jpg";

            } else {

                $thumb = $this->basepath . "theme/admin/images/file.jpg";

            }

            return $thumb;

        }

    }

}

