<?php

namespace Wooter\Http\Controllers\API\Files;

use Illuminate\Http\Request;

use Exception;
use Storage;

use Wooter\Http\Requests;
use Wooter\Http\Controllers\Controller;

/**
 * @api {get} api/svg/:file/:fromColor/:toColor Request a modifed svg file
 * @apiName GetSVG
 * @apiGroup Files
 *
 * @apiParam {string} file Path to the svg file.
 * @apiParamExample {string} Example get file:
 *      api/svg/icons.leagues.person
 *
 * @apiParam {string} fromColor Color who will be replaced
 * @apiParamExample {string} Example get file with other color (default color are #000):
 *      api/svg/icons.leagues.person/00adf2
 *
 * @apiParam {string} toColor Color who will be stored instead fromColor
 * @apiParamExample {string} Example get file with all colors #fff changed to #00adf2:
 *      api/svg/icons.leagues.person/fff/00adf2/
 *
 * @apiSuccess {String} firstname Firstname of the User.
 * @apiSuccess {String} lastname  Lastname of the User.
 */

class SVG extends Controller{

    /**
     * Primary method to get svg file and control color
     *
     * @param string $svg The path eg: icons.leagues.person (this mean file /public/img/svg/icons/leagues/person.svg
     * @param string $from color who need to change
     * @param string $to color who need to replace
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getSVG($svg, $from = null, $to = null){
        return response($this->svg($svg, $from, $to), 200, [
            'Content-Type'=>'image/svg+xml'
        ]);
    }

    /**
     * Function to get and manipulate svg file
     *
     * @param string $f Content of file
     * @param string $fc From color
     * @param string $tc To color
     * @return string
     * @throws Exception
     */
    private function svg($f, $fc, $tc){
        return $this->setColor($this->getFile($f), $fc, $tc);
    }


    /**
     * Get svg file
     *
     * @param string $f File path to svg
     * @return string
     * @throws Exception
     */
    private function getFile($f) {
        $ff = $this->dispatchFile($f, true);
        $f = $this->dispatchFile($f, false);
        if(file_exists($f)){
            return svg($ff);
        } else {
            throw new Exception('File Don\'t exist!');
        }
    }

    /**
     * Function to replace color from svg
     *
     * @param string $f
     * @param string $fc
     * @param string $tc
     * @return string
     */
    private function setColor($f, $fc, $tc) {
        if(!is_null($fc) && !is_null($tc)){
            $fc = implode('#', explode('##', '#'.$fc));
            $tc = implode('#', explode('##', '#'.$tc));
            return implode($tc, explode($fc, $f));
        } else {
            return $f;
        }
    }

    /**
     * Function to render the real url
     *
     * @param string $f The path file
     * @param bool $s Condition to render absolute url (using base_path()) or relative url
     * @return string
     */
    private function dispatchFile($f, $s = true) {
        $f = implode('', explode('.svg', $f));
        $f = implode('/', explode('.', $f));

        while(count(explode('//', $f)) > 1){
            $f = implode('/', explode('//', $f));
        }

        $f = $f.'.svg';
        $f = (!$s)?base_path('public/img/svg/'.$f):$f;
        return $f;
    }
}
