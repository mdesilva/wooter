$(document).ready(function() {
    
    setInterval(function() {
        var width = $(window).width();

        if (width > 960) {
            if ($('.wooter_mobile_header').hasClass("dropdown")) {
                $('.wooter_mobile_header').removeClass("hide");
                $('.wooter_mobile_header').toggleClass("dropdown");
                $('.wooter_mobile_header').toggleClass("dropup");
                $('.wooter_mobile_more, .wooter_mobile_orgs').removeClass("hide dropup dropdown");
                $('.wooter_mobile_more, .wooter_mobile_orgs').addClass("hide dropup");
            }
        }
    }, 10);

    $('.dropdown_links').click(function() {
        if (!($(this).find(".dropdown_list").hasClass("hide"))) {
            $(this).find(".la").toggleClass("fa-caret-up");
            $(this).find(".la").toggleClass("fa-caret-down");
            $(this).find(".dropdown_list").addClass("hide");

        } else {
            $(".dl_search, .dl_athletes, .dl_orgs, .dl_company").find(".la").removeClass("fa-caret-down");
            $(".dl_search, .dl_athletes, .dl_orgs, .dl_company").find(".la").addClass("fa-caret-up");
            $('.d_search').addClass("active_top");
            $(this).find(".la").toggleClass("fa-caret-up");
            $(this).find(".la").toggleClass("fa-caret-down");
            $(".d_search, .d_athletes, .d_company , .d_orgs").addClass("hide");
            $(this).find(".dropdown_list").toggleClass("hide");
        }
    });
    $('.dropdown_list').click(function() {
        return false;
    });

    $('.mobile_company').click(function() {
        $('.wooter_mobile_company').removeClass("hide");
        $('.wooter_mobile_company').toggleClass("dropdown");
        $('.wooter_mobile_company').toggleClass("dropup");
    });

    $('.back_company').click(function() {
        $('.wooter_mobile_company').toggleClass("dropdown");
        $('.wooter_mobile_company').toggleClass("dropup");
    });

    $('.mobile_athletes').click(function() {
        $('.wooter_mobile_athletes').removeClass("hide");
        $('.wooter_mobile_athletes').toggleClass("dropdown");
        $('.wooter_mobile_athletes').toggleClass("dropup");
    });

    $('.back_athletes').click(function() {
        $('.wooter_mobile_athletes').toggleClass("dropdown");
        $('.wooter_mobile_athletes').toggleClass("dropup");
    });

    $('.mobile_orgs').click(function() {
        $('.wooter_mobile_orgs').removeClass("hide");
        $('.wooter_mobile_orgs').toggleClass("dropdown");
        $('.wooter_mobile_orgs').toggleClass("dropup");
    });

    $('.back_orgs').click(function() {
        $('.wooter_mobile_orgs').toggleClass("dropdown");
        $('.wooter_mobile_orgs').toggleClass("dropup");
    });


    $('.wooter_hamburger').click(function() {
        $('.wooter_mobile_header').removeClass("hide");
        $('.wooter_mobile_header').toggleClass("dropdown");
        $('.wooter_mobile_header').toggleClass("dropup");
        $('.wooter_mobile_company, .wooter_mobile_athletes, .wooter_mobile_orgs').removeClass("hide dropup dropdown");
        $('.wooter_mobile_company, .wooter_mobile_athletes, .wooter_mobile_orgs').addClass("hide dropup");
    });

});
