<?php

namespace Wooter\Http\Controllers\API;

use Error;
use Exception;
use Illuminate\Http\Request;

use Storage;

use Wooter\Http\Requests;
use Wooter\Http\Controllers\Controller;

class AsseticController extends Controller{

    public function show($type, Request $res){
        if ($this->validateLink($res)) {

            $data = $res->all();

            try {
                $reverse = json_decode($this->getCacheAsset($data['q']), true);

                return $this->fetchFiles($reverse, $type);
            } catch (Exception $e) {
                return abort(404);
            }

        } else {
            return abort(404);
        }
    }

    protected function validateLink($res){
        $data = $res->all();

        try {
            $reverse = $this->getCacheAsset($data['q']);

            if ($reverse) {
                if (is_array(json_decode($reverse, true)) && count(json_decode($reverse, true)) > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }

    }

    protected function fetchFiles($req, $type){
        if ($type == 'css') {
            return $this->cssFiles($req);
        } else {
            return $this->jsFiles($req);
        }
    }

    protected function getPath($type){
        return public_path($type);
    }

    protected function cssFiles($files){
        $cho = '';

        foreach ($files as $key => $file) {
            $tp = $this->getPath('css/').implode('/', explode('.', $file)).'.css';
            if (file_exists($tp)) {
                $data = Storage::disk('local')->get('css/'.implode('/', explode('.', $file)).'.css');
                $cho .= '/*'.$file.'*/';
                $cho .= $data.PHP_EOL;
            } else {
                $cho .= '/* ("'.$file.' -> 404") */';
            }
        }

        return response($cho, 200)->header('Content-Type', 'text/css');
    }

    protected function jsFiles($files){
        $cho = '';

        foreach ($files as $key => $file) {
            $tp = $this->getPath('js/').implode('/', explode('.', $file)).'.js';
            if (file_exists($tp)) {
                $data = Storage::disk('local')->get('js/'.implode('/', explode('.', $file)).'.js');
                $cho .= '//'.$file.PHP_EOL;
                $cho .= $data;
            } else {
                $cho .= 'console.error("'.$file.' -> 404")';
            }
        }

        return response($cho, 200)->header('Content-Type', 'text/javascript');
    }

    /**
     * @param $filename
     * @return mixed
     * @throws Error
     */
    private function getCacheAsset($filename) {
        if(file_exists(cleanSlash(storage_path('/assetic/'.$filename.".json")))){
            return file_get_contents(cleanSlash(storage_path('/assetic/'.$filename.".json")));
        } else {
            throw new Error("Asset cache file don't exist! ({$filename})");
        }
    }

}
