function init_league_page(){
    console.log('Page Initialized!');
    var k = 0;
    var $video = {
        imageTemplate: {
            youtube: 'https://i1.ytimg.com/vi/{id}/sddefault.jpg',
            vimeo: 'https://i.vimeocdn.com/video/{id}_640.jpg'
        },
        embedTpl: {
            vimeo: '<iframe class="embed-responsive-item" src="https://player.vimeo.com/video/{id}?autoplay=1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>',
            youtube: '<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{id}?autoplay=1" frameborder="0" allowfullscreen></iframe>'
        },
        typeVideo: function(video){
            var $tp = false;
            if (video.toLowerCase().indexOf("youtube") > -1){ $tp = 'youtube' }
            if (video.toLowerCase().indexOf("vimeo") > -1){ $tp = 'vimeo' }
            return $tp;
        },
        getID: function(type, link){
            var id;
            if (type == 'vimeo') {
                var vimregex = /^.*(vimeo\.com\/)((channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/))?([0-9]+)/;
                var match = vimregex.exec(link);
                id = match[5];
            } else {
                var ytregex = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
                var match = ytregex.exec(link);
                id = (match&&match[7].length==11)?match[7]:false;
            }
            return id;
        },
        getImage: function(link){
            var type = $video.typeVideo(link);
            return tpl($video.imageTemplate[type], {id: $video.getID(type, link)});
        },
        getIframe: function (v) {
            var t = $video.typeVideo(v);
            var i = $video.getID(t,v);
            return tpl($video.embedTpl[t], {id: i});
        }
    };

    /**
     * Slide templates
     * @type {{photo: string}}
     */
    var Template = {
        photo: '<div class="item"><a href="#" style="background-image: url({thumb});" class="image flex-image" data-flex-image="{full_image}"></a></div>',
        video: '<div class="item"><a href="#" style="background-image: url({image});" class="image flex-image" data-flex-video="{video}"></a></div>',
        photo_flex: '<div class="flexbox-holder {class} overlay"><div class="flexbox"><a href="javascript:void(0)" class="fa fa-remove flexbox-close"></a><div class="wrapper"><div class="image lazy-image red"><img src="{img}" onload="resizeImage(this)" alt="Image"></div></div></div></div>',
        video_flex: '<div class="flexbox-holder video {class} overlay"><div class="flexbox"><a href="javascript:void(0)" class="fa fa-remove flexbox-close"></a><div class="wrapper-video">{iframe}</div></div></div>'
    };

    /**
     * Items number
     *
     * @type {{photo: number, video: number}}
     */
    var items = {
        photo: 4,
        video: 3
    };


    /**
     * Define roots
     */
    var photoSlider = function(){
        return $('.photo-slider .slider-holder');
    };
    var videoSlider = function(){
        return $('.video-slider .slider-holder');
    };

    /**
     * Methods to get Elements
     */
    var $get = {
        photo:{
            slideButtons:{
                next: function(){
                    return $(document).find('.photo-slider .slider-control.next-slide');
                },
                prev: function(){
                    return $(document).find('.photo-slider .slider-control.preview-slide');
                }
            }
        },
        video:{
            slideButtons:{
                next: function(){
                    return $(document).find('.video-slider .slider-control.next-slide');
                },
                prev: function(){
                    return $(document).find('.video-slider .slider-control.preview-slide');
                }
            }
        }
    };

    $$store.session.create('photo.slider', $$store.session.get('slides_request'));
    $$store.session.create('video.slider', videoSlider().attr('data-slides'));
    /**
     * Methods to get slides from data-slides of slider holder
     * @type {{photo: (Object|Array|string|number), video: Array}}
     */
    var slides = {
        photo: function () {
            return ($$store.session.check('photo.slider'))?angular.fromJson($$store.session.get('photo.slider')):[];
        },
        video: function () {
            return ($$store.session.check('video.slider'))?angular.fromJson($$store.session.get('video.slider')):[];
        }
    };

    /**
     * Remove data-slides attribute and disable preview button
     */
    videoSlider().removeAttr('data-slides');
    $get.photo.slideButtons.prev().attr('disabled', 'disabled');
    $get.video.slideButtons.prev().attr('disabled', 'disabled');

    /**
     * If number of slides.photo() are smaller than number of slides remove control buttons
     */
    if(count(slides.photo()) <= items.photo){
        $get.photo.slideButtons.prev().attr('disabled', 'disabled');
        $get.photo.slideButtons.next().attr('disabled', 'disabled');
    }
    /**
     * If number of slides.video() are smaller than number of slides remove control buttons
     */
    if(count(slides.video()) <= items.video){
        $get.video.slideButtons.prev().attr('disabled', 'disabled');
        $get.video.slideButtons.next().attr('disabled', 'disabled');
    }

    /**
     * If no slides, remove photo, video section
     */
    if(!count(slides.photo()) > 0){photoSlider().parents('section, .section').remove()}
    if(!count(slides.video()) > 0){videoSlider().parents('section, .section').remove()}

    /**
     * Adding photo, video slides fetched from data-slides attribute of ".photo-slider .slider-holder" element
     */
    angular.forEach(slides.photo(), function(value){ photoSlider().append(tpl(Template.photo, {thumb: value.thumbnail_path, full_image: value.file_path})) });
    angular.forEach(slides.video(), function(value){ videoSlider().append(tpl(Template.video, {image: $video.getImage(value.video), video: value.video})) });

    /**
     * Because angular method to add scripts on page we need to create a interval who will do initialize actions.
     * Interval will stop if the condition are passed
     *
     * @type {number}
     */
    var owlChecker = setInterval(function(){
        /**
         * The code will execute only if owlCarousel are defined, are a function and number of slides.photo() are bigger than 0
         */
        if(angular.isDefined($.fn.owlCarousel) && angular.isFunction($.fn.owlCarousel) && count(slides.photo()) > 0){

            /**
             * Define the Carousels
             */
            photoSlider().owlCarousel({ loop: false, margin: 12, nav: false, pagination: false, items: items.photo });
            videoSlider().owlCarousel({ loop: false, margin: 12, nav: false, pagination: false, items: items.video });

            /**
             * Get Api of Owl Carousel
             * @type {{api: {photos: *}}}
             */
            var Slider = {
                api: {
                    photos: photoSlider().data('owlCarousel'),
                    videos: videoSlider().data('owlCarousel')
                }
            };

            /**
             * Event to control Buttons states, show/hide
             */
            photoSlider().on('changed.owl.carousel', function(e){
                var now = Slider.api.photos._current;
                var max = count(slides.photo()) - items.photo;
                if(now != 0){
                    $get.photo.slideButtons.prev().removeAttr('disabled');
                    if(now < max){
                        $get.photo.slideButtons.next().removeAttr('disabled');
                    } else {
                        $get.photo.slideButtons.next().attr('disabled', 'disabled');
                    }
                } else {
                    $get.photo.slideButtons.prev().attr('disabled', 'disabled');
                }
            });
            videoSlider().on('changed.owl.carousel', function(e){
                var now = Slider.api.videos._current;
                var max = count(slides.video()) - items.video;
                if(now != 0){
                    $get.video.slideButtons.prev().removeAttr('disabled');
                    if(now < max){
                        $get.video.slideButtons.next().removeAttr('disabled');
                    } else {
                        $get.video.slideButtons.next().attr('disabled', 'disabled');
                    }
                } else {
                    $get.video.slideButtons.prev().attr('disabled', 'disabled');
                }
            });

            /**
             * Click events for next, prev buttons
             */
            $(document).on('click', '.slider-control', function(e){
                e.preventDefault();
                var controlRAW = $(this).attr('data-control');
                var control = controlRAW.split(':');
                var api = control[0];
                var action = control[1];
                Slider.api[api][action]();
                return false;
            });

            /**
             * Flexbox closer
             *
             * @param e
             * @param fl
             * @returns {boolean}
             */
            function closer (e, fl){
                e.preventDefault();
                if( $(e.target).hasClass('flexbox-close') || $(e.target).hasClass('overlay') || (e.keyCode && e.keyCode == 27) ){
                    $(fl).fadeOut(300, function () {
                        $(fl).remove();
                        $(document).find('body').removeClass('no-scroll');
                        $(document).unbind('keyup').off('keyup');
                    });
                }

                return false;
            }


            /**
             * Click events for images from slider
             */
            photoSlider().on('click', '.flex-image', function(e){
                e.preventDefault();
                var image = $(this).attr('data-flex-image');
                var flex = 'flex__'+UI.random(4);
                var flex_element = '.'+flex;

                $(document).find('body').append(tpl(Template.photo_flex, { class: flex, img: image }));

                setTimeout(function(){$(flex_element).fadeIn(300, function(){$(document).find('body').addClass('no-scroll')})}, 100);

                $(document).on('click', flex_element, function (e) {
                    e.preventDefault();
                    return closer(e, flex_element);
                });
                $(document).on('keyup', function (e) {
                    e.preventDefault();
                    return closer(e, flex_element);
                });

                return false;
            });

            videoSlider().on('click', '.flex-image', function(e){
                e.preventDefault();
                var video = $(this).attr('data-flex-video');
                var flex = 'flex__'+UI.random(4);
                var flex_element = '.'+flex;

                $(document).find('body').append(tpl(Template.video_flex, { class: flex, iframe: $video.getIframe(video) }));

                setTimeout(function(){$(flex_element).fadeIn(300, function(){$(document).find('body').addClass('no-scroll')})}, 100);

                $(document).on('click', flex_element, function (e) {
                    e.preventDefault();
                    return closer(e, flex_element);
                });
                $(document).on('keyup', function (e) {
                    e.preventDefault();
                    return closer(e, flex_element);
                });

                return false;
            });

            /**
             * Clear the Interval
             */
            clearInterval(owlChecker);
        }
    }, 10);
}

$(function($){
    /**
     * Checking if include files are loaded
     * @type {number}
     */
    var checker = setInterval(function(){
        var files = [
            logicTemplate('leagues/layout/league-sections/photos'),
           // logicTemplate('leagues/layout/league-sections/videos')
        ];
        if(includeLoaded(files) && $$store.session.check('slides_request')){
            init_league_page();
            clearInterval(checker);
        }
    }, 10);
});
