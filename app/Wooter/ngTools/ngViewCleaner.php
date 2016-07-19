<?php
namespace Wooter\Wooter\ngTools;

use Storage;

class ngViewCleaner {

    protected $paths = [
        'default' => 'views/default',
        'tablet' => 'views/tablet',
        'mobile' => 'views/mobile'
    ];

    protected $files = [
        'cache_file' => 'views/views.cache.json'
    ];

    /**
     * return directory files
     *
     * @return array
     */
    public function getFiles(){
        $cache = [];
        $filess = [];

        foreach($this->paths as $key => $path){
            $cache[$key] = Storage::allFiles($path);
        }

        foreach($cache as $key => $files){
            foreach($files as $k => $file){
                $cache[$key][$k] = implode('', explode('views/'.$key.'/', $file));
            }
        }

        foreach($cache as $key => $files){
            foreach($files as $k => $file){
                if(!isset($filess[$file][$key])){
                    $filess[$file][$key] = 0;
                } else {
                    $filess[$file][$key] += 1;
                }
            }
        }

        foreach($filess as $key => $file){
            $filess[$key]['default'] = (isset($file['default']) && is_numeric($file['default']) && $file['default'] >= 0)?true:false;
            $filess[$key]['tablet'] = (isset($file['tablet']) && is_numeric($file['tablet']) && $file['tablet'] >= 0)?true:false;
            $filess[$key]['mobile'] = (isset($file['mobile']) && is_numeric($file['mobile']) && $file['mobile'] >= 0)?true:false;
        }

        if(isset($filess['index.php'])) {
            unset($filess['index.php']);
        }

        return $filess;
    }

    public function caching (){
        return ( Storage::put($this->files['cache_file'], json_encode($this->getFiles())) )?true:false;
    }
}
