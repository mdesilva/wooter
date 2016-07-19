<?php 
namespace Wooter\Wooter\Assetic\Loader;

use Exception;
use Illuminate\Support\Facades\Storage;
use Wooter\Exceptions;

/**
 * Class for css/js render link to secure media url with front app files (angular controllers, directives factories)
 *
 * @package Assetic
 * @author Alinus (alin.designstudio -> skype)
 **/
class AsseticLoader {

    const EXTENSION = 'js';
    const EXCLUDER = 'ex_';

    private $angularDir = 'js/app';
    private $appDir = 'app';
    private $dirs = [];
    private $needle = '';
    private $types = [];
    public $excluded = [];
    public $files = [];

    /**
     * @var string
     */
    private $renderUrl = '';

    public function __construct ($type){
        $this->dirs = Storage::allDirectories($this->angularDir);
        $this->types = $this->getTypes();
        $this->needle = $type;

        if ($type != '*') {
            $search = array_search($type, $this->types);
            if (is_numeric($search) && $search >= 0) {
                $this->files = $this->getFiles();
                $render = assetic(self::EXTENSION, $this->files, false);
                return $render->renderUrl;
            } else {
                throw new Exception("Sorry this can't load \"$type\", this folder doesn't exist!");
            }
        }
    }

    private function getTypes(){
        $tmp = [];
        $types = [];
        foreach ($this->dirs as $value) {
            $key = explode('/', substr(implode('', explode($this->angularDir, $value)), 1))[0];
            $tmp[$key] = 1;
        }
        foreach ($tmp as $key => $value) {
            $types[] = $key;
        }
        return $types;
    }

    private function excluder($file){
        $dispatch = explode('/', $file);
        $ex_index = true;

        foreach ($dispatch as $key => $value) {
            if (substr($value, 0, strlen(self::EXCLUDER)) == self::EXCLUDER) {
                $ex_index = false;
                $this->excluded[] = $file;
                break;
            }
        }

        return $ex_index;
    }

    private function getFiles($type = null){
        $type = (is_null($type))?$this->needle:$type;
        $dir = $this->angularDir.'/'.$type.'/';

        $files = Storage::allFiles($dir);
        foreach ($files as $key => $value) {
            $file = implode('', explode($dir, $value));

            $dispatch = explode('.', $file);
            $ext = end($dispatch);

            if ($ext != self::EXTENSION) {
                unset($files[$key]);
            } else {
                if ($this->excluder($file)) {
                    $tpfile = $this->appDir.'/'.$type.'/'.$file;

                    if (file_exists(public_path('js').'/'.$tpfile)) {
                        $files[$key] = substr(implode('.', explode('/', $tpfile)), 0, ((strlen(self::EXTENSION)+1)*(-1)));
                    } else {
                        unset($files[$key]);
                    }
                } else {
                    unset($files[$key]);
                }
            }

        }

        return $files;
    }

    public function caching(){
        $types = $this->types;
        $files = [];
        foreach ($types as $key => $value) {
            foreach ($this->getFiles($value) as $val) {
                $files[] = $val;
            }
        }

        return Storage::put('config/assets/app.json', json_encode($files));
    }

    public function __toString(){
        $render = assetic(self::EXTENSION, $this->files, false);
        return $render->renderUrl;
    }

}
