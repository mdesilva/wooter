<?php
/*
examples for static page routes

Route::get('/homepage', function () {
    $data = [
        'title'=> 'Homepage', // title for the static page,
        'desc'=>'', // description of the static page
        'js' => [''], // js for the static page
        'css' => [''] // css needed for the static page
    ];
    return view('landing/template',$data);
});

or use a controller

Route::get('homepage', ['as' => 'homepage', 'uses'=>'PrimaryController@homepage']);
*/

// route for the promotion page
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;

Route::get('/promotion/{id}', ['as' => 'PromotionPage', 'uses' => 'StaticPages\PromotionController@index']);

//Wooter Static Pages
// Route::get('/about', function () {
//     $data = [
//         'title' => 'About Wooter',
//         'desc' => 'What is Wooter all about?',
//         'js' => ['/js/landing/index.js'],
//         'css' => ['/css/landing/about.css'],
//     ];
//     return view('landing.about', $data);
// });

Route::get('/demo', function () {
    $data = [
        'title' => 'Demo Wooter',
        'desc' => 'Demo Wooter Services',
        'js' => ['/js/landing/index.js'],
        'css' => ['/css/landing/demo.css'],
    ];
    return view('landing.demo', $data);
});

// Route::get('/contact', function () {
//     $data = [
//         'title' => 'Contact Wooter',
//         'desc' => 'Contact Wooter',
//         'js' => ['/js/landing/index.js'],
//         'css' => ['/css/landing/contact.css'],
//     ];
//     return view('landing.contact', $data);
// });

Route::get('/terms', function () {
    $data = [
        'title' => 'Wooter Terms and Conditions',
        'desc' => 'Wooter Terms and Conditions',
        'js' => ['/js/landing/index.js'],
        'css' => ['/css/landing/terms.css'],
    ];
    return view('landing.terms', $data);
});

Route::get('/policy', function () {
    $data = [
        'title' => 'Wooter Privacy Policy',
        'desc' => 'Wooter Privacy Policy',
        'js' => ['/js/landing/index.js'],
        'css' => ['/css/landing/terms.css'],
    ];
    return view('landing.policy', $data);
});


// Route::get('/referees', function () {
//     $data = [
//         'title' => 'Wooter Referees',
//         'desc' => 'Wooter Referees',
//         'js' => ['/js/landing/index.js'],
//         'css' => ['/css/landing/referees.css', '/css/landing/modals.css'],
//     ];
//     return view('landing.referees', $data);
// });

Route::get('/insurance', function () {
    $data = [
        'title' => 'Wooter Insurance',
        'desc' => 'Wooter Insurance',
        'js' => ['/js/landing/index.js'],
        'css' => ['/css/landing/insurance.css'],
    ];
    return view('landing.insurance', $data);
});

Route::get('/apparel', function () {
    $data = [
        'title' => 'Wooter Apparel',
        'desc' => 'Wooter Apparel',
        'js' => ['/js/landing/index.js'],
        'css' => ['/css/landing/apparel.css'],
    ];
    return view('landing.apparel', $data);
});

Route::get('/stats', function () {
    $data = [
        'title' => 'Wooter Statistics',
        'desc' => 'Wooter Statistics',
        'js' => ['/js/landing/index.js'],
        'css' => ['/css/landing/stats.css', '/css/landing/modals.css'],
    ];
    return view('landing.stats', $data);
});

Route::get('/video', function () {
    $data = [
        'title' => 'Wooter Videography',
        'desc' => 'Wooter Videography',
        'js' => ['/js/landing/index.js'],
        'css' => ['/css/landing/video.css', '/css/landing/modals.css'],
    ];
    return view('landing.video', $data);
});

// Route::get('/packages', function () {
//     $data = [
//         'title' => 'Wooter Packages',
//         'desc' => 'Wooter Packages',
//         'js' => ['/js/landing/index.js'],
//         'css' => ['/css/landing/packages.css', '/css/landing/modals.css'],
//     ];
//     return view('landing.packages', $data);
// });

Route::get('/socialmedia', function () {
    $data = [
        'title' => 'Wooter Social Media',
        'desc' => 'Wooter Social Media',
        'js' => ['/js/landing/index.js'],
        'css' => ['/css/landing/socialmedia.css'],
    ];
    return view('landing.socialmedia', $data);
});

Route::get('/dreamleagues', function () {

    $leagueRepo = new LeagueRepository;

    $specialLeagues = $leagueRepo->getSpecialLeagues();

    $data = [
        'title' => 'Wooter Dream Leagues',
        'desc' => 'Wooter Dream Leagues',
        'js' => ['/js/landing/index.js'],
        'css' => ['/css/landing/dreamleagues.css'],
        'special_leagues' => $specialLeagues,
    ];

    return view('landing.dreamleagues', $data);
});

Route::get('/results', function () {
    $data = [
        'title' => 'Wooter Search Results',
        'desc' => 'Wooter Search Results',
        'js' => ['/js/landing/index.js'],
        'css' => ['/css/landing/results.css'],
    ];
    return view('landing.results', $data);
});

Route::get('/search', function () {
    $data = [
        'title' => 'Wooter Search Leagues',
        'desc' => 'Wooter Search Leagues',
        'js' => ['/js/landing/index.js'],
        'css' => ['/css/landing/search.css'],
    ];
    return view('landing.search', $data);
});

// Route::get('/home', function () {
//     $data = [
//         'title' => 'Wooter',
//         'desc' => 'Wooter Homepage',
//         'js' => ['/js/landing/index.js'],
//         'css' => ['/css/landing/home.css'],
//     ];
//     return view('landing.home', $data);
// });

// // Snapgrow Static Pages
// Route::get('/snapgrow/home', function () {
//     $data = [
//         'title' => 'SnapGrow Homepage',
//         'desc' => 'SpapGrow - Your Socialmedia Management Solution!',
//         'js' => ['/js/snapgrow/home.js'],
//         'css' => ['/css/snapgrow/home.css'],
//     ];
//     return view('snapgrow.home', $data);
// });

// Route::get('/snapgrow/about', function () {
//     $data = [
//         'title' => 'About SnapGrow',
//         'desc' => 'About SnapGrow',
//         'js' => ['/js/snapgrow/home.js'],
//         'css' => ['/css/snapgrow/about.css'],
//     ];
//     return view('snapgrow.about', $data);
// });

// Route::get('/snapgrow/pricing', function () {
//     $data = [
//         'title' => 'SnapGrow Pricing',
//         'desc' => 'SpapGrow - Pricing',
//         'js' => ['/js/snapgrow/home.js'],
//         'css' => ['/css/snapgrow/pricing.css'],
//     ];
//     return view('snapgrow.pricing', $data);
// });

// Route::get('/snapgrow/contact', function () {
//     $data = [
//         'title' => 'Contact SnapGrow',
//         'desc' => 'How to contact SpapGrow',
//         'js' => ['/js/snapgrow/home.js'],
//         'css' => ['/css/snapgrow/contact.css'],
//     ];
//     return view('snapgrow.contact', $data);
// });

// Route::get('/snapgrow/consult', function () {
//     $data = [
//         'title' => 'Consult SnapGrow',
//         'desc' => 'Call now for a free consultation!',
//         'js' => ['/js/snapgrow/home.js'],
//         'css' => ['/css/snapgrow/consult.css'],
//     ];
//     return view('snapgrow.consult', $data);
// });

// Route::get('/snapgrow/testimonials', function () {
//     $data = [
//         'title' => 'SnapGrow Testimonials',
//         'desc' => 'SpapGrow - Your Socialmedia Management Solution!',
//         'js' => ['/js/snapgrow/home.js'],
//         'css' => ['/css/snapgrow/test.css'],
//     ];
//     return view('snapgrow.test', $data);
// });

// Route::get('/vc/stats', function () {
//     $data = [
//         'title' => 'Temporary Schedule', // title for the static page,
//         'desc' => 'From videos, replays and highlights we got you covered.', // description of the static page
//         'js' => [
//             '/js/vendor_cabinet/statscores/index.js',
//             '/js/landing/schedule/scheduleCtrl.js',
//             '/js/landing/schedule/teamFactory.js',
//             '/js/landing/schedule/venueFactory.js',
//             '/js/landing/schedule/slotsFactory.js',
//             '/js/vendor_cabinet/statscores/tabsCtrl.js',
//             '/js/landing/schedule/hourFactory.js',
//             '/js/vendor_cabinet/statscores/statScoreCtrl.js',
//             '/js/vendor_cabinet/league_dashboard/playerFactory.js',
//             '/js/vendor_cabinet/league_dashboard/teamCtrl.js'
//         ], // js for the static page
//         'css' => ['/css/vendor_cabinet/statscores/input.css'], // css needed for the static page
//     ];
// return view('vendor_cabinet.statscores.index', $data);
// });