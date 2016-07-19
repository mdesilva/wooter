exports.config = {
    //allScriptsTimeout: 11000,

    capabilities: {
        'browserName': 'chrome'
    },

    framework: 'jasmine',
    seleniumAddress: 'http://localhost:4444/wd/hub',
    specs: ['public/js/app/e2e-tests/*.js']
};