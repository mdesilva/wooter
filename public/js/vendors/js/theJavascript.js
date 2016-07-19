$(document).ready(function () {

    var
      //nodes
      scheduleEditBox = $('.schedule-edit-box'),
      scheduleEditForm = scheduleEditBox.find('form'),
      scheduleList = $('.schedule-list'),

      teamsList = $('.team-list'),

      headerSingleCountText = $('.page-header-section .counts-text.single'),
      headerManyCountText = $('.page-header-section .counts-text.many'),
      headerCountValue = $('.page-header-section .counts-text .count-value'),

      //input nodes
    //  dateTimePicker = scheduleEditForm.find('#datePicker'),
      dateTimeInput = scheduleEditForm.find('.datetime-input'),
      dateTimeValueInput = scheduleEditForm.find('input[name="datetime"]'),

      //button nodes
      btnScheduleMatch = $('#btnScheduleMatch'),
      btnCancelEditSchedule = scheduleEditForm.find('.button-cancel'),

      //edit-box functions
      showEditBox, hideEditBox, resetEditForm, validateTeamSelectOptions,

      //update functions
      updateCountHeader
    ;

    /*dateTimeInput.datetimepicker({
        inline: false,
        sideBySide: true,
        format: 'dddd, MMMM DD YYYY hh:mm A'
    });*/

   // var DatePickerAPI = dateTimeInput.data("DateTimePicker");

    dateTimeInput.on('dp.change', function(e){
        e.preventDefault();

        date = DatePickerAPI.viewDate();
        date = date._d;
        date = moment(date).format('MM/DD/YYYY HH:mm');
        dateTimeValueInput.val(date);

        return false;
    });


    showEditBox = function () {
        scheduleEditBox.show();
        validateTeamSelectOptions(scheduleEditForm.find('[name=team1]')[0]);
        validateTeamSelectOptions(scheduleEditForm.find('[name=team2]')[0]);
    };

    hideEditBox = function ()
    {
        //scheduleEditBox.hide();
        resetEditForm();
    };

    resetEditForm = function (){
        scheduleEditForm[0].reset();
    };

    updateCountHeader = function(count) {
        headerCountValue.text(count);
        if (count === 1) {
            headerManyCountText.hide();
            headerSingleCountText.show();
        } else {
            headerManyCountText.show();
            headerSingleCountText.hide();
        }
    };

    btnScheduleMatch.on('click', function() {
        scheduleEditForm.find('input[name="id"]').val( '' );
        resetEditForm();
        showEditBox();
        return false;
    });

    btnCancelEditSchedule.on('click', function() {
        hideEditBox();
        return false;
    });

    scheduleList.delegate('.button-edit', 'click', function(e) {
        var addLeadingZero = function(val) {
            if (('' + val).length === 1) {
                return '0' + val;
            } else {
                return val;
            }
        };

        var scheduleBox = $(e.currentTarget.closest('li'));

        var scheduleId = scheduleBox.attr('data-id');
        var team1Id = scheduleBox.attr('data-team1-id');
        var team2Id = scheduleBox.attr('data-team2-id');
        var mapId = scheduleBox.attr('data-map-id');
        var startAt = scheduleBox.attr('data-start-at');

        var startAtDate = new Date(startAt);
    //    dateTimeInput.datetimepicker('setDate', startAtDate);

        scheduleEditForm.find('input[name="id"]').val( scheduleId );
        scheduleEditForm.find('select[name="team1"]').val( team1Id );
        scheduleEditForm.find('select[name="team2"]').val( team2Id );
        scheduleEditForm.find('select[name="address"]').val( mapId );
        scheduleEditForm.find('textarea[name="note"]').val( scheduleBox.find('.note').html() );

        showEditBox();
    });

    scheduleList.delegate('.button-delete', 'click', function(e) {
        var scheduleBox = $(e.currentTarget.closest('li'));
        var teamId = scheduleBox.attr('data-id');
        var url = scheduleEditForm.attr('action') + '/delete/' + teamId;

        $.ajax(url, {
            method: 'post',
            dataType:'json',
            async:false,
            success : function (res) {
                if (res.status === 'success')
                {
                    scheduleBox.remove();
                    updateCountHeader(res.data.count);
                }
            }
        });
    });

    scheduleEditForm.validate(
        {
            'team1': {
                required: true
            },
            'team2': {
                required: true
            },
            'address': {
                required: true
            },
            'datetime': {
                required: true
            }
        },

        function () {
            var data = $(this).serialize();
            var url = $(this).attr('action');
            var method = $(this).attr('method');

            $.ajax(url, {
                data:data,
                method:method,
                dataType:'json',
                async:false,
                success : function (res) {
                    scheduleEditForm.find('.validation-error').addClass('hide');
                    if (res.status === 'success')
                    {
                        var data = res.data;

                        if (data.content) {
                            var existingScheduleBox = scheduleList.find('li[data-id="'+data.schedule.id+'"]');
                            if (existingScheduleBox.length > 0) {
                                existingScheduleBox.html(data.content);
                            } else {
                                scheduleList.prepend("<li data-id=\""+data.schedule.id+"\" data-team1-id=\""+data.schedule.team1_id+"\" data-team2-id=\""+data.schedule.team2_id+"\" data-map-id=\""+data.schedule.map_id+"\" data-start-at=\""+data.schedule.start_at+"\" class=\"schedule object\">"+data.content+"</li>");
                            }
                        }

                        updateCountHeader(data.count);
                        hideEditBox();

                    }
                }
            });

        },

        function (errors) {
            scheduleEditForm.find('.validation-error').addClass('hide');
            for (var fieldName in errors) {
                scheduleEditForm.find('.'+fieldName).closest('div').find('.validation-error').removeClass('hide');
            }
        }
    );

    teamsList.delegate('.button-delete', 'click', function(e) {
        var teamBox = $(e.currentTarget.closest('li'));
        var teamId = teamBox.attr('data-id');
        var url = teamsList.attr('data-team-url') + '/delete/' + teamId;

        $.ajax(url, {
            method: 'post',
            dataType:'json',
            async:false,
            success : function (res) {
                if (res.status === 'success')
                {
                    teamBox.remove();
                }
            }
        });
    });

    //--- add address --------------------------------------------------------------------------------------------------

    (function() {
    var
        scheduleEditBox = $('.schedule-edit-box'),
        modalNode = $('#schedule-location-modal'),
        step1Node = modalNode.find('.step-1'),
        step2Node = modalNode.find('.step-2'),
        step1Form = step1Node.find('.step-1-form'),
        step2Form = step2Node.find('.step-2-form'),
        mapNode = modalNode.find('.map')[0],
        xInputNode = step2Form.find('input[name=lat]'),
        yInputNode = step2Form.find('input[name=lng]'),

        addressesSelectNode = scheduleEditBox.find('select[name=address]'),

        location,
        map;
    var showModal = function () {
        modalNode.modal('show');

        $(document). one ('keyup', function (e){
            if (e.keyCode == 27) {
                modalNode.modal('hide');
            }
        });
    };

    var hideModal = function ()
    {
        modalNode.modal('hide');

        afterHideModal();
    };

    var afterHideModal = function ()
    {
        step2Node.hide();
        step1Node.hide();

     //   step1Form[0].reset();
       // step2Form[0].reset();
    };

    var step1 = function () {
        step1Node.slideDown('fast');
        var input = (document.getElementsByClassName('street'));
        var autocomplete = new google.maps.places.Autocomplete(input[0]);
        /*var autocomplete = new google.maps.places.Autocomplete(
      * @type {!HTMLInputElement} (document.getElementById('street_address')),
      {types: ['geocode']});*/

        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var streetInputNode = step1Form.find('input[name=street]');
            var cityInputNode = step1Form.find('input[name=city]');
            var stateInputNode = step1Form.find('input[name=state]');
            var zipInputNode = step1Form.find('input[name=zip]');

            var data = autocomplete.getPlace();
            console.log(data);
            step2Form.find('input[name=name]').val( streetInputNode.val() );
            location = data.geometry.location;
            streetInputNode.empty();

            $.each(data.address_components, function (i, v){
                $.each(v.types, function (index, value){

                    switch (value) {
                        case 'street_number' :
                            streetInputNode.val(v.short_name);
                            break;
                        case 'route' :
                            streetInputNode.val(streetInputNode.val() + ' ' +v.short_name);
                            break;
                        case 'locality' :
                            cityInputNode.val(v.short_name);
                            break;
                        case 'administrative_area_level_1' :
                            stateInputNode.val(v.short_name);
                            break;
                        case 'postal_code' :
                            zipInputNode.val(v.short_name);
                            break;
                    }

                });
            });

            return false;
        });
    };

   var getLatLng = function (){
        var geocoder = new google.maps.Geocoder();
            var address = step1Form.find('input[name=street]').val();
            var test = '';
            geocoder.geocode( { 'address': address}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            var latitude = results[0].geometry.location.lat();
            var longitude = results[0].geometry.location.lng();
            test = new google.maps.LatLng(latitude, longitude);
            alert(test);
            return test;
          } 
        }); 
    }

    function initialize() {
       
        if(location===undefined){
         var latitude =  xInputNode.val();
           var longitude = yInputNode.val();
            location = new google.maps.LatLng(latitude, longitude);
        }

        var mapOptions = {
            center: location,
            zoom: 17
        };
        map = new google.maps.Map(mapNode,
            mapOptions);

        var marker = new google.maps.Marker({
            map: map,
            draggable: true,
            position: location
        });

        google.maps.event.addListener(marker, 'dragend', function() {
            xInputNode.val(marker.getPosition().lat());
            yInputNode.val(marker.getPosition().lng());
        });

    }

    function setValues (data) {
        var latVal = step2Form.find('input[name=lat]').val(),
         lngVal = step2Form.find('input[name=lng]').val();
        $.each (data, function (i, v){
            step2Form.find(' > input[name='+v.name+']').val(v.value);
        });
        console.log(location);
        if(location!==undefined){
        xInputNode.val(location.lat());
        yInputNode.val(location.lng());
        initialize();
        }else{
        if(latVal==''){
        var geocoder = new google.maps.Geocoder();
        var address = step2Form.find(' > input[name=street]').val();

        geocoder.geocode( { 'address': address}, function(results, status) {

          if (status == google.maps.GeocoderStatus.OK) {
            var latitude = results[0].geometry.location.lat();
            var longitude = results[0].geometry.location.lng();
            xInputNode.val(latitude);
            yInputNode.val(longitude);
          } 
          initialize();
        }); 
        }else{
            
            initialize();
        }
        }
    }

    modalNode.on ('hide.bs.modal', function (){
        afterHideModal();
    });

    $('.button-add-address').on ('click', function (){

        showModal();
        step1();

        return false;

    });

    $('.button-edit-address').on ('click', function (){

        showModal();
        step1();

        return false;

    });

    $('.step1_submit').click(function(){
         var data = $('.step-1-form').serializeArray();
            step1Form.find('.validation-error').addClass('hide');
            step1Node.slideUp ('fast');
            step2Node.slideDown ('fast', function(){

                setValues(data);
                
            });
    });

    $('.step2_submit').click(function(){
          var data = $('.step-2-form').serialize();
            console.log(data);
            $.ajax({
                method:'POST',
                url:'services/add_location_data.php',
                data:data,
                success : function (data) {
                    console.log(data);
                    var jsonData = JSON.parse(data);
                    if (jsonData.success == 'true')
                    {
                        alert('done');

                        /*addressesSelectNode.append('<option value="'+data.map.id+'">'+data.map.address_line+'</option>');
                        addressesSelectNode.val(data.map.id);*/
                        
                        hideModal();

                    }else{
                        console.log(data);
                        alert('error');
                    }
                }
            });
    });

    $('.step2_edit').click(function(){
          var data = $('.step-2-form').serialize();
            console.log(data);
            $.ajax({
                method:'POST',
                url:'services/edit_location_data.php',
                data:data,
                success : function (data) {
                    console.log(data);
                    var jsonData = JSON.parse(data);
                    if (jsonData.success == 'true')
                    {
                        alert('done');

                        /*addressesSelectNode.append('<option value="'+data.map.id+'">'+data.map.address_line+'</option>');
                        addressesSelectNode.val(data.map.id);*/

                        modalNode.modal('hide');

                    }else{
                        console.log(data);
                        alert('error');
                    }
                }
            });
    });
    
    step1Form.validate({
            'street': {
                required: true
            },
            'city': {
                required: true
            },
            'state' : {
                required: true
            },
            'zip' : {
                required: true,
                regexp: 'int'
            }

        },
        function (res) {
            alert('sd');
            var data = $(this).serializeArray();
            step1Form.find('.validation-error').addClass('hide');
            step1Node.slideUp ('fast');
            step2Node.slideDown ('fast', function(){

                initialize();
                setValues(data);

            });

        },//on success
        function (errors) {
            step1Form.find('.validation-error').addClass('hide');
            for (var fieldName in errors) {
                step1Form.find('.'+fieldName).closest('div').find('.validation-error').removeClass('hide');
            }
        }// on error
    );

    step2Form.validate({
            'street': {
                required: true
            },
            'city': {
                required: true
            },
            'state': {
                required: true
            },
            'zip': {
                required: true,
                regexp: 'int'
            }
        }, function () {
            var data = $(this).serialize();
            var url = $(this).attr('action');
            var method = $(this).attr('method');

            $.ajax(url, {
                data:data,
                method:method,
                dataType:'json',
                async:false,
                success : function (res) {
                    if (res.status === 'success')
                    {
                        var data = res.data;

                        addressesSelectNode.append('<option value="'+data.map.id+'">'+data.map.address_line+'</option>');
                        addressesSelectNode.val(data.map.id);

                        hideModal();

                    }
                }
            });

        },
        function (errors){
            //step2Form.find('.validation-error').addClass('hide');
            //for (var fieldName in errors) {
            //    step2Form.find('.'+fieldName).closest('div').find('.validation-error').removeClass('hide');
            //}
        });
    })();
    
   
    teamsList.delegate('.button-delete', 'click', function(e) {
        var teamBox = $(e.currentTarget.closest('li'));
        var teamId = teamBox.attr('data-id');
        var url = teamsList.attr('data-team-url') + '/delete/' + teamId;

        $.ajax(url, {
            method: 'post',
            dataType:'json',
            async:false,
            success : function (res) {
                if (res.status === 'success')
                {
                    teamBox.remove();
                }
            }
        });
    });
    
    validateTeamSelectOptions = function(select) {
        var otherSelect = null;
        var currentValue = select.value;
        
        if (select.name === 'team1') {
            otherSelect = scheduleEditForm.find('[name=team2]');
        } else {
            otherSelect = scheduleEditForm.find('[name=team1]');
        }
        
        otherSelect.find('option').removeClass('hidden');
        if (currentValue) {
            otherSelect.find('option[value='+currentValue+']').addClass('hidden');
        }
    };
    
    scheduleEditForm.delegate('.team-select', 'change', function(e) {
        validateTeamSelectOptions(e.target);
    });

});