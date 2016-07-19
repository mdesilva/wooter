$( document ).ready(function() {
    $('.filter_expand').click(function(){
        $( '.hidden_filters' ).toggleClass( "hide" );
        $( '.show_filters' ).toggleClass( "filter_borders" );
    })

    $( ".switching_management" ).click(function() {

    
        $(".main_listing, .check_select, .manage_listing").removeClass("animated fadeOutLeft fadeInRight fadeOutRight fadeInLeft");  

        $(".main_listing, .check_select").addClass("animated fadeOutLeft").delay(400).queue(function(next){    
            $(".main_listing, .check_select").addClass("hide");  
            $(".manage_listing").removeClass("hide");  
            $(".manage_listing").addClass("animated fadeInRight").delay(400).queue(function(next){    
                next();
            });
            next();
        });
    });

    $( ".switching_mains" ).click(function() {


        $(".main_listing, .check_select, .manage_listing").removeClass("animated fadeOutLeft fadeInRight fadeOutRight fadeInLeft");  

        $(".manage_listing").addClass("animated fadeOutRight").delay(400).queue(function(next){    
            $(".manage_listing").addClass("hide");  
            $(".main_listing, .check_select").removeClass("hide");  
            $(".main_listing, .check_select").addClass("animated fadeInLeft").delay(400).queue(function(next){    
                next();
            });
            next();
        });
    });
});