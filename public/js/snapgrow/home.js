window.onload = myFunction;

function myFunction() {
    var d = new Date();
    var n = d.getFullYear();
    document.getElementById("year").innerHTML = n;
}

$( document ).ready(function() {
    console.log("ready");

    $('.snapgrow_hamburger').click(function(){
        $('.snapgrow_mobile_header').removeClass( "hide" );
        $('.snapgrow_mobile_header').toggleClass( "dropdown" );
        $('.snapgrow_mobile_header').toggleClass( "dropup" );
    });

    $('.mobile_link').click(function(){
        $('.snapgrow_mobile_header').addClass( "hide" );
        $('.snapgrow_mobile_header').removeClass( "dropdown dropup" );
        $('.snapgrow_mobile_header').addClass( "dropup" );
    });

    $('.name_input').focus(function(){
        $(this).closest( ".selection" ).find('.name_label').addClass( "label_change" );
    });

    $('.name_input').blur(function(){
        if(!$(this).val()){
            $(this).closest( ".selection" ).find('.name_label').removeClass( "label_change" );
        } 
    });
});

var mobile = 0;
setInterval(function(){ 
        $(".space_one").height($(".popup_one").height());
        $(".space_two").height($(".popup_two").height());
        $(".space_three").height($(".popup_three").height());
        $(".space_four").height($(".popup_four").height());
        $(".space_five").height($(".popup_five").height());
        $(".space_six").height($(".popup_six").height());
        $(".space_seven").height($(".popup_seven").height());
        $(".space_eight").height($(".popup_eight").height());
        $(".space_nine").height($(".popup_nine").height());

        var width = $( window ).width();
          
        if (width > 960){
            mobile = 0;
        }
        else{
            mobile = 1;
        }
}, 10);

$(function() {
    $('a[href*="#"]:not([href="#"])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 64
                }, 1000);
            return false;
            }
        }
    });
});
