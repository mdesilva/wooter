__Wooter.filter('capitalize', function() {
    return function(input, scope) {
        if (input!=null && input!=''){
            input = input.toLowerCase();
            return input.substring(0,1).toUpperCase()+input.substring(1);
        }
    }
});

__Wooter.filter('removeSpaces', [function() {
    return function(string) {
        return (!angular.isString(string))?string:string.replace(/[\s]/g, '');
    };
}]);

__Wooter.filter('distanceRange', function() {
    return function(input, distance) {
        var filteredAmount = [];
        var searchDistance = '';
        angular.forEach(input, function(item){
            var km = Math.ceil(parseInt(item.court_data.DISTANCE));
            var final_val = Math.ceil(km * .6214);
            // if(distance=='' || (final_val <= distance))
            //filteredAmount.push(item);
        });
        return filteredAmount.length>0 ? filteredAmount : input
    };
});

__Wooter.filter('startFrom', function () {
    return function (input, start) {
        if (input) {
            start = +start;
            return input.slice(start);
        }
        return [];
    };
});

__Wooter.filter('startFrom', function () {
    return function (input, start) {
        if (input) {
            start = +start;
            return input.slice(start);
        }
        return [];
    };
});

(function() {
    'use strict';
    __Wooter.filter('CourtFilter', CourtFilter);
    CourtFilter.$inject = ['$window'];
    function CourtFilter($window) {
        return function(dataArray, searchObj) {
            if (!dataArray) {
                return;
            } else if (!searchObj) {
                return dataArray;
            } else {
                return dataArray.filter(function(item) {
                    var createdAt = $window.moment(item.createdAt);
                    var result = true;
                    if (searchObj.date) {
                        var searchDate = $window.moment(searchObj.date);
                        result = (createdAt.dayOfYear() === searchDate.dayOfYear()) && (createdAt.year() === searchDate.year());
                    }
                    if (result && searchObj.start && searchObj.end) {
                        var startDate = $window.moment(new Date()), endDate = $window.moment(new Date());
                        startDate = startDate.hour(parseInt(searchObj.start.value, 10));
                        endDate = endDate.hour(parseInt(searchObj.end.value, 10));
                        startDate = startDate.minute((startDate.hour() < searchObj.start.value) ? 30 : 0);
                        endDate = endDate.minute((endDate.hour() < searchObj.end.value) ? 30 : 59);
                        result = (startDate.hour() <= createdAt.hour()) && (createdAt.hour() <= endDate.hour()) &&
                            (startDate.minute() <= createdAt.minute()) && (createdAt.minute() <= endDate.minute());
                    }
                    return result;
                });
            }
        };
    }
})();

(function() {
    'use strict';
    __Wooter.filter('ItemFilter', ItemFilter);
    ItemFilter.$inject = ['$window'];
    function ItemFilter($window) {
        return function(dataArray, searchObj, propertyNames) {
            if (!dataArray) {
                return;
            } else if (!searchObj || !propertyNames) {
                return dataArray;
            } else {
                var term = searchObj.searchText.toLowerCase();
                return dataArray.filter(function(item) {
                    var result = true;
                    if (searchObj.selectedGender) {
                        result = !(item.gender !== 'MF' && searchObj.selectedGender.value.indexOf(item.gender) === -1);
                    }
                    if (result) {
                        if (searchObj.selectAgeRange) {
                            if (searchObj.fromAge && searchObj.toAge) {
                                result = (searchObj.fromAge <= item.age) && (item.age <= searchObj.toAge);
                            }
                        } else {
                            if (searchObj.selectedAgeGroup) {
                                var min = $window._.min(searchObj.selectedAgeGroup, function(ag) {
                                    return getMinVal(ag.value);
                                });
                                var max = $window._.max(searchObj.selectedAgeGroup, function(ag) {
                                    return getMaxVal(ag.value);
                                });
                                if (min.value && max.value){
                                    var fromAge = getMinVal(min.value);
                                    var toAge = getMaxVal(max.value);
                                    result = (fromAge <= item.age) && (item.age <= toAge);
                                }
                            }
                        }
                    }
                    if (result && searchObj.selectedDistance) {
                        result = !(searchObj.selectedDistance.value > item.distance);
                    }
                    if (result && term) {
                        var termMatch = false;
                        angular.forEach(propertyNames, function(name) {
                            termMatch = termMatch || item[name].toLowerCase().indexOf(term) > -1;
                        });
                        result = result && termMatch;
                    }
                    return result;
                });
            }
        };

        function getMinVal(value) {
            if (value.indexOf('+') !== -1) { return 18; }
            if (value.indexOf('-') !== -1) {
                value = value.split('-')[0];
            }
            return parseInt(value, 10);
        }

        function getMaxVal(value) {
            if (value.indexOf('+') !== -1) { return Number.MAX_SAFE_INTEGER; }
            if (value.indexOf('-') !== -1) {
                value = value.split('-')[1];
            }
            return parseInt(value, 10);
        }
    }
})();

__Wooter.filter('vidoeLabelFilter', function () {
    return function (videos, label) {
        if(label == "0")
        {
                return videos;
        }else{
                var tempVideos = [];
                angular.forEach(videos, function (video) {
                if (video.label_id == label) {
                    tempVideos.push(video);
                }
            });
            return tempVideos;
        }
    };
});

__Wooter.filter('leagueGameFilter', function () {
    return function (videos, game) {
        if(game == "0")
        {
            return videos;
        }else{
            var tempVideos = [];
            angular.forEach(videos, function (video) {
                if (video.game_id == game) {
                    tempVideos.push(video);
                }
            });
            return tempVideos;
        }
    };
});


__Wooter.filter('photoAlbumFilter', function () {
    return function (photos, album) {
        if(album == "0")
        {
            return photos;
        }else{
            var tempPhotos = [];
            angular.forEach(photos, function (photo) {
                if (photo.album_id == album) {
                    tempPhotos.push(photo);
                }
            });
            return tempPhotos;
        }
    };
});

__Wooter.filter('photoDivisionFilter', ['Leagues', function (Leagues) {

    return function (photos, division) {

        teams =Leagues.loadLeagueTeams();

        if(division == "0")
        {
            return photos;
        }else{
            var tempPhotos = [];
            angular.forEach(photos, function (photo) {
                angular.forEach(photo.tagTeams, function (teamId) {
                    angular.forEach(teams, function (team) {
                        if(team.id == teamId && team.division[0].id == division )
                        {
                            tempPhotos.push(photo);
                        }
                    });
                });
            });
        return tempPhotos;
        }
    };
}]);

__Wooter.filter('photoTeamFilter', function () {
    return function (photos, team) {
        if(team == "0")
        {
            return photos;
        }else{
            var tempPhotos = [];
            angular.forEach(photos, function (photo) {
                angular.forEach(photo.tagTeams, function (teamId) {
                    if (teamId == team) {
                        tempPhotos.push(photo);
                    }
                });
            });
            return tempPhotos;
        }
    };
});

__Wooter.filter('dateFormat', function () {
    return function(input, splitter) {
        if(input)
        {
            input = input.split(splitter);
            return input[0];
        }
    };
});

__Wooter.filter('unique', function() {
    return function (arr, field) {
        return _.uniq(arr, function(a) { return a[field]; });
    };
});

__Wooter.filter('carbonToMMM', function($filter) {
    return function(text){

        if (text !== undefined) {
            var  tempdate= new Date(text.replace(/-/g,"/"));

            return $filter('date')(tempdate, "MMM");
        }
    }
});

__Wooter.filter('carbonToyyyy', function($filter) {
    return function(text){

        if (text !== undefined) {
            var  tempdate= new Date(text.replace(/-/g,"/"));
            return $filter('date')(tempdate, "yyyy");
        }
    }
});

__Wooter.filter('monthNameLong', [function() {
    return function (monthNumber) { //1 = January
        var monthNames = [ 'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December' ];
        return monthNames[monthNumber - 1];
    }
}]);

__Wooter.filter('monthNameShort', [function() {
    return function (monthNumber) { //1 = January
        var monthNames = [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Augt', 'Sep', 'Oct', 'Nov', 'Dec' ];
        return monthNames[monthNumber - 1];
    }
}]);

__Wooter.filter('limitString', function () {
    return function (value, wordwise, max, tail) {
        if (!value) return '';

        max = parseInt(max, 10);
        if (!max) return value;
        if (value.length <= max) return value;

        value = value.substr(0, max);
        if (wordwise) {
            var lastspace = value.lastIndexOf(' ');
            if (lastspace != -1) {
                //Also remove . and , so its gives a cleaner result.
                if (value.charAt(lastspace-1) == '.' || value.charAt(lastspace-1) == ',') {
                    lastspace = lastspace - 1;
                }
                value = value.substr(0, lastspace);
            }
        }

        return value + (tail || ' …');
    };
});





