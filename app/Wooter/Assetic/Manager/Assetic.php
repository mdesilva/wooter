<?php

namespace Wooter\Wooter\Assetic\Manager;

use Exception;
use Illuminate\Support\Str;
use Wooter\Exceptions;

/**
 * Class for css/js render link to secure media url
 *
 * @package Assetic
 * @author Alinus (alin.designstudio -> skype)
 **/
class Assetic {

    protected $tpl = '';
    protected $index = null;
    public $renderUrl = '';

    /**
     * Assetic path to cache files;
     * @var string
     */
    private $asseticStore = '';

    /**
     * render link
     *
     * @param $type
     * @param $files
     * @param bool $index
     * @throws Exception
     */
    public function __construct ($type, $files, $index = true){

        $this->index = ($index)?true:false;
        $this->asseticStore = storage_path('/assetic/');

        if (is_string($type)) {
            if ($type == 'css' || $type == 'js') {
                switch ($type) {
                    case 'js':
                        $this->tpl = '<script type="text/javascript" src="url"></script>';
                    break;
                    case 'css':
                        $this->tpl = '<link rel="stylesheet" type="text/css" href="url">';
                    break;
                }
                return $this->render($type, $files);
            } else {
                throw new Exception('First argument need to have value "css" or "js"!');
            }
        } else {
            throw new Exception('First argument need to be only string!');
        }
    }

    /**
     * Cache files, the file will store at /storage/assetic/, and file name will be md5 of the content
     * @param $data
     * @return string
     */
    private function store ($data){
        $data = json_encode($data);
        $filename = md5($data);
        file_put_contents(cleanSlash($this->asseticStore.'/'.$filename.".json"), $data);
        return $filename;
    }

    private function url ($type, $data){
        return route('media', [
            'type' => $type,
            't' => csrf_token(),
            'q' => $data
        ]);
    }

    /**
     * Render the url to asset
     * @param $type
     * @param $data
     * @return mixed
     */
    private function render ($type, $data){
        $data = (is_array($data))?$data:[$data];

        if ($this->index) {
            foreach ($data as $key => $value) {
                $data[$key] = $value.'.index';
            }
        }

        $tpl = $this->tpl;
        $data = $this->store($data);

        $url = $this->url($type, $data);

        $ret = implode($url, explode('url', $tpl));
        $this->renderUrl = $ret;

        return $ret;
    }

    public function __toString(){
        return $this->renderUrl;
    }

}
