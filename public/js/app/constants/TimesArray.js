/**
 * Created by Dumitrana Alinus
 * User: alin.designstudio
 * For: Courts app
 * License: Wooter LLC.
 * Date: 2016.03.01
 * Description: Times Array used in courts app
 *
 */

function createTimesArray (s, start_x, end_x){
    var $times = [];
    start_x = (angular.isDefined(start_x))?start_x:6;
    end_x = (angular.isDefined(end_x))?end_x:23.5;
    /**
     * return Hour by value of i
     * @param i
     * @returns {number}
     */
    var getHourByI = function(i){
        if(parseInt(i) <= 24){ return ( i > 12 )?parseInt(i)-12:i; } else { throw new Error('Invalid Value! '); }
    };

    /**
     * Return AM or PM based on hour
     *
     * @param i
     * @returns {string}
     */
    var getAmPm = function(i){ return (( i >= 12 )?"pm":'am').toUpperCase(); };

    var getName = function(i, b){
        var time = i.toString().split('.');
        return tpl("{H}:{M} {md}", {
            H: (getHourByI(time[0]) < 10 && b)?'0'+getHourByI(time[0]):getHourByI(time[0]),
            M: (time[1])?'30':'00',
            md: getAmPm(time[0])
        });
    };

    var getRange = function(i){
        var name1 = getName(i, true).split(' ').join('').toLowerCase();
        var name2 = getName(i+s, true).split(' ').join('').toLowerCase();
        return tpl('{n1} - {n2}', { n1: name1, n2: name2 })
    };

    for(var i = start_x; i<= end_x; i+=s){
        $times.push({
            name: getName(i),
            value: i,
            range: getRange(i),
            start: i,
            end: i+s,
            index: count($times)
        });
    }

    return $times;
}

/**
 * Get array with hours
 * @param a return object of (createTimesArray())
 */
function getTimesArrayHour(a){
    var $times = [];

    angular.forEach(a, function(value){
       $times.push(value.name);
    });

    return $times;
}

__Wooter.constant('TimesArray', createTimesArray(0.5));
__Wooter.constant('TimesArrayHour,', createTimesArray(1));
__Wooter.constant('TimesArray1', getTimesArrayHour(createTimesArray(0.5)));
__Wooter.constant('DayHours', getTimesArrayHour(createTimesArray(0.5, 0, 23.5)));
