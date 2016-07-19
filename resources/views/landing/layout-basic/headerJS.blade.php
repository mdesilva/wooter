<!-- $(document).ready(function() {

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
            $(this).removeClass("active");
            $('.d_search').addClass("active_top");
        } else {
            $(".dl_search, .dl_athletes, .dl_orgs, .dl_company").find(".la").removeClass("fa-caret-down");
            $(".dl_search, .dl_athletes, .dl_orgs, .dl_company").find(".la").addClass("fa-caret-up");
            $('.d_search').addClass("active_top");
            
            $(this).find(".la").toggleClass("fa-caret-up");
            $(this).find(".la").toggleClass("fa-caret-down");
            
            $(".d_search, .d_athletes, .d_company , .d_orgs").addClass("hide");
            $(this).find(".dropdown_list").toggleClass("hide");
            
            $(".dl_search, .dl_athletes, .dl_orgs, .dl_company").removeClass("active");
            $(this).toggleClass("active");
            
            if ((".dl_search").hasClass("active")) {
                $(this).removeClass("active");
                $('.d_search').addClass("active_top");
            }
        }
    });
  
    $('.dropdown_list').click(function() {
        return false;
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
  
    $('.mobile_more').click(function() {
        $('.wooter_mobile_more').removeClass("hide");
        $('.wooter_mobile_more').toggleClass("dropdown");
        $('.wooter_mobile_more').toggleClass("dropup");
    });
   
    $('.back_more').click(function() {
        $('.wooter_mobile_more').toggleClass("dropdown");
        $('.wooter_mobile_more').toggleClass("dropup");
    });
    
    $('.wooter_hamburger').click(function() {
        $('.wooter_mobile_header').removeClass("hide");
        $('.wooter_mobile_header').toggleClass("dropdown");
        $('.wooter_mobile_header').toggleClass("dropup");
        $('.wooter_mobile_more, .wooter_mobile_orgs').removeClass("hide dropup dropdown");
        $('.wooter_mobile_more, .wooter_mobile_orgs').addClass("hide dropup");
    });
    
    $('a').click(function() {
        var href = this.href;
        window.location = href;
    });
}); -->