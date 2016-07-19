__Wooter.factory('Videos', ['$http', function($http){
    
    var videos = {};
    var $this = videos;

    videos.label;
    videos.album;
    videos.photo;
    /*
     * Get a Videos by id
     * @param league_id
     */
    
    videos.setVideo = function(video) {

                        $this.videos = video;

    };

    videos.setLabel = function(label) {

        $this.label = label;

    };

    videos.setAlbum = function(album) {

        $this.album = album;

    };

    videos.setPhoto = function(photo) {

        $this.photo = photo;

    };

    
    return videos;
     
}]);

