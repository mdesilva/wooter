$(function() {
	function setupDropZone () {
		var $uploadTPL = ''+
			'<div class="dz-preview dz-file-preview">'+
				'<div class="dz-details lazy-image">'+
					'<img data-dz-thumbnail onload="resizeImage(this)" />'+
				'</div>'+
			'</div>';

		//upload function
		var dropArea = $("#logo-form-dropzone").find(".drop-area");
			dropArea.dropzone({
				url: '/api/file-upload/profile',
				paramName: "file",
				maxFilesize: 2,
				method: "POST",
				dataType: "JSON",
				parallelUploads: 1,
				uploadMultiple: false,
				addRemoveLinks: false,
				previewTemplate: $uploadTPL,
				headers: {
					"X-Requested-With": "XMLHttpRequest",
					"X-CSRF-TOKEN": getMeta('token')
				},
				sending: function (file){
                    dropArea.find('.message.success').removeClass('show');
                    dropArea.find('.message.error').removeClass('show');
                    dropArea.find('.message.loading').addClass('show');
				},
				success: function (e, res) {
					console.log(e);
					console.log(res);
                    dropArea.find('.image-state').val(1).trigger('input');
                    dropArea.find('.message.loading').removeClass('show');
                    if(e.status == 'success'){
                        dropArea.find('.message.success').addClass('show');
                    } else {
                        dropArea.find('.message.error').addClass('show');
                    }
				}
			});
	}

    var checkingDropZone = setInterval(function(){
        if (Dropzone && typeof Dropzone == "function") {
            setupDropZone();
            clearInterval(checkingDropZone);
        }
    }, 100);

    function setPagination(num){
        var $pagination = $('.forms-slider').parent().find('.pagination');
        var links = $pagination.find('li');

        links.each(function(){
            if($(this).hasClass('active')) {
                $(this).removeClass('active');
            }
        });

        $(links.get(num-1)).addClass('active');
    }

    function hideSlides(){
        $('.forms-slider').find('.item').each(function(){
            var self = this;
            $(this).removeClass('show');
            setTimeout(function(){
                $(self).removeClass('loaded');
            }, 301);
        });
    }

    function showSlide(num, parent){
        var item = $(parent).find('.item:nth-child('+num+')');
        item.addClass('loaded');
        setTimeout(function(){
            item.addClass('show');
        }, 10);
    }

    function setSlide(num){
        num = (num <= $('.forms-slider .item').length)?num:1;

        hideSlides();
        setTimeout(function(){
            showSlide(num, '.forms-slider');
        }, 302);

        setPagination(num);
    }

    setSlide(1);

    $('.forms-slider, .pagination').on('click', '[data-slide]', function(e){
        e.preventDefault();
        setSlide($(this).attr('data-slide'));
        return false;
    })
});