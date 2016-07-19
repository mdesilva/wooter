/**
 * Created by Shams Hashmi on 26-04-2016.
 */
'use strict';
( function( $, window, document, undefined, $stateParams ) {

    if($("#addVideoModal").length > 0){

    var movieData = [];
    var scope = angular.element($("#addVideoModal")).scope();


    var getJWTToken = function () {
        return ($$store.local.check('satellizer_token')) ? $$store.local.get('satellizer_token') : null;
    };

    var r = new Resumable({
        target: 'api/leagues/' + scope.leagueId + '/videos',
        fileParameterName: 'video',
        chunkSize:  1 * 1024 * 1024,
        simultaneousUploads: 5,
        testChunks: false,
        throttleProgressCallbacks: 3,
        maxFiles: 3,
        maxChunkRetries: 2,
        prioritizeFirstAndLastChunk: true,
        headers: {"Authorization": "Bearer " + getJWTToken()},
        query: {league_id: scope.leagueId}
    });

    $('#btn_cancel').click(function () {
        if (r.files.length > 0) {
            if (r.isUploading()) {
                r.cancel();
                scope.cancel();
            } else {
                if (r.progress()) {
                    scope.cancel();
                }
                scope.cancel();
            }
        }
        scope.cancel();
    });
    // Resumable.js isn't supported, fall back on a different method
    if (!r.support) {
        $('.resumable-error').show();
    } else {
        // Show a place for dropping/selecting files
        $('.resumable-drop').show();
        r.assignDrop($('.resumable-drop')[0]);
        r.assignBrowse($('.resumable-browse')[0]);

        // Handle file add event
        r.on('fileAdded', function (file) {
            $('.resumable-progress, .resumable-list').show();
            r.upload();
        });
        r.on('pause', function () {
            // Show resume, hide pause
            $('.resumable-progress .progress-resume-link').show();
            $('.resumable-progress .progress-pause-link').hide();
        });
        r.on('complete', function () {

            scope.loadVideos();
            scope.$apply(function () {

                scope.movies = movieData;
                //scope.labels = scope.loadCategories();

            });
            // Hide pause/resume when the upload has completed
            $('.resumable-progress, .resumable-list').hide();

        });
        r.on('fileSuccess', function (file, message) {
            var data = JSON.parse(message);
            movieData.push(data.data);
            // Reflect that the file upload has completed
            $('.resumable-file-' + file.uniqueIdentifier + ' .resumable-file-progress').html('(completed)');
        });
        r.on('fileError', function (file, message) {
            // Reflect that the file upload has resulted in error
            $('.resumable-file-' + file.uniqueIdentifier + ' .resumable-file-progress').html('(file could not be uploaded: ' + message + ')');
        });
        r.on('fileProgress', function (file) {
            // Handle progress for both the file and the overall upload
            $('.resumable-file-' + file.uniqueIdentifier + ' .resumable-file-progress').html(Math.floor(file.progress() * 100) + '%');
            $('.progress-bar').css({width: Math.floor(r.progress() * 100) + '%'});
        });
        r.on('cancel', function () {
            $('.resumable-file-progress').html('canceled');
        });

    }

}

})( jQuery, window, document );