/*
 * Created by Dumitrana Alinus
 * User: alin.designstudio
 * For: Media Queries
 * License: Wooter LLC.
 * Date: 2016.01.25
 * Description: Media Queries Helper
 *
 */
__Wooter.factory('MQ', ['$rootScope', function($rootScope){

    /*
     * Detect if is High Density or if is Retina
     *
     * @source http://stackoverflow.com/questions/19689715/what-is-the-best-way-to-detect-retina-support-on-a-device-using-javascript
     */
    var Checks = {
        isHightDensity: function(){
            return ((window.matchMedia && (window.matchMedia('only screen and (min-resolution: 124dpi), only screen and (min-resolution: 1.3dppx), only screen and (min-resolution: 48.8dpcm)').matches || window.matchMedia('only screen and (-webkit-min-device-pixel-ratio: 1.3), only screen and (-o-min-device-pixel-ratio: 2.6/2), only screen and (min--moz-device-pixel-ratio: 1.3), only screen and (min-device-pixel-ratio: 1.3)').matches)) || (window.devicePixelRatio && window.devicePixelRatio > 1.3));
        },
        isRetina: function (){
            return ((window.matchMedia && (window.matchMedia('only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx), only screen and (min-resolution: 75.6dpcm)').matches || window.matchMedia('only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2/1), only screen and (min--moz-device-pixel-ratio: 2), only screen and (min-device-pixel-ratio: 2)').matches)) || (window.devicePixelRatio && window.devicePixelRatio >= 2)) && /(iPad|iPhone|iPod)/g.test(navigator.userAgent);
        },
        //http://stackoverflow.com/questions/11381673/detecting-a-mobile-browser
        isMobile: function() {
            var check = false;
            (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
            return check;
        }
    };

    /*
     * Constructor
     */
    function media (){
        return this.instances
    }

    /*
     * Define Prototype
     */
    var mq = media.prototype;

    /*
     * Run a media query test
     *
     * @param {string} $val
     * @return boolean
     */
    mq.query = function ($val) {
        var clean = mq.Clean.mediaQueryString($val);
        if(clean.type == 'mediaQuery'){
            return mq.Transformer.mediaQueryList(matchMedia(clean.val));
        } else {
            return Checks[clean.val]();
        }
    };

    mq.command = function(st, nd, rd){
        return mq.instances[st](nd);
    };

    /*
     * Transform methods used to clean returns
     */
    mq.Transformer = {

        /*
         * Get return of media check
         *
         * @param value
         * @throw Error:    - Not is a instance of MediaQueryList (1)
         *                  - Browser Don't support media query via javascript (2)
         *
         * @return boolean
         */
        mediaQueryList: function (value){
            if(window.matchMedia && window.MediaQueryList){
                if(value instanceof MediaQueryList){
                    return value.matches;
                } else {
                    throw new Error('Not is a instance of MediaQueryList', 1);
                }
            } else {
                throw new Error('Browser Don\'t support media query via javascript', 2);
            }
        },
        mediaQueryStringCleaner: function (type, val) {
            return {
                type: type,
                val: val
            }
        }

    };

    /*
     * Clean methods to clean and arrange data
     */
    mq.Clean = {
        mediaQueryString: function(str){

            if(typeof str == 'string'){
                var $return;
                var $do = str.toString().toLowerCase();

                if($do == 'retina' || $do == 'isretina' || $do == 'is_retina' || $do == 'is-retina'){
                    $return = mq.Transformer.mediaQueryStringCleaner('not.media', 'isRetina');
                } else if($do == 'mobile' || $do == 'ismobile' || $do == 'is_mobile' || $do == 'is-mobile'){
                    $return = mq.Transformer.mediaQueryStringCleaner('not.media', 'isMobile');
                } else if($do == 'highdensity' || $do == 'ishighdensity' || $do == 'is_highdensity' || $do == 'is-highdensity'){
                    $return = mq.Transformer.mediaQueryStringCleaner('not.media', 'isHighDensity');
                } else {
                    $return = mq.Transformer.mediaQueryStringCleaner('mediaQuery', $do);
                }

                return $return;
            }

        },
        /**
         * Create Media Query string
         * eg object: {
         *      maxWidth: '600px',
         *      "min-width": '200px'
         * } => ' and (max-width: 600px) and (min-width: 200px)'
         * eg array: [
         *      "max-width: 600px",
         *      "min-width: 200px",
         * ] => ' and (max-width: 600px) and (min-width: 200px)'
         * @param t
         * @param v
         * @returns {string}
         */
        arrayOjectToMediaQuery: function(t,v){
            var $render = '';
            var $return = [];
            if(angular.isObject(v)){
                if(count(v) > 0){
                    var k = 0;
                    angular.forEach(v, function(val, key){
                        if(key == parseInt(key) && typeof key == 'number'){
                            $return[k] = val;
                        } else{
                            key = key.split('_').join('-');
                            $return[k] = key.toDash()+': '+val;
                        }
                        k++;
                    });
                }
            }

            console.log($return);

            angular.forEach($return, function(val){
                $render += ' '+t+' ('+val+')';
            });

            return $render.slice(t.length+2);
        }
    };


    mq.instances = angular.extend({}, Checks);
    mq.instances.minHeight = function(n){
        n = (typeof n == 'number')? n+'px' : n;
        return mq.query('(min-height: '+n+')');
    };
    mq.instances.maxHeight = function(n){
        n = (typeof n == 'number')? n+'px' : n;
        return mq.query('(max-height: '+n+')');
    };

    mq.instances.minWidth = function(n){
        n = (typeof n == 'number')? n+'px' : n;
        return mq.query('(min-width: '+n+')');
    };
    mq.instances.maxWidth = function(n){
        n = (typeof n == 'number')? n+'px' : n;
        return mq.query('(max-width: '+n+')');
    };

    mq.instances.print = function(){
        return mq.query('print');
    };
    mq.instances.printAnd = function(v){
        return mq.query('print and '+v);
    };
    mq.instances.screen = function(){
        return mq.query('screen');
    };
    mq.instances.screenAnd = function(v){
        return mq.query('screen and '+v);
    };
    mq.instances.and = function(v){
        var $render = mq.Clean.arrayOjectToMediaQuery('and',v);
        return mq.query($render);
    };
    mq.instances.or = function(v){
        var $render = mq.Clean.arrayOjectToMediaQuery(',',v);
        return mq.query($render);
    };
    mq.instances.orientation = function(v){
        return mq.query('(orientation: '+v+')');
    };
    mq.instances.portrait = function(v){
        return mq.query('(orientation: portrait)');
    };
    mq.instances.landscape = function(v){
        return mq.query('(orientation: landscape)');
    };

    mq.instances.query = mq.query;
    mq.instances.command = mq.command;
    mq.instances.getQuery = mq.Clean.arrayOjectToMediaQuery;

    return new media();
}]);
