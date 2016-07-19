<?php
namespace Wooter\Wooter\ngTools;

use Storage;

class ngTools {

    protected $paths = [
        'controller' => 'js/app/controllers',
        'directive' => 'js/app/directives',
        'factory' => 'js/app/factories',
        'function' => 'js/app/functions',
        'styles' => 'scss',
        'styleFile' => 'scss/style.scss',
        'app' => 'js/app/app',
        'route' => 'js/app/routes'
    ];

    /**
     *
     * Helper to get the template from stub file
     * Stubs are stored into /app/Console/Commands/stubs
     *
     * @author Alinus (alin.designstudio@gmail.com)
     * @param string $name
     * @return null|string
     */
    public function stub($name){
        // TODO: apply name and user name via env data
        $name = (substr($name, 0, 1) == '/')?substr($name, 1):$name;
        $name = implode('', explode('.stub', $name));

        $stub = base_path('/app/Console/Commands/stubs/'.$name.'.stub');

        if (file_exists($stub)) {
            $return = file_get_contents($stub);
        } else {
            $return = null;
        }

        return $return;
    }

    /**
     *
     * Helper to clean the name file
     * eg:
     * - input: path.to.file or path/to/file and ext='.js'
     * - output: path/to/file.js
     *
     * @author Alinus (alin.designstudio@gmail.com)
     * @param string $name
     * @param string $ext
     * @return string
     */
    public function cleaner($name, $ext = '.js'){
        $name = (substr($name, 0, 1) == '/')?substr($name, 1):$name;
        $name = implode('', explode($ext, $name));
        $name = implode('/', explode('.', $name));
        return $name;
    }

    /**
     *
     * Helper to capitalize the name file
     * eg:
     * - input: path/to/file.js
     * - output: Path/To/File.js
     *
     * - input: path/to/file
     * - output: Path/To/File
     *
     * @author Alinus (alin.designstudio@gmail.com)
     * @param string $name
     * @return string
     */
    public function capitalizer($name){
        $tpname = explode('/', $name);
        foreach($tpname as $key => $val){
            $tpname[$key] = ucfirst($tpname[$key]);
        }
        $tpname = implode('/', $tpname);
        return $tpname;
    }

    /**
     *
     * Helper to get last name of file
     * eg:
     * - input: path/to/file.js
     * - output: file.js
     *
     * - input: path/to/file
     * - output: file
     *
     * @author Alinus (alin.designstudio@gmail.com)
     * @param string $filename
     * @return string
     */
    public function getName ($filename){
        $names = explode('/', $filename);
        return end($names);
    }

    /**
     * Helper to create Angular Controller
     * Will store into /public/js/app/controller/
     *
     * eg: path/to/theController
     * output: angular controller to /public/js/app/controller/Path/To/TheController.js
     *
     * @author Alinus (alin.designstudio@gmail.com)
     * @param string $name
     * @return string
     */
    public function controller($name){
        $name = $this->cleaner($name);
        $tpname = $this->capitalizer($name);

        $tpl = $this->stub('ngController');

        if(!is_null($tpl)){
            $render = tpl($tpl, ['name' => $tpname, 'date' => date('Y.m.d')]);

            $file = $this->paths['controller'].'/'.$tpname.'.js';

            $path = implode('/', explode('\\', public_path($file)));

            if(!file_exists($path)){
                $stored = Storage::put($file, $render);

                if ($stored) {
                    return "    Good Job, Controller created successfully check :)".PHP_EOL."    $path".PHP_EOL.PHP_EOL."    Controller Name is '$tpname'";
                } else {
                    return 'Sorry ... your controller don\'t created ... try again! :( ';
                }
            } else {
                return "    This Angular Controller ($tpname) exist! ".PHP_EOL."    Check $path";
            }

        } else {
            return "    The template file for angular Controller don't exist! ".PHP_EOL."    Check ".base_path('app/Console/Commands/stubs/ngController.stub');
        }
    }

    /**
     * Helper to create Angular Factory
     * Will store into /public/js/app/factories/
     *
     * eg: path/to/theFactory
     * output: angular controller to /public/js/app/factories/Path/To/TheFactory.js
     *
     * @author Alinus (alin.designstudio@gmail.com)
     * @param string $name
     * @return string
     */
    public function factory($name){
        $name = $this->cleaner($name);
        $theName = $this->getName($name);
        $tpname = $this->capitalizer($name);

        $tpl = $this->stub('ngFactory');

        if(!is_null($tpl)){
            $render = tpl($tpl, ['name' => $theName, 'date' => date('Y.m.d')]);

            $file = $this->paths['factory'].'/'.$tpname.'.js';

            $path = implode('/', explode('\\', public_path($file)));

            if(!file_exists($path)){
                $stored = Storage::put($file, $render);

                if ($stored) {
                    return "    Good Job, Factory created successfully check :)".PHP_EOL."    $path".PHP_EOL.PHP_EOL."    Factory Name is '$theName'";
                } else {
                    return 'Sorry ... your Factory don\'t created ... try again! :( ';
                }
            } else {
                return "    This Angular Factory ($theName) exist! ".PHP_EOL."    Check $path";
            }

        } else {
            return "    The template file for angular Factory don't exist! ".PHP_EOL."    Check ".base_path('app/Console/Commands/stubs/ngFactory.stub');
        }
    }

    /**
     * Helper to create Angular Directive
     * Will store into /public/js/app/directives/
     *
     * eg: path/to/theDirective
     * output: angular controller to /public/js/app/directive/Path/To/TheDirective.js
     *
     * @author Alinus (alin.designstudio@gmail.com)
     * @param string $name
     * @return string
     */
    public function directive($name){
        $name = $this->cleaner($name);
        $theName = $this->getName($name);
        $tpname = $this->capitalizer($name);

        $tpl = $this->stub('ngDirective');

        if(!is_null($tpl)){
            $render = tpl($tpl, ['name' => $theName, 'date' => date('Y.m.d')]);

            $file = $this->paths['directive'].'/'.$tpname.'.js';

            $path = implode('/', explode('\\', public_path($file)));

            if(!file_exists($path)){
                $stored = Storage::put($file, $render);

                if ($stored) {
                    return "    Good Job, Directive created successfully check :)".PHP_EOL."    $path".PHP_EOL.PHP_EOL."    Directive Name is '$theName'";
                } else {
                    return 'Sorry ... your Directive don\'t created ... try again! :( ';
                }
            } else {
                return "    This Angular Directive ($theName) exist! ".PHP_EOL."    Check $path";
            }

        } else {
            return "    The template file for angular Directive don't exist! ".PHP_EOL."    Check ".base_path('app/Console/Commands/stubs/ngDirective.stub');
        }
    }

    /**
     * Helper to create App Function
     * Will store into /public/js/app/functions/
     *
     * eg: path/to/theFunction
     * output: angular controller to /public/js/app/functions/Path/To/TheFunction.js
     *
     * @author Alinus (alin.designstudio@gmail.com)
     * @param string $name
     * @return string
     */
    public function appFunction($name){
        $name = $this->cleaner($name);
        $theName = $this->getName($name);
        $tpname = $this->capitalizer($name);

        $tpl = $this->stub('appFunction');

        if(!is_null($tpl)){
            $render = tpl($tpl, ['name' => $theName, 'date' => date('Y.m.d')]);

            $file = $this->paths['function'].'/'.$tpname.'.js';

            $path = implode('/', explode('\\', public_path($file)));

            if(!file_exists($path)){
                $stored = Storage::put($file, $render);

                if ($stored) {
                    return "    Good Job, Function created successfully check :)".PHP_EOL."    $path".PHP_EOL.PHP_EOL."    Function Name is '$theName'";
                } else {
                    return 'Sorry ... your Function don\'t created ... try again! :( ';
                }
            } else {
                return "    This Angular Function ($theName) exist! ".PHP_EOL."    Check $path";
            }

        } else {
            return "    The template file for angular Function don't exist! ".PHP_EOL."    Check ".base_path('app/Console/Commands/stubs/appFunction.stub');
        }
    }

    /**
     * Helper to create App Style
     * Will store into /public/scss/styles
     *
     * eg: path/to/theStyle
     * output: angular controller to /public/scss/styles/Path/To/theStyle.scss
     *
     * !!!!! this will be auto added into /public/scss/style.scss !!!!!
     *
     * @author Alinus (alin.designstudio@gmail.com)
     * @param string $name
     * @return string
     */
    public function appStyle($name){
        $name = $this->cleaner($name, '.scss');
        $theName = $this->getName($name);
        $tpname = $name;

        $tpl = $this->stub('appStyle');

        if(!is_null($tpl)){
            $render = tpl($tpl, ['name' => $theName, 'date' => date('Y.m.d')]);

            $file = $this->paths['styles'].'/'.$tpname.'.scss';

            $path = implode('/', explode('\\', public_path($file)));

            if(!file_exists($path)){
                $stored = Storage::put($file, $render);

                if ($stored) {
                    return "    Good Job, Style created successfully check :)".PHP_EOL."    $path".PHP_EOL.PHP_EOL."    Style Name is '$theName'";
                } else {
                    return 'Sorry ... your Style don\'t created ... try again! :( ';
                }
            } else {
                return "    This Angular Style ($theName) exist! ".PHP_EOL."    Check $path";
            }

        } else {
            return "    The template file for angular Style don't exist! ".PHP_EOL."    Check ".base_path('app/Console/Commands/stubs/appStyle.stub');
        }
    }

}
